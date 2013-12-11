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
 * @since		Version 2.0
 * @filesource
*/

require_once(DOCUMENT_ROOT."lib/function/password.php");
require_once(DOCUMENT_ROOT."lib/function/userGroup.php");
require_once(DOCUMENT_ROOT."config/db_table_config.php");

// ========================================================================

/**
 * user_ishave
 *
 * 是否已有這個使用者
 *
 * @access	public
 * @param	string	帳號
 * @return	bool	是否已有這個使用者
 * 
 * @since	Version 3
*/
function user_ishave($username){
	global $FORM_USER;
	
	//資料庫連結
	$db = new Database();
	
	//資料庫查詢
	$db_user_query = $db->prepare("SELECT * FROM ".$db->table($FORM_USER)." WHERE `UID` = :username");
	$db_user_query->bindParam(":username",$username);
	$db_user_query->execute();
	
	//取得是否有此使用者
	//$result = ;
	if( $db_user_query->fetch() ) {
		//有找到使用者
		return true;
	}
	else {
		//無此使用者
		return false;
	}
}

// ------------------------------------------------------------------------

/**
 * user_create
 *
 * 建立使用者帳號
 *
 * @access	public
 * @param	string	帳號
 * @param	string	密碼
 * @param	string	確認密碼
 * @param	string	群組
 * @param	string	是否啟用
 * @param	string	姓名
 * @param	string	暱稱
 * @param	string	e-mail
 * @return	string	是否有成功建立
 *			"Finish": 成功建立
 *			"UsernameCreatedErr": 已有這個帳號
 *			"RepPasswdErr": 確認密碼錯誤
 *			"NoGroupErr": 沒有指定的群組
			"DBErr": 資料庫錯誤
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 3
*/
function user_create($username, $passwd, $group, $isActive, $name, $nickname, $email){
	global $FORM_USER;
	
	if(func_num_args() == 7){
		// 帶入參數
		$args = func_get_args();
		$username = $args[0];
		$passwd = $args[1];
		$group = $args[2];
		$isActive = $args[3];
		$name = $args[4];
		$nickname = $args[5];
		$email = $args[6];
		
		//將密碼加密
		$passwd = encryptText($passwd);
	}
	if(func_num_args() == 8){
		// 帶入參數
		$args = func_get_args();
		$username = $args[0];
		$passwd = $args[1];
		$encryptMode = $args[2];
		$group = $args[3];
		$isActive = $args[4];
		$name = $args[5];
		$nickname = $args[6];
		$email = $args[7];
		
		//將密碼加密
		$passwd = encryptText($passwd, $encryptMode);
	}
	
	// 動作
	//是否已有這個使用者
	if(user_ishave($username)){
		return "UsernameCreatedErr";
	}
	//檢查有無此群組
	else if( !userGroup_ishave($group) ){
		return "NoGroupErr";
	}
	//都沒有問題，新增帳號
	else{
		//開啟資料庫
		$db = new Database();
		
		//紀錄使用者帳號進資料庫
		$db_sqlString = "INSERT INTO ".$db->table($FORM_USER)." 
			(`UID` ,`GID` ,`UPassword` ,`UBuild_Time` ,`UEnabled` ,`UReal_Name` ,`UNickname` ,`UEmail`)
			VALUES (:username , :group , :passwd , NOW() , :isActive , :name , :nickname , :email)";
		$db_user_query = $db->prepare($db_sqlString);
		$db_user_query->bindParam(":username",$username);
		$db_user_query->bindParam(":group",$group);
		$db_user_query->bindParam(":passwd",$passwd);
		$db_user_query->bindParam(":isActive",$isActive);
		$db_user_query->bindParam(":name",$name);
		$db_user_query->bindParam(":nickname",$nickname);
		$db_user_query->bindParam(":email",$email);
		$db_user_query->execute();
		
		//判斷是否已加入狀況
		if( $db_user_query->rowCount() ) {
			//回傳成功訊息
			return "Finish";
		}
		else {
			return "DBErr";
		}
	}
	
	
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
			"NoActiveErr": 帳號未啟用
			"PasswdErr": 密碼錯誤
			"NoFound": 找不到存在的使用者
			"DBErr": 資料庫寫入錯誤
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 3
 *
*/

function user_login($userid, $userpasswd){
	global $FORM_USER;
	
	//將密碼加密
	$userpasswd = encryptText($userpasswd);
	
	//開啟資料庫
	$db = new Database();
	
	//查詢使用者登入資訊
	$db_user_query = $db->prepare("SELECT `UID`,`UPassword`,`UEnabled` FROM ".$db->table($FORM_USER)." WHERE `UID` = :username");
	$db_user_query->bindParam(":username",$userid);
	$db_user_query->execute();
	
	//若有找到使用者
	if( $db_user_array = $db_user_query->fetch() ) {
		//echo '<pre>', print_r($db_user_array, true), '</pre>';
		
		//若這個帳戶未啟用
		if( !$db_user_array['UEnabled'] ) {
			return "NoActiveErr";
		}
		//若密碼錯誤
		else if(  $userpasswd != $db_user_array['UPassword'] ) {
			return "PasswdErr";
		}
		//符合登入條件
		else{
			//亂數產生登入驗證碼
			$login_verify = generatorText(32);
			
			//登記新的登入碼和登入時間進資料庫
			$db_user_query = $db->prepare("UPDATE ".$db->table($FORM_USER)." SET `ULogged_code` = '".$login_verify."', `ULast_In_Time`  = NOW() WHERE `UID` = :username");
			$db_user_query->bindParam(":username",$userid);
			$db_user_query->execute();
			
			//判斷是否已加入狀況
			if( $db_user_query->rowCount() ) {
				//回傳使用者登入碼
				return $login_verify;
			} else {
				return "DBErr";
			}
			
		}
	}
	//若未找到使用者
	else {
		return "NoFound";
	}
}
// ------------------------------------------------------------------------

/**
 * user_isLoginEnable
 *
 * 此帳號是否可登入
 *
 * @access	public
 * @param	string	帳號
 * @param	string	密碼
 * @return	string	"OK": 可登入
			"NoActiveErr": 帳號未啟用
			"PasswdErr": 密碼錯誤
			"NoFound": 找不到存在的使用者
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 1
 *
*/

function user_isLoginEnable($userid, $userpasswd){
	global $FORM_USER;
	
	//將密碼加密
	$userpasswd = encryptText($userpasswd);
	
	//開啟資料庫
	$db = new Database();
	
	//查詢使用者登入資訊
	$db_user_query = $db->prepare("SELECT `UID`,`UPassword`,`UEnabled` FROM ".$db->table($FORM_USER)." WHERE `UID` = :username");
	$db_user_query->bindParam(":username",$userid);
	$db_user_query->execute();
	
	//若有找到使用者
	if( $db_user_array = $db_user_query->fetch() ) {
		//echo '<pre>', print_r($db_user_array, true), '</pre>';
		
		//若這個帳戶未啟用
		if( !$db_user_array['UEnabled'] ) {
			return "NoActiveErr";
		}
		//若密碼錯誤
		else if(  $userpasswd != $db_user_array['UPassword'] ) {
			return "PasswdErr";
		}
		//符合登入條件
		else{
			return "OK";
			
		}
	}
	//若未找到使用者
	else {
		return "NoFound";
	}
}