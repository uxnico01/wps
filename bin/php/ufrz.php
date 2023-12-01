<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));

    $user = $_SESSION["user-kuma-wps"];

    $ndata = json_decode($_POST["data"]);

    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($gdg,"") == 0)
        $err = -1;
    else if(countFrzID($id) == 0)
        $err = -3;
    else if(count($ndata) == 0)
        $err = -4;
    else if(countGdgID($gdg, $db) == 0)
        $err = -5;
    else
    {
        $data = getFrzID($id);
        $data2 = getFrzItem($id);

        $aw = "HFRZ/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastHIDFrz($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHFrz($hid, $id, $data[1], $data[2], $data[3], $id, $tgl, $user, $data[3], date('Y-m-d H:i:s'), $user, "EDIT", $data[6], $gdg);

        for($i = 0; $i < count($data2); $i++)
            newHDtlFrz($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], "B");

        delAllDtlFrz($id);

        updFrz($id, $tgl, $user, $data[3], $id, $gdg);

        for($i = 0; $i < count($ndata); $i++)
        {
            $rtrm = explode("|", $ndata[$i][0]);
            newDtlFrz($id, $rtrm[3], $rtrm[1], $rtrm[0], $rtrm[2], $i, $ndata[$i][2], $ndata[$i][1]);

            newHDtlFrz($hid, $id, $rtrm[3], $rtrm[1], $rtrm[0], $rtrm[2], $i, $ndata[$i][2], $ndata[$i][1], "A");
        }

        updQtyProFrz();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>