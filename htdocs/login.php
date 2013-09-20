<!--
  login.php
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	require_once("lib/include.php");
	require_once(DOCUMENT_ROOT."template/template.php");
	
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>使用者登入 -<?php echo SITE_NAME_REFERRED ?></title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo SITE_URL_ROOT ?>assets/css/bootstrap-Justified_nav.css" rel="stylesheet">
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	</head>
	<body>
	<div class="container">
	
		<?php template_header() ?>
		
		<div class="row-fluid">
		<div class="span12">
			<!-- 使用者登入 -->
			<div class="span6">
				<div class="area">
					<form class="form-horizontal">
						<div class="heading">
							<h4 class="form-heading">使用者登入</h4>
						</div>
						
						<!-- 通知區域 -->
						<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Access Denied!</strong> Please provide valid authorization.
						</div>
						
						<div class="control-group">
							<label class="control-label" for="inputUsername">使用者帳號</label>
							<div class="controls">
								<input type="text" id="inputUsername" placeholder="E.g. ashwinhegde">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">密碼</label>
							<div class="controls">
								<input type="password" id="inputPassword" placeholder="Min. 8 Characters">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox"> 自動讓我登入
								</label>
								<button type="submit" class="btn btn-success">登入</button>
								<button type="button" class="btn">忘記密碼</button>
							</div>
						</div>	
						
					</form>	
				</div>
			</div>
			
			<!-- 註冊帳號 -->
			<div class="span6">
				<div class="area">
					<form class="form-horizontal">
						<div class="heading">
							<h4 class="form-heading">註冊帳號</h4>
						</div>
						
						<!-- 通知區域 -->
						<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Confirmation: </strong> A confirmation email has been sent to your email.<br>
							Thank you for your registration.
						</div>
						
						<div class="control-group">
							<label class="control-label" for="user_id">帳號: </label>
							<div class="controls">
								<input autofocus type="text" name="user_id" id="user_id" required="required" placeholder="完整的網站名稱" />
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
						
						<div class="control-group">
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox"> 我同意遵守<a href="#">這裡的遊戲規則</a>
								</label>
								<button type="submit" class="btn btn-success">Sign Up</button>
								<button type="button" class="btn">Help</button>
							</div>
						</div>	
						
					</form>	
				</div>
			</div>
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