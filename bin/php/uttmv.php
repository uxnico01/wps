<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $ntt = trim(mysqli_real_escape_string($db, $_POST["ntt"]));

    $err = 0;
    
    $data = getMoveID($id, $db);

    updMove($id, $data[1], $data[2], $data[3], $data[4], $data[5], $ntt, $data[14], $db);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>