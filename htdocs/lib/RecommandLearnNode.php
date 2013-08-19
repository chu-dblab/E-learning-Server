<?php
   /*
    *  類別名稱：推薦學習點
    */
	
	require_once("DatabaseClass.php");
	class RecommandLearnNode
	{
		private $conDB;
		public function __construct()
		{
		  $conDB = new DatabaseClass();
		}
		
		/*
		 * 方法名稱：加人數
		 * 說明：當使用者的手機偵測到NFC Tag或掃描到QR code, 則人數加一
		 * 參數: $number, 學習點的編號
		 * 回傳值： NONE
		 */
		public function addPeople($number)
		{
		    $query = "UPDATE target set Mj = Mj + 1 where number = ".number;
		    $result = $conDB->execute($query);		    
		}
		
		/*
		 * 方法名稱：減人數
		 * 說明：當使用者按下"離開"按鈕時, 則人數減一
		 */
		
		public function SubPeople()
		{
			
		}
		
		/*
		 * 方法名稱：isZero
		 * 說明：確認目前的學習點是不是零
		 */
		private function isZero()
		{
			
		}
		
		/*
		 * 方法名稱：getLearningPath
		 * 說明：取得學習路徑(包含權重值)
		 */
		public function getLearningPath()
		{
			
		}
		
		/*
		 * 方法名稱：getNodeOfLearnOfParameter
		 * 說明：取得學習點的所有參數
		 */
		public function getNodeOfLearnOfParameter()
		{
			
		}
		
		/*
		 * 方法名稱：QuickSort
		 * 說明：隊取得的資料作快速排序
		 */
		private function QuickSort()
		{
			
		}
		
		/*
		 * 方法名稱：DetechteIsAllLearnNode
		 * 說明：偵測所有的學習點是不是已經達到限制人數
		 */
		public function DetechteIsAllLearnNode()
		{
			
		}
	}
?>