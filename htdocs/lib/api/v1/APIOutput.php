<?php

/**
 * 前置設定
 * 
 * @since	Version 1
*/
require_once(DOCUMENT_ROOT."config/dev_config.php"); //取得除錯參數
require_once(DOCUMENT_ROOT."lib/api/v1/APIStatus.php"); //取得除錯參數
// ========================================================================

/**
 * APIServer
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
class APIOutput {
	
	private $output;
	
	/**
	 * 建構子
	 *
	 * @access	public
	*/
	function __construct() {
		$this->output = array();
	}
	// ========================================================================
	
	function addHeader() {
		
	}
	
	function addContent($input) {
		if($this->isUseLegal()) {
			$this->output += $input;
		}
		else {
			$apiErrMsg = new APIStatus();
			$apiErrMsg->setIllegal();
			$this->output += array("status"=>$apiErrMsg->getArray());
		}
	}
	
	function addFooter() {
		$this->output += array("about"=>$this->getAbout());
	}
	
	// ========================================================================
	
	function getArray() {
		return $this->output;
	}
	
	function getJsonString() {
		return json_encode($this->output);
	}
	
	function printJson() {
		echo json_encode($this->output);
	}
	
	// ========================================================================
	
 	function isUseLegal(/*$api_key*/) {
 		return true;
 	}
 	
 	
 	function getAbout() {
		$output = array(
			"last_edit"=>"none",
			"version"=>"1",
			"project"=>"chu-elearn"
		);
		return $output;
 	}
}