<?php
function updateSiteOnGit() {
	shell_exec("git pull origin publish");
}

$action = $_GET["action"];
switch($action) {
	case "siteupdate":
		updateSiteOnGit();
		break;
}