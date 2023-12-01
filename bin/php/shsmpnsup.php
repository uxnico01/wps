<?php
    require("./clsfunction.php");

    $db = openDB();

    $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["frm"]))));
    $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["to"]))));
    $sup = trim(mysqli_real_escape_string($db, $_POST["sup"]));

    $data = getSmpnSupFrmTo($frm, $to, $sup);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data))));
?>