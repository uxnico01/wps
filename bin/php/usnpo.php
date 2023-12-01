<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    updPOStat($id, "NS", "", "");
    updQtyProKirim();

    closeDB($db);
?>