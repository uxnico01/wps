<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = schSaw($id);
    $data2 = array();

    for($i = 0; $i < count($data); $i++)
    {
        $data2[count($data2)] = getSawItem3($data[$i][0]);
    }

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'count' => array(count($data)), 'aks' => array(CekAksUser(substr($duser[7],76,1)), CekAksUser(substr($duser[7],77,1)), CekAksUser(substr($duser[7],120,1)))));
?>