<?php
 /**
  * 'tock' - the process that reviews the results from the triggers and creates actions.
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
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
			// Get clusters
			$clusters = Cluster::GetClusters($custId);
			if (is_array($clusters)){
				foreach ($clusters as $cluster){
					$clusterCls = new Cluster($cluster['clusterId']);
					if(!$clusterCls->OnHold()) { // Cluster is not on hold
						$triggers = Trigger::GetTriggersForCluster($cluster['clusterId'],$custId);
						if (is_array($triggers)){
							foreach ($triggers as $trigger) { 
								// Is there an outstanding record for this (either a pending item or an item that has been declined recently.)
								$triggerCls= new Trigger($trigger['triggerId'],$custId);
								if(!$triggerCls->HasPendingRequest()){									 
									$clusterCls->ResetHold();
									$result = $triggerCls->GetAverageResult();
									if ($result > $trigger['upper']) { 
										$triggerCls->Scale('SCALE_UP');
									} else if ($result < $trigger['lower']) { 
										$triggerCls->Scale('SCALE_DOWN');
									}
								}
							}
						}
					}
				}
			}
		}
	}
}
?>