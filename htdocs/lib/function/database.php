<?php
require_once(DOCUMENT_ROOT."lib/class/Database.php");
require_once(DOCUMENT_ROOT."config/db_config.php"); //取得連結資料庫連結變數
require_once(DOCUMENT_ROOT."config/db_table_config.php");
require_once(DOCUMENT_ROOT."lib/create_txt/create_db_config.php");

function db_rename_db_name($newName) {
	//TODO 尚未顧慮資料庫權限問題
	global $FORM_PREFIX, $DB_NAME;
	global $FORM_USER, $FORM_USER_GROUP, $FORM_BELONG, $FORM_EDGE, $FORM_QUESTION, $FORM_RECOMMEND, $FORM_STUDY, $FORM_TARGET, $FORM_THEME;
	
	$db = new Database();
	$db->exec("CREATE DATABASE `".$newName."`");
	$db->exec("RENAME TABLE `".$DB_NAME."`.`".$FORM_PREFIX.$FORM_USER."` TO `".$newName."`.`".$FORM_PREFIX.$FORM_USER."`");
	$db->exec("RENAME TABLE `".$DB_NAME."`.`".$FORM_PREFIX.$FORM_USER_GROUP."` TO `".$newName."`.`".$FORM_PREFIX.$FORM_USER_GROUP."`");
	$db->exec("RENAME TABLE `".$DB_NAME."`.`".$FORM_PREFIX.$FORM_BELONG."` TO `".$newName."`.`".$FORM_PREFIX.$FORM_BELONG."`");
	$db->exec("RENAME TABLE `".$DB_NAME."`.`".$FORM_PREFIX.$FORM_EDGE."` TO `".$newName."`.`".$FORM_PREFIX.$FORM_EDGE."`");
	$db->exec("RENAME TABLE `".$DB_NAME."`.`".$FORM_PREFIX.$FORM_QUESTION."` TO `".$newName."`.`".$FORM_PREFIX.$FORM_QUESTION."`");
	$db->exec("RENAME TABLE `".$DB_NAME."`.`".$FORM_PREFIX.$FORM_RECOMMEND."` TO `".$newName."`.`".$FORM_PREFIX.$FORM_RECOMMEND."`");
	$db->exec("RENAME TABLE `".$DB_NAME."`.`".$FORM_PREFIX.$FORM_STUDY."` TO `".$newName."`.`".$FORM_PREFIX.$FORM_STUDY."`");
	$db->exec("RENAME TABLE `".$DB_NAME."`.`".$FORM_PREFIX.$FORM_TARGET."` TO `".$newName."`.`".$FORM_PREFIX.$FORM_TARGET."`");
	$db->exec("RENAME TABLE `".$DB_NAME."`.`".$FORM_PREFIX.$FORM_THEME."` TO `".$newName."`.`".$FORM_PREFIX.$FORM_THEME."`");
	$db->exec("DROP DATABASE`".$DB_NAME."`");
	
	
	//寫入新的設定檔
	global $DB_SERV, $DB_USER, $DB_PASS;
	$create_txt_content = create_config_txt_content($DB_SERV, $DB_USER, $DB_PASS, $newName, $FORM_PREFIX);
	if($fp=fopen(DOCUMENT_ROOT."config/db_config.php","w+")){
		fputs($fp,$create_txt_content);
		return "Finish";
	}
	else{
		return $create_txt_content;
	}
	fclose($fp);
}

function db_rename_prefix($newPrefix) {
	global $FORM_PREFIX;
	global $FORM_USER, $FORM_USER_GROUP, $FORM_BELONG, $FORM_EDGE, $FORM_QUESTION, $FORM_RECOMMEND, $FORM_STUDY, $FORM_TARGET, $FORM_THEME;
	
	//更改所有資料表名稱的前綴字元
	$db = new Database();
	$db->exec("RENAME TABLE `".$FORM_PREFIX.$FORM_USER."` TO `".$newPrefix.$FORM_USER."`");
	$db->exec("RENAME TABLE `".$FORM_PREFIX.$FORM_USER_GROUP."` TO `".$newPrefix.$FORM_USER_GROUP."`");
	$db->exec("RENAME TABLE `".$FORM_PREFIX.$FORM_BELONG."` TO `".$newPrefix.$FORM_BELONG."`");
	$db->exec("RENAME TABLE `".$FORM_PREFIX.$FORM_EDGE."` TO `".$newPrefix.$FORM_EDGE."`");
	$db->exec("RENAME TABLE `".$FORM_PREFIX.$FORM_QUESTION."` TO `".$newPrefix.$FORM_QUESTION."`");
	$db->exec("RENAME TABLE `".$FORM_PREFIX.$FORM_RECOMMEND."` TO `".$newPrefix.$FORM_RECOMMEND."`");
	$db->exec("RENAME TABLE `".$FORM_PREFIX.$FORM_STUDY."` TO `".$newPrefix.$FORM_STUDY."`");
	$db->exec("RENAME TABLE `".$FORM_PREFIX.$FORM_TARGET."` TO `".$newPrefix.$FORM_TARGET."`");
	$db->exec("RENAME TABLE `".$FORM_PREFIX.$FORM_THEME."` TO `".$newPrefix.$FORM_THEME."`");
	
	//寫入新的設定檔
	global $DB_SERV, $DB_USER, $DB_PASS, $DB_NAME;
	$create_txt_content = create_config_txt_content($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME, $newPrefix);
	if($fp=fopen(DOCUMENT_ROOT."config/db_config.php","w+")){
		fputs($fp,$create_txt_content);
		return "Finish";
	}
	else{
		return $create_txt_content;
	}
	fclose($fp);
}