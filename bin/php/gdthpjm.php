<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHPjmID($id, "1");
    $dafr = getHPjmID($id, "2");

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dafr' => $dafr))
?>