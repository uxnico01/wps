<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $po = trim(mysqli_real_escape_string($db, $_POST["po"]));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $brt = trim(mysqli_real_escape_string($db, $_POST["brt"]));
    $qty = trim(mysqli_real_escape_string($db, $_POST["qty"]));
    $sat = trim(mysqli_real_escape_string($db, $_POST["sat"]));
    $tglexp = trim(mysqli_real_escape_string($db, $_POST["tglexp"]));
    $ket = strtoupper(trim(mysqli_real_escape_string($db, $_POST["ket"])));

    $set = getSett();
    $dpro = getQGdgPro($set[3][3], $pro, $db);

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($po,"") == 0 || strcasecmp($pro,"") == 0 || strcasecmp($brt,"") == 0 || strcasecmp($qty,"") == 0 || strcasecmp($sat,"") == 0 || strcasecmp($tglexp,"") == 0)
        $err = -1;
    else if(countPOID($po) == 0)
        $err = -2;
    else if(countProID($pro) == 0)
        $err = -3;
    else if($dpro < $brt)
        $err = -4;
    else
    {
        $id = getKirimIDTgl($tgl);
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');
        $cek = true;
        if(countKirimTgl($tgl) == 0)
        {
            $cek = false;
            $aw = "TP/";
            $ak = date('/my');

            $id = $aw.setID((int)substr(getLastIDKirim($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            newKirim($id, $tgl, "", "", "", $user, $wkt, $set[3][3]);
        }

        $aw = "HKRM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHKirim($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        $data = getKirimID($id);
        $data2 = getKirimItem($id);
        $urut = getLastUrutKirim($id) + 1;
        
        if(!$cek)
            newHstKirim($hid, "", "", "", "", "", "", "", $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $user, date('Y-m-d H:i:s'), "NEW", "", $set[3][3]);
        /*else
            newHstKirim($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $user, date('Y-m-d H:i:s'), "NEW");

        for($i = 0; $i < count($data2); $i++)
        {
            newHstDtlKirim($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B", $data2[$i][4]);

            newHstDtlKirim($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "A", $data2[$i][4]);
        }*/

        newDtlKirim($id, $pro, $brt, $urut, $po, $qty, $sat, $tglexp, $ket);
        
        if(!$cek)
            newHstDtlKirim($hid, $id, $pro, $brt, $urut, "A", $po, $qty, $sat, $tglexp, $ket);

        updQtyProKirim();
    }

    closeDB($db);
    
    echo json_encode(array('err' => array($err)));
?>