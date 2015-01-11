-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2015 at 04:45 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dragonsse`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `FN_ANSWER_ID` int(200) NOT NULL AUTO_INCREMENT,
  `FN_USER_ID` int(200) NOT NULL,
  `FN_QUESTION_ID` int(200) NOT NULL,
  `FC_ANSWER` longtext NOT NULL,
  `FN_VOTES_UP` int(200) NOT NULL DEFAULT '0',
  `FN_VOTES_DOWN` int(200) NOT NULL DEFAULT '0',
  PRIMARY KEY (`FN_ANSWER_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`FN_ANSWER_ID`, `FN_USER_ID`, `FN_QUESTION_ID`, `FC_ANSWER`, `FN_VOTES_UP`, `FN_VOTES_DOWN`) VALUES
(2, 1, 1, 'ateneo', 1, 0),
(3, 1, 10, 'sample', 1, 0),
(4, 2, 10, 'I am eldarel solon', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `FN_GROUP_ID` int(200) NOT NULL AUTO_INCREMENT,
  `FN_USER_ID` int(200) NOT NULL,
  `FC_GROUP_PASSCODE` varchar(200) NOT NULL,
  `FC_GROUP_NAME` varchar(200) NOT NULL,
  `FC_SUBJECT_CATEGORY` int(200) NOT NULL,
  PRIMARY KEY (`FN_GROUP_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`FN_GROUP_ID`, `FN_USER_ID`, `FC_GROUP_PASSCODE`, `FC_GROUP_NAME`, `FC_SUBJECT_CATEGORY`) VALUES
(12, 1, '1234', 'Gen-GG', 1),
(2, 2, '1234', 'Gen-MHA1', 1),
(3, 1, '1234', 'Gen-TFC4', 1),
(4, 1, '1234', 'Gen-AMIE', 1),
(5, 1, '1234', 'Gen-IIST', 2),
(6, 1, '1234', 'Gen-EM1', 3),
(7, 1, '1234', 'SB-X01', 4),
(8, 1, '1234', 'SB-X45', 6),
(9, 1, '1234', 'SB-X32', 5),
(10, 1, '1234', 'SB-X29', 6),
(11, 1, '1234', 'SB-X65', 7),
(13, 1, '1234', 'Gen-GG-2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE IF NOT EXISTS `group_members` (
  `FN_GROUP_MEMBER_ID` int(200) NOT NULL AUTO_INCREMENT,
  `FN_GROUP_ID` int(200) NOT NULL,
  `FN_USER_ID` int(200) NOT NULL,
  PRIMARY KEY (`FN_GROUP_MEMBER_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`FN_GROUP_MEMBER_ID`, `FN_GROUP_ID`, `FN_USER_ID`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `FN_QUESTION_ID` int(200) NOT NULL AUTO_INCREMENT,
  `FN_USER_ID` int(200) NOT NULL,
  `FN_ANSWER_ID` int(200) DEFAULT NULL,
  `FC_QUESTION` longtext NOT NULL,
  `FC_QUESTION_TYPE` varchar(200) NOT NULL,
  `FD_QUESTION_DATE_POSTED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`FN_QUESTION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`FN_QUESTION_ID`, `FN_USER_ID`, `FN_ANSWER_ID`, `FC_QUESTION`, `FC_QUESTION_TYPE`, `FD_QUESTION_DATE_POSTED`) VALUES
(1, 1, 0, 'What university hosted the 1st Hackathon?', 'Multiple Choice', '2015-01-10 18:09:58'),
(10, 1, NULL, 'Who are you?', 'MC', '2015-01-11 02:35:18');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `FN_SUBJECT_ID` int(200) NOT NULL AUTO_INCREMENT,
  `FC_SUBJECT_NAME` varchar(200) NOT NULL,
  `FC_SUBJECT_PIC` varchar(200) NOT NULL,
  PRIMARY KEY (`FN_SUBJECT_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`FN_SUBJECT_ID`, `FC_SUBJECT_NAME`, `FC_SUBJECT_PIC`) VALUES
(1, 'Arts', 'arts.png'),
(2, 'English', 'english.png'),
(3, 'Geology', 'geo.png'),
(4, 'Math', 'math.png'),
(5, 'Music', 'music.png'),
(6, 'PE', 'pe.png'),
(7, 'Physics', 'physics.png'),
(8, 'Science', 'science.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `FN_USER_ID` int(200) NOT NULL AUTO_INCREMENT,
  `FC_USER_FIRSTNAME` varchar(200) NOT NULL,
  `FC_USER_LASTNAME` varchar(200) NOT NULL,
  `FC_USER_EMAIL` varchar(200) NOT NULL,
  `FC_USER_PASSWORD` varchar(200) NOT NULL,
  `FC_USER_SCHOOL` varchar(200) NOT NULL,
  `FC_USER_CONTACT_NUMBER` varchar(200) NOT NULL,
  `FC_USER_STATUS` tinyint(1) NOT NULL,
  PRIMARY KEY (`FN_USER_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`FN_USER_ID`, `FC_USER_FIRSTNAME`, `FC_USER_LASTNAME`, `FC_USER_EMAIL`, `FC_USER_PASSWORD`, `FC_USER_SCHOOL`, `FC_USER_CONTACT_NUMBER`, `FC_USER_STATUS`) VALUES
(1, 'TEST', 'TEST', 'TEST', 'TEST', 'TEST', '', 0),
(2, 'Lance', 'Sta. Ana', 'lance.sta.ana@uap.asia', '', 'UA&amp;P', '9175700817', 0),
(7, 'Lance', 'Cruz', 'virgil.cruz@uap.asia', 'Starkiller', 'University of asia and the pacific', '9175800819', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
