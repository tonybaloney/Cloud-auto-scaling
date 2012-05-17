<?php
/**
  * Test the API
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
 ini_set('display_errors','On'); 
require('../src/all.inc.php'); 
$cloud = new Abiquo( "http://localhost:8080/api/","test","test",true ) ;
$cloud->CreateVM(1,1,1,1);

?>