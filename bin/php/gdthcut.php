<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHCutID($id, "1");
    $dbfr2 = getHCutItem($id, "B");
    $dafr = getHCutID($id, "2");
    $dafr2 = getHCutItem($id, "A");

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dbfr2' => $dbfr2, 'dafr' => $dafr, 'dafr2' => $dafr2, 'count' => array(count($dbfr2), count($dafr2))))
?>