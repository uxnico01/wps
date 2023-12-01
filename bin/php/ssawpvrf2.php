<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $brt = trim(mysqli_real_escape_string($db, $_POST["brt"]));

    $data = getSawID($id);
    
    $aw = "PVRF/";
    $ak = date('/my');

    $id = $aw.setID((int)substr(getLastVerifID($aw, $ak, $db), strlen($aw), 4) + 1, 4).$ak;

    $user = $_SESSION["user-kuma-wps"];
    $set = getSett();
    $sisa = getQGdgPro($set[3][3], $data[3], $db)+$data[4];
    $slsh = $brt - $sisa;
    newPVerif($id, $data[1], $data[3], $brt, $sisa, $slsh, $user, "P", "", "S", $db);

    closeDB($db);

    echo json_encode(array('vpid' => array($id)));
?>