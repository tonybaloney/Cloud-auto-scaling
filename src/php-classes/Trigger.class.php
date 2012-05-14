<?php
/** 
 * Trigger Class represents a watch (SNMP) on a cluster.
 * A trigger contains the SNMP configuration and the action/approval settings for any auto-scaling
 * @package auto-scaler
 **/
class Trigger {
	public static function CreateTrigger ( $metric, $clusterId ) {
		$name = DB::Sanitise($metric);
		$clusterId = DB::Sanitise($clusterId);
		DB::Query ( "INSERT INTO `triggers` (`triggerName`,`clusterId`) VALUES ('$name','$clusterId')" );
		if( mysql_insert_id() ){
			return new Trigger(mysql_insert_id());
		} else 
			return false;
	}
	public static function GetTriggers($uid=false){
		if(!$uid) $uid = Auth::GetUID();
		return DB::GetData("SELECT triggers.*, clusters.clusterName,`clusters`.`clusterVmCount` FROM triggers INNER JOIN `clusters` ON triggers.clusterId = clusters.clusterId WHERE clusters.customerId = $uid;");
	}
	public static function GetTriggersForCluster($clusterId){
		$clusterId = DB::Sanitise($clusterId);
		return DB::GetData("SELECT triggers.*, clusters.clusterName,`clusters`.`clusterVmCount` FROM triggers INNER JOIN `clusters` ON triggers.clusterId = clusters.clusterId WHERE clusters.clusterId = $clusterId;");
	}
	// Public fields
	private $triggerId;
	public $triggerName;
	public $clusterId;
	public $clusterName;
	public $upper;
	public $lower;
	public $scaleDownTime;
	public $scaleUpTime;
	public $oid;
	public $communityString;
	public $vmPrefix;
	public $triggerApproval;
	public $customerId;
	
	public function Trigger($id,$uid=false) {
		// Get Cluster data
		if(!$uid) $uid = Auth::GetUID();
		$id = DB::Sanitise($id);
		$data = DB::GetData("SELECT triggers.*, clusters.clusterName,clusters.customerId FROM triggers INNER JOIN clusters ON triggers.clusterId = clusters.clusterId WHERE clusters.customerId = $uid AND triggers.triggerId = $id LIMIT 1;");
		// Fill fields
		$data = $data[0];
		$this->customerId = $data['customerId'];
		$this->triggerId = $data['triggerId'];
		$this->triggerName = $data['triggerName'];
		$this->clusterId = $data['clusterId'];
		$this->clusterName = $data['clusterName'];
		$this->upper = $data['upper'];
		$this->lower = $data['lower'];
		$this->scaleDownTime = $data['scaleDownTime'];
		$this->scaleUpTime = $data['scaleUpTime'];
		$this->communityString = $data['communityString'];
		$this->vmPrefix = $data['vmPrefix'];
		$this->triggerApproval = $data['triggerApproval'];
		$this->oid = $data['oid'];
	}
	
	public function Save(){
		$q = "UPDATE `triggers` SET 
			`triggerName`='".DB::Sanitise($this->triggerName)."',
			`upper`='".DB::Sanitise($this->upper)."',
			`clusterId`='".DB::Sanitise($this->clusterId)."',
			`lower`='".DB::Sanitise($this->lower)."',
			`scaleDownTime`='".DB::Sanitise($this->scaleDownTime)."',
			`scaleUpTime`='".DB::Sanitise($this->scaleUpTime)."',
			`communityString`='".DB::Sanitise($this->communityString)."',
			`oid`='".DB::Sanitise($this->oid)."',
			`vmPrefix`='".DB::Sanitise($this->vmPrefix)."',
			`triggerApproval`='".DB::Sanitise($this->triggerApproval)."'
			WHERE `triggerId`=".DB::Sanitise($this->triggerId).";";
		DB::Query($q);
	}
	
	/**
	 * Scale this trigger up or down
	 * @access public
	 * @param string $direction Either SCALE_UP or SCALE_DOWN
	 **/
	public function Scale($direction){
		if($this->triggerApproval == 'Automatic') $approval = 'AUTO_APPROVED';
		else $approval = 'PENDING';
		Alerts::TriggerScalingAlert($this->customerId,$this->clusterId,$this->triggerId,$direction,$approval);
		// Create the item in tock actions.
		DB::Query("INSERT INTO `tock_actions` (`clusterId`,`triggerId`,`action`,`approval`,`date`) VALUES (".DB::Sanitise($this->clusterId).",".DB::Sanitise($this->triggerId).",'$direction','$approval',NOW())");
	}
	
	/**
	 * Scale this trigger up or down
	 * @access public
	 * @param string $direction Either SCALE_UP or SCALE_DOWN
	 **/
	public function CompleteScale($direction){
		$cloud = Auth::GetCloudConnection($this->customerId);
		$cluster = new Cluster($this->clusterId, $this->customerId);
		if ($direction=='SCALE_UP'){
			$cloud->CreateVM ( $cluster->clusterLocation, $cluster->targetApplianceId, $cluster->targetVlanId, $cluster->templateId );
		} else { 
			$cloud->DestroyNextVM ( $cluster->clusterLocation, $cluster->targetApplianceId, $trigger->vmPrefix ) ;
		}	
	}
	
	/**
	 * Modify the approval status of a 'tock action'
	 * @access public
	 * @static
	 * @param int $ta_id The tock action ID
	 * @param string $newApprovalStatus the new approval status e.g. APPROVED
	 **/
	public static function ModifyTockAction ($ta_id, $newApprovalStatus){
		$ta_id = DB::Sanitise($ta_id);
		$newApprovalStatus = DB::Sanitise($newApprovalStatus);
		DB::Query("UPDATE `tock_actions` SET `approval`='$newApprovalStatus' WHERE `ta_id` = $ta_id; ");
	}
}
?>