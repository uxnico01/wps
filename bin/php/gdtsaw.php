<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getSawID($id);
    $data2 = getSawItem($id);
    $data3 = getSawItem2($id);

    if(strcasecmp($data[3], "") != 0)
        $pro = getProID($data[3]);
    else
        $pro = array("", "", "", "", "", "", "");

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    $aks = array(CekAksUser(substr($duser[7],77,1)), CekAksUser(substr($duser[7],78,1)));

    if(strcasecmp($data[1], date('Y-m-d')) == 0 && strcasecmp($data[2], $duser[0]) == 0)
        $aks[0] = true;

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'data3' => $data3, 'pro' => $pro, 'count' => array(count($data2), count($data3)), 'aks' => $aks));
?>