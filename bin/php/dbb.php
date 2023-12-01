<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getBBID($id);
    $err = 0;
        
    delBB($id);
    
    $aw = "HBB/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastIDHBB($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

    newHBB($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], "", "", "", "", "",  "", "", $_SESSION["user-kuma-wps"], "DELETE", date('Y-m-d H:i:s'));

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>