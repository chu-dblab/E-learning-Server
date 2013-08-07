<?php 
/**
 * 
*/
$INCLUDE_ROOT_FILE = dirname(__FILE__)."/../";	//根目錄的位置
require_once($INCLUDE_ROOT_FILE."config.php"); //取得網站根目錄位置

require_once(DOCUMENT_ROOT."config/dev_config.php"); //取得除錯參數
require_once(DOCUMENT_ROOT."config/db_config.php"); //取得連結資料庫連結變數
require_once(DOCUMENT_ROOT."config/db_table_config.php"); //取得資料表對應