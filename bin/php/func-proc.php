<?php
//PROC
function getAllProcTglFrmTo($frm, $to, $gdg, $db){
    $whr = "";
    $whr2 = "";
    $whr3 = "";
    $whr4 = "";
    if(countGdgID($gdg, $db) > 0){
        $whr = " WHERE IDGDG = '$gdg'";
        $whr2 = " && IDGDG = '$gdg'";
        $whr3 = " WHERE IDGDGF = '$gdg' || IDGDGT = '$gdg'";
        $whr4 = " && P.IDGDG = '$gdg'";
    }

    $sql = "SELECT DISTINCT DATE FROM
                (SELECT DISTINCT DATE FROM prterima $whr
                UNION
                SELECT DISTINCT DATE FROM prcut $whr
                UNION
                SELECT DISTINCT DATE FROM prfill $whr
                UNION
                SELECT DISTINCT DATE FROM prsaw $whr
                UNION
                SELECT DISTINCT DATE FROM prfrz $whr
                UNION
                SELECT DISTINCT P.DATE FROM trkirim T INNER JOIN trkirim2 T2 ON T.ID = T2.ID INNER JOIN dtpo P ON T2.IDPO = P.ID WHERE P.STAT = 'SN' $whr4
                UNION
                SELECT DISTINCT DATE FROM trps $whr
                UNION
                SELECT DISTINCT DATE FROM trmove $whr3
                UNION
                SELECT DISTINCT DATE FROM trrkirim $whr
                UNION
                SELECT DISTINCT DATE FROM trrpkg $whr) TMP
            WHERE DATE >= '$frm' && DATE <= '$to' ORDER BY DATE";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GAPROCTGLFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    return $arr;
}

//PENERIMAAN
function getAllTrm()
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDUSER, WKT, KOTA, VDLL, KDLL, DP, BB2, VMIN, POTDLL, TBHDLL, MINUM, (SELECT SUM(WEIGHT) FROM prterima2 WHERE ID = P.ID), (SELECT COUNT(ID) FROM prterima2 WHERE ID = P.ID) FROM prterima P
            WHERE DATE = CURDATE() ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GATRM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllTTrm()
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE_FORMAT(DATE, '%d/%m/%Y'), BB, POTO, KET1, KET2, KET3, IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i'), KOTA, VDLL, KDLL, DP, VMIN, POTDLL, TBHDLL, MINUM FROM prterima_tmp
            WHERE IDUSER = '".$_SESSION["user-kuma-wps"]."' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GATTRM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $sup = getSupID($row[1]);
        $row[1] = $sup[1];
        $arr[count($arr)] = $row;
    }

    closeDB($db);

    return $arr;
}

