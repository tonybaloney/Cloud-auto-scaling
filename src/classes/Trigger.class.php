<?php

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
		return DB::GetData("SELECT triggers.*, clusters.clusterName FROM triggers INNER JOIN `clusters` ON triggers.clusterId = clusters.clusterId WHERE clusters.customerId = $uid;");
	}
	
	// Public fields
	private $customerId ;
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
		
	public function Trigger($id,$uid=false) {
		// Get Cluster data
		if(!$uid) $uid = Auth::GetUID();
		$id = DB::Sanitise($id);
		$data = DB::GetData("SELECT triggers.*, clusters.clusterName FROM triggers INNER JOIN clusters ON triggers.clusterId = clusters.clusterId WHERE clusters.customerId = $uid AND triggers.triggerId = $id LIMIT 1;");
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
			`oid`='".DB::Sanitise($this->oid)."'
			WHERE `triggerId`=".DB::Sanitise($this->triggerId).";";
		DB::Query($q);
		
	}
}