-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2014 at 01:23 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `formulargenerator`
--
	create database if not exists formulargenerator;
	use formulargenerator;

-- --------------------------------------------------------

--
-- Table structure for table `testformular`
--

CREATE TABLE IF NOT EXISTS `testformular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Geburtsdatum` date NOT NULL,
  `Anrede_r` enum('Frau','Herr') NOT NULL,
  `Vorname` varchar(50) NOT NULL,
  `Lieblingstier_d` enum('Katze','Hund','Anderes') DEFAULT NULL,
  `Passwort_p` varchar(50) NOT NULL,
  `Newsletter` tinyint(1) DEFAULT '0',
  `Beschreibung` text NOT NULL,
  `Alter` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `testformular2`
--

CREATE TABLE IF NOT EXISTS `testformular2` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `Passwort_p` varchar(20) NOT NULL,
  `Beschreibung` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
