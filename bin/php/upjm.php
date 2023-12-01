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
    $pot = trim(mysqli_real_escape_string($db, $_POST["pot"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($sup,"") == 0 || strcasecmp($tgl,"") == 0 || strcasecmp($jlh,"") == 0 || $jlh <= 0)
        $err = -1;
    else if(countPjmID($id) > 0 && strcasecmp($bid, $id) != 0)
        $err = -2;
    else if(countSupID($sup) == 0)
        $err = -3;
    else if(countPjmID($id) == 0)
        $err = -4;
    else
    {
        $data = getPjmID($bid);

        $user = $_SESSION["user-kuma-wps"];

        updPjm($id, $sup, $tgl, $jlh, $data[4], $ket1, $ket2, $ket3, $user, $data[9], $bid, $pot);

        $aw = "HPJM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHPjm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHPjm($hid, $bid, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $id, $sup, $tgl, $jlh, $data[4], $ket1, $ket2, $ket3, $user, $data[9], $_SESSION["user-kuma-wps"], "EDIT", date('Y-m-d H:i:s'), $data[12], $pot);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>