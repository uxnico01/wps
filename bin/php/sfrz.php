<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = schFrz($id);
    $data2 = array();

    for($i = 0; $i < count($data); $i++)
    {
        $data2[count($data2)] = getFrzItem2($data[$i][0]);
    }

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'count' => array(count($data)), 'aks' => array(cekAksUser(substr($duser[7],140,1)), cekAksUser(substr($duser[7],141,1)))));
?>