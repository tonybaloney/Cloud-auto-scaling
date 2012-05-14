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
while (1==1){
	$tick_count = 0;
	$tock_ready=false;
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
	$res = DB::GetRecords( "SELECT `tock_actions`.*,`clusters`.`customerId` FROM `tock_actions` INNER JOIN `clusters` ON `tock_actions`.`clusterId` = `clusters`.`clusterId` WHERE `approval` IN ('APPROVED','AUTO_APPROVED')");
	foreach ($res as $action){
		$id = $action['ta_id'];
		Alerts::ClusterChangeAlert($action['customerId'],$action['clusterId'],$action['triggerId']);
		$trigger = new Trigger ($action['triggerId'],$action['customerId']);
		$trigger->CompleteScale($action['action']);
	}
}
?>