<!--
  index.php
   
   管理介面總攬
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	require_once("../lib/include.php");
	require_once(DOCUMENT_ROOT."admin/template/template.php");
	
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>後台管理總覽 -<?php echo SITE_NAME_REFERRED ?></title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo SITE_URL_ROOT ?>assets/css/bootstrap-top-navbar.css" rel="stylesheet">
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="<?php echo SITE_URL_ROOT ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>
		<?php template_admin_top_nav() ?>
		
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span3">
					<?php template_admin_sidebar(); ?>
				</div><!--/span-->
				
				<div class="span9">
				
					<!-- 右側內容區 -->
					<div class="hero-unit">
						<h1>後台管理</h1>
						<p>嘿嘿嘿...這裡是只有管理者才能進來的暗黑天地，在這邊設定，將可能影響手機客戶端的運作！！</p>
						<p><a href="#" class="btn btn-primary btn-large">我知道了</a></p>
					</div>
					
					<section>
						<div class="row-fluid">
							<div class="span4">
								<h2>使用者管理</h2>
								<p>可在此新增學生、老師、管理員的帳號</p>
								<p><a class="btn" href="user_list.php">使用者管理 &raquo;</a></p>
							</div><!--/span-->
							<div class="span4">
								<h2>網站管理</h2>
								<p>更改站名、預設加密方式</p>
								<p><a class="btn" href="site_manager.php">進入網站管理 &raquo;</a></p>
							</div><!--/span-->
						</div><!--/row-->
					</section>
					
				</div><!--/span-->
			</div><!--/row-->
			<hr />
			<footer>
				<?php template_admin_footer() ?>
			</footer>
		</div>
		
		<script src="<?php echo SITE_URL_ROOT ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
