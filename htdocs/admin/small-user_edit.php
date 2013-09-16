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
	require_once(DOCUMENT_ROOT."lib/function/user.php");
	require_once(DOCUMENT_ROOT."lib/class/User.php");
	
	/**
	 * 產生動作
	*/

	
	
	
	


	
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>編輯使用者帳號 -<?php echo SITE_NAME_REFERRED ?></title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	</head>
	<body>
		<form action="action/user_process.php" method="post">
			<div class="modal-header">
				<h3>修改資料</h3>
			</div>
			<div class="modal-body">
				<?php
				if(!isset( $_REQUEST['UID'] )) {
					//TODO 美化
					echo "uninput UID";
				}
				else if(!user_ishave($_REQUEST['UID'])) {
					//TODO 美化
					echo "No UID";
				}
				else {
					$UID = $_REQUEST['UID'];
					
					$thisUser = new User($UID);
					
					$realName = $thisUser->getRealName();
					$nickName = $thisUser->getNickName();
					$email = $thisUser->getEmail();
					
					echo "<input type='hidden' name='user_UID' id='user_UID' value='$UID' />";
					
					echo "<div class='form-horizontal'>";
						echo "<div class='control-group'>";
							echo "<label class='control-label' for='user_realName'>姓名: </label>";
							echo "<div class='controls'>";
								echo "<input type='text' name='user_realName' id='user_realName' value='$realName' />";
							echo "</div>";
						echo "</div>";
						echo "<div class='control-group'>";
							echo "<label class='control-label' for='user_nickName'>暱稱: </label>";
							echo "<div class='controls'>";
								echo "<input type='text' name='user_nickName' id='user_nickName' value='$nickName' />";
							echo "</div>";
						echo "</div>";
						echo "<div class='control-group'>";
							echo "<label class='control-label' for='user_email'>e-mail: </label>";
							echo "<div class='controls'>";
								echo "<input type='text' name='user_email' id='user_email' value='$email' />";
							echo "</div>";
						echo "</div>";
						
					echo "</div>";
				}
				?>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn">Close</a>
				<button type="reset" class="btn btn-inverse" id="resetbutton" name="resetbutton">重填</button>
				<button type="submit" class="btn btn-success" id="sendbutton" name="sendbutton">註冊！！</button>
			</div>
		</form>
		<script src="<?php echo SITE_URL_ROOT ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>