<?php
    require("./clsfunction.php");

    $db = openDB();

    $dbs = trim(mysqli_real_escape_string($db, $_POST["db"]));

    $_SESSION["kuma-db"] = $dbs;

    if(strcasecmp($dbs, "kuma_wps") == 0)
        $_SESSION["kuma-db-nm"] = "Bulan Berjalan";
    else
        $_SESSION["kuma-db-nm"] = strtoupper(explode("kuma_wps_", $dbs)[1]);

    closeDB($db);
?>