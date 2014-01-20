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
		* @param $point_number 學習點的編號
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
		* @param $point_number int  學習點的編號
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
		 * @param $point_number 學習點的編號
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
		* @param $point_number 目前學習點的編號
		* @param $userID 使用者編號
		* @return $recommand array 系統推薦的學習點 
		*/
		public function getLearningNode($point_number,$userID)
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
			//將下一個學習點的陣列排序
			foreach($node as $key=>$value)
			{
				$tmp[$key] = $value["pathCost"];
			}
			array_multisort($tmp,SORT_DESC,$node,SORT_DESC);
			
			//將結果(前三高的學習點)包裝成JSON傳送至手機
			// TODO 判斷有沒有學習完，不然會陷入無限迴圈
			$i = 0;
			while(isset($node) && isset($node[$i+1])) {
				while($this->checkFinish($userID,$node[$i]["Tj"]) && isset($node[$i+1])) array_splice($node, $i, 1);
				$i++;
			};
			
			if(isset($node[$i-1])) {
				if( $this->checkFinish($userID,$node[$i-1]["Tj"]) ) array_pop($node);
			}
			
			if(isset($node[0]))
				$info_1 = array("node"=>(int)$node[0]["Tj"],"TName"=>$node[0]["TName"],"pathCost"=>$node[0]["pathCost"],"isEntity"=>$node[0]["isEntity"],"LearnTime"=>(int)$node[0]["LearnTime"],"MapURL"=>$node[0]["mapURL"],"MaterialUrl"=>$node[0]["materialUrl"]);
			
			if(isset($node[1]))
				$info_2 = array("node"=>(int)$node[1]["Tj"],"TName"=>$node[1]["TName"],"pathCost"=>$node[1]["pathCost"],"isEntity"=>$node[1]["isEntity"],"LearnTime"=>(int)$node[1]["LearnTime"],"MapURL"=>$node[1]["mapURL"],"MaterialUrl"=>$node[1]["materialUrl"]);
			if(isset($node[2]))
				$info_3 = array("node"=>(int)$node[2]["Tj"],"TName"=>$node[2]["TName"],"pathCost"=>$node[2]["pathCost"],"isEntity"=>$node[2]["isEntity"],"LearnTime"=>(int)$node[2]["LearnTime"],"MapURL"=>$node[2]["mapURL"],"MaterialUrl"=>$node[2]["materialUrl"]);
			
			if(isset($info_1) && isset($info_2) && isset($info_3))
				$content = array("first"=>$info_1,"second"=>$info_2,"third"=>$info_3);
			else if(isset($info_1) && isset($info_2))
				$content = array("first"=>$info_1,"second"=>$info_2);
			else if(isset($info_1))
				$content = array("first"=>$info_1);
			
			if(isset($content["first"])) {
				$recommand = array("currentNode"=>(int)$node[0]["Ti"],"nextNode"=>$content);
			}
			else {
				$recommand = array("currentNode"=>(int)$point_number,"nextNode"=>null);
			}
			return $recommand;
		}
		
		/**
		 * computeNormalizationParam
		 *
		 * 計算正規化參數
		 *
		 * @param $userID 使用者編號
		 * @return $normal double 正規化參數
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
		* @param $next_point_number 學習點的編號
		* @param $userID 學習者的帳號
		* @return $node array 取得學習點之所有參數
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
		 * @param $userID 使用者編號
		 * @param $point_number 學習點的編號
		 * @return $row array 學習狀態資訊
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
		 * @param $userID 使用者編號
		 * @param $point 學習點編號
		 * @return Boolean (true/flase)
		 */
		private function checkFinish($userID,$point)
		{
			$result = $this->conDB->prepare("SELECT ".$this->conDB->table("study").".TID FROM ".$this->conDB->table("study")." WHERE UID = :uid AND TID = :point");
			$result->bindParam(":uid",$userID);
			$result->bindParam(":point",$point);
			$result->execute();
			$row = $result->fetch(PDO::FETCH_ASSOC);
			if($point == $row["TID"]) return true;
			else return false;
		}
		
		/**
		 * turnToRealPointNumber
		 *
		 * 將標的編號轉換成實際的學習點編號
		 *
		 * @access private
		 * @param $point_number 標的編號
		 * @return int 實際的學習點編號
		 */
		private function turnToRealPointNumber($point_number)
		{
			return ($point_number % 15) + 1;
		}
}
?>