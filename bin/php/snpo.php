<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $gdg = trim(mysqli_real_escape_string($db, $_POST["gdg"]));
    $tt = trim(mysqli_real_escape_string($db, $_POST["tt"]));

    $lpro = array();
    $err = 0;
    if(strcasecmp($gdg,"") == 0 || strcasecmp($tt,"") == 0){
        $err = -2;
    }
    else if(countGdgID($gdg, $db) == 0){
        $err = -3;
    }
    else{
        $dtl = getPOItem2($id, $db);

        for($i = 0; $i < count($dtl); $i++){
            $sisa = getQGdgPro($gdg, $dtl[$i][0], $db);
            
            if((double)$dtl[$i][5] > (double)$sisa){
                $lpro[count($lpro)] = array($dtl[$i][1], $dtl[$i][5], $sisa);
                $err = -1;
                break;
            }
        }

        if($err == 0){
            updPOStat($id, "SN", $gdg, $tt);
            updQtyProKirim();
        }
    }

    closeDB($db);

    echo json_encode(array('err' => array($err), 'lpro' => $lpro));
?>