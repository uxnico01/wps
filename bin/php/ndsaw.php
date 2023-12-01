<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $fpro = trim(mysqli_real_escape_string($db, $_POST["fpro"]));
    $fbrt = trim(mysqli_real_escape_string($db, $_POST["fbrt"]));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $brt = trim(mysqli_real_escape_string($db, $_POST["brt"]));
    $thp = trim(mysqli_real_escape_string($db, $_POST["thp"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));

    $id = getSawIDTgl($tgl, $fpro, $thp);
    $bb = (float)$fbrt;
    $mbb = 0;

    if(countSawTgl($tgl, $fpro, $thp) > 0){
        $mbb = getSumSawID($id, $db);
    }

    $bb -= $mbb;

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($fpro,"") == 0)
        $err = -1;
    else if(strcasecmp($fpro,"") == 0 && strcasecmp($pro,"") == 0)
        $err = -3;
    else if((countProID($pro) == 0 && strcasecmp($pro,"") != 0) || (countProID($fpro) == 0 && strcasecmp($fpro,"") != 0))
        $err = -2;
    //else if($bb < $brt)
        //$err = -5;
    else
    {
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');
        $set = getSett();
        $cek = true;
        if(countSawTgl($tgl, $fpro, $thp) == 0)
        {
            $aw = "TS/";
            $ak = date('/my');

            $id = $aw.setID((int)substr(getLastIDSaw($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            /*if(countProID($fpro) > 0){
                $dpro = getProID($fpro);

                if($dpro[5] < $fbrt){
                    $err = -4;
                }
            }*/

            if($err == 0){
                newSaw($id, $tgl, $user, $fpro, $fbrt, $wkt, $set[2][2], $set[2][1], $thp, $ket, $set[3][3]);
            }

            $cek = false;
        }
        else{
            $dsaw = getSawID($id);

            /*if(countProID($dsaw[3]) > 0){
                $dpro = getProID($dsaw[3]);

                if($dpro[5]+$dsaw[4] < $fbrt){
                    $err = -3;
                }
            }*/

            if($err == 0){
                updSaw($id, $tgl, $user, $fpro, $fbrt, $wkt, $set[2][2], $set[2][1], $id, $thp, $ket, $set[3][3]);
            }
        }

        if($err == 0){
            $aw = "HSAW/";
            $ak = date('/my');
            $hid = $aw.setID((int)substr(getLastIDHSaw($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            $data = getSawID($id);
            $data2 = getSawItem($id);
            $urut = getLastUrutSaw($id) + 1;
            
            if(!$cek)
                newHstSaw($hid, "", "", "", "", "", "", "", "", $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $user, date('Y-m-d H:i:s'), "NEW", "", $thp, "", $ket, "", $set[3][3]);
            else
                $hid = getSawHIDTgl($tgl, $fpro, $thp);
            /*else
                newHstSaw($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $user, date('Y-m-d H:i:s'), "NEW", $data[10], $data[10]);

            for($i = 0; $i < count($data2); $i++)
            {
                newHstDtlSaw($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B");

                newHstDtlSaw($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "A");
            }*/

            if(strcasecmp($pro,"") != 0)
            {
                newDtlSaw($id, $pro, $brt, $urut);
                newHstDtlSaw($hid, $id, $pro, $brt, $urut, "A");
            }

            updQtyProSaw();
        }
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>