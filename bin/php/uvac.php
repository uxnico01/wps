<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $ctgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["ctgl"]))));
    $margin = trim(mysqli_real_escape_string($db, $_POST["margin"]));
    $tmargin = trim(mysqli_real_escape_string($db, $_POST["tmargin"]));
    $fpro = trim(mysqli_real_escape_string($db, $_POST["fpro"]));
    $fbrt = trim(mysqli_real_escape_string($db, $_POST["fbrt"]));
    $fpro2 = trim(mysqli_real_escape_string($db, $_POST["fpro2"]));
    $fbrt2 = trim(mysqli_real_escape_string($db, $_POST["fbrt2"]));
    $type = trim(mysqli_real_escape_string($db, $_POST["type"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $thp = trim(mysqli_real_escape_string($db, $_POST["thp"]));
    $hcut = trim(mysqli_real_escape_string($db, $_POST["hcut"]));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));

    $user = $_SESSION["user-kuma-wps"];
    $set = getSett();
    $lpro = json_decode($_POST["lpro"]);

    $qbhn = 0;
    if(strcasecmp($type,"2") == 0)
    {
        $ctgl = "";

        if(strcasecmp($fpro,"") == 0)
            $fbrt = 0;

        if(strcasecmp($fpro2,"") == 0)
            $fbrt2 = 0;

        $qbhn = $fbrt + $fbrt2;
    }
    else if(strcasecmp($type,"1") == 0)
    {
        $fpro = "";
        $fbrt = 0;
        $fpro2 = "";
        $fbrt2 = 0;
        $qbhn = getSisaHCut($tgl, $ctgl, $db);
    }

    $qty = 0;
    $qty2 = 0;
    $qhsl = 0;
    $data = getVacID($id);
    if(strcasecmp($type,"2") == 0 && strcasecmp($data[5], $fpro) == 0 && strcasecmp($data[17], $gdg) == 0){
        $qty = $data[6];
    }
    else if(strcasecmp($type,"2") == 0 && strcasecmp($data[15], $fpro2) == 0 && strcasecmp($data[17], $gdg) == 0){
        $qty2 = $data[16];
    }

    for($i = 0; $i < count($lpro); $i++){
        $qhsl += $lpro[$i][1];
    }

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || (strcasecmp($type,"1") == 0 && strcasecmp($ctgl,"") == 0) || (strcasecmp($type,"2") == 0 && (strcasecmp($fpro,"") == 0 || strcasecmp($fbrt,"") == 0)) || strcasecmp($gdg,"") == 0)
        $err = -1;
    else if(countProID($fpro) == 0 && strcasecmp($fpro,"") != 0)
        $err = -2;
    else if(countVacID($id) == 0)
        $err = -3;
    else if(count($lpro) == 0)
        $err = -4;
    else if(strcasecmp($type,"2") == 0 && strcasecmp($fpro,"") != 0 && $fbrt > getQGdgPro($gdg, $fpro, $db)+$qty)
        $err = -5;
    else if(strcasecmp($type,"2") == 0 && strcasecmp($fpro2,"") != 0 && $fbrt2 > getQGdgPro($gdg, $fpro2, $db)+$qty2)
        $err = -6;
    else if(countGdgID($gdg, $db) == 0)
        $err = -7;
    else if($qhsl > $qbhn)
        $err = -8;
    else
    {
        $data2 = getVacItem($id);
        /*if(countProID($data[5]) > 0){
            $dpro = getProID($data[5]);

            if($dpro[5]+$data[6] < $fbrt){
                $err = -5;
            }
        }
        else if(countProID($data[15]) > 0){
            $dpro = getProID($data[15]);

            if($dpro[5]+$data[16] < $fbrt2){
                $err = -6;
            }
        }
        else*/{
            $aw = "HVAC/";
            $ak = date('/my');
            $hid = $aw.setID((int)substr(getLastIDHVac($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            newHstVac($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $id, $tgl, $type, $ctgl, $user, $fpro, $fbrt, $data[7], $margin, $tmargin, $user, date('Y-m-d H:i:s'), "EDIT", $data[12], $ket, $data[13], $thp, $data[14], $hcut, $data[15], $data[16], $fpro2, $fbrt2, $data[17], $gdg);

            for($i = 0; $i < count($data2); $i++)
            {
                newHstDtlVac($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B", $data2[$i][4], $data2[$i][5]);
            }

            delAllDtlVac($id);

            updVac($id, $tgl, $type, $ctgl, $user, $fpro, $fbrt, $data[7], $margin, $tmargin, $id, $ket, $thp, $hcut, $fpro2, $fbrt2, $gdg);

            for($i = 0; $i < count($lpro); $i++)
            {
                newDtlVac($id, $lpro[$i][0], $lpro[$i][1], $i, $lpro[$i][3], $lpro[$i][4]);

                newHstDtlVac($hid, $id, $lpro[$i][0], $lpro[$i][1], $i, "A", $lpro[$i][3], $lpro[$i][4]);
            }

            updQtyProVac();
        }
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>