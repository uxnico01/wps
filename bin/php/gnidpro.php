<?php
    require("./clsfunction.php");

    $aw = "";
    $ak = "-WTNA";
    $nid = $aw.setID((int)substr(getLastProID($aw, $ak), strlen($aw), 6) + 1, 6).$ak;

    echo json_encode(array('nid' => array($nid)));
?>