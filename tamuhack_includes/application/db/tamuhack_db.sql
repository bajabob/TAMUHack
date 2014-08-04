-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 04, 2014 at 03:01 PM
-- Server version: 5.1.67-rel14.3-log
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tamuhack_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `th_applications`
--

CREATE TABLE IF NOT EXISTS `th_applications` (
  `id` int(10) NOT NULL,
  `school` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `grad_year` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `travel_costs` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hack_xp` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `is_accepted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `th_applications`
--

INSERT INTO `th_applications` (`id`, `school`, `linkedin`, `grad_year`, `travel_costs`, `hack_xp`, `is_accepted`) VALUES
(31, 'UCLA', 'linkedin/in/bajabob', '1987', '70.00', '<p>testing this</p>\r\n<h1>I SWEAR</h1>', 0),
(32, 'TAMU', 'bajabob', '5555', '$0.00', '<p>Hello</p>', 0),
(33, 'texas', 'hrllr', '1099', '100', '<p>lskdnfs,sf lksdjfsdflk</p>', 0);

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
  `publish` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `th_events`
--

INSERT INTO `th_events` (`id`, `title`, `date`, `location`, `link`, `publish`) VALUES
(1, 'HackTX', '1413651600', 'University+OF+Texas,+Austin,+TX,+United+States', 'http://hacktx.com', 1),
(2, 'PennApps', '1410498000', 'University+of+Pennsylvania,+Walnut+Street,+Philadelphia,+PA,+United+States', 'http://2014f.pennapps.com/', 1),
(3, 'HackMIT', '1412398800', 'Massachusetts+Institute+of+Technology,+Massachusetts+Avenue,+Cambridge,+MA,+United+States', 'http://hackmit.org', 1),
(4, 'Hack the North', '1411102800', 'https://www.google.com/maps/embed/v1/place?q=University+of+Waterloo,+Waterloo,+ON,+Canada&key', 'http://hackthenorth.com', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `th_events_rsvp`
--

INSERT INTO `th_events_rsvp` (`id`, `event_id`, `member_id`, `member_name`) VALUES
(1, 1, 1, 'Robert Timm'),
(2, 1, 3, 'Rafa Moreno'),
(3, 1, 9, 'Coulton Vento'),
(4, 1, 10, 'Nicolas Botello'),
(5, 1, 13, 'Santos Solorzano'),
(6, 1, 6, 'Omar Bahena'),
(7, 1, 7, 'Brian Wrobel'),
(8, 1, 2, 'Karrie Cheng'),
(9, 1, 21, 'Jeremy Cantu'),
(10, 1, 29, 'Jason Gould');

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
  `rep` int(6) NOT NULL,
  `email_verified` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `th_members`
--

INSERT INTO `th_members` (`id`, `account_type`, `name_first`, `name_last`, `email`, `pass`, `rep`, `email_verified`) VALUES
(0, 99, 'Rafa', 'Moreno', '', 'ad9f4aac444df2c34180f76a35f872ccd9205f1520b2b18ef6a6b450827d5801', 0, 1),
(2, 10, 'Karrie', 'Cheng', '', 'ed1669108b15a99efe4c7f0a1b5e147f3049d0cef1b04c232b5b841a1237145a', 0, 1),
(4, 10, 'Chethna', 'Kabeerdoss', '', 'a6a9bad03aca660bdcff39080163af03d805d759e5836b044cf535b3d90af854', 0, 1),
(5, 10, 'Kyle', 'Wilson', '', '7971b395e035e919d7bd00dd633bd6676f7238cfc45dee483708cdc21a42c01a', 0, 1),
(6, 10, 'Omar', 'Bahena', '', '43d167902654e8d8ad8fadd51ec440a771c2a9cc7210323b16790c70e054508f', 0, 1),
(7, 10, 'Brian', 'Wrobel', '', '316ce0981aa9fd728ed7b6b9dfccb92db379faaea00564dc3383a67268b750b2', 0, 1),
(8, 99, 'Christopher', 'Nolan', '', '1695d8907642720a3a770aaeb6f83a410bd42c8584798f63663a693103269549', 0, 1),
(9, 10, 'Coulton', 'Vento', '', '49de73cb4ad4039ef19e5465e1e2d248e8f08faa48ac3991a506e5b82530c9a4', 0, 1),
(10, 10, 'Nicolas', 'Botello', '', '378e6006eed9fcbae0720f46b75ae56d549bfcd354dcc20367098cd0e06453b9', 0, 1),
(11, 10, 'Carlos', 'Salamanca', '', '880f3b8df9259b8f29d3526878c31a07487dc81d8d902b5896f560052bf88ed5', 0, 1),
(12, 10, 'Matt', 'Dyl', '', 'c607a9300a6b130a42edbc45ad10c700ebfa3304b5d1394040bc26165d185dd8', 0, 1),
(13, 10, 'Santos', 'Solorzano', '', '0b33ac3f113093bc43e4f29b486eb98d143f6775016a9a76c94afed8e6cd57ba', 0, 1),
(14, 10, 'Roel', 'Orduno', '', 'd2d6e0d3cca11a648944cad8bb4147bc8ad9a06d147fb22d7abd1e6ffd1d6a1b', 0, 1),
(15, 10, 'Emmanuel', 'Estrada', '', '8f318f78a2d14f1ca3810ebcb34dcc573a7b29de630cce7ce562d642f447460b', 0, 1),
(16, 99, 'Eleni', 'Mijalis', '', 'c67418bb7e3e15457e786289c88b6698fc9b2fbbcee3ddfb5a3dcadd3eb360e9', 0, 1),
(17, 10, 'Jose', 'Manriquez', '', 'c45fd6fbcbf75869a8c377b193c6109d4593a0d31cfdc30faed198dc0d81054e', 0, 1),
(18, 10, 'Raj', 'Shah', '', '2ad3960b9123cae27d1b0664139e22d567dc8ecf2959386ded3a4d2cdddd1844', 0, 1),
(19, 10, 'Wilson', 'Ding', '', 'c24405bcd59399ee74e570e27cb62b1b20e6f18e16c6fd9e66140b5deea145db', 0, 1),
(20, 10, 'Theres', 'Roberts', '', '10532e9e81baee901d1523091aedbb92648c6e96245d67b5ffc85c4e926c1d88', 0, 1),
(21, 10, 'Jeremy', 'Cantu', '', '5afe81957c3316650ba47fe7d1f5c632d7f59759e07df608f7eb4afd5b0a5a86', 0, 1),
(22, 10, 'Ryan', 'Walters', '', 'c5a4d3b24a5f8d79b42d258b3e5a025d116839df4c40c1b182d4ac1ff3aa8743', 0, 1),
(23, 10, 'Yash', 'Chitneni', '', 'a4b66d52682ab51eed0b197fb38d97a5d61d634e11edb2afd23da0d352f5194a', 0, 1),
(24, 10, 'Andrew', 'Chepey', '', '370b5f5879785898e97fe4bd0fc7852cb2315f257fbcf5bca9eb4a5b34effee2', 0, 1),
(25, 10, 'Keaton', 'Brown', '', '663a01bb18efb52370b82d4e168b992583315086d43ee4e3ed69f8d05b4ed5bf', 0, 1),
(26, 10, 'Phong', 'Tran', '', '3ed29d593b7e279735e956885d6fae0451a8dd2b203efa753650bab213092a03', 0, 1),
(27, 10, 'Chaace', 'Graves', '', 'f81227bd074b31cf11b267e062d1c324450b90e514310a38b3b2d9a5ab429654', 0, 1),
(28, 10, 'Devan', 'Huapaya', '', 'a93d0bbf3032d731d3b9c1ecb07d10bd84171618a2fb8e439b70024fc2134eaf', 0, 1),
(29, 10, 'Jason', 'Gould', '', 'ce21edc0c193a429e9087d8c75671baf41b4b9dd87ffbdb5202fa1f343af63b7', 0, 1),
(32, 10, 'Robert', 'Timm', '', '36cf30d56ff23df64709be6336d6ec46a879bbe4b4fb1895d5492f9a8a57b037', 0, 1),
(33, 0, 'Robert', 'Timm', '', 'e9d4dd0b132c841851bb1cda4cd4819c9c1a6d2c180cb420d04649ebcfafcca9', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `th_members_activate`
--

CREATE TABLE IF NOT EXISTS `th_members_activate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `activation` varchar(64) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `th_members_activate`
--

INSERT INTO `th_members_activate` (`id`, `activation`, `email`) VALUES
(5, 'f7b285db6abbea5ab82e66c8e09d868dec005774c80c6e052383b92c07c2fa73', 'bluyam@tamu.edu'),
(35, 'db4d94f2f48d1b8b1852fc51fc54df0bf87a5963386ebcf5e11d640960a31290', 'bajabob.tx@gmail.com'),
(36, '95fc4d5b8025a903c04ef9b5d2b0eda0ff3af7c4159fec76d79b06b69b6fc17d', 'bobtimm@tamu.edu');

-- --------------------------------------------------------

--
-- Table structure for table `th_members_recover`
--

CREATE TABLE IF NOT EXISTS `th_members_recover` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `activation` varchar(64) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
