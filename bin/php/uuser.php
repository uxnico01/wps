<?php
    require("./clsfunction.php");

    $db = openDB();

    $user = trim(mysqli_real_escape_string($db, $_POST["user"]));
    $buser = trim(mysqli_real_escape_string($db, $_POST["buser"]));
    $pass = trim(mysqli_real_escape_string($db, $_POST["pass"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));
    $pos = trim(mysqli_real_escape_string($db, $_POST["pos"]));
    $div = trim(mysqli_real_escape_string($db, $_POST["div"]));
    $lvl = trim(mysqli_real_escape_string($db, $_POST["lvl"]));
    $act = trim(mysqli_real_escape_string($db, $_POST["act"]));

    $err = 0;

    if(strcasecmp($user,"") == 0)
        $err = -1;
    else if(countUserID($user) > 0 && strcasecmp($buser, $user) != 0)
        $err = -2;
    else if(countUserID($buser) == 0)
        $err = -3;
    else
    {
        $data = getUserID($buser);

        $npass = $data[1];
        if(strcasecmp($pass,"") != 0)
            $npass = getHash($pass);

        updUser($user, $npass, $name, $pos, $div, $act, $lvl, $data[7], $buser);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>