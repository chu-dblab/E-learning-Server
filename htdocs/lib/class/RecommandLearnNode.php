<?php
  require_once("../../../lib/include.php");
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
			$this->conDB = new Database();
			$this->fullflag = false;
		}
		
		/**
		* @Method_Name	加人數
		* @description	當使用者的手機偵測到NFC Tag或掃描到QR code, 則人數加一
		* @param	   string  $point_number, 學習點的編號
		* @return   NONE
		*/
		public function addPeople($point_number)
		{
			$query = $this->conDB->prepare("UPDATE `".$this->conDB->table("target")."` SET `Mj` = `Mj` + 1 where `TID` = :number");
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
			if(!isZero($point_number))
			{
				$query = $this->conDB->prepare("UPDATE `".$this->conDB->table("target")."` SET `Mj` =`Mj` - 1 WHERE `TID` = :number");
				$query->bindParam(":number",$point_number);
				$query->execute();
			}
			else return "已達最低人數，人數不可能是負值！！";
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
			$result = $this->conDB->prepare("SELECT Mj FROM ".$this->conDB->table("target")." WHERE TID = :number AND Mj = 0");
			$result->bindParam(":number",$point_number);
			$result->execute();
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
			$result = $this->conDB->prepare("SELECT DISTINCT ".$this->conDB->table("edge").".Ti,".$this->conDB->table("edge").".Tj,".$this->conDB->table("edge").".MoveTime".
						" FROM ".$this->conDB->table("edge").",".$this->conDB->table("user").
						" WHERE ".$this->conDB->table("edge").".Ti = :point_number"." AND ".$this->conDB->table("user").".UID = :userID");
			$result->bindParam(":point_number",$point_number);
			$result->bindParam(":userID",$userID);
			$result->execute();
			
			$node=array();
			//帶入公式計算下一個要推荐的學習點的編號
			while($row=$result->fetch()) 
			{
				$nextNode=array();
				$pathCost = -1;
				$getNextNodeParameter = $this->getNodeOfLearnOfParameter($row["Tj"],$userID);
				
				if($getNextNodeParameter["Fj"] ==1) $pathCost = 0;
				else
				{
					$pathCost = $getNextNodeParameter["weights"] * ($getNextNodeParameter["S"] - ($getNextNodeParameter["Mj"] / $getNextNodeParameter["PLj"]) + 1) / ( $row["MoveTime"]+$getNextNodeParameter["TLearn_Time"]);
					if($getNextNodeParameter["TID"] > 15)
					{
						//實體學習點
					}
					else 
					{
						$pathCost = $pathCost * 0.06;
					}
				}
				//儲存計算好的下一個學習點
				$thisArray = array("Ti"=>$row["Ti"],"Tj"=>$row["Tj"],"pathCost"=>$pathCost,"LearnTime"=>$getNextNodeParameter["TLearn_Time"],"mapURL"=>$getNextNodeParameter["Map_Url"],"materialUrl"=>$getNextNodeParameter["Material_Url"]);
				array_push($node,$thisArray);
			}
			//將下一個學習點的陣列排序
			foreach($node as $key=>$value) $tmp[$key] = $value["pathCost"];
			array_multisort($tmp,SORT_DESC,$node,SORT_DESC);
			//將結果(前三高的學習點)包裝成JSON傳送至手機
			$info_1 = array("node"=>(int)$node[0]["Tj"],"LearnTime"=>$node[0]["LearnTime"],"MapURL"=>$node[0]["mapURL"],"MaterialUrl"=>$node[0]["materialUrl"]);
			$info_2 = array("node"=>(int)$node[1]["Tj"],"LearnTime"=>$node[1]["LearnTime"],"MapURL"=>$node[1]["mapURL"],"MaterialUrl"=>$node[1]["materialUrl"]);
			$info_3 = array("node"=>(int)$node[2]["Tj"],"LearnTime"=>$node[2]["LearnTime"],"MapURL"=>$node[2]["mapURL"],"MaterialUrl"=>$node[2]["materialUrl"]);
			$content = array("first"=>$info_1,"second"=>$info_2,"third"=>$info_3);
			$recommand = array("currentNode"=>(int)$node[0]["Ti"],"nextNode"=>$content);
			return $recommand;
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
			$result = $this->conDB->prepare("SELECT ".$this->conDB->table("target").".TID,".
														$this->conDB->table("target").".Mj,".
														$this->conDB->table("target").".PLj,".
														$this->conDB->table("belong").".weights,".
														$this->conDB->table("target").".Fj,".
														$this->conDB->table("target").".TLearn_Time,".
														$this->conDB->table("edge").".MoveTime,".
														$this->conDB->table("target").".S,".
														$this->conDB->table("target").".Map_Url,".
														$this->conDB->table("target").".Material_Url".
											" FROM ".$this->conDB->table("target").",".
													$this->conDB->table("belong").",".
													$this->conDB->table("edge").",".
													$this->conDB->table("user").
											" WHERE ".$this->conDB->table("user").".UID = :UID AND ".
														$this->conDB->table("target").".TID = :next_point_number");
			$result->bindParam(":UID",$userID);
			$result->bindParam(":next_point_number",$next_point_number);
			$result->execute();		
			$node = array();
			while($row=$result->fetch())
			{
				$node+=array("TID"=>$row["TID"],
							"PLj"=>$row["PLj"],
							"Mj"=>$row["Mj"],
							"S" => $row["S"],
							"Fj"=>$row["Fj"],
							"MoveTime"=>$row["MoveTime"],
							"weights"=>$row["weights"],
							"TLearn_Time"=>$row["TLearn_Time"],"Map_Url"=>$row["Map_Url"],"Material_Url"=>$row["Material_Url"]);
			}
			return $node;
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
					$result = $this->conDB->prepare("SELECT ".$this->conDB->table("target").".Fj FROM ".$this->conDB->table("target")." WHERE ".$this->conDB->table("target").".TID = :count");
					$result->bindParam(":count",$count);
					$result->execute();
					
					while($row=$result->fetch())
					{
						$getNextNodeParameter = getNodeOfLearnOfParameter($row[Tj],1);
						if(!$row["Fj"]) $this->fullflag = true;
					}
					return $this->fullflag;
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
			$result = $this->conDB->prepare("SELECT ".$this->conDB->table("user").".UID,".$this->conDB->table("user").".UNickname,".$this->conDB->table("target").".TLearn_Time,".$this->conDB->table("target").".Mj ".
										"FROM ".$this->conDB->table("user").",".$this->conDB->table("target").
										"WHERE ".$this->conDB->table("user").".UID = :UID AND ".$this->conDB->table("target").".TID = :TID");
			$result->bindParam(":UID",$userID);
			$result->bindParam(":TID",$point_number);
			$result->execute();
			$row = $result->fetchAll();
			return $row;
		}
}
?>