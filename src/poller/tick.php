<?php

/** 
 * 'Tick' - PHP version
 * A script to iterate through a list of: 
 * Customers 
 * -> Clusters
 * --> Triggers
 * Collect the performance data for each server in a cluster, log to the DB
 **/
require( '../all.inc.php');
Tick();
function Tick () {
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
					// Get the network information..
					// Cluster location ID (VDC ID in Abiquo)
					$location = $cluster['clusterLocation'];
					// VLAN ID (Private Network ID in Abiquo)
					$applianceId = $cluster['targetApplianceId'];
					$pnId = $cluster['targetVlanId'];

					$triggers = Trigger::GetTriggersForCluster($cluster['clusterId']);
					// 1: Get a list of each VM in the target appliance
					$vms = $cloud->GetVirtualMachines($location,$applianceId);
					if (is_array($vms)){
						foreach ($vms as $vm){
							$nets = $cloud->GetVirtualMachineNetworks($location,$applianceId,$vm['vmId']);
							if(is_array($nets)){
								foreach ($nets as $net) { 
									$ip = $net['nicIP'];
									foreach ( $triggers as $trigger ) {
										$result = @snmpget($ip,$trigger['communityString'],$trigger['oid']);
										if ($result !== false){
											// Log SNMP result to the DB.
											$result_parts = explode(' ',$result);
											if (is_numeric($result_parts[1]))
												Log::LogTickResult($customer['customerId'],$cluster['clusterId'],$trigger['triggerId'],$vm['vmId'],$vm['vmName'],$result_parts[1]);
											else
												trigger_error( "SNMP result is non-numeric, cannot track and action strings, trigger:".$trigger['triggerName'] );
											$result_count++;
										}
									}
								}
							} else
								invalid_result();
						}	
					} else {
						invalid_result();
					}
				}
			} else
				invalid_result();
		}
	} else 
		invalid_result();
	if($result_count==0)
		trigger_error("Did not establish any succesful SNMP results. Check configuration and network connectivity.");
}
function invalid_result(){
	trigger_error("Received invalid result from an API or DB call.");
}
?>