<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    if(!isset($_POST["type"]))
    {
        $kode = "?";
        $user = $_SESSION["user-kuma-wps"];
    }
    else
    {
        $kode = genKode();
        $user = getMoveID($id, $db)[9];
    }

    setMoveVerif($id, $user, $kode, $db);

    closeDB($db);
?>