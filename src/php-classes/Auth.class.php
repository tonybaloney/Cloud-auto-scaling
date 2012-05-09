<?php
/**
 * Basic auth class, just provide dummy user context for now as appliance is single user.
 */

/** 
 * Authentication Class
 * @package auto-scaler
 */
class Auth { 
	/** 
	 * Get the customerId of the logged in user
	 * @static
	 * @access public
	 * @return int Customer ID number
	 */
	public static function GetUID () {
 		return 1;
	}
		
	/** 
	 * Get the details of the current logged in user
	 * @static
	 * @access public
	 * @return Array Customer details
	 */
	public static function GetMe() {
		return DB::GetRecord("SELECT * from customers where customerId='".DB::Sanitise(Auth::GetUID())."' LIMIT 1");
	}
	
	/** 
	 * Get the details of all the customers on the system
	 * @static
	 * @access public
	 * @return Array Customer list
	 */
	public static function GetAllCustomers(){
		return DB::GetData("SELECT * from customers ;");
	}
	
	/** 
	 * Save the details of the current customer
	 * @static
	 * @access public
	 * @param string $portalAPIUrl URL of the Portal API the user wants to call
	 * @param string $portalUsername Username to authenticate on the API with
	 * @param string $portalPassword Password for the API
	 * @param string $apiType Type of API (Only 'abiquo' is the current option)
	 * @return bool Success/Failure
	 */
	public static function SaveDetails ($portalAPIUrl, $portalUsername, $portalPassword, $apiType){
		$q = "UPDATE `customers` SET
			portalAPIUrl = '".DB::Sanitise($portalAPIUrl)."',
			portalUsername = '".DB::Sanitise($portalUsername)."',
			portalPassword = '".DB::Sanitise($portalPassword)."',
			apiType = '".DB::Sanitise($apiType)."'
		WHERE customerId = '".DB::Sanitise(Auth::GetUID())."' ";
		return (DB::Query($q));
	}
	
	public static function GetCloudConnection () {
		$me = Auth::GetMe();
		switch ( $me['apiType'] ) {
			case 'abiquo':
				$cloud = new Abiquo($me['portalAPIUrl'],$me['portalUsername'],$me['portalPassword']);
				break;
			case 'abiquo2':
				$cloud = new Abiquo2($me['portalAPIUrl'],$me['portalUsername'],$me['portalPassword']);
				break;
			default:
				die ('Cloud proxy not recognised.');
				break;
		}
		return $cloud;
	}
}
?>