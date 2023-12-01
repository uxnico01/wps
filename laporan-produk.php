<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Produk";

    $sett = getSett();
    $tmpl = "1";
    $jns = "1";
    $lp = "1";
    $frm = date('Y-m-d');
    $to = date('Y-m-d');
    $gdg = "";
    $kates = "";
    $mdl = "1";
    $gol = "";
    if(isset($_GET["s"]))
    {
        $tmpl = trim(mysqli_real_escape_string($db, $_GET["t"]));
        $jns = trim(mysqli_real_escape_string($db, $_GET["j"]));
        $lp = trim(mysqli_real_escape_string($db, $_GET["lp"]));
        $gdg = trim(mysqli_real_escape_string($db, $_GET["g"]));
        $kates = trim(mysqli_real_escape_string($db, $_GET["k"]));
        $gol = trim(mysqli_real_escape_string($db, $_GET["gl"]));
        $mdl = trim(mysqli_real_escape_string($db, $_GET["md"]));
        
        if(strcasecmp($tmpl,"1") == 0)
        {
            $frm = date('Y-m-d');
            $to = date('Y-m-d');
        }
        else if(strcasecmp($tmpl,"2") == 0)
        {
            $frm = date('Y-m-01');
            $to = date('Y-m-t');
        }
        else
        {
            $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
            $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        }
    }

    $lgdg = getAllGdg($db);
    $lkates = getAllKates($db);
    $lgol = getAllGol($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Produk | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 79, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2">
                    <label for="slct-lp-pro">Jenis Laporan</label>
                    <select name="lp" id="slct-lp-pro" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Rekap - Transaksi</option>
                        <option value="3" <?php if(strcasecmp($lp,"3") == 0) echo "selected=\"selected\"";?>>Rekap - Sisa Stock</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Per Tanggal</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 my-2 <?php if(strcasecmp($lp,"3") == 0) echo "d-none";?>" id="div-type">
                    <label for="slct-type">Tampil Berdasarkan</label>
                    <select name="t" id="slct-type" class="custom-select slct-type">
                        <option value="1" <?php if(strcasecmp($tmpl,"1") == 0) echo "selected=\"selected\"";?>>Qty hari ini</option>
                        <option value="2" <?php if(strcasecmp($tmpl,"2") == 0) echo "selected=\"selected\"";?>>Qty bulan ini</option>
                        <option value="3" <?php if(strcasecmp($tmpl,"3") == 0) echo "selected=\"selected\"";?>>Qty berdasarkan tanggal</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2">
                    <label for="slct-type">Jenis Tampil</label>
                    <select name="j" id="slct-tmpl" class="custom-select">
                        <option value="1" <?php if(strcasecmp($jns,"1") == 0) echo "selected=\"selected\"";?>>Tampil semua</option>
                        <option value="2" <?php if(strcasecmp($jns,"2") == 0) echo "selected=\"selected\"";?>>Tampil bersaldo</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"3") != 0) echo "d-none";?>" id="div-mdl-lp-pro">
                    <label for="slct-type">Model Laporan</label>
                    <select name="md" id="slct-mdl" class="custom-select">
                        <option value="1" <?php if(strcasecmp($mdl,"1") == 0) echo "selected=\"selected\"";?>>Default</option>
                        <option value="2" <?php if(strcasecmp($mdl,"2") == 0) echo "selected=\"selected\"";?>>Berdasarkan Golongan</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($tmpl,"3") != 0) echo "d-none";?>" id="div-frm">
                    <label for="dte-frm">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dte-frm" name="f" value="<?php echo $frm;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($tmpl,"3") != 0) echo "d-none";?>" id="div-to">
                    <label for="dte-smpi">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="dte-smpi" name="tt" value="<?php echo $to;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2" id="div-gdg">
                    <label for="dte-smpi">Pilih Gudang</label>
                    <select name="g" id="slct-gdg" class="custom-select">
                        <option value="">Semua Gudang</option>
                        <?php
                            for($i = 0; $i < count($lgdg); $i++){
                        ?>
                        <option value="<?php echo $lgdg[$i][0];?>" <?php if(strcasecmp($gdg,$lgdg[$i][0]) == 0) echo "selected=\"selected\"";?>><?php echo $lgdg[$i][1];?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2" id="div-kates">
                    <label for="dte-smpi">Pilih Kategori</label>
                    <select name="k" id="slct-kates" class="custom-select">
                        <option value="">Semua Kategori</option>
                        <?php
                            for($i = 0; $i < count($lkates); $i++){
                        ?>
                        <option value="<?php echo $lkates[$i][0];?>" <?php if(strcasecmp($kates,$lkates[$i][0]) == 0) echo "selected=\"selected\"";?>><?php echo $lkates[$i][1];?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"3") != 0) echo "d-none";?>" id="div-gol">
                    <label for="dte-smpi">Pilih Golongan</label>
                    <select name="gl" id="slct-gol" class="custom-select">
                        <option value="">Semua Golongan</option>
                        <?php
                            for($i = 0; $i < count($lgol); $i++){
                        ?>
                        <option value="<?php echo $lgol[$i][0];?>" <?php if(strcasecmp($gol,$lgol[$i][0]) == 0) echo "selected=\"selected\"";?>><?php echo $lgol[$i][1];?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-pro-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 80, 1)))
                            {
                        ?>
                        <button class="m-1 btn btn-light border border-info btn-print" type="button"><img src="./bin/img/icon/print-icon.png" alt="" width="21"></button>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <hr class="mt-1 mb-0">
        </div>

        <?php
            if(isset($_GET["s"]))
            {
        ?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 80, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Produk</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-60vh mxh-60vh">
                <?php
                    if(strcasecmp($lp,"1") == 0){
                ?>
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border align-middle sticky-top" rowspan="2">ID</th>
                            <th class="border align-middle sticky-top" rowspan="2">Nama</th>
                            <th class="border align-middle sticky-top" rowspan="2">Kategori</th>
                            <th class="border text-right align-middle sticky-top" rowspan="2">Saldo</th>
                            <th class="border text-right align-middle sticky-top" rowspan="2">Terima</th>
                            <th class="border text-right sticky-top" colspan="2">Cut</th>
                            <th class="border text-right sticky-top" colspan="3">Vacuum</th>
                            <th class="border text-right sticky-top" colspan="2">Saw</th>
                            <th class="border text-right sticky-top" colspan="2">Beku</th>
                            <th class="border text-right align-middle sticky-top" colspan="2">Re-Packing</th>
                            <th class="border text-right align-middle sticky-top" colspan="2">Pindah</th>
                            <th class="border text-right align-middle sticky-top" rowspan="2">Penyesuaian</th>
                            <th class="border text-right align-middle sticky-top" rowspan="2">Masuk</th>
                            <th class="border text-right align-middle sticky-top" rowspan="2">Kirim</th>
                            <th class="border text-right align-middle sticky-top" rowspan="2">Retur Kirim</th>
                            <th class="border text-right align-middle sticky-top" rowspan="2">Total</th>
                        </tr>

                        <tr>
                            <th class="border text-right sticky-top top-35px align-middle">Proses</th>
                            <th class="border text-right sticky-top top-35px align-middle">Hasil</th>
                            <th class="border text-right sticky-top top-35px align-middle">Proses (Cutting)</th>
                            <th class="border text-right sticky-top top-35px align-middle">Proses (Defroze)</th>
                            <th class="border text-right sticky-top top-35px align-middle">Hasil</th>
                            <th class="border text-right sticky-top top-35px align-middle">Proses</th>
                            <th class="border text-right sticky-top top-35px align-middle">Hasil</th>
                            <th class="border text-right sticky-top top-35px align-middle">Proses</th>
                            <th class="border text-right sticky-top top-35px align-middle">Hasil</th>
                            <th class="border text-right sticky-top top-35px align-middle">Proses</th>
                            <th class="border text-right sticky-top top-35px align-middle">Hasil</th>
                            <th class="border text-right sticky-top top-35px align-middle">Msk</th>
                            <th class="border text-right sticky-top top-35px align-middle">Klr</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $lst = getProFrmTo($frm, $to, $gdg, $kates);

                            $sum = array();
                            for($i = 0; $i < 19; $i++){
                                $sum[$i] = 0;
                            }

                            for($i = 0; $i < count($lst); $i++)
                            {
                                $cutpro = getSumCutFrmTo4($frm, $to, $lst[$i][0], $gdg);
                                $cutpro2 = getSumCutFrmTo5($frm, $lst[$i][0], $gdg);
                                $saldo = $lst[$i][7]-$lst[$i][10]-$lst[$i][13]+$lst[$i][16]-$lst[$i][19]+$lst[$i][22]-$lst[$i][25]+$lst[$i][28]+$lst[$i][30]-$cutpro2+$lst[$i][32]-$lst[$i][35]+$lst[$i][38]+$lst[$i][41]+$lst[$i][44]-$lst[$i][47]-$lst[$i][51]+$lst[$i][54]+$lst[$i][57];

                                $sum[0] += $saldo;
                                $sum[1] += $lst[$i][6];
                                $sum[2] += $lst[$i][9];
                                $sum[3] += $lst[$i][27];
                                $sum[4] += $lst[$i][12];
                                $sum[5] += $lst[$i][15];
                                $sum[6] += $lst[$i][18];
                                $sum[7] += $lst[$i][21];
                                $sum[8] += $lst[$i][24];
                                $sum[9] += $cutpro;
                                $sum[10] += $lst[$i][31];
                                $sum[11] += $lst[$i][34];
                                $sum[12] += $lst[$i][37];
                                $sum[13] += $lst[$i][40];
                                $sum[14] += $lst[$i][46];
                                $sum[15] += $lst[$i][43];
                                $sum[16] += $lst[$i][50];
                                $sum[17] += $lst[$i][53];
                                $sum[18] += $lst[$i][56];

                                if($saldo == 0 && $lst[$i][6] == 0 && $lst[$i][9] == 0 && $lst[$i][27] == 0 && $lst[$i][12] == 0 && $lst[$i][15] == 0 && $lst[$i][18] == 0 && $lst[$i][21] == 0 && $lst[$i][24] == 0 && $cutpro == 0 && $lst[$i][31] == 0 && $lst[$i][34] == 0 && $lst[$i][37] == 0 && $lst[$i][40] == 0 && $lst[$i][43] == 0 && $lst[$i][46] == 0 && $lst[$i][50] == 0 && $lst[$i][53] == 0 && $lst[$i][56] == 0 && strcasecmp($jns,"2") == 0)
                                    continue;

                                $sttl = $saldo + $lst[$i][6] - $lst[$i][9] + $lst[$i][27] - $lst[$i][12] + $lst[$i][15] - $lst[$i][18] + $lst[$i][21] - $lst[$i][24] - $cutpro + $lst[$i][31] - $lst[$i][34] + $lst[$i][37] + $lst[$i][40] - $lst[$i][43] + $lst[$i][46] - $lst[$i][50] + $lst[$i][53] + $lst[$i][56];
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo $lst[$i][1]." / ".$lst[$i][4]; if(strcasecmp($lst[$i][2],"") != 0) echo " / ".$lst[$i][2]; if(strcasecmp($lst[$i][3],"") != 0) echo " / ".$lst[$i][3]; ?></td>
                            <td class="border"><?php echo $lst[$i][49];?></td>
                            <td class="border text-right"><?php if(isDecimal($saldo)) echo number_format($saldo, 2, '.', ','); else echo number_format($saldo, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][6])) echo number_format($lst[$i][6], 2, '.', ','); else echo number_format($lst[$i][6], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][9])) echo number_format($lst[$i][9], 2, '.', ','); else echo number_format($lst[$i][9], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][27])) echo number_format($lst[$i][27], 2, '.', ','); else echo number_format($lst[$i][27], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($cutpro)) echo number_format($cutpro, 2, '.', ','); else echo number_format($cutpro, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][12])) echo number_format($lst[$i][12], 2, '.', ','); else echo number_format($lst[$i][12], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][15])) echo number_format($lst[$i][15], 2, '.', ','); else echo number_format($lst[$i][15], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][18])) echo number_format($lst[$i][18], 2, '.', ','); else echo number_format($lst[$i][18], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][21])) echo number_format($lst[$i][21], 2, '.', ','); else echo number_format($lst[$i][21], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][34])) echo number_format($lst[$i][34], 2, '.', ','); else echo number_format($lst[$i][34], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][37])) echo number_format($lst[$i][37], 2, '.', ','); else echo number_format($lst[$i][37], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][50])) echo number_format($lst[$i][50], 2, '.', ','); else echo number_format($lst[$i][50], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][53])) echo number_format($lst[$i][53], 2, '.', ','); else echo number_format($lst[$i][53], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][46])) echo number_format($lst[$i][46], 2, '.', ','); else echo number_format($lst[$i][46], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][43])) echo number_format($lst[$i][43], 2, '.', ','); else echo number_format($lst[$i][43], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][40])) echo number_format($lst[$i][40], 2, '.', ','); else echo number_format($lst[$i][40], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][31])) echo number_format($lst[$i][31], 2, '.', ','); else echo number_format($lst[$i][31], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][24])) echo number_format($lst[$i][24], 2, '.', ','); else echo number_format($lst[$i][24], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][56])) echo number_format($lst[$i][56], 2, '.', ','); else echo number_format($lst[$i][56], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($sttl)) echo number_format($sttl, 2, '.', ','); else echo number_format($sttl, 0, '.', ',');?></td>
                        </tr>
                        <?php
                            }
                        ?>
                        <?php
                            $ttl = $sum[0] + $sum[1] - $sum[2] + $sum[3] - $sum[4] + $sum[5] - $sum[6] + $sum[7] - $sum[8] - $sum[9] + $sum[10] - $sum[11] + $sum[12] + $sum[13] + $sum[14] - $sum[15] - $sum[16] + $sum[17] + $sum[18];
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="3">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[3])) echo number_format($sum[3], 2, '.', ','); else echo number_format($sum[3], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[9])) echo number_format($sum[9], 2, '.', ','); else echo number_format($sum[9], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[4])) echo number_format($sum[4], 2, '.', ','); else echo number_format($sum[4], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[5])) echo number_format($sum[5], 2, '.', ','); else echo number_format($sum[5], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[6])) echo number_format($sum[6], 2, '.', ','); else echo number_format($sum[6], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[7])) echo number_format($sum[7], 2, '.', ','); else echo number_format($sum[7], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[11])) echo number_format($sum[11], 2, '.', ','); else echo number_format($sum[11], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[12])) echo number_format($sum[12], 2, '.', ','); else echo number_format($sum[12], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[16])) echo number_format($sum[16], 2, '.', ','); else echo number_format($sum[16], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[17])) echo number_format($sum[17], 2, '.', ','); else echo number_format($sum[17], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[14])) echo number_format($sum[14], 2, '.', ','); else echo number_format($sum[14], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[15])) echo number_format($sum[15], 2, '.', ','); else echo number_format($sum[15], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[13])) echo number_format($sum[13], 2, '.', ','); else echo number_format($sum[13], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[10])) echo number_format($sum[10], 2, '.', ','); else echo number_format($sum[10], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[8])) echo number_format($sum[8], 2, '.', ','); else echo number_format($sum[8], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[18])) echo number_format($sum[18], 2, '.', ','); else echo number_format($sum[18], 0, '.', ',');?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($ttl)) echo number_format($ttl, 2, '.', ','); else echo number_format($ttl, 0, '.', ',');?></td>
                        </tr>
                    </tbody>
                </table>
                <?php
                    }
                    else if(strcasecmp($lp,"2") == 0){
                        $slsh = (int)(strtotime($to) - strtotime($frm))/86400;

                        if((int)$slsh > 30){
                ?>
                <div class="alert alert-danger">Periode maksimal 30 hari</div>
                <?php
                        }
                        else{
                            $sum = array();
                            $ltgl = getAllProcTglFrmTo($frm, $to, $gdg, $db);
                ?>
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border align-middle sticky-top" rowspan="2">ID</th>
                            <th class="border align-middle sticky-top" rowspan="2">Produk</th>
                            <th class="border align-middle sticky-top" rowspan="2">Kategori</th>
                            <th class="border text-right align-middle sticky-top" rowspan="2">Saldo</th>
                            <?php
                                for($i = 0; $i < count($ltgl); $i++){
                            ?>
                            <th class="border align-middle sticky-top text-center" colspan="3"><?php echo date('d/m/Y', strtotime($ltgl[$i]));?></th>
                            <?php
                                }
                            ?>
                            <th class="border align-middle sticky-top text-right" rowspan="2">Total Akhir</th>
                        </tr>
                        <tr>
                            <?php
                                for($i = 0; $i < count($ltgl); $i++){
                                    $sum[$i] = array(0,0);
                            ?>
                            <th class="border align-middle sticky-top text-right top-35px">Msk</th>
                            <th class="border align-middle sticky-top text-right top-35px">Klr</th>
                            <th class="border align-middle sticky-top top-35px">Ket</th>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $lpro = getAllPro("2", "", $kates);

                            $ssaldo = 0;
                            for($i = 0; $i < count($lpro); $i++){
                                $saldo = getSaldoProFrmTo($lpro[$i][0], $frm, $to, $gdg, $db);
                                $ssaldo += $saldo[0];
                                $sttl = $saldo[0];

                                if(strcasecmp($jns,"2") == 0 && $saldo[1] == 0)
                                    continue;
                        ?>
                        <tr>
                            <td class="border"><?php echo $lpro[$i][0]; ?></td>
                            <td class="border"><?php echo $lpro[$i][1]." / ".$lpro[$i][2]; if(strcasecmp($lpro[$i][3],"") != 0) echo " / ".$lpro[$i][3]; if(strcasecmp($lpro[$i][4],"") != 0) echo " / ".$lpro[$i][4]; ?></td>
                            <td class="border"><?php echo $lpro[$i][15]; ?></td>
                            <td class="border text-right"><?php if(isDecimal($saldo[0])) echo number_format($saldo[0], 2, '.', ','); else echo number_format($saldo[0], 0, '.', ',');?></td>
                            <?php
                                for($j = 0; $j < count($ltgl); $j++){
                                    $qin = getQtyInProTgl($lpro[$i][0], $ltgl[$j], $gdg, $db);
                                    $qpcut = getQtyCutProTgl($lpro[$i][0], $ltgl[$j], $gdg, $db);
                                    $qpvac = getQtyVacProTgl($lpro[$i][0], $ltgl[$j], $gdg, $db);
                                    $qpsaw = getQtySawProTgl($lpro[$i][0], $ltgl[$j], $gdg, $db);
                                    $qpkrm = getQtyKrmProTgl($lpro[$i][0], $ltgl[$j], $gdg, $db);
                                    $qpfrz = getQtyFrzProTgl($lpro[$i][0], $ltgl[$j], $gdg, $db);
                                    $qpps = getQtyPsProTgl($lpro[$i][0], $ltgl[$j], $gdg, $db);
                                    $qpmv = getQtyMoveProTgl($lpro[$i][0], $ltgl[$j], $gdg, $db);
                                    $qprpkg = getQtyRPkgProTgl($lpro[$i][0], $ltgl[$j], $gdg, $db);

                                    $qout = $qpcut + $qpvac + $qpsaw + $qpkrm[0] + $qpfrz + $qpps + $qpmv + $qprpkg;

                                    $txt = "";
                                    if($qpcut > 0)
                                        $txt .= "Cutting (".number_format($qpcut,2,'.',',').")";

                                    if($qpvac > 0){
                                        if(strcasecmp($txt,"") != 0)
                                            $txt .= ", ";

                                        $txt .= "Vacuum (".number_format($qpvac,2,'.',',').")";
                                    }
                                    
                                    if($qpsaw > 0){
                                        if(strcasecmp($txt,"") != 0)
                                            $txt .= ", ";

                                        $txt .= "Sawing (".number_format($qpsaw,2,'.',',').")";
                                    }
                                    
                                    if(strcasecmp($qpkrm[1],"") != 0){
                                        if(strcasecmp($txt,"") != 0)
                                            $txt .= ", ";
                                            
                                        $txt .= $qpkrm[1];
                                    }
                                    
                                    if($qpfrz > 0){
                                        if(strcasecmp($txt,"") != 0)
                                            $txt .= ", ";

                                        $txt .= "Pembekuan (".number_format($qpfrz,2,'.',',').")";
                                    }
                                    
                                    if($qpps > 0){
                                        if(strcasecmp($txt,"") != 0)
                                            $txt .= ", ";

                                        $txt .= "Penyesuaian (".number_format($qpps,2,'.',',').")";
                                    }
                                    
                                    if($qpmv > 0){
                                        if(strcasecmp($txt,"") != 0)
                                            $txt .= ", ";

                                        $txt .= "Pindah Lokasi (".number_format($qpmv,2,'.',',').")";
                                    }
                                    
                                    if($qprpkg > 0){
                                        if(strcasecmp($txt,"") != 0)
                                            $txt .= ", ";

                                        $txt .= "Re-Packing (".number_format($qprpkg,2,'.',',').")";
                                    }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($qin)) echo number_format($qin, 2, '.', ','); else echo number_format($qin, 0, '.', ',');?></td>
                            <td class="border text-danger text-right"><?php if(isDecimal($qout)) echo number_format($qout, 2, '.', ','); else echo number_format($qout, 0, '.', ',');?></td>
                            <td class="border small"><?php echo $txt;?></td>
                            <?php
                                    $sum[$j][0] += $qin;
                                    $sum[$j][1] += $qout;
                                    $sttl += $qin-$qout;
                                }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($sttl)) echo number_format($sttl, 2, '.', ','); else echo number_format($sttl, 0, '.', ',');?></td>
                        </tr>
                        <?php
                            }
                        ?>

                        <tr>
                            <td class="border font-weight-bold text-right" colspan="3">Grand Total</td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($ssaldo)) echo number_format($ssaldo, 2, '.', ','); else echo number_format($ssaldo, 0, '.', ',');?></td>
                            <?php
                                $ttl = $ssaldo;
                                for($i = 0; $i < count($sum); $i++){
                            ?>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($sum[$i][0])) echo number_format($sum[$i][0], 2, '.', ','); else echo number_format($sum[$i][0], 0, '.', ',');?></td>
                            <td class="border font-weight-bold text-danger text-right"><?php if(isDecimal($sum[$i][1])) echo number_format($sum[$i][1], 2, '.', ','); else echo number_format($sum[$i][1], 0, '.', ',');?></td>
                            <td class="border"></td>
                            <?php
                                    $ttl += $sum[$i][0]-$sum[$i][1];
                                }
                            ?>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($ttl)) echo number_format($ttl, 2, '.', ','); else echo number_format($ttl, 0, '.', ',');?></td>
                        </tr>
                    </tbody>
                </table>
                <?php
                        }
                    }
                    else if(strcasecmp($lp,"3") == 0){
                        if(strcasecmp($gdg,"") == 0)
                            $lgdg = getAllGdg($db);
                        else
                            $lgdg = array(getGdgID($gdg, $db));
                        
                        if(strcasecmp($mdl,"1") == 0){
                            if(strcasecmp($jns,"2") == 0){
                                $lpro = getAllPro("3", "", $kates);
                            }
                            else{
                                $lpro = getAllPro("2", "", $kates);
                            }

                            $sum = array()
                ?>
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top align-middle text-center">No</th>
                            <th class="border sticky-top align-middle">ID</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle">Kategori</th>
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

                    <tbody>
                        <?php
                            $ttl = 0;
                            for($i = 0; $i < count($lpro); $i++){
                                $sttl = 0;
                        ?>
                        <tr>
                            <td class="border text-center"><?php echo $i+1;?></td>
                            <td class="border"><?php echo $lpro[$i][0];?></td>
                            <td class="border"><?php echo $lpro[$i][1]." / ".$lpro[$i][2]; if(strcasecmp($lpro[$i][3],"") != 0) echo " / ".$lpro[$i][3]; if(strcasecmp($lpro[$i][4],"") != 0) echo " / ".$lpro[$i][4]; ?></td>
                            <td class="border"><?php echo $lpro[$i][15];?></td>
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
                                $ttl += $sttl;
                            }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="4">Total</td>
                            <?php
                                for($i = 0; $i < count($sum); $i++){
                            ?>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($sum[$i])) echo number_format($sum[$i], 2, '.', ','); else echo number_format($sum[$i], 0, '.', ',');?></td>
                            <?php
                                }
                            ?>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($ttl)) echo number_format($ttl, 2, '.', ','); else echo number_format($ttl, 0, '.', ',');?></td>
                        </tr>
                    </tbody>
                </table>
                <?php
                        }
                        else if(strcasecmp($mdl,"2") == 0){
                            if(strcasecmp($gol,"") == 0){
                                $lgols = getAllGol($db);
                            }
                            else{
                                $lgols = array(getGolID($gol, $db));
                            }
                ?>
                <div id="tbl-data">
                <?php
                            $mjns = $jns;
                            if(strcasecmp($jns,"2") == 0){
                                $mjns = "3";
                            }

                            for($i = 0; $i < count($lgols); $i++){
                                $lpro = getAllProGol($lgols[$i][0], $mjns, $kates, $db);
                                $sum = array();

                                if(count($lpro) == 0){
                                    continue;
                                }
                ?>
                    <table class="table table-sm table-striped">
                        <thead>
                            <?php
                                if($i > 0){
                            ?>
                            <tr>
                                <th class="border-0" colspan="<?php echo 5+count($lgdg);?>"></th>
                            </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <th colspan="<?php echo 5+count($lgdg);?>" class="border-0 text-center h4"><?php echo $lgols[$i][1];?></th>
                            </tr>
                        </thead>
                        <thead class="thead-dark">
                            <tr>
                                <th class="border align-middle text-center">No</th>
                                <th class="border align-middle">ID</th>
                                <th class="border align-middle">Produk</th>
                                <th class="border align-middle">Kategori</th>
                                <?php
                                    for($j = 0; $j < count($lgdg); $j++){
                                        $sum[$j] = 0;
                                ?>
                                <th class="border align-middle text-right"><?php echo $lgdg[$j][1];?></th>
                                <?php
                                    }
                                ?>
                                <th class="border align-middle text-right">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $ttl = 0;
                                for($j = 0; $j < count($lpro); $j++){
                                    $sttl = 0;
                            ?>
                            <tr>
                                <td class="border text-center"><?php echo $j+1;?></td>
                                <td class="border"><?php echo $lpro[$j][0];?></td>
                                <td class="border"><?php echo $lpro[$j][1]." / ".$lpro[$j][2]; if(strcasecmp($lpro[$j][3],"") != 0) echo " / ".$lpro[$j][3]; if(strcasecmp($lpro[$j][4],"") != 0) echo " / ".$lpro[$j][4]; ?></td>
                                <td class="border"><?php echo $lpro[$j][15];?></td>
                                <?php
                                    for($k = 0; $k < count($lgdg); $k++){
                                        $dgpro = getQGdgPro($lgdg[$k][0], $lpro[$j][0], $db);
                                        $sttl += $dgpro;
                                ?>
                                <td class="border text-right"><?php if(isDecimal($dgpro)) echo number_format($dgpro, 2, '.', ','); else echo number_format($dgpro, 0, '.', ',');?></td>
                                <?php
                                        $sum[$k] += $dgpro;
                                    }
                                ?>
                                <td class="border text-right"><?php if(isDecimal($sttl)) echo number_format($sttl, 2, '.', ','); else echo number_format($sttl, 0, '.', ',');?></td>
                            </tr>
                            <?php
                                    $ttl += $sttl;
                                }
                            ?>
                            <tr>
                                <td class="border font-weight-bold text-right" colspan="4">Total</td>
                                <?php
                                    for($j = 0; $j < count($sum); $j++){
                                ?>
                                <td class="border font-weight-bold text-right"><?php if(isDecimal($sum[$j])) echo number_format($sum[$j], 2, '.', ','); else echo number_format($sum[$j], 0, '.', ',');?></td>
                                <?php
                                    }
                                ?>
                                <td class="border font-weight-bold text-right"><?php if(isDecimal($ttl)) echo number_format($ttl, 2, '.', ','); else echo number_format($ttl, 0, '.', ',');?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php
                            }
                ?>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
        <?php
            }
        ?>
    </div>

    <?php
        require("./bin/php/footer.php");

        closeDB($db);
    ?>
</body>

</html>