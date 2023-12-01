<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));
    $cut = trim(mysqli_real_escape_string($db, $_POST["cut"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($name,"") == 0 || strcasecmp($cut,"") == 0)
        $err = -1;
    else if(countKatesID($id, $db) > 0)
        $err = -2;
    else
        newKates($id, $name, $cut, $db);
        
    $nid = setID(getLastIDKates($db) + 1, 3);

    closeDB($db);

    echo json_encode(array('err' => array($err), 'nid' => array($nid)));
?>