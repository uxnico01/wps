<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getPjmID($id);

    $sup = getSupID($data[1]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'sup' => $sup, 'aks' => array(CekAksUser(substr($duser[7],54,1)))));
?>