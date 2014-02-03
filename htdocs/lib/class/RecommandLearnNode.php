<?php
/**
 * 推薦學習點類別
 */
 
 //前置作業
  require_once("../../../lib/include.php");
  require_once(DOCUMENT_ROOT."lib/class/Database.php");
//===============================================================================================
 /**
  * 推薦學習點
  *
  * 此類別是根據論文上的公式所實作出來的類別
  *
  * @author ~kobayashi();
  * @link https://github.com/CHU-TDAP/
  * @version 2.0
  */
class RecommandLearnNode
{
		/**
		 * 資料庫PDO物件
		 *
		 * @access private
		 * @var PDO Object
		 */
		private $conDB;
		
		/**
		 * 調和參數
		 *
		 * 此欄位是常數值
		 * @access private
		 * @var int
		 */
		const ALPHA = 0.5; //調和參數
		
		/**
		 * 滿額指標
		 *
		 * 偵測目前這個學習點的人數是否已達上限，其值為true/false
		 * @access private
		 * @var Boolean
		 */
		private $fullflag;  //偵測目前這個學習點的人數是否已達上限
		
		/**
		 * 正規化參數
		 *
		 * @access private
		 * @var double
		 */
		private $gamma;  //正規化參數
		
		public function __construct()
		{
			$this->conDB = new Database();
			$this->fullflag = false;
			$this->gamma = 0;
		}
		
		/**
		* 加人數
		*
		* 當使用者的手機偵測到NFC Tag或掃描到QR code, 則人數加一
		*
		* @access private
		* @param string $point_number 學習點的編號
		*/
		public function addPeople($point_number)
		{
			if(!$this->isCurrentPointFull($point_number))
			{
				$query = $this->conDB->prepare("UPDATE `".$this->conDB->table("target")."` SET `Mj` = `Mj` + 1 where `TID` = :number");
				$query->bindParam(":number",$point_number);
				$query->execute(); 
			}
			else return "該學習點人數已達上限";
		}
		
		/**
		* 減人數
		*
		* 當使用者按下"離開"按鈕時, 則人數減一
		*
		* @access public
		* @param string $point_number 學習點的編號
		*/		
		public function subPeople($point_number)
		{
			if(!$this->isZero($point_number))
			{
				$query = $this->conDB->prepare("UPDATE `".$this->conDB->table("target")."` SET `Mj` =`Mj` - 1 WHERE `TID` = :number");
				$query->bindParam(":number",$point_number);
				$query->execute();
			}
			else return "已達最低人數，人數不可能是負值！！";
		}
		
		/** 
		* isZero
		*
		* 確認目前的學習點的人數是不是零
		*
		* @access private
		* @param int $point_number  學習點的編號
		* @return Boolean (true/false)
		*/
		private function isZero($point_number)
		{
			$result = $this->conDB->prepare("SELECT Mj FROM ".$this->conDB->table("target")." WHERE TID = :number AND Mj = 0");
			$result->bindParam(":number",$point_number);
			$result->execute();
			
			$row = $result->fetch();
			if($row["Mj"] == 0) return true;
			else return false;
		}
		
		/**
		 * isCurrentPointFull
		 *
		 * 確認這個學習點是不是人數已滿
		 *
		 * @access private
		 * @param int $point_number 學習點的編號
		 * @return Boolean (true/false)
		 */
		private function isCurrentPointFull($point_number)
		{
			$result = $this->conDB->prepare("SELECT ".$this->conDB->table("target").".Mj,".$this->conDB->table("target").".PLj".
											" FROM ".$this->conDB->table("target")." WHERE TID = :point");
			$result->bindParam(":point",$point_number);
			$result->execute();
			$row = $result->fetch();
			if($row["Mj"] == $row["PLj"]) 
			{
				$query = $this->conDB->prepare("UPDATE `".$this->conDB->table("target")."` SET `Fj` = `Fj` + 1 WHERE `TID` = :point");
				$query->bindParam(":point",$point_number);
				$query->execute();
				return true;
			}
			else return false;
		}
		
