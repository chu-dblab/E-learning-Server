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
	//require_once(DOCUMENT_ROOT."lib/sql.php");
	require_once(DOCUMENT_ROOT."admin/template/template.php");
	require_once(DOCUMENT_ROOT."lib/user.php");
	
	// ------------------------------------------------------------------------
	// TODO 顯示帳號資料表的function
	function usersTotal(){
		global $user_DBTable;
		return mysql_num_rows($user_DBTable);
	}
	
	function showUsersTable(){
		global $user_DBTable;
		if( usersTotal() > 0 ){	//若已有1個以上的使用者
			//建立表格
			echo "<table class='allUsers_table'>";
			echo "<thead>";
			echo "<tr>";
				//第1行: 欄位名稱
				echo "<th scpoe='col'>ID</th>";
				echo "<th scpoe='col'>帳號名稱</th>";
				echo "<th scpoe='col'>登入碼</th>";
				echo "<th scpoe='col'>最後登入時間</th>";
				echo "<th scpoe='col'>建立時間</th>";
				echo "<th scpoe='col'>啟用</th>";
				echo "<th scpoe='col'>真實姓名</th>";
				echo "<th scpoe='col'>暱稱</th>";
				echo "<th scpoe='col'>Email</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				while( $user_DBTableRow = mysql_fetch_array($user_DBTable) ){
					echo "<tr>";
						echo "<th scrope='row'>".$user_DBTableRow['ID']."</th>";
						echo "<td>".$user_DBTableRow['username']."</td>";
						echo "<td>".$user_DBTableRow['logged_code']."</td>";
						echo "<td>".$user_DBTableRow['last_login_time']."</td>";
						echo "<td>".$user_DBTableRow['create_time']."</td>";
						echo "<td>".$user_DBTableRow['isActive']."</td>";
						echo "<td>".$user_DBTableRow['name']."</td>";
						echo "<td>".$user_DBTableRow['nickname']."</td>";
						echo "<td>".$user_DBTableRow['email']."</td>";
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
	
	$db = sql_connect();	//連接資料庫0
	$user_DBTable = user_queryAll($db);	//查詢所有使用者
	
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>建立使用者帳號</title>
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

					<section>
						<p>總共有<?php echo usersTotal(); ?>個使用者</p>
						<?php showUsersTable(); ?>
						
					</section>
					
				</div><!--/span-->
			</div>
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