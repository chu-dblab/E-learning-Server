<!--
  site_manager.php
   
   本站管理
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	// 前置設定
	require_once("../lib/include.php");
	require_once(DOCUMENT_ROOT."admin/template/template.php");
	require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");
	require_once(DOCUMENT_ROOT."config/db_config.php");
	
	//取得通知資料
	$theAlert = new Alert();
	$theAlert->getInSession("site_manager");
	
	/**
	 * 輸出通知資料
	 * @ignore
	 */
	function show_status_notify(){
		global $theAlert;
		$theAlert->show();
	}
	
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

					<section id="site-manager">
						<header>
							<h2>本站管理</h2>
						</header>
						
						<section id="status-notify">
							<?php show_status_notify() ?>
						</section>
						
						<div class="row-fluid">
							<div class="span6">
								<section>
									<h3>網站名稱</h3>
									<form action="action/site_manager_action.php?action=rename_site_title" method="post">
										<div class="control-group">
											<label class="control-label" for="inputSiteName">網站名稱: </label>
											<div class="controls">
												<input type="text" name="inputSiteName" required="required" id="inputSiteName" placeholder="完整的網站名稱" value="<?php echo SITE_NAME; ?>">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="inputSiteSubName">網站副標題: </label>
											<div class="controls">
												<input type="text" name="inputSiteSubName" id="inputSiteSubName" placeholder="副標題" value="<?php echo SITE_SUBNAME; ?>">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="inputSiteReferred">網站簡稱: </label>
											<div class="controls">
												<input type="text" name="inputSiteReferred" id="inputSiteReferred" placeholder="簡稱" value="<?php echo SITE_NAME_REFERRED; ?>">
											</div>
										</div>
										<button type="submit" class="btn btn-success">更改</button>
									</form>
								</section>
								
								<section>
									<h3>網站更新</h3>
									<p>將會在伺服器下<code>git pull origin publish</code></p>
									<a href="action/update_site_on_git.php" class="btn btn-warning">更新</a>
								</section>
							</div><!--/span-->
							
							<div class="span6">
								<section>
									<h3>更改預設加密方式</h3>
									<form action="action/site_manager_action.php?action=change_default_encryptMode" method="post">
										<div class="input-append">
											<!-- TODO 自動選取目前的設定 -->
											<select name="inputEncryptMode" id="inputEncryptMode">
												<option value="MD5">MD5</option>
												<option value="SHA1">SHA1</option>
												<option value="CRYPT">CRYPT</option>
												<option value="">無</option>
											</select>
											<button type="submit" class="btn btn-success">更改</button>
										</div>
									</form>
								</section>
								
								<section>
									<h3>Cookies設定</h3>
									<form action="action/site_manager_action.php?action=change_cookies_config" method="post">
										<div class="control-group">
											<label class="control-label" for="inputCookiesPrefix">前綴字元: </label>
											<div class="controls">
												<input type="text" required="required" name="inputCookiesPrefix" id="inputCookiesPrefix" value="<?php echo $COOKIES_PREFIX; ?>" placeholder="chu_">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="inputCookiesUserExpired">使用者登入期限: </label>
											<div class="controls">
												<input type="number" required="required" name="inputCookiesUserExpired" id="inputCookiesUserExpired" value="<?php echo $COOKIES_LOGIN_TIMEOUT; ?>" placeholder="86400">
											</div>
										</div>
										<button type="submit" class="btn btn-success">更改</button>
									</form>
								</section>
							</div><!--/span-->
						</div><!--/row-->
					</section>
					
					<hr />
					
					<section id="database-manager">
						<header>
							<h2>資料庫管理</h2>
						</header>
						<div class="row-fluid">
							<div class="span6">
								<section>
									<h3>更改資料庫名稱</h3>
									<form action="action/site_manager_action.php?action=rename_db_name" method="post">
										<div class="input-append">
											<input type="text" required="required" name="inputSqlName" id="inputSqlName" value="<?php echo $DB_NAME; ?>">
											<button type="submit" class="btn btn-success">更改</button>
										</div>
									</form>
								</section>
							</div><!--/span-->
							
							<div class="span6">
								<section>
									<h3>更改資料表的前綴字元</h3>
									<form action="action/site_manager_action.php?action=rename_db_prefix" method="post">
										<div class="input-append">
											<input type="text" required="required" name="inputSqlPrefix" id="inputSqlPrefix" value="<?php echo $FORM_PREFIX; ?>">
											<button type="submit" class="btn btn-success">更改</button>
										</div>
									</form>
								</section>
							</div><!--/span-->
						</div><!--/row-->
						
						<div class="row-fluid">
							<div class="span6">
								<!--<section>
									<h3>重設資料庫內容</h3>
									<p class="text-warning"><strong>警告！</strong>執行此動作，將會刪除所有的資料！！</p>
									<form>
										<p class="muted">含所有的使用者帳號將清除，請建立一個管理者帳號</p>
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
										<button type="submit" class="btn btn-danger">重設</button>
									</form>
								</section>-->
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
