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
	require_once(DOCUMENT_ROOT."lib/function/user.php");
	require_once(DOCUMENT_ROOT."lib/function/user_admin.php");
	require_once(DOCUMENT_ROOT."lib/function/userGroup.php");
	require_once(DOCUMENT_ROOT."lib/web/AlertClass.php");
	
	//取得通知資料
	$theAlert = new Alert();
	$theAlert->getInSession("user_process");
	
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
			echo "<table id='allUsers_table' class='allUsers_table table table-striped'>";
			echo "<thead>";
			echo "<tr>";
				//第1行: 欄位名稱
				echo "<th scpoe='col'>";
				echo "<div class='btn-group'>";
					echo "<a href='javascript:usel()' class='btn btn-small'><span class='icon-check' /></a>";
					echo "<button class='btn btn-small dropdown-toggle' data-toggle='dropdown'>";
						echo "<span class='caret'></span>";
					echo "</button>";
					echo "<ul class='dropdown-menu'>";
						echo "<li><a href='javascript:selAll()'>全選</a></li>";
						echo "<li><a href='javascript:unselAll()'>全不選</a></li>";
						echo "<li class='divider'></li>";
						echo "<li><a href='javascript:usel()'>反向選</a></li>";
					echo "</ul>";
				echo "</div>";
				echo "</th>";
				
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
				echo "<th scpoe='col'>操作</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				foreach ($user_DBTable as $userKey => $thisUserArray) {
					echo "<tr>";
						echo "<th scrope='row'><input type='checkbox' name='select_UID[]' value='".$thisUserArray['UID']."'></th>";
						echo "<td>".$thisUserArray['UID']."</td>";
						echo "<td>".$thisUserArray['GID']."</td>";
						echo "<td>".$thisUserArray['ULogged_code']."</td>";
						echo "<td>".$thisUserArray['ULast_In_Time']."</td>";
						echo "<td>".$thisUserArray['UBuild_Time']."</td>";
						echo "<td>".$thisUserArray['UEnabled']."</td>";
						echo "<td>".$thisUserArray['In_Learn_Time']."</td>";
						echo "<td>".$thisUserArray['UReal_Name']."</td>";
						echo "<td>".$thisUserArray['UNickname']."</td>";
						echo "<td>".$thisUserArray['UEmail']."</td>";
						echo "<td><a href='#user-edit' class='btn btn-warning' data-toggle='modal'>修改</a></td>";
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
		<style>
			
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
						<h1>使用者帳號清單</h1>
						<h2></h2>
					</header>
					
					<section id="status-notify">
						<?php show_status_notify() ?>
					</section>
					
					<section>
						<form action="action/user_process.php" method="post">
							<p>總共有<?php echo usersTotal(); ?>個使用者</p>
							動作: 
							<select name="action" id="multi-action">
								<option value="">請選擇動作</option>
								<option value="enable">啟用</option>
								<option value="disable">停用</option>
								<!-- <option value="remove">刪除</option> -->
								<option value="logout">強制登出</option>
								<option value="change-userGroup">更換群組至: </option>
							</select>
							<select name="user_group" id="user_group">
								<?php 
									$userGroup = userGroup_getList();
									foreach($userGroup as $key=>$value){
										echo "<option value='$key'>$key: $value</option>";
									}
								?>
							</select>
							<input class="btn btn-success" type="submit" value="送出">
							
							<hr />
							<?php showUsersTable(); ?>
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
		<script>
			//來源: http://jsfiddle.net/mm78k/1/
			function toggleRow() {
				var $this = $(this);
				var $row = $this.parent().parent();

				if ($this.is(':checked'))
				{
					$row.addClass('info');
					//$row.removeClass('off');
				}
				else
				{
					//$row.addClass('off');
					$row.removeClass('info');
				}
			}
			
			//來源: http://blog.xuite.net/abgne/diary1/3855816-%E7%94%A8CheckBox%E4%BE%86%E5%81%9A%E5%85%A8%E9%81%B8%2F%E5%85%A8%E5%8F%96%E6%B6%88%2F%E5%8F%8D%E5%90%91%E9%81%B8%E5%8F%96
			function selAll(){
				//變數checkItem為checkbox的集合
				var checkItem = document.getElementsByName("select_UID[]");
				for(var i=0;i<checkItem.length;i++){
					checkItem[i].checked=true;   
				}
			}
			
			function unselAll(){
				//變數checkItem為checkbox的集合
				var checkItem = document.getElementsByName("select_UID[]");
				for(var i=0;i<checkItem.length;i++){
					checkItem[i].checked=false;
				}
			}
			
			function usel(){
				//變數checkItem為checkbox的集合
				var checkItem = document.getElementsByName("select_UID[]");
				for(var i=0;i<checkItem.length;i++){
					checkItem[i].checked=!checkItem[i].checked;
				}
			}

			$().ready(function() {
				//Assign the toggle
				$('#allUsers_table').find(':checkbox').each(function() {
				$(this).click(toggleRow);
				$(this).parent().parent().addClass('off');
				});
			});
		</script>
	</body>
</html>