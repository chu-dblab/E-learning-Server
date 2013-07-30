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