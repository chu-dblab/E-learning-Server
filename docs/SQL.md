資料庫連線
=====================
## 

**本專案一律採用PDO來連結資料庫**，不使用mysql專用函式。一個物件即是資料庫連結！

* PHP5.3 以上 （要支援pdo_mysql）
* MariaDB 5.5.31 (可用MySQL)

## 連結資料庫
### PDO連結語法
    $db_connect = new PDO("mysql:dbname=資料庫名;host:位址;charset=utf8;", "資料庫帳號", "密碼");
    
### 本專案的連結語法
    //請先引入需要的函式庫
    require_once("lib/include.php");
    require_once(DOCUMENT_ROOT."lib/class/Database.php");
    
    //* 資料庫連結
    $db_connect = new Database();
    
## 查詢資料
### 簡易查詢範例

#### 用迴圈單筆單筆查詢
`$row=$result->fetch();`: 將 **一筆** 資料以陣列型態記到`$row`變數內

    //資料庫連結
    $db_connect = new Database();
    
    //* SQL查詢
    $result = $db_connect->query("SELECT * FROM chu_users"); 
    
    //除錯用（非必要）
    if ($result === false){
        print_r($db_connect->errorInfo());
    }
    
    //* 顯示查詢結果
    while($row=$result->fetch()){  
        echo '<pre>', print_r($row, true), '</pre>';
    }

#### 一次以二維陣列
`$table=$result->fetchAll();`: 一次 **全部** 資料以二維陣列型態記到`$table`變數內

    //資料庫連結
    $db_connect = new Database();
    
    //SQL查詢
    $result = $db_connect->query("SELECT * FROM chu_users"); 
    
    //除錯用（非必要）
    if ($result === false){
        print_r($db_connect->errorInfo());
    }
    
    //* 顯示查詢結果
    $table=$result->fetchAll();
    echo '<pre>', print_r($table, true), '</pre>';

### 推薦使用！含預處理的查詢範例
主要就是把關鍵字串再次包裝一次，可防SQL Injection。建議要讓使用者填入的地方（如名字、帳號...），用預處理來包裝。

    //關鍵字變數
    $username = "yuan817";

    //資料庫連結
    $db_connect = new Database();
    
    //* 預處理的SQL查詢
    $result = $db_connect->prepare("SELECT * FROM chu_users WHERE `username` = :name");
    $result->bindParam(":name",$username);
    $result->execute();
    
    //除錯用（非必要）
    if ($result === false){
        print_r($db_connect->errorInfo());
    }
    
    //顯示查詢結果
    while($row=$result->fetch()){  
        echo "<pre>", print_r($row, true), "</pre>";
    }
    
## 修改資料
    //關鍵字變數
    $username = "yuan817";
    $user_email = "yuan817.tw@yahoo.com.tw";

    //資料庫連結
    $db_connect = new Database();
    
    //* 修改某筆資料的內容
    $result = $db_connect->prepare("UPDATE chu_users SET `email` = :email WHERE `username` = :name");
    $result->bindParam(":name",$username);
    $result->bindParam(":email",$user_email);
    $result->execute();

    //更動到幾筆資料
    echo $result->rowCount();

## 參考資料
* [Ununtu-PHP PDO安裝](http://programmingpaul.blogspot.tw/2012/09/ununtuphp-pdo.html)
* [Re: 請多用 PDO...](http://www.ptt.cc/bbs/PHP/M.1369529562.A.236.html)
* [淺談 PHP-MySQL, PHP-MySQLi, PDO 的差異](http://blog.roga.tw/2010/06/%E6%B7%BA%E8%AB%87-php-mysql-php-mysqli-pdo-%E7%9A%84%E5%B7%AE%E7%95%B0/)
* [PDO 認識](http://wordpress.lamp.dzvhost.com/?p=605)
