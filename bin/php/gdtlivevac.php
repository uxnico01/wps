<?php
    require("./clsfunction.php");

    $db = openDB();

    $set = getSett();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    
    $scut = (double)getSumCutFrmTo($tgl, $tgl);
    $lscut = getVacCutFrmTo($tgl, $tgl);
    $lvac = getVacProFrmTo($tgl, $tgl);
    $lvacc = getVacProFrmTo2($tgl, $tgl);

    $lsvac = array();
    for($i = 0; $i < count($lvac); $i++)
        $lsvac[count($lsvac)] = getVacItem3($lvac[$i][5]);

    $lsvacc = array();
    for($i = 0; $i < count($lvacc); $i++)
        $lsvacc[count($lsvacc)] = getVacItem4($tgl, $tgl, $lvacc[$i][0]);

    closeDB($db);
    
    echo json_encode(array('tgl' => array(date('d/m/Y', strtotime($tgl))), 'lscut' => $lscut, 'lvac' => $lvac, 'lvacc' => $lvacc, 'lsvac' => $lsvac, 'lsvacc' => $lsvacc, 'count' => array(count($lvacc), count($lvac)), 'scut' => array($scut), 'dte' => array(date('d/m/Y', strtotime($tgl)))));
?>