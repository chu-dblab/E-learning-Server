<?php
echo "s";
/**
 * 取得使用者輸入過的資料
*/
$inputSQLHost = $_SESSION["install_inputSQLHost"];
$inputSQLUser = $_SESSION["install_inputSQLUser"];
$inputSQLPass = $_SESSION["install_inputSQLPass"];
$inputSQLDBName = $_SESSION["install_inputSQLDBName"];
$inputSQLDBFormPrefix = $_SESSION["install_inputSQLDBFormPrefix"];

/**
 * 資料庫設定檔建立
*/
$create_txt_content = "<?php\n";
$create_txt_content .= "\$DB_SERV = '$inputSQLHost';\t//資料庫伺服器名稱\n";
$create_txt_content .= "\$DB_USER = '$inputSQLUser';\t//資料庫使用者名稱\n";
$create_txt_content .= "\$DB_PASS = '$inputSQLPass';\t//資料庫使用者密碼\n";
$create_txt_content .= "\$DB_NAME = '$inputSQLDBName';\t//指定要使用哪個資料庫\n";
$create_txt_content .= "\$FORM_PREFIX = '$inputSQLDBFormPrefix';\t//資料表的前綴字元";

if($fp=fopen("../../config/db_config.php","w+")){
	fputs($fp,$create_txt_content);
	unset($_SESSION["install_db_config_code"]);
}
else{
	$_SESSION["install_db_config_code"] = $create_txt_content;
}
fclose($fp);

echo "db_config text created";

/**
 * 資料庫連結
*/
//連結資料庫
$db = mysql_connect($inputSQLHost,$inputSQLUser,$inputSQLPass) or die(mysql_error());
//建立資料庫
mysql_query("CREATE DATABASE IF NOT EXISTS `$inputSQLDBName` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci") or die(mysql_error());
//指定這個資料庫
mysql_select_db($inputSQLDBName,$db);

/**
 * 建立資料表
*/
//mysql_query("") or die(mysql_error());
//".$inputSQLDBFormPrefix."


