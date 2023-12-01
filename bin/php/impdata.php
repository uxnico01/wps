<?php
    require("./clsfunction.php");

    $db = openDB();
    $db2 = openDB2();

    //DATA
    //CUSTOMER
    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3 FROM dtcus";

    $result = mysqli_query($db2, $sql) or die("Error F(x) DC - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countCusID($row[0]) == 0)
            newCus($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9]);
        else
            updCus($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[0]);
    }

    //SUPPLIER
    $sql = "SELECT ID, NAME, ADDR, REG, HP, HP2, EMAIL, KET1, KET2, KET3, SAVINGS FROM dtsup";

    $result = mysqli_query($db2, $sql) or die("Error F(x) DS - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countSupID($row[0]) == 0)
            newSup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
        else
            updSup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[0], $row[10]);
    }

    //GRADE
    $sql = "SELECT ID, NAME, KET FROM dtgrade";

    $result = mysqli_query($db2, $sql) or die("Error F(x) GRD - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countGradeID($row[0]) == 0)
            newGrade($row[0], $row[1], $row[2]);
        else
            updGrade($row[0], $row[1], $row[2], $row[0]);
    }

    //SATUAN
    $sql = "SELECT ID, NAME, KET FROM dtsat";

    $result = mysqli_query($db2, $sql) or die("Error F(x) STN - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countSatuanID($row[0]) == 0)
            newSatuan($row[0], $row[1], $row[2]);
        else
            updSatuan($row[0], $row[1], $row[2], $row[0]);
    }

    //HSUP
    $sql = "SELECT IDSAT, IDGRADE, IDSUP, PRICE FROM dthsup";

    $result = mysqli_query($db2, $sql) or die("Error F(x) HSUP - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countHSup($row[2], $row[1], $row[0]) == 0)
            newHSup($row[2], $row[1], $row[0], $row[3]);
        else
            updHSup($row[2], $row[1], $row[0], $row[3]);
    }

    //PSUP
    $sql = "SELECT IDSAT, IDGRADE, IDSUP, PRICE FROM dtpsup";

    $result = mysqli_query($db2, $sql) or die("Error F(x) PSUP - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countPSup($row[2], $row[1], $row[0]) == 0)
            newPSup($row[2], $row[1], $row[0], $row[3]);
        else
            updPSup($row[2], $row[1], $row[0], $row[3]);
    }

    //KATE
    $sql = "SELECT ID, NAME, KET FROM dtkate";

    $result = mysqli_query($db2, $sql) or die("Error F(x) KATE - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countKateID($row[0]) == 0)
            newKate($row[0], $row[1], $row[2]);
        else
            updKate($row[0], $row[1], $row[2], $row[0]);
    }

    //SKATE
    $sql = "SELECT ID, NAME, KET, IDKATE FROM dtskate";

    $result = mysqli_query($db2, $sql) or die("Error F(x) SKATE - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countSKateID($row[0]) == 0)
            newSKate($row[0], $row[1], $row[2], $row[3]);
        else
            updSKate($row[0], $row[1], $row[2], $row[3], $row[0]);
    }

    //PRODUK
    $sql = "SELECT ID, NAME, IDKATE, IDSKATE, IDGRADE, AQTY, STRM, SCUT, SFILL, SSAW, SPKG, SMP, SFRZ, HSELL, IDKATES, IDGOL FROM dtproduk";

    $result = mysqli_query($db2, $sql) or die("Error F(x) PRO - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countProID($row[0]) == 0)
            newPro($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15]);
        else
            updPro($row[0], $row[1], $row[2], $row[3], $row[4], $row[0], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15]);
    }

    //PO
    $sql = "SELECT ID, IDCUS, DATE, KET1, KET2, KET3, TAMPIL, DTAMPIL, QTY, STAT, IDGDG, ID2 FROM dtpo";

    $result = mysqli_query($db2, $sql) or die("Error F(x) PO - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countPOID($row[0]) == 0)
            newPo($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[11]);
        else
            updPo($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[0], $row[8]);

        updPoStat($row[0], $row[9], $row[10], $row[5]);
    }

    //SETT
    $sql = "SELECT TYPE, VAL FROM dtsett
            WHERE ID = 'MGCUT'";

    $result = mysqli_query($db2, $sql) or die("Error F(x) SETT - 1 : ".mysqli_error($db2));

    $mcut = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT TYPE, VAL FROM dtsett
            WHERE ID = 'MGSAW'";

    $result = mysqli_query($db2, $sql) or die("Error F(x) SETT - 2 : ".mysqli_error($db2));

    $msaw = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT TYPE, VAL FROM dtsett
            WHERE ID = 'MGVAC'";

    $result = mysqli_query($db2, $sql) or die("Error F(x) SETT - 3 : ".mysqli_error($db2));

    $mvac = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT TYPE, VAL2 FROM dtsett
            WHERE ID = 'DFGDG'";

    $result = mysqli_query($db2, $sql) or die("Error F(x) SETT - 4 : ".mysqli_error($db2));

    $dfgdg = mysqli_fetch_array($result, MYSQLI_NUM);

    $sql = "SELECT TYPE, VAL2 FROM dtsett
            WHERE ID = 'DFKGDG'";

    $result = mysqli_query($db2, $sql) or die("Error F(x) SETT - 5 : ".mysqli_error($db2));

    $dfgdg = mysqli_fetch_array($result, MYSQLI_NUM);

    updSett($mcut[0], $mcut[1], $mvac[0], $mvac[1], $msaw[0], $msaw[1], $dfgdg[1], $dfkgdg[1], "", "", "");

    //USER
    $sql = "SELECT ID, PASS, NAME, POSITION, DIVISION, AKTIF, LEVEL, AKSES FROM dtuser";

    $result = mysqli_query($db2, $sql) or die("Error F(x) USR - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        if(countUserID($row[0]) == 0)
            newUser($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
        else
            updUser($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[0]);
    }

    //TRANSAKSI
    //PJM
    $sql = "SELECT ID, IDSUP, DATE, JLH, XJLH, KET1, KET2, KET3, IDUSER, WKT, VERIF, VUSER, POT FROM trpinjam";

    $result = mysqli_query($db2, $sql) or die("Error F(x) PJM - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $aw = "HPJM/";
        $ak = date('/my', strtotime($row[9]));
        $hid = $aw.setID((int)substr(getLastIDHPjm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        if(countPjmID($row[0]) == 0)
        {
            newPjm($row[0], $row[1], $row[2], $row[3], $row[5], $row[6], $row[7], $row[8], $row[9], $row[12]);
            updXPjm($row[0], $row[4]);
            newHPjm($hid, "", "", "" ,"" , "", "", "", "", "", "", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[8], "NEW", $row[9], "", $row[12]);
        }
        else
        {
            $data = getPjmID($row[0]);
            updPjm($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[0], $row[12]);
            newHPjm($hid, $row[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[8], "EDIT", $row[9], "", $row[12]);
        }
    }

    //WD
    $sql = "SELECT ID, IDSUP, DATE, TOTAL, KET1, KET2, KET3, VERIF, VUSER, IDUSER, WKT FROM trwd";

    $result = mysqli_query($db2, $sql) or die("Error F(x) WD - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $aw = "HWD/";
        $ak = date('/my', strtotime($row[10]));
        $hid = $aw.setID((int)substr(getLastIDHWd($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        if(countWdID($row[0]) == 0)
        {
            newWd($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[9], $row[10]);
            newHWd($hid, "", "", "", "", "", "", "", "", "", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[9], $row[10], $row[9], "NEW", $row[10]);
        }
        else
        {
            $data = getWdID($row[0]);
            updWd($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[9], $row[10], $row[0]);
            newHWd($hid, $row[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[9], $data[10], $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[9], $row[10], $row[9], "EDIT", $row[10]);
        }
    }

    //BB
    $sql = "SELECT ID, DATE, TOTAL, KET, TYPE, WKT, IDUSER, VERIF, VUSER FROM trbb";

    $result = mysqli_query($db, $sql) or die("Error F(x) BB - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $aw = "HBB/";
        $ak = date('/my', strtotime($row[5]));
        $hid = $aw.setID((int)substr(getLastIDHBB($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        if(countBBID($row[0]) == 0)
        {
            newBB($row[0], $row[1], $row[2], $row[3], $row[4], $row[6], $row[5]);
            newHBB($hid, "", "", "", "", "", "", "", $row[0], $row[1], $row[2], $row[3], $row[4], $row[6], $row[5], $row[6], "NEW", $row[5]);
        }
        else
        {
            $data = getBBID($row[0]);
            updBB($row[0], $row[1], $row[2], $row[3], $row[4], $row[6], $row[5], $row[0]);
            newHBB($hid, $row[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $row[0], $row[1], $row[2], $row[3], $row[4], $row[6], $row[5], $row[6], "EDIT", $row[5]);
        }
    }

    //PROCESS
    //TERIMA
    $sql = "SELECT ID, IDSUP, DATE, BB, POTO, KET1, KET2, KET3, IDUSER, WKT, VERIF, VUSER, KOTA, VDLL, KDLL, DP, BB2, TOTAL, VMIN, POTDLL, TBHDLL, MINUM, IDGDG FROM prterima";

    $result = mysqli_query($db2, $sql) or die("Error F(x) TRM - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $aw = "HTRM/";
        $ak = date('/my', strtotime($row[9]));
        $hid = $aw.setID((int)substr(getLastIDHTrm($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        if(countTrmID($row[0]) == 0)
        {
            newTrm($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[12], $row[13], $row[14], $row[15], $row[16], $row[18], $row[19], $row[20], $row[21], $row[22]);
            newHTrm($hid, "", "", "", "", "", "", "", "", "", "", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[8], $row[9], "NEW", "", $row[12], "", "", "", $row[13], $row[14], $row[15], "", $row[18], "", $row[19], "", $row[20], "", $row[21], "", $row[22]);
        }
        else
        {
            $data = getTrmID($row[0]);
            $data2 = getTrmItem($row[0]);
            $data3 = getTrmDll($row[0]);
            $data4 = getTrmPDll($row[0]);
            $data5 = getTrmDP($row[0]);

            updTrm($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[0], $row[12], $row[13], $row[14], $row[15], $row[16], $row[18], $row[19], $row[20], $row[21], $row[22]);
            newHTrm($hid, $row[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[8], $row[9], "EDIT", $data[12], $row[12], $data[13], $data[14], $data[15], $row[13], $row[14], $row[15], $data[17], $row[18], $data[18], $row[19], $data[19], $row[20], $data[20], $row[21], $data[21], $row[22]);

            delAllDtlTrm($row[0]);
            delAllDllTrm($row[0]);
            delAllPDllTrm($row[0]);
            delAllDPTrm($row[0]);
            delAllTDllTrm($row[0]);

            for($i = 0; $i < count($data2); $i++)
                newHDtlTrm($hid, $row[0], $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], "B", $data2[$i][5], $data2[$i][12]);

            for($i = 0; $i < count($data3); $i++)
                newHDllTrm($hid, $row[0], $data3[$i][1], $data3[$i][2], $data3[$i][3], $data3[$i][4], "B");

            for($i = 0; $i < count($data4); $i++)
                newHPDllTrm($hid, $row[0], $data4[$i][1], $data4[$i][2], $data4[$i][3], $data4[$i][4], "B");

            for($i = 0; $i < count($data5); $i++)
                newHDPTrm($hid, $row[0], $data5[$i][1], $data5[$i][2], $data5[$i][3], "B");
        }
        
        //DTL
        $sql = "SELECT ID, IDPRODUK, WEIGHT, IDSAT, URUT, PRICE, SPRICE FROM prterima2
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) TRM - 2 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
        {
            newDtlTrm($row2[0], $row2[1], $row2[2], $row2[3], $row2[4], $row2[5], $row2[6]);
            newHDtlTrm($hid, $row2[0], $row2[1], $row2[2], $row2[3], $row2[4], "A", $row2[5], $row2[6]);
        }
    
        //DLL
        $sql = "SELECT ID, TYPE, KET, VAL, URUT FROM prterima3
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) TRM - 3 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
        {
            newDllTrm($row2[0], $row2[1], $row2[2], $row2[3], $row2[4]);
            newHDllTrm($hid, $row2[0], $row2[1], $row2[2], $row2[3], $row2[4], "A");
        }
    
        //PDLL
        $sql = "SELECT ID, TYPE, KET, VAL, URUT FROM prterima4
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) TRM - 4 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
        {
            newPDllTrm($row2[0], $row2[1], $row2[2], $row2[3], $row2[4]);
            newHPDllTrm($hid, $row2[0], $row2[1], $row2[2], $row2[3], $row2[4], "A");
        }
    
        //DP
        $sql = "SELECT ID, DATE, VAL, URUT FROM prterima5
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) TRM - 5 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
        {
            newDPTrm($row2[0], $row2[1], $row2[2], $row2[3]);
            newHDPTrm($hid, $row2[0], $row2[1], $row2[2], $row2[3], "A");
        }
    
        //TDLL
        $sql = "SELECT ID, TYPE, KET, VAL, URUT FROM prterima6
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) TRM - 6 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
        {
            newTDllTrm($row2[0], $row2[1], $row2[2], $row2[3], $row2[4], $row2[5], $row2[6]);
            newHTDllTrm($hid, $row2[0], $row2[1], $row2[2], $row2[3], $row2[4], "A", $row2[5], $row2[6]);
        }
    }

    //CUT
    $sql = "SELECT ID, DATE, MARGIN, IDUSER, WKT, VERIF, VUSER, TMARGIN, IDGDG FROM prcut";

    $result = mysqli_query($db2, $sql) or die("Error F(x) CUT - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $aw = "HCUT/";
        $ak = date('/my', strtotime($row[1]));
        $hid = $aw.setID((int)substr(getLastIDHCut($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        if(countCutID($row[0]) == 0)
        {
            newCut($row[0], $row[1], $row[2], $row[3], $row[4], $row[7], $row[8]);
            newHstCut($hid, "", "", "", "", "", "", $row[0], $row[1], $row[2], $row[3], $row[4], $row[7], $row[3], $row[4], "NEW", "", $row[8]);
        }
        else
        {
            $data = getCutID($row[0]);
            $data2 = getCutItem($row[0]);

            updCut($row[0], $row[1], $row[2], $row[3], $row[4], $row[7], $row[0], $row[8]);
            newHstCut($hid, $row[0], $data[1], $data[2], $data[3], $data[4], $data[7], $row[0], $row[1], $row[2], $row[3], $row[4], $row[7], $row[3], $row[4], "EDIT", $data[8], $row[8]);

            for($i = 0; $i < count($data2); $i++)
            {
                newHstDtlCut($hid, $row[0], $data2[$i][1], $data2[$i][2], $data2[$i][3], $data2[$i][4], $data2[$i][5], $data2[$i][6], $data2[$i][7], $data2[$i][8], $data2[$i][9], $data2[$i][10], $data2[$i][11], "B", $data2[$i][16], $data2[$i][17], $data2[$i][18], $data2[$i][19], $data2[$i][20], $data2[$i][21], $data2[$i][22], $data2[$i][23]);
            }

            delAllDtlCut($row[0]);
        }

        $sql = "SELECT ID, IDPRODUK, TCUT1, TCUT2, TCUT3, TCUT4, TCUT5, TCUT6, URUT, IDTERIMA, URUTTRM, WEIGHT, KET, GRADE, GRADE2, GRADE3, GRADE4, GRADE5, GRADE6, NOSAMPLE FROM prcut2
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) CUT - 2 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
        {
            newDtlCut($row2[0], $row2[1], $row2[2], $row2[3], $row2[4], $row2[5], $row2[6], $row2[7], $row2[8], $row2[9], $row2[10], $row2[11], $row2[13], $row2[14], $row2[15], $row2[16], $row2[17], $row2[18], $row2[12], $row2[19]);
            newHstDtlCut($hid, $row2[0], $row2[1], $row2[2], $row2[3], $row2[4], $row2[5], $row2[6], $row2[7], $row2[8], $row2[9], $row2[10], $row2[11], "A", $row2[13], $row2[14], $row2[15], $row2[16], $row2[17], $row2[18], $row2[12], $row2[19]);
        }
    }

    //VAC
    $sql = "SELECT ID, DATE, TYPE, CDATE, IDUSER, IDPRODUK, WEIGHT, WKT, MARGIN, TMARGIN, VERIF, VUSER, KET, TAHAP, TYPE2, IDPRODUK2, WEIGHT2, IDGDG FROM prfill";

    $result = mysqli_query($db2, $sql) or die("Error F(x) VAC - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $aw = "HVAC/";
        $ak = date('/my', strtotime($row[1]));
        $hid = $aw.setID((int)substr(getLastIDHVac($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        if(countVacID($row[0]) == 0)
        {
            newVac($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[11], $row[12], $row[13], $row[15], $row[16], $row[17]);
            newHstVac($hid, "", "", "", "", "", "", "", "", "", "", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[4], $row[7], "NEW", "", $row[12], "", $row[13], "", $row[14], "", "", $row[15], $row[16], "", $row[17]);
        }
        else
        {
            $data = getVacID($row[0]);
            $data2 = getVacItem($row[0]);

            updVac($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[0], $row[11], $row[12], $row[13], $row[15], $row[16], $row[17]);
            newHstVac($hid, $row[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[4], $row[7], "EDIT", $data[12], $row[12], $data[13], $row[13], $data[14], $row[14], $data[15], $data[16], $row[15], $row[16], $data[17], $row[17]);

            for($i = 0; $i < count($data2); $i++){
                newHstDtlVac($hid, $row[0], $data2[$i][1], $data2[$i][2], $data2[$i][3], "B", $data2[$i][4], "");
            }
    
            delAllDtlVac($row[0]);
        }

        $sql = "SELECT ID, IDPRODUK, WEIGHT, URUT, KET FROM prfill2
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) VAC - 2 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
        {
            newDtlVac($row2[0], $row2[1], $row2[2], $row2[3], $row2[4], "");
            newHstDtlVac($hid, $row2[0], $row2[1], $row2[2], $row2[3], "A", $row2[4], "");
        }
    }

    //SAW
    $sql = "SELECT ID, DATE, IDUSER, IDPRODUK, WEIGHT, WKT, MARGIN, TMARGIN, VERIF, VUSER, TAHAP, KET, IDGDG FROM prsaw";

    $result = mysqli_query($db2, $sql) or die("Error F(x) SAW - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $aw = "HSAW/";
        $ak = date('/my', strtotime($row[1]));
        $hid = $aw.setID((int)substr(getLastIDHSaw($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        if(countSawID($row[0]) == 0)
        {
            newSaw($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[10], $row[11], $row[12]);
            newHstSaw($hid, "", "", "", "", "", "", "", "", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[2], $row[5], "NEW", "", $row[10], "", $row[11], "", $row[12]);
        }
        else
        {
            $data = getSawID($row[0]);
            $data2 = getSawItem($row[0]);
            
            updSaw($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[0], $row[10], $row[11], $row[12]);
            newHstSaw($hid, $row[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[2], $row[5], "EDIT", $data[10], $row[10], $data[11], $row[11], $data[12], $row[12]);

            for($i = 0; $i < count($data2); $i++)
                newHstDtlSaw($hid, $row[0], $data2[$i][1], $data2[$i][2], $data2[$i][3], "B");
        }

        $sql = "SELECT ID, IDPRODUK, WEIGHT, URUT FROM prsaw2
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) SAW - 2 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
        {
            newDtlSaw($row2[0], $row2[1], $row2[2], $row2[3]);
            newHstDtlSaw($hid, $row2[0], $row2[1], $row2[2], $row2[3], "A");
        }
    }

    //MP
    $sql = "SELECT ID, DATE, IDUSER, WKT, VERIF, VUSER, IDGDG FROM prmsk";

    $result = mysqli_query($db2, $sql) or die("Error F(x) MP - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $aw = "HMP/";
        $ak = date('/my', strtotime($row[1]));
        $hid = $aw.setID((int)substr(getLastHIDMP($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        if(countMPID($row[0]) == 0)
        {
            newMP($row[0], $row[1], $row[2], $row[3], $row[6]);
            newHMP($hid, "", "", "", "", $row[0], $row[1], $row[2], $row[3], $row[3], $row[2], "NEW", "", $row[6]);
        }
        else
        {
            $data = getMPID($row[0]);
            $data2 = getMPItem($row[0]);

            updMP($row[0], $row[1], $row[2], $row[3], $row[0], $row[6]);
            newHMP($hid, $row[0], $data[1], $data[2], $data[3], $row[0], $row[1], $row[2], $row[3], $row[3], $row[2], "EDIT", $data[6], $row[6]);

            delAllDtlMP($row[0]);
        }

        $sql = "SELECT ID, IDPRODUK, WEIGHT, URUT, KET FROM prmsk2
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) MP - 2 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result2, MYSQLI_NUM))
        {
            newDtlMP($row2[0], $row2[1], $row2[2], $row2[3], $row2[4]);
            newHDtlMP($hid, $row2[0], $row2[1], $row2[2], $row2[3], $row2[4], "A");
        }
    }

    //BEKU
    $sql = "SELECT ID, DATE, IDUSER, WKT, VERIF, VUSER, IDGDG FROM prfrz";

    $result = mysqli_query($db2, $sql) or die("Error F(x) FRZ - 1 : ".mysqli_error($db2));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $aw = "HFRZ/";
        $ak = date('/my', strtotime($row[1]));
        $hid = $aw.setID((int)substr(getLastHIDFrz($aw, $ak), strlen($aw), 4) + 1, 4).$ak;

        if(countFrzID($row[0]) == 0)
        {
            newFrz($row[0], $row[1], $row[2], $row[3], $row[6]);
            newHFrz($hid, "", "", "", "", $row[0], $row[1], $row[2], $row[3], $row[3], $row[2], "NEW", "", $row[6]);
        }
        else
        {
            $data = getFrzID($id);
            $data2 = getFrzItem($id);

            updFrz($row[0], $row[1], $row[2], $row[3], $row[0], $row[6]);
            newHFrz($hid, $row[0], $data[1], $data[2], $data[3], $row[0], $row[1], $row[2], $row[3], $row[3], $row[2], "EDIT", $data[6], $row[6]);
        }

        $sql = "SELECT ID, IDPRODUK, IDTERIMA, URUTTRM, WEIGHT, KET, URUT, IDPRODUK2 FROM prfrz2
                WHERE ID = '$row[0]'";

        $result2 = mysqli_query($db2, $sql) or die("Error F(x) FRZ - 2 : ".mysqli_error($db2));

        while($row2 = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            newDtlFrz($row2[0], $row2[1], $row2[2], $row2[3], $row2[4], $row2[6], $row2[5], $row2[7]);
            newHDtlFrz($hid, $row2[0], $row2[1], $row2[2], $row2[3], $row2[4], $row2[6], $row2[5], $row2[7], "A");
        }
    }

    closeDB($db);
    closeDB($db2);

    echo json_encode(array('err' => array(0)));
?>