<?php
/**
 * 取得使用者輸入過的資料
*/
$inputSQLHost = $_SESSION["install_inputSQLHost"];
$inputSQLUser = $_SESSION["install_inputSQLUser"];
$inputSQLPass = $_SESSION["install_inputSQLPass"];
$inputSQLDBName = $_SESSION["install_inputSQLDBName"];
$inputSQLDBFormPrefix = $_SESSION["install_inputSQLDBFormPrefix"];

//連結資料庫
$db = mysql_connect($inputSQLHost,$inputSQLUser,$inputSQLPass) or die(mysql_error());
//建立資料庫
mysql_query("CREATE DATABASE IF NOT EXISTS `$inputSQLDBName` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci") or die(mysql_error());
//指定這個資料庫
mysql_select_db($inputSQLDBName,$db);

/**
 * 建立資料表
*/

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."users` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `".$inputSQLDBFormPrefix."user_groups` (
  `ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2") or die(mysql_error());

mysql_query("INSERT INTO `".$inputSQLDBFormPrefix."user_groups` (`ID`, `name`, `admin`) VALUES
(1, 'admin', 1);") or die(mysql_error());

mysql_query("ALTER TABLE `".$inputSQLDBFormPrefix."users`
  ADD CONSTRAINT `".$inputSQLDBFormPrefix."users_ibfk_1` FOREIGN KEY (`group`) REFERENCES `".$inputSQLDBFormPrefix."user_groups` (`ID`)") or die(mysql_error());