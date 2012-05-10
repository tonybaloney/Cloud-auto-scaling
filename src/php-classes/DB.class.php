<?php
// quick db class.

/** 
 * @package auto-scaler
 */
class DB { 
	/** 
	 * Connect to the database 
	 * @access public
	 * @return MySQLResource
	 **/
	public static function Connect(){
		return mysql_connect( 'localhost','scaler','scaler' );
	}
	
	/** 
	 * Run an SQL Query 
	 * @access public
	 * @param string $sql SQL Query
	 * @return resource
	 **/
	public static function Query( $sql ) {
		DB::Connect();
		mysql_selectdb('scaler');
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