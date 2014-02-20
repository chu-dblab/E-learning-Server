後端伺服器
=======================
## 簡介
主要的東西都放在Server那邊，處理手機客戶端與伺服器資料的溝通。

包含每位學生的學習資料、場地狀況、學習教材。以及處理學習路徑規劃。

## 系統需求
* PHP5.3 以上，需要有以下Extension:
    * pdo_mysql
    * zip
* MariaDB 5.5.31 (可用MySQL)

## 開發文件
已將整份專案使用[PHPDocumentor](http://www.phpdoc.org/)產生出[開發文件網站](docs/apidocs/index.html)

產生指令:

    phpdoc -d htdocs/ -t docs/apidocs --ignore htdocs/admin/,htdocs/API/,htdocs/assets/,htdocs/install/,htdocs/template/ --parseprivate --template="zend"

    
## 拷貝專案
1. `$ git clone git@github.com:CHU-TDAP/E-learning-Server.git`

        Cloning into 'E-learning-Server'...
        remote: Counting objects: 2275, done.
        remote: Compressing objects: 100% (820/820), done.
        remote: Total 2275 (delta 1503), reused 2164 (delta 1393)
        Receiving objects: 100% (2275/2275), 682.27 KiB | 89.00 KiB/s, done.
        Resolving deltas: 100% (1503/1503), done.
        Checking connectivity... done
    
2. `$ cd E-learning-Server`
        
3. `$ git submodule init`

        Submodule 'htdocs/Material' (git@github.com:CHU-TDAP/E-learning-material.git) registered for path 'htdocs/Material'

4. `$ git submodule update`

        Cloning into 'htdocs/Material'...
        remote: Counting objects: 322, done.
        remote: Compressing objects: 100% (261/261), done.
        remote: Total 322 (delta 143), reused 220 (delta 44)
        Receiving objects: 100% (322/322), 26.76 MiB | 76.00 KiB/s, done.
        Resolving deltas: 100% (143/143), done.
        Checking connectivity... done
        Submodule path 'htdocs/Material': checked out 'aff4987f61755f0f66fe1bf382b4a3250f080344'
        
## 架設到你自己的伺服器
### Apache
1. 開啟以下設定檔
    * Windows: 到`C:\AppServ\Apache2.2\conf\httpd.conf`
    * Arch Linux: 到`/etc/httpd/conf/httpd.conf`
    
    將 `LoadModule rewrite_module modules/mod_rewrite.so` 取消註解
    
2. 開啟以下設定檔
    * Windows: 到`C:\Windows\php.ini`
    * Arch Linux: 到`/etc/php/php.ini`

    找到`output_buffering`那行修改成 `output_buffering = On`。（`output_buffering = 4096`也OK）

    並將`extension=php_pdo.dll`和`extension=php_pdo_mysql.dll`取消註解。（Linux請把`.so`當成`.dll`看待）
    
3. 啟用本站/重新啟動伺服器:

    * Windows: 
        1. `C:\AppServ\Apache2.2\apache_serviceuninstall.bat`
        2. `C:\AppServ\Apache2.2\apache_serviceinstall.bat`
    * ArchLinux: `$ sudo systemctl restart httpd.service`
    * Ubuntu: `$ sudo service apache2 restart`

### Apache VirtualHost
1. 編輯以下文件:
    * ArchLinux: `/etc/httpd/conf/extra/httpd-vhosts.conf`
    * Ubuntu: `/etc/apache2/sites-available/chu-elearning.conf`
    
    加入以下內容:
    
        # Chu E-learning Website
        <VirtualHost *:80>
            ServerName chu-elearning.yourdomain.name
            ServerAdmin admin@yourdomain.name
            
            DocumentRoot /srv/http/website/chu-elearning/htdocs
            DirectoryIndex index.php index.shtml index.html
        </VirtualHost>
        <Directory /srv/http/website/chu-elearning/htdocs/>
            Options FollowSymLinks MultiViews
            AllowOverride All
            Allow from All
            Order allow,deny
            Require all granted
        </Directory>
    
2. 啟用本站/重新啟動伺服器:
    * ArchLinux: `$ sudo systemctl restart httpd.service`
    * Ubuntu:
        1. `$ sudo a2ensite chu-elearning`
        2. `$ sudo /etc/init.d/apache2 restart`

## 如何安裝
### <del>引導式安裝</del> （目前尚未完成，請不要使用）

安裝前請先把`/htdocs/config.php`、`/htdocs/config/db_config.php`砍掉，若之前有安裝過，請砍掉之前安裝的資料庫

1. 請先把`/htdocs/` 整個複製到你的網頁空間
2. 設定你的網頁伺服器、資料夾權限，允許由網頁伺服器建立檔案（此步可略過，但安裝完後請手動建立安裝完成畫面提到的檔案）
3. 打開你的瀏覽器，網址輸入 http://你的網站/install/ 進行安裝，接下來就按照畫面的提示去做
4. 安裝完後，為了增加安全性，請刪除`/htdocs/install/`整個資料夾。

### 手動安裝
1. 請先把 `/htdocs/` 整個複製到你的網頁空間
2. 將內附的 `chu-elearn.sql` 匯入進你的資料庫
3. 將 `/htdocs/config.sample.php` 檔案複製成 `config.php` ，並依你的需求修改。
4. 將 `/htdocs/config/db_config.sample.php` 檔案複製成 `db_config.php` 檔案，並依你的資料庫狀況修改。


## 本站採用的Framework
### 網頁前端（含後台管理介面）
* Bootstrap Version 2.3.2
* JQuery v1.10.2

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
