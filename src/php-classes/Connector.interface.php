<?php
 /**
  * Connector.interface.php
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
  
/**
 * Interface providing a consistent connection between types of cloud interface
 * @package auto-scaler
 */
interface Connector {
	/** 
	 * Test connection to the cloud provider
	 * @return bool Connection successful
	 * @access public
	 **/
	public function TestConnection();
	
	/**
	 * Get a list of locations, for multi-regional cloud platforms.
	 * @return array List of locations (Key-Value pair array)
	 * @access public
	 **/
	public function GetLocations ();
	
	/**
	 * Get a list of private networks
	 * @param int $location Location ID
	 * @return array List of private networks 
	 * @access public
	 **/
	public function GetPrivateNetworks ($location);
	
	/**
	 * Get a list of private networks
	 * @param int $location Location ID
	 * @param int $networkId Private Network ID
	 * @return array List of private networks 
	 * @access public
	 **/
	public function GetPrivateNetwork ($location, $networkId);
	
	/**
	 * Get a list of VM Groups/Appliances
	 * @param int $location Location ID
	 * @return array List of appliances 
	 * @access public
	 **/
	public function GetAppliances ($location);
	
	/**
	 * Get a list of VM s
	 * @param int $location Location ID
	 * @param int $appliance Appliance ID
	 * @return array List of virtual machines.
	 * @access public
	 **/
	public function GetVirtualMachines ($location, $appliance) ;
	
	/**
	 * Get a list of VM s
	 * @param int $location Location ID
	 * @param int $appliance Appliance ID
	 * @param int $virtualMachine VM ID
	 * @return array List of NICS.
	 * @access public
	 **/
	public function GetVirtualMachineNetworks ($location, $appliance, $virtualMachine);
	
	/**
	 * Create a VM
	 * @access public
	 * @param int $clusterLocation The ID of the cluster location
	 * @param int $targetApplianceId The ID of the target virtual appliance
	 * @param int $targetVlanId The ID of the target VLAN
	 * @param int $targetSecondaryVlanId the ID of the secondary VLAN
	 * @param int $templateUrl the path of the image
	 * @param string $vmname The name of the new VM.
	 **/
	public function CreateVM ( $clusterLocation, $targetApplianceId, $targetVlanId, $targetSecondaryVlanId, $templateUrl, $vmname ) ;
	
	/**
	 * Destroy the next VM in a cluster
	 * @access public
	 * @param int $clusterLocation The ID of the cluster location
	 * @param int $targetApplianceId The ID of the target virtual appliance
	 * @param string $vmPrefix The prefix for Virtual Machines.
	 **/
	public function DestroyNextVM ( $clusterLocation, $targetApplianceId, $vmPrefix ) ;
	
	/**
	 * Get the templates for this enterprise
	 * @param int $location_id The template library location 
	 * @access public 
	 **/
	public function GetTemplates ( $location_id	) ;
}
?>