<?php
    require("../bin/php/clsfunction.php");

    $db = openDB();

    $nav = 1;

    $ttl = "Live View - Laporan Inventory";

    $tgl = date('Y-m-d');

    $set = getSett();

    //$lst = getProFrmTo($tgl, $tgl, "");
    $lst = array();
    $lpro = getAllPro("2");
    $lgdg = getAllGdg($db);
    $pro = array(countAllPro(), getSumPro($db));
    $trm = getSumTrmFrmTo(date('Y-m-d'), date('Y-m-d'));
    $bhn = getSumBhnVacFrmTo(date('Y-m-d'), date('Y-m-d'), $db) + getSumBhnSawFrmTo(date('Y-m-d'), date('Y-m-d'), $db);
    $hsl = getSumHslVacFrmTo(date('Y-m-d'), date('Y-m-d'), $db) + getSumHslSawFrmTo(date('Y-m-d'), date('Y-m-d'), $db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Live View - Laporan Inventory | PT Winson Prima Sejahtera</title>
    
    <?php
        require("../bin/php/head-live.php");
    ?>
</head>

<body class="mh-100">
    <div class="container-fluid py-2" style="min-height: 100vh;">
        <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 mt-2 no-print mx-auto">
            <div class="input-group justify-content-center">
                <input type="date" class="form-control d-none" id="dte-tgl" value="<?php echo $tgl;?>">

                <div class="input-group-append d-none">
                    <button class="btn btn-light border" id="btn-slv-inv" value="<?php echo UE64($tgl);?>"><img src="../bin/img/icon/search.png" alt="Cari" width="20"></button>
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
            <h4>Live View - Laporan Inventory (<span id="spn-dte"><?php echo date('d/m/Y', strtotime($tgl))?></span>)</h4>
        </div>

        <div class="row m-0 p-0 no-print" id="div-dash">
            <div class="col-6 col-md-5 col-lg-3 mb-3">
                <div class="border shadow pt-3 pl-3 pb-2">
                    <strong class="">Total Produk</strong>
                    <div class="small text-secondary">Keseluruhan</div>
                    <h6 class="pl-2 mt-1" id="lv-cpro"><?php echo number_format($pro[0],0,'.',',');?> (<?php echo number_format($pro[1],2,'.',',');?> KG)</h6>
                </div>
            </div>
            <div class="col-6 col-md-5 col-lg-3 mb-3">
                <div class="border shadow pt-3 pl-3 pb-2">
                    <strong class="">Jlh Terima Hari Ini</strong>
                    <div class="small text-secondary">Keseluruhan</div>
                    <h6 class="pl-2 mt-1" id="lv-strm"><?php echo number_format($trm[1],0,'.',',')." Ekor (".number_format($trm[0],2,'.',',')." KG)";?></h6>
                </div>
            </div>
            <div class="col-6 col-md-5 col-lg-3 mb-3">
                <div class="border shadow pt-3 pl-3 pb-2">
                    <strong class="">Jlh Bahan Baku Proses Hari Ini</strong>
                    <div class="small text-secondary">Vacuum / Sawing</div>
                    <h6 class="pl-2 mt-1" id="lv-sbproc"><?php echo number_format($bhn,2,'.',',');?> KG</h6>
                </div>
            </div>
            <div class="col-6 col-md-5 col-lg-3 mb-3">
                <div class="border shadow pt-3 pl-3 pb-2">
                    <strong class="">Jlh Hasil Proses Hari Ini</strong>
                    <div class="small text-secondary">Vacuum / Sawing</div>
                    <h6 class="pl-2 mt-1" id="lv-shproc"><?php echo number_format($hsl,2,'.',',');?> KG</h6>
                </div>
            </div>
        </div>

        <div class="table-responsive mxh-70vh">
            <table class="table table-sm d-none">
                <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top align-middle text-center">No</th>
                            <th class="border sticky-top align-middle">ID</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top text-right align-middle">Total</th>
                        </tr>
                </thead>

                <tbody id="blv-inv">
                    <?php
                        for($i = 0; $i < count($lst); $i++)
                        {
                            $cutpro = getSumCutFrmTo4($tgl, $tgl, $lst[$i][0], "");
                            $cutpro2 = getSumCutFrmTo5($tgl, $lst[$i][0], "");
                            $saldo = $lst[$i][7]-$lst[$i][10]-$lst[$i][13]+$lst[$i][16]-$lst[$i][19]+$lst[$i][22]-$lst[$i][25]+$lst[$i][28]+$lst[$i][30]-$cutpro2+$lst[$i][32]-$lst[$i][35]+$lst[$i][38];

                            $qty = $saldo + $lst[$i][6] - $lst[$i][9] + $lst[$i][27] - $lst[$i][12] + $lst[$i][15] - $lst[$i][18] + $lst[$i][21] - $lst[$i][24] - $cutpro + $lst[$i][31] - $lst[$i][34] + $lst[$i][37] + $lst[$i][40];
                    ?>
                    <tr>
                        <td class="border text-center"><?php echo $i+1;?></td>
                        <td class="border"><?php echo $lst[$i][0];?></td>
                        <td class="border"><?php echo $lst[$i][1]." / ".$lst[$i][4]; if(strcasecmp($lst[$i][2],"") != 0) echo " / ".$lst[$i][2]; if(strcasecmp($lst[$i][3],"") != 0) echo " / ".$lst[$i][3]; ?></td>
                        <td class="border text-right"><?php if(isDecimal($qty)) echo number_format($qty, 2, '.', ','); else echo number_format($qty, 0, '.', ',');?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>

            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="border sticky-top align-middle text-center">No</th>
                        <th class="border sticky-top align-middle">ID</th>
                        <th class="border sticky-top align-middle">Produk</th>
                        <?php
                            for($i = 0; $i < count($lgdg); $i++){
                                $sum[$i] = 0;
                        ?>
                        <th class="border sticky-top align-middle text-right"><?php echo $lgdg[$i][1];?></th>
                        <?php
                            }
                        ?>
                        <th class="border sticky-top align-middle text-right">Total</th>
                    </tr>
                </thead>

                <tbody id="lv-inv">
                    <?php
                        for($i = 0; $i < count($lpro); $i++){
                            $sttl = 0;
                    ?>
                    <tr>
                        <td class="border text-center"><?php echo $i+1;?></td>
                        <td class="border"><?php echo $lpro[$i][0];?></td>
                        <td class="border"><?php echo $lpro[$i][1]." / ".$lpro[$i][4]; if(strcasecmp($lpro[$i][2],"") != 0) echo " / ".$lpro[$i][2]; if(strcasecmp($lpro[$i][3],"") != 0) echo " / ".$lpro[$i][3]; ?></td>
                        <?php
                            for($j = 0; $j < count($lgdg); $j++){
                                $dgpro = getQGdgPro($lgdg[$j][0], $lpro[$i][0], $db);
                                $sttl += $dgpro;
                        ?>
                        <td class="border text-right"><?php if(isDecimal($dgpro)) echo number_format($dgpro, 2, '.', ','); else echo number_format($dgpro, 0, '.', ',');?></td>
                        <?php
                                $sum[$j] += $dgpro;
                            }
                        ?>
                        <td class="border text-right"><?php if(isDecimal($sttl)) echo number_format($sttl, 2, '.', ','); else echo number_format($sttl, 0, '.', ',');?></td>
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
                setInterval(getLViewInv, 5000);
            });
        </script>
    </div>
    <?php
        closeDB($db);
    ?>
</body>

</html>