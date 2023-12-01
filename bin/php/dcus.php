<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;
    if(countCusPO($id) > 0)
        $err = -1;
    else
        delCus($id);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>