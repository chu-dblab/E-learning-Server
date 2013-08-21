<?php
/**
 * 前置作業
*/
require_once(DOCUMENT_ROOT."lib/user.php");
require_once(DOCUMENT_ROOT."lib/UserClass.php");

/**
 * web_userLogin
 *
 * 登入使用者帳號
 *
 * @access	public
 * @param	string	帳號
 * @param	string	密碼
 * @return	string	使用者登入碼
			"NoActiveErr": 帳號未啟用
			"PasswdErr": 密碼錯誤
			"NoFound": 找不到存在的使用者
			"DBErr": 資料庫寫入錯誤
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 3
 *
*/
function web_userLogin($userid, $userpasswd) {
	global $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT;
	$loginCode = user_login($userid, $userpasswd);
	
	//當使用者登入成功的話
	if( $loginCode!="NoActiveErr" && $loginCode!="PasswdErr" && $loginCode!="DBErr" && $loginCode!="NoFound"){
		//設定cookies到使用者瀏覽器
		setcookie($COOKIES_PREFIX."userLoginCode", $loginCode, time() + $COOKIES_LOGIN_TIMEOUT);
	}
	return $loginCode;
}
/**
 *
 *
*/
function web_userLogout() {
	global $COOKIES_PREFIX;
	
	if( isset($_COOKIE[$COOKIES_PREFIX."userLoginCode"]) ) {
		$theUserLoginCode = $_COOKIE[$COOKIES_PREFIX."userLoginCode"];
		
		$theUser = new User($theUserLoginCode);
	
		if( $result = $theUser->logout() ) {
			setcookie($COOKIES_PREFIX."userLoginCode", "", time()-3600);
			
			return true;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
	
	
}