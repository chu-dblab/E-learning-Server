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
	require_once(DOCUMENT_ROOT."lib/sql.php");
	require_once(DOCUMENT_ROOT."admin/template/template.php");
	
	$sql_query_input = "SELECT * FROM ce_users";
	// ------------------------------------------------------------------------
	
	function show_status_notify(){
		global $sql_status, $sql_result_message;
		
		if($sql_status){
			echo "<div class='alert";
			switch($sql_status){
				case "Finish":
					echo " alert-success";
					break;
				case "Error":
					echo " alert-error";
					break;
			}
			echo "'>";
			
			echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
			echo $sql_result_message;
			
			echo "</div>";
		}
	}
	
	function sqlTotal(){
		global $sql_Table;
		return mysql_num_rows($sql_Table);
	}
	
	function showSqlTable(){
		global $sql_Table;
		if( mysql_num_rows($sql_Table) > 0 ){	//若已有1個以上的使用者
			//建立表格
			echo "<table id='sql_result' class='table table-striped'>";
			echo "<thead>";
			echo "<tr>";
				//第1行: 欄位名稱
				while($sql_TableCol = mysql_fetch_field($sql_Table))
				{
					echo "<th scpoe='col'>";
					echo $sql_TableCol->name; //顯示Field
					echo "</th>";
				}
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				while( $sql_TableRow = mysql_fetch_array($sql_Table) ){
					echo "<tr>";
						echo "<th scrope='row'>";
						echo $sql_TableRow[0];
						echo "</th>";
						for($i=1; $i<mysql_num_fields($sql_Table);$i++){
							echo "<td>";
							echo $sql_TableRow[$i]."&nbsp;";
							print "</td>";
						}
					echo "</tr>";
				}
			echo "<tbody>";
			echo "</table>";
			
		}
		else{
			echo "無資料";
		}
	}
	
	// ------------------------------------------------------------------------
	
	//若有輸入SQL查詢語法的話
	if($sql_query_input){
		//連接資料庫
		$db = sql_connect();
		
		//對資料庫進行查詢
		if( $sql_Table = mysql_query($sql_query_input) ){
			$sql_status = "Finish";
			$sql_result_message = "成功查詢到".sqlTotal()."筆資料！";
		}
		else{
			$sql_status = "Error";
			$sql_result_message =  mysql_error();
		}
	}
	
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>SQL語法查詢 -<?php echo SITE_NAME_REFERRED ?></title>
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
						<h1>SQL語法查詢</h1>
					</header>
					
					<section id="sql-query-input">
						<form action="sql_tool_query.php" method="post">
						
						</form>
					</section>
					
					<section id="status-notify">
						<?php show_status_notify() ?>
					</section>
					
					<section>
						<?php showSqlTable(); ?>
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