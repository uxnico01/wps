<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = schGdg($id, $db);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'aks' => array(CekAksUser(substr($duser[7],161,1)), CekAksUser(substr($duser[7],162,1)))));
?>