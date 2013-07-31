-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2013 年 07 月 31 日 07:25
-- 伺服器版本: 5.5.32-MariaDB-log
-- PHP 版本: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `chu-elearn`
--
CREATE DATABASE IF NOT EXISTS `chu-elearn` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `chu-elearn`;

-- --------------------------------------------------------

--
-- 表的結構 `ce_users`
--

CREATE TABLE IF NOT EXISTS `ce_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` varchar(64) NOT NULL,
  `group` int(20) unsigned NOT NULL DEFAULT '1',
  `logged_code` varchar(32) DEFAULT NULL,
  `last_login_time` timestamp NULL DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(60) DEFAULT NULL,
  `nickname` varchar(60) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `group` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `ce_user_groups`
--

CREATE TABLE IF NOT EXISTS `ce_user_groups` (
  `ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `ce_user_groups`
--

INSERT INTO `ce_user_groups` (`ID`, `name`, `admin`) VALUES
(1, 'admin', 1),
(2, 'user', 0);

--
-- 匯出資料表的 Constraints
--

--
-- 資料表的 Constraints `ce_users`
--
ALTER TABLE `ce_users`
  ADD CONSTRAINT `ce_users_ibfk_1` FOREIGN KEY (`group`) REFERENCES `ce_user_groups` (`ID`);
