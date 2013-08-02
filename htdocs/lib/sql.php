<?php
/**
 * E-learning
 *
 *
 * @package	CHU-E-learning
 * @author		CHU-TDAP
 * @copyright	
 * @license		type filter text
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
require_once(DOCUMENT_ROOT."config/dev_config.php"); //取得除錯參數
require_once(DOCUMENT_ROOT."config/db_config.php"); //取得連結資料庫連結變數
require_once(DOCUMENT_ROOT."lib/user.php");
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
	global $DB_SERV,$DB_USER,$DB_PASS,$DB_NAME;
	
	$db = mysql_connect($DB_SERV,$DB_USER,$DB_PASS) or die( "<h1>無法連結資料庫主機</h1>".sql_getErrMsg() );	//連結資料庫
	mysql_select_db($DB_NAME,$db) or die( "<h1>無法連結資料庫</h1>".sql_getErrMsg() ); //指定這個資料庫
	mysql_query("SET NAMES utf8");
	
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
	global $FORM_PREFIX;
	return $FORM_PREFIX.$inputName;
 }
// ------------------------------------------------------------------------

/**
 * sql_getTheUserQuery
 *
 * 查詢此使用者
 *
 * @access	public
 * @param	string	登入碼
 * @return	object	資料庫物件
 * 
 * @since	Version 0
 * @author	元兒～ <yuan817@moztw.org>
 */
function sql_getTheUserQuery($loggedCode){
	global $FORM_USER;
	//連結資料庫
	$db = sql_connect();
	
	//尋找登入碼
	$db_user_query = mysql_query("SELECT * FROM ".sql_getFormName($FORM_USER)." WHERE `logged_code` = '$loggedCode'") or die(sql_getErrMsg());
	
	//若有找到
	if(mysql_num_rows($db_user_query) >= 1){
		return $db_user_query;
	}
	else{
		return NULL;
	}
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
	global $DEV_DEGUG;
	//輸出錯誤資訊
	if($DEV_DEGUG == true){
		return "<p>SQL Debug: <br />".mysql_error()."</p>";
	}
	else{
		return null;
	}
}
