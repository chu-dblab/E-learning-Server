<?php
// 取得使用者輸入過的資料
$inputSiteName = $_SESSION["install_inputSiteName"];
$inputSiteSubName = $_SESSION["install_inputSiteSubName"];
$inputSiteReferred = $_SESSION["install_inputSiteReferred"];
$inputEncryptMode = $_SESSION["install_inputEncryptMode"];
$inputSiteRootUrl = $_SESSION["install_inputSiteRootUrl"];
$inputSiteIndexUrl = $_SESSION["install_inputSiteIndexUrl"];

// 網站設定檔建立
$create_txt_content = "<?php\n\t/**\n\t * 網站根目錄\n\t * @ignore\n\t */\n";
$create_txt_content .= "\tdefine('DOCUMENT_ROOT',dirname(__FILE__).'/');\n";
$create_txt_content .= "\n";

$create_txt_content .= "\t/**\n\t *網站標題\n\t * @ignore\n\t */\n";
$create_txt_content .= "\tdefine('SITE_NAME','$inputSiteName');\n";
$create_txt_content .= "\t\n\t/** \n\t * 網站副標題\n\t * @ignore\n\t */\n";
$create_txt_content .= "\tdefine('SITE_SUBNAME','$inputSiteSubName');\n";
$create_txt_content .= "\t\n\t/**\n\t * 網站標題簡稱\n\t * @ignore\n\t */\n";
$create_txt_content .= "\tdefine('SITE_NAME_REFERRED','$inputSiteReferred');";
$create_txt_content .= "\n";

$create_txt_content .= "\t/**\n\t * 網站首頁網址\n\t * \n\t * Warning: 網址後面務必加上\"/\"\n\t * @ignore\n\t */ \n\tdefine('SITE_URL','.$inputSiteIndexUrl.');\n";
$create_txt_content .= "\t/**\n\t * 本系統根網址\n\t * \n\t * 給絕對路徑用的。\n\t * Warning: 網址後面務必加上\"/\"\n\t * @ignore\n\t */\n\tdefine('SITE_URL_ROOT','$inputSiteRootUrl');\n";
$create_txt_content .= "\n";

$create_txt_content .= "\t/**\n\t * 要用哪種加密方式\n\t * \n\t * 目前提供選項: \n\t * <ul>\n\t *   <li>MD5</li>\n\t *   <li>SHA1</li>\n\t *   <li>CRYPT</li>\n\t * </ul>\n\t * @ignore\n\t */\n";
$create_txt_content .= "\t\$ENCRYPT_MODE = '$inputEncryptMode';\n";
$create_txt_content .= "\n";

$create_txt_content .= "\t/**\n\t * 你的地區\n\t * @ignore\n\t */\n";
$create_txt_content .= "\tdate_default_timezone_set('Asia/Taipei');\t//設定時區\n";

// echo "content:<br>";
// echo "<pre>".htmlentities($create_txt_content, ENT_QUOTES, 'UTF-8')."</pre>";


if($fp=fopen("../../config.php","w+")){
	//fputs($fp,$create_txt_content);
	fwrite($fp,$create_txt_content);
	unset($_SESSION["install_config_code"]);
}
else{
	$_SESSION["install_config_code"] = $create_txt_content;
}
fclose($fp);


//echo "Finish";