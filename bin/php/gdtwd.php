<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getWdID($id);

    $sup = getSupID($data[1]);
    $ssmpn = getSumSupSmpn($sup[0]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'sup' => $sup, 'ssmpn' => array((double)$ssmpn+$data[3]+$sup[10]), 'aks' => array(CekAksUser(substr($duser[7],109,1)))));
?>