<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $brt = trim(mysqli_real_escape_string($db, $_POST["brt"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));

    $set = getSett();

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($pro,"") == 0 || strcasecmp($brt,"") == 0)
        $err = -1;
    else if(countProID($pro) == 0)
        $err = -2;
    else
    {
        $id = getMPIDTgl($tgl);
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');
        $cek = true;
        if(countMPTgl($tgl) == 0)
        {
            $cek = false;
            $aw = "TMP/";
            $ak = date('/my');

            $id = $aw.setID((int)substr(getLastIDMP($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            newMP($id, $tgl, $user, $wkt, $set[3][3]);
        }

        $aw = "HMP/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHIDMP($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        $data = getMPID($id);
        $data2 = getMPItem($id);
        $urut = getLastUrutMP($id) + 1;
        
        if(!$cek)
            newHMP($hid, "", "", "", "", $id, $tgl, $user, $wkt, date('Y-m-d H:i:s'), $user, "NEW", "", $set[3][3]);
        else
            $hid = getMPHIDTgl($tgl);

        newDtlMP($id, $pro, $brt, $urut, $ket);
        newHDtlMP($hid, $id, $pro, $brt, $urut, $ket, "A");

        updQtyProMP();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>