<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db,$_POST["id"]));

    $err = 0;
    if(countProTT($id) > 0 || countProCut($id) > 0 || countProKrm($id) > 0 || countProSaw($id) > 0 || countProVac($id) > 0 || countProMP($id) > 0 || countProFrz($id) > 0 || countProPs($id) > 0 || countProMove($id) > 0 || countProHCut($id) > 0 || countProHNCut($id) > 0)
        $err = -1;
    else
        delPro($id);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>