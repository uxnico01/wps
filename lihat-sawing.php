<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    CloseDB($db);

    $data = getSawID($id);
    $pro = getProID($data[3]);
    $grade = getGradeID($pro[4]);
    $kate = getKateID($pro[2]);
    $skate = getSKateID($pro[3]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Sawing | PT. Winson Prima Sejahtera</title>
    
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
                    <th colspan="17" class="h4 font-weight-bold text-center">Tally Sawing</th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Nomor</th>
                    <th colspan="4" class="text-left">: <?php echo $id;?></th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Tanggal</th>
                    <th colspan="4" class="text-left">: <?php echo date('d - m - Y', strtotime($data[1]));?></th>
                    <?php
                        if($data[10] != 0 && $data[10] != null)
                        {
                    ?>
                    <th class="font-weight-bold text-right" colspan="6">Bahan</th>
                    <th colspan="5" class="text-left">: 
                        <?php 
                            if(strcasecmp($pro[1],"") != 0)
                                echo $pro[1];

                            if(strcasecmp($grade[1],"") != 0)
                                echo " / ".$grade[1];

                            if(strcasecmp($kate[1],"") != 0)
                                echo " / ".$kate[1];
                            
                            if(strcasecmp($skate[1],"") != 0)
                                echo " / ".$skate[1];

                            if(isDecimal($data[4]))
                                echo " ( ".number_format($data[4], 2, '.',' ,')." KG)";
                            else
                                echo " ( ".number_format($data[4], 0, '.',' ,')." KG)";
                        ?>
                    </th>
                    <?php
                        }
                    ?>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Tally</th>
                    <th colspan="4" class="text-left">: <?php echo $data[2];?></th>
                    <?php
                        if($data[10] != 0 && $data[10] != null)
                        {
                    ?>
                    <th class="font-weight-bold text-right" colspan="6">Tahapan Ke</th>
                    <th colspan="5" class="text-left">: <?php echo $data[10];?></th>
                    <?php
                        }
                        else
                        {
                    ?>
                    <!-- Empty Header -->
                    <th class="font-weight-bold text-right" colspan="6"></th>
                    <th colspan="6" class="text-left small">
                        <div class="d-flex flex-column">
                            <div style="font-size: 16px">
                                <span style="font-size: 16px; font-weight: bold; margin-left: -55px">Bahan:</span>
                                    <?php 
                                        if(strcasecmp($pro[1],"") != 0)
                                            echo $pro[1];

                                        if(strcasecmp($grade[1],"") != 0)
                                            echo " / ".$grade[1];

                                        if(strcasecmp($kate[1],"") != 0)
                                            echo " / ".$kate[1];
                                        
                                        if(strcasecmp($skate[1],"") != 0)
                                            echo " / ".$skate[1];
                                    ?>
                            </div>
                            <div style="font-size: 16px">
                                <?php
                                    if(isDecimal($data[4]))
                                        echo " (".number_format($data[4], 2, '.',' ,')." KG)";
                                    else
                                        echo " (".number_format($data[4], 0, '.',' ,')." KG)";
                                ?>
                            </div>
                        </div>
                    </th>
                    <?php
                        }
                    ?>
                </tr>

                <?php
                    if(strcasecmp($data[11],"") != 0)
                    {
                ?>
                <tr>
                    <th class="font-weight-bold text-left">Keterangan</th>
                    <th colspan="6" class="text-left">: <?php echo $data[11];?></th>
                </tr>
                <?php
                    }
                ?>

                <tr class="thead-dark">
                    <th class="border align-middle">Kode Produk</th>
                    <th class="border align-middle">Produk</th>
                    <th class="border align-middle">Grade</th>
                    <th class="border align-middle">Oz</th>
                    <th class="border align-middle">Cut Style</th>
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
                </tr>
            </thead>

            <tbody>
                <?php
                    $data2 = getProSawItem($id);

                    $vsum = 0;
                    for($i = 0; $i < count($data2); $i++)
                    {
                        $sum = 0;
                ?>
                <tr>
                    <td class="border"><?php echo $data2[$i][0];?></td>
                    <td class="border"><?php echo $data2[$i][1];?></td>
                    <td class="border"><?php echo $data2[$i][2];?></td>
                    <td class="border"><?php echo $data2[$i][3];?></td>
                    <td class="border"><?php echo $data2[$i][4];?></td>
                    <?php
                        $data3 = getProSawItemID($id, $data2[$i][0]);
                        $cspan = count($data3) / 10;

                        $n = 0;

                        if(count($data3) % 10 != 0)
                            $cspan++;

                        for($j = 1; $j <= count($data3); $j++)
                        {
                            $sum += $data3[$j-1];
                    ?>
                    <td class="border text-center"><?php if(isDecimal($data3[$j-1])) echo number_format($data3[$j-1], 2, '.', ','); else echo number_format($data3[$j-1], 0, '.', ',');?></td>
                    <?php
                            if($j % 10 == 0 && $j != 0)
                            {
                    ?>
                    <td class="border text-center"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',')?></td>
                    <?php
                                $sum = 0;
                                if($j == 10)
                                {
                                    $vssum = getSumSawItemID($id, $data2[$i][0]);
                    ?>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php if(isDecimal($vssum)) echo number_format($vssum, 2, '.', ','); else echo number_format($vssum, 0, '.', ',');?></td>
                    <?php
                                    $vsum += $vssum;
                                }

                                if(count($data3) % 10 == 0 && $j != count($data3))
                                    echo "</tr><tr><td class=\"border\" colspan=\"4\"></td>";
                                else if($i != count($data2) - 1 && count($data3) % 10 != 0 )
                                    echo "</tr><tr><td class=\"border\" colspan=\"4\"></td>";
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
                            $vssum = getSumSawItemID($id, $data2[$i][0]);
                    ?>
                    <td class="border text-center align-middle" rowspan="<?php echo $cspan;?>"><?php if(isDecimal($vssum)) echo number_format($vssum, 2, '.', ','); else echo number_format($vssum, 0, '.', ',');?></td>
                    <?php
                            $vsum += $vssum;
                        }
                    ?>
                </tr>
                <?php
                    }
                ?>
                <tr>
                    <td class="border" colspan="16"></td>
                    <td class="border text-center"><?php if(isDecimal($vsum)) echo number_format($vsum, 2, '.', ','); else echo number_format($vsum, 0, '.', ',');?></td>
                </tr>
            </tbody>
        </table>

        <div class="my-2">
            <h6>Rincian Singkat :</h6>
            <ul>
                <?php
                    $dtl = getSawItem3($id);

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
    </div>
</body>
</html>