<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $margin = trim(mysqli_real_escape_string($db, $_POST["margin"]));
    $tmargin = trim(mysqli_real_escape_string($db, $_POST["tmargin"]));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));
    $user = $_SESSION["user-kuma-wps"];

    $lpro = json_decode($_POST["lpro"]);
    $lcpro = json_decode($_POST["lcpro"]);
    $lcnpro = json_decode($_POST["lcnpro"]);

    $sbb = 0;
    $scut = 0;
    $scpro = 0;
    $scnpro = 0;
    for($i = 0; $i < count($lpro); $i++){
        for($j = 0; $j < count($lpro[$i]); $j++){
            $lpro[$i][$j] = trim(mysqli_real_escape_string($db, $lpro[$i][$j]));
        }

        $sbb += $lpro[$i][11];
        $scut += $lpro[$i][2]+$lpro[$i][3]+$lpro[$i][4]+$lpro[$i][5];
    }

    for($i = 0; $i < count($lcpro); $i++){
        for($j = 0; $j < count($lcpro[$i]); $j++){
            $lcpro[$i][$j] = trim(mysqli_real_escape_string($db, $lcpro[$i][$j]));
        }

        $scpro += $lcpro[$i][1];
    }

    for($i = 0; $i < count($lcnpro); $i++){
        for($j = 0; $j < count($lcnpro[$i]); $j++){
            $lcnpro[$i][$j] = trim(mysqli_real_escape_string($db, $lcnpro[$i][$j]));
        }

        $scnpro += $lcnpro[$i][1];
    }
    
    $slsh = number_format($sbb-$scut-$scpro-$scnpro, 2, '.', '');
    
    $err = 0;
    if(strcasecmp($tgl, "") == 0 || strcasecmp($margin,"") == 0 || strcasecmp($gdg,"") == 0)
        $err = -1;
    else if(count($lpro) == 0)
        $err = -2;
    else if(countCutID($id) == 0)
        $err = -3;
    else if(countGdgID($gdg, $db) == 0)
        $err = -4;
    else if($slsh < 0){
        $err = -5;
    }
    else
    {
        $data = getCutID($id);
        $data2 = getCutItem($id);
        $data3 = getCutPro($id, $db);
        $data4 = getCutNPro($id, $db);

        $aw = "HCUT/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHCut($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHstCut($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[7], $id, $tgl, $margin, $user, $data[4], $tmargin, $user, date('Y-m-d H:i:s'), "EDIT", $data[8], $gdg);

        for($i = 0; $i < count($data2); $i++){
            newHstDtlCut($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], $data2[$i][8], $data2[$i][9], $data2[$i][10], $data2[$i][11], "B", $data2[$i][16], $data2[$i][17], $data2[$i][18], $data2[$i][19], $data2[$i][20], $data2[$i][21], $data2[$i][22], $data2[$i][23], $data2[$i][24], $data2[$i][25], $data2[$i][26], $data2[$i][27], $data2[$i][28], $data2[$i][29], $data2[$i][37], $data2[$i][38]);
        }
                    
        for($i = 0; $i < count($data3); $i++){
            newHstHCutPro($hid, $id, $data3[$i][1], $data3[$i][2], $i, "B", $db);
        }
        
        for($i = 0; $i < count($data4); $i++){
            newHstHCutNPro($hid, $id, $data4[$i][1], $data4[$i][2], $i, "B", $db);
        }

        delAllDtlCut($id);
        delAllDtlHCutPro($id);
        delAllDtlHCutNPro($id);

        updCut($id, $tgl, $margin, $user, $data[4], $tmargin, $id, $gdg);

        for($i = 0; $i < count($lpro); $i++){
            newDtlCut($lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], $lpro[$i][6], $lpro[$i][7], $lpro[$i][8], $lpro[$i][9], $lpro[$i][10], $lpro[$i][11], $lpro[$i][12], $lpro[$i][13], $lpro[$i][14], $lpro[$i][15], $lpro[$i][16], $lpro[$i][17], $lpro[$i][18], $lpro[$i][19], $lpro[$i][20], $lpro[$i][21], $lpro[$i][22], $lpro[$i][23], $lpro[$i][24], $lpro[$i][25], $lpro[$i][26], $lpro[$i][27]);

            newHstDtlCut($hid, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5], $lpro[$i][6], $lpro[$i][7], $lpro[$i][8], $lpro[$i][9], $lpro[$i][10], $lpro[$i][11], "A", $lpro[$i][12], $lpro[$i][13], $lpro[$i][14], $lpro[$i][15], $lpro[$i][16], $lpro[$i][17], $lpro[$i][18], $lpro[$i][19], $lpro[$i][20], $lpro[$i][21], $lpro[$i][22], $lpro[$i][23], $lpro[$i][24], $lpro[$i][25], $lpro[$i][26], $lpro[$i][27]);
        }

        for($i = 0; $i < count($lcpro); $i++){
            $urut = getLastUrutHCutPro($id, $db) + 1;
            newHCutPro($id, $lcpro[$i][0], $lcpro[$i][1], $i, $db);
            newHstHCutPro($hid, $id, $lcpro[$i][0], $lcpro[$i][1], $i, "A", $db);
        }

        for($i = 0; $i < count($lcnpro); $i++){
            $urut = getLastUrutHCutPro($id, $db) + 1;
            newHCutNPro($id, $lcnpro[$i][0], $lcnpro[$i][1], $i, $db);
            newHstHCutNPro($hid, $id, $lcnpro[$i][0], $lcnpro[$i][1], $i, "A", $db);
        }

        updQtyProCut();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>