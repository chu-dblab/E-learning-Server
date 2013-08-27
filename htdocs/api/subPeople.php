<?php
    require_once(DOCUMENT_ROOT."lib/include.php");
    require_once(DOCUMENT_ROOT."/lib/class/RecommandLearnNode.php");
    
    $subpeople = new RecommandLearnNode();
    $num = $_POST["numberOfPeople"];
    $subpeople->subPeople($num);
?>

