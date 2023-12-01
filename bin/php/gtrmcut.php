<?php
    require("./clsfunction.php");

    $db = openDB();

    $sup = trim(mysqli_real_escape_string($db, $_POST["sup"]));
    $ttrm = trim(mysqli_real_escape_string($db, $_POST["ttrm"]));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));

    $data = getTrmCut($sup, $ttrm, $pro);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data))));
?>