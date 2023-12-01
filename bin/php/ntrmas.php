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
    $kdll = "";
    $sdll = "";
    $dp = trim(mysqli_real_escape_string($db, $_POST["dp"]));

    $lpro = json_decode($_POST["lpro"]);
    $dll = json_decode($_POST["dll"]);

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
    else
    {
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');

        if(strcasecmp($id, "") == 0)
        {
            $aw = "TT/";
            $ak = date('/my');
            $id = $aw.setID((int)substr(getLastIDTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            newTrm($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $wkt, $kota, $vdll, $kdll, $dp, $bb2, "", "", "", "");
        }
        else
        {
            updTrm($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $wkt, $id, $kota, $vdll, $kdll, $dp, $bb2, "", "", "", "");
            delAllDtlTrm($id);
            delAllDllTrm($id);
        }
        
        for($i = 0; $i < count($lpro); $i++)
        {
            if(countProID($lpro[$i][0]) === 0)
                continue;

            $pro = getProID($lpro[$i][0]);
            
            $hsup = getHSupID($sup, $pro[4], $lpro[$i][2]);
            
            $psup = getPSupID($sup, $pro[4], $lpro[$i][2]);

            newDtlTrm($id, $lpro[$i][0], $lpro[$i][1], $lpro[$i][2], $i + 1, $hsup[3], $psup[3]);
        }

        for($i = 0; $i < count($dll); $i++)
        {
            newDllTrm($id, $dll[$i][0], $dll[$i][1], $dll[$i][2], $i + 1);
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

        updQtyProTrm();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'id' => array($id)));
?>