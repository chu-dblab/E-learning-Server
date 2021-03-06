<?php
function create_dbconfig_txt_content($inputSQLHost, $inputSQLUser, $inputSQLPass, $inputSQLDBName, $inputSQLDBFormPrefix) {
	$create_txt_content = "<?php\n";
	$create_txt_content .= "\$DB_SERV = '$inputSQLHost';\t//資料庫伺服器名稱\n";
	$create_txt_content .= "\$DB_USER = '$inputSQLUser';\t//資料庫使用者名稱\n";
	$create_txt_content .= "\$DB_PASS = '$inputSQLPass';\t//資料庫使用者密碼\n";
	$create_txt_content .= "\$DB_NAME = '$inputSQLDBName';\t//指定要使用哪個資料庫\n";
	$create_txt_content .= "\$FORM_PREFIX = '$inputSQLDBFormPrefix';\t//資料表的前綴字元";

	return $create_txt_content;
}