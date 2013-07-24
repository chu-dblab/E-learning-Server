<!--
   register_account.html
   
   註冊使用者帳號
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	require_once("lib/include.php");
	require_once(DOCUMENT_ROOT."lib/sql.php");

	//$FORM_USER = "users";	//使用者帳號資料表
	
	// ------------------------------------------------------------------------
	// TODO 顯示帳號資料表的function

	
	// ------------------------------------------------------------------------
	
	$db = sql_connect();	//連接資料庫
	// TODO 顯示所有帳號
	
	
	
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
				</section>
				
			</div>
		</div>
		<footer>
			<p>Create in 2013/7/24 &nbsp;&nbsp;By 元兒～</p>
		</footer>
	</body>
</html>
<?php sql_close($db); ?>