<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;

    $data = getCutID($id);
    $data2 = getCutItem($id);

    $aw = "HCUT/";
    $ak = date('/my');
    $hid = $aw.setID((int)substr(getLastIDHCut($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

    newHstCut($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[7], "", "", "", "", "", "", $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "DELETE", $data[8], "");

    for($i = 0; $i < count($data2); $i++)
        newHstDtlCut($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], $data2[$i][8], $data2[$i][9], $data2[$i][10], $data2[$i][11], "B", $data2[$i][16], $data2[$i][17], $data2[$i][18], $data2[$i][19], $data2[$i][20], $data2[$i][21], $data2[$i][22], $data2[$i][23], $data2[$i][24], $data2[$i][25], $data2[$i][26], $data2[$i][27], $data2[$i][28], $data2[$i][29], $data2[$i][37], $data2[$i][38]);

    delCut($id);

    updQtyProCut();

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>