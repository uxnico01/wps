<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getSKateID($id);

    $kate = getKateID($data[3]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'kate' => $kate));
?>