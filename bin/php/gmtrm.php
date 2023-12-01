<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));
    $lmt = date('Y-m-d', strtotime("-3day".date('Y-m-d')));

    $data = array();
    $err = 0;
    if($tgl < $lmt)
        $err = -1;
    else
        $data = getTrmFrmTo6($tgl, $tgl);

    closeDB($db);

    echo json_encode(array('err' => array($err), 'data' => $data, 'count' => array(count($data))));
?>