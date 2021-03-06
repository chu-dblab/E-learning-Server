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
	
	require_once("action/step.php");
	if($_POST["inputSiteAdminUser"]){
		input_admin_account();
	}
	
	/**
	 * 取得使用者輸入過的資料
	*/
	session_start();
	$inputSiteName = $_SESSION["install_inputSiteName"];
	$inputSiteSubName = $_SESSION["install_inputSiteSubName"];
	$inputSiteReferred = $_SESSION["install_inputSiteReferred"];
	$inputEncryptMode = $_SESSION["install_inputEncryptMode"];
	$inputSiteRootUrl = $_SESSION["install_inputSiteRootUrl"];
	$inputSiteIndexUrl = $_SESSION["install_inputSiteIndexUrl"];
	
	$inputSQLHost = $_SESSION["install_inputSQLHost"];
	$inputSQLUser = $_SESSION["install_inputSQLUser"];
	//$inputSQLPass = $_SESSION["install_inputSQLPass"];
	$inputSQLDBName = $_SESSION["install_inputSQLDBName"];
	$inputSQLDBFormPrefix = $_SESSION["install_inputSQLDBFormPrefix"];
	
	$inputSiteAdminUser = $_SESSION["install_inputSiteAdminUser"];
	//$inputSiteAdminPass = $_SESSION["install_inputSiteAdminPass"];
	//$inputSiteAdminRepPass = $_SESSION["install_inputSiteAdminRepPass"];
	$inputSiteAdminUserRealName = $_SESSION["install_inputSiteAdminUserRealName"];
	$inputSiteAdminUserNickName = $_SESSION["install_inputSiteAdminUserNickName"];
	$inputSiteAdminUserEmail = $_SESSION["install_inputSiteAdminUserEmail"];
	
	/*$SITE_URL = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$SITE_URL = dirname( dirname($SITE_URL) )."/";*/
	//echo $SITE_URL;
	
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
				<h1>快完成了 <small>請確認你輸入的資訊</small></h1>
			</div>
			
			<section>
				<div class="form-horizontal">
					<div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<label class="control-label">網站名稱: </label>
								<div class="controls">
									<?php echo $inputSiteName ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">網站副標題: </label>
								<div class="controls">
									<?php echo $inputSiteSubName ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">網站簡稱: </label>
								<div class="controls">
									<?php echo $inputSiteReferred ?>
								</div>
							</div>
						</div><!-- /span -->
						
						<div class="span6">
							<div class="control-group">
								<label class="control-label">網站首頁網址: </label>
								<div class="controls">
									<?php echo $inputSiteIndexUrl ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">網站系統根網址: </label>
								<div class="controls">
									<?php echo $inputSiteRootUrl ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">密碼加密方式: </label>
								<div class="controls">
									<?php echo $inputEncryptMode ?>
								</div>
							</div>
						</div><!-- /span -->
					</div>
					<hr>
					<div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<label class="control-label">資料庫伺服器位址: </label>
								<div class="controls">
									<?php echo $inputSQLHost ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">資料庫伺服器帳號: </label>
								<div class="controls">
									<?php echo $inputSQLUser ?>
								</div>
							</div>
						</div><!-- /span -->
						
						<div class="span6">
							<div class="control-group">
								<label class="control-label">要使用的資料庫名稱: </label>
								<div class="controls">
									<?php echo $inputSQLDBName ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">資料表前綴字元: </label>
								<div class="controls">
									<?php echo $inputSQLDBFormPrefix ?>
								</div>
							</div>
						</div><!-- /span -->
					</div>
					<hr>
					<div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<label class="control-label">管理者帳號: </label>
								<div class="controls">
									<?php echo $inputSiteAdminUser ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">姓名: </label>
								<div class="controls">
									<?php echo $inputSiteAdminUserRealName ?>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="control-group">
								<label class="control-label">暱稱: </label>
								<div class="controls">
									<?php echo $inputSiteAdminUserNickName ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">E-mail: </label>
								<div class="controls">
									<?php echo $inputSiteAdminUserEmail ?>
								</div>
							</div>
							
						</div><!-- /span -->
					</div>
					
					<a href="action/install.php" class="btn btn-success pull-right">確認無誤，開始安裝!!</a>
					<a href="javascript:(history.back(1))" class="btn pull-right">&laquo; 上一步</a>
					
				</form>
			</section>
			
			<hr>
			<?php template_install_footer() ?>
		</div>
		
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>