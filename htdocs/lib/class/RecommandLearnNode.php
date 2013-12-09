<?php
  require_once("../lib/include.php");
  require_once(DOCUMENT_ROOT."lib/class/Database.php");

 /**
  * @Class_Name：推薦學習點
  * @author	~kobayashi();
  * @link	https://github.com/CHU-TDAP/
  * @since	Version 1.0
  */
  class RecommandLearnNode
  {
	private $conDB;
	private $fullflag;  //偵測目前這個學習點的人數是否已達上限
	public function __construct()
	{
	  $conDB = new Database();
	  $fullflag = false;
	}
	
     /**
      * @Method_Name	加人數
      * @description	當使用者的手機偵測到NFC Tag或掃描到QR code, 則人數加一
      * @param	   string  $point_number, 學習點的編號
      * @return   NONE
      */
      public function addPeople($point_number)
      {
			$query = $conDB->prepare("UPDATE ".$conDB->table("target")." Mj = Mj + 1 where TID = :number");
			$query->bindParam(":number",$point_number);
			$query->execute();		    
      }
	
     /**
      *  @Method_Name		減人數
      *  @description		當使用者按下"離開"按鈕時, 則人數減一
      *  @param		$point_number, 學習點的編號
      *  @return		NONE
      */		
	public function subPeople($point_number)
	{
	    $query = $conDB->prepare("UPDATE ".$conDB->table("target")." set Mj = Mj - 1 where TID = :number");
	    $query->bindParam(":number",$point_number);
	    $query->execute();		    
	}
	
     /** 
      * @Method_Name	isZero
      * @description	確認目前的學習點是不是零
      * @param		$point_number (data type is an Integer)  學習點的編號
      * @return	Boolean (true/false)
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
	
       /**
	* @Method_Name	getLearningNode
	* @description	取得學習點的參數值，將數值帶入公式計算出推薦分數最高的前三名
	* @param		$point_number_學習點的編號
	* @param		$userID_使用者編號
	* @return		推薦學習之標的編號
	*/
	public function getLearningNode($point_number,$userID)
	{
	      //從資料抓取目前路徑的資料
	      $result = $conDB->prepare("SELECT DISTINCT".$conDB->table("edge").".Ti,".$conDB->table("edge").".Tj".$conDB->table("edge")."MoveTime".
					" FROM ".$conDB->table("edge").",".$conDB->table("recommand").
					" WHERE ".$conDB->table("edge").".Ti = :point_number"." AND ".$conDB->table("recommand").".UID = :userID");
	      $result->bindParam(":point_number",$point_number);
	      $result->bindParam(":UID",$userID);
	      $result->excute();
	      
	      //帶入公式計算下一個要推荐的學習點的編號
	      while($row=$result->fetch()) {
		  $pathCost = -1;
		  $getNextNodeParameter = getNodeOfLearnOfParameter($row["Tj"],$userID);
		  if($getNextNodeParameter["Fj"] == 1) pathCost = 0;
		  else{
			  $pathCost = $getNextNodeParameter["weight"] * ($getNextNodeParameter["S"] - ($getNextNodeParameter["Mj"] / $getNextNodeParameter["PLj"]) + 1) / ( $row["MoveTime"] + $getNextNodeParameter["TLearn_Time"];
			  if($getNextNodeParameter["TID"] <= 11){
			      //實體學習點
			  }
			  else{
			      //虛擬學習點
			      $pathCost = $pathCost * 0.06;
			  }
		  }
	      }
	      //將計算結果做快速排序
	      $temp = array("crrentNode" => $row["Ti"],"nextNode" => $row["Tj"],"PathCost" => $pathCost);
	      $sorted = arsort($temp);
	      //將結果(前三高的學習點)包裝成JSON傳送至手機
	      echo json_encode($sorted);
	}
	
       /**
	* @Method_Name		getNodeOfLearnOfParameter
	* @description		取得學習點的所有參數
	* @param			$next_point_number_學習點的編號
	* @param			$userID_學習者的帳號
	* @return			取得學習點之所有參數(2D array);
	*/
	private function getNodeOfLearnOfParameter($next_point_number,$userID)
	{
		$conString = "SELECT ".$conDB->table("target").".Mj,".$conDB->table("target").".PLj,".$conDB->table("belong").".weight,".$conDB->table("target").".Fj,".
				      $conDB->table("target").".TLearn_Time,".$conDB->table("edge").".MoveTime,".$conDB->table("target").".S".
			     " FROM ".$conDB->table("target").",".$conDB->table("belong").",".$conDB->table("edge").",".$conDB->table("user").
			     " WHERE ".$conDB->table("user").".UID = :UID AND ".$conDB->table("target").".TID = :next_point_number";
		$result = $conDB->prepare($conString);
		$result->bindParam(":UID",$userID);
		$result->bindParam(":next_point_number",$next_point_number);
		$result->execute();		
		$row = $result->fetchAll();
		return $row;
	}
	
       /**
	* @Method_Name		DetectAllLearnNodeFull
	* @description		偵測所有的學習點是不是已經達到限制人數
	* @param			NONE
	* @return			true/false
	*/
	public function DetectAllLearnNodeFull()
	{
	      for($count=2;$count<=10;$count++)
	      {
				$result = $conDB->prepare("SELECT ".$conDB->table("target").".Fj FROM ".$conDB->table("target")." WHERE ".$conDB->table("target").".TID = :count");
				$result->bindParam(":count",$count);
				$result->execute();
				
				while($row=$result->fetch())
				{
					$getNextNodeParameter = getNodeOfLearnOfParameter($row[Tj],1);
					if(!$row["Fj"]) $fullflag = true;
				}
				return $fullflag
	      }
	}
	
       /**
	* @Method_Name		getLearningStatus
	* @description		取得使用者學習的狀態
	* @param			$userID_使用者編號
	* @param			$point_number_學習點的編號
	* @return			學習狀態資訊
	*/	
	public function getLearningStatus($userID,$point_number)
	{
	   $result = $conDB->prepare("SELECT ".$conDB->table("user").".UID,".$conDB->table("user").".UNickname,".$conDB->table("target").".TLearn_Time".$conDB->table("target").".Mj ".
								 "FROM ".$conDB->table("user").",".$conDB->table("target").
								 "WHERE ".$conDB->table("user").".UID = :UID AND ".$conDB->table("target").".TID = :TID");
	   $result->bindParam(":UID",$userID);
	   $result->bindParam(":TID",$point_number);
	   $result->execute();
	   $row = $result->fetchAll();
	   return $row;
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
	   $result = $conDB->prepare("UPDATE ".$conDB->table("study").
				     " SET ".$conDB->table("study").".Answer = ".$ClientData->Answer.",".
					     $conDB->table("study").".Answer_Time = ".$ClientData->Answer_Time.",".
					     $conDB->table("study").".In_TargetTime = ".$ClientData->.In_TargetTime.",".
					     $conDB->table("study").".Out_TargetTime = ".$ClientData->Out_TargetTime.",".
					     $conDB->table("study").".TCheck = ".$ClientData->TCheck.
					     $conDB->table("study").".QID = ".$ClientData->QID.
				    " WHERE ".$conDB->table("study").".TID = ".$ClientData->TID." AND ".$conDB->table("study").".UID = ".$ClientData->UID );
	  $result->excute();
	}
	
	public function userInWhere($userID,$position)
	{
		$result = $conDB->prepare("UPDATE ".$conDB->table("target").
								  " SET ".$conDB->table("target").".");
	}
  }
?>