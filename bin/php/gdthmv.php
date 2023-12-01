<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHstMoveID($id, "A", $db);
    $dbfr2 = getHstMoveItem($id, "B", $db);
    $dafr = getHstMoveID($id, "B", $db);
    $dafr2 = getHstMoveItem($id, "A", $db);

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dbfr2' => $dbfr2, 'dafr' => $dafr, 'dafr2' => $dafr2, 'count' => array(count($dbfr2), count($dafr2))))
?>