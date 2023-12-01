<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($name,"") == 0)
        $err = -1;
    else if(countSatuanID($id) > 0 && strcasecmp($id, $bid) != 0)
        $err = -2;
    else if(countSatuanID($bid) == 0)
        $err = -3;
    else
        updSatuan($id, $name, $ket, $bid);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>