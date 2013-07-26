<?php
/**
 * 網站根目錄
*/
define('DOCUMENT_ROOT',dirname(__FILE__)."/");

/**
 * 網站資訊
*/
//網站標題
define('SITE_NAME',"無所不在學習導引系統");

//網站副標題
define('SITE_SUBNAME',"");

//網站網址
define('SITE_URL',"http://chu-elearning/");


/**
 * 要用哪種加密方式
 * 
 * 目前提供選項: MD5
*/
$ENCRYPT_MODE = "MD5";

/**
 * 你的地區
*/
date_default_timezone_set("Asia/Taipei");	//設定時區