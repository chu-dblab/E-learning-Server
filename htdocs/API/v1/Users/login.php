<?php
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/function/user.php");
require_once(DOCUMENT_ROOT."lib/class/MyUser.php");
require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");

//-------------------設定區-----------------------//
$action = (empty($_REQUEST['op']))?null:$_REQUEST['op'];
$id = (empty($_REQUEST['uid']))?null:$_REQUEST['uid'];
$pwd = (empty($_REQUEST['upasswd']))?null:$_REQUEST['upasswd'];
$logCode = (empty($_REQUEST['ucode']))?null:$_REQUEST['ucode'];

//---------------流程控制區----------------------//

//宣告輸出的陣列內容
$output = array();

switch($action){
//登入此使用者
case "login":
	$output += array("action"=>"login");
	//有填入登入資料
	if(isset($id) && isset($pwd)) {
		//登入使用者
		$login_code = user_login($id,$pwd);
		
		//找不到此使用者
		if($login_code=="NoFound") {
			$output += array(
				"uid"=>$id,
				"status"=>"NoFound"
			);
		}
		//帳號未啟用
		else if($login_code=="NoActiveErr") {
			$output += array(
				"uid"=>$id,
				"status"=>"NoActiveErr"
			);
		}
		//密碼錯誤
		else if($login_code=="PasswdErr") {
			$output += array(
				"uid"=>$id,
				"status"=>"PasswdErr"
			);
		}
		//資料庫錯誤
		else if($login_code=="DBErr") {
			$output += array(
				"uid"=>$id,
				"status"=>"DBErr"
			);
		}
		//已登入成功
		else {
			$output += array(
				"uid"=>$id,
				"logincode"=>$login_code,
				"status"=>"OK"
			);
		}
	}
	//未填入登入資料
	else {
		$output += array(
			"status"=>"CmdErr"
		);
	}
	break;

//登出此使用者
case "logout":
	$output += array("action"=>"logout");
	//有填入登入碼
	if(isset($logCode)) {
		$user = new MyUser($logCode);
		if( $user->isLogged() ) {
			$userid = $user->getUsername();
			$user->logout();
			$output += array(
				"logincode"=>$logCode,
				"uid"=>$userid,
				"status"=>"OK"
			);
		}
		else {
			$output += array(
				"logincode"=>$logCode,
				"status"=>"NoUserFound"
			);
		}
	}
	//未填入登入碼
	else {
		$output += array(
			"status"=>"CmdErr"
		);
	}
	break;

//這個帳號使否可登入
case "is-login-enable":
	$output += array("action"=>"is-login-enable");
	//有填入登入資料
	if(isset($id) && isset($pwd)) {
		//登入使用者
		$result = user_isLoginEnable($id,$pwd);
		
		//找不到此使用者
		if($result=="NoFound") {
			$output += array(
				"uid"=>$id,
				"status"=>"NoFound"
			);
		}
		//帳號未啟用
		else if($result=="NoActiveErr") {
			$output += array(
				"uid"=>$id,
				"status"=>"NoActiveErr"
			);
		}
		//密碼錯誤
		else if($result=="PasswdErr") {
			$output += array(
				"uid"=>$id,
				"status"=>"PasswdErr"
			);
		}
		//已登入成功
		else {
			$output += array(
				"uid"=>$id,
				"status"=>"OK"
			);
		}
	}
	//未填入登入資料
	else {
		$output += array(
			"status"=>"CmdErr"
		);
	}
	break;
	
default:
	$output += array(
		"status"=>"CmdErr"
	);
}

//---------------輸出區----------------------//
apitemplate_header();
echo json_encode($output);