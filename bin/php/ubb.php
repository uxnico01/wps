<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $jlh = trim(mysqli_real_escape_string($db, $_POST["jlh"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $type = trim(mysqli_real_escape_string($db, $_POST["type"]));

    $err = 0;

    if(strcasecmp($type,"") == 0 || strcasecmp($tgl,"") == 0 || strcasecmp($jlh,"") == 0 || $jlh <= 0)
        $err = -1;
    else if(countBBID($id) == 0)
        $err = -2;
    else
    {
        $data = getBBID($bid);

        $user = $_SESSION["user-kuma-wps"];

        updBB($id, $tgl, $jlh, $ket, $type, $user, $data[6], $bid);

        $aw = "HBB/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHBB($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHBB($hid, $bid, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $id, $tgl, $jlh, $ket, $type, $user, $data[6], $_SESSION["user-kuma-wps"], "EDIT", date('Y-m-d H:i:s'));
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>