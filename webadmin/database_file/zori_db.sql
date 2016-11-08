-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2016 at 02:28 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zori_db`
--
CREATE DATABASE IF NOT EXISTS `zori_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `zori_db`;

-- --------------------------------------------------------

--
-- Table structure for table `sysfaq`
--

DROP TABLE IF EXISTS `sysfaq`;
CREATE TABLE `sysfaq` (
  `FAQID` int(11) NOT NULL,
  `lstTopic` varchar(100) NOT NULL,
  `strTitle` varchar(100) NOT NULL,
  `strTags` varchar(100) NOT NULL,
  `txtFAQ` text NOT NULL,
  `intOrder` int(11) NOT NULL DEFAULT '0',
  `blnActive` tinyint(1) NOT NULL DEFAULT '1',
  `strLastUser` varchar(100) NOT NULL DEFAULT 'SYSTEM',
  `dtLastEdit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syslog`
--

DROP TABLE IF EXISTS `syslog`;
CREATE TABLE `syslog` (
  `LogID` int(11) NOT NULL,
  `dtLog` date NOT NULL,
  `strResult` varchar(255) NOT NULL,
  `txtArgs` text,
  `srlArgs` text,
  `srlSession` text,
  `strLastUser` varchar(50) NOT NULL DEFAULT 'System',
  `strLastEdit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syslogin`
--

DROP TABLE IF EXISTS `syslogin`;
CREATE TABLE `syslogin` (
  `LoginID` int(11) NOT NULL,
  `strType` varchar(100) NOT NULL DEFAULT 'iAdmin',
  `strIP` varchar(20) NOT NULL,
  `strResult` varchar(100) NOT NULL DEFAULT '',
  `strUsername` varchar(100) NOT NULL,
  `strPassword` varchar(100) DEFAULT NULL,
  `strDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `syslogin`
--

INSERT INTO `syslogin` (`LoginID`, `strType`, `strIP`, `strResult`, `strUsername`, `strPassword`, `strDateTime`) VALUES
(1, '', '192.168.100.85', 'Login failed: Incorrect password', 'pj@overdrive.co.za', 'P0n13s!', '2016-03-31 06:51:10'),
(2, '', '192.168.100.85', 'Login failed: Incorrect password', 'pj@overdrive.co.za', 'P0n13s!', '2016-03-31 06:51:20'),
(3, '', '192.168.100.85', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-03-31 06:53:59'),
(4, '', '192.168.100.85', 'Login failed: User not found or SG not active', 'gael@overdrive.co.za', 'Password01', '2016-03-31 07:23:16'),
(5, '', '192.168.100.85', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-03-31 07:33:57'),
(6, '', '192.168.100.85', 'Login failed: Incorrect password', 'pj@overdrive.co.za', '123ert', '2016-03-31 08:00:27'),
(7, '', '192.168.100.85', 'Login failed: Incorrect password', 'pj@overdrive.co.za', '123ert', '2016-03-31 08:00:30'),
(8, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-03-31 08:00:47'),
(9, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-03-31 09:16:04'),
(10, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-03-31 12:21:16'),
(11, '', '192.168.100.85', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '123ert', '2016-03-31 13:04:22'),
(12, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-03-31 13:04:37'),
(13, '', '192.168.100.85', 'Login failed: User not found or SG not active', '', '123ert', '2016-03-31 14:15:29'),
(14, '', '192.168.100.85', 'Login failed: User not found or SG not active', '', '123ert', '2016-03-31 14:15:42'),
(15, '', '192.168.100.85', 'Login failed: User not found or SG not active', '', '123ert', '2016-03-31 14:15:45'),
(16, '', '192.168.100.85', 'Login failed: User not found or SG not active', '', '123ert', '2016-03-31 14:15:58'),
(17, '', '192.168.100.85', 'Login failed: User not found or SG not active', '', '123ert', '2016-03-31 14:16:02'),
(18, '', '192.168.100.85', 'Login failed: User not found or SG not active', '', '123ert', '2016-03-31 14:16:22'),
(19, '', '192.168.100.85', 'Login failed: User not found or SG not active', '', '123ert', '2016-03-31 14:18:42'),
(20, '', '192.168.100.85', 'Login failed: User not found or SG not active', '', '123ert', '2016-03-31 14:19:20'),
(21, '', '192.168.100.85', 'Login failed: User not found or SG not active', '', '123ert', '2016-03-31 14:19:39'),
(22, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-03-31 14:34:03'),
(23, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-04-01 07:08:01'),
(24, '', '192.168.100.85', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '123ert', '2016-04-01 07:18:24'),
(25, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-04-01 07:18:29'),
(26, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-04-01 08:15:28'),
(27, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-04-01 08:20:01'),
(28, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-04-04 08:34:01'),
(29, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-04-05 12:02:21'),
(30, '', '192.168.100.85', 'Login successful', 'gael@overdrive.co.za', '', '2016-04-08 11:05:50'),
(31, '', '192.168.100.63', 'Login failed: Incorrect password', 'pj@overdrive.co.za', '123ert', '2016-04-11 11:58:33'),
(32, '', '192.168.100.63', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-04-11 11:58:42'),
(33, '', '192.168.100.63', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'G@ssword01', '2016-04-11 12:02:59'),
(34, '', '192.168.100.63', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'G@el3228#!', '2016-04-11 12:03:16'),
(35, '', '192.168.100.63', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'G@el3228#!', '2016-04-11 12:03:42'),
(36, '', '192.168.100.63', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'test', '2016-04-11 12:04:41'),
(37, '', '192.168.100.63', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'test', '2016-04-11 12:05:21'),
(38, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', 'test', '2016-04-11 12:06:17'),
(39, '', '192.168.100.63', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-04-11 12:06:32'),
(40, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', 'test', '2016-04-19 10:14:26'),
(41, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', 'test', '2016-04-19 10:14:36'),
(42, '', '192.168.100.63', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'test', '2016-04-19 10:14:44'),
(43, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', 'test', '2016-04-19 10:15:05'),
(44, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'Wamba@gmail.com', 'test', '2016-04-19 10:15:24'),
(45, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', 'test', '2016-04-19 10:16:33'),
(46, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', '123ert', '2016-04-19 10:17:30'),
(47, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', 'test', '2016-04-19 10:17:37'),
(48, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', '123ert', '2016-04-19 10:18:13'),
(49, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', '123ert', '2016-04-19 10:18:30'),
(50, '', '192.168.100.63', 'Login failed: User not found or SG not active', 'wamba@gmail.com', '123ert', '2016-04-19 10:18:46'),
(51, '', '192.168.100.69', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'test', '2016-05-03 08:43:30'),
(52, '', '192.168.100.69', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'test', '2016-05-03 08:44:46'),
(53, '', '192.168.100.69', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'G@el3228#!', '2016-05-03 08:45:10'),
(54, '', '192.168.100.69', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-05-03 08:51:39'),
(55, '', '192.168.100.69', 'Login successful', 'neils@overdrive.co.za', '', '2016-05-03 08:53:04'),
(56, '', '192.168.100.69', 'Login failed: Incorrect password', 'neils@overdrive.co.za', '123ert', '2016-05-03 09:03:24'),
(57, '', '192.168.100.69', 'Login failed: Incorrect password', 'neils@overdrive.co.za', 'neils', '2016-05-03 09:03:40'),
(58, '', '192.168.100.69', 'Login successful', 'neils@overdrive.co.za', '', '2016-05-03 09:03:51'),
(59, '', '192.168.100.69', 'Login successful', 'neils@overdrive.co.za', '', '2016-05-03 11:36:36'),
(60, '', '192.168.100.69', 'Login successful', 'neils@overdrive.co.za', '', '2016-05-03 12:11:16'),
(61, '', '192.168.100.63', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-05-12 09:05:36'),
(62, '', '192.168.100.116', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-05-12 11:44:04'),
(63, '', '192.168.100.69', 'Login successful', 'neils@overdrive.co.za', '', '2016-05-23 13:00:38'),
(64, '', '192.168.100.63', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-05-25 09:23:37'),
(65, '', '192.168.100.63', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-05-25 10:40:00'),
(66, '', '192.168.100.63', 'Login failed: Incorrect password', 'pj@overdrive.co.za', 'test', '2016-05-25 10:59:53'),
(67, '', '192.168.100.63', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-05-25 10:59:58'),
(68, '', '192.168.100.85', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-06-30 10:54:09'),
(69, '', '192.168.100.85', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-07-11 10:01:20'),
(70, '', '192.168.100.85', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'P0n13s!', '2016-09-05 13:01:01'),
(71, '', '192.168.100.85', 'Login successful', 'pj@overdrive.co.za', 'P0n13s!', '2016-09-05 13:01:10'),
(72, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 10:33:07'),
(73, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 10:33:14'),
(74, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 10:35:24'),
(75, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'rrrr', '2016-09-27 10:35:35'),
(76, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-27 10:35:41'),
(77, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-27 10:49:53'),
(78, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 10:50:16'),
(79, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 11:19:00'),
(80, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:12:54'),
(81, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:14:03'),
(82, '', '::1', 'Login failed: User not found or SG not active', 'cronjec@sawis.co.za', 'sf', '2016-09-27 14:17:12'),
(83, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'teest', '2016-09-27 14:17:25'),
(84, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:17:44'),
(85, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:18:43'),
(86, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:21:20'),
(87, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:22:32'),
(88, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:23:02'),
(89, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:23:33'),
(90, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:27:39'),
(91, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:27:47'),
(92, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:28:02'),
(93, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:28:28'),
(94, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-27 14:30:23'),
(95, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 08:16:20'),
(96, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 08:24:22'),
(97, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 08:27:25'),
(98, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 08:27:49'),
(99, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 08:28:29'),
(100, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 08:28:51'),
(101, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 08:50:28'),
(102, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:06:50'),
(103, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:10:40'),
(104, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:11:01'),
(105, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:11:24'),
(106, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:17:05'),
(107, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:18:13'),
(108, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:18:33'),
(109, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:19:42'),
(110, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:19:53'),
(111, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:22:22'),
(112, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 09:23:09'),
(113, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 10:08:48'),
(114, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-29 11:25:31'),
(115, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 11:25:40'),
(116, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:07:24'),
(117, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:07:52'),
(118, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:08:08'),
(119, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:08:23'),
(120, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:08:48'),
(121, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:09:15'),
(122, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:10:07'),
(123, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:14:14'),
(124, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:16:45'),
(125, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:32:40'),
(126, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:33:18'),
(127, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:36:02'),
(128, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:36:37'),
(129, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:55:24'),
(130, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:57:25'),
(131, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:57:43'),
(132, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:57:51'),
(133, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:59:09'),
(134, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 12:59:41'),
(135, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:00:24'),
(136, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:01:34'),
(137, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:01:51'),
(138, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:02:51'),
(139, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:03:20'),
(140, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:03:52'),
(141, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:08:42'),
(142, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:10:18'),
(143, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:10:39'),
(144, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:12:35'),
(145, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:12:58'),
(146, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:14:53'),
(147, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:15:03'),
(148, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:16:14'),
(149, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:17:27'),
(150, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:17:35'),
(151, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:17:54'),
(152, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:18:01'),
(153, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:18:08'),
(154, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:18:36'),
(155, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:18:53'),
(156, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:23:41'),
(157, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:24:06'),
(158, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:24:33'),
(159, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:25:03'),
(160, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:25:50'),
(161, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:26:43'),
(162, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:26:57'),
(163, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 13:27:31'),
(164, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 14:10:13'),
(165, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 14:11:13'),
(166, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 14:11:41'),
(167, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 14:11:47'),
(168, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 14:13:54'),
(169, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 14:15:50'),
(170, '', '::1', 'Login failed: Incorrect password', 'pj@overdrive.co.za', 'test', '2016-09-29 14:16:04'),
(171, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-29 14:16:14'),
(172, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 09:22:57'),
(173, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 09:23:33'),
(174, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 09:26:30'),
(175, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'v', '2016-09-30 09:29:26'),
(176, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'v', '2016-09-30 09:30:03'),
(177, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'v', '2016-09-30 09:30:07'),
(178, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'v', '2016-09-30 09:30:10'),
(179, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'v', '2016-09-30 09:30:12'),
(180, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'v', '2016-09-30 09:31:11'),
(181, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 09:31:40'),
(182, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 09:32:03'),
(183, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 09:32:29'),
(184, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'c', '2016-09-30 09:32:58'),
(185, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'c', '2016-09-30 09:33:05'),
(186, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'f', '2016-09-30 09:33:43'),
(187, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'tes', '2016-09-30 09:34:01'),
(188, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:34:30'),
(189, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:34:32'),
(190, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:34:33'),
(191, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'c', '2016-09-30 09:34:41'),
(192, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:45:35'),
(193, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:46:50'),
(194, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:46:55'),
(195, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:46:56'),
(196, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:46:59'),
(197, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:47:08'),
(198, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '', '2016-09-30 09:47:15'),
(199, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:48:01'),
(200, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:48:19'),
(201, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:48:33'),
(202, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:48:50'),
(203, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:48:56'),
(204, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:49:03'),
(205, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:49:09'),
(206, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:49:22'),
(207, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:50:42'),
(208, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '', '2016-09-30 09:50:50'),
(209, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 09:51:38'),
(210, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '', '2016-09-30 09:51:56'),
(211, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:52:04'),
(212, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:52:38'),
(213, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 09:52:44'),
(214, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:15:10'),
(215, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:15:17'),
(216, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 12:15:31'),
(217, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:15:45'),
(218, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:19:15'),
(219, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:20:59'),
(220, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:21:37'),
(221, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:24:32'),
(222, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:25:31'),
(223, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:25:50'),
(224, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 12:26:16'),
(225, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:34:54'),
(226, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:35:17'),
(227, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:35:38'),
(228, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:35:42'),
(229, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:35:48'),
(230, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:36:47'),
(231, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:36:52'),
(232, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:38:57'),
(233, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:40:08'),
(234, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:40:19'),
(235, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:40:36'),
(236, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:40:47'),
(237, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:40:59'),
(238, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:41:30'),
(239, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:41:41'),
(240, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:41:54'),
(241, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:42:05'),
(242, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:42:11'),
(243, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'd', '2016-09-30 14:42:18'),
(244, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:42:34'),
(245, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:42:38'),
(246, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:44:09'),
(247, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'd', '2016-09-30 14:44:16'),
(248, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:46:07'),
(249, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:46:11'),
(250, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'd', '2016-09-30 14:46:18'),
(251, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 14:46:32'),
(252, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:48:25'),
(253, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:48:31'),
(254, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-09-30 14:48:37'),
(255, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-09-30 14:48:46'),
(256, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '', '2016-10-03 07:27:52'),
(257, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-03 07:28:05'),
(258, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '', '2016-10-03 08:51:27'),
(259, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-03 08:59:14'),
(260, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '', '2016-10-03 09:05:53'),
(261, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'df', '2016-10-03 09:06:05'),
(262, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-03 09:08:28'),
(263, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-03 09:09:15'),
(264, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-03 09:09:26'),
(265, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-03 09:17:57'),
(266, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-03 09:18:11'),
(267, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-04 07:42:39'),
(268, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-04 07:48:55'),
(269, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-04 08:34:17'),
(270, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '', '2016-10-04 08:34:25'),
(271, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-04 08:36:33'),
(272, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '', '2016-10-04 12:18:35'),
(273, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-04 12:18:46'),
(274, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-04 12:19:07'),
(275, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-04 12:23:24'),
(276, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-05 15:23:18'),
(277, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-05 15:23:23'),
(278, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-05 15:23:32'),
(279, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 09:27:03'),
(280, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-07 09:27:13'),
(281, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 09:28:21'),
(282, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 09:29:31'),
(283, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 09:29:42'),
(284, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-07 10:10:14'),
(285, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 10:10:24'),
(286, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 10:28:20'),
(287, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 'tes', '2016-10-07 10:33:33'),
(288, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 10:33:37'),
(289, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 11:17:12'),
(290, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', 't', '2016-10-07 11:20:53'),
(291, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 11:21:02'),
(292, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 12:21:34'),
(293, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-07 13:57:52'),
(294, '', '::1', 'Login failed: Incorrect password', 'gael@overdrive.co.za', '', '2016-10-10 09:58:40'),
(295, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-10 09:59:00'),
(296, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-10 13:09:52'),
(297, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-10 13:10:03'),
(298, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-10 13:11:54'),
(299, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-10 13:12:27'),
(300, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:50:13'),
(301, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-11 12:50:53'),
(302, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-11 12:58:08'),
(303, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-11 12:58:28'),
(304, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:35'),
(305, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:35'),
(306, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:36'),
(307, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:36'),
(308, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:36'),
(309, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:36'),
(310, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:37'),
(311, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:38'),
(312, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:38'),
(313, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 12:58:38'),
(314, '', '::1', 'Login failed: User not found or SG not active', 'gael@overdrive.c.za', 'test', '2016-10-11 12:59:06'),
(315, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-11 12:59:33'),
(316, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-11 13:00:11'),
(317, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:40'),
(318, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:41'),
(319, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:41'),
(320, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:42'),
(321, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:42'),
(322, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:43'),
(323, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:43'),
(324, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:43'),
(325, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:44'),
(326, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:44'),
(327, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:45'),
(328, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:45'),
(329, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:45'),
(330, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:45'),
(331, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:46'),
(332, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:46'),
(333, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:46'),
(334, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:46'),
(335, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:47'),
(336, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:47'),
(337, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:47'),
(338, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:47'),
(339, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:48'),
(340, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:48'),
(341, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:49'),
(342, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:49'),
(343, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:49'),
(344, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:49'),
(345, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:49'),
(346, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:50'),
(347, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:50'),
(348, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:51'),
(349, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-11 13:00:52'),
(350, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-12 08:05:07'),
(351, '', '::1', 'Login failed: User not found or SG not active', '', '', '2016-10-12 14:36:18'),
(352, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-12 14:36:43'),
(353, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-13 07:45:51'),
(354, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-13 10:46:18'),
(355, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-13 13:28:01'),
(356, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-14 07:31:49'),
(357, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-18 07:21:15'),
(358, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-10-25 08:24:24'),
(359, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-11-01 10:02:13'),
(360, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-11-01 11:02:21'),
(361, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-11-01 12:35:49'),
(362, '', '::1', 'Login successful', 'gael@overdrive.co.za', 'test', '2016-11-08 13:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `sysmenulevel1`
--

DROP TABLE IF EXISTS `sysmenulevel1`;
CREATE TABLE `sysmenulevel1` (
  `MenuLevel1ID` int(11) NOT NULL,
  `strMenuLevel1` varchar(50) NOT NULL DEFAULT '- New -',
  `strUrl` varchar(100) NOT NULL DEFAULT '#',
  `intOrder` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sysmenulevel1`
--

INSERT INTO `sysmenulevel1` (`MenuLevel1ID`, `strMenuLevel1`, `strUrl`, `intOrder`) VALUES
(1, 'Home', 'index.php', 0),
(2, 'System Settings', '#', 9),
(3, 'Administration', '#', 8),
(4, 'Reports', 'report.php', 3),
(9, 'My Profile', 'my.profile.php', 10);

-- --------------------------------------------------------

--
-- Table structure for table `sysmenulevel2`
--

DROP TABLE IF EXISTS `sysmenulevel2`;
CREATE TABLE `sysmenulevel2` (
  `MenuLevel2ID` int(11) NOT NULL,
  `MenuLevel1ID` int(11) NOT NULL DEFAULT '0',
  `strMenuLevel2` varchar(50) NOT NULL,
  `strEntity` varchar(50) DEFAULT NULL,
  `strUrl` varchar(100) NOT NULL DEFAULT '#',
  `strNotes` varchar(100) NOT NULL,
  `intOrder` double NOT NULL DEFAULT '0',
  `blnMenuItem` tinyint(1) NOT NULL DEFAULT '1',
  `blnDivider` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sysmenulevel2`
--

INSERT INTO `sysmenulevel2` (`MenuLevel2ID`, `MenuLevel1ID`, `strMenuLevel2`, `strEntity`, `strUrl`, `strNotes`, `intOrder`, `blnMenuItem`, `blnDivider`) VALUES
(-4, 1, 'AjaxFunctions', '', 'ajaxfunctions.php', 'accessable to all', 0, 0, 0),
(-2, 1, 'Message', 'Message', 'message.php', 'accessable to all', 0, 0, 0),
(-1, 1, 'Home', 'Home', 'index.php', 'accessable to all', 0, 0, 0),
(2, 2, 'Security Groups', 'Security Group', 'security.group.php', '', 10, 1, 0),
(3, 2, 'User List', 'User', 'user.php', '', 11, 1, 0),
(4, 2, 'Advanced Settings', 'Advanced Setting', 'settings.php', '', 10, 1, 1),
(56, 4, 'Reports', 'Report', 'report.php', '', 20, 0, 0),
(57, 9, 'My Profile', 'My Profile', 'my.profile.php', '', 0, 0, 0),
(60, 3, 'Emails', 'Email', 'email.php', '', 0, 1, 0),
(61, 2, 'Email Templates', 'Email Template', 'email.template.php', '', 0, 1, 0),
(67, 3, 'FAQ', 'FAQ', 'faq.php', '', 30, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sysmenusidebar`
--

DROP TABLE IF EXISTS `sysmenusidebar`;
CREATE TABLE `sysmenusidebar` (
  `MenuSidebarID` int(11) NOT NULL,
  `strMenuSidebar` varchar(50) NOT NULL,
  `EN_strMenuSidebar` varchar(50) NOT NULL,
  `AF_strMenuSidebar` varchar(50) NOT NULL,
  `strUrl` varchar(100) NOT NULL,
  `strNotes` varchar(100) NOT NULL,
  `strFunctionName` varchar(100) NOT NULL,
  `arrFunctionArgs` varchar(50) NOT NULL,
  `intOrder` int(11) NOT NULL,
  `blnActive` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sysmenusidebar`
--

INSERT INTO `sysmenusidebar` (`MenuSidebarID`, `strMenuSidebar`, `EN_strMenuSidebar`, `AF_strMenuSidebar`, `strUrl`, `strNotes`, `strFunctionName`, `arrFunctionArgs`, `intOrder`, `blnActive`) VALUES
(1, 'My Tickets', 'My Tickets', 'My Tickets', 'tikect,php', '', 'getNewTickets', '', 1, 1),
(2, 'Emails', 'Emails', 'Emails', 'emails.php', '', 'getNewEmails', '', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `syssecurity`
--

DROP TABLE IF EXISTS `syssecurity`;
CREATE TABLE `syssecurity` (
  `refSecurityGroupID` int(11) NOT NULL DEFAULT '0',
  `refMenulevel2ID` int(11) NOT NULL DEFAULT '0',
  `blnView` tinyint(1) NOT NULL DEFAULT '1',
  `blnDelete` tinyint(1) NOT NULL DEFAULT '0',
  `blnSave` tinyint(1) NOT NULL DEFAULT '0',
  `blnNew` tinyint(1) NOT NULL DEFAULT '1',
  `blnSpecial` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `syssecurity`
--

INSERT INTO `syssecurity` (`refSecurityGroupID`, `refMenulevel2ID`, `blnView`, `blnDelete`, `blnSave`, `blnNew`, `blnSpecial`) VALUES
(1, -4, 1, 0, 0, 0, 0),
(1, -2, 1, 0, 0, 0, 0),
(1, -1, 1, 0, 0, 0, 0),
(1, 2, 1, 1, 1, 1, 0),
(1, 3, 1, 1, 1, 1, 0),
(1, 4, 1, 0, 1, 0, 0),
(1, 56, 1, 0, 0, 1, 0),
(1, 57, 1, 0, 1, 0, 0),
(1, 60, 1, 1, 1, 1, 0),
(1, 61, 1, 1, 1, 1, 0),
(1, 67, 1, 1, 1, 1, 0),
(2, -4, 1, 0, 0, 0, 0),
(2, -2, 1, 0, 0, 0, 0),
(2, -1, 1, 0, 0, 0, 0),
(2, 2, 1, 1, 1, 1, 0),
(2, 3, 1, 1, 1, 1, 0),
(2, 4, 1, 0, 1, 0, 0),
(2, 56, 1, 0, 0, 0, 0),
(2, 57, 1, 0, 1, 0, 0),
(2, 60, 1, 0, 0, 0, 0),
(2, 61, 1, 0, 0, 0, 0),
(2, 67, 1, 1, 1, 1, 0),
(3, -4, 1, 0, 0, 0, 0),
(3, -2, 1, 0, 0, 0, 0),
(3, -1, 1, 0, 0, 0, 0),
(3, 2, 0, 0, 0, 0, 0),
(3, 3, 0, 0, 0, 0, 0),
(3, 4, 0, 0, 0, 0, 0),
(3, 56, 0, 0, 0, 0, 0),
(3, 57, 1, 0, 1, 1, 0),
(3, 60, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `syssecuritygroup`
--

DROP TABLE IF EXISTS `syssecuritygroup`;
CREATE TABLE `syssecuritygroup` (
  `SecurityGroupID` int(11) NOT NULL,
  `strSecurityGroup` varchar(100) NOT NULL,
  `blnActive` tinyint(1) NOT NULL DEFAULT '1',
  `strLastUser` varchar(20) NOT NULL DEFAULT 'SYSTEM',
  `dtLastEdit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `syssecuritygroup`
--

INSERT INTO `syssecuritygroup` (`SecurityGroupID`, `strSecurityGroup`, `blnActive`, `strLastUser`, `dtLastEdit`) VALUES
(1, 'Admin Dev', 1, 'Gael', '2016-10-13 07:48:52'),
(2, 'Admin', 1, 'Gael', '2016-10-13 07:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `syssettings`
--

DROP TABLE IF EXISTS `syssettings`;
CREATE TABLE `syssettings` (
  `SettingID` int(11) NOT NULL,
  `strSetting` varchar(100) NOT NULL DEFAULT '',
  `strValue` text NOT NULL,
  `strComment` varchar(255) DEFAULT NULL,
  `strLastUser` varchar(20) NOT NULL DEFAULT 'SYSTEM',
  `dtLastEdit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `syssettings`
--

INSERT INTO `syssettings` (`SettingID`, `strSetting`, `strValue`, `strComment`, `strLastUser`, `dtLastEdit`) VALUES
(1, 'Session Timeout', '31', '', 'SYSTEM', '0000-00-00 00:00:00'),
(2, 'Title', 'Zori Admin (Test)', '', 'wamba', '2016-09-27 10:43:51'),
(3, 'System Version', 'v2 2015', '', 'PJ', '2014-11-04 09:30:11'),
(4, 'PageSize', '100', '', 'Stephen', '2011-10-10 11:08:14'),
(5, 'SMTP Send As', 'Jacques <jacques@overdrive.co.za>', '', 'PJ', '2015-02-09 15:14:51'),
(6, 'SMTP BCC', 'gael@overdrive.co.za', 'BCC', 'Gael', '2016-10-13 13:49:46'),
(7, 'NumericChars', '0123456789-+/*#$=.', '', 'PJ', '2011-09-19 11:57:27'),
(8, 'Enable PDFEncryption', '2', '', 'PJ', '2010-12-09 15:09:27'),
(11, 'LogoutRedirect', 'message.php?MID=s44', '', 'PJ', '2010-12-08 08:00:21'),
(12, 'SessionExRedirect', 'message.php?MID=s13', '', 'SYSTEM', '0000-00-00 00:00:00'),
(13, 'LastVisited', '5', '', 'Stephen', '2010-12-08 09:32:43'),
(14, 'imgRequired', '<b style=''font-size: 20px;'' class=''textColour''>*</b>', '', 'SYSTEM', '0000-00-00 00:00:00'),
(15, 'Brand', 'Zori Corporation', 'MOVED To _nemo.translations.inc.php', 'Gael', '2016-10-13 13:50:16'),
(18, 'PublicKey', '', 'google recatcha', 'SYSTEM', '2014-09-18 15:00:51'),
(19, 'PrivateKey', '', 'google recatcha', 'SYSTEM', '2014-09-18 15:00:51'),
(20, 'EmailReadReceiptURL', 'http://???/email.read.receipt.php', NULL, 'SYSTEM', '2014-09-18 15:00:51'),
(21, 'VAT', '0.14', NULL, 'SYSTEM', '2011-11-16 10:02:45'),
(29, 'EmailReadOnlineURL', 'http://www.livesiteurl.co.za/email.read.online.php', NULL, 'SYSTEM', '2015-03-24 08:53:28'),
(30, 'AllowIndividualEmails', '1', NULL, 'SYSTEM', '2012-02-02 14:37:20'),
(37, 'Google Analytics', '<script type=''text/javascript''> var _gaq = _gaq || []; _gaq.push([''_setAccount'', ''???'']); _gaq.push([''_trackPageview'']); (function() { var ga = document.createElement(''script''); ga.type = ''text/javascript''; ga.async = true; ga.src = (''https:'' == document.location.protocol ? ''https://ssl'' : ''http://www'') + ''.google-analytics.com/ga.js''; var s = document.getElementsByTagName(''script'')[0]; s.parentNode.insertBefore(ga, s); })(); </script> ', NULL, 'pj', '2014-09-18 15:01:29'),
(43, 'LiveURL', 'http://www.???.co.za', NULL, 'SYSTEM', '2014-09-18 15:01:29'),
(48, 'ProfileImageDirAdmin', './profilepictures/', NULL, 'SYSTEM', '2014-12-12 08:44:01'),
(49, 'CompanyImagesDir', './companyimages/', NULL, 'SYSTEM', '2015-01-23 09:41:24'),
(50, 'SiteColorMain', '#FFFFFF', 'Main Site Color', 'Gael', '2016-04-08 11:21:37'),
(51, 'SiteColorLight', '#d75345', 'Lighter version of main color', 'SYSTEM', '2015-02-05 12:53:01'),
(52, 'SiteColorDark', '#a21e10', 'Darker version of main color', 'SYSTEM', '2015-02-05 12:53:01'),
(53, 'SiteColorAlt', '#9E8851', 'Alternative color 1', 'SYSTEM', '2015-02-09 10:26:09'),
(54, 'SiteColorAlt2', '#7e6d41', 'Alternative color 2', 'SYSTEM', '2015-02-09 10:33:21'),
(55, 'SiteColorAlt3', '#FFFFFF', 'Alternative color 3', 'SYSTEM', '2015-02-05 12:53:01'),
(56, 'LoginBG', '2.jpg', 'Background to be displayd on login page', 'SYSTEM', '2015-02-09 11:16:01'),
(61, 'EN_Brand', 'Company Name', NULL, 'SYSTEM', '2015-03-24 08:59:16'),
(62, 'AF_Brand', 'Maatskappy Naam', NULL, 'SYSTEM', '2015-03-24 08:59:16'),
(63, 'EN_Title', 'Nemo V2', '', 'wamba', '2016-04-19 10:29:35'),
(64, 'AF_Title', 'Zori Corporation.', '', 'Gael', '2016-10-13 13:47:47'),
(65, 'vieEmailContacts ', 'CREATE OR REPLACE VIEW vieEmailContacts AS\r\nSELECT DISTINCT strTo as ViewID, strTo as strView, '''' as DisplayName\r\nFROM tblEmail \r\nWHERE strTo NOT LIKE (''%;%'') AND strTo <> '''' \r\nORDER BY ViewID, strView', NULL, 'SYSTEM', '2015-10-27 09:34:06'),
(66, 'blnMultiLanguage', '0', '1 = On , 0 = Off', 'SYSTEM', '2016-01-12 12:57:54'),
(67, 'MadeBy', 'Made by Gael Musikingala', 'Footer made by text', 'SYSTEM', '2016-09-27 10:48:16'),
(68, 'Copyright', 'Doudjiem Corporation', 'Copyright Text', 'SYSTEM', '2016-09-27 10:46:16'),
(69, 'CopyrightSymbolYear', '&copy 2016', 'Copyright Symbol and display Year', 'SYSTEM', '2016-09-27 10:47:27'),
(70, 'ProjectName', 'Zori PHP Starter', 'Name of the project', 'SYSTEM', '2016-09-27 11:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `sysuser`
--

DROP TABLE IF EXISTS `sysuser`;
CREATE TABLE `sysuser` (
  `UserID` int(11) NOT NULL,
  `refSecurityGroupID` int(11) NOT NULL DEFAULT '0',
  `strUser` varchar(100) NOT NULL,
  `strEmail` varchar(100) NOT NULL,
  `strPasswordMD5` varchar(32) NOT NULL DEFAULT '',
  `strTel` varchar(100) DEFAULT NULL,
  `Profile:PicturePath` varchar(100) DEFAULT 'blank.jpg',
  `strSetting:Language` enum('English') NOT NULL DEFAULT 'English',
  `strFirstUser` varchar(255) DEFAULT NULL,
  `dtFirstEdit` datetime NOT NULL,
  `blnActive` tinyint(1) NOT NULL DEFAULT '1',
  `strLastUser` varchar(100) NOT NULL DEFAULT 'SYSTEM',
  `dtLastEdit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sysuser`
--

INSERT INTO `sysuser` (`UserID`, `refSecurityGroupID`, `strUser`, `strEmail`, `strPasswordMD5`, `strTel`, `Profile:PicturePath`, `strSetting:Language`, `strFirstUser`, `dtFirstEdit`, `blnActive`, `strLastUser`, `dtLastEdit`) VALUES
(-4, 1, 'Jacques', 'jacques@overdrive.co.za', 'd41d8cd98f00b204e9800998ecf8427e', '', 'blank.jpg', 'English', 'Gael', '0000-00-00 00:00:00', 0, 'Gael', '2016-11-02 13:41:41'),
(-3, 1, 'Gareth', 'gareth@overdrive.co.za', 'd41d8cd98f00b204e9800998ecf8427e', '', 'blank.jpg', 'English', 'PJ', '2010-12-07 12:56:33', 1, 'Gael', '2016-10-13 07:59:36'),
(-2, 1, 'Software', 'software@overdrive.co.za', 'd41d8cd98f00b204e9800998ecf8427e', '', '000-2_lyan.jpg', 'English', 'PJ', '2010-12-07 12:56:33', 1, 'Gael', '2016-11-01 14:08:08'),
(-1, 1, 'Pieter van der Merwe', 'pj@overdrive.co.za', 'e3438300b97bcb6166560ecae31ea467', '', '000-1_Desertsd.jpg', 'English', 'PJ', '2010-12-07 12:56:33', 1, 'Pieter van der Merwe', '2016-03-31 06:53:50'),
(1, 1, 'Gael', 'gael@overdrive.co.za', '098f6bcd4621d373cade4e832627b4f6', '0797134913', '00001_Liverpool_FC_logo.png', 'English', 'Gael', '2016-03-31 09:35:12', 1, 'Gael', '2016-11-01 13:47:57'),
(2, 1, 'Neil', 'neils@overdrive.co.za', 'd41d8cd98f00b204e9800998ecf8427e', '', '00002_Kinshasa.png', 'English', 'Neil', '2016-05-03 10:52:33', 0, 'Gael', '2016-11-02 07:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `tblemail`
--

DROP TABLE IF EXISTS `tblemail`;
CREATE TABLE `tblemail` (
  `EmailID` int(11) NOT NULL,
  `UniqueID` varchar(12) CHARACTER SET latin1 NOT NULL COMMENT 'system assigned - used to access read-online',
  `refEmailTemplateID` int(11) DEFAULT NULL,
  `strFrom` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `strTo` varchar(100) CHARACTER SET latin1 NOT NULL,
  `strCC` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `strSubject` varchar(100) CHARACTER SET latin1 NOT NULL,
  `strStatus` enum('Sending','Sent','Read','Error') CHARACTER SET latin1 NOT NULL DEFAULT 'Sending',
  `txtHeaders` text CHARACTER SET latin1 NOT NULL,
  `txtBody` text CHARACTER SET latin1 NOT NULL,
  `arrAttachments` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `dtEmail` datetime NOT NULL,
  `txtNotes` text CHARACTER SET latin1 COMMENT 'Internal use only',
  `strLastUser` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT 'SYSTEM',
  `dtLastEdit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblemail`
--

INSERT INTO `tblemail` (`EmailID`, `UniqueID`, `refEmailTemplateID`, `strFrom`, `strTo`, `strCC`, `strSubject`, `strStatus`, `txtHeaders`, `txtBody`, `arrAttachments`, `dtEmail`, `txtNotes`, `strLastUser`, `dtLastEdit`) VALUES
(1, '2NGN6F', 0, 'Jacques <jacques@overdrive.co.za>', 'gael@overdrive.co.za', '', 'GMW News Security Warning', 'Sent', 'From: =?UTF-8?Q?Jacques?= <jacques@overdrive.co.za>\nBCC:jacques@overdrive.co.za\nMIME-Version: 1.0\nDate: Mon, 11 Apr 2016 14:05:21 +0200\nContent-Type: multipart/mixed;\n boundary=|==Multipart_Boundary_x2769a442df6bc9d001720cf936b6db55x|', '--==Multipart_Boundary_x2769a442df6bc9d001720cf936b6db55x\nContent-Type:text/html; charset=''iso-8859-1''\nContent-Transfer-Encoding: 7bit\n\n<font style=''font-size:11.0pt; font-family:Calibri,sans-serif,Arial;''><br />Attention Gael<br /><br />Your login account has been suspended due to repeated failed login attempts.<br /><br />Please contact your site administrator to verify your details and restore your account.<br /><br />Regards<br />GMW News\r\n<table cellpadding=''2'' cellspacing=''1'' border=''0'' style=''border: 1px solid #343434;'' bgcolor=''#D5D5D5'' >\r\n<caption colspan=''100%''><b>Last 5 Login Results</b></caption>\r\n<tr bgcolor=''#E6E6E6''>\r\n<th>LoginID</th><th>IP</th><th>Result</th><th>Username</th><th>Password</th><th>DT</th>\r\n</tr>\r\n<tr bgcolor=''white''><td>37</td><td>192.168.100.63</td><td>Login failed: Incorrect\n password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-11 14:05:21</td></tr><tr bgcolor=''white''><td>36</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-11 14:04:41</td></tr><tr bgcolor=''white''><td>35</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>G@el3228#!</td><td>2016-04-11 14:03:42</td></tr><tr bgcolor=''white''><td>34</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>G@el3228#!</td><td>2016-04-11 14:03:16</td></tr><tr bgcolor=''white''><td>33</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>G@ssword01</td><td>2016-04-11 14:02:59</td></tr>\r\n</table>\r\n</font>', '', '2016-04-11 14:05:22', '', '', '2016-04-11 12:05:22'),
(2, '7C60GK', 0, 'Jacques <jacques@overdrive.co.za>', 'gael@overdrive.co.za', '', 'Open Layers Security Warning', 'Sent', 'From: =?UTF-8?Q?Jacques?= <jacques@overdrive.co.za>\nBCC:jacques@overdrive.co.za\nMIME-Version: 1.0\nDate: Tue, 19 Apr 2016 12:14:44 +0200\nContent-Type: multipart/mixed;\n boundary=|==Multipart_Boundary_xd66d40b6a25d4b130d5c7288f0f24d80x|', '--==Multipart_Boundary_xd66d40b6a25d4b130d5c7288f0f24d80x\nContent-Type:text/html; charset=''iso-8859-1''\nContent-Transfer-Encoding: 7bit\n\n<font style=''font-size:11.0pt; font-family:Calibri,sans-serif,Arial;''><br />Attention Gael<br /><br />Your login account has been suspended due to repeated failed login attempts.<br /><br />Please contact your site administrator to verify your details and restore your account.<br /><br />Regards<br />Open layers\r\n<table cellpadding=''2'' cellspacing=''1'' border=''0'' style=''border: 1px solid #343434;'' bgcolor=''#D5D5D5'' >\r\n<caption colspan=''100%''><b>Last 5 Login Results</b></caption>\r\n<tr bgcolor=''#E6E6E6''>\r\n<th>LoginID</th><th>IP</th><th>Result</th><th>Username</th><th>Password</th><th>DT</th>\r\n</tr>\r\n<tr bgcolor=''white''><td>42</td><td>192.168.100.63</td><td>Login failed: Incorrect\n password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-19 12:14:44</td></tr><tr bgcolor=''white''><td>37</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-11 14:05:21</td></tr><tr bgcolor=''white''><td>36</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-11 14:04:41</td></tr><tr bgcolor=''white''><td>35</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>G@el3228#!</td><td>2016-04-11 14:03:42</td></tr><tr bgcolor=''white''><td>34</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>G@el3228#!</td><td>2016-04-11 14:03:16</td></tr>\r\n</table>\r\n</font>', '', '2016-04-19 12:14:45', '', '', '2016-04-19 10:14:45'),
(3, '2FCCAE', 0, 'Jacques <jacques@overdrive.co.za>', 'gael@overdrive.co.za', '', 'Nemo V2 Security Warning', 'Sent', 'From: =?UTF-8?Q?Jacques?= <jacques@overdrive.co.za>\nBCC:jacques@overdrive.co.za\nMIME-Version: 1.0\nDate: Tue, 03 May 2016 10:43:31 +0200\nContent-Type: multipart/mixed;\n boundary=|==Multipart_Boundary_x58c53a1299f132619babb7c54b538076x|', '--==Multipart_Boundary_x58c53a1299f132619babb7c54b538076x\nContent-Type:text/html; charset=''iso-8859-1''\nContent-Transfer-Encoding: 7bit\n\n<font style=''font-size:11.0pt; font-family:Calibri,sans-serif,Arial;''><br />Attention Gael<br /><br />Your login account has been suspended due to repeated failed login attempts.<br /><br />Please contact your site administrator to verify your details and restore your account.<br /><br />Regards<br />Company Name\r\n<table cellpadding=''2'' cellspacing=''1'' border=''0'' style=''border: 1px solid #343434;'' bgcolor=''#D5D5D5'' >\r\n<caption colspan=''100%''><b>Last 5 Login Results</b></caption>\r\n<tr bgcolor=''#E6E6E6''>\r\n<th>LoginID</th><th>IP</th><th>Result</th><th>Username</th><th>Password</th><th>DT</th>\r\n</tr>\r\n<tr bgcolor=''white''><td>51</td><td>192.168.100.69</td><td>Login failed: Incorrect\n password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-05-03 10:43:30</td></tr><tr bgcolor=''white''><td>42</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-19 12:14:44</td></tr><tr bgcolor=''white''><td>37</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-11 14:05:21</td></tr><tr bgcolor=''white''><td>36</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-11 14:04:41</td></tr><tr bgcolor=''white''><td>35</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>G@el3228#!</td><td>2016-04-11 14:03:42</td></tr>\r\n</table>\r\n</font>', '', '2016-05-03 10:43:32', '', '', '2016-05-03 08:43:32'),
(4, 'A2BFAK', 0, 'Jacques <jacques@overdrive.co.za>', 'gael@overdrive.co.za', '', 'Nemo V2 Security Warning', 'Sent', 'From: =?UTF-8?Q?Jacques?= <jacques@overdrive.co.za>\nBCC:jacques@overdrive.co.za\nMIME-Version: 1.0\nDate: Tue, 03 May 2016 10:44:46 +0200\nContent-Type: multipart/mixed;\n boundary=|==Multipart_Boundary_x4d6a3db818aa6b4cb9a920e80751dfb8x|', '--==Multipart_Boundary_x4d6a3db818aa6b4cb9a920e80751dfb8x\nContent-Type:text/html; charset=''iso-8859-1''\nContent-Transfer-Encoding: 7bit\n\n<font style=''font-size:11.0pt; font-family:Calibri,sans-serif,Arial;''><br />Attention Gael<br /><br />Your login account has been suspended due to repeated failed login attempts.<br /><br />Please contact your site administrator to verify your details and restore your account.<br /><br />Regards<br />Company Name\r\n<table cellpadding=''2'' cellspacing=''1'' border=''0'' style=''border: 1px solid #343434;'' bgcolor=''#D5D5D5'' >\r\n<caption colspan=''100%''><b>Last 5 Login Results</b></caption>\r\n<tr bgcolor=''#E6E6E6''>\r\n<th>LoginID</th><th>IP</th><th>Result</th><th>Username</th><th>Password</th><th>DT</th>\r\n</tr>\r\n<tr bgcolor=''white''><td>52</td><td>192.168.100.69</td><td>Login failed: Incorrect\n password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-05-03 10:44:46</td></tr><tr bgcolor=''white''><td>51</td><td>192.168.100.69</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-05-03 10:43:30</td></tr><tr bgcolor=''white''><td>42</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-19 12:14:44</td></tr><tr bgcolor=''white''><td>37</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-11 14:05:21</td></tr><tr bgcolor=''white''><td>36</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-11 14:04:41</td></tr>\r\n</table>\r\n</font>', '', '2016-05-03 10:44:47', '', '', '2016-05-03 08:44:47'),
(5, '197089', 0, 'Jacques <jacques@overdrive.co.za>', 'gael@overdrive.co.za', '', 'Nemo V2 Security Warning', 'Sent', 'From: =?UTF-8?Q?Jacques?= <jacques@overdrive.co.za>\nBCC:jacques@overdrive.co.za\nMIME-Version: 1.0\nDate: Tue, 03 May 2016 10:45:10 +0200\nContent-Type: multipart/mixed;\n boundary=|==Multipart_Boundary_xeea77f111778a4b73d2a29f7f9ecbdbdx|', '--==Multipart_Boundary_xeea77f111778a4b73d2a29f7f9ecbdbdx\nContent-Type:text/html; charset=''iso-8859-1''\nContent-Transfer-Encoding: 7bit\n\n<font style=''font-size:11.0pt; font-family:Calibri,sans-serif,Arial;''><br />Attention Gael<br /><br />Your login account has been suspended due to repeated failed login attempts.<br /><br />Please contact your site administrator to verify your details and restore your account.<br /><br />Regards<br />Company Name\r\n<table cellpadding=''2'' cellspacing=''1'' border=''0'' style=''border: 1px solid #343434;'' bgcolor=''#D5D5D5'' >\r\n<caption colspan=''100%''><b>Last 5 Login Results</b></caption>\r\n<tr bgcolor=''#E6E6E6''>\r\n<th>LoginID</th><th>IP</th><th>Result</th><th>Username</th><th>Password</th><th>DT</th>\r\n</tr>\r\n<tr bgcolor=''white''><td>53</td><td>192.168.100.69</td><td>Login failed: Incorrect\n password</td><td>gael@overdrive.co.za</td><td>G@el3228#!</td><td>2016-05-03 10:45:10</td></tr><tr bgcolor=''white''><td>52</td><td>192.168.100.69</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-05-03 10:44:46</td></tr><tr bgcolor=''white''><td>51</td><td>192.168.100.69</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-05-03 10:43:30</td></tr><tr bgcolor=''white''><td>42</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-19 12:14:44</td></tr><tr bgcolor=''white''><td>37</td><td>192.168.100.63</td><td>Login failed: Incorrect password</td><td>gael@overdrive.co.za</td><td>test</td><td>2016-04-11 14:05:21</td></tr>\r\n</table>\r\n</font>', '', '2016-05-03 10:45:11', '', '', '2016-05-03 08:45:11');

-- --------------------------------------------------------

--
-- Table structure for table `tblemailtemplate`
--

DROP TABLE IF EXISTS `tblemailtemplate`;
CREATE TABLE `tblemailtemplate` (
  `EmailTemplateID` int(11) NOT NULL,
  `strEmailTemplate` varchar(100) NOT NULL COMMENT 'read-only',
  `strSubject` varchar(100) NOT NULL,
  `txtBody` text NOT NULL,
  `arrAttachments` varchar(255) DEFAULT NULL,
  `arrSubstitutions` varchar(255) DEFAULT NULL,
  `txtNotes` text COMMENT 'Internal use only',
  `blnActive` tinyint(1) NOT NULL DEFAULT '1',
  `strLastUser` varchar(100) NOT NULL DEFAULT 'SYSTEM',
  `dtLastEdit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblemailtemplate`
--

INSERT INTO `tblemailtemplate` (`EmailTemplateID`, `strEmailTemplate`, `strSubject`, `txtBody`, `arrAttachments`, `arrSubstitutions`, `txtNotes`, `blnActive`, `strLastUser`, `dtLastEdit`) VALUES
(-2, 'Login PIN', 'SAWIS Online: New Login PIN', 'Hi [DisplayName]\r\n\r\nA new Login PIN was generated:\r\nNew PIN: [LoginPIN]\r\n\r\nRegards\r\nSAWIS Online\r\n\r\n[Logo]\r\n\r\nTo view this email online go to [ReadOnline]\r\n[ReadReceipt]', NULL, 'DisplayName,LoginPIN', 'not in use sawis', 0, 'SYSTEM', '2016-03-29 09:16:30'),
(-1, 'Reset Password', 'SAWIS Online: Reset password procedure', 'Hi [DisplayName]\r\n\r\nPlease follow the following link to reset your password:\r\n[Link] \r\n\r\nRegards \r\nSAWIS Online\r\n\r\n[Logo]\r\n\r\nTo view this email online go to [ReadOnline]\r\n[ReadReceipt]', '', 'DisplayName,Link', '', 1, 'Pieter van der Merwe', '2016-03-29 09:16:30');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vieemailcontacts`
--
DROP VIEW IF EXISTS `vieemailcontacts`;
CREATE TABLE `vieemailcontacts` (
`ViewID` varchar(100)
,`strView` varchar(100)
,`DisplayName` char(0)
);

-- --------------------------------------------------------

--
-- Structure for view `vieemailcontacts`
--
DROP TABLE IF EXISTS `vieemailcontacts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vieemailcontacts`  AS  select distinct `tblemail`.`strTo` AS `ViewID`,`tblemail`.`strTo` AS `strView`,'' AS `DisplayName` from `tblemail` where ((not((`tblemail`.`strTo` like '%;%'))) and (`tblemail`.`strTo` <> '')) order by `tblemail`.`strTo`,`tblemail`.`strTo` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sysfaq`
--
ALTER TABLE `sysfaq`
  ADD PRIMARY KEY (`FAQID`);

--
-- Indexes for table `syslog`
--
ALTER TABLE `syslog`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `dtLog` (`dtLog`);

--
-- Indexes for table `syslogin`
--
ALTER TABLE `syslogin`
  ADD PRIMARY KEY (`LoginID`);

--
-- Indexes for table `sysmenulevel1`
--
ALTER TABLE `sysmenulevel1`
  ADD PRIMARY KEY (`MenuLevel1ID`),
  ADD KEY `strMenuLevel1` (`strMenuLevel1`);

--
-- Indexes for table `sysmenulevel2`
--
ALTER TABLE `sysmenulevel2`
  ADD PRIMARY KEY (`MenuLevel2ID`),
  ADD KEY `MenuLevel1ID` (`MenuLevel1ID`);

--
-- Indexes for table `sysmenusidebar`
--
ALTER TABLE `sysmenusidebar`
  ADD PRIMARY KEY (`MenuSidebarID`);

--
-- Indexes for table `syssecurity`
--
ALTER TABLE `syssecurity`
  ADD PRIMARY KEY (`refSecurityGroupID`,`refMenulevel2ID`);

--
-- Indexes for table `syssecuritygroup`
--
ALTER TABLE `syssecuritygroup`
  ADD PRIMARY KEY (`SecurityGroupID`);

--
-- Indexes for table `syssettings`
--
ALTER TABLE `syssettings`
  ADD PRIMARY KEY (`SettingID`);

--
-- Indexes for table `sysuser`
--
ALTER TABLE `sysuser`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `strUser` (`strUser`),
  ADD UNIQUE KEY `strEmail` (`strEmail`),
  ADD KEY `refSecurityGroupID` (`refSecurityGroupID`);

--
-- Indexes for table `tblemail`
--
ALTER TABLE `tblemail`
  ADD PRIMARY KEY (`EmailID`),
  ADD KEY `UniqueID` (`UniqueID`),
  ADD KEY `strTo` (`strTo`),
  ADD KEY `refEmailTemplateID` (`refEmailTemplateID`);

--
-- Indexes for table `tblemailtemplate`
--
ALTER TABLE `tblemailtemplate`
  ADD PRIMARY KEY (`EmailTemplateID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sysfaq`
--
ALTER TABLE `sysfaq`
  MODIFY `FAQID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `syslog`
--
ALTER TABLE `syslog`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `syslogin`
--
ALTER TABLE `syslogin`
  MODIFY `LoginID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=363;
--
-- AUTO_INCREMENT for table `sysmenulevel1`
--
ALTER TABLE `sysmenulevel1`
  MODIFY `MenuLevel1ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sysmenulevel2`
--
ALTER TABLE `sysmenulevel2`
  MODIFY `MenuLevel2ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `sysmenusidebar`
--
ALTER TABLE `sysmenusidebar`
  MODIFY `MenuSidebarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `syssecuritygroup`
--
ALTER TABLE `syssecuritygroup`
  MODIFY `SecurityGroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `syssettings`
--
ALTER TABLE `syssettings`
  MODIFY `SettingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `sysuser`
--
ALTER TABLE `sysuser`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblemail`
--
ALTER TABLE `tblemail`
  MODIFY `EmailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tblemailtemplate`
--
ALTER TABLE `tblemailtemplate`
  MODIFY `EmailTemplateID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `sysmenulevel2`
--
ALTER TABLE `sysmenulevel2`
  ADD CONSTRAINT `sysMenuLevel2_ibfk_1` FOREIGN KEY (`MenuLevel1ID`) REFERENCES `sysmenulevel1` (`MenuLevel1ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sysMenuLevel2_ibfk_2` FOREIGN KEY (`MenuLevel1ID`) REFERENCES `sysmenulevel1` (`MenuLevel1ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sysuser`
--
ALTER TABLE `sysuser`
  ADD CONSTRAINT `sysUser.strSecurityGroup` FOREIGN KEY (`refSecurityGroupID`) REFERENCES `syssecuritygroup` (`SecurityGroupID`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
