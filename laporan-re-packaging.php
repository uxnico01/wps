<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Re - Packaging";

    $lp = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    $pro = "";
    $np = "";
    $pro2 = "";
    $np2 = "";
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        $pro = trim(mysqli_real_escape_string($db, $_GET["p"]));
        $np = trim(mysqli_real_escape_string($db, $_GET["np"]));
        $pro2 = trim(mysqli_real_escape_string($db, $_GET["p2"]));
        $np2 = trim(mysqli_real_escape_string($db, $_GET["np2"]));
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Re - Packaging | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 177, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2">
                    <label for="slct-jns-rpkg">Jenis Laporan</label>
                    <select name="l" id="slct-jns-rpkg" class="custom-select">
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
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-2 my-2" id="div-bpro">
                    <label for="txt-nma-pro">Pilih Bahan Awal</label>
                    <div class="d-none" id="bloodhound">
                        <input class="typeahead form-control" type="text">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set" id="txt-nma-pro3-0" name="np2" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $np2;?>">
                        <input type="text" class="d-none" id="txt-pro3-0" name="p2" value="<?php echo $pro2;?>">

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-spro5" type="button" data-value="0"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                        </div>

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-rpro2" type="button" data-value="0"><img src="./bin/img/icon/delete-icon.png" width="20" alt="Reset"></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-2 my-2 <?php if(strcasecmp($lp,"1") == 0) echo "d-none";?>" id="div-hpro">
                    <label for="txt-nma-pro">Pilih Hasil Produk</label>
                    <div class="d-none" id="bloodhound">
                        <input class="typeahead form-control" type="text">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set txt-pro-lap" id="txt-nma-pro3-1" name="np" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $np;?>">
                        <input type="text" class="d-none" id="txt-pro3-1" name="p" value="<?php echo $pro;?>">

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-spro5" type="button" data-value="1"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                        </div>

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-rpro2" type="button" data-value="1"><img src="./bin/img/icon/delete-icon.png" width="20" alt="Reset"></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-rpkg-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 178, 1)))
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
                <h5>Laporan Re-Packaging</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <?php
                            if(strcasecmp($lp,"1") == 0){
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle">ID</th>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle text-right">Hasil Berat (KG)</th>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0){
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle">ID</th>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle">Hasil Produk</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                        </tr>
                        <?php
                            }
                        ?>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"1") == 0){
                                $lst = getRPkgFrmTo($frm, $to, $pro2, $db);
                                $sum = array(0, 0);
                                for($i = 0; $i < count($lst); $i++){
                                    $nma = $lst[$i][1]." / ".$lst[$i][2];

                                    if(strcasecmp($lst[$i][3],"") == 0){
                                        $nma .= " / ".$lst[$i][3];
                                    }
                                    
                                    if(strcasecmp($lst[$i][4],"") == 0){
                                        $nma .= " / ".$lst[$i][4];
                                    }
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][8];?></td>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo $nma;?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][5])) echo number_format($lst[$i][5],2,'.',','); else echo number_format($lst[$i][5],0,'.',',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][9])) echo number_format($lst[$i][9],2,'.',','); else echo number_format($lst[$i][9],0,'.',',');?></td>
                        </tr>
                        <?php
                                    $sum[0] += $lst[$i][5];
                                    $sum[1] += $lst[$i][9];
                                }
                        ?>
                        <tr>
                            <td class="border text-right font-weight-bold" colspan="3">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0],2,'.',','); else echo number_format($sum[0],0,'.',',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1],2,'.',','); else echo number_format($sum[1],0,'.',',');?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0){
                                $lst = getRPkgFrmTo2($frm, $to, $pro2, $pro, $db);
                                $sum = array(0, 0);
                                $tmp = "";
                                for($i = 0; $i < count($lst); $i++){
                        ?>
                        <tr>
                            <?php
                                if(strcasecmp($tmp,$lst[$i][8]) != 0){
                                    $nma = $lst[$i][1]." / ".$lst[$i][2];

                                    if(strcasecmp($lst[$i][3],"") == 0){
                                        $nma .= " / ".$lst[$i][3];
                                    }
                                    
                                    if(strcasecmp($lst[$i][4],"") == 0){
                                        $nma .= " / ".$lst[$i][4];
                                    }
                            ?>
                            <td class="border"><?php echo $lst[$i][8];?></td>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo $nma;?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][5])) echo number_format($lst[$i][5],2,'.',','); else echo number_format($lst[$i][5],0,'.',',');?></td>
                            <?php
                                    $sum[0] += $lst[$i][5];
                                }
                                else{
                            ?>
                            <td class="border" colspan="4"></td>
                            <?php
                                }

                                $nma2 = $lst[$i][9]." / ".$lst[$i][10];

                                if(strcasecmp($lst[$i][11],"") == 0){
                                    $nma2 .= " / ".$lst[$i][11];
                                }
                                
                                if(strcasecmp($lst[$i][12],"") == 0){
                                    $nma2 .= " / ".$lst[$i][12];
                                }
                            ?>
                            <td class="border"><?php echo $nma2;?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][13])) echo number_format($lst[$i][13],2,'.',','); else echo number_format($lst[$i][13],0,'.',',');?></td>
                        </tr>
                        <?php
                                    $sum[1] += $lst[$i][13];
                                    $tmp = $lst[$i][8];
                                }
                        ?>
                        <tr>
                            <td class="border text-right font-weight-bold" colspan="3">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0],2,'.',','); else echo number_format($sum[0],0,'.',',');?></td>
                            <td class="border"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1],2,'.',','); else echo number_format($sum[1],0,'.',',');?></td>
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
        require("./modals/mdl-spro5.php");
        require("./modals/mdl-spro3.php");
        require("./bin/php/footer.php");

        closeDB($db);
    ?>
</body>

</html>