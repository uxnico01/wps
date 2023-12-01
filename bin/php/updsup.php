<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["supD"]));
    
    $lDData = json_decode($_POST["lDData"]);

    $cek = 0;

    for($i = 0; $i < count($lDData); $i++)
    {
        $lDData[$i][0] = trim(mysqli_real_escape_string($db, $lDData[$i][0]));
        $lDData[$i][1] = trim(mysqli_real_escape_string($db, $lDData[$i][1]));
        $lDData[$i][2] = trim(mysqli_real_escape_string($db, $lDData[$i][2]));
        $lDData[$i][3] = trim(mysqli_real_escape_string($db, $lDData[$i][3]));
        $lDData[$i][4] = trim(mysqli_real_escape_string($db, $lDData[$i][4]));
        $lDData[$i][5] = trim(mysqli_real_escape_string($db, $lDData[$i][5]));
        if(countDPSup($id, $lDData[$i][1], $lDData[$i][2], $lDData[$i][0], $lDData[$i][5], $db) == 0)
        {
            $cek = -1;
            newDPSup($id, $lDData[$i][2], $lDData[$i][1], $lDData[$i][4], $lDData[$i][0], $lDData[$i][5], $db);
        }
        else
        {
            updDPSup($id, $lDData[$i][2], $lDData[$i][1], $lDData[$i][4], $lDData[$i][0], $lDData[$i][5], $db);
            $cek = -2;
        }
    }

    closeDB($db);

    echo json_encode(array('cek' => array($cek)));
?>
