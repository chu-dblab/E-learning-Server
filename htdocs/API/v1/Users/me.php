<?php
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
require_once(DOCUMENT_ROOT."lib/class/MyUser.php");

//-------------------設定區-----------------------//
$op = (empty($_REQUEST['op']))?null:$_REQUEST['op'];
$ucode = (empty($_REQUEST['ucode']))?null:$_REQUEST['ucode'];

$upasswd = (empty($_REQUEST['upasswd']))?null:$_REQUEST['upasswd'];
$upasswd_chg = (empty($_REQUEST['upasswd-new']))?null:$_REQUEST['upasswd-new'];
$upasswd_chgrep = (empty($_REQUEST['upasswd-new-rep']))?null:$_REQUEST['upasswd-new-rep'];

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
				"logincode"=>$ucode,
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

//---------------流程控制區----------------------//
//宣告輸出的陣列內容
$output = array();

switch($op){
//取得帳號資訊
case "get_info":
	$output += array("action"=>"get_info");
	
	if( createUserObj() ) {
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
			"status_ok"=>true,
			"status"=>"OK"
		);
	}
	
//更改密碼
case "chg_passwd":
	$output += array("action"=>"chg_passwd");
	
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
case "chk_passwd":
	$output += array("action"=>"chk_passwd");
	
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