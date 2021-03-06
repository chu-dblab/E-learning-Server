<?php
/**
 * 使用者帳號類別（以登入碼為主）
*/
// 前置作業
require_once(DOCUMENT_ROOT."lib/class/User.php");
require_once(DOCUMENT_ROOT."lib/class/Database.php");

/**
 * 這一位使用者處理專用類別
 * 
 * 以User類別為基底 衍生出以登入碼為主的使用者類別MyUser。
 * 一個物件即代表這一位使用者。
 * 
 * @author CHU-TDAP
 * @link https://github.com/CHU-TDAP/
 * @version  Version 2.0
 */
class MyUser {
	/**
	 * 使用者登入碼
	 * 
	 * @access private
	 */
	private $loggedCode;
	
	/**
	 * 此帳號的原始物件
	 * 
	 * 由 __construct 取得
	 * @access private
	 */
	private $userObject;
	
	/**
	 * 建構子
	 *
	 * @access public
	 * @param string 登入碼
	 */
	function __construct($inputLoggedCode){
		global $FORM_USER;
		$this->loggedCode = $inputLoggedCode;
		
		$db = new Database();
		$queryResult = $db->prepare("SELECT UID FROM ".$db->table($FORM_USER)." WHERE `ULogged_code` = :code");
		$queryResult->bindParam(':code',$this->loggedCode);
		$queryResult->execute();
		
		$result = $queryResult->fetch(PDO::FETCH_NUM);
		$username = $result[0];
		
		//若有找到使用者
		if( isset($username) ) {
			$this->userObject = new User($username);
		}
		//若沒有找到使用者
		else {
			unset($this->loggedCode);
		}
	}
	
	// ========================================================================
	
