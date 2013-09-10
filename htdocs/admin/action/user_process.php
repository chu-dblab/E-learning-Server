<?php
/**
 * 前置設定
*/
require_once("../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/function/user.php");
require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");

/**
 *
*/
$action = $_POST['action'];
if(isset($_POST["select_UID"])) {
	$select_UID = $_POST["select_UID"];
}

//echo "action:".$action;
//echo '<pre>', print_r($select_UID, true), '</pre>';

if(!isset($select_UID)) {
	
	$theAlert = new Alert("error", false, "<strong>尚未處理！</strong>  你忘了選擇要套用哪位使用者喔～");
	$theAlert->setInSession("user_process");

 	header("Location: ../user_list.php");
}

if(isset($_SESSION["back_verifyCode"]) && $_SESSION["back_verifyCode"]==$_GET['token']){
	//驗證成功
	switch($action){
		case "enable":
			
			break;
		case "disable":
			
			break;
		case "remove":
			
			break;
		case "logout":
			
			break;
		case "change-userGroup":
			$user_group = $_POST["user_group"];
			break;
	}
}
else{
	//驗證失敗
	
}