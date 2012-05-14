<?php 
/**
 * Signpost for POST requests from the frontend
 * all are of the format ?form.php?form=[Add|Save][Cluster|Trigger|Customer]
 * @package auto-scaler
 */

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
		Cluster::CreateCluster($_POST['clusterName']);
		$res['success'] = true;
		$res['msg'] = "Cluster created successfully";
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
			$cluster->targetApplianceId=$_POST['targetApplianceId'];
			$cluster->clusterEmailAlerts=$_POST['clusterEmailAlerts'];
			$cluster->Save();
			$res['success'] = true;
			$res['msg'] = "Cluster modified successfully";
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
			$t->Save();
			$res['success'] = true;
			$res['msg'] = "Trigger modified successfully";
		} else {
			$res['success'] = false;
			$res['msg'] = "Could not find trigger, deleted in another session?";
		}
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