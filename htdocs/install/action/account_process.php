<?php
/**
 * 前置設定
*/
require_once("../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/user.php");

/**
 *
*/

//帶入使用者輸入的資料
$register_user_id = $_POST["user_id"];
$register_user_password = $_POST["user_password"];
$register_user_confirm_password = $_POST["user_confirm_password"];
$register_user_active = $_POST["user_active"];
$register_user_realName = $_POST["user_realName"];
$register_user_nickName = $_POST["user_nickName"];
$register_user_email = $_POST["user_email"];

//debug
echo $register_user_id."<br />";
echo $register_user_password."<br />";
echo $register_user_confirm_password."<br />";
echo $register_user_active."<br />";
echo $register_user_realName."<br />";
echo $register_user_nickName."<br />";
echo $register_user_email."<br />";

if($register_user_active) {
	echo "True"."<br />";
}


$account_create_status = user_create($register_user_id, $register_user_password, $register_user_confirm_password, $register_user_active, $register_user_realName, $register_user_nickName, $register_user_email);

if($account_create_status == "Finish"){
	$status_message = "<strong>建立成功！</strong>";
	$status_message .= " '$register_user_id'已成功建立！！";
	
	//利用session傳回錯誤訊息
	session_start();
	$_SESSION["user_create_status"] = $account_create_status;
	$_SESSION["user_create_status_message"] = $status_message;
 	header("Location: ../account_list.php");
}
else{
	$status_message = "<strong>無法建立！</strong>";
	
	switch($account_create_status){
		case "UsernameCreatedErr":
			$status_message .= " '$register_user_id'名稱已經有人使用了喔～";
			break;
		case "RepPasswdErr":
			$status_message .= " 確認密碼錯誤，請重新再試";
			break;
	}
	
	//利用session傳回錯誤訊息
	session_start();
	$_SESSION["user_create_status"] = $account_create_status;
	$_SESSION["user_create_status_message"] = $status_message;
 	header("Location: ../account_create.php");
}