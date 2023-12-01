<?php
    require("../bin/php/clsfunction.php");

    $nav = 1;

    $ttl = "Live View - Laporan Cutting";

    $tgl = date('Y-m-d');

    $set = getSett();

    $tmrgn = "";

    if(strcasecmp($set[0][1],"1") == 0)
        $tmrgn = "<";
    else if(strcasecmp($set[0][1],"2") == 0)
        $tmrgn = ">";

    $ltrm = array();
    $lcut = array();
    $lvac = array();
    $lfrz = array();
    $ltgl = array();
    $lwrn = array();
    $lvaccut = array();

    for($i = 0; $i < 10; $i++)
    {
        $tgls = date('Y-m-d', strtotime($tgl."-".$i."day"));

        $trm = getSumTrmFrmTo2($tgls, $tgls);
        $cut = getSumCutFrmTo2($tgls, $tgls);
        $frz = getSumFrzFrmTo($tgls, $tgls);
        $vac = getSumVacFrmTo2($tgls, $tgls);
        $vac2 = getSumVacCutFrmTo($tgls, $tgls);
        $lvc = getSumVacCutFrmTo2($tgls, $tgls);

        if($trm[1] == 0)
            continue;

        $ltrm[count($ltrm)] = $trm;
        $lcut[count($lcut)] = $cut;
        $lvac[count($lvac)] = array($vac, $vac2);
        $lfrz[count($lfrz)] = $frz;
        $ltgl[count($ltgl)] = $tgls;
        $lvaccut[count($lvaccut)] = $lvc;

        $text = "";
        if((($trm[1] != $cut[1] || (strcasecmp($set[0][1],"1") == 0 && $cut[0]/$trm[0] >= $set[0][2]) || (strcasecmp($set[0][1],"2") == 0 && $cut[0]/$trm[0] <= $set[0][2]))) || ($vac == 0 && $cut[0] != 0 && count($lvc) > 0))
            $text = "text-danger";

        $lwrn[count($lwrn)] = $text;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Live View - Laporan Cutting | PT Winson Prima Sejahtera</title>

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
                    <button class="btn btn-light border" id="btn-slv-cut" value="<?php echo UE64($tgl);?>"><img src="../bin/img/icon/search.png" alt="Cari" width="20"></button>
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
            <h4>Live View - Laporan Cutting (<span id="spn-dte"><?php echo date('d/m/Y', strtotime($tgl))?></span>)</h4>
        </div>
        <div class="" style="min-height: 80vh;">
            <div class="row m-0">
                <div class="col-4"><div class="my-2 text-left"><div class="h5 d-inline-block px-3 py-2 border-bottom border-dark">Penerimaan</div></div></div>

                <div class="col-4 border-left border-right"><div class="my-2 text-left"><div class="h5 d-inline-block px-3 py-2 border-bottom border-dark">Cutting</div></div></div>

                <div class="col-4"><div class="my-2 text-left"><div class="h5 d-inline-block px-3 py-2 border-bottom border-dark">Vacuum</div></div></div>
            </div>

            <div id="live-view">
                <?php
                    for($i = 0; $i < count($ltgl); $i++){
                        if($i != 0)
                            echo "<hr>";
                ?>
                <div class="row m-0">
                    <div class="col-4">
                        <h6 class="<?php echo $lwrn[$i];?>"><?php echo date('d/m/Y', strtotime($ltgl[$i]));?></h6>

                        <div class="row">
                            <div class="col-5 my-1">Total (Ekor)</div>
                            <div class="col-7 my-1 font-weight-bold"><?php echo number_format($ltrm[$i][1], 0, '.', ',');?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 my-1">Total (KG)</div>
                            <div class="col-7 my-1 font-weight-bold"><?php if(isDecimal($ltrm[$i][0])) echo number_format($ltrm[$i][0], 2, '.', ','); else echo number_format($ltrm[$i][0], 0, '.', ',');?></div>
                        </div>
                    </div>

                    <div class="col-4 border-left">
                        <h6 class="<?php echo $lwrn[$i];?>"><?php echo date('d/m/Y', strtotime($ltgl[$i]));?></h6>

                        <div class="row">
                            <div class="col-5 my-1">Total (Ekor)</div>
                            <div class="col-7 my-1 font-weight-bold"><?php if(isDecimal($lcut[$i][1])) echo number_format($lcut[$i][1], 2, '.', ','); else echo number_format($lcut[$i][1], 0, '.', ',')?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 my-1">Total (KG)</div>
                            <div class="col-7 my-1 font-weight-bold"><?php if(isDecimal($lcut[$i][0])) echo number_format($lcut[$i][0], 2, '.', ','); else echo number_format($lcut[$i][0], 0, '.', ','); echo " [".number_format(($lcut[$i][0]/$ltrm[$i][0])*100, 2, '.', ',')." %]"; echo "<br>(".$tmrgn." ".$set[0][2]." %)";?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 my-1">Ket Cutting :</div>
                            <div class="col-7 my-1 small">
                                <?php
                                    $lst = getListCutVac($ltgl[$i]);
                                    
                                    for($j = 0; $j < count($lst); $j++)
                                    {
                                        if($j != 0)
                                            echo "<br>";

                                        echo $lst[$j][0]." = ";
                                        if(isDecimal($lst[$j][1]))
                                            echo number_format($lst[$j][1], 2, '.', ',');
                                        else
                                            echo number_format($lst[$j][1], 0, '.', ',');

                                        echo " KG";
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-5 my-1">Total Beku (Ekor)</div>
                            <div class="col-7 my-1 font-weight-bold"><?php echo number_format($lfrz[$i][1], 0, '.', ',');?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 my-1">Total Beku (KG)</div>
                            <div class="col-7 my-1 font-weight-bold"><?php if(isDecimal($lfrz[$i][0])) echo number_format($lfrz[$i][0], 2, '.', ','); else echo number_format($lfrz[$i][0], 0, '.', ','); echo " [".number_format(($lfrz[$i][0]/$ltrm[$i][0])*100, 2, '.', ',')." %]";?></div>
                        </div>
                    </div>

                    <div class="col-4 border-left">
                        <h6 class="<?php echo $lwrn[$i];?>"><?php echo date('d/m/Y', strtotime($ltgl[$i]));?></h6>

                        <div class="row">
                            <div class="col-5 my-1">Bahan (KG)</div>
                            <div class="col-7 my-1 font-weight-bold"><?php if(isDecimal($lvac[$i][1])) echo number_format($lvac[$i][1],2,'.',','); else echo number_format($lvac[$i][1], 0, '.', ',');?></div>
                        </div>
                        <?php
                            if($lvac[$i][1] == 0){
                                $lvac[$i][1] = 1;
                            }
                        ?>
                        <div class="row">
                            <div class="col-5 my-1">Hasil (KG)</div>
                            <div class="col-7 my-1 font-weight-bold"><?php if(isDecimal($lvac[$i][0])) echo number_format($lvac[$i][0],2,'.',','); else echo number_format($lvac[$i][0], 0, '.', ',');?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 my-1">Persentase</div>
                            <div class="col-7 my-1 font-weight-bold"><?php if(isDecimal($lvac[$i][0]/$lvac[$i][1]*100)) echo number_format($lvac[$i][0]/$lvac[$i][1]*100, 2, '.', ','); else echo number_format($lvac[$i][0]/$lvac[$i][1]*100, 0, '.', ',');?> %</div>
                        </div>

                        <div class="row">
                            <div class="col-5 my-1">Dari Cut Tgl :</div>
                            <div class="col-7 my-1 small">
                                <?php
                                    for($j = 0; $j < count($lvaccut[$i]); $j++){
                                        if($j != 0)
                                            echo "<br>";

                                        echo date('d/m/Y', strtotime($lvaccut[$i][$j][0]))." = ";
                                        if(isDecimal($lvaccut[$i][$j][1]))
                                            echo number_format($lvaccut[$i][$j][1], 2, '.', ',');
                                        else
                                            echo number_format($lvaccut[$i][$j][1], 0, '.', ',');

                                        echo " KG";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
            <div class="col-6 d-none">
                <div class="my-2 text-left"><div class="h5 d-inline-block px-3 py-2 border-bottom border-dark">Penerimaan</div></div>

                <div id="dpnrm" class="px-3">
                    <?php
                        for($i = 0; $i < count($ltgl); $i++)
                        {
                            if($i != 0)
                                echo "<hr>";
                    ?>
                    <h6 class="<?php echo $lwrn[$i];?>"><?php echo date('d/m/Y', strtotime($ltgl[$i]));?></h6>

                    <div class="row">
                        <div class="col-7 my-1">Total (Ekor)</div>
                        <div class="col-5 my-1 font-weight-bold"><?php echo number_format($ltrm[$i][1], 0, '.', ',');?></div>
                    </div>

                    <div class="row">
                        <div class="col-7 my-1">Total (KG)</div>
                        <div class="col-5 my-1 font-weight-bold"><?php if(isDecimal($ltrm[$i][0])) echo number_format($ltrm[$i][0], 2, '.', ','); else echo number_format($ltrm[$i][0], 0, '.', ',');?></div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>

            <div class="col-6 border-left d-none">
                <div class="my-2 text-left"><div class="h5 d-inline-block px-3 py-2 border-bottom border-dark">Cutting</div></div>

                <div id="dcut" class="px-3">
                    <?php
                        for($i = 0; $i < count($ltgl); $i++)
                        {
                            if($i != 0)
                                echo "<hr>";
                    ?>
                    <h6 class="<?php echo $lwrn[$i];?>"><?php echo date('d/m/Y', strtotime($ltgl[$i]));?></h6>

                    <div class="row">
                        <div class="col-7 my-1">Total (Ekor)</div>
                        <div class="col-5 my-1 font-weight-bold"><?php echo number_format($lcut[$i][1], 0, '.', ',');?></div>
                    </div>

                    <div class="row">
                        <div class="col-7 my-1">Total (KG)</div>
                        <div class="col-5 my-1 font-weight-bold"><?php if(isDecimal($lcut[$i][0])) echo number_format($lcut[$i][0], 2, '.', ','); else echo number_format($lcut[$i][0], 0, '.', ','); echo " [".number_format(($lcut[$i][0]/$ltrm[$i][0])*100, 2, '.', ',')." %]"; echo "<br>(".$tmrgn." ".$set[0][2]." %)";?></div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-7 my-1">Ket Cutting :</div>
                        <div class="col-5 my-1">
                            <?php
                                $lst = getListCutVac($ltgl[$i]);
                                
                                for($j = 0; $j < count($lst); $j++)
                                {
                                    if($j != 0)
                                        echo "<br>";

                                    echo $lst[$j][0]." = ";
                                    if(isDecimal($lst[$j][1]))
                                        echo number_format($lst[$j][1], 2, '.', ',');
                                    else
                                        echo number_format($lst[$j][1], 0, '.', ',');

                                    echo " KG";
                                }
                            ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="lscripts">
        <script type="text/javascript">
            $(document).ready(function() {
                setInterval(getLViewCut, 5000);
            });
        </script>
    </div>
</body>

</html>