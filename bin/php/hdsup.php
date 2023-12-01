<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    
    deleteDuplicateSupp($id);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>