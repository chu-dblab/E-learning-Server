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

require_once(DOCUMENT_ROOT."lib/function/user.php");
require_once(DOCUMENT_ROOT."config/db_table_config.php");
require_once(DOCUMENT_ROOT."lib/class/Database.php");

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
 *			"DBErr": 資料庫錯誤
 * 
* @author	元兒～ <yuan817@moztw.org>
 * @since	Version 2
*/
function userGroup_create($name, $display_name, $adminPermissions){
	global $FORM_USER_GROUP;
	//檢查有無重複的名稱
	if( userGroup_ishave($name) ){
		return "NameCreatedErr";
	}
	//都沒有問題，新增帳號
	else{
		//資料庫連結
		$db = new Database();
		
		//紀錄使用者帳號進資料庫
		$db_userGroup_query = $db->prepare("INSERT INTO `".$db->table($FORM_USER_GROUP)."` (`GID`, `GName`, `Gauth_admin`) VALUES (:groupName, :display_name , :adminPermissions )");
		$db_userGroup_query->bindParam(":groupName",$name);
		$db_userGroup_query->bindParam(":display_name",$display_name);
		$db_userGroup_query->bindParam(":adminPermissions",$adminPermissions);
		$db_userGroup_query->execute();
		
		//若有有加入
		if( $db_userGroup_query->rowCount() ) {
			return "Finish";	//回傳成功訊息
		}
		//若無加入
		else {
			return "DBErr";
		}
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
			"DBErr": 資料庫錯誤
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 2
*/
function userGroup_remove($name){
	global $FORM_USER, $FORM_USER_GROUP;
	//資料庫連結
	$db = new Database();
	
	//查詢此群組是否有使用者
	$db_user_query = $db->prepare("SELECT `UID` FROM ".$db->table($FORM_USER)." WHERE `GID` = :groupName");
	$db_user_query->bindParam(":groupName",$name);
	$db_user_query->execute();
	
	//檢查是否有此群組
	if( !userGroup_ishave($name) ){
		return "NoFound";
	}
	//檢查是否有使用者還存在這個群組
	else if( $db_user_query->fetch() ){
		return "UserExist";
	}
	//都沒有問題
	else{
		//刪除群組
		$db_userGroup_query = $db->prepare("DELETE FROM `".$db->table($FORM_USER_GROUP)."` WHERE `GID` = :groupName");
		$db_userGroup_query->bindParam(":groupName",$name);
		$db_userGroup_query->execute();
		
		//若有成功刪除
		if( $db_userGroup_query->rowCount() ) {
			return "Finish";	//回傳成功訊息
		}
		else {
			return "DBErr";
		}
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
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 2
*/
function userGroup_getList(){
	global $FORM_USER_GROUP;
	
	//資料庫連結
	$db = new Database();
	
	//資料庫查詢
	$db_userGroup_query = $db->query("SELECT distinct(`GID`) `GID`, `GName` FROM ".$db->table($FORM_USER_GROUP));
	
	//若有找到，將列表以陣列傳回
	//$result[內部群組名稱] = 使用者看得到的群組名稱
	while( $db_thisGroupArray = $db_userGroup_query->fetch() ) {
		$result[ $db_thisGroupArray['GID'] ] = $db_thisGroupArray['GName'];
	}
	return $result;
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
	$db_userGroup_query = $db->prepare("SELECT `GID` FROM ".$db->table($FORM_USER_GROUP)." WHERE `GID` = :groupName");
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
	$db_userGroup_query = $db->prepare("SELECT `GID`, `GName` FROM ".$db->table($FORM_USER_GROUP)." WHERE `GID` = :groupName");
	$db_userGroup_query->bindParam(":groupName",$groupName);
	$db_userGroup_query->execute();
	
	//取得顯示名稱
	if( $groupArray = $db_userGroup_query->fetch() ) {
		return $groupArray['GName'];
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
 * @return	array	mysql_query的查詢結果
 * 
 * @author	元兒～ <yuan817@moztw.org>
 * @since	Version 2
*/
function userGroup_queryAll(){
	global $FORM_USER, $FORM_USER_GROUP;
	//資料庫連結
	$db = new Database();
	
	//資料庫查詢
	//	SELECT `groups`.`GID`, `groups`.`GName`, COUNT(`users`.`GID`) AS `in_user`, `groups`.`Gauth_admin` 
	//	FROM `chu_user` AS `users` 
	//	JOIN `chu_group` AS `groups` ON `users`.`GID` = `groups`.`GID` 
	//	GROUP BY `users`.`GID`
	//UNION
	//	SELECT DISTINCT `GID`, `GName`, "0", `Gauth_admin`
	//	FROM `chu_group` AS `groups`
	//	WHERE (SELECT COUNT(`UID`) FROM `chu_user` WHERE `GID` = `groups`.`GID` ) = 0
	$db_userGroup_query = $db->query("
		SELECT `groups`.`GID`, `groups`.`GName`, count(`users`.`GID`) AS `in_user`, `groups`.`Gauth_admin` 
		FROM `".$db->table($FORM_USER)."` AS `users` 
		JOIN `".$db->table($FORM_USER_GROUP)."` AS `groups` ON `users`.`GID` = `groups`.`GID` 
		GROUP BY `users`.`GID` 
		UNION 
		SELECT `GID`, `GName`, '0', `Gauth_admin` 
		FROM `".$db->table($FORM_USER_GROUP)."` AS `groups` 
		WHERE (SELECT COUNT(`UID`) FROM `".$db->table($FORM_USER)."` WHERE `GID` = `groups`.`GID` ) = 0 
		ORDER BY `in_user` DESC
	");
	
	return $db_userGroup_query->fetchAll();
}