<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    $data = getCutID($id);
    $data2 = getCutItem($id);
    $datacpro = getCutPro($id, $db);
    $datacnpro = getCutNPro($id, $db);
    $dllcut = getDllCutID($id);
    $dbl = getCutNoSampleDbl($id, $db);
    $dis = "";
    $min = 0;
    $max = 0;

    //$cgrade = array("F", "SP", "ST", "M", "B", "Vit");
    $cgrade = array("F", "SP", "ST", "M", "B");
    $csum = array(0, 0, 0, 0, 0, 0);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Cutting | PT. Winson Prima Sejahtera</title>
    
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
                if(cekAksUser(substr($duser[7], 119, 1)) || cekAksUser(substr($duser[7], 88, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <button class="btn btn-sm btn-light border border-success m-1" id="btn-pcut-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="25"> <span class="small">Excel</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-2 px-4 pb-3 div-print <?php if(!cekAksUser(substr($duser[7], 119, 1)) && !cekAksUser(substr($duser[7], 88, 1))) echo "no-print";?>">
        <div class="table-responsive" id="tbl-data">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th colspan="18" class="h4 font-weight-bold text-center">Tally Cutting</th>
                    </tr>
                    
                    <tr>
                        <th class="font-weight-bold text-left">Nomor</th>
                        <th colspan="3" class="text-left">: <?php echo $id;?></th>
                    </tr>
                    
                    <tr>
                        <th class="font-weight-bold text-left">Tanggal</th>
                        <th colspan="3" class="text-left">: <?php echo date('d - m - Y', strtotime($data[1]))." (".getJulianDate($data[1]).")";?></th>
                    </tr>
                    
                    <tr>
                        <th class="font-weight-bold text-left">Tally</th>
                        <th colspan="3" class="text-left">: <?php echo $data[3];?></th>
                    </tr>

                    <tr class="thead-dark">
                        <th class="border align-middle">No</th>
                        <th class="border align-middle">Supplier</th>
                        <th class="border align-middle">Ket</th>
                        <th class="border align-middle">Suhu</th>
                        <th class="border align-middle">Premium</th>
                        <th class="border align-middle">Tgl Msk</th>
                        <th class="border align-middle text-center">Qty (KG)</th>
                        <th class="border align-middle text-center">1</th>
                        <th class="border align-middle text-center">2</th>
                        <th class="border align-middle text-center">3</th>
                        <th class="border align-middle text-center">4</th>
                        <!-- <th class="border align-middle text-center">5</th>
                        <th class="border align-middle text-center">6</th> -->
                        <th class="border align-middle text-center">Ket</th>
                        <th class="border align-middle text-center">F</th>
                        <th class="border align-middle text-center">SP</th>
                        <th class="border align-middle text-center">ST</th>
                        <th class="border align-middle text-center">M</th>
                        <th class="border align-middle text-center">B</th>
                        <!-- <th class="border align-middle text-center">Vit</th> -->
                        <?php
                            for($i = 0; $i < count($dllcut); $i++)
                            {
                                $cgrade[count($cgrade)] = $dllcut[$i];
                                $csum[count($csum)] = 0;
                        ?>
                        <th class="border align-middle text-center"><?php echo $dllcut[$i];?></th>
                        <?php
                            }
                        ?>
                        <th class="border align-middle text-center">Total</th>
                        <th class="border align-middle text-center">%</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        for($i = 0; $i < count($data2); $i++)
                        {
                            if($min > $data2[$i][23] || $i == 0){
                                $min = $data2[$i][23];
                            }

                            if($data2[$i][23] > $max || $i == 0){
                                $max = $data2[$i][23];
                            }

                            $sum = array(0, 0, 0, 0, 0, 0);

                            for($j = 0; $j < count($dllcut); $j++)
                                $sum[count($sum)] = 0;

                            $idx1 = array_search($data2[$i][16], $cgrade);
                            $idx2 = array_search($data2[$i][17], $cgrade);
                            $idx3 = array_search($data2[$i][18], $cgrade);
                            $idx4 = array_search($data2[$i][19], $cgrade);
                            $idx5 = array_search($data2[$i][20], $cgrade);
                            $idx6 = array_search($data2[$i][21], $cgrade);
                            
                            if(strcasecmp($data2[$i][16],"Dll") == 0)
                                $idx1 = array_search($data2[$i][24], $cgrade);
                            
                            if(strcasecmp($data2[$i][17],"Dll") == 0)
                                $idx2 = array_search($data2[$i][25], $cgrade);
                            
                            if(strcasecmp($data2[$i][18],"Dll") == 0)
                                $idx3 = array_search($data2[$i][26], $cgrade);
                            
                            if(strcasecmp($data2[$i][19],"Dll") == 0)
                                $idx4 = array_search($data2[$i][27], $cgrade);
                            
                            if(strcasecmp($data2[$i][20],"Dll") == 0)
                                $idx5 = array_search($data2[$i][28], $cgrade);
                            
                            if(strcasecmp($data2[$i][21],"Dll") == 0)
                                $idx6 = array_search($data2[$i][29], $cgrade);
                            
                            $sum[$idx1] += $data2[$i][2];
                            $sum[$idx2] += $data2[$i][3];
                            $sum[$idx3] += $data2[$i][4];
                            $sum[$idx4] += $data2[$i][5];
                            $sum[$idx5] += $data2[$i][6];
                            $sum[$idx6] += $data2[$i][7];

                            $sttl = 0;
                            for($j = 0; $j < count($cgrade); $j++){
                                $sttl += $sum[$j];
                            }

                            $prsn = ($sttl / $data2[$i][11]) * 100;
                            
                            $bg = "print-text-black";
                            if((strcasecmp($data[7],"1") == 0 && $prsn > $data[2]) || (strcasecmp($data[7],"2") == 0 && $prsn < $data[2])){
                                $bg = "text-danger print-text-black";
                            }
                    ?>
                    <tr class="<?php echo $bg;?>">
                        <td class="border"><?php echo $data2[$i][23];?></td>
                        <td class="border"><?php echo $data2[$i][15];?></td>
                        <td class="border"><?php echo $data2[$i][36];?></td>
                        <td class="border text-center"><?php if(strcasecmp($data2[$i][37], "S") == 0) echo "<img src=\"./bin/img/icon/check.png\" width=\"25\">"; else if(strcasecmp($data2[$i][37],"T") == 0) echo "<img src=\"./bin/img/icon/double-check.png\" width=\"25\">";?></td>
                        <td class="border text-center"><?php if(strcasecmp($data2[$i][38], "Y") == 0) echo "PR"; else if(strcasecmp($data2[$i][38], "N") != 0) echo $data2[$i][38];?></td>
                        <td class="border"><?php echo $data2[$i][14];?></td>
                        <td class="border text-center"><?php if(isDecimal($data2[$i][11])) echo number_format($data2[$i][11], 2, '.', ','); else echo number_format($data2[$i][11], 0, '.', ','); echo " (".$data2[$i][13].")";?></td>
                        <td class="border text-center"><?php if($data2[$i][2] != 0) {if(isDecimal($data2[$i][2])) echo number_format($data2[$i][2], 2, '.', ','); else echo number_format($data2[$i][2], 0, '.', ','); echo " (".$data2[$i][16].")"; }?></td>
                        <td class="border text-center"><?php if($data2[$i][3] != 0) {if(isDecimal($data2[$i][3])) echo number_format($data2[$i][3], 2, '.', ','); else echo number_format($data2[$i][3], 0, '.', ','); echo " (".$data2[$i][17].")"; }?></td>
                        <td class="border text-center"><?php if($data2[$i][4] != 0) {if(isDecimal($data2[$i][4])) echo number_format($data2[$i][4], 2, '.', ','); else echo number_format($data2[$i][4], 0, '.', ','); echo " (".$data2[$i][18].")"; }?></td>
                        <td class="border text-center"><?php if($data2[$i][5] != 0) {if(isDecimal($data2[$i][5])) echo number_format($data2[$i][5], 2, '.', ','); else echo number_format($data2[$i][5], 0, '.', ','); echo " (".$data2[$i][19].")"; }?></td>
                        <!-- <td class="border text-center"><?php if($data2[$i][6] != 0) {if(isDecimal($data2[$i][6])) echo number_format($data2[$i][6], 2, '.', ','); else echo number_format($data2[$i][6], 0, '.', ','); echo " (".$data2[$i][20].")"; }?></td>
                        <td class="border text-center"><?php if($data2[$i][7] != 0) {if(isDecimal($data2[$i][7])) echo number_format($data2[$i][7], 2, '.', ','); else echo number_format($data2[$i][7], 0, '.', ','); echo " (".$data2[$i][21].")"; }?></td> -->
                        <td class="border text-center"><?php echo $data2[$i][22]?></td>
                        <?php
                            for($j = 0; $j < count($cgrade); $j++)
                            {
                                $csum[$j] += $sum[$j];
                        ?>
                        <td class="border text-center"><?php if($sum[$j] != 0) {if(isDecimal($sum[$j])) echo number_format($sum[$j], 2, '.', ','); else echo number_format($sum[$j], 0, '.', ',');}?></td>
                        <?php
                            }
                        ?>
                        <!-- <td class="border text-center"><?php if($sum[1] != 0) {if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if($sum[2] != 0) {if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if($sum[3] != 0) {if(isDecimal($sum[3])) echo number_format($sum[3], 2, '.', ','); else echo number_format($sum[3], 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if($sum[4] != 0) {if(isDecimal($sum[4])) echo number_format($sum[4], 2, '.', ','); else echo number_format($sum[4], 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if($sum[5] != 0) {if(isDecimal($sum[5])) echo number_format($sum[5], 2, '.', ','); else echo number_format($sum[5], 0, '.', ',');}?></td> -->
                        <td class="border text-center"><?php if($sttl != 0) {if(isDecimal($sttl)) echo number_format($sttl, 2, '.', ','); else echo number_format($sttl, 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if(isDecimal($prsn)) echo number_format($prsn, 2, '.', ','); else echo number_format($prsn, 0, '.', ',');?></td>
                    </tr>
                    <?php
                            $csum[count($cgrade)] += $sttl;
                        }
                    ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td class="border" colspan="12"></td>
                        <?php
                            for($i = 0; $i <= count($cgrade); $i++)
                            {
                        ?>
                        <td class="border text-center"><?php if($csum[$i] != 0) {if(isDecimal($csum[$i])) echo number_format($csum[$i], 2, '.', ','); else echo number_format($csum[$i], 0, '.', ',');}?></td>
                        <?php
                            }
                        ?>
                        <!-- <td class="border text-center"><?php if($csum[1] != 0) {if(isDecimal($csum[1])) echo number_format($csum[1], 2, '.', ','); else echo number_format($csum[1], 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if($csum[2] != 0) {if(isDecimal($csum[2])) echo number_format($csum[2], 2, '.', ','); else echo number_format($csum[2], 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if($csum[3] != 0) {if(isDecimal($csum[3])) echo number_format($csum[3], 2, '.', ','); else echo number_format($csum[3], 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if($csum[4] != 0) {if(isDecimal($csum[4])) echo number_format($csum[4], 2, '.', ','); else echo number_format($csum[4], 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if($csum[6] != 0) {if(isDecimal($csum[6])) echo number_format($csum[6], 2, '.', ','); else echo number_format($csum[6], 0, '.', ',');}?></td>
                        <td class="border text-center"><?php if(isDecimal($csum[5])) echo number_format($csum[5], 2, '.', ','); else echo number_format($csum[5], 0, '.', ',');?></td> -->
                    </tr>
                </tfoot>
            </table>

            <?php
                for($i = $min; $i <= $max; $i++){
                    $cek = false;
                    for($j = 0; $j < count($data2); $j++){
                        if(strcasecmp($i,$data2[$j][23]) == 0){
                            $cek = true;
                            break;
                        }
                    }

                    if(!$cek){
                        if(strcasecmp($dis,"") != 0){
                            $dis .= ", ";
                        }

                        $dis .= $i;
                    }
                }

                if(strcasecmp($dbl,"") == 0){
                    $dbl = "Tidak ada data";
                }

                if(strcasecmp($dis,"") == 0){
                    $dis = "Tidak ada data";
                }
            ?>
            <div>
                <div class="font-weight-bold">NB:</div>
                <div class="">Nomor sampel yang double dari <?php echo $min."-".$max." = <strong>".$dbl."</strong>";?></div>
                <div class="mb-1">Nomor sampel yang tidak ada dari <?php echo $min."-".$max." = <strong>".$dis."</strong>";?></div>
            </div>

            <h4 class="mt-5">Hasil Tetelan dan lainnya</h4>
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="border">Kode Produk</th>
                        <th class="border">Nama Produk</th>
                        <th class="border text-right">Berat</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $sum_ttl = 0;
                        for($i = 0; $i < count($datacpro); $i++){
                            $nama = $datacpro[$i][4]." / ".$datacpro[$i][5];

                            if(strcasecmp($datacpro[$i][6],"") != 0){
                                $nama .= " / ".$datacpro[$i][6];
                            }

                            if(strcasecmp($datacpro[$i][7],"") != 0){
                                $nama .= " / ".$datacpro[$i][7];
                            }
                    ?>
                    <tr>
                        <td class="border"><?php echo $datacpro[$i][1];?></td>
                        <td class="border"><?php echo $nama;?></td>
                        <td class="border text-right"><?php if(isDecimal($datacpro[$i][2])) echo number_format($datacpro[$i][2],2,'.',','); else echo number_format($datacpro[$i][2],0,'.',',');?></td>
                    </tr>
                    <?php
                            $sum_ttl += $datacpro[$i][2];
                        }
                    ?>
                </tbody>
            </table>

            <h4 class="mt-5">Hasil Tulang dan lainnya</h4>
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="border">Kode Produk</th>
                        <th class="border">Nama Produk</th>
                        <th class="border text-right">Berat</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $sum_tlg = 0;
                        for($i = 0; $i < count($datacnpro); $i++){
                            $nama = $datacnpro[$i][4]." / ".$datacnpro[$i][5];

                            if(strcasecmp($datacnpro[$i][6],"") != 0){
                                $nama .= " / ".$datacnpro[$i][6];
                            }

                            if(strcasecmp($datacnpro[$i][7],"") != 0){
                                $nama .= " / ".$datacnpro[$i][7];
                            }
                    ?>
                    <tr>
                        <td class="border"><?php echo $datacnpro[$i][1];?></td>
                        <td class="border"><?php echo $nama;?></td>
                        <td class="border text-right"><?php if(isDecimal($datacnpro[$i][2])) echo number_format($datacnpro[$i][2],2,'.',','); else echo number_format($datacnpro[$i][2],0,'.',',');?></td>
                    </tr>
                    <?php
                            $sum_tlg += $datacnpro[$i][2];
                        }
                    ?>
                </tbody>
            </table>
            
            <?php
                $data3 = getSumGradeCutID($id);
                $data4 = getSumTotalCut($id);
                $data5 = getEkorTotalCut($id);

                //REKAP CUTTING
            ?>
            <h4 class="mt-5">Rekap Cutting</h4>
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="border text-center" colspan="<?php echo count($data3);?>">Total Weight</th>
                        <th class="border text-center" colspan="<?php echo count($data4);?>">Total Cutting</th>
                        <th class="border text-center" colspan="<?php echo count($data5);?>">Total Ekor</th>
                        <th class="border text-center align-middle" rowspan="2">%</th>
                        <th class="border text-center align-middle" rowspan="2">Total Hasil Tetelan dan lainnya</th>
                        <th class="border text-center align-middle" rowspan="2">%</th>
                        <th class="border text-center align-middle" rowspan="2">Total Hasil Tulang dan lainnya</th>
                        <th class="border text-center align-middle" rowspan="2">%</th>
                    </tr>
                    
                    <tr>
                        <?php
                            for($i = 0; $i < count($data3); $i++)
                            {
                        ?>
                        <th class="border text-center"><?php echo $data3[$i][0];?></th>
                        <?php
                            }
                        ?>

                        <?php
                            for($i = 0; $i < count($data4); $i++)
                            {
                        ?>
                        <th class="border text-center"><?php echo $data4[$i][0];?></th>
                        <?php
                            }
                        ?>

                        <?php
                            for($i = 0; $i < count($data5); $i++)
                            {
                        ?>
                        <th class="border text-center"><?php echo $data5[$i][0];?></th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php
                            $sum = 0;
                            for($i = 0; $i < count($data3); $i++)
                            {
                                $sum += $data3[$i][1];
                        ?>
                        <td class="border text-center"><?php if(isDecimal($data3[$i][1])) echo number_format($data3[$i][1], 2, '.', ','); else echo number_format($data3[$i][1], 0, '.', ',');?></td>
                        <?php
                            }
                        ?>
                        
                        <?php
                            $sumC = 0;
                            for($i = 0; $i < count($data4); $i++)
                            {
                                $sumC += $data4[$i][1];
                        ?>
                        <td class="border text-center"><?php if(isDecimal($data4[$i][1])) echo number_format($data4[$i][1], 2, '.', ','); else echo number_format($data4[$i][1], 0, '.', ',');?></td>
                        <?php
                            }
                        ?>

                        <?php
                            $sumE = 0;
                            for($i = 0; $i < count($data5); $i++)
                            {
                                $sumE += $data5[$i][1];
                        ?>
                        <td class="border text-center"><?php if(isDecimal($data5[$i][1])) echo number_format($data5[$i][1], 2, '.', ','); else echo number_format($data5[$i][1], 0, '.', ',');?></td>
                        <?php
                            }
                        ?>

                        <td class="border text-center align-middle" rowspan="2">
                            <?php if(isDecimal($csum[count($csum)-1]/$sum)) echo number_format($csum[count($csum)-1]/$sum*100, 2, '.', ','); else echo number_format($csum[count($csum)-1]/$sum*100, 0, '.', ',');?>
                        </td>

                        <td class="border text-center align-middle" rowspan="2">0</td>

                        <td class="border text-center align-middle" rowspan="2">0</td>

                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($sum_tlg)) echo number_format($sum_tlg, 2, '.', ','); else echo number_format($sum_tlg, 0, '.', ',');?></td>
                        
                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($sum_tlg/$sum)) echo number_format($sum_tlg/$sum*100, 2, '.', ','); else echo number_format($sum_tlg/$sum*100, 0, '.', ',');?></td>
                    </tr>

                    <tr>
                        <td class="border text-center" colspan="<?php echo count($data3);?>">
                            <?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?>
                        </td>

                        <td class="border text-center" colspan="<?php echo count($data4);?>">
                            <?php if(isDecimal($sumC)) echo number_format($sumC, 2, '.', ','); else echo number_format($sumC, 0, '.', ',');?>
                        </td>
                        
                        <td class="border text-center" colspan="<?php echo count($data5);?>">
                            <?php if(isDecimal($sumE)) echo number_format($sumE, 2, '.', ','); else echo number_format($sumE, 0, '.', ',');?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h4 class="mt-5">Total Keseluruhan</h4>
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="border text-center" colspan="<?php echo count($data3);?>">Total Weight</th>
                        <th class="border text-center align-middle" rowspan="2">Total Ekor</th>
                        <th class="border text-center align-middle" rowspan="2">Total Cutting</th>
                        <!-- <th class="border text-center align-middle" rowspan="2">Total Non-Vitamin</th>
                        <th class="border text-center align-middle" rowspan="2">Total Vitamin</th> -->
                        <th class="border text-center align-middle" rowspan="2">%</th>
                    </tr>
                    
                    <tr>
                        <?php
                            for($i = 0; $i < count($data3); $i++)
                            {
                        ?>
                        <th class="border text-center"><?php echo $data3[$i][0];?></th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php
                            $sum = 0;
                            for($i = 0; $i < count($data3); $i++)
                            {
                                $sum += $data3[$i][1];
                        ?>
                        <td class="border text-center"><?php if(isDecimal($data3[$i][1])) echo number_format($data3[$i][1], 2, '.', ','); else echo number_format($data3[$i][1], 0, '.', ',');?></td>
                        <?php
                            }
                        ?>
                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal(count($data2))) echo number_format(count($data2), 2, '.', ','); else echo number_format(count($data2), 0, '.', ',');?></td>
                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($csum[count($csum)-1])) echo number_format($csum[count($csum)-1], 2, '.', ','); else echo number_format($csum[count($csum)-1], 0, '.', ',');?></td>
                        <!-- <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($csum[count($csum)-1]-$csum[5])) echo number_format($csum[count($csum)-1]-$csum[5], 2, '.', ','); else echo number_format($csum[count($csum)-1]-$csum[5], 0, '.', ',');?></td>
                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($csum[5])) echo number_format($csum[5], 2, '.', ','); else echo number_format($csum[5], 0, '.', ',');?></td> -->
                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($csum[count($csum)-1]/$sum)) echo number_format($csum[count($csum)-1]/$sum*100, 2, '.', ','); else echo number_format($csum[count($csum)-1]/$sum*100, 0, '.', ',');?></td>
                    </tr>

                    <tr>
                        <td class="border text-center" colspan="<?php echo count($data3);?>"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?></td>
                    </tr>
                </tbody>
            </table>

            <?php
                //TOTAL KESELURUHAN PER-PRODUK
                $lpro = getListProCut($id);
                
                for($i = 0; $i < count($lpro); $i++)
                {
                    $data3 = getSumGradeCutProID($id, $lpro[$i]);
            ?>
            <h4 class="mt-5 d-none">Total Keseluruhan (<?php echo ucwords(strtolower($lpro[$i]));?>)</h4>
            <table class="table table-sm table-striped d-none">
                <thead class="thead-dark">
                    <tr>
                        <th class="border text-center" colspan="<?php echo count($data3);?>">Total Weight</th>
                        <th class="border text-center align-middle" rowspan="2">Total Cutting</th>
                        <th class="border text-center align-middle" rowspan="2">%</th>
                    </tr>
                    
                    <tr>
                        <?php
                            for($j = 0; $j < count($data3); $j++)
                            {
                        ?>
                        <th class="border text-center"><?php echo $data3[$j][0];?></th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php
                            $sum = 0;
                            $cksum = 0;
                            for($j = 0; $j < count($data3); $j++)
                            {
                                $sum += $data3[$j][1];
                                $cksum += $data3[$j][2];
                        ?>
                        <td class="border text-center"><?php if(isDecimal($data3[$j][1])) echo number_format($data3[$j][1], 2, '.', ','); else echo number_format($data3[$j][1], 0, '.', ',');?></td>
                        <?php
                            }
                        ?>
                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($cksum)) echo number_format($cksum, 2, '.', ','); else echo number_format($cksum, 0, '.', ',');?></td>
                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($cksum/$sum)) echo number_format($cksum/$sum*100, 2, '.', ','); else echo number_format($cksum/$sum*100, 0, '.', ',');?></td>
                    </tr>

                    <tr>
                        <td class="border text-center" colspan="<?php echo count($data3);?>"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?></td>
                    </tr>
                </tbody>
            </table>
            <?php
                }

                $lkota = getListKotaCut($id);

                for($i = 0; $i < count($lkota); $i++)
                {
                    $data3 = getSumGradeCutKotaID($id, $lkota[$i]);
            ?>
            <h4 class="mt-5">Total <?php echo ucwords(strtolower($lkota[$i]));?></h4>
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="border text-center" colspan="<?php echo count($data3);?>">Total Weight</th>
                        <th class="border text-center align-middle" rowspan="2">Total Cutting</th>
                        <th class="border text-center align-middle" rowspan="2">%</th>
                    </tr>
                    
                    <tr>
                        <?php
                            for($j = 0; $j < count($data3); $j++)
                            {
                        ?>
                        <th class="border text-center"><?php echo $data3[$j][0];?></th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php
                            $sum = 0;
                            $cksum = 0;
                            for($j = 0; $j < count($data3); $j++)
                            {
                                $sum += $data3[$j][1];
                                $cksum += $data3[$j][2];
                        ?>
                        <td class="border text-center"><?php if(isDecimal($data3[$j][1])) echo number_format($data3[$j][1], 2, '.', ','); else echo number_format($data3[$j][1], 0, '.', ',');?></td>
                        <?php
                            }
                        ?>
                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($cksum)) echo number_format($cksum, 2, '.', ','); else echo number_format($cksum, 0, '.', ',');?></td>
                        <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($cksum/$sum)) echo number_format($cksum/$sum*100, 2, '.', ','); else echo number_format($cksum/$sum*100, 0, '.', ',');?></td>
                    </tr>

                    <tr>
                        <td class="border text-center" colspan="<?php echo count($data3);?>"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?></td>
                    </tr>
                </tbody>
            </table>
            <?php
                }

                //TOTAL PERTANGGAL
                $ltgl = getListTglCut($id);
                for($i = 0; $i < count($ltgl); $i++)
                {
                    $data3 = getSumGradeCutIDTgl($id, $ltgl[$i]);
                ?>
                <hr class="my-5">
                <h4>Total Keseluruhan (<?php echo date('d/m/Y', strtotime($ltgl[$i]));?>)</h4>
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border text-center" colspan="<?php echo count($data3);?>">Total Weight</th>
                            <th class="border text-center align-middle" rowspan="2">Total Cutting</th>
                            <th class="border text-center align-middle" rowspan="2">%</th>
                        </tr>
                        
                        <tr>
                            <?php
                                for($j = 0; $j < count($data3); $j++)
                                {
                            ?>
                            <th class="border text-center"><?php echo $data3[$j][0];?></th>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>
    
                    <tbody>
                        <tr>
                            <?php
                                $sum = 0;
                                $cksum = 0;
                                for($j = 0; $j < count($data3); $j++)
                                {
                                    $sum += $data3[$j][1];
                                    $cksum += $data3[$j][2];
                            ?>
                            <td class="border text-center"><?php if(isDecimal($data3[$j][1])) echo number_format($data3[$j][1], 2, '.', ','); else echo number_format($data3[$j][1], 0, '.', ',');?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($cksum)) echo number_format($cksum, 2, '.', ','); else echo number_format($cksum, 0, '.', ',');?></td>
                            <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($cksum/$sum)) echo number_format($cksum/$sum*100, 2, '.', ','); else echo number_format($cksum/$sum*100, 0, '.', ',');?></td>
                        </tr>
    
                        <tr>
                            <td class="border text-center" colspan="<?php echo count($data3);?>"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?></td>
                        </tr>
                    </tbody>
                </table>
    
                <?php
                    $lkota = getListKotaCutTgl($id, $ltgl[$i]);
                    
                    for($j = 0; $j < count($lkota); $j++)
                    {
                        $data3 = getSumGradeCutKotaIDTgl($id, $lkota[$j], $ltgl[$i]);
                ?>
                <h4 class="mt-5">Total <?php echo ucwords(strtolower($lkota[$j]))." (".date('d/m/Y', strtotime($ltgl[$i])).")";?></h4>
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border text-center" colspan="<?php echo count($data3);?>">Total Weight</th>
                            <th class="border text-center align-middle" rowspan="2">Total Cutting</th>
                            <th class="border text-center align-middle" rowspan="2">%</th>
                        </tr>
                        
                        <tr>
                            <?php
                                for($k = 0; $k < count($data3); $k++)
                                {
                            ?>
                            <th class="border text-center"><?php echo $data3[$k][0];?></th>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>
    
                    <tbody>
                        <tr>
                            <?php
                                $sum = 0;
                                $cksum = 0;
                                for($k = 0; $k < count($data3); $k++)
                                {
                                    $sum += $data3[$k][1];
                                    $cksum += $data3[$k][2];
                            ?>
                            <td class="border text-center"><?php if(isDecimal($data3[$k][1])) echo number_format($data3[$k][1], 2, '.', ','); else echo number_format($data3[$k][1], 0, '.', ',');?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($cksum)) echo number_format($cksum, 2, '.', ','); else echo number_format($cksum, 0, '.', ',');?></td>
                            <td class="border text-center align-middle" rowspan="2"><?php if(isDecimal($cksum/$sum)) echo number_format($cksum/$sum*100, 2, '.', ','); else echo number_format($cksum/$sum*100, 0, '.', ',');?></td>
                        </tr>
    
                        <tr>
                            <td class="border text-center" colspan="<?php echo count($data3);?>"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?></td>
                        </tr>
                    </tbody>
                </table>
            <?php
                    }
                }

                CloseDB($db);
            ?>
        </div>
    </div>
</body>
</html>