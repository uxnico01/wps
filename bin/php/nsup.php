<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));
    $addr = trim(mysqli_real_escape_string($db, $_POST["addr"]));
    $reg = trim(mysqli_real_escape_string($db, $_POST["reg"]));
    $hp = trim(mysqli_real_escape_string($db, $_POST["hp"]));
    $hp2 = trim(mysqli_real_escape_string($db, $_POST["hp2"]));
    $mail = trim(mysqli_real_escape_string($db, $_POST["mail"]));
    $ket1 = strtoupper(trim(mysqli_real_escape_string($db, $_POST["ket1"])));
    $ket2 = trim(mysqli_real_escape_string($db, $_POST["ket2"]));
    $ket3 = trim(mysqli_real_escape_string($db, $_POST["ket3"]));
    $smpn = trim(mysqli_real_escape_string($db, $_POST["smpn"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($name,"") == 0)
        $err = -1;
    else if(countSupID($id) > 0)
        $err = -2;
    else if(strcasecmp($mail,"") != 0 && !filter_var($mail, FILTER_VALIDATE_EMAIL))
        $err = -3;
    else
        newSup($id, $name, $addr, $reg, $hp, $hp2, $mail, $ket1, $ket2, $ket3, $smpn);
        
    $nid = setID((int)getLastSupID() + 1, 3);

    closeDB($db);

    echo json_encode(array('err' => array($err), 'nid' => array($nid)));
?>