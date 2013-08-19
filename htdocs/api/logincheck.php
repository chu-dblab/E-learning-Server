<?php
	/*
	 * Android Phone can access this file to get JSON format message.
	 */
	require_once(DOCUMENT_ROOT."/lib/user.php");
	$ID = $_POST[];
	$PWD = $_POST[];
	$login_code = array(code=>user_login($ID,$PWD));
	echo json_encode($login_code);
?>