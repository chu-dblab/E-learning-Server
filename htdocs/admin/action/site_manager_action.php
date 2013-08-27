<?php
function updateSiteOnGit() {
	$output = shell_exec("git pull origin publish");
	
 	echo $output;	//DEBUG
}

$action = $_GET["action"];
switch($action) {
	case "siteupdate":
		updateSiteOnGit();
		break;
}