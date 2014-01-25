<?php
/**
 * 更新所有使用者資訊類別
 */
	require_once("../../../lib/include.php");
	require_once(DOCUMENT_ROOT."lib/class/Database.php");
//==========================================================================================================
	/**
	 * 更新所有使用者資訊類別
	 *
	 * @author ~kobayashi();
	 * @link https://github.com/CHU-TDAP/
	 * @version Version 1.0
	 */
	class UpdateInfo
	{
		/**
		 * 連接資料庫的PDO物件
		 * @access private
		 * @var PDO Object
		 */
		private $conDB;
		
		public function __construct()
		{
			$this->conDB = new Database();
		}
		
		/**
		 * receiveQuestionData
		 *
		 * 接收Client端傳送過來的資料
		 * @param $num_of_question 問題編號
		 * @param $point_number 標的編號
		 */
		public function receiveQuestionData($num_of_question,$point_number)
		{
			$result = $this->conDB->prepare("INSERT INTO ".$this->conDB->table("question")." VALUES(:qid,:tid,0,0)");
			$result->bindParam(":qid",$num_of_question);
			$result->bindParam(":tid",$point_number);
			$result->execute();
			
			$test = $result->errorInfo();
			echo print_r($test);
		}
		
		/**
		 * updateQestionStatus
		 *
		 * 更新答題狀態
		 *
		 * @param $questionNumber
		 * @param $receiveData
		 */
		public function updateQestionStatus($questionNumber,$receiveData)
		{
				if($receiveData["correct"] == 1)
				{
					$result = $this->conDB->prepare("UPDATE `".$this->conDB->table("question")."` SET `Cnumber` = `Cnumber` + 1 WHERE `QID` = :qid");
					$result->bindParam(":qid",$receiveData["QID"]);
					$result->execute();
					$result->errorInfo();
					$info = $result->errorInfo();
					return print_r($info);
				}
				else if($receiveData["wrong"] == 1)
				{
					$result = $this->conDB->prepare("UPDATE `".$this->conDB->table("question")."` SET `Wnumber` = `Wnumber` + 1 WHERE `QID` = :qid");
					$result->bindParam(":qid",$receiveData["QID"]);
					$result->execute();
					$info = $result->errorInfo();
					return print_r($info);
				}
				else return false;
		}
		
		/**
		 * updateUserLearnData
		 *
		 * 更新使用者的學習狀態
		 *
		 * @param $InTime 進入系統推薦的標的的時間
		 * @param $OutTime 離開系統推薦得標的的時間
		 */
		public function updateUserLearnData($userID,$point_number,$InTime,$OutTime)
		{
			
			$result = $this->conDB->prepare("INSERT INTO `".$this->conDB->table("study")."` VALUES (:point,:ID,:in,:out)");
			$result->bindParam(":point",$point_number);
			$result->bindParam(":ID",$userID);
			$result->bindParam(":in",$InTime);
			$result->bindParam(":out",$OutTime);
			$result->execute();
		}
	}
?>