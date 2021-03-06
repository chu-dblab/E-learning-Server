<?php
/** 
 * 資料庫連接專用類別庫
 */

// 前置設定
require_once(DOCUMENT_ROOT."config/dev_config.php"); //取得除錯參數
require_once(DOCUMENT_ROOT."config/db_config.php"); //取得連結資料庫連結變數

/**
 * 資料庫連接專用類別
 *
 * @extends PDO
 * @author CHU-TDAP
 * @link https://github.com/CHU-TDAP/
 * @version Version 1.0
 * @see https://github.com/shuliu/myPDO
 */
class Database extends PDO {
	/**
	 * 建構子
	 *
	 * @access	public
	 * @global string $DB_SERV 在/config/db_config.php的資料庫URL
	 * @global string $DB_NAME 在/config/db_config.php的資料庫名稱
	 * @global string $DB_USER 在/config/db_config.php的資料庫帳號
	 * @global string $DB_PASS 在/config/db_config.php的資料庫密碼
	 */
	public function __construct(){
		global $DB_SERV, $DB_NAME, $DB_USER, $DB_PASS;
		parent::__construct("mysql:dbname={$DB_NAME};host:{$DB_SERV};charset=utf8", $DB_USER, $DB_PASS);

		//配合PHP< 5.3.6 PDO沒有charset用的
		//參考: http://gdfan1114.wordpress.com/2013/06/24/php-5-3-6-%E7%89%88-pdo-%E9%85%8D%E5%90%88%E5%AD%98%E5%8F%96%E8%B3%87%E6%96%99%E5%BA%AB%E6%99%82%E7%9A%84%E4%B8%AD%E6%96%87%E5%95%8F%E9%A1%8C/
		$this->exec("set names utf8");
		
	}
	// ========================================================================

	/**
	* 取得帶有前綴字元的完整資料表名稱
	*
	* @access public
	* @param string $inputName 資料表名稱
	* @return string 完整的資料表名稱
	* 
	* @version	Version 2
	* @author	元兒～ <yuan817@moztw.org>
	*/
	public function table($inputName){
		global $FORM_PREFIX;
		return $FORM_PREFIX.$inputName;
	}
	
	// ========================================================================
	/**
	* 錯誤訊息的陣列
	*
	* 改寫Adodb -> ErrorMsg
	*
	* @access public
	* @return array 錯誤訊息
	* 
	* @since 2013.8.6
	* @author shuliu <https://github.com/shuliu>
	* @see https://github.com/shuliu/myPDO/blob/master/PDO.class.php
	*/
	public function ErrorMsg(){
		$err = parent ::errorinfo();
		if( $err[0]!='00000' ){
			return array('errorCode'=>$err[0],'number'=>$err[1],'message'=>$err[2]);
		}else{
			return null;
		}
	}
	
 }