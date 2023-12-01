<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getMoveID($id, $db);
    $dtl = getMoveItem($id, $db);

    $err = 0;
    delMove($id, $db);
    
    $aw = "HMV/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastHMoveID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

    newHMove($hid, $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], "", "", "", "", "", "", "", "", $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "NEW", $data[14], "", $db);

    for($i = 0; $i < count($dtl); $i++){
        newDtlHMove($hid, $dtl[$i][0], $dtl[$i][1], $dtl[$i][2], $dtl[$i][4], $dtl[$i][3], $dtl[$i][9], $dtl[$i][10], $dtl[$i][11], "B", $db);
    }

    updQtyProMove($db);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>