<?php
session_start();

	$inputSiteAdminUser = $_SESSION["install_inputSiteAdminUser"];
	$inputSiteAdminPass = $_SESSION["install_inputSiteAdminPass"];
	//$inputSiteAdminRepPass = $_SESSION["install_inputSiteAdminRepPass"];
	$inputSiteAdminUserRealName = $_SESSION["install_inputSiteAdminUserRealName"];
	$inputSiteAdminUserNickName = $_SESSION["install_inputSiteAdminUserNickName"];
	$inputSiteAdminUserEmail = $_SESSION["install_inputSiteAdminUserEmail"];
	

require_once("../../config.php");
require_once(DOCUMENT_ROOT."lib/user.php"); //取得連結資料庫連結變數
require_once(DOCUMENT_ROOT."lib/password.php");

user_create("$inputSiteAdminUser", "$inputSiteAdminPass", "$inputSiteAdminPass", "1", true, "$inputSiteAdminUserRealName", "$inputSiteAdminUserNickName", "$inputSiteAdminUserEmail");