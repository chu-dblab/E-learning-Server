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
		<li class="<?php getCurrentActiveClass('index.html') ?>"><a href="<?php echo SITE_URL_ROOT ?>admin/index.html">總覽</a></li>
		
		<li class="nav-header">使用者</li>
		<li class="<?php getCurrentActiveClass('account_list.php') ?>"><a href="<?php echo SITE_URL_ROOT ?>admin/account_list.php">帳號管理</a></li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		
		<li class="nav-header">學習教材</li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		
		<li class="nav-header">系統設定</li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		<li class="<?php getCurrentActiveClass('') ?>"><a href="#">Link</a></li>
		
	</ul>
</div><!--/.well -->