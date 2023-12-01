<?php
    require("./clsfunction.php");

    $db = openDB();

    $set = getSett();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    
    $lsaw = getSawProFrmTo($tgl, $tgl);

    $lssaw = array();
    for($i = 0; $i < count($lsaw); $i++)
        $lssaw[count($lssaw)] = getSawItem3($lsaw[$i][5]);

    closeDB($db);
    
    echo json_encode(array('tgl' => array(date('d/m/Y', strtotime($tgl))), 'lsaw' => $lsaw, 'lssaw' => $lssaw, 'count' => array(count($lsaw)), 'dte' => array(date('d/m/Y', strtotime($tgl)))));
?>