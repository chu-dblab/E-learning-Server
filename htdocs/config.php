<?php
/**
 * 網站根目錄
*/
	define('DOCUMENT_ROOT',dirname(__FILE__).'/');

/**
 * 網站資訊
*/
	//網站標題
	define('SITE_NAME','無所不在學習導引系統');
	//網站副標題
	define('SITE_SUBNAME','');
	//網站標題簡稱
	define('SITE_NAME_REFERRED','無所不在學習導引系統');

	//網站網址
	//Warning: 網址後面務必加上"/"
	define('SITE_URL','http://chu-elearning/');             //網站首頁
	define('SITE_URL_ROOT','http://chu-elearning/');        //本系統的根網址

/**
 * 要用哪種加密方式
 * 
 * 目前提供選項: MD5
*/
	$ENCRYPT_MODE = 'MD5';

/**
 * 瀏覽器Cookies
 * 
*/	
	//CookiesID的前綴字元
	$COOKIES_PREFIX = "chu_";
	//設定登入狀態的有效期限
	$COOKIES_LOGIN_TIMEOUT = 3000;
/**
 * 你的地區
*/
	date_default_timezone_set('Asia/Taipei');	//設定時區
