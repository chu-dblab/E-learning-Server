<?php
/**
 * E-learning
 *
 *
 * @package	CHU-E-learning
 * @author		CHU-TDAP
 * @copyright	
 * @license		
 * @link		https://github.com/CHU-TDAP/
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------
$ROOT_FILE = "./";	//根目錄的位置
$DB_INFO_URL = $ROOT_FILE+"config/db_config.php"; 	//設定檔的位置
// ------------------------------------------------------------------------

/**
 * sql_connect
 *
 * 連結資料庫
 *
 * @access	public
 * @return	object	
 */
function sql_connect(){
	global $DB_INFO_URL;
	require_once($DB_INFO_URL); //取得連結資料庫連結變數
	
	$db = mysql_connect($DB_SERV,$DB_USER,$DB_PASS) or die(mysql_error());	//連結資料庫
	
	mysql_select_db($DB_NAME,$db); //指定這個資料庫
	
	return $db;
}

// ------------------------------------------------------------------------
/**
 * getFormName
 *
 * 取得完整資料表名稱
 *
 * @access	public
 * @param	string	資料表名稱
 * @return	string	完整的資料表名稱
 */
 function getFormName($inputName){
	global $DB_INFO_URL;
	require_once($DB_INFO_URL); //取得連結資料庫連結變數
	
	return $FORM_PREFIX + $inputName;
 }

