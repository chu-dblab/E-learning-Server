<?php
     require_once("../lib/include.php");
     require_once(DOCUMENT_ROOT."lib/api/v1/apiTemplate.php");
     require_once(DOCUMENT_ROOT."lib/class/RecommandLearnNode.php");
     
     $action = (empty($_REQUEST["op"])) ? null : $_REQUEST["op"];
     $num = (empty($_REQUEST["amount"])) ? null : $_REQUEST["amount"];
     $Data = (empty($_REQUEST["data"])) ? null : $_REQUEST["data"];
     $point = (empty($_REQUEST["point"])) ? null : $_REQUEST["point"];
     $ID = (empty($_REQUEST["uid"])) ? null : $_REQUEST["uid"];
     $learn = new RecommandLearnNode();
     
     $message = array();
     
    // if(isset($action) && isset($num))
     
     switch($action)
     {
	case "addPeople":
	    $learn->addPeople($num);
	    $message += array("status"=>"OK");
	    break;
	case "subPeople":
	    $learn->subPeople($num);
	     $message += array("status"=>"OK");
	    break;
	case "upgrade":
	     $learn->updateUserLearnData($Data);
	     $message += array("status"=>"OK");
	    break;
	case "recommand" :
	      $learn->getLearningNode($point,$ID);
	      $message += array("status"=>"OK");
	    break;
	default:
	      $message += array("status"=>"ERROR!!");
     }
     
     apitemplate_header();
     echo json_encode($message);
     
?>