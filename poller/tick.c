/** * * * * * * * 
 * Tick.c 
 * * * * * * * * 
 * A daemon to watch the database for pending queries to subnets in a web application
 * will spawn  MAX_POLL_THREADS to check every 5 seconds for pending triggers that need their health updating
 * each pending health check will then attempt to connect to every host in that subnet and check it's SNMP result
 * the results will be posted back into the database.
 * The 'tock.c' file makes decisions on scale-up/scale-down actions
 * /copyright Anthony Shaw
 * /date 15/03/2012
 * /website http://github.com/tonybaloney
 **/

#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>
#include <mysql/mysql.h>
#include <linux/snmp.h> 
#include <linux/ip.h>  
#include <arpa/inet.h>

/** 
 * A structure to define the connection to the MySQL database 
 **/ 
typedef struct {
	char * db_server ;
	char * db_host ; 
	char * db_username ;
	char * db_password ; 
	char * db_name ;
	MYSQL * db_connection ; 
} mysql_details_t;

/** 
 * A structure to define a SNMP request (host, community, oid)
 **/
 typedef struct { 
	in_addr target_host; // check later, might be ip4_addr in 2.6
	char * community;
	char * oid; //Prob a type in snmp.h - check later
 } snmp_request_t;

 /** 
  * Create some locks to prevent memory access conflicts
  **/
pthread_mutex_t log_lock = PTHREAD_MUTEX_INITIALIZER;
pthread_mutex_t result_lock = PTHREAD_MUTEX_INITIALIZER;

/** 
 * TODO : 
 * Create a header file for function def's if this gets out of control.
 **/
void * poll_func ( void * ptr) ;
void * snmp_poll ( void * request_details ) ; 

/** 
 * Maximum number of concurrent poll threads 
 * Consider each will be select(ing) and update'ing to the DB
 **/
#define MAX_POLL_THREADS 5

/** 
 * Maximum number of sub threads that a poll thread can spawn
 * for a VLAN of 254 usable addresses, it will consecutively connect to [x] servers for a SNMP get
 * consider each will need an open TCP port
 * NB: this process will have MAX_POLL_THREADS * SNMP_THREADS open as POSIX threads.
 **/
 #define SNMP_THREADS 5
 
 #define DB_CONNECTION_FAILED 1
 #define DB_CONNECTION_SUCCESS 0  
 
 /** 
  * Global state of the MySQL Database connection
  **/
int reconnect_needed = DB_CONNECTION_SUCCESS;

/**
 *	Number of ms to wait between re-spawning poller threads
 **/
 #define LOOP_WAIT_TIME 500

 /**
  * Main process
  * /return Result ( bool ) 
  **/ 
 int main () {
	// Create an array of POSIX threads
	pthread_t pollers[MAX_POLL_THREADS];
	// Create an array of results for the threads
	int returns[MAX_POLL_THREADS];
	// Create a blank MySQL connection variable
	mysql_details_t connection ;
	
	/* Establish connection to the database .. */
	/* TODO : read from settings file */
	connection = {
		"localhost",
		"scaler",
		"scaler",
		"scaler",
		"Test"
		};
	// Connect to the DB, select DB
	mysql_real_connect ( 
		connection.db_connection, 
		connection.db_host, 
		connection.db_username, 
		connection.db_password,
		connection.db_name,
		3306,
		NULL,
		0 ) ;
	if (!connection.db_connection){
		log_message ( "Could not connect to the database. Exiting. \n" ) ;
	}
	
	/* Create a chain of pollers */
	while (1==1) { 
		int i;
		/**  If MySQL connection has dropped out during the last run, try and reconnect - or quit.
		 * TODO : Pause and retry, instead of quitting 
		 **/
		if (reconnect_needed == DB_CONNECTION_FAILED) {
				mysql_real_connect ( 
					connection.db_connection, 
					connection.db_host, 
					connection.db_username, 
					connection.db_password,
					connection.db_name,
					3306,
					NULL,
					0 ) ;	
			if ( !connection.db_connection ) {
				log_message( "Supposed to reconnect to DB, but failed to establish. Exiting.\n" ) ;
				exit (0);
			}	
		}	
		// Iterate through the threads and spawn SNMP polling sessions
		// Each thread is not given any information other than a connection to the DB
		for ( i=0 ; i < MAX_POLL_THREADS ; i++ ) {
			returns[i] = pthread_create (&pollers[i], NULL, poll_func, (void *) &connection );
		}
		// Wait for each thread to close
		for ( i=0; i < MAX_POLL_THREADS ; i++ ) {
			pthread_join ( pollers[i], NULL );
		}
		wait(LOOP_WAIT_TIME);
	}
	mysql_close ( connection.db_connection ) ;
	return 0 ;
}

