<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    
    $data = getMPID($id);
    $data2 = getMPItem($id);

    $user = $_SESSION["user-kuma-wps"];

    $err = 0;

    $aw = "HMP/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastHIDMP($aw, $ak), strlen($aw), 4) + 1, 4).$ak;
    
    newHMP($hid, $id, $data[1], $data[2], $data[3], "", "", "", "", date('Y-m-d H:i:s'), $user, "DELETE", $data[6],"");

    for($i = 0; $i < count($data2); $i++)
        newHDtlMP($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], "B");

    delMP($id);

    updQtyProMP();

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>