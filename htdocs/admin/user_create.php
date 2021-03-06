<!--
  user_create.php
   
   新增一位使用者
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	require_once("../lib/include.php");
	require_once(DOCUMENT_ROOT."lib/function/user.php");
	require_once(DOCUMENT_ROOT."lib/function/userGroup.php");
	require_once(DOCUMENT_ROOT."admin/template/template.php");
	require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");
	
	//取得通知資料
	$theAlert = new Alert();
	$theAlert->getInSession("user_process");
	
	//輸出通知資料
	/**
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
		<title>建立使用者帳號 -<?php echo SITE_NAME_REFERRED ?></title>
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
				
					<header>
						<h1>新增使用者</h1>
					</header>
					
					<section id="status-notify">
						<?php show_status_notify() ?>
					</section>
					<section id="create-form">
						<form class="form-horizontal" action="action/user_toCreate.php" method="post">
							<fieldset>
								<legend>請在此填入新使用者資料</legend>
								
								<div class="control-group">
									<label class="control-label" for="user_id">帳號: </label>
									<div class="controls">
										<input autofocus type="text" name="user_id" id="user_id" required="required" placeholder="" />
										<span class="help-inline">*</span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="user_password">密碼: </label>
									<div class="controls">
										<input type="password" name="user_password" id="user_password" required="required" oninput="checkPasswords()" />
										<span class="help-inline">*</span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="user_confirm_password">確認密碼: </label>
									<div class="controls">
										<input type="password" name="user_confirm_password" id="user_confirm_password" required="required" oninput="checkPasswords()" />
										<span class="help-inline">*</span>
									</div>
								</div>
								<script>
									function checkPasswords() {
										var user_password = document.getElementById('user_password');
										var user_confirm_password = document.getElementById('user_confirm_password');
										if (user_password.value != user_confirm_password.value) {
											user_confirm_password.setCustomValidity('您這兩次輸入的密碼不同，請再次確認！');
										}
										else {
											user_confirm_password.setCustomValidity('');
										}
									}
								</script>
								
								<div class="control-group">
									<label class="control-label" for="user_group">使用者群組: </label>
									<div class="controls">
										<select name="user_group" id="user_group">
											<?php 
												$userGroup = userGroup_getList();
												foreach($userGroup as $key=>$value){
													echo "<option value='$key'>$key: $value</option>";
												}
											?>
											<!--<option value="MD5">MD5</option>
											<otion value="">無</option>-->
										</select>
										<span class="help-inline">*</span>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<label class="checkbox">
											<input type="checkbox" name="user_active" value="active" checked> 啟用這個帳號
										</label>
									</div>
								</div>
								<hr />
								<div class="control-group">
									<label class="control-label" for="user_realName">姓名: </label>
									<div class="controls">
										<input type="text" name="user_realName" id="user_realName" />
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="user_nickName">暱稱: </label>
									<div class="controls">
										<input type="text" name="user_nickName" id="user_nickName" />
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="user_email">e-mail: </label>
									<div class="controls">
										<input type="email" name="user_email" id="user_email" placeholder="XXX@XXX.XXX" />
										<span class="help-inline"></span>
									</div>
								</div>
										
								<hr />
								<div class="control-group">
									<div class="controls">
										<button type="submit" class="btn btn-success" id="sendbutton" name="sendbutton">註冊！！</button>
										<button type="reset" class="btn" id="resetbutton" name="resetbutton">重填</button>
									</div>
								</div>
							</fieldset>
						</form>
						
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
