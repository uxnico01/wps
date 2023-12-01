<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = schVac($id);
    $data2 = array();

    for($i = 0; $i < count($data); $i++)
    {
        $data2[count($data2)] = getVacItem3($data[$i][0]);
    }

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'count' => array(count($data)), 'aks' => array(CekAksUser(substr($duser[7],73,1)), CekAksUser(substr($duser[7],74,1)), CekAksUser(substr($duser[7],121,1)))));
?>