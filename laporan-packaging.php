<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Pengiriman";

    $lp = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    $po = "";
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        $po = trim(mysqli_real_escape_string($db, $_GET["po"]));
    }

    closeDB($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Packaging | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 93, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 my-2">
                    <label for="slct-jns-krm">Jenis Laporan</label>
                    <select name="l" id="slct-jns-krm" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Rekap</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Rincian</option>
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
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 my-2 <?php if(strcasecmp($lp,"1") == 0) echo "d-none";?>" id="div-po">
                    <label for="txt-po">P/O</label>
                    <div class="d-none" id="bloodhound">
                        <input class="typeahead form-control" type="text">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set" id="txt-po" name="po" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $po;?>">

                        <div class="input-group-append">
                            <button class="btn btn-light border" type="button" data-target="#mdl-spo3" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                        </div>

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-rpo" type="button"><img src="./bin/img/icon/delete-icon.png" width="20" alt="Reset"></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-krm-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 94, 1)))
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 94, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Packaging</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top align-middle d-none">ID</th>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle d-none">Ket</th>
                            <th class="border sticky-top align-middle d-none">Ket2</th>
                            <th class="border sticky-top align-middle d-none">Ket3</th>
                            <?php
                                if(strcasecmp($lp,"1") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle text-right">Total Kirim (KG)</th>
                            <?php
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle">No P/O</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle">Grade</th>
                            <th class="border sticky-top align-middle">Oz</th>
                            <th class="border sticky-top align-middle">Cut Style</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle">Keterangan</th>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"2") == 0)
                                $lst = getKirimFrmTo2($frm, $to, $po);
                            else
                                $lst = getKirimFrmTo($frm, $to);

                            $sum = array(0);
                            $tmp = "";
                            for($i = 0; $i < count($lst); $i++)
                            {
                        ?>
                        <tr>
                            <?php
                                if((strcasecmp($tmp, $lst[$i][0]) != 0 && strcasecmp($lp,"2") == 0) || strcasecmp($lp,"1") == 0)
                                {
                            ?>
                            <td class="border d-none"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1]));?></td>
                            <td class="border d-none"><?php echo $lst[$i][2];?></td>
                            <td class="border d-none"><?php echo $lst[$i][3];?></td>
                            <td class="border d-none"><?php echo $lst[$i][4];?></td>
                            <td class="border d-none"><?php echo $lst[$i][5];?></td>
                            <?php
                                }
                                else
                                {
                            ?>
                            <td class="border" colspan="1"></td>
                            <?php
                                }

                                if(strcasecmp($lp,"1") == 0)
                                {
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][7])) echo number_format($lst[$i][7], 2, '.', ','); else echo number_format($lst[$i][7], 0, '.', ',');?></td>
                            <?php
                                    $sum[0] += $lst[$i][7];
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                            ?>
                            <td class="border"><?php echo $lst[$i][13];?></td>
                            <td class="border"><?php echo $lst[$i][8];?></td>
                            <td class="border"><?php echo $lst[$i][9];?></td>
                            <td class="border"><?php echo $lst[$i][10];?></td>
                            <td class="border"><?php echo $lst[$i][11];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][12])) echo number_format($lst[$i][12], 2, '.', ','); else echo number_format($lst[$i][12], 0, '.', ',');?></td>
                            <td class="border"><?php echo $lst[$i][17];?></td>
                            <?php
                                    $sum[0] += $lst[$i][12];
                                }

                                $tmp = $lst[$i][0];
                            ?>
                        </tr>
                        <?php
                            }
                            
                            if(strcasecmp($lp,"1") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="1">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="6">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
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
        require("./modals/mdl-spo3.php");
        require("./bin/php/footer.php");
    ?>
</body>

</html>