<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["sup"]));
    
    $ldata = json_decode($_POST["ldata"]);

    for($i = 0; $i < count($ldata); $i++)
    {
        if(countHSup($id, $ldata[$i][0], $ldata[$i][1]) == 0)
            newHSup($id, $ldata[$i][0], $ldata[$i][1], $ldata[$i][2]);
        else
            updHSup($id, $ldata[$i][0], $ldata[$i][1], $ldata[$i][2]);
    }

    closeDB($db);
?>