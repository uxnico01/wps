<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $margin = trim(mysqli_real_escape_string($db, $_POST["margin"]));
    $tmargin = trim(mysqli_real_escape_string($db, $_POST["tmargin"]));
    $fpro = trim(mysqli_real_escape_string($db, $_POST["fpro"]));
    $fbrt = trim(mysqli_real_escape_string($db, $_POST["fbrt"]));
    $thp = trim(mysqli_real_escape_string($db, $_POST["thp"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));

    $user = $_SESSION["user-kuma-wps"];

    $lpro = json_decode($_POST["lpro"]);
    
    $qty = 0;
    $qhsl = 0;
    $data = getSawID($id);
    if(strcasecmp($data[3],$fpro) == 0 && strcasecmp($data[12], $gdg) == 0){
        $qty = $data[4];
    }

    for($i = 0; $i < count($lpro); $i++){
        $qhsl += $lpro[$i][1];
    }

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($fpro,"") == 0 || strcasecmp($fbrt,"") == 0 || strcasecmp($gdg,"") == 0)
        $err = -1;
    else if(countProID($fpro) == 0)
        $err = -2;
    else if(countSawID($id) == 0)
        $err = -3;
    else if(count($lpro) == 0)
        $err = -4;
    else if(countGdgID($gdg, $db) == 0)
        $err = -5;
    else if($fbrt > getQGdgPro($gdg, $fpro, $db)+$qty)
        $err = -6;
    else if($fbrt < $qhsl)
        $err = -7;
    else
    {
        $data2 = getSawItem($id);

        $aw = "HSAW/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHSaw($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHstSaw($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $id, $tgl, $user, $fpro, $fbrt, $data[5], $margin, $tmargin, $user, date('Y-m-d H:i:s'), "EDIT", $data[10], $thp, $data[11], $ket, $data[12], $gdg);

        for($i = 0; $i < count($data2); $i++)
        {
            newHstDtlSaw($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B");
        }

        delAllDtlSaw($id);

        updSaw($id, $tgl, $user, $fpro, $fbrt, $data[5], $margin, $tmargin, $id, $thp, $ket, $gdg);

        for($i = 0; $i < count($lpro); $i++)
        {
            newDtlSaw($id, $lpro[$i][0], $lpro[$i][1], $i);

            newHstDtlSaw($hid, $id, $lpro[$i][0], $lpro[$i][1], $i, "A");
        }

        updQtyProSaw();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>