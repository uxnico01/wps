<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHTrmID($id, "1");
    $dbfr2 = getHTrmItem($id, "B");
    $dafr = getHTrmID($id, "2");
    $dafr2 = getHTrmItem($id, "A");

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dbfr2' => $dbfr2, 'dafr' => $dafr, 'dafr2' => $dafr2, 'count' => array(count($dbfr2), count($dafr2))))
?>