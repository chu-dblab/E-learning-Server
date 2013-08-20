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

-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_belong`
-- 

CREATE TABLE `chu_belong` (
  `TID` int(10) unsigned NOT NULL,
  `ThemeID` int(10) unsigned NOT NULL,
  `Weights` float NOT NULL COMMENT '當次學習主題的某一個學習標的之權重',
  UNIQUE KEY `TID` (`TID`),
  UNIQUE KEY `ThemeID` (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_belong`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_edge`
-- 

CREATE TABLE `chu_edge` (
  `Ti` int(10) unsigned NOT NULL,
  `Tj` int(10) unsigned NOT NULL,
  `MoveTime` varchar(20) NOT NULL COMMENT '移動時間(分鐘)',
  `Distance` varchar(20) NOT NULL COMMENT '距離(M)',
  UNIQUE KEY `Ti` (`Ti`),
  UNIQUE KEY `Tj` (`Tj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和標的之間 資料表';

-- 
-- 列出以下資料庫的數據： `chu_edge`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_group`
-- 

CREATE TABLE `chu_group` (
  `GID` int(10) unsigned NOT NULL,
  `GName` varchar(15) NOT NULL,
  `GCompetence` varchar(10) NOT NULL,
  PRIMARY KEY  (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_group`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_question`
-- 

CREATE TABLE `chu_question` (
  `QID` int(10) unsigned NOT NULL,
  `QA` varchar(10) NOT NULL,
  `Q_Url` varchar(50) NOT NULL,
  `TID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`QID`),
  UNIQUE KEY `TID` (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_question`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_recommend`
-- 

CREATE TABLE `chu_recommend` (
  `TID` int(10) unsigned NOT NULL,
  `UID` int(10) unsigned NOT NULL,
  `Order` int(10) unsigned NOT NULL COMMENT '系統推薦標地順序',
  UNIQUE KEY `TID` (`TID`,`UID`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_recommend`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_study`
-- 

CREATE TABLE `chu_study` (
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
-- 列出以下資料庫的數據： `chu_study`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_target`
-- 

CREATE TABLE `chu_target` (
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
  `PLj` int(11) unsigned NOT NULL COMMENT '學習標的人數限制',
  `Mj` int(11) unsigned default NULL COMMENT '目前人數',
  PRIMARY KEY  (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_target`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_theme`
-- 

CREATE TABLE `chu_theme` (
  `ThemeID` int(10) unsigned NOT NULL,
  `ThemeName` varchar(15) NOT NULL,
  `theme_Learn_DateTime` datetime NOT NULL COMMENT '本次學習此主題發生的日期時間',
  `Theme_LearnTotal` int(10) unsigned NOT NULL COMMENT '學習此主題要花的總時間(hr)',
  `Theme_Introduction` varchar(70) NOT NULL,
  PRIMARY KEY  (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_theme`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_user`
-- 

CREATE TABLE `chu_user` (
  `UID` int(10) unsigned NOT NULL COMMENT 'S#',
  `UPassword` varchar(30) NOT NULL COMMENT '密碼',
  `UName` varchar(20) NOT NULL COMMENT '使用者名稱',
  `UReal_Name` varchar(20) NOT NULL COMMENT '真實名稱',
  `ULogged_no` varchar(40) default NULL,
  `UAccount_no` varchar(20) NOT NULL COMMENT '帳號',
  `ULast_In_Time` datetime default NULL,
  `UNickname` varchar(20) default NULL COMMENT '使用者暱稱',
  `UEmail` varchar(50) NOT NULL,
  `UBuild_Time` datetime NOT NULL COMMENT '帳號建立時間',
  `UEnabled` varchar(10) NOT NULL COMMENT '帳號啟用狀態',
  `In_Learn_Time` datetime NOT NULL,
  `GID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`UID`),
  KEY `GID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_user`
-- 


-- 
-- 備份資料表限制
-- 

-- 
-- 資料表限制 `chu_belong`
-- 
ALTER TABLE `chu_belong`
  ADD CONSTRAINT `chu_belong_ibfk_2` FOREIGN KEY (`ThemeID`) REFERENCES `chu_theme` (`ThemeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chu_belong_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_edge`
-- 
ALTER TABLE `chu_edge`
  ADD CONSTRAINT `chu_edge_ibfk_2` FOREIGN KEY (`Tj`) REFERENCES `chu_target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chu_edge_ibfk_1` FOREIGN KEY (`Ti`) REFERENCES `chu_target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_question`
-- 
ALTER TABLE `chu_question`
  ADD CONSTRAINT `chu_question_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_recommend`
-- 
ALTER TABLE `chu_recommend`
  ADD CONSTRAINT `chu_recommend_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `chu_user` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chu_recommend_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_study`
-- 
ALTER TABLE `chu_study`
  ADD CONSTRAINT `chu_study_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `chu_user` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chu_study_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_user`
-- 
ALTER TABLE `chu_user`
  ADD CONSTRAINT `chu_user_ibfk_1` FOREIGN KEY (`GID`) REFERENCES `chu_group` (`GID`) ON DELETE CASCADE ON UPDATE CASCADE;
