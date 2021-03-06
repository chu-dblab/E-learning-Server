<?php
	/**
	 * 網站根目錄
	 */
	define('DOCUMENT_ROOT',dirname(__FILE__).'/');

	/**
	 *網站標題
	 */
	define('SITE_NAME','無所不在學習導引系統');
	
	/** 
	 * 網站副標題
	 */
	define('SITE_SUBNAME','');
	
	/**
	 * 網站標題簡稱
	 */
	define('SITE_NAME_REFERRED','E-learning');

	/**
	 * 網站首頁網址
	 * 
	 * Warning: 網址後面務必加上"/"
	 */ 
	define('SITE_URL','http://localhost/');
	
	/**
	 * 本系統根網址
	 * 
	 * 給絕對路徑用的。
	 * Warning: 網址後面務必加上"/"
	 */
	define('SITE_URL_ROOT','http://localhost/');

	/**
	 * 要用哪種加密方式
	 * 
	 * 目前提供選項: 
	 * <ul>
	 *   <li>MD5</li>
	 *   <li>SHA1</li>
	 *   <li>CRYPT</li>
	 * </ul>
	 */
	$ENCRYPT_MODE = 'SHA1';

	/**
	 * 你的地區
	 */
	date_default_timezone_set('Asia/Taipei');	//設定時區
	