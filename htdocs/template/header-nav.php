<?php
function getCurrentActiveClass($link_file){
	$current_file = basename(getenv('SCRIPT_NAME'));	//取得目前網頁
	
	if($current_file == $link_file){
		echo "active";
	}
}
?>

<!-- 最上方導覽列 -->
<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<ul class="nav">
				<li class="<?php getCurrentActiveClass('index.php') ?>"><a href="index.php">首頁</a></li>
				<li class="<?php getCurrentActiveClass('') ?>"><a href="#">簡介</a></li>
				<li class="<?php getCurrentActiveClass('') ?>"><a href="#">您的學習資訊</a></li>
				<li class="<?php getCurrentActiveClass('') ?>"><a href="#">教材導覽</a></li>	
				<li><a href="admin">網站管理</a></li>	
			</ul>
		</div>
	</div>
</div>
<!-- End- 最上方導覽列 --> 
