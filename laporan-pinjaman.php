<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Pinjaman";

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
        
    closeDB($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Pinjaman | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 115, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 my-2">
                    <label for="slct-jns-pjm">Jenis Laporan</label>
                    <select name="l" id="slct-jns-pjm" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Rekap</option>
                        <option value="3" <?php if(strcasecmp($lp,"3") == 0) echo "selected=\"selected\"";?>>Rekap Keseluruhan</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Rincian</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"3") == 0) echo "d-none";?>" id="div-frm">
                    <label for="dte-frm">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dte-frm" name="f" value="<?php echo $frm;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"3") == 0) echo "d-none";?>" id="div-to">
                    <label for="dte-smpi">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="dte-smpi" name="tt" value="<?php echo $to;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2" id="div-sup">
                    <label for="txt-nma-sup">Supplier</label>
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
                        <button class="m-1 btn btn-light border border-success" id="btn-pjm-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 116, 1)))
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
                <h5>Laporan Pinjaman</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <?php
                                if(strcasecmp($lp,"3") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle">No</th>
                            <th class="border sticky-top align-middle">Supplier</th>
                            <th class="border sticky-top align-middle text-right">Sisa Pinjaman</th>
                            <th class="border sticky-top align-middle">Nomor Pinjaman</th>
                            <?php
                                }
                                else
                                {
                            ?>
                            <?php
                                    if(strcasecmp($lp,"1") == 0)
                                    {
                            ?>
                            <th class="border sticky-top align-middle">Nomor Pinjaman</th>
                            <?php
                                    }
                            ?>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">Supplier</th>
                            <?php
                                    if(strcasecmp($lp,"1") == 0)
                                    {
                            ?>
                            <th class="border sticky-top align-middle text-right">Total Pinjaman</th>
                            <th class="border sticky-top align-middle text-right">Potongan Lainnya</th>
                            <th class="border sticky-top align-middle text-right">Total Potongan</th>
                            <th class="border sticky-top align-middle text-right">Sisa</th>
                            <?php
                                    }
                                    else if(strcasecmp($lp,"2") == 0)
                                    {
                            ?>
                            <th class="border sticky-top align-middle">Keterangan</th>
                            <th class="border sticky-top align-middle text-right">Jlh Pinjam</th>
                            <th class="border sticky-top align-middle text-right">Pot Lain</th>
                            <th class="border sticky-top align-middle text-right">Jlh Potong</th>
                            <th class="border sticky-top align-middle text-right">Saldo</th>
                            <?php
                                    }
                                }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"3") == 0)
                            {
                                $n = 1;
                                for($i = 0; $i < count($sarr); $i++)
                                {
                                    $sup = getSupID($sarr[$i]);
                                    $lst = getSisaPjm($sarr[$i]);
                                    if(count($lst) == 0)
                                        continue;

                                    $nota = "";
                                    $sum = 0;
                                    for($j = 0; $j < count($lst); $j++)
                                    {
                                        if(strcasecmp($nota,"") != 0)
                                            $nota .= ", ";

                                        $sum += $lst[$j][0];
                                        $nota .= $lst[$j][1];
                                    }
                        ?>
                        <tr>
                            <td class="border"><?php echo $n;?></td>
                            <td class="border"><?php echo $sup[1];?></td>
                            <td class="border text-right"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?></td>
                            <td class="border"><?php echo $nota;?></td>
                        </tr>
                        <?php
                                    $n++;
                                }
                            }
                            else
                            {
                                $sum = array(0, 0);
                                for($i = 0; $i < count($sarr); $i++)
                                {
                                    $saldo = 0;
                                    if(strcasecmp($lp,"1") == 0)
                                        $lst = getPjmSupFrmTo2($frm, $to, $sarr[$i]);
                                    else if(strcasecmp($lp,"2") == 0)
                                        $lst = getPjmSupFrmTo($frm, $to, $sarr[$i]);

                                    $sup = getSupID($sarr[$i]);

                                    if(strcasecmp($lp,"2") == 0)
                                    {
                                        $gspjm = getSumSupPjm3($sarr[$i], $frm);
                                        $saldo += $gspjm[0] - $gspjm[1] - $gspjm[2];
                                        $sum[0] += $gspjm[0];
                                        $sum[1] += $gspjm[2];
                                        $sum[2] += $gspjm[1];
                        ?>
                        <tr>
                            <td class="border">Saldo</td>
                            <td class="border"><?php echo $sup[1];?></td>
                            <td class="border"></td>
                            <td class="border text-right"><?php if(isDecimal($gspjm[0])) echo number_format($gspjm[0], 2, '.', ','); else echo number_format($gspjm[0], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($gspjm[2])) echo number_format($gspjm[2], 2, '.', ','); else echo number_format($gspjm[2], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($gspjm[1])) echo number_format($gspjm[1], 2, '.', ','); else echo number_format($gspjm[1], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                        </tr>
                        <?php
                                    }

                                    $tmp = "";
                                    for($j = 0; $j < count($lst); $j++)
                                    {
                        ?>
                        <tr>
                            <?php
                                        if(strcasecmp($lp,"2") != 0)
                                        {
                            ?>
                            <td class="border"><?php echo $lst[$j][4];?></td>
                            <?php
                                        }
                            ?>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$j][0]));?></td>
                            <td class="border"><?php echo $sup[1];?></td>
                            <?php
                                        if(strcasecmp($lp,"2") == 0)
                                        {
                            ?>
                            <td class="border"><?php echo $lst[$j][4];?></td>
                            <?php
                                        }

                                        $saldo += $lst[$j][1] - $lst[$j][2] - $lst[$j][5];
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$j][1])) echo number_format($lst[$j][1], 2, '.', ','); else echo number_format($lst[$j][1], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$j][5])) echo number_format($lst[$j][5], 2, '.', ','); else echo number_format($lst[$j][5], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$j][2])) echo number_format($lst[$j][2], 2, '.', ','); else echo number_format($lst[$j][2], 0, '.', ',');?></td>
                            <?php
                                        if(strcasecmp($lp,"2") == 0)
                                        {
                            ?>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                            <?php
                                        }

                                        if(strcasecmp($lp,"1") == 0)
                                        {
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$j][3])) echo number_format($lst[$j][3], 2, '.', ','); else echo number_format($lst[$j][3], 0, '.', ',');?></td>
                            <?php
                                        }

                                        $sum[0] += $lst[$j][1];
                                        $sum[1] += $lst[$j][5];
                                        $sum[2] += $lst[$j][2];
                                    }
                            ?>
                        </tr>
                        <?php
                                }
                            }
                            
                            if(strcasecmp($lp,"3") == 0)
                            {
                        ?>
                        
                        <?php
                            }
                            else
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="<?php if(strcasecmp($lp,"1") == 0 || strcasecmp($lp,"2") == 0) echo "3"; else echo "2";?>">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0]-$sum[1]-$sum[2])) echo number_format($sum[0]-$sum[1]-$sum[2], 2, '.', ','); else echo number_format($sum[0]-$sum[1]-$sum[2], 0, '.', ',')?></td>
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
        require("./modals/mdl-ssup.php");

        require("./bin/php/footer.php");
    ?>
</body>

</html>