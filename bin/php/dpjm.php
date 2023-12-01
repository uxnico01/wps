<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getPjmID($id);

    $err = 0;
    if($data[4] > 0)
        $err = -1;
    else
    {
        $data = getPjmID($id);
        
        delPjm($id);
        
        $aw = "HPJM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHPjm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHPjm($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], "", "", "", "", "",  "", "", "", "", "", $_SESSION["user-kuma-wps"], "DELETE", date('Y-m-d H:i:s'), $data[12], "");
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>