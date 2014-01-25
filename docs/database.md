#Client 端資料庫

*   Client 端資料庫分成 **2個實體(user、target)** 和 **1個關連(study)** 。
*   分成兩個Java檔, 分別：ClientDBHelper.java、ClientDBProvider.java
*   **ClientDBHelper.java**
    
    + 包含 _SQLiteOpenHelper_ 的 __onCreate()__、 __onUpgrade__ 方法。

        `public void onCreate(SQLiteDatabase db)`

        `public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion)`


    + 資料庫的 *開啟並寫入* ： __openToWrite()__ 、 *開啟並讀* ： __openToRead()__ 、
    	      *開啟* ： __onOpen(db)__、  *關閉* ： __close()__ 。
    
    + onCreate和onUpgrade是在資料庫不存在or版本更改時,會自動run的程式方法,使用者不會使用到；至於其他4個方法, _直接呼叫方法名稱+()_ 即可使用。

*   **ClientDBProvider.java**
    
    + 包含資料庫的4大功能方法。
    
## 功能

1.  __新增__
    * 個別新增改3張表(user、target、study), 所以會有3個新增方法。
    * __<新增> 的3個方法, 只要在()內加入正確對應的參數即可使用!!__
    * **user 新增**
    
     `public long user_insert(String v1,String v2,String v3,String v4)`
    
        + v1 → UID             (使用者帳號)
        + v2 → UNickname       (暱稱)
        + v3 → ULogged_code    (登入碼)
        + v4 → In_Learn_Time   (開始學習時間)
    * **target 新增**

     `target_insert(String v1,String v2,String v3,String v4,String v5)`
     
        + v1 → TID             (標的編號)
        + v2 → MapID           (地圖編號)
        + v3 → Map_Url         (地圖url)
        + v4 → MaterialID      (教材編號)
        + v5 → Material_Url    (教材url)
    * **study 新增**

        `study_insert(String v1,String v2,String v3,String v4,String v5,String v6,String v7,String v8)`
    
        + v1 → TID             (標的編號)
        + v2 → UID             (使用者帳號)
        + v3 → QID             (答題編號)
        + v4 → Answer          (答題對錯)
        + v5 → Answer_Time     (回答時間)
        + v6 → In_TargetTime   (進入標的時間)
        + v7 → Out_TargetTime  (離開標的時間)
        + v8 → TCheck          (有無正確到學習點)
        
    
2.  __修改__
    * 分成2種修改方法：update()、study_update()
    * __這2個方法()中只要加上 table名稱、要修改的內容、WHERE條件字串等參數即可使用。__
    * **user、target 修改**
    
        `update(String user_table,String newv1,String newv2,String where_string)`
        + user 參數
            + user_table → table名稱
            + newv1 → ULogged_code
            + newv2 → In_Learn_Time
            + where_string → WHERE條件
        + target 參數
            + user_table → table名稱
            + newv1 → Map_Url
            + newv2 → Material_Url
            + where_string → WHERE條件
    * **study 修改**
        
        `study_update(String user_table,String newv1,String newv2,String newv3,String newv4,String where_string)`
        + user_table → table名稱
        + newv1 → QID
        + newv2 → Answer
        + newv3 → Answer_Time
        + newv4 → Out_TargetTime
        + where_string → WHERE條件

        
3.  __刪除__
    * 此刪除方法會先判斷撰寫者要選哪個 **Table** ,再做刪除動作。
        
        `delete(String where_string,String user_table)`

        + where_string → WHERE條件
        + user_table → 表格名稱


4.  __查詢__
    * 填入對應的參數即可使用。
    * 結果返回一字串陣列。
        
        `search(String user_table,String search_item,String where_string)`
        + user_table → table名稱
        + search_item → 要搜尋項目
        + where_string → WHERE條件字串

***

## Server 端資料庫名稱及欄位名稱對照表


*   __chu_user__ ( 使用者 Table )

|       欄位名稱 (English)    | 欄位名稱 (Chinese)|    DataType   |  NULL |    KEY    |
|-----------------------------|-------------------|---------------|-------|-----------|
|              UID            |      使用者帳號   |   varchar(30) |   N   |  PRIMARY  |
|              GID            |       標的編號    |   varchar(30) |   N   |  FOREIGN  |
|           UPassword         |         密碼      |   varchar(40) |   N   |           |
|          ULogged_code       |        登入碼     |   varchar(32) |   Y   |           |
|         ULast_In_Time       |     最後登入時間  |    timestamp  |   Y   |           |
|          UBuild_Time        |     帳號建立時間  |    timestamp  |   N   |           |
|            UEnabled         |       啟用狀態    |    tinyint(1) |   N   |           |
|         In_Learn_Time       |     開始學習時間  |    datetime   |   N   |           |
|          UReal_Name         |       真實姓名    |   varchar(20) |   Y   |           |
|           UNickname         |         暱稱      |   varchar(20) |   Y   |           |
|             UEmail          |         信箱      |   varchar(50) |   Y   |           |

*   __chu_target__ ( 標的 Table )

