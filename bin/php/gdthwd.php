<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHWdID($id, "1");
    $dafr = getHWdID($id, "2");

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dafr' => $dafr))
?>