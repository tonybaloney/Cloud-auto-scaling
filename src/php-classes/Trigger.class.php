<?php
 /**
  * Trigger.class.php
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/

/** 
 * Trigger Class represents a watch (SNMP) on a cluster.
 * A trigger contains the SNMP configuration and the action/approval settings for any auto-scaling
 * @package auto-scaler
 **/
class Trigger {
	/** 
	 * Create a new trigger
	 * @access public
	 * @static
	 * @param string $metric The metric to use
	 * @param int $clusterId The cluster in which this trigger is located
	 * @return object The Trigger, returns false on failure
	 **/
	public static function CreateTrigger ( $metric, $clusterId ) {
		$name = DB::Sanitise($metric);
		$clusterId = DB::Sanitise($clusterId);
		DB::Query ( "INSERT INTO `triggers` (`triggerName`,`clusterId`) VALUES ('$name','$clusterId')" );
		if( mysql_insert_id() ){
			return new Trigger(mysql_insert_id());
		} else 
			return false;
	}
	
	/** 
	 * Delete a trigger
	 * @param int $triggerId The trigger  ID
	 * @param int $uid Filter by user, default to current user
	 * @static
	 * @access public
	 **/
	public static function DeleteTrigger ($triggerId, $uid = false){
		$triggerId = DB::Sanitise($triggerId);
		if(!$uid) $uid = Auth::GetUID();
		DB::Query("DELETE FROM `triggers` WHERE `triggerId` = $triggerId;");
		DB::Query("DELETE FROM `tick_log` WHERE `triggerId` = $triggerId;");
		DB::Query("DELETE FROM `tock_actions` WHERE `triggerId` = $triggerId;");
	}
	
	/** 
	 * Get all of the triggers 
	 * @param int $uid Only get triggers for this user
	 * @access public
	 * @return array List of triggers
	 **/
	public static function GetTriggers($uid=false){
		if(!$uid) $uid = Auth::GetUID();
		return DB::GetData("SELECT triggers.*, clusters.clusterName,`clusters`.`clusterVmCount` FROM triggers INNER JOIN `clusters` ON triggers.clusterId = clusters.clusterId WHERE clusters.customerId = $uid ORDER BY priority ASC;");
	}
	
	/**
	 * Get triggers for a specific cluster
	 * @param int $clusterId The cluster ID
	 * @param int $uid Only get triggers for this user, defaults to current user
	 * @access public
	 * @return array List of triggers 
	 **/
	public static function GetTriggersForCluster($clusterId,$uid=false){
		$clusterId = DB::Sanitise($clusterId);
		if(!$uid) $uid = Auth::GetUID();
		return DB::GetData("SELECT triggers.*, clusters.clusterName,`clusters`.`clusterVmCount` FROM triggers INNER JOIN `clusters` ON triggers.clusterId = clusters.clusterId WHERE clusters.clusterId = $clusterId AND clusters.customerId=$uid  ORDER BY priority ASC");
	}
	
	/** 
	 * The trigger ID
	 * @var int
	 * @access private
	 **/
	private $triggerId;
	
	/** 
	 * The trigger name
	 * @var string
	 * @access public
	 **/
	public $triggerName;
	
	/** 
	 * The cluster ID this trigger belongs to
	 * @var int
	 * @access public
	 **/
	public $clusterId;
	
	/** 
	 * The upper trigger limit
	 * @var string
	 * @access public
	 **/
	public $upper;
	
	/** 
	 * The lower trigger limit
	 * @var string
	 * @access public
	 **/
	public $lower;
	
	/** 
	 * The trigger name
	 * @var string
	 * @access public
	 **/
	public $scaleDownTime;
	
	/** 
	 * The time window for scale up events, in seconds
	 * @var int
	 * @access public
	 **/
	public $scaleUpTime;
	
	/** 
	 * The time window for scale down events, in seconds
	 * @var string
	 * @access public
	 **/
	public $oid;
	
	/** 
	 * The SNMP v2 community string
	 * @var string
	 * @access public
	 **/
	public $communityString;
	
	/** 
	 * The vm prefix for new Virtual Machines, monitored ones or deleted ones
	 * @var string
	 * @access public
	 **/
	public $vmPrefix;
	
	/** 
	 * Approval method, either 'Automatic' or 'Manual'
	 * @var string
	 * @access public
	 **/
	public $triggerApproval;
	
	/** 
	 * The customer id
	 * @var int
	 * @access public
	 **/
	public $customerId;

	/**
	 * The priority of the trigger (highest takes priority)
	 * @var int
	 * @access public
	 **/
	public $priority;
	
