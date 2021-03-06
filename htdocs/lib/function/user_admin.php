<?php
/**
 * 使用者帳號管理函式庫
*/

require_once(DOCUMENT_ROOT."lib/function/password.php");
require_once(DOCUMENT_ROOT."lib/function/user.php");
require_once(DOCUMENT_ROOT."lib/function/userGroup.php");
require_once(DOCUMENT_ROOT."config/db_table_config.php");

// ========================================================================

/**
 * 取得使用者名單
 *
 * @return array 索引: 使用者ID; 值: 真實名字: 暱稱
 * 
 * @author 元兒～ <yuan817@moztw.org>
 * @since Version 1
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
 * 查詢使用者帳號
 *
 * @return array mysql_query的查詢結果
 * 
 * @version	Version 3
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
