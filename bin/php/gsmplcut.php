<?php
    require("./clsfunction.php");
    
    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    
    closeDB($db);

    echo json_encode(array('nsmpl' => array((int)getLastSampleCut($tgl) + 1)));
?>