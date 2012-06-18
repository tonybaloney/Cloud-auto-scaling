<?php
/**
  * Load database views into JSON for frontend
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/

if (!isset($_GET['view'])) die();

include ('../src/all.inc.php');
$data = array();
switch ($_GET['view']){
	case 'Cluster':
		$data = Cluster::GetClusters();
		break;
	case 'Trigger':
		if(isset($_GET['clusterId']))
			$data = Trigger::GetTriggersForCluster($_GET['clusterId']);
		else
			$data = Trigger::GetTriggers();
		break;
	case 'Customer':
		$data[] = Auth::GetMe();
		break;
	case 'TickLog':
		if(isset($_GET['clusterId']) && isset($_GET['triggerId'])) 
			$data = Log::GetTickLog($_GET['clusterId'],$_GET['triggerId'],$_GET['limit']);
		break;
	case 'TockLog':
		if(isset($_GET['clusterId']))
			$data = Log::GetTockLog($_GET['clusterId']);
		break;
	case 'ErrorLog':
		$data['logs'] = Log::GetErrorLogs(false,$_GET['start'],$_GET['limit']);
		$limit=Log::GetErrorLogsLimit();
		$data['total'] = $limit;
		break;
	case 'Locations':
		try {
			$cloud = Auth::GetCloudConnection();
			$data = $cloud->GetLocations();
		} catch (ConnectorException $cex){
			die ($cex->GetConnectorErrorMessage());
		}
		break;
	case 'Templates':
		if(isset($_GET['location'])) {
			try {
				$cloud = Auth::GetCloudConnection();
				$data = $cloud->GetTemplates($_GET['location']);
			} catch (ConnectorException $cex){
				die ($cex->GetConnectorErrorMessage());
			}
		}
		break;
	case 'PrivateNetworks':
		if(isset($_GET['location'])) {
			try {
				$cloud = Auth::GetCloudConnection();
				$data = $cloud->GetPrivateNetworks($_GET['location']);
			} catch (ConnectorException $cex){
				die ($cex->GetConnectorErrorMessage());
			}
		}
		break;
	case 'VirtualAppliances':
		if(isset($_GET['location'])) {
			try {
				$cloud = Auth::GetCloudConnection();
				$data = $cloud->GetAppliances($_GET['location']);
			} catch (ConnectorException $cex){
				die ($cex->GetConnectorErrorMessage());
			}
		}
		break;		
	case 'clockd_status':
		$process_count = exec ( "ps axc | awk  '{print $5}' | grep clockd | wc -l" ) ;
		$data['running'] = ($process_count > 0) ;
		break;
}
echo json_encode($data);
?>
