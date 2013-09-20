<!--
  index.php
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	require_once("lib/include.php");
	require_once(DOCUMENT_ROOT."template/template.php");
	require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");
	
	//取得通知資料
	$loginAlert = new Alert();
	$loginAlert->getInSession("user_login");
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title><?php echo SITE_NAME ?></title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo SITE_URL_ROOT ?>assets/css/bootstrap-Justified_nav.css" rel="stylesheet">
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="<?php echo SITE_URL_ROOT ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<style>
		/* Main marketing message and sign up button */
		/* http://getbootstrap.com/2.3.2/examples/justified-nav.html */
		.jumbotron {
			margin: 80px 0;
			text-align: center;
		}
		.jumbotron h1 {
			font-size: 80px;
			line-height: 1;
		}
		.jumbotron .lead {
			font-size: 24px;
			line-height: 1.25;
		}
		.jumbotron .btn {
			font-size: 21px;
			padding: 14px 24px;
		}
		</style>
	</head>
	<body>
	<div class="container">
	
		<?php template_header() ?>
		
		<!-- 通知區域 -->
		<?php $loginAlert->show(); ?>
		
		<!-- Jumbotron -->
		<div class="jumbotron">
			<h1>歡迎使用我們的系統</h1>
			<p class="lead">此系統會依學生狀況、現場人數分配而規劃最佳的學習路徑給學生，並紀錄學生學習時的狀況。</p>
			<a class="btn btn-large btn-success" href="#">咱們開始吧～</a>
		</div>
		<!-- End Jumbotron -->
		
		<hr />
		<?php template_footer() ?>
		
	</div>
	<script src="<?php echo SITE_URL_ROOT ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo SITE_URL_ROOT ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script>
		
	</script>
	</body>
</html>