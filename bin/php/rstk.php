<?php
    require("./clsfunction.php");

    $db = openDB();

    repairStk($db);

    closeDB($db);
?>