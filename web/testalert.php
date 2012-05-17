<?php
/**
  * Test an alert to a user
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
 
 ini_set('display_errors','On'); 
include('../src/all.inc.php');

Alerts::TriggerScalingAlert(1,1,3,'SCALE_UP','PENDING');

?>