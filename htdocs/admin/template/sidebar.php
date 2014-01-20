<?php
require_once("../lib/include.php");

function getCurrentActiveClass($link_file){
	$current_file = basename(getenv('SCRIPT_NAME'));	//取得目前網頁
	
	if($current_file == $link_file){
		echo "active";
	}
}
?>

<div class="well sidebar-nav">
	<ul class="nav nav-list">
		<?php include("sidebar_nav_list_content.php"); ?>
	</ul>
</div><!--/.well -->