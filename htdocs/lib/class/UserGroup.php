<?php
/**
 * 前置作業
*/
require_once(DOCUMENT_ROOT."lib/class/Database.php");
require_once(DOCUMENT_ROOT."lib/function/userGroup.php");

 /**
 * UserGroup
 * 一個物件即代表這一位使用者
 *
 * @package	CHU-E-learning
 * @author	CHU-TDAP
 * @copyright	
 * @license	type filter text
 * @link	https://github.com/CHU-TDAP/
 * @since	Version 1.0
*/
class UserGroup {
	private $thisGroup;
	
	// ========================================================================
	
	/**
	 * 建構子
	 *
	 * @access	public
	 * @param	string	登入碼
	 * 
	 * @author	元兒～ <yuan817@moztw.org>
	 * @since	Version 1
	*/
	function __construct($inputGroupName) {
		if(userGroup_ishave($inputGroupName)) {
			$this->$thisGroup = $inputGroupName;
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得顯示名稱
	 *
	 * @access	public
	 * @return	string	群組顯示名稱
	 *
	 * @author	元兒～ <yuan817@moztw.org>
	 * @since	Version 1
	 */
	function getDiaplayName() {
		global $FORM_USER_GROUP;
		
		//資料庫連結
		$db = new Database();
		
		//資料庫查詢
		$db_userGroup_query = $db->prepare("SELECT `GID`, `GName` FROM ".$db->table($FORM_USER_GROUP)." WHERE `GID` = :groupName");
		$db_userGroup_query->bindParam(":groupName",$this->thisGroup);
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
	* remove
	*
	* 刪除使用者群組
	*
	* @access	public
	* @return	string	是否有成功刪除
	*			"Finish": 成功建立
	*			"UserExist": 尚有存在的使用者
				"NoFound": 找不到存在的群組
				"DBErr": 資料庫錯誤
	* @author	元兒～ <yuan817@moztw.org>
	* @since	Version 2
	*/
	function userGroup_remove(){
		global $FORM_USER, $FORM_USER_GROUP;
		//資料庫連結
		$db = new Database();
		
		//查詢此群組是否有使用者
		$db_user_query = $db->prepare("SELECT `UID` FROM ".$db->table($FORM_USER)." WHERE `GID` = :groupName");
		$db_user_query->bindParam(":groupName",$this->thisGroup);
		$db_user_query->execute();
		
		//檢查是否有此群組
		if( !userGroup_ishave($this->thisGroup) ){
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
			$db_userGroup_query->bindParam(":groupName",$this->thisGroup);
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
	
}
