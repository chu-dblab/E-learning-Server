<?php
/**
 * 使用者帳號類別
 */
// 前置作業
require_once(DOCUMENT_ROOT."lib/class/Database.php");
require_once(DOCUMENT_ROOT."lib/function/password.php");
require_once(DOCUMENT_ROOT."lib/class/UserGroup.php");
require_once(DOCUMENT_ROOT."lib/function/userGroup.php");

/**
 * 使用者處理專用類別
 * 
 * 一個物件即代表這一位使用者
 * @author CHU-TDAP
 * @link https://github.com/CHU-TDAP/
 * @version  Version 2.0
 */
class User {
	/**
	 * 使用者ID
	 * 
	 * @access private
	 * @var string
	 */
	private $thisUID;
	/**
	 * 此帳號的所有資訊
	 * 
	 * 由 $this->getQuery() 抓取資料表中所有資訊，並放在此陣列裡
	 * @access private
	 * @var array
	 */
	private $infoArray;
	
	/**
	 * 取得此使用者的資料表欄位內容
	 *
	 * @access private
	 * @param string $colName 資料表欄位名稱
	 * @return int|bool|string 資料表欄位內容
	 * 
	 * @author	元兒～ <yuan817@moztw.org>
	 * @version	Version 1
	 */
	private function getQueryInfo($colName){
		
		return $this->infoArray[0][$colName];
	}
	/**
	 * 更新此使用者的資料表欄位內容
	 *
	 * @access private
	 * @global string $FORM_USER 在/config/db_table_config.php的使用者資料表名稱
	 * @param string $colName 資料表欄位名稱
	 * @param string $rowContent 資料表此欄位內容
	 * @param int|bool|string 資料表欄位內容
	 * @return int 更動到幾筆
	 * 
	 * @author	元兒～ <yuan817@moztw.org>
	 * @version	Version 4
	 */
	private function setQueryInfo($colName, $rowContent){
		global $FORM_USER;
		$db = new Database();
		
		$queryResult = $db->prepare("UPDATE ".$db->table($FORM_USER)." SET $colName = :content WHERE `UID` = :toUID");
		$queryResult->bindParam(':content',$rowContent);
		$queryResult->bindParam(':toUID',$this->thisUID);
		$queryResult->execute();
		
		return $queryResult->rowCount();
	}
	
	// ========================================================================
	
	/**
	 * 建構子
	 *
	 * @access public
	 * @param string $inputUID 使用者ID
	 */
	public function __construct($inputUID){
		$this->thisUID = $inputUID;
		$this->getQuery();
	}
	
	// ========================================================================
	
