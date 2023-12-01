<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    if(countEmptySetLike("ASCHNPRO", $db) > 0){
        $set = getEmptySetLike("ASCHNPRO", $db);

        updSettID($set, "", $id, $db);
        $data = array($set);
    }
    else{
        $lid = getLastIDSet("ASCHNPRO", $db);
        $n = (int)substr($lid, strlen("ASCHNPRO")) + 1;
        newSettID("ASCHNPRO".$n, "", $id, $db);
        $data = array("ASCHNPRO".$n);
    }

    closeDB($db);

    echo json_encode(array('data' => $data));
?>