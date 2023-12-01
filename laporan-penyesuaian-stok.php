<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Penyesuaian Stok";

    $lp = "1";
    $jns = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    $p = "";
    $np = "";
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $jns = trim(mysqli_real_escape_string($db, $_GET["j"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        $p = trim(mysqli_real_escape_string($db, $_GET["p"]));
        $np = trim(mysqli_real_escape_string($db, $_GET["np"]));
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Penyesuaian Stok | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 156, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2">
                    <label for="slct-type">Jenis Laporan</label>
                    <select name="l" id="slct-type" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Rekap Per Tgl</option>
                        <option value="3" <?php if(strcasecmp($lp,"3") == 0) echo "selected=\"selected\"";?>>Rekap Per Bulan</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Rincian Per Tgl</option>
                        <option value="4" <?php if(strcasecmp($lp,"4") == 0) echo "selected=\"selected\"";?>>Rincian Per Bulan</option>
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
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 my-2" id="div-pro">
                    <label for="txt-nma-pro">Produk</label>
                    <div class="d-none" id="bloodhound">
                        <input class="typeahead form-control" type="text">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set" id="txt-nma-pro" name="np" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $np;?>">
                        <input type="text" class="d-none" id="txt-pro" name="p" value="<?php echo $p;?>">

                        <div class="input-group-append">
                            <button class="btn btn-light border" type="button" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                        </div>

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-rpro" type="button"><img src="./bin/img/icon/delete-icon.png" width="20" alt="Reset"></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-ps-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 157, 1)))
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 133, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Penyesuaian Stok</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <?php
                                if(strcasecmp($lp,"1") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <?php
                                }
                                else if(strcasecmp($lp,"2") == 0 || strcasecmp($lp,"4") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle">No</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle">Grade</th>
                            <th class="border sticky-top align-middle">Oz</th>
                            <th class="border sticky-top align-middle">Cut Style</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <?php
                                    if(strcasecmp($lp,"4") != 0)
                                    {
                            ?>
                            <th class="border sticky-top align-middle">Keterangan</th>
                            <?php
                                    }
                                }
                                else if(strcasecmp($lp,"3") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle">Bulan</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"3") == 0 || strcasecmp($lp,"4") == 0)
                                $lst = getPsFrmTo2($frm, $to, $p);
                            else
                                $lst = getPsFrmTo($frm, $to, $p);

                            if(strcasecmp($lp,"1") == 0)
                            {
                                $sum = 0;
                                for($i = 0; $i < count($lst); $i++)
                                {
                        ?>
                        <tr>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1]));?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][3])) echo number_format($lst[$i][3],2,'.',','); else echo number_format($lst[$i][3],0,'.',',');?></td>
                        </tr>
                        <?php
                                    $sum += $lst[$i][3];
                                }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right">Total</td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($sum)) echo number_format($sum,2,'.',','); else echo number_format($sum,0,'.',',');?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0)
                            {
                                $sum = 0;
                                for($i = 0; $i < count($lst); $i++)
                                {
                        ?>
                        <tr>
                            <th class="border font-weight-bold bg-dark text-light" colspan="7"><?php echo date('d/m/Y', strtotime($lst[$i][1]));?></th>
                        </tr>
                        <?php
                                    $lst2 = getPsItem3($lst[$i][0], $p);
                                    for($j = 0; $j < count($lst2); $j++)
                                    {
                        ?>
                        <tr>
                            <td class="border"><?php echo $j+1;?></td>
                            <td class="border"><?php echo $lst2[$j][0];?></td>
                            <td class="border"><?php echo $lst2[$j][1];?></td>
                            <td class="border"><?php echo $lst2[$j][2];?></td>
                            <td class="border"><?php echo $lst2[$j][3];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst2[$j][4])) echo number_format($lst2[$j][4],2,'.',','); else echo number_format($lst2[$j][4],0,'.',',');?></td>
                            <td class="border"><?php echo $lst2[$j][5];?></td>
                        </tr>
                        <?php
                                    }
                                    $sum += $lst[$i][3];
                                }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="5">Total</td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($sum)) echo number_format($sum,2,'.',','); else echo number_format($sum,0,'.',',');?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"3") == 0)
                            {
                                $sum = 0;
                                for($i = 0; $i < count($lst); $i++)
                                {
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][1])) echo number_format($lst[$i][1],2,'.',','); else echo number_format($lst[$i][1],0,'.',',');?></td>
                        </tr>
                        <?php
                                    $sum += $lst[$i][1];
                                }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right">Total</td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($sum)) echo number_format($sum,2,'.',','); else echo number_format($sum,0,'.',',');?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"4") == 0)
                            {
                                $sum = 0;
                                for($i = 0; $i < count($lst); $i++)
                                {
                        ?>
                        <tr>
                            <th class="border font-weight-bold bg-dark text-light" colspan="7"><?php echo $lst[$i][0];?></th>
                        </tr>
                        <?php
                                    $frm = date('Y-m-d', strtotime($lst[$i][2]."-01"));
                                    $to = date('Y-m-t', strtotime($frm));
                                    $lst2 = getPsItem4($frm, $to, $p);
                                    for($j = 0; $j < count($lst2); $j++)
                                    {
                        ?>
                        <tr>
                            <td class="border"><?php echo $j+1;?></td>
                            <td class="border"><?php echo $lst2[$j][0];?></td>
                            <td class="border"><?php echo $lst2[$j][1];?></td>
                            <td class="border"><?php echo $lst2[$j][2];?></td>
                            <td class="border"><?php echo $lst2[$j][3];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst2[$j][4])) echo number_format($lst2[$j][4],2,'.',','); else echo number_format($lst2[$j][4],0,'.',',');?></td>
                        </tr>
                        <?php
                                        $sum += $lst2[$j][4];
                                    }
                                }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="5">Total</td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($sum)) echo number_format($sum,2,'.',','); else echo number_format($sum,0,'.',',');?></td>
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
        require("./modals/mdl-spro.php");
        require("./bin/php/footer.php");

        closeDB($db);
    ?>
</body>

</html>