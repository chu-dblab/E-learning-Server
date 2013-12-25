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
			$result = $this->conDB->prepare("INSERT INTO ".$this->conDB->table("question")." VALUES(:qid,:tid:)");
			$result->bindParam(":qid",$num_of_question);
			$result->bindParam("tid",$point_number);
			$result->execute();
			
			$result->errorInfo();
			echo "String = ".$result->errorInfo();
		}
		
		/**
		 *	更新答題狀態
		 */
		public function updateQestionStatus()
		{
			$receiveData = json_decode($JSONData);
			$result = $this->conDB->prepare("SELECT * FROM ".$this->conDB->table("question"));
			$result->execute();
			
			$result->errorInfo();
			echo "String = ".$result->errorInfo();
			
			/*
			if($result != null)
			{
				if($receiveData["correct"] == 1)
				{
					$result = $this->conDB->prepare("UPDATE `".$this->conDB->table("question")."` SET `Cnumber` = `Cnumber` + 1 WHERE `QID` = :qid");
					$result->bindParam(":qid",$receiveData["QID"]);
					$result->execute();
					$result->errorInfo();
					echo "String = ".$result->errorInfo();
				}
				else if($receiveData["wrong"] == 1)
				{
					$result = $this->conDB->prepare("UPDATE `".$this->conDB->table("question")."` SET `Wnumber` = `Wnumber` + 1 WHERE `QID` = :qid");
					$result->bindParam(":qid",$receiveData["QID"]);
					$result->execute();
					$result->errorInfo();
					echo "String = ".$result->errorInfo();
				}
				else return false;
			}*/
		}
		
		/**
		* @Method_Name		updateUserLearnData
		* @description		更新使用者的學習狀態
		* @param			$JSONData Client端所傳過來的JSON格式資料
		* @return			NONE
		*/
		public function updateUserLearnData($JSONData)
		{
			$ClientData = json_decode($JSONData);
			$result = $this->conDB->prepare("UPDATE ".$this->conDB->table("study")." SET ".$this->conDB->table("study").".Answer = ".$ClientData->Answer.","
												.$this->conDB->table("study").".Answer_Time = ".$ClientData->Answer_Time.","
												.$this->conDB->table("study").".In_TargetTime = ".$ClientData->In_TargetTime.","
												.$this->conDB->table("study").".Out_TargetTime = ".$ClientData->Out_TargetTime.","
												.$this->conDB->table("study").".TCheck = ".$ClientData->TCheck
												.$this->conDB->table("study").".QID = ".$ClientData->QID." WHERE ".$this->conDB->table("study").".TID = ".$ClientData->TID." AND ".$this->conDB->table("study").".UID = ".$ClientData->UID );
			$result->excute();
			$result->errorInfo();
			echo "String = ".$result->errorInfo();
		}
		
		
	}
?>