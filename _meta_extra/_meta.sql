-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: mysql5.activeby.net
-- Generation Time: Apr 18, 2020 at 11:50 AM
-- Server version: 5.5.52
-- PHP Version: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user2031505_meta`
--

-- --------------------------------------------------------

--
-- Table structure for table `k-tn`
--
-- Creation: Apr 18, 2020 at 08:45 AM
--

CREATE TABLE IF NOT EXISTS `k-tn` (
  `idn` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Sets in Cyrillic' AUTO_INCREMENT=580386 ;

-- --------------------------------------------------------

--
-- Table structure for table `k-ts`
--
-- Creation: Apr 18, 2020 at 08:43 AM
--

CREATE TABLE IF NOT EXISTS `k-ts` (
  `ids` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `s` varchar(60) COLLATE utf8mb4_bin NOT NULL COMMENT 'Word',
  `kol` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'Amount',
  `f` tinyint(3) unsigned NOT NULL DEFAULT '7' COMMENT 'Status',
  PRIMARY KEY (`ids`),
  UNIQUE KEY `s` (`s`),
  KEY `f` (`f`),
  KEY `kol` (`kol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Words in Cyrillic' AUTO_INCREMENT=9473954 ;

-- --------------------------------------------------------

--
-- Table structure for table `k-t_s`
--
-- Creation: Oct 20, 2018 at 07:19 AM
--

CREATE TABLE IF NOT EXISTS `k-t_s` (
  `id_sv` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_n` int(10) unsigned zerofill NOT NULL COMMENT 'Set ID',
  `id_s` int(10) unsigned zerofill NOT NULL COMMENT 'Word ID',
  PRIMARY KEY (`id_sv`),
  UNIQUE KEY `sost` (`id_n`,`id_s`),
  KEY `id_s` (`id_s`),
  KEY `id_n` (`id_n`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Links for Cyrillic' AUTO_INCREMENT=9276493 ;

-- --------------------------------------------------------

--
-- Table structure for table `k_l`
--
-- Creation: Oct 20, 2018 at 07:23 AM
--

CREATE TABLE IF NOT EXISTS `k_l` (
  `idk_l` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `idk` int(10) unsigned zerofill NOT NULL COMMENT 'Cyrillic word ID',
  `idl` int(10) unsigned zerofill NOT NULL COMMENT 'Latin word ID',
  `idz` int(10) unsigned zerofill NOT NULL COMMENT 'Meaning ID',
  PRIMARY KEY (`idk_l`),
  KEY `idk` (`idk`),
  KEY `idl` (`idl`),
  KEY `idz` (`idz`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Links for translation' AUTO_INCREMENT=33803 ;

-- --------------------------------------------------------

--
-- Table structure for table `l-ts`
--
-- Creation: Apr 18, 2020 at 08:47 AM
--

CREATE TABLE IF NOT EXISTS `l-ts` (
  `ids` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `s` varchar(60) COLLATE utf8mb4_bin NOT NULL COMMENT 'Word',
  `f` tinyint(3) unsigned NOT NULL DEFAULT '7' COMMENT 'Status',
  PRIMARY KEY (`ids`),
  UNIQUE KEY `s` (`s`),
  KEY `f` (`f`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Words in Latin' AUTO_INCREMENT=461464 ;

-- --------------------------------------------------------

--
-- Table structure for table `tz`
--
-- Creation: Oct 20, 2018 at 07:47 AM
--

CREATE TABLE IF NOT EXISTS `tz` (
  `idz` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `z` varchar(191) COLLATE utf8mb4_bin NOT NULL COMMENT 'Meaning',
  PRIMARY KEY (`idz`),
  UNIQUE KEY `z` (`z`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Meanings for translation' AUTO_INCREMENT=33809 ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
