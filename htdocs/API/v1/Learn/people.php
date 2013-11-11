<?php
     require_once("../lib/include.php");
     require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
     require_once(DOCUMENT_ROOT."lib/class/RecommandLearnNode.php");
     
     $action = (empty($_REQUEST["op"])) ? null : $_REQUEST["op"];
     $num = (empty($_POST["amount"])) ? null : $_POST["amount"];
     $Data = (empty($_POST["data"])) ? null : $_POST["data"];
     $point = (empty($_REQUEST["point"])) ? null : $_REQUEST["point"];
     $ID = (empty($_REQUEST["uid"])) ? null : $_REQUEST["uid"];
     $learn = new RecommandLearnNode();
     
     $message = array();
     
     switch($action)
     {
	case "addPeople":
	    if(!isset($num)) $message += array("status"=>"CommandError");
	    else
	    {
			$learn->addPeople($num);
			$message += array("status_ok"=>True);
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
	case "upgrade":
	     if(!isset($Data)) array("status_ok"=>false,"status"=>"CommandError");
	     else 
	     {
			$learn->updateUserLearnData($Data);
			$message += array("status_ok"=>True);
	     }
	     break;
	case "recommand" :
	      if(isset($point) && isset($ID))
	      {
			$learn->getLearningNode($point,$ID);
			$message += array("status_ok"=>True);
	      }
	      else array("status_ok"=>false,"status"=>"CommandError");
	    break;
	default:
	      $message += array("status"=>"Internal Error!!");
     }
     
     apitemplate_header();
     echo json_encode($message);     
?>