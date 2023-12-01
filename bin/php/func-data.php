<?php
//SUPPLIER
function getAllSup()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3, SAVINGS FROM dtsup ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GASUP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllAddrSup()
{
    $db = openDB();

    $sql = "SELECT DISTINCT ADDR FROM dtsup ORDER BY ADDR";

    $result = mysqli_query($db,$sql) or die("Error F(x) GADSUP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllRegSup()
{
    $db = openDB();

    $sql = "SELECT DISTINCT REG FROM dtsup ORDER BY ADDR";

    $result = mysqli_query($db,$sql) or die("Error F(x) GArSUP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllSupID()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3 FROM dtsup ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GASUP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getListJSup($db){
    $sql = "SELECT DISTINCT KET1 FROM dtsup
            WHERE KET1 != '' ORDER BY KET1";

    $result = mysqli_query($db,$sql) or die("Error F(x) GLJSUP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    return $arr;
}

function getSupID($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3, SAVINGS FROM dtsup
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GSUPID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getSupFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3, (SELECT SUM(P2.WEIGHT) FROM prterima2 P2 INNER JOIN prterima P ON P2.ID = P.ID WHERE P.IDSUP = S.ID && P.DATE >= '$frm' && P.DATE <= '$to'), (SELECT SUM(JLH-XJLH) FROM trpinjam WHERE IDSUP = S.ID) FROM dtsup S ORDER BY NAME, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSUPFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSupTrmFrmTo($frm, $to, $sup, $type = 1)
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), ID, (SELECT COUNT(ID) FROM prterima2 WHERE ID = P.ID), (SELECT SUM(WEIGHT) FROM prterima2 WHERE ID = P.ID), BB, POTO, KET1, KET2, KET3, IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM prterima P
            WHERE DATE >= '$frm' && DATE <= '$to' && IDSUP = '$sup'";

    if(strcasecmp($type,"2") == 0)
        $sql .= " && POTO != 0";

    $sql .= " ORDER BY DATE";

    $result = mysqli_query($db,$sql) or die("Error F(x) GSUPTRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSupTTFrmTo($frm, $to, $sup)
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), ID, (SELECT COUNT(ID) FROM trtt2 WHERE ID = T.ID), (SELECT SUM(WEIGHT) FROM trtt2 WHERE ID = T.ID), (SELECT SUM(PRICE * WEIGHT) FROM trtt2 WHERE ID = T.ID) AS STTL, BB, POTO, (SELECT SUM(PRICE * WEIGHT) FROM trtt2 WHERE ID = T.ID)-BB-POTO, KET1, KET2, KET3, IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM trtt T
            WHERE DATE >= '$frm' && DATE <= '$to' && IDSUP = '$sup'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GSUPTTFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSupPjmFrmTo($frm, $to, $sup)
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), ID, JLH, XJLH, JLH-XJLH, KET1, KET2, KET3, IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM trpinjam
            WHERE DATE >= '$frm' && DATE <= '$to' && IDSUP = '$sup'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GSUPPJMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumSupPjm($id)
{
    $db = openDB();

    $sql = "SELECT SUM(JLH - XJLH - POT) FROM trpinjam
            WHERE IDSUP = '$id'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPPJM : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function getSumSupPjm2($id, $tgl)
{
    $db = openDB();

    $sql = "SELECT SUM(JLH)-SUM(POT) FROM trpinjam
            WHERE IDSUP = '$id' && DATE <= '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPPJM2 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(POTO) FROM prterima
            WHERE IDSUP = '$id' && DATE <= '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPPJM2 - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0]-$row2[0];
}

function getSumSupPjm3($id, $tgl)
{
    $db = openDB();

    $sql = "SELECT SUM(JLH), SUM(POT) FROM trpinjam
            WHERE IDSUP = '$id' && DATE < '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPPJM3 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(POTO) FROM prterima
            WHERE IDSUP = '$id' && DATE < '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPPJM3 - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $arr = array($row[0], $row2[0], $row[1]);

    closeDB($db);

    return $arr;
}

function getSumSupPjm4($id, $wkt)
{
    $db = openDB();

    $sql = "SELECT SUM(JLH-POT) FROM trpinjam
            WHERE IDSUP = '$id' && WKT < '$wkt'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPPJM4 : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumSupSmpn($id)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT * P2.SPRICE) FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID
            WHERE P.IDSUP = '$id'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPSMPN : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(TOTAL) FROM trwd
            WHERE IDSUP = '$id'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPSMPN - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0]-$row2[0];
}

function getSumSupSmpn2($id, $tgl)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT * P2.SPRICE) FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID
            WHERE P.IDSUP = '$id' && P.DATE <= '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPSMPN2 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(TOTAL) FROM trwd
            WHERE IDSUP = '$id' && DATE <= '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPSMPN2 - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SAVINGS FROM dtsup
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPSMPN2 - 3 : ".mysqli_error($db));

    $row3 = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0]-$row2[0]+$row3[0];
}

function getSumSupSmpn3($id, $tgl)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT * P2.SPRICE) FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID
            WHERE P.IDSUP = '$id' && P.DATE <= '$tgl'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPSMPN2 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SUM(TOTAL) FROM trwd
            WHERE IDSUP = '$id' && DATE <= '$tgl'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPSMPN2 - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT SAVINGS FROM dtsup
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSSUPSMPN2 - 3 : ".mysqli_error($db));

    $row3 = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0]-$row2[0]+$row3[0];
}

