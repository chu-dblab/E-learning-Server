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
	global $FORM_USER;
	$userpasswd = encryptText($userpasswd);
	
	//查詢使用者登入資訊
	$db = sql_connect();	//開啟資料庫
	
	$db_user_query = mysql_query("SELECT `username`,`password`,`isActive` FROM ".sql_getFormName($FORM_USER)." WHERE `username` = '$userid'") or die(sql_getErrMsg());
	//若有找到使用者
	if(mysql_num_rows($db_user_query) >= 1){
		//檢查這個帳戶是否已啟用
		if( mysql_result($db_user_query, 0, isActive) ){
			//核對密碼正確
			if( $userpasswd == mysql_result($db_user_query, 0, password) ){
				
				//符合登入條件
				
				//亂數產生登入驗證碼
				$login_verify = generatorText(32);
				
				//取得現在時間，用字串的形式
				$nowDate = date("Y-m-d H:i:s");
				
				//登記新的登入碼和登入時間進資料庫
				mysql_query("UPDATE ".sql_getFormName($FORM_USER)." 
					SET `logged_code` = '".$login_verify."', `last_login`  = '$nowDate' 
					WHERE `username` = '$userid'") or die(sql_getErrMsg());
				
				
				//回傳使用者登入碼
				return $login_verify;
				
			}
			//密碼錯誤
			else{
				sql_close($db);	//關閉資料庫
				return "PasswdErr";
			}
		}
		else{
			return "NoActiveErr";
		}
		
	}
	//若沒有這個使用者
	else{
		sql_close($db);	//關閉資料庫
		return "UsernameErr";
	}
	
	sql_close($db);	//關閉資料庫
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

function user_logout($loginCode){
	global $FORM_USER;
	
	//連結資料庫
	$db = sql_connect();	

	$db_user_query = mysql_query("SELECT `username` FROM ".sql_getFormName($FORM_USER)." WHERE `logged_code` = '$loginCode'") or die(sql_getErrMsg());
	//若有找到
	if(mysql_num_rows($db_user_query) >= 1){
		//清除登入碼和登入時間進資料庫
		mysql_query("UPDATE ".sql_getFormName($FORM_USER)." 
			SET `logged_code` = '' 
			WHERE `logged_code` = '$loginCode'") or die(sql_getErrMsg()
		);
			
		sql_close($db);	//關閉資料庫
		
		return true;	//傳回登出成功
	}
	else{
		return false;	//傳回登出失敗
	}
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
	$db_table = mysql_query("SELECT `ID`, `username`, `logged_code`, `last_login`, `isActive`, `name`, `nickname`, `email` FROM ".sql_getFormName($FORM_USER)) or die(sql_getErrMsg());
	return $db_table;
}