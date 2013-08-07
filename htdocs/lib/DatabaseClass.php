<?php

/**
 * 前置設定
 * 
 * @since	Version 1
*/
require_once(DOCUMENT_ROOT."config/dev_config.php"); //取得除錯參數
require_once(DOCUMENT_ROOT."config/db_config.php"); //取得連結資料庫連結變數
// ========================================================================

/**
 * Database
 *
 *
 * @package	CHU-E-learning
 * @author		CHU-TDAP
 * @copyright	
 * @license		type filter text
 * @link		https://github.com/CHU-TDAP/
 * @since		Version 1.0
 * @filesource
 * 部份來源	https://github.com/shuliu/myPDO
*/
 class Database extends PDO {
	
	
	// ========================================================================
	/**
	 * 建構子
	 *
	 * @access	public
	 */
	function __construct(){
		global $DB_SERV, $DB_NAME, $DB_USER, $DB_PASS;
		parent::__construct("mysql:dbname={$DB_NAME};host:{$DB_SERV};charset=utf8", $DB_USER, $DB_PASS);

		//配合PHP< 5.3.6 PDO沒有charset用的
		//參考: http://gdfan1114.wordpress.com/2013/06/24/php-5-3-6-%E7%89%88-pdo-%E9%85%8D%E5%90%88%E5%AD%98%E5%8F%96%E8%B3%87%E6%96%99%E5%BA%AB%E6%99%82%E7%9A%84%E4%B8%AD%E6%96%87%E5%95%8F%E9%A1%8C/
		$this->exec("set names utf8");
		
	}
	// ========================================================================

	/**
	* form
	*
	* 取得完整資料表名稱
	*
	* @access	public
	* @param	string	資料表名稱
	* @return	string	完整的資料表名稱
	* 
	* @since	Version 2
	* @author	元兒～ <yuan817@moztw.org>
	*/
	function table($inputName){
		global $FORM_PREFIX;
		return $FORM_PREFIX.$inputName;
	}
	
	// ========================================================================

	/**
	* form
	* TODO
	* 取得完整資料表名稱
	*
	* @access	public
	* @param	string	資料表名稱
	* @return	string	完整的資料表名稱
	* 
	* @since	Version 2
	* @author	元兒～ <yuan817@moztw.org>
	*/
	function getTheUserQuery($loggedCode){
		global $FORM_USER;
		$result = $this->prepare("SELECT * FROM ".$this->table($FORM_USER)." WHERE `username` = 'yuan817'");
		$result->bindParam(':loggedCode',$loggedCode);
		$result->execute();
		
		echo "f";
		echo $result->fetchColumn();
		
		return $result;
	}
	// ========================================================================
	/**
	* ErrorMsg
	*
	* 改寫Adodb -> ErrorMsg
	*
	* @access	public
	* @return	array	錯誤訊息
	* 
	* @since	2013.8.6
	* @author	shuliu <https://github.com/shuliu>
	* @source	https://github.com/shuliu/myPDO/blob/master/PDO.class.php
	*/
	function ErrorMsg(){
		$err = parent ::errorinfo();
		if( $err[0]!='00000' ){
			return array('errorCode'=>$err[0],'number'=>$err[1],'message'=>$err[2]);
		}else{
			return null;
		}
	}
	
 }