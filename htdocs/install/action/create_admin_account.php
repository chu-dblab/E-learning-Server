<?php
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
require_once(DOCUMENT_ROOT."lib/function/user.php");
echo "c";	
user_create($inputSiteAdminUser, $inputSiteAdminPass, $inputEncryptMode, "admin", true, $inputSiteAdminUserRealName, $inputSiteAdminUserNickName, $inputSiteAdminUserEmail);
