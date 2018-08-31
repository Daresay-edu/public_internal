-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2018 at 06:29 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xingpai`
--
CREATE DATABASE IF NOT EXISTS `xingpai` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `xingpai`;

-- --------------------------------------------------------

--
-- Table structure for table `absent`
--

CREATE TABLE IF NOT EXISTS `absent` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `classid` varchar(32) DEFAULT NULL,
  `engname` varchar(32) DEFAULT NULL,
  `ab_hour` varchar(32) DEFAULT NULL,
  `ab_date` varchar(32) DEFAULT NULL,
  `in_classid` varchar(32) DEFAULT NULL,
  `finish` varchar(10) DEFAULT NULL,
  `note` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `absent`
--

INSERT INTO `absent` (`id`, `classid`, `engname`, `ab_hour`, `ab_date`, `in_classid`, `finish`, `note`) VALUES
(1, 'K1001', 'test', '1-2', '2018-6-16', 'K1002', 'no', '');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `classid` varchar(32) DEFAULT NULL,
  `open_time` varchar(32) DEFAULT NULL,
  `class_time` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `teachers` varchar(32) DEFAULT NULL,
  `mail_address` varchar(32) DEFAULT NULL,
  `source1` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `source2` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `note` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `classid`, `open_time`, `class_time`, `teachers`, `mail_address`, `source1`, `source2`, `note`) VALUES
(1, 'K1001', '2018-6-16', 'å‘¨ä¸€01:00,å‘¨ä¸€01:00', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `class_info_record`
--

CREATE TABLE IF NOT EXISTS `class_info_record` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `classid` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `week` varchar(100) CHARACTER SET utf8 NOT NULL,
  `hour` varchar(100) DEFAULT NULL,
  `class_info` varchar(1000) DEFAULT NULL,
  `absent` varchar(64) DEFAULT NULL,
  `note` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `class_info_record`
--

INSERT INTO `class_info_record` (`id`, `classid`, `date`, `week`, `hour`, `class_info`, `absent`, `note`) VALUES
(1, 'x', '2018-06-16', 'wen', '1-2', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dollar`
--

CREATE TABLE IF NOT EXISTS `dollar` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `classid` varchar(100) NOT NULL,
  `engname` varchar(100) NOT NULL,
  `hour` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `dollar_num` int(10) NOT NULL,
  `note` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `online_user`
--

CREATE TABLE IF NOT EXISTS `online_user` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `classid` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `engname` varchar(100) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `hour_begin` int(100) NOT NULL,
  `hour_end` int(100) NOT NULL,
  `lastday` varchar(100) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `access_times` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `schoolid` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `open_time` varchar(32) DEFAULT NULL,
  `addr` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `note` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `schoolid`, `open_time`, `addr`, `note`) VALUES
(1, 'NO1(花溪苑)', '2014-5-6', '中北镇花溪苑20号楼', '');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `engname` varchar(100) NOT NULL,
  `classid` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `school` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `pay_time` varchar(100) NOT NULL,
  `charge` varchar(100) NOT NULL,
  `hour_end` varchar(30) DEFAULT NULL,
  `note` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `sex` varchar(100) CHARACTER SET utf8 NOT NULL,
  `hour_begin` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`engname`,`classid`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `engname` varchar(32) DEFAULT NULL,
  `age` varchar(32) DEFAULT NULL,
  `sex` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `join_date` varchar(32) DEFAULT NULL,
  `chief_salary` varchar(32) DEFAULT NULL,
  `assist_salary` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `note` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `engname`, `age`, `sex`, `phone`, `join_date`, `chief_salary`, `assist_salary`, `password`, `note`) VALUES
(10, 'liyanchun', 'liyanchun', '30', '女', 'null', '2016-8-23', '0', '0', 'xingpai888', 'daresay6968967816967816.php'),
(34, 'ä½ å¥½è€å¸ˆ', 'nihao', '', 'ç”·', '', '2018-6-16', '', '', '111111', '');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_salary`
--

CREATE TABLE IF NOT EXISTS `teacher_salary` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `engname` varchar(32) DEFAULT NULL,
  `classid` varchar(32) DEFAULT NULL,
  `hour` varchar(20) CHARACTER SET utf8 NOT NULL,
  `character1` varchar(32) DEFAULT NULL,
  `date` varchar(32) DEFAULT NULL,
  `week` varchar(32) NOT NULL,
  `salary` varchar(32) DEFAULT NULL,
  `listen` varchar(32) DEFAULT NULL,
  `note` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
