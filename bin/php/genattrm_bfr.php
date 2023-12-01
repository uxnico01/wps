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
        for($i = 0; $i < count($lpro); $i++)
        {
            $tsum[$i] = 0;
            $prsn += $lpro[$i][1];
        }

        $cprsn = 0;
        $ctsum = array();
        for($i = 0; $i < count($lcpro); $i++)
        {
            $ctsum[$i] = 0;
            $cprsn += $lcpro[$i][1];
        }
        
        $err = 0;
        if($sw === "" || (double)$sw == 0 || (double)$sw < 0)
            $err = -1;
        else if(count($lpro) == 0)
            $err = -2;
        else if(strcasecmp($tsup, "N") == 0 && count($lsup) == 0)
            $err = -3;
        else if(count($ltgl) == 0)
            $err = -4;
        else if($prsn != 100)
            $err = -5;
        else if(count($lcpro) == 0 && strcasecmp($dpdhc,"N") == 0 && strcasecmp($tcut, "N") == 0)
            $err = -6;
        else if($cprsn != 100 && strcasecmp($dpdhc,"N") == 0 && strcasecmp($tcut, "N") == 0)
            $err = -7;
        else
        {
            //PENERIMAAN
            $sum = 0;
            //GET MAX BERAT / DAY
            $dw = $sw / count($ltgl);
            $ljtran = array();
            $lvpro = getAllProVac();
            
            if(strcasecmp($tsup,"Y") == 0)
                $lsup = getAllSupID();
                
            //LOOP BY TGL

            //CARA PERTAMA
            /*for($i = 0; $i < count($ltgl); $i++)
            {
                if(strcasecmp($dpd,"Y") == 0)
                    delTrmTgl($ltgl[$i]);

                //RAND JLH TRAN
                $jtran = mt_rand($mtran, $mxtran);
                $ljtran[$i] = $jtran;
                $nw = $dw / $jtran;
                
                $w = getRandMinMax(($nw/2), $nw);
                while($w > $nw)
                    $w = getRandMinMax(($nw/2), $nw);
                    
                //LOOP JLH TRAN
                for($j = 0; $j < $jtran; $j++)
                {
                    if($sum > $sw)
                        break;

                    //GET JLH PRODUCT
                    $jpro = mt_rand(1, count($lpro)/2);
                    $nlpro = array();
                    for($k = 0; $k < $jpro; $k++)
                    {
                        $rpro = mt_rand(0, count($lpro) - 1);
                        $rate = $sw * $lpro[$rpro][1]/100;
                        while($tsum[$rpro] > $rate)
                        {
                            $rpro = mt_rand(0, count($lpro) - 1);
                            $rate = $sw * $lpro[$rpro][1]/100;
                        }
        
                        $nlpro[count($nlpro)] = $rpro;
                    }

                    $rdm = mt_rand(0, 1);

                    if(strcasecmp($rdm,"1") == 0)
                    {
                        $nmin = $w/mt_rand(3,10);
                        $nmax = $w/mt_rand(3,10);
                    }
                    else
                    {
                        $nmin = $w/mt_rand(7,10);
                        $nmax = $w/mt_rand(7,10);
                    }

                    if($nmin > $nmax)
                    {
                        $tmp = $nmin;
                        $nmin = $nmax;
                        $nmax = $nmin;
                    }
                
                    $tw = getRandMinMax($nmin, $nmax);
                    while($tw > $nw)
                        $tw = getRandMinMax($nmin, $nmax);

                    if(strcasecmp($rdm,"1") == 0)
                        $w -= ($tw);
                    else
                        $w += ($tw);

                    //RAND SUPPLIER
                    $nsup = mt_rand(0, count($lsup) - 1);
                    while(countTrmSupTgl($lsup[$nsup], $ltgl[$i]) > 0)
                        $nsup = mt_rand(0, count($lsup) - 1);

                    $aw = "TTT/";
                    $ak = date('/my');
                    $id = $aw.setID((int)substr(getLastIDTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                    newTrm($id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], "", 0, 0, 0, 0, 0, 0);

                    $aw = "HTRM/";
                    $ak = date('/my');
                    $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                    newHTrm($hid, "", "", "", "", "", "", "", "", "", "", $id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], $user, $ltgl[$i], "NEW", "", "", "", "", "", "", "", "", "", "", "", "");

                    //LOOP PRODUCT
                    $k = 0;
                    $tsum2 = 0;
                    while($tsum2 < $nw)
                    {
                        $cek = true;
                        for($m = 0; $m < count($nlpro); $m++)
                        {
                            if($nlpro[$m] != -1)
                            {
                                $cek = false;
                                break;
                            }
                        }

                        if($cek || $sum > $sw)
                            break;

                        //RAND PRODUCT
                        $n = mt_rand(0, count($nlpro) - 1);
                        while($nlpro[$n] == -1)
                            $n = mt_rand(0, count($nlpro) - 1);

                        $l = $nlpro[$n];

                        $rate = $sw * $lpro[$l][1]/100;
                        $sisa = $rate - $tsum[$l];
                        
                        $val = getRandMinMax($mbrt, $mxbrt);
                        while($val < $mbrt || $val > $mxbrt)
                            $val = getRandMinMax($mbrt, $mxbrt);

                        if($tsum[$l] > $rate)
                        {
                            $nlpro[$n] = -1;
                            continue;
                        }
                        else if($sisa < $mbrt)
                            $val = $mbrt;
                        else if($sisa > $mbrt && $sisa < $mxbrt)
                            $val = $sisa;

                        $pro = getProID($lpro[$l][0]);
                        
                        $hsup = getHSupID($lsup[$nsup], $pro[4], $sat);
                        
                        $psup = getPSupID($lsup[$nsup], $pro[4], $sat);
                        
                        newDtlTrm($id, $lpro[$l][0], $val, $sat, $k + 1, $hsup[3], $psup[3]);
                        newHDtlTrm($hid, $id, $lpro[$l][0], $val, $sat, $k + 1, "A", $hsup[3], $psup[3]);

                        $tsum[$l] += $val;
                        $sum += $val;
                        $tsum2 += $val;
                        $k++;
                    }
                }
            }*/

            //CARA KEDUA
            for($i = 0; $i < count($ltgl); $i++)
            {
                if(strcasecmp($dpd,"Y") == 0)
                    delTrmTgl($ltgl[$i]);

                //RAND JLH TRAN
                $jtran = mt_rand($mtran, $mxtran);
                $ljtran[$i] = $jtran;
                $nw = $dw / $jtran;
                
                //LOOP JLH TRAN
                for($j = 0; $j < $jtran; $j++)
                {
                    if($sum > $sw)
                        break;

                    //RAND SUPPLIER
                    $nsup = mt_rand(0, count($lsup) - 1);
                    while(countTrmSupTgl($lsup[$nsup], $ltgl[$i]) > 0)
                        $nsup = mt_rand(0, count($lsup) - 1);

                    $aw = "TT/";
                    $ak = date('/my');
                    $id = $aw.setID((int)substr(getLastIDTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                    newTrm($id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], "", 0, 0, 0, 0, 0, 0, 0, 0, "");

                    $aw = "HTRM/";
                    $ak = date('/my');
                    $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                    newHTrm($hid, "", "", "", "", "", "", "", "", "", "", $id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], $user, $ltgl[$i], "NEW", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");

                    //LOOP PRODUCT
                    $jpro = mt_rand(ceil(count($lpro)/2), count($lpro));

                    $k = 0;
                    $l = 0;
                    $n = 0;
                    while($n < $jpro)
                    {
                        if($l >= count($lpro))
                            break;

                        $tsum2 = 0;
                        $pprsn = $lpro[$l][1];

                        if($n + 1 == $jpro && $l < count($lpro) - 1)
                        {
                            for($m = $l+1; $m < count($lpro); $m++)
                                $pprsn += $lpro[$m][1];
                        }

                        $prate = $nw * $pprsn/100;
                        $rate = getRandMinMax($prate-$prate*getRandMinMax(0.1, 0.3), $prate+$prate*getRandMinMax(0.3, 0.5));

                        $rate = floor($rate * 2) / 2;

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

                            $pro = getProID($lpro[$l][0]);
                            
                            $hsup = getHSupID($lsup[$nsup], $pro[4], $sat);
                            
                            $psup = getPSupID($lsup[$nsup], $pro[4], $sat);
                            
                            newDtlTrm($id, $lpro[$l][0], $val, $sat, $k + 1, $hsup[3], $psup[3]);
                            newHDtlTrm($hid, $id, $lpro[$l][0], $val, $sat, $k + 1, "A", $hsup[3], $psup[3]);

                            $tsum[$l] += $val;
                            $sum += $val;
                            $tsum2 += $val;
                            $k++;
                        }
                        
                        $l++;
                        $n++;
                    }
                }
            }

            /*$ctgl = 0;
            for($i = 0; $i < count($ltgl); $i++)
            {
                if($ljtran[$i] < $mxtran)
                    $ctgl += 1;
            }

            /*$dw = ($sw - $sum)/$ctgl;
            while($sum < $sw - ($sw*0.005))
            {
                $cek = true;
                for($i = 0; $i < count($ltgl); $i++)
                {
                    if($ljtran[$i] < $mxtran)
                    {
                        $cek = false;
                        $jtran = mt_rand(1, $mxtran - $ljtran[$i]);
                        
                        $ljtran[$i] += $jtran;
                        $nw = $dw/$jtran;
                        
                        //LOOP JLH TRAN
                        for($j = 0; $j < $jtran; $j++)
                        {
                            if($sum > $sw)
                                break;

                            //RAND SUPPLIER
                            $nsup = mt_rand(0, count($lsup) - 1);
                            while(countTrmSupTgl($lsup[$nsup], $ltgl[$i]) > 0)
                                $nsup = mt_rand(0, count($lsup) - 1);
            
                            $aw = "TTT/";
                            $ak = date('/my');
                            $id = $aw.setID((int)substr(getLastIDTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;
            
                            newTrm($id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], "", 0, 0, 0, 0, 0, 0);
            
                            $aw = "HTRM/";
                            $ak = date('/my');
                            $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;
            
                            newHTrm($hid, "", "", "", "", "", "", "", "", "", "", $id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], $user, $ltgl[$i], "NEW", "", "", "", "", "", "", "", "", "", "", "", "");
            
                            //LOOP PRODUCT
                            $k = 0;
                            $tsum2 = 0;
                            while($tsum2 < $nw)
                            {
                                if($sum > $sw)
                                    break;

                                //RAND PRODUCT
                                $l = mt_rand(0, count($lpro) - 1);
            
                                $rate = $sw * $lpro[$l][1]/100;
                                $sisa = $rate - $tsum[$l];
                                
                                $val = getRandMinMax($mbrt, $mxbrt);
                                while($val < $mbrt || $val > $mxbrt)
                                    $val = getRandMinMax($mbrt, $mxbrt);
            
                                if($tsum[$l] > $rate)
                                    continue;
                                else if($sisa < $mbrt)
                                    $val = $mbrt;
                                else if($sisa > $mbrt && $sisa < $mxbrt)
                                    $val = $sisa;
            
                                $pro = getProID($lpro[$l][0]);
                                
                                $hsup = getHSupID($lsup[$nsup], $pro[4], $sat);
                                
                                $psup = getPSupID($lsup[$nsup], $pro[4], $sat);
                                
                                newDtlTrm($id, $lpro[$l][0], $val, $sat, $k + 1, $hsup[3], $psup[3]);
                                newHDtlTrm($hid, $id, $lpro[$l][0], $val, $sat, $k + 1, "A", $hsup[3], $psup[3]);
            
                                $tsum[$l] += $val;
                                $sum += $val;
                                $tsum2 += $val;
                                $k++;
                            }
                        }
                    }
                }
                
                if($cek)
                    break;
            }*/

            //LOOP AS LONG AS SUM < SW
            /*while($sum < $sw)
            {
                //if($sum == 0)
                {
                    //LOOP BY TGL
                    for($i = 0; $i < count($ltgl); $i++)
                    {
                        if($sum > $sw)
                            break;

                        //RAND JLH TRAN
                        $jtran = mt_rand($mtran, $mxtran);
                        
                        //LOOP JLH TRAN
                        for($j = 0; $j < $jtran; $j++)
                        {
                            //RAND SUPPLIER
                            $nsup = mt_rand(0, count($lsup) - 1);
                            while(countTrmSupTgl($lsup[$nsup], $ltgl[$i]) > 0)
                                $nsup = mt_rand(0, count($lsup) - 1);

                            if($sum > $sw)
                                break;

                            $aw = "TT/";
                            $ak = date('/my');
                            $id = $aw.setID((int)substr(getLastIDTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                            newTrm($id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], "", 0, 0, 0, 0, 0, 0);

                            $aw = "HTRM/";
                            $ak = date('/my');
                            $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                            newHTrm($hid, "", "", "", "", "", "", "", "", "", "", $id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], $user, $ltgl[$i], "NEW", "", "", "", "", "", "", "", "", "", "", "", "");

                            //RAND JLH PRODUCT
                            $jpro = mt_rand($mjf, $mxjf);
                            //LOOP PRODUCT
                            $k = 0;
                            $tsum2 = 0;
                            while($k < $jpro)
                            {
                                //RAND PRODUCT
                                $l = mt_rand(0, count($lpro) - 1);

                                if($sum > $sw || $tsum2 >= $mxsbrt)
                                    break;

                                $rate = $sw * $lpro[$l][1]/100;
                                $sisa = $rate - $tsum[$l];
                                
                                $val = getRandMinMax($mbrt, $mxbrt);
                                while($val < $mbrt || $val > $mxbrt)
                                    $val = getRandMinMax($mbrt, $mxbrt);

                                if($tsum[$l] > $rate)
                                    continue;
                                else if($sisa < $mbrt)
                                    $val = $mbrt;
                                else if($sisa > $mbrt && $sisa < $mxbrt)
                                    $val = $sisa;

                                $pro = getProID($lpro[$l][0]);
                                
                                $hsup = getHSupID($lsup[$nsup], $pro[4], $sat);
                                
                                $psup = getPSupID($lsup[$nsup], $pro[4], $sat);
                                
                                newDtlTrm($id, $lpro[$l][0], $val, $sat, $k + 1, $hsup[3], $psup[3]);
                                newHDtlTrm($hid, $id, $lpro[$l][0], $val, $sat, $k + 1, "A", $hsup[3], $psup[3]);

                                $tsum[$l] += $val;
                                $sum += $val;
                                $tsum2 += $val;
                                $k++;
                            }
                        }
                    }
                }
                else
                {
                    //GET RAND TGL
                    $i = mt_rand(0, count($ltgl)-1);

                    $nsup = mt_rand(0, count($lsup) - 1);
                    while(countTrmSupTgl($lsup[$nsup], $ltgl[$i]) > 0)
                        $nsup = mt_rand(0, count($lsup) - 1);
                                
                    $aw = "TT/";
                    $ak = date('/my');
                    $id = $aw.setID((int)substr(getLastIDTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                    newTrm($id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], "", 0, 0, 0, 0, 0, 0);

                    $aw = "HTRM/";
                    $ak = date('/my');
                    $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                    newHTrm($hid, "", "", "", "", "", "", "", "", "", "", $id, $lsup[$nsup], $ltgl[$i], 0, 0, "", "", "", $user, $ltgl[$i], $user, $ltgl[$i], "NEW", "", "", "", "", "", "", "", "", "", "", "", "");
                    
                    //RAND JLH PRODUCT
                    $jpro = mt_rand($mjf, $mxjf);
                    //LOOP PRODUCT
                    $k = 0;
                    $tsum2 = 0;
                    while($k < $jpro)
                    {
                        //RAND PRODUCT
                        $l = mt_rand(0, count($lpro) - 1);

                        if($sum > $sw || $tsum2 > $mxsbrt)
                            break;

                        $rate = $sw * $lpro[$l][1]/100;
                        $sisa = $rate - $tsum[$l];
                        
                        $val = getRandMinMax($mbrt, $mxbrt);
                        while($val < $mbrt || $val > $mxbrt)
                            $val = getRandMinMax($mbrt, $mxbrt);

                        if($tsum[$l] > $rate)
                            continue;
                        else if($sisa < $mbrt)
                            $val = $mbrt;
                        else if($sisa > $mbrt && $sisa < $mxbrt)
                            $val = $sisa;

                        $pro = getProID($lpro[$l][0]);
                        
                        $hsup = getHSupID($lsup[$nsup], $pro[4], $sat);
                        
                        $psup = getPSupID($lsup[$nsup], $pro[4], $sat);
                        
                        newDtlTrm($id, $lpro[$l][0], $val, $sat, $k + 1, $hsup[3], $psup[3]);
                        newHDtlTrm($hid, $id, $lpro[$l][0], $val, $sat, $k + 1, "A", $hsup[3], $psup[3]);

                        $tsum[$l] += $val;
                        $sum += $val;
                        $tsum2 += $val;
                        $k++;
                    }
                }
            }*/

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
                        $ak = date('/my');
            
                        $id = $aw.setID((int)substr(getLastIDCut($aw, $ak), strlen($aw), 4) + 1, 4).$ak;
            
                        newCut($id, $ltgl[$i], $set[0][2], $cuser, $ltgl[$i], $set[0][1], "");
            
                        $aw = "HCUT/";
                        $ak = date('/my');
                        $hid = $aw.setID((int)substr(getLastIDHCut($aw, $ak), strlen($aw), 4) + 1, 4).$ak;
            
                        newHstCut($hid, "", "", "", "", "", "", $id, $ltgl[$i], $set[0][2], $cuser, $ltgl[$i], $set[0][1], $cuser, $ltgl[$i], "NEW", "", "");

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

                                $tmp -= $vcut;
                                $cut[$k] = $vcut;
                            }

                            $cut[$jpot - 1] = $tmp;

                            newDtlCut($id, $lst[$j][0], $cut[0], $cut[1], $cut[2], $cut[3], $cut[4], $cut[5], $j+1, $lst[$j][3], $lst[$j][2], $lst[$j][1], $scut[0], $scut[1], $scut[2], $scut[3], $scut[4], $scut[5], "", $j+1);
                        
                            newHstDtlCut($hid, $id, $lst[$j][0], $cut[0], $cut[1], $cut[2], $cut[3], $cut[4], $cut[5], $j+1, $lst[$j][3], $lst[$j][2], $lst[$j][1], "A", $scut[0], $scut[1], $scut[2], $scut[3], $scut[4], $scut[5], "", $j+1);
                        }
                    }
                }

                //VACUUM
                //LOOP BY TGL
                for($i = 0; $i < count($ltgl); $i++)
                {
                    //GET CUT WEIGHT
                    $cw = getSumCutFrmTo($ltgl[$i], $ltgl[$i]);
                    
                    $aw = "TV/";
                    $ak = date('/my');

                    $id = $aw.setID((int)substr(getLastIDVac($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                    newVac($id, $ltgl[$i], "1", $ltgl[$i], $vuser, "", 0, $ltgl[$i], 0, '1', "", "", "0", "", "", "");

                    $aw = "HVAC/";
                    $ak = date('/my');
                    $hid = $aw.setID((int)substr(getLastIDHVac($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

                    newHstVac($hid, "", "", "", "", "", "", "", "", "", "", $id, $ltgl[$i], "1", $ltgl[$i], $vuser, "", 0, $ltgl[$i], 0, '1', $user, date('Y-m-d H:i:s'), "NEW", "", "", "", "", "", "A", "", "", "", "", "", "");

                    //LOOP PRODUCT VACUUM
                    if(strcasecmp($tcut,"N") == 0)
                    {
                        for($j = 0; $j < count($lcpro); $j++)
                        {
                            $brt = $cw * $lcpro[$j][1]/100;
                            newDtlVac($id, $lcpro[$j][0], $brt, $j+1, "", "");
                            newHstDtlVac($hid, $id, $lcpro[$j][0], $brt, $j+1, "A", "", "");
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
                                while($srate + $rate > 100)
                                    $rate = getRandMinMax($mrate/2, $mrate);
                            }

                            $brt = $cw * $rate/100;

                            $srate += $rate;
                            
                            newDtlVac($id, $cpro, $brt, $j+1, "", "");
                            newHstDtlVac($hid, $id, $cpro, $brt, $j+1, "A", "", "");
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
                    $ak = date('/my');
                    $id = $aw.setID((int)substr(getLastIDTrm2($aw, $ak), strlen($aw), 4) + 1, 4).$ak;
                    
                    updTrmID($id, $lst[$j][0]);
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