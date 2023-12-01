<?php
    require("./clsfunction.php");

    $db = openDB();

    $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["frm"]))));
    $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["to"]))));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));

    $data = getProKrmFrmTo($frm, $to, $pro);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data))));
?>