	/**
	 * 取得登入碼
	 *
	 * @access public
	 * @return string 登入碼
	 */
	function getLoggedCode(){
		return $this->userObject->getLoggedCode();
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號名稱
	 *
	 * @access public
	 * @return string 帳號名稱
	 */
	function getUsername(){
		if(isset($this->userObject)) {
			return $this->userObject->getUsername();
		}
		else {
			return "NoUserFound";
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得登入時間
	 *
	 * @access public
	 * @return string 登入時間
	 */
	function getLoginTime(){
		if(isset($this->userObject)) {
			return $this->userObject->getLoginTime();
		}
		else {
			return "NoUserFound";
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號建立時間
	 *
	 * @access public
	 * @return string 建立時間
	 */
	function getCreateTime(){
		if(isset($this->userObject)) {
			return $this->userObject->getCreateTime();
		}
		else {
			return "NoUserFound";
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得所在群組
	 *
	 * @access public
	 * @return string 群組名稱
	 */
	function getGroup(){
		if(isset($this->userObject)) {
			return $this->userObject->getGroup();
		}
		else {
			return "NoUserFound";
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得所在群組顯式名稱
	 *
	 * @access public
	 * @return string 群組顯示名稱
	 */
	function getGroupName(){
		if(isset($this->userObject)) {
			return $this->userObject->getGroupName();
		}
		else {
			return "NoUserFound";
		}
	}
	// ========================================================================
	
	/**
	 * 取得真實姓名
	 *
	 * @access public
	 * @return string 真實姓名
	 */
	function getRealName(){
		if(isset($this->userObject)) {
			return $this->userObject->getRealName();
		}
		else {
			return "NoUserFound";
		}
	}
	
	/**
	 * 修改真實姓名
	 *
	 * @access public
	 * @param string $input 新真實姓名
	 * @return bool 是否更改成功
	 */
	function setRealName(){
		if(isset($this->userObject)) {
			return $this->userObject->setRealName($input);
		}
		else {
			return false;
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得暱稱
	 *
	 * @access public
	 * @return string 暱稱
	 */
	function getNickName(){
		if(isset($this->userObject)) {
			return $this->userObject->getNickName();
		}
		else {
			return "NoUserFound";
		}
	}
	
	/**
	 * 修改暱稱
	 *
	 * @access public
	 * @param string $input 新暱稱
	 * @return bool 是否更改成功
	 */
	function setNickName($input){
		if(isset($this->userObject)) {
			return $this->userObject->setNickName($input);
		}
		else {
			return false;
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得名稱
	 *
	 * @access public
	 * @return string 依照有填入多少名字（優先順序: 暱稱→真實名字→帳號名稱）
	 */
	function getName(){
		if(isset($this->userObject)) {
			return $this->userObject->getName();
		}
		else {
			return "NoUserFound";
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號Email
	 *
	 * @access public
	 * @return string 使用者資訊的Email
	 */
	function getEmail(){
		if(isset($this->userObject)) {
			return $this->userObject->getEmail();
		}
		else {
			return "NoUserFound";
		}
	}
	
	/**
	 * 修改帳號Email
	 *
	 * @access public
	 * @param string $input 新Email
	 * @return bool 是否更改成功
	 */
	function setEmail($input){
		if(isset($this->userObject)) {
			return $this->userObject->setEmail($input);
		}
		else {
			return false;
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得此帳號查詢
	 *
	 * @access public
	 * @return object 此使用者的資料表內容(回傳NULL為找不到使用者)
	 * 
	 * @version Version 0
	 */
	function getQuery(){
		if(isset($this->userObject)) {
			return $this->userObject->getQuery();
		}
		else {
			return null;
		}
	}
	// ========================================================================
	
	/**
	 * 驗證密碼是否錯誤
	 *
	 * @access public
	 * @param string 密碼
	 * @param string 加密方式(可省略)
	 * @return bool true:密碼正確 false:密碼錯誤
	 * 
	 * @version Version 0
	 */
	function isPasswordCorrect(){
		if(isset($this->userObject)) {
			//若帶入兩個參數
			if(func_num_args() == 2){
				//對應變數
				$args = func_get_args();
				$inputPasswd = $args[0];
				$mode = $args[1];
				
				return $this->userObject->isPasswordCorrect($inputPasswd, $mode);
			}
			else if(func_num_args() == 1){
				//對應變數
				$args = func_get_args();
				$inputPasswd = $args[0];
				
				return $this->userObject->isPasswordCorrect($inputPasswd);
			}
		}
		else {
			return false;
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 更改密碼
	 *
	 * 傳回的字串如果是:
	 * <ul>
	 *   <li>"Finish":密碼更改完成</li>
	 * </ul>
	 * @access public
	 * @global string $ENCRYPT_MODE 放在/config.php的加密方式選項
	 * @param string $newPasswd 新密碼
	 * @param string $newPasswdMode 新密碼加密方式（可省略）
	 * @return string 狀態回傳
	 * @version Version 1
	 */
	function changePassword(){
		global $ENCRYPT_MODE;
		if(isset($this->userObject)) {
			//若帶入兩個參數
			if(func_num_args() == 2){
				//對應變數
				$args = func_get_args();
				$newPasswd = $args[0];
				$newPasswdMode = $args[1];
				
				return $this->userObject->changePassword($newPasswd, $newPasswdMode);
			}
			else if(func_num_args() == 1){
				//對應變數
				$args = func_get_args();
				$newPasswd = $args[0];
				
				return $this->changePassword($newPasswd);
				
			}
		}
		else {
			return "NoUserFound";
		}
	}
	// ========================================================================
	/**
	 * 是否還在登入狀態
	 *
	 * @access public
	 * @return bool 是否仍在登入狀態
	 */
	function isLogged() {
		if(isset($this->userObject)) {
			return $this->userObject->isLogged();
		}
		else {
			return false;
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得權限清單
	 *
	 * @access public
	 * @return array 權限清單
	 */
	 public function getPermissionList() {
		if(isset($this->userObject)) {
			return $this->userObject->getPermissionList();
		}
		else {
			return "NoUserFound";
		}		
	 }
	
	/**
	 * 是否擁有此權限
	 *
	 * @access public
	 * @param string $permissionName 權限名稱
	 * @return bool 是否擁有
	 */
	 function havePermission($permissionName) {
		if(isset($this->userObject)) {
			return $this->userObject->havePermission($permissionName);
		}
		else {
			return false;
		}
	 }
	 
	// ------------------------------------------------------------------------
	
	/**
	 * 登出
	 *
	 * @access public
	 * @return bool 是否登出成功
	 */
	 function logout(){
		if(isset($this->userObject)) {
			return $this->userObject->logout();
		}
		else {
			return false;
		}
	 }
}
