<?php
/** 
 * Load database views into JSON for frontend 
 * @package auto-scaler
 */

if (!isset($_GET['view'])) die();

include ('../src/all.inc.php');

switch ($_GET['view']){
	case 'Cluster':
		$data = Cluster::GetClusters();
		break;
	case 'Trigger':
		$data = Trigger::GetTriggers();
		break;
	case 'Customer':
		$data[] = Auth::GetMe();
		break;
	case 'Log':
		$data = Log::GetLogs();
		break;
	case 'Locations':
		try { 
			$cloud = Auth::GetCloudConnection();
			$data = $cloud->GetLocations();
		} catch (ConnectorException $cex){
			die ($cex->GetConnectorErrorMessage());
		}
		break;
	case 'PrivateNetworks':
		try { 
			$cloud = Auth::GetCloudConnection();
			$data = $cloud->GetPrivateNetworks($_GET['location']);
		} catch (ConnectorException $cex){
			die ($cex->GetConnectorErrorMessage());
		}
		break;
}
echo json_encode($data);
?>