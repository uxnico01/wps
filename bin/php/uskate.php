<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $kate = trim(mysqli_real_escape_string($db, $_POST["kate"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($name,"") == 0)
        $err = -1;
    else if(countSKateID($id) > 0 && strcasecmp($bid, $id) != 0)
        $err = -2;
    else if(countSKateID($bid) == 0)
        $err = -3;
    /*else if(countKateID($kate) == 0)
        $err = -4;*/
    else
        updSKate($id, $name, $ket, $kate, $bid);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>