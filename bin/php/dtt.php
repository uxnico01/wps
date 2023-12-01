<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;
    
    $data = getTTID($id);
    $data2 = getTTItem($id);

    $aw = "HTT/";
    $ak = date('/my');
    $hid = $aw.setID(substr(getLastIDHTT($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

    newHTT($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10], "", "", "", "", "", "", "", "", "", "", "", $_SESSION["user-kuma-wps"], "DELETE", date('Y-m-d H:i:s'));

    for($i = 0; $i < count($data2); $i++)
        newHDtlTT($hid, $id, $data2[$i][1], $data2[$i][3], $data2[$i][5], $data2[$i][6], $data2[$i][4], "B", $data2[$i][2]);

    delTT($id);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>