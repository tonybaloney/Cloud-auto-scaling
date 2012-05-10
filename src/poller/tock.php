<?php

/** 
 * 'tock' - the process that reviews the results from the triggers and creates actions.
 * @package auto-scaler
 **/
require('../all.inc.php');
Tock();
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
							$scaleup = DB::GetRecord("SELECT AVG(result) FROM tick_log WHERE triggerId=$trigger[triggerId] AND date > SUBDATE(date,INTERVAL $trigger[scaleUpTime] SECOND);" ) ;
							$scaledown = DB::GetRecord("SELECT AVG(result) FROM tick_log WHERE triggerId=$trigger[triggerId] AND date > SUBDATE(date,INTERVAL $trigger[scaleUpTime] SECOND);" ) ;
							if ($scaleup > $trigger['upper']) { 
								// Scale UP!!
							} else if ($scaledown < $trigger['lower']) { 
								// Scale down..
							}	
						}
					}
				}
			}
		}
	}
}
?>