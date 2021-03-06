<!--
  sql_tool_query.php
   
   SQL查詢工具
   
   version: 2.0
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	require_once("../lib/include.php");
	//require_once(DOCUMENT_ROOT."lib/sql.php");
	require_once(DOCUMENT_ROOT."lib/class/Database.php");
	require_once(DOCUMENT_ROOT."admin/template/template.php");
	
	//$sql_query_input = "SELECT * FROM ce_users";
	if(isset($_POST["sql-query-input"])){
		$sql_query_input = $_POST["sql-query-input"];
	}
	// ------------------------------------------------------------------------
	/**
	 * @ignore
	 */
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
	
	/**
	 * @ignore
	 */
	function sqlTotal(){
		global $sql_Table;
		return count($sql_Table);
	}
	
	/**
	 * @ignore
	 */
	function showSqlTable(){
		global $sql_Table, $sql_result;
		if( count($sql_Table) > 0 ){
			//建立表格
			echo "<table id='sql_result' class='table table-striped'>";
			echo "<thead>";
			echo "<tr>";
				for ($i = 0; $i < $sql_result->columnCount(); $i++) {
					echo "<th scpoe='col'>";
					$col = $sql_result->getColumnMeta($i);
					echo $col['name'];
					//echo $sql_TableCol->name; //顯示Field
					echo "</th>";
				}
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				foreach ($sql_Table as $mainKey => $thisArray) {
					echo "<tr>";
						echo "<th scrope='row'>";
						echo $thisArray[0];
						echo "</th>";
						for($i=1; $i<count($thisArray);$i++){
							echo "<td>";
							echo $thisArray[$i]."&nbsp;";
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
	if(isset($sql_query_input)){
		//連接資料庫
		$db = new Database();
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
		
		//對資料庫進行查詢
		try {
			$sql_result = $db->query($sql_query_input);
			$sql_Table = $sql_result->fetchAll(PDO::FETCH_NUM);
			$sql_status = "Finish";
			$sql_result_message = "成功查詢到".sqlTotal()."筆資料！";
		}
		catch(PDOException $e)
		{
			$sql_status = "Error";
			$sql_result_message = $e->getMessage();
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
		<link href="<?php echo SITE_URL_ROOT ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<style>
		#sql-query-input{
			width: 100%;
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
						<h1>SQL語法查詢</h1>
					</header>
					
					<section id="sql-query-input">
						<div class="well">
							<form action="sql_tool_query.php" method="post">
								<div class="control-group">
									<label class="control-label" for="sql-query-input">SQL查詢語法: </label>
									<div class="controls">
										<textarea name="sql-query-input" id="sql-query-input" ><?php if(isset($sql_query_input)){ echo $sql_query_input; } ?></textarea>
									</div>
									<button type="submit" class="btn" id="sendbutton" name="sendbutton">SQL!!!</button>
									<button type="reset" class="btn" id="resetbutton" name="resetbutton">重填</button>
								</div>
							</form>
						</div>
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
		
		<script src="<?php echo SITE_URL_ROOT ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo SITE_URL_ROOT ?>assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
