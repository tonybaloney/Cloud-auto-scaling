<?php
/**
 * Include all of the classes needed to interact with the system
 * @package auto-scaler
 */
include ( 'php-classes/DB.class.php');
include ( 'php-classes/Auth.class.php');
include ( 'php-classes/Connector.interface.php');
include ( 'php-classes/ConnectorException.class.php');
include ( 'php-classes/connectors/Abiquo.class.php');
include ( 'php-classes/Cluster.class.php');
include ( 'php-classes/Trigger.class.php');
include ( 'php-classes/Log.class.php');
include ( 'php-classes/ErrorLogger.php');
?>