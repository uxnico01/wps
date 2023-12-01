<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $cus = trim(mysqli_real_escape_string($db, $_POST["cus"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $ket1 = trim(mysqli_real_escape_string($db, $_POST["ket1"]));
    $ket2 = trim(mysqli_real_escape_string($db, $_POST["ket2"]));
    $ket3 = trim(mysqli_real_escape_string($db, $_POST["ket3"]));

    $lpro = json_decode($_POST["lpro"]);

    $err = 0;

    if(strcasecmp($cus,"") == 0 || strcasecmp($tgl,"") == 0)
        $err = -1;
    else if(countKirimID($id) > 0)
        $err = -2;
    else if(countCusID($cus) == 0)
        $err = -3;
    else if(count($lpro) == 0)
        $err = -4;
    else
    {
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');

        $aw = "TK/";
        $ak = date('/my');
        $id = $aw.setID((int)substr(getLastIDKirim($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newKirim($id, $cus, $tgl, $ket1, $ket2, $ket3, $user, $wkt);

        $aw = "HKRM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHKirim($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHKirim($hid, "", "", "", "", "", "", "", "", $id, $cus, $tgl, $ket1, $ket2, $ket3, $user, $wkt, $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "NEW");

        for($i = 0; $i < count($lpro); $i++)
        {
            if(countProID($lpro[$i][0]) == 0)
                continue;

            newDtlKirim($id, $lpro[$i][0], $lpro[$i][1], $i + 1);
            newHDtlKirim($hid, $id, $lpro[$i][0], $lpro[$i][1], $i + 1, "A");
        }

        updQtyProKirim();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'id' => array($id)));
?>