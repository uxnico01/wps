<?php
    try{
        require("./clsfunction.php");
        //error_reporting(-1);
        //ini_set('max_execution_time', 120);

        //session_destroy();

        $db = openDB();

        $sw = trim(mysqli_real_escape_string($db, $_POST["sw"]));
        $mpo = trim(mysqli_real_escape_string($db, $_POST["mpo"]));
        $mxpo = trim(mysqli_real_escape_string($db, $_POST["mxpo"]));
        $kuser = trim(mysqli_real_escape_string($db, $_POST["kuser"]));
        $dpdk = trim(mysqli_real_escape_string($db, $_POST["dpdk"]));
        $tcus = trim(mysqli_real_escape_string($db, $_POST["tcus"]));
        $pkrm = trim(mysqli_real_escape_string($db, $_POST["pkrm"]));
        $sstk = trim(mysqli_real_escape_string($db, $_POST["sstk"]));
        $kurs = trim(mysqli_real_escape_string($db, $_POST["kurs"]));

        $lpro = json_decode($_POST["lpro"]);
        $lcus = json_decode($_POST["lcus"]);
        $ltgl = json_decode($_POST["ltgl"]);
        $lpo = json_decode($_POST["lpo"]);
        
        if($mpo > $mxpo)
        {
            $tmp = $mxpo;
            $mxpo = $mpo;
            $mpo = $tmp;
        }

        if($mpo < 0)
            $mpo = 1;

        if($mxpo == 0)
            $mxpo = 3;

        $prsn = 0;
        $tsum = array();
        for($i = 0; $i < count($lpro); $i++)
        {
            $tsum[$i] = 0;
            $prsn += $lpro[$i][1];
            $lpro[$i][2] = 0;
        }
        
        $err = 0;
        /*if($sw === "" || (double)$sw == 0 || (double)$sw < 0)
            $err = -1;
        else*/ if(count($lpro) == 0 && strcasecmp($pkrm,"N") == 0)
            $err = -2;
        else if(strcasecmp($tcus, "N") == 0 && count($lcus) == 0)
            $err = -3;
        else if(count($ltgl) == 0)
            $err = -4;
        else if($prsn != 100 && strcasecmp($pkrm,"N") == 0)
            $err = -5;
        else if(count($lpo) == 0 && strcasecmp($pkrm,"N") == 0)
            $err = -6;
        else
        {
            //delAllAtKrm($tgl, $db);
            if(strcasecmp($tcus,"Y") == 0)
                $lcus = getAllCusID();
            
            if(strcasecmp($dpdk,"Y") == 0)
            {
                for($i = 0; $i < count($lpo); $i++)
                {
                    delKirimPO($lpo[$i][0]);
                    updPOStat($lpo[$i][0], "NS", "", "");
                }

                updQtyProKirim();
            }

            $sum = 0;
            $lpro2 = array();
            if(strcasecmp($pkrm,"N") == 0){
                for($i = 0; $i < count($lpo); $i++){
                    $po = getPOID2($lpo[$i][0], $db);
                    $sum += $po[9];
                }

                $lpro2 = array();
                for($i = 0; $i < count($lpro); $i++){
                    if($lpro[$i][1] == 0){
                        continue;
                    }
                    
                    $lpro2[count($lpro2)] = array($lpro[$i][0], $sum * $lpro[$i][1]/100);
                }
            }
            
            for($i = 0; $i < count($lpo); $i++)
            {
                $ctgl = 0;
                $po = getPOID2($lpo[$i][0], $db);
                for($j = 0; $j < count($ltgl); $j++)
                {
                    if($ltgl[$j] > $po[2])
                        break;
                    else if($ltgl[$j] >= $lpo[$i][1])
                        $ctgl++;
                }

                if($ctgl == 0)
                    continue;

                if(strcasecmp($pkrm,"Y") == 0)
                {
                    $lvpro = getAllProVac2($ltgl[0], $ltgl[count($ltgl)-1], $kurs, $db);
                    
                    $spro = getSumSPro2($ltgl[0], $ltgl[count($ltgl)-1], $kurs, $db);
                    $min = mt_rand((int)count($lvpro)/3, (int)count($lvpro)/2);
                    $max = mt_rand((int)count($lvpro)/2, count($lvpro));
                    
                    for($j = $min; $j <= $max; $j++)
                    {
                        $arr = array();
                        $lvpro2 = array();
                        $tsstk = ($spro-$sstk)/$j;
                        
                        for($k = 0; $k < count($lvpro); $k++)
                        {
                            $lvpro[$k][14] = $tsstk / $lvpro[$k][13];

                            if($lvpro[$k][14] > $lvpro[$k][5])
                                $lvpro[$k][14] = $lvpro[$k][5];

                            $lvpro[$k][15] = ($lvpro[$k][14]/$po[9])*100;
                            $arr[count($arr)] = $k;
                        }

                        $carr = combinations($arr, $j);

                        for($k = 0; $k < count($carr); $k++)
                        {
                            $sumw = 0;
                            for($l = 0; $l < count($carr[$k]); $l++)
                                $sumw += $lvpro[$carr[$k][$l]][14];
                                
                            if($sumw >= $po[9])
                                $lvpro2[count($lvpro2)] = $carr[$k];

                            //if(count($lvpro2) > 5)
                                //break;
                        }

                        if(count($lvpro2) > 0)
                            break;
                    }
                    
                    if(count($lvpro2) == 0)
                        continue;

                    $lvpro2 = $lvpro2[rand(0, count($lvpro2)-1)];
                    $prsn = 0;
                    $mw = $po[9] / count($lvpro2);
                    for($j = 0; $j < count($lvpro2); $j++)
                    {
                        if($lvpro[$lvpro2[$j]][14] <= $mw)
                            $lvpro[$lvpro2[$j]][16] = number_format($lvpro[$lvpro2[$j]][15],2,'.','');
                        else if($lvpro[$lvpro2[$j]][15] > 100)
                            $lvpro[$lvpro2[$j]][16] = number_format(getRandMinMax(100/count($lvpro2), 100),2,'.','');
                        else
                            $lvpro[$lvpro2[$j]][16] = number_format(getRandMinMax(100/count($lvpro2), $lvpro[$lvpro2[$j]][15]),2,'.','');
                    }
                }

                $dw = $po[9] / $ctgl;
                $ctgls = 0;
                $sumdw = 0;

                for($j = 0; $j < count($ltgl); $j++)
                {
                    $dws = getRandMinMax($dw-$dw*getRandMinMax(0.1, 0.3), $dw+$dw*getRandMinMax(0.1, 0.3));
                    $mrate = 100;
                    
                    if($j == count($ltgl)-1 || $sumdw + $dws > $po[9] || $ctgls+1 == $ctgl)
                        $dws = $po[9]-$sumdw;
                    else if($j+1 < count($ltgl))
                    {
                        if($ltgl[$j+1] >= $po[2])
                            $dws = $po[9]-$sumdw;
                    }

                    if($ltgl[$j] > $po[2] || $sumdw >= $po[9])
                        break;
                    else if($ltgl[$j] >= $lpo[$i][1])
                    {
                        if(countKirimTgl2($ltgl[$j], $db) == 0)
                        {
                            $cek = false;
                            $aw = "TPS/";
                            $ak = date('/my', strtotime($ltgl[$j]));

                            $id = $aw.setID((int)substr(getLastIDKirim3($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

                            $aw = "HKRM/";
                            $ak = date('/my', strtotime($ltgl[$j]));
                            $hid = $aw.setID((int)substr(getLastIDHKirim2($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

                            newKirim2($id, $ltgl[$j], "", "", "", $kuser, $ltgl[$j], $db);
                            newHstKirim2($hid, "", "", "", "", "", "", "", $id, $ltgl[$j], "", "", "", $kuser, $ltgl[$j], $kuser, $ltgl[$j], "NEW", $db);
                        }
                        else
                        {
                            $id = getKirimIDTgl2($ltgl[$j], $db);
                            $hid = getKirimHIDTgl2($id, $db);
                        }

                        $tdws = $dws;
                        if(strcasecmp($pkrm,"N") == 0)
                        {
                            while($mrate > 0 && count($lpro2) > 0)
                            {
                                $rate = $mrate;
                                $n = rand(0, count($lpro2)-1);
    
                                $brt = $dws * $rate/100;
                                while($brt > $lpro2[$n][1] || $rate == 100){
                                    if($rate > 50){
                                        $rate = getRandMinMax($rate/3, $rate);
                                        $brt = $dws * $rate/100;
                                    }
                                    else{
                                        $rate = ($lpro2[$n][1] / $dws) * 100;
                                        $brt = $lpro2[$n][1];
                                    }
                                }

                                if($brt > $tdws){
                                    $brt = $tdws;
                                }

                                $urut = getLastUrutKirim2($id, $db) + 1;

                                newDtlKirim2($id, $lpro2[$n][0], $brt, $urut, $lpo[$i][0], 0, "", date('Y-m-d'), "", $db);
                                newHstDtlKirim2($hid, $id, $lpro2[$n][0], $brt, $urut, "A", $lpo[$i][0], 0, "", date('Y-m-d'), "", $db);
                                
                                $lpro2[$n][1] -= $brt;
                                $mrate -= $rate;
                                $tdws -= $brt;

                                $narr = array();
                                for($k = 0; $k < count($lpro2); $k++){
                                    if($lpro2[$k][1] > 0){
                                        $narr[count($narr)] = $lpro2[$k];
                                    }
                                }

                                $lpro2 = $narr;
                            }
                        }
                        else
                        {
                            $st = 0;
                            shuffle($lvpro2);

                            for($k = 0; $k < count($lvpro2); $k++)
                            {
                                if($lvpro[$lvpro2[$k]][16] == 0)
                                    continue;
                                else if($st >= $dws)
                                    break;
                                    
                                $brt = $dws * $lvpro[$lvpro2[$k]][16]/100;
                                $urut = getLastUrutKirim2($id, $db) + 1;

                                if($st + $brt > $dws)
                                    $brt = $dws - $st;

                                newDtlKirim2($id, $lvpro[$lvpro2[$k]][0], $brt, $urut, $lpo[$i][0], 0, "", date('Y-m-d'), "", $db);
                                newHstDtlKirim2($hid, $id, $lvpro[$lvpro2[$k]][0], $brt, $urut, "A", $lpo[$i][0], 0, "", date('Y-m-d'), "", $db);

                                $st += $brt;
                            }
                        }
                    }

                    $sumdw += $dws;
                    $ctgls ++;
                }

                updPOStat($lpo[$i][0], "SN", "", "");
                updQtyProKirim();
            }

            //REPAIR NOTA P/O
            for($i = 0; $i < count($ltgl); $i++)
            {
                $lst = getKirimFrmTo3($ltgl[$i], $ltgl[$i]);

                for($j = 0; $j < count($lst); $j++)
                {
                    $aw = "TP/";
                    $ak = date('/my', strtotime($ltgl[$i]));
                    $id = $aw.setID((int)substr(getLastIDKirim4($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;
                    
                    updKirimID($id, $lst[$j][0]);
                }
            }
        }

        closeDB($db);
        
        echo json_encode(array('err' => array($err)));
    }
    catch(Exception $err){
        echo json_encode(array('err' => array($err->getMessage())));
    }
?>