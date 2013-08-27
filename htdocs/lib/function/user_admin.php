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
require_once(DOCUMENT_ROOT."lib/function/user.php");
require_once(DOCUMENT_ROOT."lib/function/userGroup.php");
require_once(DOCUMENT_ROOT."config/db_table_config.php");

// ========================================================================

/**
 * user_logout
 *
 * 登出某使用者帳號
 *
 * @access	public
 * @param	string	帳號
 * @return	bool	是否登出成功
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 3
*/
function user_logout($userid){
	global $FORM_USER;
	
	//連結資料庫
	$db = new Database();
	
	//清除登入碼進資料庫
	$db_user_query = $db->prepare("UPDATE ".$db->table($FORM_USER)." SET `ULogged_code` = NULL WHERE `UID` = :username");
	$db_user_query->bindParam(":username",$userid);
	$db_user_query->execute();
	
	//判斷是否已登出
	if( $db_user_query->rowCount() ) {
		//回傳成功訊息
		return true;
	}
	else {
		return false;
	}
}
// ------------------------------------------------------------------------ 

/**
 * user_changeGroup
 *
 * 切換使用者群組
 *
 * @access	public
 * @param	string	使用者帳號
 * @param	string	群組
 * @return	string	是否更改成功
 * 			"Finish": 成功更改
 * 			"NoFoundUser": 無此帳號
 * 			"NoFoundUserGroup": 無此使用者群組
 * 			"DBErr": 其他資料庫錯誤
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 1
*/
function user_changeGroup($userid, $toGroup){
	global $FORM_USER;
	
	if( user_ishave($userid) ) {
		//連結資料庫
		$db = new Database();
		
		$queryResult = $db->prepare("UPDATE ".$db->table($FORM_USER)." SET `GID` = :togroup WHERE `UID` = :username");
		$queryResult->bindParam(':username',$userid);
		$queryResult->bindParam(':togroup',$toGroup);
		$queryResult->execute();
		
		
		$errmsg = $queryResult->errorInfo();
		if( $errmsg[1] == 0 ) {
			return "Finish";
		}
		else if ( $errmsg[1] == 1452) {
			return "NoFoundUserGroup";
		}
		else {
			return "DBErr";
		}
	}
	else {
		return "NoFoundUser";
	}
}
// ------------------------------------------------------------------------ 

/**
 * user_getList
 *
 * 取得使用者名單
 *
 * @access	public
 * @param	string	以何種內容傳回
 * @param	string	以何種方式排序
 * @return	array	索引: 使用者ID; 值: 真實名字: 暱稱
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 1
*/
function user_getList(){
	global $FORM_USER;
	
	//連結資料庫
	$db = new Database();
	
	//取得所有使用者
	$result_sql = $db->query( "SELECT `UID`, `UReal_Name`, `UNickname` FROM ".$db->table($FORM_USER) );
		
	//$result[內部群組名稱] = 使用者看得到的群組名稱
	while( $db_thisArray = $result_sql->fetch() ) {
		$output_realName = $db_thisArray['UReal_Name'];
		$output_nickName = $db_thisArray['UNickname'];
		$result[ $db_thisArray['UID'] ] = $output_realName."- ".$output_nickName;
	}
	return $result;
}
// ------------------------------------------------------------------------

/**
 * user_queryAll
 *
 * 查詢使用者帳號
 *
 * @access	public
 * @return	array	mysql_query的查詢結果
 * 
 * @since	Version 3
*/
function user_queryAll(){
	global $FORM_USER;
	
	//連結資料庫
	$db = new Database();
	
	//取得所有使用者
	$result_sql = $db->query( "SELECT `UID`, `GID`, `ULogged_code`, `ULast_In_Time`, `UBuild_Time`, `UEnabled`, `In_Learn_Time`, `UReal_Name`, `UNickname`, `UEmail` 
		FROM ".$db->table($FORM_USER) );
	
	return $result_sql->fetchAll();
}
