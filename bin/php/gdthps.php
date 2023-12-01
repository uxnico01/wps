<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $dbfr = getHPsID($id, "1");
    $dbfr2 = getHPsItem($id, "B");
    $dafr = getHPsID($id, "2");
    $dafr2 = getHPsItem($id, "A");

    closeDB($db);

    echo json_encode(array('dbfr' => $dbfr, 'dbfr2' => $dbfr2, 'dafr' => $dafr, 'dafr2' => $dafr2, 'count' => array(count($dbfr2), count($dafr2))))
?>