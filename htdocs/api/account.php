<?php
require_once("../lib/include.php");
require_once(DOCUMENT_ROOT."/lib/class/MyUser.php");

//-------------------設定區-----------------------//
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];
$op=(empty($_REQUEST['ucode']))?"":$_REQUEST['ucode'];

//---------------流程控制區----------------------//
switch($op){
//取得帳號資訊
case "get_info":
	
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