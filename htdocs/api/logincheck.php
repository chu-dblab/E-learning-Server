<?php
	/*
	 * Android Phone can access this file to get JSON format message.
	 */
	require_once("../lib/include.php");
	require_once(DOCUMENT_ROOT."/lib/function/user.php");
	$ID = $_POST["mId"];
	$PWD = $_POST["mPassword"];
	$login_code = array(code=>user_login($ID,$PWD));
	echo json_encode($login_code);
?>