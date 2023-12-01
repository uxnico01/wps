<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHVacID($id, "1");
    $dbfr2 = getHVacItem($id, "B");
    $dafr = getHVacID($id, "2");
    $dafr2 = getHVacItem($id, "A");

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dbfr2' => $dbfr2, 'dafr' => $dafr, 'dafr2' => $dafr2, 'count' => array(count($dbfr2), count($dafr2))))
?>