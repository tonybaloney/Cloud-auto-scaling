<?php
 /**
  * Include all classes to interact with the system
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
  
 /**
  * Path to the scaling class and poller code
  * @package auto-scaler
  **/
define('SCALE_PATH','/usr/local/src/cloud-scale/src/');

/**
 * Interval between tick cycles
 * @package auto-scaler
 **/
define('TICK_INTERVAL',5);

include ( SCALE_PATH.'php-classes/DB.class.php');
include ( SCALE_PATH.'php-classes/Auth.class.php');
include ( SCALE_PATH.'php-classes/Connector.interface.php');
include ( SCALE_PATH.'php-classes/ConnectorException.class.php');
include ( SCALE_PATH.'php-classes/connectors/Abiquo.class.php');
include ( SCALE_PATH.'php-classes/Cluster.class.php');
include ( SCALE_PATH.'php-classes/Trigger.class.php');
include ( SCALE_PATH.'php-classes/Log.class.php');
include ( SCALE_PATH.'php-classes/ErrorLogger.php');
include ( SCALE_PATH.'php-classes/Alerts.class.php');
include ( SCALE_PATH.'php-classes/Charts.class.php');
?>