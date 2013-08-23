<!--
  database_manager.php
   
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
	</head>
	<body>
		<?php template_admin_top_nav() ?>
		
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span3">
					<?php template_admin_sidebar(); ?>
				</div><!--/span-->
				
				<div class="span9">
				
					<header>
						<h1>專案資料庫管理</h1>
						<h2></h2>
					</header>
					
					<section>
						<h2>更改資料庫名稱</h2>
					</section>
					
					<section>
						<h2>更改資料表的前綴字元</h2>
					</section>
					
					<section>
						<h2>重設資料庫內容</h2>
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