<?php
require_once("../lib/include.php");
require_once(DOCUMENT_ROOT."/lib/function/user.php");
require_once(DOCUMENT_ROOT."/lib/class/MyUser.php");

$action = $_REQUEST['action'];

switch($action){

case "login":
	$ID = $_POST["mId"];
	$PWD = $_POST["mPassword"];
	$login_code = array(code=>user_login($ID,$PWD));
	echo json_encode($login_code);
	break;

case "logout":
	$logCode = $_POST["mCode"];
	$user = new MyUser($logCode);
	$user->logout();
	break;

}