<?php
  require_once(DOCUMENT_ROOT."lib/include.php");
  require_once(DOCUMENT_ROOT."lib/RecommandLearnNode.php");
  
  $num = _POST[""];
  $add = new RecommandLearnNode();
  $add->addPeople($num);
?>