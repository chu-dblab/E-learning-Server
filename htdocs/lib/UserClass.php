<?php
/**
 * 前置作業
*/
require_once(DOCUMENT_ROOT."lib/DatabaseClass.php");
require_once(DOCUMENT_ROOT."lib/password.php");
require_once(DOCUMENT_ROOT."lib/userGroup.php");

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
	private $loggedCode;
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
	 * @since	Version 3
	 */
	private function setQueryInfo($colName, $rowContent){
		$db = new Database();
		return $db->setTheUserArray($this->loggedCode, $colName, $rowContent);
	}
	// ========================================================================
	
	/**
	 * 建構子
	 *
	 * @access	public
	 * @param	string	登入碼
	 */
	function __construct($inputLoggedCode){
		$this->loggedCode = $inputLoggedCode;
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
		return $this->loggedCode;
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號名稱
	 *
	 * @access	public
	 * @return	string	帳號名稱
	 */
	function getUsername(){
		return $this->getQueryInfo("UID");
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
	 * @since	Version 0
	 */
	function getQuery(){
		$db = new Database();
		$this->infoArray = $db->getTheUserArray($this->loggedCode);
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
	
	/**
	 * 登出
	 *
	 * @access	public
	 * @return	bool	是否登出成功
	 */
	 function logout(){
		global $FORM_USER;
		if($this->loggedCode){

			//清除登入碼進資料庫
			$this->setQueryInfo("ULogged_code", NULL);
			
			$this->loggedCode = NULL;
			return true;
		}
		return false;
	 }
}
