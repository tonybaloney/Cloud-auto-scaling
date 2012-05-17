<?php
/** 
 * 'Clock' The process that loops around the checks, triggers and actions.
 * sends alerts to relevant parties about automatically approved or pending requests.
 * @package auto-scaler
 * @todo Setup check externally to this script so it can be monitored.
 **/
require( '../all.inc.php');
require( 'tick.php' ) ;
require( 'tock.php' ) ;
// Loop forever
while (1==1){
	$tick_count = 0;
	$tock_ready=false;
	
	// Purge all old
	// "Currently, you cannot delete from a table and select from the same table in a subquery. " - MYSQL 5.5 DOC
	// Instead get the ID list from a select and put into a delete statement.
	$ids = DB::GetData("SELECT `tl_id` FROM `tick_log` AS `tl` WHERE TIMESTAMPDIFF(SECOND,`date`,(Select MAX(date) from tick_log AS `tl2` WHERE `tl2`.`triggerId`=`tl`.`triggerId`)) > 300;");
	$id_list=array();
	foreach ($ids as $id)
		$id_list [] = $id['tl_id'];
	$id_in_string = implode(',',$id_list);
	if ($id_in_string!='')
		DB::Query("DELETE FROM `tick_log` WHERE `tl_id` IN ($id_in_string);");
	
	// Loop through the tick process
	// Break the loop on either the 5th iteration or when a tick takes longer than 60 seconds
	while(!$tock_ready){
		$t1 = time();
		Tick();
		$tick_count++;
		$t2 = time();
		if($t2-$t1>60){
			$tock_ready=true;
		} else if ($tick_count>=5)
			$tock_ready=true;
		else
			sleep(5);
	}
	Tock();
	// Run the tock process to determine actions to take on these results
	$res = DB::GetData( "SELECT `tock_actions`.*,`clusters`.`customerId` FROM `tock_actions` INNER JOIN `clusters` ON `tock_actions`.`clusterId` = `clusters`.`clusterId` WHERE `approval` IN ('APPROVED','AUTO_APPROVED')");
	foreach ($res as $action){
		$id = $action['ta_id'];
		Alerts::ClusterChangeAlert($action['customerId'],$action['clusterId'],$action['triggerId']);
		$trigger = new Trigger ($action['triggerId'],$action['customerId']);
		try { 
			$trigger->CompleteScale($action['action']);
		} catch ( ConnectorException $cex ){
			echo "Failure in API call. Logged to records.\n";
		}	
	}
}
?>