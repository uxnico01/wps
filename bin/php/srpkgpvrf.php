<?php
    require("./clsfunction.php");

    $db = openDB();

    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $brt = trim(mysqli_real_escape_string($db, $_POST["brt"]));
    $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));
    
    $aw = "PVRF/";
    $ak = date('/my');

    $id = $aw.setID((int)substr(getLastVerifID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

    $user = $_SESSION["user-kuma-wps"];
    $set = getSett();
    $sisa = getQGdgPro($set[3][3], $pro, $db);
    $slsh = $brt - $sisa;
    newPVerif($id, $tgl, $pro, $brt, $sisa, $slsh, $user, "P", "", "RPKG", $db);

    closeDB($db);

    echo json_encode(array('vpid' => array($id)));
?>