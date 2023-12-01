<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($name,"") == 0)
        $err = -1;
    else if(countGolID($id, $db) > 0)
        $err = -2;
    else
        newGol($id, $name, $db);
        
    $aw = "G";
    $ak = "";
    $nid = $aw.setID((int)substr(getLastIDGol($aw, $ak, $db), strlen($aw), 3) + 1, 3).$ak;

    closeDB($db);

    echo json_encode(array('err' => array($err), 'nid' => array($nid)));
?>