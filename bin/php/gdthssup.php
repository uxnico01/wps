<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getSupHSup($id);
    $sup = getSupID($id);

    closeDB($db);

    echo json_encode(array('data' => $data, 'sup' => $sup, 'count' => array(count($data))));
?>