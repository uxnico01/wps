<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - BB";

    $lp = "1";
    $tt = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $tt = trim(mysqli_real_escape_string($db, $_GET["t"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
    }

    closeDB($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - BB | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 117, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 my-2">
                    <label for="slct-jns">Jenis Laporan</label>
                    <select name="l" id="slct-jns-bb" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Dari Penerimaan</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Dari Transaksi</option>
                        <option value="3" <?php if(strcasecmp($lp,"3") == 0) echo "selected=\"selected\"";?>>Penerimaan + Transaksi</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"2") != 0) echo "d-none";?>" id="div-ttran">
                    <label for="slct-ttran">Jenis Transaksi</label>
                    <select name="t" id="slct-ttran" class="custom-select">
                        <option value="" <?php if(strcasecmp($tt,"") == 0) echo "selected=\"selected\"";?>>Semua</option>
                        <option value="IN" <?php if(strcasecmp($tt,"IN") == 0) echo "selected=\"selected\"";?>>Tambah</option>
                        <option value="OUT" <?php if(strcasecmp($tt,"OUT") == 0) echo "selected=\"selected\"";?>>Keluar</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2" id="div-frm">
                    <label for="dte-frm">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dte-frm" name="f" value="<?php echo $frm;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2" id="div-to">
                    <label for="dte-smpi">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="dte-smpi" name="tt" value="<?php echo $to;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-trm-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 118, 1)))
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 118, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan BB</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <?php
                            if(strcasecmp($lp,"1") == 0)
                            {
                        ?>
                        <tr>
                            <th class="border sticky-top">ID</th>
                            <th class="border sticky-top">Tgl</th>
                            <th class="border sticky-top">Supplier</th>
                            <th class="border sticky-top text-right">BB</th>
                            <th class="border sticky-top text-right">DLL</th>
                            <th class="border sticky-top text-right">Minum</th>
                            <th class="border sticky-top text-right">Total</th>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0)
                            {
                        ?>
                        <tr>
                            <th class="border sticky-top">ID</th>
                            <th class="border sticky-top">Tgl</th>
                            <th class="border sticky-top text-right">Jlh</th>
                            <th class="border sticky-top">Ket</th>
                            <th class="border sticky-top">Jenis</th>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"3") == 0)
                            {
                        ?>
                        <tr>
                            <th class="border sticky-top">ID</th>
                            <th class="border sticky-top">Tgl</th>
                            <th class="border sticky-top">Ket</th>
                            <th class="border sticky-top text-right">Debet</th>
                            <th class="border sticky-top text-right">Kredit</th>
                            <th class="border sticky-top text-right">Saldo</th>
                        </tr>
                        <?php
                            }
                        ?>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"1") == 0)
                                $lst = getTrmFrmTo($frm, $to);
                            else if(strcasecmp($lp,"2") == 0)
                                $lst = getBBFrmTo($frm, $to, $tt);
                            else if(strcasecmp($lp,"3") == 0)
                                $lst = getBBFrmTo2($frm, $to);

                            $sum = array(0, 0, 0, 0, 0, 0);
                            $tmp = "";
                            $saldo = getSumBBBfr($frm);

                            if(strcasecmp($lp,"3") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border" colspan="2"></td>
                            <td class="border">Saldo</td>
                            <td class="text-right"></td>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                        </tr>
                        <?php
                                $sum[1] += $saldo;
                            }

                            for($i = 0; $i < count($lst); $i++)
                            {
                                if(strcasecmp($lp,"1") == 0)
                                {
                        ?>
                        <tr>
                            <?php
                                    $vdll = $lst[$i][15];
                                    $kdll = $lst[$i][16];
                                    $dp = $lst[$i][17];
                                    $sttl = $lst[$i][3] + $vdll + $lst[$i][27];
                            ?>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1]));?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][3])) echo number_format($lst[$i][3], 2, '.', ','); else echo number_format($lst[$i][3], 0, '.', ',');?></td>
                            <td class="border text-right">
                                <?php
                                        $ldll = getTrmDll($lst[$i][0]);

                                        if(count($ldll) == 0)
                                        {                                        
                                            if(strcasecmp($kdll,"") != 0 && $vdll != 0)
                                                echo "(".$kdll.") ";

                                            if(isDecimal($vdll))
                                                echo number_format($vdll, 2, '.', ',');
                                            else
                                                echo number_format($vdll, 0, '.', ',');
                                        }
                                        else
                                        {
                                ?>
                                <ul class="m-0">
                                    <?php
                                            $sums = 0;
                                            for($j = 0; $j < count($ldll); $j++)
                                            {
                                                $dkets = $ldll[$j][2];

                                                if(strcasecmp($ldll[$j][1],"1") == 0)
                                                    $dkets = "CASH";
                                                else if(strcasecmp($ldll[$j][1],"2") == 0)
                                                    $dkets = "ES";
                                    ?>
                                    <li style="list-style:none;"><?php echo "($dkets) "; if(isDecimal($ldll[$j][3])) echo number_format($ldll[$j][3], 2, '.', ','); else echo number_format($ldll[$j][3], 0, '.', ',');?></li>
                                    <?php
                                                $sums += $ldll[$j][3];
                                            }
                                    ?>
                                    <li class="font-weight-bold" style="list-style:none;"><?php if(isDecimal($sums)) echo number_format($sums, 2, '.', ','); else echo number_format($sums, 0, '.', ',');?></li>
                                </ul>
                                <?php
                                        }
                                ?>
                            </td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][27])) echo number_format($lst[$i][27], 2, '.', ','); else echo number_format($lst[$i][27], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($sttl)) echo number_format($sttl, 2, '.', ','); else echo number_format($sttl, 0, '.', ',');?></td>
                        </tr>
                        <?php
                                    $sum[0] += $lst[$i][3];
                                    $sum[1] += $vdll;
                                    $sum[2] += $sttl;
                                    $sum[3] += $lst[$i][27];
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo $lst[$i][1];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][2])) echo number_format($lst[$i][2],2,'.',','); else echo number_format($lst[$i][2],0,'.',',');?></td>
                            <td class="border"><?php echo $lst[$i][3];?></td>
                            <td class="border"><?php echo $lst[$i][4];?></td>
                        </tr>
                        <?php
                                    $sum[0] += $lst[$i][2];
                                }
                                else if(strcasecmp($lp,"3") == 0)
                                {
                                    $saldo += $lst[$i][4]-$lst[$i][3];
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo $lst[$i][1];?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][3])) echo number_format($lst[$i][3],2,'.',','); else echo number_format($lst[$i][3],0,'.',',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][4])) echo number_format($lst[$i][4],2,'.',','); else echo number_format($lst[$i][4],0,'.',',');?></td>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo,2,'.',','); else echo number_format($saldo,0,'.',',');?></td>
                        </tr>
                        <?php
                                    $sum[0] += $lst[$i][3];
                                    $sum[1] += $lst[$i][4];
                                }
                            }

                            if(strcasecmp($lp,"1") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="3">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[3])) echo number_format($sum[3], 2, '.', ','); else echo number_format($sum[3], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?></td>
                        </tr>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="6">BB Penerimaan</td>
                            <td class="border text-right font-weight-bold">(<?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?>)</td>
                        </tr>
                        <?php
                                $lout = getBBFrmTo($frm, $to, "OUT");
                                $lin = getBBFrmTo($frm, $to, "IN");

                                $sum[2] *= -1;
                                for($i = 0; $i < count($lout); $i++)
                                {
                        ?>
                        <tr>
                            <td class="border-0 text-right" colspan="6"><?php echo $lout[$i][3]." - ".$lout[$i][1];?></td>
                            <td class="border-0 text-right">(<?php if(isDecimal($lout[$i][2])) echo number_format($lout[$i][2], 2, '.', ','); else echo number_format($lout[$i][2], 0, '.', ',')?>)</td>
                        </tr>
                        <?php
                                    $sum[2] -= $lout[$i][2];
                                }

                                $tsum = sqrt(pow($sum[2],2));
                        ?>
                        <tr>
                            <td class="border-0 text-right" colspan="3"></td>
                            <td class="border border-right-0 border-left-0 border-bottom-0 border-secondary text-right font-weight-bold" colspan="3">Sub Total</td>
                            <td class="border border-right-0 border-left-0 border-bottom-0 border-secondary text-right font-weight-bold">(<?php if(isDecimal($tsum)) echo number_format($tsum, 2, '.', ','); else echo number_format($tsum, 0, '.', ',')?>)</td>
                        </tr>
                        <tr>
                            <td class="border-0 text-right" colspan="6">Saldo BB</td>
                            <td class="border-0 text-right"><?php if($saldo < 0) { $tsaldo = sqrt(pow($saldo,2)); echo "("; if(isDecimal($tsaldo)) echo number_format($tsaldo, 2, '.', ','); else echo number_format($tsaldo, 0, '.', ','); echo ")";} else { if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ','); }?></td>
                        </tr>
                        <?php
                                $sum[2] += $saldo;
                                for($i = 0; $i < count($lin); $i++)
                                {
                        ?>
                        <tr>
                            <td class="border-0 text-right" colspan="6"><?php echo $lin[$i][3]." - ".$lin[$i][1];?></td>
                            <td class="border-0 text-right"><?php if(isDecimal($lin[$i][2])) echo number_format($lin[$i][2], 2, '.', ','); else echo number_format($lin[$i][2], 0, '.', ',')?></td>
                        </tr>
                        <?php
                                    $sum[2] += $lin[$i][2];
                                }
                        ?>
                        <tr>
                            <td class="border-0 text-right" colspan="3"></td>
                            <td class="border border-right-0 border-left-0 border-bottom-0 border-secondary text-right font-weight-bold" colspan="3">Grand Total</td>
                            <td class="border border-left-0 border-right-0 border-secondary text-right font-weight-bold"><?php if($sum[2] < 0) { $sum[2] = sqrt(pow($sum[2],2)); echo "("; if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ','); echo ")";} else { if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ','); }?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="2">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"3") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="3">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
            }
        ?>
    </div>

    <?php
    require("./bin/php/footer.php");
    ?>
</body>

</html>