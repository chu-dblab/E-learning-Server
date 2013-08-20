<?php
/**
 * 前置設定
*/
require_once("../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/userGroup.php");

/**
 *
*/

//帶入使用者輸入的資料
$register_userGroup_id = $_POST["userGroup_id"];
$register_userGroup_displayName = $_POST["userGroup_displayName"];
$register_userGroup_admin = false;
if($_POST["userGroup_admin"]){
	$register_userGroup_admin = true;
}

//若為填入顯示名稱的話，顯示名稱即和內部名稱一樣
if(!$register_userGroup_displayName) {
	$register_userGroup_displayName = $register_userGroup_id;
}

//debug
echo $register_userGroup_id."<br />";
echo $register_userGroup_displayName."<br />";
echo $register_userGroup_admin."<br />";


$account_create_status = userGroup_create($register_userGroup_id, $register_userGroup_displayName, $register_userGroup_admin);

if($account_create_status == "Finish"){
	$status_message = "<strong>建立成功！</strong>";
	$status_message .= " '$register_user_id'已成功建立！！";
	
	//利用session傳回錯誤訊息
	session_start();
	$_SESSION["userGroup_create_status"] = $account_create_status;
	$_SESSION["userGroup_create_status_message"] = $status_message;
 	header("Location: ../userGroup_manager.php");
}
else{
	$status_message = "<strong>無法建立！</strong>";
	
	switch($account_create_status){
		case "NameCreatedErr":
			$status_message .= " '$register_userGroup_id'名稱已經使用了喔～";
			break;
		case "DBErr":
			$status_message .= " 資料庫錯誤";
			break;
	}
	
	//利用session傳回錯誤訊息
	session_start();
	$_SESSION["userGroup_create_status"] = $account_create_status;
	$_SESSION["userGroup_create_status_message"] = $status_message;
 	header("Location: ../userGroup_manager.php");
}