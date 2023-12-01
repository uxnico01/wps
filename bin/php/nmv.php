<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $gdgf = trim(mysqli_real_escape_string($db, $_POST["gdgf"]));
    $gdgt = trim(mysqli_real_escape_string($db, $_POST["gdgt"]));
    $tipe = trim(mysqli_real_escape_string($db, $_POST["tipe"]));
    $kpd = trim(mysqli_real_escape_string($db, $_POST["kpd"]));
    $lpro = json_decode($_POST["lpro"]);

    $err = 0;
    $err2 = array();
    $lpro2 = array();
    $qty = array();
    $cek = false;
    $n = 0;
    for($i = 0; $i < count($lpro); $i++){
        if(strcasecmp($lpro[$i][0],"") == 0){
            continue;
        }

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
    $cek = false;
    for($i = 0; $i < count($lpro2); $i++){
        $lpro2[$i][1] = number_format($lpro2[$i][1],2,'.','');
        $qty[$i] = number_format($qty[$i],2,'.','');

        if((double)$lpro2[$i][1] > (double)$qty[$i]){
            $cek = true;

            for($j = 0; $j < count($lpro); $j++){
                if(strcasecmp($lpro2[$i][0], $lpro[$j][0]) == 0)
                    $err2[count($err2)] = $lpro[$j][6];
            }
        }
    }
    // WEIGHT
    $cekweight = false;
    for($i = 0; $i < count($lpro2); $i++){
        $lpro2[$i][3] = number_format($lpro2[$i][3],2,'.','');
        $qty[$i] = number_format($qty[$i],2,'.','');

        if((double)$lpro2[$i][3] > (double)$qty[$i]){
            $cekweight = true;

            for($j = 0; $j < count($lpro); $j++){
                if(strcasecmp($lpro2[$i][0], $lpro[$j][0]) == 0)
                    $err2[count($err2)] = $lpro[$j][6];
            }
        }
    }

    /*for($i = 0; $i < count($lpro); $i++){
        if($lpro[$i][1] > getQGdgPro($gdgf, $lpro[$i][0], $db)){
            $cek = true;
            $err2[count($err2)] = $lpro[$i][6];
        }
    }*/
    
    if(strcasecmp($tgl,"") == 0 || strcasecmp($gdgf,"") == 0 || strcasecmp($gdgt,"") == 0 || strcasecmp($tipe,"") == 0 || strcasecmp($kpd,"") == 0)
        $err = -1;
    else if(countGdgID($gdgf, $db) == 0)
        $err = -3;
    else if(countGdgID($gdgt, $db) == 0)
        $err = -4;
    else if(count($lpro) == 0)
        $err = -5;
    else if(strcasecmp($gdgf, $gdgt) == 0)
        $err = -6;
    else if($cek){
        $err = -7;
    }
    else if($cekweight){
        $err = -8;
    }
    else
    {
        $wkt = date('Y-m-d H:i:s');
        $user = $_SESSION["user-kuma-wps"];

        $aw = "MV/";
        $ak = date('/my');
        $id = $aw.setID((int)substr(getLastMoveID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

        newMove($id, $gdgf, $gdgt, $tgl, $tipe, $ket, $wkt, $user, $kpd, $db);

        $aw = "HMV/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHMoveID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

        newHMove($hid, "", "", "", "", "", "", "", "", $id, $gdgf, $gdgt, $tgl, $tipe, $ket, $wkt, $user, $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "NEW", "", $kpd, $db);

        for($i = 0; $i < count($lpro); $i++){
            if(countProID($lpro[$i][0]) > 0){
                newDtlMove($id, $lpro[$i][0], $lpro[$i][1], $i, $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], $db);
                newDtlHMove($hid, $id, $lpro[$i][0], $lpro[$i][1], $i, $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], "A", $db);
            }
        }
        
        updQtyProMove($db);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'err2' => $err2, 'id' => array($id)));
?>