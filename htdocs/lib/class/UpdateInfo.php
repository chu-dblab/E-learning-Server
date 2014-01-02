<?php

	require_once("../../../lib/include.php");
	require_once(DOCUMENT_ROOT."lib/class/Database.php");
	
	/**
	* @Class_Name：更新所有使用者資訊類別
	* @author	~kobayashi();
	* @link	https://github.com/CHU-TDAP/
	* @since	Version 1.0
	*/
	class UpdateInfo
	{
		private $conDB;
		
		public function __construct()
		{
			$this->conDB = new Database();
		}
		
		/**
		 *	接收Client端傳送過來的資料
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
		 *	更新答題狀態
		 *	@param $questionNumber
		 *	@param $receiveData
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
		* @Method_Name		updateUserLearnData
		* @description		更新使用者的學習狀態
		* @param			$InTime
		* @param			$OutTime
		* @return			NONE
		*/
		public function updateUserLearnData($userID,$point_number,$InTime,$OutTime)
		{
			$result = $this->conDB->prepare("INSERT INTO `".$this->conDB->table("study")."` VALUES (:point,:ID,:in,:out)");
			$result->bindParam(":point",$point_number);
			$result->bindParam(":ID",$userID);
			$result->bindParam(":in",$InTime);
			$result->bindParam(":out",$OutTime);
			$result->execute();
			
			$info=$result->errorInfo();
			echo print_r($info);
		}
		
		
	}
?>