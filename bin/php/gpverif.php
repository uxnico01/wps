<?php
    require("./clsfunction.php");

    $db = openDB();

    $pvrf = getAllPVerif($db);

    closeDB($db);

    echo json_encode(array('data' => $pvrf, 'count' => array(count($pvrf))));
?>