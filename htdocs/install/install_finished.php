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
	
	/**
	 * @ignore
	 */
	function show_status_notify(){
		global $status_message;
		
		if($status_message){
			echo "<div class='alert'>";
			
			echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
			echo $status_message;
			
			echo "</div>";
		}
	}
	
	/**
	 * 取得系統訊息
	*/
	session_start();
	
	$install_config_code = $_SESSION["install_config_code"];
	$install_db_config_code = $_SESSION["install_db_config_code"];
	unset($_SESSION["install_config_code"]);
	unset($_SESSION["install_db_config_code"]);
	
	if($install_config_code || $install_db_config_code){
		$status_message = "因為伺服器權限問題，無法自動建立檔案，請自行手動建立以下檔案";
	}
	else{
		$status_message = NULL;
	}
	
	
	
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
				<h1>安裝完成！ <small>開始使用吧！！</small></h1>
			</div>
			<?php show_status_notify() ?>
			<section>
				
				<?php 
					if($install_config_code){
						echo "<div>";
						echo "<h2>尚未建立config.php</h2>";
						echo "<p>請將以下內容建立成 <code>網站根目錄/config.php</code></p>";
						echo "<pre>".htmlentities($install_config_code, ENT_QUOTES, 'UTF-8')."</pre>";
						echo "</div>";
					}
				?>
				<?php 
					if($install_db_config_code){
						echo "<div>";
						echo "<h2>尚未建立db_config.php</h2>";
						echo "<p>請將以下內容建立成 <code>網站根目錄/config/db_config.php</code></p>";
						echo "<pre>".htmlentities($install_db_config_code, ENT_QUOTES, 'UTF-8')."</pre>";
						echo "</div>";
					}
				?>
				<?php
					if($install_config_code || $install_db_config_code){
						echo "<p class='text-warning'>請先建立好上述檔案後，再進入本網站！！</p>";
						echo "<hr>";
					}
				?>
			</section>
			<section>
				<p><strong>恭喜你！</strong>你已經可以開始使用了！！</p>
				<p>為了增加本站安全性，建議現在可以把<code>網站根目錄/install/</code>整個資料夾刪除吧！！</p>
				<p><a href="../" class="btn btn-success btn-large">進入本站首頁吧 &raquo;</a></p>
			</section>
			<hr>
			<?php template_install_footer() ?>
		</div>
		
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT_TMP_INSTALL ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>