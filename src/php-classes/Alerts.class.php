<?php
/**
 * Alerts class
 * Static functions for sending email alerts out to the user about events on the system
 * Requirements : pear/Mail_Mime
 * Requirements : pear/Mail
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
		if ($action=='SCALE_UP') {
			$val = DB::GetRecord("SELECT AVG(result) AS `result` FROM tick_log WHERE triggerId=$triggerId AND date > SUBDATE(date,INTERVAL ".$trigger->scaleUpTime." SECOND);" ) ;
			$records = DB::GetData("SELECT result,date FROM tick_log WHERE triggerId=$triggerId AND date > SUBDATE(date),INTERVAL ".$trigger->scaleUpTime." SECOND);" ) ;
		} else {
			$val = DB::GetRecord("SELECT AVG(result) AS `result` FROM tick_log WHERE triggerId=$triggerId AND date > SUBDATE(date,INTERVAL ".$trigger->scaleDownTime." SECOND);" ) ;
			$records = DB::GetData("SELECT result,date FROM tick_log WHERE triggerId=$triggerId AND date > SUBDATE(date,INTERVAL ".$trigger->scaleUpTime." SECOND);" ) ;
		}
		$subject = $action." '".$cluster->clusterName."' on the trigger '".$trigger->triggerName."' is ".$approval;
		$msg = "Hi,\nThis is the auto-scaling system; there is a trigger watching the cluster called '$cluster->clusterName' which has decided to $action.\n";
		$msg .= "The trigger that watches the cluster has detected the SNMP OID ".$trigger->oid." across your cluster to having a value of ".$val['result'].".";
		$msg_html = "<body>".nl2br($msg);
		$msg_html .= "<table><thead><tr><th>Date</th><th>Result</th></tr></thead><tbody>";
		foreach ($records as $record){
			$msg .= "$record[date] : $record[result] \n";
			$msg_html .= "<tr><td>$record[date]</td><td>$record[result]</td></tr>\n";
		}
		$msg_html .= "</tbody></table>";
		
		include ('Mail.php');
		include ('Mail/mime.php');
		$mime = new Mail_mime(array('eol'=>"\n"));
		$mime->setTXTBody($msg);
		$mime->setHTMLBody($msg_html);
		$mime->addHTMLImage('/tmp/test.jpg','image/jpeg');
		$mime->setSubject($subject);
		$body = $mime->get();
		$hdrs = $mime->headers($hdrs);

		$mail =& Mail::factory('mail');
		$mail->send($emails, $hdrs, $body);
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