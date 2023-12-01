<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;
    
    $data = getKirimID($id);
    $data2 = getKirimItem($id);

    $aw = "HKRM/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastIDHKirim($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

    newHstKirim($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], "", "", "", "", "", "", "", $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "DELETE", $data[9], "");

    for($i = 0; $i < count($data2); $i++)
        newHstDtlKirim($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B", $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], $data2[$i][8]);

    delKirim($id);

    updQtyProKirim();

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>