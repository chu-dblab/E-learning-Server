<?php
echo "s";
// 取得使用者輸入過的資料
$inputSQLHost = $_SESSION["install_inputSQLHost"];
$inputSQLUser = $_SESSION["install_inputSQLUser"];
$inputSQLPass = $_SESSION["install_inputSQLPass"];
$inputSQLDBName = $_SESSION["install_inputSQLDBName"];
$inputSQLDBFormPrefix = $_SESSION["install_inputSQLDBFormPrefix"];

// 資料庫設定檔建立
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

// 資料庫連結
//連結資料庫
$db = mysql_connect($inputSQLHost,$inputSQLUser,$inputSQLPass) or die(mysql_error());
//設定編碼成UTF-8
mysql_query("SET NAMES UTF8") or die(mysql_error());
//建立資料庫
mysql_query("CREATE DATABASE IF NOT EXISTS `$inputSQLDBName` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci") or die(mysql_error());
//指定這個資料庫
mysql_select_db($inputSQLDBName,$db);

// 建立資料表
//mysql_query("") or die(mysql_error());
//".$inputSQLDBFormPrefix."


mysql_query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'") or die(mysql_error());
mysql_query("SET time_zone = '+00:00'") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."group(
  GID varchar(30) NOT NULL,
  GName varchar(15) NOT NULL,
  Gauth_Admin tinyint(1) NOT NULL DEFAULT '0',
  Gauth_ClientAdmin tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (GID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群組'") or die(mysql_error());


mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."group
VALUES ('admin', '管理者', 1, 1)") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."group
VALUES ('user', '使用者', 0, 0)") or die(mysql_error());

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
  MapID int(10) unsigned NOT NULL COMMENT '地圖編號',
  MaterialID int(10) unsigned NOT NULL COMMENT '教材編號',
  TName varchar(15) NOT NULL COMMENT '標的名稱',
  TLearn_Time int(10) unsigned NOT NULL COMMENT '預估此標的應該學習的時間',
  PLj int(200) unsigned NOT NULL COMMENT '學習標的的人數限制',
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
  In_TargetTime datetime NOT NULL,
  Out_TargetTime datetime default NULL,
  PRIMARY KEY (TID,UID),
  FOREIGN KEY (TID) REFERENCES ".$inputSQLDBFormPrefix."target (TID),
  FOREIGN KEY (UID) REFERENCES ".$inputSQLDBFormPrefix."user (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者與標的間study'") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."recommend(
  TID int(10) unsigned NOT NULL,
  UID varchar(30) NOT NULL COMMENT '使用者帳號',
  gradation int(50) unsigned NOT NULL COMMENT '系統推薦標地順序',
  PRIMARY KEY (TID,UID),
  FOREIGN KEY (TID) REFERENCES ".$inputSQLDBFormPrefix."target (TID),
  FOREIGN KEY (UID) REFERENCES ".$inputSQLDBFormPrefix."user (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='推薦'") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."belong(
  TID int(10) unsigned NOT NULL,
  ThemeID int(10) unsigned NOT NULL,
  Weights float NOT NULL COMMENT '當次學習主題的某一個學習標的之權重',
  PRIMARY KEY (TID,ThemeID),
  FOREIGN KEY (TID) REFERENCES ".$inputSQLDBFormPrefix."target (TID),
  FOREIGN KEY (ThemeID) REFERENCES ".$inputSQLDBFormPrefix."theme(ThemeID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和主題之間'") or die(mysql_error());

mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."edge(
  Ti int(10) unsigned NOT NULL,
  Tj int(10) unsigned NOT NULL,
  MoveTime varchar(20) NOT NULL COMMENT '移動時間(分鐘)',
  Distance varchar(20) NOT NULL COMMENT '距離(M)',
  PRIMARY KEY (Ti,Tj),
  FOREIGN KEY (Ti) REFERENCES ".$inputSQLDBFormPrefix."target (TID),
  FOREIGN KEY (Tj) REFERENCES ".$inputSQLDBFormPrefix."target (TID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和標的之間'") or die(mysql_error());


mysql_query("CREATE TABLE ".$inputSQLDBFormPrefix."question(
	QID varchar(5) PRIMARY KEY NOT NULL,
	TID int(10) unsigned NOT NULL,
	Cnumber int(10) unsigned COMMENT '答對次數',
	Wnumber int(10) unsigned COMMENT '答錯次數',
	FOREIGN KEY (TID) REFERENCES ".$inputSQLDBFormPrefix."target (TID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='題目'") or die(mysql_error());

// ==================================================================================

/*mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('01', 'map_01_02_03.png', '01.html', '含有生物遺跡的岩石','7', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('02', 'map_01_02_03.png', '02.html', '岩石中的紀錄','8', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('03', 'map_01_02_03.png', '03.html', '生命在水中的演化','3', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('04', 'map_04.jpg', '04.html', '最早的森林','3', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('05', 'map_05.jpg', '05.html', '古代的兩棲類','5', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('06', 'map_06.jpg', '06.html', '恐龍時代','6', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('07', 'map_07.jpg', '07.html', '蒙古的恐龍','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('08', 'map_08.jpg', '08.html', '恐龍再現','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('09', 'map_09.jpg', '09.html', '竊蛋龍','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('10', 'map_10.jpg', '10.html', '巨龍的腳印','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('11', 'map_11.jpg', '11.html', '始祖鳥與帶有羽毛的恐龍','8', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('12', 'map_12.jpg', '12.html', '阿法南猿','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('13', 'map_13.jpg', '13.html', '探索人類的過去','5', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('14', 'map_14.jpg', '14.html', '周口店北京人','3', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('15', 'map_15.jpg', '15.html', '木乃伊','8', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('16', 'map_01_02_03.png', '16.html', '含有生物遺跡的岩石','7', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('17', 'map_01_02_03.png', '17.html', '岩石中的紀錄','8', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('18', 'map_01_02_03.png', '18.html', '生命在水中的演化','3', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('19', 'map_04.jpg', '19.html', '最早的森林','3', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('20', 'map_05.jpg', '20.html', '古代的兩棲類','5', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('21', 'map_06.jpg', '21.html', '恐龍時代','6', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('22', 'map_07.jpg', '22.html', '蒙古的恐龍','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('23', 'map_08.jpg', '23.html', '恐龍再現','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('24', 'map_09.jpg', '24.html', '竊蛋龍','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('25', 'map_10.jpg', '25.html', '巨龍的腳印','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('26', 'map_11.jpg', '26.html', '始祖鳥與帶有羽毛的恐龍','8', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('27', 'map_12.jpg', '27.html', '阿法南猿','4', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('28', 'map_13.jpg', '28.html', '探索人類的過去','5', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('29', 'map_14.jpg', '29', '周口店北京人','3', '100', '0', '0.6', '0')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."target
VALUES ('30', 'map_15.jpg', '30', '木乃伊','8', '100', '0', '0.6', '0')") or die(mysql_error());

// ==================================================================================

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('01', '', '10')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('02', '', '10')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('03', '', '2')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('04', '', '4')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('05', '', '4')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('06', '', '7')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('07', '', '5')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('08', '', '4')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('09', '', '6')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('10', '', '8')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('11', '', '10')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('12', '', '5')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('13', '', '5')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('14', '', '2')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('15', '', '6')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('16', '', '10')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('17', '', '10')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('18', '', '2')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('19', '', '4')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('20', '', '4')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('21', '', '7')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('22', '', '5')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('23', '', '4')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('24', '', '6')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('25', '', '8')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('26', '', '10')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('27', '', '5')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('28', '', '5')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('29', '', '2')") or die(mysql_error());

mysql_query("INSERT
INTO ".$inputSQLDBFormPrefix."belong
VALUES ('30', '', '6')") or die(mysql_error());
*/