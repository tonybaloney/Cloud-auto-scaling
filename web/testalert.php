<?php
 ini_set('display_errors','On'); 
include('../src/all.inc.php');

Alerts::TriggerScalingAlert(1,1,3,'SCALE_UP','PENDING');

?>