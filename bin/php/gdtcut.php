<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getCutID($id);
    $data2 = getCutItem($id);
    $data3 = getCutPro($id, $db);
    $data4 = getCutNPro($id, $db);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
    $aks = array(cekAksUser(substr($duser[7],69,1)), cekAksUser(substr($duser[7],70,1)));

    if(strcasecmp($data[1],date('Y-m-d')) == 0 && strcasecmp($data[3], $duser[0]) == 0)
        $aks[0] = true;

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'data3' => $data3, 'data4' => $data4, 'count' => array(count($data2)), 'aks' => $aks));
?>