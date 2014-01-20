<?php
	/**
	 * 前置設定
	*/
	require_once("../../lib/include.php");
	require_once(DOCUMENT_ROOT."admin/template/template.php");
	
	//更新網站
	$output = shell_exec("git checkout master");
	$output .= "\n";
	$output .= shell_exec("git pull origin master");
	//$output .= shell_exec("git submodule update");
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>更新網站 -<?php echo SITE_NAME_REFERRED ?></title>
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
				<h2 class="form-signin-heading">網站更新中</h2>
				
				<p>已啟動網站更新，約半分鐘後即可上去看看</p>
				
				<pre><?php echo $output ?></pre>
				
				<a href="<?php echo SITE_URL ?>" class="btn btn-large btn-primary">回首頁</a>
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