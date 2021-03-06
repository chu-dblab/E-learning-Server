<?php
/**
 * 前置設定
*/
require_once("../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/function/site_admin.php");
require_once(DOCUMENT_ROOT."lib/function/database.php");
require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");

// ========================================================================

/**
 * 更新動作
*/
$action = $_GET['action'];

switch($action){
	//更改網站名稱
	case "rename_site_title":
		//帶入使用者輸入的資料
		$inputSiteName = $_POST["inputSiteName"];
		$inputSiteSubName = $_POST["inputSiteSubName"];
		$inputSiteReferred = $_POST["inputSiteReferred"];
		
		$result = rename_site_title($inputSiteName, $inputSiteSubName, $inputSiteReferred);
		
		//更改完成，並成功寫入設定檔
		if($result == "Finish") {
			//送出通知訊息
			$theAlert = new Alert("success", false, "<strong>更改完成！</strong>  更改網站名稱！！");
			$theAlert->setInSession("site_manager");
			
			//回到網站管理頁面
			header("Location: ../site_manager.php");
		}
		//更改完成，但無法寫入設定檔
		else {
			//送出通知訊息
			$theAlert = new Alert("warning", true, "<h4>需手動更改設定檔！</h4>
			<p>需手動更改以下內容到<code>/config.php</code></p>
			<pre>".htmlentities($result, ENT_QUOTES, 'UTF-8')."</pre>");
			$theAlert->setInSession("site_manager");
			
			//回到網站管理頁面
			header("Location: ../site_manager.php");
		}
		break;

	//更改網站名稱
	case "change_default_encryptMode":
		//帶入使用者輸入的資料
		$inputEncryptMode = $_POST["inputEncryptMode"];
		
		if(
			$inputEncryptMode == "MD5" ||
			$inputEncryptMode == "SHA1" ||
			$inputEncryptMode == "CRYPT"
		) {
			$result = change_default_encryptMode($inputEncryptMode);
			
			//更改完成，並成功寫入設定檔
			if($result == "Finish") {
				//送出通知訊息
				$theAlert = new Alert("success", false, "<strong>更改完成！</strong>  更改網站名稱！！");
				$theAlert->setInSession("site_manager");
				
				//回到網站管理頁面
				header("Location: ../site_manager.php");
			}
			//更改完成，但無法寫入設定檔
			else {
				//送出通知訊息
				$theAlert = new Alert("warning", true, "<h4>需手動更改設定檔！</h4>
				<p>需手動更改以下內容到<code>/config.php</code></p>
				<pre>".htmlentities($result, ENT_QUOTES, 'UTF-8')."</pre>");
				$theAlert->setInSession("site_manager");
				
				//回到網站管理頁面
				header("Location: ../site_manager.php");
			}
		}
		else {
			//送出通知訊息
			$theAlert = new Alert("error", false, "<strong>更改錯誤！</strong> 你輸入'$inputEncryptMode'不在支援範圍內");
			$theAlert->setInSession("site_manager");
			
			//回到網站管理頁面
			header("Location: ../site_manager.php");
		}
		
		break;
		
	//更改Cookies設定
	case "change_cookies_config":
		//帶入使用者輸入的資料
		$inputCookiesPrefix = $_POST["inputCookiesPrefix"];
		$inputCookiesUserExpired = $_POST["inputCookiesUserExpired"];
		
		if( !is_numeric($inputCookiesUserExpired) ) {
			//送出通知訊息
			$theAlert = new Alert("error", false, "<strong>更改錯誤！</strong> 你輸入的'使用者登入期限'不是數字喔～");
			$theAlert->setInSession("site_manager");
			
			//回到網站管理頁面
			header("Location: ../site_manager.php");
		}
		else {
			$result = change_cookies_config($inputCookiesPrefix, $inputCookiesUserExpired);
			
			//更改完成，並成功寫入設定檔
			if($result == "Finish") {
				//送出通知訊息
				$theAlert = new Alert("success", false, "<strong>更改完成！</strong>");
				$theAlert->setInSession("site_manager");
				
				//回到網站管理頁面
				header("Location: ../site_manager.php");
			}
			//更改完成，但無法寫入設定檔
			else {
				//送出通知訊息
				$theAlert = new Alert("warning", true, "<h4>需手動更改設定檔！</h4>
				<p>需手動更改以下內容到<code>/config.php</code></p>
				<pre>".htmlentities($result, ENT_QUOTES, 'UTF-8')."</pre>");
				$theAlert->setInSession("site_manager");
				
				//回到網站管理頁面
				header("Location: ../site_manager.php");
			}
		}
		break;
		
	//更改資料庫名稱
	case "rename_db_name":
		//帶入使用者輸入的資料
		$inputSqlName = $_POST["inputSqlName"];
		
		//更改資料庫名稱
		$result = db_rename_db_name($inputSqlName);
		
		//更改完成，並成功寫入設定檔
		if($result == "Finish") {
			//送出通知訊息
			$theAlert = new Alert("success", false, "<strong>更改完成！</strong>  已將資料庫名稱改成 '$inputSqlName'！！");
			$theAlert->setInSession("site_manager");
			
			//回到網站管理頁面
			header("Location: ../site_manager.php");
		}
		//更改完成，但無法寫入設定檔
		else {
			//送出通知訊息
			$theAlert = new Alert("warning", true, "<h4>需手動更改設定檔！</h4>
			<p>雖然已將資料庫名稱改成 '$inputSqlName'，但仍需手動更改以下內容到<code>/config/db_config.php</code></p>
			<pre>".htmlentities($result, ENT_QUOTES, 'UTF-8')."</pre>");
			$theAlert->setInSession("site_manager");
			
			//回到網站管理頁面
			header("Location: ../site_manager.php");
		}
		break;
	
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