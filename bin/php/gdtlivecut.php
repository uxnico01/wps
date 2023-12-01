<?php
    require("./clsfunction.php");

    $db = openDB();

    $set = getSett();

    $tmrgn = "";

    if(strcasecmp($set[0][1],"1") == 0)
        $tmrgn = "<";
    else if(strcasecmp($set[0][1],"2") == 0)
        $tmrgn = ">";

    $tgl = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_POST["tgl"]))));

    $ltrm = array();
    $lcut = array();
    $lvac = array();
    $lfrz = array();
    $ltgl = array();
    $lket = array();
    $lwrn = array();
    $lvaccut = array();

    for($i = 0; $i < 10; $i++)
    {
        $tgls = date('Y-m-d', strtotime($tgl."-".$i."day"));

        $trm = getSumTrmFrmTo2($tgls, $tgls);
        $cut = getSumCutFrmTo2($tgls, $tgls);
        $frz = getSumFrzFrmTo($tgls, $tgls);
        $vac = getSumVacFrmTo2($tgls, $tgls);
        $vac2 = getSumVacCutFrmTo($tgls, $tgls);
        $kets = getListCutVac($tgls);
        $lvc = getSumVacCutFrmTo2($tgls, $tgls);

        if($trm[1] == 0)
            continue;

        for($j = 0; $j < count($lvc); $j++){
            $lvc[$j][0] = date('d/m/Y', strtotime($lvc[$j][0]));
        }

        $ltrm[count($ltrm)] = $trm;
        $lcut[count($lcut)] = $cut;
        $lfrz[count($lfrz)] = $frz;
        $ltgl[count($ltgl)] = date('d/m/Y', strtotime($tgls));
        $lket[count($lket)] = $kets;
        $lvac[count($lvac)] = array($vac, $vac2);
        $lvaccut[count($lvaccut)] = $lvc;

        $text = "";
        if((($trm[1] != $cut[1] || (strcasecmp($set[0][1],"1") == 0 && $cut[0]/$trm[0] >= $set[0][2]) || (strcasecmp($set[0][1],"2") == 0 && $cut[0]/$trm[0] <= $set[0][2]))) || ($vac == 0 && $cut[0] != 0 && count($lvc) > 0))
            $text = "text-danger";

        $lwrn[count($lwrn)] = $text;
    }

    closeDB($db);
    echo $sql;
    echo json_encode(array('ltgl' => $ltgl, 'ltrm' => $ltrm, 'lket' => $lket, 'lcut' => $lcut, 'lfrz' => $lfrz, 'lwrn' => $lwrn, 'lvac' => $lvac, 'count' => array(count($ltgl)), 'set' => array($tmrgn, $set[0][2]), 'dte' => array(date('d/m/Y', strtotime($tgl))), 'lv' => $lvaccut));
?>