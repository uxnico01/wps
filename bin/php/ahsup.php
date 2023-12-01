<?php

use function Complex\ln;

    require("./clsfunction.php");

    $db = openDB();

    $tsup = trim(mysqli_real_escape_string($db, $_POST["tsup"]));
    $tgrade = trim(mysqli_real_escape_string($db, $_POST["tgrade"]));
    $tsat = trim(mysqli_real_escape_string($db, $_POST["tsat"]));
    $jns = trim(mysqli_real_escape_string($db, $_POST["jns"]));
    $jlh = trim(mysqli_real_escape_string($db, $_POST["jlh"]));
    $prb = trim(mysqli_real_escape_string($db, $_POST["prb"]));
    $blsup = json_decode($_POST["lsup"]);
    $blgrade = json_decode($_POST["lgrade"]);
    $blsat = json_decode($_POST["lsat"]);

    $lsup = array();
    $lgrade = array();
    $lsat = array();
    $lgsup = array();
    for($i = 0; $i < count($blsup); $i++){
        if(countSupID($blsup[$i]) == 0)
            continue;

        array_push($lsup, $blsup[$i]);
    }

    for($i = 0; $i < count($blgrade); $i++){
        if(countGradeID($blgrade[$i][0]) == 0)
            continue;

        array_push($lgrade, $blgrade[$i][0]);
        array_push($lgsup, $blgrade[$i][1]);
    }

    for($i = 0; $i < count($blsat); $i++){
        if(countSatuanID($blsat[$i]) == 0)
            continue;

        array_push($lsat, $blsat[$i]);
    }

    $err = 0;
    if((strcasecmp($tsup,"2") == 0 && count($lsup) == 0) || (strcasecmp($tgrade,"2") == 0 && count($lgrade) == 0) || (strcasecmp($tsat,"2") == 0 && count($lsat) == 0) || strcasecmp($jns,"") == 0 || ((double)$jlh == 0 && strcasecmp($prb,"1") == 0) || (strcasecmp($prb,"2") == 0 && count($blgrade) == 0) || strcasecmp($prb,"") == 0){
        $err = -1;
    }
    else{
        $wsup = "(";
        $wgrade = "(";
        $wsat = "(";

        if(strcasecmp($tsup,"1") == 0){
            $lsup = getAllSupID();
        }

        if(strcasecmp($tgrade,"1") == 0){
            $lgrade = getAllGradeID();
        }

        if(strcasecmp($tsat,"1") == 0){
            $lsat = getAllSatuanID();
        }

        for($i = 0; $i < count($lsup); $i++){
            if($i > 0){
                $wsup .= " || ";
            }

            $wsup .= "IDSUP = '".$lsup[$i]."'";
        }
        $wsup .= ")";

        for($i = 0; $i < count($lgrade); $i++){
            if($i > 0){
                $wgrade .= " || ";
            }

            $wgrade .= "IDGRADE = '".$lgrade[$i]."'";
        }
        $wgrade .= ")";

        for($i = 0; $i < count($lsat); $i++){
            if($i > 0){
                $wsat .= " || ";
            }

            $wsat .= "IDSAT = '".$lsat[$i]."'";
        }
        $wsat .= ")";

        updAHSup($wsup, $wgrade, $wsat, $jns, $jlh, $prb, $lgsup, $lgrade, $db);
    }

    closeDB($db);

    echo json_encode(array('err' => array($err)));
?>