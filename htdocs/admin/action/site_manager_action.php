<?php
/**
 * 前置設定
*/
require_once("../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/function/database.php");
require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");

/**
 *
*/
$action = $_GET['action'];

switch($action){
	//更改資料庫所有資料表的前綴字元
	case "rename_db_prefix":
		//帶入使用者輸入的資料
		$inputSqlPrefix = $_POST["inputSqlPrefix"];
		
		//更改資料庫資料表的前綴字元
		$result = db_rename_prefix($inputSqlPrefix);
		
		//更改完成，並成功寫入設定檔
		if($result == "Finish") {
			//送出通知訊息
			$theAlert = new Alert("success", false, "<strong>更改完成！</strong>  已將資料庫資料表的前綴字元改成 '$inputSqlPrefix'！！");
			$theAlert->setInSession("site_manager");
			
			//回到網站管理頁面
			header("Location: ../site_manager.php");
		}
		//更改完成，但無法寫入設定檔
		else {
			//送出通知訊息
			$theAlert = new Alert("warning", true, "<h4>需手動更改設定檔！</h4>
			<p>雖然已將資料庫資料表的前綴字元改成 '$inputSqlPrefix'，但仍需手動更改以下內容到<code>/config/db_config.php</code></p>
			<pre>".htmlentities($result, ENT_QUOTES, 'UTF-8')."</pre>");
			$theAlert->setInSession("site_manager");
			
			//回到網站管理頁面
			header("Location: ../site_manager.php");
		}
		
		break;
}