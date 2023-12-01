<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $cus = trim(mysqli_real_escape_string($db, $_POST["cus"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $ket2 = trim(mysqli_real_escape_string($db, $_POST["ket2"]));
    $ket3 = trim(mysqli_real_escape_string($db, $_POST["ket3"]));
    $tmpl = trim(mysqli_real_escape_string($db, $_POST["tmpl"]));
    $dtmpl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["dtmpl"]))));
    $qty = trim(mysqli_real_escape_string($db, $_POST["qty"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($cus,"") == 0 || strcasecmp($tgl,"") == 0)
        $err = -1;
    else if(countPOID($id) > 0)
        $err = -2;
    else if(countCusID($cus) == 0)
        $err = -3;
    else{
        $aw = "WPO".date('ym')."-";
        $ak = "";
        $lid = getLastID2PO($aw, $ak, $db);
        $id2 = $aw.setID((int)substr($lid, strlen($aw), 5) + 1, 5).$ak;
        newPO($id, $cus, $tgl, $ket, $ket2, "", $tmpl, $dtmpl, $qty, $id2);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>