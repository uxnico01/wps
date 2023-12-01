<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $ket1 = trim(mysqli_real_escape_string($db, $_POST["ket1"]));
    $ket2 = trim(mysqli_real_escape_string($db, $_POST["ket2"]));
    $ket3 = trim(mysqli_real_escape_string($db, $_POST["ket3"]));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));

    $lpro = json_decode($_POST["lpro"]);

    $data = getKirimID($bid);
    $data2 = getKirimItem($bid);

    $err = 0;
    $err2 = array();
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
            $qty[$n] = getQGdgPro($gdg, $lpro[$i][0], $db);

            if(strcasecmp($gdg, $data[9]) == 0){
                for($j = 0; $j < count($data2); $j++){
                    if(strcasecmp($lpro[$i][0], $data2[$j][1]) == 0){
                        $qty[$n] += $data2[$j][2];
                    }
                }
            }

            $lpro2[count($lpro2)] = $lpro[$i];
            $n++;
        }
    }
    for($i = 0; $i < count($lpro2); $i++){
        if($lpro2[$i][1] > $qty[$i]){
            $cek = true;

            for($j = 0; $j < count($lpro); $j++){
                if(strcasecmp($lpro2[$i][0], $lpro[$j][0]) == 0)
                    $err2[count($err2)] = $lpro[$j][7];
            }
        }

        $qty[$i] -= $lpro2[$i][1];
    }

    if(strcasecmp($id,"") == 0 || strcasecmp($tgl,"") == 0 || strcasecmp($gdg,"") == 0)
        $err = -1;
    /*else if(countKirimID($id) > 0 && strcasecmp($bid, $id) != 0)
        $err = -2;
    else if(countCusID($cus) == 0)
        $err = -3;*/
    else if(count($lpro) == 0)
        $err = -4;
    else if(countKirimID($bid) == 0)
        $err = -5;
    else if(countGdgID($gdg, $db) == 0)
        $err = -6;
    else if(count($err2) > 0)
        $err = -7;
    else
    {
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');

        updKirim($id, $tgl, $ket1, $ket2, $ket3, $user, $data[6], $bid, $gdg);

        $aw = "HKRM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHKirim($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHstKirim($hid, $bid, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $id, $tgl, $ket1, $ket2, $ket3, $user, $data[6], $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "EDIT", $data[9], $gdg);

        for($i = 0; $i < count($data2); $i++)
            newHstDtlKirim($hid, $bid, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B", $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], $data2[$i][8]);

        delAllDtlKirim($bid);

        for($i = 0; $i < count($lpro); $i++)
        {
            if(countProID($lpro[$i][0]) == 0 || $lpro[$i][2] == 0 || countPOID($lpro[$i][3]) == 0)
                continue;

            newDtlKirim($id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], $lpro[$i][6], $lpro[$i][8]);
            newHstDtlKirim($hid, $id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], "A", $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], $lpro[$i][6], $lpro[$i][8]);
        }

        for($i = 0; $i < count($lpro); $i++)
        {
            if($lpro[$i][2] != 0 || countProID($lpro[$i][0]) == 0 || countPOID($lpro[$i][3]) == 0)
                continue;
            else
                $lpro[$i][2] = getLastUrutKirim($id) + 1;

            $lpro[$i][8] = strtoupper($lpro[$i][8]);

            newDtlKirim($id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], $lpro[$i][6], $lpro[$i][8]);
            newHstDtlKirim($hid, $id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], "A", $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], $lpro[$i][6], $lpro[$i][8]);
        }

        updQtyProKirim();
    }
    
    closeDB($db);

    echo json_encode(array('err' => array($err), 'err2' => $err2));
?>