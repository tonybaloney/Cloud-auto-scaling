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
}

 define ('CEX_BACKEND_HTTP_FAILURE', 101);
 define ('CEX_NO_BACKEND_CONFIGURED', 102);
 define ('CEX_INVALID_API_RESPONSE', 103);
 /** 
 * Holding exception class for errors from Cloud providers..
 * @package auto-scaler
 **/
class ConnectorException extends Exception { 
	/** 
	 * Error message
	 * @var string
	 * @access protected
	 **/
	protected $message ;
	
	/** 
	 * Type of failure
	 * @var int
	 * @access protected
	 **/
	protected $type ; 
	
	/** 
	 * Cloud that failed.
	 * @var Connector
	 * @access protected
	 **/
	protected $cloud ; 
	
	/**
	 * Create a ConnectorException
	 * @access public
	 * @param string $message The text of the message
	 * @param int $type One of the CEX exception types
	 **/
	public function ConnectorException ($cloud, $message, $type) { 
		$this->cloud = $cloud; $this->message = $message; $this->type = $type;
	}
	
	/**
	 * Get the error message
	 * @access public
	 * @return string The text of the message
	 **/
	public function GetConnectorErrorMessage() { 
		return "Error with message :".$this->message." and exception code ".$this->type.".";
	}
}
?>
