<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHRPkgID($id, "A", $db);
    $dbfr2 = getHRPkgItem($id, "B", $db);
    $dafr = getHRPkgID($id, "B", $db);
    $dafr2 = getHRPkgItem($id, "A", $db);

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dbfr2' => $dbfr2, 'dafr' => $dafr, 'dafr2' => $dafr2, 'count' => array(count($dbfr2), count($dafr2))))
?>