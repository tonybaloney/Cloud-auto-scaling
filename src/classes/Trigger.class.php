<?php

class Trigger {
	public static function CreateTrigger ( $metric ) {
		$name = DB::Sanitise($name);
		DB::Query ( "INSERT INTO `clusters` (`clusterName`) VALUES ('$name')" );
		if( mysql_insert_id() ){
			return new Trigger(mysql_insert_id());
		} else 
			return false;
	}
	public static function GetTriggers(){
		$uid = Auth::GetUID();
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
		
	public function Trigger($id) {
		// Get Cluster data
		$uid = Auth::GetUID();
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
	}
	
	public function Save(){
		$q = "UPDATE `triggers` SET 
			`triggerName`='".DB::Sanitise($this->triggerName)."',
			`upper`='".DB::Sanitise($this->upper)."',
			`clusterId`='".DB::Sanitise($this->clusterId)."',
			`lower`='".DB::Sanitise($this->lower)."',
			`scaleDownTime`='".DB::Sanitise($this->scaleDownTime)."',
			`scaleUpTime`='".DB::Sanitise($this->scaleUpTime)."'
			WHERE `triggerId`=".DB::Sanitise($this->triggerId).";";
		DB::Query($q);
		
	}
}