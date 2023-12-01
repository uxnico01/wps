<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHBBID($id, "B", $db);
    $dafr = getHBBID($id, "A", $db);

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dafr' => $dafr));
?>