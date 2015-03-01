-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Ned 01. bře 2015, 16:52
-- Verze MySQL: 5.1.60
-- Verze PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `gamedevfest`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `achievements`
--

CREATE TABLE IF NOT EXISTS `achievements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `location` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `nice_image` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `basic_image` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `congrats_text` varchar(500) COLLATE utf8_czech_ci NOT NULL,
  `unlocked_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `leaderboard`
--

CREATE TABLE IF NOT EXISTS `leaderboard` (
  `gplus_id` decimal(30,0) unsigned NOT NULL,
  `email` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  `user_name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `user_image` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_czech_ci DEFAULT NULL,
  `location` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `achievements_unlocked` int(11) NOT NULL DEFAULT '0',
  `unlocked_first` timestamp NULL DEFAULT NULL,
  `unlocked_last` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`gplus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `gplus_id` decimal(30,0) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `unlocked_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `org_email` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`gplus_id`,`achievement_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Spouště `log`
--
DROP TRIGGER IF EXISTS `trUpAchievementCount`;
DELIMITER //
CREATE TRIGGER `trUpAchievementCount` AFTER INSERT ON `log`
 FOR EACH ROW BEGIN
 UPDATE leaderboard
  SET achievements_unlocked = (achievements_unlocked + 1),
      unlocked_first = IF (unlocked_first IS NULL, NOW(), unlocked_first),
      unlocked_last = NOW()
  WHERE gplus_id = NEW.gplus_id;
 UPDATE achievements
  SET unlocked_count = (unlocked_count + 1)
  WHERE id = NEW.achievement_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabulky `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `key` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
