<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));
    $lpro = json_decode($_POST["lpro"]);

    $sum = 0;
    for($i = 0; $i < count($lpro); $i++){
        $lpro[$i][0] = trim(mysqli_real_escape_string($db, $lpro[$i][0]));
        $lpro[$i][1] = trim(mysqli_real_escape_string($db, $lpro[$i][1]));
        $sum += $lpro[$i][1];
    }

    $err = 0;
    if(strcasecmp($tgl,"") == 0){
        $err = -1;
    }
    else{
        if(countCutTgl($tgl) == 0){
            $err = -2;
        }
        else{
            $id = getCutIDTgl($tgl);

            if(getSumBBCutID($id, $db) < $sum){
                $err = -3;
            }
            else{
                $hid = getCutHIDTgl2($id, $db);

                if(strcasecmp($hid,"") == 0){
                    $data = getCutID($id);
                    $data2 = getCutItem($id);
                    $data3 = getCutPro($id, $db);
                    $data4 = getCutNPro($id, $db);
            
                    $aw = "HCUT/";
                    $ak = date('/my');
                    $hid = $aw.setID((int)substr(getLastIDHCut($aw, $ak), strlen($aw), 4) + 1, 4).$ak;
            
                    newHstCut($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[7], $id, $data[1], $data[2], $data[3], $data[4], $data[7], $user, date('Y-m-d H:i:s'), "EDIT", $data[8], $gdg);

                    for($i = 0; $i < count($data2); $i++){
                        newHstDtlCut($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], $data2[$i][8], $data2[$i][9], $data2[$i][10], $data2[$i][11], "B", $data2[$i][16], $data2[$i][17], $data2[$i][18], $data2[$i][19], $data2[$i][20], $data2[$i][21], $data2[$i][22], $data2[$i][23], $data2[$i][24], $data2[$i][25], $data2[$i][26], $data2[$i][27], $data2[$i][28], $data2[$i][29], $data2[$i][37], $data2[$i][38]);

                        newHstDtlCut($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], $data2[$i][8], $data2[$i][9], $data2[$i][10], $data2[$i][11], "A", $data2[$i][16], $data2[$i][17], $data2[$i][18], $data2[$i][19], $data2[$i][20], $data2[$i][21], $data2[$i][22], $data2[$i][23], $data2[$i][24], $data2[$i][25], $data2[$i][26], $data2[$i][27], $data2[$i][28], $data2[$i][29], $data2[$i][37], $data2[$i][38]);
                    }
                    
                    for($i = 0; $i < count($data3); $i++){
                        newHstHCutPro($hid, $data3[$i][0], $data3[$i][1], $data3[$i][2], $i, "B", $db);
                    }
                    
                    for($i = 0; $i < count($data4); $i++){
                        newHstHCutNPro($hid, $data4[$i][0], $data4[$i][1], $data4[$i][2], $i, "B", $db);
                    }
                }

                for($i = 0; $i < count($lpro); $i++){
                    $urut = getLastUrutHCutNPro($id, $db) + 1;
                    newHCutNPro($id, $lpro[$i][0], $lpro[$i][1], $urut, $db);
                    newHstHCutNPro($hid, $id, $lpro[$i][0], $lpro[$i][1], $urut, "A", $db);
                }
            }
        }
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>