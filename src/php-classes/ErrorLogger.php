<?php

/**
 * Custom error logger for PHP that tracks the errors in the database against the user that caused them
 * @package auto-scaler
 **/
 /**
  * Catch PHP errors
  * @param int $errno The PHP error Number
  * @param string $errstr The PHP error string
  * @param string $errfile The PHP file that caused the error
  * @param int $errline The line in the PHP file that caused the error
  **/
function cloudErrorHandler ($errno, $errstr, $errfile, $errline){
	$message= "<b>PHP ERROR</b> [$errno] $errstr<br />";
    $message.= "Error on line $errline in file $errfile";
	Log::LogCustomerError(Auth::GetUID(), $message);
}
set_error_handler ('cloudErrorHandler');
?>