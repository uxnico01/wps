<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getMoveID($id, $db);
    $dtl = getMoveItem($id, $db);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
    $aks = array(CekAksUser(substr($duser[7],165,1)));

    if(strcasecmp($data[3],date('Y-m-d')) == 0 && strcasecmp($data[7], $duser[0]) == 0)
        $aks[0] = true;

    closeDB($db);

    echo json_encode(array('data' => $data, 'dtl' => $dtl, 'count' => array(count($dtl)), 'aks' => $aks));
?>