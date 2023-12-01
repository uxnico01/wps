<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Pindah Stok";

    $lp = "1";
    $jns = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    $p = "";
    $np = "";
    $gdgf = "";
    $gdgt = "";
    $jns = "";
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $jns = trim(mysqli_real_escape_string($db, $_GET["j"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        $p = trim(mysqli_real_escape_string($db, $_GET["p"]));
        $np = trim(mysqli_real_escape_string($db, $_GET["np"]));
        $gdgf = trim(mysqli_real_escape_string($db, $_GET["gf"]));
        $gdgt = trim(mysqli_real_escape_string($db, $_GET["gt"]));
    }

    $lgdg = getAllGdg($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Pindah Stok | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 168, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2">
                    <label for="slct-type">Jenis Laporan</label>
                    <select name="l" id="slct-type-mv" class="custom-select">
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
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2">
                    <label for="slct-gdgf">Dari Gudang</label>
                    <select name="gf" id="slct-gdgf" class="custom-select">
                        <option value="">Semua Gudang</option>
                        <?php
                            for($i = 0; $i < count($lgdg); $i++){
                        ?>
                        <option value="<?php echo $lgdg[$i][0];?>" <?php if(strcasecmp($lgdg[$i][0], $gdgf) == 0) echo "selected=\"selected\"";?>><?php echo $lgdg[$i][1];?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2">
                    <label for="slct-gdgt">Ke Gudang</label>
                    <select name="gt" id="slct-gdgt" class="custom-select">
                        <option value="">Semua Gudang</option>
                        <?php
                            for($i = 0; $i < count($lgdg); $i++){
                        ?>
                        <option value="<?php echo $lgdg[$i][0];?>" <?php if(strcasecmp($lgdg[$i][0], $gdgt) == 0) echo "selected=\"selected\"";?>><?php echo $lgdg[$i][1];?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2">
                    <label for="slct-jns">Jenis</label>
                    <select name="j" id="slct-jns" class="custom-select">
                        <option value="">Semua Jenis</option>
                        <option value="I" <?php if(strcasecmp($jns,"I") == 0) echo "selected=\"selected\"";?>>Penitipan</option>
                        <option value="O" <?php if(strcasecmp($jns,"O") == 0) echo "selected=\"selected\"";?>>Pengambilan</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 my-2 <?php if(strcasecmp($lp,"1") == 0) echo "d-none";?>" id="div-pro">
                    <label for="txt-nma-pro">Produk</label>
                    <div class="d-none" id="bloodhound">
                        <input class="typeahead form-control" type="text">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set txt-pro-lap" id="txt-nma-pro" name="np" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $np;?>">
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
                        <button class="m-1 btn btn-light border border-success" id="btn-mv-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 169, 1)))
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 169, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Pindah Stok - <?php if(strcasecmp($lp,"1") == 0) echo "Rekap"; else if(strcasecmp($lp,"2") == 0) echo "Rincian";?></h5>
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
                            <th class="border sticky-top align-middle">ID</th>
                            <th class="border sticky-top align-middle">Dari</th>
                            <th class="border sticky-top align-middle">Tujuan</th>
                            <th class="border sticky-top align-middle">Jenis</th>
                            <th class="border sticky-top align-middle">Kepada</th>
                            <th class="border sticky-top align-middle">Deskripsi</th>
                            <th class="border sticky-top align-middle">No TT</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <?php
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">ID</th>
                            <th class="border sticky-top align-middle">Dari</th>
                            <th class="border sticky-top align-middle">Tujuan</th>
                            <th class="border sticky-top align-middle">Jenis</th>
                            <th class="border sticky-top align-middle">Kepada</th>
                            <th class="border sticky-top align-middle">Deskripsi</th>
                            <th class="border sticky-top align-middle">No TT</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle text-right">Qty</th>
                            <th class="border sticky-top align-middle">Sat</th>
                            <th class="border sticky-top align-middle">Tgl Exp</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle">Ket</th>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"1") == 0){
                                $lst = getMoveFrmTo($frm, $to, $jns, $gdgf, $gdgt, $db);
                                $sum = 0;
                                for($i = 0; $i < count($lst); $i++)
                                {
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo $lst[$i][1];?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border"><?php echo $lst[$i][3];?></td>
                            <td class="border"><?php echo $lst[$i][4];?></td>
                            <td class="border"><?php echo $lst[$i][5];?></td>
                            <td class="border"><?php echo $lst[$i][8];?></td>
                            <td class="border"><?php echo $lst[$i][6];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][7])) echo number_format($lst[$i][7],2,'.',','); else echo number_format($lst[$i][7],0,'.',',');?></td>
                        </tr>
                        <?php
                                    $sum += $lst[$i][7];
                                }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="8">Total</td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($sum)) echo number_format($sum,2,'.',','); else echo number_format($sum,0,'.',',');?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0)
                            {
                                $lst = getMoveFrmTo2($frm, $to, $jns, $gdgf, $gdgt, $p, $db);
                                $sum = array(0, 0);
                                $tmp = "";
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    $nma = $lst[$i][7]." / ".$lst[$i][8];

                                    if(strcasecmp($lst[$i][9],"") != 0){
                                        $nma .= " / ".$lst[$i][9];
                                    }
                                    
                                    if(strcasecmp($lst[$i][10],"") != 0){
                                        $nma .= " / ".$lst[$i][10];
                                    }
                        ?>
                        <tr>
                            <?php
                                    if(strcasecmp($lst[$i][1], $tmp) != 0){
                            ?>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo $lst[$i][1];?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border"><?php echo $lst[$i][3];?></td>
                            <td class="border"><?php echo $lst[$i][4];?></td>
                            <td class="border"><?php echo $lst[$i][16];?></td>
                            <td class="border"><?php echo $lst[$i][5];?></td>
                            <td class="border"><?php echo $lst[$i][6];?></td>
                            <?php
                                    }
                                    else{
                            ?>
                            <td class="border" colspan="8"></td>
                            <?php
                                    }
                            ?>
                            <td class="border"><?php echo $nma;?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][11])) echo number_format($lst[$i][11],2,'.',','); else echo number_format($lst[$i][11],0,'.',',');?></td>
                            <td class="border"><?php echo $lst[$i][12];?></td>
                            <td class="border"><?php echo $lst[$i][13];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][14])) echo number_format($lst[$i][14],2,'.',','); else echo number_format($lst[$i][14],0,'.',',');?></td>
                            <td class="border"><?php echo $lst[$i][15];?></td>
                        </tr>
                        <?php
                                    $tmp = $lst[$i][1];
                                    $sum[0] += $lst[$i][11];
                                    $sum[1] += $lst[$i][14];
                                }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="9">Total</td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($sum[0])) echo number_format($sum[0],2,'.',','); else echo number_format($sum[0],0,'.',',');?></td>
                            <td class="border" colspan="2"></td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($sum[1])) echo number_format($sum[1],2,'.',','); else echo number_format($sum[1],0,'.',',');?></td>
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