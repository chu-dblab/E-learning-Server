<!--
  index.php
   
   管理介面總攬
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	require_once("config.php");
	require_once("template/template.php");
	
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>安裝</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/css/bootstrap-top-navbar.css" rel="stylesheet">
		<link href="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	</head>
	<body>
		<?php template_install_top_nav() ?>
		
		<div class="container">
			<div class="hero-unit">
				<h1>安裝程式</h1>
				<p>接下來會帶著你安裝系統</p>
				<p><a href="input_site_config.php" class="btn btn-primary btn-large">咱們就開始吧 &raquo;</a></p>
			</div>
			
			<hr>
			<?php template_install_footer() ?>
		</div>
		
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/js/jquery-1.10.2.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>