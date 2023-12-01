<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getPsID($id);
    $data2 = getPsItem($id);
    $data3 = getPsItem2($id);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'data3' => $data3, 'count' => array(count($data2), count($data3)), 'aks' => array(CekAksUser(substr($duser[7],153,1)), CekAksUser(substr($duser[7],154,1)))));
?>