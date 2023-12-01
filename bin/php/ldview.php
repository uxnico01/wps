<?php
    require("./clsfunction.php");

    $db = openDB();

    $trm = (float)getSumTrmFrmTo(date('Y-m-d'), date('Y-m-d'))[0];
    $cut = (float)getSumCutFrmTo(date('Y-m-d'), date('Y-m-d'));
    $vac = (float)getSumVacFrmTo(date('Y-m-d'), date('Y-m-d'));
    $saw = (float)getSumSawFrmTo(date('Y-m-d'), date('Y-m-d'));

    closeDB($db);

    echo json_encode(array('data' => array($trm, $cut, $vac, $saw)));
?>