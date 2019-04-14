-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Хост: mysql5.activeby.net
-- Время создания: Апр 13 2019 г., 15:18
-- Версия сервера: 5.5.52
-- Версия PHP: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `user2031505_meta`
--

-- --------------------------------------------------------

--
-- Структура таблицы `k-tn`
--

CREATE TABLE IF NOT EXISTS `k-tn` (
  `idn` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `vr` int(11) NOT NULL,
  `ses` varchar(32) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`idn`),
  KEY `vr` (`vr`),
  KEY `ses` (`ses`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Наборы на кириллице' AUTO_INCREMENT=579297 ;

-- --------------------------------------------------------

--
-- Структура таблицы `k-ts`
--

CREATE TABLE IF NOT EXISTS `k-ts` (
  `ids` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `s` varchar(60) COLLATE utf8mb4_bin NOT NULL,
  `kol` mediumint(8) unsigned NOT NULL COMMENT 'Количество',
  `f` tinyint(3) unsigned NOT NULL COMMENT 'Состояние',
  PRIMARY KEY (`ids`),
  UNIQUE KEY `s` (`s`),
  KEY `f` (`f`),
  KEY `kol` (`kol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Слова на кириллице' AUTO_INCREMENT=9440798 ;

-- --------------------------------------------------------

--
-- Структура таблицы `k-t_s`
--

CREATE TABLE IF NOT EXISTS `k-t_s` (
  `id_sv` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_n` int(10) unsigned zerofill NOT NULL,
  `id_s` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id_sv`),
  UNIQUE KEY `sost` (`id_n`,`id_s`),
  KEY `id_s` (`id_s`),
  KEY `id_n` (`id_n`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Связи для кириллицы' AUTO_INCREMENT=9243366 ;

-- --------------------------------------------------------

--
-- Структура таблицы `k_l`
--

CREATE TABLE IF NOT EXISTS `k_l` (
  `idk_l` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `idk` int(10) unsigned zerofill NOT NULL COMMENT 'На русском',
  `idl` int(10) unsigned zerofill NOT NULL COMMENT 'На английском',
  `idz` int(10) unsigned zerofill NOT NULL COMMENT 'Номера значений',
  PRIMARY KEY (`idk_l`),
  KEY `idk` (`idk`),
  KEY `idl` (`idl`),
  KEY `idz` (`idz`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=33803 ;

-- --------------------------------------------------------

--
-- Структура таблицы `l-ts`
--

CREATE TABLE IF NOT EXISTS `l-ts` (
  `ids` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `s` varchar(60) COLLATE utf8mb4_bin NOT NULL,
  `f` tinyint(3) unsigned NOT NULL COMMENT 'Состояние',
  PRIMARY KEY (`ids`),
  UNIQUE KEY `s` (`s`),
  KEY `f` (`f`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Слова на латинице' AUTO_INCREMENT=278941 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tyrki`
--

CREATE TABLE IF NOT EXISTS `tyrki` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `lori` int(10) unsigned zerofill NOT NULL COMMENT 'Номер страницы',
  `f` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tz`
--

CREATE TABLE IF NOT EXISTS `tz` (
  `idz` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `z` varchar(191) COLLATE utf8mb4_bin NOT NULL COMMENT 'Значение слова',
  PRIMARY KEY (`idz`),
  UNIQUE KEY `z` (`z`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=33809 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
