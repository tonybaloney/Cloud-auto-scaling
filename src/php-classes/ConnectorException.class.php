<?php
 /**
  * ConnectorException.class.php
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/

/** 
 * Backend failure
 * @package auto-scaler
 **/
define ('CEX_BACKEND_HTTP_FAILURE', 101);
/** 
 * Backend not configured correctly
 * @package auto-scaler
 **/
define ('CEX_NO_BACKEND_CONFIGURED', 102);
/** 
 * API response was unexpected
 * @package auto-scaler
 **/
define ('CEX_INVALID_API_RESPONSE', 103);
/**
 * No target VM
 * @package auto-scaler
 **/
define ('CEX_NO_TARGET_VM',104);
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
	 * @param object $cloud Link to Connector object
	 * @param string $message The text of the message
	 * @param int $type One of the CEX exception types
	 **/
	public function ConnectorException ($cloud, $message, $type) { 
		$this->cloud = $cloud; $this->message = $message; $this->type = $type;
		// Save this error to the log DB
		$this->LogError();
	}
	
	/**
	 * Get the error message
	 * @access public
	 * @return string The text of the message
	 **/
	public function GetConnectorErrorMessage() { 
		return "Error with message :".$this->message." and exception code ".$this->type.".";
	}
	
	/**
	 * Log this error 
	 * @access public
	 * @return null
	 */
	public function LogError() {
		Log::LogCustomerError( Auth::GetUID(), $this->GetConnectorErrorMessage() ) ;
	}
}
?>