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
	input_sql_config();
	
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
				<h1>第三步 <small>建立管理者帳號</small></h1>
			</div>
			
			<section>
				<form class="form-horizontal" action="pre_install_detail.php" method="post">
					<div class="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>注意!</strong> 請記好你的管理者帳密，並不要洩漏給第三者。
					</div>
					<div class="row-fluid">
						<div class="span6">
						
							<div class="control-group">
								<label class="control-label" for="inputSiteAdminUser">管理者帳號: </label>
								<div class="controls">
									<input type="text" name="inputSiteAdminUser" id="inputSiteAdminUser" placeholder="帳號名稱" value="root" required="required">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputSiteAdminPass">管理者密碼: </label>
								<div class="controls">
									<input type="password" name="inputSiteAdminPass" id="inputSiteAdminPass" placeholder="請輸入密碼" required="required" oninput="checkPasswords()">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputSiteAdminRepPass">管理者確認密碼: </label>
								<div class="controls">
									<input type="password" name="inputSiteAdminRepPass" id="inputSiteAdminRepPass" placeholder="確認密碼" required="required" oninput="checkPasswords()">
								</div>
							</div>
							<script>
								function checkPasswords() {
									var user_password = document.getElementById('inputSiteAdminPass');
									var user_confirm_password = document.getElementById('inputSiteAdminRepPass');
									if (user_password.value != user_confirm_password.value) {
										user_confirm_password.setCustomValidity('您這兩次輸入的密碼不同，請再次確認！');
									}
									else {
										user_confirm_password.setCustomValidity('');
									}
								}
							</script>
						</div><!-- /span -->
						
						<div class="span6">
						
							<div class="control-group">
								<label class="control-label" for="inputSiteAdminUserRealName">姓名: </label>
								<div class="controls">
									<input type="text" name="inputSiteAdminUserRealName" id="inputSiteAdminUserRealName" placeholder="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputSiteAdminUserNickName">暱稱: </label>
								<div class="controls">
									<input type="text" name="inputSiteAdminUserNickName" id="inputSiteAdminUserNickName" placeholder="">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputSiteAdminUserEmail">E-mail: </label>
								<div class="controls">
									<input type="text" name="inputSiteAdminUserEmail" id="inputSiteAdminUserEmail" placeholder="">
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