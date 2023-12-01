<?php
    require("./clsfunction.php");

    $db = openDB();

    $nid = setID((int)getLastIDKates($db) + 1, 3);

    closeDB($db);

    echo json_encode(array('nid' => array($nid)));
?>