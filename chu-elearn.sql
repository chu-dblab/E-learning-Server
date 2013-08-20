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
  `chu_TID` int(10) unsigned NOT NULL,
  `chu_ThemeID` int(10) unsigned NOT NULL,
  `chu_Weights` float NOT NULL COMMENT '當次學習主題的某一個學習標的之權重',
  UNIQUE KEY `chu_TID` (`chu_TID`),
  UNIQUE KEY `chu_ThemeID` (`chu_ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_belong`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_edge`
-- 

CREATE TABLE `chu_edge` (
  `chu_Ti` int(10) unsigned NOT NULL,
  `chu_Tj` int(10) unsigned NOT NULL,
  `chu_MoveTime` varchar(20) NOT NULL COMMENT '移動時間(分鐘)',
  `chu_Distance` varchar(20) NOT NULL COMMENT '距離(M)',
  UNIQUE KEY `chu_Ti` (`chu_Ti`),
  UNIQUE KEY `chu_Tj` (`chu_Tj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和標的之間 資料表';

-- 
-- 列出以下資料庫的數據： `chu_edge`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_group`
-- 

CREATE TABLE `chu_group` (
  `chu_GID` int(10) unsigned NOT NULL,
  `chu_GName` varchar(15) NOT NULL,
  `chu_GCompetence` varchar(10) NOT NULL,
  PRIMARY KEY  (`chu_GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_group`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_question`
-- 

CREATE TABLE `chu_question` (
  `chu_QID` int(10) unsigned NOT NULL,
  `chu_QA` varchar(10) NOT NULL,
  `chu_Q_Url` varchar(50) NOT NULL,
  `chu_TID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`chu_QID`),
  UNIQUE KEY `chu_TID` (`chu_TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_question`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_recommend`
-- 

CREATE TABLE `chu_recommend` (
  `chu_TID` int(10) unsigned NOT NULL,
  `chu_UID` int(10) unsigned NOT NULL,
  `chu_Order` int(10) unsigned NOT NULL COMMENT '系統推薦標地順序',
  UNIQUE KEY `chu_TID` (`chu_TID`,`chu_UID`),
  KEY `chu_UID` (`chu_UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_recommend`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_study`
-- 

CREATE TABLE `chu_study` (
  `chu_TID` int(10) unsigned NOT NULL,
  `chu_UID` int(10) unsigned NOT NULL,
  `chu_QID` int(10) unsigned default NULL,
  `chu_Answer` varchar(5) default NULL COMMENT '答題對錯 Y=對 N=錯',
  `chu_Answer_Time` varchar(10) default NULL COMMENT '作答時間',
  `chu_In_TargetTime` datetime NOT NULL,
  `chu_Out_TargetTime` datetime default NULL,
  `chu_TCheck` varchar(5) NOT NULL COMMENT '有無正確到推薦點',
  UNIQUE KEY `TID` (`chu_TID`),
  UNIQUE KEY `SID` (`chu_UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_study`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_target`
-- 

CREATE TABLE `chu_target` (
  `chu_TID` int(10) unsigned NOT NULL,
  `chu_TName` varchar(15) NOT NULL,
  `chu_TLearn_Time` int(10) unsigned NOT NULL,
  `chu_MapID` int(10) unsigned NOT NULL,
  `chu_Map_Url` varchar(50) NOT NULL,
  `chu_FloorName` varchar(50) NOT NULL,
  `chu_BlockName` varchar(50) NOT NULL,
  `chu_BlockMap` varchar(50) NOT NULL,
  `chu_CourseName` varchar(50) NOT NULL,
  `chu_MaterialID` int(10) unsigned NOT NULL,
  `chu_Material_Url` varchar(50) NOT NULL,
  `chu_PLj` int(11) unsigned NOT NULL COMMENT '學習標的人數限制',
  `chu_Mj` int(11) unsigned default NULL COMMENT '目前人數',
  PRIMARY KEY  (`chu_TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_target`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_theme`
-- 

CREATE TABLE `chu_theme` (
  `chu_ThemeID` int(10) unsigned NOT NULL,
  `chu_ThemeName` varchar(15) NOT NULL,
  `chu_theme_Learn_DateTime` datetime NOT NULL COMMENT '本次學習此主題發生的日期時間',
  `chu_Theme_LearnTotal` int(10) unsigned NOT NULL COMMENT '學習此主題要花的總時間(hr)',
  `chu_Theme_Introduction` varchar(70) NOT NULL,
  PRIMARY KEY  (`chu_ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- 列出以下資料庫的數據： `chu_theme`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_user`
-- 

CREATE TABLE `chu_user` (
  `chu_UID` int(10) unsigned NOT NULL COMMENT 'S#',
  `chu_UPassword` varchar(30) NOT NULL COMMENT '密碼',
  `chu_UName` varchar(20) NOT NULL COMMENT '使用者名稱',
  `chu_UReal_Name` varchar(20) NOT NULL COMMENT '真實名稱',
  `chu_ULogged_no` varchar(40) default NULL,
  `chu_UAccount_no` varchar(20) NOT NULL COMMENT '帳號',
  `chu_ULast_In_Time` datetime default NULL,
  `chu_UNickname` varchar(20) default NULL COMMENT '使用者暱稱',
  `chu_UEmail` varchar(50) NOT NULL,
  `chu_UBuild_Time` datetime NOT NULL COMMENT '帳號建立時間',
  `chu_UEnabled` varchar(10) NOT NULL COMMENT '帳號啟用狀態',
  `chu_In_Learn_Time` datetime NOT NULL,
  `chu_GID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`chu_UID`),
  KEY `GID` (`chu_GID`)
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
  ADD CONSTRAINT `chu_belong_ibfk_2` FOREIGN KEY (`chu_ThemeID`) REFERENCES `chu_theme` (`chu_ThemeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chu_belong_ibfk_1` FOREIGN KEY (`chu_TID`) REFERENCES `chu_target` (`chu_TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_edge`
-- 
ALTER TABLE `chu_edge`
  ADD CONSTRAINT `chu_edge_ibfk_2` FOREIGN KEY (`chu_Tj`) REFERENCES `chu_target` (`chu_TID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chu_edge_ibfk_1` FOREIGN KEY (`chu_Ti`) REFERENCES `chu_target` (`chu_TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_question`
-- 
ALTER TABLE `chu_question`
  ADD CONSTRAINT `chu_question_ibfk_1` FOREIGN KEY (`chu_TID`) REFERENCES `chu_target` (`chu_TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_recommend`
-- 
ALTER TABLE `chu_recommend`
  ADD CONSTRAINT `chu_recommend_ibfk_2` FOREIGN KEY (`chu_UID`) REFERENCES `chu_user` (`chu_UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chu_recommend_ibfk_1` FOREIGN KEY (`chu_TID`) REFERENCES `chu_target` (`chu_TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_study`
-- 
ALTER TABLE `chu_study`
  ADD CONSTRAINT `chu_study_ibfk_2` FOREIGN KEY (`chu_UID`) REFERENCES `chu_user` (`chu_UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chu_study_ibfk_1` FOREIGN KEY (`chu_TID`) REFERENCES `chu_target` (`chu_TID`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- 資料表限制 `chu_user`
-- 
ALTER TABLE `chu_user`
  ADD CONSTRAINT `chu_user_ibfk_1` FOREIGN KEY (`chu_GID`) REFERENCES `chu_group` (`chu_GID`) ON DELETE CASCADE ON UPDATE CASCADE;