|       欄位名稱 (English)    |       欄位名稱 (Chinese)       |    DataType    |  NULL |    KEY    |
|-----------------------------|--------------------------------|----------------|-------|-----------|
|              TID            |          標的編號              |    int(10)     |   N   |  PRIMARY  |
|             TName           |          標的名稱              |   varchar(15)  |   N   |           |
|           TLearn_Time       |          學習時間              |    int(10)     |   N   |           |
|             MapID           |           地圖ID               |    int(10)     |   N   |           |
|            Map_Url          |           地圖URL              |   varchar(150) |   N   |           |
|           FloorName         |    學習標的所在的樓層名稱      |   varchar(50)  |   N   |           |
|            BlockName        |    學習標的所在的區塊名稱      |   varchar(50)  |   N   |           |
|            BlockMap         | 學習標的所在的樓層區塊地圖名稱 |   varchar(50)  |   N   |           |
|           CourseName        |    學習標的所在的地圖名稱      |   varchar(50)  |   N   |           |
|           MaterialID        |           教材ID               |    int(10)     |   N   |           |
|          Material_Url       |           教材URL              |   varchar(150) |   N   |           |
|             PLj             |          人數上限              |    int(200)    |   N   |           |
|              Mj             |          目前人數              |    int(200)    |   N   |           |
|              S              |      標的的飽和率上限          |      Float     |   N   |           |
|              Fj             |          滿額指標              |      Bool      |   N   |           |

*   __chu_question__ ( 題目 Table )

|       欄位名稱 (English)    |       欄位名稱 (Chinese)       |    DataType    |  NULL |        KEY         |
|-----------------------------|--------------------------------|----------------|-------|--------------------|
|             QID             |          題目編號              |    int(10)     |   N   |      PRIMARY       |
|             QA              |          問題答案              |   varchar(10)  |   N   |                    |
|            Q_Url            |          題目URL               |   varchar(150) |   N   |                    |
|             TID             |          標的編號              |    int(10)     |   N   |  UNIQUE & FOREIGN  |


*   __chu_theme__ ( 主題 Table )

|       欄位名稱 (English)    |       欄位名稱 (Chinese)       |    DataType    |  NULL |    KEY    |
|-----------------------------|--------------------------------|----------------|-------|-----------|
|            ThemeID          |         主題序號               |    int(10)     |   N   |  PRIMARY  |
|           ThemeName         |         主題名稱               |   varchar(15)  |   N   |           |
|     theme_Learn_DateTime    | 本次學習此主題發生的日期時間   |    datetime    |   N   |           |
|        Theme_LearnTotal     |   學習此主題要花的總時間(hr)   |    int(10)     |   N   |           |
|       Theme_Introduction    |           描述                 |   varchar(70)  |   N   |           |


*   __chu_group__ ( 群組 Table )

|       欄位名稱 (English)    |       欄位名稱 (Chinese)       |    DataType    |  NULL |    KEY    |
|-----------------------------|--------------------------------|----------------|-------|-----------|
|              GID            |          群組編號              |    varchar(30) |   N   |  PRIMARY  |
|             GName           |          群組名稱              |    varchar(15) |   N   |           |
|          Gauth_admin        |                                |    tinyint(1)  |   N   |           |
|          GCompetence        |                                |    varchar(10) |   N   |           |



*   __chu_belong__ ( 屬於 Table ) → 主題、標的間關係

|       欄位名稱 (English)    |       欄位名稱 (Chinese)       |    DataType    |  NULL |        KEY         |
|-----------------------------|--------------------------------|----------------|-------|--------------------|
|             TID             |          標的編號              |    int(10)     |   N   |  UNIQUE & FOREIGN  |
|           ThemeID           |          主題序號              |    int(10)     |   N   |  UNIQUE & FOREIGN  |
|           Weights           |            權重                |     float      |   N   |                    |


*   __chu_edge__ ( EDGE Table ) → 標的、標的間關係

|       欄位名稱 (English)    |       欄位名稱 (Chinese)       |    DataType    |  NULL |        KEY         |
|-----------------------------|--------------------------------|----------------|-------|--------------------|
|             Ti              |          標的編號(i)           |    int(10)     |   N   |  UNIQUE & FOREIGN  |
|             Tj              |          標的編號(j)           |   varchar(15)  |   N   |  UNIQUE & FOREIGN  |
|           MoveTime          |           移動時間             |   varchar(20)  |   N   |                    |
|           Distance          |             距離               |   varchar(20)  |   N   |                    |


*   __chu_recommend__ ( 推薦 Table ) → 使用者、標的間關係

|       欄位名稱 (English)    |       欄位名稱 (Chinese)       |    DataType    |  NULL |        KEY         |
|-----------------------------|--------------------------------|----------------|-------|--------------------|
|             TID             |          標的編號              |    int(10)     |   N   |  UNIQUE & FOREIGN  |
|             UID             |          使用者帳號            |   varchar(30)  |   N   |  UNIQUE & FOREIGN  |
|            Order            |       系統推薦標地順序         |    int(50)     |   N   |                    |


*   __chu_study__ ( study Table ) → 使用者、標的間關係

|       欄位名稱 (English)    |       欄位名稱 (Chinese)       |    DataType    |  NULL |        KEY         |
|-----------------------------|--------------------------------|----------------|-------|--------------------|
|             TID             |          標的編號              |    int(10)     |   N   |  UNIQUE & FOREIGN  |
|             UID             |         使用者帳號             |   varchar(30)  |   N   |  UNIQUE & FOREIGN  |
|             QID             |       答題的題目編號           |    int(10)     |   Y   |                    |
|            Answer           |          答題對錯              |   varchar(5)   |   Y   |                    |
|          Answer_Time        |          回答時間              |   varchar(10)  |   Y   |                    |
|         In_TargetTime       |        進入標的時間            |    datetime    |   N   |                    |
|         Out_TargetTime      |        離開標的時間            |    datetime    |   Y   |                    |
|            TCheck           |      有無正確到推薦點          |   varchar(5)   |   N   |                    |


























