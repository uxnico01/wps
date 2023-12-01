<?php
    require("./clsfunction.php");

    $db = openDB();

    $set = getSett();

    $type = trim(mysqli_real_escape_string($db, $_POST["type"]));
    $po = trim(mysqli_real_escape_string($db, $_POST["po"]));
    
    $lpo = getAllPO();
    
    if(strcasecmp($type,"1") == 0)
        $lpo = array(getPOID($po));

    $ldpo = array();
    for($i = 0; $i < count($lpo); $i++)
        $ldpo[count($ldpo)] = getKirimItemPO($lpo[$i][0]);

    closeDB($db);
    
    echo json_encode(array('lpo' => $lpo, 'ldpo' => $ldpo, 'count' => array(count($lpo))));
?>