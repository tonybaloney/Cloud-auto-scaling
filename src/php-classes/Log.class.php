<?php
 /**
  * Log.class.php 
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/

/**
 * Logging class
 * @package auto-scaler
 **/
class Log {
	/** 
	 * Get the generic error logs
	 * @access public
	 * @param int $uid Customer ID
	 * @param int $start Starting row
	 * @param int $limit Limit the number of results
	 * @return array The log entries
	 **/
	public static function GetErrorLogs( $uid=false,$start=0,$limit=0 ) {
		if(!$uid) $uid = Auth::GetUID();
		$start=DB::Sanitise($start);
		$limit=DB::Sanitise($limit);
		return DB::GetData("SELECT `error_log`.* FROM `error_log` WHERE `error_log`.`customerId` = $uid ORDER BY `date` DESC LIMIT $start,$limit");
	}
	
	/**
	 * How many error log entries are there?
	 * @param int $uid Customer ID, defaults to current user
	 * @return int The limit
	 **/
	public static function GetErrorLogsLimit($uid=false){
		if(!$uid) $uid = Auth::GetUID();
		$rec = DB::GetRecord("SELECT COUNT(1) AS `total` FROM `error_log` WHERE `error_log`.`customerId` = $uid ORDER BY `date` DESC");
		return $rec['total'];
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
	 * @param int $vmId The Virtual Machine UID
	 * @param string $vmName The target Virtual Machine Name
	 * @param string $result The result string
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
	 * @param int $triggerId The ID of the trigger
	 * @param int $limit the maximum number of rows to return
	 * @return array The tick_log rows
	 **/
	public static function GetTickLog ($clusterId,$triggerId,$limit){
		$clusterId = DB::Sanitise($clusterId);
		$triggerId = DB::Sanitise($triggerId);
		$limit = DB::Sanitise($limit);
		return DB::GetData("SELECT * FROM `tick_log` WHERE `clusterId` = $clusterId AND `triggerId` = $triggerId ORDER BY `date` DESC LIMIT $limit;");
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