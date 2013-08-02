<?php
session_start();

	$inputSiteAdminUser = $_SESSION["install_inputSiteAdminUser"];
	$inputSiteAdminPass = $_SESSION["install_inputSiteAdminPass"];
	$inputSiteAdminUserRealName = $_SESSION["install_inputSiteAdminUserRealName"];
	$inputSiteAdminUserNickName = $_SESSION["install_inputSiteAdminUserNickName"];
	$inputSiteAdminUserEmail = $_SESSION["install_inputSiteAdminUserEmail"];
	
	
function encryptText($text){
	global $inputEncryptMode;
	switch($inputEncryptMode){
		case "MD5":
			return md5($text);
			break;
		default:
			return $text;
			break;
	}
}


mysql_query("INSERT INTO `".$inputSQLDBFormPrefix."users` (`username` ,`password` ,`user_group` ,`create_time` ,`isActive` ,`realname` ,`nickname` ,`email`)
	VALUES ('$inputSiteAdminUser', '".encryptText($inputSiteAdminPass)."', 'admin', NOW() , '1', '$inputSiteAdminUserRealName', '$inputSiteAdminUserNickName', '$inputSiteAdminUserEmail')") 
	or die(mysql_error());