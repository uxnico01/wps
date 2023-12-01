<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
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

    $lpro = json_decode($_POST["lpro"]);
    $dll = json_decode($_POST["dll"]);
    $pdll = json_decode($_POST["pdll"]);
    $ldp = json_decode($_POST["ldp"]);
    $tdll = json_decode($_POST["tdll"]);

    $err = 0;

    $spjm = (double)getSumSupPjm($sup);

    if(strcasecmp($sup,"") == 0 || strcasecmp($tgl,"") == 0 || (double)$bb < 0)
        $err = -1;
    /*else if(countTrmID($id) > 0)
        $err = -2;*/
    else if(countSupID($sup) == 0)
        $err = -3;
    else if($poto > $spjm)
        $err = -4;
    else if(count($lpro) == 0)
        $err = -5;
    else
    {
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');

        if(strcasecmp($id,"") != 0)
            delTTrm($id);

        $stdp = 0;
        if(count($ldp) > 0)
        {
            for($i = 0; $i < count($ldp); $i++)
                $stdp += $ldp[$i][1];

            if($stdp != $dp)
                $dp = $stdp;
        }

        $set = getSett();
        
        $aw = "TT/";
        $ak = date('/my');
        $id = $aw.setID((int)substr(getLastIDTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newTrm($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $wkt, $kota, $vdll, $kdll, $dp, $bb2, $min, $vpdll, $vtdll, $mnm, $set[3][3]);

        $aw = "HTRM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHTrm($hid, "", "", "", "", "", "", "", "", "", "", $id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $wkt, $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "NEW", "", $kota, "", "", "", $vdll, $kdll, $dp, "", $min, "", $vpdll, "", $vtdll, "", $mnm, "", $set[3][3]);

        for($i = 0; $i < count($lpro); $i++)
        {
            if(countProID($lpro[$i][0]) === 0)
                continue;

            $pro = getProID($lpro[$i][0]);
            
            $hsup = getHSupID($sup, $pro[4], $lpro[$i][2]);
            
            $psup = getPSupID($sup, $pro[4], $lpro[$i][2]);

            newDtlTrm($id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $i + 1, $hsup[3], $psup[3]);
            newHDtlTrm($hid, $id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $i + 1, "A", $hsup[3], $psup[3]);
        }

        for($i = 0; $i < count($dll); $i++)
        {
            newDllTrm($id, $dll[$i][0], $dll[$i][1], $dll[$i][2], $i + 1);
            newHDllTrm($hid, $id, $dll[$i][0], $dll[$i][1], $dll[$i][2], $i + 1, "A");
        }

        for($i = 0; $i < count($pdll); $i++)
        {
            newPDllTrm($id, $pdll[$i][0], $pdll[$i][1], $pdll[$i][2], $i + 1);
            newHPDllTrm($hid, $id, $pdll[$i][0], $pdll[$i][1], $pdll[$i][2], $i + 1, "A");
        }

        for($i = 0; $i < count($ldp); $i++)
        {
            newDPTrm($id, $ldp[$i][0], $ldp[$i][1], $i + 1);
            newHDPTrm($hid, $id, $ldp[$i][0], $ldp[$i][1], $i + 1, "A");
        }

        for($i = 0; $i < count($tdll); $i++)
        {
            newTDllTrm($id, $tdll[$i][0], $tdll[$i][1], $tdll[$i][2], $i + 1, $tdll[$i][3], $tdll[$i][4]);
            newHTDllTrm($hid, $id, $tdll[$i][0], $tdll[$i][1], $tdll[$i][2], $i + 1, "A", $tdll[$i][3], $tdll[$i][4]);
        }

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

        if($vtdll != 0){
            updDtlTbhTrm($id, $vtdll / count($lpro), $db);
        }

        updQtyProTrm();
        updTTrm();
        repairPjm();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'id' => array($id)));
?>