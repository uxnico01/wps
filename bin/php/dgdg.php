<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;
    if(countGdgTrm($id, $db) > 0 || countGdgCut($id, $db) > 0 || countGdgSaw($id, $db) > 0 || countGdgVac($id, $db) > 0 || countGdgFrz($id, $db) > 0 || countGdgKirim($id, $db) > 0 || countGdgMP($id, $db) > 0 || countGdgPs($id, $db) > 0 || countGdgSett($id, $db) > 0 || countGdgMove($id, $db) > 0 || countGdgPO($id, $db) > 0)
        $err = -1;
    else
        delGdg($id, $db);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>