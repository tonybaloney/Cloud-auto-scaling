<?php
/**
  * 'Tick' - PHP version
  * A script to iterate through a list of: 
  * Customers 
  * -> Clusters
  * --> Triggers
  * Collect the performance data for each server in a cluster, log to the DB
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
  
/**
 * Tick function
 * @access public
 * @package auto-scaler
 **/
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

					$triggers = Trigger::GetTriggersForCluster($cluster['clusterId'],$custId);
					// 1: Get a list of each VM in the target appliance
					$vms = $cloud->GetVirtualMachines($location,$applianceId);
					if (is_array($vms)){
						$num_vms= count($vms);
						DB::Query("UPDATE `clusters` SET `clusterVmCount` = $num_vms WHERE `clusterId`=$cluster[clusterId]");
						foreach ($vms as $vm){
							$nets = $cloud->GetVirtualMachineNetworks($location,$applianceId,$vm['vmId']);
							$lastNicSucceed=false;
							if(is_array($nets)){
								foreach ($nets as $net) { 
									if ($lastNicSucceed){
										// Continue to end of list..
									} else {
										$ip = $net['nicIP'];
										foreach ( $triggers as $trigger ) {
											if(strncmp($vm['vmName'], $trigger['vmPrefix'], strlen($trigger['vmPrefix'])) == 0){
												$result = @snmpget($ip,$trigger['communityString'],$trigger['oid']);
												if ($result !== false){
													// Log SNMP result to the DB.
													$result_parts = explode(' ',$result);
													if (is_numeric($result_parts[1])) {
														Log::LogTickResult($customer['customerId'],$cluster['clusterId'],$trigger['triggerId'],$vm['vmId'],$vm['vmName'],$result_parts[1]);
													} else
														trigger_error( "SNMP result is non-numeric, cannot track and action strings, trigger:".$trigger['triggerName'] );
													$lastNicSucceed=true;
													$result_count++;
												}
											} else {
												// Ignore because this VM does not start with the vmPrefix that the trigger contains..
											}
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
/** 
 * Log invalid result from SNMP or API
 * @package auto-scaler
 **/
function invalid_result(){
	trigger_error("Received invalid result from an API or DB call.");
}
?>