<?php
     require_once("../lib/include.php");
     require_once(DOCUMENT_ROOT."lib/class/RecommandLearnNode.php");
     
     $action = (empty($_REQUEST["op"])) ? null : $_REQUEST["op"];
     $num = (empty($_REQUEST["amount"])) ? null : $_REQUEST["amount"];
     $Data = (empty($_REQUEST["data"])) ? null : $_REQUEST["data"];
     $add = new RecommandLearnNode();
     
     switch($action)
     {
	case "addPeople":
	    $add->addPeople($num);
	    break;
	case "subPeople":
	    $subpeople->subPeople($num);
	    break;
	case "upgrade":
	     $update->updateUserLearnData($Data);
	    break;	   
     }
     
?>