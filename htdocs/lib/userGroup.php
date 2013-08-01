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
$FORM_USER_GROUP = "user_groups";	//使用者帳號資料表

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
function userGroup_create($name, $adminPermissions){
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
			(`name` ,`admin`)
			VALUES ('user', '$adminPermissions');
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
 * @return	array	陣列索引為ID，值為群組名稱
 * 
 * @since	Version 0
*/
function userGroup_getList(){
	global $FORM_USER_GROUP;
	
	//連結資料庫
	$db = sql_connect();
	
	//查詢群組
	$db_usergroup_query = mysql_query("SELECT `ID`, `name` FROM ".sql_getFormName($FORM_USER_GROUP)) or die(sql_getErrMsg());
	
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
 * userGroup_ishave
 *
 * 是否擁有此群組
 *
 * @access	public
 * @param	string	群組名稱
 * @return	bool	是否已有
 * 
 * @since	Version 0
*/
function userGroup_ishave($name){
	global $FORM_USER_GROUP;
	
	//連結資料庫
	$db = sql_connect();
	
	//查詢群組
	$db_usergroup_query = mysql_query("SELECT `ID`, `name` FROM ".sql_getFormName($FORM_USER_GROUP)." WHERE `name` = '$name'") or die(sql_getErrMsg());
	
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
 * userGroup_getID
 *
 * 取得此使用者群組的ID
 *
 * @access	public
 * @param	string	群組名稱
 * @return	int	ID
 * 
 * @since	Version 0
*/
function userGroup_getID($groupName){
	global $FORM_USER_GROUP;
	
	//連結資料庫
	$db = sql_connect();
	
	//查詢群組
	$db_usergroup_query = mysql_query("SELECT `ID`, `name` FROM ".sql_getFormName($FORM_USER_GROUP)." WHERE `name` = '$groupName'") or die(sql_getErrMsg());
	
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
 * userGroup_getName
 *
 * 取得此使用者群組的名稱
 *
 * @access	public
 * @param	int	ID
 * @return	string	群組名稱
 * 
 * @since	Version 0
*/
function userGroup_getName($groupID){
	global $FORM_USER_GROUP;
	
	//連結資料庫
	$db = sql_connect();
	
	//查詢群組
	$db_usergroup_query = mysql_query("SELECT `ID`, `name` FROM ".sql_getFormName($FORM_USER_GROUP)." WHERE `ID` = '$groupID'") or die(sql_getErrMsg());
	
	//若有找到
	if(mysql_num_rows($db_usergroup_query) >= 1){
		$result = mysql_result($db_usergroup_query, 0, name);
		sql_close($db);	//關閉資料庫
		return $result;
	}
	else{
		return NULL;
	}
}

// ------------------------------------------------------------------------ 

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
	$db_table = mysql_query("SELECT `ID`, `name`, `admin` FROM ".sql_getFormName($FORM_USER_GROUP)) or die(sql_getErrMsg());
	return $db_table;
}