	/**
	 * 取得登入碼
	 *
	 * @access public
	 * @return string 登入碼
	 */
	public function getLoggedCode(){
		return $this->getQueryInfo("ULogged_code");
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號名稱
	 *
	 * @access public
	 * @return string 帳號名稱
	 */
	public function getUsername(){
		return $this->thisUID;
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得登入時間
	 *
	 * @access public
	 * @return string 登入時間
	 */
	public function getLoginTime(){
		return $this->getQueryInfo("ULast_In_Time");
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號建立時間
	 *
	 * @access public
	 * @return string 建立時間
	 */
	public function getCreateTime(){
		return $this->getQueryInfo("UBuild_Time");
	}
	// ========================================================================
	
	/**
	 * 取得所在群組
	 *
	 * @access public
	 * @return string 群組名稱
	 */
	public function getGroup(){
		return $this->getQueryInfo("GID");
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得所在群組顯式名稱
	 *
	 * @access public
	 * @return string 群組顯示名稱
	 */
	public function getGroupName(){
		$thisGroup = new UserGroup($this->getQueryInfo("GID"));
		return $thisGroup->getDiaplayName();
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 設定所在群組
	 *
	 * 傳回的字串如果是:
	 * 
	 * @access public
	 * @global string $FORM_USER 在/config/db_table_config.php的使用者資料表名稱
	 * @param string $toGroup 群組
	 * @return string
	 *          是否更改成功
	 *          <ul>
	 *            <li>"Finish": 密碼更改完成 </li>
	 *            <li>"NoFoundUserGroup": 無此使用者群組</li>
	 *            <li>"DBErr": 其他資料庫錯誤</li>
	 *          </ul>
	 * @todo 防呆: 判斷至少要有一個以上的帳號為啟用
	 * 
	 * @author 元兒～ <yuan817@moztw.org>
	 * @version Version 1
	 */
	public function setGroup($toGroup){
		global $FORM_USER;
		
		//連結資料庫
		$db = new Database();
		
		$queryResult = $db->prepare("UPDATE ".$db->table($FORM_USER)." SET `GID` = :togroup WHERE `UID` = :username");
		$queryResult->bindParam(":username",$this->thisUID);
		$queryResult->bindParam(":togroup",$toGroup);
		$queryResult->execute();
		
		
		$errmsg = $queryResult->errorInfo();
		if( $errmsg[1] == 0 ) {
			return "Finish";
		}
		else if ( $errmsg[1] == 1452) {
			return "NoFoundUserGroup";
		}
		else {
			return "DBErr";
		}
	
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號啟用狀態
	 *
	 * @access public
	 * @return bool 是否已啟用
	 */
	public function isEnable(){
		return $this->getQueryInfo("UEnabled");
	}
	
	/**
	 * 設定帳號啟用狀態
	 *
	 * @access public
	 * @param bool $isActive 是否為啟用
	 * @return bool 是否更改成功
	 */
	public function setEnable($isActive){
		return $this->setQueryInfo("UEnabled", $isActive);
	}
	
	// ========================================================================
	
	/**
	 * 取得真實姓名
	 *
	 * @access public
	 * @return string 真實姓名
	 */
	public function getRealName(){
		return $this->getQueryInfo("UReal_Name");
	}
	
	/**
	 * 修改真實姓名
	 *
	 * @access public
	 * @param string $input 新真實姓名
	 * @return bool 是否更改成功
	 */
	public function setRealName($input){
		return $this->setQueryInfo("UReal_Name", $input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得暱稱
	 *
	 * @access public
	 * @return string 暱稱
	 */
	public function getNickName(){
		return $this->getQueryInfo("UNickname");
	}
	
	/**
	 * 修改暱稱
	 *
	 * @access public
	 * @param string $input 新暱稱
	 * @return bool 是否更改成功
	 */
	public function setNickName($input){
		return $this->setQueryInfo("UNickname", $input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得名稱
	 *
	 * @access public
	 * @return string 依照有填入多少名字（優先順序: 暱稱→真實名字→帳號名稱）
	 */
	public function getName(){
		if($this->getNickName() != "") {
			return $this->getNickName();
		}
		else if($this->getRealName() != "") {
			return $this->getRealName();
		}
		else {
			return $this->getUsername();
		}
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * 取得帳號Email
	 *
	 * @access public
	 * @return string 使用者資訊的Email
	 */
	public function getEmail(){
		return $this->getQueryInfo("UEmail");
	}
	
	/**
	 * 修改帳號Email
	 *
	 * @access public
	 * @param string $input 新Email
	 * @return bool 是否更改成功
	 */
	public function setEmail($input){
		return $this->setQueryInfo("UEmail", $input);
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得此帳號查詢
	 *
	 * @access public
	 * @global string $FORM_USER 在/config/db_table_config.php的使用者資料表名稱
	 * @return object 此使用者的資料表內容(回傳NULL為找不到使用者)
	 * @version Version 4
	 */
	public function getQuery(){
		global $FORM_USER;
		$db = new Database();
		
		$queryResult = $db->prepare("SELECT * FROM ".$db->table($FORM_USER)." WHERE `UID` = :toUID");
		$queryResult->bindParam(':toUID',$this->thisUID);
		$queryResult->execute();
		
		$result = $queryResult->fetchAll();
		$this->infoArray = $result;
		return $this->infoArray;
	}
	// ========================================================================
	
	/**
	 * 驗證密碼是否錯誤
	 *
	 * @access public
	 * @global string $ENCRYPT_MODE 放在/config.php的加密方式選項
	 * @param string $inputPasswd 密碼
	 * @param string $mode 加密方式(可省略)
	 * @return bool true:密碼正確，false:密碼錯誤
	 */
	public function isPasswordCorrect(){
		//若帶入兩個參數
		if(func_num_args() == 2){
			//對應變數
			$args = func_get_args();
			$inputPasswd = $args[0];
			$mode = $args[1];
			
			//動作
			if( $this->getQueryInfo("UPassword") == encryptText($inputPasswd, $mode) ){
				return true;
			}
			else{
				return false;
			}
		}
		else if(func_num_args() == 1){
			global $ENCRYPT_MODE;
			$args = func_get_args();
			$inputPasswd = $args[0];
			
			return $this->isPasswordCorrect($inputPasswd, $ENCRYPT_MODE);
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 更改密碼
	 * 
	 * @access public
	 * @global string $FORM_USER 在/config/db_table_config.php的使用者資料表名稱
	 * @global string $ENCRYPT_MODE 在/config.php的加密方式選項
	 * @param string $newPasswd 新密碼
	 * @param string $newPasswdMode 新密碼加密方式（可省略）
	 * @return string 狀態回傳
	 * @version Version 0
	 */
	public function changePassword(){
		global $FORM_USER, $ENCRYPT_MODE;
		//若帶入兩個參數
		if(func_num_args() == 2){
			//對應變數
			$args = func_get_args();
			$newPasswd = $args[0];
			$newPasswdMode = $args[1];
			
			//將密碼加密
			$passwd = encryptText($newPasswd, $newPasswdMode);
			
			//登記新的密碼進資料庫
			$this->setQueryInfo("UPassword", $passwd);
			
			return "Finish";
		}
		else if(func_num_args() == 1){
			//對應變數
			$args = func_get_args();
			$newPasswd = $args[0];
			
			return $this->changePassword($newPasswd, $ENCRYPT_MODE);
		}
	}
	// ========================================================================
	/**
	 * 是否還在登入狀態
	 *
	 * @access public
	 * @return bool 是否仍在登入狀態
	 */
	public function isLogged() {
		if($this->getQuery()) {
			return true;
		} else {
			return false;
		}
	}
	// ------------------------------------------------------------------------
	
	/**
	 * 取得權限清單
	 *
	 * @access public
	 * @return array 權限清單
	 */
	 public function getPermissionList() {
		$thisGroup = new UserGroup($this->getQueryInfo("GID"));
		return $thisGroup->getPermissionList();
		
	 }
	 
	/**
	 * 是否擁有此權限
	 *
	 * @access public
	 * @global string $FORM_USER 在/config/db_table_config.php的使用者資料表名稱
	 * @global string $FORM_USER_GROUP 在/config/db_table_config.php的使用者群組資料表名稱
	 * @param string $permissionName 權限名稱
	 * @return bool 是否擁有
	 */
	 public function havePermission($permissionName) {
		global $FORM_USER,$FORM_USER_GROUP;
		
		//將使用者的選擇轉為資料表的欄位名稱
		switch($permissionName){
			case "admin":
				$db_auth = "Gauth_admin";
				break;
			default:
				$db_auth = $permissionName;
				break;
		}
		
		//對此使用者進行權限查詢
		$db = new Database();
		$queryResult = $db->prepare("SELECT `ugroup`.`$db_auth` 
			FROM `".$db->table($FORM_USER)."` AS `user` 
			JOIN `".$db->table($FORM_USER_GROUP)."` AS `ugroup` ON `user`.`GID` = `ugroup`.`GID` 
			WHERE `UID` = :toUID"
		);
		$queryResult->bindParam(':toUID',$this->thisUID);
		$queryResult->execute();
		
		$result = $queryResult->fetch(PDO::FETCH_NUM);
		if($result[0] == 1) {
			return true;
		}
		else {
			return false;
		}
	 }
	 
	// ------------------------------------------------------------------------
	
	/**
	 * 登出
	 *
	 * @access public
	 * @return bool 是否登出成功
	 */
	 public function logout(){
		global $FORM_USER;
		if($this->thisUID){
			//清除登入碼進資料庫
			$this->setQueryInfo("ULogged_code", NULL);
			
			$this->thisUID = NULL;
			return true;
		}
		return false;
	 }
}
