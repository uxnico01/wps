<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getWdID($id);

    $err = 0;
    
    delWd($id);
    
    $aw = "HWD/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastIDHWd($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

    newHWd($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[9], $data[10], "", "", "", "", "",  "", "", "", "", $_SESSION["user-kuma-wps"], "DELETE", date('Y-m-d H:i:s'));

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>