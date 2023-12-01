<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    if(strcasecmp($id,"") == 0)
        $data = getAllMove($db);
    else
        $data = schMove($id, $db);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'aks' => array(CekAksUser(substr($duser[7],165,1)), CekAksUser(substr($duser[7],166,1)))));
?>