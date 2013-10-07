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
	private $content;
	
	// ========================================================================
	
	/**
	 * 建構子
	 *
	 * @access	public
	*/
	function __construct() {
		
	}
	// ========================================================================
	
 	function setID($setid) {
		$this->ID = $setid;
 	}
	// ------------------------------------------------------------------------
	
	function setContent($input) {
		$this->content = $input;
	}
	// ------------------------------------------------------------------------
	function getArray() {
		$output = array(
			"id" => $this->ID,
			"description" => null,
			"content" => $this->content
		);
		return $output;
	}
	// ------------------------------------------------------------------------

	function getJsonString() {
		return json_encode( $this->getArray() );
	}
	// ------------------------------------------------------------------------

	function printJson() {
		$output = array("status"=>$this->getArray());
		echo json_encode( $output );
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