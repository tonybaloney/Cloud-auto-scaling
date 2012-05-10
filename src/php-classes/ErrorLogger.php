<?php

/**
 * Custom error logger for PHP that tracks the errors in the database against the user that caused them
 **/
function cloudErrorHandler ($errno, $errstr, $errfile, $errline){
	$message= "<b>PHP ERROR</b> [$errno] $errstr<br />";
    $message.= "Error on line $errline in file $errfile";
	Log::LogCustomerError(Auth::GetUID(), $message);
}
set_error_handler ('cloudErrorHandler');
?>