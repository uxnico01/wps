<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $sup = trim(mysqli_real_escape_string($db, $_POST["sup"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $bb = trim(mysqli_real_escape_string($db, $_POST["bb"]));
    $bb2 = trim(mysqli_real_escape_string($db, $_POST["bb2"]));
    $poto = trim(mysqli_real_escape_string($db, $_POST["poto"]));
    $ket1 = trim(mysqli_real_escape_string($db, $_POST["ket1"]));
    $ket2 = trim(mysqli_real_escape_string($db, $_POST["ket2"]));
    $ket3 = trim(mysqli_real_escape_string($db, $_POST["ket3"]));
    $kota = trim(mysqli_real_escape_string($db, $_POST["kota"]));
    $vdll = trim(mysqli_real_escape_string($db, $_POST["vdll"]));
    $vpdll = trim(mysqli_real_escape_string($db, $_POST["vpdll"]));
    $vtdll = trim(mysqli_real_escape_string($db, $_POST["vtdll"]));
    $kdll = "";
    $sdll = "";
    $dp = trim(mysqli_real_escape_string($db, $_POST["dp"]));
    $min = trim(mysqli_real_escape_string($db, $_POST["min"]));
    $mnm = trim(mysqli_real_escape_string($db, $_POST["mnm"]));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));

    $lpro = json_decode($_POST["lpro"]);
    $dll = json_decode($_POST["dll"]);
    $pdll = json_decode($_POST["pdll"]);
    $ldp = json_decode($_POST["ldp"]);
    $tdll = json_decode($_POST["tdll"]);

    $err = 0;

    $spjm = (double)getSumSupPjm($sup);

    if(strcasecmp($id,"") == 0 || strcasecmp($sup,"") == 0 || strcasecmp($tgl,"") == 0 || (double)$bb < 0 || strcasecmp($gdg,"") == 0)
        $err = -1;
    else if(countTrmID($id) > 0 && strcasecmp($bid, $id) != 0)
        $err = -2;
    else if(countSupID($sup) == 0)
        $err = -3;
    else if(count($lpro) == 0)
        $err = -5;
    else if(countTrmID($bid) == 0)
        $err = -6;
    else if(countGdgID($gdg, $db) == 0)
        $err = -7;
    else
    {
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');

        $data = getTrmID($bid);
        $data2 = getTrmItem($bid);
        $data3 = getTrmDll($bid);
        $data4 = getTrmPDll($bid);
        $data5 = getTrmDP($bid);
        $data6 = getTrmTDll($bid);

        if($poto > $spjm + $data[4])
            $err = -4;
        else
        {
            $stdp = 0;
            if(count($ldp) > 0)
            {
                for($i = 0; $i < count($ldp); $i++)
                    $stdp += $ldp[$i][1];
    
                if($stdp != $dp)
                    $dp = $stdp;
            }
            
            if($data[4] != 0)
            {
                $tpoto = $data[4];
                $lpjm = getPjmSupCross($data[1]);

                for($i = 0; $i < count($lpjm); $i++)
                {
                    $sisa = $lpjm[$i][2];

                    if($sisa < $tpoto)
                    {
                        updXPjm($lpjm[$i][0], -$sisa);
                        $tpoto -= $sisa;
                    }
                    else
                    {
                        updXPjm($lpjm[$i][0], -$tpoto);
                        break;
                    }
                }
            }

            updTrm($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $data[9], $bid, $kota, $vdll, $kdll, $dp, $bb2, $min, $vpdll, $vtdll, $mnm, $gdg);

            if($poto != 0)
            {
                $lpjm = getPjmSupNCross($sup);

                for($i = 0; $i < count($lpjm); $i++)
                {
                    $sisa = $lpjm[$i][1] - $lpjm[$i][2];

                    if($sisa > $poto)
                    {
                        updXPjm($lpjm[$i][0], $poto);
                        break;
                    }
                    else
                    {
                        updXPjm($lpjm[$i][0], $sisa);
                        $poto -= $sisa;
                    }
                    
                }
            }
            
            $set = getSett();

            $aw = "HTRM/";
            $ak = date('/my');
            $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            newHTrm($hid, $bid, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $data[9], $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "EDIT", $data[12], $kota, $data[13], $data[14], $data[15], $vdll, $kdll, $dp, $data[17], $min, $data[18], $vpdll, $data[19], $vtdll, $data[20], $mnm, $data[21], $set[3][3]);

            for($i = 0; $i < count($data2); $i++)
                newHDtlTrm($hid, $bid, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], "B", $data2[$i][5], $data2[$i][12]);

            for($i = 0; $i < count($data3); $i++)
                newHDllTrm($hid, $bid, $data3[$i][1], $data3[$i][2], $data3[$i][3], $data3[$i][4], "B");

            for($i = 0; $i < count($data4); $i++)
                newHPDllTrm($hid, $bid, $data4[$i][1], $data4[$i][2], $data4[$i][3], $data4[$i][4], "B");

            for($i = 0; $i < count($data5); $i++)
                newHDPTrm($hid, $bid, $data5[$i][1], $data5[$i][2], $data5[$i][3], "B");

            for($i = 0; $i < count($data6); $i++)
                newHTDllTrm($hid, $bid, $data6[$i][1], $data6[$i][2], $data6[$i][3], $data6[$i][4], "B", $data6[$i][5], $data6[$i][6]);

            delAllDtlTrm($bid);
            delAllDllTrm($bid);
            delAllPDllTrm($bid);
            delAllDPTrm($bid);
            delAllTDllTrm($bid);

            for($i = 0; $i < count($lpro); $i++)
            {
                if(countProID($lpro[$i][0]) == 0 || $lpro[$i][3] == 0)
                    continue;

                newDtlTrm($id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5]);
                newHDtlTrm($hid, $id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $lpro[$i][3], "A", $lpro[$i][4], $lpro[$i][5]);
            }

            for($i = 0; $i < count($lpro); $i++)
            {
                if($lpro[$i][3] != 0 || countProID($lpro[$i][0]) === 0)
                    continue;
                else
                    $lpro[$i][3] = getLastUrutTrm($id) + 1;

                newDtlTrm($id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $lpro[$i][3], $lpro[$i][4], $lpro[$i][5]);
                newHDtlTrm($hid, $id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $lpro[$i][3], "A", $lpro[$i][4], $lpro[$i][5]);
            }

            for($i = 0; $i < count($dll); $i++)
            {
                newDllTrm($id, $dll[$i][0], $dll[$i][1], $dll[$i][2], $i+1);
                newHDllTrm($hid, $id, $dll[$i][0], $dll[$i][1], $dll[$i][2], $i+1, "A");
            }

            for($i = 0; $i < count($pdll); $i++)
            {
                newPDllTrm($id, $pdll[$i][0], $pdll[$i][1], $pdll[$i][2], $i+1);
                newHPDllTrm($hid, $id, $pdll[$i][0], $pdll[$i][1], $pdll[$i][2], $i+1, "A");
            }

            for($i = 0; $i < count($ldp); $i++)
            {
                newDPTrm($id, $ldp[$i][0], $ldp[$i][1], $i+1);
                newHDPTrm($hid, $id, $ldp[$i][0], $ldp[$i][1], $i+1, "A");
            }

            for($i = 0; $i < count($tdll); $i++)
            {
                newTDllTrm($id, $tdll[$i][0], $tdll[$i][1], $tdll[$i][2], $i+1, $tdll[$i][3], $tdll[$i][4]);
                newHTDllTrm($hid, $id, $tdll[$i][0], $tdll[$i][1], $tdll[$i][2], $i+1, "A", $tdll[$i][3], $tdll[$i][4]);
            }

            if($vtdll != 0){
                updDtlTbhTrm($id, $vtdll / count($lpro), $db);
            }

            updQtyProTrm();
            updTTrm();
            repairPjm();
        }
    }
    
    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>