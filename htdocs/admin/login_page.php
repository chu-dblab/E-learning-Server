<!--
  user_list.php
   
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
	/*session_start();
	if( isset($_SESSION["user_create_status"]) ) {
		$status_create =  $_SESSION["user_create_status"];
	}
	if( isset($_SESSION["user_create_status_message"]) ) {
		$status_create_message =  $_SESSION["user_create_status_message"];
	}
	unset($_SESSION["user_create_status"]);
	unset($_SESSION["user_create_status_message"]);*/
	// ------------------------------------------------------------------------
	
	//取得上個頁面傳來的訊息
	function show_status_notify(){
		global $status_create, $status_create_message;
		
		if($status_create){
			echo "<div class='alert";
			switch($status_create){
				case "Finish":
					echo " alert-success";
					break;
			}
			echo "'>";
			
			echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
			echo $status_create_message;
			
			echo "</div>";
		}
	}
	// ------------------------------------------------------------------------

	
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>管理者登入 -<?php echo SITE_NAME_REFERRED ?></title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo SITE_URL_ROOT ?>assets/css/bootstrap-top-navbar.css" rel="stylesheet">
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		
		<style>
		body {
		/*padding-top: 40px;
		padding-bottom: 40px;*/
		background-color: #f5f5f5;
		}

		.form-signin {
		max-width: 300px;
		padding: 19px 29px 29px;
		margin: 0 auto 20px;
		background-color: #fff;
		border: 1px solid #e5e5e5;
		-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
		-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
			-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
			box-shadow: 0 1px 2px rgba(0,0,0,.05);
		}
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
		margin-bottom: 10px;
		}
		.form-signin input[type="text"],
		.form-signin input[type="password"] {
		font-size: 16px;
		height: auto;
		margin-bottom: 15px;
		padding: 7px 9px;
		}
		</style>
	</head>
	<body>
		<?php template_admin_top_nav() ?>
		
		<div class="container">
			<form class="form-signin">
				<h2 class="form-signin-heading">請登入管理者帳號</h2>
				
				<input type="text" class="input-block-level" placeholder="帳號名稱">
				<input type="password" class="input-block-level" placeholder="密碼">
				
				<label class="checkbox">
					<input type="checkbox" value="remember-me"> 記住我
				</label>
				
				<button class="btn btn-large btn-primary" type="submit">登入</button>
			</form>
			<hr />
			<footer>
				<?php template_admin_footer() ?>
			</footer>
		</div>
		
		<script src="<?php echo SITE_URL_ROOT ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>