<?php
// 前置作業
require_once(DOCUMENT_ROOT."lib/function/user.php");
require_once(DOCUMENT_ROOT."lib/class/MyUser.php");

/**
 * 登入使用者帳號
 *
 * @access public
 * @param string $userid 帳號
 * @param string $userpasswd 密碼
 * @return string 
 *          使用者登入碼
 *          <ul>
 *            <li>"NoActiveErr": 帳號未啟用</li>
 *            <li>"PasswdErr": 密碼錯誤</li>
 *            <li>"NoFound": 找不到存在的使用者</li>
 *            <li>"DBErr": 資料庫寫入錯誤</li>
 *          </ul>
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 1
 *
*/
function web_userLogin($userid, $userpasswd) {
	global $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT;
	$loginCode = user_login($userid, $userpasswd);
	
	//當使用者登入成功的話
	if( $loginCode!="NoActiveErr" && $loginCode!="PasswdErr" && $loginCode!="DBErr" && $loginCode!="NoFound"){
		//設定cookies到使用者瀏覽器
		setcookie($COOKIES_PREFIX."userLoginCode", $loginCode, time() + $COOKIES_LOGIN_TIMEOUT, "/");
	}
	return $loginCode;
}
// ------------------------------------------------------------------------

/**
 * 登出使用者帳號
 * 
 * @access public
 * @return bool 是否成功登出
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 1
*/
function web_userLogout() {
	global $COOKIES_PREFIX;
	
	if( isset($_COOKIE[$COOKIES_PREFIX."userLoginCode"]) ) {
		$theUserLoginCode = $_COOKIE[$COOKIES_PREFIX."userLoginCode"];
		
		$theUser = new MyUser($theUserLoginCode);
	
		if( $result = $theUser->logout() ) {
			setcookie($COOKIES_PREFIX."userLoginCode", "", time()-3600, "/");
			
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

// ========================================================================

/**
 * 取得目前登入的使用者物件
 * 
 * @access public
 * @return object 使用者物件
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 1
*/
function web_isLogged() {
	global $COOKIES_PREFIX;
	
	if( isset($_COOKIE[$COOKIES_PREFIX."userLoginCode"]) ) {
		$theUserLoginCode = $_COOKIE[$COOKIES_PREFIX."userLoginCode"];
		
		$theUser = new MyUser($theUserLoginCode);
		
		if( $theUser->isLogged() ) {
			return true;
		} else {
			return false;
		}
		
	} else {
		return false;
	}
}
// ------------------------------------------------------------------------

/**
 * 取得目前登入的使用者物件
 * 
 * @access public
 * @return object 使用者物件
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 1
*/
function web_getLoggedUser() {
	global $COOKIES_PREFIX;
	if( isset($_COOKIE[$COOKIES_PREFIX."userLoginCode"]) ) {
		$theUserLoginCode = $_COOKIE[$COOKIES_PREFIX."userLoginCode"];
		
		$theUser = new MyUser($theUserLoginCode);
		
		if( $theUser->isLogged() ) {
			return $theUser;
		} else {
			return null;
		}
		
	} else {
		return null;
	}
}