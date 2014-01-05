<?php
     require_once("../../../lib/include.php");
     require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
     require_once(DOCUMENT_ROOT."lib/class/RecommandLearnNode.php");
//======================================================================================================//   
     $action = (empty($_REQUEST["op"])) ? null : $_REQUEST["op"];
     $num = (empty($_POST["amount"])) ? null : $_POST["amount"];
     $Data = (empty($_POST["data"])) ? null : $_POST["data"];
     $point = (empty($_POST["point"])) ? null : $_POST["point"];
     $ID = (empty($_POST["uid"])) ? null : $_POST["uid"];
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
			if(isset($point) && isset($ID))
			{
				$data = $learn->getLearningNode($point,$ID);
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
		default:
			$message += array("status"=>"Internal Error!!");
     }
//=============================================================================================//    
     apitemplate_header();
     echo json_encode($message);     
?>