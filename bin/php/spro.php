<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $type = trim(mysqli_real_escape_string($db, $_POST["type"]));

    $data = schPro($id, $type);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'aks' => array(CekAksUser(substr($duser[7],11,1)), CekAksUser(substr($duser[7],12,1)), CekAksUser(substr($duser[7],13,4)))));
?>