<?php
/**
 * 前置作業
*/
require_once(DOCUMENT_ROOT."lib/sql.php");
require_once(DOCUMENT_ROOT."lib/password.php");
//require_once(DOCUMENT_ROOT."lib/user.php");
require_once(DOCUMENT_ROOT."lib/userGroup.php");

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
	 * 建構子
	 *
	 * @access	public
	 * @param	string	登入碼
	 * @return	string
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
	 * @return	string	登入碼
	 */
	function getID(){
		$db_user_query = sql_getTheUserQuery($this->loggedCode);
		
		if($db_user_query){
			$iserID = mysql_result($db_user_query, 0, ID);
			return $iserID;
		}
		else{
			return NULL;
		}
		
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
	 * 登出
	 *
	 * @access	public
	 * @return	bool	是否登出成功
	 */
	 function logout(){
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
