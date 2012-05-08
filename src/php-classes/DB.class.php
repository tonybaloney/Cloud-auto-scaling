<?php
// quick db class.

class DB { 
	public static function Connect(){
		return mysql_connect( 'localhost','scaler','scaler' );
	}
	public static function Query( $sql ) {
		DB::Connect();
		mysql_selectdb('scaler');
		$q = mysql_query ( $sql );
		if(!$q) die (mysql_error());
		return $q;
	}
	public static function GetData ($sql){
		$res = DB::Query($sql);
		$data = array();
		while($row = mysql_fetch_assoc($res))
			$data[] = $row;	
		return $data;
	}
	/*
	 * Return an assoc array from a SQL query with 1 row
	*/
	public static function GetRecord($sql){
		$data= DB::GetData($sql);
		return $data[0];
	}
	public static function Sanitise ($data){
		return mysql_real_escape_string($data,DB::Connect());
	}
}

?>