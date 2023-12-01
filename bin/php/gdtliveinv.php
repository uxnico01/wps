<?php
    require("./clsfunction.php");

    $db = openDB();

    /*$set = getSett();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    
    $data = getProFrmTo($tgl, $tgl, "");
    for($i = 0; $i < count($data); $i++)
    {
        $cutpro = getSumCutFrmTo4($tgl, $tgl, $data[$i][0], "");
        $cutpro2 = getSumCutFrmTo5($tgl, $data[$i][0], "");
        $saldo = $data[$i][7]-$data[$i][10]-$data[$i][13]+$data[$i][16]-$data[$i][19]+$data[$i][22]-$data[$i][25]+$data[$i][28]+$data[$i][30]-$cutpro2+$data[$i][32]-$data[$i][35]+$data[$i][38]+$lst[$i][41];

        $qty = $saldo + $data[$i][6] - $data[$i][9] + $data[$i][27] - $data[$i][12] + $data[$i][15] - $data[$i][18] + $data[$i][21] - $data[$i][24] - $cutpro + $data[$i][31] - $data[$i][34] + $data[$i][37] + $lst[$i][40];

        $data[$i][31] = $saldo;
        $data[$i][32] = $qty;
    }

    closeDB($db);
    
    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'dte' => array(date('d/m/Y', strtotime($tgl)))));*/

    
    $lpro = getAllPro("2");
    $lgdg = getAllGdg($db);
    $pro = array(countAllPro(), getSumPro($db));
    $trm = getSumTrmFrmTo(date('Y-m-d'), date('Y-m-d'));
    $bhn = getSumBhnVacFrmTo(date('Y-m-d'), date('Y-m-d'), $db) + getSumBhnSawFrmTo(date('Y-m-d'), date('Y-m-d'), $db);
    $hsl = getSumHslVacFrmTo(date('Y-m-d'), date('Y-m-d'), $db) + getSumHslSawFrmTo(date('Y-m-d'), date('Y-m-d'), $db);
    $proc = array($bhn, $hsl);

    $data = array();
    for($i = 0; $i < count($lpro); $i++){
        $nma = $lpro[$i][1]." / ".$lpro[$i][4];
        if(strcasecmp($lpro[$i][2],"") != 0)
            $nma .= " / ".$lpro[$i][2];
        if(strcasecmp($lpro[$i][3],"") != 0)
            $nma .= " / ".$lpro[$i][3];

        $arr = array($lpro[$i][0], $nma);
        $sttl = 0;
        for($j = 0; $j < count($lgdg); $j++){
            $qgpro = getQGdgPro($lgdg[$j][0], $lpro[$i][0], $db);
            array_push($arr, $qgpro);
            $sttl += $qgpro;
        }

        array_push($arr, $sttl);

        $data[count($data)] = $arr;
    }

    closeDB($db);
    
    echo json_encode(array('data' => $data, 'lgdg' => $lgdg, 'count' => array(count($data)), 'pro' => $pro, 'trm' => $trm, 'proc' => array($bhn, $hsl)));
?>