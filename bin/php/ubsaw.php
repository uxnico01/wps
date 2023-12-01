<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $qty = trim(mysqli_real_escape_string($db, $_POST["qty"]));
    $set = getSett();
    $data = getSawID($id);
    $dpro = getQGdgPro($set[3][3], $data[3], $db);
    $err = 0;

    $sbrt = getSumSawID($id, $db);
    if($sbrt > $qty)
        $err = -1;
    else if($dpro+$data[4] < $qty){
        $err = -2;
    }
    else{
        updRblcSaw($id, $qty);
        updQtyProSaw();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>