		/**
		* getLearningNode
		*
		* 取得學習點的參數值，將數值帶入公式計算出推薦分數最高的前三名
		*
		* @param int $point_number 目前學習點的編號
		* @param string $userID 使用者編號
		* @return $recommand array 系統推薦的學習點 
		*/
		public function getLearningNode($point_number,$userID,$remainingTime)
		{
			$this->gamma = $this->computeNormalizationParam($userID);
			//從資料抓取目前路徑的資料
			$result = $this->conDB->prepare("SELECT DISTINCT ".$this->conDB->table("edge").".Ti,".$this->conDB->table("edge").".Tj,".$this->conDB->table("edge").".MoveTime".
						" FROM ".$this->conDB->table("edge").",".$this->conDB->table("user").
						" WHERE ".$this->conDB->table("edge").".Ti = :point_number"." AND ".$this->conDB->table("user").".UID = :userID");
			$result->bindParam(":point_number",$point_number);
			$result->bindParam(":userID",$userID);
			$result->execute();
			
			$node=array();
			set_time_limit(60);
			//帶入公式計算下一個要推荐的學習點的編號
			while($row=$result->fetch()) 
			{
				$pathCost = -1;
				$isEntity = 1;
				$getNextNodeParameter = $this->getNodeOfLearnOfParameter($row["Tj"],$userID);
				
					if($getNextNodeParameter["Fj"] ==1) $pathCost = 0;
					else
					{
						if($getNextNodeParameter["TID"] <= 15)
						{
							$pathCost = RecommandLearnNode::ALPHA * $this->gamma * ($getNextNodeParameter["weights"] / $getNextNodeParameter["TLearn_Time"]);
							$isEntity = 0;
						}
						else 
						{
							$pathCost = (1-RecommandLearnNode::ALPHA) * $getNextNodeParameter["weights"]*($getNextNodeParameter["S"]-($getNextNodeParameter["Mj"] / $getNextNodeParameter["PLj"]) + 1) / ( $getNextNodeParameter["MoveTime"] + $getNextNodeParameter["TLearn_Time"]);
							
						}
					}
				//儲存計算好的下一個學習點
				$thisArray = array("Ti"=>$row["Ti"],"Tj"=>$row["Tj"],"pathCost"=>$pathCost,"TName"=>$getNextNodeParameter["TName"],"isEntity"=>$isEntity,"LearnTime"=>$getNextNodeParameter["TLearn_Time"],"mapURL"=>$getNextNodeParameter["Map_Url"],"materialUrl"=>$getNextNodeParameter["Material_Url"]);
				array_push($node,$thisArray);
			}
			$recommand = $this->checkIsAllPointAreLearned($node,$userID,$point_number,$remainingTime);
			return $recommand;
		}
		
