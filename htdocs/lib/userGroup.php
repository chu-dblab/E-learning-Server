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

require_once(DOCUMENT_ROOT."lib/sql.php");
require_once(DOCUMENT_ROOT."lib/user.php");
require_once(DOCUMENT_ROOT."config/db_table_config.php");

// ========================================================================

/**
 * userGroup_create
 *
 * 建立使用者群組
 *
 * @access	public
 * @param	string	名稱
 * @param	string	管理員權限
 * @return	string	是否有成功建立
 *			"Finish": 成功建立
 *			"NameCreatedErr": 有重複名稱
 * 
 * @since	Version 0
*/
function userGroup_create($name, $display_name, $adminPermissions){
	global $FORM_USER_GROUP;
	//檢查有無重複的名稱
	if( userGroup_ishave($name) ){
		return "NameCreatedErr";
	}
	//都沒有問題，新增帳號
	else{
		//開啟資料庫Finish
		$db = sql_connect();
		
		//紀錄使用者帳號進資料庫
		mysql_query("INSERT INTO `".sql_getFormName($FORM_USER_GROUP)."` 
			(`name`, `display_name`, `admin`)
			VALUES ('$name', '$display_name', '$adminPermissions');
			") 
			or die(sql_getErrMsg());
			
		//關閉資料庫
		sql_close($db);
		
		//回傳成功訊息
		return "Finish";
	}
}
// ------------------------------------------------------------------------

/**
 * userGroup_remove
 *
 * 刪除使用者群組
 *
 * @access	public
 * @param	string	名稱
 * @return	string	是否有成功刪除
 *			"Finish": 成功建立
 *			"UserExist": 尚有存在的使用者
			"NoFound": 找不到存在的群組
 * 
 * @since	Version 0
*/
function userGroup_remove($name){
	global $FORM_USER, $FORM_USER_GROUP;
	//開啟資料庫
	$db = sql_connect();
	
	// TODO 尚未完成移除動作
	$db_existUser = mysql_query("SELECT `username` FROM ".sql_getFormName($FORM_USER)." WHERE `user_group` = '$name'") or die(sql_getErrMsg());
	
	//檢查是否有此群組
	if( !userGroup_ishave($name) ){
		return "NoFound";
	}
	//檢查是否有使用者還存在這個群組
	else if( mysql_num_rows($db_existUser) >= 1 ){
		return "UserExist";
	}
	//都沒有問題
	else{
		//刪除群組
		$db = sql_connect();
		mysql_query("DELETE FROM `".sql_getFormName($FORM_USER_GROUP)."` 
			WHERE `name` = '$name'
			") 
			or die(sql_getErrMsg());
		
			
		//關閉資料庫
		sql_close($db);
		
		//回傳成功訊息
		return "Finish";
	}
}
// ========================================================================

/**
 * userGroup_getList
 *
 * 取得使用者群組清單
 *
 * @access	public
 * @return	array	陣列索引為name，值為群組顯示名稱
 * 
 * @since	Version 0
*/
function userGroup_getList(){
	global $FORM_USER_GROUP;
	
	//連結資料庫
	$db = sql_connect();
	
	//查詢群組
	$db_usergroup_query = mysql_query("SELECT distinct(`name`) `name`, `display_name` FROM ".sql_getFormName($FORM_USER_GROUP)) or die(sql_getErrMsg());
	
	//若有找到
	if(mysql_num_rows($db_usergroup_query) >= 1){
		while( $db_usergroup_queryRow = mysql_fetch_array($db_usergroup_query) ){
			$groupArray[ $db_usergroup_queryRow['name'] ] = $db_usergroup_queryRow['display_name'];
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
 * userGroup_ishave
 *
 * 是否擁有此群組
 *
 * @access	public
 * @param	string	群組名稱
 * @return	bool	是否已有
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 2
*/
function userGroup_ishave($name){
	global $FORM_USER_GROUP;
	
	//資料庫連結
	$db = new Database();
	
	//資料庫查詢
	$db_userGroup_query = $db->prepare("SELECT `name` FROM ".$db->table($FORM_USER_GROUP)." WHERE `name` = :groupName");
	$db_userGroup_query->bindParam(":groupName",$name);
	$db_userGroup_query->execute();
	
	//若有找到
	if( $db_userGroup_query->fetch() ) {
		return true;
	}
	//若找不到
	else {
		return false;
	}
}
// ------------------------------------------------------------------------ 

/**
 * userGroup_getName
 *
 * 取得此使用者群組的名稱
 *
 * @access	public
 * @param	string	groupName
 * @return	string	群組名稱
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 2
*/
function userGroup_getDiaplayName($groupName){
	global $FORM_USER_GROUP;
	
	//資料庫連結
	$db = new Database();
	
	//資料庫查詢
	$db_userGroup_query = $db->prepare("SELECT `name`, `display_name` FROM ".$db->table($FORM_USER_GROUP)." WHERE `name` = :groupName");
	$db_userGroup_query->bindParam(":groupName",$groupName);
	$db_userGroup_query->execute();
	
	if( $groupArray = $db_userGroup_query->fetch() ) {
		return $groupArray['display_name'];
	}
	else {
		return null;
	}
}

// ========================================================================

/**
 * userGroup_queryAll
 *
 * 查詢所有使用者群組
 *
 * @access	public
 * @param	object	資料庫
 * @return	object	mysql_query的查詢結果
 * 
 * @since	Version 1
*/
function userGroup_queryAll($db){
	global $DEV_DEGUG, $FORM_USER_GROUP;
	$db_table = mysql_query("SELECT `name`, `display_name`, `admin` FROM ".sql_getFormName($FORM_USER_GROUP)) or die(sql_getErrMsg());
	return $db_table;
}