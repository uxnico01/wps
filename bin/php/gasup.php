<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d');

    if(isset($_POST["tgl"]))
        $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));

    if(strcasecmp($tgl, "") == 0)
        $tgl = date('Y-m-d');
    
    $data = getAllSup();
    $nnsmpl = (int)getLastSampleCut($tgl) + 1;

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => array($nnsmpl, $tgl), 'count' => array(count($data))));
?>