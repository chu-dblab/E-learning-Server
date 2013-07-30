<?php

function backPage($toPage, $Message){
	//利用session傳回錯誤訊息
	session_start();
	
	$_SESSION["install_status_message"] = $Message;
	
	header("Location: $toPage");
}

function input_site_config(){
	/**
	 * 帶入使用者輸入的資料
	*/
	$inputSiteName = $_POST["inputSiteName"];
	$inputSiteSubName = $_POST["inputSiteSubName"];
	//如果有填網站簡稱的話
	if($_POST["inputSiteReferred"]){
		$inputSiteReferred = $_POST["inputSiteReferred"];
	}
	else{
		$inputSiteReferred = $inputSiteName;
	}
	$inputEncryptMode = $_POST["inputEncryptMode"];
	$inputSiteRootUrl = $_POST["inputSiteRootUrl"];
	$inputSiteIndexUrl = $_POST["inputSiteIndexUrl"];
	
	/**
	 * 驗證資料有無填錯
	*/
	//是否有填必填資料
	if($inputSiteName == ""){
		backPage("input_site_config.php","網站名稱是必填的喔");
	}
	//密碼加密選項
	else if( !($inputEncryptMode=="MD5" || $inputEncryptMode=="") ) {
		backPage("input_site_config.php","沒有你選擇的密碼加密選項");
	}
	else if($inputSiteRootUrl == ""){
		backPage("input_site_config.php","網站系統根網址是必填的喔");
	}
	else if($inputSiteIndexUrl == ""){
		backPage("input_site_config.php","網站首頁網址是必填的喔");
	}
	
	/**
	 * 紀錄使用者輸入的資料
	*/
	session_start();
	$_SESSION["install_inputSiteName"]  = $inputSiteName;
	$_SESSION["install_inputSiteSubName"] = $inputSiteSubName;
	$_SESSION["install_inputSiteReferred"] = $inputSiteReferred;
	$_SESSION["install_inputEncryptMode"] = $inputEncryptMode;
	$_SESSION["install_inputSiteRootUrl"] = $inputSiteRootUrl;
	$_SESSION["install_inputSiteIndexUrl"] = $inputSiteIndexUrl;
	
	//DEBUG
	/*echo $inputSiteName."<br>";
	echo $inputSiteSubName."<br>";
	echo $inputSiteReferred."<br>";
	echo $inputEncryptMode."<br>";
	echo $inputSiteRootUrl."<br>";
	echo $inputSiteIndexUrl."<br>";*/
}


function input_sql_config(){
	/**
	 * 帶入使用者輸入的資料
	*/
	$inputSQLHost = $_POST["inputSQLHost"];
	$inputSQLUser = $_POST["inputSQLUser"];
	$inputSQLPass = $_POST["inputSQLPass"];
	$inputSQLDBName = $_POST["inputSQLDBName"];
	$inputSQLDBFormPrefix = $_POST["inputSQLDBFormPrefix"];
	
	/**
	 * 驗證資料有無填錯
	*/
	//是否有填必填資料
	if($inputSQLHost == ""){
		backPage("input_sql_config.php","資料庫伺服器位址是必填的喔");
	}
	else if($inputSQLUser == ""){
		backPage("input_sql_config.php","資料庫伺服器帳號是必填的喔");
	}
	else if($inputSQLPass == ""){
		backPage("input_sql_config.php","資料庫伺服器是必填的喔");
	}
	//測試資料庫連線
	else if( !mysql_connect($inputSQLHost,$inputSQLUser,$inputSQLPass) ){
		backPage("input_sql_config.php","資料庫無法連結，請檢查你填入的資訊有無錯誤，或是資料庫系統是否有啟動");
	}
	//是否有填必填資料
	else if($inputSQLDBName == ""){
		backPage("input_sql_config.php","要使用的資料庫名稱是必填的喔");
	}
	
	/**
	 * 紀錄使用者輸入的資料
	*/
	session_start();
	$_SESSION["install_inputSQLHost"]  = $inputSQLHost;
	$_SESSION["install_inputSQLUser"]  = $inputSQLUser;
	$_SESSION["install_inputSQLPass"]  = $inputSQLPass;
	$_SESSION["install_inputSQLDBName"]  = $inputSQLDBName;
	$_SESSION["install_inputSQLDBFormPrefix"]  = $inputSQLDBFormPrefix;
	
	//DEBUG
	/*echo $inputSQLHost."<br>";
	echo $inputSQLUser."<br>";
	echo $inputSQLPass."<br>";
	echo $inputSQLDBName."<br>";
	echo $inputSQLDBFormPrefix."<br>";*/
	
}

function input_admin_account(){
	/**
	 * 帶入使用者輸入的資料
	*/
	$inputSiteAdminUser = $_POST["inputSiteAdminUser"];
	$inputSiteAdminPass = $_POST["inputSiteAdminPass"];
	$inputSiteAdminRepPass = $_POST["inputSiteAdminRepPass"];
	$inputSiteAdminUserRealName = $_POST["inputSiteAdminUserRealName"];
	$inputSiteAdminUserNickName = $_POST["inputSiteAdminUserNickName"];
	$inputSiteAdminUserEmail = $_POST["inputSiteAdminUserEmail"];
	
	/**
	 * 驗證資料有無填錯
	*/
	if($inputSiteAdminUser == ""){
		backPage("input_admin_account.php","請填入管理者帳號");
	}
	else if($inputSiteAdminPass == ""){
		backPage("input_admin_account.php","請填入確認密碼");
	}
	else if($inputSiteAdminRepPass != $inputSiteAdminPass){
		backPage("input_admin_account.php","確認密碼錯誤");
	}
	
	/**
	 * 紀錄使用者輸入的資料
	*/
	session_start();
	$_SESSION["install_inputSiteAdminUser"]  = $inputSQLHost;
	$_SESSION["install_inputSiteAdminPass"]  = $inputSiteAdminPass;
	$_SESSION["install_inputSiteAdminRepPass"]  = $inputSiteAdminRepPass;
	$_SESSION["install_inputSiteAdminUserRealName"]  = $inputSiteAdminUserRealName;
	$_SESSION["install_inputSiteAdminUserNickName"]  = $inputSiteAdminUserNickName;
	$_SESSION["install_inputSiteAdminUserEmail"]  = $inputSiteAdminUserEmail;
	
}