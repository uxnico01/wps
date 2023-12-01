<?php
    require("./clsfunction.php");

    $db = openDB();

    $smcut = trim(mysqli_real_escape_string($db, $_POST["smcut"]));
    $vmcut = trim(mysqli_real_escape_string($db, $_POST["vmcut"]));
    $smvac = trim(mysqli_real_escape_string($db, $_POST["smvac"]));
    $vmvac = trim(mysqli_real_escape_string($db, $_POST["vmvac"]));
    $smsaw = trim(mysqli_real_escape_string($db, $_POST["smsaw"]));
    $vmsaw = trim(mysqli_real_escape_string($db, $_POST["vmsaw"]));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));
    $kgdg = trim(mysqli_real_escape_string($db, $_POST["kgdg"]));
    $phcut = trim(mysqli_real_escape_string($db, $_POST["phcut"]));
    $phttl = trim(mysqli_real_escape_string($db, $_POST["phttl"]));
    $phtlg = trim(mysqli_real_escape_string($db, $_POST["phtlg"]));

    updSett($smcut, $vmcut, $smvac, $vmvac, $smsaw, $vmsaw, $gdg, $kgdg, $phcut, $phttl, $phtlg);

    closeDB($db);
?>