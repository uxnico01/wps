<?php
    require("./clsfunction.php");

    $db = openDB();

    $aw = "G";
    $ak = "";
    $nid = $aw.setID((int)substr(getLastIDGol($aw, $ak, $db), strlen($aw), 3) + 1, 3).$ak;

    closeDB($db);

    echo json_encode(array('nid' => array($nid)));
?>