<?php

/** 
 * 'tock' - the process that reviews the results from the triggers and creates actions.
 * @package auto-scaler
 **/

function Tock(){
	// Get Every customer
	$customers = Auth::GetAllCustomers();
	$result_count=0;
	// Get all customers.
	if (is_array($customers)){
		foreach ($customers as $customer){
			$custId = $customer['customerId'];
			$cloud = Auth::GetCloudConnection($custId);
			// Get clusters
			$clusters = Cluster::GetClusters($custId);
			if (is_array($clusters)){
				foreach ($clusters as $cluster){
					$triggers = Trigger::GetTriggersForCluster($cluster['clusterId']);
					if (is_array($triggers)){
						foreach ($triggers as $trigger) { 
							// Is there an outstanding record for this (either a pending item or an item that has been declined recently.)
							$t = ($trigger['scaleUpTime']>$trigger['scaleDownTime']?$trigger['scaleUpTime']:$trigger['scaleDownTime']);
							$rec=DB::GetRecord("SELECT COUNT(1) as `num` FROM `tock_actions` WHERE `triggerId`=$trigger[triggerId] AND (`approval` IN('PENDING','APPROVED','AUTO_APPROVED') OR (`approval`='DECLINED' AND `date` < SUBDATE(date, INTERVAL $t SECOND)))");
							$has_outstanding_request = ($rec['num']>0);
							if(!$has_outstanding_request){
								$scaleup = DB::GetRecord("SELECT AVG(result) FROM tick_log WHERE triggerId=$trigger[triggerId] AND date > SUBDATE(date,INTERVAL $trigger[scaleUpTime] SECOND);" ) ;
								$scaledown = DB::GetRecord("SELECT AVG(result) FROM tick_log WHERE triggerId=$trigger[triggerId] AND date > SUBDATE(date,INTERVAL $trigger[scaleDownTime] SECOND);" ) ;
								$triggerCls= new Trigger($trigger['triggerId'],$custId);
								if ($scaleup > $trigger['upper']) { 
									// Scale UP!!
									$triggerCls->Scale('SCALE_UP');
								} else if ($scaledown < $trigger['lower']) { 
									// Scale down..
									$triggerCls->Scale('SCALE_DOWN');
								}
							}
							// Purge old data
							DB::Query("DELETE FROM `tick_log` WHERE `date` < SUBDATE(date,INTERVAL $t SECOND) AND `triggerId`=$trigger[triggerId]");
						}
					}
				}
			}
		}
	}
}
?>