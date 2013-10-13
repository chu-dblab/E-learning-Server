<?php
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
require_once(DOCUMENT_ROOT."lib/class/MyUser.php");

//-------------------設定區-----------------------//
$op = (empty($_REQUEST['op']))?null:$_REQUEST['op'];
$ucode = (empty($_REQUEST['ucode']))?null:$_REQUEST['ucode'];

//---------------流程控制區----------------------//
//宣告輸出的陣列內容
$output = array();

switch($op){
//取得帳號資訊
case "get_info":
	$output += array("action"=>"get-info");
	
	//有輸入登入碼
	if( isset($ucode) ) {
		//建立此使用者物件
		$theUser = new MyUser($ucode);
		
		//未找到此使用者
		if( !$theUser->isLogged() ) {
			$output += array(
				"logincode"=>$ucode,
				"status"=>"NoUserFound"
			);
		}
		//找到此使用者
		else {
			$output += array(
				"logincode"=>$ucode,
			);
			
			$output += array(
				"uid" => $theUser->getUsername(),
				"ulogin_time" => $theUser->getLoginTime(),
				"ucreate_time" => $theUser->getCreateTime(),
				"ugid" => $theUser->getGroup(),
				"ugname" => $theUser->getGroupName(),
				"urealname" => $theUser->getRealName(),
				"unickname" => $theUser->getNickName(),
				"uemail" => $theUser->getEmail()
			);
			
			$output += array(
				"status"=>"OK"
			);
		}
	}
	//未輸入登入碼
	else {
		$output += array(
			"status"=>"CmdErr"
		);
	}
	
	break;
	
//更改密碼
case "chg_passwd":
	
	
	break;

//檢查密碼
case "chk_passwd":
	
	break;

//取得權限資訊
case "get_auth":
	
	break;

//更改名字
case "chg_realname":
	
	break;

//更改暱稱
case "chg_nickname":
	
	break;
	
//更改email
case "chg_email":
	
	break;

//其他動作
default:
	$output += array(
		"status"=>"CmdErr"
	);

}

//---------------輸出區----------------------//
apitemplate_header();
echo json_encode($output);