<?php

/** 
 * Test the API.
 **/
 ini_set('display_errors','On'); 
require('../src/all.inc.php'); 
$cloud = new Abiquo( "http://localhost:8080/api/","test","test",true ) ;
$cloud->CreateVM(1,1,1,1);

?>