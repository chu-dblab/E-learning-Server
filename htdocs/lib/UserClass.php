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
	 * @return	bool	密碼是否正確
	 * 
	 * @since	Version 0
	 */
	function isPasswordCorrect(){
		/*//若帶入兩個參數
		if(func_num_args() == 2){
			//對應變數
			$args = func_get_args();
			$inputPasswd = $args[0];
			$mode = $args[1];
			
			//動作
			switch($mode){
				case "MD5":
					if(){
						
					}
					return md5($text);
					break;
				default:
					return $text;
					break;
			}
		}
		else if(func_num_args() == 1){
			global $ENCRYPT_MODE;
			$args = func_get_args();
			$text = $args[0];
			
			return encryptText($text, $ENCRYPT_MODE);
		}*/
	}
	
	/**
	 * 更改密碼
	 *
	 * TODO 函式
	 * @access	public
	 * @param	string	帳號
	 * @return	object	此使用者的資料表內容(回傳NULL為找不到使用者)
	 * 
	 * @since	Version 0
	 */
	function changePassword(){
		
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
