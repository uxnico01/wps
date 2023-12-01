<?php
    require("./clsfunction.php");

    $db = openDB();

    $trm = getAllTrmVerif();
    $cut = getAllCutVerif();
    $vac = getAllVacVerif();
    $saw = getAllSawVerif();
    $tt = getAllTTVerif();
    $pjm = getAllPjmVerif();
    $krm = getAllKirimVerif();
    $mp = getAllMPVerif();
    $wd = getAllWdVerif();

    $arr = array($trm, $cut, $vac, $saw, $tt, $pjm, $krm, $mp, $wd);
    $arr2 = array(count($trm), count($cut), count($vac), count($saw), count($tt), count($pjm), count($krm), count($mp), count($wd));

    closeDB($db);

    echo json_encode(array('data' => $arr, 'count' => $arr2));
?>