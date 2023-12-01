<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));

    $user = $_SESSION["user-kuma-wps"];

    $lpro = json_decode($_POST["lpro"]);

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($gdg,"") == 0)
        $err = -1;
    else if(countMPID($id) == 0)
        $err = -3;
    else if(count($lpro) == 0)
        $err = -4;
    else if(countGdgID($gdg, $db) == 0)
        $err = -5;
    else
    {
        $data = getMPID($id);
        $data2 = getMPItem($id);

        $aw = "HMP/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHIDMP($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHMP($hid, $id, $data[1], $data[2], $data[3], $id, $tgl, $user, $data[3], date('Y-m-d H:i:s'), $user, "EDIT", $data[6], $gdg);

        for($i = 0; $i < count($data2); $i++)
        {
            newHDtlMP($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], "B");
        }

        delAllDtlMP($id);

        updMP($id, $tgl, $user, $data[3], $id, $gdg);

        for($i = 0; $i < count($lpro); $i++)
        {
            newDtlMP($id, $lpro[$i][0], $lpro[$i][1], $i, $lpro[$i][3]);

            newHDtlMP($hid, $id, $lpro[$i][0], $lpro[$i][1], $i, $lpro[$i][3], "A");
        }

        updQtyProMP();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>