<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));

    $data = getHCutTgl($tgl);
    $lgrade = getBBCutGrade($tgl, $db);

    $hgrd = "<option =\"\">Tanpa Grade</option>";

    for($i = 0; $i < count($lgrade); $i++){
        $hgrd .= "<option value=\"".$lgrade[$i][0]."\">".$lgrade[$i][1]."</option>";
    }
    
    closeDB($db);

    echo json_encode(array('data' => array($data), 'hgrd' => array($hgrd)));
?>