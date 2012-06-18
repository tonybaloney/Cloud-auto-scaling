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
  `customerId` int(11) NOT NULL,
  `clusterName` varchar(50) DEFAULT NULL,
  `clusterLocation` varchar(50) DEFAULT NULL,
  `minServers` smallint(5) unsigned DEFAULT NULL,
  `maxServers` smallint(5) unsigned DEFAULT NULL,
  `targetVlanId` varchar(50) DEFAULT NULL,
  `targetApplianceId` varchar(50) DEFAULT NULL,
  `targetApplianceName` varchar(50) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `dateChanged` datetime DEFAULT NULL,
  `clusterVmCount` int(11) DEFAULT NULL,
  `clusterEmailAlerts` varchar(255) DEFAULT NULL,
  `targetSecondaryVlanId` int(11) DEFAULT NULL,
  `holdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `templateUrl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`clusterId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=MyISAM AUTO_INCREMENT=36569 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `result` float unsigned DEFAULT NULL,
  `vmId` varchar(50) DEFAULT NULL,
  `vmName` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`tl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=375921 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `lower` float unsigned DEFAULT NULL,
  `upper` float unsigned DEFAULT NULL,
  `scaleUpTime` int(10) unsigned DEFAULT NULL,
  `scaleDownTime` int(10) unsigned DEFAULT NULL,
  `oid` varchar(100) DEFAULT NULL,
  `communityString` varchar(255) DEFAULT NULL,
  `vmPrefix` varchar(50) DEFAULT NULL,
  `triggerApproval` enum('Manual','Automatic') DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`triggerId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-06-18 22:09:06
