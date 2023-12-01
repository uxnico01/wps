<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $jlh = trim(mysqli_real_escape_string($db, $_POST["jlh"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $type = trim(mysqli_real_escape_string($db, $_POST["type"]));

    $err = 0;

    if(strcasecmp($type,"") == 0 || strcasecmp($tgl,"") == 0 || strcasecmp($jlh,"") == 0 || $jlh <= 0)
        $err = -1;
    else
    {
        $wkt = date('Y-m-d H:i:s');
        $user = $_SESSION["user-kuma-wps"];

        $aw = "TB/";
        $ak = date('/my');
        $id = $aw.setID((int)substr(getLastIDBB($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newBB($id, $tgl, $jlh, $ket, $type, $user, $wkt);

        $aw = "HBB/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHBB($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHBB($hid, "", "", "", "", "", "", "", $id, $tgl, $jlh, $ket, $type, $user, $wkt, $_SESSION["user-kuma-wps"], "NEW", date('Y-m-d H:i:s'));
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'id' => array($id)));
?>