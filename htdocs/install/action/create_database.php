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
//設定編碼成UTF-8
mysql_query("SET NAMES UTF8") or die(mysql_error());
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

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."group(
  GID varchar(30) NOT NULL,
  GName varchar(15) NOT NULL,
  Gauth_admin tinyint(1) NOT NULL default '0',
  GCompetence varchar(10) NOT NULL,
  PRIMARY KEY (GID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群組'") or die(mysql_error());


mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."group
VALUES ('admin', '管理者', 1, '')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."group
VALUES ('user', '使用者', 0, '')") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."user(
  UID varchar(30) NOT NULL COMMENT '使用者帳號',
  GID varchar(30) NOT NULL COMMENT '使用者群組',
  UPassword varchar(40) NOT NULL COMMENT '密碼',
  ULogged_code varchar(32) default NULL COMMENT '登入碼',
  ULast_In_Time timestamp NULL default NULL COMMENT '最後登入時間',
  UBuild_Time timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '帳號建立時間',
  UEnabled tinyint(1) NOT NULL default '1' COMMENT '帳號啟用狀態',
  In_Learn_Time datetime NOT NULL COMMENT '開始學習時間',
  UReal_Name varchar(20) default NULL COMMENT '真實姓名',
  UNickname varchar(20) default NULL COMMENT '使用者暱稱',
  UEmail varchar(50) default NULL COMMENT '使用者email',
  PRIMARY KEY (UID),
  FOREIGN KEY (GID) REFERENCES ".$inputSQLDBFormPrefix."group (GID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者'") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."target(
  TID int(10) unsigned NOT NULL,
  TName varchar(15) NOT NULL,
  TLearn_Time int(10) unsigned NOT NULL,
  MapID int(10) unsigned NOT NULL,
  Map_Url varchar(150) NOT NULL,
  FloorName varchar(50) NOT NULL,
  BlockName varchar(50) NOT NULL,
  BlockMap varchar(50) NOT NULL,
  MaterialID int(10) unsigned NOT NULL,
  Material_Url varchar(150) NOT NULL,
  PLj int(200) unsigned NOT NULL COMMENT '學習標的人數限制',
  Mj int(200) unsigned default NULL COMMENT '目前人數',
  S float unsigned default NULL COMMENT '學習標的飽和率上限',
  Fj tinyint(1) default NULL COMMENT '學習標的滿額指標',
  PRIMARY KEY (TID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的'") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."theme(
  ThemeID int(10) unsigned NOT NULL,
  ThemeName varchar(15) NOT NULL,
  theme_Learn_DateTime datetime NOT NULL COMMENT '本次學習此主題發生的日期時間',
  Theme_LearnTotal int(10) unsigned NOT NULL COMMENT '學習此主題要花的總時間(hr)',
  Theme_Introduction varchar(70) NOT NULL,
  PRIMARY KEY (ThemeID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主題'") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."study(
  TID int(10) unsigned NOT NULL,
  UID varchar(30) NOT NULL COMMENT '使用者帳號',
  QID int(10) unsigned default NULL,
  TCheck varchar(5) NOT NULL COMMENT '有無正確到推薦點',
  Answer varchar(5) default NULL COMMENT '答題對錯 Y=對 N=錯',
  Answer_Time varchar(10) default NULL COMMENT '作答時間',
  In_TargetTime datetime NOT NULL,
  Out_TargetTime datetime default NULL,
  PRIMARY KEY (TID,UID),
  FOREIGN KEY (TID) REFERENCES chu_target (TID),
  FOREIGN KEY (UID) REFERENCES chu_user (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者與標的間study'") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."recommend(
  TID int(10) unsigned NOT NULL,
  UID varchar(30) NOT NULL COMMENT '使用者帳號',
  gradation int(50) unsigned NOT NULL COMMENT '系統推薦標地順序',
  PRIMARY KEY (TID,UID),
  FOREIGN KEY (TID) REFERENCES chu_target (TID),
  FOREIGN KEY (UID) REFERENCES chu_user (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='推薦'") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."belong(
  TID int(10) unsigned NOT NULL,
  ThemeID int(10) unsigned NOT NULL,
  Weights float NOT NULL COMMENT '當次學習主題的某一個學習標的之權重',
  PRIMARY KEY (TID,ThemeID),
  FOREIGN KEY (TID) REFERENCES ".$inputSQLDBFormPrefix."target (TID),
  FOREIGN KEY (ThemeID) REFERENCES ".$inputSQLDBFormPrefix."theme(ThemeID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和主題之間';") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."edge(
  Ti int(10) unsigned NOT NULL,
  Tj int(10) unsigned NOT NULL,
  MoveTime varchar(20) NOT NULL COMMENT '移動時間(分鐘)',
  Distance varchar(20) NOT NULL COMMENT '距離(M)',
  PRIMARY KEY (Ti,Tj),
  FOREIGN KEY (Ti) REFERENCES ".$inputSQLDBFormPrefix."target (TID),
  FOREIGN KEY (Tj) REFERENCES ".$inputSQLDBFormPrefix."target (TID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和標的之間'") or die(mysql_error());
