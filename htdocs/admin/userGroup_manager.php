<!--
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
	require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");
	require_once(DOCUMENT_ROOT."lib/function/userGroup.php");

	
	//取得通知資料
	$theAlert = new Alert();
	$theAlert->getInSession("userGroup_process");
	// ------------------------------------------------------------------------
	
	//取得上個頁面傳來的訊息
	/**
	 * @ignore
	 */
	function show_status_notify(){
		global $theAlert;
		$theAlert->show();
	}
	
	//取得共有幾個使用者
	/**
	 * @ignore
	 */
	function userGroupsTotal(){
		global $userGroup_DBTable;
		return count($userGroup_DBTable);
	}
	
	//顯示使用者列表
	/**
	 * @ignore
	 */
	function showuserGroupsTable(){
		global $userGroup_DBTable;
		if( userGroupsTotal() > 0 ){	//若已有1個以上的使用者
			//建立表格
			echo "<table id='allUserGroups_table' class='allUserGroups_table table table-striped'>";
			echo "<thead>";
			echo "<tr>";
				//第1行: 欄位名稱
				echo "<th scpoe='col'>內部名稱</th>";
				echo "<th scpoe='col'>顯示名稱</th>";
				echo "<th scpoe='col'>群組內使用者</th>";
				echo "<th scpoe='col'>管理員權限</th>";
				echo "<th scpoe='col'>Client端管理權限</th>";
				echo "<th scpoe='col'>操作</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				foreach ($userGroup_DBTable as $groupKey => $thisGroupArray) {
					echo "<tr>";
						echo "<th scrope='row'>".$thisGroupArray['GID']."</th>";
						echo "<td>".$thisGroupArray['GName']."</td>";
						echo "<td>".$thisGroupArray['in_user']."</td>";
						echo "<td>".$thisGroupArray['Gauth_Admin']."</td>";
						echo "<td>".$thisGroupArray['Gauth_ClientAdmin']."</td>";
						echo "<td>";
							echo "<a href='#edit-userGroup-dialog' class='btn btn-warning' data-toggle='modal' onclick='displayUserEditDialog(&#39;".$thisGroupArray['GID']."&#39;)'><span class='icon-edit icon-white' /></a>";
							echo "<a href='#remove-userGroup-dialog' class='btn btn-danger' data-toggle='modal' onclick='displayUserEditDialog(&#39;".$thisGroupArray['GID']."&#39;)'><span class='icon-remove icon-white' /></a>";
						echo "</td>";
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
		<link href="<?php echo SITE_URL_ROOT ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<style>
			.modal form {
				margin: 0;
			}
		</style>
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
					<!-- 修改使用者群組資料對話方塊 -->
					<div id="edit-userGroup-dialog" class="modal hide fade" tabindex="-1" role="dialog" >
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>修改資料</h3>
						</div>
						<form action="action/userGroup_process.php?action=edit-data" method="post">
							<input type="hidden" name="edit-userGroup_GID" id="edit-userGroup_GID" value="" />
							<div class="form-horizontal">
								<div class="control-group">
									<label class="control-label" for="edit-userGroup_displayName">顯式名稱: </label>
									<div class="controls">
										<input type="text" name="edit-userGroup_displayName" id="edit-userGroup_displayName" value="" />
									</div>
								</div>
								<hr />
								<div class="control-group">
									<label class="control-label">授予權限: </label>
									<div class="controls">
										<ul>
											<li>
												<label class="checkbox">
													<input type="checkbox" name="edit-userGroup_auth-admin" value="on" > 總管理
												</label>
											</li>
											<li>
												<label class="checkbox">
													<input type="checkbox" name="edit-userGroup_auth-client_admin" value="on" > 客戶端管理
												</label>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">關閉</button>
								<button type="submit" class="btn btn-success" id="sendbutton" name="sendbutton">更改！！</button>
							</div>
						</form>
					</div>
					<!-- End-修改使用者群組資料對話方塊 -->
					
					<!-- 確認刪除對話方塊 -->
					<div id="remove-userGroup-dialog" class="modal hide fade" tabindex="-1" role="dialog" >
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>刪除群組</h3>
						</div>
						<form action="action/userGroup_process.php?action=remove" method="post">
							<input type="hidden" name="edit-userGroup_GID" id="edit-userGroup_GID" value="" />
							<div class="modal-body">
								<p class="text-error">這個群組將被刪除，確定嗎？？</p>
							</div>
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
								<button type="submit" class="btn btn-danger" id="sendbutton" name="sendbutton">刪除</button>
							</div>
						</form>
					</div>
					<!-- End-確認刪除對話方塊 -->
					<hr />
					
					<section>
						<div class="well"><h2>新增使用者群組</h2>
							<form class="form-horizontal" action="action/userGroup_toCreate.php" method="post">
								<fieldset>
									<div class="control-group">
										<label class="control-label" for="userGroup_id">內部群組名稱: </label>
										<div class="controls">
											<input type="text" name="userGroup_id" id="userGroup_id" required="required" placeholder="僅限英文字" />
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
											<label class="checkbox">
												<input type="checkbox" name="userGroup_client_admin" value="active"> 客戶端管理
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
		<script>
			//更改使用者資料、更改使用者密碼對話方塊
			function displayUserEditDialog($UID) {
				$('#edit-userGroup-dialog #edit-userGroup_GID').val($UID);
				$('#remove-userGroup-dialog #edit-userGroup_GID').val($UID);
			}
		</script>
	</body>
</html>
