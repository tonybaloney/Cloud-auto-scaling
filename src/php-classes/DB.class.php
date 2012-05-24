<?php
 /**
  * DB.class.php
  * Requires DB_NAME,DB_HOST,DB_USERNAME and DB_PASSWORD to be defined.
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/

/** 
 * DB class
 * @package auto-scaler
 */
class DB { 
	/** 
	 * Connect to the database 
	 * @access public
	 * @return MySQLResource
	 **/
	public static function Connect(){
		include_once('db_settings.inc.php');
		return mysql_connect( DB_HOST , DB_USERNAME , DB_PASSWORD );
	}
	
	/** 
	 * Run an SQL Query 
	 * @access public
	 * @param string $sql SQL Query
	 * @return resource
	 **/
	public static function Query( $sql ) {
		DB::Connect();
		mysql_selectdb(DB_NAME);
		$q = mysql_query ( $sql );
		if(!$q) die (mysql_error());
		return $q;
	}
	
	/** 
	 * Run an SQL query and return an array of the results
	 * @access public
	 * @param string $sql Query
	 * @return array
	 **/
	public static function GetData ($sql){
		$res = DB::Query($sql);
		$data = array();
		while($row = mysql_fetch_assoc($res))
			$data[] = $row;	
		return $data;
	}
	
	/**
	 * Return an assoc array from a SQL query with 1 row
	 * @param string $sql SQL query
	 * @return array Single row as array
	 **/
	public static function GetRecord($sql){
		$data= DB::GetData($sql);
		return $data[0];
	}
	
	/** 
	 * Connect to the database 
	 * @access public
	 * @param string $data String to sanitise
	 * @return string
	 **/
	public static function Sanitise ($data){
		return mysql_real_escape_string($data,DB::Connect());
	}
}
?>