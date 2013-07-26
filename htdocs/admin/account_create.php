<!--
  account_list.php
   
   查詢有哪些使用者
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	require_once("../lib/include.php");
	require_once(DOCUMENT_ROOT."admin/template/template.php");
	
	//讀取session資料
	session_start();
	$status_create =  $_SESSION["user_create_status"];
	$status_create_message =  $_SESSION["user_create_status_message"];
	unset($_SESSION["user_create_status"]);
	unset($_SESSION["user_create_status_message"]);
	
	function show_status_notify(){
		global $status_create, $status_create_message;
		
		if($status_create){
			echo "<div class='alert";
			switch($status_create){
				case "UsernameCreatedErr":
				case "RepPasswdErr":
					echo " alert-error";
					break;
			}
			echo "'>";
			
			echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
			echo $status_create_message;
			
			echo "</div>";
		}
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
						<form action="account_process.php" method="post">
							<fieldset>
								<legend>請在此填入新使用者資料</legend>
								<label>帳號: <input autofocus type="text" name="user_id" required="required" />*</label>
								<label>密碼: <input type="password" name="user_password" id="user_password" required="required" oninput="checkPasswords()" />*</label>
								<label>確認密碼: <input type="password" name="user_confirm_password" id="user_confirm_password" required="required" oninput="checkPasswords()" />*</label>
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
								 <label class="checkbox">
									<input type="checkbox" name="user_active" value="active" checked> 啟用這個帳號
								</label>
								<hr />
								<label>姓名: <input type="text" name="user_realName" /></label>
								<label>暱稱: <input type="text" name="user_nickName" /></label>
								<label>e-mail: <input type="email" name="user_email" placeholder="XXX@XXX.XXX" /></label>
								<hr />
								<button type="submit" class="btn" id="sendbutton" name="sendbutton">註冊！！</button>
								<button type="reset" class="btn" id="resetbutton" name="resetbutton">重填</button>
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
		
		<script src="<?php echo SITE_URL_ROOT ?>assets/js/jquery-1.10.2.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
<?php sql_close($db); ?>