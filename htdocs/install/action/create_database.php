<?php
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
$create_txt_content .= "\$DB_SERV = '$inputSQLHost'\t//資料庫伺服器名稱\n";
$create_txt_content .= "\$DB_USER = '$inputSQLUser'\t//資料庫使用者名稱\n";
$create_txt_content .= "\$DB_PASS = '$inputSQLPass'\t//資料庫使用者密碼\n";
$create_txt_content .= "\$DB_NAME = '$inputSQLDBName'\t//指定要使用哪個資料庫\n";
$create_txt_content .= "\$FORM_PREFIX = '$inputSQLDBFormPrefix'\t//資料表的前綴字元";

if($fp=fopen("../../config/db_config.php","w+")){
	fputs($fp,$create_txt_content);
	unset($_SESSION["install_db_config_code"]);
}
else{
	$_SESSION["install_db_config_code"] = $create_txt_content;
}
fclose($fp);

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