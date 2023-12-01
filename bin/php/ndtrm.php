<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));
    $sup = trim(mysqli_real_escape_string($db, $_POST["sup"]));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $kg = trim(mysqli_real_escape_string($db, $_POST["kg"]));
    $tipe = trim(mysqli_real_escape_string($db, $_POST["tipe"]));
    $sat = trim(mysqli_real_escape_string($db, $_POST["sat"]));
    $user = $_SESSION["user-kuma-wps"];

    $set = getSett();

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($sup,"") == 0 || strcasecmp($pro,"") == 0 || strcasecmp($kg,"") == 0 || strcasecmp($sat,"") == 0)
        $err = -1;
    else if(countSupID($sup) == 0)
        $err = -2;
    else if(countProID($pro) == 0)
        $err = -3;
    else if(countSatuanID($sat) == 0)
        $err = -4;
    else{
        if(countTrmSupTpTgl($sup, $tgl, $tipe) > 0){
            $id = getTrmSupTpTglID($sup, $tgl, $tipe);
        }
        else{
            $aw = "TT/";
            $ak = date('/my');
            $id = $aw.setID((int)substr(getLastIDTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            newTrm($id, $sup, $tgl, 0, 0, $tipe, "", "", $user, date('Y-m-d H:i:s'), "", 0, 0, 0, 0, 0, 0, 0, 0, $set[3][3]);
        }
        
        $urut = getLastUrutTrm($id) + 1;
        $dpro = getProID($pro);
        $hrga = array(getHSupID($sup, $dpro[4], $sat)[3], getPSupID($sup, $dpro[4], $sat)[3]);
        newDtlTrm($id, $pro, $kg, $sat, $urut, $hrga[0], $hrga[1]);
    }


    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>