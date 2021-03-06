<?php
/**
 * 顯示通知訊息
 *
 * 需搭配Bootstrap 2.x 使用
 * @author CHU-TDAP
 * @link https://github.com/CHU-TDAP/
 * @version Version 1.0
 */
class Alert {

/**
 * 通知型態
 * @access private
 * @var string
 */
private $message_type;
/**
 * 是否要顯示成一塊
 * @access private
 * @var bool
 */
private $message_isBlock;
/**
 * 通知內容
 * @access private
 * @var string
 */
private $message_content;

/**
 * 建構子
 *
 * @access public
 * @param string 通知型態（warning, error, success, info）(選填)
 * @param bool 是否要顯示成一塊(選填)
 * @param string 通知內容(選填)
*/
function __construct(){
	//若帶入3個參數
	if(func_num_args() == 3) {
		//對應變數
		$args = func_get_args();
		$input_type = $args[0];
		$input_isBlock = $args[1];
		$input_content = $args[2];
		
		//設定通知內容
		$this->set($input_type, $input_isBlock, $input_content);
	}
	else {
		$this->set(null, null, null);
	}
}

// ========================================================================

/**
* 從Session取得通知訊息
*
* @access public
* @param string $message_category 通知session內的分類
*/
function getInSession($message_category){
	//啟動session
	if (!isset($_SESSION)) session_start();
	
	//若session內有通知資料
	if( isset($_SESSION["alert_".$message_category."_type"])
		&& isset($_SESSION["alert_".$message_category."_isBlock"])
		&& isset($_SESSION["alert_".$message_category."_content"]) 
	) {
		//將session資料紀錄到此物件內的變數
		$this->message_type = $_SESSION["alert_".$message_category."_type"];
		$this->message_isBlock = $_SESSION["alert_".$message_category."_isBlock"];
		$this->message_content = $_SESSION["alert_".$message_category."_content"];
	}
	
	
	//清除session資料
	unset($_SESSION["alert_".$message_category."_type"]);
	unset($_SESSION["alert_".$message_category."_isBlock"]);
	unset($_SESSION["alert_".$message_category."_content"]);
}
// ------------------------------------------------------------------------

/**
* 通知訊息紀錄到Session
*
* @access public
* @param string $message_category 通知session內的分類
*/
function setInSession($message_category){
	//啟動session
	if (!isset($_SESSION)) session_start();
	
	//紀錄到session
	$_SESSION["alert_".$message_category."_type"] = $this->message_type;
	$_SESSION["alert_".$message_category."_isBlock"] = $this->message_isBlock;
	$_SESSION["alert_".$message_category."_content"] = $this->message_content;

}

// ========================================================================

/**
* 設定通知訊息
*
* @access public
* @param string 通知型態（warning, error, success, info）
* @param bool 是否要顯示成一塊
* @param string 通知內容
*/
function set($input_type, $input_isBlock, $input_content){
	$this->message_type = $input_type;
	$this->message_isBlock = $input_isBlock;
	$this->message_content = $input_content;
}

// ------------------------------------------------------------------------
/**
* 輸出通知訊息
*
* @access public
*/
function show(){
	if($this->message_type){
		echo "<div class='alert fade in";
		switch($this->message_type){
			case "warning":
				echo "";
				break;
			case "error":
				echo " alert-error";
				break;
			case "success":
				echo " alert-success";
				break;
			case "info":
				echo " alert-info";
				break;
		}
		
		if($this->message_isBlock) {
			echo " alert-block";
		}
		echo "'>";
		
		echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
		echo $this->message_content;
		
		echo "</div>";
		
	}
}
	
}