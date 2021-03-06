<?php
/**
 * 使用者群組
 */
// 前置作業
require_once(DOCUMENT_ROOT."lib/class/Database.php");
require_once(DOCUMENT_ROOT."lib/function/userGroup.php");

 /**
 * 一個物件即代表這一個使用者群組
 *
 * @link https://github.com/CHU-TDAP/
 * @version Version 1.0
*/
class UserGroup {
	/**
	 * 群組ID
	 * 
	 * @access private
	 * @var string
	 */
	private $thisGroup;
	
	// ========================================================================
	
	/**
	 * 建構子
	 *
	 * @access public
	 * @param string $inputGroupName 群組ID
	 * @author 元兒～ <yuan817@moztw.org>
	 * @version Version 1
	*/
	function __construct($inputGroupName) {
		if(userGroup_ishave($inputGroupName)) {
			$this->thisGroup = $inputGroupName;
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得顯示名稱
	 *
	 * @access public
	 * @return string 群組顯示名稱
	 * @author 元兒～ <yuan817@moztw.org>
	 * @version Version 1
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
	 * 刪除使用者群組
	 * 
	 * @access public
	 * @return string
	 *          是否有成功刪除
	 *          <ul>
	 *            <li>"Finish": 成功建立</li>
	 *            <li>"UserExist": 尚有存在的使用者</li>
	 *            <li>"NoFound": 找不到存在的群組</li>
	 *            <li>"DBErr": 資料庫錯誤</li>
	 *          </ul>
	 * @author 元兒～ <yuan817@moztw.org>
	 * @version Version 2
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
	// ------------------------------------------------------------------------
	/**
	* 取得此群組內有哪些權限
	*
	* @access public
	* @return array 所有權限名稱
	* @author 元兒～ <yuan817@moztw.org>
	* @version Version 2
	*/
	public function getPermissionList() {
		global $FORM_USER_GROUP;
		
		//資料庫連結
		$db = new Database();
		
		//資料庫查詢
		$db_userGroup_query = $db->prepare("SELECT * FROM ".$db->table($FORM_USER_GROUP)." WHERE `GID` = :groupName");
		$db_userGroup_query->bindParam(":groupName",$this->thisGroup);
		$db_userGroup_query->execute();
		
		//取得權限欄位
		if( $groupArray = $db_userGroup_query->fetch(PDO::FETCH_ASSOC) ) {
			$output = array();
			
			foreach ($groupArray as $key => $value) {
				// 如果是"非權限"欄位，則跳過
				if($key == "GID" || $key == "GName") {
					continue;
				}
				
				// 如果有有此權限，加入置清單
				if($value == true) {
					//$output += array($key);
					array_push($output,$key);
				}
				
			}
			return $output;
		}
		else {
			return null;
		}
		
	}
}
