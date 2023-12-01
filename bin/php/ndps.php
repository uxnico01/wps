<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $brt = trim(mysqli_real_escape_string($db, $_POST["brt"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $ket2 = trim(mysqli_real_escape_string($db, $_POST["ket2"]));

    $set = getSett();

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($pro,"") == 0 || strcasecmp($brt,"") == 0)
        $err = -1;
    else if(countProID($pro) == 0)
        $err = -2;
    else
    {
        $id = getPsIDTgl($tgl);
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');
        $cek = true;
        if(countPsTgl($tgl) == 0)
        {
            $cek = false;
            $aw = "TPS/";
            $ak = date('/my');

            $id = $aw.setID((int)substr(getLastIDPs($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            newPs($id, $tgl, $ket, $user, $wkt, $set[3][3]);
        }

        $aw = "HPS/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHIDPs($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        $data = getPsID($id);
        $data2 = getPsItem($id);
        $urut = getLastUrutPs($id) + 1;
        
        if(!$cek)
            newHPs($hid, "", "", "", "", "", $id, $tgl, $ket, $user, $wkt, date('Y-m-d H:i:s'), $user, "NEW", "", $set[3][3]);
        else
            $hid = getPsHIDTgl($tgl);

        newDtlPs($id, $pro, $brt, $urut, $ket2);
        newHDtlPs($hid, $id, $pro, $brt, $urut, $ket2, "A");

        updQtyProPs();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>