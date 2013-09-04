<?php
require_once(DOCUMENT_ROOT."config.php"); //取得網站變數
require_once(DOCUMENT_ROOT."lib/create_txt/create_db_config.php");

function rename_site_title($fullName, $subName, $referredName) {
	global $ENCRYPT_MODE, $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT;
	
	//如果沒填網站簡稱的話
	if($referredName == ""){
		$referredName = $fullName;
	}
	
	//取得設定檔內容
	$create_txt_content = create_config_txt_content($fullName, $subName, $referredName, SITE_URL, SITE_URL_ROOT, $ENCRYPT_MODE, $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT);
	
	//更改進設定檔
	if($fp=fopen(DOCUMENT_ROOT."config.php","w+")){
		fputs($fp,$create_txt_content);
		return "Finish";
	}
	else{
		return $create_txt_content;
	}
	fclose($fp);
}

function change_default_encryptMode($input_encryptMode){
	global $ENCRYPT_MODE, $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT;
	
	//取得設定檔內容
	$create_txt_content = create_config_txt_content(SITE_NAME, SITE_SUBNAME, SITE_NAME_REFERRED, SITE_URL, SITE_URL_ROOT, $input_encryptMode, $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT);
	
	//更改進設定檔
	if($fp=fopen(DOCUMENT_ROOT."config.php","w+")){
		fputs($fp,$create_txt_content);
		return "Finish";
	}
	else{
		return $create_txt_content;
	}
	fclose($fp);
}