<?php
/**
 * 前置設定
*/
require_once("../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/function/user.php");
require_once(DOCUMENT_ROOT."lib/class/User.php");
require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");

/**
 * 取得傳過來的填入的資料
*/
$action = $_POST['action'];
if(isset($_POST["select_UID"])) {
	$select_UID = $_POST["select_UID"];
}

/**
 * 測試用的顯示
*/
//echo "action:".$action;
//echo '<pre>', print_r($select_UID, true), '</pre>';

/**
 * 對帳號進行處理
*/
//如果有選擇哪些使用者帳號
if(!isset($select_UID)) {
	//產生錯誤訊息
	$theAlert = new Alert("error", false, "<strong>尚未處理！</strong>  你忘了選擇要套用哪位使用者喔～");
	$theAlert->setInSession("user_process");
	//回到原本的那一頁
	header("Location: ../user_list.php");
}
//沒有問題，進行處理
else {
	//TODO 防呆處理: 若處理途中有失敗的處理
	//宣告這帳號的處理狀態變數
	$select_UID_status = array();
	
	//針對所有選取的帳號
	foreach($select_UID as $key=>$thisUID){
		//選取什麼動作
		switch($action){
			case "enable":
				//設定這個帳號啟用
				$thisUser = new User($thisUID);
				$thisUID_status = $thisUser->setEnable(true);
				//$thisUID_status = user_setEnable($thisUID, true);
				//將設定結果紀錄到$select_UID_status陣列
				$select_UID_status += array($thisUID=>$thisUID_status);
				break;
			case "disable":
				//設定這個帳號停用
				$thisUser = new User($thisUID);
				$thisUID_status = $thisUser->setEnable(false);
				//$thisUID_status = user_setEnable($thisUID, false);
				//將設定結果紀錄到$select_UID_status陣列
				$select_UID_status += array($thisUID=>$thisUID_status);
				break;
			case "remove":
				//TODO 移除動作
				break;
			case "logout":
				//登出這個帳號
				$thisUser = new User($thisUID);
				$thisUID_status = $thisUser->logout();
				//$thisUID_status = user_logout($thisUID);
				//將設定結果紀錄到$select_UID_status陣列
				$select_UID_status += array($thisUID=>$thisUID_status);
				break;
			case "change-userGroup":
				//取得填入的選擇群組欄位
				$user_group = $_POST["user_group"];
				
				//更換使用者群組
				$thisUser = new User($thisUID);
				$thisUID_status = $thisUser->setGroup($user_group);
				//$thisUID_status = user_setGroup($thisUID, $user_group);
				//將設定結果紀錄到$select_UID_status陣列
				$select_UID_status += array($thisUID=>$thisUID_status);
				break;
		}
		
	}
	echo '<pre>', print_r($select_UID_status, true), '</pre>';
	
	//產生成功訊息
	$theAlert = new Alert("success", true, "<h4>處理完成！</h4><p><pre>".print_r($select_UID_status, true)."</pre></p>");
	$theAlert->setInSession("user_process");
	//回到原本的那一頁
	header("Location: ../user_list.php");
}

/*if(isset($_SESSION["back_verifyCode"]) && $_SESSION["back_verifyCode"]==$_GET['token']){
	//驗證成功
	
}
else{
	//驗證失敗
	
}*/