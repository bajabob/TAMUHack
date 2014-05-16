-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2014 at 04:45 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tamuhack_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `th_events`
--

CREATE TABLE IF NOT EXISTS `th_events` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `date` varchar(12) NOT NULL,
  `location` varchar(200) NOT NULL,
  `link` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `th_events_rsvp`
--

CREATE TABLE IF NOT EXISTS `th_events_rsvp` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `th_members`
--

CREATE TABLE IF NOT EXISTS `th_members` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_type` int(2) NOT NULL,
  `name_first` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name_last` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `uin` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `address_street` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `address_zip` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `address_state` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `address_city` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `rep` int(6) NOT NULL,
  `email_verified` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `th_members_activate`
--

CREATE TABLE IF NOT EXISTS `th_members_activate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `activation` varchar(64) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `th_members_recover`
--

CREATE TABLE IF NOT EXISTS `th_members_recover` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `activation` varchar(64) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
