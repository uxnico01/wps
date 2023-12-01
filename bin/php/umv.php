<?php
    require("./clsfunction.php");

    $db = openDB();

    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $gdgf = trim(mysqli_real_escape_string($db, $_POST["gdgf"]));
    $gdgt = trim(mysqli_real_escape_string($db, $_POST["gdgt"]));
    $tipe = trim(mysqli_real_escape_string($db, $_POST["tipe"]));
    $ntt = trim(mysqli_real_escape_string($db, $_POST["ntt"]));
    $kpd = trim(mysqli_real_escape_string($db, $_POST["kpd"]));
    $lpro = json_decode($_POST["lpro"]);

    $err = 0;
        
    $data = getMoveID($bid, $db);
    $dtl = getMoveItem($bid, $db);

    $err2 = array();
    $err3 = array();
    $qty = array();
    $lpro2 = array();
    $n = 0;
    for($i = 0; $i < count($lpro); $i++){
        $cek = false;
        for($j = 0; $j < count($lpro2); $j++){
            if(strcasecmp($lpro[$i][0], $lpro2[$j][0]) == 0){
                $lpro2[$j][1] += $lpro[$i][1];
                $cek = true;
                break;
            }
        }

        if(!$cek){
            $qty[$n] = getQGdgPro($gdgf, $lpro[$i][0], $db);

            if(strcasecmp($gdgf, $data[1]) == 0){
                for($j = 0; $j < count($dtl); $j++){
                    if(strcasecmp($lpro[$i][0], $dtl[$j][1]) == 0){
                        $qty[$n] += $dtl[$j][2];
                    }
                }
            }

            $lpro2[count($lpro2)] = $lpro[$i];
            $n++;
        }
    }
    // QTY
    $cekqty = false;
    for($i = 0; $i < count($lpro2); $i++){
        $lpro2[$i][1] = number_format($lpro2[$i][1],2,'.','');
        $qty[$i] = number_format($qty[$i],2,'.','');
        
        if($lpro2[$i][1] > $qty[$i]){
            $cekqty = true;

            for($j = 0; $j < count($lpro); $j++){
                if(strcasecmp($lpro2[$i][0], $lpro[$j][0]) == 0)
                    $err2[count($err2)] = $lpro[$j][6];
            }
        }

        $qty[$i] -= $lpro2[$i][1];
    }
    // Weight
    for($i = 0; $i < count($lpro2); $i++){
        $lpro2[$i][3] = number_format($lpro2[$i][3],2,'.','');
        $qty[$i] = number_format($qty[$i],2,'.','');
        
        if($lpro2[$i][3] > $qty[$i]){
            $cek = true;

            for($j = 0; $j < count($lpro); $j++){
                if(strcasecmp($lpro2[$i][0], $lpro[$j][0]) == 0)
                    $err3[count($err3)] = $lpro[$j][6];
            }
        }

        $qty[$i] -= $lpro2[$i][3];
    }
    
    if(strcasecmp($tgl,"") == 0 || strcasecmp($gdgf,"") == 0 || strcasecmp($gdgt,"") == 0 || strcasecmp($tipe,"") == 0 || strcasecmp($kpd,"") == 0)
        $err = -1;
    else if(countGdgID($gdgf, $db) == 0)
        $err = -3;
    else if(countGdgID($gdgt, $db) == 0)
        $err = -4;
    else if(count($lpro) == 0)
        $err = -5;
    else if(countMoveID($bid, $db) == 0)
        $err = -6;
    else if(strcasecmp($gdgf, $gdgt) == 0)
        $err = -7;
    else if(count($err2) > 0)
        $err = -8;
    else if(count($err3) > 0)
        $err = -9;
    else
    {
        $wkt = date('Y-m-d H:i:s');
        $user = $_SESSION["user-kuma-wps"];

        $aw = "HMV/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHMoveID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

        newHMove($hid, $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $bid, $gdgf, $gdgt, $tgl, $tipe, $ket, $wkt, $user, $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "EDIT", $data[14], $kpd, $db);

        for($i = 0; $i < count($dtl); $i++){
            newDtlHMove($hid, $dtl[$i][0], $dtl[$i][1], $dtl[$i][2], $dtl[$i][4], $dtl[$i][3], $dtl[$i][9], $dtl[$i][10], $dtl[$i][11], "B", $db);
        }
        
        updMove($bid, $gdgf, $gdgt, $tgl, $tipe, $ket, $ntt, $kpd, $db);
        delAllDtlMove($bid, $db);
        for($i = 0; $i < count($lpro); $i++){
            if(countProID($lpro[$i][0]) > 0){
                newDtlMove($bid, $lpro[$i][0], $lpro[$i][1], $i, $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], $db);
                newDtlHMove($hid, $bid, $lpro[$i][0], $lpro[$i][1], $i, $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], "A", $db);
            }
        }

        updQtyProMove($db);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'err2' => $err2, 'err3' => $err3));
?>