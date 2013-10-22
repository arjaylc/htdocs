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
-- Table structure for table `appraisal_professional_skills`
--

DROP TABLE IF EXISTS `appraisal_professional_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appraisal_professional_skills` (
  `supervisor` varchar(150) NOT NULL,
  `student` varchar(40) NOT NULL,
  `productivity` int(1) NOT NULL,
  `quality` int(1) NOT NULL,
  `planning` int(1) NOT NULL,
  `timeliness` int(1) NOT NULL,
  `knowledge` int(1) NOT NULL,
  `adaptability` int(1) NOT NULL,
  `creativity` int(1) NOT NULL,
  `initiative` int(1) NOT NULL,
  `adherence` int(1) NOT NULL,
  `communication_skills` int(1) NOT NULL,
  `cooperation` int(1) NOT NULL,
  `interpersonal_skills` int(1) NOT NULL,
  `decision_making` int(1) NOT NULL,
  `problem_solving` int(1) NOT NULL,
  `personal_development` int(1) NOT NULL,
  `interaction` int(1) NOT NULL,
  `attendance` int(1) NOT NULL,
  `remarks` varchar(400) NOT NULL,
  PRIMARY KEY (`student`),
  KEY `fk_professional_supervisor_idx` (`supervisor`),
  KEY `fk_professional_student_idx` (`student`),
  CONSTRAINT `fk_professional_student` FOREIGN KEY (`student`) REFERENCES `evaluator_information` (`student`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_professional_supervisor` FOREIGN KEY (`supervisor`) REFERENCES `evaluator_information` (`supervisor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appraisal_programming_skills`
--

DROP TABLE IF EXISTS `appraisal_programming_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appraisal_programming_skills` (
  `supervisor` varchar(150) NOT NULL,
  `student` varchar(40) NOT NULL,
  `knowledge_of_language` int(1) NOT NULL,
  `knowledge_of_operating` int(1) NOT NULL,
  `program_design` int(1) NOT NULL,
  `testing_debugging` int(1) NOT NULL,
  `awareness` int(1) NOT NULL,
  `remarks` varchar(400) NOT NULL,
  PRIMARY KEY (`student`),
  KEY `fk_programming_supervisor_idx` (`supervisor`),
  KEY `fk_programming_student_idx` (`student`),
  CONSTRAINT `fk_programming_student` FOREIGN KEY (`student`) REFERENCES `evaluator_information` (`student`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_programming_supervisor` FOREIGN KEY (`supervisor`) REFERENCES `evaluator_information` (`supervisor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appraisal_rating_summary`
--

DROP TABLE IF EXISTS `appraisal_rating_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appraisal_rating_summary` (
  `supervisor` varchar(150) NOT NULL,
  `student` varchar(40) NOT NULL,
  `general_professional_skills` int(1) NOT NULL,
  `technical_skills` int(1) NOT NULL,
  `systems_analysis_skills` int(1) NOT NULL,
  `overall_performance` int(1) NOT NULL,
  `summary` varchar(400) NOT NULL,
  PRIMARY KEY (`student`),
  KEY `fk_summary_supervisor_idx` (`supervisor`),
  KEY `fk_summary_student_idx` (`student`),
  CONSTRAINT `fk_summary_student` FOREIGN KEY (`student`) REFERENCES `evaluator_information` (`student`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_summary_supervisor` FOREIGN KEY (`supervisor`) REFERENCES `evaluator_information` (`supervisor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appraisal_systems_analysis_skills`
--

DROP TABLE IF EXISTS `appraisal_systems_analysis_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appraisal_systems_analysis_skills` (
  `supervisor` varchar(150) NOT NULL,
  `student` varchar(40) NOT NULL,
  `business_requirements` int(1) NOT NULL,
  `technical_requirements` int(1) NOT NULL,
  `estimating` int(1) NOT NULL,
  `systems_design` int(1) NOT NULL,
  `quality_usability_of_docu` int(1) NOT NULL,
  `project_planning` int(1) NOT NULL,
  `user_satisfaction` int(1) NOT NULL,
  `remarks` varchar(400) NOT NULL,
  PRIMARY KEY (`student`),
  KEY `fk_analysis_supervisor_idx` (`supervisor`),
  KEY `fk_analysis_student_idx` (`student`),
  CONSTRAINT `fk_analysis_student` FOREIGN KEY (`student`) REFERENCES `evaluator_information` (`student`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_analysis_supervisor` FOREIGN KEY (`supervisor`) REFERENCES `evaluator_information` (`supervisor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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

INSERT INTO `company` (`company_id`, `companyname`, `businessline`, `floor_unit`, `street`, `building`, `city`) VALUES
('1b6453892473a467d07372d45eb05abc2031647a', 'Holla Designs', 'Video Production', 'N/A', 'Taft Ave.', 'Aloha Bldg.', 'Manila'),
('356a192b7913b04c54574d18c28d46e6395428ab', 'Hewlett Packard', 'Computer Hardware', '3rd Floor', 'Ayala Ave.', 'Some Building', 'Makati City'),
('77de68daecd823babbb58edb1c8e14d7106e83bb', 'Hansel and Gretel Inc.', 'Graphic Design', '30th Floor', 'Taft Ave.', 'H&G Bldg.', 'Manila'),
('ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'History Channel Philippines', 'TV Broadcasting', 'N/A', 'Ayala Ave.', 'HC Building', 'Makati City'),
('c1dfd96eea8cc2b62785275bca38ac261256e278', 'Hello World!', 'Educational Institution', 'N/A', 'Taft Ave.', 'Huge Building', 'Manila'),
('da4b9237bacccdf19c0760cab7aec4a8359010b0', 'Hewlett Packard', 'Computer Hardware', 'Tower 2 Unit 3111', 'Aurora Blvd. cor. Araneta Ave.', 'Mezza Residences', 'Quezon City');

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
  `telnum` varchar(50) NOT NULL,
  `faxnum` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `contactpersons` (`name`, `position`, `department`, `email`, `telnum`, `faxnum`) VALUES
('Julian Asoy', 'Core Developer', 'Web Development Team', 'julianasoy@shimshinatti.com', '(053) 323-6689', NULL);

--
-- Table structure for table `eval_course_content`
--

DROP TABLE IF EXISTS `eval_course_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eval_course_content` (
  `submitter` varchar(40) NOT NULL,
  `relevance` int(1) NOT NULL,
  `importance` int(1) NOT NULL,
  `informed_guidelines` int(1) NOT NULL,
  `duration` int(1) NOT NULL,
  `requirement_definition` int(1) NOT NULL,
  `requirement_appropriation` int(1) NOT NULL,
  `deliverable_relevance` int(1) NOT NULL,
  `requirement_heaviness` int(1) NOT NULL,
  PRIMARY KEY (`submitter`),
  KEY `fk_content_submitter_idx` (`submitter`),
  CONSTRAINT `fk_content_submitter` FOREIGN KEY (`submitter`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eval_essay`
--

DROP TABLE IF EXISTS `eval_essay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eval_essay` (
  `submitter` varchar(40) NOT NULL,
  `learnings` varchar(200) NOT NULL,
  `preparations` varchar(200) NOT NULL,
  `policy_modifications` varchar(200) NOT NULL,
  `corrdinator_evaluation` varchar(200) NOT NULL,
  `comments` varchar(200) NOT NULL,
  PRIMARY KEY (`submitter`),
  KEY `fk_essay_submitter_idx` (`submitter`),
  CONSTRAINT `fk_essay_submitter` FOREIGN KEY (`submitter`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eval_impact`
--

DROP TABLE IF EXISTS `eval_impact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eval_impact` (
  `submitter` varchar(40) NOT NULL,
  `objectives_clarity` int(1) NOT NULL,
  `objectives_met` int(1) NOT NULL,
  `organized` int(1) NOT NULL,
  `seminars_sufficient` int(1) NOT NULL,
  `stcurriculum_preparatory` int(1) NOT NULL,
  `adjustability` int(1) NOT NULL,
  `motivation` int(1) NOT NULL,
  `challenging` int(1) NOT NULL,
  `work_satisfaction` int(1) NOT NULL,
  `company_likeness` int(1) NOT NULL,
  `companyenvironment_exp` int(1) NOT NULL,
  `importance` int(1) NOT NULL,
  `career_clarification` int(1) NOT NULL,
  `work_preparedness` int(1) NOT NULL,
  `bestcouse` int(1) NOT NULL,
  PRIMARY KEY (`submitter`),
  KEY `fk_impact_submitter_idx` (`submitter`),
  CONSTRAINT `fk_impact_submitter` FOREIGN KEY (`submitter`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eval_skill`
--

DROP TABLE IF EXISTS `eval_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eval_skill` (
  `submitter` varchar(40) NOT NULL,
  `punctuality` int(1) NOT NULL,
  `adaptability` int(1) NOT NULL,
  `creativity` int(1) NOT NULL,
  `initiative` int(1) NOT NULL,
  `decision_making` int(1) NOT NULL,
  `planning` int(1) NOT NULL,
  `time_management` int(1) NOT NULL,
  `verbal_communication` int(1) NOT NULL,
  `written_communication` int(1) NOT NULL,
  `courteousness` int(1) NOT NULL,
  `interpersonal` int(1) NOT NULL,
  `cooperation` int(1) NOT NULL,
  PRIMARY KEY (`submitter`),
  KEY `fk_skill_submitter_idx` (`submitter`),
  CONSTRAINT `fk_skill_submitter` FOREIGN KEY (`submitter`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eval_subject_application`
--

DROP TABLE IF EXISTS `eval_subject_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eval_subject_application` (
  `submitter` varchar(40) NOT NULL,
  `ALGOCOM` int(1) NOT NULL,
  `COMPILE` int(1) NOT NULL,
  `WEBDEVE` int(1) NOT NULL,
  `INTROAI` int(1) NOT NULL,
  `INTRODB` int(1) NOT NULL,
  `INTROOS` int(1) NOT NULL,
  `INTROSE` int(1) NOT NULL,
  `STELEC1` int(1) NOT NULL,
  `STRESME` int(1) NOT NULL,
  `THEOPRO` int(1) NOT NULL,
  PRIMARY KEY (`submitter`),
  KEY `fk_subject_submitter_idx` (`submitter`),
  CONSTRAINT `fk_subject_submitter` FOREIGN KEY (`submitter`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `evaluator_information`
--

DROP TABLE IF EXISTS `evaluator_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evaluator_information` (
  `supervisor` varchar(150) NOT NULL,
  `position` varchar(20) NOT NULL,
  `student` varchar(40) NOT NULL,
  `date_of_start` date NOT NULL,
  `date_of_end` date NOT NULL,
  `jobdescription` varchar(40) NOT NULL,
  PRIMARY KEY (`student`),
  KEY `fk_information_supervisor_idx` (`supervisor`),
  KEY `fk_information_student_idx` (`student`),
  CONSTRAINT `fk_information_student` FOREIGN KEY (`student`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_information_supervisor` FOREIGN KEY (`supervisor`) REFERENCES `practicum_application_contacts` (`ts_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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

INSERT INTO `group_member` (`group_id`, `username`) VALUES
(3, 'hollychua'),
(3, 'julianshimay'),
(3, 'paulo'),
(3, 'shimay'),
(4, 'julianasoy');

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
  CONSTRAINT `fk_company_assignment` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_linkage_officer` FOREIGN KEY (`username`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `company_id` char(40) NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_student2_idx` (`student`),
  KEY `fk_company_idx` (`company_id`),
  CONSTRAINT `fk_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_student2` FOREIGN KEY (`student`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `practicum_application_contacts`
--

DROP TABLE IF EXISTS `practicum_application_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practicum_application_contacts` (
  `application_id` char(40) NOT NULL,
  `hr_name` varchar(150) NOT NULL,
  `ts_name` varchar(150) NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_hr_contact_idx` (`hr_name`),
  KEY `fk_ts_contact_idx` (`ts_name`),
  CONSTRAINT `fk_application_id2` FOREIGN KEY (`application_id`) REFERENCES `practicum_application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_hr_contact` FOREIGN KEY (`hr_name`) REFERENCES `contactpersons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ts_contact` FOREIGN KEY (`ts_name`) REFERENCES `contactpersons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `project_duration` int(11) NOT NULL,
  PRIMARY KEY (`application_id`),
  CONSTRAINT `fk_application_id3` FOREIGN KEY (`application_id`) REFERENCES `practicum_application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  KEY `fk_projecttype_idx` (`project_type`),
  CONSTRAINT `fk_application_id4` FOREIGN KEY (`application_id`) REFERENCES `practicum_application_project` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_projecttype` FOREIGN KEY (`project_type`) REFERENCES `projecttype` (`projecttype`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `practicum_group` (`group_id`, `group_name`, `group_admin`, `datecreated`, `status`) VALUES
(3, 'Tyrone''s Group', 'bossing', '2013-03-10 00:00:00', 'open'),
(4, 'I''m Gonna Wreck It', 'wreckitralph', '2013-03-10 00:00:00', 'open');

--
-- Table structure for table `projecttype`
--

DROP TABLE IF EXISTS `projecttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projecttype` (
  `projecttype_text` varchar(75) NOT NULL,
  `projecttype` varchar(75) NOT NULL,
  PRIMARY KEY (`projecttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `projecttype` (`projecttype_text`, `projecttype`) VALUES
('Information Systems and Software Development ', 'softwaredev'),
('Internet-based Applications Development', 'webappdev'),
('Programming or Implementation', 'programming'),
('Support Service', 'supportservice'),
('Systems Analysis', 'systemsanalysis'),
('Systems and Software Customization Systems ', 'customization'),
('Systems Design', 'systemsdesign'),
('Systems Migration and Conversion', 'conversion'),
('Technical Research', 'technicalresearch');

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

INSERT INTO `user` (`username`, `password`, `firstname`, `lastname`, `email`, `contactnum`, `address`, `type`) VALUES
('boom', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Boom', 'Shakalaka', 'boom@gmail.com', '09063462691', '123', 'practicum coordinator'),
('bossing', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Tyrone', 'Batingal', 'bossing@gmail.com', '987', 'MNL', 'practicum coordinator'),
('hollychua', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Holly', 'Chua', 'hollychua@gmail.com', '9128', 'Manila', 'student'),
('julianasoy', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Shimay', 'Asoy', 'julianshimay@yahoo.com', '09063462692', '123', 'student'),
('julianshimay', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Julian', 'Asoy', 'julianshimay@gmail.com', '123456', 'QC', 'student'),
('paulo', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Paulo', 'del Rosario', 'paulo@yahoo.com', '12376', 'QC', 'student'),
('sgtan', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Sharmaine', 'Tan', 'sgtan@gmail.com', '6527', '123456', 'practicum coordinator'),
('shimay', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Julian', 'Shims', 'gmail@gmail.com', '123', 'a', 'student'),
('wreckitralph', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Wreck-It', 'Ralph', 'ralph@wreckitralph.com', '5678', '123', 'practicum coordinator');

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

INSERT INTO `usertype` (`type`) VALUES
('linkage officer'),
('practicum coordinator'),
('student');

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

-- Dump completed on 2013-04-16  2:44:35
