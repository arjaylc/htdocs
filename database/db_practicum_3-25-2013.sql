CREATE DATABASE  IF NOT EXISTS `practicum` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `practicum`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: practicum
-- ------------------------------------------------------
-- Server version	5.5.25a

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
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `companyname` varchar(100) NOT NULL,
  `telephonenum` varchar(40) NOT NULL,
  `faxnum` varchar(40) NOT NULL,
  `businessline` varchar(100) NOT NULL,
  `floor-dept-unit` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `area-subd-district` varchar(100) NOT NULL,
  `building` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  PRIMARY KEY (`companyname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES ('Hewlett Packard','(053) 323-6689','(053) 323-7789','Computer Hardware','Tower 2 Unit 3111','Aurora Blvd. cor. Araneta Ave.','Brgy. Dona Imelda, Sta. Mesa','Mezza Residences','Quezon City');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_submission`
--

DROP TABLE IF EXISTS `company_submission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_submission` (
  `company_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `emailsupervisor` varchar(75) NOT NULL,
  `companycity` varchar(75) NOT NULL,
  `companypn` varchar(75) NOT NULL,
  `submitter` varchar(75) NOT NULL,
  `datesubmitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','confirmed','denied') NOT NULL,
  PRIMARY KEY (`company_id`),
  KEY `fk_submitter3_idx` (`group_id`,`submitter`),
  CONSTRAINT `fk_submitterinfo` FOREIGN KEY (`group_id`, `submitter`) REFERENCES `group_member` (`group_id`, `username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_submission`
--

LOCK TABLES `company_submission` WRITE;
/*!40000 ALTER TABLE `company_submission` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_submission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactpersons`
--

DROP TABLE IF EXISTS `contactpersons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactpersons` (
  `name` varchar(150) NOT NULL,
  `position` varchar(75) NOT NULL,
  `department` varchar(75) NOT NULL,
  `telephonenum` varchar(40) NOT NULL,
  `faxnum` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactpersons`
--

LOCK TABLES `contactpersons` WRITE;
/*!40000 ALTER TABLE `contactpersons` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactpersons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_member`
--

DROP TABLE IF EXISTS `group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_member` (
  `group_id` int(10) unsigned NOT NULL,
  `username` varchar(40) NOT NULL,
  PRIMARY KEY (`username`),
  KEY `fk_student_idx` (`username`),
  KEY `fk_group_idx` (`group_id`),
  CONSTRAINT `fk_group` FOREIGN KEY (`group_id`) REFERENCES `practicum_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_student` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_member`
--

LOCK TABLES `group_member` WRITE;
/*!40000 ALTER TABLE `group_member` DISABLE KEYS */;
INSERT INTO `group_member` VALUES (3,'hollychua'),(3,'julianshimay'),(3,'paulo'),(3,'shimay'),(4,'julianasoy');
/*!40000 ALTER TABLE `group_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practicum_group`
--

DROP TABLE IF EXISTS `practicum_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practicum_group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(75) NOT NULL,
  `group_admin` varchar(40) NOT NULL,
  `datecreated` datetime NOT NULL,
  `status` enum('open','closed') NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practicum_group`
--

LOCK TABLES `practicum_group` WRITE;
/*!40000 ALTER TABLE `practicum_group` DISABLE KEYS */;
INSERT INTO `practicum_group` VALUES (3,'Tyrone\'s Group','bossing','2013-03-10 00:00:00','open'),(4,'I\'m Gonna Wreck It','wreckitralph','2013-03-10 00:00:00','open');
/*!40000 ALTER TABLE `practicum_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_submission`
--

DROP TABLE IF EXISTS `project_submission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_submission` (
  `project_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `businessname` varchar(75) NOT NULL,
  `supervisor` varchar(75) NOT NULL,
  `projtitle` varchar(75) NOT NULL,
  `projdesc` text NOT NULL,
  `output` text NOT NULL,
  `projtype` text NOT NULL,
  `numstudents` int(10) unsigned NOT NULL,
  `submitter` varchar(40) NOT NULL,
  `datesubmitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','confirmed','denied') NOT NULL,
  PRIMARY KEY (`project_id`),
  KEY `fk_submittedby_idx` (`submitter`),
  CONSTRAINT `fk_submittedby` FOREIGN KEY (`submitter`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_submission`
--

LOCK TABLES `project_submission` WRITE;
/*!40000 ALTER TABLE `project_submission` DISABLE KEYS */;
INSERT INTO `project_submission` VALUES (15,'Hewlett-Packard','BOM','BOOM','asdasdasd','asasdasd','adasasdasdas',2,'julianshimay','2013-03-24 08:31:30','pending');
/*!40000 ALTER TABLE `project_submission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `username` varchar(40) NOT NULL,
  `password` char(40) NOT NULL,
  `firstname` varchar(75) NOT NULL,
  `lastname` varchar(75) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactnum` varchar(40) NOT NULL,
  `address` text NOT NULL,
  `type` varchar(25) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`,`contactnum`),
  KEY `fk_type_idx` (`type`),
  CONSTRAINT `fk_type` FOREIGN KEY (`type`) REFERENCES `usertype` (`type`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('bossing','7c4a8d09ca3762af61e59520943dc26494f8941b','Tyrone','Batingal','bossing@gmail.com','987','MNL','practicum coordinator'),('hollychua','7c4a8d09ca3762af61e59520943dc26494f8941b','Holly','Chua','hollychua@gmail.com','9128','Manila','student'),('julianasoy','7c4a8d09ca3762af61e59520943dc26494f8941b','Shimay','Asoy','julianshimay@yahoo.com','09063462692','123','student'),('julianshimay','7c4a8d09ca3762af61e59520943dc26494f8941b','Julian','Asoy','julianshimay@gmail.com','123456','QC','student'),('paulo','7c4a8d09ca3762af61e59520943dc26494f8941b','Paulo','del Rosario','paulo@yahoo.com','12376','QC','student'),('sgtan','7c4a8d09ca3762af61e59520943dc26494f8941b','Sharmaine','Tan','sgtan@gmail.com','6527','123456','practicum coordinator'),('shimay','7c4a8d09ca3762af61e59520943dc26494f8941b','Julian','Shims','gmail@gmail.com','123','a','student'),('wreckitralph','7c4a8d09ca3762af61e59520943dc26494f8941b','Wreck-It','Ralph','ralph@wreckitralph.com','5678','123','practicum coordinator');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertype` (
  `type` varchar(25) NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES ('linkage officer'),('practicum coordinator'),('student');
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'practicum'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-25  9:38:10
