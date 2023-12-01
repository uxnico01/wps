<?php
    try{
        require("./clsfunction.php");
        //error_reporting(-1);
        //ini_set('max_execution_time', 120);

        //session_destroy();

        $db = openDB();

        $sw = trim(mysqli_real_escape_string($db, $_POST["sw"]));
        $mbrt = trim(mysqli_real_escape_string($db, $_POST["mbrt"]));
        $mxbrt = trim(mysqli_real_escape_string($db, $_POST["mxbrt"]));
        $mjf = trim(mysqli_real_escape_string($db, $_POST["mjf"]));
        $mxjf = trim(mysqli_real_escape_string($db, $_POST["mxjf"]));
        $mtran = trim(mysqli_real_escape_string($db, $_POST["mtran"]));
        $mxtran = trim(mysqli_real_escape_string($db, $_POST["mxtran"]));
        $tsup = trim(mysqli_real_escape_string($db, $_POST["tsup"]));
        $user = trim(mysqli_real_escape_string($db, $_POST["user"]));
        $sat = trim(mysqli_real_escape_string($db, $_POST["sat"]));
        $mxsbrt = trim(mysqli_real_escape_string($db, $_POST["mxsbrt"]));
        $rcfrm = trim(mysqli_real_escape_string($db, $_POST["rcfrm"]));
        $rcto = trim(mysqli_real_escape_string($db, $_POST["rcto"]));
        $jpot = trim(mysqli_real_escape_string($db, $_POST["jpot"]));
        $cuser = trim(mysqli_real_escape_string($db, $_POST["cuser"]));
        $vuser = trim(mysqli_real_escape_string($db, $_POST["vuser"]));
        $dpd = trim(mysqli_real_escape_string($db, $_POST["dpd"]));
        $dpdhc = trim(mysqli_real_escape_string($db, $_POST["dpdhc"]));
        $tcut = trim(mysqli_real_escape_string($db, $_POST["tcut"]));
        $ocut = "N";

        if(isset($_POST["ocut"])){
            $ocut = trim(mysqli_real_escape_string($db, $_POST["ocut"]));
        }

        $lpro = json_decode($_POST["lpro"]);
        $lcpro = json_decode($_POST["lcpro"]);
        $lsup = json_decode($_POST["lsup"]);
        $ltgl = json_decode($_POST["ltgl"]);
        
        if($mbrt > $mxbrt)
        {
            $tmp = $mxbrt;
            $mxbrt = $mbrt;
            $mbrt = $tmp;
        }

        if($mjf > $mxjf)
        {
            $tmp = $mxjf;
            $mxjf = $mjf;
            $mjf = $tmp;
        }

        if($mtran > $mxtran)
        {
            $tmp = $mxtran;
            $mxtran = $mtran;
            $mtran = $tmp;
        }

        if($rcfrm > $rcto)
        {
            $tmp = $rcto;
            $rcto = $rcfrm;
            $rcfrm = $tmp;
        }

        if($mbrt < 0)
            $mbrt = 50;

        if($mxbrt == 0)
            $mxbrt = 100;

        if($mtran < 0)
            $mtran = 3;

        if($mxtran == 0)
            $mxtran = 6;

        if($mjf < 0)
            $mjf = 1;

        if($mxjf == 0)
            $mxjf = 5;

        if($rcto < 0)
            $rcto = 50;

        if($rcfrm == 0)
            $rcfrm = 55;

        if($jpot == 0 || $jpot > 6)
            $jpot = 6;

        $prsn = 0;
        $tsum = array();
        $txsum = array();
        for($i = 0; $i < count($lpro); $i++)
        {
            $tsum[$i] = 0;
            $prsn += $lpro[$i][1];
            $txsum[$i] = $sw * ($lpro[$i][1]/100);
        }

        $cprsn = 0;
        $ctsum = array();
        for($i = 0; $i < count($lcpro); $i++)
        {
            $ctsum[$i] = 0;
            $cprsn += $lcpro[$i][1];
        }
        
        $err = 0;
        if(($sw === "" || (double)$sw == 0 || (double)$sw < 0) && strcasecmp($ocut,"N") == 0)
            $err = -1;
        else if(count($lpro) == 0 && strcasecmp($ocut,"N") == 0)
            $err = -2;
        else if(strcasecmp($tsup, "N") == 0 && count($lsup) == 0)
            $err = -3;
        else if(count($ltgl) == 0)
            $err = -4;
        else if($prsn != 100 && strcasecmp($ocut,"N") == 0)
            $err = -5;
        else if(count($lcpro) == 0 && strcasecmp($dpdhc,"N") == 0 && strcasecmp($tcut, "N") == 0)
            $err = -6;
        else if($cprsn != 100 && strcasecmp($dpdhc,"N") == 0 && strcasecmp($tcut, "N") == 0)
            $err = -7;
        else
        {
            //delAllAtTrm($tgl, $db);
            
            //PENERIMAAN
            if(strcasecmp($ocut,"N") == 0){
                $sum = 0;
                //GET MAX BERAT / DAY
                $dw = $sw / count($ltgl);
                $ljtran = array();
                $lvpro = getAllProVac();
                $spro = array();
                $mxpro = array();
                
                if(strcasecmp($tsup,"Y") == 0)
                    $lsup = getAllSupID();

                
                if(strcasecmp($dpd,"Y") == 0){
                    for($i = 0; $i < count($ltgl); $i++)
                        delTrmTgl2($ltgl[$i], $db);
                }

                //LOOP BY TGL
                for($i = 0; $i < count($ltgl); $i++)
                {
                    //RAND JLH TRAN
                    $jtran = mt_rand($mtran, $mxtran);
                    $ljtran[$i] = $jtran;

                    //RAND DAILY WEIGHT
                    $ndw = ($sw - $sum)/(count($ltgl) - $i);
                    //$ndw = $sw / count($ltgl);
                    //$ndw = $dw / $jtran;
                    $rdw = getRandMinMax($ndw-$ndw*getRandMinMax2(0, 1), $ndw+$ndw*getRandMinMax2(0, 1));
                    $rdw = floor($rdw * 2)/2;
                    $rnw = $rdw / $jtran;
                    //$rnw = $rdw;

                    //LOOP JLH TRAN
                    for($j = 0; $j < $jtran; $j++)
                    {
                        $nw = getRandMinMax($rnw-$rnw*getRandMinMax2(0, 1), $rnw+$rnw*getRandMinMax2(0, 1));
                        $nw = floor($nw * 2)/2;

                        if($sum > $sw)
                            break;

                        //RAND SUPPLIER
                        $nsup = mt_rand(0, count($lsup) - 1);
                        while(countTrmSupTgl($lsup[$nsup], $ltgl[$i]) > 0)
                            $nsup = mt_rand(0, count($lsup) - 1);

                        //LOOP PRODUCT
                        $jpro = mt_rand(ceil(count($lpro)/2), count($lpro));

                        $nlpro = array();
                        for($m = 0; $m < count($lpro); $m++)
                        {
                            if(count($nlpro) > $jpro)
                                break;
                            if($tsum[$m] < $txsum[$m])
                                $nlpro[count($nlpro)] = array($lpro[$m][0], $lpro[$m][1], $m);
                        }

                        if(count($nlpro) == 0)
                            continue;

                        $aw = "TT/";
                        $ak = date('/my', strtotime($ltgl[$i]));
                        $id = $aw.setID((int)substr(getLastIDTrm3($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

                        newTrm2($id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], "", 0, 0, 0, 0, 0, 0, 0, 0, $db);

                        $aw = "HTRM/";
                        $ak = date('/my', strtotime($ltgl[$i]));
                        $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                        newHTrm2($hid, "", "", "", "", "", "", "", "", "", "", $id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], $user, $ltgl[$i], "NEW", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $db);

                        $k = 0;
                        $trate = 0;
                        for($l = 0; $l < count($nlpro); $l++)
                        {
                            $tsum2 = 0;
                            $pprsn = $nlpro[$l][1];
                            $rate = $nw * $pprsn/100;
                            $rate = floor($rate * 2) / 2;

                            $trate += $pprsn;

                            if($rate + $tsum[$nlpro[$l][2]] > $txsum[$nlpro[$l][2]])
                                $rate = $txsum[$nlpro[$l][2]] - $tsum[$nlpro[$l][2]];
                                
                            while($tsum2 < $rate)
                            {
                                $sisa = $rate - $tsum2;
                                
                                if($sisa < $mbrt)
                                    $val = $mbrt;
                                else if($sisa > $mbrt && $sisa < $mxbrt)
                                    $val = $sisa;
                                else
                                {
                                    $val = getRandMinMax($mbrt, $mxbrt);
                                    while($val < $mbrt || $val > $mxbrt)
                                        $val = getRandMinMax($mbrt, $mxbrt);
                                }

                                $val = floor($val * 2) / 2;

                                $pro = getProID2($nlpro[$l][0], $db);
                                
                                $hsup = getHSupID2($lsup[$nsup], $pro[4], $sat, $db);
                                
                                $psup = getPSupID2($lsup[$nsup], $pro[4], $sat, $db);
                                
                                newDtlTrm2($id, $nlpro[$l][0], $val, $sat, $k + 1, $hsup[3], $psup[3], $db);
                                newHDtlTrm2($hid, $id, $nlpro[$l][0], $val, $sat, $k + 1, "A", $hsup[3], $psup[3], $db);

                                $tsum[$nlpro[$l][2]] += $val;
                                $sum += $val;
                                $tsum2 += $val;
                                $k++;
                            }
                        }
                    }
                }
            }

            if(strcasecmp($dpdhc,"N") == 0)
            {
                //CUTTING
                //LOOP BY TGL
                $carr = array("F", "SP", "ST", "M", "B");
                $set = getSett();
                for($i = 0; $i < count($ltgl); $i++)
                {
                    //GET NOT CUTTED TERIMA
                    $lst = getTrmNCut($ltgl[$i]);

                    if(count($lst) > 0)
                    {
                        $aw = "TC/";
                        $ak = date('/my', strtotime($ltgl[$i]));
            
                        $id = $aw.setID((int)substr(getLastIDCut2($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;
            
                        newCut2($id, $ltgl[$i], $set[0][2], $cuser, $ltgl[$i], $set[0][1], $db);
            
                        $aw = "HCUT/";
                        $ak = date('/my', strtotime($ltgl[$i]));
                        $hid = $aw.setID((int)substr(getLastIDHCut2($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;
            
                        newHstCut2($hid, "", "", "", "", "", "", $id, $ltgl[$i], $set[0][2], $cuser, $ltgl[$i], $set[0][1], $cuser, $ltgl[$i], "NEW", $db);

                        //LOOP NOT CUTTED TERIMA
                        for($j = 0; $j < count($lst); $j++)
                        {
                            //GET MARGIN CUTTING
                            $mrgn = getRandMinMax($rcfrm, $rcto);
                            while($mrgn > $rcto)
                                $mrgn = getRandMinMax($rcfrm, $rcto);
                
                            $scut = array();
                            $cut = array(0, 0, 0, 0, 0, 0);

                            //MAX WEIGHT
                            $mw = $lst[$j][1] * $mrgn/100;

                            //GET RANDOM STAT CUT
                            for($k = 0; $k < 6; $k++)
                                $scut[$k] = $carr[mt_rand(0,4)];

                            //GET RANDOM WEIGHT CUT
                            $mwcut = $mw / $jpot;
                            $tmp = $mw;
                            for($k = 0; $k < $jpot - 1; $k++)
                            {
                                $vcut = getRandMinMax($mwcut - 1, $mwcut);
                                while($vcut > $mwcut)
                                    $vcut = getRandMinMax($mwcut - 1, $mwcut);

                                $tmp -= number_format($vcut,2,'.',',');
                                $cut[$k] = number_format($vcut,2,'.',',');
                            }

                            $cut[$jpot - 1] = $tmp;

                            newDtlCut2($id, $lst[$j][0], $cut[0], $cut[1], $cut[2], $cut[3], $cut[4], $cut[5], $j+1, $lst[$j][3], $lst[$j][2], $lst[$j][1], $scut[0], $scut[1], $scut[2], $scut[3], $scut[4], $scut[5], "", $j+1, $db);
                        
                            newHstDtlCut2($hid, $id, $lst[$j][0], $cut[0], $cut[1], $cut[2], $cut[3], $cut[4], $cut[5], $j+1, $lst[$j][3], $lst[$j][2], $lst[$j][1], "A", $scut[0], $scut[1], $scut[2], $scut[3], $scut[4], $scut[5], "", $j+1, $db);
                        }
                    }
                }

                if(strcasecmp($ocut,"Y") == 0 && strcasecmp($dpd,"Y") == 0){
                    for($i = 0; $i < count($ltgl); $i++){
                        delVacTgl($ltgl[$i], $db);
                    }
                }

                //VACUUM
                //LOOP BY TGL
                if(strcasecmp($tcut,"N") == 0){
                    $sw = getSumCutFrmTo6($ltgl[0], $ltgl[count($ltgl)-1], $db);
                    $lcpro2 = array();
                    for($i = 0; $i < count($lcpro); $i++){
                        if($lcpro[$i][1] == 0){
                            continue;
                        }

                        $lcpro2[count($lcpro2)] = array($lcpro[$i][0], $sw * $lcpro[$i][1]/100);
                    }
                }

                for($i = 0; $i < count($ltgl); $i++)
                {
                    //GET CUT WEIGHT
                    $cw = getSumCutFrmTo6($ltgl[$i], $ltgl[$i], $db);
                    $tcw = $cw;
                    $mrate = 100;
                    
                    $aw = "TV/";
                    $ak = date('/my', strtotime($ltgl[$i]));

                    $id = $aw.setID((int)substr(getLastIDVac2($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

                    newVac2($id, $ltgl[$i], "1", $ltgl[$i], $vuser, "", 0, $ltgl[$i], 0, '1', "", "", "0", $db);

                    $aw = "HVAC/";
                    $ak = date('/my', strtotime($ltgl[$i]));
                    $hid = $aw.setID((int)substr(getLastIDHVac2($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

                    newHstVac2($hid, "", "", "", "", "", "", "", "", "", "", $id, $ltgl[$i], "1", $ltgl[$i], $vuser, "", 0, $ltgl[$i], 0, '1', $user, date('Y-m-d H:i:s'), "NEW", "", "", "", "", "", "A", $db);

                    //LOOP PRODUCT VACUUM
                    if(strcasecmp($tcut,"N") == 0)
                    {
                        $j = 0;
                        while($mrate > 0 && count($lcpro2) > 0)
                        {
                            $rate = $mrate;
                            $n = rand(0, count($lcpro2) - 1);

                            $brt = $cw * $rate/100;
                            $k = 0;
                            while($brt > $lcpro2[$n][1] || $rate == 100){
                                if($rate > 50){
                                    $rate = getRandMinMax($rate/3, $rate/2);
                                    $brt = $cw * $rate/100;
                                }
                                else{
                                    $rate = ($lcpro2[$n][1] / $cw) * 100;
                                    $brt = $lcpro2[$n][1];
                                }

                                if($k > 25){
                                    break;
                                }

                                $k++;
                            }

                            if($brt > $tcw){
                                $brt = $tcw;
                            }

                            newDtlVac2($id, $lcpro2[$n][0], $brt, $j+1, "", $db);
                            newHstDtlVac2($hid, $id, $lcpro2[$n][0], $brt, $j+1, "A", "", $db);

                            $lcpro2[$n][1] -= $brt;
                            $mrate -= $rate;
                            $tcw -= $brt;
                            $j++;

                            $narr = array();
                            for($k = 0; $k < count($lcpro2); $k++){
                                if($lcpro2[$k][1] > 0){
                                    $narr[count($narr)] = $lcpro2[$k];
                                }
                            }

                            $lcpro2 = $narr;
                        }
                    }
                    else
                    {
                        $min = mt_rand(1, (int)count($lvpro)/2);
                        $max = mt_rand((int)count($lvpro)/2, count($lvpro));
                        $count = mt_rand($min, $max);

                        $srate = 0;
                        for($j = 0; $j < $count; $j++)
                        {
                            $rnd = mt_rand(0, count($lvpro)-1);
                            $mrate = (100 - $srate)/($count-$j);
                            $cpro = $lvpro[$rnd][0];

                            if($j == $count-1)
                                $rate = 100-$srate;
                            else
                            {
                                $rate = getRandMinMax($mrate/2, $mrate);
                                while($srate + $rate > 100){
                                    $rate = getRandMinMax($mrate/2, $mrate);
                                }
                            }
                            
                            $brt = $cw * $rate/100;

                            $srate += $rate;
                            
                            newDtlVac2($id, $cpro, $brt, $j+1, "", $db);
                            newHstDtlVac2($hid, $id, $cpro, $brt, $j+1, "A", "", $db);
                        }
                    }
                }
            }

            //REPAIR NOTA PENERIMAAN
            for($i = 0; $i < count($ltgl); $i++)
            {
                $lst = getTrmFrmTo5($ltgl[$i], $ltgl[$i]);

                for($j = 0; $j < count($lst); $j++)
                {
                    $aw = "TT/";
                    $ak = date('/my', strtotime($ltgl[$i]));
                    $id = $aw.setID((int)substr(getLastIDTrm4($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;
                    
                    updTrmID2($id, $lst[$j][0], $db);
                }
            }
        }

        updTTrm();
        updQtyProTrm();
        updQtyProCut();
        updQtyProVac();

        closeDB($db);
        
        echo json_encode(array('err' => array($err)));
    }
    catch (Exception $err){
        echo json_encode(array('err' => array($err->getMessage())));
    }
?>