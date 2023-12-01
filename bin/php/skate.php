<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = schKate($id);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'aks' => array(cekAksUser(substr($duser[7],28,1)), cekAksUser(substr($duser[7],29,1)), cekAksUser(substr($duser[7],30,2)))));
?>