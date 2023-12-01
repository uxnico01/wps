<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getPOID($id);
    $data2 = getPOItem($id, $db);
    
    $cus = getCusID($data[1]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'cus' => $cus));
?>