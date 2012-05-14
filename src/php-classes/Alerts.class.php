<?php
/**
 * Alerts class
 * Static functions for sending email alerts out to the user about events on the system
 * @package auto-scaler
 **/
class Alerts { 
	/** 
	 * Trigger scaling alert
	 * @param int $customerId Customer ID
	 * @param int $clusterId Cluster ID
	 * @param int $triggerId Trigger ID
	 * @param string $action Scaling action (SCALE_UP,SCALE_DOWN)
	 * @param string $approval The approval status (e.g. AUTO_APPROVED)
	 *
	 * @todo Print table or graph of results historically.
	 * @todo List threshold and number of VMs
	 **/
	 public static function TriggerScalingAlert ($customerId,$clusterId, $triggerId, $action, $approval){
		$emails = Alerts::GetEmails($clusterId);
		$trigger = new Trigger($triggerId,$customerId);
		$cluster = new Cluster($clusterId,$customerId);
		if ($action=='SCALE_UP')
			$val = DB::GetRecord("SELECT AVG(result) AS `result` FROM tick_log WHERE triggerId=$triggerId AND date > SUBDATE(date,INTERVAL ".$trigger->scaleUpTime." SECOND);" ) ;
		else 
			$val = DB::GetRecord("SELECT AVG(result) AS `result` FROM tick_log WHERE triggerId=$triggerId AND date > SUBDATE(date,INTERVAL ".$trigger->scaleDownTime." SECOND);" ) ;

		$subject = $action." '".$cluster->clusterName."' on the trigger '".$trigger->triggerName."' is ".$approval;
		$msg = "Hi,\nThis is the auto-scaling system; there is a trigger watching the cluster called '$cluster->clusterName' which has decided to $action.\n";
		$msg .= "The trigger that watches the cluster has detected the SNMP OID ".$trigger->oid." across your cluster to having a value of ".$val['result'].".";
		mail($emails,$subject,$msg);
	 }
	 
	/** 
	 * Trigger VM creation/deletion alert.
	 * @param int $customerId Customer ID
	 * @param int $clusterId Cluster ID
	 * @param int $triggerId Trigger ID
	 * 
	 * @tood implement functionality.
	 **/
	 public static function ClusterChangeAlert( $customerId, $clusterId, $triggerId ) {
	 
	 }
	 
	/** 
	 * Get the emails for this cluster
	 * @param int $clusterId Cluster ID
	 * @access public
	 * @return string List of emails (seperated by semi-colons)
	 **/
	public static function GetEmails ( $clusterId ) {
		$clusterId= DB::Sanitise($clusterId);
		$rec=DB::GetRecord("SELECT `clusterEmailAlerts` FROM `clusters` WHERE `clusterId`=$clusterId");
		return $rec['clusterEmailAlerts'];
	}
}
?>