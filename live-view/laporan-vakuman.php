<?php
    require("../bin/php/clsfunction.php");

    $nav = 1;

    $ttl = "Live View - Laporan Vakuman";

    $tgl = date('Y-m-d');

    $set = getSett();
    
    $lvac = getVacProFrmTo($tgl, $tgl);
    $lvacc = getVacProFrmTo2($tgl, $tgl);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Live View - Laporan Vakuman | PT Winson Prima Sejahtera</title>
    
    <?php
        require("../bin/php/head-live.php");
    ?>
</head>

<body class="mh-100">
    <div class="container-fluid py-2" style="min-height: 100vh;">
        <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 mt-2 mb-2 no-print mx-auto">
            <div class="input-group">
                <input type="date" class="form-control" id="dte-tgl" value="<?php echo $tgl;?>">

                <div class="input-group-append">
                    <button class="btn btn-light border" id="btn-slv-vac" value="<?php echo UE64($tgl);?>"><img src="../bin/img/icon/search.png" alt="Cari" width="20"></button>
                </div>

                <div class="input-group-append">
                    <button class="btn btn-light border btn-print"><img src="../bin/img/icon/print-icon.png" alt="Print" width="20"></button>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-light border btn-close-view"><img src="../bin/img/icon/cancel-icon.png" alt="Tutup" width="20"></button>
                </div>
            </div>
        </div><hr class="no-print">

        <div class="print-only">
            <h4>Live View - Laporan Vakuman (<span id="spn-dte"><?php echo date('d/m/Y', strtotime($tgl))?></span>)</h4>
        </div>
        <div class="table-responsive" style="min-height: 80vh;">
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th class="border">Dari Cutting / Bahan Sjd</th>
                        <th class="border">Hasil Vacuum</th>
                    </tr>
                </thead>

                <tbody id="lv-vac">
                    <?php
                        for($i = 0; $i < count($lvacc); $i++)
                        {
                            $lst = getVacItem4($tgl, $tgl, $lvacc[$i][0]);

                            $count = 0;
                            if(count($lst) > 0)
                                $count = count($lst) - 1;
                            
                            $sum = 0;
                            for($j = 0; $j <= $count; $j++)
                            {
                    ?>
                    <tr>
                        <?php
                                if($j == 0)
                                {
                        ?>
                        <td class="border font-weight-bold" rowspan="<?php if(count($lst) == 0) echo 1; else echo count($lst);?>">Cutting (<?php echo $lvacc[$i][1];?>) = <?php if(isDecimal($lvacc[$i][2])) echo number_format($lvacc[$i][2],2,".",","); else echo number_format($lvacc[$i][2],0,".",",");?> KG</td>
                        <?php
                                }
                        ?>
                        
                        <td class="border">
                            <?php
                                if(count($lst) > 0)
                                {
                                    echo $lst[$j][0]." / ".$lst[$j][1];
                                    
                                    if(strcasecmp($lst[$j][2],"") != 0)
                                        echo " / ".$lst[$j][2];
                                        
                                    if(strcasecmp($lst[$j][2],"") != 0)
                                        echo " / ".$lst[$j][3];
                                
                                    if(isDecimal($lst[$j][4]))
                                        echo " = ".number_format($lst[$j][4],2,'.',',');
                                    else
                                        echo " = ".number_format($lst[$j][4],0,'.',',');
                                        
                                    $prsn = ($lst[$j][4] / $lvacc[$i][2]) * 100;

                                    if(isDecimal($prsn))
                                        echo " KG <strong>(".number_format($prsn,2,'.',',')." %)</strong>";
                                    else
                                        echo " KG <strong>(".number_format($prsn,0,'.',',')." %)</strong>";

                                    $sum += $prsn;
                                }
                            ?>
                        </td>
                    </tr>
                    <?php
                            }
                    ?>
                    <tr>
                        <td class="border text-right font-weight-bold">Total</td>
                        <td class="border text-right font-weight-bold"><?php if(isDecimal($sum)) echo number_format($sum,2,'.',','); else echo number_format($sum,0,'.',',');?> %</td>
                    </tr>
                    <?php
                        }
                    ?>
                    <?php
                        for($i = 0; $i < count($lvac); $i++)
                        {
                            $lst = getVacItem3($lvac[$i][5]);

                            $count = 0;
                            if(count($lst) > 0)
                                $count = count($lst) - 1;
                            
                            $sum = 0;
                            for($j = 0; $j <= $count; $j++)
                            {
                    ?>
                    <tr>
                        <?php
                                if($j == 0)
                                {
                        ?>
                        <td class="border font-weight-bold" rowspan="<?php echo count($lst);?>">
                            <?php
                                echo $lvac[$i][0]." / ".$lvac[$i][1];
                                    
                                if(strcasecmp($lvac[$i][2],"") != 0)
                                    echo " / ".$lvac[$i][2];
                                    
                                if(strcasecmp($lvac[$i][3],"") != 0)
                                    echo " / ".$lvac[$i][3];
                                
                                if(isDecimal($lvac[$i][4]))
                                    echo " = ".number_format($lvac[$i][4],2,".",",");
                                else
                                    echo " = ".number_format($lvac[$i][4],0,".",",");
                            ?> KG
                        </td>
                        <?php
                                }
                        ?>
                        <td class="border">
                            <?php
                                if(count($lst) > 0)
                                {
                                    echo $lst[$j][0]." / ".$lst[$j][1];
                                    
                                    if(strcasecmp($lst[$j][2],"") != 0)
                                        echo " / ".$lst[$j][2];
                                        
                                    if(strcasecmp($lst[$j][3],"") != 0)
                                        echo " / ".$lst[$j][3];
                                
                                    if(isDecimal($lst[$j][4]))
                                        echo " = ".number_format($lst[$j][4],2,'.',',');
                                    else
                                        echo " = ".number_format($lst[$j][4],0,'.',',');

                                    $prsn = ($lst[$j][4] / $lvac[$i][4]) * 100;

                                    if(isDecimal($prsn))
                                        echo " KG <strong>(".number_format($prsn,2,'.',',')." %)</strong>";
                                    else
                                        echo " KG <strong>(".number_format($prsn,0,'.',',')." %)</strong>";

                                    $sum += $prsn;
                                }
                            ?>
                        </td>
                    </tr>
                    <?php
                            }
                    ?>
                    <tr>
                        <td class="border text-right font-weight-bold">Total</td>
                        <td class="border text-right font-weight-bold"><?php if(isDecimal($sum)) echo number_format($sum,2,'.',','); else echo number_format($sum,0,'.',',');?> %</td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="lscripts">
        <script type="text/javascript">
            $(document).ready(function() {
                setInterval(getLViewVac, 5000);
            });
        </script>
    </div>
</body>

</html>