<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $aks = trim(mysqli_real_escape_string($db, $_POST["aks"]));

    $err = 0;

    if(countUserID($id) == 0)
        $err = -1;
    else
    {
        $data = getUserID($id, 2);
        
        updUser($id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $aks, $id);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>