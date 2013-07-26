後端伺服器
=======================
## 簡介
主要的東西都放在Server那邊，處理手機客戶端與伺服器資料的溝通。

包含每位學生的學習資料、場地狀況、學習教材。以及處理學習路徑規劃。

## 系統需求
* PHP4 以上 
* MariaDB 5.5.31 (可用MySQL)

## 如何安裝

1. /htdocs/ 為網站根目錄
2. 修改 /htdocs/config.php 檔案，依你的需求設定
3. 建立 /htdocs/config/db_config.php 檔案，裡面填入

        <?php
        $DB_SERV = "localhost";    //資料庫伺服器名稱
        $DB_USER = "user";    //資料庫使用者名稱
        $DB_PASS = "password";    //資料庫使用者密碼
        $DB_NAME = "chu-elearn";    //指定要使用哪個資料庫
        $FORM_PREFIX = "ce_";	//資料表的前綴字元

4. <strike>執行install.php檔案，將以上述設定檔資料自動安裝資料庫</strike>
    (目前尚未完成此功能，需手動建立資料庫、資料表)

## 本站採用的Framework
### 網頁前端（含後台管理介面）
* Bootstrap Version 2.3.2
* JQuery v1.10.2



## 修改紀錄
* 2013.7.26
    * README.md: 加入**如何安裝**
    * **建立後台管理介面**！（使用Bootstrap套版）
    * 後台管理介面- 使用者列表
* 2013.7.25
    * **更改users資料表的欄位登入碼為`login_code`**
    * 完成登入、登出函式
    * 修正加密函式（避免和HTML、PHP字元衝到）
* 2013.7.24
    * 架構調整
    * 做出測試用的account_list.php網頁
    * 加密函式（目前只提供MD5）
* 2013.7.23
    * 架構調整
    * 建立Git repository
* 更久以前...
    * 建立初步架構

## 部份資源來源

* /htdocs/lib/password.php 的`generatorText($password_len)`函式
    * 原作者: [Tsung-Hao Lee](http://about.me/tsung)
    * 來源: <http://blog.longwin.com.tw/2007/08/php_function_gen_password_2007/>  
* 網站介面套版 Bootstrap
    * 網站: <http://twitter.github.io/bootstrap/index.html>
    * Github: <http://github.com/twitter/bootstrap>
* JQuery
    * 網站: <http://jquery.com/>
    * Github: <http://github.com/jquery/jquery>

## 關於
* 主要連結 <https://github.com/organizations/CHU-TDAP> 
