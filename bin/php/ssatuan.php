<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = schSatuan($id);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'aks' => array(CekAksUser(substr($duser[7],24,1)), CekAksUser(substr($duser[7],25,1)))));
?>