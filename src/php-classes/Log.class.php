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
	public static function GetErrorLogs( $uid=false,$start=0,$limit=0 ) {
		if(!$uid) $uid = Auth::GetUID();
		$start=DB::Sanitise($start);
		$limit=DB::Sanitise($limit);
		return DB::GetData("SELECT `error_log`.* FROM `error_log` WHERE `error_log`.`customerId` = $uid ORDER BY `date` DESC LIMIT $start,$limit");
	}
	
	public static function GetErrorLogsLimit($uid=false){
		if(!$uid) $uid = Auth::GetUID();
		return DB::GetRecord("SELECT COUNT(1) AS `total` FROM `error_log` WHERE `error_log`.`customerId` = $uid ORDER BY `date` DESC");
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
	
	/** 
	 * Get the results in the tick log for a cluster
	 * @param int $clusterId The ID of the cluster
	 * @return array The tick_log rows
	 **/
	public static function GetTickLog ($clusterId,$triggerId){
		$clusterId = DB::Sanitise($clusterId);
		$triggerId = DB::Sanitise($triggerId);
		return DB::GetData("SELECT * FROM `tick_log` WHERE `clusterId` = $clusterId AND `triggerId` = $triggerId");
	}
	
	/**
	 * Get a list of tock_log actions (scale up or down)
	 * @param int $clusterId the ID of the cluster
	 * @return array the tock_log rows and the triggerName from triggers, newest first
	 **/
	public static function GetTockLog ($clusterId) {
		$clusterId = DB::Sanitise($clusterId);
		return DB::GetData("select `tock_actions`.*,`triggers`.`triggerName` from tock_actions INNER JOIN triggers ON tock_actions.triggerId = triggers.triggerId WHERE `tock_actions`.`clusterId` = $clusterId ORDER BY `tock_actions`.`date` DESC;");
	}
}
?>