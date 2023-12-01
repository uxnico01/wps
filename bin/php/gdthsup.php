<?php
    require("./clsfunction.php");

    $db = openDB();

    $sup = trim(mysqli_real_escape_string($db, $_POST["sup"]));
    $grade = trim(mysqli_real_escape_string($db, $_POST["grade"]));
    $sat = trim(mysqli_real_escape_string($db, $_POST["sat"]));

    $data = getHSupID($sup, $grade, $sat);
    $data2 = getPSupID($sup, $grade, $sat);

    if(strcasecmp($data[0],"") == 0)
        $data = array("", "", "", 0);

    if(strcasecmp($data2[0],"") == 0)
        $data2 = array("", "", "", 0);

    $duser = getUserID($_SESSION["user-kuma-wps"]);

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'aks' => array(CekAksUser(substr($duser[7],64,1)), CekAksUser(substr($duser[7],65,1)), CekAksUser(substr($duser[7],135,1)))));
?>