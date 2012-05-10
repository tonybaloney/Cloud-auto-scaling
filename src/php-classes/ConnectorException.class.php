<?php
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