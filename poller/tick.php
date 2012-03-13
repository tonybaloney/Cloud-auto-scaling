<?php

/*
 * SNMP Poller
 */
require_once('../src/all.inc.php');
 
 // Get all of the customers
 foreach (Auth::GetAllCustomers() as $cust){
	// Get all of the clusters for this customer.
	foreach (Cluster::GetClusters($cust['customerId']) as $cluster ) {
		// Get all of the triggers in this cluster
		foreach (Trigger::GetTriggers($cust['customerId'] as $trigger){
			// Get the IP's in this VAPP
			$vdc_id = $cluster['targetVdcId'];
			$vapp_id = $cluster['targetApplianceId'];
			$abq = new Abiquo ($cust['portalAPIUrl'],$cust['portalUsername'],$cust['portalPassword']);
			if($abq){
				$ips = $abq->GetIPsUsedInVirtualAppliance($vdc_id,$vapp_id);
				foreach ($ips->ips->ip as $ip){
					$addr= $ip->ip;
					$result = @snmpget ( $addr, $trigger['communityString'], $trigger['oid'] );
					if ($result) {
						// Add the result to the DB
						DB::Query( "INSERT INTO `tick_log` (`customerId`,`clusterId`,`triggerId`,`result`) VALUES (".DB::Sanitise($cust['customerId']).",".DB::Sanitise($cluster['clusterId']).",".DB::Sanitise($trigger['triggerId']).",'".DB::Sanitise($result)."');") ;
					}
				}
			}
		}
	}
 }
 
?>