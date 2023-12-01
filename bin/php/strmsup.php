<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $tgl = trim(mysqli_real_escape_string($db, $_POST["tgl"]));

    $data = getAllTrmSupNC($id, $tgl);

    $data2 = "{";
    for($i = 0; $i < count($data); $i++)
        $data2 .= "\"".$data[$i][2]." | ".$data[$i][3]." | ".$data[$i][1]." | ".$data[$i][0]." | ".$data[$i][4]."\":\"".$data[$i][0]."|".$data[$i][5]."|".$data[$i][6]."\",";

    $data2 .= "}";
    
    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => array($data2), 'count' => array(count($data))));
?>