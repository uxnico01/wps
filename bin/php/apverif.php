<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $user = $_SESSION["user-kuma-wps"];

    setStatPVerif($id, "V", $user, "", $db);

    $pverif = getPVerifID($id, $db);

    $set = getSett();
    $id = getPsIDTgl($pverif[1]);
    $wkt = date('Y-m-d H:i:s');
    $cek = true;
    if(countPsTgl($pverif[1]) == 0)
    {
        $cek = false;
        $aw = "TPS/";
        $ak = date('/my');

        $id = $aw.setID((int)substr(getLastIDPs($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newPs($id, $pverif[1], "Penyesuaian", $user, $wkt, $set[3][3]);
    }

    $aw = "HPS/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastHIDPs($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

    $urut = getLastUrutPs($id) + 1;
    
    if(!$cek)
        newHPs($hid, "", "", "", "", "", $id, $pverif[1], "Penyesuaian", $user, $wkt, date('Y-m-d H:i:s'), $user, "NEW", "", $set[3][3]);
    else
        $hid = getPsHIDTgl($pverif[1]);

    newDtlPs($id, $pverif[2], $pverif[5], $urut, "Penyesuaian ".$pverif[12]);
    newHDtlPs($hid, $id, $pverif[2], $pverif[5], $urut, "Penyesuaian ".$pverif[12], "A");

    updQtyProPs();

    closeDB($db);

    echo json_encode(array('err' => array(1)));
?>