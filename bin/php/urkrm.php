<?php
    require("./clsfunction.php");

    $db = openDB();

    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $po = trim(mysqli_real_escape_string($db, $_POST["po"]));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));
    $lpro = json_decode($_POST["lpro"]);
    
    $dpo = getPOID($po);
    $lpropo = getPOItem($po, $db);

    $err = 0;
    $err2 = array();
    $n = 0;
    for($i = 0; $i < count($lpro); $i++){
        if(strcasecmp($lpro[$i][0],"") == 0){
            continue;
        }
        
        for($j = 0; $j < count($lpropo); $j++){
            if(strcasecmp($lpro[$i][0], $lpropo[$j][0]) == 0){
                $lpro[$i][1] = number_format($lpro[$i][1],2,'.','');
                $lpropo[$j][8] = number_format($lpropo[$j][8],2,'.','');
                if($lpro[$i][1] > $lpropo[$j][8]){
                    array_push($err2, $i);
                    break;
                }
            }
        }
    }
    
    if(strcasecmp($tgl,"") == 0 || strcasecmp($po,"") == 0)
        $err = -1;
    else if(countPOID($po) == 0)
        $err = -2;
    else if(count($lpro) == 0)
        $err = -3;
    else if(count($err2) > 0)
        $err = -4;
    else if(countGdgID($gdg, $db) == 0)
        $err = -5;
    else
    {
        $wkt = date('Y-m-d H:i:s');
        $user = $_SESSION["user-kuma-wps"];

        $data = getRKirimID($bid, $db);
        $dtl = getRKirimItem($bid, $db);

        updRKirim($bid, $dpo[1], $po, $tgl, $ket, $user, $gdg, $db);

        $aw = "HRKRM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHRKirimID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

        newHRKirim($hid, $bid, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $bid, $dpo[1], $po, $tgl, $ket, $user, $wkt, $gdg, $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "EDIT", $db);

        for($i = 0; $i < count($dtl); $i++){
            newDtlHRKirim($hid, $dtl[$i][0], $dtl[$i][1], $dtl[$i][2], "B", $db);
        }

        delAllDtlRKirim($bid, $db);
        for($i = 0; $i < count($lpro); $i++){
            if(countProID($lpro[$i][0]) > 0){
                newDtlRKirim($bid, $lpro[$i][0], $lpro[$i][1], $db);
                newDtlHRKirim($hid, $bid, $lpro[$i][0], $lpro[$i][1], "A", $db);
            }
        }
        
        updQtyProRKirim($db);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'err2' => $err2, 'id' => array($bid)));
?>