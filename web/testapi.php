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
$cloud = Auth::GetCloudConnection(false,true);
print_r($cloud->GetAbiquoPrivateNetworkIps(4,1,true));
?>