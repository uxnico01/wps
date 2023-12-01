<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    
    $data = getVacID($id);
    $data2 = getVacItem($id);

    $user = $_SESSION["user-kuma-wps"];

    $err = 0;

    $aw = "HVAC/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastIDHVac($aw, $ak), strlen($aw), 4) + 1, 4).$ak;
    
    newHstVac($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], "", "", "", "", "", "", "", "", "", "", $user, date('Y-m-d H:i:s'), "DELETE", $data[12], "", $data[13], "", $data[14], "", $data[15], $data[16], "", "", $data[17], "");

    for($i = 0; $i < count($data2); $i++)
        newHstDtlVac($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B", $data2[$i][4]);

    delVac($id);

    updQtyProVac();

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>