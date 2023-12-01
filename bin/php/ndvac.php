<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $ctgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["ctgl"]))));
    $fpro = trim(mysqli_real_escape_string($db, $_POST["fpro"]));
    $fbrt = trim(mysqli_real_escape_string($db, $_POST["fbrt"]));
    $fpro2 = trim(mysqli_real_escape_string($db, $_POST["fpro2"]));
    $fbrt2 = trim(mysqli_real_escape_string($db, $_POST["fbrt2"]));
    $type = trim(mysqli_real_escape_string($db, $_POST["type"]));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $brt = trim(mysqli_real_escape_string($db, $_POST["brt"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $ketp = trim(mysqli_real_escape_string($db, $_POST["ketp"]));
    $thp = trim(mysqli_real_escape_string($db, $_POST["thp"]));
    $hcut = trim(mysqli_real_escape_string($db, $_POST["hcut"]));
    $vid = trim(mysqli_real_escape_string($db, $_POST["vid"]));
    $grade = trim(mysqli_real_escape_string($db, $_POST["grade"]));

    $pverif = getPVerifID($vid, $db);
    $id = getVacIDTgl($tgl, $type, $fpro, $ctgl, $thp);

    if(strcasecmp($type,"1") == 0){
        $bb = getSisaHCut($tgl, $ctgl, $db, "2");
    }
    else{
        $bb = (float)$fbrt + (float)$fbrt2;
        $mbb = 0;

        if(countVacTgl($tgl, $type, $fpro, $ctgl, $thp, $fpro2) > 0){
            $mbb = getSumVacID($id, $db);
        }

        $bb -= $mbb;
    }
    
    $err = 0;
    if(strcasecmp($tgl,"") == 0 || (strcasecmp($type,"1") == 0 && strcasecmp($ctgl,"") == 0) || (strcasecmp($type,"2") == 0 && (strcasecmp($fpro,"") == 0 || strcasecmp($fbrt,"") == 0)) || strcasecmp($pro,"") == 0 || strcasecmp($brt,"") == 0)
        $err = -1;
    else if(countProID($pro) == 0 || (countProID($fpro) == 0 && strcasecmp($fpro,"") != 0))
        $err = -2;
    else if($bb < $brt)
        $err = -5;
    else if(countCutTgl($ctgl) == 0 && strcasecmp($type,"1") == 0){
        $err = -6;
    }
    else
    {
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');
        $set = getSett();
        $cek = true;
        if(countVacTgl($tgl, $type, $fpro, $ctgl, $thp, $fpro2) == 0)
        {
            $cek = false;
            $aw = "TV/";
            $ak = date('/my');

            $id = $aw.setID((int)substr(getLastIDVac($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            if(strcasecmp($type,"2") == 0)
            {
                $ctgl = "";

                if(strcasecmp($fpro,"") == 0)
                    $fbrt = 0;
    
                if(strcasecmp($fpro2,"") == 0)
                    $fbrt2 = 0;
            }
            else if(strcasecmp($type,"1") == 0)
            {
                $fpro = "";
                $fbrt = 0;
                $fpro2 = "";
                $fbrt2 = 0;
            }

            if(countProID($fpro) > 0){
                $dpro = getQGdgPro($set[3][3], $fpro, $db);

                if($dpro < $fbrt){
                    $err = -3;
                }
            }

            if($err == 0 && countProID($fpro2) > 0){
                $dpro = getQGdgPro($set[3][3], $fpro2, $db);

                if($dpro < $fbrt2){
                    $err = -4;
                }
            }

            if($err == 0){
                newVac($id, $tgl, $type, $ctgl, $user, $fpro, $fbrt, $wkt, $set[1][2], $set[1][1], $ketp, $thp, $hcut, $fpro2, $fbrt2, $set[3][3]);
            }
        }
        else{
            $dvac = getVacID($id);

            if(countProID($dvac[5]) > 0){
                $dpro = getQGdgPro($set[3][3], $dvac[5], $db);

                if($dpro+$dvac[6] < $fbrt){
                    $err = -3;
                }
            }

            if(countProID($dvac[15]) > 0){
                $dpro = getQGdgPro($set[3][3], $dvac[15], $db);

                if($dpro+$dvac[16] < $fbrt2){
                    $err = -4;
                }
            }
        }

        if($err == 0){
            $aw = "HVAC/";
            $ak = date('/my');
            $hid = $aw.setID((int)substr(getLastIDHVac($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            $data = getVacID($id);
            $data2 = getVacItem($id);
            $urut = getLastUrutVac($id) + 1;
            
            if(!$cek)
                newHstVac($hid, "", "", "", "", "", "", "", "", "", "", $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $user, date('Y-m-d H:i:s'), "NEW", "", $ketp, "", $thp, "", $hcut, "", "", $fpro2, $fbrt2, "", $set[3][3]);
            else
                $hid = getVacHIDTgl($tgl);
            /*else
                newHstVac($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $user, date('Y-m-d H:i:s'), "NEW");

            for($i = 0; $i < count($data2); $i++)
            {
                newHstDtlVac($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B");

                newHstDtlVac($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "A");
            }*/

            newDtlVac($id, $pro, $brt, $urut, $ket, $grade);
            newHstDtlVac($hid, $id, $pro, $brt, $urut, "A", $ket, $grade);

            updQtyProVac();
        }
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>