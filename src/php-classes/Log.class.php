<?php
/**
 * Logging class
 * @package auto-scaler
 **/
class Log {
	/** 
	 * Get the user ( trigger ) logs
	 * @access public
	 * @param int Customer ID
	 * @return array The log entries
	 **/
	public static function GetLogs( $uid=false ) {
		if(!$uid) $uid = Auth::GetUID();
		return DB::GetData("SELECT `log`.*,`triggers`.triggerName,`clusters`.`clusterName` FROM `log` INNER JOIN `triggers` ON `triggers`.`triggerId`=`log`.`triggerId` INNER JOIN `clusters` ON `clusters`.`clusterId`=`log`.`clusterId` WHERE `log`.`customerId` = $uid");
	}
	
	/** 
	 * Get the generic error logs
	 * @access public
	 * @param int Customer ID
	 * @return array The log entries
	 **/
	public static function GetErrorLogs( $uid=false ) {
		if(!$uid) $uid = Auth::GetUID();
		return DB::GetData("SELECT `error_log`.* FROM `error_log` WHERE `error_log`.`customerId` = $uid ORDER BY `date` DESC");
	}
	
	/** 
	 * Log an error in the trigger log
	 * @access public
	 * @param int $customerId The customer
	 * @param int $clusterId The cluster
	 * @param int $triggerId The trigger
	 * @param string $message Error message
	 **/
	public static function LogTriggerError ( $customerId, $clusterId, $triggerId, $message ) { 
	
	}
	
	/** 
	 * Log an error in the customer generic log
	 * @access public
	 * @param int $customerId The customer
	 * @param string $message Error message
	 **/
	public static function LogCustomerError( $customerId, $message ) {
		$customerId = DB::Sanitise($customerId);
		$message = DB::Sanitise($message);
		DB::Query("INSERT INTO `error_log` (`customerId`, `message`, `date`) VALUES ( $customerId, '$message', NOW()) ;");
	}
	
	/** 
	 * Log an SNMP result in the tick_log table
	 * @access public
	 * @param int $customerId The customer
	 * @param int $clusterId The target cluster
	 * @param int $triggerId The target trigger
	 * @param string $hostname The target Virtual Machine Name
	 * @param string $message Error message
	 **/
	public static function LogTickResult( $customerId, $clusterId, $triggerId, $vmId, $vmName, $result ){
		$customerId = DB::Sanitise($customerId);
		$clusterId = DB::Sanitise($clusterId);
		$triggerId = DB::Sanitise($triggerId);
		$vmId = DB::Sanitise($vmId);
		$vmName = DB::Sanitise($vmName);
		$result = DB::Sanitise($result);
		DB::Query("INSERT INTO `tick_log` (`customerId`,`clusterId`,`triggerId`,`vmId`,`vmName`,`date`,`result`) VALUES ( $customerId, $clusterId, $triggerId, $vmId, '$vmName',NOW(), '$result')");
	}
}
?>