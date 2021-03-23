-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 22, 2021 at 08:15 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpezdrivedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `dropbox_credentials`
--

DROP TABLE IF EXISTS `dropbox_credentials`;
CREATE TABLE IF NOT EXISTS `dropbox_credentials` (
  `tokenId` int(11) NOT NULL AUTO_INCREMENT,
  `usersId` int(11) NOT NULL,
  `accessToken` varchar(256) NOT NULL,
  `expires` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `serviceType` varchar(256) NOT NULL,
  PRIMARY KEY (`tokenId`),
  KEY `usersId` (`usersId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `google_credentials`
--

DROP TABLE IF EXISTS `google_credentials`;
CREATE TABLE IF NOT EXISTS `google_credentials` (
  `tokenId` int(11) NOT NULL AUTO_INCREMENT,
  `usersId` int(11) NOT NULL,
  `accessToken` varchar(256) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(128) NOT NULL,
  `tokenType` varchar(128) NOT NULL,
  `created` int(11) NOT NULL,
  `refreshToken` varchar(256) NOT NULL,
  `serviceType` varchar(256) NOT NULL,
  PRIMARY KEY (`tokenId`),
  KEY `usersId` (`usersId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `onedrive_credentials`
--

DROP TABLE IF EXISTS `onedrive_credentials`;
CREATE TABLE IF NOT EXISTS `onedrive_credentials` (
  `tokenId` int(11) NOT NULL AUTO_INCREMENT,
  `usersId` int(11) NOT NULL,
  `accessToken` varchar(1200) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(128) NOT NULL,
  `tokenType` varchar(128) NOT NULL,
  `created` int(11) NOT NULL,
  `refreshToken` varchar(1200) NOT NULL,
  `serviceType` varchar(256) NOT NULL,
  PRIMARY KEY (`tokenId`),
  KEY `usersId` (`usersId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `usersId` int(11) NOT NULL AUTO_INCREMENT,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  PRIMARY KEY (`usersId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
