<?php 
/**
  * Signpost for POST requests from the frontend
  * all are of the format ?form.php?form=[Add|Save][Cluster|Trigger|Customer]
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
if (!isset($_GET['form'])) 
	if (!isset($_POST['form']))
		die("{success:false,msg:'Request invalid'}");
	else 
		$form = $_POST['form'];
else 
	$form = $_GET['form'];

include ('../src/all.inc.php');

$res = array( 'success'=>false,'msg'=>'Message not understood');

switch ($form){
	case 'ApproveTock':
		$ta_id = $_POST['ta_id'];
		Trigger::ModifyTockAction($ta_id,'APPROVED');
		$res['success'] = true;
		$res['msg'] = "Approved $ta_id";
		break;
	case 'DeclineTock':
		$ta_id = $_POST['ta_id'];
		Trigger::ModifyTockAction($ta_id,'DECLINED');
		$res['success'] = true;
		$res['msg'] = "Declined $ta_id";
		break;
	case 'AddCluster':
		$cluster = Cluster::CreateCluster($_POST['clusterName']);
		if ($cluster===false){
			$res['success'] = false;
			$res['msg'] = "Failed to create cluster, could not connect or auth to DB.";	
		} else {
			$cluster->clusterLocation=$_POST['clusterLocation'];
			$cluster->minServers=$_POST['minServers'];
			$cluster->maxServers=$_POST['maxServers'];
			$cluster->targetVlanId=$_POST['targetVlanId'];
			$cluster->targetSecondaryVlanId=$_POST['targetSecondaryVlanId'];
			$cluster->targetApplianceId=$_POST['targetApplianceId'];
			$cluster->clusterEmailAlerts=$_POST['clusterEmailAlerts'];
			$cluster->templateUrl=$_POST['templateUrl'];
			$cluster->Save();
			$res['success'] = true;
			$res['msg'] = "Cluster created successfully";
		}
		
		break;
	case 'SaveCluster':
		$cluster = new Cluster($_POST['clusterId']);
		if( $cluster ) {
			// Save fields.
			$cluster->clusterName=$_POST['clusterName'];
			$cluster->clusterLocation=$_POST['clusterLocation'];
			$cluster->minServers=$_POST['minServers'];
			$cluster->maxServers=$_POST['maxServers'];
			$cluster->targetVlanId=$_POST['targetVlanId'];
			$cluster->targetSecondaryVlanId=$_POST['targetSecondaryVlanId'];
			$cluster->targetApplianceId=$_POST['targetApplianceId'];
			$cluster->clusterEmailAlerts=$_POST['clusterEmailAlerts'];
			$cluster->templateUrl=$_POST['templateUrl'];
			$cluster->Save();
			$res['success'] = true;
			$res['msg'] = "Cluster modified successfully";
		} else { 
			$res['success'] = false;
			$res['msg'] = "Could not find cluster, deleted in another session?";
		}
		break;
	case 'DeleteCluster':
		$cluster = new Cluster($_POST['id']);
		if ($cluster)	{
			$cluster->Delete();
			$res['success'] = true;
			$res['msg'] = "Cluster deleted successfully";
		} else {
			$res['success'] = false;
			$res['msg'] = "Could not find cluster, deleted in another session?";
		}
		break;	
	case 'AddTrigger':
		$t = Trigger::CreateTrigger($_POST['triggerName'],$_POST['clusterId']);
		if ($t){
			$t->upper = $_POST['upper'];
			$t->lower = $_POST['lower'];
			$t->scaleUpTime = $_POST['scaleUpTime'];
			$t->scaleDownTime = $_POST['scaleDownTime'];
			$t->clusterId = $_POST['clusterId'];
			$t->oid = $_POST['oid'];
			$t->communityString = $_POST['communityString'];
			$t->triggerApproval = $_POST['triggerApproval'];
			$t->vmPrefix = $_POST['vmPrefix'];
			$t->priority = $_POST['priority'];
			$t->Save();
			$res['success'] = true;
			$res['msg'] = "Trigger created successfully";
		} else {
			$res['success'] = false;
			$res['msg'] = "Could not find trigger, deleted in another session?";
		}
		break;
	case 'SaveTrigger':
		$t = new Trigger($_POST['triggerId']);
		if ($t){
			$t->triggerName = $_POST['triggerName'];
			$t->upper = $_POST['upper'];
			$t->lower = $_POST['lower'];
			$t->scaleUpTime = $_POST['scaleUpTime'];
			$t->scaleDownTime = $_POST['scaleDownTime'];
			$t->clusterId = $_POST['clusterId'];
			$t->oid = $_POST['oid'];
			$t->communityString = $_POST['communityString'];
			$t->triggerApproval = $_POST['triggerApproval'];
			$t->vmPrefix = $_POST['vmPrefix'];
			$t->priority = $_POST['priority'];
			$t->Save();
			$res['success'] = true;
			$res['msg'] = "Trigger modified successfully";
		} else {
			$res['success'] = false;
			$res['msg'] = "Could not find trigger, deleted in another session?";
		}
		break;
	case 'DeleteTrigger':
		$triggerId = $_POST['triggerId'];
		Trigger::DeleteTrigger($triggerId);
		$res['success'] = true;
		$res['msg'] = "Trigger deleted.";
		break;
	case 'TriggerForceScale':
		$triggerId = $_POST['triggerId'];
		$trigger = new Trigger($triggerId);
		$trigger->Scale($_POST['direction'],'PENDING');
		$res['success'] = true;
		$res['msg'] = "Trigger deleted.";
		break;
	case 'SaveCustomer':
		Auth::SaveDetails($_POST['portalAPIUrl'],$_POST['portalUsername'],$_POST['portalPassword'],$_POST['apiType']);
		try {
			$cloud = Auth::GetCloudConnection();
			$result = $cloud->TestConnection();
			if($result) {
				$res['success'] = true;
				$res['msg'] = 'Updated user details. Connection test to API was successful.';
			} else {
				$res['success'] = false;
				$res['msg'] = 'Could not establish connection to API';
			}
		} catch (ConnectorException $cex){
			$res['success'] = false;
			$res['msg'] = $cex->GetConnectorErrorMessage();
		}
	break;
}
echo json_encode($res);
?>