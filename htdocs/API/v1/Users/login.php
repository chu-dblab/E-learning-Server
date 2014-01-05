<?php
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
require_once(DOCUMENT_ROOT."lib/function/user.php");
require_once(DOCUMENT_ROOT."lib/class/MyUser.php");

//-------------------設定區-----------------------//
$action = ( isset($_REQUEST['op']) )?$_REQUEST['op']:null;
$id = ( isset($_REQUEST['uid']) )?$_REQUEST['uid']:null;
$pwd = ( isset($_REQUEST['upasswd']) )?$_REQUEST['upasswd']:null;
$logCode = ( isset($_REQUEST['ucode']) )?$_REQUEST['ucode']:null;

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
				"status_ok"=>false,
				"status"=>"NoFound"
			);
		}
		//帳號未啟用
		else if($login_code=="NoActiveErr") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"NoActiveErr"
			);
		}
		//密碼錯誤
		else if($login_code=="PasswdErr") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"PasswdErr"
			);
		}
		//資料庫錯誤
		else if($login_code=="DBErr") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"DBErr"
			);
		}
		//已登入成功
		else {
			$output += array(
				"uid"=>$id,
				"ucode"=>$login_code,
				"status_ok"=>true,
				"status"=>"OK"
			);
		}
	}
	//未填入登入資料
	else {
		$output += array(
			"status_ok"=>false,
			"status"=>"CmdErr"
		);
	}
	break;
	
//登入此使用者驗證
case "check-login":
	$output += array("action"=>"login");
	//有填入登入資料
	if(isset($id) && isset($pwd)) {
		//登入使用者
		$isLoginEnable = user_isLoginEnable($id,$pwd);
		
		//找不到此使用者
		if($isLoginEnable=="NoFound") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"NoFound"
			);
		}
		//帳號未啟用
		else if($isLoginEnable=="NoActiveErr") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"NoActiveErr"
			);
		}
		//密碼錯誤
		else if($isLoginEnable=="PasswdErr") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"PasswdErr"
			);
		}
		//資料庫錯誤
		else if($isLoginEnable=="DBErr") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"DBErr"
			);
		}
		//已登入成功
		else {
			$output += array(
				"uid"=>$id,
				"status_ok"=>true,
				"status"=>"OK"
			);
		}
	}
	//未填入登入資料
	else {
		$output += array(
			"status_ok"=>false,
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
				"ucode"=>$logCode,
				"uid"=>$userid,
				"status_ok"=>true,
				"status"=>"OK"
			);
		}
		else {
			$output += array(
				"ucode"=>$logCode,
				"status_ok"=>false,
				"status"=>"NoUserFound"
			);
		}
	}
	//未填入登入碼
	else {
		$output += array(
			"status_ok"=>false,
			"status"=>"CmdErr"
		);
	}
	break;

//這個帳號使否可登入
case "is_login_enable":
	$output += array("action"=>"is_login_enable");
	//有填入登入資料
	if(isset($id) && isset($pwd)) {
		//登入使用者
		$result = user_isLoginEnable($id,$pwd);
		
		//找不到此使用者
		if($result=="NoFound") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"NoFound"
			);
		}
		//帳號未啟用
		else if($result=="NoActiveErr") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"NoActiveErr"
			);
		}
		//密碼錯誤
		else if($result=="PasswdErr") {
			$output += array(
				"uid"=>$id,
				"status_ok"=>false,
				"status"=>"PasswdErr"
			);
		}
		//可登入
		else {
			$output += array(
				"uid"=>$id,
				"status_ok"=>true,
				"status"=>"OK"
			);
		}
	}
	//未填入登入資料
	else {
		$output += array(
			"status_ok"=>false,
			"status"=>"CmdErr"
		);
	}
	break;
	
default:
	$output += array(
		"status_ok"=>false,
		"status"=>"CmdErr"
	);
}

//---------------輸出區----------------------//
apitemplate_header();
echo json_encode($output);