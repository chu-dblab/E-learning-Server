<?php
     require_once("../../../lib/include.php");
     require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
     require_once(DOCUMENT_ROOT."lib/class/UpdateInfo.php");
//======================================================================================================//   
     $action = (empty($_REQUEST["op"])) ? null : $_REQUEST["op"];
     $Data = (empty($_POST["data"])) ? null : $_POST["data"];
     $point = (empty($_POST["point"])) ? null : $_POST["point"];
     $question = (empty($_POST["QID"])) ? null : $_POST["QID"];
     $ID = (empty($_POST["uid"])) ? null : $_POST["uid"];
     $inTime = (empty($_POST["inTime"])) ? null : $_POST["inTime"];
     $outTime = (empty($_POST["outTime"])) ? null : $_POST["outTime"];
//======================================================================================================//
     $renew = new UpdateInfo();
     
     $message = array();
//=====================================================================================================//
     switch($action)
     {
		case "upgrade":
			if(!isset($Data)) array("status_ok"=>false,"status"=>"CommandError");
			else 
			{
				$renew->updateUserLearnData($ID,(int)$point,$inTime,$outTime);
				$message += array("status_ok"=>True);
			}
			break;
		case "sendQuestionData":
			if(isset($point) && isset($question)&&isset($Data))
			{
				$renew->receiveQuestionData($question,$point);
				$renew->updateQestionStatus($question,$Data);
				$message += array("status_ok"=>True);
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