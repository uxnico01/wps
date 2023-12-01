<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $sup = trim(mysqli_real_escape_string($db, $_POST["sup"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $jlh = trim(mysqli_real_escape_string($db, $_POST["jlh"]));
    $ket1 = trim(mysqli_real_escape_string($db, $_POST["ket1"]));
    $ket2 = trim(mysqli_real_escape_string($db, $_POST["ket2"]));
    $ket3 = trim(mysqli_real_escape_string($db, $_POST["ket3"]));

    $ssmpn = getSumSupSmpn($sup);
    $dsup = getSupID($sup);
    $data = getWdID($bid);

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($sup,"") == 0 || strcasecmp($tgl,"") == 0 || strcasecmp($jlh,"") == 0 || $jlh <= 0)
        $err = -1;
    else if(countWdID($id) > 0 && strcasecmp($bid, $id) != 0)
        $err = -2;
    else if(countSupID($sup) == 0)
        $err = -3;
    else if($jlh > $ssmpn + $data[3] + $dsup[10])
        $err = -4;
    else if(countWdID($id) == 0)
        $err = -5;
    else
    {
        $ssmpn = getSumSupSmpn($sup) + $data[3];

        $user = $_SESSION["user-kuma-wps"];

        updWd($id, $sup, $tgl, $jlh, $ket1, $ket2, $ket3, $user, $data[10], $bid);

        $aw = "HWD/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHWd($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHWd($hid, $bid, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[9], $data[10], $id, $sup, $tgl, $jlh, $data[4], $ket1, $ket2, $ket3, $user, $data[10], $_SESSION["user-kuma-wps"], "EDIT", date('Y-m-d H:i:s'));
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>