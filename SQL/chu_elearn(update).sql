-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主機: localhost
-- 建立日期: Jan 25, 2014, 03:32 PM
-- 伺服器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 資料庫: `chu_elearn`
-- 

-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_belong`
-- 

CREATE TABLE `chu_belong` (
  `TID` int(10) unsigned NOT NULL,
  `ThemeID` varchar(10) NOT NULL default '0',
  `Weights` float NOT NULL COMMENT '當次學習主題的某一個學習標的之權重',
  PRIMARY KEY  (`TID`,`ThemeID`),
  KEY `ThemeID` (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和主題之間';

-- 
-- 列出以下資料庫的數據： `chu_belong`
-- 

INSERT INTO `chu_belong` VALUES (1, 'T1', 10);
INSERT INTO `chu_belong` VALUES (1, 'T2', 10);
INSERT INTO `chu_belong` VALUES (1, 'T3', 10);
INSERT INTO `chu_belong` VALUES (1, 'T4', 10);
INSERT INTO `chu_belong` VALUES (2, 'T1', 10);
INSERT INTO `chu_belong` VALUES (2, 'T2', 10);
INSERT INTO `chu_belong` VALUES (2, 'T3', 10);
INSERT INTO `chu_belong` VALUES (2, 'T4', 10);
INSERT INTO `chu_belong` VALUES (3, 'T1', 2);
INSERT INTO `chu_belong` VALUES (3, 'T2', 2);
INSERT INTO `chu_belong` VALUES (3, 'T3', 2);
INSERT INTO `chu_belong` VALUES (3, 'T4', 2);
INSERT INTO `chu_belong` VALUES (4, 'T1', 4);
INSERT INTO `chu_belong` VALUES (4, 'T5', 4);
INSERT INTO `chu_belong` VALUES (4, 'T6', 4);
INSERT INTO `chu_belong` VALUES (4, 'T7', 4);
INSERT INTO `chu_belong` VALUES (5, 'T1', 4);
INSERT INTO `chu_belong` VALUES (5, 'T5', 4);
INSERT INTO `chu_belong` VALUES (5, 'T6', 4);
INSERT INTO `chu_belong` VALUES (5, 'T7', 4);
INSERT INTO `chu_belong` VALUES (6, 'T2', 7);
INSERT INTO `chu_belong` VALUES (6, 'T5', 7);
INSERT INTO `chu_belong` VALUES (6, 'T8', 7);
INSERT INTO `chu_belong` VALUES (6, 'T9', 7);
INSERT INTO `chu_belong` VALUES (7, 'T2', 5);
INSERT INTO `chu_belong` VALUES (7, 'T5', 5);
INSERT INTO `chu_belong` VALUES (7, 'T8', 5);
INSERT INTO `chu_belong` VALUES (7, 'T9', 5);
INSERT INTO `chu_belong` VALUES (8, 'T2', 4);
INSERT INTO `chu_belong` VALUES (8, 'T5', 4);
INSERT INTO `chu_belong` VALUES (8, 'T8', 4);
INSERT INTO `chu_belong` VALUES (8, 'T9', 4);
INSERT INTO `chu_belong` VALUES (9, 'T2', 6);
INSERT INTO `chu_belong` VALUES (9, 'T5', 6);
INSERT INTO `chu_belong` VALUES (9, 'T8', 6);
INSERT INTO `chu_belong` VALUES (9, 'T9', 6);
INSERT INTO `chu_belong` VALUES (10, 'T2', 8);
INSERT INTO `chu_belong` VALUES (10, 'T5', 8);
INSERT INTO `chu_belong` VALUES (10, 'T8', 8);
INSERT INTO `chu_belong` VALUES (10, 'T9', 8);
INSERT INTO `chu_belong` VALUES (11, 'T10', 10);
INSERT INTO `chu_belong` VALUES (11, 'T3', 10);
INSERT INTO `chu_belong` VALUES (11, 'T6', 10);
INSERT INTO `chu_belong` VALUES (11, 'T8', 10);
INSERT INTO `chu_belong` VALUES (12, 'T10', 5);
INSERT INTO `chu_belong` VALUES (12, 'T4', 5);
INSERT INTO `chu_belong` VALUES (12, 'T7', 5);
INSERT INTO `chu_belong` VALUES (12, 'T9', 5);
INSERT INTO `chu_belong` VALUES (13, 'T10', 5);
INSERT INTO `chu_belong` VALUES (13, 'T4', 5);
INSERT INTO `chu_belong` VALUES (13, 'T7', 5);
INSERT INTO `chu_belong` VALUES (13, 'T9', 5);
INSERT INTO `chu_belong` VALUES (14, 'T10', 2);
INSERT INTO `chu_belong` VALUES (14, 'T4', 2);
INSERT INTO `chu_belong` VALUES (14, 'T7', 2);
INSERT INTO `chu_belong` VALUES (14, 'T9', 2);
INSERT INTO `chu_belong` VALUES (15, 'T10', 6);
INSERT INTO `chu_belong` VALUES (15, 'T4', 6);
INSERT INTO `chu_belong` VALUES (15, 'T7', 6);
INSERT INTO `chu_belong` VALUES (15, 'T9', 6);

-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_edge`
-- 

