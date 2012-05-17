<?php
 /**
  * Custom error logger for PHP that tracks the errors in the database against the user that caused them
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
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
	if($errno==E_STRICT) return;
	$message= "<b>PHP ERROR</b> [$errno] $errstr<br />";
    $message.= "Error on line $errline in file $errfile";
	Log::LogCustomerError(Auth::GetUID(), $message);
}
set_error_handler ('cloudErrorHandler');
?>