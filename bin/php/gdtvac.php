<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));

    $data = getVacID($id);
    $data2 = getVacItem($id);
    $data3 = getVacItem2($id);

    if(strcasecmp($data[5],"") == 0)
    {
        $pro = array("","","","","");
        $pro2 = array("","","","","");
    }
    else
    {
        $pro = getProID($data[5]);
        $grade = getGradeID($pro[4]);
        $kate = getKateID($pro[2]);
        $skate = getSKateID($pro[3]);

        $pro = array($pro[0], $pro[1], $grade[1], $kate[1], $skate[1]);
        
        $pro2 = getProID($data[15]);
        $grade = getGradeID($pro2[4]);
        $kate = getKateID($pro2[2]);
        $skate = getSKateID($pro2[3]);

        $pro2 = array($pro2[0], $pro2[1], $grade[1], $kate[1], $skate[1]);
    }

    $duser = getUserID($_SESSION["user-kuma-wps"]);
    $aks = array(CekAksUser(substr($duser[7],73,1)), CekAksUser(substr($duser[7],74,1)));

    if(strcasecmp($data[1], date('Y-m-d')) == 0 && strcasecmp($data[4], $duser[0]) == 0){
        $aks[0] = true;
    }

    $lgrade = getBBCutGrade($data[3], $db);

    $hgrd = "<option =\"\">Tanpa Grade</option>";

    for($i = 0; $i < count($lgrade); $i++){
        $hgrd .= "<option value=\"".$lgrade[$i][0]."\">".$lgrade[$i][1]."</option>";
    }

    closeDB($db);

    echo json_encode(array('data' => $data, 'data2' => $data2, 'data3' => $data3, 'pro' => $pro, 'pro2' => $pro2, 'count' => array(count($data2), count($data3)), 'aks' => $aks, 'hgrd' => array($hgrd), 'lgrade' => $lgrade));
?>