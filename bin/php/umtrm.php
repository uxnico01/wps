<?php
    require("./clsfunction.php");

    $db = openDB();

    $arr = json_decode($_POST["arr"]);

    for($i = 0; $i < count($arr); $i++)
        updMTrm($arr[$i][0], $arr[$i][1]);

    closeDB($db);

    echo json_encode(array('err' => array(0)));
?>