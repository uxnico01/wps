<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getTTrmID($id);
    $data2 = getTTrmItem($id);
    $data4 = getTTrmDll($id);
    $data5 = getTTrmPDll($id);
    $data6 = getTTrmDP($id);
    $data7 = getTTrmTDll($id);

    $spjm = (double)getSumSupPjm($data[1]);

    $sup = getSupID($data[1]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'data4' => $data4, 'data5' => $data5, 'data6' => $data6, 'data7' => $data7, 'count' => array(count($data2), 0, count($data4), count($data5), count($data6), count($data7)), 'sup' => $sup, 'spjm' => array($spjm+$data[4])));
?>