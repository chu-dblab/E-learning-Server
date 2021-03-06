<?php
function create_config_txt_content($inputSiteName, $inputSiteSubName, $inputSiteReferred, $inputSiteIndexUrl, $inputSiteRootUrl, $inputEncryptMode, $inputCookiesPrefix, $inputCookiesLoginTimeout) {
	$create_txt_content = "<?php\n/**\n * 網站根目錄\n*/\n";
	$create_txt_content .= "\tdefine('DOCUMENT_ROOT',dirname(__FILE__).'/');\n";
	$create_txt_content .= "\n";

	$create_txt_content .= "/**\n * 網站資訊\n*/\n";
	$create_txt_content .= "\t//網站標題\n";
	$create_txt_content .= "\tdefine('SITE_NAME','$inputSiteName');\n";
	$create_txt_content .= "\t//網站副標題\n";
	$create_txt_content .= "\tdefine('SITE_SUBNAME','$inputSiteSubName');\n";
	$create_txt_content .= "\t//網站標題簡稱\n";
	$create_txt_content .= "\tdefine('SITE_NAME_REFERRED','$inputSiteReferred');\n";
	$create_txt_content .= "\n";

	$create_txt_content .= "\t//網站網址\n";
	$create_txt_content .= "\t//Warning: 網址後面務必加上\"/\"\n";
	$create_txt_content .= "\tdefine('SITE_URL','$inputSiteIndexUrl');\n";
	$create_txt_content .= "\tdefine('SITE_URL_ROOT','$inputSiteRootUrl');\n";
	$create_txt_content .= "\n";

	$create_txt_content .= "/**\n * 要用哪種加密方式\n * \n * 目前提供選項: MD5, SHA1, CRYPT\n*/\n";
	$create_txt_content .= "\t\$ENCRYPT_MODE = '$inputEncryptMode';\n";
	$create_txt_content .= "\n";

	$create_txt_content .= "/**\n * 瀏覽器Cookies\n * \n*/\n";
	$create_txt_content .= "\t//CookiesID的前綴字元\n";
	$create_txt_content .= "\t\$COOKIES_PREFIX = '$inputCookiesPrefix';\n";
	$create_txt_content .= "\t//設定登入狀態的有效期限\n";
	$create_txt_content .= "\t\$COOKIES_LOGIN_TIMEOUT = '$inputCookiesLoginTimeout';\n";
	$create_txt_content .= "\n";

	$create_txt_content .= "/**\n * 你的地區\n*/\n";
	$create_txt_content .= "\tdate_default_timezone_set('Asia/Taipei');\t//設定時區\n";
	
	return $create_txt_content;
}