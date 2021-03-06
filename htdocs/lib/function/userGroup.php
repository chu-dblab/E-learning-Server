<?php
/**
 * 使用者群組函式庫
 */

require_once(DOCUMENT_ROOT."lib/function/user.php");
require_once(DOCUMENT_ROOT."config/db_table_config.php");
require_once(DOCUMENT_ROOT."lib/class/Database.php");

// ========================================================================

/**
 * 建立使用者群組
 *
 * @param string $name 群組ID
 * @param string $display_name 顯示名稱
 * @param string $adminPermissions 管理員權限
 * @param string $clientAdminPermissions 客戶端管理權限
 * @return string 
 *          是否有成功建立
 *          <ul>
 *            <li>"Finish": 成功建立</li>
 *            <li>"NameCreatedErr": 有重複名稱</li>
 *            <li>"DBErr": 資料庫錯誤</li>
 *          </ul>
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 2
 */
function userGroup_create($name, $display_name, $adminPermissions, $clientAdminPermissions){
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
		$db_userGroup_query = $db->prepare("INSERT INTO `".$db->table($FORM_USER_GROUP)."` (`GID`, `GName`, `Gauth_Admin`, `Gauth_ClientAdmin`) VALUES (:groupName, :display_name, :adminPermissions, :clientAdminPermissions)");
		$db_userGroup_query->bindParam(":groupName",$name);
		$db_userGroup_query->bindParam(":display_name",$display_name);
		$db_userGroup_query->bindParam(":adminPermissions",$adminPermissions);
		$db_userGroup_query->bindParam(":clientAdminPermissions",$clientAdminPermissions);
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
 * 刪除使用者群組
 *
 * @param string $name 群組ID
 * @return string 
 *          是否有成功刪除
 *          <ul>
 *            <li>"Finish": 成功刪除</li>
 *            <li>"UserExist": 尚有存在的使用者</li>
 *            <li>"NoFound": 找不到存在的群組</li>
 *            <li>"DBErr": 資料庫錯誤</li>
 *          </ul>
 * @author 元兒～ <yuan817@moztw.org>
 * @version Version 2
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
 * 取得使用者群組清單
 *
 * @return array 陣列索引為name，值為群組顯示名稱
 * 
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 2
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
 * 是否擁有此群組
 *
 * @param string $name 群組ID
 * @return bool 是否已有
 * 
 * @author 元兒～ <yuan817@moztw.org>
 * @version Version 2
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
// ========================================================================

/**
 * 取得此使用者群組的名稱
 *
 * @param string $groupName 群組ID
 * @return string 群組名稱
 * 
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 2
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
// ------------------------------------------------------------------------ 

/**
 * 取得此使用者群組的名稱
 *
 * @param string $groupName 群組ID
 * @param string $displayName 要更改的顯示名稱
 * @return string
 *          狀態回傳
 *          <ul>
 *            <li>"Finish": 成功更改</li>
 *            <li>"NoFound": 無此使用者群組</li>
 *            <li>"DBErr": 其他資料庫錯誤</li>
 *          </ul>
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 1
 */
function userGroup_setDiaplayName($groupName, $displayName){
	global $FORM_USER_GROUP;
	
	//資料庫連結
	$db = new Database();
	
	//若沒有這個群組
	if(!userGroup_ishave($groupName)) {
		return "NoFound";
	}
	else {
		//寫入資料庫
		$queryResult = $db->prepare("UPDATE ".$db->table($FORM_USER_GROUP)." SET `GName` = :name WHERE `GID` = :gid");
		$queryResult->bindParam(":name",$displayName);
		$queryResult->bindParam(":gid",$groupName);
		$queryResult->execute();
		
		
		$errmsg = $queryResult->errorInfo();
		if( $errmsg[1] == 0 ) {
			return "Finish";
		}
		else {
			return "DBErr";
		}
	}
}
// ========================================================================

/**
 * 取得此使用者群組的名稱
 *
 * @param string $groupName 群組ID
 * @param string $permissionName 權限名稱
 * @return bool 是否擁有
 * 
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 1
 */
function userGroup_havePermission($groupName, $permissionName){
	global $FORM_USER_GROUP;
	
	//將使用者的選擇轉為資料表的欄位名稱
	switch($permissionName){
		case "admin":
			$db_auth = "Gauth_admin";
			break;
		default:
			$db_auth = $permissionName;
			break;
	}
	
	//對此使用者進行權限查詢
	$db = new Database();
	//SELECT `Gauth_admin` FROM `chu_group` WHERE `GID` = 'admin'
	$queryResult = $db->prepare("SELECT `$db_auth` FROM `".$db->table($FORM_USER_GROUP)."` WHERE `GID` = :gid");
	$queryResult->bindParam(':gid',$groupName);
	$queryResult->execute();
	
	$result = $queryResult->fetch(PDO::FETCH_NUM);
	
	if($result[0] == 1) {
		return true;
	}
	else {
		return false;
	}
}
// ------------------------------------------------------------------------ 

/**
 * 取得此使用者群組的名稱
 *
 * @param string $groupName 群組ID
 * @param string $permissionName 權限名稱
 * @param bool $permissionEnable 是否擁有
 * @return bool 是否設定成功
 * 
 * @author 元兒～ <yuan817@moztw.org>
 * @version Version 1
*/
function userGroup_setPermission($groupName, $permissionName, $permissionEnable){
	global $FORM_USER_GROUP;
	
	//若沒有這個群組
	if(!userGroup_ishave($groupName)) {
		return false;
	}
	else {
		//將使用者的選擇轉為資料表的欄位名稱
		switch($permissionName){
			case "admin":
				$db_auth = "Gauth_admin";
				break;
			default:
				$db_auth = $permissionName;
				break;
		}
		
		//對此使用者進行權限查詢
		$db = new Database();
		//UPDATE ".$db->table($FORM_USER_GROUP)." SET `GName` = :name WHERE `GID` = :gid
		$queryResult = $db->prepare("UPDATE ".$db->table($FORM_USER_GROUP)." SET `$db_auth` = :isenable WHERE `GID` = :gid");
		$queryResult->bindParam(':isenable', $permissionEnable);
		$queryResult->bindParam(':gid', $groupName);
		$queryResult->execute();
		
		$errmsg = $queryResult->errorInfo();
		if( $errmsg[1] == 0 ) {
			return true;
		}
		else {
			return false;
		}
	}
	
	
	
	
}
// ========================================================================

/**
 * 查詢所有使用者群組
 *
 * @return array mysql_query的查詢結果
 * 
 * @author 元兒～ <yuan817@moztw.org>
 * @version Version 2
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
		SELECT `groups`.`GID`, `groups`.`GName`, count(`users`.`GID`) AS `in_user`, `groups`.`Gauth_Admin`, `groups`.`Gauth_ClientAdmin`
		FROM `".$db->table($FORM_USER)."` AS `users` 
		JOIN `".$db->table($FORM_USER_GROUP)."` AS `groups` ON `users`.`GID` = `groups`.`GID` 
		GROUP BY `users`.`GID` 
		UNION 
		SELECT `GID`, `GName`, '0', `Gauth_Admin`, `Gauth_ClientAdmin`
		FROM `".$db->table($FORM_USER_GROUP)."` AS `groups` 
		WHERE (SELECT COUNT(`UID`) FROM `".$db->table($FORM_USER)."` WHERE `GID` = `groups`.`GID` ) = 0 
		ORDER BY `in_user` DESC
	");
	
	return $db_userGroup_query->fetchAll();
}