CREATE TABLE `chu_edge` (
  `Ti` int(10) unsigned NOT NULL,
  `Tj` int(10) unsigned NOT NULL,
  `MoveTime` varchar(20) NOT NULL COMMENT '移動時間(分鐘)',
  `Distance` varchar(20) NOT NULL COMMENT '距離(M)',
  PRIMARY KEY  (`Ti`,`Tj`),
  KEY `Tj` (`Tj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和標的之間';

-- 
-- 列出以下資料庫的數據： `chu_edge`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_group`
-- 

CREATE TABLE `chu_group` (
  `GID` varchar(30) NOT NULL,
  `GName` varchar(15) NOT NULL,
  `Gauth_Admin` tinyint(1) NOT NULL default '0',
  `Gauth_ClientAdmin` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群組';

-- 
-- 列出以下資料庫的數據： `chu_group`
-- 

INSERT INTO `chu_group` VALUES ('admin', '管理者', 1, 0);
INSERT INTO `chu_group` VALUES ('user', '使用者', 0, 0);

-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_question`
-- 

CREATE TABLE `chu_question` (
  `QID` varchar(5) NOT NULL,
  `TID` int(10) unsigned NOT NULL,
  `Cnumber` int(10) unsigned default NULL COMMENT '答對次數',
  `Wnumber` int(10) unsigned default NULL COMMENT '答錯次數',
  PRIMARY KEY  (`QID`),
  KEY `TID` (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='題目';

-- 
-- 列出以下資料庫的數據： `chu_question`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_recommend`
-- 

CREATE TABLE `chu_recommend` (
  `TID` int(10) unsigned NOT NULL,
  `UID` varchar(30) NOT NULL COMMENT '使用者帳號',
  `gradation` int(50) unsigned NOT NULL COMMENT '系統推薦標地順序',
  PRIMARY KEY  (`TID`,`UID`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='推薦';

-- 
-- 列出以下資料庫的數據： `chu_recommend`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_study`
-- 

CREATE TABLE `chu_study` (
  `TID` int(10) unsigned NOT NULL,
  `UID` varchar(30) NOT NULL COMMENT '使用者帳號',
  `In_TargetTime` datetime NOT NULL,
  `Out_TargetTime` datetime default NULL,
  PRIMARY KEY  (`TID`,`UID`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者與標的間study';

-- 
-- 列出以下資料庫的數據： `chu_study`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_target`
-- 

CREATE TABLE `chu_target` (
  `TID` int(10) unsigned NOT NULL,
  `MapID` varchar(20) NOT NULL COMMENT '地圖編號',
  `MaterialID` varchar(20) NOT NULL COMMENT '教材編號',
  `TName` varchar(15) NOT NULL COMMENT '標的名稱',
  `TLearn_Time` int(10) unsigned NOT NULL COMMENT '預估此標的應該學習的時間',
  `PLj` int(200) unsigned NOT NULL COMMENT '學習標的的人數限制',
  `Mj` int(200) unsigned default NULL COMMENT '目前人數',
  `S` float unsigned default NULL COMMENT '學習標的飽和率上限',
  `Fj` tinyint(1) default NULL COMMENT '學習標的滿額指標',
  PRIMARY KEY  (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的';

-- 
-- 列出以下資料庫的數據： `chu_target`
-- 

INSERT INTO `chu_target` VALUES (0, '1F.gif', '', '入口', 1, 100, 0, 0.6, 0);
INSERT INTO `chu_target` VALUES (1, 'map_01_02_03.png', '01.html', '含有生物遺跡的岩石', 7, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (2, 'map_01_02_03.png', '02.html', '岩石中的紀錄', 8, 2, 1, 0.6, 0);
INSERT INTO `chu_target` VALUES (3, 'map_01_02_03.png', '03.html', '生命在水中的演化', 3, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (4, 'map_04.jpg', '04.html', '最早的森林', 3, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (5, 'map_05.jpg', '05.html', '古代的兩棲類', 5, 2, 1, 0.6, 0);
INSERT INTO `chu_target` VALUES (6, 'map_06.jpg', '06.html', '恐龍時代', 6, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (7, 'map_07.jpg', '07.html', '蒙古的恐龍', 4, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (8, 'map_08.jpg', '08.html', '恐龍再現', 4, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (9, 'map_09.jpg', '09.html', '竊蛋龍', 4, 2, 1, 0.6, 0);
INSERT INTO `chu_target` VALUES (10, 'map_10.jpg', '10.html', '巨龍的腳印', 4, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (11, 'map_11.jpg', '11.html', '始祖鳥與帶有羽毛的恐龍', 8, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (12, 'map_12.jpg', '12.html', '阿法南猿', 4, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (13, 'map_13.jpg', '13.html', '探索人類的過去', 5, 1, 1, 0.6, 0);
INSERT INTO `chu_target` VALUES (14, 'map_14.jpg', '14.html', '周口店北京人', 3, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (15, 'map_15.jpg', '15.html', '木乃伊', 8, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (16, 'map_01_02_03.png', '16.html', '含有生物遺跡的岩石', 7, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (17, 'map_01_02_03.png', '17.html', '岩石中的紀錄', 8, 2, 1, 0.6, 0);
INSERT INTO `chu_target` VALUES (18, 'map_01_02_03.png', '18.html', '生命在水中的演化', 3, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (19, 'map_04.jpg', '19.html', '最早的森林', 3, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (20, 'map_05.jpg', '20.html', '古代的兩棲類', 5, 2, 1, 0.6, 0);
INSERT INTO `chu_target` VALUES (21, 'map_06.jpg', '21.html', '恐龍時代', 6, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (22, 'map_07.jpg', '22.html', '蒙古的恐龍', 4, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (23, 'map_08.jpg', '23.html', '恐龍再現', 4, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (24, 'map_09.jpg', '24.html', '竊蛋龍', 4, 2, 1, 0.6, 0);
INSERT INTO `chu_target` VALUES (25, 'map_10.jpg', '25.html', '巨龍的腳印', 4, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (26, 'map_11.jpg', '26.html', '始祖鳥與帶有羽毛的恐龍', 8, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (27, 'map_12.jpg', '27.html', '阿法南猿', 4, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (28, 'map_13.jpg', '28.html', '探索人類的過去', 5, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (29, 'map_14.jpg', '29.html', '周口店北京人', 3, 2, 2, 0.6, 0);
INSERT INTO `chu_target` VALUES (30, 'map_15.jpg', '30.html', '木乃伊', 8, 2, 2, 0.6, 0);

-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_theme`
-- 

CREATE TABLE `chu_theme` (
  `ThemeID` varchar(10) NOT NULL,
  `ThemeName` varchar(15) NOT NULL,
  `theme_Learn_DateTime` datetime NOT NULL COMMENT '本次學習此主題發生的日期時間',
  `Theme_LearnTotal` int(10) unsigned NOT NULL COMMENT '學習此主題要花的總時間(m)',
  `Theme_Introduction` varchar(70) NOT NULL,
  PRIMARY KEY  (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主題';

-- 
-- 列出以下資料庫的數據： `chu_theme`
-- 

INSERT INTO `chu_theme` VALUES ('T1', '生命的起源+生命登上陸地', '2014-01-31 23:01:21', 40, '生命的起源+生命登上陸地');
INSERT INTO `chu_theme` VALUES ('T10', '生命征服天空+人類的過去', '2014-01-15 23:11:46', 40, '生命征服天空+人類的過去');
INSERT INTO `chu_theme` VALUES ('T2', '生命的起源+恐龍時代', '2014-01-25 23:00:44', 40, '生命的起源+恐龍時代');
INSERT INTO `chu_theme` VALUES ('T3', '生命的起源+生命征服天空', '2014-01-23 23:08:33', 40, '生命的起源+生命征服天空');
INSERT INTO `chu_theme` VALUES ('T4', '生命的起源+人類的過去', '2014-01-07 23:08:59', 40, '生命的起源+人類的過去');
INSERT INTO `chu_theme` VALUES ('T5', '生命登上陸地+恐龍時代', '2014-01-04 23:09:49', 40, '生命登上陸地+恐龍時代');
INSERT INTO `chu_theme` VALUES ('T6', '生命登上陸地+生命征服天空', '2014-02-19 23:09:59', 40, '生命登上陸地+生命征服天空');
INSERT INTO `chu_theme` VALUES ('T7', '生命登上陸地+人類的過去', '2014-05-28 23:10:26', 40, '生命登上陸地+人類的過去');
INSERT INTO `chu_theme` VALUES ('T8', '恐龍時代+生命征服天空', '2014-07-30 23:10:57', 40, '恐龍時代+生命征服天空');
INSERT INTO `chu_theme` VALUES ('T9', '恐龍時代+人類的過去', '2014-01-06 23:11:23', 40, '恐龍時代+人類的過去');

-- --------------------------------------------------------

-- 
-- 資料表格式： `chu_user`
-- 

CREATE TABLE `chu_user` (
  `UID` varchar(30) NOT NULL COMMENT '使用者帳號',
  `GID` varchar(30) NOT NULL COMMENT '使用者群組',
  `UPassword` varchar(40) NOT NULL COMMENT '密碼',
  `ULogged_code` varchar(32) default NULL COMMENT '登入碼',
  `ULast_In_Time` timestamp NULL default NULL COMMENT '最後登入時間',
  `UBuild_Time` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '帳號建立時間',
  `UEnabled` tinyint(1) NOT NULL default '1' COMMENT '帳號啟用狀態',
  `In_Learn_Time` datetime NOT NULL COMMENT '開始學習時間',
  `UReal_Name` varchar(20) default NULL COMMENT '真實姓名',
  `UNickname` varchar(20) default NULL COMMENT '使用者暱稱',
  `UEmail` varchar(50) default NULL COMMENT '使用者email',
  PRIMARY KEY  (`UID`),
  KEY `GID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者';

-- 
-- 列出以下資料庫的數據： `chu_user`
-- 

INSERT INTO `chu_user` VALUES ('root', 'admin', '63a9f0ea7bb98050796b649e854818', NULL, NULL, '2013-08-20 14:58:38', 1, '0000-00-00 00:00:00', '', '', '');

-- 
-- 備份資料表限制
-- 

-- 
-- 資料表限制 `chu_belong`
-- 
ALTER TABLE `chu_belong`
  ADD CONSTRAINT `chu_belong_ibfk_2` FOREIGN KEY (`ThemeID`) REFERENCES `chu_theme` (`ThemeID`),
  ADD CONSTRAINT `chu_belong_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`);

-- 
-- 資料表限制 `chu_edge`
-- 
ALTER TABLE `chu_edge`
  ADD CONSTRAINT `chu_edge_ibfk_1` FOREIGN KEY (`Ti`) REFERENCES `chu_target` (`TID`),
  ADD CONSTRAINT `chu_edge_ibfk_2` FOREIGN KEY (`Tj`) REFERENCES `chu_target` (`TID`);

-- 
-- 資料表限制 `chu_question`
-- 
ALTER TABLE `chu_question`
  ADD CONSTRAINT `chu_question_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`);

-- 
-- 資料表限制 `chu_recommend`
-- 
ALTER TABLE `chu_recommend`
  ADD CONSTRAINT `chu_recommend_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`),
  ADD CONSTRAINT `chu_recommend_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `chu_user` (`UID`);

-- 
-- 資料表限制 `chu_study`
-- 
ALTER TABLE `chu_study`
  ADD CONSTRAINT `chu_study_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`),
  ADD CONSTRAINT `chu_study_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `chu_user` (`UID`);

-- 
-- 資料表限制 `chu_user`
-- 
ALTER TABLE `chu_user`
  ADD CONSTRAINT `chu_user_ibfk_1` FOREIGN KEY (`GID`) REFERENCES `chu_group` (`GID`);
