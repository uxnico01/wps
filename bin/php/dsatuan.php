<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;

    if(countSatuanTrm($id) > 0 || countHSupSatuan($id) > 0 || countSatuanDupp($id) > 0)
        $err = -1;
    else
        delSatuan($id);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>