function getAllTrmNTT()
{
    $db = openDB();

    $sql = "SELECT P.ID, P.IDSUP, P.DATE, P.BB, P.POTO, P.KET1, P.KET2, P.KET3, P.IDUSER, P.WKT FROM prterima P LEFT JOIN trtt T ON P.ID = T.IDTERIMA
            WHERE T.IDTERIMA = '' || T.IDTERIMA IS NULL ORDER BY P.DATE, P.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GATRMNTT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllTrmVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM prterima
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GATRMVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllTrmSupNC($id, $tgl)
{
    $db = openDB();

    $sql = "SELECT T.ID, DATE_FORMAT(T.DATE, '%d/%m/%Y'), P.NAME, G.NAME, T2.WEIGHT, T2.URUT, T2.IDPRODUK, T.KET1 FROM prterima T INNER JOIN prterima2 T2 ON T.ID = T2.ID INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN prcut2 C2 ON C2.IDPRODUK = T2.IDPRODUK && C2.IDTERIMA = T2.ID && C2.URUTTRM = T2.URUT LEFT JOIN prfrz2 F2 ON F2.IDTERIMA = T2.ID && C2.URUTTRM = T2.URUT
            WHERE C2.IDPRODUK IS NULL && F2.IDPRODUK IS NULL && T.IDSUP = '$id' && DATEDIFF(T.DATE, '$tgl') >= -3 && DATEDIFF(T.DATE, '$tgl') <= 0 ORDER BY P.NAME, G.NAME, T.DATE, T2.WEIGHT";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) STRMITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmFrmToPrd($frm, $to, $sup, $jsup, $db){
    $sql = "SELECT DATE_FORMAT(T.DATE, '%M %Y'), COUNT(T2.IDPRODUK), SUM(T2.WEIGHT), SUM(T2.WEIGHT*(T2.PRICE-T2.SPRICE)), 0, SUM(T2.WEIGHT*T2.SPRICE) FROM prterima T INNER JOIN prterima2 T2 ON T.ID = T2.ID INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to'";

    if(strcasecmp($sup,"") != 0){
        $sql .= " && T.IDSUP = '$sup'";
    }

    if(strcasecmp($jsup,"") != 0){
        $sql .= " && S.KET1 = '$jsup'";
    }

    $sql .= " GROUP BY DATE_FORMAT(T.DATE, '%M %Y') ORDER BY DATE_FORMAT(T.DATE, '%Y-%m-01')";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFTPRD : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $sql = "SELECT SUM(TBHDLL) FROM prterima
                WHERE DATE_FORMAT(DATE, '%M %Y') = '$row[0]'";

        $result2 = mysqli_query($db, $sql) or die("Error F(x) GTRMFTPRD - 2 : ".mysqli_error($db));

        $sum = mysqli_fetch_array($result2, MYSQLI_NUM);

        $row[4] = $sum[0];
        
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getTrmFrmTo($frm, $to, $sup = "", $jsup = ""){
    $db = openDB();

    $sql = "SELECT T.ID, T.DATE, S.NAME, T.BB, T.POTO, T.KET1, T.KET2, T.KET3, T.IDUSER, T.WKT, IFNULL((SELECT SUM(IFNULL(WEIGHT, 0)) FROM prterima2 WHERE ID = T.ID), 0), IFNULL((SELECT SUM(IFNULL(TCUT1,0)+IFNULL(TCUT2,0)+IFNULL(TCUT3,0)+IFNULL(TCUT4,0)+IFNULL(TCUT5,0)+IFNULL(TCUT6,0)) FROM prcut2 WHERE IDTERIMA = T.ID), 0), (SELECT COUNT(IDPRODUK) FROM prcut2 WHERE IDTERIMA = T.ID), (SELECT COUNT(IDPRODUK) FROM prterima2 WHERE ID = T.ID), T.KOTA, T.VDLL, T.KDLL, T.DP, IFNULL((SELECT SUM(IFNULL((WEIGHT*PRICE), 0) - IFNULL((WEIGHT*SPRICE),0)) FROM prterima2 WHERE ID = T.ID), 0)-IFNULL(T.POTO,0)-IFNULL(T.BB,0)-IFNULL(T.VDLL,0)-IFNULL(T.KDLL,0)-IFNULL(T.DP,0)-IFNULL(T.POTDLL,0)+IFNULL(T.TBHDLL,0)-IFNULL(T.VMIN,0), IFNULL((SELECT SUM(IFNULL((WEIGHT*SPRICE), 0)) FROM prterima2 WHERE ID = T.ID), 0), (SELECT COUNT(IDPRODUK) FROM prterima2 WHERE ID = T.ID), IFNULL((SELECT SUM(IFNULL((WEIGHT*SPRICE),0)) FROM prterima2 WHERE ID = T.ID), 0), IFNULL((SELECT SUM(IFNULL(WEIGHT, 0)) FROM prcut2 WHERE IDTERIMA = T.ID), 0), IFNULL((SELECT SUM(IFNULL(WEIGHT, 0)) FROM prfrz2 WHERE IDTERIMA = T.ID), 0), (SELECT COUNT(IDPRODUK) FROM prfrz2 WHERE IDTERIMA = T.ID), T.POTDLL, T.TBHDLL, T.MINUM, T.VMIN, IFNULL((SELECT SUM(IFNULL(VAL, 0)) FROM prterima3 WHERE TYPE = '1' && ID = T.ID), 0), IFNULL((SELECT SUM(IFNULL(VAL, 0)) FROM prterima3 WHERE TYPE = '2' && ID = T.ID), 0), IFNULL((SELECT SUM(IFNULL(VAL, 0)) FROM prterima3 WHERE TYPE = '3' && ID = T.ID), 0), IFNULL((SELECT SUM(IFNULL(T2.WEIGHT,0)) FROM prterima2 T2 INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtkates KS ON P.IDKATES = KS.ID WHERE T2.ID = T.ID && KS.CUT = 'Y'), 0) FROM prterima T INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to'";

    if(strcasecmp($sup,"") != 0)
        $sql .= " && T.IDSUP = '$sup'";

    if(strcasecmp($jsup,"") != 0)
        $sql .= " && S.KET1 = '$jsup'";

    $sql .= " ORDER BY T.DATE, S.NAME, T.ID";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmFrmTo2($frm, $to, $sup = "", $scut = "", $jsup)
{
    $db = openDB();

    $sql = "SELECT T.ID, T.DATE, S.NAME, T.BB, T.POTO, T.KET1, T.KET2, T.KET3, T.IDUSER, T.WKT, (SELECT SUM(WEIGHT) FROM prterima2 WHERE ID = T.ID), P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), T2.WEIGHT, (SELECT SUM(TCUT1+TCUT2+TCUT3+TCUT4+TCUT5+TCUT6) FROM prcut2 WHERE IDTERIMA = T.ID && IDPRODUK = T2.IDPRODUK && URUTTRM = T2.URUT), T.KOTA, T.VDLL, T.KDLL, T.DP, T2.PRICE, (SELECT SUM(WEIGHT) FROM prfrz2 WHERE IDTERIMA = T.ID && IDPRODUK = T2.IDPRODUK && URUTTRM = T2.URUT), T.POTDLL, T.TBHDLL, T.MINUM, T.VMIN, (SELECT COUNT(ID) FROM prcut2 WHERE IDTERIMA = T.ID AND URUTTRM = T2.URUT), (SELECT SUM(VAL) FROM prterima3 WHERE TYPE = '1' && ID = T.ID), (SELECT SUM(VAL) FROM prterima3 WHERE TYPE = '2' && ID = T.ID), (SELECT SUM(VAL) FROM prterima3 WHERE TYPE = '3' && ID = T.ID), KS.CUT, ST.NAME, (SELECT NOSAMPLE FROM prcut2 WHERE IDTERIMA = T.ID && IDPRODUK = T2.IDPRODUK && URUTTRM = T2.URUT), (SELECT SP.DATE FROM prcut2 SP2 INNER JOIN prcut SP ON SP2.ID = SP.ID WHERE SP2.IDTERIMA = T.ID && SP2.IDPRODUK = T2.IDPRODUK && SP2.URUTTRM = T2.URUT) FROM prterima T INNER JOIN dtsup S ON T.IDSUP = S.ID INNER JOIN prterima2 T2 ON T2.ID = T.ID INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN dtkates KS ON P.IDKATES = KS.ID INNER JOIN dtsat ST ON T2.IDSAT = ST.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to'";

    if(strcasecmp($sup,"") != 0)
        $sql .= " && T.IDSUP = '$sup'";

    if(strcasecmp($jsup,"") != 0)
        $sql .= " && S.KET1 = '$jsup'";

    if(strcasecmp($scut,"S") == 0){
        $sql .= " && (SELECT COUNT(ID) FROM prcut2 WHERE IDTERIMA = T.ID AND URUTTRM = T2.URUT) > 0";
    }
    else if(strcasecmp($scut,"B") == 0){
        $sql .= " && (SELECT COUNT(ID) FROM prcut2 WHERE IDTERIMA = T.ID AND URUTTRM = T2.URUT) = 0";
    }

    $sql .= " ORDER BY T.DATE, T.ID, T2.URUT";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmFrmTo3($frm, $to, $sup = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT S.NAME, (SELECT SUM(SP2.WEIGHT) FROM prterima2 SP2 INNER JOIN prterima SP ON SP2.ID = SP2.ID WHERE IDSUP = S.ID && SP.DATE >= '$frm' && SP.DATE <= '$to'), (SELECT SUM(SP2.WEIGHT * SP2.PRICE) FROM prterima2 SP2 INNER JOIN prterima SP ON SP2.ID = SP2.ID WHERE IDSUP = S.ID && SP.DATE >= '$frm' && SP.DATE <= '$to')-(SELECT SUM(SP2.WEIGHT * SP2.SPRICE) FROM prterima2 SP2 INNER JOIN prterima SP ON SP2.ID = SP2.ID WHERE IDSUP = S.ID && SP.DATE >= '$frm' && SP.DATE <= '$to') FROM dtsup S";

    if(strcasecmp($sup,"") != 0)
        $sql .= " WHERE S.ID = '$sup'";

    $sql .= " ORDER BY NAME";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmFrmTo4($frm, $to, $sup = "", $jsup = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT S.NAME, (SELECT SUM(SP2.WEIGHT) FROM prterima2 SP2 INNER JOIN prterima SP ON SP.ID = SP2.ID WHERE SP.IDSUP = S.ID && SP.DATE >= '$frm' && SP.DATE <= '$to'), (SELECT SUM(SP2.WEIGHT * SP2.PRICE) FROM prterima2 SP2 INNER JOIN prterima SP ON SP.ID = SP2.ID WHERE SP.IDSUP = S.ID && SP.DATE >= '$frm' && SP.DATE <= '$to'), (SELECT SUM(SP.TBHDLL) FROM prterima SP WHERE SP.IDSUP = S.ID && SP.DATE >= '$frm' && SP.DATE <= '$to'), (SELECT SUM(SP2.WEIGHT * SP2.SPRICE) FROM prterima2 SP2 INNER JOIN prterima SP ON SP.ID = SP2.ID WHERE SP.IDSUP = S.ID && SP.DATE >= '$frm' && SP.DATE <= '$to') FROM dtsup S";

    if(strcasecmp($sup,"") != 0)
        $sql .= " WHERE S.ID = '$sup'";

    if(strcasecmp($jsup,"") != 0)
        $sql .= " WHERE S.KET1 = '$jsup'";

    $sql .= " ORDER BY NAME";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT4 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmFrmTo5($frm, $to, $sup = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT ID FROM prterima
            WHERE ID LIKE 'TTT/%' && DATE >= '$frm' && DATE <= '$to'";

    if(strcasecmp($sup,"") != 0)
        $sql .= " WHERE IDSUP = '$sup'";

    $sql .= " ORDER BY ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT5 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmFrmTo6($frm, $to)
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), (SELECT NAME FROM dtsup WHERE ID = P.IDSUP), BB, VDLL, MINUM, ID FROM prterima P
            WHERE DATE >= '$frm' && DATE <= '$to' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT6 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmFrmTo7($frm, $to, $sup, $type, $jns, $dgfk, $wgfk)
{
    $db = openDB();

    $fy = date('Y', strtotime($frm));
    $fm = date('n', strtotime($frm));
    $fd = date('d', strtotime($frm));

    $ty = date('Y', strtotime($to));
    $tm = date('n', strtotime($to));
    $td = date('d', strtotime($to));

    $qtype = "SUM(P2.WEIGHT)";
    if(strcasecmp($type,"2") == 0)
        $qtype = "COUNT(P2.ID)";

    $date = array();
    $ldate = array();
    $data = array();

    if(strcasecmp($jns,"1") == 0)
    {
        for($i = $fy; $i <= $ty; $i++)
        {
            $sm = 1;
            $em = 12;
            if(strcasecmp($i, $fy) == 0)
                $sm = $fm;

            if(strcasecmp($i, $ty) == 0)
                $em = $tm;

            for($j = $sm; $j <= $em; $j++)
            {
                $sd = 1;
                $ed = date('t', strtotime(date($i."-".$j."-01")));
                if(strcasecmp($j, $fm) == 0)
                    $sd = $fd;
        
                if(strcasecmp($j, $em) == 0)
                    $ed = $td;

                for($k = $sd; $k <= $ed; $k++)
                {
                    $date[count($date)] = date('d/m', strtotime($i."-".$j."-".$k));
                    $ldate[count($ldate)] = date('Y-m-d', strtotime($i."-".$j."-".$k));
                    $sql = "SELECT $qtype FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID INNER JOIN dtsup S ON P.IDSUP = S.ID
                            WHERE P.DATE = '".$i."-".$j."-".$k."'";

                    if(strcasecmp($dgfk,"") != 0)
                        $sql .= " && S.ADDR = '$dgfk'";

                    if(strcasecmp($wgfk,"") != 0)
                        $sql .= " && S.REG = '$wgfk'";

                    if(strcasecmp($sup,"") != 0)
                        $sql .= " && P.IDSUP = '$sup'";

                    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT7 : ".mysqli_error($db));

                    $row = mysqli_fetch_array($result, MYSQLI_NUM);

                    $data[count($data)] = $row[0];
                }
            }
        }
    }
    else if(strcasecmp($jns,"2") == 0)
    {
        for($i = $fy; $i <= $ty; $i++)
        {
            $sm = 1;
            $em = 12;
            if(strcasecmp($i, $fy) == 0)
                $sm = $fm;

            if(strcasecmp($i, $ty) == 0)
                $em = $tm;

            for($j = $sm; $j <= $em; $j++)
            {
                $date[count($date)] = date('m/y', strtotime($i."-".$j."-01"));
                $ldate[count($ldate)] = date('Y-m-d', strtotime($i."-".$j."-01"));
                $sql = "SELECT $qtype FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID INNER JOIN dtsup S ON P.IDSUP = S.ID
                        WHERE MONTH(P.DATE) = MONTH('".$i."-".$j."-01') AND YEAR(P.DATE) = YEAR('".$i."-".$j."-01')";

                if(strcasecmp($dgfk,"") != 0)
                    $sql .= " && S.ADDR = '$dgfk'";

                if(strcasecmp($wgfk,"") != 0)
                    $sql .= " && S.REG = '$wgfk'";

                if(strcasecmp($sup,"") != 0)
                    $sql .= " && P.IDSUP = '$sup'";

                $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT7 - 2 : ".mysqli_error($db));

                $row = mysqli_fetch_array($result, MYSQLI_NUM);

                $data[count($data)] = $row[0];
            }
        }
    }

    closeDB($db);

    return array($data, $date, $ldate);
}

function getTrmFrmTo8($ldate, $sup, $type, $grade, $jns, $dgfk, $wgfk)
{
    $db = openDB();

    $qtype = "SUM(P2.WEIGHT)";
    if(strcasecmp($type,"2") == 0)
        $qtype = "COUNT(P2.ID)";

    $arr = array();
    
    for($i = 0; $i < count($ldate); $i++)
    {
        $sql = "SELECT $qtype FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID INNER JOIN dtsup S ON P.IDSUP = S.ID
                WHERE (SELECT IDGRADE FROM dtproduk WHERE ID = P2.IDPRODUK) = '$grade'";

        if(strcasecmp($jns,"1") == 0)
            $sql .= " && P.DATE = '$ldate[$i]'";
        else if(strcasecmp($jns,"2") == 0)
            $sql .= " && MONTH(P.DATE) = MONTH('$ldate[$i]') && YEAR(P.DATE) = YEAR('$ldate[$i]')";

        if(strcasecmp($dgfk,"") != 0)
            $sql .= " && S.ADDR = '$dgfk'";

        if(strcasecmp($sup,"") != 0)
            $sql .= " && P.IDSUP = '$sup'";
            
        $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT8 : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $arr[count($arr)] = (double)$row[0];
    }

    closeDB($db);

    return $arr;
}

function getTrmFrmTo9($frm, $to, $sup = "", $jsup = "")
{
    $db = openDB();

    $sql = "SELECT '', DATE_FORMAT(T.DATE, '%M %Y') AS MDATE, S.NAME, SUM(T.BB), SUM(T.POTO), '', '', '', '', '', SUM((SELECT SUM(WEIGHT) FROM prterima2 WHERE ID = T.ID)), SUM((SELECT SUM(TCUT1+TCUT2+TCUT3+TCUT4+TCUT5+TCUT6) FROM prcut2 WHERE IDTERIMA = T.ID)), SUM((SELECT COUNT(IDPRODUK) FROM prcut2 WHERE IDTERIMA = T.ID)), SUM((SELECT COUNT(IDPRODUK) FROM prterima2 WHERE ID = T.ID)), '', SUM(T.VDLL), '', SUM(T.DP), SUM((SELECT SUM((WEIGHT*PRICE) - (WEIGHT*SPRICE)) FROM prterima2 WHERE ID = T.ID)-T.POTO-T.BB-T.VDLL-T.KDLL-T.DP-T.POTDLL+T.TBHDLL-T.VMIN), SUM((SELECT SUM(WEIGHT*SPRICE) FROM prterima2 WHERE ID = T.ID)), SUM((SELECT COUNT(IDPRODUK) FROM prterima2 WHERE ID = T.ID)), SUM((SELECT SUM(WEIGHT*SPRICE) FROM prterima2 WHERE ID = T.ID)), SUM((SELECT SUM(WEIGHT) FROM prcut2 WHERE IDTERIMA = T.ID)), SUM((SELECT SUM(WEIGHT) FROM prfrz2 WHERE IDTERIMA = T.ID)), SUM((SELECT COUNT(IDPRODUK) FROM prfrz2 WHERE IDTERIMA = T.ID)), SUM(T.POTDLL), SUM(T.TBHDLL), SUM(T.MINUM), SUM(T.VMIN) FROM prterima T INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to'";

    if(strcasecmp($sup,"") != 0)
        $sql .= " && T.IDSUP = '$sup'";

    if(strcasecmp($jsup,"") != 0)
        $sql .= " && S.KET1 = '$jsup'";

    $sql .= " GROUP BY MDATE, S.NAME";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMFT9 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLTrmPNFrmTo($frm, $to, $sup = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT PR.NAME FROM prterima2 P2 INNER JOIN dtproduk PR ON P2.IDPRODUK = PR.ID INNER JOIN prterima P ON P2.ID = P.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to'";

    if(strcasecmp($sup,"") != 0)
        $sql .= " && P.IDSUP = '$sup'";

    $sql .= " ORDER BY PR.NAME";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GLTRMPNFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmID($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDUSER, WKT, VERIF, VUSER, KOTA, VDLL, KDLL, DP, BB2, VMIN, POTDLL, TBHDLL, MINUM, IDGDG FROM prterima
            WHERE ID = '$id' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getTTrmID($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDUSER, WKT, VERIF, VUSER, KOTA, VDLL, KDLL, DP, BB2, VMIN, POTDLL, TBHDLL, MINUM FROM prterima_tmp
            WHERE ID = '$id' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTTRMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getTrmItem($id)
{
    $db = openDB();

    $sql = "SELECT P2.ID, P2.IDPRODUK, P2.WEIGHT, P2.IDSAT, P2.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), S.NAME, P2.PRICE, P.IDGRADE, P2.SPRICE, (SELECT COUNT(ID) FROM prcut2 WHERE IDTERIMA = P2.ID && URUTTRM = P2.URUT) FROM prterima2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN dtsat S ON P2.IDSAT = S.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE P2.ID = '$id' ORDER BY G.NAME, P2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTTrmItem($id)
{
    $db = openDB();

    $sql = "SELECT P2.ID, P2.IDPRODUK, P2.WEIGHT, P2.IDSAT, P2.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), S.NAME, P2.PRICE, P.IDGRADE, P2.SPRICE FROM prterima2_tmp P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN dtsat S ON P2.IDSAT = S.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE P2.ID = '$id' ORDER BY G.NAME, P2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTTRMITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmItem2()
{
    $db = openDB();
    
    $sql = "SELECT T.ID, DATE_FORMAT(T.DATE, '%d/%m/%Y'), S.NAME, P.NAME, G.NAME, T2.WEIGHT, T.DATE, T2.URUT, T2.IDPRODUK FROM prterima T INNER JOIN prterima2 T2 ON T.ID = T2.ID INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN dtsup S ON T.IDSUP = S.ID LEFT JOIN prcut2 C2 ON C2.IDPRODUK = T2.IDPRODUK && C2.IDTERIMA = T2.ID && C2.URUTTRM = T2.URUT
            WHERE C2.IDPRODUK IS NULL ORDER BY T.ID, T.DATE, P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMITM2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmItem3($id)
{
    $db = openDB();
    
    $sql = "SELECT DISTINCT T2.ID, T2.IDPRODUK, (SELECT COUNT(IDPRODUK) FROM prterima2 WHERE ID = T2.ID && IDPRODUK = T2.IDPRODUK && IDSAT = T2.IDSAT), (SELECT SUM(WEIGHT) FROM prterima2 WHERE ID = T2.ID && IDPRODUK = T2.IDPRODUK && IDSAT = T2.IDSAT), T2.PRICE, T2.IDSAT, T2.SPRICE FROM prterima2 T2 INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE T2.ID = '$id' ORDER BY G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMITM3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);
    
    return $arr;
}

function getTrmItem4($frm, $to, $sup)
{
    $db = openDB();

    $sp = "";
    $sp2 = "";
    if(strcasecmp($sup,"") != 0)
    {
        $sp = " && T.IDSUP = '$sup'";
        $sp2 = " && ST.IDSUP = '$sup'";
    }
    
    $sql = "SELECT DISTINCT T2.IDPRODUK, P.NAME, G.NAME, S.NAME, (SELECT COUNT(ST2.IDPRODUK) FROM prterima2 ST2 INNER JOIN prterima ST ON ST2.ID = ST.ID WHERE ST2.IDPRODUK = T2.IDPRODUK && ST2.IDSAT = T2.IDSAT && ST.DATE >= '$frm' && ST.DATE <= '$to' $sp2), (SELECT SUM(ST2.WEIGHT) FROM prterima2 ST2 INNER JOIN prterima ST ON ST.ID = ST2.ID WHERE ST2.IDPRODUK = T2.IDPRODUK && ST2.IDSAT = T2.IDSAT && ST.DATE >= '$frm' && ST.DATE <= '$to' $sp2) FROM prterima2 T2 INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN dtsat S ON T2.IDSAT = S.ID INNER JOIN prterima T ON T.ID = T2.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to' $sp ORDER BY G.NAME, P.NAME, S.NAME";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMITM4 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);
    
    return $arr;
}

function getTrmDll($id)
{
    $db = openDB();

    $sql = "SELECT ID, TYPE, KET, VAL, URUT FROM prterima3
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMDLL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmDllDll($id, $db)
{
    $sql = "SELECT ID, TYPE, KET, VAL, URUT FROM prterima3
            WHERE ID = '$id' && TYPE = '3' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMDLLDLL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getTTrmDll($id)
{
    $db = openDB();

    $sql = "SELECT ID, TYPE, KET, VAL, URUT FROM prterima3_tmp
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTTRMDLL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmPDll($id)
{
    $db = openDB();

    $sql = "SELECT ID, TYPE, KET, VAL, URUT FROM prterima4
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMPDLL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmPDll2($id, $db)
{
    $sql = "SELECT ID, TYPE, KET, VAL, URUT FROM prterima4
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMPDLL2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getTTrmPDll($id)
{
    $db = openDB();

    $sql = "SELECT ID, TYPE, KET, VAL, URUT FROM prterima4_tmp
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTTRMPDLL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmDP($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, VAL, URUT FROM prterima5
            WHERE ID = '$id' ORDER BY DATE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMDP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTTrmDP($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, VAL, URUT FROM prterima5_tmp
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTTRMDP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmTDll($id)
{
    $db = openDB();

    $sql = "SELECT ID, TYPE, KET, VAL, URUT, WEIGHT, VAL2 FROM prterima6
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMTDLL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmTDll2($id, $db)
{
    $sql = "SELECT ID, TYPE, KET, VAL, URUT, WEIGHT, VAL2 FROM prterima6
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMTDLL2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getTTrmTDll($id)
{
    $db = openDB();

    $sql = "SELECT ID, TYPE, KET, VAL, URUT, WEIGHT, VAL2 FROM prterima6_tmp
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTTRMTDLL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmCut($sup, $ttrm, $pro)
{
    $db = openDB();

    $sql = "SELECT T2.WEIGHT, T2.URUT, T2.ID FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID LEFT JOIN prcut2 C2 ON C2.IDPRODUK = T2.IDPRODUK && C2.IDTERIMA = T2.ID && C2.URUTTRM = T2.URUT
            WHERE T.IDSUP = '$sup' && T.DATE = '$ttrm' && T2.IDPRODUK = '$pro' && C2.IDPRODUK IS NULL ORDER BY T2.WEIGHT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMCUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmNCut($tgl)
{
    $db = openDB();

    $sql = "SELECT T2.IDPRODUK, T2.WEIGHT, T2.URUT, T2.ID FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID LEFT JOIN prcut2 C2 ON C2.IDPRODUK = T2.IDPRODUK && C2.IDTERIMA = T2.ID && C2.URUTTRM = T2.URUT
            WHERE C2.IDPRODUK IS NULL && T.DATE <= '$tgl' ORDER BY T.DATE, T.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMNCUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmItemTT($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT G.NAME, P.NAME, S.NAME, (SELECT SUM(WEIGHT) FROM prterima2 WHERE ID = P2.ID && IDPRODUK = P2.IDPRODUK), (SELECT COUNT(IDPRODUK) FROM prterima2 WHERE ID = P2.ID && IDPRODUK = P2.IDPRODUK), P2.IDPRODUK, P2.IDSAT FROM prterima2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN dtsat S ON P2.IDSAT = S.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE P2.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMITMTT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmGrade($frm, $to, $dgfk, $wgfk)
{
    $db = openDB();

    $sql = "SELECT DISTINCT IDGRADE, (SELECT NAME FROM dtgrade WHERE ID = P.IDGRADE) AS GRADE FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID INNER JOIN dtproduk P ON P.ID = T2.IDPRODUK INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to'";

    if(strcasecmp($dgfk,"") != 0)
        $sql .= " && S.ADDR = '$dgfk'";

    if(strcasecmp($wgfk,"") != 0)
        $sql .= " && S.REG = '$wgfk'";

    $sql .= " ORDER BY GRADE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMGRD : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmSat($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT IDSAT FROM prterima2
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMSAT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmSatGrade($id, $sat)
{
    $db = openDB();

    $sql = "SELECT DISTINCT G.ID, G.NAME FROM prterima2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE P2.ID = '$id' && P2.IDSAT = '$sat'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMSTNGRD : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmSatItem($id, $sat)
{
    $db = openDB();

    $sql = "SELECT ID, IDPRODUK, WEIGHT, IDSAT, URUT FROM prterima2
            WHERE ID = '$id' && IDSAT = '$sat' ORDER BY IDPRODUK, URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMSATITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmSatGradeItem($id, $sat, $grade)
{
    $db = openDB();

    $sql = "SELECT ID, IDPRODUK, WEIGHT, IDSAT, URUT, (SELECT NAME FROM dtproduk WHERE ID = P2.IDPRODUK) FROM prterima2 P2
            WHERE ID = '$id' && IDSAT = '$sat' && (SELECT IDGRADE FROM dtproduk WHERE ID = P2.IDPRODUK) = '$grade' ORDER BY IDPRODUK, URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMSATGRDITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmSupSPjm($sup, $spjm)
{
    $db = openDB();

    $sql = "SELECT DATE, ID, POTO, (SELECT SUM(POTO) FROM prterima WHERE IDSUP = P.IDSUP && WKT <= P.WKT) FROM prterima P
            WHERE IDSUP = '$sup' && POTO != 0 && (SELECT SUM(POTO) FROM prterima WHERE IDSUP = P.IDSUP && WKT <= P.WKT) > '$spjm' ORDER BY DATE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPJMSUPSPJM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTrmSupTpTglID($sup, $tgl, $tipe)
{
    $db = openDB();

    $sql = "SELECT ID FROM prterima
            WHERE IDSUP = '$sup' && DATE = '$tgl' && KET1 = '$tipe'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTRMSUPTPTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLTrmTglFrmTo($frm, $to, $sup = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE FROM prterima
            WHERE DATE >= '$frm' && DATE <= '$to'";

    if(strcasecmp($sup,"") != 0)
        $sql .= " && IDSUP = '$sup'";

    $sql .= " ORDER BY DATE";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GLTRMTGLFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumTrmGradeTgl($pro, $tgl)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT) FROM prterima2 P2 INNER JOIN prterima P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSTRMGRDT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getHstTrmFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, IDTRAN_BFR, DATE_BFR, IDSUP_BFR, BB_BFR, POTO_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, IDSUP_AFR, BB_AFR, POTO_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR, KOTA_BFR, KOTA_AFR, VDLL_BFR, KDLL_BFR, DP_BFR, VDLL_AFR, KDLL_AFR, DP_AFR, POTDLL_BFR, POTDLL_AFR, TBHDLL_BFR, TBHDLL_AFR, MINUM_BFR, MINUM_AFR FROM hst_prterima";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHTRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHTrmID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT T.IDTRAN_BFR, DATE_FORMAT(T.DATE_BFR, '%d/%m/%Y'), S.NAME, T.BB_BFR, T.POTO_BFR, T.KET1_BFR, T.KET2_BFR, T.KET3_BFR, T.IDUSER_BFR, DATE_FORMAT(T.WKT_BFR, '%d/%m/%Y'), KOTA_BFR, VDLL_BFR, KDLL_BFR, DP_BFR, POTDLL_BFR, TBHDLL_BFR, MINUM_BFR FROM hst_prterima T LEFT JOIN dtsup S ON T.IDSUP_BFR = S.ID";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT T.IDTRAN_AFR, DATE_FORMAT(T.DATE_AFR, '%d/%m/%Y'), S.NAME, T.BB_AFR, T.POTO_AFR, T.KET1_AFR, T.KET2_AFR, T.KET3_AFR, T.IDUSER_AFR, DATE_FORMAT(T.WKT_AFR, '%d/%m/%Y'), KOTA_AFR, VDLL_AFR, KDLL_AFR, DP_AFR, POTDLL_AFR, TBHDLL_AFR, MINUM_AFR FROM hst_prterima T LEFT JOIN dtsup S ON T.IDSUP_AFR = S.ID";

    $sql .= " WHERE T.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHTRMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getHTrmItem($id, $type)
{
    $db = openDB();

    $sql = "SELECT T2.ID, T2.IDTRAN, T2.IDPRODUK, T2.WEIGHT, T2.IDSAT, T2.TYPE, T2.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), S.NAME, T2.PRICE, T2.SPRICE FROM hst_prterima2 T2 LEFT JOIN dtproduk P ON T2.IDPRODUK = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtsat S ON T2.IDSAT = S.ID
            WHERE T2.ID = '$id' && T2.TYPE = '$type' ORDER BY T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHTRMITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumTrmSatGrade($id, $sat, $grade)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT), COUNT(P2.IDPRODUK) FROM prterima2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID
            WHERE P2.ID = '$id' && P2.IDSAT = '$sat' && P.IDGRADE = '$grade'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSTRMSTNGRD : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getSumTrmSatGrade2($sat, $grade, $tgl, $sup)
{
    $db = openDB();

    $sql = "SELECT DISTINCT SUM(WEIGHT), SPRICE FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID INNER JOIN dtproduk PR ON P2.IDPRODUK = PR.ID
            WHERE P.DATE = '$tgl' && P2.IDSAT = '$sat' && PR.IDGRADE = '$grade' && P.IDSUP = '$sup'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSTRMSATGRD2 : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum;
}

function getSumTrmFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT IFNULL(SUM(P2.WEIGHT),0), IFNULL(COUNT(P2.IDPRODUK),0) FROM prterima2 P2 INNER JOIN prterima P ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSTRMFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum;
}

function getSumTrmFrmTo2($frm, $to)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT), COUNT(P2.IDPRODUK) FROM prterima2 P2 INNER JOIN prterima P ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && P.KOTA = '' && (SELECT COUNT(ID) FROM prfrz2 WHERE IDTERIMA = P2.ID && IDPRODUK = P2.IDPRODUK && URUTTRM = P2.URUT) = 0";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSTRMFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum;
}


function getSumTrmID($id)
{
    $db = openDB();

    $sql = "SELECT SUM(WEIGHT) FROM prterima2
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GSTRMID : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getLastIDHTrm($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prterima
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHTRM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDTrm($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM prterima
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDTRM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDTrm2($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM prterima
            WHERE ID LIKE '$aw%$ak' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDTRM2 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDTrm3($aw, $ak, $db)
{
    $sql = "SELECT ID FROM prterima
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDTRM3 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastIDTrm4($aw, $ak, $db)
{
    $db = openDB();

    $sql = "SELECT ID FROM prterima
            WHERE ID LIKE '$aw%$ak' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDTRM4 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDTTrm($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM prterima_tmp
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDTTRM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastUrutTrm($id)
{
    $db = openDB();

    $sql = "SELECT URUT FROM prterima2
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUTRM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastSumThrTrm()
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE, (SELECT SUM(SP2.WEIGHT) FROM prterima SP INNER JOIN prterima2 SP2 ON SP.ID = SP2.ID WHERE SP.DATE = P.DATE) FROM prterima P ORDER BY DATE DESC LIMIT 0, 30";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSTTRM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumItemTrmSat($id, $sat, $type = "1")
{
    $db = openDB();

    $sql = "SELECT COUNT(ID), SUM(WEIGHT), SUM(PRICE*WEIGHT), SUM(SPRICE*WEIGHT) FROM prterima2
            WHERE ID = '$id' && IDSAT = '$sat'";

    if(strcasecmp($type,"2") == 0)
        $sql .= " && SPRICE != 0";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSITMTRMSAT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getLstSupTrmSatFrmTo($frm, $to, $sarr)
{
    $db = openDB();

    $sup = " && (";

    for($i = 0; $i < count($sarr); $i++)
    {
        if($i != 0)
            $sup .= " || ";
        
        $sup .= "P.IDSUP = '$sarr[$i]'";
    }

    $sup .= ")";

    $sql = "SELECT DISTINCT P2.IDSAT, (SELECT NAME FROM dtsat WHERE ID = P2.IDSAT) FROM prterima2 P2 INNER JOIN prterima P ON P2.ID = P.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' $sup";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSUPTRMSATFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLstSupTrmGradeFrmTo($frm, $to, $sarr, $sat)
{
    $db = openDB();

    $sup = " && (";

    for($i = 0; $i < count($sarr); $i++)
    {
        if($i != 0)
            $sup .= " || ";
        
        $sup .= "P.IDSUP = '$sarr[$i]'";
    }

    $sup .= ")";

    $sql = "SELECT DISTINCT IDGRADE, (SELECT NAME FROM dtgrade WHERE ID = PR.IDGRADE) FROM prterima2 P2 INNER JOIN prterima P ON P2.ID = P.ID INNER JOIN dtproduk PR ON PR.ID = P2.IDPRODUK
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && P2.IDSAT = '$sat' $sup";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSUPTRMGRDFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getWeightTrmItemID($id, $pro, $urut)
{
    $db = openDB();

    $sql = "SELECT WEIGHT FROM prterima2
            WHERE ID = '$id' && IDPRODUK = '$pro' && URUT = '$urut'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GWTRMITMID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTrmID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prterima
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CTRMID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTrm($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(P.ID) FROM prterima P INNER JOIN dtsup S ON P.IDSUP = S.ID
            WHERE P.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || P.KET1 LIKE '%$id%' || P.KET2 LIKE '%$id%' || P.KET3 LIKE '%$id%' || DATE_FORMAT(P.DATE, '%d/%m/%Y') LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CTRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTrmSupTgl($sup, $tgl)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prterima
            WHERE IDSUP = '$sup' && DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CTRMSUPTGL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTrmSupTpTgl($sup, $tgl, $tipe)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prterima
            WHERE IDSUP = '$sup' && DATE = '$tgl' && KET1 = '$tipe'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CTRMSUPTPTGL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTrmItem($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(P.ID) FROM prterima T INNER JOIN prterima2 T2 ON T.ID = T2.ID INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN dtsup S ON T.IDSUP = S.ID LEFT JOIN prcut2 C2 ON C2.IDPRODUK = T2.IDPRODUK && C2.IDTERIMA = T2.ID && C2.URUTTRM = T2.URUT
        WHERE C2.IDPRODUK IS NULL && (P.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || P.NAME LIKE '%$id%' || G.NAME LIKE '%$id%')";

    $result = mysqli_query($db, $sql) or die("Error F(x) CTRMITM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTrmItemID($id, $pro, $urut)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prterima2
            WHERE ID = '$id' && IDPRODUK = '$pro' && URUT = '$urut'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) CTRMITMID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTrmTT($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trtt
            WHERE IDTERIMA = '$id'";

    $result = mysqli_query($db, $sql) or die("Error CTRMTT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTrmCut($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prcut2
            WHERE IDTERIMA = '$id'";

    $result = mysqli_query($db, $sql) or die("Error CTRMCUT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTrmTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prterima
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CTRMTGL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schTrm($id)
{
    $db = openDB();

    $sql = "SELECT P.ID, DATE_FORMAT(P.DATE, '%d/%m/%Y'), S.NAME, P.BB, P.POTO, P.KET1, P.KET2, P.KET3, P.IDUSER, DATE_FORMAT(P.WKT, '%d/%m/%Y %H:%i'), P.KOTA, P.VDLL, P.KDLL, P.DP, (SELECT SUM(WEIGHT) FROM prterima2 WHERE ID = P.ID), P.BB2, P.VMIN, P.POTDLL, P.TBHDLL, P.MINUM, (SELECT SUM(WEIGHT) FROM prterima2 WHERE ID = P.ID), (SELECT COUNT(ID) FROM prterima2 WHERE ID = P.ID), P.IDSUP, P.DATE FROM prterima P INNER JOIN dtsup S ON P.IDSUP = S.ID";

    if(countTrm($id) > 0)
        $sql .= " WHERE (P.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || P.KET1 LIKE '%$id%' || P.KET2 LIKE '%$id%' || P.KET3 LIKE '%$id%' || DATE_FORMAT(P.DATE, '%d/%m/%Y') LIKE '%$id%')";
    else
    {
        $y = explode(" ",$id);
        
        $sql .= " WHERE (";
        for($i = 0; $i < count($y); $i++)
        {
            $sch = $y[$i];
            for($j = 0; $j < count($y); $j++)
            {
                if($j == $i)
                    continue;
                
                $sch = $sch."%".$y[$j];
            }
            
            $sql .= "P.ID LIKE '%$sch%' || S.NAME LIKE '%$sch%' || P.KET1 LIKE '%$sch%' || P.KET2 LIKE '%$sch%' || P.KET3 LIKE '%$sch%' || DATE_FORMAT(P.DATE, '%d/%m/%Y') LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }

    if(strcasecmp($id,"") == 0)
        $sql .= " && P.DATE = CURDATE()";

    $sql .= " ORDER BY P.DATE, P.ID";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) STRM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $row[24] = getSumSupSmpn2($row[22], $row[23]);
        $arr[count($arr)] = $row;
    }

    closeDB($db);

    return $arr;
}

function schTrmItem($id)
{
    $db = openDB();

    $sql = "SELECT T.ID, DATE_FORMAT(T.DATE, '%d/%m/%Y'), S.NAME, P.NAME, G.NAME, T2.WEIGHT, T.DATE, T2.URUT, T2.IDPRODUK, T2.SPRICE FROM prterima T INNER JOIN prterima2 T2 ON T.ID = T2.ID INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN dtsup S ON T.IDSUP = S.ID LEFT JOIN prcut2 C2 ON C2.IDPRODUK = T2.IDPRODUK && C2.IDTERIMA = T2.ID && C2.URUTTRM = T2.URUT LEFT JOIN prfrz2 F2 ON F2.IDPRODUK = T2.IDPRODUK && F2.IDTERIMA = T2.ID && F2.URUTTRM = T2.URUT
        WHERE C2.IDPRODUK IS NULL && F2.IDPRODUK IS NULL";

    if(countTrmItem($id) > 0)
        $sql .= " && (P.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || P.NAME LIKE '%$id%' || G.NAME LIKE '%$id%')";
    else
    {
        $y = explode(" ",$id);
        
        $sql .= " && (";
        for($i = 0; $i < count($y); $i++)
        {
            $sch = $y[$i];
            for($j = 0; $j < count($y); $j++)
            {
                if($j == $i)
                    continue;
                
                $sch = $sch."%".$y[$j];
            }
            
            $sql .= "P.ID LIKE '%$sch%' || S.NAME LIKE '%$sch%' || P.NAME LIKE '%$sch%' || G.NAME LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }

        $sql .= ")";
    }
    
    $sql .= " ORDER BY T.ID, T.DATE, P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) STRMITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setTrmVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE prterima
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) STRMVRF : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProTrm()
{
    $db = openDB();

    $sql = "UPDATE dtproduk P
            SET TQTY = ROUND((SELECT SUM(WEIGHT) FROM prterima2 WHERE IDPRODUK = P.ID), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROTRM : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET TQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prterima2 SP2 INNER JOIN prterima SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROTRM - 2 : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProTrm2($db)
{
    $sql = "UPDATE dtproduk P
            SET TQTY = ROUND((SELECT SUM(WEIGHT) FROM prterima2 WHERE IDPRODUK = P.ID), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROTRM : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET TQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prterima2 SP2 INNER JOIN prterima SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROTRM - 2 : ".mysqli_error($db));
}

function getTglMinTrm($sup, $tgl, $id)
{
    $db = openDB();

    $sql = "SELECT DATE FROM prterima
            WHERE (TOTAL-BB-POTO-VDLL-KDLL-DP-VMIN-POTDLL+TBHDLL) < 0 && DATE <= '$tgl' && IDSUP = '$sup' && ID != '$id' ORDER BY DATE DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTGLMTRM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function newTrm($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $wkt, $kota, $vdll, $kdll, $dp, $bb2 = 0, $min, $pdll, $tdll, $mnm, $gdg)
{
    $db = openDB();

    $sql = "INSERT INTO prterima
            (ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDUSER, WKT, KOTA, VDLL, KDLL, DP, BB2, VMIN, POTDLL, TBHDLL, MINUM, IDGDG)
            VALUES
            ('$id', '$sup', '$tgl', '$bb', '$poto', '$ket1', '$ket2', '$ket3', '$user', '$wkt', '$kota', '$vdll', '$kdll', '$dp', '$bb2', '$min', '$pdll', '$tdll', '$mnm', '$gdg')";

    mysqli_query($db, $sql) or die("Error F(x) NTRM : ".mysqli_error($db));

    closeDB($db);
}

function newTrm2($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $wkt, $kota, $vdll, $kdll, $dp, $bb2 = 0, $min, $pdll, $tdll, $mnm, $db)
{
    $sql = "INSERT INTO prterima
            (ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDUSER, WKT, KOTA, VDLL, KDLL, DP, BB2, VMIN, POTDLL, TBHDLL, MINUM)
            VALUES
            ('$id', '$sup', '$tgl', '$bb', '$poto', '$ket1', '$ket2', '$ket3', '$user', '$wkt', '$kota', '$vdll', '$kdll', '$dp', '$bb2', '$min', '$pdll', '$tdll', '$mnm')";

    mysqli_query($db, $sql) or die("Error F(x) NTRM : ".mysqli_error($db));
}

function newTTrm($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $wkt, $kota, $vdll, $kdll, $dp, $bb2 = 0, $vmin, $pdll, $tdll, $mnm)
{
    $db = openDB();

    $sql = "INSERT INTO prterima_tmp
            (ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDUSER, WKT, KOTA, VDLL, KDLL, DP, BB2, VMIN, POTDLL, TBHDLL, MINUM)
            VALUES
            ('$id', '$sup', '$tgl', '$bb', '$poto', '$ket1', '$ket2', '$ket3', '$user', '$wkt', '$kota', '$vdll', '$kdll', '$dp', '$bb2', '$vmin', '$pdll', '$tdll', '$mnm')";

    mysqli_query($db, $sql) or die("Error F(x) NTTRM : ".mysqli_error($db));

    closeDB($db);
}

function newDtlTrm($id, $pro, $weight, $sat, $urut, $price, $sprice = 0)
{
    $db = openDB();

    $sql = "INSERT INTO prterima2
            (ID, IDPRODUK, WEIGHT, IDSAT, URUT, PRICE, SPRICE)
            VALUES
            ('$id', '$pro', '$weight', '$sat', '$urut', '$price', '$sprice')";
            
    mysqli_query($db, $sql) or die("Error F(x) NDTRM : ".mysqli_error($db));

    $sql = "UPDATE prcut2
            SET WEIGHT = '$weight'
            WHERE IDPRODUK = '$pro' && IDTERIMA = '$id' && URUTTRM = '$urut'";

    mysqli_query($db, $sql) or die("Error F(x) NDTRM - 2 : ".mysqli_error($db));

    closeDB($db);
}

function newDtlTrm2($id, $pro, $weight, $sat, $urut, $price, $sprice = 0, $db)
{
    $sql = "INSERT INTO prterima2
            (ID, IDPRODUK, WEIGHT, IDSAT, URUT, PRICE, SPRICE)
            VALUES
            ('$id', '$pro', '$weight', '$sat', '$urut', '$price', '$sprice')";
            
    mysqli_query($db, $sql) or die("Error F(x) NDTRM : ".mysqli_error($db));

    $sql = "UPDATE prcut2
            SET WEIGHT = '$weight'
            WHERE IDPRODUK = '$pro' && IDTERIMA = '$id' && URUTTRM = '$urut'";

    mysqli_query($db, $sql) or die("Error F(x) NDTRM - 2 : ".mysqli_error($db));
}

function newDtlTTrm($id, $pro, $weight, $sat, $urut, $price, $sprice = 0)
{
    $db = openDB();

    $sql = "INSERT INTO prterima2_tmp
            (ID, IDPRODUK, WEIGHT, IDSAT, URUT, PRICE, SPRICE)
            VALUES
            ('$id', '$pro', '$weight', '$sat', '$urut', '$price', '$sprice')";
            
    mysqli_query($db, $sql) or die("Error F(x) NDTTRM : ".mysqli_error($db));

    closeDB($db);
}

function newDllTrm($id, $type, $ket, $val, $urut)
{
    $db = openDB();

    $sql = "INSERT INTO prterima3
            (ID, TYPE, KET, VAL, URUT)
            VALUES
            ('$id', '$type', '$ket', '$val', '$urut')";
            
    mysqli_query($db, $sql) or die("Error F(x) NDLLTRM : ".mysqli_error($db));

    closeDB($db);
}

function newDllTTrm($id, $type, $ket, $val, $urut)
{
    $db = openDB();

    $sql = "INSERT INTO prterima3_tmp
            (ID, TYPE, KET, VAL, URUT)
            VALUES
            ('$id', '$type', '$ket', '$val', '$urut')";
            
    mysqli_query($db, $sql) or die("Error F(x) NDLLTTRM : ".mysqli_error($db));

    closeDB($db);
}

function newPDllTrm($id, $type, $ket, $val, $urut)
{
    $db = openDB();

    $sql = "INSERT INTO prterima4
            (ID, TYPE, KET, VAL, URUT)
            VALUES
            ('$id', '$type', '$ket', '$val', '$urut')";
            
    mysqli_query($db, $sql) or die("Error F(x) NPDLLTRM : ".mysqli_error($db));

    closeDB($db);
}

function newPDllTTrm($id, $type, $ket, $val, $urut)
{
    $db = openDB();

    $sql = "INSERT INTO prterima4_tmp
            (ID, TYPE, KET, VAL, URUT)
            VALUES
            ('$id', '$type', '$ket', '$val', '$urut')";
            
    mysqli_query($db, $sql) or die("Error F(x) NPDLLTTRM : ".mysqli_error($db));

    closeDB($db);
}

function newDPTrm($id, $tgl, $val, $urut)
{
    $db = openDB();

    $sql = "INSERT INTO prterima5
            (ID, DATE, VAL, URUT)
            VALUES
            ('$id', '$tgl', '$val', '$urut')";
            
    mysqli_query($db, $sql) or die("Error F(x) NDPTRM : ".mysqli_error($db));

    closeDB($db);
}

function newDPTTrm($id, $tgl, $val, $urut)
{
    $db = openDB();

    $sql = "INSERT INTO prterima5_tmp
            (ID, DATE, VAL, URUT)
            VALUES
            ('$id', '$tgl', '$val', '$urut')";
            
    mysqli_query($db, $sql) or die("Error F(x) NDPTTRM : ".mysqli_error($db));

    closeDB($db);
}

function newTDllTrm($id, $type, $ket, $val, $urut, $weight, $val2)
{
    $db = openDB();

    $sql = "INSERT INTO prterima6
            (ID, TYPE, KET, VAL, URUT, WEIGHT, VAL2)
            VALUES
            ('$id', '$type', '$ket', '$val', '$urut', '$weight', '$val2')";
            
    mysqli_query($db, $sql) or die("Error F(x) NTDLLTRM : ".mysqli_error($db));

    closeDB($db);
}

function newTDllTTrm($id, $type, $ket, $val, $urut, $weight, $val2)
{
    $db = openDB();

    $sql = "INSERT INTO prterima6_tmp
            (ID, TYPE, KET, VAL, URUT, WEIGHT, VAL2)
            VALUES
            ('$id', '$type', '$ket', '$val', '$urut', '$weight', '$val2')";
            
    mysqli_query($db, $sql) or die("Error F(x) NTDLLTTRM : ".mysqli_error($db));

    closeDB($db);
}

function newHTrm($id, $idtran_bfr, $sup_bfr, $tgl_bfr, $bb_bfr, $poto_bfr, $ket1_bfr, $ket2_bfr, $ket3_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $sup_afr, $tgl_afr, $bb_afr, $poto_afr, $ket1_afr, $ket2_afr, $ket3_afr, $user_afr, $wkt_afr, $eby, $eon, $estat, $kota_bfr, $kota_afr, $vdll_bfr, $kdll_bfr, $dp_bfr, $vdll_afr, $kdll_afr, $dp_afr, $min_bfr, $min_afr, $pdll_bfr, $pdll_afr, $tdll_bfr, $tdll_afr, $mnm_bfr, $mnm_afr, $gdg_bfr, $gdg_afr)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prterima
            (ID, IDTRAN_BFR, IDSUP_BFR, DATE_BFR, BB_BFR, POTO_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, IDSUP_AFR, DATE_AFR, BB_AFR, POTO_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR, EDITEDBY, EDITEDON, EDITEDSTAT, KOTA_BFR, KOTA_AFR, VDLL_BFR, KDLL_BFR, DP_BFR, VDLL_AFR, KDLL_AFR, DP_AFR, VMIN_BFR, VMIN_AFR, POTDLL_BFR, POTDLL_AFR, TBHDLL_BFR, TBHDLL_AFR, MINUM_BFR, MINUM_AFR, IDGDG_AFR, IDGDG_BFR)
            VALUES
            ('$id', '$idtran_bfr', '$sup_bfr', '$tgl_bfr', '$bb_bfr', '$poto_bfr', '$ket1_bfr', '$ket2_bfr', '$ket3_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$sup_afr', '$tgl_afr', '$bb_afr', '$poto_afr', '$ket1_afr', '$ket2_afr', '$ket3_afr', '$user_afr', '$wkt_afr', '$eby', '$eon', '$estat', '$kota_bfr', '$kota_afr', '$vdll_bfr', '$kdll_bfr', '$dp_bfr', '$vdll_afr', '$kdll_afr', '$dp_afr', '$min_bfr', '$min_afr', '$pdll_bfr', '$pdll_afr', '$tdll_bfr', '$tdll_afr', '$mnm_bfr', '$mnm_afr', '$gdg_bfr', '$gdg_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHTRM : ".mysqli_error($db));

    closeDB($db);
}

function newHTrm2($id, $idtran_bfr, $sup_bfr, $tgl_bfr, $bb_bfr, $poto_bfr, $ket1_bfr, $ket2_bfr, $ket3_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $sup_afr, $tgl_afr, $bb_afr, $poto_afr, $ket1_afr, $ket2_afr, $ket3_afr, $user_afr, $wkt_afr, $eby, $eon, $estat, $kota_bfr, $kota_afr, $vdll_bfr, $kdll_bfr, $dp_bfr, $vdll_afr, $kdll_afr, $dp_afr, $min_bfr, $min_afr, $pdll_bfr, $pdll_afr, $tdll_bfr, $tdll_afr, $mnm_bfr, $mnm_afr, $db)
{
    $sql = "INSERT INTO hst_prterima
            (ID, IDTRAN_BFR, IDSUP_BFR, DATE_BFR, BB_BFR, POTO_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, IDSUP_AFR, DATE_AFR, BB_AFR, POTO_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR, EDITEDBY, EDITEDON, EDITEDSTAT, KOTA_BFR, KOTA_AFR, VDLL_BFR, KDLL_BFR, DP_BFR, VDLL_AFR, KDLL_AFR, DP_AFR, VMIN_BFR, VMIN_AFR, POTDLL_BFR, POTDLL_AFR, TBHDLL_BFR, TBHDLL_AFR, MINUM_BFR, MINUM_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$sup_bfr', '$tgl_bfr', '$bb_bfr', '$poto_bfr', '$ket1_bfr', '$ket2_bfr', '$ket3_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$sup_afr', '$tgl_afr', '$bb_afr', '$poto_afr', '$ket1_afr', '$ket2_afr', '$ket3_afr', '$user_afr', '$wkt_afr', '$eby', '$eon', '$estat', '$kota_bfr', '$kota_afr', '$vdll_bfr', '$kdll_bfr', '$dp_bfr', '$vdll_afr', '$kdll_afr', '$dp_afr', '$min_bfr', '$min_afr', '$pdll_bfr', '$pdll_afr', '$tdll_bfr', '$tdll_afr', '$mnm_bfr', '$mnm_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHTRM : ".mysqli_error($db));
}

function newHDtlTrm($id, $idtran, $pro, $weight, $sat, $urut, $type, $price, $sprice = 0)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prterima2
            (ID, IDTRAN, IDPRODUK, WEIGHT, IDSAT, URUT, TYPE, PRICE, SPRICE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$sat', '$urut', '$type', '$price', '$sprice')";

    mysqli_query($db, $sql) or die("Error F(x) NHDTRM : ".mysqli_error($db));

    closeDB($db);
}

function newHDtlTrm2($id, $idtran, $pro, $weight, $sat, $urut, $type, $price, $sprice = 0, $db)
{
    $sql = "INSERT INTO hst_prterima2
            (ID, IDTRAN, IDPRODUK, WEIGHT, IDSAT, URUT, TYPE, PRICE, SPRICE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$sat', '$urut', '$type', '$price', '$sprice')";

    mysqli_query($db, $sql) or die("Error F(x) NHDTRM : ".mysqli_error($db));
}

function newHDllTrm($id, $idtran, $type, $ket, $val, $urut, $htype)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prterima3
            (ID, IDTRAN, TYPE, KET, VAL, URUT, HTYPE)
            VALUES
            ('$id', '$idtran', '$type', '$ket', '$val', '$urut', '$htype')";

    mysqli_query($db, $sql) or die("Error F(x) NHDTRM - 2 : ".mysqli_error($db));

    closeDB($db);
}

function newHPDllTrm($id, $idtran, $type, $ket, $val, $urut, $htype)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prterima4
            (ID, IDTRAN, TYPE, KET, VAL, URUT, HTYPE)
            VALUES
            ('$id', '$idtran', '$type', '$ket', '$val', '$urut', '$htype')";

    mysqli_query($db, $sql) or die("Error F(x) NHPDTRM : ".mysqli_error($db));

    closeDB($db);
}

function newHDPTrm($id, $idtran, $tgl, $val, $urut, $type)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prterima5
            (ID, IDTRAN, DATE, VAL, URUT, TYPE)
            VALUES
            ('$id', '$idtran', '$tgl', '$val', '$urut', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NHDPTRM : ".mysqli_error($db));

    closeDB($db);
}

function newHTDllTrm($id, $idtran, $type, $ket, $val, $urut, $htype, $weight, $val2)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prterima6
            (ID, IDTRAN, TYPE, KET, VAL, URUT, HTYPE, WEIGHT, VAL2)
            VALUES
            ('$id', '$idtran', '$type', '$ket', '$val', '$urut', '$htype', '$weight', '$val2')";

    mysqli_query($db, $sql) or die("Error F(x) NHTDTRM : ".mysqli_error($db));

    closeDB($db);
}

function updMTrm($id, $mnm)
{
    $db = openDB();

    $sql = "UPDATE prterima
            SET MINUM = '$mnm'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) UMTRM : ".mysqli_error($db));

    closeDB($db);
}

function updTrm($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $user, $wkt, $bid, $kota, $vdll, $kdll, $dp, $bb2, $min, $vpdll, $vtdll, $mnm, $gdg)
{
    $db = openDB();

    $sql = "UPDATE prterima
            SET ID = '$id', IDSUP = '$sup', DATE = '$tgl', BB = '$bb', POTO = '$poto', KET1 = '$ket1', KET2 = '$ket2', KET3 = '$ket3', IDUSER = '$user', WKT = '$wkt', KOTA = '$kota', VDLL = '$vdll', KDLL = '$kdll', DP = '$dp', BB2 = '$bb2', VMIN = '$min', POTDLL = '$vpdll', TBHDLL = '$vtdll', MINUM = '$mnm', IDGDG = '$gdg'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UTRM : ".mysqli_error($db));

    closeDB($db);
}

function updTrmID($id, $bid)
{
    $db = openDB();

    $sql = "UPDATE prterima
            SET ID = '$id'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UTRMID : ".mysqli_error($db));

    $sql = "UPDATE hst_prterima
            SET IDTRAN_AFR = '$id'
            WHERE IDTRAN_AFR = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UTRMID - 2 : ".mysqli_error($db));

    closeDB($db);
}

function updTrmID2($id, $bid, $db)
{
    $sql = "UPDATE prterima
            SET ID = '$id'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UTRMID : ".mysqli_error($db));

    $sql = "UPDATE hst_prterima
            SET IDTRAN_AFR = '$id'
            WHERE IDTRAN_AFR = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UTRMID - 2 : ".mysqli_error($db));
}

function updDtlTrm($id, $pro, $weight, $sat, $urut, $bid, $bpro)
{
    $db = openDB();

    $sql = "UPDATE prterima2
            SET ID = '$id', IDPRODUK = '$pro', WEIGHT = '$weight', IDSAT = '$sat'
            WHERE ID = '$bid' && IDPRODUK = '$bpro' && URUT = '$urut'";

    mysqli_query($db, $sql) or die("Error F(X) UDTRM : ".mysqli_error($db));

    closeDB($db);
}

function updTTrm()
{
    $db = openDB();

    $sql = "UPDATE prterima P
            SET TOTAL = (SELECT SUM((WEIGHT * PRICE) - (WEIGHT*SPRICE)) FROM prterima2 WHERE ID = P.ID)";

    mysqli_query($db, $sql) or die("Error F(x) UTTRM : ".mysqli_error($db));

    closeDB($db);
}

function updDtlTbhTrm($id, $val, $db){
    $sql = "UPDATE prterima2
            SET TBHDLL = '$val'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) UDTTRM : ".mysqli_error($db));
}

function delTrm($id)
{
    $db = openDB();

    $sql = "DELETE FROM prterima
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DTRM : ".mysqli_error($db));

    closeDB($db);
}

function delTTrm($id)
{
    $db = openDB();

    $sql = "DELETE FROM prterima_tmp
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DTTRM : ".mysqli_error($db));

    closeDB($db);
}

function delTrmTgl($tgl)
{
    $db = openDB();

    $sql = "DELETE FROM prfill
            WHERE DATE = '$tgl'";
            
    mysqli_query($db, $sql) or die("Error F(x) DTRMT : ".mysqli_error($db));

    $sql = "DELETE FROM prcut
            WHERE DATE = '$tgl'";
            
    mysqli_query($db, $sql) or die("Error F(x) DTRMT - 2 : ".mysqli_error($db));

    $sql = "DELETE FROM prterima
            WHERE DATE = '$tgl'";
            
    mysqli_query($db, $sql) or die("Error F(x) DTRMT - 3 : ".mysqli_error($db));

    $sql = "DELETE FROM hst_prterima
            WHERE ((EDITEDSTAT = 'NEW' || EDITEDSTAT = 'EDIT') && DATE_AFR = '$tgl') || (EDITEDSTAT = 'DELETE' && DATE_BFR = '$tgl')";

    mysqli_query($db, $sql) or die("Error F(x) DTRMT - 4 : ".mysqli_error($db));

    $sql = "DELETE FROM hst_prcut
            WHERE ((EDITEDSTAT = 'NEW' || EDITEDSTAT = 'EDIT') && DATE_AFR = '$tgl') || (EDITEDSTAT = 'DELETE' && DATE_BFR = '$tgl')";

    mysqli_query($db, $sql) or die("Error F(x) DTRMT - 5 : ".mysqli_error($db));

    $sql = "DELETE FROM hst_prfill
            WHERE ((EDITEDSTAT = 'NEW' || EDITEDSTAT = 'EDIT') && DATE_AFR = '$tgl') || (EDITEDSTAT = 'DELETE' && DATE_BFR = '$tgl')";

    mysqli_query($db, $sql) or die("Error F(x) DTRMT - 6 : ".mysqli_error($db));

    closeDB($db);
}

function delTrmTgl2($tgl, $db)
{
    $sql = "DELETE FROM prfill
            WHERE DATE = '$tgl'";
            
    mysqli_query($db, $sql) or die("Error F(x) DTRMT2 : ".mysqli_error($db));

    $sql = "DELETE FROM prcut
            WHERE DATE = '$tgl'";
            
    mysqli_query($db, $sql) or die("Error F(x) DTRMT2 - 2 : ".mysqli_error($db));

    $sql = "DELETE FROM prterima
            WHERE DATE = '$tgl'";
            
    mysqli_query($db, $sql) or die("Error F(x) DTRMT2 - 3 : ".mysqli_error($db));

    $sql = "DELETE FROM hst_prterima
            WHERE ((EDITEDSTAT = 'NEW' || EDITEDSTAT = 'EDIT') && DATE_AFR = '$tgl') || (EDITEDSTAT = 'DELETE' && DATE_BFR = '$tgl')";

    mysqli_query($db, $sql) or die("Error F(x) DTRMT2 - 4 : ".mysqli_error($db));

    $sql = "DELETE FROM hst_prcut
            WHERE ((EDITEDSTAT = 'NEW' || EDITEDSTAT = 'EDIT') && DATE_AFR = '$tgl') || (EDITEDSTAT = 'DELETE' && DATE_BFR = '$tgl')";

    mysqli_query($db, $sql) or die("Error F(x) DTRMT2 - 5 : ".mysqli_error($db));

    $sql = "DELETE FROM hst_prfill
            WHERE ((EDITEDSTAT = 'NEW' || EDITEDSTAT = 'EDIT') && DATE_AFR = '$tgl') || (EDITEDSTAT = 'DELETE' && DATE_BFR = '$tgl')";

    mysqli_query($db, $sql) or die("Error F(x) DTRMT2 - 6 : ".mysqli_error($db));
}

function delAllDtlTrm($id)
{
    $db = openDB();

    $sql = "DELETE FROM prterima2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADTRM : ".mysqli_error($db));

    closeDB($db);
}

function delAllDllTrm($id)
{
    $db = openDB();

    $sql = "DELETE FROM prterima3
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADLLTRM : ".mysqli_error($db));

    closeDB($db);
}

function delAllPDllTrm($id)
{
    $db = openDB();

    $sql = "DELETE FROM prterima4
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DAPDLLTRM : ".mysqli_error($db));

    closeDB($db);
}

function delAllDPTrm($id)
{
    $db = openDB();

    $sql = "DELETE FROM prterima5
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADPTRM : ".mysqli_error($db));

    closeDB($db);
}

function delAllTDllTrm($id)
{
    $db = openDB();

    $sql = "DELETE FROM prterima6
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DAPTLLTRM : ".mysqli_error($db));

    closeDB($db);
}

function delDtlTrm($id, $pro, $urut)
{
    $db = openDB();

    $sql = "DELETE FROM prterima2
            WHERE ID = '$id' && IDPRODUK = '$pro' && URUT = '$urut'";

    mysqli_query($db, $sql) or die("Error F(x) DDTRM : ".mysqli_error($db));

    closeDB($db);
}

//CUTTING
function getAllCut()
{
    $db = openDB();

    $sql = "SELECT ID, DATE, MARGIN, IDUSER, WKT, (SELECT SUM(WEIGHT) FROM prcut2 WHERE ID = P.ID), (SELECT SUM(TCUT1+TCUT2+TCUT3+TCUT4+TCUT5+TCUT6) FROM prcut2 WHERE ID = P.ID), TMARGIN, (SELECT SUM(TCUT1) FROM prcut2 WHERE GRADE = 'VIT' && ID = P.ID), (SELECT SUM(TCUT2) FROM prcut2 WHERE GRADE2 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT3) FROM prcut2 WHERE GRADE3 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT4) FROM prcut2 WHERE GRADE4 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT5) FROM prcut2 WHERE GRADE5 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT6) FROM prcut2 WHERE GRADE6 = 'VIT' && ID = P.ID), (SELECT SUM(WEIGHT) FROM prcut3 WHERE ID = P.ID), (SELECT SUM(WEIGHT) FROM prcut4 WHERE ID = P.ID) FROM prcut P
            WHERE DATE = CURDATE() ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GACUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllCutVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM prcut
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GACUTVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getCutFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, MARGIN, TMARGIN, IDUSER, WKT, (SELECT SUM(WEIGHT) FROM prcut2 WHERE ID = C.ID), (SELECT SUM(TCUT1+TCUT2+TCUT3+TCUT4+TCUT5+TCUT6) FROM prcut2 WHERE ID = C.ID), (SELECT SUM(P2.WEIGHT) FROM prfill2 P2 INNER JOIN prfill P ON P2.ID = P.ID WHERE P.CDATE = C.DATE), (SELECT SUM(WEIGHT) FROM prcut3 WHERE ID = C.ID), (SELECT SUM(WEIGHT) FROM prcut4 WHERE ID = C.ID), (SELECT SUM(P2.WEIGHT*P2.PRICE+P2.TBHDLL) FROM prterima2 P2 INNER JOIN prcut2 C2 ON P2.ID = C2.IDTERIMA && P2.IDPRODUK = C2.IDPRODUK && P2.URUT = C2.URUTTRM WHERE C2.ID = C.ID) FROM prcut C
            WHERE DATE >= '$frm' && DATE<= '$to' ORDER BY DATE, ID";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getCutFrmTo2($frm, $to)
{
    $db = openDB();

    $sql = "SELECT C.ID, C.DATE, C.MARGIN, C.TMARGIN, C.IDUSER, C.WKT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), C2.WEIGHT, C2.TCUT1, C2.TCUT2, C2.TCUT3, C2.TCUT4, C2.TCUT5, C2.TCUT6, C2.TCUT1 + C2.TCUT2 + C2.TCUT3 + C2.TCUT4 + C2.TCUT5 + C2.TCUT6 FROM prcut C INNER JOIN prcut2 C2 ON C.ID = C2.ID INNER JOIN dtproduk P ON C2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE C.DATE >= '$frm' && C.DATE <= '$to' ORDER BY C.DATE, C.ID, C2.URUT";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getCutFrmTo3($frm, $to, $db){
    $sql = "SELECT C.DATE, P.IDGRADE, G.NAME, SUM(C2.WEIGHT), SUM(IF(C2.GRADE = 'DLL', 0, C2.TCUT1)+IF(C2.GRADE2 = 'DLL', 0, C2.TCUT2)+IF(C2.GRADE3 = 'DLL', 0, C2.TCUT3)+IF(C2.GRADE4 = 'DLL', 0, C2.TCUT4)+IF(C2.GRADE5 = 'DLL', 0, C2.TCUT5)+IF(C2.GRADE6 = 'DLL', C2.TCUT6, 0)) FROM prcut C INNER JOIN prcut2 C2 ON C.ID = C2.ID INNER JOIN prterima2 T2 ON C2.IDTERIMA = T2.ID AND C2.URUTTRM = T2.URUT INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE C.DATE >= '$frm' && C.DATE <= '$to'
            GROUP BY C.DATE, P.IDGRADE, G.NAME
            ORDER BY C.DATE, G.NAME";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTFT3 : ".mysqli_error($db));

    $arr = array();
    $tmp = "";
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        if(strcasecmp($tmp, $row[0]) != 0){
            $arr[count($arr)] = array($row[0], "", "Tanpa grade", 0, 0);
            $tmp = $row[0];
        }

        $arr[count($arr)] = $row;
    }
    
    return $arr;
}

function getCutID($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, MARGIN, IDUSER, WKT, VERIF, VUSER, TMARGIN, IDGDG FROM prcut
            WHERE ID = '$id' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getHCutTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT (SELECT SUM(TCUT1) FROM prcut2 WHERE GRADE = 'VIT' && ID = P.ID), (SELECT SUM(TCUT2) FROM prcut2 WHERE GRADE2 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT3) FROM prcut2 WHERE GRADE3 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT4) FROM prcut2 WHERE GRADE4 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT5) FROM prcut2 WHERE GRADE5 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT6) FROM prcut2 WHERE GRADE6 = 'VIT' && ID = P.ID) FROM prcut P
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x0 GHCUTT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0]+$row[1]+$row[2]+$row[3]+$row[4]+$row[5];
}

function getCutItem($id)
{
    $db = openDB();

    $sql = "SELECT P2.ID, P2.IDPRODUK, P2.TCUT1, P2.TCUT2, P2.TCUT3, P2.TCUT4, P2.TCUT5, P2.TCUT6, P2.URUT, P2.IDTERIMA, P2.URUTTRM, P2.WEIGHT, P.NAME, G.NAME, DATE_FORMAT(T.DATE, '%d/%m/%Y'), S.NAME, P2.GRADE, P2.GRADE2, P2.GRADE3, P2.GRADE4, P2.GRADE5, P2.GRADE6, P2.KET, P2.NOSAMPLE, P2.IDPRODUK1, P2.IDPRODUK2, P2.IDPRODUK3, P2.IDPRODUK4, P2.IDPRODUK5, P2.IDPRODUK6, '' , '', '', '', '', '', T.KET1, P2.HSUHU, P2.ISPR FROM prcut2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN prterima T ON P2.IDTERIMA = T.ID INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE P2.ID = '$id' ORDER BY P2.NOSAMPLE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(strcasecmp($row[24],"") != 0)
        {
            $data = getProID2($row[24], $db);

            $row[30] = $data[1]." / ".$data[15];

            if(strcasecmp($data[16],"") != 0)
                $row[30] .= " / ".$data[16];

            if(strcasecmp($data[17],"") != 0)
                $row[30] .= " / ".$data[17];
        }
        
        if(strcasecmp($row[25],"") != 0)
        {
            $data = getProID2($row[25], $db);

            $row[31] = $data[1]." / ".$data[15];

            if(strcasecmp($data[16],"") != 0)
                $row[31] .= " / ".$data[16];

            if(strcasecmp($data[17],"") != 0)
                $row[31] .= " / ".$data[17];
        }

        if(strcasecmp($row[26],"") != 0)
        {
            $data = getProID2($row[26], $db);

            $row[32] = $data[1]." / ".$data[15];

            if(strcasecmp($data[16],"") != 0)
                $row[32] .= " / ".$data[16];

            if(strcasecmp($data[17],"") != 0)
                $row[32] .= " / ".$data[17];
        }

        if(strcasecmp($row[27],"") != 0)
        {
            $data = getProID2($row[27], $db);

            $row[33] = $data[1]." / ".$data[15];

            if(strcasecmp($data[16],"") != 0)
                $row[33] .= " / ".$data[16];

            if(strcasecmp($data[17],"") != 0)
                $row[33] .= " / ".$data[17];
        }

        if(strcasecmp($row[28],"") != 0)
        {
            $data = getProID2($row[28], $db);

            $row[34] = $data[1]." / ".$data[15];

            if(strcasecmp($data[16],"") != 0)
                $row[34] .= " / ".$data[16];

            if(strcasecmp($data[17],"") != 0)
                $row[34] .= " / ".$data[17];
        }
        
        if(strcasecmp($row[29],"") != 0)
        {
            $data = getProID2($row[29], $db);

            $row[35] = $data[1]." / ".$data[15];

            if(strcasecmp($data[16],"") != 0)
                $row[35] .= " / ".$data[16];

            if(strcasecmp($data[17],"") != 0)
                $row[35] .= " / ".$data[17];
        }

        $arr[count($arr)] = $row;
    }

    closeDB($db);

    return $arr;
}

function getCutPro($id, $db){
    $sql = "SELECT P3.ID, P3.IDPRODUK, P3.WEIGHT, P3.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, '') FROM prcut3 P3 INNER JOIN dtproduk P ON P3.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE P3.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getCutNPro($id, $db){
    $sql = "SELECT P4.ID, P4.IDPRODUK, P4.WEIGHT, P4.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, '') FROM prcut4 P4 INNER JOIN dtproduk P ON P4.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE P4.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTNPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getSumGradeCutID($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT G.NAME, (SELECT SUM(SP2.WEIGHT) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID WHERE SP.IDGRADE = P.IDGRADE && SP2.ID = P2.ID) FROM prcut2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE P2.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSGRDCUTID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumTotalCut($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT G.NAME, (SELECT SUM(SP2.TCUT1 + SP2.TCUT2 + SP2.TCUT3 + SP2.TCUT4 + SP2.TCUT5 + SP2.TCUT6) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID WHERE SP.IDGRADE = P.IDGRADE && SP2.ID = P2.ID) AS TOTAL FROM prcut2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID WHERE P2.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSTCUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getEkorTotalCut($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT G.NAME, (SELECT COUNT(SP2.ID) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID WHERE SP.IDGRADE = P.IDGRADE && SP2.ID = P2.ID) AS TOTAL FROM prcut2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID WHERE P2.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSTCUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumCutGradeTgl($grade, $tgl, $db){
    $sql = "SELECT SUM(C2.WEIGHT), SUM(IF(C2.GRADE = 'DLL', 0, C2.TCUT1)+IF(C2.GRADE2 = 'DLL', 0, C2.TCUT2)+IF(C2.GRADE3 = 'DLL', 0, C2.TCUT3)+IF(C2.GRADE4 = 'DLL', 0, C2.TCUT4)+IF(C2.GRADE5 = 'DLL', 0, C2.TCUT5)+IF(C2.GRADE6 = 'DLL', C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID INNER JOIN prterima2 T2 ON C2.IDTERIMA = T2.ID AND C2.URUTTRM = T2.URUT INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID
            WHERE P.IDGRADE = '$grade' && C.DATE = '$tgl'";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTGRDT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum;
}

function getSumGradeCutIDTgl($id, $tgl)
{
    $db = openDB();

    $sql = "SELECT DISTINCT G.NAME, (SELECT SUM(SP2.WEIGHT) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID INNER JOIN prterima ST ON SP2.IDTERIMA = ST.ID WHERE SP.IDGRADE = P.IDGRADE && SP2.ID = P2.ID && ST.DATE = '$tgl'), (SELECT SUM(SP2.TCUT1+SP2.TCUT2+SP2.TCUT3+SP2.TCUT4+SP2.TCUT5+SP2.TCUT6) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID INNER JOIN prterima ST ON SP2.IDTERIMA = ST.ID WHERE SP.IDGRADE = P.IDGRADE && SP2.ID = P2.ID && ST.DATE = '$tgl') FROM prcut2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN prterima T ON P2.IDTERIMA = T.ID
            WHERE P2.ID = '$id' && T.DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSGRDCUTIDTGL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumGradeCutProID($id, $pro)
{
    $db = openDB();

    $sql = "SELECT DISTINCT G.NAME, (SELECT SUM(SP2.WEIGHT) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID WHERE SP.IDGRADE = P.IDGRADE && UPPER(SP.NAME) = '$pro' && SP2.ID = P2.ID), (SELECT SUM(SP2.TCUT1+SP2.TCUT2+SP2.TCUT3+SP2.TCUT4+SP2.TCUT5+SP2.TCUT6) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID WHERE SP.IDGRADE = P.IDGRADE && UPPER(SP.NAME) = '$pro' && SP2.ID = P2.ID) FROM prcut2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE P2.ID = '$id' && UPPER(P.NAME) = '$pro'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSGRDCUTPROID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumGradeCutKotaID($id, $kota)
{
    $db = openDB();

    $sql = "SELECT DISTINCT G.NAME, (SELECT SUM(SP2.WEIGHT) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID INNER JOIN prterima ST ON SP2.IDTERIMA = ST.ID INNER JOIN dtsup SS ON ST.IDSUP = SS.ID WHERE SP.IDGRADE = P.IDGRADE && SP2.ID = P2.ID && UPPER(SS.REG) = '$kota'), (SELECT SUM(SP2.TCUT1+SP2.TCUT2+SP2.TCUT3+SP2.TCUT4+SP2.TCUT5+SP2.TCUT6) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID INNER JOIN prterima ST ON SP2.IDTERIMA = ST.ID INNER JOIN dtsup SS ON ST.IDSUP = SS.ID WHERE SP.IDGRADE = P.IDGRADE && SP2.ID = P2.ID && UPPER(SS.REG) = '$kota') FROM prcut2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN prterima T ON P2.IDTERIMA = T.ID INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE P2.ID = '$id' && UPPER(S.REG) = '$kota'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSGRDCUTKTAID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumGradeCutKotaIDTgl($id, $kota, $tgl)
{
    $db = openDB();
    
    $sql = "SELECT DISTINCT G.NAME, (SELECT SUM(SP2.WEIGHT) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID INNER JOIN prterima ST ON SP2.IDTERIMA = ST.ID INNER JOIN dtsup SS ON ST.IDSUP = SS.ID WHERE SP.IDGRADE = P.IDGRADE && SP2.ID = P2.ID && UPPER(SS.REG) = '$kota' && ST.DATE = '$tgl'), (SELECT SUM(SP2.TCUT1+SP2.TCUT2+SP2.TCUT3+SP2.TCUT4+SP2.TCUT5+SP2.TCUT6) FROM prcut2 SP2 INNER JOIN dtproduk SP ON SP2.IDPRODUK = SP.ID INNER JOIN prterima ST ON SP2.IDTERIMA = ST.ID INNER JOIN dtsup SS ON ST.IDSUP = SS.ID WHERE SP.IDGRADE = P.IDGRADE && SP2.ID = P2.ID && UPPER(SS.REG) = '$kota' && ST.DATE = '$tgl') FROM prcut2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN prterima T ON P2.IDTERIMA = T.ID INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE P2.ID = '$id' && UPPER(S.REG) = '$kota' && T.DATE = '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSGRDCUTKTAIDTGL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumBBCutID($id, $db){
    $sql = "SELECT SUM(ROUND(WEIGHT,2)) FROM prcut2
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSBBCUTID : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(ROUND((TCUT1+TCUT2+TCUT3+TCUT4+TCUT5+TCUT6),2)) FROM prcut2
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSBBCUTID - 2 : ".mysqli_error($db));

    $sum2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(WEIGHT) FROM prcut3
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSBBCUTID - 3 : ".mysqli_error($db));

    $sum3 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(WEIGHT) FROM prcut4
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSBBCUTID - 4 : ".mysqli_error($db));

    $sum4 = mysqli_fetch_array($result, MYSQLI_NUM);
    
    return number_format($sum[0]-$sum2[0]-$sum3[0]-$sum4[0], 2, '.', ',');
}

function getCutIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM prcut
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getCutHIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prcut
            WHERE DATE_AFR = '$tgl' && EDITEDSTAT = 'NEW'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTHIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getCutHIDTgl2($id, $db)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDSTAT FROM hst_prcut
            WHERE IDTRAN_AFR = '$id' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d') ORDER BY EDITEDON DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTHIDTGL2 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    if(strcasecmp($row[1],"EDIT") != 0){
        $row[0] = "";
    }

    closeDB($db);

    return $row[0];
}

function getSisaHCut($vtgl, $ctgl, $db, $type = "1"){
    $sql = "SELECT SUM(IF(STRCMP(C2.IDPRODUK1,'') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2,'') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3,'') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4,'') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5,'') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6,'') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID
            WHERE C.DATE = '$ctgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSHCUT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID
            WHERE F.CDATE = '$ctgl'";

    if(strcasecmp($type,"1") == 0){
        $sql .= " && DATE < '$vtgl'";
    }
    else if(strcasecmp($type,"2") == 0){
        $sql .= " && DATE <= '$vtgl'";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) GSHCUT - 2 : ".mysqli_error($db));

    $sum2 = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0] - $sum2[0];
}

function getDllCutID($id)
{
    $db = openDB();

    $arr = array();
    $sql = "SELECT DISTINCT IDPRODUK1 FROM prcut2
            WHERE ID = '$id' && IDPRODUK1 != '' && GRADE = 'Dll'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GDLLCUTID : ".mysqli_error($db));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $cek = false;
        for($i = 0; $i < count($arr); $i++)
        {
            if(strcasecmp($arr[$i], $row[0]) == 0)
            {
                $cek = true;
                break;
            }
        }

        if(!$cek)
            $arr[count($arr)] = $row[0];
    }

    $sql = "SELECT DISTINCT IDPRODUK2 FROM prcut2
            WHERE ID = '$id' && IDPRODUK2 != '' && GRADE2 = 'Dll'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GDLLCUTID - 2 : ".mysqli_error($db));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $cek = false;
        for($i = 0; $i < count($arr); $i++)
        {
            if(strcasecmp($arr[$i], $row[0]) == 0)
            {
                $cek = true;
                break;
            }
        }

        if(!$cek)
            $arr[count($arr)] = $row[0];
    }

    $sql = "SELECT DISTINCT IDPRODUK3 FROM prcut2
            WHERE ID = '$id' && IDPRODUK3 != '' && GRADE3 = 'Dll'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GDLLCUTID - 3 : ".mysqli_error($db));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $cek = false;
        for($i = 0; $i < count($arr); $i++)
        {
            if(strcasecmp($arr[$i], $row[0]) == 0)
            {
                $cek = true;
                break;
            }
        }

        if(!$cek)
            $arr[count($arr)] = $row[0];
    }

    $sql = "SELECT DISTINCT IDPRODUK4 FROM prcut2
            WHERE ID = '$id' && IDPRODUK4 != '' && GRADE4 = 'Dll'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GDLLCUTID - 4 : ".mysqli_error($db));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $cek = false;
        for($i = 0; $i < count($arr); $i++)
        {
            if(strcasecmp($arr[$i], $row[0]) == 0)
            {
                $cek = true;
                break;
            }
        }

        if(!$cek)
            $arr[count($arr)] = $row[0];
    }

    $sql = "SELECT DISTINCT IDPRODUK5 FROM prcut2
            WHERE ID = '$id' && IDPRODUK5 != '' && GRADE5 = 'Dll'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GDLLCUTID - 5 : ".mysqli_error($db));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $cek = false;
        for($i = 0; $i < count($arr); $i++)
        {
            if(strcasecmp($arr[$i], $row[0]) == 0)
            {
                $cek = true;
                break;
            }
        }

        if(!$cek)
            $arr[count($arr)] = $row[0];
    }

    $sql = "SELECT DISTINCT IDPRODUK6 FROM prcut2
            WHERE ID = '$id' && IDPRODUK6 != '' && GRADE6 = 'Dll'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GDLLCUTID - 6 : ".mysqli_error($db));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $cek = false;
        for($i = 0; $i < count($arr); $i++)
        {
            if(strcasecmp($arr[$i], $row[0]) == 0)
            {
                $cek = true;
                break;
            }
        }

        if(!$cek)
            $arr[count($arr)] = $row[0];
    }

    closeDB($db);

    return $arr;
}

function getHstCutFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, IDTRAN_BFR, DATE_BFR, TMARGIN_BFR, MARGIN_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, TMARGIN_AFR, MARGIN_AFR, IDUSER_AFR, WKT_AFR FROM hst_prcut";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHCUTFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHCutID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT T.IDTRAN_BFR, DATE_FORMAT(T.DATE_BFR, '%d/%m/%Y'), TMARGIN_BFR, MARGIN_BFR, T.IDUSER_BFR, DATE_FORMAT(T.WKT_BFR, '%d/%m/%Y') FROM hst_prcut T";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT T.IDTRAN_AFR, DATE_FORMAT(T.DATE_AFR, '%d/%m/%Y'), TMARGIN_AFR, MARGIN_AFR, T.IDUSER_AFR, DATE_FORMAT(T.WKT_AFR, '%d/%m/%Y') FROM hst_prcut T";

    $sql .= " WHERE T.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHCUTID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getHCutItem($id, $type)
{
    $db = openDB();

    $sql = "SELECT T2.ID, T2.IDTRAN, T2.IDPRODUK, T2.WEIGHT, T2.TCUT1, T2.TCUT2, T2.TCUT3, T2.TCUT4, T2.TCUT5, T2.TCUT6, T2.TYPE, T2.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), IF(STRCMP(T2.GRADE, 'Dll') = 0, T2.IDPRODUK1, T2.GRADE), IF(STRCMP(T2.GRADE2, 'Dll') = 0, T2.IDPRODUK2, T2.GRADE2), IF(STRCMP(T2.GRADE3, 'Dll') = 0, T2.IDPRODUK3, T2.GRADE3), IF(STRCMP(T2.GRADE4, 'Dll') = 0, T2.IDPRODUK4, T2.GRADE4), IF(STRCMP(T2.GRADE5, 'Dll') = 0, T2.IDPRODUK5, T2.GRADE5), IF(STRCMP(T2.GRADE6, 'Dll') = 0, T2.IDPRODUK6, T2.GRADE6), T2.NOSAMPLE, S.NAME FROM hst_prcut2 T2 LEFT JOIN dtproduk P ON T2.IDPRODUK = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN prterima PT ON T2.IDTERIMA = PT.ID LEFT JOIN dtsup S ON PT.IDSUP = S.ID
            WHERE T2.ID = '$id' && T2.TYPE = '$type' ORDER BY T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHCUTITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumCutFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT ROUND(IFNULL(SUM(IF(STRCMP(P2.IDPRODUK1, '') = 0, P2.TCUT1, 0)+IF(STRCMP(P2.IDPRODUK2, '') = 0, P2.TCUT2, 0)+IF(STRCMP(P2.IDPRODUK3, '') = 0, P2.TCUT3, 0)+IF(STRCMP(P2.IDPRODUK4, '') = 0, P2.TCUT4, 0)+IF(STRCMP(P2.IDPRODUK5, '') = 0, P2.TCUT5, 0)+IF(STRCMP(P2.IDPRODUK6, '') = 0, P2.TCUT6, 0)), 0), 2), COUNT(P2.IDPRODUK) FROM prcut2 P2 INNER JOIN prcut P ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumCutFrmTo2($frm, $to)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.TCUT1+P2.TCUT2+P2.TCUT3+P2.TCUT4+P2.TCUT5+P2.TCUT6), COUNT(P2.IDPRODUK) FROM prcut2 P2 INNER JOIN prcut P ON P.ID = P2.ID INNER JOIN prterima T ON P2.IDTERIMA = T.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to' && T.KOTA = ''";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT2 : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum;
}

function getSumCutFrmTo3($frm, $to, $gdg)
{
    $db = openDB();

    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && IDGDG = '$gdg'";
    }

    $sql = "SELECT CDATE FROM prfill
            WHERE DATE >= '$frm' && DATE <= '$to' $whr ORDER BY CDATE ASC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT3 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT CDATE FROM prfill
            WHERE DATE >= '$frm' && DATE <= '$to' $whr ORDER BY CDATE DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT3 - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(P2.TCUT1+P2.TCUT2+P2.TCUT3+P2.TCUT4+P2.TCUT5+P2.TCUT6) FROM prcut2 P2 INNER JOIN prcut P ON P.ID = P2.ID
            WHERE P.DATE >= '$row[0]' && P.DATE <= '$row2[0]' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT3 - 3 : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumCutFrmTo4($frm, $to, $pro, $gdg)
{
    $db = openDB();
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && IDGDG = '$gdg'";
    }

    $sql = "SELECT CDATE FROM prfill
            WHERE DATE >= '$frm' && DATE <= '$to' $whr ORDER BY CDATE ASC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT4 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT CDATE FROM prfill
            WHERE DATE >= '$frm' && DATE <= '$to' $whr ORDER BY CDATE DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT4 - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(IF(STRCMP(P2.IDPRODUK1,'') = 0, P2.TCUT1, 0)+IF(STRCMP(P2.IDPRODUK2,'') = 0, P2.TCUT2, 0)+IF(STRCMP(P2.IDPRODUK3,'') = 0, P2.TCUT3, 0)+IF(STRCMP(P2.IDPRODUK4,'') = 0, P2.TCUT4, 0)+IF(STRCMP(P2.IDPRODUK5,'') = 0, P2.TCUT5, 0)+IF(STRCMP(P2.IDPRODUK6,'') = 0, P2.TCUT6, 0)) FROM prcut2 P2 INNER JOIN prcut P ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && P2.IDPRODUK = '$pro' $whr";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT4 - 3 : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumCutFrmTo5($frm, $pro, $gdg)
{
    $db = openDB();
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && IDGDG = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(IF(STRCMP(P2.IDPRODUK1,'') = 0, P2.TCUT1, 0)+IF(STRCMP(P2.IDPRODUK2,'') = 0, P2.TCUT2, 0)+IF(STRCMP(P2.IDPRODUK3,'') = 0, P2.TCUT3, 0)+IF(STRCMP(P2.IDPRODUK4,'') = 0, P2.TCUT4, 0)+IF(STRCMP(P2.IDPRODUK5,'') = 0, P2.TCUT5, 0)+IF(STRCMP(P2.IDPRODUK6,'') = 0, P2.TCUT6, 0)),2) FROM prcut2 P2 INNER JOIN prcut P ON P.ID = P2.ID
            WHERE P.DATE < '$frm' && P2.IDPRODUK = '$pro' $whr";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT5 - 2 : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumCutFrmTo6($frm, $to, $db)
{
    $sql = "SELECT SUM(P2.TCUT1+P2.TCUT2+P2.TCUT3+P2.TCUT4+P2.TCUT5+P2.TCUT6), COUNT(P2.IDPRODUK) FROM prcut2 P2 INNER JOIN prcut P ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getSumCutFrmTo7($frm, $to, $pro, $gdg, $db)
{
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && IDGDG = '$gdg'";
    }

    $sql = "SELECT CDATE FROM prfill
            WHERE DATE >= '$frm' && DATE <= '$to' $whr ORDER BY CDATE ASC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT7 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT CDATE FROM prfill
            WHERE DATE >= '$frm' && DATE <= '$to' $whr ORDER BY CDATE DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT7 - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(IF(STRCMP(P2.IDPRODUK1,'') = 0, P2.TCUT1, 0)+IF(STRCMP(P2.IDPRODUK2,'') = 0, P2.TCUT2, 0)+IF(STRCMP(P2.IDPRODUK3,'') = 0, P2.TCUT3, 0)+IF(STRCMP(P2.IDPRODUK4,'') = 0, P2.TCUT4, 0)+IF(STRCMP(P2.IDPRODUK5,'') = 0, P2.TCUT5, 0)+IF(STRCMP(P2.IDPRODUK6,'') = 0, P2.TCUT6, 0)) FROM prcut2 P2 INNER JOIN prcut P ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && P2.IDPRODUK = '$pro' $whr";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT7 - 3 : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getSumCutFrmTo8($frm, $pro, $gdg, $db)
{
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && IDGDG = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(IF(STRCMP(P2.IDPRODUK1,'') = 0, P2.TCUT1, 0)+IF(STRCMP(P2.IDPRODUK2,'') = 0, P2.TCUT2, 0)+IF(STRCMP(P2.IDPRODUK3,'') = 0, P2.TCUT3, 0)+IF(STRCMP(P2.IDPRODUK4,'') = 0, P2.TCUT4, 0)+IF(STRCMP(P2.IDPRODUK5,'') = 0, P2.TCUT5, 0)+IF(STRCMP(P2.IDPRODUK6,'') = 0, P2.TCUT6, 0)),2) FROM prcut2 P2 INNER JOIN prcut P ON P.ID = P2.ID
            WHERE P.DATE < '$frm' && P2.IDPRODUK = '$pro' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSCUTFT8 - 2 : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getLastIDCut($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM prcut
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDCUT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDCut2($aw, $ak, $db)
{
    $sql = "SELECT ID FROM prcut
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDCUT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastUrutCut($id)
{
    $db = openDB();

    $sql = "SELECT URUT FROM prcut2
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUCUT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastSumThrCut()
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE, (SELECT SUM(SP2.TCUT1+SP2.TCUT2+SP2.TCUT3+SP2.TCUT4+SP2.TCUT5+SP2.TCUT6) FROM prcut SP INNER JOIN prcut2 SP2 ON SP.ID = SP2.ID WHERE SP.DATE = P.DATE) FROM prcut P ORDER BY DATE DESC LIMIT 0, 30";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSTCUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastSampleCut($id)
{
    $db = openDB();

    $sql = "SELECT C2.NOSAMPLE FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID
            WHERE C.DATE = '$id' ORDER BY C2.NOSAMPLE DESC";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GLSMPLCUT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDHCut($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prcut
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHCUT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDHCut2($aw, $ak, $db)
{
    $sql = "SELECT ID FROM hst_prcut
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHCUT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastUrutHCutPro($id, $db){
    $sql = "SELECT URUT FROM prcut3
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUHCUTPRO : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastUrutHCutNPro($id, $db){
    $sql = "SELECT URUT FROM prcut4
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUHCUTNPRO : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getListProCut($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT UPPER(NAME) FROM dtproduk P INNER JOIN prcut2 C2 ON P.ID = C2.IDPRODUK
            WHERE C2.ID = '$id'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GLPROCUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getListKotaCut($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT UPPER(S.REG) AS SREG FROM prcut2 C2 INNER JOIN prterima T ON C2.IDTERIMA = T.ID INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE C2.ID = '$id' ORDER BY SREG";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLKTACUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getListKotaCutTgl($id, $tgl)
{
    $db = openDB();

    $sql = "SELECT DISTINCT UPPER(S.REG) FROM prcut2 C2 INNER JOIN prterima T ON C2.IDTERIMA = T.ID INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE C2.ID = '$id' && T.DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLKTACUTTGL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getListTglCut($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT T.DATE FROM prcut2 C2 INNER JOIN prterima T ON C2.IDTERIMA = T.ID
            WHERE C2.ID = '$id' ORDER BY T.DATE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLTGLCUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getCutNoSampleDbl($id, $db){
    $sql = "SELECT NOSAMPLE, (SELECT COUNT(ID) FROM prcut2 WHERE ID = P2.ID AND NOSAMPLE = P2.NOSAMPLE) FROM prcut2 P2
            WHERE ID = '$id' && (SELECT COUNT(ID) FROM prcut2 WHERE ID = P2.ID AND NOSAMPLE = P2.NOSAMPLE) > 1 ORDER BY NOSAMPLE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GCUTNSD : ".mysqli_error($db));

    $hsl = "";
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        if(strcasecmp($hsl,"") != 0){
            $hsl .= ", ";
        }
        $hsl .= $row[0];
    }

    return $hsl;
}

function getBBCutGrade($tgl, $db){
    $sql = "SELECT DISTINCT G.ID, G.NAME FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID INNER JOIN prterima2 T2 ON C2.IDTERIMA = T2.ID AND C2.URUTTRM = T2.URUT INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE C.DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GBBCUTGRD : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function countCutID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prcut
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CCUTID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countCutNoSample($tgl, $no, $db){
    $sql = "SELECT COUNT(P2.ID) FROM prcut2 P2 INNER JOIN prcut P ON P2.ID = P.ID
            WHERE P.DATE = '$tgl' && P2.NOSAMPLE = '$no'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CCUTNS : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countCut($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prcut
            WHERE ID LIKE '%$id%' || DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CCUT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countCutItemTrm($trm, $pro, $utrm)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prcut2
            WHERE IDTERIMA = '$trm' && URUTTRM = '$utrm'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CCUTITMTRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countCutTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prcut
            WHERE DATE = '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) CCUTTGL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schCut($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), MARGIN, IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i'), (SELECT SUM(WEIGHT) FROM prcut2 WHERE ID = P.ID), (SELECT SUM(TCUT1+TCUT2+TCUT3+TCUT4+TCUT5+TCUT6) FROM prcut2 WHERE ID = P.ID), TMARGIN, (SELECT SUM(TCUT1) FROM prcut2 WHERE GRADE = 'VIT' && ID = P.ID), (SELECT SUM(TCUT2) FROM prcut2 WHERE GRADE2 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT3) FROM prcut2 WHERE GRADE3 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT4) FROM prcut2 WHERE GRADE4 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT5) FROM prcut2 WHERE GRADE5 = 'VIT' && ID = P.ID), (SELECT SUM(TCUT6) FROM prcut2 WHERE GRADE6 = 'VIT' && ID = P.ID), (SELECT SUM(WEIGHT) FROM prcut3 WHERE ID = P.ID), (SELECT SUM(WEIGHT) FROM prcut4 WHERE ID = P.ID) FROM prcut P";

    if(countCut($id) > 0)
        $sql .= " WHERE (ID LIKE '%$id%' || DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$id%')";
    else
    {
        $y = explode(" ",$id);
        
        $sql .= " WHERE (";
        for($i = 0; $i < count($y); $i++)
        {
            $sch = $y[$i];
            for($j = 0; $j < count($y); $j++)
            {
                if($j == $i)
                    continue;
                
                $sch = $sch."%".$y[$j];
            }
            
            $sql .= "ID LIKE '%$sch%' || DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }

    if(strcasecmp($id,"") == 0)
        $sql .= " && DATE = CURDATE()";

    $sql .= " ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) SCUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $row[16] = $row[15];
        $row[15] = $row[14];
        $row[14] = $row[8]+$row[9]+$row[10]+$row[11]+$row[12]+$row[13];
        $arr[count($arr)] = $row;
    }

    closeDB($db);

    return $arr;
}

function setCutVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE prcut
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SCUTVRF : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProCut($id = "")
{
    $db = openDB();

    $whr = "";
    if(strcasecmp($id,"") != 0){
        $whr = " && SP2.ID = '$id'";
    }

    $sql = "UPDATE dtproduk P
            SET CQTY = ROUND((SELECT SUM(WEIGHT) FROM prcut2 SP2 WHERE IDPRODUK = P.ID $whr), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROCUT : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET CQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prcut2 SP2 INNER JOIN prcut SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG $whr), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROCUT - 2 : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProCut_2($db)
{
    $sql = "UPDATE dtproduk P
            SET CQTY = ROUND((SELECT SUM(WEIGHT) FROM prcut2 WHERE IDPRODUK = P.ID), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROCUT : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET CQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prcut2 SP2 INNER JOIN prcut SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROCUT - 2 : ".mysqli_error($db));
}

function updQtyProCut2($id = "")
{
    $db = openDB();

    $whr = "";
    $whr2 = "";
    if(strcasecmp($id,"") != 0){
        $whr = " WHERE SP2.ID = '$id'";
        $whr2 = " && SP2.ID = '$id'";
    }
    
    $sql = "UPDATE dtproduk P
            SET CINQTY = ROUND((SELECT SUM(IF(STRCMP(IDPRODUK1, P.ID) = 0, TCUT1, 0)+IF(STRCMP(IDPRODUK2, P.ID) = 0, TCUT2, 0)+IF(STRCMP(IDPRODUK3, P.ID) = 0, TCUT3, 0)+IF(STRCMP(IDPRODUK4, P.ID) = 0, TCUT4, 0)+IF(STRCMP(IDPRODUK5, P.ID) = 0, TCUT5, 0)+IF(STRCMP(IDPRODUK6, P.ID) = 0, TCUT6, 0)) FROM prcut2 SP2 $whr), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROCUT2 : ".mysqli_error($db));
    
    $sql = "UPDATE dtgpro P
            SET CINQTY = ROUND((SELECT SUM(IF(STRCMP(SP2.IDPRODUK1, P.IDPRODUK) = 0, SP2.TCUT1, 0)+IF(STRCMP(SP2.IDPRODUK2, P.IDPRODUK) = 0, SP2.TCUT2, 0)+IF(STRCMP(SP2.IDPRODUK3, P.IDPRODUK) = 0, SP2.TCUT3, 0)+IF(STRCMP(SP2.IDPRODUK4, P.IDPRODUK) = 0, SP2.TCUT4, 0)+IF(STRCMP(SP2.IDPRODUK5, P.IDPRODUK) = 0, SP2.TCUT5, 0)+IF(STRCMP(SP2.IDPRODUK6, P.IDPRODUK) = 0, SP2.TCUT6, 0)) FROM prcut2 SP2 INNER JOIN prcut SP ON SP2.ID = SP.ID WHERE SP.IDGDG = P.IDGDG $whr2), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROCUT2 - 2 : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProCut2_2($db)
{
    $sql = "UPDATE dtproduk P
            SET CINQTY = ROUND((SELECT SUM(IF(STRCMP(IDPRODUK1, P.ID) = 0, TCUT1, 0)+IF(STRCMP(IDPRODUK2, P.ID) = 0, TCUT2, 0)+IF(STRCMP(IDPRODUK3, P.ID) = 0, TCUT3, 0)+IF(STRCMP(IDPRODUK4, P.ID) = 0, TCUT4, 0)+IF(STRCMP(IDPRODUK5, P.ID) = 0, TCUT5, 0)+IF(STRCMP(IDPRODUK6, P.ID) = 0, TCUT6, 0)) FROM prcut2), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROCUT2 : ".mysqli_error($db));
    
    $sql = "UPDATE dtgpro P
            SET CINQTY = ROUND((SELECT SUM(IF(STRCMP(SP2.IDPRODUK1, P.IDPRODUK) = 0, SP2.TCUT1, 0)+IF(STRCMP(SP2.IDPRODUK2, P.IDPRODUK) = 0, SP2.TCUT2, 0)+IF(STRCMP(SP2.IDPRODUK3, P.IDPRODUK) = 0, SP2.TCUT3, 0)+IF(STRCMP(SP2.IDPRODUK4, P.IDPRODUK) = 0, SP2.TCUT4, 0)+IF(STRCMP(SP2.IDPRODUK5, P.IDPRODUK) = 0, SP2.TCUT5, 0)+IF(STRCMP(SP2.IDPRODUK6, P.IDPRODUK) = 0, SP2.TCUT6, 0)) FROM prcut2 SP2 INNER JOIN prcut SP ON SP2.ID = SP.ID WHERE SP.IDGDG = P.IDGDG), 2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROCUT2 - 2 : ".mysqli_error($db));
}

function getHslCutTgl($tgl, $db){
    $sql = "SELECT SUM(C2.TCUT1+C2.TCUT2+C2.TCUT3+C2.TCUT4+C2.TCUT5+C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID
            WHERE C.DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHCUTT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function newCut($id, $tgl, $mrgn, $user, $wkt, $tmrgn, $gdg)
{
    $db = openDB();

    $sql = "INSERT INTO prcut
            (ID, DATE, MARGIN, IDUSER, WKT, TMARGIN, IDGDG)
            VALUES
            ('$id', '$tgl', '$mrgn', '$user', '$wkt', '$tmrgn', '$gdg')";

    mysqli_query($db, $sql) or die("Error F(x) NCUT : ".mysqli_error($db));

    closeDB($db);
}

function newCut2($id, $tgl, $mrgn, $user, $wkt, $tmrgn, $db)
{
    $sql = "INSERT INTO prcut
            (ID, DATE, MARGIN, IDUSER, WKT, TMARGIN)
            VALUES
            ('$id', '$tgl', '$mrgn', '$user', '$wkt', '$tmrgn')";

    mysqli_query($db, $sql) or die("Error F(x) NCUT : ".mysqli_error($db));
}

function newDtlCut($id, $pro, $cut1, $cut2, $cut3, $cut4, $cut5, $cut6, $urut, $trm, $utrm, $weight, $scut1, $scut2, $scut3, $scut4, $scut5, $scut6, $ket, $nsmpl, $pro1 = "", $pro2 = "", $pro3 = "", $pro4 = "", $pro5 = "", $pro6 = "", $suhu = "R", $pr = "N")
{
    $db = openDB();

    $sql = "INSERT INTO prcut2
            (ID, IDPRODUK, TCUT1, TCUT2, TCUT3, TCUT4, TCUT5, TCUT6, URUT, IDTERIMA, URUTTRM, WEIGHT, GRADE, GRADE2, GRADE3, GRADE4, GRADE5, GRADE6, KET, NOSAMPLE, IDPRODUK1, IDPRODUK2, IDPRODUK3, IDPRODUK4, IDPRODUK5, IDPRODUK6, HSUHU, ISPR)
            VALUES
            ('$id', '$pro', '$cut1', '$cut2', '$cut3', '$cut4', '$cut5', '$cut6', '$urut', '$trm', '$utrm', '$weight', '$scut1', '$scut2', '$scut3', '$scut4', '$scut5', '$scut6', '$ket', '$nsmpl', '$pro1', '$pro2', '$pro3', '$pro4', '$pro5', '$pro6', '$suhu', '$pr')";

    mysqli_query($db, $sql) or die("Error F(x) NDCUT : ".mysqli_error($db));

    closeDB($db);
}

function newDtlCut2($id, $pro, $cut1, $cut2, $cut3, $cut4, $cut5, $cut6, $urut, $trm, $utrm, $weight, $scut1, $scut2, $scut3, $scut4, $scut5, $scut6, $ket, $nsmpl, $db, $pro1 = "", $pro2 = "", $pro3 = "", $pro4 = "", $pro5 = "", $pro6 = "", $suhu = "R", $pr = "N")
{
    $sql = "INSERT INTO prcut2
            (ID, IDPRODUK, TCUT1, TCUT2, TCUT3, TCUT4, TCUT5, TCUT6, URUT, IDTERIMA, URUTTRM, WEIGHT, GRADE, GRADE2, GRADE3, GRADE4, GRADE5, GRADE6, KET, NOSAMPLE, IDPRODUK1, IDPRODUK2, IDPRODUK3, IDPRODUK4, IDPRODUK5, IDPRODUK6, HSUHU, ISPR)
            VALUES
            ('$id', '$pro', '$cut1', '$cut2', '$cut3', '$cut4', '$cut5', '$cut6', '$urut', '$trm', '$utrm', '$weight', '$scut1', '$scut2', '$scut3', '$scut4', '$scut5', '$scut6', '$ket', '$nsmpl', '$pro1', '$pro2', '$pro3', '$pro4', '$pro5', '$pro6', '$suhu', '$pr')";

    mysqli_query($db, $sql) or die("Error F(x) NDCUT2 : ".mysqli_error($db));
}

function newHCutPro($id, $pro, $weight, $urut, $db){
    $sql = "INSERT INTO prcut3
            (ID, IDPRODUK, WEIGHT, URUT)
            VALUES
            ('$id', '$pro', '$weight', '$urut')";

    mysqli_query($db, $sql) or die("Error F(x) NHCUTPRO : ".mysqli_error($db));
}

function newHCutNPro($id, $pro, $weight, $urut, $db){
    $sql = "INSERT INTO prcut4
            (ID, IDPRODUK, WEIGHT, URUT)
            VALUES
            ('$id', '$pro', '$weight', '$urut')";

    mysqli_query($db, $sql) or die("Error F(x) NHCUTNPRO : ".mysqli_error($db));
}

function newHstCut($id, $idtran_bfr, $tgl_bfr, $mrgn_bfr, $user_bfr, $wkt_bfr, $tmrgn_bfr, $idtran_afr, $tgl_afr, $mrgn_afr, $user_afr, $wkt_afr, $tmrgn_afr, $eby, $eon, $estat, $gdg_bfr, $gdg_afr)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prcut
            (ID, IDTRAN_BFR, DATE_BFR, MARGIN_BFR, IDUSER_BFR, WKT_BFR, TMARGIN_BFR, IDTRAN_AFR, DATE_AFR, MARGIN_AFR, IDUSER_AFR, WKT_AFR, TMARGIN_AFR, EDITEDBY, EDITEDON, EDITEDSTAT, IDGDG_BFR, IDGDG_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$mrgn_bfr', '$user_bfr', '$wkt_bfr', '$tmrgn_bfr', '$idtran_afr', '$tgl_afr', '$mrgn_afr', '$user_afr', '$wkt_afr', '$tmrgn_afr', '$eby', '$eon', '$estat', '$gdg_bfr', '$gdg_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHCUT : ".mysqli_error($db));

    closeDB($db);
}

function newHstCut2($id, $idtran_bfr, $tgl_bfr, $mrgn_bfr, $user_bfr, $wkt_bfr, $tmrgn_bfr, $idtran_afr, $tgl_afr, $mrgn_afr, $user_afr, $wkt_afr, $tmrgn_afr, $eby, $eon, $estat, $db)
{
    $sql = "INSERT INTO hst_prcut
            (ID, IDTRAN_BFR, DATE_BFR, MARGIN_BFR, IDUSER_BFR, WKT_BFR, TMARGIN_BFR, IDTRAN_AFR, DATE_AFR, MARGIN_AFR, IDUSER_AFR, WKT_AFR, TMARGIN_AFR, EDITEDBY, EDITEDON, EDITEDSTAT)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$mrgn_bfr', '$user_bfr', '$wkt_bfr', '$tmrgn_bfr', '$idtran_afr', '$tgl_afr', '$mrgn_afr', '$user_afr', '$wkt_afr', '$tmrgn_afr', '$eby', '$eon', '$estat')";

    mysqli_query($db, $sql) or die("Error F(x) NHCUT : ".mysqli_error($db));
}

function newHstDtlCut($id, $idtran, $pro, $cut1, $cut2, $cut3, $cut4, $cut5, $cut6, $urut, $trm, $utrm, $weight, $type, $scut1, $scut2, $scut3, $scut4, $scut5, $scut6, $ket, $nsmpl, $pro1 = "", $pro2 = "", $pro3 = "", $pro4 = "", $pro5 = "", $pro6 = "", $suhu = "R", $pr = "N")
{
    $db = openDB();

    $sql = "INSERT INTO hst_prcut2
            (ID, IDTRAN, IDPRODUK, TCUT1, TCUT2, TCUT3, TCUT4, TCUT5, TCUT6, URUT, IDTERIMA, URUTTRM, WEIGHT, TYPE, GRADE, GRADE2, GRADE3, GRADE4, GRADE5, GRADE6, KET, NOSAMPLE, IDPRODUK1, IDPRODUK2, IDPRODUK3, IDPRODUK4, IDPRODUK5, IDPRODUK6, HSUHU, ISPR)
            VALUES
            ('$id', '$idtran', '$pro', '$cut1', '$cut2', '$cut3', '$cut4', '$cut5', '$cut6', '$urut', '$trm', '$utrm', '$weight', '$type', '$scut1', '$scut2', '$scut3', '$scut4', '$scut5', '$scut6', '$ket', '$nsmpl', '$pro1', '$pro2', '$pro3', '$pro4', '$pro5', '$pro6', '$suhu', '$pr')";

    mysqli_query($db, $sql) or die("Error F(x) NHDCUT : ".mysqli_error($db));

    closeDB($db);
}

function newHstDtlCut2($id, $idtran, $pro, $cut1, $cut2, $cut3, $cut4, $cut5, $cut6, $urut, $trm, $utrm, $weight, $type, $scut1, $scut2, $scut3, $scut4, $scut5, $scut6, $ket, $nsmpl, $db, $pro1 = "", $pro2 = "", $pro3 = "", $pro4 = "", $pro5 = "", $pro6 = "", $suhu = "R", $pr = "N")
{
    $sql = "INSERT INTO hst_prcut2
            (ID, IDTRAN, IDPRODUK, TCUT1, TCUT2, TCUT3, TCUT4, TCUT5, TCUT6, URUT, IDTERIMA, URUTTRM, WEIGHT, TYPE, GRADE, GRADE2, GRADE3, GRADE4, GRADE5, GRADE6, KET, NOSAMPLE, IDPRODUK1, IDPRODUK2, IDPRODUK3, IDPRODUK4, IDPRODUK5, IDPRODUK6, HSUHU, ISPR)
            VALUES
            ('$id', '$idtran', '$pro', '$cut1', '$cut2', '$cut3', '$cut4', '$cut5', '$cut6', '$urut', '$trm', '$utrm', '$weight', '$type', '$scut1', '$scut2', '$scut3', '$scut4', '$scut5', '$scut6', '$ket', '$nsmpl', '$pro1', '$pro2', '$pro3', '$pro4', '$pro5', '$pro6', '$suhu', '$pr')";

    mysqli_query($db, $sql) or die("Error F(x) NHDCUT : ".mysqli_error($db));
}

function newHstHCutPro($id, $idtran, $pro, $weight, $urut, $type, $db){
    $sql = "INSERT INTO hst_prcut3
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, TYPE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NHHCUTPRO : ".mysqli_error($db));
}

function newHstHCutNPro($id, $idtran, $pro, $weight, $urut, $type, $db){
    $sql = "INSERT INTO hst_prcut4
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, TYPE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NHHCUTNPRO : ".mysqli_error($db));
}

function updCut($id, $tgl, $mrgn, $user, $wkt, $tmrgn, $bid, $gdg)
{
    $db = openDB();

    $sql = "UPDATE prcut
            SET ID = '$id', DATE = '$tgl', MARGIN = '$mrgn', IDUSER = '$user', WKT = '$wkt', TMARGIN = '$tmrgn', IDGDG = '$gdg'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UCUT : ".mysqli_error($db));

    closeDB($db);
}

function delCut($id)
{
    $db = openDB();

    $sql = "DELETE FROM prcut
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DCUT : ".mysqli_error($db));

    closeDB($db);
}

function delAllDtlCut($id)
{
    $db = openDB();

    $sql = "DELETE FROM prcut2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADCUT : ".mysqli_error($db));

    closeDB($db);
}

function delAllDtlHCutPro($id)
{
    $db = openDB();

    $sql = "DELETE FROM prcut3
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADHCUTPRO : ".mysqli_error($db));

    closeDB($db);
}

function delAllDtlHCutNPro($id)
{
    $db = openDB();

    $sql = "DELETE FROM prcut4
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADHCUTNPRO : ".mysqli_error($db));

    closeDB($db);
}

//VACUUM
function getAllVac()
{
    $db = openDB();

    $sql = "SELECT ID, DATE, TYPE, CDATE, IDUSER, IDPRODUK, IF(STRCMP(TYPE,'1') = 0, IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1,'') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2,'') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3,'') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4,'') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5,'') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6,'') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE),0) - IFNULL((SELECT SUM(SF2.WEIGHT) FROM prfill2 SF2 INNER JOIN prfill SF ON SF2.ID = SF.ID WHERE SF.CDATE = F.CDATE AND SF.DATE < F.DATE),0), F.WEIGHT+F.WEIGHT2), WKT, MARGIN, TMARGIN, (SELECT SUM(WEIGHT) FROM prfill2 WHERE ID = F.ID), KET, TAHAP, (IFNULL((SELECT SUM(C2.TCUT1) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT2) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE2 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT3) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE3 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT4) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE4 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT5) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE5 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE6 = 'VIT'),0)), F.TYPE2, IDPRODUK2, WEIGHT2, (SELECT SUM(SP2.WEIGHT) FROM prfill2 SP2 INNER JOIN prfill SP ON SP2.ID = SP.ID WHERE SP.CDATE = F.CDATE AND SP.ID != F.ID) FROM prfill F
            WHERE DATE = CURDATE() ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAVAC : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllVacVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM prfill
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAVACVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getVacGradeFrmTo($frm, $to, $jtgl, $db){
    $sql = "SELECT V.DATE, V.CDATE, V2.IDGRADE, IFNULL(G.NAME, 'Tanpa grade') AS GNAME, P.NAME, G2.NAME, IFNULL(K.NAME, '') AS KNAME, IFNULL(SK.NAME, '') AS SKNAME, SUM(V2.WEIGHT) FROM prfill V INNER JOIN prfill2 V2 ON V.ID = V2.ID LEFT JOIN dtgrade G ON V2.IDGRADE = G.ID INNER JOIN dtproduk P ON V2.IDPRODUK = P.ID INNER JOIN dtgrade G2 ON P.IDGRADE = G2.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE V.TYPE = '1'";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " && V.DATE >= '$frm' && V.DATE <= '$to'";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " && V.CDATE >= '$frm' && V.CDATE <= '$to'";
    }

    $sql .= "GROUP BY V.DATE, V.CDATE, V2.IDGRADE, GNAME, P.NAME, G2.NAME, KNAME, SKNAME";
    
    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " ORDER BY V.DATE, V.CDATE";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " ORDER BY V.CDATE, V.DATE";
    }

    $sql .= ", G.NAME, P.NAME, G2.NAME, KNAME, SKNAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTVACFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getVacGradeID($id, $db){
    $sql = "SELECT DISTINCT V2.IDGRADE, IFNULL(G.NAME, 'Tanpa grade') FROM prfill2 V2 LEFT JOIN dtgrade G ON V2.IDGRADE = G.ID
            WHERE V2.ID = '$id' ORDER BY V2.IDGRADE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACGRDID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }
    
    return $arr;
}

function getVacItemCut($ctgl, $grd, $db){
    $sql = "SELECT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), SUM(V2.WEIGHT) FROM prfill V INNER JOIN prfill2 V2 ON V.ID = V2.ID INNER JOIN dtproduk P ON V2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE V.CDATE = '$ctgl' && V2.IDGRADE = '$grd'
            GROUP BY P.NAME, G.NAME, K.NAME, SK.NAME";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GVACITMCUT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    $narr = array();
    for($i = 0; $i < count($arr); $i++){
        if(strcasecmp($arr[$i][0],"") == 0){
            continue;
        }

        $narr[count($narr)] = $arr[$i];
    }
    
    return $narr;
}

function getVacFrmTo($frm, $to, $type, $pro = "", $jt = "1")
{
    $db = openDB();

    $sql = "SELECT V.ID, V.DATE, V.CDATE, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), IF(STRCMP(V.TYPE,'2') = 0, V.WEIGHT+V.WEIGHT2, (SELECT SUM(IF(STRCMP(C2.IDPRODUK1,'') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2,'') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3,'') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4,'') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5,'') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6,'') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE = V.CDATE)), V.MARGIN, V.TMARGIN, V.IDUSER, V.WKT, (SELECT SUM(WEIGHT) FROM prfill2 WHERE ID = V.ID), V.TAHAP, V.KET, (IFNULL((SELECT SUM(C2.TCUT1) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT2) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE2 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT3) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE3 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT4) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE4 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT5) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE5 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE6 = 'VIT'),0)), V.TYPE2, V.TYPE, V.IDPRODUK2, P2.NAME, G2.NAME, IFNULL(K2.NAME, ''), IFNULL(SK2.NAME, ''), ROUND(IFNULL((SELECT SUM(SP2.WEIGHT) FROM prfill2 SP2 INNER JOIN prfill SP ON SP2.ID = SP.ID WHERE SP.CDATE = V.CDATE AND SP.DATE <= V.DATE AND SP.ID != V.ID), 0), 2), V.WEIGHT, V.WEIGHT2 FROM prfill V LEFT JOIN dtproduk P ON V.IDPRODUK = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtproduk P2 ON V.IDPRODUK2 = P2.ID LEFT JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID";

    if(strcasecmp($jt,"1") == 0){
        $sql .= " WHERE V.DATE >= '$frm' && V.DATE <= '$to'";
    }
    else if(strcasecmp($jt,"2") == 0){
        $sql .= " WHERE V.CDATE >= '$frm' && V.CDATE <= '$to'";
    }

    if(strcasecmp($type,"") != 0)
        $sql .= " && V.TYPE = '$type'";

    if(strcasecmp($pro,"") != 0)
        $sql .= " && (V.IDPRODUK = '$pro' || V.IDPRODUK2 = '$pro')";

    $sql .= " ORDER BY V.DATE, V.ID, V.TYPE";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GVACFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(strcasecmp($row[3],"") != 0)
        {
            $row[3] = "<li>".$row[3];
            if(strcasecmp($row[4],"") != 0)
                $row[3] .= " / ".$row[4];

            if(strcasecmp($row[5],"") != 0)
                $row[3] .= " / ".$row[5];

            if(strcasecmp($row[6],"") != 0)
                $row[3] .= " / ".$row[6];

            $row[3] .= " = ".number_format($row[24],2,'.',',')."</li>";

            if(strcasecmp($row[18],"") != 0)
            {
                $row[3] .= "<li>".$row[19];

                if(strcasecmp($row[20],"") != 0)
                    $row[3] .= " / ".$row[20];

                if(strcasecmp($row[21],"") != 0)
                    $row[3] .= " / ".$row[21];

                if(strcasecmp($row[22],"") != 0)
                    $row[3] .= " / ".$row[22];
                    
                $row[3] .= " = ".number_format($row[25],2,'.',',')."</li>";

                $row[3] .= "</li>";
            }
        }

        $arr[count($arr)] = $row;
    }

    closeDB($db);

    return $arr;
}

function getVacFrmTo2($frm, $to, $type, $pro = "", $pro2 = "", $jt = "1")
{
    $db = openDB();

    $sql = "SELECT DISTINCT V.ID, V.DATE, V.CDATE, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), IF(STRCMP(V.TYPE,'2') = 0, V.WEIGHT+V.WEIGHT2, (SELECT SUM(IF(STRCMP(C2.IDPRODUK1,'') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2,'') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3,'') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4,'') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5,'') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6,'') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE = V.CDATE)), V.MARGIN, V.TMARGIN, V.IDUSER, V.WKT, P2.NAME, G2.NAME, K2.NAME, SK2.NAME, (SELECT SUM(WEIGHT) FROM prfill2 WHERE ID = V.ID AND IDPRODUK = V2.IDPRODUK), V.TAHAP, V.KET, (IFNULL((SELECT SUM(C2.TCUT1) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT2) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE2 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT3) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE3 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT4) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE4 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT5) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE5 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = V.CDATE && C2.GRADE6 = 'VIT'),0)), V.TYPE2, V.TYPE, V.IDPRODUK2, P3.NAME, G3.NAME, IFNULL(K3.NAME, ''), IFNULL(SK3.NAME, ''), ROUND(IFNULL((SELECT SUM(SP2.WEIGHT) FROM prfill2 SP2 INNER JOIN prfill SP ON SP2.ID = SP.ID WHERE SP.CDATE = V.CDATE AND SP.DATE <= V.DATE AND SP.ID != V.ID), 0), 2), V.WEIGHT, V.WEIGHT2 FROM prfill V LEFT JOIN dtproduk P ON V.IDPRODUK = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN prfill2 V2 ON V.ID = V2.ID INNER JOIN dtproduk P2 ON V2.IDPRODUK = P2.ID INNER JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID LEFT JOIN dtproduk P3 ON V.IDPRODUK2 = P3.ID LEFT JOIN dtgrade G3 ON P3.IDGRADE = G3.ID LEFT JOIN dtkate K3 ON P3.IDKATE = K3.ID LEFT JOIN dtskate SK3 ON P3.IDSKATE = SK3.ID";

    if(strcasecmp($jt,"1") == 0){
        $sql .= " WHERE V.DATE >= '$frm' && V.DATE <= '$to'";
    }
    else if(strcasecmp($jt,"2") == 0){
        $sql .= " WHERE V.CDATE >= '$frm' && V.CDATE <= '$to'";
    }
            
    if(strcasecmp($type,"") != 0)
        $sql .= " && V.TYPE = '$type'";

    if(strcasecmp($pro,"") != 0)
        $sql .= " && V2.IDPRODUK = '$pro'";

    if(strcasecmp($pro2,"") != 0)
        $sql .= " && (V.IDPRODUK = '$pro2' || V.IDPRODUK2 = '$pro2')";

    $sql .= " ORDER BY V.DATE, V.ID, V.TYPE, V2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(strcasecmp($row[3],"") != 0)
        {
            $row[3] = "<li>".$row[3];
            if(strcasecmp($row[4],"") != 0)
                $row[3] .= " / ".$row[4];

            if(strcasecmp($row[5],"") != 0)
                $row[3] .= " / ".$row[5];

            if(strcasecmp($row[6],"") != 0)
                $row[3] .= " / ".$row[6];

            $row[3] .= " = ".number_format($row[28],2,'.',',')."</li>";

            if(strcasecmp($row[22],"") != 0)
            {
                $row[3] .= "<li>".$row[23];

                if(strcasecmp($row[24],"") != 0)
                    $row[3] .= " / ".$row[24];

                if(strcasecmp($row[25],"") != 0)
                    $row[3] .= " / ".$row[25];

                if(strcasecmp($row[26],"") != 0)
                    $row[3] .= " / ".$row[26];

                $row[3] .= " = ".number_format($row[29],2,'.',',')."</li>";

                $row[3] .= "</li>";
            }
        }

        $arr[count($arr)] = $row;
    }

    closeDB($db);

    return $arr;
}

function getVacFrmTo3($frm, $to, $type, $pro = "")
{
    $db = openDB();

    $wtype = "";
    if(strcasecmp($type,"") != 0)
        $wtype = "&& TYPE = '$type'";

    $sql = "SELECT DISTINCT P.NAME, G.NAME, K.NAME, SK.NAME, (SELECT SUM(SF2.WEIGHT) FROM prfill2 SF2 INNER JOIN prfill SF ON SF.ID = SF2.ID WHERE SF2.IDPRODUK = P.ID && SF.DATE >= '$frm' && SF.DATE <= '$to' $wtype) FROM prfill F INNER JOIN prfill2 F2 ON F.ID = F2.ID INNER JOIN dtproduk P ON F2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE F.DATE >= '$frm' && F.DATE <= '$to' $wtype";

    if(strcasecmp($pro,"") != 0)
        $sql .= " && F2.IDPRODUK = '$pro'";

    $sql .= " ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACFT3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getVacGolFrmTo($frm, $to, $type, $pro, $db){
    $wtype = "";
    if(strcasecmp($type,"") != 0){
        $wtype = "&& TYPE = '$type'";
    }

    $sql = "SELECT DISTINCT P.IDGOL, G.NAMA FROM prfill F INNER JOIN prfill2 F2 ON F.ID = F2.ID INNER JOIN dtproduk P ON F2.IDPRODUK = P.ID INNER JOIN dtgol G ON P.IDGOL = G.ID
            WHERE F.DATE >= '$frm' && F.DATE <= '$to' $wtype";

    if(strcasecmp($pro,"") != 0){
        $sql .= " && F2.IDPRODUK = '$pro'";
    }

    $sql .= " ORDER BY G.NAMA";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACFT3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getVacFrmToGol($frm, $to, $type, $pro, $gol, $db){
    $wtype = "";
    if(strcasecmp($type,"") != 0){
        $wtype = "&& TYPE = '$type'";
    }

    $sql = "SELECT DISTINCT P.NAME, G.NAME, K.NAME, SK.NAME, (SELECT SUM(SF2.WEIGHT) FROM prfill2 SF2 INNER JOIN prfill SF ON SF.ID = SF2.ID WHERE SF2.IDPRODUK = P.ID && SF.DATE >= '$frm' && SF.DATE <= '$to' $wtype) FROM prfill F INNER JOIN prfill2 F2 ON F.ID = F2.ID INNER JOIN dtproduk P ON F2.IDPRODUK = P.ID INNER JOIN dtgol GL ON P.IDGOL = GL.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE F.DATE >= '$frm' && F.DATE <= '$to' $wtype";

    if(strcasecmp($pro,"") != 0){
        $sql .= " && F2.IDPRODUK = '$pro'";
    }

    if(strcasecmp($gol,"") != 0){
        $sql .= " && GL.ID = '$gol'";
    }

    $sql .= " ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACFT3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getVacCutFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(WEIGHT) FROM prfill2 WHERE ID = V2.ID && IDPRODUK = V2.IDPRODUK) FROM prfill2 V2 INNER JOIN dtproduk P ON V2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN prfill V ON V2.ID = V.ID
            WHERE V.CDATE >= '$frm' && V.CDATE <= '$to' && TYPE = '1'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACCUTFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getVacProFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), V.WEIGHT, V.ID, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), V.WEIGHT2 FROM prfill V LEFT JOIN dtproduk P ON V.IDPRODUK = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtproduk P2 ON V.IDPRODUK2 = P2.ID LEFT JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID
            WHERE V.DATE >= '$frm' && V.DATE <= '$to' && TYPE = '2'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACPROFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getVacProFrmTo2($frm, $to)
{
    $db = openDB();

    $sql = "SELECT DISTINCT V.CDATE FROM prfill V
            WHERE V.DATE >= '$frm' && V.DATE <= '$to' && TYPE = '1'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACPROFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $row[2] = (double)getSumCutFrmTo($row[0], $row[0]);
        $row[1] = date('d/m/Y', strtotime($row[0]));
        $arr[count($arr)] = $row;
    }

    closeDB($db);

    return $arr;
}

function getVacID($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, TYPE, CDATE, IDUSER, IDPRODUK, WEIGHT, WKT, MARGIN, TMARGIN, VERIF, VUSER, KET, TAHAP, TYPE2, IDPRODUK2, WEIGHT2, IDGDG FROM prfill
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getVacIDTgl($tgl, $type, $pro, $ctgl, $thp)
{
    $db = openDB();

    $sql = "SELECT ID FROM prfill
            WHERE DATE = '$tgl'";

    if(strcasecmp($type,"1") == 0)
        $sql .= " && CDATE = '$ctgl' && TAHAP = '$thp'";
    else if(strcasecmp($type,"2") == 0)
        $sql .= " && IDPRODUK = '$pro' && TAHAP = '$thp'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getVacItem($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDPRODUK, WEIGHT, URUT, KET, IDGRADE FROM prfill2
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getVacItem2($id)
{
    $db = openDB();

    $sql = "SELECT P2.ID, P2.IDPRODUK, P2.WEIGHT, P2.URUT, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, P2.KET, P2.IDGRADE FROM prfill2 P2 INNER JOIN dtproduk P ON P2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE P2.ID = '$id' ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME, P2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACITM2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getVacItem4($frm, $to, $cdate)
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(SV2.WEIGHT) FROM prfill2 SV2 INNER JOIN prfill SV ON SV2.ID = SV.ID WHERE SV.CDATE = '$cdate' && SV2.IDPRODUK = V2.IDPRODUK && SV.DATE >= '$frm' && SV.DATE <= '$to') FROM prfill2 V2 INNER JOIN prfill V ON V2.ID = V.ID INNER JOIN dtproduk P ON V2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE V.CDATE = '$cdate' && V.DATE >= '$frm' && V.DATE <= '$to' ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACITM4 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getVacHIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prfill
            WHERE DATE_AFR = '$tgl' && EDITEDSTAT = 'NEW'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACHIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getProVacItem($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT F2.IDPRODUK, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, '') FROM prfill2 F2 INNER JOIN dtproduk P ON F2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE F2.ID = '$id' ORDER BY P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getProVacItem2($id, $grade, $db)
{
    $sql = "SELECT DISTINCT F2.IDPRODUK, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, '') FROM prfill2 F2 INNER JOIN dtproduk P ON F2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE F2.ID = '$id' && F2.IDGRADE = '$grade' ORDER BY P.NAME, G.NAME";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GVACITM2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getProVacItemID($id, $pro)
{
    $db = openDB();

    $sql = "SELECT WEIGHT, KET FROM prfill2
            WHERE ID = '$id' && IDPRODUK = '$pro' ORDER BY URUT";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GPROVACITMID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getProVacItemID2($id, $pro, $grade, $db){
    $sql = "SELECT WEIGHT, KET FROM prfill2
            WHERE ID = '$id' && IDPRODUK = '$pro' && IDGRADE = '$grade' ORDER BY URUT";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GPROVACITMID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getSumVacItemID($id, $pro)
{
    $db = openDB();

    $sql = "SELECT SUM(WEIGHT) FROM prfill2
            WHERE ID = '$id' && IDPRODUK = '$pro'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSVACITMID : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumVacItemID2($id, $pro, $grade, $db){
    $sql = "SELECT SUM(WEIGHT) FROM prfill2
            WHERE ID = '$id' && IDPRODUK = '$pro' && IDGRADE = '$grade'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSVACITMID : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getSumVacID($id, $db){
    $sql = "SELECT SUM(WEIGHT) FROM prfill2
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSVACID : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getSumBhnVacFrmTo($frm, $to, $db){
    $sql = "SELECT SUM(WEIGHT+WEIGHT2) FROM prfill
            WHERE DATE >= '$frm' && DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSBVACFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getSumHslVacFrmTo($frm, $to, $db){
    $sql = "SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill V ON F2.ID = V.ID
            WHERE V.DATE >= '$frm' && V.DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSHVACFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getHstVacFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT F.ID, F.EDITEDON, F.EDITEDBY, F.EDITEDSTAT, F.IDTRAN_BFR, F.DATE_BFR, IF(STRCMP(TYPE_BFR,'1') = 0, F.CDATE_BFR, ''), F.TMARGIN_BFR, F.MARGIN_BFR, F.IDUSER_BFR, F.WKT_BFR, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), IF(STRCMP(TYPE_BFR, '1') = 0, (SELECT SUM(C2.WEIGHT) FROM prcut C INNER JOIN prcut2 C2 ON C.ID = C2.ID WHERE C.DATE = F.CDATE_BFR), WEIGHT_BFR), F.IDTRAN_AFR, F.DATE_AFR, IF(STRCMP(TYPE_AFR,'1') = 0, F.CDATE_AFR, ''), F.TMARGIN_AFR, F.MARGIN_AFR, F.IDUSER_AFR, F.WKT_AFR, P2.NAME, K2.NAME, SK2.NAME, IF(STRCMP(TYPE_AFR, '1') = 0, (SELECT SUM(C2.WEIGHT) FROM prcut C INNER JOIN prcut2 C2 ON C.ID = C2.ID WHERE C.DATE = F.CDATE_AFR), WEIGHT_AFR), G.NAME, G2.NAME, F.TAHAP_BFR, F.TAHAP_AFR, F.KET_BFR, F.KET_AFR, P3.NAME, G3.NAME, K3.NAME, SK3.NAME, P4.NAME, G4.NAME, K4.NAME, SK4.NAME FROM hst_prfill F LEFT JOIN dtproduk P ON F.IDPRODUK_BFR = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtproduk P2 ON F.IDPRODUK_AFR = P2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtproduk P3 ON F.IDPRODUK2_BFR = P3.ID LEFT JOIN dtkate K3 ON P3.IDKATE = K3.ID LEFT JOIN dtskate SK3 ON P3.IDSKATE = SK3.ID LEFT JOIN dtgrade G3 ON P3.IDGRADE = G3.ID LEFT JOIN dtproduk P4 ON F.IDPRODUK2_AFR = P4.ID LEFT JOIN dtkate K4 ON P4.IDKATE = K4.ID LEFT JOIN dtskate SK4 ON P4.IDSKATE = SK4.ID LEFT JOIN dtgrade G4 ON P4.IDGRADE = G4.ID";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHVACFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(strcasecmp($row[11],"") != 0)
        {
            $row[11] = "<li>".$row[11];
            if(strcasecmp($row[26],"") != 0)
                $row[11] .= " / ".$row[26];

            if(strcasecmp($row[12],"") != 0)
                $row[11] .= " / ".$row[12];

            if(strcasecmp($row[13],"") != 0)
                $row[11] .= " / ".$row[13];

            $row[11] .= "</li>";

            if(strcasecmp($row[32],"") != 0)
            {
                $row[11] .= "<li>".$row[32];

                if(strcasecmp($row[33],"") != 0)
                    $row[11] .= " / ".$row[33];

                if(strcasecmp($row[34],"") != 0)
                    $row[11] .= " / ".$row[34];

                if(strcasecmp($row[35],"") != 0)
                    $row[11] .= " / ".$row[35];

                $row[11] .= "</li>";
            }
        }

        if(strcasecmp($row[22],"") != 0)
        {
            $row[22] = "<li>".$row[22];
            if(strcasecmp($row[27],"") != 0)
                $row[22] .= " / ".$row[27];

            if(strcasecmp($row[23],"") != 0)
                $row[22] .= " / ".$row[23];

            if(strcasecmp($row[24],"") != 0)
                $row[22] .= " / ".$row[24];

            $row[22] .= "</li>";

            if(strcasecmp($row[36],"") != 0)
            {
                $row[22] .= "<li>".$row[36];

                if(strcasecmp($row[37],"") != 0)
                    $row[22] .= " / ".$row[37];

                if(strcasecmp($row[38],"") != 0)
                    $row[22] .= " / ".$row[38];

                if(strcasecmp($row[39],"") != 0)
                    $row[22] .= " / ".$row[39];

                $row[22] .= "</li>";
            }
        }

        $arr[count($arr)] = $row;
    }

    closeDB($db);

    return $arr;
}

function getHVacID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT F.IDTRAN_BFR, DATE_FORMAT(F.DATE_BFR, '%d/%m/%Y'), IF(STRCMP(TYPE_BFR,'1') = 0, DATE_FORMAT(F.CDATE_BFR, '%d/%m/%Y'), ''), F.TMARGIN_BFR, F.MARGIN_BFR, F.IDUSER_BFR, F.WKT_BFR, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), IF(STRCMP(TYPE_BFR, '1') = 0, IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut C INNER JOIN prcut2 C2 ON C.ID = C2.ID WHERE C.DATE = F.CDATE_BFR),0), WEIGHT_BFR), F.IDTRAN_AFR, F.DATE_BFR, IF(STRCMP(TYPE_BFR,'1') = 0, F.CDATE_BFR, ''), F.TMARGIN_BFR, F.MARGIN_BFR, F.IDUSER_BFR, DATE_FORMAT(F.WKT_BFR, '%d/%m/%Y'), P2.NAME, G2.NAME, IFNULL(K2.NAME, ''), IFNULL(SK2.NAME, ''), G.NAME, G2.NAME, F.WEIGHT2_BFR FROM hst_prfill F LEFT JOIN dtproduk P ON F.IDPRODUK_BFR = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtproduk P2 ON F.IDPRODUK2_BFR = P2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtgrade G2 ON P2.IDGRADE = G2.ID";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT F.IDTRAN_AFR, DATE_FORMAT(F.DATE_AFR, '%d/%m/%Y'), IF(STRCMP(TYPE_AFR,'1') = 0, DATE_FORMAT(F.CDATE_AFR, '%d/%m/%Y'), ''), F.TMARGIN_AFR, F.MARGIN_AFR, F.IDUSER_AFR, F.WKT_AFR, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), IF(STRCMP(TYPE_AFR, '1') = 0, IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut C INNER JOIN prcut2 C2 ON C.ID = C2.ID WHERE C.DATE = F.CDATE_AFR),0), WEIGHT_AFR), F.IDTRAN_AFR, F.DATE_AFR, IF(STRCMP(TYPE_AFR,'1') = 0, F.CDATE_AFR, ''), F.TMARGIN_AFR, F.MARGIN_AFR, F.IDUSER_AFR, DATE_FORMAT(F.WKT_AFR, '%d/%m/%Y'), P2.NAME, G2.NAME, IFNULL(K2.NAME, ''), IFNULL(SK2.NAME, ''), G.NAME, G2.NAME, F.WEIGHT2_AFR FROM hst_prfill F LEFT JOIN dtproduk P ON F.IDPRODUK_AFR = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtproduk P2 ON F.IDPRODUK2_AFR = P2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtgrade G2 ON P2.IDGRADE = G2.ID";

    $sql .= " WHERE F.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHVACID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    if($row[10] == null)
        $row[10] = 0;

    if(strcasecmp($row[7],"") != 0)
    {
        $row[7] = "<li>".$row[7];
        if(strcasecmp($row[22],"") != 0)
            $row[7] .= " / ".$row[22];

        if(strcasecmp($row[8],"") != 0)
            $row[7] .= " / ".$row[8];

        if(strcasecmp($row[9],"") != 0)
            $row[7] .= " / ".$row[9];

        if(isDecimal((double)$row[10]))
            $row[7] .= " (".number_format((double)$row[10],2,'.',',')." KG)</li>";
        else
            $row[7] .= " (".number_format((double)$row[10],0,'.',',')." KG)</li>";

        $row[7] .= "</li>";

        if(strcasecmp($row[19],"") != 0)
        {
            $row[7] .= "<li>".$row[19];

            if(strcasecmp($row[23],"") != 0)
                $row[7] .= " / ".$row[23];

            if(strcasecmp($row[20],"") != 0)
                $row[7] .= " / ".$row[20];

            if(strcasecmp($row[21],"") != 0)
                $row[7] .= " / ".$row[21];

            if(isDecimal((double)$row[24]))
                $row[7] .= " (".number_format((double)$row[24],2,'.',',')." KG)</li>";
            else
                $row[7] .= " (".number_format((double)$row[24],0,'.',',')." KG)</li>";

            $row[7] .= "</li>";
        }
    }

    closeDB($db);

    return $row;
}

function getHVacItem($id, $type)
{
    $db = openDB();

    $sql = "SELECT T2.ID, T2.IDTRAN, T2.IDPRODUK, T2.WEIGHT, T2.TYPE, T2.URUT, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, T2.KET FROM hst_prfill2 T2 LEFT JOIN dtproduk P ON T2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE T2.ID = '$id' && T2.TYPE = '$type' ORDER BY T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHVACITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumVacFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT) FROM prfill2 P2 INNER JOIN prfill P ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSVACFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumVacFrmTo2($frm, $to)
{
    $db = openDB();

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM prfill2 P2 INNER JOIN prfill P ON P.ID = P2.ID
            WHERE P.CDATE >= '$frm' && P.CDATE <= '$to' && P.TYPE = '1'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSVACFT2 : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumVacCutFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.CDATE, IFNULL((SELECT SUM(C2.TCUT1+C2.TCUT2+C2.TCUT3+C2.TCUT4+C2.TCUT5+C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE = P.CDATE),0) FROM prfill P
            WHERE P.CDATE >= '$frm' && P.CDATE <= '$to' && P.TYPE = '1'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSVACCUTFT : ".mysqli_error($db));

    $sum = 0;
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $sum += $row[1];
    }

    closeDB($db);

    return $sum;
}

function getSumVacCutFrmTo2($frm, $to)
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.CDATE, IFNULL((SELECT SUM(C2.TCUT1+C2.TCUT2+C2.TCUT3+C2.TCUT4+C2.TCUT5+C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE = P.CDATE),0) FROM prfill P
            WHERE P.CDATE >= '$frm' && P.CDATE <= '$to' && P.TYPE = '1'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSVACCUTFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    closeDB($db);

    return $arr;
}

function getLastIDVac($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM prfill
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(X) GLIDVAC : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDVac2($aw, $ak, $db)
{
    $sql = "SELECT ID FROM prfill
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(X) GLIDVAC : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastIDHVac($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prfill
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(X) GLIDHVAC : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDHVac2($aw, $ak, $db)
{
    $sql = "SELECT ID FROM hst_prfill
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(X) GLIDHVAC : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastUrutVac($id)
{
    $db = openDB();

    $sql = "SELECT URUT FROM prfill2
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(X) GLUVAC : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastSumThrVac()
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE, (SELECT SUM(SP2.WEIGHT) FROM prfill SP INNER JOIN prfill2 SP2 ON SP.ID = SP2.ID WHERE SP.DATE = P.DATE) FROM prfill P ORDER BY DATE DESC LIMIT 0, 30";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSTVAC : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getWeightVacPro($id, $tgl)
{
    $db = openDB();

    $sql = "SELECT SUM(F2.WEIGHT) FROM prfill F INNER JOIN prfill2 F2 ON F.ID = F2.ID
            WHERE F.TYPE = '1' && F2.IDPRODUK = '$id' && F.DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GWVACPRO : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(F2.WEIGHT) FROM prfill F INNER JOIN prfill2 F2 ON F.ID = F2.ID
            WHERE F.TYPE = '2' && F2.IDPRODUK = '$id' && F.DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GWVACPRO - 2 : ".mysqli_error($db));

    $sum2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $arr = array($sum[0], $sum2[0]);

    closeDB($db);

    return $arr;
}

function getListCutVac($tgl)
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE_FORMAT(C.DATE, '%d/%m/%Y'), (SELECT SUM(SC2.TCUT1+SC2.TCUT2+SC2.TCUT3+SC2.TCUT4+SC2.TCUT5+SC2.TCUT6) FROM prcut2 SC2 INNER JOIN prterima ST ON SC2.IDTERIMA = ST.ID WHERE SC2.ID = C.ID && ST.DATE = '$tgl') FROM prcut C INNER JOIN prcut2 C2 ON C.ID = C2.ID INNER JOIN prterima T ON C2.IDTERIMA = T.ID
            WHERE T.DATE = '$tgl' ORDER BY C.DATE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLCUTVAC : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function countVacID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prfill
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CVACID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countVac($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(F.ID) FROM prfill F LEFT JOIN dtproduk P ON F.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE (P.NAME LIKE '%$id%' || K.NAME LIKE '%$id%' || SK.NAME LIKE '%$id%' || DATE_FORMAT(F.DATE, '%d/%m/%Y') LIKE '%$id%' || G.NAME LIKE '%$id%' || F.KET LIKE '%$id%' || (SELECT COUNT(PH.ID) FROM dtproduk PH INNER JOIN prfill2 PFH2 ON PFH2.IDPRODUK = PH.ID LEFT JOIN dtkate DTK ON DTK.ID = PH.IDKATE LEFT JOIN dtskate DTSK ON DTSK.ID = PH.IDSKATE INNER JOIN dtgrade DTG ON DTG.ID = PH.IDGRADE WHERE CONCAT(PH.NAME,' / ',DTG.NAME, IF(DTK.ID = '', '', CONCAT(' / ',DTK.NAME)), IF(DTSK.ID = '', '', CONCAT(' / ',DTSK.NAME))) LIKE '%$id%' && PFH2.ID = F.ID) > 0)";

    $result = mysqli_query($db, $sql) or die("Error F(x) CVAC : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countVacTgl($tgl, $type, $pro, $ctgl, $thp, $pro2)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prfill
            WHERE DATE = '$tgl'";

    if(strcasecmp($type,"1") == 0)
        $sql .= " && CDATE = '$ctgl' && TAHAP = '$thp'";
    else if(strcasecmp($type,"2") == 0)
        $sql .= " && IDPRODUK = '$pro' && TAHAP = '$thp' && IDPRODUK2 = '$pro2'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CVACTGL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schVac($id)
{
    $db = openDB();

    $sql = "SELECT F.ID, DATE_FORMAT(F.DATE, '%d/%m/%Y'), F.TYPE, IF(YEAR(F.CDATE) < 2000, '', DATE_FORMAT(F.CDATE, '%d/%m/%Y')), F.IDUSER, F.IDPRODUK, IF(STRCMP(TYPE,'1') = 0, IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1,'') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2,'') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3,'') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4,'') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5,'') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6,'') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE),0) - IFNULL((SELECT SUM(SF2.WEIGHT) FROM prfill2 SF2 INNER JOIN prfill SF ON SF2.ID = SF.ID WHERE SF.CDATE = F.CDATE AND SF.DATE < F.DATE),0), F.WEIGHT+F.WEIGHT2), DATE_FORMAT(F.WKT, '%d/%m/%Y %H:%i'), IFNULL(P.NAME, ''), IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(WEIGHT) FROM prfill2 WHERE ID = F.ID), F.MARGIN, F.TMARGIN, IFNULL(G.NAME, ''), F.KET, F.TAHAP, (IFNULL((SELECT SUM(C2.TCUT1) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT2) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE2 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT3) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE3 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT4) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE4 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT5) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE5 = 'VIT'),0)+IFNULL((SELECT SUM(C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C.ID = C2.ID WHERE C.DATE = F.CDATE && C2.GRADE6 = 'VIT'),0)), F.TYPE2, F.IDPRODUK2, F.WEIGHT2, IFNULL(P2.NAME, ''), IFNULL(G2.NAME, ''), IFNULL(K2.NAME, ''), IFNULL(SK2.NAME, ''), F.WEIGHT, (SELECT SUM(SP2.WEIGHT) FROM prfill2 SP2 INNER JOIN prfill SP ON SP2.ID = SP.ID WHERE SP.CDATE = F.CDATE AND SP.ID != F.ID) FROM prfill F LEFT JOIN dtproduk P ON F.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtproduk P2 ON F.IDPRODUK2 = P2.ID LEFT JOIN dtkate K2 ON P.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID LEFT JOIN dtgrade G2 ON P2.IDGRADE = G2.ID";

    if (countVac($id) > 0)
        $sql .= " WHERE (P.NAME LIKE '%$id%' || K.NAME LIKE '%$id%' || SK.NAME LIKE '%$id%' || DATE_FORMAT(F.DATE, '%d/%m/%Y') LIKE '%$id%' || G.NAME LIKE '%$id%' || F.KET LIKE '%$id%' || (SELECT COUNT(PH.ID) FROM dtproduk PH INNER JOIN prfill2 PFH2 ON PFH2.IDPRODUK = PH.ID LEFT JOIN dtkate DTK ON DTK.ID = PH.IDKATE LEFT JOIN dtskate DTSK ON DTSK.ID = PH.IDSKATE INNER JOIN dtgrade DTG ON DTG.ID = PH.IDGRADE WHERE CONCAT(PH.NAME,' / ',DTG.NAME, IF(DTK.ID = '', '', CONCAT(' / ',DTK.NAME)), IF(DTSK.ID = '', '', CONCAT(' / ',DTSK.NAME))) LIKE '%$id%' && PFH2.ID = F.ID) > 0)";
    else
    {
        $y = explode(" ",$id);
                
        $sql .= " WHERE (";
        for($i = 0; $i < count($y); $i++)
        {
            $sch = $y[$i];
            for($j = 0; $j < count($y); $j++)
            {
                if($j == $i)
                    continue;
                    
                $sch = $sch."%".$y[$j];
            }
                
            $sql .= "P.NAME LIKE '%$sch%' || K.NAME LIKE '%$sch%' || SK.NAME LIKE '%$sch%' || DATE_FORMAT(F.DATE, '%d/%m/%Y') LIKE '%$sch%' || G.NAME LIKE '%$sch%' || F.KET LIKE '%$sch%' || (SELECT COUNT(PH.ID) FROM dtproduk PH INNER JOIN prfill2 PFH2 ON PFH2.IDPRODUK = PH.ID LEFT JOIN dtkate DTK ON DTK.ID = PH.IDKATE LEFT JOIN dtskate DTSK ON DTSK.ID = PH.IDSKATE INNER JOIN dtgrade DTG ON DTG.ID = PH.IDGRADE WHERE CONCAT(PH.NAME,' / ',DTG.NAME, IF(DTK.ID = '', '', CONCAT(' / ',DTK.NAME)), IF(DTSK.ID = '', '', CONCAT(' / ',DTSK.NAME))) LIKE '%$sch%' && PFH2.ID = F.ID) > 0";
                
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }

    if(strcasecmp($id,"") == 0)
        $sql .= " && F.DATE = CURDATE()";

    $sql .= " ORDER BY F.DATE, F.ID";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) SVAC : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getVacItem3($id)
{
    $db = openDB();
    
    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, '') AS KNAME, IFNULL(SK.NAME, '') AS SKNAME, (SELECT SUM(WEIGHT) FROM prfill2 WHERE ID = V2.ID && IDPRODUK = V2.IDPRODUK), P.ID FROM prfill2 V2 INNER JOIN dtproduk P ON V2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID WHERE V2.ID = '$id' ORDER BY P.NAME, G.NAME, KNAME, SKNAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GVACITM3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setVacVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE prfill
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SVACVRF : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProVac()
{
    $db = openDB();

    $sql = "UPDATE dtproduk P
            SET VIQTY = ROUND((SELECT SUM(WEIGHT) FROM prfill2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROVAC : ".mysqli_error($db));

    $sql = "UPDATE dtproduk P
            SET VOQTY = IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID),0)+IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID),0)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROVAC - 2 : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET VIQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prfill2 SP2 INNER JOIN prfill SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROVAC - 3 : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET VOQTY = IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.IDPRODUK AND IDGDG = P.IDGDG),0)+IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.IDPRODUK AND IDGDG = P.IDGDG),0)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROVAC - 4 : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProVac2($db)
{
    $sql = "UPDATE dtproduk P
            SET VIQTY = ROUND((SELECT SUM(WEIGHT) FROM prfill2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROVAC : ".mysqli_error($db));

    $sql = "UPDATE dtproduk P
            SET VOQTY = IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID),0)+IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID),0)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROVAC - 2 : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET VIQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prfill2 SP2 INNER JOIN prfill SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROVAC - 3 : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET VOQTY = IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.IDPRODUK AND IDGDG = P.IDGDG),0)+IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.IDPRODUK AND IDGDG = P.IDGDG),0)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROVAC - 4 : ".mysqli_error($db));
}

function newVac($id, $tgl, $type, $ctgl, $user, $pro, $weight, $wkt, $mrgn, $tmrgn, $ket, $thp, $type2, $pro2, $brt2, $gdg)
{
    $db = openDB();

    $sql = "INSERT INTO prfill
            (ID, DATE, TYPE, CDATE, IDUSER, IDPRODUK, WEIGHT, WKT, MARGIN, TMARGIN, KET, TAHAP, TYPE2, IDPRODUK2, WEIGHT2, IDGDG)
            VALUES
            ('$id', '$tgl', '$type', '$ctgl', '$user', '$pro', '$weight', '$wkt', '$mrgn', '$tmrgn', '$ket', '$thp', '$type2', '$pro2', '$brt2', '$gdg')";
    
    mysqli_query($db, $sql) or die("Error F(x) NVAC : ".mysqli_error($db));

    closeDB($db);
}

function newVac2($id, $tgl, $type, $ctgl, $user, $pro, $weight, $wkt, $mrgn, $tmrgn, $ket, $thp, $type2, $db)
{
    $sql = "INSERT INTO prfill
            (ID, DATE, TYPE, CDATE, IDUSER, IDPRODUK, WEIGHT, WKT, MARGIN, TMARGIN, KET, TAHAP, TYPE2)
            VALUES
            ('$id', '$tgl', '$type', '$ctgl', '$user', '$pro', '$weight', '$wkt', '$mrgn', '$tmrgn', '$ket', '$thp', '$type2')";
    
    mysqli_query($db, $sql) or die("Error F(x) NVAC : ".mysqli_error($db));
}

function newDtlVac($id, $pro, $weight, $urut, $ket, $grade)
{
    $db = openDB();

    $sql = "INSERT INTO prfill2
            (ID, IDPRODUK, WEIGHT, URUT, KET, IDGRADE)
            VALUES
            ('$id', '$pro', '$weight', '$urut', '$ket', '$grade')";

    mysqli_query($db, $sql) or die("Error F(x) NDVAC : ".mysqli_error($db));

    closeDB($db);
}

function newDtlVac2($id, $pro, $weight, $urut, $ket, $db)
{
    $sql = "INSERT INTO prfill2
            (ID, IDPRODUK, WEIGHT, URUT, KET)
            VALUES
            ('$id', '$pro', '$weight', '$urut', '$ket')";

    mysqli_query($db, $sql) or die("Error F(x) NDVAC : ".mysqli_error($db));
}

function newHstVac($id, $idtran_bfr, $tgl_bfr, $type_bfr, $ctgl_bfr, $user_bfr, $pro_bfr, $weight_bfr, $wkt_bfr, $mrgn_bfr, $tmrgn_bfr, $idtran_afr, $tgl_afr, $type_afr, $ctgl_afr, $user_afr, $pro_afr, $weight_afr, $wkt_afr, $mrgn_afr, $tmrgn_afr, $eby, $eon, $estat, $ket_bfr, $ket_afr, $thp_bfr, $thp_afr, $type2_bfr, $type2_afr, $pro2_bfr, $weight2_bfr, $pro2_afr, $weight2_afr, $gdg_bfr, $gdg_afr)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prfill
            (ID, IDTRAN_BFR, DATE_BFR, TYPE_BFR, CDATE_BFR, IDUSER_BFR, IDPRODUK_BFR, WEIGHT_BFR, WKT_BFR, MARGIN_BFR, TMARGIN_BFR, IDTRAN_AFR, DATE_AFR, TYPE_AFR, CDATE_AFR, IDUSER_AFR, IDPRODUK_AFR, WEIGHT_AFR, WKT_AFR, MARGIN_AFR, TMARGIN_AFR, EDITEDBY, EDITEDON, EDITEDSTAT, KET_BFR, KET_AFR, TAHAP_BFR, TAHAP_AFR, TYPE2_BFR, TYPE2_AFR, IDPRODUK2_BFR, WEIGHT2_BFR, IDPRODUK2_AFR, WEIGHT2_AFR, IDGDG_BFR, IDGDG_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$type_bfr', '$ctgl_bfr', '$user_bfr', '$pro_bfr', '$weight_bfr', '$wkt_bfr', '$mrgn_bfr', '$tmrgn_bfr', '$idtran_afr', '$tgl_afr', '$type_afr', '$ctgl_afr', '$user_afr', '$pro_afr', '$weight_afr', '$wkt_afr', '$mrgn_afr', '$tmrgn_afr', '$eby', '$eon', '$estat', '$ket_bfr', '$ket_afr', '$thp_bfr', '$thp_afr', '$type2_bfr', '$type2_afr', '$pro2_bfr', '$weight2_bfr', '$pro2_afr', '$weight2_afr', '$gdg_bfr', '$gdg_afr')";
    
    mysqli_query($db, $sql) or die("Error F(x) NHVAC : ".mysqli_error($db));

    closeDB($db);
}

function newHstVac2($id, $idtran_bfr, $tgl_bfr, $type_bfr, $ctgl_bfr, $user_bfr, $pro_bfr, $weight_bfr, $wkt_bfr, $mrgn_bfr, $tmrgn_bfr, $idtran_afr, $tgl_afr, $type_afr, $ctgl_afr, $user_afr, $pro_afr, $weight_afr, $wkt_afr, $mrgn_afr, $tmrgn_afr, $eby, $eon, $estat, $ket_bfr, $ket_afr, $thp_bfr, $thp_afr, $type2_bfr, $type2_afr, $db)
{
    $sql = "INSERT INTO hst_prfill
            (ID, IDTRAN_BFR, DATE_BFR, TYPE_BFR, CDATE_BFR, IDUSER_BFR, IDPRODUK_BFR, WEIGHT_BFR, WKT_BFR, MARGIN_BFR, TMARGIN_BFR, IDTRAN_AFR, DATE_AFR, TYPE_AFR, CDATE_AFR, IDUSER_AFR, IDPRODUK_AFR, WEIGHT_AFR, WKT_AFR, MARGIN_AFR, TMARGIN_AFR, EDITEDBY, EDITEDON, EDITEDSTAT, KET_BFR, KET_AFR, TAHAP_BFR, TAHAP_AFR, TYPE2_BFR, TYPE2_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$type_bfr', '$ctgl_bfr', '$user_bfr', '$pro_bfr', '$weight_bfr', '$wkt_bfr', '$mrgn_bfr', '$tmrgn_bfr', '$idtran_afr', '$tgl_afr', '$type_afr', '$ctgl_afr', '$user_afr', '$pro_afr', '$weight_afr', '$wkt_afr', '$mrgn_afr', '$tmrgn_afr', '$eby', '$eon', '$estat', '$ket_bfr', '$ket_afr', '$thp_bfr', '$thp_afr', '$type2_bfr', '$type2_afr')";
    
    mysqli_query($db, $sql) or die("Error F(x) NHVAC : ".mysqli_error($db));
}

function newHstDtlVac($id, $idtran, $pro, $weight, $urut, $type, $ket, $grade)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prfill2
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, TYPE, KET, IDGRADE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$type', '$ket', '$grade')";

    mysqli_query($db, $sql) or die("Error F(x) NHDVAC : ".mysqli_error($db));

    closeDB($db);
}

function newHstDtlVac2($id, $idtran, $pro, $weight, $urut, $type, $ket, $db)
{
    $sql = "INSERT INTO hst_prfill2
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, TYPE, KET)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$type', '$ket')";

    mysqli_query($db, $sql) or die("Error F(x) NHDVAC : ".mysqli_error($db));
}

function updVac($id, $tgl, $type, $ctgl, $user, $pro, $weight, $wkt, $mrgn, $tmrgn, $bid, $ket, $thp, $type2, $pro2, $weight2, $gdg)
{
    $db = openDB();

    $sql = "UPDATE prfill
            SET ID = '$id', DATE = '$tgl', TYPE = '$type', CDATE = '$ctgl', IDUSER = '$user', IDPRODUK = '$pro', WEIGHT = '$weight', WKT = '$wkt', MARGIN = '$mrgn', TMARGIN = '$tmrgn', KET = '$ket', TAHAP = '$thp', TYPE2 = '$type2', IDPRODUK2 = '$pro2', WEIGHT2 = '$weight2', IDGDG = '$gdg'
            WHERE ID = '$bid'";
    
    mysqli_query($db, $sql) or die("Error F(x) UVAC : ".mysqli_error($db));

    closeDB($db);
}

function delVac($id)
{
    $db = openDB();

    $sql = "DELETE FROM prfill
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DVAC : ".mysqli_error($db));

    closeDB($db);
}

function delVacTgl($tgl, $db)
{
    $sql = "DELETE FROM prfill
            WHERE DATE = '$tgl'";
            
    mysqli_query($db, $sql) or die("Error F(x) DVACT : ".mysqli_error($db));

    $sql = "DELETE FROM hst_prfill
            WHERE ((EDITEDSTAT = 'NEW' || EDITEDSTAT = 'EDIT') && DATE_AFR = '$tgl') || (EDITEDSTAT = 'DELETE' && DATE_BFR = '$tgl')";

    mysqli_query($db, $sql) or die("Error F(x) DVACT - 1 : ".mysqli_error($db));
}

function delAllDtlVac($id)
{
    $db = openDB();

    $sql = "DELETE FROM prfill2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADVAC : ".mysqli_error($db));

    closeDB($db);
}

//SAWING
function getAllSaw()
{
    $db = openDB();

    $sql = "SELECT ID, DATE, IDUSER, IDPRODUK, WEIGHT, WKT, MARGIN, TMARGIN, (SELECT SUM(WEIGHT) FROM prsaw2 WHERE ID = S.ID), TAHAP, KET, (SELECT TIMESTAMPDIFF(DAY,CURRENT_DATE,WKT)) FROM prsaw S
            WHERE DATE = CURDATE() ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GASAW : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllSawVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM prsaw
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GASAWVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSawFrmTo($frm, $to, $pro= "", $bb = "")
{
    $db = openDB();

    $sql = "SELECT S.ID, S.DATE, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), S.WEIGHT, S.MARGIN, S.TMARGIN, S.IDUSER, S.WKT, (SELECT SUM(WEIGHT) FROM prsaw WHERE ID = S.ID), TAHAP, S.KET FROM prsaw S LEFT JOIN dtproduk P ON S.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE S.DATE >= '$frm' && S.DATE <= '$to'";

    if(strcasecmp($pro,"") != 0)
        $sql .= " && S.IDPRODUK = '$pro'";

    if(strcasecmp($bb,"") != 0)
        $sql .= " && S.IDPRODUK = '$bb'";

    $sql .= " ORDER BY S.DATE, S.ID";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSawFrmTo2($frm, $to, $pro = "", $bb = "")
{
    $db = openDB();

    $sql = "SELECT S.ID, S.DATE, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), S.WEIGHT, S.MARGIN, S.TMARGIN, S.IDUSER, S.WKT, (SELECT SUM(WEIGHT) FROM prsaw WHERE ID = S.ID), P2.NAME, G2.NAME, K2.NAME, SK2.NAME, S2.WEIGHT, S.TAHAP, S.KET FROM prsaw S LEFT JOIN dtproduk P ON S.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN prsaw2 S2 ON S.ID = S2.ID INNER JOIN dtproduk P2 ON S2.IDPRODUK = P2.ID INNER JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID
            WHERE S.DATE >= '$frm' && S.DATE <= '$to'";
    
    if(strcasecmp($pro,"") != 0)
        $sql .= " && S2.IDPRODUK = '$pro'";

    if(strcasecmp($bb,"") != 0)
        $sql .= " && S.IDPRODUK = '$bb'";

    $sql .= " ORDER BY S.DATE, S.ID, S2.URUT";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSawFrmTo3($frm, $to, $pro = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, K.NAME, SK.NAME, (SELECT SUM(SS2.WEIGHT) FROM prsaw2 SS2 INNER JOIN prsaw SS ON SS.ID = SS2.ID WHERE SS2.IDPRODUK = P.ID && SS.DATE >= '$frm' && SS.DATE <= '$to') FROM prsaw S INNER JOIN prsaw2 S2 ON S.ID = S2.ID INNER JOIN dtproduk P ON S2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE S.DATE >= '$frm' && S.DATE <= '$to'";

    if(strcasecmp($pro,"") != 0)
        $sql .= " && S2.IDPRODUK = '$pro'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWFT3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSawFrmTo4($frm, $to, $pro = "", $bb = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = S.IDPRODUK && DATE >= '$frm' && DATE <= '$to'), P2.NAME, G2.NAME, K2.NAME, SK2.NAME, (SELECT SUM(SS2.WEIGHT) FROM prsaw2 SS2 INNER JOIN prsaw SS ON SS2.ID = SS.ID WHERE SS2.IDPRODUK = S2.IDPRODUK && SS.DATE >= '$frm' && SS.DATE <= '$to' && SS.IDPRODUK = S.IDPRODUK), S.IDPRODUK FROM prsaw S LEFT JOIN dtproduk P ON S.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN prsaw2 S2 ON S.ID = S2.ID INNER JOIN dtproduk P2 ON S2.IDPRODUK = P2.ID INNER JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID
            WHERE S.DATE >= '$frm' && S.DATE <= '$to'";
    
    if(strcasecmp($pro,"") != 0)
        $sql .= " && S2.IDPRODUK = '$pro'";

    if(strcasecmp($bb,"") != 0)
        $sql .= " && S.IDPRODUK = '$bb'";

    $sql .= " ORDER BY S.IDPRODUK, P2.NAME";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWFT4 : ".mysqli_error($db));
    
    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSawProFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), S.WEIGHT, S.ID FROM prsaw S LEFT JOIN dtproduk P ON S.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE S.DATE >= '$frm' && S.DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWPROFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSawID($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, IDUSER, IDPRODUK, WEIGHT, WKT, MARGIN, TMARGIN, VERIF, VUSER, TAHAP, KET, IDGDG FROM prsaw
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getSawItem($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDPRODUK, WEIGHT, URUT FROM prsaw2
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSawItem2($id)
{
    $db = openDB();

    $sql = "SELECT S2.ID, S2.IDPRODUK, S2.WEIGHT, S2.URUT, IF(P.NAME IS NULL, '', P.NAME), IF(K.NAME IS NULL, '', K.NAME), IF(SK.NAME IS NULL, '', SK.NAME), IF(G.NAME IS NULL, '', G.NAME) FROM prsaw2 S2 INNER JOIN dtproduk P ON S2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE S2.ID = '$id' ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME, URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWITM2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSawIDTgl($tgl, $pro, $thp)
{
    $db = openDB();

    $sql = "SELECT ID FROM prsaw
            WHERE DATE = '$tgl' && IDPRODUK = '$pro' && TAHAP = '$thp'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getSawHIDTgl($tgl, $pro, $thp)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prsaw
            WHERE DATE_AFR = '$tgl' && IDPRODUK_AFR = '$pro' && TAHAP_AFR = '$thp' && EDITEDSTAT = 'NEW'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWHIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getProSawItem($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT S2.IDPRODUK, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, '') FROM prsaw2 S2 INNER JOIN dtproduk P ON S2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE S2.ID = '$id' ORDER BY P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getProSawItemID($id, $pro)
{
    $db = openDB();

    $sql = "SELECT WEIGHT FROM prsaw2
            WHERE ID = '$id' && IDPRODUK = '$pro' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPROSAWITMID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getSumSawItemID($id, $pro)
{
    $db = openDB();

    $sql = "SELECT SUM(WEIGHT) FROM prsaw2
            WHERE ID = '$id' && IDPRODUK = '$pro'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSSAWITMID : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumBhnSawFrmTo($frm, $to, $db){
    $sql = "SELECT SUM(WEIGHT) FROM prsaw
            WHERE DATE >= '$frm' && DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSBSAWFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getSumHslSawFrmTo($frm, $to, $db){
    $sql = "SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID
            WHERE S.DATE >= '$frm' && S.DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSHSAWFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getHstSawFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT S.ID, S.EDITEDON, S.EDITEDBY, S.EDITEDSTAT, S.IDTRAN_BFR, S.DATE_BFR, S.TMARGIN_BFR, S.MARGIN_BFR, S.IDUSER_BFR,  S.WKT_BFR, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), S.WEIGHT_BFR, S.IDTRAN_AFR, S.DATE_AFR, S.TMARGIN_AFR, S.MARGIN_AFR, S.IDUSER_AFR, S.WKT_AFR, P2.NAME, K2.NAME, SK2.NAME, S.WEIGHT_AFR, G.NAME, G2.NAME, S.TAHAP_BFR, S.TAHAP_BFR FROM hst_prsaw S LEFT JOIN dtproduk P ON S.IDPRODUK_BFR = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtproduk P2 ON S.IDPRODUK_AFR = P2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtgrade G2 ON P2.IDGRADE = G2.ID";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHSAWFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHSawID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT S.IDTRAN_BFR, DATE_FORMAT(S.DATE_BFR, '%d/%m/%Y'), S.TMARGIN_BFR, S.MARGIN_BFR, S.IDUSER_BFR, S.WKT_BFR, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), S.WEIGHT_BFR, S.IDTRAN_BFR, S.DATE_BFR, S.TMARGIN_BFR, S.MARGIN_BFR, S.IDUSER_BFR, DATE_FORMAT(S.WKT_BFR, '%d/%m/%Y'), S.TAHAP_BFR FROM hst_prsaw S LEFT JOIN dtproduk P ON S.IDPRODUK_BFR = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT S.IDTRAN_AFR, DATE_FORMAT(S.DATE_AFR, '%d/%m/%Y'), S.TMARGIN_AFR, S.MARGIN_AFR, S.IDUSER_AFR, S.WKT_AFR, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), S.WEIGHT_AFR, S.IDTRAN_AFR, S.DATE_AFR, S.TMARGIN_AFR, S.MARGIN_AFR, S.IDUSER_AFR, DATE_FORMAT(S.WKT_AFR, '%d/%m/%Y'), S.TAHAP_AFR FROM hst_prsaw S LEFT JOIN dtproduk P ON S.IDPRODUK_AFR = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID";

    $sql .= " WHERE S.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHSAWID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getHSawItem($id, $type)
{
    $db = openDB();

    $sql = "SELECT S2.ID, S2.IDTRAN, S2.IDPRODUK, S2.WEIGHT, S2.TYPE, S2.URUT, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME FROM hst_prsaw2 S2 LEFT JOIN dtproduk P ON S2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE S2.ID = '$id' && S2.TYPE = '$type' ORDER BY S2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHSAWITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumSawID($id, $db)
{
    $sql = "SELECT SUM(WEIGHT) FROM prsaw2
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSSAWID : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getSumSawFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT) FROM prsaw2 P2 INNER JOIN prsaw P ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSSAWFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getLastIDSaw($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM prsaw
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDSAW : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastUrutSaw($id)
{
    $db = openDB();

    $sql = "SELECT URUT FROM prsaw2
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUSAW : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastSumThrSaw()
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE, (SELECT SUM(SP2.WEIGHT) FROM prsaw SP INNER JOIN prsaw2 SP2 ON SP.ID = SP2.ID WHERE SP.DATE = P.DATE) FROM prsaw P ORDER BY DATE DESC LIMIT 0, 30";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSTSAW : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastIDHSaw($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prsaw
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHSAW : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getWeightSawPro($id, $tgl)
{
    $db = openDB();

    $sql = "SELECT SUM(S2.WEIGHT) FROM prsaw S INNER JOIN prsaw2 S2 ON S.ID = S2.ID
            WHERE S2.IDPRODUK = '$id' && S.DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GWSAWPRO : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum;
}

function countSawID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prsaw
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CSAWID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSawTgl($tgl, $pro, $thp)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prsaw
            WHERE DATE = '$tgl' && IDPRODUK = '$pro' && TAHAP = '$thp'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CSAWTGL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSaw($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(S.ID) FROM prsaw S LEFT JOIN dtproduk P ON S.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE P.NAME LIKE '%$id%' || K.NAME LIKE '%$id%' || SK.NAME LIKE '%$id%' || G.NAME LIKE '%$id%' || DATE_FORMAT(S.DATE, '%d/%m/%Y') LIKE '%$id%' || S.KET LIKE '%$id%' || (SELECT COUNT(SH.ID) FROM dtproduk SH INNER JOIN prsaw2 PSH2 ON PSH2.IDPRODUK = SH.ID LEFT JOIN dtkate DTK ON DTK.ID = SH.IDKATE LEFT JOIN dtskate DTSK ON DTSK.ID = SH.IDSKATE INNER JOIN dtgrade DTG ON DTG.ID = SH.IDGRADE WHERE CONCAT(SH.NAME,' / ',DTG.NAME, IF(DTK.ID = '', '', CONCAT(' / ',DTK.NAME)), IF(DTSK.ID = '', '', CONCAT(' / ',DTSK.NAME))) LIKE '%$id%' && PSH2.ID = S.ID) > 0";

    $result = mysqli_query($db, $sql) or die("Error F(x) CSAW : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schSaw($id)
{
    $db = openDB();

    $sql = "SELECT S.ID, DATE_FORMAT(S.DATE, '%d/%m/%Y'), S.IDUSER, S.IDPRODUK, S.WEIGHT, DATE_FORMAT(S.WKT, '%d/%m/%Y %H:%i'), S.MARGIN, S.TMARGIN, (SELECT SUM(WEIGHT) FROM prsaw2 WHERE ID = S.ID), IF(P.NAME IS NULL, '', P.NAME), IF(K.NAME IS NULL, '', K.NAME), IF(SK.NAME IS NULL, '', SK.NAME), IF(G.NAME IS NULL, '', G.NAME), S.TAHAP, S.KET, S.WKT AS WKT_BEFORE, TIMESTAMPDIFF(DAY,DATE_FORMAT(S.WKT, '%Y-%m-%d'),CURRENT_DATE) FROM prsaw S LEFT JOIN dtproduk P ON S.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID";

    if(countSaw($id) > 0)
        $sql .= " WHERE (P.NAME LIKE '%$id%' || K.NAME LIKE '%$id%' || SK.NAME LIKE '%$id%' || G.NAME LIKE '%$id%' || DATE_FORMAT(S.DATE, '%d/%m/%Y') LIKE '%$id%' || S.KET LIKE '%$id%' || (SELECT COUNT(SH.ID) FROM dtproduk SH INNER JOIN prsaw2 PSH2 ON PSH2.IDPRODUK = SH.ID LEFT JOIN dtkate DTK ON DTK.ID = SH.IDKATE LEFT JOIN dtskate DTSK ON DTSK.ID = SH.IDSKATE INNER JOIN dtgrade DTG ON DTG.ID = SH.IDGRADE WHERE CONCAT(SH.NAME,' / ',DTG.NAME, IF(DTK.ID = '', '', CONCAT(' / ',DTK.NAME)), IF(DTSK.ID = '', '', CONCAT(' / ',DTSK.NAME))) LIKE '%$id%' && PSH2.ID = S.ID) > 0)";
    else
    {
        $y = explode(" ",$id);
            
        $sql .= " WHERE (";
        for($i = 0; $i < count($y); $i++)
        {
            $sch = $y[$i];
            for($j = 0; $j < count($y); $j++)
            {
                if($j == $i)
                    continue;
                
                $sch = $sch."%".$y[$j];
            }
            
            $sql .= "P.NAME LIKE '%$sch%' || K.NAME LIKE '%$sch%' || SK.NAME LIKE '%$sch%' || G.NAME LIKE '%$sch%' || DATE_FORMAT(S.DATE, '%d/%m/%Y') LIKE '%$sch%' || S.KET LIKE '%$sch%' || (SELECT COUNT(SH.ID) FROM dtproduk SH INNER JOIN prsaw2 PSH2 ON PSH2.IDPRODUK = SH.ID LEFT JOIN dtkate DTK ON DTK.ID = SH.IDKATE LEFT JOIN dtskate DTSK ON DTSK.ID = SH.IDSKATE INNER JOIN dtgrade DTG ON DTG.ID = SH.IDGRADE WHERE CONCAT(SH.NAME,' / ',DTG.NAME, IF(DTK.ID = '', '', CONCAT(' / ',DTK.NAME)), IF(DTSK.ID = '', '', CONCAT(' / ',DTSK.NAME))) LIKE '%$sch%' && PSH2.ID = S.ID) > 0";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }

    if(strcasecmp($id,"") == 0)
        $sql .= " && S.DATE = CURDATE()";

    $sql .= " ORDER BY S.DATE, S.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) SSAW : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSawItem3($id)
{
    $db = openDB();
    
    $sql = "SELECT DISTINCT IF(P.NAME IS NULL, '', P.NAME) AS PNAME, IF(G.NAME IS NULL, '', G.NAME) AS GNAME, IF(K.NAME IS NULL, '', K.NAME) AS KNAME, IF(SK.NAME IS NULL, '', SK.NAME) AS SKNAME, (SELECT SUM(WEIGHT) FROM prsaw2 WHERE ID = S2.ID && IDPRODUK = S2.IDPRODUK), P.ID FROM prsaw2 S2 INNER JOIN dtproduk P ON S2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID WHERE S2.ID = '$id' ORDER BY PNAME, GNAME, KNAME, SKNAME";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSAWITM3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setSawVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE prsaw
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SSAWVRF : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProSaw()
{
    $db = openDB();

    $sql = "UPDATE dtproduk P
            SET SIQTY = ROUND((SELECT SUM(WEIGHT) FROM prsaw2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROSAW : ".mysqli_error($db));

    $sql = "UPDATE dtproduk P
            SET SOQTY = ROUND((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROSAW - 2 : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET SIQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prsaw2 SP2 INNER JOIN prsaw SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROSAW - 3 : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET SOQTY = ROUND((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.IDPRODUK AND IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROSAW - 4 : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProSaw2($db)
{
    $sql = "UPDATE dtproduk P
            SET SIQTY = ROUND((SELECT SUM(WEIGHT) FROM prsaw2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROSAW : ".mysqli_error($db));

    $sql = "UPDATE dtproduk P
            SET SOQTY = ROUND((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROSAW - 2 : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET SIQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prsaw2 SP2 INNER JOIN prsaw SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROSAW - 3 : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET SOQTY = ROUND((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.IDPRODUK AND IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROSAW - 4 : ".mysqli_error($db));
}

function newSaw($id, $tgl, $user, $pro, $weight, $wkt, $mrgn, $tmrgn, $thp = 0, $ket = "", $gdg)
{
    $db = openDB();

    $sql = "INSERT INTO prsaw
            (ID, DATE, IDUSER, IDPRODUK, WEIGHT, WKT, MARGIN, TMARGIN, TAHAP, KET, IDGDG)
            VALUES
            ('$id', '$tgl', '$user', '$pro', '$weight', '$wkt', '$mrgn', '$tmrgn', '$thp', '$ket', '$gdg')";

    mysqli_query($db, $sql) or die("Error F(x) NSAW : ".mysqli_error($db));

    closeDB($db);
}

function newDtlSaw($id, $pro, $weight, $urut)
{
    $db = openDB();

    $sql = "INSERT INTO prsaw2
            (ID, IDPRODUK, WEIGHT, URUT)
            VALUES
            ('$id', '$pro', '$weight', '$urut')";

    mysqli_query($db, $sql) or die("Error F(x) NDSAW : ".mysqli_error($db));

    closeDB($db);
}

function newHstSaw($id, $idtran_bfr, $tgl_bfr, $user_bfr, $pro_bfr, $weight_bfr, $wkt_bfr, $mrgn_bfr, $tmrgn_bfr, $idtran_afr, $tgl_afr, $user_afr, $pro_afr, $weight_afr, $wkt_afr, $mrgn_afr, $tmrgn_afr, $eby, $eon, $estat, $thp_bfr, $thp_afr, $ket_bfr, $ket_afr, $gdg_bfr, $gdg_afr)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prsaw
            (ID, IDTRAN_BFR, DATE_BFR, IDUSER_BFR, IDPRODUK_BFR, WEIGHT_BFR, WKT_BFR, MARGIN_BFR, TMARGIN_BFR, IDTRAN_AFR, DATE_AFR, IDUSER_AFR, IDPRODUK_AFR, WEIGHT_AFR, WKT_AFR, MARGIN_AFR, TMARGIN_AFR, EDITEDBY, EDITEDON, EDITEDSTAT, TAHAP_BFR, TAHAP_AFR, KET_AFR, KET_BFR, IDGDG_BFR, IDGDG_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$user_bfr', '$pro_bfr', '$weight_bfr', '$wkt_bfr', '$mrgn_bfr', '$tmrgn_bfr', '$idtran_afr', '$tgl_afr', '$user_afr', '$pro_afr', '$weight_afr', '$wkt_afr', '$mrgn_afr', '$tmrgn_afr', '$eby', '$eon', '$estat', '$thp_bfr', '$thp_afr', '$ket_afr', '$ket_bfr', '$gdg_bfr', '$gdg_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHSAW : ".mysqli_error($db));

    closeDB($db);
}

function newHstDtlSaw($id, $idtran, $pro, $weight, $urut, $type)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prsaw2
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, TYPE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NHDSAW : ".mysqli_error($db));

    closeDB($db);
}

function updRblcSaw($id, $qty)
{
    $db = openDB();

    $sql = "UPDATE prsaw
            SET WEIGHT = '$qty'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) URBLCSAW : ".mysqli_error($db));

    closeDB($db);
}

function updSaw($id, $tgl, $user, $pro, $weight, $wkt, $mrgn, $tmrgn, $bid, $thp, $ket, $gdg)
{
    $db = openDB();

    $sql = "UPDATE prsaw
            SET ID = '$id', DATE = '$tgl', IDUSER = '$user', IDPRODUK = '$pro', WEIGHT = '$weight', WKT = '$wkt', MARGIN = '$mrgn', TMARGIN = '$tmrgn', TAHAP = '$thp', KET = '$ket', IDGDG = '$gdg'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) USAW : ".mysqli_error($db));

    closeDB($db);
}

function delSaw($id)
{
    $db = openDB();

    $sql = "DELETE FROM prsaw
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DSAW : ".mysqli_error($db));

    closeDB($db);
}

function delAllDtlSaw($id)
{
    $db = openDB();

    $sql = "DELETE FROM prsaw2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADSAW : ".mysqli_error($db));

    closeDB($db);
}

//PACKAGING
function getAllKirim()
{
    $db = openDB();

    $sql = "SELECT ID, DATE, KET1, KET2, KET3, IDUSER, WKT, (SELECT SUM(WEIGHT) FROM trkirim2 WHERE ID = K.ID) FROM trkirim K
            WHERE DATE = CURDATE() ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAKRM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllKirimVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM trkirim
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAKRMVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getKirimFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT K.ID, K.DATE, K.KET1, K.KET2, K.KET3, K.IDUSER, K.WKT, (SELECT SUM(WEIGHT) FROM trkirim2 WHERE ID = K.ID) FROM trkirim K
            WHERE K.DATE >= '$frm' && K.DATE <= '$to' ORDER BY K.DATE, K.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getKirimFrmTo2($frm, $to, $po)
{
    $db = openDB();

    $sql = "SELECT K.ID, K.DATE, K.KET1, K.KET2, K.KET3, K.IDUSER, K.WKT, (SELECT SUM(WEIGHT) FROM trkirim2 WHERE ID = K.ID), P.NAME, G.NAME, IFNULL(KT.NAME, ''), IFNULL(SK.NAME, ''), K2.WEIGHT, K2.IDPO, K2.QTY, K2.SAT, K2.TGLEXP, K2.KET FROM trkirim K INNER JOIN trkirim2 K2 ON K.ID = K2.ID INNER JOIN dtproduk P ON K2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate KT ON P.IDKATE = KT.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE K.DATE >= '$frm' && K.DATE <= '$to'";

    if(strcasecmp($po,"") != 0){
        $sql .= " && K2.IDPO = '$po'";
    }

    $sql .= " ORDER BY K.DATE, K.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getKirimFrmTo3($frm, $to)
{
    $db = openDB();

    $sql = "SELECT DISTINCT ID FROM trkirim
            WHERE ID LIKE 'TPS/%' && DATE >= '$frm' && DATE <= '$to' ORDER BY ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMFT3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getKirimID($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, KET1, KET2, KET3, IDUSER, WKT, VERIF, VUSER, IDGDG FROM trkirim
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getKirimIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM trkirim
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getKirimIDTgl2($tgl, $db)
{
    $sql = "SELECT ID FROM trkirim
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getKirimHIDTgl($id)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_trkirim
            WHERE IDTRAN_AFR = '$id' && EDITEDSTAT = 'NEW'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMHIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getKirimHIDTgl2($id, $db)
{
    $sql = "SELECT ID FROM hst_trkirim
            WHERE IDTRAN_AFR = '$id' && EDITEDSTAT = 'NEW'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMHIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getKirimItem($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDPRODUK, WEIGHT, URUT, IDPO, QTY, SAT, TGLEXP, KET FROM trkirim2
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getKirimItem2($id)
{
    $db = openDB();

    $sql = "SELECT K2.ID, K2.IDPRODUK, K2.WEIGHT, K2.URUT, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, K2.IDPO, K2.QTY, K2.SAT, K2.TGLEXP, (SELECT STAT FROM dtpo WHERE ID = K2.IDPO), K2.KET FROM trkirim2 K2 INNER JOIN dtproduk P ON K2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE K2.ID = '$id' ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME, K2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMITM2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getKirimItem3($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(WEIGHT) FROM trkirim2 WHERE ID = K2.ID && IDPRODUK = K2.IDPRODUK && IDPO = K2.IDPO), K2.IDPO, K2.QTY, K2.SAT, K2.TGLEXP, K2.KET FROM trkirim2 K2 INNER JOIN dtproduk P ON K2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE K2.ID = '$id' ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME, K2.URUT, K2.IDPO";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMITM3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getKirimItemPO($id)
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(WEIGHT) FROM trkirim2 WHERE IDPRODUK = K2.IDPRODUK && IDPO = K2.IDPO), K2.QTY, K2.SAT, K2.TGLEXP, K2.KET FROM trkirim2 K2 INNER JOIN dtproduk P ON K2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE K2.IDPO = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GKRMITMPO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHstKirimFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, IDTRAN_BFR, DATE_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR FROM hst_trkirim";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHKRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHKirimID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT T.IDTRAN_BFR, DATE_FORMAT(T.DATE_BFR, '%d/%m/%Y'), T.KET1_BFR, T.KET2_BFR, T.KET3_BFR, T.IDUSER_BFR, DATE_FORMAT(T.WKT_BFR, '%d/%m/%Y') FROM hst_trkirim T";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT T.IDTRAN_AFR, DATE_FORMAT(T.DATE_AFR, '%d/%m/%Y'), T.KET1_AFR, T.KET2_AFR, T.KET3_AFR, T.IDUSER_AFR, DATE_FORMAT(T.WKT_AFR, '%d/%m/%Y') FROM hst_trkirim T";

    $sql .= " WHERE T.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHKRMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getHKirimItem($id, $type)
{
    $db = openDB();

    $sql = "SELECT T2.ID, T2.IDTRAN, T2.IDPRODUK, T2.WEIGHT, T2.TYPE, T2.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), T2.IDPO, T2.QTY, T2.SAT, T2.TGLEXP, T2.KET, DATE_FORMAT(T2.TGLEXP, '%d/%m/%Y') FROM hst_trkirim2 T2 LEFT JOIN dtproduk P ON T2.IDPRODUK = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE T2.ID = '$id' && T2.TYPE = '$type' ORDER BY T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHKRMITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumKirimFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT) FROM trkirim2 P2 INNER JOIN trkirim P ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSKRMFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getLastIDKirim($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM trkirim
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDKRM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDKirim2($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM trkirim
            WHERE ID LIKE '$aw%$ak' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDKRM2 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDKirim3($aw, $ak, $db)
{
    $sql = "SELECT ID FROM trkirim
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDKRM3 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastIDKirim4($aw, $ak, $db)
{
    $sql = "SELECT ID FROM trkirim
            WHERE ID LIKE '$aw%$ak' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDKRM4 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastIDHKirim($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_trkirim
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHKRM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDHKirim2($aw, $ak, $db)
{
    $sql = "SELECT ID FROM hst_trkirim
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHKRM2 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastUrutKirim($id)
{
    $db = openDB();

    $sql = "SELECT URUT FROM trkirim2
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUKRM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastUrutKirim2($id, $db)
{
    $sql = "SELECT URUT FROM trkirim2
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUKRM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastSumThrKirim()
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE, (SELECT SUM(SP2.WEIGHT) FROM trkirim SP INNER JOIN trkirim2 SP2 ON SP.ID = SP2.ID WHERE SP.DATE = P.DATE) FROM trkirim P ORDER BY DATE DESC LIMIT 0, 30";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSTKRM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function countKirimID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trkirim
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CKRMID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countKirim($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(K.ID) FROM trkirim K
            WHERE K.ID LIKE '%$id%' || K.KET1 LIKE '%$id%' || K.KET2 LIKE '%$id%' || K.KET3 LIKE '%$id%' || DATE_FORMAT(K.DATE, '%d/%m/%Y') LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CKRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countKirimTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trkirim
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CKRMTGL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countKirimTgl2($tgl, $db)
{
    $sql = "SELECT COUNT(ID) FROM trkirim
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CKRMTGL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function schKirim($id)
{
    $db = openDB();

    $sql = "SELECT K.ID, DATE_FORMAT(K.DATE, '%d/%m/%Y'), K.KET1, K.KET2, K.KET3, K.IDUSER, DATE_FORMAT(K.WKT, '%d/%m/%Y %H:%i'), (SELECT SUM(WEIGHT) FROM trkirim2 WHERE ID = K.ID) FROM trkirim K";

    if(countKirim($id) > 0)
        $sql .= " WHERE K.ID LIKE '%$id%' || K.KET1 LIKE '%$id%' || K.KET2 LIKE '%$id%' || K.KET3 LIKE '%$id%' || DATE_FORMAT(K.DATE, '%d/%m/%Y') LIKE '%$id%'";
    else
    {
        $y = explode(" ",$id);
        
        $sql .= " WHERE ";
        for($i = 0; $i < count($y); $i++)
        {
            $sch = $y[$i];
            for($j = 0; $j < count($y); $j++)
            {
                if($j == $i)
                    continue;
                
                $sch = $sch."%".$y[$j];
            }
            
            $sql .= "K.ID LIKE '%$sch%' || K.KET1 LIKE '%$sch%' || K.KET2 LIKE '%$sch%' || K.KET3 LIKE '%$sch%' || DATE_FORMAT(K.DATE, '%d/%m/%Y') LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY K.DATE, K.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) SKRM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setKirimVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE trkirim
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SKRMVRF : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProKirim()
{
    $db = openDB();

    $sql = "UPDATE dtproduk P
            SET KQTY = ROUND((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo PO ON K2.IDPO = PO.ID WHERE K2.IDPRODUK = P.ID && PO.STAT = 'SN'),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROKRM : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET KQTY = ROUND((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo PO ON K2.IDPO = PO.ID INNER JOIN trkirim K ON K.ID = K2.ID WHERE K2.IDPRODUK = P.IDPRODUK && PO.STAT = 'SN' && PO.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROKRM - 2 : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProKirim2($db)
{
    $sql = "UPDATE dtproduk P
            SET KQTY = ROUND((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo PO ON K2.IDPO = PO.ID WHERE K2.IDPRODUK = P.ID && PO.STAT = 'SN'),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROKRM : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET KQTY = ROUND((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo PO ON K2.IDPO = PO.ID INNER JOIN trkirim K ON K.ID = K2.ID WHERE K2.IDPRODUK = P.IDPRODUK && PO.STAT = 'SN' && PO.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROKRM - 2 : ".mysqli_error($db));
}

function newKirim($id, $tgl, $ket1, $ket2, $ket3, $user, $wkt, $gdg)
{
    $db = openDB();

    $sql = "INSERT INTO trkirim
            (ID, DATE, KET1, KET2, KET3, IDUSER, WKT, IDGDG)
            VALUES
            ('$id', '$tgl', '$ket1', '$ket2', '$ket3', '$user', '$wkt', '$gdg')";

    mysqli_query($db, $sql) or die("Error F(x) NKRM : ".mysqli_error($db));

    closeDB($db);
}

function newKirim2($id, $tgl, $ket1, $ket2, $ket3, $user, $wkt, $db)
{
    $sql = "INSERT INTO trkirim
            (ID, DATE, KET1, KET2, KET3, IDUSER, WKT)
            VALUES
            ('$id', '$tgl', '$ket1', '$ket2', '$ket3', '$user', '$wkt')";

    mysqli_query($db, $sql) or die("Error F(x) NKRM : ".mysqli_error($db));
}

function newDtlKirim($id, $pro, $weight, $urut, $po, $qty, $sat, $tglexp, $ket)
{
    $db = openDB();

    $sql = "INSERT INTO trkirim2
            (ID, IDPRODUK, WEIGHT, URUT, IDPO, QTY, SAT, TGLEXP, KET)
            VALUES
            ('$id', '$pro', '$weight', '$urut', '$po', '$qty', '$sat', '$tglexp', '$ket')";

    mysqli_query($db, $sql) or die("Error F(x) NDKRM : ".mysqli_error($db));

    closeDB($db);
}

function newDtlKirim2($id, $pro, $weight, $urut, $po, $qty, $sat, $tglexp, $ket, $db)
{
    $sql = "INSERT INTO trkirim2
            (ID, IDPRODUK, WEIGHT, URUT, IDPO, QTY, SAT, TGLEXP, KET)
            VALUES
            ('$id', '$pro', '$weight', '$urut', '$po', '$qty', '$sat', '$tglexp', '$ket')";

    mysqli_query($db, $sql) or die("Error F(x) NDKRM2 : ".mysqli_error($db));
}

function newHstKirim($id, $idtran_bfr, $tgl_bfr, $ket1_bfr, $ket2_bfr, $ket3_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $tgl_afr, $ket1_afr, $ket2_afr, $ket3_afr, $user_afr, $wkt_afr, $eby, $eon, $estat, $gdg_bfr, $gdg_afr)
{
    $db = openDB();

    $sql = "INSERT INTO hst_trkirim
            (ID, IDTRAN_BFR, DATE_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR, EDITEDBY, EDITEDON, EDITEDSTAT, IDGDG_BFR, IDGDG_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$ket1_bfr', '$ket2_bfr', '$ket3_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$tgl_afr', '$ket1_afr', '$ket2_afr', '$ket3_afr', '$user_afr', '$wkt_afr', '$eby', '$eon', '$estat', '$gdg_bfr', '$gdg_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHKRM : ".mysqli_error($db));

    closeDB($db);
}

function newHstKirim2($id, $idtran_bfr, $tgl_bfr, $ket1_bfr, $ket2_bfr, $ket3_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $tgl_afr, $ket1_afr, $ket2_afr, $ket3_afr, $user_afr, $wkt_afr, $eby, $eon, $estat, $db)
{
    $sql = "INSERT INTO hst_trkirim
            (ID, IDTRAN_BFR, DATE_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR, EDITEDBY, EDITEDON, EDITEDSTAT)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$ket1_bfr', '$ket2_bfr', '$ket3_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$tgl_afr', '$ket1_afr', '$ket2_afr', '$ket3_afr', '$user_afr', '$wkt_afr', '$eby', '$eon', '$estat')";

    mysqli_query($db, $sql) or die("Error F(x) NHKRM : ".mysqli_error($db));
}

function newHstDtlKirim($id, $idtran, $pro, $weight, $urut, $type, $po, $qty, $sat, $tglexp, $ket)
{
    $db = openDB();

    $sql = "INSERT INTO hst_trkirim2
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, TYPE, IDPO, QTY, SAT, TGLEXP, KET)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$type', '$po', '$qty', '$sat', '$tglexp', '$ket')";

    mysqli_query($db, $sql) or die("Error F(x) NHDKRM : ".mysqli_error($db));

    closeDB($db);
}

function newHstDtlKirim2($id, $idtran, $pro, $weight, $urut, $type, $po, $qty, $sat, $tglexp, $ket, $db)
{
    $sql = "INSERT INTO hst_trkirim2
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, TYPE, IDPO, QTY, SAT, TGLEXP, KET)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$type', '$po', '$qty', '$sat', '$tglexp', '$ket')";

    mysqli_query($db, $sql) or die("Error F(x) NHDKRM : ".mysqli_error($db));
}

function updKirim($id, $tgl, $ket1, $ket2, $ket3, $user, $wkt, $bid, $gdg)
{
    $db = openDB();

    $sql = "UPDATE trkirim
            SET ID = '$id', DATE = '$tgl', KET1 = '$ket1', KET2 = '$ket2', KET3 = '$ket3', IDUSER = '$user', WKT = '$wkt', IDGDG = '$gdg'
            WHERE ID = '$bid'";
            
    mysqli_query($db, $sql) or die("Error F(x) UKRM : ".mysqli_error($db));

    closeDB($db);
}

function updKirimID($id, $bid)
{
    $db = openDB();

    $sql = "UPDATE trkirim
            SET ID = '$id'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UKRMID : ".mysqli_error($db));

    $sql = "UPDATE hst_trkirim
            SET IDTRAN_AFR = '$id'
            WHERE IDTRAN_AFR = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UKRMID - 2 : ".mysqli_error($db));

    closeDB($db);
}

function delKirim($id)
{
    $db = openDB();

    $sql = "DELETE FROM trkirim
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DKRM : ".mysqli_error($db));

    closeDB($db);
}

function delKirimTgl($tgl)
{
    $db = openDB();

    $sql = "DELETE FROM trkirim
            WHERE DATE = '$tgl'";
            
    mysqli_query($db, $sql) or die("Error F(x) DKRMT : ".mysqli_error($db));

    $sql = "SET foreign_key_checks = 0";

    mysqli_query($db, $sql) or die("Error F(x) DKRMT - 1 : ".mysqli_error($db));

    $sql = "DELETE FROM dtpo
            WHERE DATE = '$tgl'";
            
    mysqli_query($db, $sql) or die("Error F(x) DKRMT - 2 : ".mysqli_error($db));

    $sql = "SET foreign_key_checks = 1";

    mysqli_query($db, $sql) or die("Error F(x) DKRMT - 3 : ".mysqli_error($db));

    $sql = "DELETE FROM hst_trkirim
            WHERE ((EDITEDSTAT = 'NEW' || EDITEDSTAT = 'EDIT') && DATE_AFR = '$tgl') || (EDITEDSTAT = 'DELETE' && DATE_BFR = '$tgl');";

    mysqli_query($db, $sql) or die("Error F(x) DKRMT - 4 : ".mysqli_error($db));

    closeDB($db);
}

function delKirimPO($id)
{
    $db = openDB();

    $sql = "DELETE FROM trkirim2
            WHERE IDPO = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DKRMPO : ".mysqli_error($db));

    $sql = "DELETE FROM hst_trkirim2
            WHERE IDPO = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DKRMPO - 2 : ".mysqli_error($db));

    $sql = "DELETE T FROM trkirim T
            WHERE (SELECT COUNT(ID) FROM trkirim2 WHERE ID = T.ID) = 0";

    mysqli_query($db, $sql) or die("Error F(x) DKRMPO - 3 : ".mysqli_error($db));

    closeDB($db);
}

function delAllDtlKirim($id)
{
    $db = openDB();

    $sql = "DELETE FROM trkirim2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADKRM : ".mysqli_error($db));

    closeDB($db);
}

//MASUK PRODUK
function getAllMP()
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), (SELECT SUM(WEIGHT) FROM prmsk2 WHERE ID = M.ID), IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM prmsk M
            WHERE DATE = CURDATE() ORDER BY DATE, WKT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAMP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getMPID($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, IDUSER, WKT, VERIF, VUSER, IDGDG FROM prmsk
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMPID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getMPHIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prmsk
            WHERE DATE_AFR = '$tgl' && EDITEDSTAT = 'NEW'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMPHIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getMPItem($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDPRODUK, WEIGHT, URUT, KET FROM prmsk2
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMPITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getMPItem2($id)
{
    $db = openDB();

    $sql = "SELECT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), M2.WEIGHT, M2.KET, P.ID, M2.URUT, M2.IDPRODUK FROM prmsk2 M2 INNER JOIN dtproduk P ON M2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE M2.ID = '$id' ORDER BY P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMPITM2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getMPItem3($id, $pro = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(WEIGHT) FROM prmsk2 WHERE ID = M2.ID && IDPRODUK = M2.IDPRODUK), M2.KET FROM prmsk2 M2 INNER JOIN dtproduk P ON M2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE M2.ID = '$id'";

    if(strcasecmp($pro,"") != 0)
        $sql .= " && M2.IDPRODUK = '$pro'";

    $sql .= " ORDER BY P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMPITM3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getMPItem4($frm, $to, $pro = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(SM2.WEIGHT) FROM prmsk2 SM2 INNER JOIN prmsk SM ON SM2.ID = SM.ID WHERE SM.DATE >= '$frm' && SM.DATE <= '$to' && SM2.IDPRODUK = M2.IDPRODUK), M2.KET FROM prmsk2 M2 INNER JOIN dtproduk P ON M2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN prmsk M ON M2.ID = M.ID
            WHERE M.DATE >= '$frm' && M.DATE <= '$to'";

    if(strcasecmp($pro,"") != 0)
        $sql .= " && M2.IDPRODUK = '$pro'";

    $sql .= " ORDER BY P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMPITM4 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getMPIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM prmsk
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMPIDT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);    

    closeDB($db);

    return $row[0];
}

function getMPFrmTo($frm, $to, $pro = "")
{
    $db = openDB();

    $whr = "";
    if(strcasecmp($pro,"") != 0)
        $whr = " && IDPRODUK = '$pro'";

    $sql = "SELECT ID, DATE, (SELECT SUM(WEIGHT) FROM prmsk2 WHERE ID = M.ID $whr) FROM prmsk M
            WHERE DATE >= '$frm' && DATE <= '$to' && (SELECT SUM(WEIGHT) FROM prmsk2 WHERE ID = M.ID $whr) IS NOT NULL ORDER BY DATE ASC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMPFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getMPFrmTo2($frm, $to, $pro = "")
{
    $db = openDB();

    $whr = "";
    if(strcasecmp($pro,"") != 0)
        $whr = " && IDPRODUK = '$pro'";

    $sql = "SELECT DISTINCT DATE_FORMAT(DATE, '%M %Y'), (SELECT SUM(SM2.WEIGHT) FROM prmsk2 SM2 INNER JOIN prmsk SM ON SM2.ID = SM.ID WHERE MONTH(SM.DATE) = MONTH(M.DATE) $whr), DATE_FORMAT(DATE, '%Y-%m') FROM prmsk M
            WHERE DATE >= '$frm' && DATE <= '$to' && (SELECT SUM(WEIGHT) FROM prmsk2 WHERE ID = M.ID $whr) IS NOT NULL ORDER BY DATE ASC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMPFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHstMPFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, ID, IDTRAN_BFR, DATE_BFR, (SELECT SUM(WEIGHT) FROM hst_prmsk2 WHERE ID = M.ID && TYPE = 'B'), IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, (SELECT SUM(WEIGHT) FROM hst_prmsk2 WHERE ID = M.ID && TYPE = 'A'), IDUSER_AFR, WKT_AFR FROM hst_prmsk M";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) GHMPFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getHMPID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT IDTRAN_BFR, DATE_FORMAT(DATE_BFR, '%d/%m/%Y'), IDUSER_BFR, WKT_BFR FROM hst_prmsk";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT IDTRAN_AFR, DATE_FORMAT(DATE_AFR, '%d/%m/%Y'), IDUSER_AFR, WKT_AFR FROM hst_prmsk";

    $sql .= " WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHMPID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getHMPItem($id, $type)
{
    $db = openDB();

    $sql = "SELECT T2.ID, T2.IDTRAN, T2.IDPRODUK, T2.WEIGHT, T2.TYPE, T2.URUT, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, T2.KET FROM hst_prmsk2 T2 LEFT JOIN dtproduk P ON T2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE T2.ID = '$id' && T2.TYPE = '$type' ORDER BY T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHMPITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastIDMP($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM prmsk
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDMP : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastHIDMP($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prmsk
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLHIDMP : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastUrutMP($id)
{
    $db = openDB();

    $sql = "SELECT URUT FROM prmsk2
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUMP : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countMPID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prmsk
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CMPID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countMP($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prmsk
            WHERE DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$id%' || IDUSER LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CMP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countMPTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prmsk
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CMPT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schMP($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), (SELECT SUM(WEIGHT) FROM prmsk2 WHERE ID = M.ID), IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM prmsk M";

    if(countMP($id) > 0)
        $sql .= " WHERE (DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$id%' || IDUSER LIKE '%$id%')";
    else
    {
        $y = explode(" ",$id);
        
        $sql .= " WHERE (";
        for($i = 0; $i < count($y); $i++)
        {
            $sch = $y[$i];
            for($j = 0; $j < count($y); $j++)
            {
                if($j == $i)
                    continue;
                
                $sch = $sch."%".$y[$j];
            }
            
            $sql .= "DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$sch%' || IDUSER LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }

    if(strcasecmp($id,"") == 0)
        $sql .= " && DATE = CURDATE()";

    $sql .= " ORDER BY DATE, WKT";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) SMP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function updQtyProMP()
{
    $db = openDB();

    $sql = "UPDATE dtproduk P
            SET MPQTY = ROUND((SELECT SUM(WEIGHT) FROM prmsk2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROMP : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET MPQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prmsk2 SP2 INNER JOIN prmsk SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROMP - 2 : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProMP2($db)
{
    $sql = "UPDATE dtproduk P
            SET MPQTY = ROUND((SELECT SUM(WEIGHT) FROM prmsk2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROMP : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET MPQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prmsk2 SP2 INNER JOIN prmsk SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROMP - 2 : ".mysqli_error($db));
}

function newMP($id, $tgl, $user, $wkt, $gdg)
{
    $db = openDB();

    $sql = "INSERT INTO prmsk
            (ID, DATE, IDUSER, WKT, IDGDG)
            VALUES
            ('$id', '$tgl', '$user', '$wkt', '$gdg')";

    mysqli_query($db, $sql) or die("Error F(x) NMP : ".mysqli_error($db));

    closeDB($db);
}

function newHMP($id, $idtran_bfr, $tgl_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $tgl_afr, $user_afr, $wkt_afr, $eon, $eby, $estat, $gdg_bfr, $gdg_afr)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prmsk
            (ID, IDTRAN_BFR, DATE_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, IDUSER_AFR, WKT_AFR, EDITEDON, EDITEDBY, EDITEDSTAT, IDGDG_BFR, IDGDG_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$tgl_afr', '$user_afr', '$wkt_afr', '$eon', '$eby', '$estat', '$gdg_bfr', '$gdg_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHMP : ".mysqli_error($db));

    closeDB($db);
}

function newDtlMP($id, $pro, $weight, $urut, $ket)
{
    $db = openDB();

    $sql = "INSERT INTO prmsk2
            (ID, IDPRODUK, WEIGHT, URUT, KET)
            VALUES
            ('$id', '$pro', '$weight', '$urut', '$ket')";

    mysqli_query($db, $sql) or die("Error F(x) NDMP : ".mysqli_error($db));

    closeDB($db);
}

function newHDtlMP($id, $idtran, $pro, $weight, $urut, $ket, $type)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prmsk2
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, KET, TYPE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$ket', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NHDMP : ".mysqli_error($db));

    closeDB($db);
}

function updMP($id, $tgl, $user, $wkt, $bid, $gdg)
{
    $db = openDB();

    $sql = "UPDATE prmsk
            SET ID = '$id', DATE = '$tgl', IDUSER = '$user', WKT = '$wkt', IDGDG = '$gdg'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UMP : ".mysqli_error($db));

    closeDB($db);
}

function delMP($id)
{
    $db = openDB();

    $sql = "DELETE FROM prmsk
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DMP : ".mysqli_error($db));

    closeDB($db);
}

function delAllDtlMP($id)
{
    $db = openDB();

    $sql = "DELETE FROM prmsk2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADMP : ".mysqli_error($db));

    closeDB($db);
}

function getAllMPVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM prmsk
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAMPVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setMPVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE prmsk
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SMPVRF : ".mysqli_error($db));

    closeDB($db);
}

//PEMBEKUAN
function getAllFrz()
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), (SELECT SUM(WEIGHT) FROM prfrz2 WHERE ID = F.ID), IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM prfrz F
            WHERE DATE = CURDATE() ORDER BY DATE, WKT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAFRZ : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getFrzID($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, IDUSER, WKT, VERIF, VUSER, IDGDG FROM prfrz
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GFRZID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getFrzHIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prfrz
            WHERE DATE_AFR = '$tgl' && EDITEDSTAT = 'NEW'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GFrzHIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getFrzItem($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDPRODUK, IDTERIMA, URUTTRM, WEIGHT, URUT, KET, IDPRODUK2 FROM prfrz2
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GFRZITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getFrzItem2($id)
{
    $db = openDB();

    $sql = "SELECT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT NAME FROM dtsup WHERE ID = (SELECT IDSUP FROM prterima WHERE ID = M2.IDTERIMA)), M2.IDTERIMA, (SELECT DATE_FORMAT(DATE, '%d/%m/%Y') FROM prterima WHERE ID = M2.IDTERIMA), M2.WEIGHT, M2.KET, P.ID, M2.URUT, P2.NAME, G2.NAME, IFNULL(K2.NAME, ''), IFNULL(SK2.NAME, ''), M2.URUTTRM, P2.ID FROM prfrz2 M2 INNER JOIN dtproduk P ON M2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtproduk P2 ON M2.IDPRODUK2 = P2.ID INNER JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID
            WHERE M2.ID = '$id' ORDER BY P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GFRZITM2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getFrzIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM prfrz
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GFRZIDT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);    

    closeDB($db);

    return $row[0];
}

function getFrzFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT DATE, (SELECT SUM(WEIGHT) FROM prfrz2 WHERE ID = M.ID) FROM prfrz M
            WHERE DATE >= '$frm' && DATE <= '$to' && (SELECT SUM(WEIGHT) FROM prfrz2 WHERE ID = M.ID) IS NOT NULL ORDER BY DATE ASC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GFRZFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getFrzFrmTo2($frm, $to)
{
    $db = openDB();

    $sql = "SELECT F.DATE, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), F2.WEIGHT, SP.NAME, F2.IDTERIMA, DATE_FORMAT(T.DATE, '%d/%m/%Y'), P2.NAME, G2.NAME, IFNULL(K2.NAME, ''), IFNULL(SK2.NAME, '') FROM prfrz F INNER JOIN prfrz2 F2 ON F.ID = F2.ID INNER JOIN dtproduk P ON F2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN prterima T ON F2.IDTERIMA = T.ID INNER JOIN dtsup SP ON T.IDSUP = SP.ID INNER JOIN dtproduk P2 ON F2.IDPRODUK2 = P2.ID INNER JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID
            WHERE F.DATE >= '$frm' && F.DATE <= '$to' ORDER BY F.DATE ASC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GFRZFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHstFrzFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, ID, IDTRAN_BFR, DATE_BFR, (SELECT SUM(WEIGHT) FROM hst_prfrz2 WHERE ID = M.ID && TYPE = 'B'), IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, (SELECT SUM(WEIGHT) FROM hst_prfrz2 WHERE ID = M.ID && TYPE = 'A'), IDUSER_AFR, WKT_AFR FROM hst_prfrz M";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) GHFRZFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getHFrzID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT IDTRAN_BFR, DATE_FORMAT(DATE_BFR, '%d/%m/%Y'), IDUSER_BFR, WKT_BFR FROM hst_prfrz";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT IDTRAN_AFR, DATE_FORMAT(DATE_AFR, '%d/%m/%Y'), IDUSER_AFR, WKT_AFR FROM hst_prfrz";

    $sql .= " WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHFRZID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    if($row[10] == null)
        $row[10] = 0;

    closeDB($db);

    return $row;
}

function getHFrzItem($id, $type)
{
    $db = openDB();

    $sql = "SELECT T2.ID, T2.IDTRAN, T2.IDPRODUK, T2.WEIGHT, T2.TYPE, T2.URUT, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, T2.KET, T2.IDTERIMA, DATE_FORMAT(PT.DATE, '%d/%m/%Y'), (SELECT NAME FROM dtsup WHERE ID = PT.IDSUP), T2.IDPRODUK2, P2.NAME, IFNULL(K2.NAME, ''), IFNULL(SK2.NAME, ''), G2.NAME FROM hst_prfrz2 T2 LEFT JOIN dtproduk P ON T2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN prterima PT ON T2.IDTERIMA = PT.ID LEFT JOIN dtproduk P2 ON T2.IDPRODUK2 = P2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID LEFT JOIN dtgrade G2 ON P2.IDGRADE = G2.ID
            WHERE T2.ID = '$id' && T2.TYPE = '$type' ORDER BY T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHFRZITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastIDFrz($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM prfrz
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDFRZ : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastHIDFrz($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_prfrz
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLHIDFRZ : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastUrutFrz($id)
{
    $db = openDB();

    $sql = "SELECT URUT FROM prfrz2
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUFRZ : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getSumFrzFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT SUM(F2.WEIGHT), COUNT(F2.IDPRODUK) FROM prfrz2 F2 INNER JOIN prfrz F ON F.ID = F2.ID INNER JOIN prterima T ON F2.IDTERIMA = T.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to' && T.KOTA = ''";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSFRZFT : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum;
}

function countFrzID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prfrz
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CFRZID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countFrz($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prfrz
            WHERE DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$id%' || IDUSER LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CFRZ : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countFrzTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM prfrz
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CFRZT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schFrz($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), (SELECT SUM(WEIGHT) FROM prfrz2 WHERE ID = M.ID), IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM prfrz M";

    if(countFrz($id) > 0)
        $sql .= " WHERE (DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$id%' || IDUSER LIKE '%$id%')";
    else
    {
        $y = explode(" ",$id);
        
        $sql .= " WHERE (";
        for($i = 0; $i < count($y); $i++)
        {
            $sch = $y[$i];
            for($j = 0; $j < count($y); $j++)
            {
                if($j == $i)
                    continue;
                
                $sch = $sch."%".$y[$j];
            }
            
            $sql .= "DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$sch%' || IDUSER LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }

    if(strcasecmp($id,"") == 0)
        $sql .= " && DATE = CURDATE()";

    $sql .= " ORDER BY DATE, WKT";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) SFRZ : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function updQtyProFrz()
{
    $db = openDB();

    $sql = "UPDATE dtproduk P
            SET FOQTY = ROUND((SELECT SUM(WEIGHT) FROM prfrz2 WHERE IDPRODUK = P.ID), 2), FIQTY = ROUND((SELECT SUM(WEIGHT) FROM prfrz2 WHERE IDPRODUK2 = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROFRZ : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET FOQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prfrz2 SP2 INNER JOIN prfrz SP ON SP.ID = SP2.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2), FIQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prfrz2 SP2 INNER JOIN prfrz SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK2 = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROFRZ - 2 : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProFrz2($db)
{
    $sql = "UPDATE dtproduk P
            SET FOQTY = ROUND((SELECT SUM(WEIGHT) FROM prfrz2 WHERE IDPRODUK = P.ID), 2), FIQTY = ROUND((SELECT SUM(WEIGHT) FROM prfrz2 WHERE IDPRODUK2 = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROFRZ : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET FOQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prfrz2 SP2 INNER JOIN prfrz SP ON SP.ID = SP2.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2), FIQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM prfrz2 SP2 INNER JOIN prfrz SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK2 = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROFRZ - 2 : ".mysqli_error($db));
}

function newFrz($id, $tgl, $user, $wkt, $gdg)
{
    $db = openDB();

    $sql = "INSERT INTO prfrz
            (ID, DATE, IDUSER, WKT, IDGDG)
            VALUES
            ('$id', '$tgl', '$user', '$wkt', '$gdg')";

    mysqli_query($db, $sql) or die("Error F(x) NFRZ : ".mysqli_error($db));

    closeDB($db);
}

function newHFrz($id, $idtran_bfr, $tgl_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $tgl_afr, $user_afr, $wkt_afr, $eon, $eby, $estat, $gdg_bfr, $gdg_afr)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prfrz
            (ID, IDTRAN_BFR, DATE_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, IDUSER_AFR, WKT_AFR, EDITEDON, EDITEDBY, EDITEDSTAT, IDGDG_BFR, IDGDG_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$tgl_afr', '$user_afr', '$wkt_afr', '$eon', '$eby', '$estat', '$gdg_bfr', '$gdg_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHFRZ : ".mysqli_error($db));

    closeDB($db);
}

function newDtlFrz($id, $pro, $idtrm, $utrm, $weight, $urut, $ket, $pro2)
{
    $db = openDB();

    $sql = "INSERT INTO prfrz2
            (ID, IDPRODUK, IDTERIMA, URUTTRM, WEIGHT, URUT, KET, IDPRODUK2)
            VALUES
            ('$id', '$pro', '$idtrm', '$utrm', '$weight', '$urut', '$ket', '$pro2')";
            
    mysqli_query($db, $sql) or die("Error F(x) NDFRZ : ".mysqli_error($db));

    closeDB($db);
}

function newHDtlFrz($id, $idtran, $pro, $idtrm, $utrm, $weight, $urut, $ket, $pro2, $type)
{
    $db = openDB();

    $sql = "INSERT INTO hst_prfrz2
            (ID, IDTRAN, IDPRODUK, IDTERIMA, URUTTRM, WEIGHT, URUT, KET, IDPRODUK2, TYPE)
            VALUES
            ('$id', '$idtran', '$pro', '$idtrm', '$utrm', '$weight', '$urut', '$ket', '$pro2', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NHDFRZ : ".mysqli_error($db));

    closeDB($db);
}

function updFrz($id, $tgl, $user, $wkt, $bid, $gdg)
{
    $db = openDB();

    $sql = "UPDATE prfrz
            SET ID = '$id', DATE = '$tgl', IDUSER = '$user', WKT = '$wkt', IDGDG = '$gdg'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UFRZ : ".mysqli_error($db));

    closeDB($db);
}

function delFrz($id)
{
    $db = openDB();

    $sql = "DELETE FROM prfrz
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DFRZ : ".mysqli_error($db));

    closeDB($db);
}

function delAllDtlFrz($id)
{
    $db = openDB();

    $sql = "DELETE FROM prfrz2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADFRZ : ".mysqli_error($db));

    closeDB($db);
}

function getAllFrzVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM prfrz
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAFRZVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setFrzVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE prfrz
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SFRZVRF : ".mysqli_error($db));

    closeDB($db);
}

//RE-PACKAGING
function getAllRPkg($db){
    $sql = "SELECT DATE_FORMAT(T.DATE, '%d/%m/%Y'), P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), T.WEIGHT, T.IDUSER, DATE_FORMAT(T.WKT, '%d/%m/%Y'), T.ID, (SELECT SUM(WEIGHT) FROM trrpkg2 WHERE ID = T.ID), T.KET FROM trrpkg T INNER JOIN dtproduk P ON T.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE T.DATE = CURDATE() ORDER BY T.WKT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GARPKG : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getRPkgID($id, $db){
    $sql = "SELECT T.ID, T.IDGDG, T.DATE, T.IDUSER, T.WKT, T.VERIF, T.VUSER, T.IDPRODUK, T.WEIGHT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), T.KET FROM trrpkg T INNER JOIN dtproduk P ON T.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE T.ID = '$id'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GRPKGID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getRPkgItem($id, $db){
    $sql = "SELECT T2.ID, T2.IDPRODUK, T2.WEIGHT, T2.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, '') FROM trrpkg2 T2 INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE T2.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GRPKGITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getRPkgFrmTo($frm, $to, $bhn, $db){
    $sql = "SELECT DATE_FORMAT(T.DATE, '%d/%m/%Y'), P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), T.WEIGHT, T.IDUSER, DATE_FORMAT(T.WKT, '%d/%m/%Y'), T.ID, (SELECT SUM(WEIGHT) FROM trrpkg2 WHERE ID = T.ID), T.KET FROM trrpkg T INNER JOIN dtproduk P ON T.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to'";

    if(strcasecmp($bhn,"") != 0){
        $sql .= " && T.IDPRODUK = '$bhn'";
    }

    $sql .= " ORDER BY T.DATE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GRPKGFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getRPkgFrmTo2($frm, $to, $bhn, $hsl, $db){
    $sql = "SELECT DATE_FORMAT(T.DATE, '%d/%m/%Y'), P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), T.WEIGHT, T.IDUSER, DATE_FORMAT(T.WKT, '%d/%m/%Y'), T.ID, P2.NAME, G2.NAME, IFNULL(K2.NAME, ''), IFNULL(SK2.NAME, ''), T2.WEIGHT, T.KET FROM trrpkg T INNER JOIN dtproduk P ON T.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN trrpkg2 T2 ON T.ID = T2.ID INNER JOIN dtproduk P2 ON T2.IDPRODUK = P2.ID INNER JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to'";

    if(strcasecmp($bhn,"") != 0){
        $sql .= " && T.IDPRODUK = '$bhn'";
    }

    if(strcasecmp($hsl,"") != 0){
        $sql .= " && T2.IDPRODUK = '$hsl'";
    }

    $sql .= " ORDER BY T.DATE, T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GRPKGFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getHRPkgID($id, $type, $db){
    if(strcasecmp($type,"B") == 0){
        $sql = "SELECT R.IDTRAN_BFR, DATE_FORMAT(R.DATE_BFR, '%d/%m/%Y'), IFNULL(P.NAME,''), IFNULL(G.NAME,''), IFNULL(K.NAME,''), IFNULL(SK.NAME,''), R.WEIGHT_BFR, T.KET_BFR FROM hst_trrpkg R LEFT JOIN dtproduk P ON R.IDPRODUK_BFR = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID";
    }
    else if(strcasecmp($type,"A") == 0){
        $sql = "SELECT R.IDTRAN_AFR, DATE_FORMAT(R.DATE_AFR, '%d/%m/%Y'), IFNULL(P.NAME,''), IFNULL(G.NAME,''), IFNULL(K.NAME,''), IFNULL(SK.NAME,''), R.WEIGHT_AFR, T.KET_AFR FROM hst_trrpkg R LEFT JOIN dtproduk P ON R.IDPRODUK_AFR = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID";
    }

    $sql .= " WHERE R.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHRPKGID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getHRPkgItem($id, $type, $db){
    $sql = "SELECT R2.IDTRAN, IFNULL(P.NAME,''), IFNULL(G.NAME,''), IFNULL(K.NAME,''), IFNULL(SK.NAME,''), R2.WEIGHT FROM hst_trrpkg2 R2 INNER JOIN dtproduk P ON R2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE R2.ID = '$id' && R2.TYPE = '$type'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHRPKGITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getHRPkgFrmTo($frm, $to, $jtgl, $db){
    $sql = "SELECT R.ID, DATE_FORMAT(R.EDITEDON, '%d/%m/%Y'), R.EDITEDBY, R.EDITEDSTAT, DATE_FORMAT(R.DATE_BFR, '%d/%m/%Y'), R.IDTRAN_BFR, P.NAME, G.NAME, K.NAME, SK.NAME, R.WEIGHT_BFR, (SELECT SUM(WEIGHT) FROM hst_trrpkg2 WHERE ID = R.ID AND TYPE = 'B'), DATE_FORMAT(R.DATE_AFR, '%d/%m/%Y'), R.IDTRAN_AFR, P2.NAME, G2.NAME, K2.NAME, SK2.NAME, R.WEIGHT_AFR, (SELECT SUM(WEIGHT) FROM hst_trrpkg2 WHERE ID = R.ID AND TYPE = 'A'), T.KET FROM hst_trrpkg R LEFT JOIN dtproduk P ON R.IDPRODUK_BFR = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtproduk P2 ON R.IDPRODUK_AFR = P2.ID LEFT JOIN dtgrade G2 ON P2.IDGRADE = G2.ID LEFT JOIN dtkate K2 ON P2.IDKATE = K2.ID LEFT JOIN dtskate SK2 ON P2.IDSKATE = SK2.ID";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(R.EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(R.EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY R.EDITEDON, R.ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(R.EDITEDSTAT,'DELETE') = 0,R.DATE_BFR, R.DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(R.EDITEDSTAT,'DELETE') = 0,R.DATE_BFR, R.DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(R.EDITEDSTAT,'DELETE') = 0,R.DATE_BFR, R.DATE_AFR), R.ID";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) GHRPKGFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getLastRPkgID($aw, $ak, $db){
    $sql = "SELECT ID FROM trrpkg
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLRPKGID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastHRPkgID($aw, $ak, $db){
    $sql = "SELECT ID FROM hst_trrpkg
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLHRPKGID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function countRPkgID($id, $db){
    $sql = "SELECT COUNT(ID) FROM trrpkg
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CRPKGID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countRPkg($id, $db){
    $sql = "SELECT COUNT(T.ID) FROM trrpkg T INNER JOIN dtproduk P ON T.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$id%' || P.NAME LIKE '%$id%' || G.NAME LIKE '%$id%' || K.NAME LIKE '%$id%' || SK.NAME LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CRPKG : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function schRPkg($id, $db){
    $sql = "SELECT DATE_FORMAT(T.DATE, '%d/%m/%Y'), P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), T.WEIGHT, T.IDUSER, DATE_FORMAT(T.WKT, '%d/%m/%Y'), T.ID, (SELECT SUM(WEIGHT) FROM trrpkg2 WHERE ID = T.ID), T.KET FROM trrpkg T INNER JOIN dtproduk P ON T.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID";

    if(countRPkg($id, $db) > 0){
        $sql .= " WHERE DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$id%' || P.NAME LIKE '%$id%' || G.NAME LIKE '%$id%' || K.NAME LIKE '%$id%' || SK.NAME LIKE '%$id%' || T.KET LIKE '%$id%'";
    }
    else{
        $y = explode(" ",$id);
        
        $sql .= " WHERE (";
        for($i = 0; $i < count($y); $i++)
        {
            $sch = $y[$i];
            for($j = 0; $j < count($y); $j++)
            {
                if($j == $i)
                    continue;
                
                $sch = $sch."%".$y[$j];
            }
            
            $sql .= "DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$sch%' || P.NAME LIKE '%$sch%' || G.NAME LIKE '%$sch%' || K.NAME LIKE '%$sch%' || SK.NAME LIKE '%$sch%' || T.KET LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) SRPKG : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function setRPkgVerif($id, $user, $kode, $db)
{
    $sql = "UPDATE trrpkg
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SRPKGVRF : ".mysqli_error($db));
}

function newRPkg($id, $gdg, $tgl, $user, $wkt, $pro, $weight, $ket, $db){
    $sql = "INSERT INTO trrpkg
            (ID, IDGDG, DATE, IDUSER, WKT, IDPRODUK, WEIGHT, KET)
            VALUES
            ('$id', '$gdg', '$tgl', '$user', '$wkt', '$pro', '$weight', '$ket')";

    mysqli_query($db, $sql) or die("Error F(x) NRPKG : ".mysqli_error($db));
}

function newHRPkg($id, $idtran_bfr, $gdg_bfr, $tgl_bfr, $user_bfr, $wkt_bfr, $pro_bfr, $weight_bfr, $idtran_afr, $gdg_afr, $tgl_afr, $user_afr, $wkt_afr, $pro_afr, $weight_afr, $ket_bfr, $ket_afr, $eby, $eon, $estat, $db){
    $sql = "INSERT INTO hst_trrpkg
            (ID, IDTRAN_BFR, IDGDG_BFR, DATE_BFR, IDUSER_BFR, WKT_BFR, IDPRODUK_BFR, WEIGHT_BFR, IDTRAN_AFR, IDGDG_AFR, DATE_AFR, IDUSER_AFR, WKT_AFR, IDPRODUK_AFR, WEIGHT_AFR, KET_BFR, KET_AFR, EDITEDBY, EDITEDON, EDITEDSTAT)
            VALUES
            ('$id', '$idtran_bfr', '$gdg_bfr', '$tgl_bfr', '$user_bfr', '$wkt_bfr', '$pro_bfr', '$weight_bfr', '$idtran_afr', '$gdg_afr', '$tgl_afr', '$user_afr', '$wkt_afr', '$pro_afr', '$weight_afr', '$ket_bfr', '$ket_afr', '$eby', '$eon', '$estat')";

    mysqli_query($db, $sql) or die("Error F(x) NHRPKG : ".mysqli_error($db));
}

function newDtlRPkg($id, $pro, $weight, $urut, $db){
    $sql = "INSERT INTO trrpkg2
            (ID, IDPRODUK, WEIGHT, URUT)
            VALUES
            ('$id', '$pro', '$weight', '$urut')";

    mysqli_query($db, $sql) or die("Error F(x) NDRPKG : ".mysqli_error($db));
}

function newDtlHRPkg($id, $idtran, $pro, $weight, $urut, $type, $db){
    $sql = "INSERT INTO hst_trrpkg2
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, TYPE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NDHRPKG : ".mysqli_error($db));
}

function updRPkg($id, $gdg, $tgl, $user, $pro, $weight, $ket, $db){
    $sql = "UPDATE trrpkg
            SET IDGDG = '$gdg', DATE = '$tgl', IDUSER = '$user', IDPRODUK = '$pro', WEIGHT = '$weight', KET = '$ket'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) URPKG : ".mysqli_error($db));
}

function updQtyProRPkg($db){
    $sql = "UPDATE dtproduk P
            SET RPIQTY = (SELECT SUM(WEIGHT) FROM trrpkg2 WHERE IDPRODUK = P.ID), RPOQTY = (SELECT SUM(WEIGHT) FROM trrpkg WHERE IDPRODUK = P.ID)";

    mysqli_query($db, $sql) or die("Error F(x) UQPRORPKG : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET RPIQTY = (SELECT SUM(T2.WEIGHT) FROM trrpkg2 T2 INNER JOIN trrpkg T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.IDPRODUK AND T.IDGDG = P.IDGDG), RPOQTY = (SELECT SUM(WEIGHT) FROM trrpkg WHERE IDPRODUK = P.IDPRODUK AND IDGDG = P.IDGDG)";

    mysqli_query($db, $sql) or die("Error F(x) UQPRORPKG - 2 : ".mysqli_error($db));
}

function delAllDtlRPkg($id, $db){
    $sql = "DELETE FROM trrpkg2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADRPKG : ".mysqli_error($db));
}

function delRPkg($id, $db){
    $sql = "DELETE FROM trrpkg
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DRPKG : ".mysqli_error($db));
}
?>