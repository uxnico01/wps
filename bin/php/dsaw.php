<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;
    $user = $_SESSION["user-kuma-wps"];

    $data = getSawID($id);
    $data2 = getSawItem($id);

    $aw = "HSAW/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastIDHSaw($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

    newHstSaw($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], "", "", "", "", "", "", "", "", $user, date('Y-m-d H:i:s'), "DELETE", $data[10], "", $data[11], "", $data[12], "");

    for($i = 0; $i < count($data2); $i++)
    {
        newHstDtlSaw($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B");
    }

    delSaw($id);

    updQtyProSaw();

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>