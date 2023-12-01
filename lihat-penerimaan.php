<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    CloseDB($db);

    $data = getTrmID($id);
    $sup = getSupID($data[1]);

    $spjm = getSumSupPjm2($data[1], $data[2]);
    $ssmpn = getSumSupSmpn2($data[1], $data[2]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Penerimaan | PT. Winson Prima Sejahtera</title>
    
    <?php
        if(file_exists("./bin/php/head.php"))
            require("./bin/php/head.php");
    ?>

    <style>
        table *
        {
            border: none !important;
        }
    </style>
</head>
<body>
    <div class="my-2 no-print">
        <div class="col-12">
            <?php
                if(cekAksUser(substr($duser[7], 66, 1)) || cekAksUser(substr($duser[7], 86, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-secondary m-1" data-target="#mdl-opt-trm" data-toggle="modal"><img src="./bin/img/icon/more-info.png" alt="" width="25"> <span class="small">Option</span></button>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-3 container div-print <?php if(!cekAksUser(substr($duser[7], 66, 1)) || !cekAksUser(substr($duser[7], 86, 1))) echo "no-print";?>">
        <div id="div-lp1">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th colspan="9" class="h4 font-weight-bold text-center">Tanda Terima Bahan</th>
                    </tr>
                    
                    <tr>
                        <th class="font-weight-bold text-left">Nomor</th>
                        <th colspan="3" class="text-left">: <?php echo $id;?></th>
                    </tr>
                    
                    <tr>
                        <th class="font-weight-bold text-left">Tanggal</th>
                        <th colspan="3" class="text-left">: <?php echo date('d - m - Y', strtotime($data[2]));?></th>
                        <th class="font-weight-bold text-right d-none" colspan="4">Total Simpanan saat ini</th>
                        <th colspan="2" class="text-left d-none">: <?php if(isDecimal($ssmpn)) echo number_format($ssmpn,2,'.',','); else echo number_format($ssmpn,0,'.',',');?></th>
                    </tr>
                    
                    <tr>
                        <th class="font-weight-bold text-left">Supplier</th>
                        <th colspan="2" class="text-left">: <?php echo $sup[1]; if(strcasecmp($data[12],"") != 0) echo " / ".$data[12]; if(strcasecmp($data[5],"") != 0) echo " ($data[5])";?></th>
                        <th class="font-weight-bold text-right <?php if(countSupTrPjm($data[1]) == 0 || ($spjm == 0 && $data[4] == 0)) echo "d-none";?>" colspan="3">Total Pinjaman (<?php echo date('d/m/Y', strtotime($data[2]));?>)</th>
                        <th colspan="2" class="text-left <?php if(countSupTrPjm($data[1]) == 0 || ($spjm == 0 && $data[4] == 0)) echo "d-none";?>">: <?php if(isDecimal($spjm)) echo number_format($spjm,2,'.',','); else echo number_format($spjm,0,'.',',');?></th>
                    </tr>

                    <tr class="thead-dark">
                        <th class="border align-middle">Grade</th>
                        <th class="border align-middle">Produk</th>
                        <th class="border align-middle">Satuan</th>
                        <th class="border align-middle text-right">Qty (Ekor)</th>
                        <th class="border align-middle text-right">Qty (KG)</th>
                        <th class="border align-middle text-right">Harga / KG</th>
                        <th class="border align-middle text-right d-none">Simpanan / KG</th>
                        <th class="border align-middle text-right d-none">Jlh Simpanan</th>
                        <th class="border align-middle text-right">Total Harga</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $data2 = getTrmItem3($id);

                        for($i = 0; $i < count($data2); $i++)
                        {
                            $pro = getProID($data2[$i][1]);
                            $sat = getSatuanID($data2[$i][5]);
                            $grade = getGradeID($pro[4]);

                            $ttl = $data2[$i][3] * $data2[$i][4];

                            $ttls = $data2[$i][3] * $data2[$i][6];

                            $dcl = 0;
                            if(isDecimal($data2[$i][3]))
                                $dcl = 2;

                            $hdcl = 0;
                            if(isDecimal($data2[$i][4]))
                                $hdcl = 2;

                            $sdcl = 0;
                            if(isDecimal($data2[$i][6]))
                                $sdcl = 2;

                            $tdcl = 0;
                            if(isDecimal($ttl))
                                $tdcl = 2;

                            $tsdcl = 0;
                            if(isDecimal($ttls))
                                $tsdcl = 2;
                    ?>
                    <tr>
                        <td class="border"><?php echo $grade[1];?></td>
                        <td class="border"><?php echo $pro[1];?></td>
                        <td class="border"><?php echo $sat[1];?></td>
                        <td class="border text-right"><?php echo number_format($data2[$i][2], 0, '.', ',');?></td>
                        <td class="border text-right"><?php echo number_format($data2[$i][3], $dcl, '.', ',');?></td>
                        <td class="border text-right"><?php echo number_format($data2[$i][4]-$data2[$i][6], $hdcl, '.', ',');?></td>
                        <td class="border text-right d-none"><?php echo number_format($data2[$i][6], $sdcl, '.', ',');?></td>
                        <td class="border text-right d-none"><?php echo number_format($ttls, $tsdcl, '.', ',');?></td>
                        <td class="border text-right"><?php echo number_format($ttl-$ttls, $tdcl, '.', ',');?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>

                <tfoot>
                    <?php
                        $lsat = getAllSatuan();

                        $sarr = array(0, 0, 0, 0);
                        for($i = 0; $i < count($lsat); $i++)
                        {
                            $sum = getSumItemTrmSat($id, $lsat[$i][0]);

                            if($sum[0] == 0)
                                continue;

                            $sum[2] -= $sum[3];
                    ?>
                    <tr>
                        <td class="" colspan="3">Total Ikan <?php echo $lsat[$i][1];?></td>

                        <td class="text-right"><?php echo number_format($sum[0],0,'.',',');?> Ekor</td>

                        <td class="text-right"><?php if(isDecimal($sum[1])) echo number_format($sum[1],2,'.',','); else echo number_format($sum[1],0,'.',',');?> KG</td>

                        <td class="text-right d-none" colspan="3"><?php if(isDecimal($sum[3])) echo number_format($sum[3],2,'.',','); else echo number_format($sum[3],0,'.',',');?></td>

                        <td class="text-right" colspan="2"><?php if(isDecimal($sum[2])) echo number_format($sum[2],2,'.',','); else echo number_format($sum[2],0,'.',',');?></td>
                    </tr>
                    <?php
                            $sarr[0] += $sum[0];
                            $sarr[1] += $sum[1];
                            $sarr[2] += $sum[2];
                            $sarr[3] += $sum[3];
                        }
                    ?>
                    <tr>
                        <td class="text-left border-top border-dark" colspan="3">Total Ikan</td>

                        <td class="text-right border-top border-dark"><?php echo number_format($sarr[0],0,'.',',');?> Ekor</td>

                        <td class="text-right border-top border-dark"><?php if(isDecimal($sarr[1])) echo number_format($sarr[1],2,'.',','); else echo number_format($sarr[1],0,'.',',');?> KG</td>

                        <td class="text-right border-top border-dark d-none" colspan="3"><?php if(isDecimal($sarr[3])) echo number_format($sarr[3],2,'.',','); else echo number_format($sarr[3],0,'.',',');?></td>

                        <td class="text-right border-top border-dark" colspan="2"><?php if(isDecimal($sarr[2])) echo number_format($sarr[2],2,'.',','); else echo number_format($sarr[2],0,'.',',');?></td>
                    </tr>
                    <?php
                        if($data[4] != 0)
                        {
                    ?>
                    <tr>
                        <td class="text-right" colspan="6">Total Potongan</td>

                        <td class="text-right">(<?php if(isDecimal($data[4])) echo number_format($data[4],2,'.',','); else echo number_format($data[4],0,'.',',');?>)</td>
                    </tr>
                    <?php
                        }

                        $bb = $data[16] * $sarr[1];
                        if($data[3] != 0 || $data[16] != 0)
                        {
                            if($data[3] != 0)
                                $bb = $data[3];
                    ?>
                    <tr>
                        <td class="text-right" colspan="6">BB</td>

                        <td class="text-right">(<?php if(isDecimal($bb)) echo number_format($bb,2,'.',','); else echo number_format($bb,0,'.',',');?>)</td>
                    </tr>
                    <?php
                        }
                        
                        if($data[15] != 0)
                        {
                            $ldp = getTrmDP($id);

                            if(count($ldp) > 0)
                            {
                                for($i = 0; $i < count($ldp); $i++)
                                {
                    ?>
                    <tr>
                        <td class="text-right" colspan="6">DP - <?php echo date('d/m/Y', strtotime($ldp[$i][1]));?></td>

                        <td class="text-right">(<?php if(isDecimal($ldp[$i][2])) echo number_format($ldp[$i][2],2,'.',','); else echo number_format($ldp[$i][2],0,'.',',');?>)</td>
                    </tr>
                    <?php
                                }
                            }
                            else
                            {
                    ?>
                    <tr>
                        <td class="text-right" colspan="6">DP</td>

                        <td class="text-right">(<?php if(isDecimal($data[15])) echo number_format($data[15],2,'.',','); else echo number_format($data[15],0,'.',',');?>)</td>
                    </tr>
                    <?php
                            }
                        }

                        $sisa = $sarr[2] - $bb - $data[4] - $data[15];
                        
                        if($data[13] != 0)
                        {
                            $sisa -= $data[13];

                            $ldll = getTrmDll($id);

                            for($i = 0; $i < count($ldll); $i++)
                            {
                    ?>
                    <tr>
                        <td class="text-right" colspan="6"><?php if(strcasecmp($ldll[$i][1],"1") == 0) echo "CASH"; else if(strcasecmp($ldll[$i][1],"2") == 0) echo "ES"; else echo $ldll[$i][2]?></td>

                        <td class="text-right">(<?php if(isDecimal($ldll[$i][3])) echo number_format($ldll[$i][3],2,'.',','); else echo number_format($ldll[$i][3],0,'.',',');?>)</td>
                    </tr>
                    <?php
                            }
                        }
                        
                        if($data[17] != 0)
                        {
                            $sisa -= $data[17];
                            $dmtrm = getTglMinTrm($data[1], $data[2], $id);
                    ?>
                    <tr>
                        <td class="text-right" colspan="6">Minus (<?php echo date('d/m/Y', strtotime($dmtrm));?>)</td>

                        <td class="text-right">(<?php if(isDecimal($data[17])) echo number_format($data[17],2,'.',','); else echo number_format($data[17],0,'.',',');?>)</td>
                    </tr>
                    <?php
                        }
                        
                        if($data[18] != 0)
                        {
                            $sisa -= $data[18];

                            $lpdll = getTrmPDll($id);

                            for($i = 0; $i < count($lpdll); $i++)
                            {
                    ?>
                    <tr>
                        <td class="text-right" colspan="6"><?php echo $lpdll[$i][2]?></td>

                        <td class="text-right">(<?php if(isDecimal($lpdll[$i][3])) echo number_format($lpdll[$i][3],2,'.',','); else echo number_format($lpdll[$i][3],0,'.',',');?>)</td>
                    </tr>
                    <?php
                            }
                        }
                        
                        if($data[19] != 0)
                        {
                            $sisa += $data[19];

                            $ltdll = getTrmTDll($id);

                            for($i = 0; $i < count($ltdll); $i++)
                            {
                    ?>
                    <tr>
                        <td class="text-right" colspan="6"><?php echo $ltdll[$i][2]; if(strcasecmp($ltdll[$i][1],"2") == 0) { echo " ("; if(isDecimal($ltdll[$i][5])) echo number_format($ltdll[$i][5],2,'.',','); else echo number_format($ltdll[$i][5],0,'.',','); echo " KG x Rp "; if(isDecimal($ltdll[$i][6])) echo number_format($ltdll[$i][6],2,'.',','); else echo number_format($ltdll[$i][6],0,'.',','); echo ")";}?></td>

                        <td class="text-right"><?php if(isDecimal($ltdll[$i][3])) echo number_format($ltdll[$i][3],2,'.',','); else echo number_format($ltdll[$i][3],0,'.',',');?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                    <tr>
                        <td class="text-right border-top border-dark font-weight-bold" colspan="6"><?php if($sisa < 0) echo "Minus"; else echo "Sisa";?></td>

                        <td class="text-right border-top border-dark font-weight-bold"><?php if($sisa < 0) echo "("; if(isDecimal($sisa)) echo number_format(sqrt(pow($sisa,2)),2,'.',','); else echo number_format(sqrt(pow($sisa,2)),0,'.',','); if($sisa < 0) echo ")";?></td>
                    </tr>
                </tfoot>
            </table>

            <?php
                if($sarr[3] != 0)
                {
            ?>
            <div class="<?php if($sarr[3] != 0) echo "pagebreak";?>"></div>

            <hr class="my-5 print-no-border">

            <table class="table table-sm <?php if($sarr[3] == 0) echo "no-print";?>">
                <thead>
                    <tr>
                        <th colspan="9" class="h4 font-weight-bold text-center">Tanda Terima Bahan - Simpanan</th>
                    </tr>
                    
                    <tr>
                        <th class="font-weight-bold text-left">Nomor</th>
                        <th colspan="3" class="text-left">: <?php echo $id;?></th>
                    </tr>
                    
                    <tr>
                        <th class="font-weight-bold text-left">Tanggal</th>
                        <th colspan="3" class="text-left">: <?php echo date('d - m - Y', strtotime($data[2]));?></th>
                    </tr>
                    
                    <tr>
                        <th class="font-weight-bold text-left">Supplier</th>
                        <th colspan="3" class="text-left">: <?php echo $sup[1]; if(strcasecmp($data[12],"") != 0) echo " / ".$data[12]; if(strcasecmp($data[5],"") != 0) echo " ($data[5])";?></th>
                    </tr>

                    <tr class="thead-dark">
                        <th class="border align-middle">Grade</th>
                        <th class="border align-middle">Produk</th>
                        <th class="border align-middle">Satuan</th>
                        <th class="border align-middle text-right">Qty (Ekor)</th>
                        <th class="border align-middle text-right">Qty (KG)</th>
                        <th class="border align-middle text-right d-none">Harga / KG</th>
                        <th class="border align-middle text-right">Simpanan / KG</th>
                        <th class="border align-middle text-right">Jlh Simpanan</th>
                        <th class="border align-middle text-right d-none">Total Harga</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $data2 = getTrmItem3($id);

                        for($i = 0; $i < count($data2); $i++)
                        {
                            if($data2[$i][6] == 0)
                                continue;

                            $pro = getProID($data2[$i][1]);
                            $sat = getSatuanID($data2[$i][5]);
                            $grade = getGradeID($pro[4]);

                            $ttl = $data2[$i][3] * $data2[$i][4];

                            $ttls = $data2[$i][3] * $data2[$i][6];

                            $dcl = 0;
                            if(isDecimal($data2[$i][3]))
                                $dcl = 2;

                            $hdcl = 0;
                            if(isDecimal($data2[$i][4]))
                                $hdcl = 2;

                            $sdcl = 0;
                            if(isDecimal($data2[$i][6]))
                                $sdcl = 2;

                            $tdcl = 0;
                            if(isDecimal($ttl))
                                $tdcl = 2;

                            $tsdcl = 0;
                            if(isDecimal($ttls))
                                $tsdcl = 2;
                    ?>
                    <tr>
                        <td class="border"><?php echo $grade[1];?></td>
                        <td class="border"><?php echo $pro[1];?></td>
                        <td class="border"><?php echo $sat[1];?></td>
                        <td class="border text-right"><?php echo number_format($data2[$i][2], 0, '.', ',');?></td>
                        <td class="border text-right"><?php echo number_format($data2[$i][3], $dcl, '.', ',');?></td>
                        <td class="border text-right d-none"><?php echo number_format($data2[$i][4]-$data2[$i][6], $hdcl, '.', ',');?></td>
                        <td class="border text-right"><?php echo number_format($data2[$i][6], $sdcl, '.', ',');?></td>
                        <td class="border text-right"><?php echo number_format($ttls, $tsdcl, '.', ',');?></td>
                        <td class="border text-right d-none"><?php echo number_format($ttl-$ttls, $tdcl, '.', ',');?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>

                <tfoot>
                    <?php
                        $lsat = getAllSatuan();

                        $sarr = array(0, 0, 0, 0);
                        for($i = 0; $i < count($lsat); $i++)
                        {
                            $sum = getSumItemTrmSat($id, $lsat[$i][0], 2);

                            if($sum[0] == 0)
                                continue;

                            $sum[2] -= $sum[3];
                    ?>
                    <tr>
                        <td class="" colspan="3">Total Ikan <?php echo $lsat[$i][1];?></td>

                        <td class="text-right"><?php echo number_format($sum[0],0,'.',',');?> Ekor</td>

                        <td class="text-right"><?php if(isDecimal($sum[1])) echo number_format($sum[1],2,'.',','); else echo number_format($sum[1],0,'.',',');?> KG</td>

                        <td class="text-right" colspan="2"><?php if(isDecimal($sum[3])) echo number_format($sum[3],2,'.',','); else echo number_format($sum[3],0,'.',',');?></td>

                        <td class="text-right d-none" colspan="2"><?php if(isDecimal($sum[2])) echo number_format($sum[2],2,'.',','); else echo number_format($sum[2],0,'.',',');?></td>
                    </tr>
                    <?php
                            $sarr[0] += $sum[0];
                            $sarr[1] += $sum[1];
                            $sarr[2] += $sum[2];
                            $sarr[3] += $sum[3];
                        }
                    ?>
                    <tr>
                        <td class="text-left border-top border-dark" colspan="3">Total Ikan</td>

                        <td class="text-right border-top border-dark"><?php echo number_format($sarr[0],0,'.',',');?> Ekor</td>

                        <td class="text-right border-top border-dark"><?php if(isDecimal($sarr[1])) echo number_format($sarr[1],2,'.',','); else echo number_format($sarr[1],0,'.',',');?> KG</td>

                        <td class="text-right border-top border-dark" colspan="2"><?php if(isDecimal($sarr[3])) echo number_format($sarr[3],2,'.',','); else echo number_format($sarr[3],0,'.',',');?></td>

                        <td class="text-right border-top border-dark d-none" colspan="2"><?php if(isDecimal($sarr[2])) echo number_format($sarr[2],2,'.',','); else echo number_format($sarr[2],0,'.',',');?></td>
                    </tr>
                    
                    <tr>
                        <td class="text-right" colspan="6">Total Simpanan</td>

                        <td class="text-right" colspan="2"><?php if(isDecimal($sarr[3])) echo number_format($sarr[3],2,'.',','); else echo number_format($sarr[3],0,'.',',');?></td>
                    </tr>
                    
                    <tr>
                        <td class="font-weight-bold text-right" colspan="6">Total Simpanan (<?php echo date('d/m/Y', strtotime($data[2]));?>)</td>
                        <td colspan="2" class="text-right"><?php if(isDecimal($ssmpn)) echo number_format($ssmpn,2,'.',','); else echo number_format($ssmpn,0,'.',',');?></td>
                    </tr>
                </tfoot>
            </table>
            <?php
                }
            ?>
        </div>

        <div id="div-lp2" class="d-none">
            <div class="col-12 p-0">
                <h4 class="text-center">Tanda Terima Bahan</h4>
                <div class="my-1"><span class="font-weight-bold">No</span> : <?php echo $data[0];?></div>
                <div class="my-1"><span class="font-weight-bold">Tanggal</span> : <?php echo date('d - m - Y', strtotime($data[2]));?></div>
                <div class="my-1"><span class="font-weight-bold">Supplier</span> : <?php echo $sup[1];?></div>
            </div>

            <div class="row m-0">
            <?php
                $lsat = getTrmSat($id);
                for($i = 0; $i < count($lsat); $i++)
                {
                    $lsgrd = getTrmSatGrade($id, $lsat[$i][0]);
                    $sat = getSatuanID($lsat[$i][0]);
                    $litm = array();
                    $count = 0;
                    $tsum = array();
                    $sum = array(0, 0);
            ?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 p-1">
                <table class="table table-sm mt-2 mb-0">
                    <thead>
                        <tr class="thead-dark">
                            <th class="border align-middle text-center" rowspan="2">No</th>
                            <th class="border align-middle text-center" colspan="<?php echo count($lsgrd)*3;?>"><?php echo $sat[1];?></th>
                        </tr>
                        <tr class="thead-dark">
                        <?php
                            for($j = 0; $j < count($lsgrd); $j++)
                            {
                                $litm[$j] = getTrmSatGradeItem($id, $lsat[$i][0], $lsgrd[$j][0]);
                                $tsum[$j] = array(0, count($litm[$j]));
                                
                                if(count($litm[$j]) > $count)
                                    $count = count($litm[$j]);
                        ?>
                            <th class="border text-center" colspan="3"><?php echo $lsgrd[$j][1];?></th>
                        <?php
                            }
                        ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $count = ceil($count/3);
                            for($j = 0; $j < $count; $j++)
                            {
                        ?>
                        <tr>
                            <td class="border text-center small"><?php echo $j+1;?></td>
                            <?php
                                for($k = 0; $k < count($litm); $k++)
                                {
                                    $col2 = $j+ceil(count($litm[$k])/3);
                                    $col3 = $j+ceil(count($litm[$k])/3)*2;
                                    if(count($litm[$k]) < $count || $col2 < $count+$j)
                                    {
                                        $col2 = $j+$count;
                                        $col3 = $j+$count*2;
                                    }
                            ?>
                            <td class="text-center border small" style="width:<?php echo 100/(count($lsgrd)*3);?>%"><?php if(count($litm[$k]) > $j) { if(isDecimal($litm[$k][$j][2])) echo number_format($litm[$k][$j][2], 2, '.', ','); else echo number_format($litm[$k][$j][2] , 0, '.', ','); }?></td>
                            <td class="text-center border small" style="width:<?php echo 100/(count($lsgrd)*3);?>%"><?php if(count($litm[$k]) > $col2) { if(isDecimal($litm[$k][$col2][2])) echo number_format($litm[$k][$col2][2], 2, '.', ','); else echo number_format($litm[$k][$col2][2], 0, '.', ','); }?></td>
                            <td class="text-center border small" style="width:<?php echo 100/(count($lsgrd)*3);?>%"><?php if(count($litm[$k]) > $col3) { if(isDecimal($litm[$k][$col3][2])) echo number_format($litm[$k][$col3][2], 2, '.', ','); else echo number_format($litm[$k][$col3][2], 0, '.', ','); }?></td>
                            <?php
                                    if(count($litm[$k]) > $j)
                                        $tsum[$k][0] += $litm[$k][$j][2];

                                    if(count($litm[$k]) > $col2)
                                        $tsum[$k][0] += $litm[$k][$col2][2];

                                    if(count($litm[$k]) > $col3)
                                        $tsum[$k][0] += $litm[$k][$col3][2];
                                }
                            ?>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>

                <table class="table table-sm mb-2">
                    <tbody>
                        <td class="border align-middle text-center font-weight-bold" colspan="<?php if(count($lsgrd) == 1) echo 2; else echo count($lsgrd);?>">Rekap - <?php echo $sat[1];?></td>
                        <tr class="thead-dark">
                        <?php
                            for($j = 0; $j < count($lsgrd); $j++)
                            {
                        ?>
                            <td class="border text-center font-weight-bold" colspan="<?php if(count($lsgrd) == 1) echo 2;?>"><?php echo $lsgrd[$j][1];?></td>
                        <?php
                            }
                        ?>
                        </tr>
                        <tr>
                        <?php
                            for($j = 0; $j < count($lsgrd); $j++)
                            {
                        ?>
                            <td class="border text-center" colspan="<?php if(count($lsgrd) == 1) echo 2;?>"><?php echo number_format($tsum[$j][1], 0, '.', ',');?></td>
                        <?php
                                $sum[1] += $tsum[$j][1];
                            }
                        ?>
                        </tr>
                        <tr>
                        <?php
                            for($j = 0; $j < count($lsgrd); $j++)
                            {
                        ?>
                            <td class="border text-center" colspan="<?php if(count($lsgrd) == 1) echo 2;?>"><?php if(isDecimal($tsum[$j][0])) echo number_format($tsum[$j][0], 2, '.', ','); else echo number_format($tsum[$j][0], 0, '.', ',');?></td>
                        <?php
                                $sum[0] += $tsum[$j][0];
                            }
                        ?>
                        </tr>
                        <tr>
                            <td class="border text-right font-weight-bold" colspan="<?php echo count($lsgrd)-1;?>">Total (Ekor)</td>
                            <td class="border text-right font-weight-bold"><?php echo number_format($sum[1], 0, '.', ',');?></td>
                        </tr>
                        <tr>
                            <td class="border text-right font-weight-bold" colspan="<?php echo count($lsgrd)-1;?>">Total (KG)</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',');?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
                }
            ?>
            </div>
        </div>
    </div>

    <div class="div-mdl">
        <?php
            require("./modals/mdl-opt-trm.php");
        ?>
    </div>
</body>
</html>