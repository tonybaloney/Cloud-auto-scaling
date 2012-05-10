<?php
/**
 * Connector Interface
 * @package auto-scaler
 */
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
}
?>