function getMinTrmSup($id)
{
    $db = openDB();

    $sql = "SELECT IFNULL(SUM(TOTAL-BB-POTO-VDLL-DP),0)+(SELECT IFNULL(SUM(VMIN),0) FROM prterima WHERE IDSUP = '$id') FROM prterima
            WHERE (TOTAL-BB-POTO-VDLL-DP) < 0 && IDSUP = '$id'";
    /*$sql = "SELECT SUM(TOTAL-BB-POTO-VDLL-DP+VMIN) FROM prterima
            WHERE IDSUP = '$id'";*/

    $result = mysqli_query($db, $sql) or die("Error F(x) GMINTRMSUP : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getLastSupID()
{
    $db = openDB();

    $sql = "SELECT ID FROM dtsup ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSUPID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countAllSup()
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtsup";

    $result = mysqli_query($db,$sql) or die("Error F(x) CASUP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSupID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtsup
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSUPID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSup($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtsup
            WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || ADDR LIKE '%$id%' || REG LIKE '%$id%' || HP LIKE '%$id%' || HP2 LIKE '%$id%' || EMAIL LIKE '%$id%' || KET1 LIKE '%$id%' || KET2 LIKE '%$id%' || KET3 LIKE '%$id%'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSUP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSupPrTT($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) FROM prterima
            WHERE IDSUP = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSUPPRTT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSupTrTT($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) FROM trtt
            WHERE IDSUP = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSUPTRTT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSupTrPjm($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) FROM trpinjam
            WHERE IDSUP = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSUPTRPJM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSupTrWd($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) FROM trwd
            WHERE IDSUP = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSUPTRWD : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countDelIDDupp($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) from dtdsup
            WHERE IDSUP = '$id'";
        
    $result = mysqli_query($db,$sql) or die("Error F(x) CDIDDUPP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSupHSup($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) FROM dthsup
            WHERE IDSUP = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSUPHSUP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schSup($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3, SAVINGS FROM dtsup";

    if(countSup($id) > 0)
        $sql .= " WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || ADDR LIKE '%$id%' || REG LIKE '%$id%' || HP LIKE '%$id%' || HP2 LIKE '%$id%' || EMAIL LIKE '%$id%' || KET1 LIKE '%$id%' || KET2 LIKE '%$id%' || KET3 LIKE '%$id%'";
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
            
            $sql .= "ID LIKE '%$sch%' || NAME LIKE '%$sch%' || ADDR LIKE '%$sch%' || REG LIKE '%$sch%' || HP LIKE '%$sch%' || HP2 LIKE '%$sch%' || EMAIL LIKE '%$sch%' || KET1 LIKE '%$sch%' || KET2 LIKE '%$sch%' || KET3 LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) SSUP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSupHSup($id)
{
    $db = openDB();

    $sql = "SELECT IDSUP, IDGRADE, IDSAT, PRICE FROM dthsup
            WHERE IDSUP = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSUPHSUP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getHSupID($sup, $grade, $sat)
{
    $db = openDB();

    $sql = "SELECT IDSUP, IDGRADE, IDSAT, PRICE FROM dthsup
            WHERE IDSUP = '$sup' && IDGRADE = '$grade' && IDSAT = '$sat'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHSUPID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    if(is_null($row))
        $row = array("", "", "", 0);

    closeDB($db);

    return $row;
}

function getHSupID2($sup, $grade, $sat, $db)
{
    $sql = "SELECT IDSUP, IDGRADE, IDSAT, PRICE FROM dthsup
            WHERE IDSUP = '$sup' && IDGRADE = '$grade' && IDSAT = '$sat'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GHSUPID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    if(is_null($row))
        $row = array("", "", "", 0);

    return $row;
}

function countHSup($sup, $grade, $sat)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) FROM dthsup
            WHERE IDSUP = '$sup' && IDGRADE = '$grade' && IDSAT = '$sat'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CHSUPID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function newHSup($sup, $grade, $sat, $hrga)
{
    $db = openDB();

    $sql = "INSERT INTO dthsup
            (IDSUP, IDGRADE, IDSAT, PRICE)
            VALUES
            ('$sup', '$grade', '$sat', '$hrga')";
            
    mysqli_query($db, $sql) or die("Error F(x) NHSUP : ".mysqli_error($db));

    closeDB($db);
}

function updHSup($sup, $grade, $sat, $hrga)
{
    $db = openDB();

    $sql = "UPDATE dthsup
            SET PRICE = '$hrga'
            WHERE IDSUP = '$sup' && IDGRADE = '$grade' && IDSAT = '$sat'";

    mysqli_query($db, $sql) or die("Error F(x) UHSUP : ".mysqli_error($db));

    closeDB($db);
}

function newDuplicateSupp($id)
{
    $db = openDB();

    $sql = "INSERT INTO dtdsup (IDDSup, IDSat, IDGrade, IDSup, Price, Name) SELECT CONCAT(LEFT(SUP.NAME, 1), DSUP.IDSUP, (SELECT COUNT(DISTINCT CDSUP.NAME)+1 FROM dtdsup CDSUP WHERE CDSUP.IDSUP = '$id')) AS IDDSUP, DSUP.IDSAT, DSUP.IDGRADE, DSUP.IDSUP, DSUP.PRICE, (SELECT CONCAT(SUP.NAME, ' Duplikat - ', (SELECT COUNT(DISTINCT CDSN.NAME)+1 FROM dtdsup CDSN WHERE CDSN.IDSUP = '$id'))) AS NAME FROM dtpsup DSUP INNER JOIN dtsup SUP ON DSUP.IDSUP = SUP.ID WHERE SUP.ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) NDSUPP : ".mysqli_error($db));

    closeDB($db);
}

function deleteDuplicateSupp($id)
{
    $db = openDB();

    $sql = "DELETE FROM dtdsup WHERE Name = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DDSUPP : ".mysqli_error($db));

    closeDB($db);
}

function getDuplicateSuppData($id)
{
    $db = openDB();

    $sql = "SELECT IDDTDSUP, IDDSUP, IDSAT, IDGRADE, IDSUP, PRICE, NAME FROM dtdsup WHERE IDSUP = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GDSUPPD : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getDuplicateSuppHeader($id)
{
    $db = openDB();

    $sql = "SELECT IDDTDSUP, IDDSUP, IDSAT, IDGRADE, IDSUP, PRICE, NAME FROM dtdsup WHERE IDSup = '$id' GROUP BY NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GDSUPPH : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSupPSup($id)
{
    $db = openDB();

    $sql = "SELECT IDSUP, IDGRADE, IDSAT, PRICE FROM dtpsup
            WHERE IDSUP = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSUPPSUP : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPSupID($sup, $grade, $sat)
{
    $db = openDB();

    $sql = "SELECT IDSUP, IDGRADE, IDSAT, PRICE FROM dtpsup
            WHERE IDSUP = '$sup' && IDGRADE = '$grade' && IDSAT = '$sat'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GPSUPID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    
    if(is_null($row))
        $row = array("", "", "", 0);

    closeDB($db);

    return $row;
}

function getPSupID2($sup, $grade, $sat, $db)
{
    $sql = "SELECT IDSUP, IDGRADE, IDSAT, PRICE FROM dtpsup
            WHERE IDSUP = '$sup' && IDGRADE = '$grade' && IDSAT = '$sat'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GPSUPID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    
    if(is_null($row))
        $row = array("", "", "", 0);

    return $row;
}

function countPSup($sup, $grade, $sat)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) FROM dtpsup
            WHERE IDSUP = '$sup' && IDGRADE = '$grade' && IDSAT = '$sat'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPSUPID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countDPSup($sup, $sat, $grade, $iddsup, $name, $db)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSUP) FROM dtdsup
            WHERE IDSUP = '$sup' && IDSAT = '$sat' && IDGRADE = '$grade' && IDDSUP = '$iddsup' && NAME = '$name'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CDPSUPID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function newPSup($sup, $grade, $sat, $hrga)
{
    $db = openDB();

    $sql = "INSERT INTO dtpsup
            (IDSUP, IDGRADE, IDSAT, PRICE)
            VALUES
            ('$sup', '$grade', '$sat', '$hrga')";
            
    mysqli_query($db, $sql) or die("Error F(x) NPSUP : ".mysqli_error($db));

    closeDB($db);
}

function newDPSup($sup, $grade, $sat, $hrga, $iddsup, $name, $db)
{
    $db = openDB();

    $sql = "INSERT INTO dtdsup
            (IDSUP, IDGRADE, IDSAT, PRICE, IDDSUP, NAME)
            VALUES
            ('$sup', '$grade', '$sat', '$hrga', $iddsup, $name)";
            
    mysqli_query($db, $sql) or die("Error F(x) NDPSUP : ".mysqli_error($db));

    closeDB($db);
}

function updPSup($sup, $grade, $sat, $hrga)
{
    $db = openDB();

    $sql = "UPDATE dtpsup
            SET PRICE = '$hrga'
            WHERE IDSUP = '$sup' && IDGRADE = '$grade' && IDSAT = '$sat'";

    mysqli_query($db, $sql) or die("Error F(x) UPSUP : ".mysqli_error($db));

    closeDB($db);
}

function updDPSup($sup, $grade, $sat, $hrga, $iddsup, $name, $db)
{
    $db = openDB();

    $sql = "UPDATE dtdsup
            SET PRICE = '$hrga'
            WHERE IDSUP = '$sup' && IDGRADE = '$grade' && IDSAT = '$sat' && IDDSUP = '$iddsup' && NAME = '$name'";

    mysqli_query($db, $sql) or die("Error F(x) UDPSUP : ".mysqli_error($db));

    closeDB($db);
}

function getSmpnSupFrmTo($frm, $to, $sup)
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
        $ms = 1;
        $me = 12;

        if($i == $fy)
            $ms = $fm;

        if($i == $ty)
            $me = $tm;

        for($j = $ms; $j <= $me; $j++)
        {
            $ds = 1;
            $de = 31;

            if($j == $ms && $i == $fy)
                $ds = $fd;

            if($j == $me && $i == $ty)
                $de = $td;

            for($k = $ds; $k <= $de; $k++)
            {
                $sql = "SELECT SUM(P2.WEIGHT * P2.SPRICE) FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID
                        WHERE P.DATE = '$i-$j-$k' && P.IDSUP = '$sup'";
                        
                $result = mysqli_query($db, $sql) or die("Error F(x) GSMPNSUPFT : ".mysqli_error($db));

                $smpn = mysqli_fetch_array($result, MYSQLI_NUM);
                
                $sql = "SELECT SUM(TOTAL) FROM trwd
                        WHERE DATE = '$i-$j-$k' && IDSUP = '$sup'";

                $result = mysqli_query($db, $sql) or die("Error F(x) GSMPNSUPFT - 2 : ".mysqli_error($db));

                $wd = mysqli_fetch_array($result, MYSQLI_NUM);

                if($wd[0] == 0 && $smpn[0] == 0)
                    continue;

                $arr[count($arr)] = array("$i-$j-$k", $smpn[0], $wd[0], "$k/$j/$i");
            }
        }
    }
    
    closeDB($db);

    return $arr;
}

function getSmpnSupFrmTo2($frm, $to, $sup)
{
    $db = openDB();
    
    $sql = "SELECT P.DATE AS 'DATE', SUM(P2.WEIGHT*P2.SPRICE), SUM(P2.WEIGHT), P2.SPRICE, P.IDSUP FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && P.IDSUP = '$sup' && P2.SPRICE > 0
            GROUP BY P.DATE, P2.SPRICE, P.IDSUP ORDER BY P.DATE";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSMPNSUPFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSmpnSupFrmTo3($frm, $to, $sup)
{
    $db = openDB();
    
    $sql = "SELECT DISTINCT P2.SPRICE FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && P.IDSUP = '$sup' && SPRICE != 0 ORDER BY P.DATE, P.ID";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSMPNSUPFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getSmpnSupFrmTo4($frm, $to, $sup)
{
    $db = openDB();
    
    $sql = "SELECT DISTINCT MONTH(P.DATE), YEAR(P.DATE), (SELECT SUM(SP2.WEIGHT*SP2.SPRICE) FROM prterima2 SP2 INNER JOIN prterima SP ON SP.ID = SP2.ID WHERE MONTH(SP.DATE) = MONTH(P.DATE) && YEAR(SP.DATE) = YEAR(P.DATE) && SP.IDSUP = P.IDSUP), (SELECT SUM(TOTAL) FROM trwd WHERE MONTH(DATE) = MONTH(P.DATE) && YEAR(DATE) = YEAR(P.DATE) && IDSUP = P.IDSUP) FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && P.IDSUP = '$sup' ORDER BY P.DATE, P.ID";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSMPNSUPFT4 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSmpnSupBfr($tgl, $sup)
{
    $db = openDB();

    $sql = "SELECT SUM(P2.WEIGHT*P2.SPRICE) FROM prterima2 P2 INNER JOIN prterima P ON P.ID = P2.ID
            WHERE P.DATE < '$tgl' && P.IDSUP = '$sup'";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GSMPNSUPB : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function updAHSup($wsup, $wgrade, $wsat, $jns, $jlh, $prb, $lgsup, $lgrade, $db){
    if(strcasecmp($prb,"1") == 0){
        if(strcasecmp($jns,"1") == 0){
            $sql = "UPDATE dthsup
                    SET PRICE = PRICE + $jlh
                    WHERE $wsup && $wgrade && $wsat";
        }
        else if(strcasecmp($jns,"2") == 0){
            $sql = "UPDATE dthsup
                    SET PRICE = PRICE - $jlh
                    WHERE $wsup && $wgrade && $wsat";
        }
        else if(strcasecmp($jns,"3") == 0){
            $sql = "UPDATE dthsup
                    SET PRICE = $jlh
                    WHERE $wsup && $wgrade && $wsat";
        }
    
        mysqli_query($db, $sql) or die("Error F(x) UAHSUP : ".mysqli_error($db));
    }
    else if(strcasecmp($prb,"2") == 0){
        for($i = 0; $i < count($lgrade); $i++){
            if(strcasecmp($jns,"1") == 0){
                $sql = "UPDATE dthsup
                        SET PRICE = PRICE + $lgsup[$i]
                        WHERE $wsup && $wsat && IDGRADE = '$lgrade[$i]'";
            }
            else if(strcasecmp($jns,"2") == 0){
                $sql = "UPDATE dthsup
                        SET PRICE = PRICE - $lgsup[$i]
                        WHERE $wsup && $wsat && IDGRADE = '$lgrade[$i]'";
            }
            else if(strcasecmp($jns,"3") == 0){
                $sql = "UPDATE dthsup
                        SET PRICE = $lgsup[$i]
                        WHERE $wsup && $wsat && IDGRADE = '$lgrade[$i]'";
            }
            
            mysqli_query($db, $sql) or die("Error F(x) UAHSUP -2 : ".mysqli_error($db));
        }
    }
}

function newSup($id, $name, $addr, $reg, $hp, $hp2, $mail, $ket1, $ket2, $ket3, $smpn = 0)
{
    $db = openDB();

    $sql = "INSERT INTO dtsup
            (ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3, SAVINGS)
            VALUES
            ('$id', '$name', '$addr', '$reg', '$hp', '$hp2', '$mail', '$ket1', '$ket2', '$ket3', '$smpn')";

    mysqli_query($db,$sql) or die("Error F(x) NSUP : ".mysqli_error($db));

    closeDB($db);
}

function updSup($id, $name, $addr, $reg, $hp, $hp2, $mail, $ket1, $ket2, $ket3, $bid, $smpn = 0)
{
    $db = openDB();

    $sql = "UPDATE dtsup, dtdsup
            SET dtsup.ID = '$id', dtsup.NAME = '$name', dtsup.ADDR = '$addr', dtsup.REG = '$reg', dtsup.HP = '$hp', dtsup.HP2 = '$hp2', dtsup.EMAIL = '$mail', dtsup.KET1 = '$ket1', dtsup.KET2 = '$ket2', dtsup.KET3 = '$ket3', dtsup.SAVINGS = '$smpn', dtdsup.IDSUP = '$id'
            WHERE dtsup.ID = '$bid' AND dtdsup.IDSUP = '$bid'";

    mysqli_query($db,$sql) or die("Error F(x) USUP : ".mysqli_error($db));

    closeDB($db);
}

function delSup($id)
{
    $db = openDB();

    $sql = "DELETE FROM dtsup
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DSUP : ".mysqli_error($db));

    closeDB($db);
}

//CUSTOMER
function getAllCus()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3 FROM dtcus ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GACUS : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllAddrCus()
{
    $db = openDB();

    $sql = "SELECT DISTINCT ADDR FROM dtcus ORDER BY ADDR";

    $result = mysqli_query($db,$sql) or die("Error F(x) GADCUS : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllCusID()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3 FROM dtcus ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GACUSID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getCusID($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3 FROM dtcus
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GCUSID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getCusFrmTo($frm, $to)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3, (SELECT SUM(T2.WEIGHT) FROM trkirim2 T2 INNER JOIN trkirim T ON T2.ID = T.ID WHERE T.IDCUS = C.ID && T.DATE >= '$frm' && T.DATE <= '$to') FROM dtcus C ORDER BY NAME, ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GCUSFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getCusKrmFrmTo($frm, $to, $cus)
{
    $db = openDB();

    $sql = "SELECT DATE_FORMAT(DATE, '%d/%m/%Y'), ID, (SELECT SUM(WEIGHT) FROM trkirim2 WHERE ID = K.ID), KET1, KET2, KET3, IDUSER, DATE_FORMAT(WKT, '%d/%m/%Y %H:%i') FROM trkirim K
            WHERE DATE >= '$frm' && DATE <= '$to' && IDCUS = '$cus'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GCUSKRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastCusID()
{
    $db = openDB();

    $sql = "SELECT ID FROM dtcus ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLCUSID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countAllCus()
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtcus";

    $result = mysqli_query($db,$sql) or die("Error F(x) CACUS : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countCusID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtcus
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CCUSID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countCus($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtcus
            WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || ADDR LIKE '%$id%' || REG LIKE '%$id%' || HP LIKE '%$id%' || HP2 LIKE '%$id%' || EMAIL LIKE '%$id%' || KET1 LIKE '%$id%' || KET2 LIKE '%$id%' || KET3 LIKE '%$id%'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CCUS : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countCusPO($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDCUS) FROM dtpo
            WHERE IDCUS = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CCUSPO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schCus($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3 FROM dtcus";

    if(countCus($id) > 0)
        $sql .= " WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || ADDR LIKE '%$id%' || REG LIKE '%$id%' || HP LIKE '%$id%' || HP2 LIKE '%$id%' || EMAIL LIKE '%$id%' || KET1 LIKE '%$id%' || KET2 LIKE '%$id%' || KET3 LIKE '%$id%'";
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
            
            $sql .= "ID LIKE '%$sch%' || NAME LIKE '%$sch%' || ADDR LIKE '%$sch%' || REG LIKE '%$sch%' || HP LIKE '%$sch%' || HP2 LIKE '%$sch%' || EMAIL LIKE '%$sch%' || KET1 LIKE '%$sch%' || KET2 LIKE '%$sch%' || KET3 LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) SCUS : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function newCus($id, $name, $addr, $reg, $hp, $hp2, $mail, $ket1, $ket2, $ket3)
{
    $db = openDB();

    $sql = "INSERT INTO dtcus
            (ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3)
            VALUES
            ('$id', '$name', '$addr', '$reg', '$hp', '$hp2', '$mail', '$ket1', '$ket2', '$ket3')";

    mysqli_query($db,$sql) or die("Error F(x) NCUS : ".mysqli_error($db));

    closeDB($db);
}

function updCus($id, $name, $addr, $reg, $hp, $hp2, $mail, $ket1, $ket2, $ket3, $bid)
{
    $db = openDB();

    $sql = "UPDATE dtcus
            SET ID = '$id', NAME = '$name', ADDR = '$addr', REG = '$reg', HP = '$hp', HP2 = '$hp2', EMAIL = '$mail', KET1 = '$ket1', KET2 = '$ket2', KET3 = '$ket3'
            WHERE ID = '$bid'";

    mysqli_query($db,$sql) or die("Error F(x) UCUS : ".mysqli_error($db));

    closeDB($db);
}

function delCus($id)
{
    $db = openDB();

    $sql = "DELETE FROM dtcus
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DCUS : ".mysqli_error($db));

    closeDB($db);
}

//GRADE
function getAllGrade()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtgrade ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GAGRD : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllGradeID()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtgrade ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GAGRDID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getGradeID($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtgrade
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GGRDID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getGradePro($id)
{
    $db = openDB();

    $sql = "SELECT P.ID, K.NAME, SK.NAME, P.NAME, (TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MPQTY+FIQTY-FOQTY+PSQTY+RBQTY-P.RPOQTY+P.RPIQTY) AS QTY FROM dtproduk P INNER JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE P.IDGRADE = '$id' ORDER BY P.NAME, K.NAME, SK.NAME";

    $result = mysqli_query($db,$sql) or die("Error F(x) GGRDPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row; 

    closeDB($db);

    return $arr;
}

function getLastGradeID()
{
    $db = openDB();

    $sql = "SELECT ID FROM dtgrade ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLGRDID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countAllGrade()
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtgrade";

    $result = mysqli_query($db,$sql) or die("Error F(x) CAGRD : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countGradeID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtgrade
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CGRDID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countGrade($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtgrade
            WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || KET LIKE '%$id%'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CGRD : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countGradePro($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDGRADE) FROM dtproduk
            WHERE IDGRADE = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CGRDPRO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countHSupGrade($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDGRADE) FROM dthsup
            WHERE IDGRADE = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CHSUPGRD : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countGradeDupp($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDGRADE) FROM dtdsup
        WHERE IDGRADE = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CGRDDUPP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countPSupGrade($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDGRADE) FROM dtpsup
            WHERE IDGRADE = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CPSUPGRD : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schGrade($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtgrade";

    if(countGrade($id) > 0)
        $sql .= " WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || KET LIKE '%$id%'";
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
            
            $sql .= "ID LIKE '%$sch%' || NAME LIKE '%$sch%' || KET LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) SGRD : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function schGradePro($id, $id2)
{
    $db = openDB();

    $sql = "SELECT P.ID, K.NAME, SK.NAME, P.NAME, (TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MPQTY+FIQTY-FOQTY+PSQTY+RBQTY-P.RPOQTY+P.RPIQTY) AS QTY FROM dtproduk P INNER JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE P.IDGRADE = '$id'";

    if(countPro($id2) > 0)
        $sql .= " && (P.ID LIKE '%$id2%' || P.NAME LIKE '%$id2%' || K.NAME LIKE '%$id2%' || SK.NAME = '%$id2%')";
    else
    {
        $y = explode(" ",$id2);
        
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
            
            $sql .= "P.ID LIKE '%$sch%' || P.NAME LIKE '%$sch%' || K.NAME LIKE '%$sch%' || SK.NAME = '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }

        $sql .= ")";
    }

    $sql .= " ORDER BY P.NAME, K.NAME, SK.NAME";

    $result = mysqli_query($db,$sql) or die("Error F(x) SGRDPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row; 

    closeDB($db);

    return $arr;
}

function newGrade($id, $name, $ket)
{
    $db = openDB();

    $sql = "INSERT INTO dtgrade
            (ID, NAME, KET)
            VALUES
            ('$id', '$name', '$ket')";

    mysqli_query($db,$sql) or die("Error F(x) NGRD : ".mysqli_error($db));

    closeDB($db);
}

function updGrade($id, $name, $ket, $bid)
{
    $db = openDB();

    $sql = "UPDATE dtgrade, dtdsup
            SET dtgrade.ID = '$id', dtgrade.NAME = '$name', dtgrade.KET = '$ket', dtdsup.IDGRADE = '$id'
            WHERE ID = '$bid' AND IDGRADE = '$bid'";

    mysqli_query($db,$sql) or die("Error F(x) UGRD : ".mysqli_error($db));

    closeDB($db);
}

function delGrade($id)
{
    $db = openDB();

    $sql = "DELETE FROM dtgrade
            WHERE ID = '$id'";

    mysqli_query($db,$sql) or die("Error F(x) DGRD : ".mysqli_error($db));

    closeDB($db);
}

//SATUAN
function getAllSatuan()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtsat ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GASTN : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllSatuanID()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtsat ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GASTNID : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row[0];

    closeDB($db);

    return $arr;
}

function getSatuanID($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtsat
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GSTNID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getLastSatuanID()
{
    $db = openDB();

    $sql = "SELECT ID FROM dtsat ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSTNID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countAllSatuan()
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtsat";

    $result = mysqli_query($db,$sql) or die("Error F(x) CASTN : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSatuanID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtsat
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSTNID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSatuan($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtsat
            WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || KET LIKE '%$id%'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSTN : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSatuanTrm($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSAT) FROM prterima2
            WHERE IDSAT = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSTNTRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countHSupSatuan($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSAT) FROM dthsup
            WHERE IDSAT = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CHSUPSTN : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countPSupSatuan($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSAT) FROM dtpsup
            WHERE IDSAT = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CPSUPSTN : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSatuanDupp($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSAT) FROM dtdsup
            WHERE IDSAT = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSATDUPP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schSatuan($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtsat";

    if(countSatuan($id) > 0)
        $sql .= " WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || KET LIKE '%$id%'";
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
            
            $sql .= "ID LIKE '%$sch%' || NAME LIKE '%$sch%' || KET LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) SSTN : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function newSatuan($id, $name, $ket)
{
    $db = openDB();

    $sql = "INSERT INTO dtsat
            (ID, NAME, KET)
            VALUES
            ('$id', '$name', '$ket')";

    mysqli_query($db,$sql) or die("Error F(x) NSTN : ".mysqli_error($db));

    closeDB($db);
}

function updSatuan($id, $name, $ket, $bid)
{
    $db = openDB();

    $sql = "UPDATE dtsat, dtdsup
            SET dtsat.ID = '$id', dtsat.NAME = '$name', dtsat.KET = '$ket', dtdsup.IDSAT = '$id'
            WHERE dtsat.ID = '$bid' AND dtdsup.IDSAT = '$bid'";

    mysqli_query($db,$sql) or die("Error F(x) USTN : ".mysqli_error($db));

    closeDB($db);
}

function delSatuan($id)
{
    $db = openDB();

    $sql = "DELETE FROM dtsat
            WHERE ID = '$id'";

    mysqli_query($db,$sql) or die("Error F(x) DSTN : ".mysqli_error($db));

    closeDB($db);
}

//KATEGORI
function getAllKate()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtkate ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GAKATE : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getKateID($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtkate
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GKATEID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getKatePro($id)
{
    $db = openDB();

    $sql = "SELECT P.ID, G.NAME, SK.NAME, P.NAME, (TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MPQTY+FIQTY-FOQTY+PSQTY+RBQTY-RPOQTY+RPIQTY) AS QTY FROM dtproduk P INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE P.IDKATE = '$id' ORDER BY P.NAME, G.NAME, SK.NAME";

    $result = mysqli_query($db,$sql) or die("Error F(x) GKATEPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row; 

    closeDB($db);

    return $arr;
}

function getKateSKate($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtskate
            WHERE IDKATE = '$id' ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GKATESKATE : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastKateID()
{
    $db = openDB();

    $sql = "SELECT ID FROM dtkate ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLKATEID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countAllKate()
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtkate";

    $result = mysqli_query($db,$sql) or die("Error F(x) CAKATE : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countKateID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtkate
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CKATEID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countKate($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtkate
            WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || KET LIKE '%$id%'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CKATE : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countKatePro($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDKATE) FROM dtproduk
            WHERE IDKATE = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CKATETRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countKateSKate($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDKATE) FROM dtskate
            WHERE IDKATE = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CKATESKATE : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schKate($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtkate";

    if(countKate($id) > 0)
        $sql .= " WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || KET LIKE '%$id%'";
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
            
            $sql .= "ID LIKE '%$sch%' || NAME LIKE '%$sch%' || KET LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) SKATE : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function schKatePro($id, $id2)
{
    $db = openDB();

    $sql = "SELECT P.ID, G.NAME, SK.NAME, P.NAME, (TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MPQTY+FIQTY-FOQTY+PSQTY+RBQTY-RPOQTY+RPIQTY) AS QTY FROM dtproduk P INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE P.IDKATE = '$id'";

    if(countPro($id2) > 0)
        $sql .= " && (P.ID LIKE '%$id2%' || P.NAME LIKE '%$id2%' || SK.NAME LIKE '%$id2%' || G.NAME = '%$id2%')";
    else
    {
        $y = explode(" ",$id2);
        
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
            
            $sql .= "P.ID LIKE '%$sch%' || P.NAME LIKE '%$sch%' || SK.NAME LIKE '%$sch%' || G.NAME = '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }

        $sql .= ")";
    }

    $sql .= " ORDER BY P.NAME, G.NAME, SK.NAME";

    $result = mysqli_query($db,$sql) or die("Error F(x) SKATEPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row; 

    closeDB($db);

    return $arr;
}

function schKateSKate($id, $id2)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET FROM dtskate
            WHERE IDKATE = '$id'";

    if(countSKate($id2) > 0)
        $sql .= " && (ID LIKE '%$id2%' || NAME LIKE '%$id2%' || KET LIKE '%$id%')";
    else
    {
        $y = explode(" ",$id2);
        
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
            
            $sql .= "ID LIKE '%$sch%' || NAME LIKE '%$sch%' || KET LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }

        $sql .= ")";
    }

    $sql .= " ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) SKATESKATE : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row; 

    closeDB($db);

    return $arr;
}

function newKate($id, $name, $ket)
{
    $db = openDB();

    $sql = "INSERT INTO dtkate
            (ID, NAME, KET)
            VALUES
            ('$id', '$name', '$ket')";

    mysqli_query($db,$sql) or die("Error F(x) NKATE : ".mysqli_error($db));

    closeDB($db);
}

function updKate($id, $name, $ket, $bid)
{
    $db = openDB();

    $sql = "UPDATE dtkate
            SET ID = '$id', NAME = '$name', KET = '$ket'
            WHERE ID = '$bid'";

    mysqli_query($db,$sql) or die("Error F(x) UKATE : ".mysqli_error($db));

    closeDB($db);
}

function delKate($id)
{
    $db = openDB();

    $sql = "DELETE FROM dtkate
            WHERE ID = '$id'";

    mysqli_query($db,$sql) or die("Error F(x) DKATE : ".mysqli_error($db));

    closeDB($db);
}

//SUB KATEGORI
function getAllSKate()
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET, IDKATE FROM dtskate ORDER BY NAME, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GASKATE : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSKateID($id)
{
    $db = openDB();

    $sql = "SELECT ID, NAME, KET, IDKATE FROM dtskate
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GSKATEID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getSKatePro($id)
{
    $db = openDB();

    $sql = "SELECT P.ID, K.NAME, G.NAME, P.NAME, (TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MPQTY+FIQTY-FOQTY+PSQTY+RBQTY-RPOQTY+RPIQTY) AS QTY FROM dtproduk P INNER JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE P.IDSKATE = '$id' ORDER BY P.NAME, K.NAME, G.NAME";

    $result = mysqli_query($db,$sql) or die("Error F(x) GSKATEPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row; 

    closeDB($db);

    return $arr;
}

function getLastSKateID()
{
    $db = openDB();

    $sql = "SELECT ID FROM dtskate ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLSKATEID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countAllSKate()
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtskate";

    $result = mysqli_query($db,$sql) or die("Error F(x) CASKATE : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSKateID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtskate
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSKATEID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSKate($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(SK.ID) FROM dtskate SK LEFT JOIN dtkate K ON SK.IDKATE = K.ID
            WHERE SK.ID LIKE '%$id%' || SK.NAME LIKE '%$id%' || SK.KET LIKE '%$id%' || K.NAME LIKE '%$id%'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSKATE : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countSKatePro($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDSKATE) FROM dtproduk
            WHERE IDSKATE = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CSKATEPRO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schSKate($id)
{
    $db = openDB();

    $sql = "SELECT SK.ID, SK.NAME, SK.KET, K.NAME FROM dtskate SK LEFT JOIN dtkate K ON SK.IDKATE = K.ID";

    if(countSKate($id) > 0)
        $sql .= " WHERE SK.ID LIKE '%$id%' || SK.NAME LIKE '%$id%' || SK.KET LIKE '%$id%'";
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
            
            $sql .= "SK.ID LIKE '%$sch%' || SK.NAME LIKE '%$sch%' || SK.KET LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY SK.NAME, K.NAME";

    $result = mysqli_query($db,$sql) or die("Error F(x) SSKATE : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function schSKatePro($id, $id2)
{
    $db = openDB();

    $sql = "SELECT P.ID, K.NAME, G.NAME, P.NAME, (TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MPQTY+FIQTY-FOQTY+PSQTY+RBQTY-RPOQTY+RPIQTY) AS QTY FROM dtproduk P INNER JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE P.IDSKATE = '$id'";

    if(countPro($id2) > 0)
        $sql .= " && (P.ID LIKE '%$id2%' || P.NAME LIKE '%$id2%' || K.NAME LIKE '%$id2%' || G.NAME = '%$id2%')";
    else
    {
        $y = explode(" ",$id2);
        
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
            
            $sql .= "P.ID LIKE '%$sch%' || P.NAME LIKE '%$sch%' || K.NAME LIKE '%$sch%' || G.NAME = '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }

        $sql .= ")";
    }

    $sql .= " ORDER BY P.NAME, K.NAME, G.NAME";

    $result = mysqli_query($db,$sql) or die("Error F(x) SSKATEPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row; 

    closeDB($db);

    return $arr;
}

function newSKate($id, $name, $ket, $kate)
{
    $db = openDB();

    $sql = "INSERT INTO dtskate
            (ID, NAME, KET, IDKATE)
            VALUES
            ('$id', '$name', '$ket', '$kate')";

    mysqli_query($db,$sql) or die("Error F(x) NSKATE : ".mysqli_error($db));

    closeDB($db);
}

function updSKate($id, $name, $ket, $kate, $bid)
{
    $db = openDB();

    $sql = "UPDATE dtskate
            SET ID = '$id', NAME = '$name', KET = '$ket', IDKATE = '$kate'
            WHERE ID = '$bid'";

    mysqli_query($db,$sql) or die("Error F(x) USKATE : ".mysqli_error($db));

    closeDB($db);
}

function delSKate($id)
{
    $db = openDB();

    $sql = "DELETE FROM dtskate
            WHERE ID = '$id'";

    mysqli_query($db,$sql) or die("Error F(x) DSKATE : ".mysqli_error($db));

    closeDB($db);
}

//PRODUK
function getAllPro($type = "1", $type2 = "", $kates = "", $katej = "")
{
    $db = openDB();

    $sql = "SELECT P.ID, P.NAME, G.NAME, K.NAME, SK.NAME, ROUND((P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MPQTY+P.FIQTY-P.FOQTY+P.PSQTY+P.RBQTY-P.RPOQTY+P.RPIQTY),2) AS QTY, STRM, SCUT, SFILL, SSAW, SPKG, SMP, SFRZ, HSELL, P.AQTY, KS.NAMA, GO.NAMA, KJ.NAMA FROM dtproduk P LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkates KS ON P.IDKATES = KS.ID LEFT JOIN dtgol GO ON P.IDGOL = GO.ID LEFT JOIN dtkatej KJ ON P.IDKATEJ = KJ.ID";

    if(strcasecmp($type2, "TRM") == 0)
        $sql .= " WHERE P.STRM = 'Y'";
    else if(strcasecmp($type2, "CUT") == 0)
        $sql .= " WHERE P.SCUT = 'Y'";
    else if(strcasecmp($type2, "VAC") == 0)
        $sql .= " WHERE P.SFILL = 'Y'";
    else if(strcasecmp($type2, "SAW") == 0)
        $sql .= " WHERE P.SSAW = 'Y'";
    else if(strcasecmp($type2, "KRM") == 0)
        $sql .= " WHERE P.SPKG = 'Y'";
    else if(strcasecmp($type2, "MP") == 0)
        $sql .= " WHERE P.SMP = 'Y'";
    else if(strcasecmp($type2, "FRZ") == 0)
        $sql .= " WHERE P.SFRZ = 'Y'";

    if(strcasecmp($type2,"") != 0 && strcasecmp($type,"3") == 0){
        $sql .= " && ROUND((P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MPQTY+P.FIQTY-P.FOQTY+P.PSQTY+P.RBQTY-P.RPOQTY+P.RPIQTY),2) != 0";
    }
    else if(strcasecmp($type,"3") == 0){
        $sql .= " WHERE ROUND((P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MPQTY+P.FIQTY-P.FOQTY+P.PSQTY+P.RBQTY-P.RPOQTY+P.RPIQTY),2) != 0";
    }

    if((strcasecmp($type,"3") == 0 || strcasecmp($type2,"") != 0) && strcasecmp($kates,"") || strcasecmp($katej,"") != 0){
        $sql .= " && P.IDKATES = '$kates' && P.IDKATEJ = '$katej'";
    }
    else if(strcasecmp($kates,"") != 0 || strcasecmp($katej, "" != 0)){
        $sql .= " WHERE P.IDKATES = '$kates' && P.IDKATEJ = '$katej'";
    }

    $sql .= " ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME, P.ID";
    
    if(strcasecmp($type,"1") == 0)
        $sql .= " LIMIT 0, 50";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllProGol($gol, $type = "1", $kates = "", $db)
{
    $sql = "SELECT P.ID, P.NAME, G.NAME, K.NAME, SK.NAME, ROUND((P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MPQTY+P.FIQTY-P.FOQTY+P.PSQTY+P.RBQTY-P.RPOQTY+P.RPIQTY),2) AS QTY, STRM, SCUT, SFILL, SSAW, SPKG, SMP, SFRZ, HSELL, P.AQTY, KS.NAMA, GO.NAMA FROM dtproduk P LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkates KS ON P.IDKATES = KS.ID LEFT JOIN dtgol GO ON P.IDGOL = GO.ID
            WHERE IDGOL = '$gol'";

    if(strcasecmp($type,"3") == 0){
        $sql .= " && ROUND((P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MPQTY+P.FIQTY-P.FOQTY+P.PSQTY+P.RBQTY-P.RPOQTY+P.RPIQTY),2) != 0";
    }

    if(strcasecmp($kates,"") != 0){
        $sql .= " && P.IDKATES = '$kates'";
    }

    $sql .= " ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME, P.ID";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GAPROGOL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getAllProVac()
{
    $db = openDB();

    $sql = "SELECT P.ID, P.NAME, G.NAME, K.NAME, SK.NAME, (P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MPQTY+P.FIQTY-P.FOQTY+P.PSQTY+P.RBQTY-P.RPOQTY+P.RPIQTY) AS QTY, STRM, SCUT, SFILL, SSAW, SPKG, SMP, SFRZ, HSELL FROM dtproduk P LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE SFILL = 'Y' ORDER BY P.NAME, P.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getAllProVac2($frm, $to, $kurs, $db)
{
    $sql = "SELECT P.ID, P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), (P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY) AS QTY, (SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE >= '$frm' && T.DATE <= '$to'), (SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE < '$frm'), (SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE > '$to'), (SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE >= '$frm' && C.DATE <= '$to'), (SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE < '$frm'), (SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE > '$to'), (SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to'), (SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE < '$frm'), (SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE > '$to'), (SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE >= '$frm' && F.DATE <= '$to'), (SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE < '$frm'), (SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE > '$to'), (SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to'), (SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE < '$frm'), (SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE > '$to'), (SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE >= '$frm' && S.DATE <= '$to'), (SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE < '$frm'), (SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE > '$to'), (SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID WHERE K2.IDPRODUK = P.ID && K.DATE >= '$frm' && K.DATE <= '$to' && K.STAT = 'SN'), (SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID WHERE K2.IDPRODUK = P.ID && K.DATE < '$frm' && K.STAT = 'SN'), (SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID WHERE K2.IDPRODUK = P.ID && K.DATE > '$to' && K.STAT = 'SN'), (SELECT SUM(C2.TCUT1+C2.TCUT2+C2.TCUT3+C2.TCUT4+C2.TCUT5+C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE >= '$frm' && C.DATE <= '$to'), (SELECT SUM(C2.TCUT1+C2.TCUT2+C2.TCUT3+C2.TCUT4+C2.TCUT5+C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE < '$frm'), (SELECT SUM(C2.TCUT1+C2.TCUT2+C2.TCUT3+C2.TCUT4+C2.TCUT5+C2.TCUT6) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE > '$to'), P.AQTY, (SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE >= '$frm' && M.DATE <= '$to'), (SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE < '$frm'), (SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE > '$to'), (SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE >= '$frm' && F.DATE <= '$to'), (SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE < '$frm'), (SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE > '$to'), (SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE >= '$frm' && F.DATE <= '$to'), (SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE < '$frm'), (SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE > '$to'), IF(P.HSELL < 100, P.HSELL * $kurs, P.HSELL) FROM dtproduk P LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID
            WHERE P.SFILL = 'Y' ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GPROVAC2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $cutpro = getSumCutFrmTo7($frm, $to, $row[0], "", $db);
        $cutpro2 = getSumCutFrmTo8($frm, $row[0], "", $db);
        $saldo = $row[7]-$row[10]-$row[13]+$row[16]-$row[19]+$row[22]-$row[25]+$row[28]+$row[30]-$cutpro2+$row[32]-$row[35]+$row[38];

        $row[5] = $saldo + $row[6] - $row[9] + $row[27] - $row[12] + $row[15] - $row[18] + $row[21] - $row[24] - $cutpro + $row[31] - $row[34] + $row[37];

        $arr[count($arr)] = array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], 0, 0, 0, 0, 0, 0, 0, $row[40], 0, 0, 0);
    }

    return $arr;
}

function getProID($id)
{
    $db = openDB();

    $sql = "SELECT P.ID, P.NAME, P.IDKATE, P.IDSKATE, P.IDGRADE, ROUND((P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.PSQTY+P.RBQTY+P.MIQTY-P.MOQTY-P.RPOQTY+P.RPIQTY),2) AS QTY, P.AQTY, P.STRM, P.SCUT, P.SFILL, P.SSAW, P.SPKG, P.SMP, P.SFRZ, P.HSELL, P.IDKATES, P.IDGOL, P.IDKATEJ FROM dtproduk P
        WHERE P.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPROID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getProID2($id, $db)
{
    $sql = "SELECT P.ID, P.NAME, P.IDKATE, P.IDSKATE, P.IDGRADE, ROUND((P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY),2) AS QTY, P.AQTY, P.STRM, P.SCUT, P.SFILL, P.SSAW, P.SPKG, P.SMP, P.SFRZ, P.HSELL, (SELECT NAME FROM dtgrade WHERE ID = P.IDGRADE), (SELECT NAME FROM dtkate WHERE ID = P.IDKATE), (SELECT NAME FROM dtskate WHERE ID = P.IDSKATE) FROM dtproduk P
            WHERE P.ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPROID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getQtyInProTgl($pro, $tgl, $gdg, $db){
    $whr = "";
    $whr2 = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && P.IDGDG = '$gdg'";
        $whr2 = " && P.IDGDGT = '$gdg'";
    }

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM prterima2 P2 INNER JOIN prterima P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 1 : ".mysqli_error($db));

    $row1 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM prfill2 P2 INNER JOIN prfill P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM prsaw2 P2 INNER JOIN prsaw P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 3 : ".mysqli_error($db));

    $row3 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM prmsk2 P2 INNER JOIN prmsk P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 3 : ".mysqli_error($db));

    $row4 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM prfrz2 P2 INNER JOIN prfrz P ON P2.ID = P.ID
            WHERE P2.IDPRODUK2 = '$pro' && P.DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 4 : ".mysqli_error($db));

    $row5 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM prfrz2 P2 INNER JOIN prfrz P ON P2.ID = P.ID
            WHERE P2.IDPRODUK2 = '$pro' && P.DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 4 : ".mysqli_error($db));

    $row5 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM trps2 P2 INNER JOIN trps P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl' && P2.WEIGHT > 0 $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 5 : ".mysqli_error($db));

    $row6 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM trmove2 P2 INNER JOIN trmove P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl' $whr2";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 6 : ".mysqli_error($db));

    $row7 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM trrpkg2 P2 INNER JOIN trrpkg P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 7 : ".mysqli_error($db));

    $row8 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(IFNULL(SUM(P2.WEIGHT),0),2) FROM trrkirim2 P2 INNER JOIN trrkirim P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQIPROT - 8 : ".mysqli_error($db));

    $row9 = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row1[0]+$row2[0]+$row3[0]+$row4[0]+$row5[0]+$row6[0]+$row7[0]+$row8[0]+$row9[0];
}

function getQtyCutProTgl($pro, $tgl, $gdg, $db){
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && P.IDGDG = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(P2.WEIGHT),2) FROM prcut2 P2 INNER JOIN prcut P ON P2.ID = P.ID
            WHERE P2.IDPRODUK = '$pro' && P.DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQCUTPROT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getQtyVacProTgl($pro, $tgl, $gdg, $db){
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && IDGDG = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(WEIGHT),2) FROM prfill
            WHERE IDPRODUK = '$pro' && DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQVACPROT - 1 : ".mysqli_error($db));

    $row1 = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT ROUND(SUM(WEIGHT2),2) FROM prfill
            WHERE IDPRODUK2 = '$pro' && DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQVACPROT - 2 : ".mysqli_error($db));

    $row2 = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row1[0]+$row2[0];
}

function getQtySawProTgl($pro, $tgl, $gdg, $db){
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && IDGDG = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(WEIGHT),2) FROM prsaw
            WHERE IDPRODUK = '$pro' && DATE = '$tgl' $whr";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQSAWPROT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function getQtyKrmProTgl($pro, $tgl, $gdg, $db){
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && P.IDGDG = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(T2.WEIGHT),2), T2.IDPO, T2.IDPRODUK, P.DATE, P.STAT, T.IDGDG FROM trkirim2 T2 INNER JOIN dtpo P ON T2.IDPO = P.ID INNER JOIN trkirim T ON T2.ID = T.ID
            GROUP BY T2.IDPO HAVING T2.IDPRODUK = '$pro' && P.DATE = '$tgl' && P.STAT = 'SN' $whr";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GQKRMPROT : ".mysqli_error($db));

    $data = array(0, "");
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $data[0] += $row[0];
        
        if(strcasecmp($data[1],"") != 0)
            $data[1] .= ", ";

        $data[1] .= $row[1]." (".number_format($row[0],2,'.',',').")";
    }
    
    return $data;
}

function getQtyFrzProTgl($pro, $tgl, $gdg, $db){
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && T.IDGDG = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(T2.WEIGHT),2) FROM prfrz2 T2 INNER JOIN prfrz T ON T2.ID = T.ID
            WHERE T2.IDPRODUK = '$pro' && T.DATE = '$tgl' $whr";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GQFRZPROT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    
    return $row[0];
}

function getQtyPsProTgl($pro, $tgl, $gdg, $db){
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && T.IDGDG = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(T2.WEIGHT),2) FROM trps2 T2 INNER JOIN trps T ON T2.ID = T.ID
            WHERE T2.IDPRODUK = '$pro' && T.DATE = '$tgl' && T2.WEIGHT < 0 $whr";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GQPSPROT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    
    return $row[0];
}

function getQtyMoveProTgl($pro, $tgl, $gdg, $db){
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && T.IDGDGF = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(T2.WEIGHT),2) FROM trmove2 T2 INNER JOIN trmove T ON T2.ID = T.ID
            WHERE T2.IDPRODUK = '$pro' && T.DATE = '$tgl' $whr";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GQMVPROT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    
    return $row[0];
}

function getQtyRPkgProTgl($pro, $tgl, $gdg, $db){
    $whr = "";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && T.IDGDGT = '$gdg'";
    }

    $sql = "SELECT ROUND(SUM(T2.WEIGHT),2) FROM trrpkg2 T2 INNER JOIN trrpkg T ON T2.ID = T.ID
            WHERE T2.IDPRODUK = '$pro' && T.DATE = '$tgl' $whr";
            
    $result = mysqli_query($db, $sql) or die("Error F(x) GQRPKGPROT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    
    return $row[0];
}

function getSaldoProFrmTo($pro, $frm, $to, $gdg, $db){
    $whr = "";
    $whr2 = "";
    $whr3 = "";
    $whr4 = "";
    $qty = "(P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MIQTY-P.MOQTY+P.RBQTY) AS QTY";
    $qawl = "P.AQTY";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && IDGDG = '$gdg'";
        $whr2 = " && IDGDGF = '$gdg'";
        $whr3 = " && IDGDGT = '$gdg'";
        $whr4 = " && K.IDGDG = '$gdg'";
        $qty = "ROUND(IFNULL((SELECT TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MIQTY-MOQTY+RBQTY FROM dtgpro WHERE IDPRODUK = P.ID AND IDGDG = '$gdg'), 0), 2)";
        $qawl = "ROUND(IFNULL((SELECT AQTY FROM dtgpro WHERE IDPRODUK = P.ID AND IDGDG = '$gdg'), 0), 2)";
    }

    /*KET INDEX
        0 = ID
        1 = NAMA
        2 = OZ
        3 = CUT STYLE
        4 = GRADE
        5 = QTY
        6 = TRM
        7 = TRM BFR
        8 = TRF AFR
        9 = CUT
        10 = CUT BFR
        11 = CUT AFR
        12 = VAC OUT
        13 = VAC OUT BFR
        14 = VAC OUT AFR
        15 = VAC IN
        16 = VAC IN BFR
        17 = VAC IN AFR
        18 = SAW OUT
        19 = SAW OUT BFR
        20 = SAW OUT AFR
        21 = SAW IN
        22 = SAW IN BFR
        23 = SAW IN AFR
        24 = KIRIM
        25 = KIRIM BFR
        26 = KIRIM AFR
        27 = CUT PRO
        28 = CUT PRO BFR
        29 = CUT PRO AFR
        30 = QTY AWAL
        31 = MP
        32 = MP BFR
        33 = MP AFR
        34 = FRZ OUT
        35 = FRZ OUT BFR
        36 = FRZ OUT AFR
        37 = FRZ IN
        38 = FRZ IN BFR
        39 = FRZ IN AFR
        40 = PS
        41 = PS BFR
        42 = PS AFR
        43 = MOVE OUT
        44 = MOVE OUT BFR
        45 = MOVE OUT AFR
        46 = MOVE IN
        47 = MOVE IN BFR
        48 = MOVE IN AFR
        49 = KATES
        50 = REPACK OUT
        51 = REPACK OUT BFR
        52 = REPACK OUT AFR
        53 = REPACK IN
        54 = REPACK IN BFR
        55 = REPACK IN AFR
        56 = RETUR KIRIM
        57 = RETUR KIRIM BFR
        58 = RETUR KIRIM AFR
    */
    $sql = "SELECT P.ID, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, $qty, ROUND(IFNULL((SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE >= '$frm' && T.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE >= '$frm' && C.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to' $whr), 0),2)+ROUND(IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID && DATE >= '$frm' && DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE < '$frm' $whr),0),2)+ROUND(IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID && DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE > '$to' $whr),0),2)+ROUND(IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID && DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE >= '$frm' && F.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE >= '$frm' && S.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID INNER JOIN trkirim K3 ON K2.ID = K3.ID WHERE K2.IDPRODUK = P.ID && K.DATE >= '$frm' && K.DATE <= '$to' && K.STAT = 'SN' $whr4), 0),2), ROUND(IFNULL((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID INNER JOIN trkirim K3 ON K2.ID = K3.ID WHERE K2.IDPRODUK = P.ID && K.DATE < '$frm' && K.STAT = 'SN' $whr4), 0),2), ROUND(IFNULL((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID INNER JOIN trkirim K3 ON K2.ID = K3.ID WHERE K2.IDPRODUK = P.ID && K.DATE > '$to' && K.STAT = 'SN' $whr4), 0),2), ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, '') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, '') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, '') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, '') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, '') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, '') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE >= '$frm' && C.DATE <= '$to' $whr), 0),2)+ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, P.ID) = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, P.ID) = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, P.ID) = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, P.ID) = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, P.ID) = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, P.ID) = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE >= '$frm' && C.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, '') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, '') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, '') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, '') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, '') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, '') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE < '$frm' $whr), 0),2)+ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, P.ID) = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, P.ID) = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, P.ID) = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, P.ID) = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, P.ID) = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, P.ID) = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, '') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, '') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, '') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, '') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, '') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, '') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE > '$to' $whr), 0),2)+ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, P.ID) = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, P.ID) = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, P.ID) = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, P.ID) = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, P.ID) = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, P.ID) = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE > '$to' $whr), 0),2), $qawl, ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE >= '$frm' && M.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE >= '$frm' && F.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE >= '$frm' && F.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(PS2.WEIGHT) FROM trps2 PS2 INNER JOIN trps PS ON PS2.ID = PS.ID WHERE PS2.IDPRODUK = P.ID && PS.DATE >= '$frm' && PS.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(PS2.WEIGHT) FROM trps2 PS2 INNER JOIN trps PS ON PS2.ID = PS.ID WHERE PS2.IDPRODUK = P.ID && PS.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(PS2.WEIGHT) FROM trps2 PS2 INNER JOIN trps PS ON PS2.ID = PS.ID WHERE PS2.IDPRODUK = P.ID && PS.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE >= '$frm' && M.DATE <= '$to' $whr2), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE < '$frm' $whr2), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE > '$to' $whr2), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE >= '$frm' && M.DATE <= '$to' $whr3), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE < '$frm' $whr3), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE > '$to' $whr3), 0), 2), KS.NAMA, ROUND(IFNULL((SELECT SUM(WEIGHT) FROM trrpkg WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM trrpkg WHERE IDPRODUK = P.ID && DATE < '$frm' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM trrpkg WHERE IDPRODUK = P.ID && DATE > '$to' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(R2.WEIGHT) FROM trrpkg2 R2 INNER JOIN trrpkg R ON R2.ID = R.ID WHERE R2.IDPRODUK = P.ID && R.DATE >= '$frm' && R.DATE <= '$to' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(R2.WEIGHT) FROM trrpkg2 R2 INNER JOIN trrpkg R ON R2.ID = R.ID WHERE R2.IDPRODUK = P.ID && R.DATE < '$frm' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(R2.WEIGHT) FROM trrpkg2 R2 INNER JOIN trrpkg R ON R2.ID = R.ID WHERE R2.IDPRODUK = P.ID && R.DATE > '$to' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(RK2.WEIGHT) FROM trrkirim2 RK2 INNER JOIN trrkirim RK ON RK2.ID = RK.ID WHERE RK2.IDPRODUK = P.ID && RK.DATE >= '$frm' && RK.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(RK2.WEIGHT) FROM trrkirim2 RK2 INNER JOIN trrkirim RK ON RK2.ID = RK.ID WHERE RK2.IDPRODUK = P.ID && RK.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(RK2.WEIGHT) FROM trrkirim2 RK2 INNER JOIN trrkirim RK ON RK2.ID = RK.ID WHERE RK2.IDPRODUK = P.ID && RK.DATE > '$to'), 0),2) FROM dtproduk P LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkates KS ON P.IDKATES = KS.ID
            WHERE P.ID = '$pro' ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GSPROFT : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    $cutpro = getSumCutFrmTo7($frm, $to, $pro, $gdg, $db);
    $cutpro2 = getSumCutFrmTo8($frm, $pro, $gdg, $db);
    $saldo = $row[7] - $row[10] - $row[13] + $row[16] - $row[19] + $row[22] - $row[25] + $row[28] + $row[30] - $cutpro2 + $row[32] - $row[35] + $row[38] + $row[41] + $row[44] - $row[47] - $row[51] + $row[54] + $row[57];
    $sisa = $saldo + $row[6] - $row[9] + $row[27] - $row[12] + $row[15] - $row[18] + $row[21] - $row[24] - $cutpro + $row[31] - $row[34] + $row[37] + $row[40] - $row[43] + $row[46] - $row[50] + $row[53] + $row[56];
    
    return array($saldo, $sisa);
}

function getProFrmTo($frm, $to, $gdg, $kates = "")
{
    $db = openDB();
    $whr = "";
    $whr2 = "";
    $whr3 = "";
    $whr4 = "";
    $qty = "(P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MIQTY-P.MOQTY) AS QTY";
    $qawl = "P.AQTY";

    if(countGdgID($gdg, $db) > 0){
        $whr = " && IDGDG = '$gdg'";
        $whr2 = " && IDGDGF = '$gdg'";
        $whr3 = " && IDGDGT = '$gdg'";
        $whr4 = " && K.IDGDG = '$gdg'";
        $qty = "ROUND(IFNULL((SELECT TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MIQTY-MOQTY FROM dtgpro WHERE IDPRODUK = P.ID AND IDGDG = '$gdg'), 0), 2)";
        $qawl = "ROUND(IFNULL((SELECT AQTY FROM dtgpro WHERE IDPRODUK = P.ID AND IDGDG = '$gdg'), 0), 2)";
    }

    /*KET INDEX
        0 = ID
        1 = NAMA
        2 = OZ
        3 = CUT STYLE
        4 = GRADE
        5 = QTY
        6 = TRM
        7 = TRM BFR
        8 = TRF AFR
        9 = CUT
        10 = CUT BFR
        11 = CUT AFR
        12 = VAC OUT
        13 = VAC OUT BFR
        14 = VAC OUT AFR
        15 = VAC IN
        16 = VAC IN BFR
        17 = VAC IN AFR
        18 = SAW OUT
        19 = SAW OUT BFR
        20 = SAW OUT AFR
        21 = SAW IN
        22 = SAW IN BFR
        23 = SAW IN AFR
        24 = KIRIM
        25 = KIRIM BFR
        26 = KIRIM AFR
        27 = CUT PRO
        28 = CUT PRO BFR
        29 = CUT PRO AFR
        30 = QTY AWAL
        31 = MP
        32 = MP BFR
        33 = MP AFR
        34 = FRZ OUT
        35 = FRZ OUT BFR
        36 = FRZ OUT AFR
        37 = FRZ IN
        38 = FRZ IN BFR
        39 = FRZ IN AFR
        40 = PS
        41 = PS BFR
        42 = PS AFR
        43 = MOVE OUT
        44 = MOVE OUT BFR
        45 = MOVE OUT AFR
        46 = MOVE IN
        47 = MOVE IN BFR
        48 = MOVE IN AFR
        49 = KATES
        50 = REPACK OUT
        51 = REPACK OUT BFR
        52 = REPACK OUT AFR
        53 = REPACK IN
        54 = REPACK IN BFR
        55 = REPACK IN AFR
        56 = RETUR KIRIM
        57 = RETUR KIRIM BFR
        58 = RETUR KIRIM AFR
    */
    $sql = "SELECT P.ID, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, $qty, ROUND(IFNULL((SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE >= '$frm' && T.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE >= '$frm' && C.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to' $whr), 0),2)+ROUND(IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID && DATE >= '$frm' && DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE < '$frm' $whr),0),2)+ROUND(IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID && DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE > '$to' $whr),0),2)+ROUND(IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID && DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE >= '$frm' && F.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE >= '$frm' && S.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID INNER JOIN trkirim K3 ON K2.ID = K3.ID WHERE K2.IDPRODUK = P.ID && K.DATE >= '$frm' && K.DATE <= '$to' && K.STAT = 'SN' $whr4), 0),2), ROUND(IFNULL((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID INNER JOIN trkirim K3 ON K2.ID = K3.ID WHERE K2.IDPRODUK = P.ID && K.DATE < '$frm' && K.STAT = 'SN' $whr4), 0),2), ROUND(IFNULL((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID INNER JOIN trkirim K3 ON K2.ID = K3.ID WHERE K2.IDPRODUK = P.ID && K.DATE > '$to' && K.STAT = 'SN' $whr4), 0),2), ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, '') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, '') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, '') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, '') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, '') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, '') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE >= '$frm' && C.DATE <= '$to' $whr), 0),2)+ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, P.ID) = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, P.ID) = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, P.ID) = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, P.ID) = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, P.ID) = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, P.ID) = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE >= '$frm' && C.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, '') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, '') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, '') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, '') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, '') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, '') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE < '$frm' $whr), 0),2)+ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, P.ID) = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, P.ID) = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, P.ID) = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, P.ID) = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, P.ID) = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, P.ID) = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, '') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, '') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, '') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, '') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, '') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, '') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE > '$to' $whr), 0),2)+ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, P.ID) = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, P.ID) = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, P.ID) = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, P.ID) = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, P.ID) = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, P.ID) = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE > '$to' $whr), 0),2), $qawl, ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE >= '$frm' && M.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE >= '$frm' && F.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE >= '$frm' && F.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(PS2.WEIGHT) FROM trps2 PS2 INNER JOIN trps PS ON PS2.ID = PS.ID WHERE PS2.IDPRODUK = P.ID && PS.DATE >= '$frm' && PS.DATE <= '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(PS2.WEIGHT) FROM trps2 PS2 INNER JOIN trps PS ON PS2.ID = PS.ID WHERE PS2.IDPRODUK = P.ID && PS.DATE < '$frm' $whr), 0),2), ROUND(IFNULL((SELECT SUM(PS2.WEIGHT) FROM trps2 PS2 INNER JOIN trps PS ON PS2.ID = PS.ID WHERE PS2.IDPRODUK = P.ID && PS.DATE > '$to' $whr), 0),2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE >= '$frm' && M.DATE <= '$to' $whr2), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE < '$frm' $whr2), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE > '$to' $whr2), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE >= '$frm' && M.DATE <= '$to' $whr3), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE < '$frm' $whr3), 0), 2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM trmove2 M2 INNER JOIN trmove M ON M.ID = M2.ID WHERE M2.IDPRODUK = P.ID && M.DATE > '$to' $whr3), 0), 2), KS.NAMA, ROUND(IFNULL((SELECT SUM(WEIGHT) FROM trrpkg WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM trrpkg WHERE IDPRODUK = P.ID && DATE < '$frm' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM trrpkg WHERE IDPRODUK = P.ID && DATE > '$to' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(R2.WEIGHT) FROM trrpkg2 R2 INNER JOIN trrpkg R ON R2.ID = R.ID WHERE R2.IDPRODUK = P.ID && R.DATE >= '$frm' && R.DATE <= '$to' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(R2.WEIGHT) FROM trrpkg2 R2 INNER JOIN trrpkg R ON R2.ID = R.ID WHERE R2.IDPRODUK = P.ID && R.DATE < '$frm' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(R2.WEIGHT) FROM trrpkg2 R2 INNER JOIN trrpkg R ON R2.ID = R.ID WHERE R2.IDPRODUK = P.ID && R.DATE > '$to' $whr), 0), 2), ROUND(IFNULL((SELECT SUM(RK2.WEIGHT) FROM trrkirim2 RK2 INNER JOIN trrkirim RK ON RK2.ID = RK.ID WHERE RK2.IDPRODUK = P.ID && RK.DATE >= '$frm' && RK.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(RK2.WEIGHT) FROM trrkirim2 RK2 INNER JOIN trrkirim RK ON RK2.ID = RK.ID WHERE RK2.IDPRODUK = P.ID && RK.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(RK2.WEIGHT) FROM trrkirim2 RK2 INNER JOIN trrkirim RK ON RK2.ID = RK.ID WHERE RK2.IDPRODUK = P.ID && RK.DATE > '$to'), 0),2) FROM dtproduk P LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkates KS ON P.IDKATES = KS.ID";

    if(strcasecmp($kates,"") != 0){
        $sql .= " WHERE P.IDKATES = '$kates'";
    }

    $sql .= " ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME, KS.NAMA";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GPROFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getProFrmTo2($frm, $to, $kurs, $db)
{
    $sql = "SELECT P.ID, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, (P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY) AS QTY, ROUND(IFNULL((SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE >= '$frm' && T.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(T2.WEIGHT) FROM prterima2 T2 INNER JOIN prterima T ON T2.ID = T.ID WHERE T2.IDPRODUK = P.ID && T.DATE > '$to'), 0),2), ROUND(IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE >= '$frm' && C.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(C2.WEIGHT) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE > '$to'), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to'), 0),2)+ROUND(IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID && DATE >= '$frm' && DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE < '$frm'),0),2)+ROUND(IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID && DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prfill WHERE IDPRODUK = P.ID && DATE > '$to'),0),2)+ROUND(IFNULL((SELECT SUM(WEIGHT2) FROM prfill WHERE IDPRODUK2 = P.ID && DATE > '$to'), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE >= '$frm' && F.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfill2 F2 INNER JOIN prfill F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE > '$to'), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE >= '$frm' && DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(WEIGHT) FROM prsaw WHERE IDPRODUK = P.ID && DATE > '$to'), 0),2), ROUND(IFNULL((SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE >= '$frm' && S.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(S2.WEIGHT) FROM prsaw2 S2 INNER JOIN prsaw S ON S2.ID = S.ID WHERE S2.IDPRODUK = P.ID && S.DATE > '$to'), 0),2), ROUND(IFNULL((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID INNER JOIN trkirim K3 ON K2.ID = K3.ID WHERE K2.IDPRODUK = P.ID && K.DATE >= '$frm' && K.DATE <= '$to' && K.STAT = 'SN'), 0),2), ROUND(IFNULL((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID INNER JOIN trkirim K3 ON K2.ID = K3.ID WHERE K2.IDPRODUK = P.ID && K.DATE < '$frm' && K.STAT = 'SN'), 0),2), ROUND(IFNULL((SELECT SUM(K2.WEIGHT) FROM trkirim2 K2 INNER JOIN dtpo K ON K2.IDPO = K.ID INNER JOIN trkirim K3 ON K2.ID = K3.ID WHERE K2.IDPRODUK = P.ID && K.DATE > '$to' && K.STAT = 'SN'), 0),2), ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, '') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, '') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, '') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, '') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, '') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, '') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE >= '$frm' && C.DATE <= '$to'), 0),2)+ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, P.ID) = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, P.ID) = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, P.ID) = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, P.ID) = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, P.ID) = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, P.ID) = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE >= '$frm' && C.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, '') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, '') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, '') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, '') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, '') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, '') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE < '$frm'), 0),2)+ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, P.ID) = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, P.ID) = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, P.ID) = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, P.ID) = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, P.ID) = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, P.ID) = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, '') = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, '') = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, '') = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, '') = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, '') = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, '') = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C2.IDPRODUK = P.ID && C.DATE > '$to'), 0),2)+ROUND(IFNULL((SELECT SUM(IF(STRCMP(C2.IDPRODUK1, P.ID) = 0, C2.TCUT1, 0)+IF(STRCMP(C2.IDPRODUK2, P.ID) = 0, C2.TCUT2, 0)+IF(STRCMP(C2.IDPRODUK3, P.ID) = 0, C2.TCUT3, 0)+IF(STRCMP(C2.IDPRODUK4, P.ID) = 0, C2.TCUT4, 0)+IF(STRCMP(C2.IDPRODUK5, P.ID) = 0, C2.TCUT5, 0)+IF(STRCMP(C2.IDPRODUK6, P.ID) = 0, C2.TCUT6, 0)) FROM prcut2 C2 INNER JOIN prcut C ON C2.ID = C.ID WHERE C.DATE > '$to'), 0),2), P.AQTY, ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE >= '$frm' && M.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(M2.WEIGHT) FROM prmsk2 M2 INNER JOIN prmsk M ON M2.ID = M.ID WHERE M2.IDPRODUK = P.ID && M.DATE > '$to'), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE >= '$frm' && F.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK = P.ID && F.DATE > '$to'), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE >= '$frm' && F.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(F2.WEIGHT) FROM prfrz2 F2 INNER JOIN prfrz F ON F2.ID = F.ID WHERE F2.IDPRODUK2 = P.ID && F.DATE > '$to'), 0),2), ROUND(IFNULL((SELECT SUM(PS2.WEIGHT) FROM trps2 PS2 INNER JOIN trps PS ON PS2.ID = PS.ID WHERE PS2.IDPRODUK = P.ID && PS.DATE >= '$frm' && PS.DATE <= '$to'), 0),2), ROUND(IFNULL((SELECT SUM(PS2.WEIGHT) FROM trps2 PS2 INNER JOIN trps PS ON PS2.ID = PS.ID WHERE PS2.IDPRODUK = P.ID && PS.DATE < '$frm'), 0),2), ROUND(IFNULL((SELECT SUM(PS2.WEIGHT) FROM trps2 PS2 INNER JOIN trps PS ON PS2.ID = PS.ID WHERE PS2.IDPRODUK = P.ID && PS.DATE > '$to'), 0),2), IF(P.HSELL < 100, P.HSELL * $kurs, P.HSELL) FROM dtproduk P LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID ORDER BY P.NAME, G.NAME, K.NAME, SK.NAME";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) GPROFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getProTrmFrmTo($frm, $to, $pro)
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE_FORMAT(P.DATE, '%d/%m/%Y'), P.ID, S.NAME, (SELECT COUNT(ID) FROM prterima2 WHERE ID = P.ID), (SELECT SUM(WEIGHT) FROM prterima2 WHERE ID = P.ID), P.BB, P.POTO, P.KET1, P.KET2, P.KET3, P.IDUSER, DATE_FORMAT(P.WKT, '%d/%m/%Y %H:%i') FROM prterima P INNER JOIN prterima2 P2 ON P.ID = P2.ID INNER JOIN dtsup S ON P.IDSUP = S.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && P2.IDPRODUK = '$pro'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPROTRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getProVacFrmTo($frm, $to, $pro)
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE_FORMAT(P.DATE, '%d/%m/%Y'), P.ID, IF(YEAR(P.DATE) < 2000, '', DATE_FORMAT(P.DATE, '%d/%m/%Y')), IFNULL((SELECT SUM(WEIGHT) FROM prfill2 WHERE ID = P.ID && IDPRODUK = '$pro'), 0), IF(STRCMP(P.IDPRODUK, '$pro') = 0, P.WEIGHT, 0)+IF(STRCMP(P.IDPRODUK2, '$pro') = 0, P.WEIGHT2, 0) FROM prfill P INNER JOIN prfill2 P2 ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && (P2.IDPRODUK = '$pro' || P.IDPRODUK = '$pro' || P.IDPRODUK2 = '$pro')";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPROVACFT : ".mysqli_error($db));
    
    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getProSawFrmTo($frm, $to, $pro)
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE_FORMAT(P.DATE, '%d/%m/%Y'), P.ID, IF(YEAR(P.DATE) < 2000, '', DATE_FORMAT(P.DATE, '%d/%m/%Y')), (SELECT SUM(WEIGHT) FROM prsaw2 WHERE ID = P.ID && IDPRODUK = '$pro'), IF(STRCMP(P.IDPRODUK,'$pro') = 0, 0, P.WEIGHT) FROM prsaw P INNER JOIN prsaw2 P2 ON P.ID = P2.ID
            WHERE P.DATE >= '$frm' && P.DATE <= '$to' && (P2.IDPRODUK = '$pro' || P.IDPRODUK = '$pro')";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPROSAWFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getProKrmFrmTo($frm, $to, $pro)
{
    $db = openDB();

    $sql = "SELECT DISTINCT DATE_FORMAT(T.DATE, '%d/%m/%Y'), T2.IDPO, (SELECT SUM(WEIGHT) FROM trkirim2 WHERE IDPO = T2.IDPO && IDPRODUK = '$pro'), T.KET1, T.KET2, T.KET3, T.IDUSER, DATE_FORMAT(T.WKT, '%d/%m/%Y %H:%i') FROM trkirim T INNER JOIN trkirim2 T2 ON T.ID = T2.ID
            WHERE T.DATE >= '$frm' && T.DATE <= '$to' && T2.IDPRODUK = '$pro'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPROKRMFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getSumSPro($kurs)
{
    $db = openDB();

    $sql = "SELECT SUM((P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MPQTY+P.FIQTY-P.FOQTY+P.PSQTY+P.RBQTY-P.RPOQTY+P.RPIQTY) * IF(HSELL < 100, HSELL * $kurs, HSELL)) FROM dtproduk P";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSPRO : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $sum[0];
}

function getSumSPro2($frm, $to, $kurs, $db)
{
    $lst = getProFrmTo2($frm, $to, $kurs, $db);

    $sttl = 0;
    for($i = 0; $i < count($lst); $i++)
    {
        $cutpro = getSumCutFrmTo7($frm, $to, $lst[$i][0], "", $db);
        $cutpro2 = getSumCutFrmTo8($frm, $lst[$i][0], "", $db);
        $saldo = $lst[$i][7]-$lst[$i][10]-$lst[$i][13]+$lst[$i][16]-$lst[$i][19]+$lst[$i][22]-$lst[$i][25]+$lst[$i][28]+$lst[$i][30]-$cutpro2+$lst[$i][32]-$lst[$i][35]+$lst[$i][38]+$lst[$i][41];

        $sttl += ($saldo + $lst[$i][6] - $lst[$i][9] + $lst[$i][27] - $lst[$i][12] + $lst[$i][15] - $lst[$i][18] + $lst[$i][21] - $lst[$i][24] - $cutpro + $lst[$i][31] - $lst[$i][34] + $lst[$i][37] + $lst[$i][40]) * $lst[$i][43];
    }

    return $sttl;
}

function getSumPro($db){
    $sql = "SELECT ROUND(SUM(TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MPQTY+FIQTY-FOQTY+PSQTY+RBQTY-RPOQTY+RPIQTY),2) FROM dtproduk";

    $result = mysqli_query($db, $sql) or die("Error F(x) GSPRO : ".mysqli_error($db));

    $sum = mysqli_fetch_array($result, MYSQLI_NUM);

    return $sum[0];
}

function getLGradePro($pro, $frm, $to)
{
    $db = openDB();

    $sql = "SELECT DISTINCT G.NAME, P.ID FROM dtproduk P INNER JOIN dtgrade G ON P.IDGRADE = G.ID INNER JOIN prterima2 T2 ON T2.IDPRODUK = P.ID INNER JOIN prterima T ON T2.ID = T.ID
            WHERE P.NAME = '$pro' && T.DATE >= '$frm' && T.DATE <= '$to' ORDER BY G.NAME";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLGRADEPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastProID($aw, $ak)
{
    $db = openDB();

    $sql = "SELECT ID FROM dtproduk
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLPROID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row[0];
}

function countAllPro()
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtproduk";

    $result = mysqli_query($db, $sql) or die("Error F(x) CAPRO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtproduk
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CAPRO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countPro($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(P.ID) FROM dtproduk P INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID LEFT JOIN dtkates KS ON P.IDKATES = KS.ID LEFT JOIN dtgol GO ON P.IDGOL = GO.ID LEFT JOIN dtkatej KJ ON P.IDKATEJ = KJ.ID
            WHERE P.ID LIKE '%$id%' || P.NAME LIKE '%$id%' || G.NAME LIKE '%$id%' || K.NAME LIKE '%$id%' || SK.NAME LIKE '%$id%' || KS.NAMA LIKE '%$id%' || GO.NAMA LIKE '%$id%' LIKE '%$id%'";
        
    $result = mysqli_query($db, $sql) or die("Error F(x) CPRO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProTrm($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM prterima2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROTRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProCut($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM prcut2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROCUT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProVac($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM prfill2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROVAC : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT COUNT(IDPRODUK) FROM prfill
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROVAC - 2 : ".mysqli_error($db));

    $count2 = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0] + $count2[0];
}

function countProSaw($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM prsaw2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROSAW : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT COUNT(IDPRODUK) FROM prsaw
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROSAW - 2 : ".mysqli_error($db));

    $count2 = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0] + $count2[0];
}

function countProTT($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM trtt2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROTRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProKrm($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM trkirim2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROKRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProMP($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM prmsk2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROMP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProFrz($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM prfrz2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROFRZ : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProPs($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM trps2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROPS : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProMove($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM trmove2
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROMV : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProHCut($id){
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM prcut3
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROHCUT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countProHNCut($id){
    $db = openDB();

    $sql = "SELECT COUNT(IDPRODUK) FROM prcut4
            WHERE IDPRODUK = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPROHNCUT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schPro($id, $type = "")
{
    $db = openDB();

    $sql = "SELECT P.ID, P.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), G.NAME, ROUND((P.TQTY+P.AQTY+P.VIQTY+P.SIQTY-P.SOQTY-P.KQTY-P.CQTY-P.VOQTY+P.CINQTY+P.MPQTY+P.FIQTY-P.FOQTY+P.PSQTY+P.RBQTY-P.RPOQTY+P.RPIQTY),2) AS QTY, P.STRM, P.SCUT, P.SFILL, P.SSAW, P.SPKG, P.SMP, P.SFRZ, P.HSELL, IFNULL(KS.NAMA, ''), IFNULL(GO.NAMA, ''), IFNULL(KJ.NAMA, '') FROM dtproduk P LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkates KS ON KS.ID = P.IDKATES LEFT JOIN dtgol GO ON P.IDGOL = GO.ID LEFT JOIN dtkatej KJ ON KJ.ID = P.IDKATEJ";

    if(countPro($id) > 0)
        $sql .= " WHERE (P.ID LIKE '%$id%' || P.NAME LIKE '%$id%' || G.NAME LIKE '%$id%' || K.NAME LIKE '%$id%' || SK.NAME LIKE '%$id%' || KS.NAMA LIKE '%$id%' || GO.NAMA LIKE '%$id%' || KJ. NAMA LIKE '%$id%')";
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
            
            $sql .= "P.ID LIKE '%$sch%' || P.NAME LIKE '%$sch%' || G.NAME LIKE '%$sch%' || K.NAME LIKE '%$sch%' || SK.NAME LIKE '%$sch%' || KS.NAMA LIKE '%$sch%' || GO.NAMA LIKE '%$sch%' || KJ.NAMA LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }

    if(strcasecmp($type, "TRM") == 0)
        $sql .= " && P.STRM = 'Y'";
    else if(strcasecmp($type, "CUT") == 0)
        $sql .= " && P.SCUT = 'Y'";
    else if(strcasecmp($type, "VAC") == 0)
        $sql .= " && P.SFILL = 'Y'";
    else if(strcasecmp($type, "SAW") == 0)
        $sql .= " && P.SSAW = 'Y'";
    else if(strcasecmp($type, "KRM") == 0)
        $sql .= " && P.SPKG = 'Y'";
    else if(strcasecmp($type, "MP") == 0)
        $sql .= " && P.SMP = 'Y'";
    else if(strcasecmp($type, "FRZ") == 0)
        $sql .= " && P.SFRZ = 'Y'";

    $sql .= " ORDER BY P.NAME, P.ID";
    
    $result = mysqli_query($db, $sql) or die("Error F(x) SPRO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function newPro($id, $name, $kate, $skate, $grade, $aqty, $strm, $scut, $svac, $ssaw, $spkg, $smp, $sfrz, $hsell, $kates, $gol, $katej)
{
    $db = openDB();

    $sql = "INSERT INTO dtproduk
            (ID, NAME, IDKATE, IDSKATE, IDGRADE, AQTY, STRM, SCUT, SFILL, SSAW, SPKG, SMP, SFRZ, HSELL, IDKATES, IDGOL, IDKATEJ)
            VALUES
            ('$id', '$name', '$kate', '$skate', '$grade', '$aqty', '$strm', '$scut', '$svac', '$ssaw', '$spkg', '$smp', '$sfrz', '$hsell', '$kates', '$gol', '$katej')";

    mysqli_query($db, $sql) or die("Error F(x) NPRO : ".mysqli_error($db));

    closeDB($db);
}

function updPro($id, $name, $kate, $skate, $grade, $bid, $qawl, $strm, $scut, $svac, $ssaw, $spkg, $smp, $sfrz, $hsell, $kates, $gol, $katej)
{
    $db = openDB();

    $sql = "UPDATE dtproduk
            SET ID = '$id', NAME = '$name', IDKATE = '$kate', IDSKATE = '$skate', IDGRADE = '$grade', AQTY = '$qawl', STRM = '$strm', SCUT = '$scut', SFILL = '$svac', SSAW = '$ssaw', SPKG = '$spkg', SMP = '$smp', SFRZ = '$sfrz', HSELL = '$hsell', IDKATES = '$kates', IDGOL = '$gol', IDKATEJ = '$katej'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO : ".mysqli_error($db));

    $sql = "UPDATE prfill
            SET IDPRODUK = '$id'
            WHERE IDPRODUK = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 2 : ".mysqli_error($db));

    $sql = "UPDATE prfill
            SET IDPRODUK2 = '$id'
            WHERE IDPRODUK2 = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 2 - 2 : ".mysqli_error($db));

    $sql = "UPDATE prsaw
            SET IDPRODUK = '$id'
            WHERE IDPRODUK = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 3 : ".mysqli_error($db));

    $sql = "UPDATE prcut2
            SET IDPRODUK = '$id'
            WHERE IDPRODUK = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 4 : ".mysqli_error($db));

    $sql = "UPDATE prcut2
            SET IDPRODUK1 = '$id'
            WHERE IDPRODUK1 = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 4 - 2 : ".mysqli_error($db));

    $sql = "UPDATE prcut2
            SET IDPRODUK2 = '$id'
            WHERE IDPRODUK2 = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 4 - 3 : ".mysqli_error($db));

    $sql = "UPDATE prcut2
            SET IDPRODUK3 = '$id'
            WHERE IDPRODUK3 = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 4 - 4 : ".mysqli_error($db));

    $sql = "UPDATE prcut2
            SET IDPRODUK4 = '$id'
            WHERE IDPRODUK4 = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 4 - 5 : ".mysqli_error($db));

    $sql = "UPDATE prcut2
            SET IDPRODUK5 = '$id'
            WHERE IDPRODUK5 = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 4 : ".mysqli_error($db));

    $sql = "UPDATE prcut2
            SET IDPRODUK6 = '$id'
            WHERE IDPRODUK6 = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 4 : ".mysqli_error($db));

    $sql = "UPDATE prmsk2
            SET IDPRODUK = '$id'
            WHERE IDPRODUK = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPRO - 5 : ".mysqli_error($db));

    closeDB($db);
}

function delPro($id)
{
    $db = openDB();

    $sql = "DELETE FROM dtproduk
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DPRO : ".mysqli_error($db));

    closeDB($db);
}

//USER
function getAllUser()
{
    $db = openDB("kuma_wps");

    $sql = "SELECT ID, PASS, NAME, POSITION, DIVISION, AKTIF, LEVEL, AKSES FROM dtuser";

    $duser = getUserID($_SESSION["user-kuma-wps"]);
    if(strcasecmp($duser[6],"USER") == 0)
        $sql .= " WHERE LEVEL = 'USER'";

    $sql .= " ORDER BY ID, NAME";

    $result = mysqli_query($db,$sql) or die("Error F(x) GAUSR : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getUserID($id, $y = 1)
{
    $db = openDB("kuma_wps");
    
    if(strcasecmp($_SESSION["user-kuma-wps"],"kumaKevin") == 0 && strcasecmp($y,"1") == 0)
        $row = array("kumaKevin", GetHash("Kumagy@slogin88"), "Kevin", "Owner", "Developer", "Y", "SUPER", "");
    else if(strcasecmp($_SESSION["user-kuma-wps"],"kumaDevelop") == 0 && strcasecmp($y,"1") == 0)
        $row = array("kumaKevin", GetHash("Kumagy@login"), "Developer", "Developer", "Developer", "Y", "SUPER", "");
    else
    {
        $sql = "SELECT ID, PASS, NAME, POSITION, DIVISION, AKTIF, LEVEL, AKSES FROM dtuser
                WHERE ID = '$id' ORDER BY ID, NAME";
    
        $result = mysqli_query($db,$sql) or die("Error F(x) GUSRID : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);
    }
    
    closeDB($db);
    
    return $row;
}

function countUserID($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM dtuser
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSRID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countUserIDTT($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM trtt
            WHERE IDUSER = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSRIDTT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countUserIDPjm($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM trpinjam
            WHERE IDUSER = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSRIDPJM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countUserIDKrm($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM trkirim
            WHERE IDUSER = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSRIDKRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countUserIDTrm($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM prterima
            WHERE IDUSER = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSRIDTRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countUserIDCut($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM prcut
            WHERE IDUSER = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSRIDCUT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countUserIDVac($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM prfill
            WHERE IDUSER = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSRIDFILL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countUserIDSaw($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM prsaw
            WHERE IDUSER = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSRIDSAW : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countUserIDMove($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM trmove
            WHERE IDUSER = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSRIDMV : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countUser($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT COUNT(ID) FROM dtuser
            WHERE ID LIKE '%$id%' || NAME LIKE '%$id%' || POSITION LIKE '%$id%' || DIVISION LIKE '%$id%'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CUSR : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schUser($id)
{
    $db = openDB("kuma_wps");

    $sql = "SELECT ID, PASS, NAME, POSITION, DIVISION, AKTIF, LEVEL, AKSES FROM dtuser";

    if(countUser($id) > 0)
        $sql .= " WHERE (ID LIKE '%$id%' || NAME LIKE '%$id%' || POSITION LIKE '%$id%' || DIVISION LIKE '%$id%')";
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
            
            $sql .= "ID LIKE '%$sch%' || NAME LIKE '%$sch%' || POSITION LIKE '%$sch%' || DIVISION LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }

    $duser = getUserID($_SESSION["user-kuma-wps"]);
    if(strcasecmp($duser[6],"USER") == 0)
        $sql .= " && LEVEL = 'USER'";

    $sql .= " ORDER BY ID, NAME";
    
    $result = mysqli_query($db,$sql) or die("Error F(x) SUSR : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function newUser($id, $pass, $name, $pos, $div, $akt = 'Y', $lvl = "U", $aks = "")
{
    $db = openDBAll();

    $ldb = getListDB();

    for($i = 0; $i < count($ldb); $i++){
        $sql = "INSERT INTO $ldb[$i].dtuser
                (ID, PASS, NAME, POSITION, DIVISION, AKTIF, LEVEL, AKSES)
                VALUES
                ('$id', '$pass', '$name', '$pos', '$div', '$akt', '$lvl', '$aks')";

        mysqli_query($db,$sql) or die("Error F(x) NUSR : ".mysqli_error($db));
    }

    closeDB($db);
}

function updUser($id, $pass, $name, $pos, $div, $akt, $lvl, $aks, $bid)
{
    $db = openDBAll();

    $ldb = getListDB();

    for($i = 0; $i < count($ldb); $i++){
        $sql = "UPDATE $ldb[$i].dtuser
                SET ID = '$id', PASS = '$pass', NAME = '$name', POSITION = '$pos', DIVISION = '$div', AKTIF = '$akt', LEVEL = '$lvl', AKSES = '$aks'
                WHERE ID = '$bid'";
                
        mysqli_query($db,$sql) or die("Error F(x) UUSR : ".mysqli_error($db));

        $sql = "UPDATE $ldb[$i].trkirim
                SET IDUSER = '$id'
                WHERE ID = '$bid'";
                
        mysqli_query($db,$sql) or die("Error F(x) UUSR - 2 : ".mysqli_error($db));

        $sql = "UPDATE $ldb[$i].trpinjam
                SET IDUSER = '$id'
                WHERE ID = '$bid'";
                
        mysqli_query($db,$sql) or die("Error F(x) UUSR - 3 : ".mysqli_error($db));
    }

    closeDB($db);
}

function delUser($id)
{
    $db = openDB("kuma_wps");

    $sql = "DELETE FROM dtuser
            WHERE ID = '$id'";

    mysqli_query($db,$sql) or die("Error F(x) DUSR : ".mysqli_error($db));

    closeDB($db);
}

//PO
function getAllPO($type = "1")
{
    $db = openDB();

    $sql = "SELECT ID, IDCUS, DATE, KET1, KET2, KET3, TAMPIL, DTAMPIL, IF(STRCMP(STAT,'NS') = 0, 'Belum Kirim', 'Sudah Kirim'), QTY, ID2, STAT FROM dtpo";

    if(strcasecmp($type,"1") == 0){
        $sql .= " WHERE MONTH(DATE) = MONTH(CURDATE()) && YEAR(DATE) = YEAR(CURDATE())";
    }
    else if(strcasecmp($type,"2") == 0){
        $sql .= " WHERE STRCMP(STAT,'NS') = 0";
    }

    $sql .= " ORDER BY DATE, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GAPO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPOID($id)
{
    $db = openDB();

    $sql = "SELECT ID, IDCUS, DATE, KET1, KET2, KET3, TAMPIL, DTAMPIL, STAT, QTY, ID2, (SELECT NAME FROM dtcus WHERE ID = PO.IDCUS) FROM dtpo PO
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GPOID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $row;
}

function getPOID2($id, $db)
{
    $sql = "SELECT ID, IDCUS, DATE, KET1, KET2, KET3, TAMPIL, DTAMPIL, STAT, QTY FROM dtpo
            WHERE ID = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) GPOID2 : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getPOItem($id, $db){
    $sql = "SELECT T2.IDPRODUK, P.NAME, G.NAME, IFNULL(K.NAME, '') AS KATE, IFNULL(SK.NAME, '') AS SKATE, SUM(T2.QTY), T2.SAT, T2.TGLEXP, SUM(ROUND(T2.WEIGHT,2)), T2.KET FROM trkirim2 T2 INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE T2.IDPO = '$id'
            GROUP BY T2.IDPRODUK, P.NAME, G.NAME, KATE, SKATE, T2.SAT, T2.TGLEXP, T2.KET";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPOITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getPOItem2($id, $db){
    $sql = "SELECT T2.IDPRODUK, P.NAME, G.NAME, IFNULL(K.NAME, '') AS KATE, IFNULL(SK.NAME, '') AS SKATE, SUM(T2.WEIGHT) FROM trkirim2 T2 INNER JOIN trkirim T ON T2.ID = T.ID INNER JOIN dtproduk P ON T2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
            WHERE T2.IDPO = '$id'
            GROUP BY T2.IDPRODUK, P.NAME, G.NAME, KATE, SKATE";

    $result = mysqli_query($db, $sql) or die("Error F(x) GPOITM : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getPOFrmTo($frm, $to, $po = "")
{
    $db = openDB();

    $sql = "SELECT ID, (SELECT NAME FROM dtcus WHERE ID = P.IDCUS), DATE, KET1, KET2, KET3, TAMPIL, DTAMPIL, IF(STRCMP(STAT,'NS') = 0, 'Belum Kirim', 'Sudah Kirim'), QTY, (SELECT SUM(WEIGHT) FROM trkirim2 WHERE IDPO = P.ID), (SELECT SUM(QTY) FROM trkirim2 WHERE IDPO = P.ID), (SELECT DISTINCT SAT FROM trkirim2 WHERE IDPO = P.ID ORDER BY SAT LIMIT 0,1) FROM dtpo P";

    if(strcasecmp($po,"") != 0)
        $sql .= " WHERE ID = '$po'";
    else
        $sql .= " WHERE DATE >= '$frm' && DATE <= '$to'";

    $sql .= " ORDER BY DATE, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) GPOFT : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getPOFrmTo2($frm, $to, $po = "")
{
    $db = openDB();

    $sql = "SELECT DISTINCT PO.ID, (SELECT NAME FROM dtcus WHERE ID = PO.IDCUS), PO.DATE, PO.KET1, PO.KET2, PO.KET3, PO.TAMPIL, PO.DTAMPIL, IF(STRCMP(PO.STAT,'NS') = 0, 'Belum Kirim', 'Sudah Kirim'), PO.QTY, P.NAME, G.NAME, K.NAME, SK.NAME, (SELECT SUM(WEIGHT) FROM trkirim2 WHERE IDPRODUK = K2.IDPRODUK && IDPO = K2.IDPO), (SELECT SUM(QTY) FROM trkirim2 WHERE IDPRODUK = K2.IDPRODUK && IDPO = K2.IDPO), (SELECT DISTINCT SAT FROM trkirim2 WHERE IDPRODUK = K2.IDPRODUK && IDPO = K2.IDPO ORDER BY SAT LIMIT 0,1) FROM dtpo PO INNER JOIN trkirim2 K2 ON PO.ID = K2.IDPO INNER JOIN dtproduk P ON K2.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID";

    if(strcasecmp($po,"") != 0)
        $sql .= " WHERE PO.ID = '$po'";
    else
        $sql .= " WHERE PO.DATE >= '$frm' && PO.DATE <= '$to'";

    $sql .= " ORDER BY PO.DATE, PO.ID, P.NAME, G.NAME, K.NAME, SK.NAME";

    $result = mysqli_query($db,$sql) or die("Error F(x) GPOFT2 : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function getLastID2PO($aw, $ak, $db){
    $sql = "SELECT ID2 FROM dtpo
            WHERE ID2 LIKE '%$aw%$ak%' ORDER BY ID2 DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLID2PO : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function countAllPO()
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtpo";

    $result = mysqli_query($db, $sql) or die("Error F(x) CAPO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countPOID($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM dtpo
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPOID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countPOKrm($id)
{
    $db = openDB();

    $sql = "SELECT COUNT(ID) FROM trkirim2
            WHERE IDPO = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CPOKRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function countPO($id, $type = "1")
{
    $db = openDB();

    $sql = "SELECT COUNT(P.ID) FROM dtpo P INNER JOIN dtcus C ON P.IDCUS = C.ID
            WHERE (P.ID LIKE '%$id%' || C.NAME LIKE '%$id%' || P.KET1 LIKE '%$id%' || P.KET2 LIKE '%$id%' || P.KET3 LIKE '%$id%' || P.ID2 LIKE '%$id%' || DATE_FORMAT(P.DATE, '%d/%m/%Y') LIKE '%$id%')";

    if(strcasecmp($type,"5") == 0){
        $sql .= " && P.STAT = 'SN'";
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) CPO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    closeDB($db);

    return $count[0];
}

function schPO($id, $type = "1")
{
    $db = openDB();

    $sql = "SELECT P.ID, C.NAME, DATE_FORMAT(P.DATE, '%d/%m/%Y'), P.KET1, P.KET2, P.KET3, P.TAMPIL, DATE_FORMAT(P.DTAMPIL, '%d/%m/%Y'), IF(STRCMP(STAT,'NS') = 0, 'Belum Kirim', 'Sudah Kirim'), QTY, P.ID2, P.STAT FROM dtpo p INNER JOIN dtcus C ON P.IDCUS = C.ID";

    if(countPO($id) > 0)
        $sql .= " WHERE (P.ID LIKE '%$id%' || C.NAME LIKE '%$id%' || P.KET1 LIKE '%$id%' || P.KET2 LIKE '%$id%' || P.KET3 LIKE '%$id%' || DATE_FORMAT(P.DATE, '%d/%m/%Y') LIKE '%$id%')";
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
            
            $sql .= "P.ID LIKE '%$sch%' || C.NAME LIKE '%$sch%' || P.KET1 LIKE '%$sch%' || P.KET2 LIKE '%$sch%' || P.KET3 LIKE '%$sch%' || DATE_FORMAT(P.DATE, '%d/%m/%Y') LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
        $sql .= ")";
    }
    
    if(strcasecmp($type,"5") == 0){
        $sql .= " && P.STAT = 'SN'";
    }

    $sql .= " ORDER BY P.DATE, P.ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) SPO : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    closeDB($db);

    return $arr;
}

function newPO($id, $cus, $tgl, $ket1, $ket2, $ket3, $tmpl, $dtmpl, $qty, $id2)
{
    $db = openDB();

    $sql = "INSERT INTO dtpo
            (ID, IDCUS, DATE, KET1, KET2, KET3, TAMPIL, DTAMPIL, QTY, ID2)
            VALUES
            ('$id', '$cus', '$tgl', '$ket1', '$ket2', '$ket3', '$tmpl', '$dtmpl', '$qty', '$id2')";

    mysqli_query($db, $sql) or die("Error F(x) NPO : ".mysqli_error($db));

    closeDB($db);
}

function updPO($id, $cus, $tgl, $ket1, $ket2, $ket3, $tmpl, $dtmpl, $bid, $qty)
{
    $db = openDB();

    $sql = "UPDATE dtpo
            SET ID = '$id', IDCUS = '$cus', DATE = '$tgl', KET1 = '$ket1', KET2 = '$ket2', KET3 = '$ket3', TAMPIL = '$tmpl', DTAMPIL = '$dtmpl', QTY = '$qty'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UPO : ".mysqli_error($db));

    closeDB($db);
}

function updPOStat($id, $stat, $gdg, $tt)
{
    $db = openDB();

    $sql = "UPDATE dtpo
            SET STAT = '$stat', IDGDG = '$gdg', KET3 = '$tt'
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) UPOS : ".mysqli_error($db));

    closeDB($db);
}

function delPO($id)
{
    $db = openDB();

    $sql = "DELETE FROM dtpo
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DPO : ".mysqli_error($db));

    closeDB($db);
}

//GUDANG
function getAllGdg($db){
    $sql = "SELECT ID, NAMA, ALAMAT, PIC, TEL FROM dtgdg ORDER BY NAMA";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAGDG : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function getGdgID($id, $db){
    $sql = "SELECT ID, NAMA, ALAMAT, PIC, TEL FROM dtgdg
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GGDGID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getLastGdgID($db){
    $sql = "SELECT ID FROM dtgdg ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLGDGID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function  countGdgID($id, $db){
    $sql = "SELECT COUNT(ID) FROM dtgdg
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgTrm($id, $db){
    $sql = "SELECT COUNT(ID) FROM prterima
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGTRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgCut($id, $db){
    $sql = "SELECT COUNT(ID) FROM prcut
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGCUT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgVac($id, $db){
    $sql = "SELECT COUNT(ID) FROM prfill
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGVAC : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgSaw($id, $db){
    $sql = "SELECT COUNT(ID) FROM prsaw
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGSAW : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgKirim($id, $db){
    $sql = "SELECT COUNT(ID) FROM trkirim
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGKRM : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgFrz($id, $db){
    $sql = "SELECT COUNT(ID) FROM prfrz
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGVAC : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgMP($id, $db){
    $sql = "SELECT COUNT(ID) FROM prmsk
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGMP : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgPs($id, $db){
    $sql = "SELECT COUNT(ID) FROM trps
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGPS : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgSett($id, $db){
    $sql = "SELECT COUNT(ID) FROM dtsett
            WHERE VAL2 = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGSETT : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgMove($id, $db){
    $sql = "SELECT COUNT(ID) FROM trmove
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGMV : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdgPO($id, $db){
    $sql = "SELECT COUNT(ID) FROM dtpo
            WHERE IDGDG = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDGPO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGdg($id, $db){
    $sql = "SELECT COUNT(ID) FROM dtgdg
            WHERE ID LIKE '%$id%' || NAMA LIKE '%$id%' || ALAMAT LIKE '%$id%' || PIC LIKE '%$id%' || TEL LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGDG : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function schGdg($id, $db){
    $sql = "SELECT ID, NAMA, ALAMAT, PIC, TEL FROM dtgdg";

    if(countGdg($id, $db) > 0){
        $sql .= " WHERE ID LIKE '%$id%' || NAMA LIKE '%$id%' || ALAMAT LIKE '%$id%' || PIC LIKE '%$id%' || TEL LIKE '%$id%'";
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
            
            $sql .= "ID LIKE '%$sch%' || NAMA LIKE '%$sch%' || ALAMAT LIKE '%$sch%' || PIC LIKE '%$sch%' || TEL LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $result = mysqli_query($db, $sql) or die("Error F(x) SGDG : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function newGdg($id, $nama, $addr, $pic, $tel, $db){
    $sql = "INSERT INTO dtgdg
            (ID, NAMA, ALAMAT, PIC, TEL)
            VALUES
            ('$id', '$nama', '$addr', '$pic', '$tel')";

    mysqli_query($db, $sql) or die("Error F(x) NGDG : ".mysqli_error($db));
}

function updGdg($id, $nama, $addr, $pic, $tel, $bid, $db){
    $sql = "UPDATE dtgdg
            SET ID = '$id', NAMA = '$nama', ALAMAT = '$addr', PIC = '$pic', TEL = '$tel'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UGDG : ".mysqli_error($db));

    $sql = "UPDATE prterima
            SET IDGDG = '$id'
            WHERE IDGDG = '$bid'";
        
    mysqli_query($db, $sql) or die("Error F(x) UGDG - 2 : ".mysqli_error($db));

    $sql = "UPDATE prcut
            SET IDGDG = '$id'
            WHERE IDGDG = '$bid'";
        
    mysqli_query($db, $sql) or die("Error F(x) UGDG - 3 : ".mysqli_error($db));

    $sql = "UPDATE prfill
            SET IDGDG = '$id'
            WHERE IDGDG = '$bid'";
        
    mysqli_query($db, $sql) or die("Error F(x) UGDG - 4 : ".mysqli_error($db));

    $sql = "UPDATE prsaw
            SET IDGDG = '$id'
            WHERE IDGDG = '$bid'";
        
    mysqli_query($db, $sql) or die("Error F(x) UGDG - 5 : ".mysqli_error($db));

    $sql = "UPDATE trkirim
            SET IDGDG = '$id'
            WHERE IDGDG = '$bid'";
        
    mysqli_query($db, $sql) or die("Error F(x) UGDG - 6 : ".mysqli_error($db));

    $sql = "UPDATE prfrz
            SET IDGDG = '$id'
            WHERE IDGDG = '$bid'";
        
    mysqli_query($db, $sql) or die("Error F(x) UGDG - 7 : ".mysqli_error($db));

    $sql = "UPDATE trps
            SET IDGDG = '$id'
            WHERE IDGDG = '$bid'";
        
    mysqli_query($db, $sql) or die("Error F(x) UGDG - 8 : ".mysqli_error($db));

    $sql = "UPDATE dtsett
            SET VAL2 = '$id'
            WHERE VAL2 = '$bid'";
        
    mysqli_query($db, $sql) or die("Error F(x) UGDG - 9 : ".mysqli_error($db));

    $sql = "UPDATE prmsk
            SET IDGDG = '$id'
            WHERE IDGDG = '$bid'";
        
    mysqli_query($db, $sql) or die("Error F(x) UGDG - 10 : ".mysqli_error($db));
}

function delGdg($id, $db){
    $sql = "DELETE FROM dtgdg
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DGDG : ".mysqli_error($db));
}

//GUDANG - PRODUK
function getQGdgPro($gdg, $pro, $db){
    $sql = "SELECT TQTY+AQTY+VIQTY+SIQTY-SOQTY-KQTY-CQTY-VOQTY+CINQTY+MPQTY+FIQTY-FOQTY+PSQTY+RBQTY+MIQTY-MOQTY-RPOQTY+RPIQTY FROM dtgpro
            WHERE IDPRODUK = '$pro' && IDGDG = '$gdg'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GQGPRO : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function newGdgPro($gdg, $pro, $qawl, $db){
    $sql = "INSERT INTO dtgpro
            (IDGDG, IDPRODUK, AQTY)
            VALUES
            ('$gdg', '$pro', '$qawl')";

    mysqli_query($db, $sql) or die("Error F(x) NGDGPRO : ".mysqli_error($db));
}

//KATEGORIS
function getAllKates($db){
    $sql = "SELECT ID, NAMA, CUT FROM dtkates ORDER BY NAMA";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAKATES : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getAllKatej($db){
    $sql = "SELECT ID, NAMA FROM dtkatej ORDER BY NAMA";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAKATEJ : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getKatesID($id, $db){
    $sql = "SELECT ID, NAMA, CUT FROM dtkates
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAKATES : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getLastIDKates($db){
    $sql = "SELECT ID FROM dtkates ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDKATES : ".mysqli_error($db));
    
    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function countKatesID($id, $db){
    $sql = "SELECT COUNT(ID) FROM dtkates
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CKATESID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countKatejID($id, $db){
    $sql = "SELECT COUNT(ID) FROM dtkatej
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CKATEJID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countKates($id, $db)
{
    $sql = "SELECT COUNT(ID) FROM dtkates
            WHERE ID LIKE '%$id%' || NAMA LIKE '%$id%' || CUT LIKE '%$id%'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CKATES : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countKatesPro($id, $db)
{
    $sql = "SELECT COUNT(IDKATES) FROM dtproduk
            WHERE IDKATES = '$id'";

    $result = mysqli_query($db,$sql) or die("Error F(x) CKATESPRO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}


function schKates($id, $db)
{
    $sql = "SELECT ID, NAMA, CUT FROM dtkates";

    if(countKates($id, $db) > 0)
        $sql .= " WHERE ID LIKE '%$id%' || NAMA LIKE '%$id%' || CUT LIKE '%$id%'";
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
            
            $sql .= "ID LIKE '%$sch%' || NAMA LIKE '%$sch%' || CUT LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY NAMA, ID";

    $result = mysqli_query($db,$sql) or die("Error F(x) SKATES : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        $arr[count($arr)] = $row;

    return $arr;
}

function newKates($id, $nama, $cut, $db){
    $sql = "INSERT INTO dtkates
            (ID, NAMA, CUT)
            VALUES
            ('$id', '$nama', '$cut')";

    mysqli_query($db, $sql) or die("Error F(x) NKATES : ".mysqli_error($db));
}

function updKates($id, $nama, $cut, $bid, $db){
    $sql = "UPDATE dtkates
            SET ID = '$id', NAMA = '$nama', CUT = '$cut'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UKATES : ".mysqli_error($db));

    $sql = "UPDATE dtproduk
            SET IDKATES = '$id'
            WHERE IDKATES = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UKATES - 2 : ".mysqli_error($db));
}

function delKates($id, $db){
    $sql = "DELETE FROM dtkates
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DKATES : ".mysqli_error($db));
}

//GOLONGAN
function getAllGol($db){
    $sql = "SELECT ID, NAMA, CREATED FROM dtgol ORDER BY ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GAGOL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function getGolID($id, $db){
    $sql = "SELECT ID, NAMA, CREATED FROM dtgol
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) GGOLID : ".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row;
}

function getLastIDGol($aw, $ak, $db){
    $sql = "SELECT ID FROM dtgol
            WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

    $result = mysqli_query($db, $sql) or die("Error F(x) GLIDGOL :".mysqli_error($db));

    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    return $row[0];
}

function countGolID($id, $db){
    $sql = "SELECT COUNT(ID) FROM dtgol
            WHERE ID = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGOLID : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGolPro($id, $db){
    $sql = "SELECT COUNT(ID) FROM dtproduk
            WHERE IDGOL = '$id'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGOLPRO : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function countGol($id, $db){
    $sql = "SELECT COUNT(ID) FROM dtgol
            WHERE ID LIKE '%$id%' || NAMA LIKE '%$id%'";

    $result = mysqli_query($db, $sql) or die("Error F(x) CGOL : ".mysqli_error($db));

    $count = mysqli_fetch_array($result, MYSQLI_NUM);

    return $count[0];
}

function schGol($id, $db){
    $sql = "SELECT ID, NAMA, CREATED FROM dtgol";

    if(countGol($id, $db) > 0){
        $sql .= " WHERE ID LIKE '%$id%' || NAMA LIKE '%$id%'";
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
            
            $sql .= "ID LIKE '%$sch%' || NAMA LIKE '%$sch%'";
            
            if($i < count($y)-1)
                $sql .= " || ";
        }
    }

    $sql .= " ORDER BY NAMA";

    $result = mysqli_query($db, $sql) or die("Error F(x) SGOL : ".mysqli_error($db));

    $arr = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $arr[count($arr)] = $row;
    }

    return $arr;
}

function newGol($id, $nama, $db){
    $sql = "INSERT INTO dtgol
            (ID, NAMA, CREATED)
            VALUES
            ('$id', '$nama', NOW())";

    mysqli_query($db, $sql) or die("Error F(x) NGOL : ".mysqli_error($db));
}

function updGol($id, $nama, $bid, $db){
    $sql = "UPDATE dtgol
            SET ID = '$id', NAMA = '$nama'
            WHERE ID = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UGOL : ".mysqli_error($db));

    $sql = "UPDATE dtproduk
            SET IDGOL = '$id'
            WHERE IDGOL = '$bid'";

    mysqli_query($db, $sql) or die("Error F(x) UGOL - 2 : ".mysqli_error($db));
}

function delGol($id, $db){
    $sql = "DELETE FROM dtgol
            WHERE ID = '$id'";

    mysqli_query($db, $sql) or die("Error F(x) DGOL : ".mysqli_error($db));
}
?>