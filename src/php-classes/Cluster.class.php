<?php
 /**
  * Cluster.class.php
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
 
/** 
 * Cluster class, represents a Virtual Appliance on which you add/remove Virtual Machines according to the metrics
 * @package auto-scaler
 */
class Cluster {
	/** 
	 * Create a new cluster
	 * @access public
	 * @static
	 * @param string $name Name of the cluster
	 * @return Object|bool Cluster object on success, false on failure
	 */
	public static function CreateCluster ( $name ) {
		$name = DB::Sanitise($name);
		$uid = Auth::GetUID();
		$res = DB::Query ( "INSERT INTO `clusters` (`clusterName`,`customerId`,`dateCreated`) VALUES ('$name',$uid,NOW())" );
		if ($res)
			return new Cluster (mysql_insert_id());
		else 
			return false;
	}
	
	/**
	 * Get a list of clusters on the system for the specified user
	 * @access public
	 * @static
	 * @param int $uid User ID (assumes current user if not specified)
	 * @return array List of cluster records
	 */
	public static function GetClusters($uid=false){
		if (!$uid) $uid = Auth::GetUID();
		return DB::GetData("SELECT * FROM `clusters` WHERE `customerId`=$uid;");
	}
	
	/**
	 * ID of the Cluster
	 * @var int
	 * @access private
	 */
	private $clusterId;
	
	/**
	 * Friendly name of the cluster
	 * @var string
	 * @access public
	 */
	public $clusterName;
	
	/**
	 * ID of the cluster location on the cloud
	 * @var int
	 * @access public
	 */
	public $clusterLocation;
	
	/**
	 * UID of the user/customer
	 * @var int
	 * @access public
	 */
    public $customerId;

	/**
	 * Minimum number of servers required in cluster
	 * @var int
	 * @access public
	 */
	public $minServers; 
	
	/**
	 * Maximum number of servers required in cluster
	 * @var int
	 * @access public
	 */
	public $maxServers; 
	
	/**
	 * Target VLAN ID (ID in backend, will lookup on name change)
	 * @var int
	 * @access public
	 */
	public $targetVlanId;

	/**
	 * Target VLAN ID (ID in backend, will lookup on name change)
	 * @var int
	 * @access public
	 */
	public $targetSecondaryVlanId;
	
	/**
	 * Target VLAN Name
	 * @var string
	 * @access public
	 */
	public $targetVlanName; 
	
	/**
	 * Target Virtual Appliance ID
	 * @var int
	 * @access public
	 */	
	public $targetApplianceId; 
	
	/**
	 * Target Virtual Appliance Name
	 * @var string
	 * @access public
	 */	
	public $targetApplianceName;
	
	/**
	 * Name of the Virtual Data Center
	 * @var string
	 * @access public
	 */	
	public $targetVdcName; 
	
	/**
	 * ID of the VDC
	 * @var int
	 * @access public
	 */	
	public $targetVdcId; 
	
	/**
	 * Date/Time the cluster was created 
	 * @var string
	 * @access public
	 */	
	public $dateCreated; 
	
	/**
	 * Date the cluster was last changed
	 * @var string
	 * @access public
	 */	
	public $dateChanged; 
	
	/** 
	 * E-mail address(es) to send alerts to, seperated by a semicolon
	 * @var string
	 * @access public
	 **/
	public $clusterEmailAlerts; 
	 
	/**
	 * Number of VMs in cluster
	 * @var int
	 * @access public
	 **/
	public $clusterVmCount;
	
	/**
	 * Create a cluster object from the DB
	 * @param int $id The ID of the cluster
	 * @param int $uid limit to a specific user ID
	 * @access public
	 * @return object the cluster object
	 **/
	public function Cluster($id,$uid=false) {
		// Get Cluster data
		$id = DB::Sanitise($id);
		if(!$uid) $uid = Auth::GetUID();
		$data = DB::GetRecord("SELECT * FROM `clusters` WHERE `customerId`='$uid' AND `clusterId`='$id' LIMIT 1;");
		// Fill fields
		$this->clusterId=$data['clusterId'];
		$this->clusterName=$data['clusterName'];
		$this->clusterLocation=$data['clusterLocation'];
		$this->customerId=$data['customerId'];
		$this->minServers=$data['minServers'];
		$this->maxServers=$data['maxServers'];
		$this->targetVlanId=$data['targetVlanId'];
		$this->targetSecondaryVlanId=$data['targetSecondaryVlanId'];
		$this->targetVlanName=$data['targetVlanName'];
		$this->targetApplianceId=$data['targetApplianceId'];
		$this->targetVdcName=$data['targetVdcName'];
		$this->targetVdcId=$data['targetVdcId'];
		$this->targetApplianceName=$data['targetApplianceName'];
		$this->dateCreated=$data['dateCreated'];
		$this->dateChanged=$data['dateChanged'];
		$this->clusterEmailAlerts=$data['clusterEmailAlerts'];
		$this->clusterVmCount=$data['clusterVmCount'];
	}
	
	/**
	 * Save this object back to the database
	 * @access public
	 **/
	public function Save() {
		// Save the current field back to the DB.
		$q = "UPDATE `clusters` SET
			clusterName='".DB::Sanitise($this->clusterName)."',
			clusterLocation='".DB::Sanitise($this->clusterLocation)."',
			minServers='".DB::Sanitise($this->minServers)."',
			maxServers='".DB::Sanitise($this->maxServers)."',
			targetVlanId='".DB::Sanitise($this->targetVlanId)."',
			targetSecondaryVlanId='".DB::Sanitise($this->targetSecondaryVlanId)."',
			targetVlanName='".DB::Sanitise($this->targetVlanName)."',
			targetApplianceId='".DB::Sanitise($this->targetApplianceId)."',
			targetApplianceName='".DB::Sanitise($this->targetApplianceName)."',
			targetVdcId='".DB::Sanitise($this->targetVdcId)."',
			targetVdcName='".DB::Sanitise($this->targetVdcName)."',
			clusterEmailAlerts='".DB::Sanitise($this->clusterEmailAlerts)."',
			dateChanged=NOW() WHERE clusterId = $this->clusterId";
		DB::Query($q);
	}
}