/** 
 * Poll function
 * 
 * Checks for the next 'trigger' in  the queue that hasn't been polled and attacks the subnet with SNMP requests
 * Posts results back into the DB and kills itself.
 * If it can't connect to the DB it will kill itself and provoke the main process to reconnect the DB (instead of x threads all trying reconnects.)
 **/
void * poll_func ( void * db_details ) {
	// DB connection
	mysql_details_t * connection;
	
	connection = (mysql_details_t*) db_details;
	
	// Check the connection, get the next pending trigger
	if ( connection->db_connection ) {
		// We need a list of hosts, oid, community string 
		mysql_query ( connection->db_connection , "SELECT triggers.oid, triggers.communityString, cluster.networkAddress, cluster.networkMask FROM triggers WHERE pollInAction = 0 AND lastPolled + MINUTES(pollFrequency) <= NOW() LIMIT 1");
		MYSQL_RES * res = mysql_store_result ( connection->db_connection ) ;
		if ( mysql_num_rows ( res ) == 0 ) { 
			// Nothing to do. finish thread.
			return;
		} else { 
			// result will be 0=oid, 1=communityString, 2=networkAddress,3=networkMask  
			MYSQL_ROW row = mysql_fetch_row(res);
			// 'Step' will be the number of hosts to try at once
			in_addr mask = inet_pton ( (char*) row[3] ); // Netmask as an IPv4 address
			uint_16 firstHost = (uint_16) addr_to_ip ( (char*) row[2] ) + 1; // The IP number of the first host in the range, CHECK
			uint_16 lastHost = (uint_16) firstHost + /* Inverse */ (uint_16)!mask ; // The IP number of the last host in the range, CHECK
			
			// Traverse the range
			for ( uint_16 c = firstHost ; c < lastHost ; c+=SNMP_THREADS ) {
				// Start some threads to connect to (SNMP_THREADS) hosts at once and try and request the OID
				for ( int i = 0 ; i < SNMP_THREADS ; i++ ) {
					snmp_request_t request = {
						.target_host = (ip_addr) c + i, // Current host
						.oid = (char*)row[0],
						.community = (char*)row[1]
					};
					pthread_create ( &snmp_pollers[i],NULL,snmp_poll, (void *)request );
				}
				// Regroup 
				for ( int i = 0 ; i < SNMP_THREADS ; i++ ) {
					pthread_join ( snmp_pollers[i] , NULL ) ;
				}
				// Move onto the next few hosts..
			}
			// Push the results back into the DB
			// TODO : Take SNMP poll thread results and push back into DB.
		}
		
	} else { 
		log_message ( "MySQL connection dead.\n" ) ;
	}
}

void * snmp_poll ( void * request_details ) {
	snmp_request_t req = (snmp_request_t)request_details;
	void * result = snmp_get ( req.host, req.oid, req.community ) ; //Check syntax
	if (!result) { 
		// TODO: increase a failure counter to stop the back end of ranges being pushed.
	}	
	// Push the results back to the result queue..
	pthread_mutex_lock ( &result_lock ) ;
	// TODO: create linked array for a result buffer
	pthread_mutex_unlock ( &result_lock ) ;
}

void log_message ( char * message ) {
	/** 
	 * TODO : Push into DB
	 **/
	 pthread_mutex_lock ( &log_lock ) ;
	 printf( message ) ;
	 pthread_mutex_unlock ( &log_lock ) ;
}