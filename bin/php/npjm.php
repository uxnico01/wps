<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $sup = trim(mysqli_real_escape_string($db, $_POST["sup"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $jlh = trim(mysqli_real_escape_string($db, $_POST["jlh"]));
    $ket1 = trim(mysqli_real_escape_string($db, $_POST["ket1"]));
    $ket2 = trim(mysqli_real_escape_string($db, $_POST["ket2"]));
    $ket3 = trim(mysqli_real_escape_string($db, $_POST["ket3"]));
    $pot = trim(mysqli_real_escape_string($db, $_POST["pot"]));

    $err = 0;

    if(strcasecmp($sup,"") == 0 || strcasecmp($tgl,"") == 0 || strcasecmp($jlh,"") == 0 || $jlh <= 0)
        $err = -1;
    else if(countPjmID($id) > 0)
        $err = -2;
    else if(countSupID($sup) == 0)
        $err = -3;
    else
    {
        $wkt = date('Y-m-d H:i:s');
        $user = $_SESSION["user-kuma-wps"];

        $aw = "TP/";
        $ak = date('/my');
        $id = $aw.setID((int)substr(getLastIDPjm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newPjm($id, $sup, $tgl, $jlh, $ket1, $ket2, $ket3, $user, $wkt, $pot);

        $aw = "HPJM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHPjm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHPjm($hid, "", "", "", "", "", "", "", "", "", "", $id, $sup, $tgl, $jlh, 0, $ket1, $ket2, $ket3, $user, $wkt, $_SESSION["user-kuma-wps"], "NEW", date('Y-m-d H:i:s'), "", $pot);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'id' => array($id)));
?>