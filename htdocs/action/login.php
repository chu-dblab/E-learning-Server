<?php
require_once("../lib/include.php");
require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");
require_once(DOCUMENT_ROOT."lib/web/web_user_login.php");
// ------------------------------------------------------------------------

$action = $_REQUEST['action'];
$referer_page = $_SERVER["HTTP_REFERER"];
$next_page = $_REQUEST['next'];
// ------------------------------------------------------------------------

/**
 * @ignore
 */
function successToPage() {
	global $next_page;

	if(isset($next_page)) {
		header("Location: $next_page");
	}
	else {
		header("Location: ../index.php");
	}
}

/**
 * @ignore
 */
function errorToPage() {
	global $referer_page;
	
	if(isset($referer_page)) {
		header("Location: $referer_page");
	}
	else {
		header("Location: ../login.php");
	}
}

// ------------------------------------------------------------------------
switch($action){
case "login":
	
	$ID = $_POST["inputUsername"];
	$PWD = $_POST["inputPassword"];
	
	$loginCode = web_userLogin($ID, $PWD);
	
	//當使用者登入成功的話
	if($loginCode!="NoActiveErr" && $loginCode!="PasswdErr" && $loginCode!="DBErr" && $loginCode!="NoFound") {
		$theAlert = new Alert("success", false, "<strong>登入成功</strong> 已成功登入'$ID'帳號！");
		$theAlert->setInSession("user_login");
		successToPage();
	}
	//若登入失敗的話
	else {
		//產生失敗訊息
		switch($loginCode) {
		case "NoFound":
			$theAlert = new Alert("error", false, "<strong>無法登入！</strong> '$ID'帳號是不存在的喔～");
			break;
		case "PasswdErr":
			$theAlert = new Alert("error", false, "<strong>無法登入！</strong> '$ID'帳號的密碼是錯誤的喔～");
			break;
		case "NoActiveErr":
			$theAlert = new Alert("error", false, "<strong>無法登入！</strong> '$ID'帳號未啟用，請聯絡管理員");
			break;
		case "DBErr":
			$theAlert = new Alert("error", false, "<strong>無法登入！</strong> 資料庫內部錯誤");
			break;
		}
		$theAlert->setInSession("user_login");
		errorToPage();
	}
	break;

case "logout":
	web_userLogout();
	
	//產生登出成功訊息
	$theAlert = new Alert("success", false, "<strong>Bye!Bye！</strong> 已登出此帳號！");
	$theAlert->setInSession("user_login");
	
	successToPage();
	break;
}