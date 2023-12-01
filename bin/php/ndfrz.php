<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $trm = trim(mysqli_real_escape_string($db, $_POST["trm"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));

    $rtrm = explode("|", $trm);
    $set = getSett();

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($pro,"") == 0 || strcasecmp($trm,"") == 0)
        $err = -1;
    else if(countProID($pro) == 0)
        $err = -2;
    else
    {
        $id = getFrzIDTgl($tgl);
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');
        $cek = true;
        if(countFrzTgl($tgl) == 0)
        {
            $cek = false;
            $aw = "TFRZ/";
            $ak = date('/my');

            $id = $aw.setID((int)substr(getLastIDFrz($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            newFrz($id, $tgl, $user, $wkt, $set[3][3]);
        }

        $aw = "HFRZ/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHIDFrz($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        $data = getFrzID($id);
        $data2 = getFrzItem($id);
        $urut = getLastUrutFrz($id) + 1;
        
        if(!$cek)
            newHFrz($hid, "", "", "", "", $id, $tgl, $user, $wkt, date('Y-m-d H:i:s'), $user, "NEW", "", $set[3][3]);
        else
            $hid = getFrzHIDTgl($tgl);

        newDtlFrz($id, $rtrm[3], $rtrm[1], $rtrm[0], $rtrm[2], $urut, $ket, $pro);
        newHDtlFrz($hid, $id, $rtrm[3], $rtrm[1], $rtrm[0], $rtrm[2], $urut, $ket, $pro, "A");

        updQtyProFrz();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>