	/** 
	 * Fetch the trigger from the DB
	 * @param int $id The trigger ID
	 * @param int $uid The User ID to filter by, defaults to the current user
	 **/
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
		$this->upper = $data['upper'];
		$this->lower = $data['lower'];
		$this->scaleDownTime = $data['scaleDownTime'];
		$this->scaleUpTime = $data['scaleUpTime'];
		$this->communityString = $data['communityString'];
		$this->vmPrefix = $data['vmPrefix'];
		$this->triggerApproval = $data['triggerApproval'];
		$this->oid = $data['oid'];
		$this->priority = $data['priority'];
	}
	
	/** 
	 * Save the data in this class back to the database
	 * @access public
	 **/
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
			`triggerApproval`='".DB::Sanitise($this->triggerApproval)."',
			`priority`='".DB::Sanitise($this->priority)."'
			WHERE `triggerId`=".DB::Sanitise($this->triggerId).";";
		DB::Query($q);
	}
	
	/**
	 * Scale this trigger up or down
	 * @access public
	 * @param string $direction Either SCALE_UP or SCALE_DOWN
	 **/
	public function Scale($direction,$approval=false){
		if (!$approval) {
			if($this->triggerApproval == 'Automatic') $approval = 'AUTO_APPROVED';
			else $approval = 'PENDING';
		}
		$cluster = new Cluster($this->clusterId,$this->customerId);
		// Check limits
		if (($direction=='SCALE_UP' && ($cluster->clusterVmCount+1 > $cluster->maxServers)) OR ($direction == 'SCALE_DOWN' && ($cluster->clusterVmCount-1 < $cluster->minServers))){
			Alerts::FloorCeilingAlert($this->customerId,$this->clusterId,$this->triggerId);
			$cluster->SetHold();
		} else {
			Alerts::TriggerScalingAlert($this->customerId,$this->clusterId,$this->triggerId,$direction,$approval);
			// Create the item in tock actions.
			DB::Query("INSERT INTO `tock_actions` (`clusterId`,`triggerId`,`action`,`approval`,`date`) VALUES (".DB::Sanitise($this->clusterId).",".DB::Sanitise($this->triggerId).",'$direction','$approval',NOW())");
		}
	}
	
	/**
	 * Scale this trigger up or down
	 * @access public
	 * @param string $direction Either SCALE_UP or SCALE_DOWN
	 **/
	public function CompleteScale($direction){
		$cloud = Auth::GetCloudConnection($this->customerId);
		$cluster = new Cluster($this->clusterId, $this->customerId);
		$trigger = new Trigger($this->triggerId, $this->customerId);
		if ($direction=='SCALE_UP'){
			$cloud->CreateVM ( $cluster->clusterLocation, $cluster->targetApplianceId, $cluster->targetVlanId, $cluster->targetSecondaryVlanId, $cluster->templateUrl, $trigger->vmPrefix.uniqid() );
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
	
	/**
	 * Get the time window of this trigger (the scale up or down time, whichever is the largest)
	 * @return int Window in seconds
	 * @access private
	 **/
	private function GetTimeWindow(){
		return ($this->scaleDownTime>$this->scaleUpTime?$this->scaleDownTime:$this->scaleUpTime);
	}
	
	/** 
	 * Get the average result for this trigger
	 * @access public
	 * @return string Average result
	 **/
	public function GetAverageResult ( ) {
		$val = DB::GetRecord("SELECT AVG(result) AS `result` FROM tick_log WHERE triggerId=".$this->triggerId." ;" ) ;
		return $val['result'];
	}
	
	/** 
	 * Get the results from the trigger
	 * @access public
	 * @param bool $desc List results newest first (defaults false)
	 * @return array Result log
	 **/
	public function GetResults ($desc=false) {
		if($desc)
			$order = 'DESC';
		else 
			$order = 'ASC';
		$records = DB::GetData("SELECT result,date,vmName FROM tick_log WHERE triggerId=".$this->triggerId." ORDER BY `date` $order;" ) ;
		return $records;
	}
	
	/** 
	 * Does this trigger have a pending request open? 
	 * @access public
	 * @return bool 
	 **/
	public function HasPendingRequest(){
		$rec=DB::GetRecord("SELECT COUNT(1) as `num` FROM `tock_actions` WHERE `triggerId`=".$this->triggerId." AND (`approval` IN('PENDING','APPROVED','AUTO_APPROVED') OR (`approval`='DECLINED'))");
		return ($rec['num']>0);
	}
}
?>