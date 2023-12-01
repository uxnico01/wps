<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Simpanan";

    $lp = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    $sp = "";
    $nsp = "";
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        $sp = trim(mysqli_real_escape_string($db, $_GET["sp"]));
        $nsp = trim(mysqli_real_escape_string($db, $_GET["nsp"]));
    }

    if(strcasecmp($sp,"") != 0)
        $sarr = array($sp);
    else
        $sarr = getAllSupID();

    if(strcasecmp($lp,"4") == 0)
        $sum = array();
    else
        $sum = array(0, 0);
        
    $count = array();
    closeDB($db);

    $data_sup = array();
    $lsup = getAllSup();
    for($i = 0; $i < count($lsup); $i++)
        $data_sup[count($data_sup)] = $lsup[$i][0]." - ".$lsup[$i][1];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Simpanan | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 112, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 my-2">
                    <label for="slct-jns">Jenis Laporan</label>
                    <select name="l" id="slct-jns" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Simpanan</option>
                        <option value="4" <?php if(strcasecmp($lp,"4") == 0) echo "selected=\"selected\"";?>>Simpanan Berdasarkan Grade</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Penarikan</option>
                        <option value="3" <?php if(strcasecmp($lp,"3") == 0) echo "selected=\"selected\"";?>>Simpanan + Penarikan (Rincian)</option>
                        <option value="5" <?php if(strcasecmp($lp,"5") == 0) echo "selected=\"selected\"";?>>Simpanan + Penarikan (Rekap)</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2" id="div-frm">
                    <label for="dte-frm">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dte-frm" name="f" value="<?php echo $frm;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2" id="div-to">
                    <label for="dte-smpi">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="dte-smpi" name="tt" value="<?php echo $to;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2" id="div-sup">
                    <label for="txt-nma-sup">Supplier</label>
                    <div class="d-none" id="bloodhound">
                        <input class="typeahead form-control" type="text">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set" id="txt-nma-sup" name="nsp" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $nsp;?>">
                        <input type="text" class="d-none" id="txt-sup" name="sp" value="<?php echo $sp;?>">

                        <div class="input-group-append">
                            <button class="btn btn-light border" type="button" data-target="#mdl-ssup" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                        </div>

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-rsup" type="button"><img src="./bin/img/icon/delete-icon.png" width="20" alt="Reset"></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-smpn-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 113, 1)))
                            {
                        ?>
                        <button class="m-1 btn btn-light border border-info btn-print" type="button"><img src="./bin/img/icon/print-icon.png" alt="" width="21"></button>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </form>
            <hr class="mt-1">
        </div>

        <?php
            if(isset($_GET["s"]))
            {
        ?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 113, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Simpanan</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top align-middle" <?php if(strcasecmp($lp,"4") == 0) echo "rowspan=\"2\""?>>Tgl</th>
                            <th class="border sticky-top align-middle" <?php if(strcasecmp($lp,"4") == 0) echo "rowspan=\"2\""?>>Supplier</th>
                            <?php
                                if(strcasecmp($lp,"1") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle text-right">Total KG</th>
                            <th class="border sticky-top align-middle text-right">Simpanan / KG</th>
                            <th class="border sticky-top align-middle text-right">Total Simpanan</th>
                            <th class="border sticky-top align-middle text-right">Saldo</th>
                            <?php
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle text-right">Total Penarikan</th>
                            <th class="border sticky-top align-middle">Ket1</th>
                            <th class="border sticky-top align-middle">Ket2</th>
                            <th class="border sticky-top align-middle">Ket3</th>
                            <?php
                                }
                                else if(strcasecmp($lp,"3") == 0 || strcasecmp($lp,"5") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle text-right">Total Simpanan</th>
                            <th class="border sticky-top align-middle text-right">Total Penarikan</th>
                            <th class="border sticky-top align-middle text-right">Total Saldo</th>
                            <?php
                                }
                                else if(strcasecmp($lp,"4") == 0)
                                {
                                    $lsat = getLstSupTrmSatFrmTo($frm, $to, $sarr);

                                    for($i = 0; $i < count($lsat); $i++)
                                    {
                                        $lgrade = getLstSupTrmGradeFrmTo($frm, $to, $sarr, $lsat[$i][0]);
                            ?>
                            <th class="border sticky-top align-middle" colspan="<?php echo count($lgrade)*2;?>" style="min-width: 150px;"><?php echo $lsat[$i][1];?></th>
                            <?php
                                    }
                            ?>
                            <th class="border sticky-top align-middle text-right" rowspan="2">Total Simpanan</th>
                            <?php
                                }
                            ?>
                        </tr>

                        <?php
                            if(strcasecmp($lp,"4") == 0)
                            {
                        ?>
                        <tr>
                            <?php
                                $n = 0;
                                $cn = 0;
                                for($i = 0; $i < count($lsat); $i++)
                                {
                                    $lgrade = getLstSupTrmGradeFrmTo($frm, $to, $sarr, $lsat[$i][0]);

                                    for($j = 0; $j < count($lgrade); $j++)
                                    {
                                        $sum[$n] = 0;
                                        $sum[$n+1] = 0;
                                        $count[$cn] = 0;
                            ?>
                            <th class="border sticky-top align-middle text-right small" style="top:35.5px;"><?php echo $lgrade[$j][1];?> (KG)</th>
                            <th class="border sticky-top align-middle text-right small" style="top:35.5px;"><?php echo $lgrade[$j][1];?> (Rp)</th>
                            <?php
                                        $n+=2;
                                        $cn++;
                                    }
                                }
                            ?>
                        </tr>
                        <?php
                            }
                        ?>
                    </thead>

                    <tbody>
                        <?php
                            $ssum = 0;
                            for($i = 0; $i < count($sarr); $i++)
                            {
                                // Total KG | Simpanan / KG | Total Simpanan
                                if(strcasecmp($lp,"1") == 0 || strcasecmp($lp,"4") == 0)
                                    $lst = getSmpnSupFrmTo2($frm, $to, $sarr[$i]);
                                else if(strcasecmp($lp,"2") == 0)
                                    $lst = getWdFrmTo($frm, $to, $sarr[$i]);
                                else if(strcasecmp($lp,"3") == 0)
                                    $lst = getSmpnSupFrmTo($frm, $to, $sarr[$i]);
                                else if(strcasecmp($lp,"5") == 0)
                                    $lst = getSmpnSupFrmTo4($frm, $to, $sarr[$i]);

                                $sup = getSupID($sarr[$i]);
                                $saldo = 0;
                                
                                $tmp = "";

                                if(strcasecmp($lp,"4") == 0)
                                {
                                    for($j = 0; $j < count($lst); $j++)
                                    {
                        ?>
                        <tr>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$j][0]));?></td>
                            <td class="border"><?php echo $sup[1];?></td>
                            <?php
                                        $n = 0;
                                        $cn = 0;
                                        for($k = 0; $k < count($lsat); $k++)
                                        {
                                            $lgrade = getLstSupTrmGradeFrmTo($frm, $to, $sarr, $lsat[$k][0]);
                                            
                                            for($l = 0; $l < count($lgrade); $l++)
                                            {
                                                $sgrade = getSumTrmSatGrade2($lsat[$k][0], $lgrade[$l][0], $lst[$j][0], $sarr[$i]);
                            ?>
                            <td class="border text-right"><?php if(isDecimal($sgrade[0])) echo number_format($sgrade[0], 2, '.', ','); else echo number_format($sgrade[0], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($sgrade[1])) echo number_format($sgrade[1], 2, '.', ','); else echo number_format($sgrade[1], 0, '.', ',');?></td>
                            <?php
                                                $sum[$n] += $sgrade[0];
                                                $sum[$n+1] += $sgrade[1];

                                                if($sgrade[0] != 0)
                                                    $count[$cn]++;

                                                $n+=2;
                                                $cn++;
                                            }
                                        }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$j][1])) echo number_format($lst[$j][1], 2, '.', ','); else echo number_format($lst[$j][1], 0, '.', ',');?></td>
                        </tr>
                        <?php
                                        $ssum += $lst[$j][1];
                                    }
                                }
                                else if(strcasecmp($lp,"5") == 0)
                                {
                                    $saldo = $sup[10];
                                    $gsmpn = getSmpnSupBfr($frm, $sarr[$i]);
                                    $gwd = getWdSupBfr($frm, $sarr[$i]);
                                    $saldo += $gsmpn - $gwd;
                        ?>
                        <tr>
                            <td class="border">Saldo</td>
                            <td class="border"><?php echo $sup[1];?></td>
                            <td class="border"></td>
                            <td class="border"></td>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                        </tr>
                        <?php
                                    $sum = array(0, 0);
                                    $sum[0] += $saldo;
                                    for($j = 0; $j < count($lst); $j++)
                                    {
                                        $saldo += $lst[$j][2] - $lst[$j][3];
                        ?>
                        <tr>
                            <td class="border"><?php echo getNmMonth($lst[$j][0])." - ".$lst[$j][1];?></td>
                            <td class="border"><?php echo $sup[1];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$j][2])) echo number_format($lst[$j][2], 2, '.', ','); else echo number_format($lst[$j][2], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$j][3])) echo number_format($lst[$j][3], 2, '.', ','); else echo number_format($lst[$j][3], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                        </tr>
                        <?php
                                        $sum[0] += $lst[$j][2];
                                        $sum[1] += $lst[$j][3];
                                    }

                                    $sisa = $sum[0] - $sum[1];

                                    if(count($lst) > 0)
                                    {
                        ?> 
                        <?php
                                    }
                                }
                                else
                                {
                                    $ssum = 0;
                                    if(strcasecmp($lp,"1") == 0 || strcasecmp($lp,"3") == 0)
                                    {
                                        $saldo = $sup[10];
                                        $gsmpn = getSmpnSupBfr($frm, $sarr[$i]);
                                        $gwd = getWdSupBfr($frm, $sarr[$i]);
                                        $saldo += $gsmpn;

                                        if(strcasecmp($lp,"1") == 0)
                                            $saldo -= $gwd;
                                            
                                        if((strcasecmp($lp,"1") == 0 && $saldo != 0) || (strcasecmp($lp,"3") == 0 && ($saldo != 0 || $gwd != 0)))
                                        {
                                            $ssum += $saldo;
                        ?>
                        <tr>
                            <td class="border">Saldo</td>
                            <td class="border"><?php echo $sup[1];?></td>
                            <td class="border text-right" colspan="<?php if(strcasecmp($lp,"1") == 0) echo "3";?>"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                            <?php
                                    if(strcasecmp($lp,"1") == 0)
                                    {
                            ?>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                            <?php
                                    }
                                    else if(strcasecmp($lp,"3") == 0)
                                    {
                                        $saldo -= $gwd;
                                        $ssum -= $gwd;
                            ?>
                            <td class="border text-right"><?php if(isDecimal($gwd)) echo number_format($gwd, 2, '.', ','); else echo number_format($gwd, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                            <?php
                                    }
                            ?>
                        </tr>
                        <?php
                                        }
                                    }

                                    for($j = 0; $j < count($lst); $j++)
                                    {
                                        if(strcasecmp($lp,"3") != 0 && $lst[$j][1] == 0)
                                            continue;
                        ?>
                        <!-- Simpanan / KG | Jenis Laporan : Simpanan -->
                        <tr>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$j][0]));?></td>
                            <td class="border"><?php echo $sup[1];?></td>
                            <?php
                                        if(strcasecmp($lp,"1") == 0)
                                        {
                                            // Simpanan / KG OLD
                                            // $gsmpn = getSmpnSupFrmTo3($frm, $to, $sarr[$i]);
                            ?>
                            <!-- Total KG -->
                            <td class="border text-right"><?php if(isDecimal($lst[$j][2])) echo number_format($lst[$j][2], 2, '.', ','); else echo number_format($lst[$j][2], 0, '.', ',');?></td>
                            <!-- Simpanan / KG -->
                            <td class="border text-right"><?php if(isDecimal($lst[$j][3])) echo number_format($lst[$j][3], 2, '.', ','); else echo number_format($lst[$j][3], 0, '.', ',');?></td>
                            <?php
                                        }
                                        // Saldo
                                        $ssum += $lst[$j][1];
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$j][1])) echo number_format($lst[$j][1], 2, '.', ','); else echo number_format($lst[$j][1], 0, '.', ',');?></td>
                            <?php
                                        if(strcasecmp($lp,"1") == 0)
                                        {
                            ?>
                            <!-- Saldo -->
                            <td class="border text-right"><?php if(isDecimal($ssum)) echo number_format($ssum, 2, '.', ','); else echo number_format($ssum, 0, '.', ',');?></td>
                            <?php
                                        }
                                        else if(strcasecmp($lp,"2") == 0)
                                        {
                            ?>
                            <td class="border"><?php echo $lst[$j][2];?></td>
                            <td class="border"><?php echo $lst[$j][3];?></td>
                            <td class="border"><?php echo $lst[$j][4];?></td>
                            <?php
                                        }
                                        else if(strcasecmp($lp,"3") == 0)
                                        {
                                            $ssum -= $lst[$j][2];
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$j][2])) echo number_format($lst[$j][2], 2, '.', ','); else echo number_format($lst[$j][2], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($ssum)) echo number_format($ssum, 2, '.', ','); else echo number_format($ssum, 0, '.', ',');?></td>
                            <?php
                                            $sum[1] += $lst[$j][2];
                                        }
                                        // Total Laporan Simpanan: Jenis Laporan - Simpanan
                                        $sum[0] += $lst[$j][1];
                                    }
                                    
                                    $sum[0] += $saldo;
                            ?>
                        </tr>
                        <?php
                                }
                            }

                            if(strcasecmp($lp,"4") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="2">Total</td>
                            <?php
                                $cn = 1;
                                for($i = 0; $i < count($sum); $i++)
                                {
                                    if($i % 2 != 0)
                                    {
                                        if($count[$i - $cn] != 0)
                                            $sum[$i] /= $count[$i - $cn];

                                        $cn++;
                            ?>
                            <td class="border"></td>
                            <?php
                                    }
                                    else
                                    {
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[$i])) echo number_format($sum[$i], 2, '.', ','); else echo number_format($sum[$i], 0, '.', ',')?></td>
                            <?php 
                                    }
                                }
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($ssum)) echo number_format($ssum, 2, '.', ','); else echo number_format($ssum, 0, '.', ',')?></td>
                        </tr>
                        <!-- Total Laporan Simpanan: Jenis Laporan - Simpanan -->
                        <?php
                            }
                            else if(strcasecmp($lp,"5") != 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="<?php if(strcasecmp($lp,"1") == 0) echo 4; else echo 2;?>">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                        <?php
                                if(strcasecmp($lp,"3") == 0)
                                {
                        ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                        <?php
                                }
                        ?>
                        </tr>
                        <?php
                                if(strcasecmp($lp,"1") == 0 && strcasecmp($sp,"") != 0)
                                {
                        ?>
                        <tr>
                            <?php
                                    if(countWdSup($sp) == 0)
                                    {
                            ?>
                            <td class="border text-danger" colspan="5">Tidak ada data penarikan...</td>
                            <?php
                                    }
                                    else
                                    {
                                        $glwd = getLastWdSup($sp);
                            ?>
                            <td class="border text-danger" colspan="5">Penarikan terakhir pada tanggal <strong><?php echo date('d/m/Y', strtotime($glwd[0]));?></strong> sebesar <strong><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',');?></strong></td>
                            <?php
                                    }
                            ?>
                        </tr>
                        <?php
                                }
                                else if(strcasecmp($lp,"3") == 0)
                                {
                                    $nsum = $sum[0] - $sum[1];
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="2">Sisa</td>
                            <td class="border text-right font-weight-bold" colspan="2"><?php if(isDecimal($nsum)) echo number_format($nsum, 2, '.', ','); else echo number_format($nsum, 0, '.', ',')?></td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
            }
        ?>

        <script>
            $(document).ready(function(){
                data_sup = (<?php echo json_encode($data_sup);?>);
                ndata_sup = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace,
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    // `states` is an array of state names defined in "The Basics"
                    local: data_sup
                });

                autoCmpSup();
            })
        </script>
    </div>

    <?php
        require("./modals/mdl-ssup.php");

        require("./bin/php/footer.php");
    ?>
</body>

</html>