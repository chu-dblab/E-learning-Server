<?php
/**
 * 前置作業
*/
require_once(DOCUMENT_ROOT."lib/sql.php");
require_once(DOCUMENT_ROOT."lib/password.php");
//require_once(DOCUMENT_ROOT."lib/user.php");
require_once(DOCUMENT_ROOT."lib/userGroup.php");
$FORM_USER = "users";	//使用者帳號資料表

/**
 * User
 *
 * @package Package Name
 * @subpackage Subpackage
 * @category Category
 * @author Author Name
 * @link http://example.com
 */
class User {
	private $loggedCode;
	
	/**
	 * 取得此使用者的資料表欄位內容
	 *
	 * @access	private
	 * @param	string	資料表欄位名稱
	 * @return	(依資料庫型態)	資料表欄位內容
	 * 
	 * @since	Version 0
	 */
	private function getQueryInfo($colName){
		$db_user_query = sql_getTheUserQuery($this->loggedCode);
		
		if($db_user_query){
			$resultInfo = mysql_result($db_user_query, 0, $colName);
			return $resultInfo;
		}
		else{
			return NULL;
		}
	}
	/**
	 * 更新此使用者的資料表欄位內容
	 *
	 * @access	private
	 * @param	string	資料表欄位名稱
	 * @param	(依輸入型態)	資料表欄位內容
	 * @return	bool	是否更改成功
	 * @since	Version 0
	 */
	private function setQueryInfo($colName, $rowContent){
		return sql_setTheUserQuery($this->loggedCode, $colName, $rowContent);
	}
	// ========================================================================
	
	/**
	 * 建構子
	 *
	 * @access	public
	 * @param	string	登入碼
	 */
	function __construct($inputLoggedCode){
		if( sql_getTheUserQuery($inputLoggedCode) ){
			$this->loggedCode = $inputLoggedCode;
		}
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
	 * 取得帳號ID
	 *
	 * @access	public
	 * @return	string	ID-帳號編號
	 */
	function getID(){
		return $this->getQueryInfo("ID");
		
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號名稱
	 *
	 * @access	public
	 * @return	string	帳號名稱
	 */
	function getUsername(){
		return $this->getQueryInfo("username");
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得登入時間
	 *
	 * @access	public
	 * @return	string	登入時間
	 */
	function getLoginTime(){
		return $this->getQueryInfo("last_login_time");
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號建立時間
	 *
	 * @access	public
	 * @return	string	建立時間
	 */
	function getCreateTime(){
		return $this->getQueryInfo("create_time");
	}
	// ========================================================================
	
	/**
	 * 取得真實姓名
	 *
	 * @access	public
	 * @return	string	真實姓名
	 */
	function getRealName(){
		return $this->getQueryInfo("realname");
	}
	
	/**
	 * 修改真實姓名
	 *
	 * @access	public
	 * @param	string	新真實姓名
	 * @return	bool	是否更改成功
	 */
	function setRealName($input){
		return $this->setQueryInfo("realname", $input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得暱稱
	 *
	 * @access	public
	 * @return	string	暱稱
	 */
	function getNickName(){
		return $this->getQueryInfo("nickname");
	}
	
	/**
	 * 修改暱稱
	 *
	 * @access	public
	 * @param	string	新暱稱
	 * @return	bool	是否更改成功
	 */
	function setNickName($input){
		return $this->setQueryInfo("nickname", $input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號Email
	 *
	 * @access	public
	 * @return	string	使用者資訊的Email
	 */
	function getEmail(){
		return $this->getQueryInfo("email");
	}
	
	/**
	 * 修改帳號Email
	 *
	 * @access	public
	 * @param	string	新Email
	 * @return	bool	是否更改成功
	 */
	function setEmail($input){
		return $this->setQueryInfo("email", $input);
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
		return sql_getTheUserQuery($this->loggedCode);
	}
	// ========================================================================
	
	/**
	 * 驗證密碼是否錯誤
	 *
	 * TODO 函式
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
			if( $this->getQueryInfo("password") == encryptText($inputPasswd, $mode) ){
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
	
	/**
	 * 更改密碼
	 *
	 * TODO 函式
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
				
				//開啟資料庫Finish
				$db = sql_connect();
				
				//將密碼加密
				$passwd = encryptText($newPasswd, $newPasswdMode);
				
				//登記新的密碼進資料庫
				$this->setQueryInfo("password", $passwd);
				
				sql_close($db);	//關閉資料庫
				
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
	 * 登出
	 *
	 * @access	public
	 * @return	bool	是否登出成功
	 */
	 function logout(){
		global $FORM_USER;
		if($this->loggedCode){
			//連結資料庫
			$db = sql_connect();
			
			//清除登入碼進資料庫
			mysql_query("UPDATE ".sql_getFormName($FORM_USER)." 
				SET `logged_code` = NULL 
				WHERE `logged_code` = '".$this->loggedCode."'") or die(sql_getErrMsg()
			);
			
			$this->loggedCode = NULL;
			sql_close($db);	//關閉資料庫
		}
		return false;
	 }
}
