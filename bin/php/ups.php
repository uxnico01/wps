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
    else if(countPsID($id) == 0)
        $err = -3;
    else if(count($lpro) == 0)
        $err = -2;
    else if(countGdgID($gdg, $db) == 0)
        $err = -4;
    else
    {
        $data = getPsID($id);
        $data2 = getPsItem($id);

        $aw = "HPS/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHIDPs($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHPs($hid, $id, $data[1], $data[2], $data[3], $data[4], $id, $tgl, $ket, $user, $data[4], date('Y-m-d H:i:s'), $user, "EDIT", $data[7], $gdg);

        for($i = 0; $i < count($data2); $i++)
        {
            newHDtlPs($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], "B", $data2[$i][4]);
        }

        delAllDtlPs($id);

        updPs($id, $tgl, $user, $data[4], $id, $gdg);

        for($i = 0; $i < count($lpro); $i++)
        {
            newDtlPs($id, $lpro[$i][0], $lpro[$i][1], $i, $lpro[$i][3]);

            newHDtlPs($hid, $id, $lpro[$i][0], $lpro[$i][1], $i, $lpro[$i][3], "A");
        }

        updQtyProPs();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>