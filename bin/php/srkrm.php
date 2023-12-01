<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    if(strcasecmp($id,"") == 0)
        $data = getAllRKirim($db);
    else
        $data = schRKirim($id, $db);

    $dtl = array();
    for($i = 0; $i < count($data); $i++){
        array_push($dtl, getRKirimItem($data[$i][0], $db));
    }

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'dtl' => $dtl, 'count' => array(count($data)), 'aks' => array(CekAksUser(substr($duser[7],191,1)), CekAksUser(substr($duser[7],192,1)))));
?>