-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2013 at 10:42 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `practicum`
--
CREATE DATABASE `practicum` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `practicum`;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
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

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `companyname`, `businessline`, `floor_unit`, `street`, `building`, `city`) VALUES
('1b6453892473a467d07372d45eb05abc2031647a', 'Holla Designs', 'Video Production', 'N/A', 'Taft Ave.', 'Aloha Bldg.', 'Manila'),
('356a192b7913b04c54574d18c28d46e6395428ab', 'Hewlett Packard', 'Computer Hardware', '3rd Floor', 'Ayala Ave.', 'Some Building', 'Makati City'),
('77de68daecd823babbb58edb1c8e14d7106e83bb', 'Hansel and Gretel Inc.', 'Graphic Design', '30th Floor', 'Taft Ave.', 'H&G Bldg.', 'Manila'),
('ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'History Channel Philippines', 'TV Broadcasting', 'N/A', 'Ayala Ave.', 'HC Building', 'Makati City'),
('c1dfd96eea8cc2b62785275bca38ac261256e278', 'Hello World!', 'Educational Institution', 'N/A', 'Taft Ave.', 'Huge Building', 'Manila'),
('da4b9237bacccdf19c0760cab7aec4a8359010b0', 'Hewlett Packard', 'Computer Hardware', 'Tower 2 Unit 3111', 'Aurora Blvd. cor. Araneta Ave.', 'Mezza Residences', 'Quezon City');

-- --------------------------------------------------------

--
-- Table structure for table `contactpersons`
--

CREATE TABLE IF NOT EXISTS `contactpersons` (
  `name` varchar(150) NOT NULL,
  `position` varchar(75) NOT NULL,
  `department` varchar(75) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telnum` varchar(50) NOT NULL,
  `faxnum` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contactpersons`
--

INSERT INTO `contactpersons` (`name`, `position`, `department`, `email`, `telnum`, `faxnum`) VALUES
('Julian Asoy', 'Core Developer', 'Web Development Team', 'julianasoy@shimshinatti.com', '(053) 323-6689', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_member`
--

CREATE TABLE IF NOT EXISTS `group_member` (
  `group_id` int(10) unsigned NOT NULL,
  `username` varchar(40) NOT NULL,
  PRIMARY KEY (`username`),
  KEY `fk_student_idx` (`username`),
  KEY `fk_group_idx` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_member`
--

INSERT INTO `group_member` (`group_id`, `username`) VALUES
(3, 'hollychua'),
(3, 'julianshimay'),
(3, 'paulo'),
(3, 'shimay'),
(4, 'julianasoy');

-- --------------------------------------------------------

--
-- Table structure for table `linkageofficer_company`
--

CREATE TABLE IF NOT EXISTS `linkageofficer_company` (
  `username` varchar(40) NOT NULL,
  `company_id` char(40) NOT NULL,
  PRIMARY KEY (`username`,`company_id`),
  KEY `fk_linkage_officer_idx` (`username`),
  KEY `fk_company_assignment_idx` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `practicum_application`
--

CREATE TABLE IF NOT EXISTS `practicum_application` (
  `application_id` char(40) NOT NULL,
  `student` varchar(40) NOT NULL,
  `application_date` datetime NOT NULL,
  `status` enum('confirmed','denied','pending') NOT NULL,
  `company_id` char(40) NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_student2_idx` (`student`),
  KEY `fk_company_idx` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `practicum_application_contacts`
--

CREATE TABLE IF NOT EXISTS `practicum_application_contacts` (
  `application_id` char(40) NOT NULL,
  `hr_name` varchar(150) NOT NULL,
  `ts_name` varchar(150) NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_hr_contact_idx` (`hr_name`),
  KEY `fk_ts_contact_idx` (`ts_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `practicum_application_project`
--

CREATE TABLE IF NOT EXISTS `practicum_application_project` (
  `application_id` char(40) NOT NULL,
  `project_title` char(40) NOT NULL,
  `project_description` text NOT NULL,
  `project_output` text NOT NULL,
  `project_num_students` int(11) NOT NULL,
  `project_duration` decimal(3,2) NOT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `practicum_application_project_types`
--

CREATE TABLE IF NOT EXISTS `practicum_application_project_types` (
  `application_id` char(40) NOT NULL,
  `project_type` varchar(75) NOT NULL,
  PRIMARY KEY (`application_id`,`project_type`),
  KEY `fk_application_id_idx` (`application_id`),
  KEY `fk_project_type_idx` (`project_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `practicum_group`
--

CREATE TABLE IF NOT EXISTS `practicum_group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(75) NOT NULL,
  `group_admin` varchar(40) NOT NULL,
  `datecreated` datetime NOT NULL,
  `status` enum('open','closed') NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `practicum_group`
--

INSERT INTO `practicum_group` (`group_id`, `group_name`, `group_admin`, `datecreated`, `status`) VALUES
(3, 'Tyrone''s Group', 'bossing', '2013-03-10 00:00:00', 'open'),
(4, 'I''m Gonna Wreck It', 'wreckitralph', '2013-03-10 00:00:00', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `projecttype`
--

CREATE TABLE IF NOT EXISTS `projecttype` (
  `projecttype` varchar(75) NOT NULL,
  `htmlvalue` varchar(75) NOT NULL,
  PRIMARY KEY (`projecttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projecttype`
--

INSERT INTO `projecttype` (`projecttype`, `htmlvalue`) VALUES
('Information Systems and Software Development ', 'softwaredev'),
('Internet-based Applications Development', 'webappdev'),
('Programming or Implementation', 'programming'),
('Support Service', 'supportservice'),
('Systems Analysis', 'systemsanalysis'),
('Systems and Software Customization Systems ', 'customization'),
('Systems Design', 'systemsdesign'),
('Systems Migration and Conversion', 'conversion'),
('Technical Research', 'technicalresearch');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
  KEY `fk_type_idx` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE IF NOT EXISTS `usertype` (
  `type` varchar(25) NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`type`) VALUES
('linkage officer'),
('practicum coordinator'),
('student');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_member`
--
ALTER TABLE `group_member`
  ADD CONSTRAINT `fk_group` FOREIGN KEY (`group_id`) REFERENCES `practicum_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `linkageofficer_company`
--
ALTER TABLE `linkageofficer_company`
  ADD CONSTRAINT `fk_linkage_officer` FOREIGN KEY (`username`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_company_assignment` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `practicum_application`
--
ALTER TABLE `practicum_application`
  ADD CONSTRAINT `fk_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student2` FOREIGN KEY (`student`) REFERENCES `group_member` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `practicum_application_contacts`
--
ALTER TABLE `practicum_application_contacts`
  ADD CONSTRAINT `fk_application_id2` FOREIGN KEY (`application_id`) REFERENCES `practicum_application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_hr_contact` FOREIGN KEY (`hr_name`) REFERENCES `contactpersons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ts_contact` FOREIGN KEY (`ts_name`) REFERENCES `contactpersons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `practicum_application_project`
--
ALTER TABLE `practicum_application_project`
  ADD CONSTRAINT `fk_application_id3` FOREIGN KEY (`application_id`) REFERENCES `practicum_application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `practicum_application_project_types`
--
ALTER TABLE `practicum_application_project_types`
  ADD CONSTRAINT `fk_application_id4` FOREIGN KEY (`application_id`) REFERENCES `practicum_application_project` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_project_type` FOREIGN KEY (`project_type`) REFERENCES `projecttype` (`projecttype`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_type` FOREIGN KEY (`type`) REFERENCES `usertype` (`type`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
