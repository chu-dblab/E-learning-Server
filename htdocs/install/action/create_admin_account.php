<?php
 /**
 * encryptText
 *
 * 將文字加密（不帶第二個參數）
 * 不帶第二個參數，就自動從預設的帶起
 * @ignore
 * @param	string	原文內容
 * @return	string	加密後內容
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
 */
function encryptText(){
	if(func_num_args() == 2){
		$args = func_get_args();
		$text = $args[0];
		$mode = $args[1];
		
		switch($mode){
			case "MD5":
				return md5($text);
				break;
			case "SHA1":
				return sha1($text);
				break;
			case "CRYPT":
				return crypt($text);
				break;
			default:
				return $text;
				break;
		}
	}
	else if(func_num_args() == 1){
		global $ENCRYPT_MODE;
		$args = func_get_args();
		$text = $args[0];
		
		return encryptText($text, $ENCRYPT_MODE);
	}
}

// ---------------------------------------------------

session_start();

	$inputSiteAdminUser = $_SESSION["install_inputSiteAdminUser"];
	$inputSiteAdminPass = $_SESSION["install_inputSiteAdminPass"];
	$inputSiteAdminUserRealName = $_SESSION["install_inputSiteAdminUserRealName"];
	$inputSiteAdminUserNickName = $_SESSION["install_inputSiteAdminUserNickName"];
	$inputSiteAdminUserEmail = $_SESSION["install_inputSiteAdminUserEmail"];
	
	
	$inputEncryptMode = $_SESSION["install_inputEncryptMode"];
	
error_reporting(E_ALL);
ini_set("display_errors", 1);	

echo "a";
define('DOCUMENT_ROOT',dirname(__FILE__).'/../../');
echo "b";
echo "c";	

mysql_query("INSERT INTO `".$inputSQLDBName."`.`".$inputSQLDBFormPrefix."user` (`UID`, `GID`, `UPassword`, `UEnabled`, `UReal_Name`, `UNickname`, `UEmail`) 
	VALUES ('$inputSiteAdminUser', 'admin', '".encryptText($inputSiteAdminPass, $inputEncryptMode)."', '1', '$inputSiteAdminUserRealName', '$inputSiteAdminUserNickName', '$inputSiteAdminUserEmail')") or die(mysql_error());