		/**
		 * 所有學習點是否已學完
		 *
		 * 確認學習點是否已經學完了
		 * @param array $matrix 下一個學習點(含虛擬點)
		 * @param string $userID 使用者帳號
		 * @param int $point_number 標的編號
		 * @param int $remainingTime 剩餘時間
		 * @return 系統推薦的學習點(已過濾)
		 */
		private function checkIsAllPointAreLearned($matrix,$userID,$point_number,$remainingTime)
		{			
			//將結果(前三高的學習點)包裝成JSON傳送至手機
			// TODO 判斷有沒有學習完，不然會陷入無限迴圈(流程待修)
			$i = 0;
			// 檢查系統推薦的學習點在study中是否存在
			while(isset($matrix) && isset($matrix[$i+1])) {
				while($this->checkFinish($userID,$matrix[$i]["Tj"]) && isset($matrix[$i+1]))
				{
// 					echo "<br><pre>matrix: ".print_r($matrix[$i])."\n";
					if($matrix[$i]["Tj"] > 15)
					{
						array_splice($matrix, $i, 1);
					}
					else
					{
						$numID = $matrix[$i]["Tj"] + 15;
						if($this->checkFinish($userID,$numID)) array_splice($matrix, $i, 1);
					}					
				}
				$i++;
			}
			
			if(isset($matrix[$i-1])) {
				if($matrix[$i-1]["Tj"] > 15)
				{
					if($this->checkFinish($userID,$matrix[$i-1]["Tj"])) 
						array_pop($matrix);
				}
				else
				{
					$numID = $matrix[$i-1]["Tj"] + 15;
					if($this->checkFinish($userID,$matrix[$i-1]["Tj"])) array_pop($matrix);
				}
//  				if($matrix[$i-2]["LearnTime"] <= $remainingTime) array_pop($matrix);
			}
			
			//TODO 有問題待修
			$length = count($matrix);
			for($j=0;$j<$length;$j++)
			{
				
				if($matrix[$j]["LearnTime"] <= $remainingTime) array_splice($matrix, $j, 1);
				if(!isset($matrix[$j+1])) break;
			}
			
			/*
			$j=0;
			while($remainingTime > $matrix[$j]["LearnTime"])
			{
				array_splice($matrix, $j, 1);
// 				echo "<pre>All Node:<br>".print_r($matrix,true)."</pre>";
				$j++;
			}*/
			
			//將下一個學習點的陣列排序
			foreach($matrix as $key=>$value)
			{
				$tmp[$key] = $value["pathCost"];
			}
			array_multisort($tmp,SORT_DESC,$matrix,SORT_DESC);
			
// 			echo "<pre>All Node:<br>".print_r($matrix,true)."</pre>";
			
			//塞資料
			if(isset($matrix[0]))
			{
				$info_1 = array("node"=>(int)$matrix[0]["Tj"],"TName"=>$matrix[0]["TName"],"pathCost"=>$matrix[0]["pathCost"],"isEntity"=>$matrix[0]["isEntity"],"LearnTime"=>(int)$matrix[0]["LearnTime"],"MapURL"=>$matrix[0]["mapURL"],"MaterialUrl"=>$matrix[0]["materialUrl"]);
// 				echo "<pre>info_1:<br>".print_r($info_1,true)."</pre>";
			}
			
			if(isset($matrix[1]))
			{
				$info_2 = array("node"=>(int)$matrix[1]["Tj"],"TName"=>$matrix[1]["TName"],"pathCost"=>$matrix[1]["pathCost"],"isEntity"=>$matrix[1]["isEntity"],"LearnTime"=>(int)$matrix[1]["LearnTime"],"MapURL"=>$matrix[1]["mapURL"],"MaterialUrl"=>$matrix[1]["materialUrl"]);
				//echo "<pre>info_2:<br>".print_r($info_2,true)."</pre>";
			}
			if(isset($matrix[2]))
			{
				$info_3 = array("node"=>(int)$matrix[2]["Tj"],"TName"=>$matrix[2]["TName"],"pathCost"=>$matrix[2]["pathCost"],"isEntity"=>$matrix[2]["isEntity"],"LearnTime"=>(int)$matrix[2]["LearnTime"],"MapURL"=>$matrix[2]["mapURL"],"MaterialUrl"=>$matrix[2]["materialUrl"]);
				//echo "<pre>info_3:<br>".print_r($info_3,true)."</pre>";
			}
			
			
			if(isset($info_1) && isset($info_2) && isset($info_3))
				$content = array("first"=>$info_1,"second"=>$info_2,"third"=>$info_3);
			else if(isset($info_1) && isset($info_2))
				$content = array("first"=>$info_1,"second"=>$info_2);
			else if(isset($info_1))
				$content = array("first"=>$info_1);
			
			if(isset($content["first"])) {
				$result = array("currentNode"=>(int)$matrix[0]["Ti"],"nextNode"=>$content);
			}
			else {
				$result = array("currentNode"=>(int)$point_number,"nextNode"=>null);
			}
			
			return $result;
		}
		
