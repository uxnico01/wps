<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;

    if(countUserIDTT($id) > 0 || countUserIDPjm($id) > 0 || countUserIDKrm($id) > 0 || countUserIDTrm($id) > 0 || countUserIDCut($id) > 0 || countUserIDVac($id) > 0 || countUserIDSaw($id) > 0 || countUserIDMove($id) > 0)
        $err = -1;
    else
        delUser($id);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>