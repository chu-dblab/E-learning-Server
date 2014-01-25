<?php
     require_once("../../../lib/include.php");
     require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
     require_once(DOCUMENT_ROOT."lib/class/RecommandLearnNode.php");
//======================================================================================================//   
     $action = ( isset($_REQUEST["op"]) ) ? $_REQUEST["op"] : null;
     $num = ( isset($_POST["amount"]) ) ? $_POST["amount"] : null;
     $Data = ( isset($_POST["data"]) ) ? $_POST["data"] : null;
     $point = ( isset($_POST["point"]) ) ? $_POST["point"] : null;
     $ID = ( isset($_POST["uid"]) ) ? $_POST["uid"] : null;
     $time = ( isset($_POST["remainedTime"]) ) ? $_POST["remainedTime"] : null;
//======================================================================================================//
     $learn = new RecommandLearnNode();
     
     $message = array();
//=====================================================================================================//
     switch($action)
     {
		case "addPeople":
			if(!isset($num)) $message += array("status_ok"=>false,"status"=>"CommandError");
			else
			{
				$learn->addPeople($num);
				$message += array("status_ok"=>True,"status"=>"add people sccessed.");
			}
			break;
		case "subPeople":
			if(!isset($num)) $message += array("status_ok"=>false,"status"=>"CommandError");
			else 
			{
				$learn->subPeople($num);
				$message += array("status_ok"=>True);
			}
			break;
		case "recommand" :
			if(isset($point) && isset($ID) && isset($time))
			{
				$data = $learn->getLearningNode($point,$ID,$time);
				$message += array("status_ok"=>True);
				$message += $data;
			}
			else $message += array("status_ok"=>false,"status"=>"CommandError");
			break;
		case "getUserStatus":
			if(isset($ID)&&isset($point))
			{
				$data=$learn->getLearningStatus($ID,$point);
				$message += array("status_ok"=>True);
				$message += $data;
			}
			else $message += array("status_ok"=>false,"status"=>"CommandError");
			break;
		//方法獨立測試用
		case "test":
			if(isset($ID))
			{
				$data=$learn->computeNormalizationParam($ID);
				$message += array("status_ok"=>true,"data"=>$data);
			}
			else $message += array("status_ok"=>false,"status"=>"CommandError");
			break;
		default:
			$message += array("status"=>"Internal Error!!");
     }
//=============================================================================================//    
     apitemplate_header();
     echo json_encode($message);     
?>