<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $po = trim(mysqli_real_escape_string($db, $_POST["po"]));
    $lpro = json_decode($_POST["lpro"]);

    $lpropo = getPOItem($po, $db);
    $dpo = getPOID($po);
    
    $set = getSett();

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
    else
    {
        $wkt = date('Y-m-d H:i:s');
        $user = $_SESSION["user-kuma-wps"];

        $aw = "RKRM/";
        $ak = date('/my');
        $id = $aw.setID((int)substr(getLastRKirimID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

        newRKirim($id, $dpo[1], $po, $tgl, $ket, $user, $wkt, $set[3][3], $db);

        $aw = "HRKRM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHRKirimID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

        newHRKirim($hid, "", "", "", "", "", "", "", "", $id, $dpo[1], $po, $tgl, $ket, $user, $wkt, $set[3][3], $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "NEW", $db);

        for($i = 0; $i < count($lpro); $i++){
            if(countProID($lpro[$i][0]) > 0){
                newDtlRKirim($id, $lpro[$i][0], $lpro[$i][1], $db);
                newDtlHRKirim($hid, $id, $lpro[$i][0], $lpro[$i][1], "A", $db);
            }
        }
        
        updQtyProRKirim($db);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'err2' => $err2, 'id' => array($id)));
?>