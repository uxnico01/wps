<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $sup = trim(mysqli_real_escape_string($db, $_POST["sup"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $bb = trim(mysqli_real_escape_string($db, $_POST["bb"]));
    $poto = trim(mysqli_real_escape_string($db, $_POST["poto"]));
    $ket1 = trim(mysqli_real_escape_string($db, $_POST["ket1"]));
    $ket2 = trim(mysqli_real_escape_string($db, $_POST["ket2"]));
    $ket3 = trim(mysqli_real_escape_string($db, $_POST["ket3"]));
    $trm = trim(mysqli_real_escape_string($db, $_POST["trm"]));

    $lhrga = json_decode($_POST["lhrga"]);

    $err = 0;

    $spjm = (double)getSumSupPjm($sup);

    if(strcasecmp($id,"") == 0 || strcasecmp($sup,"") == 0 || strcasecmp($tgl,"") == 0 || strcasecmp($bb,"") == 0 || $bb < 0 || strcasecmp($trm,"") == 0)
        $err = -1;
    else if(countTTID($id) > 0)
        $err = -2;
    else if(countSupID($sup) == 0)
        $err = -3;
    else if($poto > $spjm)
        $err = -4;
    else if(countTrmID($trm) == 0)
        $err = -5;
    else
    {
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');

        newTT($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $trm, $user, $wkt);

        $aw = "HTT/";
        $ak = date('/my');
        $hid = $aw.setID(substr(getLastIDHTT($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHTT($hid, "", "", "", "", "", "", "", "", "", "", "", $id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $trm, $user, $wkt, $_SESSION["user-kuma-wps"], "NEW", date('Y-m-d H:i:s'));

        $lpro = getTrmItemTT($trm);

        if(count($lpro) > count($lhrga))
        {
            for($i = count($lhrga); $i < count($lpro); $i++)
                $lhrga[$i] = 0;
        }

        for($i = 0; $i < count($lpro); $i++)
        {
            newDtlTT($id, $lpro[$i][5], $lpro[$i][3], $lpro[$i][6], $i+1, $lhrga[$i], $lpro[$i][4]);

            newHDtlTT($hid, $id, $lpro[$i][5], $lpro[$i][3], $lpro[$i][6], $i+1, $lhrga[$i], "A", $lpro[$i][4]);
        }
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>