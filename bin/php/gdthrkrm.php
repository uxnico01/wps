<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHstRKirimID($id, "B", $db);
    $dbfr2 = getHstRKirimItem($id, "B", $db);
    $dafr = getHstRKirimID($id, "A", $db);
    $dafr2 = getHstRKirimItem($id, "A", $db);

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dbfr2' => $dbfr2, 'dafr' => $dafr, 'dafr2' => $dafr2, 'count' => array(count($dbfr2), count($dafr2))))
?>