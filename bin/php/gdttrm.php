<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getTrmID($id);
    $data2 = getTrmItem($id);
    $data3 = getTrmItemTT($id);
    $data4 = getTrmDll($id);
    $data5 = getTrmPDll($id);
    $data6 = getTrmDP($id);
    $data7 = getTrmTDll($id);

    $spjm = (double)getSumSupPjm($data[1]);

    $sup = getSupID($data[1]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'data3' => $data3, 'data4' => $data4, 'data5' => $data5, 'data6' => $data6, 'data7' => $data7, 'count' => array(count($data2), count($data3), count($data4), count($data5), count($data6), count($data7)), 'sup' => $sup, 'spjm' => array($spjm+$data[4]), 'aks' => array(CekAksUser(substr($duser[7],64,1)), CekAksUser(substr($duser[7],65,1)), CekAksUser(substr($duser[7],135,1)))));
?>