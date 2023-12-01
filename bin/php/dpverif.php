<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $user = $_SESSION["user-kuma-wps"];

    setStatPVerif($id, "C", $user, $ket, $db);

    closeDB($db);

    echo json_encode(array('err' => array(1)));
?>