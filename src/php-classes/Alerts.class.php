<?php
 /**
  * Alerts.class.php
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
  
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
	 **/
	 public static function TriggerScalingAlert ($customerId,$clusterId, $triggerId, $action, $approval){
		$emails = Alerts::GetEmails($clusterId);
		if(trim($emails)=='') return;
		$trigger = new Trigger($triggerId,$customerId);
		$cluster = new Cluster($clusterId,$customerId);
		$fname = uniqid().'.jpg';
		$val = $trigger->GetAverageResult();
		$records = $trigger->GetResults();
		
		$subject = $action." '".$cluster->clusterName."' on the trigger '".$trigger->triggerName."' is ".$approval;
		$msg = "Hi,\nThis is the auto-scaling system; there is a trigger watching the cluster called '$cluster->clusterName' which has decided to $action.\n";
		$msg .= "The trigger that watches the cluster has detected the SNMP OID ".$trigger->oid." across your cluster to having a value of $val.";
		$msg_html = "<body>".nl2br($msg)."<br/><img src='$fname'/>";
		$msg_html .= "<table><thead><tr><th>Date</th><th>VM Name</th><th>Result</th></tr></thead><tbody>";
		foreach ($records as $record){
			$msg .= "$record[date] : $record[vmName] : $record[result] \n";
			$msg_html .= "<tr><td>$record[date]</td><td>$record[vmName]</td><td>$record[result]</td></tr>\n";
		}
		$msg_html .= "</tbody></table>";
		// TODO: Explain actions and next steps.
		include_once ('Mail.php');
		include_once ('Mail/mime.php');
		$mime = new Mail_mime(array('eol'=>"\n"));
		$mime->setTXTBody($msg);
		$mime->setHTMLBody($msg_html);
		
		Charts::TriggerGraph($trigger,'/tmp/'.$fname);
		$mime->addHTMLImage('/tmp/'.$fname,'image/jpeg');
		$mime->setSubject($subject);
		$body = $mime->get();
		$hdrs = $mime->headers();

		$mail =& Mail::factory('mail');
		$mail->send($emails, $hdrs, $body);
		}
	 
	/** 
	 * Trigger VM creation/deletion alert.
	 * @param int $customerId Customer ID
	 * @param int $clusterId Cluster ID
	 * @param int $triggerId Trigger ID
	 * @param string $action The change action (SCALE_UP or SCALE_DOWN)
	 **/
	 public static function ClusterChangeAlert( $customerId, $clusterId, $triggerId, $action ) {
		include_once ('Mail.php');
		include_once ('Mail/mime.php');
		$mime = new Mail_mime(array('eol'=>"\n"));
		$emails = Alerts::GetEmails($clusterId);
		
		if(trim($emails)=='') return;
		$trigger = new Trigger($triggerId,$customerId);
		$cluster = new Cluster($clusterId,$customerId);
		$fname = uniqid().'.jpg';
		$val = $trigger->GetAverageResult();
		$records = $trigger->GetResults();
		// TODO: implement functionality.
		$subject = $action." '".$cluster->clusterName."' on the trigger '".$trigger->triggerName."' has completed";
		$msg = "Hi,\nThis is the auto-scaling system; there is a trigger watching the cluster called '$cluster->clusterName' which has decided to $action.\n";
		$msg .= "The trigger that watches the cluster has detected the SNMP OID ".$trigger->oid." across your cluster to having a value of $val.";
		$msg_html = "<body>".nl2br($msg);
		
		$mime->setTXTBody($msg);
		$mime->setHTMLBody($msg_html);

		$mime->setSubject($subject);
		$body = $mime->get();
		$hdrs = $mime->headers();

		$mail =& Mail::factory('mail');
		$mail->send($emails, $hdrs, $body);	 
	 }
	 
	 /** 
	 * Trigger warning about the VM limit being reached
	 * @param int $customerId Customer ID
	 * @param int $clusterId Cluster ID
	 * @param int $triggerId Trigger ID
	 * TODO: implement code
	 **/
	 public function FloorCeilingAlert( $customerId, $clusterId, $triggerId ) { 
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
	
	/** 
	 * Trigger warning about 2 triggers raising events at the same time
	 * @param int $clusterId Cluster ID
	 **/
	public function ConflictAlert( $clusterId ) {
		
	}
}
?>