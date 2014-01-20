<?php 

//讀取session資料
session_start();
$status_message =  $_SESSION["install_status_message"];
unset($_SESSION["install_status_message"]);

/**
 * @ignore
 */
function show_status_notify(){
	global $status_message;
	
	if($status_message){
		echo "<div class='alert alert-error'>";
		
		echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
		echo $status_message;
		
		echo "</div>";
	}
}