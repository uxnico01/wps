<?php
    require("./clsfunction.php");
    
    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;

    if(countGolPro($id, $db) > 0)
        $err = -1;
    else
        delGol($id, $db);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>