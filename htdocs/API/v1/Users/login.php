<?php
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."/lib/function/user.php");
require_once(DOCUMENT_ROOT."/lib/class/MyUser.php");
require_once(DOCUMENT_ROOT."lib/api/v1/APIOutput.php");
require_once(DOCUMENT_ROOT."lib/api/v1/APIStatus.php");

//-------------------設定區-----------------------//
$action=(empty($_REQUEST['op']))?"":$_REQUEST['op'];

//---------------流程控制區----------------------//



//宣告輸出的陣列內容
$output = array();

switch($action){
case "login":
	$ID = $_REQUEST["uid"];
	$PWD = $_REQUEST["upasswd"];
	$login_code = array("code"=>user_login($ID,$PWD));
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
	$status->setID(200000);
	$output += array("status" => $status->getArray());
}

$apiOutput = new APIOutput();

$apiOutput->addHeader();
$apiOutput->addContent($output);
$apiOutput->addFooter();
$apiOutput->printJson();
