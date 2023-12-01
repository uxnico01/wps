<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getProID($id);
    $kate = getKateID($data[2]);
    $skate = getSKateID($data[3]);
    $grade = getGradeID($data[4]);

    if(strcasecmp($data[2],"") == 0)
        $kate = array("", "", "");

    if(strcasecmp($data[3],"") == 0)
        $skate = array("", "", "");

    closeDB($db);

    echo json_encode(array('data' => $data, 'count' => array(count($data)), 'kate' => $kate, 'skate' => $skate, 'grade' => $grade));
?>