<?php
/**
 * 前置作業
*/
require_once(DOCUMENT_ROOT."lib/class/User.php");
require_once(DOCUMENT_ROOT."lib/class/Database.php");

 /**
 * User
 * 以User類別為基底 衍生出以登入碼為主的使用者類別MyUser
 * 一個物件即代表這一位使用者
 *
 * @package	CHU-E-learning
 * @author	CHU-TDAP
 * @copyright	
 * @license	type filter text
 * @link	https://github.com/CHU-TDAP/
 * @since	Version 2.0
*/
class MyUser {
	private $loggedCode;
	private $userObject;
	
	/**
	 * 建構子
	 *
	 * @access	public
	 * @param	string	登入碼
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
		$this->userObject = new User($username);
	}
	
	// ========================================================================
	
	/**
	 * 取得登入碼
	 *
	 * @access	public
	 * @return	string	登入碼
	 */
	function getLoggedCode(){
		return $this->userObject->getLoggedCode();
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號名稱
	 *
	 * @access	public
	 * @return	string	帳號名稱
	 */
	function getUsername(){
		return $this->userObject->getUsername();
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得登入時間
	 *
	 * @access	public
	 * @return	string	登入時間
	 */
	function getLoginTime(){
		return $this->userObject->getLoginTime();
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號建立時間
	 *
	 * @access	public
	 * @return	string	建立時間
	 */
	function getCreateTime(){
		return $this->userObject->getCreateTime();
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得所在群組
	 *
	 * @access	public
	 * @return	string	群組名稱
	 */
	function getGroup(){
		return $this->userObject->getGroup();
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得所在群組顯式名稱
	 *
	 * @access	public
	 * @return	string	群組顯示名稱
	 */
	function getGroupName(){
		return $this->userObject->getGroupName();
	}
	// ========================================================================
	
	/**
	 * 取得真實姓名
	 *
	 * @access	public
	 * @return	string	真實姓名
	 */
	function getRealName(){
		return $this->userObject->getRealName();
	}
	
	/**
	 * 修改真實姓名
	 *
	 * @access	public
	 * @param	string	新真實姓名
	 * @return	bool	是否更改成功
	 */
	function setRealName($input){
		return $this->userObject->setRealName($input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得暱稱
	 *
	 * @access	public
	 * @return	string	暱稱
	 */
	function getNickName(){
		return $this->userObject->getNickName();
	}
	
	/**
	 * 修改暱稱
	 *
	 * @access	public
	 * @param	string	新暱稱
	 * @return	bool	是否更改成功
	 */
	function setNickName($input){
		return $this->userObject->setNickName($input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得名稱
	 *
	 * @access	public
	 * @return	string	依照有填入多少名字（優先順序: 暱稱→真實名字→帳號名稱）
	 */
	function getName(){
		return $this->userObject->getName();
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號Email
	 *
	 * @access	public
	 * @return	string	使用者資訊的Email
	 */
	function getEmail(){
		return $this->userObject->getEmail();
	}
	
	/**
	 * 修改帳號Email
	 *
	 * @access	public
	 * @param	string	新Email
	 * @return	bool	是否更改成功
	 */
	function setEmail($input){
		return $this->userObject->setEmail($input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得此帳號查詢
	 *
	 * @access	public
	 * @return	object	此使用者的資料表內容(回傳NULL為找不到使用者)
	 * 
	 * @since	Version 0
	 */
	function getQuery(){
		return $this->userObject->getQuery();
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
			
			return $this->userObject->isPasswordCorrect($inputPasswd, $mode);
		}
		else if(func_num_args() == 1){
			//對應變數
			$args = func_get_args();
			$inputPasswd = $args[0];
			
			return $this->userObject->isPasswordCorrect($inputPasswd);
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
	 * @param	string	新密碼加密方式（可省略）
	 * @return	string	狀態回傳
				"Finish": 密碼更改完成
				"CurrentPasswdErr": 目前密碼錯誤
	 * 
	 * @since	Version 0
	 */
	function changePassword(){
		global $ENCRYPT_MODE;
		//若帶入兩個參數
		if(func_num_args() == 4){
			//對應變數
			$args = func_get_args();
			$currentPasswd = $args[0];
			$currentPasswdMode = $args[1];
			$newPasswd = $args[2];
			$newPasswdMode = $args[3];
			
			//若目前密碼錯誤
			if( !$this->isPasswordCorrect($currentPasswd, $currentPasswdMode) ){
				return "CurrentPasswdErr";
			}
			
			//都沒問題，更改密碼
			else{
				return $this->userObject->changePassword($newPasswd, $newPasswdMode);
			}
		}
		else if(func_num_args() == 3){
			//對應變數
			$args = func_get_args();
			$currentPasswd = $args[0];
			$currentPasswdMode = $args[1];
			$newPasswd = $args[2];
			
			return $this->changePassword($currentPasswd, $currentPasswdMode, $newPasswd, $ENCRYPT_MODE);
			
		}
		else if(func_num_args() == 2){
			//對應變數
			$args = func_get_args();
			$currentPasswd = $args[0];
			$newPasswd = $args[1];
			
			return $this->changePassword($currentPasswd, $ENCRYPT_MODE, $newPasswd, $ENCRYPT_MODE);
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
		return $this->userObject->isLogged();
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
		return $this->userObject->havePermission($permissionName);
	 }
	 
	// ------------------------------------------------------------------------
	
	/**
	 * 登出
	 *
	 * @access	public
	 * @return	bool	是否登出成功
	 */
	 function logout(){
		return $this->userObject->logout();
	 }
}
