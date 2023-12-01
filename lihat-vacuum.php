<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    $data = getVacID($id);
    $pro = getProID($data[5]);
    $grade = getGradeID($pro[4]);
    $kate = getKateID($pro[2]);
    $skate = getSKateID($pro[3]);
    $pro2 = getProID($data[15]);
    $grade2 = getGradeID($pro2[4]);
    $kate2 = getKateID($pro2[2]);
    $skate2 = getSKateID($pro2[3]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Vacuum | PT. Winson Prima Sejahtera</title>
    
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
                if(cekAksUser(substr($duser[7], 119, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-2 container pb-3 div-print <?php if(!cekAksUser(substr($duser[7], 119, 1))) echo "no-print";?>">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="15" class="h4 font-weight-bold text-center">Tally Vacuum</th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Nomor</th>
                    <th colspan="4" class="text-left">: <?php echo $id;?></th>
                    <th class="font-weight-bold text-right" colspan="6">Dari</th>
                    <th colspan="4" class="text-left">: 
                    <?php
                        if(strcasecmp($data[2],"1") == 0){ 
                            echo "Cutting"; 
                            if(strcasecmp($data[14],"1") == 0) 
                                echo " - Non Vitamin"; 
                            else if(strcasecmp($data[14],"2") == 0) echo " - Vitamin";
                        }
                        else echo "Bahan Setengah Jadi";
                    ?>
                    </th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Tanggal</th>
                    <th colspan="4" class="text-left">: <?php echo date('d - m - Y', strtotime($data[1]));?></th>
                    <th class="font-weight-bold text-right align-top" colspan="6"><?php if(strcasecmp($data[2],"1") == 0) echo "Tanggal"; else echo "Bahan";?></th>
                    <th colspan="4" class="text-left">: 
                        <?php
                            if(strcasecmp($data[2],"1") == 0) 
                                echo date('d/m/Y', strtotime($data[3])); 
                            else
                            {
                                if(strcasecmp($pro[1],"") != 0)
                                    echo "- ".$pro[1];

                                if(strcasecmp($grade[1],"") != 0)
                                    echo " / ".$grade[1];

                                if(strcasecmp($kate[1],"") != 0)
                                    echo " / ".$kate[1];
                                
                                if(strcasecmp($skate[1],"") != 0)
                                    echo " / ".$skate[1];

                                    if(isDecimal($data[6]))
                                    echo " ( ".number_format($data[6], 2, '.',' ,')." KG)";
                                else
                                    echo " ( ".number_format($data[6], 0, '.',' ,')." KG)";

                                if(strcasecmp($pro2[1],"") != 0)
                                {
                                    echo "<br> - ".$pro2[1];

                                    if(strcasecmp($grade2[1],"") != 0)
                                        echo " / ".$grade2[1];

                                    if(strcasecmp($kate2[1],"") != 0)
                                        echo " / ".$kate2[1];
                                    
                                    if(strcasecmp($skate2[1],"") != 0)
                                        echo " / ".$skate2[1];

                                    if(isDecimal($data[16]))
                                        echo " ( ".number_format($data[16], 2, '.',' ,')." KG)";
                                    else
                                        echo " ( ".number_format($data[16], 0, '.',' ,')." KG)";
                                }
                            }
                        ?>
                    </th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Tally</th>
                    <th colspan="4" class="text-left">: <?php echo $data[4];?></th>
                    <th class="font-weight-bold text-right" colspan="6">Ket</th>
                    <th colspan="4" class="text-left">: <?php echo $data[12];?></th>
                </tr>
                
                <?php
                    if(strcasecmp($data[2],"1") == 0)
                    {
                ?>
                <tr>
                    <th class="font-weight-bold text-left">Thp ke</th>
                    <th colspan="4" class="text-left">: <?php echo $data[13];?></th>
                </tr>
                <?php
                    }
                ?>

                <tr class="thead-dark">
                    <th class="border align-middle">Kode Produk</th>
                    <th class="border align-middle">Produk</th>
                    <th class="border align-middle text-center">1</th>
                    <th class="border align-middle text-center">2</th>
                    <th class="border align-middle text-center">3</th>
                    <th class="border align-middle text-center">4</th>
                    <th class="border align-middle text-center">5</th>
                    <th class="border align-middle text-center">6</th>
                    <th class="border align-middle text-center">7</th>
                    <th class="border align-middle text-center">8</th>
                    <th class="border align-middle text-center">9</th>
                    <th class="border align-middle text-center">10</th>
                    <th class="border align-middle text-center">Sub Total (KG)</th>
                    <th class="border align-middle text-center">Grand Total (KG)</th>
                    <th class="border align-middle">Keterangan</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $data2 = getProVacItem($id);

                    $vsum = 0;
                    for($i = 0; $i < count($data2); $i++){
                        $sum = 0;
                        $nmpro = $data2[$i][1]." / ".$data2[$i][2];

                        if(strcasecmp($data2[$i][3],"") != 0){
                            $nmpro .= " / ".$data2[$i][3];
                        }

                        if(strcasecmp($data2[$i][4],"") != 0){
                            $nmpro .= " / ".$data2[$i][4];
                        }
                ?>
                <tr>
                    <td class="border"><?php echo $data2[$i][0];?></td>
                    <td class="border"><?php echo $nmpro;?></td>
                    <?php
                        $data3 = getProVacItemID($id, $data2[$i][0]);
                        $cspan = count($data3) / 10;

                        $n = 0;

                        if(count($data3) % 10 != 0)
                            $cspan++;
                        for($j = 1; $j <= count($data3); $j++)
                        {
                            $sum += $data3[$j-1][0];
                    ?>
                    <td class="border text-center"><?php if(isDecimal($data3[$j-1][0])) echo number_format($data3[$j-1][0], 2, '.', ','); else echo number_format($data3[$j-1][0], 0, '.', ',');?></td>
                    <?php
                            if($j % 10 == 0 && $j != 0)
                            {
                    ?>
                    <td class="border text-center"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?></td>
                    <?php
                                $sum = 0;
                                
                                if($j == 10)
                                {
                                    $vssum = getSumVacItemID($id, $data2[$i][0]);
                                    $ket = "";
                                    $data4 = getProVacItemID($id, $data2[$i][0]);

                                    for($k = 0; $k < count($data4); $k++)
                                    {
                                        if(strcasecmp($ket, "") != 0 && strcasecmp($data4[$k][1],"") != 0)
                                            $ket .= ", ".$data4[$k][1];
                                        else if(strcasecmp($data4[$k][1],"") != 0)
                                            $ket .= $data4[$k][1];
                                    }
                    ?>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php if(isDecimal($vssum)) echo number_format($vssum, 2, '.', ','); else echo number_format($vssum, 0, '.', ',');?></td>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php echo $ket;?></td>
                    <?php
                                    $vsum += $vssum;
                                }
                                
                                if($n < $cspan)
                                {
                                    echo "</tr><tr><td class=\"border\" colspan=\"4\"></td>";
                                    $n++;
                                }
                                
                                /*if(count($data3) % 10 == 0 && $j != count($data3))
                                    echo "</tr><tr><td class=\"border\" colspan=\"4\"></td>";
                                else if($i != count($data2) - 1 && count($data3) % 10 != 0 )
                                    echo "</tr><tr><td class=\"border\" colspan=\"4\"></td>";*/
                            }
                        }
                        
                        if(count($data3) % 10 != 0)
                        {
                            
                            for($j = (int)(count($data3) % 10); $j < 10; $j++)
                            {
                    ?>
                    <td class="border"></td>
                    <?php
                            }
                    ?>
                    <td class="border text-center"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',')?></td>
                    <?php
                        }
                        
                        if(count($data3) < 10)
                        {
                            $vssum = getSumVacItemID($id, $data2[$i][0]);
                            $ket = "";
                            $data4 = getProVacItemID($id, $data2[$i][0]);

                            for($k = 0; $k < count($data4); $k++)
                            {
                                if(strcasecmp($ket, "") != 0 && strcasecmp($data4[$k][1],"") != 0)
                                    $ket .= ", ".$data4[$k][1];
                                else if(strcasecmp($data4[$k][1],"") != 0)
                                    $ket .= $data4[$k][1];
                            }
                    ?>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php if(isDecimal($vssum)) echo number_format($vssum, 2, '.', ','); else echo number_format($vssum, 0, '.', ',');?></td>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php echo $ket;?></td>
                    <?php
                            $vsum += $vssum;
                        }
                    ?>
                </tr>
                <?php
                    }
                ?>
                <tr>
                    <td class="border" colspan="13"></td>
                    <td class="border text-center"><?php if(isDecimal($vsum)) echo number_format($vsum, 2, '.', ','); else echo number_format($vsum, 0, '.', ',');?></td>
                </tr>
            </tbody>
        </table>

        <div class="my-2">
            <h6>Rincian Singkat :</h6>
            <ul>
                <?php
                    $dtl = getVacItem3($id);

                    for($j = 0; $j < count($dtl); $j++)
                    {
                        $jlh = number_format($dtl[$j][4], 0, '.', ',');

                        if(isDecimal($dtl[$j][4]))
                            $jlh = number_format($dtl[$j][4], 2, '.', ',');
                ?>
                    <li><?php echo $dtl[$j][5]." / ".$dtl[$j][0]; if(strcasecmp($dtl[$j][1],"") != 0) echo " / ".$dtl[$j][1]; if(strcasecmp($dtl[$j][2],"") != 0) echo " / ".$dtl[$j][2]; if(strcasecmp($dtl[$j][3],"") != 0) echo " / ".$dtl[$j][3]; echo " (<strong>".$jlh." KG</strong>) "?></li>
                <?php
                    }
                ?>
            </ul>
        </div>

        <div class="pagebreak"></div>
        <table class="table table-sm table-striped">
            
        <thead>
                <tr>
                    <th colspan="15" class="h4 font-weight-bold text-center">Tally Vacuum - Per Grade</th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Nomor</th>
                    <th colspan="4" class="text-left">: <?php echo $id;?></th>
                    <th class="font-weight-bold text-right" colspan="6">Dari</th>
                    <th colspan="4" class="text-left">: 
                    <?php
                        if(strcasecmp($data[2],"1") == 0) 
                        { 
                            echo "Cutting"; 
                            if(strcasecmp($data[14],"1") == 0) 
                                echo " - Non Vitamin"; 
                            else if(strcasecmp($data[14],"2") == 0) echo " - Vitamin";
                        }
                        else echo "Bahan Setengah Jadi";
                    ?>
                    </th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Tanggal</th>
                    <th colspan="4" class="text-left">: <?php echo date('d - m - Y', strtotime($data[1]));?></th>
                    <th class="font-weight-bold text-right align-top" colspan="6"><?php if(strcasecmp($data[2],"1") == 0) echo "Tanggal"; else echo "Bahan";?></th>
                    <th colspan="4" class="text-left">: 
                        <?php
                            if(strcasecmp($data[2],"1") == 0) 
                                echo date('d/m/Y', strtotime($data[3])); 
                            else
                            {
                                if(strcasecmp($pro[1],"") != 0)
                                    echo "- ".$pro[1];

                                if(strcasecmp($grade[1],"") != 0)
                                    echo " / ".$grade[1];

                                if(strcasecmp($kate[1],"") != 0)
                                    echo " / ".$kate[1];
                                
                                if(strcasecmp($skate[1],"") != 0)
                                    echo " / ".$skate[1];

                                    if(isDecimal($data[6]))
                                    echo " ( ".number_format($data[6], 2, '.',' ,')." KG)";
                                else
                                    echo " ( ".number_format($data[6], 0, '.',' ,')." KG)";

                                if(strcasecmp($pro2[1],"") != 0)
                                {
                                    echo "<br> - ".$pro2[1];

                                    if(strcasecmp($grade2[1],"") != 0)
                                        echo " / ".$grade2[1];

                                    if(strcasecmp($kate2[1],"") != 0)
                                        echo " / ".$kate2[1];
                                    
                                    if(strcasecmp($skate2[1],"") != 0)
                                        echo " / ".$skate2[1];

                                    if(isDecimal($data[16]))
                                        echo " ( ".number_format($data[16], 2, '.',' ,')." KG)";
                                    else
                                        echo " ( ".number_format($data[16], 0, '.',' ,')." KG)";
                                }
                            }
                        ?>
                    </th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Grade</th>
                    <th colspan="4" class="text-left">: <?php echo $data[4];?></th>
                    <th class="font-weight-bold text-right" colspan="6">Ket</th>
                    <th colspan="4" class="text-left">: <?php echo $data[12];?></th>
                </tr>
                
                <?php
                    if(strcasecmp($data[2],"1") == 0)
                    {
                ?>
                <tr>
                    <th class="font-weight-bold text-left">Thp ke</th>
                    <th colspan="4" class="text-left">: <?php echo $data[13];?></th>
                </tr>
                <?php
                    }
                ?>

                <tr class="thead-dark">
                    <th class="border align-middle">Grade</th>
                    <th class="border align-middle">Kode Produk</th>
                    <th class="border align-middle">Produk</th>
                    <th class="border align-middle text-center">1</th>
                    <th class="border align-middle text-center">2</th>
                    <th class="border align-middle text-center">3</th>
                    <th class="border align-middle text-center">4</th>
                    <th class="border align-middle text-center">5</th>
                    <th class="border align-middle text-center">6</th>
                    <th class="border align-middle text-center">7</th>
                    <th class="border align-middle text-center">8</th>
                    <th class="border align-middle text-center">9</th>
                    <th class="border align-middle text-center">10</th>
                    <th class="border align-middle text-center">Sub Total (KG)</th>
                    <th class="border align-middle text-center">Grand Total (KG)</th>
                    <th class="border align-middle">Keterangan</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $lgrade = getVacGradeID($id, $db);
                    $vsum = 0;
                    $tgrade = "";
                    for($m = 0; $m < count($lgrade); $m++){
                        $data2 = getProVacItem2($id, $lgrade[$m][0], $db);

                        for($i = 0; $i < count($data2); $i++){
                            $sum = 0;
                            $nmpro = $data2[$i][1]." / ".$data2[$i][2];

                            if(strcasecmp($data2[$i][3],"") != 0){
                                $nmpro .= " / ".$data2[$i][3];
                            }

                            if(strcasecmp($data2[$i][4],"") != 0){
                                $nmpro .= " / ".$data2[$i][4];
                            }
                ?>
                <tr>
                    <?php
                            if(strcasecmp($lgrade[$m][0], $tgrade) != 0){
                                $tgrade = $lgrade[$m][0];
                    ?>
                    <td class="border"><?php echo $lgrade[$m][1];?></td>
                    <?php
                            }
                            else{
                    ?>
                    <td class="border"></td>
                    <?php
                            }
                    ?>
                    <td class="border"><?php echo $data2[$i][0];?></td>
                    <td class="border"><?php echo $nmpro;?></td>
                        <?php
                            $data3 = getProVacItemID2($id, $data2[$i][0], $tgrade, $db);
                            $cspan = count($data3) / 10;

                            $n = 0;
                            if(count($data3) % 10 != 0){
                                $cspan++;
                            }

                            for($j = 1; $j <= count($data3); $j++){
                                $sum += $data3[$j-1][0];
                        ?>
                    <td class="border text-center"><?php if(isDecimal($data3[$j-1][0])) echo number_format($data3[$j-1][0], 2, '.', ','); else echo number_format($data3[$j-1][0], 0, '.', ',');?></td>
                    <?php
                                if($j % 10 == 0 && $j != 0){
                    ?>
                    <td class="border text-center"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?></td>
                    <?php
                                    $sum = 0;
                                    if($j == 10){
                                        $vssum = getSumVacItemID2($id, $data2[$i][0], $tgrade, $db);
                    ?>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php if(isDecimal($vssum)) echo number_format($vssum, 2, '.', ','); else echo number_format($vssum, 0, '.', ',');?></td>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php echo $ket;?></td>
                    <?php
                                        $vsum += $vssum;
                                    }
                                    
                                    if($n < $cspan){
                                        echo "</tr><tr><td class=\"border\" colspan=\"4\"></td>";
                                        $n++;
                                    }
                                }
                            }
                            
                            if(count($data3) % 10 != 0){
                                for($j = (int)(count($data3) % 10); $j < 10; $j++){
                    ?>
                    <td class="border"></td>
                    <?php
                                }
                    ?>
                    <td class="border text-center"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',')?></td>
                    <?php
                            }
                            
                            if(count($data3) < 10){
                                $vssum = getSumVacItemID2($id, $data2[$i][0], $tgrade, $db);
                    ?>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php if(isDecimal($vssum)) echo number_format($vssum, 2, '.', ','); else echo number_format($vssum, 0, '.', ',');?></td>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php echo $ket;?></td>
                    <?php
                                $vsum += $vssum;
                            }
                    ?>
                </tr>
                <?php
                        }
                    }
                ?>
                <tr>
                    <td class="border" colspan="14"></td>
                    <td class="border text-center"><?php if(isDecimal($vsum)) echo number_format($vsum, 2, '.', ','); else echo number_format($vsum, 0, '.', ',');?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
        CloseDB($db);
    ?>
</body>
</html>