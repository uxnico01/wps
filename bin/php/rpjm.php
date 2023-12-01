<?php
    require("./clsfunction.php");

    $db = openDB();

    repairPjm();

    closeDB($db);
?>