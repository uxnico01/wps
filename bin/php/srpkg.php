<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = array();
    $data2 = array();
    if(strcasecmp($id,"") == 0)
        $data = getAllRPkg($db);
    else
        $data = schRPkg($id, $db);

    for($i = 0; $i < count($data); $i++){
        $data2[$i] = getRPkgItem($data[$i][8], $db);
    }

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'count' => array(count($data)), 'aks' => array(CekAksUser(substr($duser[7],174,1)), CekAksUser(substr($duser[7],175,1)))));
?>