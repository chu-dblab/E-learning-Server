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
			font-size: 40px;
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
			<h1>混合式情境感知無所不在學習導引機制</h1>
			<p class="lead">這套導引機制讓學習標的同時具有實體學習教材與虛擬學習教材，並在這個混合的架構上，提出了一套適合的導引方法，讓學習者可以進行實體學習標的之觀察或是直接檢視虛擬教材進行學習。</p>
			<a class="btn btn-large btn-success" href="#">咱們開始吧～</a>
		</div>
		<!-- End Jumbotron -->
		
		<hr />
		
		<!-- Example row of columns -->
		<div class="row-fluid">
			<div class="span4">
				<h2>規劃學習路徑</h2>
				<p>此系統會依學生狀況、現場人數分配而規劃最佳的學習路徑給學生，並紀錄學生學習時的狀況。</p>
				<p><a class="btn" href="#">了解更多 »</a></p>
			</div>
			<div class="span4">
				<h2>學習測驗</h2>
				<p>學生在學習當中，除了提供教材外，會在此學習點學習後，提供測驗給學生評量。</p>
				<p><a class="btn" href="#">了解更多 »</a></p>
			</div>
			<div class="span4">
				<h2>管理界面</h2>
				<p>提供界面給老師 or 管理員，進行人員控管、本站設定。</p>
				<p><a class="btn" href="#">了解更多 »</a></p>
			</div>
		</div>
		
		<hr />
		<?php template_footer() ?>
		
	</div>
	<script src="<?php echo SITE_URL_ROOT ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo SITE_URL_ROOT ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script>
		
	</script>
	</body>
</html>