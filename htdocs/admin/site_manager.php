<!--
  site_manager.php
   
   本站管理
   
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
		<title>本站管理 -<?php echo SITE_NAME_REFERRED ?></title>
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
						<h1>本站管理</h1>
						<h2></h2>
					</header>
					<section id="database-manager">
						<header>
							<h2>本站</h2>
						</header>
						<section>
							<h3>網站名稱</h3>
							<form>
								<div class="control-group">
									<label class="control-label" for="inputSiteName">網站名稱: </label>
									<div class="controls">
										<input type="text" name="inputSiteName" required="required" id="inputSiteName" placeholder="完整的網站名稱">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputSiteSubName">網站副標題: </label>
									<div class="controls">
										<input type="text" name="inputSiteSubName" id="inputSiteSubName" placeholder="副標題">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputSiteReferred">網站簡稱: </label>
									<div class="controls">
										<input type="text" name="inputSiteReferred" id="inputSiteReferred" placeholder="簡稱">
									</div>
								</div>
							</form>
						</section>
						<section>
							<h3>更改預設加密方式</h3>
							<form>
								<div class="control-group">
									<label class="control-label" for="inputEncryptMode">密碼加密方式: </label>
									<div class="controls">
										<select name="inputEncryptMode" id="inputEncryptMode">
											<option value="MD5">MD5</option>
											<option value="SHA1">SHA1</option>
											<option value="CRYPT">CRYPT</option>
											<option value="">無</option>
										</select>
									</div>
								</div>
							</form>
						</section>
					</section>
					
					<section id="database-manager">
						<header>
							<h2>資料庫管理</h2>
						</header>
						<section>
							<h3>更改資料庫名稱</h3>
						</section>
						
						<section>
							<h3>更改資料表的前綴字元</h3>
						</section>
						
						<section>
							<h3>重設資料庫內容</h3>
							<!-- TODO 要建立一個管理者帳號 -->
						</section>
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