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
}
?>
