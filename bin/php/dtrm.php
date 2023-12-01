<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $err = 0;

    if(countTrmTT($id) > 0 || countTrmCut($id) > 0)
        $err = -1;
    else
    {
        $data = getTrmID($id);
        $data2 = getTrmItem($id);
        $data3 = getTrmDll($id);
        $data4 = getTrmPDll($id);
        $data5 = getTrmDP($id);
        $data6 = getTrmTDll($id);

        $aw = "HTRM/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        newHTrm($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], "", "", "", "", "", "", "", "", "", "", $_SESSION["user-kuma-wps"], date('Y-m-d H:i:s'), "DELETE", $data[12], "", $data[13], $data[14], $data[15], "", "", "", $data[17], "", $data[18], "", $data[19], "", $data[20], "", $data[21], "");

        for($i = 0; $i < count($data2); $i++)
            newHDtlTrm($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], "B", $data2[$i][5], $data2[$i][12]);

        for($i = 0; $i < count($data3); $i++)
            newHDllTrm($hid, $bid, $data3[$i][1], $data3[$i][2], $data3[$i][3], $data3[$i][4], "B");

        for($i = 0; $i < count($data4); $i++)
            newHPDllTrm($hid, $bid, $data4[$i][1], $data4[$i][2], $data4[$i][3], $data4[$i][4], "B");

        for($i = 0; $i < count($data5); $i++)
            newHDPTrm($hid, $id, $data5[$i][0], $data5[$i][1], $i+1, "B");

        for($i = 0; $i < count($data6); $i++)
            newHTDllTrm($hid, $bid, $data6[$i][1], $data6[$i][2], $data6[$i][3], $data6[$i][4], "B", $data6[$i][5], $data6[$i][6]);

        delTrm($id);

        updQtyProTrm();
        updTTrm();
        repairPjm();
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>