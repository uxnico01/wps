<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));
    $addr = trim(mysqli_real_escape_string($db, $_POST["addr"]));
    $pic = trim(mysqli_real_escape_string($db, $_POST["pic"]));
    $hp = trim(mysqli_real_escape_string($db, $_POST["hp"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($name,"") == 0)
        $err = -1;
    else if(countGdgID($id, $db) > 0 && strcasecmp($id, $bid) != 0)
        $err = -2;
    else if(countGdgID($bid, $db) == 0)
        $err = -3;
    else
        updGdg($id, $name, $addr, $pic, $hp, $bid, $db);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>