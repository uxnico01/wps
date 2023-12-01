<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getSupID($id);
    $data2 = getSupHSup($id);
    $data3 = getSupPSup($id);

    $spjm = getSumSupPjm($id);
    $ssmpn = getSumSupSmpn($id);

    $vmin = getMinTrmSup($id);

    if($vmin > 0)
        $vmin = 0;
    else
        $vmin = sqrt(pow($vmin,2));

    closeDB($db);

    echo json_encode(array('data' => $data, 'spjm' => array((double)$spjm), 'ssmpn' => array((double)$data[10]+$ssmpn), 'data2' => $data2, 'data3' => $data3, 'count' => array(count($data2), count($data3)), 'vmin' => array($vmin)));
?>