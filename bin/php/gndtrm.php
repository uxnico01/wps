<?php
    require("./clsfunction.php");

    $db = openDB();
    
    $sup = getAllSup();
    $pro = getAllPro("2", "TRM");
    $sat = getAllSatuan();

    closeDB($db);

    echo json_encode(array('sup' => $sup, 'pro' => $pro, 'sat' => $sat));
?>