<?php

class Cluster {
	public static function CreateCluster ( $name ) {
		$name = DB::Sanitise($name);
		DB::Query ( "INSERT INTO `clusters` (`clusterName`) VALUES ('$name')" );
	}
	public static function GetClusters($uid=false){
		if (!$uid) $uid = Auth::GetUID();
		return DB::GetData("SELECT * FROM `clusters` WHERE `customerId`=$uid;");
	}
	
	private $clusterId;
	public $clusterName; // Friendly name of the cluster
    public $customerId; // UID of the user/customer
	public $minServers; // Minimum number of servers required in cluster
	public $maxServers; // Maximum number of servers required in cluster
	public $targetVlanId; // Target VLAN ID (ID in backend, will lookup on name change)
	public $targetVlanName; // Target VLAN Name
	public $targetApplianceId; // Target Virtual Appliance ID, 
	public $targetApplianceName; // Target Virtual Appliance Name
	public $targetVdcName; // Name of the Virtual Data Center'
	public $targetVdcId; // ID of the VDC
	public $dateCreated; // Date the cluster was created 
	public $dateChanged; // Date the cluster was last changed.
	
	public function Cluster($id,$uid=false) {
		// Get Cluster data
		$id = DB::Sanitise($id);
		if(!$uid) $uid = Auth::GetUID();
		$data = DB::GetRecord("SELECT * FROM `clusters` WHERE `customerId`='$uid' AND `clusterId`='$id' LIMIT 1;");
		// Fill fields
		$this->clusterId=$data['clusterId'];
		$this->clusterName=$data['clusterName'];
		$this->customerId=$data['customerId'];
		$this->minServers=$data['minServers'];
		$this->maxServers=$data['maxServers'];
		$this->targetVlanId=$data['targetVlanId'];
		$this->targetVlanName=$data['targetVlanName'];
		$this->targetApplianceId=$data['targetApplianceId'];
		$this->targetVdcName=$data['targetVdcName'];
		$this->targetVdcId=$data['targetVdcId'];
		$this->targetApplianceName=$data['targetApplianceName'];
		$this->dateCreated=$data['dateCreated'];
		$this->dateChanged=$data['dateChanged'];
	}
	
	public function Save() {
		// Save the current field back to the DB.
		$q = "UPDATE `clusters` SET
			clusterName='".DB::Sanitise($this->clusterName)."',
			minServers='".DB::Sanitise($this->minServers)."',
			maxServers='".DB::Sanitise($this->maxServers)."',
			targetVlanId='".DB::Sanitise($this->targetVlanId)."',
			targetVlanName='".DB::Sanitise($this->targetVlanName)."',
			targetApplianceId='".DB::Sanitise($this->targetApplianceId)."',
			targetApplianceName='".DB::Sanitise($this->targetApplianceName)."',
			targetVdcId='".DB::Sanitise($this->targetVdcId)."',
			targetVdcName='".DB::Sanitise($this->targetVdcName)."',
			dateChanged=NOW() WHERE clusterId = $this->clusterId";
		DB::Query($q);
	}
}