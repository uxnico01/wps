<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getTTID($id);
    $data2 = getTTItem($id);
    $data3 = getTTItem2($id);

    $sup = getSupID($data[1]);

    $spjm = (double)getSumSupPjm($data[1]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'data3' => $data3, 'sup' => $sup, 'spjm' => array($spjm), 'count' => array(count($data2), count($data3)), 'aks' => array(cekAksUser(substr($duser[7],49,1)))));
?>