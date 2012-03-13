<?php

// JSON data loader 

if (!isset($_GET['view'])) die();

include ('src/all.inc.php');

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
}
echo json_encode($data);
?>