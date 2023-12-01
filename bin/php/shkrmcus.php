<?php
    require("./clsfunction.php");

    $db = openDB();

    $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["frm"]))));
    $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["to"]))));
    $cus = trim(mysqli_real_escape_string($db, $_POST["cus"]));

    $data = getCusKrmFrmTo($frm, $to, $cus);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data))));
?>