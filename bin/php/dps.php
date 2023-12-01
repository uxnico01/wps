<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $user = $_SESSION["user-kuma-wps"];

    $err = 0;
    
    $data = getPsID($id);
    $data2 = getPsItem($id);

    $aw = "HPS/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastHIDPs($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

    newHPs($hid, $id, $data[1], $data[2], $data[3], $data[4], "", "", "", "", "", date('Y-m-d H:i:s'), $user, "DELETE", $data[7], "");

    for($i = 0; $i < count($data2); $i++){
        newHDtlPs($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B", $data2[$i][4]);
    }
    
    delPS($id);

    updQtyProPs();

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>