-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 04, 2020 at 02:43 AM
-- Server version: 8.0.19
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `_meta`
--

-- --------------------------------------------------------

--
-- Table structure for table `k-tn`
--

CREATE TABLE `k-tn` (
  `idn` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Sets in Cyrillic';

-- --------------------------------------------------------

--
-- Table structure for table `k-ts`
--

CREATE TABLE `k-ts` (
  `ids` int UNSIGNED NOT NULL,
  `s` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Word',
  `kol` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Amount',
  `f` tinyint UNSIGNED NOT NULL DEFAULT '7' COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Words in Cyrillic';

-- --------------------------------------------------------

--
-- Table structure for table `k-t_s`
--

CREATE TABLE `k-t_s` (
  `id_sv` int UNSIGNED NOT NULL,
  `id_n` int UNSIGNED NOT NULL COMMENT 'Set ID',
  `id_s` int UNSIGNED NOT NULL COMMENT 'Word ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Links for Cyrillic';

-- --------------------------------------------------------

--
-- Table structure for table `k_l`
--

CREATE TABLE `k_l` (
  `idk_l` int UNSIGNED NOT NULL,
  `idk` int UNSIGNED NOT NULL COMMENT 'Cyrillic word ID',
  `idl` int UNSIGNED NOT NULL COMMENT 'Latin word ID',
  `idz` int UNSIGNED NOT NULL COMMENT 'Meaning ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Links for translation';

-- --------------------------------------------------------

--
-- Table structure for table `l-ts`
--

CREATE TABLE `l-ts` (
  `ids` int UNSIGNED NOT NULL,
  `s` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Word',
  `f` tinyint UNSIGNED NOT NULL DEFAULT '7' COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Words in Latin';

-- --------------------------------------------------------

--
-- Table structure for table `tz`
--

CREATE TABLE `tz` (
  `idz` int UNSIGNED NOT NULL,
  `z` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Meaning'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Meanings for translation';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `k-tn`
--
ALTER TABLE `k-tn`
  ADD PRIMARY KEY (`idn`);

--
-- Indexes for table `k-ts`
--
ALTER TABLE `k-ts`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `s` (`s`),
  ADD KEY `f` (`f`),
  ADD KEY `kol` (`kol`);

--
-- Indexes for table `k-t_s`
--
ALTER TABLE `k-t_s`
  ADD PRIMARY KEY (`id_sv`),
  ADD UNIQUE KEY `sost` (`id_n`,`id_s`),
  ADD KEY `id_s` (`id_s`),
  ADD KEY `id_n` (`id_n`);

--
-- Indexes for table `k_l`
--
ALTER TABLE `k_l`
  ADD PRIMARY KEY (`idk_l`),
  ADD KEY `idk` (`idk`),
  ADD KEY `idl` (`idl`),
  ADD KEY `idz` (`idz`);

--
-- Indexes for table `l-ts`
--
ALTER TABLE `l-ts`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `s` (`s`),
  ADD KEY `f` (`f`);

--
-- Indexes for table `tz`
--
ALTER TABLE `tz`
  ADD PRIMARY KEY (`idz`),
  ADD UNIQUE KEY `z` (`z`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `k-tn`
--
ALTER TABLE `k-tn`
  MODIFY `idn` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `k-ts`
--
ALTER TABLE `k-ts`
  MODIFY `ids` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `k-t_s`
--
ALTER TABLE `k-t_s`
  MODIFY `id_sv` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `k_l`
--
ALTER TABLE `k_l`
  MODIFY `idk_l` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `l-ts`
--
ALTER TABLE `l-ts`
  MODIFY `ids` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz`
--
ALTER TABLE `tz`
  MODIFY `idz` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
