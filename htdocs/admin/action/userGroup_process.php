<?php
/**
 * 前置設定
*/
require_once("../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/function/userGroup.php");
require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");


/**
 * 取得傳過來的填入的資料
*/
$action = $_REQUEST['action'];

/**
 * 對單一群組進行處理
*/
switch($action){
	case "edit-data":
		//取得填入的選擇群組欄位
		$input_gid = $_POST["edit-userGroup_GID"];
		$input_displayName = $_POST["edit-userGroup_displayName"];
		//TODO 權限設定
		
		//此帳號不存在
		if(!userGroup_ishave($input_gid)) {
			//產生失敗訊息
			$theAlert = new Alert("error", false, "<strong>操作失敗！</strong> '$input_gid'群組是不存在的喔～");
		}
		//沒問題
		else {
			//更換資料
			userGroup_setDiaplayName($input_gid, $input_displayName);
			
			//產生成功訊息
			$theAlert = new Alert("success", false, "<strong>處理完成！</strong> $input_gid 資料更改完成");
		}
		
		//設定通知訊息
		$theAlert->setInSession("userGroup_process");
		//回到原本的那一頁
		header("Location: ../userGroup_manager.php");
		break;
	
	case "remove":
		//取得填入的選擇群組欄位
		$input_gid = $_POST["edit-userGroup_GID"];
		
		//移除這個群組
		$status = userGroup_remove($input_gid);
		
		switch($status) {
			case "NoFound":
				//產生失敗訊息
				$theAlert = new Alert("error", false, "<strong>移除失敗！</strong> '$input_gid'群組是不存在的喔～");
				break;
			case "UserExist":
				//產生失敗訊息
				$theAlert = new Alert("error", false, "<strong>移除失敗！</strong> '$input_gid'群組尚有人在～");
				break;
			case "DBErr":
				//產生失敗訊息
				$theAlert = new Alert("error", false, "<strong>移除失敗！</strong> 資料庫出錯");
				break;
			case "Finish":
				//產生成功訊息
				$theAlert = new Alert("success", false, "<strong>移除完成！</strong> 此群組已成功移除");
				break;
		}
		
		//設定通知訊息
		$theAlert->setInSession("userGroup_process");
		//回到原本的那一頁
		header("Location: ../userGroup_manager.php");
}