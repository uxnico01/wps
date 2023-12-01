<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $set = getSett();

    $err = 0;
    $wkt = date('Y-m-d H:i:s');
    $user = $_SESSION["user-kuma-wps"];
    
    $data = getRPkgID($id, $db);
    $data2 = getRPkgItem($id, $db);
    
    $haw = "HRPKG/";
    $hak = date('/my');
    $hid = $haw.setID((int)substr(getLastHRPkgID($haw, $hak, $db), strlen($haw), 4) + 1, 4).$hak;
    
    newHRPkg($hid, $data[0], $data[1], $data[2], $data[3], $data[4], $data[7], $data[8], "", "", "", "", "", "", "", $data[13], "", $user, $wkt, "EDIT", $db);

    for($i = 0; $i < count($data2); $i++){
        newDtlHRPkg($hid, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], "B", $db);
    }

    delRPkg($id, $db);

    updQtyProRPkg($db);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>