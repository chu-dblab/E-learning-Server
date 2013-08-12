後端伺服器
=======================
## 簡介
主要的東西都放在Server那邊，處理手機客戶端與伺服器資料的溝通。

包含每位學生的學習資料、場地狀況、學習教材。以及處理學習路徑規劃。

## 系統需求
* PHP5 以上 
* MariaDB 5.5.31 (可用MySQL)

## 如何安裝
### 引導式安裝

安裝前請先把`/htdocs/config.php`、`/htdocs/config/db_config.php`砍掉，若之前有安裝過，請砍掉之前安裝的資料庫

1. 請先把`/htdocs/` 整個複製到你的網頁空間
2. 設定你的網頁伺服器、資料夾權限，允許由網頁伺服器建立檔案（此步可略過，但安裝完後請手動建立安裝完成畫面提到的檔案）
3. 打開你的瀏覽器，網址輸入 http://你的網站/install/ 進行安裝，接下來就按照畫面的提示去做
4. 安裝完後，為了增加安全性，請刪除`/htdocs/install/`整個資料夾。

### 手動安裝
1. 請先把`/htdocs/` 整個複製到你的網頁空間
2. 將內附的chu-elearn.sql匯入進你的資料庫
3. 修改 /htdocs/config.php 檔案，依你的需求設定
4. 建立 /htdocs/config/db_config.php 檔案，裡面填入

        <?php
        $DB_SERV = "localhost";    //資料庫伺服器名稱
        $DB_USER = "user";    //資料庫使用者名稱
        $DB_PASS = "password";    //資料庫使用者密碼
        $DB_NAME = "chu-elearn";    //指定要使用哪個資料庫
        $FORM_PREFIX = "ce_";	//資料表的前綴字元


請無視: <strike>執行install.php檔案，將以上述設定檔資料自動安裝資料庫</strike>
    (目前尚未完成此功能，需手動建立資料庫、資料表)

## 本站採用的Framework
### 網頁前端（含後台管理介面）
* Bootstrap Version 2.3.2
* JQuery v1.10.2



## 修改紀錄
* 2013.8.12
    * **Table Name : student 改成 user, 按照ER圖設計
* 2013.8.8
    * **修改SQL檔成專題的後端資料庫，基本上是從第25行開始全部改掉了
* 2013.8.2
    * **架構調整: 利用登入碼針對此帳號操作獨立成User類別**，原`lib/user.php`裡利用登入碼操作的函式將逐漸被User類別取代
    * **對此使用者（登入碼）的資料庫操作，移到`lib/sql.php`**
    * **更改資料庫users資料表欄位: name->realname**
    * User類別: 實作多個函式
* 2013.8.1
    * 改名為`assets/js/jquery.min.js`，並將所有網頁有用到jquery的更改對應路徑
    * **資料庫調整: 更改users欄位名稱group->user_uroup** (因為會和MySQL的保留字衝到)
    * userGroup: 新增 建立群組 函式功能
    * **架構調整: 將lib/user.php的使用者群組相關移出成lib/userGroup.php，並修改相對應的函式名稱**
    * 完成系統安裝流程: 可進入`htdocs/install/install.php`進行安裝
* 2013.7.31
    * **(有調整user api函式)新增使用者群組功能**
* 2013.7.27
    * 使用者帳號建立功能
* 2013.7.26
    * README.md: 加入"如何安裝"
    * 建立後台管理介面！（使用Bootstrap套版）
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
