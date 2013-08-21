﻿<!--
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
	require_once(DOCUMENT_ROOT."lib/user.php");
	require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");
	
	//取得通知資料
	$theAlert = new Alert();
	$theAlert->getInSession("user_create");
	
	// ------------------------------------------------------------------------
	
	//輸出通知資料
	function show_status_notify(){
		global $theAlert;
		$theAlert->show();
	}
	
	//取得共有幾個使用者
	function usersTotal(){
		global $user_DBTable;
		return count($user_DBTable);
	}
	
	//顯示使用者列表
	function showUsersTable(){
		global $user_DBTable;
		if( usersTotal() > 0 ){	//若已有1個以上的使用者
			//建立表格
			echo "<table class='allUsers_table table table-striped'>";
			echo "<thead>";
			echo "<tr>";
				//第1行: 欄位名稱
				echo "<th scpoe='col'>帳號</th>";
				echo "<th scpoe='col'>群組</th>";
				echo "<th scpoe='col'>登入碼</th>";
				echo "<th scpoe='col'>登入時間</th>";
				echo "<th scpoe='col'>建立時間</th>";
				echo "<th scpoe='col'>啟用</th>";
				echo "<th scpoe='col'>開始學習時間</th>";
				echo "<th scpoe='col'>真實姓名</th>";
				echo "<th scpoe='col'>暱稱</th>";
				echo "<th scpoe='col'>Email</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				foreach ($user_DBTable as $userKey => $thisUserArray) {
					echo "<tr>";
						echo "<th scrope='row'>".$thisUserArray['UID']."</th>";
						echo "<td>".$thisUserArray['GID']."</td>";
						echo "<td>".$thisUserArray['ULogged_code']."</td>";
						echo "<td>".$thisUserArray['ULast_In_Time']."</td>";
						echo "<td>".$thisUserArray['UBuild_Time']."</td>";
						echo "<td>".$thisUserArray['UEnabled']."</td>";
						echo "<td>".$thisUserArray['In_Learn_Time']."</td>";
						echo "<td>".$thisUserArray['UReal_Name']."</td>";
						echo "<td>".$thisUserArray['UNickname']."</td>";
						echo "<td>".$thisUserArray['UEmail']."</td>";
					echo "</tr>";
				}
			echo "<tbody>";
			echo "</table>";
			
		}
		else{	//若無使用者
			echo "尚未建立使用者";
		}
	}
	
	// ------------------------------------------------------------------------
	
	$user_DBTable = user_queryAll();	//查詢所有使用者
	
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
						<h1>使用者帳號清單</h1>
						<h2></h2>
					</header>
					
					<section id="status-notify">
						<?php show_status_notify() ?>
					</section>
					
					<section>
						<p>總共有<?php echo usersTotal(); ?>個使用者</p>
						<?php showUsersTable(); ?>
						
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