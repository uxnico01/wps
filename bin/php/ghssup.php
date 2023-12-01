<?php
    require("./clsfunction.php");

    $db = openDB();

    $sup = trim(mysqli_real_escape_string($db, $_POST["sup"]));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $sat = trim(mysqli_real_escape_string($db, $_POST["sat"]));

    $dpro = getProID($pro);
    $data = array(getHSupID($sup, $dpro[4], $sat)[3], getPSupID($sup, $dpro[4], $sat)[3]);

    closeDB($db);
    
    echo json_encode(array('data' => $data));
?>