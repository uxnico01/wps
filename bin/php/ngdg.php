<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));
    $addr = trim(mysqli_real_escape_string($db, $_POST["addr"]));
    $pic = trim(mysqli_real_escape_string($db, $_POST["pic"]));
    $hp = trim(mysqli_real_escape_string($db, $_POST["hp"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($name,"") == 0)
        $err = -1;
    else if(countGdgID($id, $db) > 0)
        $err = -2;
    else{
        newGdg($id, $name, $addr, $pic, $hp, $db);

        $lpro = getAllPro("2");

        for($i = 0; $i < count($lpro); $i++){
            newGdgPro($id, $lpro[$i][0], 0, $db);
        }
    }
        
    $nid = setID((int)getLastGdgID($db) + 1, 3);

    closeDB($db);

    echo json_encode(array('err' => array($err), 'nid' => array($nid)));
?>