<?php
  require_once("../lib/include.php");
  require_once(DOCUMENT_ROOT."lib/class/RecommandLearnNode.php");
  
  $num = $_POST["numberOfPeople"];
  $add = new RecommandLearnNode();
  $add->addPeople($num);
?>