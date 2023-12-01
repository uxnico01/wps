<?php
    //V.1.0.0
    $result = array(); 
    $combination = array();
    session_start();
    error_reporting(0);
    //error_reporting(E_ERROR);
    date_default_timezone_set("Asia/Jakarta");
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    if(file_exists('../vendor/composer/autoload.php'))
        include('../vendor/composer/autoload.php');

    if(file_exists("../vendor/tcpdf/tcpdf.php"))
        require("../vendor/tcpdf/tcpdf.php");

    if(file_exists("./bin/vendor/tcpdf/tcpdf.php"))
        require("./bin/vendor/tcpdf/tcpdf.php");

    if(file_exists('../vendor/PHPMailer/src/Exception.php'))
        include('../vendor/PHPMailer/src/Exception.php');

    if(file_exists('../vendor/PHPMailer/src/PHPMailer.php'))
        include('../vendor/PHPMailer/src/PHPMailer.php');

    if(file_exists('../vendor/PHPMailer/src/SMTP.php'))
        include('../vendor/PHPMailer/src/SMTP.php');

    if(file_exists('./func-data.php'))
        require('./func-data.php');
    else if(file_exists('./bin/php/func-data.php'))
        require('./bin/php/func-data.php');
    else if(file_exists('../bin/php/func-data.php'))
        require('../bin/php/func-data.php');

    if(file_exists('./func-tran.php'))
        require('./func-tran.php');
    else if(file_exists('./bin/php/func-tran.php'))
        require('./bin/php/func-tran.php');
    else if(file_exists('../bin/php/func-tran.php'))
        require('../bin/php/func-tran.php');

    if(file_exists('./func-proc.php'))
        require('./func-proc.php');
    else if(file_exists('./bin/php/func-proc.php'))
        require('./bin/php/func-proc.php');
    else if(file_exists('../bin/php/func-proc.php'))
        require('../bin/php/func-proc.php');

    if(file_exists('./func-oth.php'))
        require('./func-oth.php');
    else if(file_exists('./bin/php/func-oth.php'))
        require('./bin/php/func-oth.php');
    else if(file_exists('../bin/php/func-oth.php'))
        require('../bin/php/func-oth.php');

    function openDB($dbs = "")
    {
        if(isset($_SESSION["kuma-db"]) && strcasecmp($dbs,"") == 0)
            $dbs = $_SESSION["kuma-db"];
        else if(strcasecmp($dbs,"") == 0)
            $dbs = "kuma_wps";
            
        return mysqli_connect("localhost","root","",$dbs);
    }

    function openDBAll()
    {
        return mysqli_connect("localhost","root","");
    }

    function openDB2()
    {
        return mysqli_connect("192.168.1.8","wps_Admin","WPS@db", "kuma_wps");
    }

    function closeDB($db)
    {
        mysqli_close($db);
    }

    function viewHarga()
    {
        return false;
    }

    function links()
    {
        return "../../";
    }

    function domain()
    {
        return "";
    }

    function ext()
    {
        return "";
    }

    function toHome()
    {
        header("Location: ./home");
    }

    function isLogin()
    {
        if(isset($_SESSION["user-kuma-wps"]))
            header("Location: ./home");
    }

    function isLogOut()
    {
        if(!isset($_SESSION["user-kuma-wps"]))
            header("Location: ./login?exp=1");
    }

    function setID($x, $len)
    {
        if($len == null || $len == 0 || strcasecmp($len,"") == 0)
            $len = 3;
        
        for($i = strlen($x); $i < $len; $i++)
            $x = "0".$x;
        
        return $x;
    }

    function getAllDateMonth()
    {
        $arr = array();
        
        for($i = 1; $i <= date('j'); $i++)
        {
            //if(date('N', strtotime(date('Y-m-'.$i))) == 7)
                //continue;
                
            $arr[count($arr)] = $i;
        }
        
        return $arr;
    }

    function genKode($len = 10)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $clen = strlen($chars);
        $result = '';
        for ($i = 0; $i < $len; $i++)
            $result .= $chars[rand(0, $clen - 1)];
        
        return $result;
    }

    function getHash($x)
    {
        return password_hash($x, PASSWORD_BCRYPT);
    }

    function cekHash($x,$y)
    {
        return password_verify($x, $y);
    }

    function UE64($x)
    {
        $y = explode("=",$x);
        
        if(count($y) > 1)
            $x = $y[1];
        else
            $x = $y[0];
        
        return strtr(base64_encode($x), '+/=', '._-');
    }

    function UD64($x)
    {
        return base64_decode(strtr($x, '._-', '+/='));
    }

    function isDecimal($x)
    {
        return fmod($x, 1) !== 0.00;
    }

    function getRandMinMax($min, $max)
    {
        return number_format(mt_rand($min, $max) + mt_rand() / mt_getrandmax(),2,'.','');
    }

    function getRandMinMax2($min, $max)
    {
        return number_format((mt_rand($min, $max) + mt_rand() / mt_getrandmax())/10,2,'.','');
    }

    function getJulianDate($x)
    {
        $jd = 0;

        $m = date('m', strtotime($x));

        for($i = 1; $i < $m; $i++)
            $jd += date('t', strtotime(date('Y', strtotime($x))."-".$i."-01"));

        $jd += date('d', strtotime($x));

        return $jd;
    }
    
    function combinations(array $myArray, $choose) {
        global $result, $combination;
      
        $n = count($myArray);
        
        inner(0, $choose, $myArray, $n);
        
        return $result;
    }
    
    function inner ($start, $choose_, $arr, $n) {
        global $result, $combination;
    
        if ($choose_ == 0)
            array_push($result,$combination);
        else
            for ($i = $start; $i <= $n - $choose_; ++$i) {
                array_push($combination, $arr[$i]);
                inner($i + 1, $choose_ - 1, $arr, $n);
                array_pop($combination);
            }
    }

    function getListDB()
    {
        $db = openDBAll();

        $sql = "SELECT schema_name FROM information_schema.schemata
                WHERE schema_name LIKE 'kuma_wps%' ORDER BY schema_name";

        $result = mysqli_query($db, $sql) or die("Error F(x) GLDB : ".mysqli_error($db));

        $arr = array();
        while($row = mysqli_fetch_Array($result, MYSQLI_NUM))
            $arr[count($arr)] = $row[0];

        closeDB($db);

        return $arr;
    }
    
    function dataKata($x) 
    {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x < 12)
            $temp = " ". $angka[$x];
        else if ($x < 20)
            $temp = dataKata($x - 10). " belas";
        else if ($x < 100)
            $temp = dataKata($x/10)." puluh". dataKata($x % 10);
        else if ($x < 200)
            $temp = " seratus" . dataKata($x - 100);
        else if ($x < 1000)
            $temp = dataKata($x/100) . " ratus" . dataKata($x % 100);
        else if ($x < 2000)
            $temp = " seribu" . dataKata($x - 1000);
        else if ($x < 1000000)
            $temp = dataKata($x/1000) . " ribu" . dataKata($x % 1000);
        else if ($x < 1000000000)
            $temp = dataKata($x/1000000) . " juta" . dataKata($x % 1000000);
        else if ($x < 1000000000000)
            $temp = dataKata($x/1000000000) . " milyar" . dataKata(fmod($x,1000000000));
        else if ($x < 1000000000000000)
            $temp = dataKata($x/1000000000000) . " trilyun" . dataKata(fmod($x,1000000000000));
        
        return $temp;
    }

    function terbilang($x, $style=4) 
    {
        if($x < 0)
            $hasil = "minus ". trim(dataKata($x));
        else 
            $hasil = trim(dataKata($x));
        switch ($style) 
        {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }     
        return $hasil;
    }

    function getNmMonth($x)
    {
        $arr = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return $arr[$x-1];
    }

    function cekAksUser($aks, $type = "1")
    {
        $user = getUserID($_SESSION["user-kuma-wps"]);
        
        if(strcasecmp($user[6],"OWNER") == 0 || (strcasecmp($user[6],"SUPERVISOR") == 0 && strcasecmp($type,"1") == 0) || strcasecmp($user[6],"SUPER") == 0)
            return true;
        
        for($i = 0; $i < strlen($aks); $i++)
        {
            if(strcasecmp($aks[$i],"1") == 0)
                return true;
        }
        
        return false;
    }

    //SETTING
    function getAllSett($id, $db){
        $sql = "SELECT ID, VAL2 FROM dtsett
                WHERE ID LIKE '%$id%' && VAL2 != ''";

        $result = mysqli_query($db, $sql) or die("Error F(x) GASETT : ".mysqli_error($db));

        $arr = array();
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            $arr[count($arr)] = $row;
        }

        return $arr;
    }

    function getSett()
    {
        $db = openDB();

        $arr = array();
        $sql = "SELECT ID, TYPE, VAL, VAL2 FROM dtsett
                WHERE ID = 'MGCUT'";

        $result = mysqli_query($db, $sql) or die("Error F(x) GSETT : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $arr[count($arr)] = $row;

        $sql = "SELECT ID, TYPE, VAL, VAL2 FROM dtsett
                WHERE ID = 'MGVAC'";

        $result = mysqli_query($db, $sql) or die("Error F(x) GSETT - 3 : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $arr[count($arr)] = $row;

        $sql = "SELECT ID, TYPE, VAL, VAL2 FROM dtsett
                WHERE ID = 'MGSAW'";

        $result = mysqli_query($db, $sql) or die("Error F(x) GSETT - 2 : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $arr[count($arr)] = $row;

        $sql = "SELECT ID, TYPE, VAL, VAL2 FROM dtsett
                WHERE ID = 'DFGDG'";

        $result = mysqli_query($db, $sql) or die("Error F(x) GSETT - 3 : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $arr[count($arr)] = $row;

        $sql = "SELECT ID, TYPE, VAL, VAL2 FROM dtsett
                WHERE ID = 'DFKGDG'";

        $result = mysqli_query($db, $sql) or die("Error F(x) GSETT - 4 : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $arr[count($arr)] = $row;

        $sql = "SELECT ID, TYPE, VAL, VAL2 FROM dtsett
                WHERE ID = 'PHCUT'";

        $result = mysqli_query($db, $sql) or die("Error F(x) GSETT - 5 : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $arr[count($arr)] = $row;

        $sql = "SELECT ID, TYPE, VAL, VAL2 FROM dtsett
                WHERE ID = 'PHTTL'";

        $result = mysqli_query($db, $sql) or die("Error F(x) GSETT - 6 : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $arr[count($arr)] = $row;

        $sql = "SELECT ID, TYPE, VAL, VAL2 FROM dtsett
                WHERE ID = 'PHTLG'";

        $result = mysqli_query($db, $sql) or die("Error F(x) GSETT - 7 : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $arr[count($arr)] = $row;

        closeDB($db);

        return $arr;
    }
    
    function getEmptySetLike($id, $db){
        $sql = "SELECT ID FROM dtsett
                WHERE ID LIKE '%$id%' && VAL2 = '' ORDER BY ID ASC";

        $result = mysqli_query($db, $sql) or die("Error F(x) GESETL : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        return $row[0];
    }

    function getLastIDSet($id, $db){
        $sql = "SELECT ID FROM dtsett
                WHERE ID LIKE '%$id%' ORDER BY ID DESC";
        
        $result = mysqli_query($db, $sql) or die("Error F(x) GLIDSET : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        return $row[0];
    }

    function countEmptySetLike($id, $db){
        $sql = "SELECT COUNT(ID) FROM dtsett
                WHERE ID LIKE '%$id%' && VAL2 = ''";

        $result = mysqli_query($db, $sql) or die("Error F(x) CESETL : ".mysqli_error($db));

        $count = mysqli_fetch_array($result, MYSQLI_NUM);

        return $count[0];
    }

    function newSettID($id, $val1, $val2, $db){
        $sql = "INSERT INTO dtsett
                (ID, VAL, VAL2)
                VALUES
                ('$id', '$val1', '$val2')";

        mysqli_query($db, $sql) or die("Error F(x) NSETTID : ".mysqli_error($db));
    }

    function updSett($smcut, $vmcut, $smvac, $vmvac, $smsaw, $vmsaw, $dfgdg, $dfkgdg, $phcut, $phttl, $phtlg)
    {
        $db = openDB();

        $sql = "UPDATE dtsett
                SET TYPE = '$smcut', VAL = '$vmcut'
                WHERE ID = 'MGCUT'";

        mysqli_query($db, $sql) or die("Error F(x) USETT : ".mysqli_error($db));

        $sql = "UPDATE dtsett
                SET TYPE = '$smvac', VAL = '$vmvac'
                WHERE ID = 'MGVAC'";

        mysqli_query($db, $sql) or die("Error F(x) USETT - 2 : ".mysqli_error($db));

        $sql = "UPDATE dtsett
                SET TYPE = '$smsaw', VAL = '$vmsaw'
                WHERE ID = 'MGSAW'";

        mysqli_query($db, $sql) or die("Error F(x) USETT - 3 : ".mysqli_error($db));

        $sql = "UPDATE dtsett
                SET VAL2 = '$dfgdg'
                WHERE ID = 'DFGDG'";

        mysqli_query($db, $sql) or die("Error F(x) USETT - 4 : ".mysqli_error($db));

        $sql = "UPDATE dtsett
                SET VAL2 = '$dfkgdg'
                WHERE ID = 'DFKGDG'";

        mysqli_query($db, $sql) or die("Error F(x) USETT - 5 : ".mysqli_error($db));

        $sql = "UPDATE dtsett
                SET VAL = '$phcut'
                WHERE ID = 'PHCUT'";

        mysqli_query($db, $sql) or die("Error F(x) USETT - 6 : ".mysqli_error($db));

        $sql = "UPDATE dtsett
                SET VAL = '$phttl'
                WHERE ID = 'PHTTL'";

        mysqli_query($db, $sql) or die("Error F(x) USETT - 7 : ".mysqli_error($db));

        $sql = "UPDATE dtsett
                SET VAL = '$phtlg'
                WHERE ID = 'PHTLG'";

        mysqli_query($db, $sql) or die("Error F(x) USETT - 8 : ".mysqli_error($db));

        closeDB($db);
    }

    function updSettID($id, $val1, $val2, $db){
        $sql = "UPDATE dtsett
                SET VAL = '$val1', VAL2 = '$val2'
                WHERE ID = '$id'";

        mysqli_query($db, $sql) or die("Error F(x) USETTID : ".mysqli_error($db));
    }

    function repairPjm(){
        $db = openDB();

        $sql = "SELECT DISTINCT IDSUP, (SELECT SUM(POTO) FROM prterima WHERE IDSUP = P.IDSUP) FROM prterima P ORDER BY IDSUP, DATE";

        $result = mysqli_query($db, $sql) or die("Error F(x) RPJM : ".mysqli_error($db));

        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            $sql = "UPDATE trpinjam
                    SET XJLH = 0
                    WHERE IDSUP = '$row[0]'";
    
            mysqli_query($db, $sql) or die("Error F(x) RPJM - 1 : ".mysqli_error($db));

            $sql = "SELECT ID, JLH-POT FROM trpinjam
                    WHERE IDSUP = '$row[0]' ORDER BY DATE";

            $result2 = mysqli_query($db, $sql) or die("Error F(x) RPJM - 2 : ".mysqli_error($db));

            while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
            {
                $xjlh = $row[1];
                if($row[1] > $row2[1])
                    $xjlh = $row2[1];

                $sql = "UPDATE trpinjam
                        SET XJLH = $xjlh
                        WHERE ID = '$row2[0]'";
                        
                mysqli_query($db, $sql) or die("Error F(x) RPJM - 3 : ".mysqli_error($db));

                $row[1] -= $row2[1];

                if($row[1] < 0)
                    break;   
            }
        }

        closeDB($db);
    }

    function repairStk($db){
        updQtyProTrm2($db);
        updQtyProCut_2($db);
        updQtyProCut2_2($db);
        updQtyProVac2($db);
        updQtyProSaw2($db);
        updQtyProRPkg($db);
        updQtyProKirim2($db);
        updQtyProMP2($db);
        updQtyProFrz2($db);

        updQtyProRKirim($db);
        updQtyProMove($db);
        updQtyProPs2($db);
    }

    function saveTBuku($dstk, $dpjm, $dsmpn)
    {
        $db1 = "kuma_wps";
        $db2 = "kuma_wps_".date('M_Y');
        unset($_SESSION["kuma-db"]);
        unset($_SESSION["kuma-db-nm"]);

        $db = openDB();
        $dba = openDBAll();
        $ltbl = array("dtcus", "dtgrade", "dthsup", "dtkate", "dtproduk", "dtpsup", "dtsat", "dtsett", "dtskate", "dtsup", "dtuser");

        //REPAIR
        repairStk($db);
        repairPjm();

        //CEK DB2 NAME
        $cek = false;
        $n = 1;
        while(!$cek)
        {
            $sql = "SELECT COUNT(schema_name) FROM information_schema.schemata
                    WHERE schema_name LIKE '$db2%'";

            $result = mysqli_query($dba, $sql) or die("Error F(x) STBUKU : ".mysqli_error($db));

            $count = mysqli_fetch_array($result, MYSQLI_NUM);

            if($count[0] > 0)
            {
                $n++;
                $db2 = "kuma_wps_".date('M_Y')."_".$n;
            }
            else
                $cek = true;
        }

        //CREATE DATABASE
        $sql = "CREATE DATABASE $db2";

        mysqli_query($dba, $sql) or die("Error F(x) STBUKU - 2 : ".mysqli_error($db));

        //DISABLE FOREIGN KEY CHECK
        $sql = "SET FOREIGN_KEY_CHECKS=0";

        mysqli_query($db, $sql) or die("Error F(x) STBUKU - 2 - 1 : ".mysqli_error($db));

        //TABLES
        $sql = "SHOW TABLES";

        $result = mysqli_query($db, $sql) or die("Error F(x) STBUKU - 3 : ".mysqli_error($db));

        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            $sql = "CREATE TABLE $db2.$row[0]
                    LIKE $db1.$row[0]";

            mysqli_query($dba, $sql) or die("Error F(x) STBUKU - 4 : ".mysqli_error($dba));

            $sql = "INSERT INTO $db2.$row[0]
                    SELECT * FROM $db1.$row[0]";

            mysqli_query($dba, $sql) or die("Error F(x) STBUKU - 5 : ".mysqli_error($dba));

            $cek = false;
            for($i = 0; $i < count($ltbl); $i++)
            {
                if(strcasecmp($row[0], $ltbl[$i]) == 0)
                {
                    $cek = true;
                    break;
                }
            }

            if(!$cek)
            {
                $sql = "TRUNCATE $row[0]";

                mysqli_query($db, $sql) or die("Error F(x) STBUKU - 6 : ".mysqli_error($db));
            }
        }

        //UPDATE FOREIGN KEY
        $sql = "SELECT CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = '$db1' && REFERENCED_TABLE_NAME IS NOT NULL";

        $result = mysqli_query($dba, $sql) or die("Error F(x) STBUKU - 6 - 1 : ".mysqli_error($dba));
        
        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            $stat = "UPDATE CASCADE ON DELETE CASCADE";

            if(strcasecmp(substr($row[3],0,2),"dt") == 0)
                $stat = "UPDATE CASCADE ON DELETE RESTRICT";

            $sql = "ALTER TABLE $db2.$row[1]
                    ADD CONSTRAINT $row[0] FOREIGN KEY ($row[2]) REFERENCES $row[3] ($row[4]) ON $stat";
                    
            mysqli_query($dba, $sql) or die("Error F(x) STBUKU - 6 - 2 : ".mysqli_error($dba));
        }

        //ENABLE FOREIGN KEY CHECK
        $sql = "SET FOREIGN_KEY_CHECKS=1";

        mysqli_query($db, $sql) or die("Error F(x) STBUKU - 6 - 3 : ".mysqli_error($db));

        if(strcasecmp($dstk,"Y") == 0)
            $sql = "UPDATE dtproduk
                    SET AQTY = TQTY + AQTY + VIQTY + SIQTY - SOQTY - KQTY - CQTY - VOQTY";
        else
            $sql = "UPDATE dtproduk
                    SET AQTY = 0";
                    
        mysqli_query($db, $sql) or die("Error F(x) STBUKU - 7 : ".mysqli_error($db));

        $sql = "UPDATE dtproduk
                SET TQTY = 0, VIQTY = 0, SIQTY = 0, SOQTY = 0, KQTY = 0, CQTY = 0, VOQTY = 0";
                    
        mysqli_query($db, $sql) or die("Error F(x) STBUKU - 8 : ".mysqli_error($db));

        $n = 1;
        if(strcasecmp($dpjm,"Y") == 0)
        {
            $sql = "SELECT IDSUP, (SELECT SUM(JLH-XJLH-POT) FROM $db2.trpinjam WHERE IDSUP = T.IDSUP) FROM $db2.trpinjam T";

            $result = mysqli_query($dba, $sql) or die("Error F(x) STBUKU - 9 : ".mysqli_error($dba));

            while($row = mysqli_fetch_array($result, MYSQLI_NUM))
            {
                if($row[1] != 0)
                {
                    $id = setID($n, 3);

                    newPjm($id, $row[0], date('Y-m-d'), $row[1], "SALDO PEMINJAMAN", "", "", "SYSTEM", date('Y-m-d H:i:s'), '');

                    $n++;
                }
            }
        }

        if(strcasecmp($dsmpn,"Y") == 0)
            $sql = "UPDATE $db1.dtsup S
                    SET SAVINGS = IFNULL((SELECT SAVINGS FROM $db2.dtsup WHERE ID = S.ID), 0) + IFNULL((SELECT SUM(WEIGHT * SPRICE) FROM $db2.prterima2 T2 INNER JOIN $db2.prterima T ON T2.ID = T.ID WHERE T.IDSUP = S.ID), 0) - IFNULL((SELECT SUM(TOTAL) FROM $db2.trwd WHERE IDSUP = S.ID), 0)";
        else
            $sql = "UPDATE $db1.dtsup
                    SET SAVINGS = 0";

        mysqli_query($dba, $sql) or die("Error F(x) STBUKU - 10 : ".mysqli_error($dba));
        

        closeDB($db);
        closeDB($dba);
    }

    //PVERIF
    function getAllPVerif($db){
        $sql = "SELECT V.ID, IF(STRCMP(V.TYPE, 'V') = 0, 'Vacuum', IF(STRCMP(V.TYPE,'S') = 0, 'Sawing', IF(STRCMP(V.TYPE,'K') = 0, 'Packing', 'Re-Packing'))), P.NAME, G.NAME, IFNULL(K.NAME, ''), IFNULL(SK.NAME, ''), V.SISA, V.WEIGHT, V.IDUSER FROM dtvrfpsy V INNER JOIN dtproduk P ON V.IDPRODUK = P.ID INNER JOIN dtgrade G ON P.IDGRADE = G.ID LEFT JOIN dtkate K ON P.IDKATE = K.ID LEFT JOIN dtskate SK ON P.IDSKATE = SK.ID
                WHERE V.STAT = 'P' ORDER BY ID";

        $result = mysqli_query($db, $sql) or die("Error F(x) GAPVRF : ".mysqli_error($db));

        $arr = array();
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            $arr[count($arr)] = $row;
        }

        return $arr;
    }
    
    function getPVerifID($id, $db){
        $sql = "SELECT ID, TGL, IDPRODUK, WEIGHT, SISA, SELISIH, IDUSER, STAT, KET, VUSER, VWKT, TYPE, IF(STRCMP(TYPE, 'V') = 0, 'Vacuum', IF(STRCMP(TYPE,'S') = 0, 'Sawing', IF(STRCMP(TYPE,'K') = 0, 'Packing', 'Re-Packing'))) FROM dtvrfpsy
                WHERE ID = '$id'";

        $result = mysqli_query($db, $sql) or die("Error F(x) GPVRFID : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        return $row;
    }

    function getLastVerifID($aw, $ak, $db){
        $sql = "SELECT ID FROM dtvrfpsy
                WHERE ID LIKE '%$aw%$ak%' ORDER BY ID DESC";

        $result = mysqli_query($db, $sql) or die("Error F(x) GLVRFID : ".mysqli_error($db));

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        return $row[0];
    }

    function setStatPVerif($id, $stat, $user, $ket, $db){
        $sql = "UPDATE dtvrfpsy
                SET STAT = '$stat', VUSER = '$user', KET = '$ket', VWKT = CURDATE()
                WHERE ID = '$id'";

        mysqli_query($db, $sql) or die("Error F(x) SSTATPVRF : ".mysqli_error($db));
    }

    function newPVerif($id, $tgl, $pro, $weight, $sisa, $slsh, $user, $stat, $ket, $type, $db){
        $sql = "INSERT INTO dtvrfpsy
                (ID, TGL, IDPRODUK, WEIGHT, SISA, SELISIH, IDUSER, STAT, KET, TYPE)
                VALUES
                ('$id', '$tgl', '$pro', '$weight', '$sisa', '$slsh', '$user', '$stat', '$ket', '$type')";

        mysqli_query($db, $sql) or die("Error F(x) NPVRF : ".mysqli_error($db));
    }

    function delAllAtTrm($tgl, $db){
        $sql = "DELETE FROM hst_prterima WHERE MONTH(DATE_AFR) = ".date('n', strtotime($tgl)).";
                DELETE FROM hst_prcut WHERE MONTH(DATE_AFR) = ".date('n', strtotime($tgl)).";
                DELETE FROM hst_prfill WHERE MONTH(DATE_AFR) = ".date('n', strtotime($tgl)).";
                DELETE FROM prterima WHERE MONTH(DATE) = ".date('n', strtotime($tgl)).";
                DELETE FROM prfill WHERE MONTH(DATE) = ".date('n', strtotime($tgl)).";
                DELETE FROM prcut WHERE MONTH(DATE) = ".date('n', strtotime($tgl)).";
                DELETE FROM prcut2 WHERE ID LIKE '%/".date('my', strtotime($tgl))."';
                DELETE FROM prfill2 WHERE ID LIKE '%/".date('my', strtotime($tgl))."';
                DELETE FROM prterima2 WHERE ID LIKE '%/".date('my', strtotime($tgl))."';
                DELETE FROM hst_prterima2 WHERE IDTRAN LIKE '%/".date('my', strtotime($tgl))."';
                DELETE FROM hst_prcut2 WHERE IDTRAN LIKE '%/".date('my', strtotime($tgl))."';
                DELETE FROM hst_prfill2 WHERE IDTRAN LIKE '%/".date('my', strtotime($tgl))."';";

        mysqli_query($db, $sql) or die("Error F(x) DAATTRM : ".mysqli_error($db));
    }

    function delAllAtKrm($tgl, $db){
        $sql = "DELETE FROM hst trkirim WHERE MONTH(DATE_AFR) = ".date('n', strtotime($tgl)).";
                DELETE FROM trkirim WHERE MONTH(DATE) = ".date('n', strtotime($tgl)).";
                DELETE FROM trkirim2 WHERE ID LIKE '%/".date('my', strtotime($tgl))."';
                DELETE FROM hst trkirim2 WHERE IDTRAN LIKE '%/".date('my', strtotime($tgl))."';";

        mysqli_query($db, $sql) or die("Error F(x) DAATKRM : ".mysqli_error($db));
    }
?>