mysql_query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'") or die(mysql_error());
mysql_query("SET time_zone = '+00:00'") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."belong` (
  `TID` int(10) unsigned NOT NULL,
  `ThemeID` int(10) unsigned NOT NULL,
  `Weights` float NOT NULL COMMENT '當次學習主題的某一個學習標的之權重',
  UNIQUE KEY `TID` (`TID`),
  UNIQUE KEY `ThemeID` (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die(mysql_error());


mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."edge` (
  `Ti` int(10) unsigned NOT NULL,
  `Tj` int(10) unsigned NOT NULL,
  `MoveTime` varchar(20) NOT NULL COMMENT '移動時間(分鐘)',
  `Distance` varchar(20) NOT NULL COMMENT '距離(M)',
  UNIQUE KEY `Ti` (`Ti`),
  UNIQUE KEY `Tj` (`Tj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和標的之間 資料表';") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."group` (
  `GID` varchar(30) NOT NULL,
  `GName` varchar(15) NOT NULL,
  `Gauth_admin` tinyint(1) NOT NULL DEFAULT '0',
  `GCompetence` varchar(10) NOT NULL,
  PRIMARY KEY (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die(mysql_error());

mysql_query("INSERT INTO `".$inputSQLDBFormPrefix."group` (`GID`, `GName`, `Gauth_admin`, `GCompetence`) VALUES
('admin', '管理者', 1, ''),
('user', '使用者', 0, '');") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."question` (
  `QID` int(10) unsigned NOT NULL,
  `QA` varchar(10) NOT NULL,
  `Q_Url` varchar(50) NOT NULL,
  `TID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`QID`),
  UNIQUE KEY `TID` (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."recommend` (
  `TID` int(10) unsigned NOT NULL,
  `UID` varchar(30) NOT NULL COMMENT 'S#',
  `Order` int(10) unsigned NOT NULL COMMENT '系統推薦標地順序',
  UNIQUE KEY `TID` (`TID`,`UID`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."study` (
  `TID` int(10) unsigned NOT NULL,
  `UID` varchar(30) NOT NULL COMMENT 'S#',
  `QID` int(10) unsigned DEFAULT NULL,
  `Answer` varchar(5) DEFAULT NULL COMMENT '答題對錯 Y=對 N=錯',
  `Answer_Time` varchar(10) DEFAULT NULL COMMENT '作答時間',
  `In_TargetTime` datetime NOT NULL,
  `Out_TargetTime` datetime DEFAULT NULL,
  `TCheck` varchar(5) NOT NULL COMMENT '有無正確到推薦點',
  UNIQUE KEY `TID` (`TID`),
  UNIQUE KEY `SID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."target` (
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
  `Mj` int(11) unsigned DEFAULT NULL COMMENT '目前人數',
  PRIMARY KEY (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."theme` (
  `ThemeID` int(10) unsigned NOT NULL,
  `ThemeName` varchar(15) NOT NULL,
  `theme_Learn_DateTime` datetime NOT NULL COMMENT '本次學習此主題發生的日期時間',
  `Theme_LearnTotal` int(10) unsigned NOT NULL COMMENT '學習此主題要花的總時間(hr)',
  `Theme_Introduction` varchar(70) NOT NULL,
  PRIMARY KEY (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."user` (
  `UID` varchar(30) NOT NULL COMMENT 'S#',
  `GID` varchar(30) NOT NULL COMMENT '使用者群組',
  `UPassword` varchar(40) NOT NULL COMMENT '密碼',
  `ULogged_code` varchar(32) DEFAULT NULL COMMENT '登入碼',
  `ULast_In_Time` timestamp NULL DEFAULT NULL COMMENT '最後登入時間',
  `UBuild_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '帳號建立時間',
  `UEnabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '帳號啟用狀態',
  `In_Learn_Time` datetime NOT NULL COMMENT '開始學習時間',
  `UReal_Name` varchar(20) DEFAULT NULL COMMENT '真實姓名',
  `UNickname` varchar(20) DEFAULT NULL COMMENT '使用者暱稱',
  `UEmail` varchar(50) DEFAULT NULL COMMENT '使用者email',
  PRIMARY KEY (`UID`),
  KEY `GID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die(mysql_error());

mysql_query("INSERT INTO `".$inputSQLDBFormPrefix."user` (`UID`, `GID`, `UPassword`, `ULogged_code`, `ULast_In_Time`, `UBuild_Time`, `UEnabled`, `In_Learn_Time`, `UReal_Name`, `UNickname`, `UEmail`) VALUES
('root', 'admin', '63a9f0ea7bb98050796b649e854818', NULL, NULL, '2013-08-20 14:58:38', 1, '0000-00-00 00:00:00', '', '', '');") or die(mysql_error());

mysql_query("ALTER TABLE `".$inputSQLDBFormPrefix."belong`
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."belong_ibfk_2` FOREIGN KEY (`ThemeID`) REFERENCES `".$inputSQLDBFormPrefix."theme` (`ThemeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."belong_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `".$inputSQLDBFormPrefix."target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;") or die(mysql_error());

mysql_query("ALTER TABLE `".$inputSQLDBFormPrefix."edge`
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."edge_ibfk_2` FOREIGN KEY (`Tj`) REFERENCES `".$inputSQLDBFormPrefix."target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."edge_ibfk_1` FOREIGN KEY (`Ti`) REFERENCES `".$inputSQLDBFormPrefix."target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;") or die(mysql_error());

mysql_query("ALTER TABLE `".$inputSQLDBFormPrefix."question`
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."question_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `".$inputSQLDBFormPrefix."target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;") or die(mysql_error());

mysql_query("ALTER TABLE `".$inputSQLDBFormPrefix."recommend`
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."recommend_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `".$inputSQLDBFormPrefix."user` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."recommend_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `".$inputSQLDBFormPrefix."target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;") or die(mysql_error());

mysql_query("ALTER TABLE `".$inputSQLDBFormPrefix."study`
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."study_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `".$inputSQLDBFormPrefix."user` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."study_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `".$inputSQLDBFormPrefix."target` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;") or die(mysql_error());

mysql_query("ALTER TABLE `".$inputSQLDBFormPrefix."user`
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."user_ibfk_1` FOREIGN KEY (`GID`) REFERENCES `".$inputSQLDBFormPrefix."group` (`GID`) ON DELETE CASCADE ON UPDATE CASCADE;") or die(mysql_error());

