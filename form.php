<?php 
// System form input

if (!isset($_GET['form'])) die();

include ('src/all.inc.php');

$res = array( 'success'=>false,'msg'=>'Message not understood');

switch ($_GET['form']){
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
			$cluster->minServers=$_POST['minServers'];
			$cluster->maxServers=$_POST['maxServers'];
			$cluster->targetVlanId=$_POST['targetVlanId'];
			$cluster->targetVlanName=$_POST['targetVlanName'];
			$cluster->targetApplianceId=$_POST['targetApplianceId'];
			$cluster->targetApplianceName=$_POST['targetApplianceName'];
			$cluster->Save();
			$res['success'] = true;
			$res['msg'] = "Cluster modified successfully";
		} else { 
			$res['success'] = false;
			$res['msg'] = "Could not find cluster, deleted in another session?";
		}
		break;
	case 'AddTrigger':
		$t = Trigger::CreateTrigger($_POST['triggerName']);
		if ($t){
			$t->upper = $_POST['upper'];
			$t->lower = $_POST['lower'];
			$t->scaleUpTime = $_POST['scaleUpTime'];
			$t->scaleDownTime = $_POST['scaleDownTime'];
			$t->clusterId = $_POST['clusterId'];
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
		$res['success'] = true;
		$res['msg'] = 'Updated user details.';
	break;
}
echo json_encode($res);
?>