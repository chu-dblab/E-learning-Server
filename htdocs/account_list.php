<!--
   register_account.html
   
   註冊使用者帳號
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	$ROOT_FILE = "";	//根目錄的位置
	
	$FORM_USER = "users";	//使用者帳號資料表
	
	// ------------------------------------------------------------------------
	
	/**
	 * 要include進來的函式庫
	*/
	require_once($ROOT_FILE."lib/sql.php"); //取得連結資料庫連結變數
	// ------------------------------------------------------------------------
	// TODO 顯示帳號資料表的function
	function displayAllUsersTable(){
		global $FORM_USER;
		
		echo sql_getFormName($FORM_USER);
		
		
		//建立表格
		print "<table>";
		
		//建立標題列
		print "<thead>";
		print "<tr>";
		print "<th scpoe='col'>";
		print $db_tablecol->name; //顯示Field
		print "</th>";
		print "</tr>";
		print "</thead>";
		
		//建立內容
		print "<tbody>";
		while($db_tablerow = mysql_fetch_array($db_table))
		{
			//寫法1: 
			print "<tr>";
			print "<th scrope='row'>".$db_tablerow[$DB_FROM_1COL]."</th>"; //陣列變數的[]處，也可以填入"資料表的欄位名稱"
			print "<td>".$db_tablerow[1]."</td>";
			print "<td>".$db_tablerow[2]."</td>";
			print "<td>".$db_tablerow[3]."</td>";
			print "<td>".$db_tablerow[4]."</td>";
			print "<td>".$db_tablerow[5]."</td>";
			print "<td>".$db_tablerow[6]."</td>";
			print "<td>".$db_tablerow[7]."</td>";
			print "<td>".$db_tablerow[8]."</td>";
			print "<td>".$db_tablerow[9]."</td>";
			print "<td>".$db_tablerow[10]."</td>";
			print "<td>".$db_tablerow[11]."</td>";
			print "</tr>";

		}
		print "<tbody>";
		print "</table>";
		
	}
	
	// ------------------------------------------------------------------------
	
	$db = sql_connect();	//連接資料庫
	// TODO 顯示所有帳號
	
	//sql_close($db);
	
?>
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>建立使用者帳號</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="mySeverDefault.css" />
	</head>
	<body>
		<div id="wrapper" class="container">
			<header>
				<h1>使用者帳號清單</h1>
				<h2></h2>
			</header>
		
			<div id="main" role="main">
				
				<section>
					<?php displayAllUsersTable(); ?>
				</section>
				
			</div>
		</div>
		<footer>
			<p>Create in 2013/7/24 &nbsp;&nbsp;By 元兒～</p>
		</footer>
	</body>
</html>
