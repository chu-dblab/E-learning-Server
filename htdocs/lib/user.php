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
 * user_ishave
 *
 * 是否已有這個使用者
 *
 * @access	public
 * @param	string	帳號
 * @return	bool	是否已有這個使用者
 * 
 * @since	Version 0
*/
function user_ishave($username){
	global $FORM_USER;
	
	//查詢使用者登入資訊
	$db = sql_connect();	//開啟資料庫
	
	$db_user_query = mysql_query("SELECT `username` FROM ".sql_getFormName($FORM_USER)." WHERE `username` = '$username'") or die(sql_getErrMsg());
	
	if(mysql_num_rows($db_user_query) >= 1){
		return true;
	}
	else false;
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
 * 
 * @since	Version 1
*/
function user_create($username, $passwd, $passwd_rep, $group, $isActive, $name, $nickname, $email){
	global $FORM_USER;
	
	//是否已有這個使用者
	if(user_ishave($username)){
		return "UsernameCreatedErr";
	}
	//檢查有無此群組
	else if( !user_ishaveGroup($group) ){
		return "NoGroupErr";
	}
	//確認密碼錯誤
	else if($passwd != $passwd_rep) {
		return "RepPasswdErr";
	}
	//都沒有問題，新增帳號
	else{
		//開啟資料庫Finish
		$db = sql_connect();
		
		//將密碼加密
		$passwd = encryptText($passwd);
		
		//紀錄使用者帳號進資料庫
		mysql_query("INSERT INTO ".sql_getFormName($FORM_USER)." 
			(`username` ,`password` ,`group` ,`create_time` ,`isActive` ,`name` ,`nickname` ,`email`)
			VALUES ('$username', '$passwd', '$group', NOW() , '$isActive', '$name', '$nickname', '$email')") 
			or die(sql_getErrMsg());
		
		//關閉資料庫
		sql_close($db);
		
		//回傳成功訊息
		return "Finish";
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

				//登記新的登入碼和登入時間進資料庫
				mysql_query("UPDATE ".sql_getFormName($FORM_USER)." 
					SET `logged_code` = '".$login_verify."', `last_login_time`  = NOW() 
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
// ------------------------------------------------------------------------

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

	//尋找登入碼
	$db_user_query = mysql_query("SELECT `username` FROM ".sql_getFormName($FORM_USER)." WHERE `logged_code` = '$loginCode'") or die(sql_getErrMsg());
	//若有找到
	if(mysql_num_rows($db_user_query) >= 1){
		//清除登入碼和登入時間進資料庫
		mysql_query("UPDATE ".sql_getFormName($FORM_USER)." 
			SET `logged_code` = NULL 
			WHERE `logged_code` = '$loginCode'") or die(sql_getErrMsg()
		);
			
		sql_close($db);	//關閉資料庫
		
		return true;	//傳回登出成功
	}
	else{
		return false;	//傳回登出失敗
	}
}
// ------------------------------------------------------------------------

/**
 * user_getUserId
 *
 * 查詢使用者帳號
 *
 * @access	public
 * @param	string	登入碼
 * @return	int	使用者ID(回傳0為找不到使用者)
 * 
 * @since	Version 0
 */
function user_getUserId($loggedCode){
	global $FORM_USER;
	
	//連結資料庫
	$db = sql_connect();
	
	//尋找登入碼
	$db_user_query = mysql_query("SELECT `ID` FROM ".sql_getFormName($FORM_USER)." WHERE `logged_code` = '$loggedCode'") or die(sql_getErrMsg());
	
	//若有找到
	if(mysql_num_rows($db_user_query) >= 1){
		$iserID = mysql_result($db_user_query, 0, ID);
		sql_close($db);	//關閉資料庫
		return $iserID;
	}
	else{
		sql_close($db);	//關閉資料庫
		return 0;
	}
}
// ------------------------------------------------------------------------ 
/**
 * user_getGroupList
 *
 * 取得使用者群組清單
 *
 * @access	public
 * @return	array	陣列索引為ID，值為群組名稱
 * 
 * @since	Version 0
*/
function user_getGroupList(){
	global $FORM_USER;
	
	//連結資料庫
	$db = sql_connect();
	
	//查詢群組
	$db_usergroup_query = mysql_query("SELECT `ID`, `name` FROM ".sql_getFormName("user_groups")) or die(sql_getErrMsg());
	
	//若有找到
	if(mysql_num_rows($db_usergroup_query) >= 1){
		while( $db_usergroup_queryRow = mysql_fetch_array($db_usergroup_query) ){
			$groupArray[ $db_usergroup_queryRow['ID'] ] = $db_usergroup_queryRow['name'];
		}
		sql_close($db);	//關閉資料庫
		return $groupArray;
	}
	else{
		return NULL;
	}
}
// ------------------------------------------------------------------------ 
/**
 * user_getGroupID
 *
 * 取得此使用者群組的ID
 *
 * @access	public
 * @param	int	群組ID
 * @return	bool	是否已有
 * 
 * @since	Version 0
*/
function user_ishaveGroup($groupID){
	global $FORM_USER;
	
	//連結資料庫
	$db = sql_connect();
	
	//查詢群組
	$db_usergroup_query = mysql_query("SELECT `ID`, `name` FROM ".sql_getFormName("user_groups")." WHERE `ID` = '$groupID'") or die(sql_getErrMsg());
	
	//若有找到
	if(mysql_num_rows($db_usergroup_query) >= 1){
		sql_close($db);	//關閉資料庫
		return true;
	}
	else{
		sql_close($db);	//關閉資料庫
		return false;
	}
}

// ------------------------------------------------------------------------ 
/**
 * user_getGroupID
 *
 * 取得此使用者群組的ID
 *
 * @access	public
 * @param	string	群組名稱
 * @return	int	ID
 * 
 * @since	Version 0
*/
function user_getGroupID($groupName){
	global $FORM_USER;
	
	//連結資料庫
	$db = sql_connect();
	
	//查詢群組
	$db_usergroup_query = mysql_query("SELECT `ID`, `name` FROM ".sql_getFormName("user_groups")." WHERE `name` = '$groupName'") or die(sql_getErrMsg());
	
	//若有找到
	if(mysql_num_rows($db_usergroup_query) >= 1){
		$result = mysql_result($db_usergroup_query, 0, ID);
		sql_close($db);	//關閉資料庫
		return $result;
	}
	else{
		return NULL;
	}
}

// ------------------------------------------------------------------------ 
/**
 * user_getUserQuery
 *
 * 查詢使用者
 *
 * @access	public
 * @param	string	登入碼
 * @return	object	此使用者的資料表內容(回傳NULL為找不到使用者)
 * 
 * @since	Version 0
*/
function user_getUserQuery($loggedCode){
	global $FORM_USER;
	
	//連結資料庫
	$db = sql_connect();
	
	//尋找登入碼
	$db_user_query = mysql_query("SELECT `ID` FROM ".sql_getFormName($FORM_USER)." WHERE `logged_code` = '$loggedCode'") or die(sql_getErrMsg());
	
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
 * user_queryAll
 *
 * 查詢使用者帳號
 *
 * @access	public
 * @param	object	資料庫
 * @return	object	mysql_query的查詢結果
 * 
 * @since	Version 1
*/
function user_queryAll($db){
	global $DEV_DEGUG, $FORM_USER;
	$db_table = mysql_query("SELECT `ID`, `username`, `group`, `logged_code`, `last_login_time`, `create_time`, `isActive`, `name`, `nickname`, `email` FROM ".sql_getFormName($FORM_USER)) or die(sql_getErrMsg());
	return $db_table;
}