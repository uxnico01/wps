<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getSupPSup($id);
    $data2 = getDuplicateSuppHeader($id);
    $data3 = getDuplicateSuppData($id);
    $data4 = getAllSatuan();
    $data5 = getAllGrade();
    $sup = getSupID($id);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'data3' => $data3, 'data4' => $data4, 'data5' => $data5, 'sup' => $sup, 'count' => array(count($data), count($data2), count($data3), count($data4), count($data5))));
?>