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
	
	$SERVER_URL = $_SERVER["SERVER_NAME"];
	
	require_once("action/step.php");
	input_site_config();
	//echo $SERVER_URL;
	
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
				<h1>第二步 <small>資料庫連結設定</small></h1>
			</div>
			
			<section>
				<form class="form-horizontal" action="input_admin_account.php" method="post">
					<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>提示!</strong> 請使用 MariaDB 或是 MySQL 資料庫系統。
					</div>
					<div class="row-fluid">
						<div class="span6">
						
							<div class="control-group">
								<label class="control-label" for="inputSQLHost">資料庫伺服器位址: </label>
								<div class="controls">
									<input type="text" name="inputSQLHost" value="<?php echo $SERVER_URL ?>" id="inputSQLHost" placeholder="localhost" required="required">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputSQLUser">資料庫伺服器帳號: </label>
								<div class="controls">
									<input type="text" name="inputSQLUser" id="inputSQLUser" placeholder="帳號名稱" required="required">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputSQLPass">資料庫伺服器密碼: </label>
								<div class="controls">
									<input type="password" name="inputSQLPass" id="inputSQLPass" placeholder="密碼" required="required">
								</div>
							</div>
							
						</div><!-- /span -->
						
						<div class="span6">
						
							<div class="control-group">
								<label class="control-label" for="inputSQLDBName">要使用的資料庫名稱: </label>
								<div class="controls">
									<input type="text" name="inputSQLDBName" id="inputSQLDBName" required="required">
									</input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputSQLDBFormPrefix">資料表前綴字元: </label>
								<div class="controls">
									<input type="text" name="inputSQLDBFormPrefix" id="inputSQLDBFormPrefix" placeholder="選填">
								</div>
							</div>
						
						</div><!-- /span -->
					</div>
					
					<button type="submit" class="btn btn-success pull-right" id="sendbutton" name="sendbutton">下一步 &raquo;</button>
					<button type="reset" class="btn pull-right" id="resetbutton" name="resetbutton">重填</button>
					<a href="javascript:(history.back(1))" class="btn pull-right">&laquo; 上一步</a>
					
					
				</form>
			</section>
			
			<hr>
			<?php template_install_footer() ?>
		</div>
		
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/js/jquery-1.10.2.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>