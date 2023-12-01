<?php
    require("./clsfunction.php");
    
    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;

    if(countKatesPro($id, $db) > 0)
        $err = -1;
    else
        delKates($id, $db);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>