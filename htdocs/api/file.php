<?php
	/*
	 * Android Phone can access this file to get JSON format message.
	 */
	include_once(DOCUMENT_ROOT."/lib/sql.php");
	$con = sql_connect();
	function passJSONMessageToAndroidPhone()
	{
	    echo json_encode();
	}
?>