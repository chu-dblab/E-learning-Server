<?php
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
require_once(DOCUMENT_ROOT."lib/class/MyUser.php");

//-------------------設定區-----------------------//
$op = ( isset( $_REQUEST['op']) )?$_REQUEST['op']:null;
$ucode = ( isset($_REQUEST['ucode']) )?$_REQUEST['ucode']:null;

$upasswd = ( isset($_REQUEST['upasswd']) )?$_REQUEST['upasswd']:null;
$upasswd_chg = ( isset($_REQUEST['upasswd-new']) )?$_REQUEST['upasswd-new']:null;

$realname_chg = ( isset($_REQUEST['urealname-new']) )?$_REQUEST['urealname-new']:null;
$nickname_chg = ( isset($_REQUEST['unickname-new']) )?$_REQUEST['unickname-new']:null;
$email_chg = ( isset($_REQUEST['uemail-new']) )?$_REQUEST['uemail-new']:null;


//---------------函式區----------------------//
function createUserObj() {
	global $ucode, $output, $theUser;
	
	//有輸入登入碼
	if( isset($ucode) ) {
		//建立此使用者物件
		$theUser = new MyUser($ucode);
		
		//未找到此使用者
		if( !$theUser->isLogged() ) {
			$output += array(
				"ucode"=>$ucode,
				"status_ok"=>false,
				"status"=>"NoUserFound"
			);
		}
		//找到此使用者
		else {
			return true;
		}
	}
	//未輸入登入碼
	else {
		$output += array(
			"status_ok"=>false,
			"status"=>"CmdErr"
		);
		return false;
	}
}

function outputUserInfo() {
	global $theUser;
	$output = array(
		"uid" => $theUser->getUsername(),
		"ulogin_time" => $theUser->getLoginTime(),
		"ucreate_time" => $theUser->getCreateTime(),
		"ugid" => $theUser->getGroup(),
		"uauthlist" => $theUser->getPermissionList(),
		"ugname" => $theUser->getGroupName(),
		"uname" => $theUser->getName(),
		"urealname" => $theUser->getRealName(),
		"unickname" => $theUser->getNickName(),
		"uemail" => $theUser->getEmail()
	);
	
	return $output;
}

//---------------流程控制區----------------------//
//宣告輸出的陣列內容
$output = array();

switch($op){
//取得帳號資訊
case "get-info":
	$output += array("action"=>"get-info");
	
	if( createUserObj() ) {
		$output += array(
			"ucode"=>$ucode,
		);
		
		$output += outputUserInfo();
		
		$output += array(
			"status_ok"=>true,
			"status"=>"OK"
		);
	}
	
//更改密碼
case "chg-passwd":
	$output += array("action"=>"chg-passwd");
	
	//有輸入資料
	if( isset($upasswd) && isset($upasswd_chg)) {
		if( createUserObj() ) {
			$result = $theUser->changePassword($upasswd, $upasswd_chg);
			
			if($result == "CurrentPasswdErr") {
				$output += array(
					"uid" => $theUser->getUsername(),
					"ischanged"=>false,
					"status_ok"=>false,
					"status"=>"CurrentPasswdErr"
				);
			}
			else if($result == "Finish") {
				$output += array(
					"uid" => $theUser->getUsername(),
					"ischanged"=>true,
					"status_ok"=>true,
					"status"=>"OK"
				);
			}
			else {
				$output += array(
					"uid" => $theUser->getUsername(),
					"ischanged"=>false,
					"status_ok"=>false,
					"status"=>"InErr"
				);
			}
			$output += array(
				"uid" => $theUser->getUsername(),
				"iscorrect" => $theUser->isPasswordCorrect($upasswd)
			);
			
		}
	}
	//未輸入資料
	else {
		$output += array(
			"status_ok"=>false,
			"status"=>"CmdErr"
		);
	}
	
	break;

//檢查密碼
case "chk-passwd":
	$output += array("action"=>"chk-passwd");
	
	//有輸入資料
	if( isset($upasswd) ) {
		if( createUserObj() ) {
			$output += array(
				"uid" => $theUser->getUsername(),
				"iscorrect" => $theUser->isPasswordCorrect($upasswd)
			);
			$output += array(
				"status_ok"=>true,
				"status"=>"OK"
			);
		}
	}
	//未輸入資料
	else {
		$output += array(
			"status_ok"=>false,
			"status"=>"CmdErr"
		);
	}
	
	break;

//取得權限資訊
case "get-auth":
	
	break;

//更改名字
case "chg-realname":
	$output += array("action"=>"chg-realname");
	
	//有輸入資料
	if( isset($realname_chg)) {
		if( createUserObj() ) {
			$result = $theUser->setRealName($realname_chg);
			
			//更改資料
			$output += array(
				"uid" => $theUser->getUsername(),
				"urealname" => $realname_chg,
				"ischanged"=>true,
				"status_ok"=>true,
				"status"=>"OK"
			);
		}
	}
	//未輸入資料
	else {
		$output += array(
			"status_ok"=>false,
			"status"=>"CmdErr"
		);
	}
	
	break;

//更改暱稱
case "chg-nickname":
	$output += array("action"=>"chg-nickname");
	
	//有輸入資料
	if( isset($nickname_chg)) {
		if( createUserObj() ) {
			$result = $theUser->setNickName($nickname_chg);
			
			//更改資料
			$output += array(
				"uid" => $theUser->getUsername(),
				"unickname" => $nickname_chg,
				"ischanged"=>true,
				"status_ok"=>true,
				"status"=>"OK"
			);
		}
	}
	//未輸入資料
	else {
		$output += array(
			"status_ok"=>false,
			"status"=>"CmdErr"
		);
	}
	
	break;
	
//更改email
case "chg-email":
	$output += array("action"=>"chg-email");
	
	//有輸入資料
	if( isset($email_chg)) {
		if( createUserObj() ) {
			$result = $theUser->setEmail($email_chg);
			
			//更改資料
			$output += array(
				"uid" => $theUser->getUsername(),
				"uemail" => $email_chg,
				"ischanged"=>true,
				"status_ok"=>true,
				"status"=>"OK"
			);
		}
	}
	//未輸入資料
	else {
		$output += array(
			"status_ok"=>false,
			"status"=>"CmdErr"
		);
	}
	
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