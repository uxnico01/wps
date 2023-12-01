<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($name,"") == 0)
        $err = -1;
    else if(countGolID($id, $db) > 0 && strcasecmp($bid, $id) != 0)
        $err = -2;
    else if(countGolID($bid, $db) == 0)
        $err = -3;
    else
        updGol($id, $name, $bid, $db);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>