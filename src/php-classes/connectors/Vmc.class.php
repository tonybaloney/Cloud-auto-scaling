<?php
/** 
  * Vmc Class
  * PHP Requirements 
  * - PHP-CURL (for requesting API HTTP)
  * - PHP-PCRE (for preg_match)
  * - PHP-SIMPLEXML (for decoding XML responses)
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/

/**
 * Class for talking to the Cloud-Foundry through the VMC CLI
 * Usage :
 * $a= new Vmc('api.cloudfoundry.com','user','password');
 * $a->GetVirtualDatacenters();
 * @package auto-scaler
 */
class Vmc implements Connector{ 
	/**
	 * hostname of the API to CloudFoundry server
	 * @var string
	 * @access private
	 */
	private $host; 
	
	/**
	 * username (normally in email format)
	 * @var string
	 * @access private
	 */
	private $username;
	
	/**
	 * password
	 * @var string
	 * @access private
	 */
	private $password;
	
	/** 
	 * Constructor for the Vmc Class
	 * @param string $host the hostname of the cloudfoundry server (cloudfoundry.org if hosted)
	 * @param string $username your username (normally your email)
	 * @param string $password your password
	 **/
	public function Vmc($host,$username,$password){
		$this->username = $username;
		$this->password = $password;
		$this->host = $host;
		$this->vmcPath = '/usr/sbin/vmc';
	}

	/**
	 * Execute a command on the VMC CLI
	 * @param string $command the command
	 * @return array the response lines
	 **/
	private function VmcExec ($command){
		$command = escapeshellarg($command);
		$response = array();
		exec($this->vmcPath.' target '.$this->host);
		// TODO: Login by sending $password to stdin somehow (popen maybe)
		exec($this->vmcPath.' '.$command,$response);
		return $response;
	}

	/** 
	 * Test connection to the cloud provider
	 * @return bool Connection successful
	 * @access public
	 **/
	public function TestConnection() {
		return true;
	}
	
	/**
	 * Get a list of locations, for multi-regional cloud platforms.
	 * @return array List of locations (Key-Value pair array)
	 * @access public
	 **/
	public function GetLocations () { 
		return array ( );
	}
	
	/**
	 * Get a list of private networks
	 * @param int $location Location ID
	 * @return array List of private networks 
	 * @access public
	 **/
	public function GetPrivateNetworks ($location) {
		
	}
	
	/**
	 * Get a list of private networks
	 * @param int $location Location ID
	 * @param int $networkId Private Network ID
	 * @return array List of private networks 
	 * @access public
	 **/
	public function GetPrivateNetwork ($location, $networkId) {
		
	}
	
	/**
	 * Get a list of VM Groups/Appliances
	 * @param int $location Location ID
	 * @return array List of appliances 
	 * @access public
	 **/
	public function GetAppliances ($location) {
		$results = $this->VmcExec("apps");
		// TODO: Process results and get the names and Id's of the apps.
		return array();
	}
	
	/**
	 * Get a list of VM s
	 * @param int $location Location ID
	 * @param int $appliance Appliance ID
	 * @return array List of virtual machines.
	 * @access public
	 **/
	public function GetVirtualMachines ($location, $appliance) {
		$results = $this->VmcExec("stats $appliance");
		// TODO: Return list of running instances in an app
	 return array();
	}
	
	/**
	 * Get a list of VM s
	 * @param int $location Location ID
	 * @param int $appliance Appliance ID
	 * @param int $virtualMachine VM ID
	 * @return array List of NICS.
	 * @access public
	 **/
	public function GetVirtualMachineNetworks ($location, $appliance, $virtualMachine) { 
		// TODO: not needed replace with something useful
		return array();
	}
	
	/**
	 * Create a VM
	 * @access public
	 * @param int $clusterLocation The ID of the cluster location
	 * @param int $targetApplianceId The ID of the target virtual appliance
	 * @param int $targetVlanId The ID of the target VLAN
	 * @param int $templateId The ID to create the VM from
	 * @param string $vmname The name of the new VM.
	 **/
	public function CreateVM ( $clusterLocation, $targetApplianceId, $targetVlanId, $templateUrl, $vmname ) {
		// TODO: increment the application
		// $cluster = new Cluster($clusterId);
		// $newCnt = $cluster->vmCount + 1;
		// $this->VmcExec("instances $targetApplianceId $newCnt");
	}
	
	/**
	 * Destroy the next VM in a cluster
	 * @access public
	 * @param int $clusterLocation The ID of the cluster location
	 * @param int $targetApplianceId The ID of the target virtual appliance
	 * @param string $vmPrefix The prefix for Virtual Machines.
	 **/
	public function DestroyNextVM ( $clusterLocation, $targetApplianceId, $vmPrefix ) {
		// TODO: increment the application
		// $cluster = new Cluster($clusterId);
		// $newCnt = $cluster->vmCount + 1;
		// $this->VmcExec("instances $targetApplianceId $newCnt");
	}
}