<?php
    require("./clsfunction.php");

    $db = openDB();

    $txt = trim(mysqli_real_escape_string($db, $_POST["txt"]));
    $c1 = trim(mysqli_real_escape_string($db, $_POST["c1"]));
    $c2 = trim(mysqli_real_escape_string($db, $_POST["c2"]));
    $c3 = trim(mysqli_real_escape_string($db, $_POST["c3"]));
    $dstk = trim(mysqli_real_escape_string($db, $_POST["dstk"]));
    $dpjm = trim(mysqli_real_escape_string($db, $_POST["dpjm"]));
    $dsmpn = trim(mysqli_real_escape_string($db, $_POST["dsmpn"]));

    $err = 0;
    if(strcmp($txt,"SAYA SETUJU") != 0 || !$c1 || !$c2 || !$c3)
        $err = -1;
    else
        saveTBuku($dstk, $dpjm, $dsmpn);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>