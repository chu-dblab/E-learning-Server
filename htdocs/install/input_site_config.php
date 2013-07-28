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
			<div class="page-header">
				<h1>第一步 <small>基本的網站設定</small></h1>
			</div>
			
			<section>
				<form class="form-horizontal">
					<div class="row-fluid">
						<div class="span6">
						
							<div class="control-group">
								<label class="control-label" for="inputSiteName">網站名稱: </label>
								<div class="controls">
									<input type="text" name="inputSiteName" id="inputSiteName" placeholder="完整的網站名稱">
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
							
						</div><!-- /span -->
						
						<div class="span6">
						
							<div class="control-group">
								<label class="control-label" for="inputEncryptMode">密碼加密方式: </label>
								<div class="controls">
									<select name="inputEncryptMode" id="inputEncryptMode">
										<option>MD5</option>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputSiteIndexUrl">網站首頁網址: </label>
								<div class="controls">
									<input type="url" name="inputSiteIndexUrl" id="inputSiteIndexUrl" placeholder="http://">
									</input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputSiteRootUrl">網站系統根網址: </label>
								<div class="controls">
									<input type="url" name="inputSiteIndexUrl" id="inputSiteRootUrl" placeholder="http://">
								</div>
							</div>
						
						</div><!-- /span -->
					</div>
					
					<button type="submit" class="btn btn-success pull-right" id="sendbutton" name="sendbutton">下一步 &raquo;</button>
					<button type="reset" class="btn pull-right" id="resetbutton" name="resetbutton">重填</button>
					
				</form>
			</section>
			
			<hr>
			<?php template_install_footer() ?>
		</div>
		
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/js/jquery-1.10.2.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>