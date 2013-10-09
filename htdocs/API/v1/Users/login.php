<?php
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."/lib/function/user.php");
require_once(DOCUMENT_ROOT."/lib/class/MyUser.php");
require_once(DOCUMENT_ROOT."lib/api/v1/apiTamplate.php");

//-------------------設定區-----------------------//
$action = (empty($_REQUEST['op']))?"":$_REQUEST['op'];

//---------------流程控制區----------------------//

//宣告輸出的陣列內容
$output = array();

switch($action){
case "login":
	$ID = $_REQUEST["uid"];
	$PWD = $_REQUEST["upasswd"];
	//登入使用者
	$login_code = user_login($ID,$PWD);
	
	//找不到此使用者
	if($login_code=="NoFound") {
		$output += array(
			"uid"=>$ID,
			"status"=>"NoFound"
		);
	}
	//帳號未啟用
	else if($login_code=="NoActiveErr") {
		$output += array(
			"uid"=>$ID,
			"status"=>"NoActiveErr"
		);
	}
	//密碼錯誤
	else if($login_code=="PasswdErr") {
		$output += array(
			"uid"=>$ID,
			"status"=>"PasswdErr"
		);
	}
	//資料庫錯誤
	else if($login_code=="DBErr") {
		$output += array(
			"uid"=>$ID,
			"status"=>"DBErr"
		);
	}
	//已登入成功
	else {
		$output += array(
			"uid"=>$ID,
			"code"=>$login_code
			"status"=>"OK"
		);
	}
	break;

case "logout":
	$logCode = $_REQUEST["ucode"];
	if( user_ishave() )
	$user = new MyUser($logCode);
	$user->logout();
	break;

case "test":
	$output = array("id"=>"test");
	$status = new APIStatus();
	$status->setSuccess();
	$output += array("status" => $status->getArray());
}

//---------------輸出區----------------------//
apitemplate_header();
echo json_encode($output);