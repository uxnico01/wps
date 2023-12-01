<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getMPID($id);
    $data2 = getMPItem($id);
    $data3 = getMPItem2($id);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
    $aks = array(CekAksUser(substr($duser[7],130,1)), CekAksUser(substr($duser[7],131,1)));

    if(strcasecmp($data[2], $duser[0]) == 0 && strcasecmp($data[1], date('Y-m-d')) == 0)
        $aks[0] = true;

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'data3' => $data3, 'count' => array(count($data2), count($data3)), 'aks' => $aks));
?>