<?php
    require("./clsfunction.php");

    $db = openDB();

    $user = trim(mysqli_real_escape_string($db, $_POST["user"]));
    $pass = trim(mysqli_real_escape_string($db, $_POST["pass"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));
    $pos = trim(mysqli_real_escape_string($db, $_POST["pos"]));
    $div = trim(mysqli_real_escape_string($db, $_POST["div"]));
    $lvl = trim(mysqli_real_escape_string($db, $_POST["lvl"]));

    $err = 0;

    if(strcasecmp($user,"") == 0 || strcasecmp($pass,"") == 0)
        $err = -1;
    else if(countUserID($user) > 0)
        $err = -2;
    else
        newUser($user, getHash($pass), $name, $pos, $div, "Y", $lvl);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>