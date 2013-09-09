<?php
 	require_once("../lib/include.php");
    require_once(DOCUMENT_ROOT."lib/DatabaseClass.php");
	
	/*
	 *  類別名稱：推薦學習點
     */
	class RecommandLearnNode
	{
		private $conDB;
		private $fullflag;  //偵測目前這個學習點的人數是否已達上限
		public function __construct()
		{
		  $conDB = new Database();
		}
		
		/*
		 * 方法名稱：加人數
		 * 說明：當使用者的手機偵測到NFC Tag或掃描到QR code, 則人數加一
		 * 參數: $point_number, 學習點的編號
		 * 回傳值： NONE
		 */
		public function addPeople($point_number)
		{
		    $query = $conDB->prepare("UPDATE ".$conDB->table("target")." Mj = Mj + 1 where TID = :number");
			$query->bindParam(":number",$point_number);
		    $result->execute();		    
		}
		
		/*
		 * 方法名稱：減人數
		 * 說明：當使用者按下"離開"按鈕時, 則人數減一
		 * 參數: $point_number, 學習點的編號
		 * 回傳值： NONE
		 */		
		public function subPeople($point_number)
		{
		    $query = $conDB->prepare("UPDATE ".$conDB->table("target")." set Mj = Mj - 1 where TID = :number");
		    $query->bindParam(":number",$point_number);
		    $result->execute();		    
		}
		
		/* 
		 * 方法名稱：isZero
		 * 說明：確認目前的學習點是不是零
		 * 參數：point_number (data type is an Integer)  學習點的編號
		 * 回傳值：Boolean (true/false)
		 */
		private function isZero($point_number)
		{
			$isZero = false;
			$result = $conDB->prepare("SELECT Mj FROM ".$conDB->table("target")." WHERE TID = :number AND Mj = 0");
			$result->bindParam(":number",$point_number);
			$result->excute();
			if($result != 0) return false;
			else return true;
		}
		
		/* TODO:
		 * 方法名稱：getLearningNode
		 * 說明：取得學習點(包含權重值)
		 * 參數：$point_number	學習點的編號
		 * 		 $userID	使用者編號
		 * 回傳值：推薦學習之標的編號
		 */
		public function getLearningNode($point_number,$userID)
		{
			$result = $conDB->prepare("SELECT ".$conDB->table("")."FROM WHERE" );
		}
		
		/*
		 * 方法名稱：getNodeOfLearnOfParameter
		 * 說明：取得學習點的所有參數
		 */
		private function getNodeOfLearnOfParameter($next_point_number,$userID)
		{
			$result = $conDB->prepare("SELECT ".$conDB->table("target").".Mj,".$conDB->table("target").".PLj,FROM WHERE");
		}
		
		/*
		 * 方法名稱：DetectAllLearnNodeFull
		 * 說明：偵測所有的學習點是不是已經達到限制人數
		 * 參數：NONE
		 * 回傳值：true/false
		 */
		public function DetectAllLearnNodeFull()
		{
			
		}
	}
?>