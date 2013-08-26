<?php
    require_once(DOCUMENT_ROOT."lib/include.php");
    require_once(DOCUMENT_ROOT."/lib/RecommandLearnNode.php");
    
    $subpeople = new RecommandLearnNode();
    $num = $_POST[""];
    $subpeople->subPeople($num);
?>