<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Pembekuan";

    $lp = "1";
    $jns = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $jns = trim(mysqli_real_escape_string($db, $_GET["j"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
    }

    closeDB($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Pembekuan | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 142, 2)))
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
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Rekap</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Rincian</option>
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
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-mp-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 143, 1)))
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 143, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Pembekuan</h5>
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
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">Dari</th>
                            <th class="border sticky-top align-middle">Hasil</th>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"2") == 0)
                                $lst = getFrzFrmTo2($frm, $to, $p);
                            else
                                $lst = getFrzFrmTo($frm, $to, $p);

                            if(strcasecmp($lp,"1") == 0)
                            {
                                $sum = 0;
                                for($i = 0; $i < count($lst); $i++)
                                {
                        ?>
                        <tr>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][0]));?></td>
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
                            else if(strcasecmp($lp,"2") == 0)
                            {
                                $sum = 0;
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    $dri = $lst[$i][1];

                                    if(strcasecmp($lst[$i][2],"") != 0)
                                        $dri .= " / ".$lst[$i][2];

                                    if(strcasecmp($lst[$i][3],"") != 0)
                                        $dri .= " / ".$lst[$i][3];

                                    if(strcasecmp($lst[$i][4],"") != 0)
                                        $dri .= " / ".$lst[$i][4];

                                    if(isDecimal($lst[$i][5]))
                                        $dri .= " / ".number_format($lst[$i][5],2,'.',',');
                                    else
                                        $dri .= " / ".number_format($lst[$i][5],0,'.',',');

                                    $dri .= " / ".$lst[$i][6]." / ".$lst[$i][7]." / ".$lst[$i][8]." - ".$lst[$i][9];

                                    $hsl = $lst[$i][10];

                                    if(strcasecmp($lst[$i][11],"") != 0)
                                        $hsl .= " / ".$lst[$i][11];

                                    if(strcasecmp($lst[$i][12],"") != 0)
                                        $hsl .= " / ".$lst[$i][12];

                                    if(strcasecmp($lst[$i][13],"") != 0)
                                        $hsl .= " / ".$lst[$i][13];

                                    if(isDecimal($lst[$i][5]))
                                        $hsl .= " / ".number_format($lst[$i][5],2,'.',',');
                                    else
                                        $hsl .= " / ".number_format($lst[$i][5],0,'.',',');
                        ?>
                        <tr>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][0]));?></td>
                            <td class="border"><?php echo $dri;?></td>
                            <td class="border"><?php echo $hsl;?></td>
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
    </div>

    <?php
        require("./bin/php/footer.php");
    ?>
</body>

</html>