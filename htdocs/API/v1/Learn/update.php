<?php
     require_once("../../../lib/include.php");
     require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
     require_once(DOCUMENT_ROOT."lib/class/UpdateInfo.php");
//======================================================================================================//   
     $action = ( isset($_REQUEST["op"]) ) ? $_REQUEST["op"] : null;
     $Data = ( isset($_POST["data"]) ) ? $_POST["data"] : null;
     $point = ( isset($_POST["point"]) ) ? $_POST["point"] : null;
     $question = ( isset($_POST["QID"]) ) ? $_POST["QID"] : null;
     $ID = ( isset($_POST["uid"]) ) ? $_POST["uid"] : null;
     $inTime = ( isset($_POST["inTime"]) ) ? $_POST["inTime"] : null;
     $outTime = ( isset($_POST["outTime"]) ) ? $_POST["outTime"] : null;
//======================================================================================================//
     $renew = new UpdateInfo();
     
     $message = array();
//=====================================================================================================//
     switch($action)
     {
		case "upgrade":
		
			if(isset($ID)&&isset($point)&&isset($inTime)&&isset($outTime))
			{
				$renew->updateUserLearnData($ID,(int)$point,$inTime,$outTime);
				$message += array("status_ok"=>True);
			}
			else array("status_ok"=>false,"status"=>"CommandError");
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