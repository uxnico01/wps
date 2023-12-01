<?php
    require("./clsfunction.php");

    $db = openDB();

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));
    $pro = trim(mysqli_real_escape_string($db, $_POST["pro"]));
    $utrm = trim(mysqli_real_escape_string($db, $_POST["utrm"]));
    $cut1 = trim(mysqli_real_escape_string($db, $_POST["cut1"]));
    $cut2 = trim(mysqli_real_escape_string($db, $_POST["cut2"]));
    $cut3 = trim(mysqli_real_escape_string($db, $_POST["cut3"]));
    $cut4 = trim(mysqli_real_escape_string($db, $_POST["cut4"]));
    $cut5 = trim(mysqli_real_escape_string($db, $_POST["cut5"]));
    $cut6 = trim(mysqli_real_escape_string($db, $_POST["cut6"]));
    $scut1 = trim(mysqli_real_escape_string($db, $_POST["scut1"]));
    $scut2 = trim(mysqli_real_escape_string($db, $_POST["scut2"]));
    $scut3 = trim(mysqli_real_escape_string($db, $_POST["scut3"]));
    $scut4 = trim(mysqli_real_escape_string($db, $_POST["scut4"]));
    $scut5 = trim(mysqli_real_escape_string($db, $_POST["scut5"]));
    $scut6 = trim(mysqli_real_escape_string($db, $_POST["scut6"]));
    $ket = trim(mysqli_real_escape_string($db, $_POST["ket"]));
    $trm = trim(mysqli_real_escape_string($db, $_POST["trm"]));
    $nsmpl = trim(mysqli_real_escape_string($db, $_POST["nsmpl"]));
    $nnsmpl = $nsmpl + 1;
    $cpro1 = "";
    $cpro2 = "";
    $cpro3 = "";
    $cpro4 = "";
    $suhu = "N";
    $pr = "N";

    if(isset($_POST["cpro1"]))
        $cpro1 = trim(mysqli_real_escape_string($db, $_POST["cpro1"]));
    
    if(isset($_POST["cpro2"]))
        $cpro2 = trim(mysqli_real_escape_string($db, $_POST["cpro2"]));
    
    if(isset($_POST["cpro3"]))
        $cpro3 = trim(mysqli_real_escape_string($db, $_POST["cpro3"]));
    
    if(isset($_POST["cpro4"]))
        $cpro4 = trim(mysqli_real_escape_string($db, $_POST["cpro4"]));

    if(isset($_POST["berat"]))
        $berat = trim(mysqli_real_escape_string($db, $_POST["berat"]));
    else
        $berat = getWeightTrmItemID($trm, $pro, $utrm);
    
    if(isset($_POST["suhu"]))
        $suhu = trim(mysqli_real_escape_string($db, $_POST["suhu"]));
    
    if(isset($_POST["pr"]))
        $pr = trim(mysqli_real_escape_string($db, $_POST["pr"]));
        
    $id = "";
    $urut = 0;
    $tcut = (float)$cut1 + (float)$cut2 + (float)$cut3 + (float)$cut4 + (float)$cut5 + (float)$cut6;
    
    $err = 0;
    if(strcasecmp($tgl,"") == 0 || strcasecmp($pro,"") == 0 || strcasecmp($berat,"") == 0 || $berat < 0)
        $err = -1;
    else if(countTrmID($trm) == 0 || countTrmItemID($trm, $pro, $utrm) == 0)
        $err = -2;
    else if(countCutItemTrm($trm, $pro, $utrm) > 0)
        $err = -3;
    else if((strcasecmp($scut1,"Dll") == 0 && countProID($cpro1) == 0) || (strcasecmp($scut2,"Dll") == 0 && countProID($cpro2) == 0) || (strcasecmp($scut3,"Dll") == 0 && countProID($cpro3) == 0) || (strcasecmp($scut4,"Dll") == 0 && countProID($cpro4) == 0))
        $err = -4;
    else if($berat < $tcut)
        $err = -5;
    else if(countCutNoSample($tgl, $nsmpl, $db) > 0){
        $err = -6;
    }
    else
    {
        $id = getCutIDTgl($tgl);
        $user = $_SESSION["user-kuma-wps"];
        $wkt = date('Y-m-d H:i:s');
        $set = getSett();
        $cek = true;
        if(countCutTgl($tgl) == 0)
        {
            $cek = false;
            $aw = "TC/";
            $ak = date('/my');

            $id = $aw.setID((int)substr(getLastIDCut($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

            newCut($id, $tgl, $set[0][2], $user, $wkt, $set[0][1], $set[3][3]);
        }

        $aw = "HCUT/";
        $ak = date('/my');
        $hid = $aw.setID((int)substr(getLastIDHCut($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        $data = getCutID($id);
        $data2 = getCutItem($id);
        
        if(!$cek)
            newHstCut($hid, "", "", "", "", "", "", $id, $data[1], $data[2], $user, $data[4], $data[7], $user, date('Y-m-d H:i:s'), "NEW", "", $set[3][3]);
        else
            $hid = getCutHIDTgl($tgl);
        /*else
            newHstCut($hid, $id, $data[1], $data[2], $data[3], $data[4], $data[7], $id, $data[1], $data[2], $user, $data[4], $data[7], $user, date('Y-m-d H:i:s'), "NEW");

        for($i = 0; $i < count($data2); $i++)
        {
            newHstDtlCut($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], $data2[$i][8], $data2[$i][9], $data2[$i][10], $data2[$i][11], "B", $data2[$i][16], $data2[$i][17], $data2[$i][18], $data2[$i][19], $data2[$i][20], $data2[$i][21], $data2[$i][22]);

            newHstDtlCut($hid, $id, $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], $data2[$i][8], $data2[$i][9], $data2[$i][10], $data2[$i][11], "A", $data2[$i][16], $data2[$i][17], $data2[$i][18], $data2[$i][19], $data2[$i][20], $data2[$i][21], $data2[$i][22]);
        }*/

        $urut = getLastUrutCut($id) + 1;
        newDtlCut($id, $pro, $cut1, $cut2, $cut3, $cut4, $cut5, $cut6, $urut, $trm, $utrm, $berat, $scut1, $scut2, $scut3, $scut4, $scut5, $scut6, $ket, $nsmpl, $cpro1, $cpro2, $cpro3, $cpro4, "", "", $suhu, $pr);
        newHstDtlCut($hid, $id, $pro, $cut1, $cut2, $cut3, $cut4, $cut5, $cut6, $urut, $trm, $utrm, $berat, "A", $scut1, $scut2, $scut3, $scut4, $scut5, $scut6, $ket, $nsmpl, $cpro1, $cpro2, $cpro3, $cpro4, "", "", $suhu, $pr);

        $nnsmpl = (int)getLastSampleCut($tgl) + 1;

        updQtyProCut($id);

        if(strcasecmp($scut1,"Dll") == 0 || strcasecmp($scut2,"Dll") == 0 || strcasecmp($scut3,"Dll") == 0 || strcasecmp($scut4,"Dll") == 0)
            updQtyProCut2($id);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'nsmpl' => array($nnsmpl), 'data' => array($id, $urut)));
?>