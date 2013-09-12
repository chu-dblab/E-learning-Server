<?php
/**
 * 前置作業
*/
require_once(DOCUMENT_ROOT."lib/class/Database.php");
require_once(DOCUMENT_ROOT."lib/function/password.php");
require_once(DOCUMENT_ROOT."lib/function/userGroup.php");

 /**
 * User
 * 一個物件即代表這一位使用者
 *
 * @package	CHU-E-learning
 * @author	CHU-TDAP
 * @copyright	
 * @license	type filter text
 * @link	https://github.com/CHU-TDAP/
 * @since	Version 2.0
*/
class User {
	private $thisUID;
	private $infoArray;
	
	/**
	 * 取得此使用者的資料表欄位內容
	 *
	 * @access	private
	 * @param	string	資料表欄位名稱
	 * @return	(依資料庫型態)	資料表欄位內容
	 * 
	 * @author	元兒～ <yuan817@moztw.org>
	 * @since	Version 1
	 */
	private function getQueryInfo($colName){
		
		return $this->infoArray[0][$colName];
	}
	/**
	 * 更新此使用者的資料表欄位內容
	 *
	 * @access	private
	 * @param	string	資料表欄位名稱
	 * @param	(依輸入型態)	資料表欄位內容
	 * @return	int	更動到幾筆
	 * 
	 * @author	元兒～ <yuan817@moztw.org>
	 * @since	Version 4
	 */
	private function setQueryInfo($colName, $rowContent){
		global $FORM_USER;
		$db = new Database();
		
		$queryResult = $db->prepare("UPDATE ".$db->table($FORM_USER)." SET $colName = :content WHERE `UID` = :toUID");
		$queryResult->bindParam(':content',$rowContent);
		$queryResult->bindParam(':toUID',$this->thisUID);
		$queryResult->execute();
		
		return $queryResult->rowCount();
	}
	
	// ========================================================================
	
	/**
	 * 建構子
	 *
	 * @access	public
	 * @param	string	登入碼
	 */
	function __construct($inputUID){
		$this->thisUID = $inputUID;
		$this->getQuery();
	}
	
	// ========================================================================
	
