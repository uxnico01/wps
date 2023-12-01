<?php
    require("./clsfunction.php");
    
    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;

    if(countKatePro($id) > 0)
        $err = -1;
    else
        delKate($id);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>