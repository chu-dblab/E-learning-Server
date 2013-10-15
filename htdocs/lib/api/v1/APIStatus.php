<?php

/**
 * 前置設定
 * 
 * @since	Version 1
*/
require_once(DOCUMENT_ROOT."config/dev_config.php"); //取得除錯參數
// ========================================================================

/**
 * APIStatus
 *
 *
 * @package	CHU-E-learning
 * @author		CHU-TDAP
 * @copyright	
 * @license		type filter text
 * @link		https://github.com/CHU-TDAP/
 * @since		Version 1.0
 * @filesource
*/
class APIStatus {
	private $ID;
	
	// ========================================================================
	
	/**
	 * 建構子
	 *
	 * @access	public
	*/
	function __construct() {
		//若帶入兩個參數
		if(func_num_args() == 1){
			//對應變數
			$args = func_get_args();
			$setid = $args[0];
			
			//動作
			$this->setID($setid);
		}
	}
	// ========================================================================
	
	/**
	 * 設定狀態碼
	 *
	 * @access	public
	 * @param	string	狀態碼
	 * @return	string	狀態回傳
				"Finish": 密碼更改完成
	 * 
	 * @since	Version 0
	 */
 	function setID($setid) {
		$this->ID = $setid;
 	}

	// ========================================================================
	
	/**
	 * 取得狀態陣列
	 *
	 * @access	public
	 * @return	string	狀態陣列
				id: 狀態碼
				description: 狀態描述
				content: 詳細的狀態內容
	 * 
	 * @since	Version 0
	 */
	function getArray() {
		$output = array(
			"status_id" => $this->ID,
			"status_description" => null,
		);
		return $output;
	}
	// ------------------------------------------------------------------------

	function getJsonString() {
		return json_encode( $this->getArray() );
	}
	// ------------------------------------------------------------------------

	function printJson() {
		echo json_encode( $this->getArray() );
	}
	
	// ========================================================================
	
	function setSuccess() {
		$this->setID(200000);
	}
	
	//API Key錯誤
	function setIllegal() {
		$this->setID(403001);
	}
}