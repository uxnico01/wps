<?php
    require("./clsfunction.php");

    session_destroy();

    header("Location: ../../login");
?>