<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));

    if(strcasecmp($tgl, "") == 0)
        $tgl = date('Y-m-d');
        
    $nnsmpl = (int)getLastSampleCut($tgl) + 1;

    closeDB($db);

    echo json_encode(array('data' => array($nnsmpl)));
?>