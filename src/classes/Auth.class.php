<?php

// Basic auth class, just provide dummy user context for now as appliance is single user.

class Auth { 
	public static function GetUID () {
 		return 1;
	}
	public static function GetMe() {
		return DB::GetRecord("SELECT * from customers where customerId='".DB::Sanitise(Auth::GetUID())."' LIMIT 1");
	}
	public static function GetAllCustomers(){
		return DB::GetData("SELECT * from customers ;");
	}
	public static function SaveDetails ($portalAPIUrl, $portalUsername, $portalPassword, $apiType){
		$q = "UPDATE `customers` SET
			portalAPIUrl = '".DB::Sanitise($portalAPIUrl)."',
			portalUsername = '".DB::Sanitise($portalUsername)."',
			portalPassword = '".DB::Sanitise($portalPassword)."',
			apiType = '".DB::Sanitise($apiType)."'
		WHERE customerId = '".DB::Sanitise(Auth::GetUID())."' ";
		DB::Query($q);
	}
}

?>
