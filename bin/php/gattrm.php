<?php
    require("./clsfunction.php");

    $db = openDB();

    $data = getAllTTrm();

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data))));
?>