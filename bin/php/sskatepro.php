<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $kate = trim(mysqli_real_escape_string($db, $_POST["id2"]));

    $data = schSKatePro($kate, $id);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data))));
?>