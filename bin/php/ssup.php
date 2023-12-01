<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = schSup($id);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'aks' => array(CekAksUser(substr($duser[7],11,1)), CekAksUser(substr($duser[7],12,1)), CekAksUser(substr($duser[7],13,4)) || CekAksUser(substr($duser[7],104,1)) || CekAksUser(substr($duser[7],106,1)), CekAksUser(substr($duser[7],103,1)), CekAksUser(substr($duser[7],105,1)))));
?>