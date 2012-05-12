-- MySQL dump 10.13  Distrib 5.1.61, for redhat-linux-gnu (i386)
--
-- Host: localhost    Database: scaler
-- ------------------------------------------------------
-- Server version	5.1.61

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clusters`
--

DROP TABLE IF EXISTS `clusters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clusters` (
  `clusterId` int(11) NOT NULL AUTO_INCREMENT,
  `customerId` int(11) DEFAULT NULL,
  `clusterName` varchar(50) DEFAULT NULL,
  `clusterLocation` int(11) DEFAULT NULL,
  `minServers` smallint(5) unsigned DEFAULT NULL,
  `maxServers` smallint(5) unsigned DEFAULT NULL,
  `targetVlanId` int(10) unsigned DEFAULT NULL,
  `targetVlanName` varchar(50) DEFAULT NULL,
  `targetApplianceId` int(10) unsigned DEFAULT NULL,
  `targetApplianceName` varchar(50) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `dateChanged` datetime DEFAULT NULL,
  `targetVdcId` int(11) DEFAULT NULL,
  `targetVdcName` varchar(50) DEFAULT NULL,
  `clusterVmCount` int(11) DEFAULT NULL,
  `clusterEmailAlerts` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`clusterId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clusters`
--

LOCK TABLES `clusters` WRITE;
/*!40000 ALTER TABLE `clusters` DISABLE KEYS */;
INSERT INTO `clusters` VALUES (1,1,'Web Silo 1',9,2,4,8,'',5,'',NULL,'2012-05-11 17:52:43',0,'',1,'anthony.shaw@uk.clara.net'),(6,NULL,'test web app',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `clusters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `customerId` int(11) NOT NULL AUTO_INCREMENT,
  `portalAPIUrl` varchar(250) DEFAULT NULL,
  `portalUsername` varchar(50) DEFAULT NULL,
  `portalPassword` varchar(50) DEFAULT NULL,
  `apiType` enum('abiquo') DEFAULT NULL,
  PRIMARY KEY (`customerId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'http://195.157.13.226:8080/api','anthony2@test.com','pass33','abiquo');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `error_log`
--

DROP TABLE IF EXISTS `error_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error_log` (
  `errorId` int(11) NOT NULL AUTO_INCREMENT,
  `customerId` int(11) DEFAULT NULL,
  `message` blob,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`errorId`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `error_log`
--

LOCK TABLES `error_log` WRITE;
/*!40000 ALTER TABLE `error_log` DISABLE KEYS */;
INSERT INTO `error_log` VALUES (7,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:55:56'),(2,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 53 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:44:53'),(3,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 53 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:44:53'),(4,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 53 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:44:53'),(5,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 53 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:44:53'),(6,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 53 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:44:53'),(8,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:55:56'),(9,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:55:56'),(10,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:55:56'),(11,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:55:56'),(12,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:56:12'),(13,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:56:12'),(14,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:56:12'),(15,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:56:12'),(16,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:56:12'),(17,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:56:12'),(18,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:57:07'),(19,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:57:07'),(20,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:57:07'),(21,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:57:07'),(22,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:57:07'),(23,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:57:07'),(24,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:58:46'),(25,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:58:46'),(26,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:58:46'),(27,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:58:46'),(28,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:58:46'),(29,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:58:46'),(30,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:59:29'),(31,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:59:29'),(32,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:59:29'),(33,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:59:29'),(34,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:59:29'),(35,1,'<b>PHP ERROR</b> [1024] ARRRRGGGHHH<br />Error on line 56 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 15:59:29'),(36,1,'<b>PHP ERROR</b> [8] Undefined index: clusterApplianceId<br />Error on line 26 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 18:22:08'),(37,1,'<b>PHP ERROR</b> [8] Undefined index: clusterVlanId<br />Error on line 27 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 18:22:08'),(38,1,'Error with message :Failure from cURL speaking to backend (The requested URL returned error: 500) on URL \'http://195.157.13.226:8080/api/cloud/virtualdatacenters/9/privatenetworks/\' with options - array (\n  45 => 1,\n  52 => 1,\n  42 => 0,\n  10023 => \n  array (\n    0 => \'Accept:application/vnd.abiquo.vlan+xml\',\n  ),\n  10022 => \'auth=; JSESSIONID=\',\n) and exception code 103.','2012-05-10 18:22:08'),(39,1,'<b>PHP ERROR</b> [8] Undefined index: clusterApplianceId<br />Error on line 26 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 18:25:01'),(40,1,'<b>PHP ERROR</b> [8] Undefined index: clusterVlanId<br />Error on line 27 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 18:25:01'),(41,1,'<b>PHP ERROR</b> [8] Uninitialized string offset: 0<br />Error on line 413 in file /usr/local/src/cloud-scale/src/php-classes/connectors/Abiquo.class.php','2012-05-10 18:25:01'),(42,1,'<b>PHP ERROR</b> [8] Undefined index: clusterApplianceId<br />Error on line 26 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 18:25:51'),(43,1,'<b>PHP ERROR</b> [8] Undefined index: clusterVlanId<br />Error on line 27 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 18:25:51'),(44,1,'<b>PHP ERROR</b> [8] Uninitialized string offset: 0<br />Error on line 414 in file /usr/local/src/cloud-scale/src/php-classes/connectors/Abiquo.class.php','2012-05-10 18:25:51'),(45,1,'<b>PHP ERROR</b> [8] Undefined index: clusterApplianceId<br />Error on line 27 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 18:29:45'),(46,1,'<b>PHP ERROR</b> [8] Undefined index: clusterVlanId<br />Error on line 28 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 18:29:45'),(47,1,'<b>PHP ERROR</b> [8] Uninitialized string offset: 0<br />Error on line 414 in file /usr/local/src/cloud-scale/src/php-classes/connectors/Abiquo.class.php','2012-05-10 18:29:45'),(48,1,'<b>PHP ERROR</b> [8] Uninitialized string offset: 0<br />Error on line 462 in file /usr/local/src/cloud-scale/src/php-classes/connectors/Abiquo.class.php','2012-05-10 18:30:51'),(49,1,'<b>PHP ERROR</b> [8] Uninitialized string offset: 0<br />Error on line 462 in file /usr/local/src/cloud-scale/src/php-classes/connectors/Abiquo.class.php','2012-05-10 20:10:37'),(50,1,'<b>PHP ERROR</b> [8] Undefined index: netIP<br />Error on line 36 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:38:03'),(51,1,'<b>PHP ERROR</b> [8] Undefined index: netIP<br />Error on line 40 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:55:30'),(52,1,'<b>PHP ERROR</b> [2] snmpget(): No response from <br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:55:36'),(53,1,'<b>PHP ERROR</b> [2] snmpget(): No response from <br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:55:42'),(54,1,'<b>PHP ERROR</b> [1024] Did not establish any succesful SNMP results. Check configuration and network connectivity.<br />Error on line 63 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:55:42'),(55,1,'<b>PHP ERROR</b> [2] snmpget(): No response from 127.0.0.1<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:57:11'),(56,1,'<b>PHP ERROR</b> [2] snmpget(): No response from 127.0.0.1<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:57:17'),(57,1,'<b>PHP ERROR</b> [1024] Did not establish any succesful SNMP results. Check configuration and network connectivity.<br />Error on line 63 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:57:17'),(58,1,'<b>PHP ERROR</b> [2] snmpget(): Error in packet: (noSuchName) There is no such variable name in this MIB.<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:58:06'),(59,1,'<b>PHP ERROR</b> [2] snmpget(): This name does not exist: UCD-SNMP-MIB::laLoad.2<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:58:06'),(60,1,'<b>PHP ERROR</b> [2] snmpget(): Error in packet: (noSuchName) There is no such variable name in this MIB.<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:58:06'),(61,1,'<b>PHP ERROR</b> [2] snmpget(): This name does not exist: UCD-SNMP-MIB::ssCpuRawUser.0<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:58:06'),(62,1,'<b>PHP ERROR</b> [1024] Did not establish any succesful SNMP results. Check configuration and network connectivity.<br />Error on line 63 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 20:58:06'),(63,1,'<b>PHP ERROR</b> [8] Undefined index: customerId<br />Error on line 41 in file /usr/local/src/cloud-scale/src/php-classes/Trigger.class.php','2012-05-10 21:00:49'),(64,1,'<b>PHP ERROR</b> [8] Undefined index: customerId<br />Error on line 41 in file /usr/local/src/cloud-scale/src/php-classes/Trigger.class.php','2012-05-10 21:01:02'),(65,1,'<b>PHP ERROR</b> [2] snmpget(): Error in packet: (noSuchName) There is no such variable name in this MIB.<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:01:12'),(66,1,'<b>PHP ERROR</b> [2] snmpget(): This name does not exist: UCD-SNMP-MIB::ssCpuUser.0<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:01:12'),(67,1,'<b>PHP ERROR</b> [2] snmpget(): Error in packet: (noSuchName) There is no such variable name in this MIB.<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:01:12'),(68,1,'<b>PHP ERROR</b> [2] snmpget(): This name does not exist: UCD-SNMP-MIB::memAvailReal.0<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:01:12'),(69,1,'<b>PHP ERROR</b> [1024] Did not establish any succesful SNMP results. Check configuration and network connectivity.<br />Error on line 63 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:01:12'),(70,1,'<b>PHP ERROR</b> [8] Undefined index: customerId<br />Error on line 41 in file /usr/local/src/cloud-scale/src/php-classes/Trigger.class.php','2012-05-10 21:16:29'),(71,1,'<b>PHP ERROR</b> [8] Undefined index: customerId<br />Error on line 41 in file /usr/local/src/cloud-scale/src/php-classes/Trigger.class.php','2012-05-10 21:16:39'),(72,1,'<b>PHP ERROR</b> [2] snmpget(): No response from 127.0.0.1<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:16:57'),(73,1,'<b>PHP ERROR</b> [2] snmpget(): No response from 127.0.0.1<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:17:03'),(74,1,'<b>PHP ERROR</b> [1024] Did not establish any succesful SNMP results. Check configuration and network connectivity.<br />Error on line 63 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:17:03'),(75,1,'<b>PHP ERROR</b> [2] snmpget(): Error in packet: (noSuchName) There is no such variable name in this MIB.<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:17:16'),(76,1,'<b>PHP ERROR</b> [2] snmpget(): This name does not exist: UCD-SNMP-MIB::ssCpuUser.0<br />Error on line 42 in file /usr/local/src/cloud-scale/src/poller/tick.php','2012-05-10 21:17:16'),(77,1,'<b>PHP ERROR</b> [8] Undefined index: customerId<br />Error on line 41 in file /usr/local/src/cloud-scale/src/php-classes/Trigger.class.php','2012-05-10 21:43:56'),(78,1,'<b>PHP ERROR</b> [8] Undefined index: customerId<br />Error on line 41 in file /usr/local/src/cloud-scale/src/php-classes/Trigger.class.php','2012-05-10 21:45:48'),(79,1,'<b>PHP ERROR</b> [8] Undefined variable: data<br />Error on line 60 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 21:53:00'),(80,1,'<b>PHP ERROR</b> [8] Undefined variable: data<br />Error on line 60 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 23:13:17'),(81,1,'<b>PHP ERROR</b> [8] Undefined variable: data<br />Error on line 60 in file /usr/local/src/cloud-scale/web/data.php','2012-05-10 23:13:19'),(82,1,'<b>PHP ERROR</b> [8] Undefined variable: data<br />Error on line 64 in file /usr/local/src/cloud-scale/web/data.php','2012-05-11 08:32:17'),(83,1,'<b>PHP ERROR</b> [8] Undefined variable: data<br />Error on line 64 in file /usr/local/src/cloud-scale/web/data.php','2012-05-11 11:57:45'),(84,1,'<b>PHP ERROR</b> [8] Undefined variable: tock_ready<br />Error on line 7 in file /usr/local/src/cloud-scale/src/poller/clockd.php','2012-05-11 15:39:20'),(85,1,'<b>PHP ERROR</b> [8] Undefined variable: tock_ready<br />Error on line 7 in file /usr/local/src/cloud-scale/src/poller/clockd.php','2012-05-11 15:39:50'),(86,1,'<b>PHP ERROR</b> [8] Undefined variable: tock_ready<br />Error on line 7 in file /usr/local/src/cloud-scale/src/poller/clockd.php','2012-05-11 15:40:20'),(87,1,'<b>PHP ERROR</b> [8] Undefined variable: tock_ready<br />Error on line 7 in file /usr/local/src/cloud-scale/src/poller/clockd.php','2012-05-11 15:40:50'),(88,1,'<b>PHP ERROR</b> [8] Undefined variable: tock_ready<br />Error on line 7 in file /usr/local/src/cloud-scale/src/poller/clockd.php','2012-05-11 15:41:20'),(89,1,'<b>PHP ERROR</b> [8] Undefined index: clusterAlertEmail<br />Error on line 172 in file /usr/local/src/cloud-scale/src/php-classes/Cluster.class.php','2012-05-11 17:47:28'),(90,1,'<b>PHP ERROR</b> [8] Undefined index: targetVlanName<br />Error on line 29 in file /usr/local/src/cloud-scale/web/form.php','2012-05-11 17:47:28'),(91,1,'<b>PHP ERROR</b> [8] Undefined index: targetApplianceName<br />Error on line 31 in file /usr/local/src/cloud-scale/web/form.php','2012-05-11 17:47:28'),(92,1,'<b>PHP ERROR</b> [8] Undefined index: targetVlanName<br />Error on line 29 in file /usr/local/src/cloud-scale/web/form.php','2012-05-11 17:49:10'),(93,1,'<b>PHP ERROR</b> [8] Undefined index: targetApplianceName<br />Error on line 31 in file /usr/local/src/cloud-scale/web/form.php','2012-05-11 17:49:10'),(94,1,'<b>PHP ERROR</b> [2048] Non-static method Alerts::TriggerScalingAlert() should not be called statically<br />Error on line 4 in file /usr/local/src/cloud-scale/web/testalert.php','2012-05-11 18:11:01'),(95,1,'<b>PHP ERROR</b> [2048] Non-static method Alerts::GetEmails() should not be called statically<br />Error on line 16 in file /usr/local/src/cloud-scale/src/php-classes/Alerts.class.php','2012-05-11 18:11:01'),(96,1,'<b>PHP ERROR</b> [8] Undefined index: customerId<br />Error on line 47 in file /usr/local/src/cloud-scale/src/php-classes/Trigger.class.php','2012-05-11 18:11:01'),(97,1,'<b>PHP ERROR</b> [2048] Non-static method Alerts::TriggerScalingAlert() should not be called statically<br />Error on line 4 in file /usr/local/src/cloud-scale/web/testalert.php','2012-05-12 20:30:53'),(98,1,'<b>PHP ERROR</b> [2048] Non-static method Alerts::GetEmails() should not be called statically<br />Error on line 16 in file /usr/local/src/cloud-scale/src/php-classes/Alerts.class.php','2012-05-12 20:30:53'),(99,1,'<b>PHP ERROR</b> [8] Undefined index: customerId<br />Error on line 47 in file /usr/local/src/cloud-scale/src/php-classes/Trigger.class.php','2012-05-12 20:30:53'),(100,1,'<b>PHP ERROR</b> [8] Undefined index: customerId<br />Error on line 47 in file /usr/local/src/cloud-scale/src/php-classes/Trigger.class.php','2012-05-12 20:34:23');
/*!40000 ALTER TABLE `error_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `customerId` int(11) DEFAULT NULL,
  `clusterId` int(11) DEFAULT NULL,
  `triggerId` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`logId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1,1,1,1,'Example log message');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tick_log`
--

DROP TABLE IF EXISTS `tick_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tick_log` (
  `tl_id` int(11) NOT NULL AUTO_INCREMENT,
  `customerId` int(11) DEFAULT NULL,
  `clusterId` int(11) DEFAULT NULL,
  `triggerId` int(11) DEFAULT NULL,
  `result` int(11) DEFAULT NULL,
  `vmId` int(11) DEFAULT NULL,
  `vmName` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`tl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=187 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tick_log`
--

LOCK TABLES `tick_log` WRITE;
/*!40000 ALTER TABLE `tick_log` DISABLE KEYS */;
INSERT INTO `tick_log` VALUES (7,1,1,1,0,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:42:59'),(8,1,1,3,353092,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:42:59'),(9,1,1,1,0,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:43:28'),(10,1,1,3,352968,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:43:28'),(11,1,1,1,0,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:43:29'),(12,1,1,3,352968,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:43:29'),(13,1,1,1,0,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:43:30'),(14,1,1,3,352968,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:43:30'),(15,1,1,1,0,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:44:02'),(16,1,1,3,352712,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-10 21:44:02'),(17,1,1,3,368692,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:39:20'),(18,1,1,3,368568,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:39:50'),(19,1,1,3,368072,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:40:20'),(20,1,1,3,368072,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:40:50'),(21,1,1,3,368072,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:41:20'),(22,1,1,3,368320,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:41:49'),(23,1,1,3,368312,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:41:54'),(24,1,1,3,368312,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:41:58'),(25,1,1,3,368312,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:03'),(26,1,1,3,368320,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:08'),(27,1,1,3,368320,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:13'),(28,1,1,3,368196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:18'),(29,1,1,3,368196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:18'),(30,1,1,3,368196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:23'),(31,1,1,3,368188,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:28'),(32,1,1,3,368196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:33'),(33,1,1,3,368180,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:38'),(34,1,1,3,368180,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:38'),(35,1,1,3,368196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:43'),(36,1,1,3,368196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:48'),(37,1,1,3,368196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 15:42:53'),(38,1,1,3,368320,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:20:43'),(39,1,1,3,368312,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:20:48'),(40,1,1,3,368196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:20:53'),(41,1,1,3,368188,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:20:58'),(42,1,1,3,368188,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:21:03'),(43,1,1,3,369196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:31:07'),(44,1,1,3,369196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:31:12'),(45,1,1,3,369204,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:31:17'),(46,1,1,3,369204,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:31:22'),(47,1,1,3,369204,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:31:27'),(48,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:32:13'),(49,1,1,3,369320,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:32:18'),(50,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:32:23'),(51,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:32:28'),(52,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:32:33'),(53,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:32:58'),(54,1,1,3,369312,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:33:03'),(55,1,1,3,369320,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:33:08'),(56,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:33:13'),(57,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:33:18'),(58,1,1,3,369336,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:35:37'),(59,1,1,3,369320,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:35:42'),(60,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:35:47'),(61,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:35:52'),(62,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:35:57'),(63,1,1,3,369336,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:13'),(64,1,1,3,369196,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:18'),(65,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:23'),(66,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:28'),(67,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:33'),(68,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:33'),(69,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:38'),(70,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:43'),(71,1,1,3,369064,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:48'),(72,1,1,3,369072,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:53'),(73,1,1,3,369072,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:37:53'),(74,1,1,3,369328,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:38:43'),(75,1,1,3,369072,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:38:48'),(76,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:38:53'),(77,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:38:58'),(78,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:39:03'),(79,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:39:03'),(80,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:39:08'),(81,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:39:13'),(82,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:39:19'),(83,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:39:24'),(84,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:39:24'),(85,1,1,3,369080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:39:29'),(86,1,1,3,368080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:40:41'),(87,1,1,3,368072,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:40:46'),(88,1,1,3,368080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:40:51'),(89,1,1,3,368080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:40:56'),(90,1,1,3,368080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:01'),(91,1,1,3,368080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:02'),(92,1,1,3,368080,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:07'),(93,1,1,3,367940,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:12'),(94,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:17'),(95,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:22'),(96,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:22'),(97,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:27'),(98,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:32'),(99,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:37'),(100,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:42'),(101,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:42'),(102,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:47'),(103,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:52'),(104,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:41:57'),(105,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:02'),(106,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:02'),(107,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:07'),(108,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:12'),(109,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:17'),(110,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:22'),(111,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:22'),(112,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:27'),(113,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:32'),(114,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:37'),(115,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:42'),(116,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:42'),(117,1,1,3,367948,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:47'),(118,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:52'),(119,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:42:57'),(120,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:43:02'),(121,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:43:02'),(122,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:43:07'),(123,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:43:12'),(124,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:43:17'),(125,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:43:22'),(126,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:43:22'),(127,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:43:27'),(128,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:43:58'),(129,1,1,3,367948,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:03'),(130,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:08'),(131,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:13'),(132,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:18'),(133,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:18'),(134,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:23'),(135,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:28'),(136,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:33'),(137,1,1,3,367964,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:38'),(138,1,1,3,367964,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:38'),(139,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:43'),(140,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:48'),(141,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:53'),(142,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:58'),(143,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:44:59'),(144,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:04'),(145,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:09'),(146,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:14'),(147,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:19'),(148,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:19'),(149,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:24'),(150,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:29'),(151,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:34'),(152,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:39'),(153,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:39'),(154,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:44'),(155,1,1,3,367956,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:49'),(156,1,1,3,367832,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:54'),(157,1,1,3,367832,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:59'),(158,1,1,3,367832,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:45:59'),(159,1,1,3,367824,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:04'),(160,1,1,3,367832,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:09'),(161,1,1,3,367832,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:14'),(162,1,1,3,367692,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:19'),(163,1,1,3,367692,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:19'),(164,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:24'),(165,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:29'),(166,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:34'),(167,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:39'),(168,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:39'),(169,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:44'),(170,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:49'),(171,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:54'),(172,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:59'),(173,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:46:59'),(174,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:47:04'),(175,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:47:09'),(176,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:47:14'),(177,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:47:19'),(178,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:47:19'),(179,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:47:24'),(180,1,1,3,367708,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:47:29'),(181,1,1,3,368840,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:53:55'),(182,1,1,3,368700,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:54:00'),(183,1,1,3,368576,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:54:05'),(184,1,1,3,368584,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:54:10'),(185,1,1,3,368584,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:54:15'),(186,1,1,3,368584,2,'ABQ_104b3eb7-7d0e-4117-9429-59f6d03be235','2012-05-11 16:54:15');
/*!40000 ALTER TABLE `tick_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tock_actions`
--

DROP TABLE IF EXISTS `tock_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tock_actions` (
  `ta_id` int(11) NOT NULL AUTO_INCREMENT,
  `clusterId` int(11) DEFAULT NULL,
  `triggerId` int(11) DEFAULT NULL,
  `action` enum('SCALE_UP','SCALE_DOWN') DEFAULT NULL,
  `approval` enum('PENDING','APPROVED','AUTO_APPROVED','DECLINED') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`ta_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tock_actions`
--

LOCK TABLES `tock_actions` WRITE;
/*!40000 ALTER TABLE `tock_actions` DISABLE KEYS */;
INSERT INTO `tock_actions` VALUES (1,1,3,'SCALE_UP','PENDING','2012-05-10 22:05:54'),(9,1,1,'SCALE_UP','PENDING','2012-05-11 16:41:01');
/*!40000 ALTER TABLE `tock_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `triggers`
--

DROP TABLE IF EXISTS `triggers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `triggers` (
  `triggerId` int(11) NOT NULL AUTO_INCREMENT,
  `triggerName` varchar(255) DEFAULT NULL,
  `clusterId` int(11) DEFAULT NULL,
  `lower` int(11) DEFAULT NULL,
  `upper` int(11) DEFAULT NULL,
  `scaleUpTime` int(11) DEFAULT NULL,
  `scaleDownTime` int(11) DEFAULT NULL,
  `oid` varchar(100) DEFAULT NULL,
  `communityString` varchar(255) DEFAULT NULL,
  `vmPrefix` varchar(50) DEFAULT NULL,
  `triggerApproval` enum('Manual','Automatic') DEFAULT NULL,
  PRIMARY KEY (`triggerId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `triggers`
--

LOCK TABLES `triggers` WRITE;
/*!40000 ALTER TABLE `triggers` DISABLE KEYS */;
INSERT INTO `triggers` VALUES (1,'Check load',1,0,3,60,120,'.1.3.6.1.4.1.2021.10.1.3.2','scaler','web_','Manual'),(3,'Check swap',1,1,2,120,120,'.1.3.6.1.4.1.2021.4.6.0','scaler','ABQ_','Manual');
/*!40000 ALTER TABLE `triggers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-05-12 21:54:08
