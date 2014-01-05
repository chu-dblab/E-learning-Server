CREATE TABLE chu_group(
  GID varchar(30) NOT NULL,
  GName varchar(15) NOT NULL,
  Gauth_Admin tinyint(1) NOT NULL DEFAULT '0',
  Gauth_ClientAdmin tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (GID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群組';

CREATE TABLE chu_user(
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
  FOREIGN KEY (GID) REFERENCES chu_group (GID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者';

CREATE TABLE chu_target(
  TID int(10) unsigned NOT NULL,
  MapID varchar(20) unsigned NOT NULL COMMENT '地圖編號',
  MaterialID varchar(20) unsigned NOT NULL COMMENT '教材編號',
  TName varchar(15) NOT NULL COMMENT '標的名稱',
  TLearn_Time int(10) unsigned NOT NULL COMMENT '預估此標的應該學習的時間',
  PLj int(200) unsigned NOT NULL COMMENT '學習標的的人數限制',
  Mj int(200) unsigned default NULL COMMENT '目前人數',
  S float unsigned default NULL COMMENT '學習標的飽和率上限',
  Fj tinyint(1) default NULL COMMENT '學習標的滿額指標',
  PRIMARY KEY (TID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的';

CREATE TABLE chu_theme(
  ThemeID int(10) unsigned NOT NULL,
  ThemeName varchar(15) NOT NULL,
  theme_Learn_DateTime datetime NOT NULL COMMENT '本次學習此主題發生的日期時間',
  Theme_LearnTotal int(10) unsigned NOT NULL COMMENT '學習此主題要花的總時間(m)',
  Theme_Introduction varchar(70) NOT NULL,
  PRIMARY KEY (ThemeID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主題';

CREATE TABLE chu_study(
  TID int(10) unsigned NOT NULL,
  UID varchar(30) NOT NULL COMMENT '使用者帳號',
  In_TargetTime datetime NOT NULL,
  Out_TargetTime datetime default NULL,
  PRIMARY KEY (TID,UID),
  FOREIGN KEY (TID) REFERENCES chu_target (TID),
  FOREIGN KEY (UID) REFERENCES chu_user (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者與標的間study';

CREATE TABLE chu_recommend(
  TID int(10) unsigned NOT NULL,
  UID varchar(30) NOT NULL COMMENT '使用者帳號',
  gradation int(50) unsigned NOT NULL COMMENT '系統推薦標地順序',
  PRIMARY KEY (TID,UID),
  FOREIGN KEY (TID) REFERENCES chu_target (TID),
  FOREIGN KEY (UID) REFERENCES chu_user (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='推薦';

CREATE TABLE chu_belong(
  TID int(10) unsigned NOT NULL,
  ThemeID int(10) unsigned NOT NULL,
  Weights float NOT NULL COMMENT '當次學習主題的某一個學習標的之權重',
  PRIMARY KEY (TID,ThemeID),
  FOREIGN KEY (TID) REFERENCES chu_target (TID),
  FOREIGN KEY (ThemeID) REFERENCES chu_theme(ThemeID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和主題之間';

CREATE TABLE chu_edge(
  Ti int(10) unsigned NOT NULL,
  Tj int(10) unsigned NOT NULL,
  MoveTime varchar(20) NOT NULL COMMENT '移動時間(分鐘)',
  Distance varchar(20) NOT NULL COMMENT '距離(M)',
  PRIMARY KEY (Ti,Tj),
  FOREIGN KEY (Ti) REFERENCES chu_target (TID),
  FOREIGN KEY (Tj) REFERENCES chu_target (TID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和標的之間';

CREATE TABLE chu_question(
	QID varchar(5) PRIMARY KEY NOT NULL,
	TID int(10) unsigned NOT NULL,
	Cnumber int(10) unsigned COMMENT '答對次數',
	Wnumber int(10) unsigned COMMENT '答錯次數',
	FOREIGN KEY (TID) REFERENCES chu_target (TID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='題目';
