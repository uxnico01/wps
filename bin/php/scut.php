<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = schCut($id);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'aks' => array(cekAksUser(substr($duser[7],69,1)), cekAksUser(substr($duser[7],70,1)), cekAksUser(substr($duser[7],119,1)))));
?>