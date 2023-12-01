<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getRKirimID($id, $db);
    $dtl = getRKirimItem($id, $db);

    $err = 0;
    delRKirim($id, $db);
    
    $aw = "HRKRM/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastHRKirimID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

    newHRKirim($hid, $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], "", "", "", "", "", "", "", "", $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "DELETE", $db);

    for($i = 0; $i < count($dtl); $i++){
        newDtlHRKirim($hid, $dtl[$i][0], $dtl[$i][1], $dtl[$i][2], "B", $db);
    }

    updQtyProRKirim($db);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>