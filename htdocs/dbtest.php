<?php 
/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/

require_once("lib/include.php");
require_once(DOCUMENT_ROOT."lib/DatabaseClass.php");

$db_connect = new PDO("mysql:dbname=yuan_chu_elearn;host:localhost;charset=utf8;", "yuan", "123456");
//$db_connect = new PDO("mysql:host:localhost;dbname=yuan_chu_elearn;charset=utf8;", "yuan", "123456");

$result = $db_connect->query("SELECT * FROM xe_users WHERE `username` = 'yuan817'"); 

if ($result === false){
    print_r($db_connect->errorInfo());
    //log the error or take some other smart action
}

while($row=$result->fetch(PDO::FETCH_OBJ)){   
	//PDO::FETCH_OBJ 指定取出資料的型態
	echo $row->username."\n"; 
	echo $row->ID."\n";  
}

echo "<h1>Finish</h1>";