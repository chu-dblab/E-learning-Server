<?php
/**
 * 前置設定
*/
require_once("../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/function/user.php");

/**
 *
*/
$action = $_GET['action'];
$userid = $_GET['userid'];

if(isset($_SESSION["back_verifyCode"]) && $_SESSION["back_verifyCode"]==$_GET['token']){
	//驗證成功
	switch($action){
		case "update":
			
			break;
		case "delete":
			
			break;
	}
}
else{
	//驗證失敗
	
}