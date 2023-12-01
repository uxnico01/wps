<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));

    $data = getWeightVacPro($id, $tgl);

    closeDB($db);

    echo json_encode(array('data' => $data));
?>