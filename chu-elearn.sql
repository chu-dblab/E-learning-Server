-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2013 年 08 月 02 日 15:16
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
-- 資料表格式： `belong`
-- 

CREATE TABLE `belong` (
  `TID` int(10) unsigned NOT NULL,
  `ThemeID` int(10) unsigned NOT NULL,
  `Weights` float NOT NULL COMMENT '當次學習主題的某一個學習標的之權重',
  UNIQUE KEY `TID` (`TID`),
  UNIQUE KEY `ThemeID` (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `belong`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `edge`
-- 

CREATE TABLE `edge` (
  `Ti` int(10) unsigned NOT NULL,
  `Tj` int(10) unsigned NOT NULL,
  `MoveTime` varchar(20) NOT NULL COMMENT '移動時間(分鐘)',
  `Distance` varchar(20) NOT NULL COMMENT '距離(M)',
  UNIQUE KEY `Ti` (`Ti`),
  UNIQUE KEY `Tj` (`Tj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和標的之間 資料表';

-- 
-- 列出以下資料庫的數據： `edge`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `group`
-- 

CREATE TABLE `group` (
  `GID` int(10) unsigned NOT NULL,
  `GName` varchar(15) NOT NULL,
  `GCompetence` varchar(10) NOT NULL,
  PRIMARY KEY  (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `group`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `question`
-- 

CREATE TABLE `question` (
  `QID` int(10) unsigned NOT NULL,
  `QA` varchar(10) NOT NULL,
  `Q_Url` varchar(50) NOT NULL,
  `TID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`QID`),
  UNIQUE KEY `TID` (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `question`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `recommend`
-- 

CREATE TABLE `recommend` (
  `TID` int(10) unsigned NOT NULL,
  `UID` int(10) unsigned NOT NULL,
  `Order` int(10) unsigned NOT NULL COMMENT '系統推薦標地順序',
  UNIQUE KEY `TID` (`TID`,`UID`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `recommend`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `study`
-- 

CREATE TABLE `study` (
  `TID` int(10) unsigned NOT NULL,
  `UID` int(10) unsigned NOT NULL,
  `QID` int(10) unsigned default NULL,
  `Answer` varchar(5) default NULL COMMENT '答題對錯 Y=對 N=錯',
  `Answer_Time` varchar(10) default NULL COMMENT '作答時間',
  `In_TargetTime` datetime NOT NULL,
  `Out_TargetTime` datetime default NULL,
  `TCheck` varchar(5) NOT NULL COMMENT '有無正確到推薦點',
  UNIQUE KEY `TID` (`TID`),
  UNIQUE KEY `SID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `study`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `target`
-- 

CREATE TABLE `target` (
  `TID` int(10) unsigned NOT NULL,
  `TName` varchar(15) NOT NULL,
  `TLearn_Time` int(10) unsigned NOT NULL,
  `MapID` int(10) unsigned NOT NULL,
  `Map_Url` varchar(50) NOT NULL,
  `FloorName` varchar(50) NOT NULL,
  `BlockName` varchar(50) NOT NULL,
  `BlockMap` varchar(50) NOT NULL,
  `CourseName` varchar(50) NOT NULL,
  `MaterialID` int(10) unsigned NOT NULL,
  `Material_Url` varchar(50) NOT NULL,
  `PLj` int(11) unsigned NOT NULL,
  `Mj` int(11) unsigned default NULL,
  PRIMARY KEY  (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `target`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `theme`
-- 

CREATE TABLE `theme` (
  `ThemeID` int(10) unsigned NOT NULL,
  `ThemeName` varchar(15) NOT NULL,
  `theme_Learn_DateTime` datetime NOT NULL COMMENT '本次學習此主題發生的日期時間',
  `Theme_LearnTotal` int(10) unsigned NOT NULL COMMENT '學習此主題要花的總時間(hr)',
  `Theme_Introduction` varchar(70) NOT NULL,
  PRIMARY KEY  (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `theme`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `user`
-- 

CREATE TABLE `user` (
  `UID` int(10) unsigned NOT NULL,
  `UPassword` varchar(30) NOT NULL,
  `UName` varchar(20) NOT NULL,
  `ULogged_no` varchar(40) default NULL,
  `In_Learn_Time` datetime NOT NULL,
  `GID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`UID`),
  KEY `GID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `user`
-- 


-- 
-- 備份資料表限制
-- 

-- 
-- 資料表限制 `belong`
-- 
ALTER TABLE `belong`
  ADD CONSTRAINT `belong_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `belong_ibfk_2` FOREIGN KEY (`ThemeID`) REFERENCES `theme` (`ThemeID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `edge`
-- 
ALTER TABLE `edge`
  ADD CONSTRAINT `edge_ibfk_1` FOREIGN KEY (`Ti`) REFERENCES `target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edge_ibfk_2` FOREIGN KEY (`Tj`) REFERENCES `target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `question`
-- 
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `recommend`
-- 
ALTER TABLE `recommend`
  ADD CONSTRAINT `recommend_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recommend_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `study`
-- 
ALTER TABLE `study`
  ADD CONSTRAINT `study_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `study_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `user`
-- 
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`GID`) REFERENCES `group` (`GID`) ON DELETE CASCADE ON UPDATE CASCADE;
