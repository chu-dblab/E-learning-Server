<?php
session_start();

	$inputSiteAdminUser = $_SESSION["install_inputSiteAdminUser"];
	$inputSiteAdminPass = $_SESSION["install_inputSiteAdminPass"];
	$inputSiteAdminUserRealName = $_SESSION["install_inputSiteAdminUserRealName"];
	$inputSiteAdminUserNickName = $_SESSION["install_inputSiteAdminUserNickName"];
	$inputSiteAdminUserEmail = $_SESSION["install_inputSiteAdminUserEmail"];
	

require_once("../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/function/user.php");
	
user_create($inputSiteAdminUser, $inputSiteAdminPass, $inputSiteAdminPass, "admin", true, $inputSiteAdminUserRealName, $inputSiteAdminUserNickName, $inputSiteAdminUserEmail);
