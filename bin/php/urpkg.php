<?php
    require("./clsfunction.php");

    $db = openDB();

    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $weight = trim(mysqli_real_escape_string($db, $_POST["weight"]));
    $lpro = json_decode($_POST["lpro"]);
    $data = getRPkgID($bid, $db);
    $qawl = 0;

    $set = getSett();
    $gdg = $set[3][3];

    if(strcasecmp($data[1],$gdg) == 0){
        $qawl += $data[8];
    }

    $brt = 0;
    for($i = 0; $i < count($lpro); $i++){
        $brt += $lpro[$i][1];
    }

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($pro,"") == 0 || strcasecmp($weight,"") == 0){
        $err = -1;
    }
    else if(countProID($pro) == 0){
        $err = -2;
    }
    else if(count($lpro) == 0){
        $err = -3;
    }
    else if(countRPkgID($bid, $db) == 0){
        $err = -4;
    }
    else if($weight > getQGdgPro($gdg, $pro, $db) + $qawl){
        $err = -5;
    }
    else if($weight < $brt){
        $err = -6;
    }
    else{
        $wkt = date('Y-m-d H:i:s');
        $user = $_SESSION["user-kuma-wps"];

        $data2 = getRPkgItem($bid, $db);
        
        $haw = "HRPKG/";
        $hak = date('/my');
        $hid = $haw.setID((int)substr(getLastHRPkgID($haw, $hak, $db), strlen($haw), 4) + 1, 4).$hak;

        updRPkg($bid, $gdg, $tgl, $user, $pro, $weight, $ket, $db);
        newHRPkg($hid, $data[0], $data[1], $data[2], $data[3], $data[4], $data[7], $data[8], $bid, $gdg, $tgl, $user, $wkt, $pro, $weight, $user, $data[13], $ket, $wkt, "EDIT", $db);

        for($i = 0; $i < count($data2); $i++){
            newDtlHRPkg($hid, $data2[$i][0], $data2[$i][1], $data2[$i][2], $data2[$i][3], "B", $db);
        }

        delAllDtlRPkg($bid, $db);
        for($i = 0; $i < count($lpro); $i++){
            if(countProID($lpro[$i][0]) > 0){
                newDtlRPkg($bid, $lpro[$i][0], $lpro[$i][1], $i, $db);
                newDtlHRPkg($hid, $bid, $lpro[$i][0], $lpro[$i][1], $i, "A", $db);
            }
        }

        updQtyProRPkg($db);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>