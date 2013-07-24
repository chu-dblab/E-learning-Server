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

/**
 * 前置設定
 * 
 * @since	Version 1
*/
$ROOT_FILE = "./";	//根目錄的位置
$DB_INFO_URL = $ROOT_FILE."config/db_config.php"; 	//設定檔的位置
// ------------------------------------------------------------------------

/**
 * sql_connect
 *
 * 連結資料庫
 *
 * @access	public
 * @return	object	
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
 */
function sql_connect(){
	global $DB_INFO_URL;
	require_once($DB_INFO_URL); //取得連結資料庫連結變數
	
	$db = mysql_connect($DB_SERV,$DB_USER,$DB_PASS) or die( "<h1>無法連結資料庫</h1>".sql_getErrMsg() );	//連結資料庫
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
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
 */
function sql_getFormName($inputName){
	global $DB_INFO_URL;
	require_once($DB_INFO_URL); //取得連結資料庫連結變數
	
	return $FORM_PREFIX + $inputName;
 }
// ------------------------------------------------------------------------

/**
 * sql_close
 *
 * 關閉資料庫
 *
 * @access	public
 * @param	object	資料庫物件
 * @return	bool	是否關閉成功
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
 */
function sql_close($db){
	if(!mysql_close($db)){	//如果關閉失敗
		if($DEV_DEGUG){ print sql_getErrMsg(); }
		return false;
	}
	else{	//如果關閉成功
		return true;
	}
}

/**
 * sql_getErrMsg
 *
 * 錯誤訊息
 * 配合or die使用，如: mysql_connect("localhost", "user", "passwd") or die( sql_getErrMsg() );
 *
 * @access	private
 * @return	string	錯誤訊息
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
 */

function sql_getErrMsg(){
	//取得連結資料庫連結變數
	require_once($ROOT_FILE."config/dev_config.php");
	
	//輸出錯誤資訊
	if($DEV_DEGUG == true){
		return "<p>SQL Debug: <br />".mysql_error()."</p>";
	}
	else{
		return null;
	}
}
