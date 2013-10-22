CREATE DATABASE  IF NOT EXISTS `practicum` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `practicum`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: practicum
-- ------------------------------------------------------
-- Server version	5.5.27

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
  `company_id` char(40) NOT NULL,
  `companyname` varchar(100) NOT NULL,
  `businessline` varchar(100) NOT NULL,
  `floor_unit` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `building` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `floor_unit` (`floor_unit`,`building`,`street`,`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES ('1','Hewlett Packard','Computer Hardware','3rd Floor','Ayala Ave.','Some Building','Makati City'),('2','Hewlett Packard','Computer Hardware','Tower 2 Unit 3111','Aurora Blvd. cor. Araneta Ave.','Mezza Residences','Quezon City');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
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
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactpersons`
--

LOCK TABLES `contactpersons` WRITE;
/*!40000 ALTER TABLE `contactpersons` DISABLE KEYS */;
INSERT INTO `contactpersons` VALUES ('Julian Asoy','Core Developer','Web Development Team','julianasoy@shimshinatti.com');
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
-- Table structure for table `linkageofficer_company`
--

DROP TABLE IF EXISTS `linkageofficer_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `linkageofficer_company` (
  `username` varchar(40) NOT NULL,
  `company_id` char(40) NOT NULL,
  PRIMARY KEY (`username`,`company_id`),
  KEY `fk_linkage_officer_idx` (`username`),
  KEY `fk_company_assignment_idx` (`company_id`),
  CONSTRAINT `fk_linkage_officer` FOREIGN KEY (`username`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_company_assignment` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linkageofficer_company`
--

LOCK TABLES `linkageofficer_company` WRITE;
/*!40000 ALTER TABLE `linkageofficer_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `linkageofficer_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practicum_application`
--

DROP TABLE IF EXISTS `practicum_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practicum_application` (
  `application_id` char(40) NOT NULL,
  `student` varchar(40) NOT NULL,
  `application_date` datetime NOT NULL,
  `status` enum('confirmed','denied','pending') NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_student2_idx` (`student`),
  CONSTRAINT `fk_student2` FOREIGN KEY (`student`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practicum_application`
--

LOCK TABLES `practicum_application` WRITE;
/*!40000 ALTER TABLE `practicum_application` DISABLE KEYS */;
/*!40000 ALTER TABLE `practicum_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practicum_application_company`
--

DROP TABLE IF EXISTS `practicum_application_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practicum_application_company` (
  `application_id` char(40) NOT NULL,
  `company_id` char(40) NOT NULL,
  `company_phone_num` varchar(50) NOT NULL,
  `company_fax_num` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_company_id_idx` (`company_id`),
  CONSTRAINT `fk_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_application_id` FOREIGN KEY (`application_id`) REFERENCES `practicum_application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practicum_application_company`
--

LOCK TABLES `practicum_application_company` WRITE;
/*!40000 ALTER TABLE `practicum_application_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `practicum_application_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practicum_application_contacts`
--

DROP TABLE IF EXISTS `practicum_application_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practicum_application_contacts` (
  `application_id` char(40) NOT NULL,
  `hr_name` varchar(150) NOT NULL,
  `hr_phone_num` varchar(50) NOT NULL,
  `hr_fax_num` varchar(50) DEFAULT NULL,
  `ts_name` varchar(150) NOT NULL,
  `ts_phone_num` varchar(50) NOT NULL,
  `ts_fax_num` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_hr_contact_idx` (`hr_name`),
  KEY `fk_ts_contact_idx` (`ts_name`),
  CONSTRAINT `fk_application_id2` FOREIGN KEY (`application_id`) REFERENCES `practicum_application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_hr_contact` FOREIGN KEY (`hr_name`) REFERENCES `contactpersons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ts_contact` FOREIGN KEY (`ts_name`) REFERENCES `contactpersons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practicum_application_contacts`
--

LOCK TABLES `practicum_application_contacts` WRITE;
/*!40000 ALTER TABLE `practicum_application_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `practicum_application_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practicum_application_project`
--

DROP TABLE IF EXISTS `practicum_application_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practicum_application_project` (
  `application_id` char(40) NOT NULL,
  `project_title` char(40) NOT NULL,
  `project_description` text NOT NULL,
  `project_output` text NOT NULL,
  `project_num_students` int(11) NOT NULL,
  `project_duration` decimal(3,2) NOT NULL,
  PRIMARY KEY (`application_id`),
  CONSTRAINT `fk_application_id3` FOREIGN KEY (`application_id`) REFERENCES `practicum_application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practicum_application_project`
--

LOCK TABLES `practicum_application_project` WRITE;
/*!40000 ALTER TABLE `practicum_application_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `practicum_application_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practicum_application_project_types`
--

DROP TABLE IF EXISTS `practicum_application_project_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practicum_application_project_types` (
  `application_id` char(40) NOT NULL,
  `project_type` varchar(75) NOT NULL,
  PRIMARY KEY (`application_id`,`project_type`),
  KEY `fk_application_id_idx` (`application_id`),
  KEY `fk_project_type_idx` (`project_type`),
  CONSTRAINT `fk_application_id4` FOREIGN KEY (`application_id`) REFERENCES `practicum_application_project` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_project_type` FOREIGN KEY (`project_type`) REFERENCES `projecttype` (`projecttype`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practicum_application_project_types`
--

LOCK TABLES `practicum_application_project_types` WRITE;
/*!40000 ALTER TABLE `practicum_application_project_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `practicum_application_project_types` ENABLE KEYS */;
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
-- Table structure for table `projecttype`
--

DROP TABLE IF EXISTS `projecttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projecttype` (
  `projecttype` varchar(75) NOT NULL,
  `htmlvalue` varchar(75) NOT NULL,
  PRIMARY KEY (`projecttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projecttype`
--

LOCK TABLES `projecttype` WRITE;
/*!40000 ALTER TABLE `projecttype` DISABLE KEYS */;
INSERT INTO `projecttype` VALUES ('Information Systems and Software Development ','softwaredev'),('Internet-based Applications Development','webappdev'),('Programming or Implementation','programming'),('Support Service','supportservice'),('Systems Analysis','systemsanalysis'),('Systems and Software Customization Systems ','customization'),('Systems Design','systemsdesign'),('Systems Migration and Conversion','conversion'),('Technical Research','technicalresearch');
/*!40000 ALTER TABLE `projecttype` ENABLE KEYS */;
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
INSERT INTO `user` VALUES ('boom','7c4a8d09ca3762af61e59520943dc26494f8941b','Boom','Shakalaka','boom@gmail.com','09063462691','123','practicum coordinator'),('bossing','7c4a8d09ca3762af61e59520943dc26494f8941b','Tyrone','Batingal','bossing@gmail.com','987','MNL','practicum coordinator'),('hollychua','7c4a8d09ca3762af61e59520943dc26494f8941b','Holly','Chua','hollychua@gmail.com','9128','Manila','student'),('julianasoy','7c4a8d09ca3762af61e59520943dc26494f8941b','Shimay','Asoy','julianshimay@yahoo.com','09063462692','123','student'),('julianshimay','7c4a8d09ca3762af61e59520943dc26494f8941b','Julian','Asoy','julianshimay@gmail.com','123456','QC','student'),('paulo','7c4a8d09ca3762af61e59520943dc26494f8941b','Paulo','del Rosario','paulo@yahoo.com','12376','QC','student'),('sgtan','7c4a8d09ca3762af61e59520943dc26494f8941b','Sharmaine','Tan','sgtan@gmail.com','6527','123456','practicum coordinator'),('shimay','7c4a8d09ca3762af61e59520943dc26494f8941b','Julian','Shims','gmail@gmail.com','123','a','student'),('wreckitralph','7c4a8d09ca3762af61e59520943dc26494f8941b','Wreck-It','Ralph','ralph@wreckitralph.com','5678','123','practicum coordinator');
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-31  9:27:24
