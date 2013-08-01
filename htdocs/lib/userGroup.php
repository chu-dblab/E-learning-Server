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
 * @param	int	群組ID
 * @return	bool	是否已有
 * 
 * @since	Version 0
*/
function userGroup_ishave($groupID){
	global $FORM_USER_GROUP;
	
	//連結資料庫
	$db = sql_connect();
	
	//查詢群組
	$db_usergroup_query = mysql_query("SELECT `ID`, `name` FROM ".sql_getFormName($FORM_USER_GROUP)." WHERE `ID` = '$groupID'") or die(sql_getErrMsg());
	
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

