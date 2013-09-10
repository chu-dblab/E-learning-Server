<?php
/**
 * 前置設定
*/
require_once(DOCUMENT_ROOT."config.php"); //取得網站變數
require_once(DOCUMENT_ROOT."lib/function/write_txt.php");

// ========================================================================

/**
 * rename_site_title
 *
 * 更改網站名稱
 *
 * @param	string	網站名稱
 * @param	string	網站副標題
 * @param	string	網站簡稱
 * @return	string	寫入結果
 * 		"Finish": 成功寫入
 * 		其他: 無法寫入，回傳內文
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
*/
function rename_site_title($fullName, $subName, $referredName) {
	require_once(DOCUMENT_ROOT."lib/create_txt/create_config.php");
	global $ENCRYPT_MODE, $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT;
	
	//如果沒填網站簡稱的話
	if($referredName == ""){
		$referredName = $fullName;
	}
	
	//更改進設定檔
	$create_txt_content = create_config_txt_content($fullName, $subName, $referredName, SITE_URL, SITE_URL_ROOT, $ENCRYPT_MODE, $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT);
	return write_txt($create_txt_content, DOCUMENT_ROOT."config.php");
}
// ------------------------------------------------------------------------

/**
 * change_default_encryptMode
 *
 * 更改預設加密
 *
 * @param	string	加密方式
 * @return	string	寫入結果
 * 		"Finish": 成功寫入
 * 		其他: 無法寫入，回傳內文
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
*/
function change_default_encryptMode($input_encryptMode){
	//TODO 判斷輸入的參數是否有在支援範圍內
	require_once(DOCUMENT_ROOT."lib/create_txt/create_config.php");
	global $ENCRYPT_MODE, $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT;
	
	//更改進設定檔
	$create_txt_content = create_config_txt_content(SITE_NAME, SITE_SUBNAME, SITE_NAME_REFERRED, SITE_URL, SITE_URL_ROOT, $input_encryptMode, $COOKIES_PREFIX, $COOKIES_LOGIN_TIMEOUT);
	return write_txt($create_txt_content, DOCUMENT_ROOT."config.php");
}
// ------------------------------------------------------------------------

/**
 * change_cookies_config
 *
 * 更改Cookies存取
 *
 * @param	string	前綴字元
 * @param	int	使用者登入期限(秒)
 * @return	string	寫入結果
 * 		"Finish": 成功寫入
 * 		其他: 無法寫入，回傳內文
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
*/
function change_cookies_config($set_cookies_prefix, $set_cookies_login_timeout){
	//TODO 加入防呆
	require_once(DOCUMENT_ROOT."lib/create_txt/create_config.php");
	global $ENCRYPT_MODE;
	
	//更改進設定檔
	$create_txt_content = create_config_txt_content(SITE_NAME, SITE_SUBNAME, SITE_NAME_REFERRED, SITE_URL, SITE_URL_ROOT, $input_encryptMode, $set_cookies_prefix, $set_cookies_login_timeout);
	return write_txt($create_txt_content, DOCUMENT_ROOT."config.php");
}