	/**
	 * 取得登入碼
	 *
	 * @access	public
	 * @return	string	登入碼
	 */
	function getLoggedCode(){
		return $this->getQueryInfo("ULogged_code");
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號名稱
	 *
	 * @access	public
	 * @return	string	帳號名稱
	 */
	function getUsername(){
		return $this->thisUID;
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得登入時間
	 *
	 * @access	public
	 * @return	string	登入時間
	 */
	function getLoginTime(){
		return $this->getQueryInfo("ULast_In_Time");
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號建立時間
	 *
	 * @access	public
	 * @return	string	建立時間
	 */
	function getCreateTime(){
		return $this->getQueryInfo("UBuild_Time");
	}
	// ========================================================================
	
	/**
	 * 取得所在群組
	 *
	 * @access	public
	 * @return	string	群組名稱
	 */
	function getGroup(){
		return $this->getQueryInfo("GID");
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 設定所在群組
	 *
	 * @access	public
	 * @param	string	群組
	 * @return	string	是否更改成功
	 * 			"Finish": 成功更改
	 * 			"NoFoundUserGroup": 無此使用者群組
	 * 			"DBErr": 其他資料庫錯誤
	 * 
	 * @author	元兒～ <yuan817@moztw.org>
	 * @since	Version 1
	 */
	function setGroup($toGroup){
		global $FORM_USER;
		
		//連結資料庫
		$db = new Database();
		
		$queryResult = $db->prepare("UPDATE ".$db->table($FORM_USER)." SET `GID` = :togroup WHERE `UID` = :username");
		$queryResult->bindParam(":username",$this->thisUID);
		$queryResult->bindParam(":togroup",$toGroup);
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
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號啟用狀態
	 *
	 * @access	public
	 * @return	bool	是否已啟用
	 */
	function isEnable(){
		return $this->getQueryInfo("UEnabled");
	}
	
	/**
	 * 設定帳號啟用狀態
	 *
	 * @access	public
	 * @param	bool	是否為啟用
	 * @return	bool	是否更改成功
	 */
	function setEnable($isActive){
		return $this->setQueryInfo("UEnabled", $isActive);
	}
	
	// ========================================================================
	
	/**
	 * 取得真實姓名
	 *
	 * @access	public
	 * @return	string	真實姓名
	 */
	function getRealName(){
		return $this->getQueryInfo("UReal_Name");
	}
	
	/**
	 * 修改真實姓名
	 *
	 * @access	public
	 * @param	string	新真實姓名
	 * @return	bool	是否更改成功
	 */
	function setRealName($input){
		return $this->setQueryInfo("UReal_Name", $input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得暱稱
	 *
	 * @access	public
	 * @return	string	暱稱
	 */
	function getNickName(){
		return $this->getQueryInfo("UNickname");
	}
	
	/**
	 * 修改暱稱
	 *
	 * @access	public
	 * @param	string	新暱稱
	 * @return	bool	是否更改成功
	 */
	function setNickName($input){
		return $this->setQueryInfo("UNickname", $input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號Email
	 *
	 * @access	public
	 * @return	string	使用者資訊的Email
	 */
	function getEmail(){
		return $this->getQueryInfo("UEmail");
	}
	
	/**
	 * 修改帳號Email
	 *
	 * @access	public
	 * @param	string	新Email
	 * @return	bool	是否更改成功
	 */
	function setEmail($input){
		return $this->setQueryInfo("UEmail", $input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得此帳號查詢
	 *
	 * @access	public
	 * @return	object	此使用者的資料表內容(回傳NULL為找不到使用者)
	 * 
	 * @since	Version 4
	 */
	function getQuery(){
		global $FORM_USER;
		$db = new Database();
		
		$queryResult = $db->prepare("SELECT * FROM ".$db->table($FORM_USER)." WHERE `UID` = :toUID");
		$queryResult->bindParam(':toUID',$this->thisUID);
		$queryResult->execute();
		
		$result = $queryResult->fetchAll();
		$this->infoArray = $result;
		return $this->infoArray;
	}
	// ========================================================================
	
	/**
	 * 驗證密碼是否錯誤
	 *
	 * @access	public
	 * @param	string	密碼
	 * @param	string	加密方式(可省略)
	 * @return	bool	true:密碼正確 false:密碼錯誤
	 * 
	 * @since	Version 0
	 */
	function isPasswordCorrect(){
		//若帶入兩個參數
		if(func_num_args() == 2){
			//對應變數
			$args = func_get_args();
			$inputPasswd = $args[0];
			$mode = $args[1];
			
			//動作
			if( $this->getQueryInfo("UPassword") == encryptText($inputPasswd, $mode) ){
				return true;
			}
			else{
				return false;
			}
		}
		else if(func_num_args() == 1){
			global $ENCRYPT_MODE;
			$args = func_get_args();
			$inputPasswd = $args[0];
			
			return $this->isPasswordCorrect($inputPasswd, $ENCRYPT_MODE);
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 更改密碼
	 *
	 * @access	public
	 * @param	string	舊密碼
	 * @param	string	舊密碼加密方式（可省略）
	 * @param	string	新密碼
	 * @param	string	新密碼確認
	 * @param	string	新密碼加密方式（可省略）
	 * @return	string	狀態回傳
				"Finish": 密碼更改完成
				"CurrentPasswdErr": 目前密碼錯誤
				"NewRepPasswdErr": 新密碼確認密碼錯誤
	 * 
	 * @since	Version 0
	 */
	function changePassword(){
		global $FORM_USER, $ENCRYPT_MODE;
		//若帶入兩個參數
		if(func_num_args() == 5){
			//對應變數
			$args = func_get_args();
			$currentPasswd = $args[0];
			$currentPasswdMode = $args[1];
			$newPasswd = $args[2];
			$newPasswd_rep = $args[3];
			$newPasswdMode = $args[4];
			
			
			//動作
			//若目前密碼錯誤
			if( !$this->isPasswordCorrect($currentPasswd, $currentPasswdMode) ){
				return "CurrentPasswdErr";
			}
			//確認密碼錯誤
			else if($newPasswd != $newPasswd_rep){
				return "NewRepPasswdErr";
			}
			//都沒問題，更改密碼
			else{
				
				//將密碼加密
				$passwd = encryptText($newPasswd, $newPasswdMode);
				
				//登記新的密碼進資料庫
				$this->setQueryInfo("UPassword", $passwd);
				
				return "Finish";
			}
		}
		else if(func_num_args() == 4){
			//對應變數
			$args = func_get_args();
			$currentPasswd = $args[0];
			$currentPasswdMode = $args[1];
			$newPasswd = $args[2];
			$newPasswd_rep = $args[3];
			
			return $this->changePassword($currentPasswd, $currentPasswdMode, $newPasswd, $newPasswd_rep, $ENCRYPT_MODE);
			
		}
		else if(func_num_args() == 3){
			//對應變數
			$args = func_get_args();
			$currentPasswd = $args[0];
			$newPasswd = $args[1];
			$newPasswd_rep = $args[2];
			
			return $this->changePassword($currentPasswd, $ENCRYPT_MODE, $newPasswd, $newPasswd_rep, $ENCRYPT_MODE);
		}
	}
	// ========================================================================
	/**
	 * 是否還在登入狀態
	 *
	 * @access	public
	 * @return	bool	是否仍在登入狀態
	 */
	function isLogged() {
		if($this->getQuery()) {
			return true;
		} else {
			return false;
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 是否擁有此權限
	 *
	 * @access	public
	 * @param	string	權限名稱
	 * @return	bool	是否擁有
	 */
	 function havePermission($permissionName) {
		global $FORM_USER,$FORM_USER_GROUP;
		
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
		$queryResult = $db->prepare("SELECT `ugroup`.`$db_auth` 
			FROM `".$db->table($FORM_USER)."` AS `user` 
			JOIN `".$db->table($FORM_USER_GROUP)."` AS `ugroup` ON `user`.`GID` = `ugroup`.`GID` 
			WHERE `UID` = :toUID"
		);
		$queryResult->bindParam(':toUID',$this->thisUID);
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
	 * 登出
	 *
	 * @access	public
	 * @return	bool	是否登出成功
	 */
	 function logout(){
		global $FORM_USER;
		if($this->thisUID){

			//清除登入碼進資料庫
			$this->setQueryInfo("ULogged_code", NULL);
			
			$this->thisUID = NULL;
			return true;
		}
		return false;
	 }
}
