<?php
require_once("../lib/include.php");
require_once(DOCUMENT_ROOT."/lib/class/MyUser.php");

//-------------------設定區-----------------------//
$op = (empty($_REQUEST['op']))?"":$_REQUEST['op'];
$ucode = (empty($_REQUEST['ucode']))?"":$_REQUEST['ucode'];

//---------------流程控制區----------------------//
switch($op){
//取得帳號資訊
case "get_info":
	
	//宣告輸出的陣列內容
	$output = array();
	
	//建立此使用者物件
	$theUser = new MyUser($ucode);
	
	//未找到此使用者
	//if() {
	//	$output = array();
	//}
	////找到此使用者
	//else {
		$output = array();
		$output += array("uid"=>$theUser->getUsername());
		$output += array("ulogin_time"=>$theUser->getLoginTime());
		$output += array("ucreate_time"=>$theUser->getCreateTime());
		$output += array("ugid"=>$theUser->getGroup());
		$output += array("ugname"=>$theUser->getGroupName());
		$output += array("urealname"=>$theUser->getRealName());
		$output += array("unickname"=>$theUser->getNickName());
		$output += array("uemail"=>$theUser->getEmail());
	//}
	
	//以json輸出帳號資訊
	echo json_encode($output);
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
	

}