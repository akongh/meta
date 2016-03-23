-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Ноя 17 2014 г., 19:35
-- Версия сервера: 5.5.30-30.2-log
-- Версия PHP: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `webart_200slov`
--

-- --------------------------------------------------------

--
-- Структура таблицы `k-tn`
--

CREATE TABLE IF NOT EXISTS `k-tn` (
  `idn` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `vr` bigint(12) NOT NULL,
  `ses` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idn`),
  KEY `vr` (`vr`),
  KEY `ses` (`ses`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Наборы на кириллице' AUTO_INCREMENT=377172 ;

-- --------------------------------------------------------

--
-- Структура таблицы `k-ts`
--

CREATE TABLE IF NOT EXISTS `k-ts` (
  `ids` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `s` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `kol` mediumint(8) unsigned NOT NULL COMMENT 'Количество',
  `f` tinyint(3) unsigned NOT NULL COMMENT 'Состояние',
  PRIMARY KEY (`ids`),
  UNIQUE KEY `s` (`s`),
  KEY `f` (`f`),
  KEY `kol` (`kol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Слова на кириллице' AUTO_INCREMENT=5959642 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Связи для кириллицы' AUTO_INCREMENT=5948934 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4918 ;

-- --------------------------------------------------------

--
-- Структура таблицы `l-tn`
--

CREATE TABLE IF NOT EXISTS `l-tn` (
  `idn` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `vr` bigint(12) NOT NULL,
  `ses` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idn`),
  KEY `vr` (`vr`),
  KEY `ses` (`ses`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Наборы на латинице' AUTO_INCREMENT=4533 ;

-- --------------------------------------------------------

--
-- Структура таблицы `l-ts`
--

CREATE TABLE IF NOT EXISTS `l-ts` (
  `ids` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `s` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `s` (`s`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Слова на латинице' AUTO_INCREMENT=54241 ;

-- --------------------------------------------------------

--
-- Структура таблицы `l-t_s`
--

CREATE TABLE IF NOT EXISTS `l-t_s` (
  `id_sv` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_n` int(10) unsigned zerofill NOT NULL,
  `id_s` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id_sv`),
  UNIQUE KEY `sost` (`id_n`,`id_s`),
  KEY `id_s` (`id_s`),
  KEY `id_n` (`id_n`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Связи для латиницы' AUTO_INCREMENT=48623 ;

-- --------------------------------------------------------

--
-- Структура таблицы `p`
--

CREATE TABLE IF NOT EXISTS `p` (
  `ids` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `s` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `kol` mediumint(8) unsigned NOT NULL COMMENT 'Количество',
  `f` tinyint(3) unsigned NOT NULL COMMENT 'Состояние',
  PRIMARY KEY (`ids`),
  UNIQUE KEY `s` (`s`),
  KEY `f` (`f`),
  KEY `kol` (`kol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Слова на кириллице' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tyrki`
--

CREATE TABLE IF NOT EXISTS `tyrki` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `lori` int(10) unsigned zerofill NOT NULL COMMENT 'Номер страницы',
  `fotolia` int(10) unsigned zerofill NOT NULL COMMENT 'Номер страницы',
  `f` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tz`
--

CREATE TABLE IF NOT EXISTS `tz` (
  `idz` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `z` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Значение слова',
  PRIMARY KEY (`idz`),
  UNIQUE KEY `z` (`z`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4922 ;

-- --------------------------------------------------------

--
-- Структура таблицы `zp`
--

CREATE TABLE IF NOT EXISTS `zp` (
  `idzp` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `op` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `f` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`idzp`),
  UNIQUE KEY `zp` (`op`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
