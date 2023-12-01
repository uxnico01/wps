<?php
//PEMINJAMAN
function getAllPjm()
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE_FORMAT(DATE, '%d/%m/%Y'), JLH, XJLH, KET1, KET2, KET3, IDUSER, WKT, POT FROM trpinjam ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAPJM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getAllPjmVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM trpinjam
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAPJMVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getPjmID($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE, JLH, XJLH, KET1, KET2, KET3, IDUSER, WKT, VERIF, VUSER, POT FROM trpinjam
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPJMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    
    closeDB($db);

    return $row;
}

function getPjmSupNCross($id)
{
    $db = openDB();

    $sql = "SELECT ID, JLH, XJLH, POT FROM trpinjam
            WHERE IDSUP = '$id' && JLH != XJLH ORDER BY DATE";

    $result = mysqli_query($db, $sql) or die("Error F(X) GPJMSUPNC : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPjmSupCross($id)
{
    $db = openDB();

    $sql = "SELECT ID, JLH, XJLH, POT FROM trpinjam
            WHERE IDSUP = '$id' && XJLH != 0 ORDER BY DATE DESC";

    $result = mysqli_query($db, $sql) or die("Error F(X) GPJMSUPNC : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPjmSupFrmTo($frm, $to, $sup)
{
    $db = openDB();

    $fy = date('Y', strtotime($frm));
    $fm = date('m', strtotime($frm));
    $fd = date('d', strtotime($frm));

    $ty = date('Y', strtotime($to));
    $tm = date('m', strtotime($to));
    $td = date('d', strtotime($to));

    $arr = array();
    for($i = $fy; $i <= $ty; $i++)
    {
        $sm = 1;
        $em = 12;
        if($i == $fy)
            $sm = $fm;

        if($i == $ty)
            $em = $tm;

        for($j = $sm; $j <= $em; $j++)
        {
            $sd = 1;
            $ed = 31;
            if($j == $fm)
                $sd = $fd;

            if($j == $tm)
                $ed = $td;

            for($k = $sd; $k <= $ed; $k++)
            {
                $sql = "SELECT SUM(JLH), SUM(POT) FROM trpinjam
                        WHERE DATE = '$i-$j-$k' && IDSUP = '$sup'";

                $result = mysqli_query($db, $sql) or die("Error F(x) GPJMSUPFT : ".mysqli_error($db));

                $sum = mysqli_fetch_array($result, MYSQLI_NUM);

                $sql = "SELECT SUM(POTO) FROM prterima
                        WHERE DATE = '$i-$j-$k' && IDSUP = '$sup'";

                $result = mysqli_query($db, $sql) or die("Error F(x) GPJMSUPFT - 2 : ".mysqli_error($db));

                $sum2 = mysqli_fetch_array($result, MYSQLI_NUM);
                
                if($sum[0] == 0 && $sum2[0] == 0 && $sum[1] == 0)
                    continue;

                $ket = "";

                $sql = "SELECT KET1, KET2, KET3 FROM trpinjam
                        WHERE DATE = '$i-$j-$k' && IDSUP = '$sup'";

                $result = mysqli_query($db, $sql) or die("Error F(x) GPJMSUPFT - 3 : ".mysqli_error($db));

                while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                {
                    if(strcasecmp($row[0],"") != 0 && strcasecmp($ket,"") != 0)
                        $ket .= ", ".$row[0];
                    else
                        $ket .= $row[0];

                    if(strcasecmp($row[1],"") != 0 && strcasecmp($ket,"") != 0)
                        $ket .= ", ".$row[1];
                    else
                        $ket .= $row[1];

                    if(strcasecmp($row[2],"") != 0 && strcasecmp($ket,"") != 0)
                        $ket .= ", ".$row[2];
                    else
                        $ket .= $row[2];
                }

                $arr[count($arr)] = array("$i-$j-$k", $sum[0], $sum2[0], $sum[0] - $sum2[0] - $sum[1], $ket, $sum[1]);
            }
        }
    }

    closeDB($db);

    return $arr;
}

function getPjmSupFrmTo2($frm, $to, $sup)
{
    $db = openDB();

    $sql = "SELECT DATE, JLH, XJLH, JLH - XJLH - POT, ID, POT FROM trpinjam
            WHERE DATE >= '$frm' && DATE <= '$to' && IDSUP = '$sup' ORDER BY DATE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPJMSUPFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSisaPjm($sup)
{
    $db = openDB();

    $sql = "SELECT JLH-XJLH-POT, ID FROM trpinjam
            WHERE IDSUP = '$sup' && JLH-XJLH != 0";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSPJM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHstPjmFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, IDTRAN_BFR, DATE_BFR, IDSUP_BFR, JLH_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, IDSUP_AFR, JLH_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR, POT_BFR, POT_AFR FROM hst_trpinjam";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHPJMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHPjmID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT T.IDTRAN_BFR, DATE_FORMAT(T.DATE_BFR, '%d/%m/%Y'), S.NAME, T.JLH_BFR, T.KET1_BFR, T.KET2_BFR, T.KET3_BFR, T.IDUSER_BFR, DATE_FORMAT(T.WKT_BFR, '%d/%m/%Y'), T.POT_BFR FROM hst_trpinjam T LEFT JOIN dtsup S ON T.IDSUP_BFR = S.ID";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT T.IDTRAN_AFR, DATE_FORMAT(T.DATE_AFR, '%d/%m/%Y'), S.NAME, T.JLH_AFR, T.KET1_AFR, T.KET2_AFR, T.KET3_AFR, T.IDUSER_AFR, DATE_FORMAT(T.WKT_AFR, '%d/%m/%Y'), T.POT_AFR FROM hst_trpinjam T LEFT JOIN dtsup S ON T.IDSUP_AFR = S.ID";

    $sql .= " WHERE T.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHPJMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getLastIDPjm($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM trpinjam
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDPJM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDHPjm($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_trpinjam
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHPJM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countPjmID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trpinjam
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPJMID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countHPjmID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM hst_trpinjam
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CHPJMID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countPjm($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(T.ID) FROM trpinjam T INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE T.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || T.KET1 LIKE '%$id%' || T.KET2 LIKE '%$id%' || T.KET3 LIKE '%$id%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPJM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schPjm($id)
{
    $db = openDB();

    $sql = "SELECT T.ID, DATE_FORMAT(T.DATE, '%d/%m/%Y'), S.NAME, T.JLH, T.XJLH, T.KET1, T.KET2, T.KET3, T.IDUSER, DATE_FORMAT(T.WKT, '%d/%m/%Y %H:%i'), T.POT FROM trpinjam T INNER JOIN dtsup S ON T.IDSUP = S.ID";

    if(countPjm($id) > 0)
        $sql .= " WHERE T.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || T.KET1 LIKE '%$id%' || T.KET2 LIKE '%$id%' || T.KET3 LIKE '%$id%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$id%'";
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
            
            $sql .= "T.ID LIKE '%$sch%' || S.NAME LIKE '%$sch%' || T.KET1 LIKE '%$sch%' || T.KET2 LIKE '%$sch%' || T.KET3 LIKE '%$sch%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY T.DATE, T.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) SPJM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setPjmVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE trpinjam
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SPJMVRF : ".mysqli_error($db));

    closeDB($db);
}

function newPjm($id, $sup, $tgl, $jlh, $ket1, $ket2, $ket3, $user, $wkt, $pot)
{
    $db = openDB();

    $sql = "INSERT INTO trpinjam
            (ID, IDSUP, DATE, JLH, KET1, KET2, KET3, IDUSER, WKT, POT)
            VALUES
            ('$id', '$sup', '$tgl', '$jlh', '$ket1', '$ket2', '$ket3', '$user', '$wkt', '$pot')";

    mysqli_query($db, $sql) or die("Error F(x) NPJM : ".mysqli_error($db));

    closeDB($db);
}

function newHPjm($id, $idtran_bfr, $sup_bfr, $tgl_bfr, $jlh_bfr, $xjlh_bfr, $ket1_bfr, $ket2_bfr, $ket3_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $sup_afr, $tgl_afr, $jlh_afr, $xjlh_afr, $ket1_afr, $ket2_afr, $ket3_afr, $user_afr, $wkt_afr, $eby, $estat, $eon, 
$pot_bfr, $pot_afr)
{
    $db = openDB();

    $sql = "INSERT INTO hst_trpinjam
            (ID, IDTRAN_BFR, IDSUP_BFR, DATE_BFR, JLH_BFR, XJLH_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, IDSUP_AFR, DATE_AFR, JLH_AFR, XJLH_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR, EDITEDBY, EDITEDON, EDITEDSTAT, POT_BFR, POT_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$sup_bfr', '$tgl_bfr', '$jlh_bfr', '$xjlh_bfr', '$ket1_bfr', '$ket2_bfr', '$ket3_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$sup_afr', '$tgl_afr', '$jlh_afr', '$xjlh_afr', '$ket1_afr', '$ket2_afr', '$ket3_afr', '$user_afr', '$wkt_afr', '$eby', '$eon', '$estat', '$pot_bfr', '$pot_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHPJM : ".mysqli_error($db));

    closeDB($db);
}

function updXPjm($id, $jlh)
{
    $db = openDB();

    $jlh = (double)$jlh;
    
    $sql = "UPDATE trpinjam
            SET XJLH = XJLH + $jlh
            WHERE ID = '$id'";
            
    mysqli_query($db, $sql) or die("Error F(x) UXPJM : ".mysqli_error($db));

    closeDB($db);
}

function updPjm($id, $sup, $tgl, $jlh, $xjlh, $ket1, $ket2, $ket3, $user, $wkt, $bid, $pot)
{
    $db = openDB();

    $sql = "UPDATE trpinjam
            SET ID = '$id', IDSUP = '$sup', DATE = '$tgl', JLH = '$jlh', XJLH = '$xjlh', KET1 = '$ket1', KET2 = '$ket2', KET3 = '$ket3', IDUSER = '$user', WKT = '$wkt', POT = '$pot'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPJM : ".mysqli_error($db));

    closeDB($db);
}

function delPjm($id)
{
    $db = openDB();

    $sql = "DELETE FROM trpinjam
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DPJM : ".mysqli_error($db));

    closeDB($db);
}

//TANDA TERIMA
function getAllTT()
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDTERIMA, IDUSER, WKT FROM trtt ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GATT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllTTVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM trtt
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GATTVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTTID($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDTERIMA, IDUSER, WKT, VERIF, VUSER FROM trtt
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTTID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getTTItem($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDPRODUK, QTY, WEIGHT, PRICE, IDSAT, URUT FROM trtt2
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTTITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getTTItem2($id)
{
    $db = openDB();

    $sql = "SELECT G.NAME, P.NAME, S.NAME, T2.WEIGHT, T2.QTY, T2.IDPRODUK, T2.IDSAT, T2.PRICE FROM trtt2 T2 INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN dtsat S ON T2.IDSAT = S.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE T2.ID = '$id' ORDER BY T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GTTITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHstTTFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, IDTRAN_BFR, DATE_BFR, IDSUP_BFR, BB_BFR, POTO_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, IDSUP_AFR, BB_AFR, POTO_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR FROM hst_trtt
            WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHTTFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHTTID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT T.IDTRAN_BFR, DATE_FORMAT(T.DATE_BFR, '%d/%m/%Y'), S.NAME, T.BB_BFR, T.POTO_BFR, T.KET1_BFR, T.KET2_BFR, T.KET3_BFR, T.IDUSER_BFR, DATE_FORMAT(T.WKT_BFR, '%d/%m/%Y') FROM hst_trtt T LEFT JOIN dtsup S ON T.IDSUP_BFR = S.ID";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT T.IDTRAN_AFR, DATE_FORMAT(T.DATE_AFR, '%d/%m/%Y'), S.NAME, T.BB_AFR, T.POTO_AFR, T.KET1_AFR, T.KET2_AFR, T.KET3_AFR, T.IDUSER_AFR, DATE_FORMAT(T.WKT_AFR, '%d/%m/%Y') FROM hst_trtt T LEFT JOIN dtsup S ON T.IDSUP_AFR = S.ID";

    $sql .= " WHERE T.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHTTID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getHTTItem($id, $type)
{
    $db = openDB();

    $sql = "SELECT T2.ID, T2.IDTRAN, T2.IDPRODUK, T2.QTY, T2.WEIGHT, T2.IDSAT, T2.TYPE, T2.URUT, P.NAME, G.NAME, K.NAME, SK.NAME, S.NAME, T2.PRICE FROM hst_trtt2 T2 LEFT JOIN dtproduk P ON T2.IDPRODUK = P.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtsat S ON T2.IDSAT = S.ID
            WHERE T2.ID = '$id' && T2.TYPE = '$type' ORDER BY T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHTTITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastIDHTT($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_trtt
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHTT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getSumItemTTSat($id, $sat)
{
    $db = openDB();

    $sql = "SELECT SUM(QTY), SUM(WEIGHT), SUM(PRICE*WEIGHT) FROM trtt2
            WHERE ID = '$id' && IDSAT = '$sat'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSITMTTSAT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function countTTID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trtt
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CTTID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countTT($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(T.ID) FROM trtt T INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE T.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || T.KET1 LIKE '%$id%' || T.KET2 LIKE '%$id%' || T.KET3 LIKE '%$id%' || T.IDTERIMA LIKE '%$id%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CTT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schTT($id)
{
    $db = openDB();

    $sql = "SELECT T.ID, DATE_FORMAT(T.DATE, '%d/%m/%Y'), S.NAME, T.BB, T.POTO, T.KET1, T.KET2, T.KET3, T.IDTERIMA, T.IDUSER, DATE_FORMAT(T.WKT, '%d/%m/%Y %H:%i') FROM trtt T INNER JOIN dtsup S ON T.IDSUP = S.ID";

    if(countTrm($id) > 0)
        $sql .= " WHERE T.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || T.KET1 LIKE '%$id%' || T.KET2 LIKE '%$id%' || T.KET3 LIKE '%$id%' || T.IDTERIMA LIKE '%$id%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$id%'";
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
            
            $sql .= "T.ID LIKE '%$sch%' || S.NAME LIKE '%$sch%' || T.KET1 LIKE '%$sch%' || T.KET2 LIKE '%$sch%' || T.KET3 LIKE '%$sch%' || T.IDTERIMA LIKE '%$sch%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY T.DATE, T.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) STT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setTTVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE trtt
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) STTVRF : ".mysqli_error($db));

    closeDB($db);
}

function newTT($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $trm, $user, $wkt)
{
    $db = openDB();

    $sql = "INSERT INTO trtt
            (ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDTERIMA, IDUSER, WKT)
            VALUES
            ('$id', '$sup', '$tgl', '$bb', '$poto', '$ket1', '$ket2', '$ket3', '$trm', '$user', '$wkt')";

    mysqli_query($db, $sql) or die("Error F(x) NTT : ".mysqli_error($db));

    closeDB($db);
}

function newHTT($id, $idtran_bfr, $sup_bfr, $tgl_bfr, $bb_bfr, $poto_bfr, $ket1_bfr, $ket2_bfr, $ket3_bfr, $trm_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $sup_afr, $tgl_afr, $bb_afr, $poto_afr, $ket1_afr, $ket2_afr, $ket3_afr, $trm_afr, $user_afr, $wkt_afr, $eby, $estat, $eon)
{
    $db = openDB();

    $sql = "INSERT INTO hst_trtt
            (ID, IDTRAN_BFR, IDSUP_BFR, DATE_BFR, BB_BFR, POTO_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDTERIMA_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, IDSUP_AFR, DATE_AFR, BB_AFR, POTO_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDTERIMA_AFR, IDUSER_AFR, WKT_AFR, EDITEDBY, EDITEDON, EDITEDSTAT)
            VALUES
            ('$id', '$idtran_bfr', '$sup_bfr', '$tgl_bfr', '$bb_bfr', '$poto_bfr', '$ket1_bfr', '$ket2_bfr', '$ket3_bfr', '$trm_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$sup_afr', '$tgl_afr', '$bb_afr', '$poto_afr', '$ket1_afr', '$ket2_afr', '$ket3_afr', '$trm_afr', '$user_afr', '$wkt_afr', '$eby', '$eon', '$estat')";

    mysqli_query($db, $sql) or die("Error F(x) NHTT : ".mysqli_error($db));

    closeDB($db);
}

function newDtlTT($id, $pro, $weight, $sat, $urut, $hrga, $qty)
{
    $db = openDB();

    $sql = "INSERT INTO trtt2
            (ID, IDPRODUK, WEIGHT, IDSAT, URUT, PRICE, QTY)
            VALUES
            ('$id', '$pro', '$weight', '$sat', '$urut', '$hrga', '$qty')";

    mysqli_query($db, $sql) or die("Error F(x) NDTT : ".mysqli_error($db));

    closeDB($db);
}

function newHDtlTT($id, $idtran, $pro, $weight, $sat, $urut, $hrga, $type, $qty)
{
    $db = openDB();

    $sql = "INSERT INTO hst_trtt2
            (ID, IDTRAN, IDPRODUK, WEIGHT, IDSAT, URUT, PRICE, TYPE, QTY)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$sat', '$urut', '$hrga', '$type', '$qty')";

    mysqli_query($db, $sql) or die("Error F(x) NHDTT : ".mysqli_error($db));

    closeDB($db);
}

function updTT($id, $sup, $tgl, $bb, $poto, $ket1, $ket2, $ket3, $trm, $user, $wkt, $bid)
{
    $db = openDB();

    $sql = "UPDATE trtt
            SET ID = '$id', IDSUP = '$sup', DATE = '$tgl', BB = '$bb', POTO = '$poto', KET1 = '$ket1', KET2 = '$ket2', KET3 = '$ket3', IDTERIMA = '$trm', IDUSER = '$user', WKT = '$wkt'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UTT : ".mysqli_error($db));

    closeDB($db);
}

function delTT($id)
{
    $db = openDB();

    $sql = "DELETE FROM trtt
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DTT : ".mysqli_error($db));

    closeDB($db);
}

function delAllDtlTT($id)
{
    $db = openDB();

    $sql = "DELETE FROM trtt2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADTT : ".mysqli_error($db));

    closeDB($db);
}

//PENARIKAN
function getAllWd()
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE, TOTAL, KET1, KET2, KET3, IDUSER, WKT FROM trwd ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAWD : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    CloseDB($db);

    return $arr;
}

function getAllWdVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM trwd
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAWDVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getWdID($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDSUP, DATE, TOTAL, KET1, KET2, KET3, VERIF, VUSER, IDUSER, WKT FROM trwd
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GWDID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    CloseDB($db);

    return $row;
}

function getWdSupBfr($tgl, $sup)
{
    $db = openDB();

    $sql = "SELECT SUM(TOTAL) FROM trwd
            WHERE DATE < '$tgl' && IDSUP = '$sup'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GWDSUPB : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getWdFrmTo($frm, $to, $sup)
{
    $db = openDB();

    $sql = "SELECT DATE, TOTAL, KET1, KET2, KET3 FROM trwd
            WHERE DATE >= '$frm' && DATE <= '$to' && IDSUP = '$sup' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GWDFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function countAllWd()
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trwd";

    $result = mysqli_query($db, $sql) or die("Error F(x) CAWD : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countWdID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trwd
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CWDID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countWdSup($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) FROM trwd
            WHERE IDSUP = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CWDSUP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countWd($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(T.ID) FROM trwd T INNER JOIN dtsup S ON T.IDSUP = S.ID
            WHERE T.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || T.KET1 LIKE '%$id%' || T.KET2 LIKE '%$id%' || T.KET3 LIKE '%$id%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CWD : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schWd($id)
{
    $db = openDB();

    $sql = "SELECT T.ID, T.IDSUP, DATE_FORMAT(T.DATE, '%d/%m/%Y'), T.TOTAL, T.KET1, T.KET2, T.KET3, S.NAME, T.IDUSER, DATE_FORMAT(T.WKT, '%d/%m/%Y %H:%i') FROM trwd T INNER JOIN dtsup S ON T.IDSUP = S.ID";

    if(countWd($id) > 0)
        $sql .= " WHERE T.ID LIKE '%$id%' || S.NAME LIKE '%$id%' || T.KET1 LIKE '%$id%' || T.KET2 LIKE '%$id%' || T.KET3 LIKE '%$id%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$id%'";
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
            
            $sql .= "T.ID LIKE '%$sch%' || S.NAME LIKE '%$sch%' || T.KET1 LIKE '%$sch%' || T.KET2 LIKE '%$sch%' || T.KET3 LIKE '%$sch%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY T.DATE, T.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) SWD : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHstWdFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, IDTRAN_BFR, DATE_BFR, IDSUP_BFR, TOTAL_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, IDSUP_AFR, TOTAL_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR FROM hst_trwd";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHWDFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHWdID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT T.IDTRAN_BFR, DATE_FORMAT(T.DATE_BFR, '%d/%m/%Y'), S.NAME, T.TOTAL_BFR, T.KET1_BFR, T.KET2_BFR, T.KET3_BFR, T.IDUSER_BFR, DATE_FORMAT(T.WKT_BFR, '%d/%m/%Y') FROM hst_trwd T LEFT JOIN dtsup S ON T.IDSUP_BFR = S.ID";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT T.IDTRAN_AFR, DATE_FORMAT(T.DATE_AFR, '%d/%m/%Y'), S.NAME, T.TOTAL_AFR, T.KET1_AFR, T.KET2_AFR, T.KET3_AFR, T.IDUSER_AFR, DATE_FORMAT(T.WKT_AFR, '%d/%m/%Y') FROM hst_trwd T LEFT JOIN dtsup S ON T.IDSUP_AFR = S.ID";

    $sql .= " WHERE T.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHWDID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getLastWdSup($sup)
{
    $db = openDB();

    $sql = "SELECT DATE, TOTAL FROM trwd
            WHERE IDSUP = '$sup' ORDER BY DATE DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLWDSUP : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getLastIDWd($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM trwd
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDWD : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDHWd($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_trwd
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHWD : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function setWdVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE trwd
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SWDVRF : ".mysqli_error($db));

    closeDB($db);
}

function newWd($id, $sup, $date, $ttl, $ket1, $ket2, $ket3, $user, $wkt)
{
    $db = openDB();

    $sql = "INSERT INTO trwd
            (ID, IDSUP, DATE, TOTAL, KET1, KET2, KET3, IDUSER, WKT)
            VALUES
            ('$id', '$sup', '$date', '$ttl', '$ket1', '$ket2', '$ket3', '$user', '$wkt')";

    mysqli_query($db, $sql) or die("Error F(x) NWD : ".mysqli_error($db));

    closeDB($db);
}

function newHWd($id, $idtran_bfr, $sup_bfr, $date_bfr, $ttl_bfr, $ket1_bfr, $ket2_bfr, $ket3_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $sup_afr, $date_afr, $ttl_afr, $ket1_afr, $ket2_afr, $ket3_afr, $user_afr, $wkt_afr, $eby, $estat, $eon)
{
    $db = openDB();

    $sql = "INSERT INTO hst_trwd
            (ID, IDTRAN_BFR, IDSUP_BFR, DATE_BFR, TOTAL_BFR, KET1_BFR, KET2_BFR, KET3_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, IDSUP_AFR, DATE_AFR, TOTAL_AFR, KET1_AFR, KET2_AFR, KET3_AFR, IDUSER_AFR, WKT_AFR, EDITEDBY, EDITEDON, EDITEDSTAT)
            VALUES
            ('$id', '$idtran_bfr', '$sup_bfr', '$date_bfr', '$ttl_bfr', '$ket1_bfr', '$ket2_bfr', '$ket3_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$sup_afr', '$date_afr', '$ttl_afr', '$ket1_afr', '$ket2_afr', '$ket3_afr', '$user_afr', '$wkt_afr', '$eby', '$eon', '$estat')";

    mysqli_query($db, $sql) or die("Error F(x) NHWD : ".mysqli_error($db));

    closeDB($db);
}

function updWd($id, $sup, $date, $ttl, $ket1, $ket2, $ket3, $user, $wkt, $bid)
{
    $db = openDB();

    $sql = "UPDATE trwd
            SET ID = '$id', IDSUP = '$sup', DATE = '$date', TOTAL = '$ttl', KET1 = '$ket1', KET2 = '$ket2', KET3 = '$ket3', IDUSER = '$user', WKT = '$wkt'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UWD : ".mysqli_error($db));

    closeDB($db);
}

function delWd($id)
{
    $db = openDB();

    $sql = "DELETE FROM trwd
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DWD : ".mysqli_error($db));

    closeDB($db);
}

//BB
function getAllBB()
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), TOTAL, KET, IF(TYPE = 'IN', 'TAMBAH', 'KURANG'), IDUSER, WKT FROM trbb ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GABB : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getAllBBVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM trbb
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GABBVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getBBID($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, TOTAL, KET, TYPE, IDUSER, WKT, VERIF, VUSER FROM trbb
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GBBID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    
    closeDB($db);

    return $row;
}

function getBBFrmTo($frm, $to, $type)
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), TOTAL, KET, IF(TYPE = 'IN', 'TAMBAH', 'KURANG'), IDUSER, WKT FROM trbb
            WHERE DATE >= '$frm' && DATE <= '$to'";

    if(strcasecmp($type,"") != 0)
        $sql .= " && TYPE = '$type'";

    $sql .= " ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GBBFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getBBFrmTo2($frm, $to)
{
    $db = openDB();

    $sql = "(SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y') AS DATES, KET, IF(TYPE = 'IN', 0, TOTAL) AS DEBET, IF(TYPE = 'OUT', 0, TOTAL) AS KREDIT FROM trbb WHERE DATE >= '$frm' && DATE <= '$to')
            UNION
            (SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y') AS DATES, (SELECT NAME FROM dtsup WHERE ID = P.IDSUP), (BB+VDLL+MINUM) AS DEBET, 0 AS KREDIT FROM prterima P WHERE DATE >= '$frm' && DATE <= '$to' && (BB+VDLL+MINUM) != 0)";

    $sql .= " ORDER BY DATES, KREDIT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GBBFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getHstBBFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, IDTRAN_BFR, DATE_BFR, TOTAL_BFR, KET_BFR, IF(STRCMP(TYPE_BFR, 'IN') = 0, 'Tambah', 'Kurang'), IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, TOTAL_AFR, KET_AFR, TYPE_AFR, IDUSER_AFR, WKT_AFR FROM hst_trbb";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GHBBFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHBBID($id, $type, $db)
{
    if(strcasecmp($type,"B") == 0)
        $sql = "SELECT T.IDTRAN_BFR, DATE_FORMAT(T.DATE_BFR, '%d/%m/%Y'), T.TOTAL_BFR, T.KET_BFR, IF(STRCMP(T.TYPE_BFR,'IN') = 0, 'Tambah', IF(STRCMP(T.TYPE_BFR,'') != 0, 'Kurang', '')), T.IDUSER_BFR, DATE_FORMAT(T.WKT_BFR, '%d/%m/%Y') FROM hst_trbb T";
    else if(strcasecmp($type,"A") == 0)
        $sql = "SELECT T.IDTRAN_AFR, DATE_FORMAT(T.DATE_AFR, '%d/%m/%Y'), T.TOTAL_AFR, T.KET_AFR, IF(STRCMP(T.TYPE_AFR,'IN') = 0, 'Tambah', IF(STRCMP(T.TYPE_AFR,'') != 0, 'Kurang', '')), T.IDUSER_AFR, DATE_FORMAT(T.WKT_AFR, '%d/%m/%Y') FROM hst_trbb T";

    $sql .= " WHERE T.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHBBID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getLastIDBB($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM trbb
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDBB : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastIDHBB($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_trbb
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDHBB : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getSumBBBfr($tgl)
{
    $db = openDB();

    $sql = "SELECT SUM(TOTAL) FROM trbb
            WHERE DATE < '$tgl' && TYPE = 'IN'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSBBB : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(TOTAL) FROM trbb
            WHERE DATE < '$tgl' && TYPE = 'OUT'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSBBB - 2 : ".mysqli_error($db));

    $sum2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(BB+VDLL+MINUM) FROM prterima
            WHERE DATE < '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSBBB - 3 : ".mysqli_error($db));

    $sum3 = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0]-$sum2[0]-$sum3[0];
}

function countBBID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trbb
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CBBID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countBB($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(T.ID) FROM trbb T
            WHERE T.ID LIKE '%$id%' || T.KET LIKE '%$id%' || DATE_FORMAT(T.DATE, '%d/%m/%Y') LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CBB : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schBB($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), TOTAL, KET, IF(TYPE = 'IN', 'TAMBAH', 'KURANG'), IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM trbb";

    if(countBB($id) > 0)
        $sql .= " WHERE ID LIKE '%$id%' || KET LIKE '%$id%' || DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$id%'";
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
            
            $sql .= "ID LIKE '%$sch%' || KET LIKE '%$sch%' || DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) SBB : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setBBVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE trbb
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SBBVRF : ".mysqli_error($db));

    closeDB($db);
}

function newBB($id, $tgl, $jlh, $ket, $type, $user, $wkt)
{
    $db = openDB();

    $sql = "INSERT INTO trbb
            (ID, DATE, TOTAL, KET, TYPE, IDUSER, WKT)
            VALUES
            ('$id', '$tgl', '$jlh', '$ket', '$type', '$user', '$wkt')";

    mysqli_query($db, $sql) or die("Error F(x) NBB : ".mysqli_error($db));

    closeDB($db);
}

function newHBB($id, $idtran_bfr, $tgl_bfr, $jlh_bfr, $ket_bfr, $type_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $tgl_afr, $jlh_afr, $ket_afr, $type_afr, $user_afr, $wkt_afr, $eby, $estat, $eon)
{
    $db = openDB();

    $sql = "INSERT INTO hst_trbb
            (ID, IDTRAN_BFR, DATE_BFR, TOTAL_BFR, KET_BFR, TYPE_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, TOTAL_AFR, KET_AFR, TYPE_AFR, IDUSER_AFR, WKT_AFR, EDITEDBY, EDITEDSTAT, EDITEDON)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$jlh_bfr', '$ket_bfr', '$type_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$tgl_afr', '$jlh_afr', '$ket_afr', '$type_afr', '$user_afr', '$wkt_afr', '$eby', '$estat', '$eon')";

    mysqli_query($db, $sql) or die("Error F(x) NHBB : ".mysqli_error($db));

    closeDB($db);
}

function updBB($id, $tgl, $jlh, $ket, $type, $user, $wkt, $bid)
{
    $db = openDB();

    $sql = "UPDATE trbb
            SET ID = '$id', DATE = '$tgl', TOTAL = '$jlh', KET = '$ket', TYPE = '$type', IDUSER = '$user', WKT = '$wkt'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UBB : ".mysqli_error($db));

    closeDB($db);
}

function delBB($id)
{
    $db = openDB();

    $sql = "DELETE FROM trbb
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DBB : ".mysqli_error($db));

    closeDB($db);
}

//PENYESUAIAN STOK
function getAllPs()
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), KET, (SELECT SUM(WEIGHT) FROM trps2 WHERE ID = M.ID), IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM trps M
            WHERE DATE = CURDATE() ORDER BY DATE, WKT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAPS : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPsID($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE, KET, IDUSER, WKT, VERIF, VUSER, IDGDG FROM trps
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPSID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getPsHIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_trps
            WHERE DATE_AFR = '$tgl' && EDITEDSTAT = 'NEW'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPSHIDTGL : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getPsItem($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDPRODUK, WEIGHT, URUT, KET FROM trps2
            WHERE ID = '$id' ORDER BY URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPSITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPsItem2($id)
{
    $db = openDB();

    $sql = "SELECT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), M2.WEIGHT, M2.KET, P.ID, M2.URUT FROM trps2 M2 INNER JOIN dtproduk P ON M2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE M2.ID = '$id' ORDER BY P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPSITM2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPsItem3($id, $pro = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(WEIGHT) FROM trps2 WHERE ID = M2.ID && IDPRODUK = M2.IDPRODUK && KET = M2.KET), M2.KET FROM trps2 M2 INNER JOIN dtproduk P ON M2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE M2.ID = '$id'";

    if(strcasecmp($pro,"") != 0)
        $sql .= " && M2.IDPRODUK = '$pro'";

    $sql .= " ORDER BY P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPSITM3 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPsItem4($frm, $to, $pro = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(SM2.WEIGHT) FROM trps2 SM2 INNER JOIN trps SM ON SM2.ID = SM.ID WHERE SM.DATE >= '$frm' && SM.DATE <= '$to' && SM2.IDPRODUK = M2.IDPRODUK), M2.KET FROM trps2 M2 INNER JOIN dtproduk P ON M2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN trps M ON M2.ID = M.ID
            WHERE M.DATE >= '$frm' && M.DATE <= '$to'";

    if(strcasecmp($pro,"") != 0)
        $sql .= " && M2.IDPRODUK = '$pro'";

    $sql .= " ORDER BY P.NAME, G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPSITM4 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPsIDTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT ID FROM trps
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPSIDT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);    

    closeDB($db);

    return $row[0];
}

function getPsFrmTo($frm, $to, $pro = "")
{
    $db = openDB();

    $whr = "";
    if(strcasecmp($pro,"") != 0)
        $whr = " && IDPRODUK = '$pro'";

    $sql = "SELECT ID, DATE, KET, (SELECT SUM(WEIGHT) FROM trps2 WHERE ID = M.ID $whr) FROM trps M
            WHERE DATE >= '$frm' && DATE <= '$to' && (SELECT SUM(WEIGHT) FROM trps2 WHERE ID = M.ID $whr) IS NOT NULL ORDER BY DATE ASC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPSFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPsFrmTo2($frm, $to, $pro = "")
{
    $db = openDB();

    $whr = "";
    if(strcasecmp($pro,"") != 0)
        $whr = " && IDPRODUK = '$pro'";

    $sql = "SELECT DISTINCT DATE_FORMAT(DATE, '%M %Y'), (SELECT SUM(SM2.WEIGHT) FROM trps2 SM2 INNER JOIN trps SM ON SM2.ID = SM.ID WHERE MONTH(SM.DATE) = MONTH(M.DATE) $whr), DATE_FORMAT(DATE, '%Y-%m') FROM trps M
            WHERE DATE >= '$frm' && DATE <= '$to' && (SELECT SUM(WEIGHT) FROM trps2 WHERE ID = M.ID $whr) IS NOT NULL ORDER BY DATE ASC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPSFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHstPsFrmTo($frm, $to, $jtgl)
{
    $db = openDB();

    $sql = "SELECT ID, EDITEDON, EDITEDBY, EDITEDSTAT, ID, IDTRAN_BFR, DATE_BFR, KET_BFR, (SELECT SUM(WEIGHT) FROM hst_trps2 WHERE ID = M.ID && TYPE = 'B'), IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, KET_AFR, (SELECT SUM(WEIGHT) FROM hst_trps2 WHERE ID = M.ID && TYPE = 'A'), IDUSER_AFR, WKT_AFR FROM hst_trps M";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY EDITEDON, ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(EDITEDSTAT,'DELETE') = 0,DATE_BFR, DATE_AFR), ID";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) GHPSFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;
    
    closeDB($db);

    return $arr;
}

function getHPsID($id, $type)
{
    $db = openDB();

    if(strcasecmp($type,"1") == 0)
        $sql = "SELECT IDTRAN_BFR, KET_BFR, DATE_FORMAT(DATE_BFR, '%d/%m/%Y'), IDUSER_BFR, WKT_BFR FROM hst_trps";
    else if(strcasecmp($type,"2") == 0)
        $sql = "SELECT IDTRAN_AFR, KET_AFR, DATE_FORMAT(DATE_AFR, '%d/%m/%Y'), IDUSER_AFR, WKT_AFR FROM hst_trps";

    $sql .= " WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHPSID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getHPsItem($id, $type)
{
    $db = openDB();

    $sql = "SELECT T2.ID, T2.IDTRAN, T2.IDPRODUK, T2.WEIGHT, T2.TYPE, T2.URUT, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, T2.KET FROM hst_trps2 T2 LEFT JOIN dtproduk P ON T2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE T2.ID = '$id' && T2.TYPE = '$type' ORDER BY T2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHPSITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastIDPs($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM trps
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDPS : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastHIDPs($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM hst_trps
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLHIDPS : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getLastUrutPs($id)
{
    $db = openDB();

    $sql = "SELECT URUT FROM trps2
            WHERE ID = '$id' ORDER BY URUT DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLUPS : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countPsID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trps
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPSID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countPs($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trps
            WHERE DATE_FORMAT(DATE, '%d/%m/%Y') LIKE '%$id%' || IDUSER LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPS : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countPsTgl($tgl)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trps
            WHERE DATE = '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPST : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schPs($id)
{
    $db = openDB();

    $sql = "SELECT ID, DATE_FORMAT(DATE, '%d/%m/%Y'), KET, (SELECT SUM(WEIGHT) FROM trps2 WHERE ID = M.ID), IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM trps M";

    if(countPs($id) > 0)
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
    
    $result = mysqli_query($db, $sql) or die("Error F(x) SPS : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function updQtyProPs()
{
    $db = openDB();

    $sql = "UPDATE dtproduk P
            SET PSQTY = ROUND((SELECT SUM(WEIGHT) FROM trps2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROPS : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET PSQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM trps2 SP2 INNER JOIN trps SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROPS - 2 : ".mysqli_error($db));

    closeDB($db);
}

function updQtyProPs2($db)
{
    $sql = "UPDATE dtproduk P
            SET PSQTY = ROUND((SELECT SUM(WEIGHT) FROM trps2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROPS : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET PSQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM trps2 SP2 INNER JOIN trps SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROPS - 2 : ".mysqli_error($db));
}

function newPs($id, $tgl, $ket, $user, $wkt, $gdg)
{
    $db = openDB();

    $sql = "INSERT INTO trps
            (ID, DATE, KET, IDUSER, WKT, IDGDG)
            VALUES
            ('$id', '$tgl', '$ket', '$user', '$wkt', '$gdg')";

    mysqli_query($db, $sql) or die("Error F(x) NPS : ".mysqli_error($db));

    closeDB($db);
}

function newHPs($id, $idtran_bfr, $tgl_bfr, $ket_bfr, $user_bfr, $wkt_bfr, $idtran_afr, $tgl_afr, $ket_afr, $user_afr, $wkt_afr, $eon, $eby, $estat, $gdg_bfr, $gdg_afr)
{
    $db = openDB();

    $sql = "INSERT INTO hst_trps
            (ID, IDTRAN_BFR, DATE_BFR, KET_BFR, IDUSER_BFR, WKT_BFR, IDTRAN_AFR, DATE_AFR, KET_AFR, IDUSER_AFR, WKT_AFR, EDITEDON, EDITEDBY, EDITEDSTAT, IDGDG_BFR, IDGDG_AFR)
            VALUES
            ('$id', '$idtran_bfr', '$tgl_bfr', '$ket_bfr', '$user_bfr', '$wkt_bfr', '$idtran_afr', '$tgl_afr', '$ket_afr', '$user_afr', '$wkt_afr', '$eon', '$eby', '$estat', '$gdg_bfr', '$gdg_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHPS : ".mysqli_error($db));

    closeDB($db);
}

function newDtlPs($id, $pro, $weight, $urut, $ket)
{
    $db = openDB();

    $sql = "INSERT INTO trps2
            (ID, IDPRODUK, WEIGHT, URUT, KET)
            VALUES
            ('$id', '$pro', '$weight', '$urut', '$ket')";

    mysqli_query($db, $sql) or die("Error F(x) NDPS : ".mysqli_error($db));

    closeDB($db);
}

function newHDtlPs($id, $idtran, $pro, $weight, $urut, $ket, $type)
{
    $db = openDB();

    $sql = "INSERT INTO hst_trps2
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, KET, TYPE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$urut', '$ket', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NHDPS : ".mysqli_error($db));

    closeDB($db);
}

function updPs($id, $tgl, $user, $wkt, $bid, $gdg)
{
    $db = openDB();

    $sql = "UPDATE trps
            SET ID = '$id', DATE = '$tgl', IDUSER = '$user', WKT = '$wkt', IDGDG = '$gdg'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPS : ".mysqli_error($db));

    closeDB($db);
}

function delPs($id)
{
    $db = openDB();

    $sql = "DELETE FROM trps
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DPS : ".mysqli_error($db));

    closeDB($db);
}

function delAllDtlPs($id)
{
    $db = openDB();

    $sql = "DELETE FROM trps2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADPS : ".mysqli_error($db));

    closeDB($db);
}

function getAllPsVerif()
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), VUSER, ID FROM trps
            WHERE VERIF = '?' ORDER BY DATE, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAPSVRF : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function setPsVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE trps
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SPSVRF : ".mysqli_error($db));

    closeDB($db);
}

//PINDAH LOKASI
function getAllMove($db){
    $sql = "SELECT M.ID, DATE_FORMAT(M.DATE, '%d/%m/%Y'), G.NAMA, G2.NAMA, IF(STRCMP(M.TYPE,'I') = 0, 'Penitipan', 'Pengambilan'), M.KET, M.IDUSER, DATE_FORMAT(M.WKT, '%d/%m/%Y %H:%i'), M.ID2, (SELECT SUM(WEIGHT) FROM trmove2 WHERE ID = M.ID), M.KPD FROM trmove M INNER JOIN dtgdg G ON M.IDGDGF = G.ID INNER JOIN dtgdg G2 ON M.IDGDGT = G2.ID
            WHERE M.DATE = CURDATE() ORDER BY M.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAMV : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getMoveID($id, $db){
    $sql = "SELECT ID, IDGDGF, IDGDGT, DATE, TYPE, KET, WKT, IDUSER, VERIF, VUSER, ID2, IF(STRCMP(TYPE,'I') = 0, 'Penitipan', 'Pengambilan'), (SELECT NAMA FROM dtgdg WHERE ID = M.IDGDGF), (SELECT NAMA FROM dtgdg WHERE ID = M.IDGDGT), KPD FROM trmove M
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMVID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getMoveItem($id, $db){
    $sql = "SELECT M2.ID, M2.IDPRODUK, M2.WEIGHT, M2.KET, M2.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), M2.QTY, M2.SAT, M2.TGLEXP FROM trmove2 M2 INNER JOIN dtproduk P ON M2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE M2.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMVITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getMoveFrmTo($frm, $to, $jns, $gdgf, $gdgt, $db){
    $sql = "SELECT DATE_FORMAT(M.DATE, '%d/%m/%Y'), M.ID, G.NAMA, G2.NAMA, IF(STRCMP(M.TYPE, 'I') = 0, 'Penitipan', 'Pengambilan'), M.KET, M.ID2, (SELECT SUM(WEIGHT) FROM trmove2 WHERE ID = M.ID), M.KPD FROM trmove M INNER JOIN dtgdg G ON M.IDGDGF = G.ID INNER JOIN dtgdg G2 ON M.IDGDGT = G2.ID
            WHERE M.DATE >= '$frm' && M.DATE <= '$to'";

    if(strcasecmp($jns,"") != 0){
        $sql .= " && M.TYPE = '$jns'";
    }

    if(strcasecmp($gdgf,"") != 0){
        $sql .= " && M.IDGDGF = '$gdgf'";
    }

    if(strcasecmp($gdgt,"") != 0){
        $sql .= " && M.IDGDGT = '$gdgt'";
    }

    $sql .= " ORDER BY M.DATE";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GMVFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getMoveFrmTo2($frm, $to, $jns, $gdgf, $gdgt, $p, $db){
    $sql = "SELECT DATE_FORMAT(M.DATE, '%d/%m/%Y'), M.ID, G.NAMA, G2.NAMA, IF(STRCMP(M.TYPE, 'I') = 0, 'Penitipan', 'Pengambilan'), M.KET, M.ID2, P.NAME, GR.NAME, K.NAME, SK.NAME, M2.QTY, M2.SAT, DATE_FORMAT(M2.TGLEXP, '%d/%m/%Y'), M2.WEIGHT, M2.KET, M.KPD FROM trmove M INNER JOIN dtgdg G ON M.IDGDGF = G.ID INNER JOIN dtgdg G2 ON M.IDGDGT = G2.ID INNER JOIN trmove2 M2 ON M.ID = M2.ID INNER JOIN dtproduk P ON P.ID = M2.IDPRODUK INNER JOIN dtgrade GR ON P.IDGRADE = GR.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE M.DATE >= '$frm' && M.DATE <= '$to'";

    if(strcasecmp($jns,"") != 0){
        $sql .= " && M.TYPE = '$jns'";
    }

    if(strcasecmp($gdgf,"") != 0){
        $sql .= " && M.IDGDGF = '$gdgf'";
    }

    if(strcasecmp($gdgt,"") != 0){
        $sql .= " && M.IDGDGT = '$gdgt'";
    }

    if(strcasecmp($p,"") != 0){
        $sql .= " && M2.IDPRODUK = '$p'";
    }

    $sql .= " ORDER BY M.DATE, M.ID, M2.URUT";

    $result = mysqli_query($db, $sql) or die("Error F(x) GMVFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getHstMoveFrmTo($frm, $to, $jtgl, $db){
    $sql = "SELECT M.ID, DATE_FORMAT(M.EDITEDON, '%d/%m/%Y %H:%i'), M.EDITEDBY, M.EDITEDSTAT, DATE_FORMAT(M.DATE_BFR, '%d/%m/%Y'), M.IDTRAN_BFR, G.NAMA, G2.NAMA, IF(STRCMP(M.TYPE_BFR, 'I') = 0, 'Penitipan', 'Pengambilan'), M.KET_BFR, (SELECT SUM(WEIGHT) FROM hst_trmove2 WHERE ID = M.ID AND TYPE = 'B'), DATE_FORMAT(M.DATE_AFR, '%d/%m/%Y'), M.IDTRAN_AFR, G3.NAMA, G4.NAMA, IF(STRCMP(M.TYPE_AFR, 'I') = 0, 'Penitipan', 'Pengambilan'), M.KET_AFR, (SELECT SUM(WEIGHT), M.KPD_BFR, M.KD_AFR FROM hst_trmove2 WHERE ID = M.ID AND TYPE = 'A') FROM hst_trmove M INNER JOIN dtgdg G ON M.IDGDGF_BFR = G.ID INNER JOIN dtgdg G2 ON M.IDGDGT_BFR = G2.ID INNER JOIN dtgdg G3 ON M.IDGDGF_AFR = G3.ID INNER JOIN dtgdg G4 ON M.IDGDGF_BFR = G4.ID";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(M.EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(M.EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY M.EDITEDON, M.ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(M.EDITEDSTAT,'DELETE') = 0,M.DATE_BFR, M.DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(M.EDITEDSTAT,'DELETE') = 0,M.DATE_BFR, M.DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(M.EDITEDSTAT,'DELETE') = 0,M.DATE_BFR, M.DATE_AFR), M.ID";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) GHMVFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getHstMoveID($id, $type, $db){
    if(strcasecmp($type,"B") == 0){
        $sql = "SELECT DATE_FORMAT(M.DATE_BFR, '%d/%m/%Y'), M.IDTRAN_BFR, G.NAMA, G2.NAMA, IF(STRCMP(M.TYPE_BFR, 'I') = 0, 'Penitipan', 'Pengambilan'), M.KET_BFR, M.KPD_BFR FROM hst_trmove M INNER JOIN dtgdg G ON M.IDGDGF_BFR = G.ID INNER JOIN dtgdg G2 ON M.IDGDGT_BFR = G2.ID
                WHERE M.ID = '$id'";
    }
    else if(strcasecmp($type, "A") == 0){
        $sql = "SELECT DATE_FORMAT(M.DATE_AFR, '%d/%m/%Y'), M.IDTRAN_AFR, G.NAMA, G2.NAMA, IF(STRCMP(M.TYPE_AFR, 'I') = 0, 'Penitipan', 'Pengambilan'), M.KET_AFR, M.KPD_AFR FROM hst_trmove M INNER JOIN dtgdg G ON M.IDGDGF_AFR = G.ID INNER JOIN dtgdg G2 ON M.IDGDGT_AFR = G2.ID
                WHERE M.ID = '$id'";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) GHMVID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getHstMoveItem($id, $type, $db){
    $sql = "SELECT M2.IDTRAN, M2.IDPRODUK, M2.WEIGHT, M2.KET, M2.URUT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), M2.QTY, M2.SAT, DATE_FORMAT(M2.TGLEXP, '%d/%m/%Y') FROM hst_trmove2 M2 INNER JOIN dtproduk P ON M2.IDPRODUK = P.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE M2.ID = '$id' && M2.TYPE = '$type'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHMVI : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getLastHMoveID($aw, $ak, $db){
    $sql = "SELECT ID FROM hst_trmove
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(X) GLHMVID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastMoveID($aw, $ak, $db){
    $sql = "SELECT ID FROM trmove
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(X) GLMVID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function countMoveID($id, $db){
    $sql = "SELECT COUNT(ID) FROM trmove
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(X) CMVID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countMove($id, $db){
    $sql = "SELECT COUNT(M.ID) FROM trmove M INNER JOIN dtgdg G ON M.IDGDGF = G.ID INNER JOIN dtgdg G2 ON M.IDGDGT = G2.ID
            WHERE M.ID LIKE '%$id%' || DATE_FORMAT(M.DATE, '%d/%m/%Y') LIKE '%$id%' || M.KET LIKE '%$id%' || G.NAMA LIKE '%$id%' || G2.NAMA LIKE '%$id%' || M.ID2 LIKE '%$id%' || M.KPD LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(X) CMV : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function schMove($id, $db){
    $sql = "SELECT M.ID, DATE_FORMAT(M.DATE, '%d/%m/%Y'), G.NAMA, G2.NAMA, IF(STRCMP(M.TYPE,'I') = 0, 'Penitipan', 'Pengambilan'), M.KET, M.IDUSER, DATE_FORMAT(M.WKT, '%d/%m/%Y %H:%i'), M.ID2, (SELECT SUM(WEIGHT) FROM trmove2 WHERE ID = M.ID), M.KPD FROM trmove M INNER JOIN dtgdg G ON M.IDGDGF = G.ID INNER JOIN dtgdg G2 ON M.IDGDGT = G2.ID";

    if(countMove($id, $db) > 0){
        $sql .= " WHERE M.ID LIKE '%$id%' || DATE_FORMAT(M.DATE, '%d/%m/%Y') LIKE '%$id%' || M.KET LIKE '%$id%' || G.NAMA LIKE '%$id%' || G2.NAMA LIKE '%$id%' || M.ID2 LIKE '%$id%' || M.KPD LIKE '%$id%'";
    }
    else{
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
            
            $sql .= "M.ID LIKE '%$sch%' || DATE_FORMAT(M.DATE, '%d/%m/%Y') LIKE '%$sch%' || M.KET LIKE '%$sch%' || G.NAMA LIKE '%$sch%' || G2.NAMA LIKE '%$sch%' || M.ID2 LIKE '%$sch%' || M.KPD LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY M.DATE, M.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) SMV : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function setMoveVerif($id, $user, $kode, $db)
{
    $db = openDB();

    $sql = "UPDATE trmove
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SMVVRF : ".mysqli_error($db));

    closeDB($db);
}

function newMove($id, $frm, $to, $tgl, $type, $ket, $wkt, $user, $kpd, $db){
    $sql = "INSERT INTO trmove
            (ID, IDGDGF, IDGDGT, DATE, TYPE, KET, WKT, IDUSER, KPD)
            VALUES
            ('$id', '$frm', '$to', '$tgl', '$type', '$ket', '$wkt', '$user', '$kpd')";

    mysqli_query($db, $sql) or die("Error F(x) NMV : ".mysqli_error($db));
}

function newHMove($id, $idtran_bfr, $frm_bfr, $to_bfr, $tgl_bfr, $type_bfr, $ket_bfr, $wkt_bfr, $user_bfr, $idtran_afr, $frm_afr, $to_afr, $tgl_afr, $type_afr, $ket_afr, $wkt_afr, $user_afr, $eby, $eon, $estat, $kpd_bfr, $kpd_afr, $db){
    $sql = "INSERT INTO hst_trmove
            (ID, IDTRAN_BFR, IDGDGF_BFR, IDGDGT_BFR, DATE_BFR, TYPE_BFR, KET_BFR, WKT_BFR, IDUSER_BFR, IDTRAN_AFR, IDGDGF_AFR, IDGDGT_AFR, DATE_AFR, TYPE_AFR, KET_AFR, WKT_AFR, IDUSER_AFR, EDITEDBY, EDITEDON, EDITEDSTAT, KPD_AFR, KPD_BFR)
            VALUES
            ('$id', '$idtran_bfr', '$frm_bfr', '$to_bfr', '$tgl_bfr', '$type_bfr', '$ket_bfr', '$wkt_bfr', '$user_bfr', '$idtran_afr', '$frm_afr', '$to_afr', '$tgl_afr', '$type_afr', '$ket_afr', '$wkt_afr', '$user_afr', '$eby', '$eon', '$estat', '$kpd_bfr', '$kpd_afr')";

    mysqli_query($db, $sql) or die("Error F(x) NHMV : ".mysqli_error($db));
}

function newDtlMove($id, $pro, $brt, $urut, $ket, $qty, $sat, $tglexp, $db){
    $sql = "INSERT INTO trmove2
            (ID, IDPRODUK, WEIGHT, URUT, KET, QTY, SAT, TGLEXP)
            VALUES
            ('$id', '$pro', '$brt', '$urut', '$ket', '$qty', '$sat', '$tglexp')";
            
    mysqli_query($db, $sql) or die("Error F(x) NDMV : ".mysqli_error($db));
}

function newDtlHMove($id, $idtran, $pro, $brt, $urut, $ket, $qty, $sat, $tglexp, $type, $db){
    $sql = "INSERT INTO hst_trmove2
            (ID, IDTRAN, IDPRODUK, WEIGHT, URUT, KET, QTY, SAT, TGLEXP, TYPE)
            VALUES
            ('$id', '$idtran', '$pro', '$brt', '$urut', '$ket', '$qty', '$sat', '$tglexp', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NDHMV : ".mysqli_error($db));
}

function updMove($id, $frm, $to, $tgl, $type, $ket, $id2, $kpd, $db){
    $sql = "UPDATE trmove
            SET IDGDGF = '$frm', IDGDGT = '$to', DATE = '$tgl', TYPE = '$type', KET = '$ket', ID2 = '$id2', KPD = '$kpd'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) UMV : ".mysqli_error($db));
}

function updQtyProMove($db){
    $sql = "UPDATE dtproduk P
            SET MIQTY = ROUND((SELECT SUM(WEIGHT) FROM trmove2 WHERE IDPRODUK = P.ID),2), MOQTY = ROUND((SELECT SUM(WEIGHT) FROM trmove2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROMV : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET MOQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM trmove2 SP2 INNER JOIN trmove SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDGF = P.IDGDG),2), MIQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM trmove2 SP2 INNER JOIN trmove SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDGT = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPROMV - 2 : ".mysqli_error($db));
}

function delAllDtlMove($id, $db){
    $sql = "DELETE FROM trmove2
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DADMV : ".mysqli_error($db));
}

function delMove($id, $db){
    $sql = "DELETE FROM trmove
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DMV : ".mysqli_error($db));
}

//RETUR KIRIM
function getAllRKirim($db){
    $sql = "SELECT RK.ID, C.NAME, RK.IDPO, DATE_FORMAT(RK.DATE, '%d/%m/%Y'), RK.KET, RK.IDUSER, DATE_FORMAT(RK.WKT, '%d/%m/%Y %H:%i'), (SELECT SUM(WEIGHT) FROM trrkirim2 WHERE ID = RK.ID) FROM trrkirim RK INNER JOIN dtcus C ON RK.IDCUS = C.ID
            WHERE RK.DATE = CURDATE() ORDER BY RK.DATE, RK.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GARKRM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        array_push($arr, $row);
    }

    return $arr;
}

function getRKirimID($id, $db){
    $sql = "SELECT ID, IDCUS, IDPO, DATE, KET, IDUSER, WKT, VERIF, VUSER, IDGDG, (SELECT NAME FROM dtcus WHERE ID = RK.IDCUS) FROM trrkirim RK
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GRKRMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getRKirimItem($id, $db){
    $sql = "SELECT RK2.ID, RK2.IDPRODUK, RK2.WEIGHT, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (SELECT SUM(WEIGHT) FROM trkirim2 WHERE IDPO = RK.IDPO AND IDPRODUK = RK2.IDPRODUK) FROM trrkirim2 RK2 INNER JOIN trrkirim RK ON RK2.ID = RK.ID INNER JOIN dtproduk P ON RK2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE RK2.ID = '$id' ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GRKRMITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        array_push($arr, $row);
    }

    return $arr;
}

function getLastRKirimID($aw, $ak, $db){
    $sql = "SELECT ID FROM trrkirim
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLRKRMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getLastHRKirimID($aw, $ak, $db){
    $sql = "SELECT ID FROM hst_trrkirim
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLHRKRMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getRKirimFrmTo($frm, $to, $cus, $db){
    $sql = "SELECT RK.ID, RK.DATE, C.NAME, RK.KET, (SELECT SUM(WEIGHT) FROM trrkirim2 WHERE ID = RK.ID) FROM trrkirim RK INNER JOIN dtcus C ON RK.IDCUS = C.ID
            WHERE RK.DATE >= '$frm' && RK.DATE <= '$to'";

    if(strcasecmp($cus,"") != 0){
        $sql .= " && RK.IDCUS = '$cus'";
    }

    $sql .= " ORDER BY RK.DATE, RK.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GRKRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getRKirimFrmTo2($frm, $to, $cus, $pro, $db){
    $sql = "SELECT RK.ID, RK.DATE, C.NAME, RK.KET, RK2.IDPRODUK, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), RK2.WEIGHT FROM trrkirim RK INNER JOIN trrkirim2 RK2 ON RK.ID = RK2.ID INNER JOIN dtcus C ON RK.IDCUS = C.ID INNER JOIN dtproduk P ON RK2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE RK.DATE >= '$frm' && RK.DATE <= '$to'";

    if(strcasecmp($cus,"") != 0){
        $sql .= " && RK.IDCUS = '$cus'";
    }

    if(strcasecmp($pro,"") != 0){
        $sql .= " && RK2.IDPRODUK = '$pro'";
    }

    $sql .= " ORDER BY RK.DATE, RK.ID, P.NAME, G.NAME, K.NAME, SK.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GRKRMFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }
    
    return $arr;
}

function getHstRKirimFrmTo($frm, $to, $jtgl, $db){
    $sql = "SELECT RK.ID, RK.EDITEDON, RK.EDITEDBY, RK.EDITEDSTAT, RK.DATE_BFR, RK.IDTRAN_BFR, C.NAME, RK.IDPO_BFR, (SELECT SUM(WEIGHT) FROM hst_trrkirim2 WHERE ID = RK.ID && TYPE = 'B'), RK.KET_BFR, RK.DATE_AFR, RK.IDTRAN_AFR, C2.NAME, RK.IDPO_AFR, (SELECT SUM(WEIGHT) FROM hst_trrkirim2 WHERE ID = RK.ID && TYPE = 'A'), RK.KET_AFR FROM hst_trrkirim RK LEFT JOIN dtcus C ON RK.IDCUS_BFR = C.ID LEFT JOIN dtcus C2 ON RK.IDCUS_AFR = C2.ID";

    if(strcasecmp($jtgl,"1") == 0){
        $sql .= " WHERE DATE_FORMAT(RK.EDITEDON, '%Y-%m-%d') >= '$frm' && DATE_FORMAT(RK.EDITEDON, '%Y-%m-%d') <= '$to' ORDER BY RK.EDITEDON, RK.ID";
    }
    else if(strcasecmp($jtgl,"2") == 0){
        $sql .= " WHERE DATE_FORMAT(IF(STRCMP(RK.EDITEDSTAT,'DELETE') = 0,RK.DATE_BFR, RK.DATE_AFR), '%Y-%m-%d') >= '$frm' && DATE_FORMAT(IF(STRCMP(RK.EDITEDSTAT,'DELETE') = 0,RK.DATE_BFR, RK.DATE_AFR), '%Y-%m-%d') <= '$to' ORDER BY IF(STRCMP(RK.EDITEDSTAT,'DELETE') = 0,RK.DATE_BFR, RK.DATE_AFR), RK.ID";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) GHRKRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getHstRKirimID($id, $type, $db){
    if(strcasecmp($type,"B") == 0){
        $sql = "SELECT DATE_FORMAT(RK.DATE_BFR, '%d/%m/%Y'), RK.IDTRAN_BFR, C.NAME, RK.IDPO_BFR, RK.KET_BFR FROM hst_trrkirim RK LEFT JOIN dtcus C ON RK.IDCUS_BFR = C.ID";
    }
    else if(strcasecmp($type,"A") == 0){
        $sql = "SELECT DATE_FORMAT(RK.DATE_AFR, '%d/%m/%Y'), RK.IDTRAN_AFR, C.NAME, RK.IDPO_AFR, RK.KET_AFR FROM hst_trrkirim RK LEFT JOIN dtcus C ON RK.IDCUS_AFR = C.ID";
    }

    $sql .= " WHERE RK.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHRKRMID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getHstRKirimItem($id, $type, $db){
    $sql = "SELECT P.NAME, G.NAME, K.NAME, SK.NAME, RK2.WEIGHT FROM hst_trrkirim2 RK2 INNER JOIN dtproduk P ON RK2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE RK2.ID = '$id' && RK2.TYPE = '$type' ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHRKRMITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function countRKirimID($id, $db){
    $sql = "SELECT COUNT(ID) FROM trrkirim
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CRKRMID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countRKirim($id, $db){
    $sql = "SELECT COUNT(RK.ID) FROM trrkirim RK INNER JOIN dtcus C ON RK.IDCUS = C.ID
            WHERE RK.ID LIKE '%$id%' || DATE_FORMAT(RK.DATE, '%d/%m/%Y') LIKE '%$id%' || C.NAME LIKE '%$id%' || RK.IDPO LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CRKRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function schRKirim($id, $db){
    $sql = "SELECT RK.ID, C.NAME, RK.IDPO, DATE_FORMAT(RK.DATE, '%d/%m/%Y'), RK.KET, RK.IDUSER, DATE_FORMAT(RK.WKT, '%d/%m/%Y %H:%i'), (SELECT SUM(WEIGHT) FROM trrkirim2 WHERE ID = RK.ID) FROM trrkirim RK INNER JOIN dtcus C ON RK.IDCUS = C.ID";

    if(countRKirim($id, $db) > 0){
        $sql .= " WHERE RK.ID LIKE '%$id%' || DATE_FORMAT(RK.DATE, '%d/%m/%Y') LIKE '%$id%' || C.NAME LIKE '%$id%' || RK.IDPO LIKE '%$id%'";
    }
    else{
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
            
            $sql .= "RK.ID LIKE '%$sch%' || DATE_FORMAT(RK.DATE, '%d/%m/%Y') LIKE '%$sch%' || C.NAME LIKE '%$sch%' || RK.IDPO LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY RK.DATE, RK.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) SRKRM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        array_push($arr, $row);
    }

    return $arr;
}

function setRKirimVerif($id, $user, $kode)
{
    $db = openDB();

    $sql = "UPDATE trrkirim
            SET VERIF = '$kode', VUSER = '$user'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) SRKRMVRF : ".mysqli_error($db));

    closeDB($db);
}

function newRKirim($id, $cus, $po, $tgl, $ket, $user, $wkt, $gdg, $db){
    $sql = "INSERT INTO trrkirim
            (ID, IDCUS, IDPO, DATE, KET, IDUSER, WKT, IDGDG)
            VALUES
            ('$id', '$cus', '$po', '$tgl', '$ket', '$user', '$wkt', '$gdg')";

    mysqli_query($db, $sql) or die("Error F(x) NRKRM : ".mysqli_error($db));
}

function newHRKirim($id, $idtran_bfr, $cus_bfr, $po_bfr, $tgl_bfr, $ket_bfr, $user_bfr, $wkt_bfr, $gdg_bfr, $idtran_afr, $cus_afr, $po_afr, $tgl_afr, $ket_afr, $user_afr, $wkt_afr, $gdg_afr, $eby, $eon, $estat, $db){
    $sql = "INSERT INTO hst_trrkirim
            (ID, IDTRAN_BFR, IDCUS_BFR, IDPO_BFR, DATE_BFR, KET_BFR, IDUSER_BFR, WKT_BFR, IDGDG_BFR, IDTRAN_AFR, IDCUS_AFR, IDPO_AFR, DATE_AFR, KET_AFR, IDUSER_AFR, WKT_AFR, IDGDG_AFR, EDITEDBY, EDITEDON, EDITEDSTAT)
            VALUES
            ('$id', '$idtran_bfr', '$cus_bfr', '$po_bfr', '$tgl_bfr', '$ket_bfr', '$user_bfr', '$wkt_bfr', '$gdg_bfr', '$idtran_afr', '$cus_afr', '$po_afr', '$tgl_afr', '$ket_afr', '$user_afr', '$wkt_afr', '$gdg_afr', '$eby', '$eon', '$estat')";

    mysqli_query($db, $sql) or die("Error F(x) NHRKRM : ".mysqli_error($db));
}

function newDtlRKirim($id, $pro, $weight, $db){
    $sql = "INSERT INTO trrkirim2
            (ID, IDPRODUK, WEIGHT)
            VALUES
            ('$id', '$pro', '$weight')";

    mysqli_query($db, $sql) or die("Error F(x) NDRKRM : ".mysqli_error($db));
}

function newDtlHRKirim($id, $idtran, $pro, $weight, $type, $db){
    $sql = "INSERT INTO hst_trrkirim2
            (ID, IDTRAN, IDPRODUK, WEIGHT, TYPE)
            VALUES
            ('$id', '$idtran', '$pro', '$weight', '$type')";

    mysqli_query($db, $sql) or die("Error F(x) NDHRKRM : ".mysqli_error($db));
}

function updRKirim($id, $cus, $po, $tgl, $ket, $user, $gdg, $db){
    $sql = "UPDATE trrkirim
            SET IDCUS = '$cus', IDPO = '$po', DATE = '$tgl', KET = '$ket', IDUSER = '$user', IDGDG = '$gdg'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) URKRM : ".mysqli_error($db));
}

function updQtyProRKirim($db){
    $sql = "UPDATE dtproduk P
            SET RBQTY = ROUND((SELECT SUM(WEIGHT) FROM trrkirim2 WHERE IDPRODUK = P.ID),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPRORKRM : ".mysqli_error($db));

    $sql = "UPDATE dtgpro P
            SET RBQTY = ROUND((SELECT SUM(SP2.WEIGHT) FROM trrkirim2 SP2 INNER JOIN trrkirim SP ON SP2.ID = SP.ID WHERE SP2.IDPRODUK = P.IDPRODUK AND SP.IDGDG = P.IDGDG),2)";

    mysqli_query($db, $sql) or die("Error F(x) UQPRORKRM - 2 : ".mysqli_error($db));
}

function delAllDtlRKirim($id, $db){
    $sql = "DELETE FROM trrkirim2
            WHERE ID = '$id'";
    
    mysqli_query($db, $sql) or die("Error F(x) DADRKRM : ".mysqli_error($db));
}

function delRKirim($id, $db){
    $sql = "DELETE FROM trrkirim
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DRKRM : ".mysqli_error($db));
}
?>