		/**
		 * computeNormalizationParam
		 *
		 * 計算正規化參數
		 *
		 * @param string $userID 使用者編號
		 * @return 正規化參數
		 */
		public function computeNormalizationParam($userID)
		{
			$result = $this->conDB->prepare("SELECT DISTINCT ".$this->conDB->table("edge").".Ti,".$this->conDB->table("edge").".Tj,".$this->conDB->table("edge").".MoveTime".
						" FROM ".$this->conDB->table("edge")." WHERE ".$this->conDB->table("edge").".Ti = 0");
			$result->execute();
			
			$sum1 = 0;
			$sum2 = 0;
			while($row=$result->fetch())
			{
				$getNextNodeParameter = $this->getNodeOfLearnOfParameter($row["Tj"],$userID);				
				
				if($getNextNodeParameter["TID"] <= 15 ) $sum2 += $getNextNodeParameter["weights"] / $getNextNodeParameter["TLearn_Time"];
				else
				{
					$Rj = $getNextNodeParameter["Mj"] / $getNextNodeParameter["PLj"];
					$sum1 += ($getNextNodeParameter["weights"] * ($getNextNodeParameter["S"]-$Rj+1)) / ($getNextNodeParameter["MoveTime"] + $getNextNodeParameter["TLearn_Time"]);
				}				
			}
			$normal = $sum1 / $sum2;
			return $normal;
		}
		
		/**
		* getNodeOfLearnOfParameter
		*
		* 取得學習點的所有參數
		*
		* @param int $next_point_number 學習點的編號
		* @param string $userID 學習者的帳號
		* @return 學習點之所有參數(array)
		*/	
		private function getNodeOfLearnOfParameter($next_point_number,$userID)
		{
			$result = $this->conDB->prepare("SELECT ".$this->conDB->table("target").".TID,".
														$this->conDB->table("target").".Mj,".
														$this->conDB->table("target").".PLj,".
														$this->conDB->table("target").".TName,".
														$this->conDB->table("belong").".weights,".
														$this->conDB->table("target").".Fj,".
														$this->conDB->table("target").".TLearn_Time,".
														$this->conDB->table("edge").".MoveTime,".
														$this->conDB->table("target").".S,".
														$this->conDB->table("target").".MapID,".
														$this->conDB->table("target").".MaterialID".
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
							"TName"=>$row["TName"],
							"TLearn_Time"=>$row["TLearn_Time"],"Map_Url"=>$row["MapID"],"Material_Url"=>$row["MaterialID"]);
			}
			return $node;
		}
		
		/**
		 * getLearningStatus
		 * 取得使用者學習的狀態
		 *
		 * @param string $userID 使用者編號
		 * @param int $point_number 學習點的編號
		 * @return 學習狀態資訊(array)
		 */	
		public function getLearningStatus($userID,$point_number)
		{
			$result = $this->conDB->prepare("SELECT ".$this->conDB->table("user").".UID,".$this->conDB->table("user").".UNickname,".$this->conDB->table("target").".TLearn_Time,".$this->conDB->table("target").".Mj ".
										" FROM ".$this->conDB->table("user").",".$this->conDB->table("target").
										" WHERE ".$this->conDB->table("user").".UID = :UID AND ".$this->conDB->table("target").".TID = :TID");
			$result->bindParam(":UID",$userID);
			$result->bindParam(":TID",$point_number);
			$result->execute();
			$row = $result->fetch();
			return $row;
		}
		
		/**
		 * checkFinish
		 *
		 * 確認使用者是不是學過系統推薦的學習點
		 *
		 * @param string $userID 使用者編號
		 * @param int $point 學習點編號
		 * @return true->已經學過系統推薦的學習點,false->還沒學過系統推薦的學習點
		 */
		private function checkFinish($userID,$point)
		{
			$result = $this->conDB->prepare("SELECT ".$this->conDB->table("study").".TID FROM ".$this->conDB->table("study")." WHERE UID = :uid AND TID = :point");
			$result->bindParam(":uid",$userID);
			$result->bindParam(":point",$point);
			$result->execute();
			$row = $result->fetch();
// 			echo "<pre>Row: <br>".print_r($row)."</pre>";
			if($point == $row["TID"]) return true;
			else return false;
		}
}
?>