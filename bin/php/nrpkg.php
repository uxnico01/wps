<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $weight = trim(mysqli_real_escape_string($db, $_POST["weight"]));
    $lpro = json_decode($_POST["lpro"]);

    $set = getSett();
    $gdg = $set[3][3];

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
    else if($weight > getQGdgPro($set[3][3], $pro, $db)){
        $err = -4;
    }
    else if($weight < $brt){
        $err = -5;
    }
    else{
        $wkt = date('Y-m-d H:i:s');
        $user = $_SESSION["user-kuma-wps"];

        $aw = "RPKG/";
        $ak = date('/my');
        $id = $aw.setID((int)substr(getLastRPkgID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

        $haw = "HRPKG/";
        $hak = date('/my');
        $hid = $haw.setID((int)substr(getLastHRPkgID($haw, $hak, $db), strlen($haw), 4) + 1, 4).$hak;

        newRPkg($id, $gdg, $tgl, $user, $wkt, $pro, $weight, $ket, $db);
        newHRPkg($hid, "", "", "", "", "", "", "", $id, $gdg, $tgl, $user, $wkt, $pro, $weight, $user, "", $ket, $wkt, "NEW", $db);

        for($i = 0; $i < count($lpro); $i++){
            if(countProID($lpro[$i][0]) > 0){
                newDtlRPkg($id, $lpro[$i][0], $lpro[$i][1], $i, $db);
                newDtlHRPkg($hid, $id, $lpro[$i][0], $lpro[$i][1], $i, "A", $db);
            }
        }

        updQtyProRPkg($db);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>