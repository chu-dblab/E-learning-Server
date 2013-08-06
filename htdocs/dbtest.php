<?php
/**
 * 前置設定
*/
require_once("lib/include.php");
require_once(DOCUMENT_ROOT."config/db_config.php"); //取得連結資料庫連結變數
require_once(DOCUMENT_ROOT."lib/DatabaseClass.php");

try {
	$db_connect = new Database();
	
	echo "成功";
} catch (PDOException $e){
	echo "Fail: ".$e;
}


echo "<h1>Finish</h1>";