﻿<!--
  user_Group_manager.php
   
   查詢有哪些使用者群組
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	require_once("../lib/include.php");
	require_once(DOCUMENT_ROOT."admin/template/template.php");
	require_once(DOCUMENT_ROOT."lib/userGroup.php");
	
	//讀取session資料
	session_start();
	if( isset($_SESSION["userGroup_create_status"]) ) {
		$status_create =  $_SESSION["userGroup_create_status"];
	}
	if( isset($_SESSION["userGroup_create_status_message"]) ) {
		$status_create_message =  $_SESSION["userGroup_create_status_message"];
	}
	unset($_SESSION["userGroup_create_status"]);
	unset($_SESSION["userGroup_create_status_message"]);
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
	
	//取得共有幾個使用者
	function userGroupsTotal(){
		global $userGroup_DBTable;
		return count($userGroup_DBTable);
	}
	
	//顯示使用者列表
	function showuserGroupsTable(){
		global $userGroup_DBTable;
		if( userGroupsTotal() > 0 ){	//若已有1個以上的使用者
			//建立表格
			echo "<table class='allUsers_table table table-striped'>";
			echo "<thead>";
			echo "<tr>";
				//第1行: 欄位名稱
				echo "<th scpoe='col'>內部名稱</th>";
				echo "<th scpoe='col'>顯示名稱</th>";
				echo "<th scpoe='col'>群組內使用者、</th>";
				echo "<th scpoe='col'>管理員權限</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				foreach ($userGroup_DBTable as $groupKey => $thisGroupArray) {
					echo "<tr>";
						echo "<th scrope='row'>".$thisGroupArray['GID']."</th>";
						echo "<td>".$thisGroupArray['GName']."</td>";
						echo "<td>".$thisGroupArray['in_user']."</td>";
						echo "<td>".$thisGroupArray['Gauth_admin']."</td>";
					echo "</tr>";
				}
			echo "<tbody>";
			echo "</table>";
			
		}
		else{	//若無使用者
			echo "尚未建立使用者群組";
		}
	}
	
	// ------------------------------------------------------------------------
	
	$userGroup_DBTable = userGroup_queryAll();	//查詢所有使用者群組
	
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
						<h1>使用者群組清單</h1>
						<h2></h2>
					</header>
					
					<section id="status-notify">
						<?php show_status_notify() ?>
					</section>
					
					<section>
						<p>總共有<?php echo userGroupsTotal(); ?>個使用者群組</p>
						<?php showuserGroupsTable(); ?>
						
					</section>
					
					<hr />
					
					<section>
						<div class="well"><h2>新增使用者群組</h2>
						
<!--  -->
							<form class="form-horizontal" action="action/userGroup_toCreate.php" method="post">
								<fieldset>
									<div class="control-group">
										<label class="control-label" for="userGroup_id">內部群組名稱: </label>
										<div class="controls">
											<input autofocus type="text" name="userGroup_id" id="userGroup_id" required="required" placeholder="僅限英文字" />
											<span class="help-inline">*</span>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="userGroup_displayName">群組顯示名稱: </label>
										<div class="controls">
											<input type="text" name="userGroup_displayName" id="userGroup_displayName" />
											<span class="help-inline"></span>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">授予權限: </label>
										<div class="controls">
											<label class="checkbox">
												<input type="checkbox" name="userGroup_admin" value="active"> 管理者權限
											</label>
										</div>
									</div>
														
									<hr />
									<div class="control-group">
										<div class="controls">
											<button type="submit" class="btn btn-success" id="sendbutton" name="sendbutton">建立！！</button>
											<button type="reset" class="btn" id="resetbutton" name="resetbutton">重填</button>
										</div>
									</div>
								</fieldset>
							</form>
<!-- -->
						</div>
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