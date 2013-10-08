<?php
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."/lib/function/user.php");
require_once(DOCUMENT_ROOT."/lib/class/MyUser.php");
require_once(DOCUMENT_ROOT."lib/api/v1/APIOutput.php");
require_once(DOCUMENT_ROOT."lib/api/v1/APIStatus.php");

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
			"uid"=>$ID
		);
		
		$status = new APIStatus(404010);
		$output += $status->getArray();
	}
	
	else if($login_code=="NoActiveErr") {
	
	}
	else if($login_code=="PasswdErr") {
	
	}
	else if($login_code=="DBErr") {
	
	}
	//已登入成功
	else {
		$output += array(
			"uid"=>$ID,
			"code"=>$login_code
		);
		
		$status = new APIStatus(200000);
		$output += $status->getArray();
	}
	
	
	echo json_encode($login_code);
	break;

case "logout":
	$logCode = $_REQUEST["ucode"];
	$user = new MyUser($logCode);
	$user->logout();
	break;

case "test":
	$output = array("id"=>"test");
	$status = new APIStatus();
	$status->setSuccess();
	$output += array("status" => $status->getArray());
}
echo json_encode($output);