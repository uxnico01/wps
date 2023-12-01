<?php
    require("./clsfunction.php");

    $db = openDB();

    $type = "1";
    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    if(isset($_POST["type"])){
        $type = trim(mysqli_real_escape_string($db, $_POST["type"]));
    }

    $data = schPO($id, $type);

    if(isset($_SESSION["user-kuma-wps"]))
    {
        $duser = getUserID($_SESSION["user-kuma-wps"]);
        $aks = array(cekAksUser(substr($duser[7],125,1)), cekAksUser(substr($duser[7],126,1)));
    }
    else
        $aks = array(false, false);

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'aks' => $aks));
?>