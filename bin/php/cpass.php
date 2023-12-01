<?php
    require("./clsfunction.php");

    $db = openDB();

    $bpass = trim(mysqli_real_escape_string($db, $_POST["bpass"]));
    $npass = trim(mysqli_real_escape_string($db, $_POST["npass"]));
    $cnpass = trim(mysqli_real_escape_string($db, $_POST["cnpass"]));
    
    $user = $_SESSION["user-kuma-wps"];

    $data = getUserID($user, 2);

    $err = 0;

    if(strcasecmp($bpass,"") == 0 || strcasecmp($npass,"") == 0 || strcasecmp($cnpass,"") == 0)
        $err = -1;
    else if(strcmp($npass, $cnpass) != 0)
        $err = -2;
    else if(!cekHash($bpass, $data[1]))
        $err = -3;
    else
        updUser($user, getHash($npass), $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $user);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>