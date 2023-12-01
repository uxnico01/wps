<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $bid = trim(mysqli_real_escape_string($db, $_POST["bid"]));
    $name = trim(mysqli_real_escape_string($db, $_POST["name"]));
    $kate = trim(mysqli_real_escape_string($db, $_POST["kate"]));
    $skate = trim(mysqli_real_escape_string($db, $_POST["skate"]));
    $grade = trim(mysqli_real_escape_string($db, $_POST["grade"]));
    $qawl = trim(mysqli_real_escape_string($db, $_POST["qawl"]));
    $strm = trim(mysqli_real_escape_string($db, $_POST["strm"]));
    $scut = trim(mysqli_real_escape_string($db, $_POST["scut"]));
    $svac = trim(mysqli_real_escape_string($db, $_POST["svac"]));
    $ssaw = trim(mysqli_real_escape_string($db, $_POST["ssaw"]));
    $spkg = trim(mysqli_real_escape_string($db, $_POST["spkg"]));
    $smp = trim(mysqli_real_escape_string($db, $_POST["smp"]));
    $sfrz = trim(mysqli_real_escape_string($db, $_POST["sfrz"]));
    $hsell = trim(mysqli_real_escape_string($db, $_POST["hsell"]));
    $kates = trim(mysqli_real_escape_string($db, $_POST["kates"]));
    $gol = trim(mysqli_real_escape_string($db, $_POST["gol"]));
    $katej = trim(mysqli_real_escape_string($db, $_POST["katej"]));

    $err = 0;

    if(strcasecmp($id,"") == 0 || strcasecmp($name,"") == 0 || strcasecmp($grade,"") == 0)
        $err = -1;
    else if(countProID($id) > 0 && strcasecmp($bid, $id) != 0)
        $err = -2;
    else if(countProID($bid) == 0)
        $err = -3;
    else if(countKateID($kate) == 0 && strcasecmp($kate,"") != 0)
        $err = -4;
    else if(countSKateID($skate) == 0 && strcasecmp($skate,"") != 0)
        $err = -5;
    else if(countGradeID($grade) == 0)
        $err = -6;
    else if(countKatesID($kates, $db) == 0 && strcasecmp($kates,"") != 0)
        $err = -7;
    else if(countGolID($gol, $db) == 0 && strcasecmp($gol,"") != 0)
        $err = -8;
    else if(countKatejID($katej, $db) == 0 && strcasecmp($katej,"") != 0)
        $err = -9;
    else
        updPro($id, $name, $kate, $skate, $grade, $bid, $qawl, $strm, $scut, $svac, $ssaw, $spkg, $smp, $sfrz, $hsell, $kates, $gol, $katej);

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>