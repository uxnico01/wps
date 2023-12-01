<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;
    if(countSupPrTT($id) > 0 || countSupTrPjm($id) > 0 || countSupTrWd($id) > 0 || countDelIDDupp($id) > 0)
        $err = -1;
    else
        delSup($id);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>