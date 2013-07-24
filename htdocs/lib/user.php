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

require_once(DOCUMENT_ROOT."lib/sql.php");
require_once(DOCUMENT_ROOT."lib/password.php"); //取得連結資料庫連結變數
$FORM_USER = "users";	//使用者帳號資料表

// ------------------------------------------------------------------------

/**
 * user_create
 *
 * 建立使用者帳號
 *
 * @access	public
 * @param	string	帳號
 * @param	string	密碼
 * @return	bool	是否有成功建立
 * 
 * @since	Version 0
 */
function user_create(){
	
}

// ------------------------------------------------------------------------

/**
 * user_login
 *
 * 登入使用者帳號
 *
 * @access	public
 * @param	string	帳號
 * @param	string	密碼
 * @return	string	使用者登入碼
 * 
 * @since	Version 0
 */

function user_login($userid, $userpasswd){
	
}

/**
 * user_logout
 *
 * 登出使用者帳號
 *
 * @access	public
 * @param	string	登入碼
 * @return	bool	是否登出成功
 * 
 * @since	Version 0
 */

function user_logout(){
	
}

/**
 * user_queryAll
 *
 * 查詢使用者帳號
 *
 * @access	public
 * @param	object	資料庫
 * @return	object	mysql_query的查詢結果
 * 
 * @since	Version 0
 */
function user_queryAll($db){
	global $DEV_DEGUG, $FORM_USER;
	$db_table = mysql_query("SELECT `ID`, `username`, `isActive`, `name`, `nickname`, `email` FROM ".sql_getFormName($FORM_USER)) or die(sql_getErrMsg());
	return $db_table;
}