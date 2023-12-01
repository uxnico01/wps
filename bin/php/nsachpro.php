<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    if(countEmptySetLike("ASCHPRO", $db) > 0){
        $set = getEmptySetLike("ASCHPRO", $db);
        
        updSettID($set, "", $id, $db);
        $data = array($set);
    }
    else{
        $lid = getLastIDSet("ASCHPRO", $db);
        $n = (int)substr($lid, strlen("ASCHPRO")) + 1;
        newSettID("ASCHPRO".$n, "", $id, $db);
        $data = array("ASCHPRO".$n);
    }

    closeDB($db);

    echo json_encode(array('data' => $data));
?>