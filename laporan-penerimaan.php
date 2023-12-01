<?php
    require("./bin/php/clsfunction.php");
    
    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Penerimaan";

    $lp = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    $nsp = "";
    $sp = "";
    $tgfk = "1";
    $jgfk = "1";
    $dgfk = "";
    $wgfk = "";
    $scut = "";
    $jsup = "";
    $date = [];
    $data = [];
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        $sp = trim(mysqli_real_escape_string($db, $_GET["sp"]));
        $nsp = trim(mysqli_real_escape_string($db, $_GET["nsp"]));
        $tgfk = trim(mysqli_real_escape_string($db, $_GET["tg"]));
        $jgfk = trim(mysqli_real_escape_string($db, $_GET["tj"]));
        $dgfk = trim(mysqli_real_escape_string($db, $_GET["td"]));
        $wgfk = trim(mysqli_real_escape_string($db, $_GET["tw"]));
        $scut = trim(mysqli_real_escape_string($db, $_GET["sc"]));
        $jsup = trim(mysqli_real_escape_string($db, $_GET["js"]));
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Penerimaan | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 85, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2">
                    <label for="slct-jns-trm">Jenis Laporan</label>
                    <select name="l" id="slct-jns-trm" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Rekap - Harian</option>
                        <option value="8" <?php if(strcasecmp($lp,"8") == 0) echo "selected=\"selected\"";?>>Rekap - Bulanan</option>
                        <option value="6" <?php if(strcasecmp($lp,"6") == 0) echo "selected=\"selected\"";?>>Rekap - Bulanan Per Supplier</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Rincian</option>
                        <option value="3" <?php if(strcasecmp($lp,"3") == 0) echo "selected=\"selected\"";?>>Per Produk</option>
                        <option value="7" <?php if(strcasecmp($lp,"7") == 0) echo "selected=\"selected\"";?>>Per Grade</option>
                        <option value="4" <?php if(strcasecmp($lp,"4") == 0) echo "selected=\"selected\"";?>>Per Supplier</option>
                        <option value="5" <?php if(strcasecmp($lp,"5") == 0) echo "selected=\"selected\"";?>>Grafik</option>
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
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"1") != 0 && strcasecmp($lp,"6") != 0 && strcasecmp($lp,"2") != 0 && strcasecmp($lp,"4") != 0 && strcasecmp($lp,"8") != 0) echo "d-none";?>" id="div-jsup">
                    <label for="dte-smpi">Jenis Supplier</label>
                    <select name="js" id="slct-jsup" class="custom-select">
                        <option value="">Semua Jenis</option>
                        <?php
                            $ljsup = getListJSup($db);

                            for($i = 0; $i < count($ljsup); $i++){
                        ?>
                        <option value="<?php echo $ljsup[$i];?>" <?php if(strcasecmp($ljsup[$i],$jsup) == 0) echo "selected=\"selected\"";?>><?php echo $ljsup[$i];?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-5 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"3") == 0) echo "d-none";?>" id="div-sup">
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
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"5") != 0) echo "d-none";?>" id="div-tgfk">
                    <label for="slct-tgfk">Berdasarkan</label>
                    <select name="tg" id="slct-tgfk" class="custom-select">
                        <option value="1" <?php if(strcasecmp($tgfk,"1") == 0) echo "selected=\"selected\"";?>>Total Berat</option>
                        <option value="2" <?php if(strcasecmp($tgfk,"2") == 0) echo "selected=\"selected\"";?>>Jumlah Ekor</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"5") != 0) echo "d-none";?>" id="div-jgfk">
                    <label for="slct-jgfk">Jenis Grafik</label>
                    <select name="tj" id="slct-jgfk" class="custom-select">
                        <option value="1" <?php if(strcasecmp($jgfk,"1") == 0) echo "selected=\"selected\"";?>>Harian</option>
                        <option value="2" <?php if(strcasecmp($jgfk,"2") == 0) echo "selected=\"selected\"";?>>Bulanan</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"5") != 0) echo "d-none";?>" id="div-dgfk">
                    <label for="slct-dgfk">Daerah (Alamat)</label>
                    <select name="td" id="slct-dgfk" class="custom-select">
                        <option value="">Semua Daerah</option>
                        <?php
                            $ldsup = getAllAddrSup();

                            for($i = 0; $i < count($ldsup); $i++)
                            {
                                if(strcasecmp($ldsup[$i][0],"") == 0)
                                    continue;
                        ?>
                        <option value="<?php echo $ldsup[$i][0];?>" <?php if(strcasecmp($dgfk,$ldsup[$i][0]) == 0) echo "selected=\"selected\"";?>><?php echo $ldsup[$i][0];?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"5") != 0) echo "d-none";?>" id="div-wgfk">
                    <label for="slct-wgfk">Wilayah</label>
                    <select name="tw" id="slct-wgfk" class="custom-select">
                        <option value="">Semua Wilayah</option>
                        <?php
                            $lwsup = getAllRegSup();

                            for($i = 0; $i < count($lwsup); $i++)
                            {
                                if(strcasecmp($lwsup[$i][0],"") == 0)
                                    continue;
                        ?>
                        <option value="<?php echo $lwsup[$i][0];?>" <?php if(strcasecmp($wgfk,$lwsup[$i][0]) == 0) echo "selected=\"selected\"";?>><?php echo $lwsup[$i][0];?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"2") != 0) echo "d-none";?>" id="div-scut">
                    <label for="slct-scut">Status Cutting</label>
                    <select name="sc" id="slct-scut" class="custom-select">
                        <option value="">Semua</option>
                        <option value="S" <?php if(strcasecmp($scut,"S") == 0) echo "selected=\"selected\"";?>>Sudah Potong</option>
                        <option value="B" <?php if(strcasecmp($scut,"B") == 0) echo "selected=\"selected\"";?>>Belum Potong</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <?php
                            if(strcasecmp($lp,"5") != 0)
                            {
                        ?>
                        <button class="m-1 btn btn-light border border-success" id="btn-trm-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>
                        <?php
                            }

                            if(cekAksUser(substr($duser[7], 86, 1)))
                            {
                        ?>
                        <button class="m-1 btn btn-light border border-info <?php if(strcasecmp($lp,"5") == 0) echo "btn-print2"; else echo "btn-print";?>" type="button"><img src="./bin/img/icon/print-icon.png" alt="" width="21"></button>
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 86, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Penerimaan</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <?php
                if(strcasecmp($lp,"1") == 0 || strcasecmp($lp,"2") == 0 || strcasecmp($lp,"4") == 0 || strcasecmp($lp,"8") == 0)
                {
            ?>
            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <?php
                            if(strcasecmp($lp,"4") == 0)
                            {
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle">No</th>
                            <th class="border sticky-top align-middle">Nama Supplier</th>
                            <th class="border sticky-top align-middle text-right">Jlh Masuk Ikan (KG)</th>
                            <th class="border sticky-top align-middle text-right">Sub Total (Rp)</th>
                            <th class="border sticky-top align-middle text-right">Tambahan (Rp)</th>
                            <th class="border sticky-top align-middle text-right">Jlh Simpanan (Rp)</th>
                            <th class="border sticky-top align-middle text-right">Total</th>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"8") == 0){
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle">Periode</th>
                            <th class="border sticky-top align-middle text-right">Jlh Masuk Ikan (Ekor)</th>
                            <th class="border sticky-top align-middle text-right">Jlh Masuk Ikan (KG)</th>
                            <th class="border sticky-top align-middle text-right">Sub Total (Rp)</th>
                            <th class="border sticky-top align-middle text-right">Tambahan (Rp)</th>
                            <th class="border sticky-top align-middle text-right">Jlh Simpanan (Rp)</th>
                            <th class="border sticky-top align-middle text-right">Total</th>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"1") == 0)
                            {
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle no-print"></th>
                            <th class="border sticky-top align-middle">ID</th>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">Supplier</th>
                            <th class="border sticky-top align-middle text-right">BB</th>
                            <th class="border sticky-top align-middle text-right">Poto</th>
                            <th class="border sticky-top align-middle text-right">DLL - CASH</th>
                            <th class="border sticky-top align-middle text-right">DLL - ES</th>
                            <th class="border sticky-top align-middle text-right">DLL - DLL</th>
                            <th class="border sticky-top align-middle">Ket DLL</th>
                            <th class="border sticky-top align-middle text-right">Minus</th>
                            <th class="border sticky-top align-middle text-right">DP</th>
                            <th class="border sticky-top align-middle text-right">Pot Lain</th>
                            <th class="border sticky-top align-middle">Ket Pot Lain</th>
                            <th class="border sticky-top align-middle text-right">Tbh Lain</th>
                            <th class="border sticky-top align-middle">Ket Tbh Lain</th>
                            <th class="border sticky-top align-middle text-right">Minum</th>
                            <th class="border sticky-top align-middle">Ket</th>
                            <th class="border sticky-top align-middle">Ket2</th>
                            <th class="border sticky-top align-middle">Ket3</th>
                            <th class="border sticky-top align-middle">Kota</th>
                            <th class="border sticky-top align-middle text-right">Jlh Terima (KG)</th>
                            <th class="border sticky-top align-middle text-right">Jlh Cut (KG)</th>
                            <th class="border sticky-top align-middle text-right">Jlh Beku (KG)</th>
                            <th class="border sticky-top align-middle text-right">Jlh Ekor</th>
                            <th class="border sticky-top align-middle text-right">Total</th>
                            <th class="border sticky-top align-middle text-right">Simpanan</th>
                            <th class="border sticky-top align-middle">Status</th>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0)
                            {
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle">ID</th>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">Supplier</th>
                            <th class="border sticky-top align-middle text-right">BB</th>
                            <th class="border sticky-top align-middle text-right">Poto</th>
                            <th class="border sticky-top align-middle text-right">DLL - CASH</th>
                            <th class="border sticky-top align-middle text-right">DLL - ES</th>
                            <th class="border sticky-top align-middle text-right">DLL - DLL</th>
                            <th class="border sticky-top align-middle">Ket DLL</th>
                            <th class="border sticky-top align-middle text-right">Minus</th>
                            <th class="border sticky-top align-middle text-right">DP</th>
                            <th class="border sticky-top align-middle text-right">Pot Lain</th>
                            <th class="border sticky-top align-middle">Ket Pot Lain</th>
                            <th class="border sticky-top align-middle text-right">Tbh Lain</th>
                            <th class="border sticky-top align-middle">Ket Tbh Lain</th>
                            <th class="border sticky-top align-middle text-right">Minum</th>
                            <th class="border sticky-top align-middle">Ket</th>
                            <th class="border sticky-top align-middle">Ket2</th>
                            <th class="border sticky-top align-middle">Ket3</th>
                            <th class="border sticky-top align-middle">Kota</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle">Satuan</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle text-right">Harga</th>
                            <th class="border sticky-top align-middle text-right">Total</th>
                            <th class="border sticky-top align-middle text-right">Cut (KG)</th>
                            <th class="border sticky-top align-middle text-right">Beku (KG)</th>
                            <th class="border sticky-top align-middle text-right">Cut (Ekor)</th>
                            <th class="border sticky-top align-middle text-right">No Sampel Cut</th>
                            <th class="border sticky-top align-middle text-right">Tgl Cut</th>
                        </tr>
                        <?php
                            }
                        ?>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"4") == 0){
                                $lst = getTrmFrmTo4($frm, $to, $sp, $jsup);

                                $n = 1;
                                $sum = array(0, 0, 0, 0);
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    if($lst[$i][1] == 0)
                                        continue;
                        ?>
                        <tr>
                            <td class="border"><?php echo $n;?></td>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][1])) echo number_format($lst[$i][1], 2, '.', ','); else echo number_format($lst[$i][1], 0, '.', ',')?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][2]-$lst[$i][4])) echo number_format($lst[$i][2]-$lst[$i][4], 2, '.', ','); else echo number_format($lst[$i][2]-$lst[$i][4], 0, '.', ',')?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][3])) echo number_format($lst[$i][3], 2, '.', ','); else echo number_format($lst[$i][3], 0, '.', ',')?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][4])) echo number_format($lst[$i][4], 2, '.', ','); else echo number_format($lst[$i][4], 0, '.', ',')?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][2]+$lst[$i][3])) echo number_format($lst[$i][2]+$lst[$i][3], 2, '.', ','); else echo number_format($lst[$i][2]+$lst[$i][3], 0, '.', ',')?></td>
                        </tr>
                        <?php
                                    $sum[0] += $lst[$i][1];
                                    $sum[1] += $lst[$i][2]-$lst[$i][4];
                                    $sum[2] += $lst[$i][3];
                                    $sum[3] += $lst[$i][4];
                                    $sum[4] += $lst[$i][2]+$lst[$i][3];
                                    $n++;
                                }
                            }
                            else if(strcasecmp($lp,"8") == 0){
                                $lst = getTrmFrmToPrd($frm, $to, $sp, $jsup, $db);

                                for($i = 0; $i < count($lst); $i++){
                                    $ttl = $lst[$i][3]+$lst[$i][4]+$lst[$i][5];
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][1])) echo number_format($lst[$i][1], 2, '.', ','); else echo number_format($lst[$i][1], 0, '.', ',')?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][2])) echo number_format($lst[$i][2], 2, '.', ','); else echo number_format($lst[$i][2], 0, '.', ',')?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][3])) echo number_format($lst[$i][3], 2, '.', ','); else echo number_format($lst[$i][3], 0, '.', ',')?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][4])) echo number_format($lst[$i][4], 2, '.', ','); else echo number_format($lst[$i][4], 0, '.', ',')?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][5])) echo number_format($lst[$i][5], 2, '.', ','); else echo number_format($lst[$i][5], 0, '.', ',')?></td>
                            <td class="border text-right"><?php if(isDecimal($ttl)) echo number_format($ttl, 2, '.', ','); else echo number_format($ttl, 0, '.', ',')?></td>
                        </tr>
                        <?php
                                    $sum[0] += $lst[$i][1];
                                    $sum[1] += $lst[$i][2];
                                    $sum[2] += $lst[$i][3];
                                    $sum[3] += $lst[$i][4];
                                    $sum[4] += $lst[$i][5];
                                    $sum[5] += $ttl;
                                }
                            }
                            else if(strcasecmp($lp,"1") == 0){
                                $lst = getTrmFrmTo($frm, $to, $sp, $jsup);
                                $sum = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                $tmp = "";
                                for($i = 0; $i < count($lst); $i++){
                        ?>
                        <tr>
                            <?php
                                    $kdll = $lst[$i][16];
                                    $dp = $lst[$i][17];
                                    $pdll = $lst[$i][25];
                                    $tdll = $lst[$i][26];
                                    $mnm = $lst[$i][27];
                                    $min = $lst[$i][28];
                            ?>
                            <td class="border no-print"><button class="btn btn-sm border boder-info" onclick="viewTrm('<?php echo UE64($lst[$i][0]);?>')"><img src="./bin/img/icon/view-list-icon.png" alt="" width="18"></button></td>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo date('Y-m-d', strtotime($lst[$i][1]));?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][3])) echo number_format($lst[$i][3], 2, '.', ','); else echo number_format($lst[$i][3], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][4])) echo number_format($lst[$i][4], 2, '.', ','); else echo number_format($lst[$i][4], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][29])) echo number_format($lst[$i][29], 2, '.', ','); else echo number_format($lst[$i][29], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][30])) echo number_format($lst[$i][30], 2, '.', ','); else echo number_format($lst[$i][30], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][31])) echo number_format($lst[$i][31], 2, '.', ','); else echo number_format($lst[$i][31], 0, '.', ',');?></td>
                            <td class="border">
                                <ul class="m-0 small pl-4">
                                    <?php
                                        $ldll = getTrmDllDll($lst[$i][0], $db);
                                        for($j = 0; $j < count($ldll); $j++){
                                    ?>
                                    <li><?php echo $ldll[$j][2]." ("; if(isDecimal($ldll[$j][3])) echo number_format($ldll[$j][3],2,'.',','); else echo number_format($ldll[$j][3],0,'.',','); echo ")";?></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td class="border text-right"><?php if(isDecimal($min)) echo number_format($min, 2, '.', ','); else echo number_format($min, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($dp)) echo number_format($dp, 2, '.', ','); else echo number_format($dp, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($pdll)) echo number_format($pdll, 2, '.', ','); else echo number_format($pdll, 0, '.', ',');?></td>
                            <td class="border">
                                <ul class="m-0 small pl-4">
                                    <?php
                                        $lpdll = getTrmPDll2($lst[$i][0], $db);
                                        for($j = 0; $j < count($lpdll); $j++){
                                    ?>
                                    <li><?php echo $lpdll[$j][2]." ("; if(isDecimal($lpdll[$j][3])) echo number_format($lpdll[$j][3],2,'.',','); else echo number_format($lpdll[$j][3],0,'.',','); echo ")";?></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td class="border text-right"><?php if(isDecimal($tdll)) echo number_format($tdll, 2, '.', ','); else echo number_format($tdll, 0, '.', ',');?></td>
                            <td class="border">
                                <ul class="m-0 small pl-4">
                                    <?php
                                        $ltdll = getTrmTDll2($lst[$i][0], $db);
                                        for($j = 0; $j < count($ltdll); $j++){
                                    ?>
                                    <li><?php echo $ltdll[$j][2]." ("; if(isDecimal($ltdll[$j][3])) echo number_format($ltdll[$j][3],2,'.',','); else echo number_format($ltdll[$j][3],0,'.',','); echo ")";?></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td class="border text-right"><?php if(isDecimal($mnm)) echo number_format($mnm, 2, '.', ','); else echo number_format($mnm, 0, '.', ',');?></td>
                            <td class="border"><?php echo $lst[$i][5];?></td>
                            <td class="border"><?php echo $lst[$i][6];?></td>
                            <td class="border"><?php echo $lst[$i][7];?></td>
                            <td class="border"><?php if(strcasecmp($lp,"1") == 0) echo $lst[$i][14]; else echo $lst[$i][17];?></td>
                            <?php
                                $sum[0] += $lst[$i][3];
                                $sum[1] += $lst[$i][4];
                                $sum[4] += 0;
                                $sum[5] += $dp;
                                $sum[10] += $pdll;
                                $sum[11] += $tdll;
                                $sum[12] += $min;
                                $sum[13] += $mnm;
                                $sum[14] += $lst[$i][29];
                                $sum[15] += $lst[$i][30];
                                $sum[16] += $lst[$i][31];
                                
                                $stl = "text-danger";
                                $text = "Pending";

                                if(number_format($lst[$i][22]+$lst[$i][23],2,'.','') == number_format($lst[$i][32],2,'.','')){
                                    $stl = "text-success";
                                    $text = "Selesai";
                                }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][10])) echo number_format($lst[$i][10], 2, '.', ','); else echo number_format($lst[$i][10], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][11])) echo number_format($lst[$i][11], 2, '.', ','); else echo number_format($lst[$i][11], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][23])) echo number_format($lst[$i][23], 2, '.', ','); else echo number_format($lst[$i][23], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][20])) echo number_format($lst[$i][20], 2, '.', ','); else echo number_format($lst[$i][20], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][18])) echo number_format($lst[$i][18], 2, '.', ','); else echo number_format($lst[$i][18], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][19])) echo number_format($lst[$i][19], 2, '.', ','); else echo number_format($lst[$i][19], 0, '.', ',');?></td>
                            <td class="border <?php echo $stl;?>"><?php echo $text;?></td>
                            <?php
                                $sum[2] += $lst[$i][10];
                                $sum[3] += $lst[$i][11];
                                $sum[6] += $lst[$i][18];
                                $sum[7] += $lst[$i][19];
                                $sum[8] += $lst[$i][20];
                                $sum[9] += $lst[$i][23];

                                $tmp = $lst[$i][0];
                            ?>
                        </tr>
                        <?php
                                }
                            }
                            else if(strcasecmp($lp,"2") == 0){
                                $lst = getTrmFrmTo2($frm, $to, $sp, $scut, $jsup);
                                $sum = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                $tmp = "";
                                for($i = 0; $i < count($lst); $i++){
                        ?>
                        <tr>
                            <?php
                                    if(strcasecmp($tmp, $lst[$i][0]) != 0){
                                        $vdll = 0;
                                        $kdll = $lst[$i][19];
                                        $dp = $lst[$i][20];
                                        $pdll = $lst[$i][23];
                                        $tdll = $lst[$i][24];
                                        $mnm = $lst[$i][25];
                                        $min = $lst[$i][26];
                            ?>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo date('Y-m-d', strtotime($lst[$i][1]));?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][3])) echo number_format($lst[$i][3], 2, '.', ','); else echo number_format($lst[$i][3], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][4])) echo number_format($lst[$i][4], 2, '.', ','); else echo number_format($lst[$i][4], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][28])) echo number_format($lst[$i][28], 2, '.', ','); else echo number_format($lst[$i][28], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][29])) echo number_format($lst[$i][29], 2, '.', ','); else echo number_format($lst[$i][29], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][30])) echo number_format($lst[$i][30], 2, '.', ','); else echo number_format($lst[$i][30], 0, '.', ',');?></td>
                            <td class="border">
                                <ul class="m-0 small pl-4">
                                    <?php
                                        $ldll = getTrmDllDll($lst[$i][0], $db);
                                        for($j = 0; $j < count($ldll); $j++){
                                    ?>
                                    <li><?php echo $ldll[$j][2]." ("; if(isDecimal($ldll[$j][3])) echo number_format($ldll[$j][3],2,'.',','); else echo number_format($ldll[$j][3],0,'.',','); echo ")";?></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td class="border text-right"><?php if(isDecimal($min)) echo number_format($min, 2, '.', ','); else echo number_format($min, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($dp)) echo number_format($dp, 2, '.', ','); else echo number_format($dp, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($pdll)) echo number_format($pdll, 2, '.', ','); else echo number_format($pdll, 0, '.', ',');?></td>
                            <td class="border">
                                <ul class="m-0 small pl-4">
                                    <?php
                                        $lpdll = getTrmPDll2($lst[$i][0], $db);
                                        for($j = 0; $j < count($lpdll); $j++){
                                    ?>
                                    <li><?php echo $lpdll[$j][2]." ("; if(isDecimal($lpdll[$j][3])) echo number_format($lpdll[$j][3],2,'.',','); else echo number_format($lpdll[$j][3],0,'.',','); echo ")";?></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td class="border text-right"><?php if(isDecimal($tdll)) echo number_format($tdll, 2, '.', ','); else echo number_format($tdll, 0, '.', ',');?></td>
                            <td class="border">
                                <ul class="m-0 small pl-4">
                                    <?php
                                        $ltdll = getTrmTDll2($lst[$i][0], $db);
                                        for($j = 0; $j < count($ltdll); $j++){
                                    ?>
                                    <li><?php echo $ltdll[$j][2]." ("; if(isDecimal($ltdll[$j][3])) echo number_format($ltdll[$j][3],2,'.',','); else echo number_format($ltdll[$j][3],0,'.',','); echo ")";?></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td class="border text-right"><?php if(isDecimal($mnm)) echo number_format($mnm, 2, '.', ','); else echo number_format($mnm, 0, '.', ',');?></td>
                            <td class="border"><?php echo $lst[$i][5];?></td>
                            <td class="border"><?php echo $lst[$i][6];?></td>
                            <td class="border"><?php echo $lst[$i][7];?></td>
                            <td class="border"><?php if(strcasecmp($lp,"1") == 0) echo $lst[$i][14]; else echo $lst[$i][17];?></td>
                            <?php
                                        $sum[0] += $lst[$i][3];
                                        $sum[1] += $lst[$i][4];
                                        $sum[4] += $vdll;
                                        $sum[5] += $dp;
                                        $sum[10] += $pdll;
                                        $sum[11] += $tdll;
                                        $sum[12] += $min;
                                        $sum[13] += $mnm;
                                        $sum[14] += $lst[$i][28];
                                        $sum[15] += $lst[$i][29];
                                        $sum[16] += $lst[$i][30];
                                    }
                                    else
                                    {
                            ?>
                            <td class="border" colspan="20"></td>
                            <?php
                                    }
                                    
                                    $sttl = $lst[$i][15] * $lst[$i][21];

                                    $pro = $lst[$i][11]." / ".$lst[$i][12];

                                    if(strcasecmp($lst[$i][13],"") != 0){
                                        $pro .= " / ".$lst[$i][13];
                                    }

                                    if(strcasecmp($lst[$i][14],"") != 0){
                                        $pro .= " / ".$lst[$i][14];
                                    }
                            ?>
                            <td class="border"><?php echo $pro;?></td>
                            <td class="border"><?php echo $lst[$i][32];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][15])) echo number_format($lst[$i][15], 2, '.', ','); else echo number_format($lst[$i][15], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][21])) echo number_format($lst[$i][21], 2, '.', ','); else echo number_format($lst[$i][21], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($sttl)) echo number_format($sttl, 2, '.', ','); else echo number_format($sttl, 0, '.', ',');?></td>
                            <td class="border text-right <?php if($lst[$i][16] == 0 && $lst[$i][22] == 0 && strcasecmp($lst[$i][31],"Y") == 0) echo "text-danger";?>"><?php if($lst[$i][16] != 0) {if(isDecimal($lst[$i][16])) echo number_format($lst[$i][16], 2, '.', ','); else echo number_format($lst[$i][16], 0, '.', ','); } else if($lst[$i][16] == 0 && $lst[$i][22] == 0 && strcasecmp($lst[$i][31],"Y") == 0) echo "Pending"; else if(($lst[$i][16] == 0 && $lst[$i][22] != 0) || strcasecmp($lst[$i][31],"N") == 0) echo "-";?></td>
                            <td class="border text-right <?php if($lst[$i][16] == 0 && $lst[$i][22] == 0 && strcasecmp($lst[$i][31],"Y") == 0) echo "text-danger";?>"><?php if($lst[$i][22] != 0) {if(isDecimal($lst[$i][22])) echo number_format($lst[$i][22], 2, '.', ','); else echo number_format($lst[$i][22], 0, '.', ','); } else if($lst[$i][16] == 0 && $lst[$i][22] == 0 && strcasecmp($lst[$i][31],"Y") == 0) echo "Pending"; else if(($lst[$i][16] != 0 && $lst[$i][22] == 0) || strcasecmp($lst[$i][31],"N") == 0) echo "-";?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][27])) echo number_format($lst[$i][27], 2, '.', ','); else echo number_format($lst[$i][27], 0, '.', ',');?></td>
                            <td class="border"><?php echo $lst[$i][33];?></td>
                            <td class="border"><?php echo date('Y-m-d', strtotime($lst[$i][34]));?></td>
                            <?php
                                    $sum[2] += $lst[$i][15];
                                    $sum[6] += $sttl;
                                    $sum[7] += $lst[$i][16];
                                    $sum[8] += $lst[$i][22];

                                    $tmp = $lst[$i][0];
                            ?>
                        </tr>
                        <?php
                                }
                            }
                            
                            if(strcasecmp($lp,"4") == 0){
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="2">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[3])) echo number_format($sum[3], 2, '.', ','); else echo number_format($sum[3], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[4])) echo number_format($sum[4], 2, '.', ','); else echo number_format($sum[4], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"8") == 0){
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" >Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[3])) echo number_format($sum[3], 2, '.', ','); else echo number_format($sum[3], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[4])) echo number_format($sum[4], 2, '.', ','); else echo number_format($sum[4], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[5])) echo number_format($sum[5], 2, '.', ','); else echo number_format($sum[5], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"1") == 0){
                        ?>
                        <tr>
                            <td class="no-print"></td>
                            <td class="border font-weight-bold text-right" colspan="3">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[14])) echo number_format($sum[14], 2, '.', ','); else echo number_format($sum[14], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[15])) echo number_format($sum[15], 2, '.', ','); else echo number_format($sum[15], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[16])) echo number_format($sum[16], 2, '.', ','); else echo number_format($sum[16], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[12])) echo number_format($sum[12], 2, '.', ','); else echo number_format($sum[12], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[5])) echo number_format($sum[5], 2, '.', ','); else echo number_format($sum[5], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[10])) echo number_format($sum[10], 2, '.', ','); else echo number_format($sum[10], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[11])) echo number_format($sum[11], 2, '.', ','); else echo number_format($sum[11], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[13])) echo number_format($sum[13], 2, '.', ','); else echo number_format($sum[13], 0, '.', ',')?></td>
                            <td class="border" colspan="4"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[3])) echo number_format($sum[3], 2, '.', ','); else echo number_format($sum[3], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[9])) echo number_format($sum[9], 2, '.', ','); else echo number_format($sum[9], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[8])) echo number_format($sum[8], 2, '.', ','); else echo number_format($sum[8], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[6])) echo number_format($sum[6], 2, '.', ','); else echo number_format($sum[6], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[7])) echo number_format($sum[7], 2, '.', ','); else echo number_format($sum[7], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0){
                        ?>
                        <tr>
                            <td class=""></td>
                            <td class="border font-weight-bold text-right" colspan="2">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[14])) echo number_format($sum[14], 2, '.', ','); else echo number_format($sum[14], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[15])) echo number_format($sum[15], 2, '.', ','); else echo number_format($sum[15], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[16])) echo number_format($sum[16], 2, '.', ','); else echo number_format($sum[16], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[12])) echo number_format($sum[12], 2, '.', ','); else echo number_format($sum[12], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[5])) echo number_format($sum[5], 2, '.', ','); else echo number_format($sum[5], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[10])) echo number_format($sum[10], 2, '.', ','); else echo number_format($sum[10], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[11])) echo number_format($sum[11], 2, '.', ','); else echo number_format($sum[11], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[13])) echo number_format($sum[13], 2, '.', ','); else echo number_format($sum[13], 0, '.', ',')?></td>
                            <td class="border" colspan="6"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[6])) echo number_format($sum[6], 2, '.', ','); else echo number_format($sum[6], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[7])) echo number_format($sum[7], 2, '.', ','); else echo number_format($sum[7], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[8])) echo number_format($sum[8], 2, '.', ','); else echo number_format($sum[8], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
                }
                else if(strcasecmp($lp,"3") == 0)
                {
                    $lst = getLTrmPNFrmTo($frm, $to);
                    $ltgl = getLTrmTglFrmTo($frm, $to);

                    if(count($lst) == 0)
                    {
            ?>
            <div class="alert alert-danger">Tidak ada penerimaan pada tanggal terpilih...</div>
            <?php
                    }
                    else
                    {
                        for($i = 0; $i < count($lst); $i++)
                        {
                            $lgrade = getLGradePro($lst[$i][0], $frm, $to);
                            $sums = array();

                            if($i != 0)
                            {
            ?>

            <div class="pagebreak"></div>
    
            <hr class="my-5 print-no-border">
            
            <div class="my-2 print-only">
                <h5>Laporan Penerimaan</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>
            <?php
                            }
            ?>

            <h4><?php echo $lst[$i][0];?></h4>
            <table class="table table-sm table-striped mb-5">
                <tbody>
                    <tr>
                        <th class="border bg-dark text-white align-middle" rowspan="2">Tanggal</th>
                        <th class="border bg-dark text-white text-center" colspan="<?php echo count($lgrade);?>">Grade</th>
                        <th class="border bg-dark text-white text-right align-middle" rowspan="2">Total</th>
                    </tr>

                    <tr>
                        <?php
                            for($j = 0; $j < count($lgrade); $j++)
                            {
                                $sums[$j] = 0;
                        ?>
                        <th class="border bg-dark text-white text-center"><?php echo $lgrade[$j][0];?></th>
                        <?php
                            }
                        ?>
                    </tr>

                    <?php
                        for($j = 0; $j < count($ltgl); $j++)
                        {
                            $ssum = 0;
                    ?>
                    <tr>
                        <td class="border"><?php echo date('Y-m-d', strtotime($ltgl[$j][0]));?></td>
                        <?php
                            for($k = 0; $k < count($lgrade); $k++)
                            {
                                $ttl = getSumTrmGradeTgl($lgrade[$k][1], $ltgl[$j][0]);
                                $sums[$k] += $ttl;
                        ?>
                        <td class="border text-right"><?php if(isDecimal($ttl)) echo number_format($ttl,2,'.',','); else echo number_format($ttl,0,'.',',');?></td>
                        <?php
                                $ssum += $ttl;
                            }
                        ?>
                        <td class="border text-right"><?php if(isDecimal($ssum)) echo number_format($ssum,2,'.',','); else echo number_format($ssum,0,'.',',');?></td>
                    </tr>
                    <?php
                        }
                    ?>
                    <tr>
                        <td class="border font-weight-bold">Grand Total</td>
                        <?php
                            $ttl = 0;
                            for($j = 0; $j < count($lgrade); $j++)
                            {
                        ?>
                        <td class="border font-weight-bold text-right"><?php if(isDecimal($sums[$j])) echo number_format($sums[$j],2,'.',','); else echo number_format($sums[$j],0,'.',',');?></td>
                        <?php
                                $ttl += $sums[$j];
                            }
                        ?>
                        <td class="border font-weight-bold text-right"><?php if(isDecimal($ttl)) echo number_format($ttl,2,'.',','); else echo number_format($ttl,0,'.',',');?></td>
                    </tr>
                </tbody>
            </table>
            <?php
                        }
                    }
                }
                else if(strcasecmp($lp,"7") == 0)
                {
                    $fy = date('Y', strtotime($frm));
                    $fm = date('n', strtotime($frm));
                    $ty = date('Y', strtotime($to));
                    $tm = date('n', strtotime($to));

                    for($i = $fy; $i <= $ty; $i++)
                    {
                        $sm = 1;
                        $em = 12;

                        if($i == $fy)
                            $sm = $fm;

                        if($i == $ty)
                            $em = $tm;

                        for($j = $sm; $j <= $em; $j++)
                        {
                            $tfrm = date('Y-m-d', strtotime($i."-".$j."-01"));
                            $tto = date('Y-m-t', strtotime($i."-".$j."-01"));
                            $lst = getTrmItem4($tfrm, $tto, $sp);
                            $sums = array(0, 0);

                            if($j != $fm)
                            {
            ?>

            <div class="pagebreak"></div>

            <hr class="my-5 print-no-border">
            
            <div class="my-2 print-only">
                <h5>Laporan Penerimaan</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>
            <?php
                            }
            ?>

            <h4>Periode : <?php echo date('M Y', strtotime($tfrm));?></h4>
            <table class="table table-sm table-striped mb-5">
                <tbody>
                    <tr>
                        <th class="border bg-dark text-white align-middle">Grade</th>
                        <th class="border bg-dark text-white align-midde">Produk</th>
                        <th class="border bg-dark text-white align-middle">Satuan</th>
                        <th class="border bg-dark text-white text-right align-middle">Jlh Ekor</th>
                        <th class="border bg-dark text-white text-right align-middle">Jlh Berat (KG)</th>
                    </tr>

                    <?php
                            for($k = 0; $k < count($lst); $k++)
                            {
                    ?>
                    <tr>
                        <td class="border"><?php echo $lst[$k][2];?></td>
                        <td class="border"><?php echo $lst[$k][1];?></td>
                        <td class="border"><?php echo $lst[$k][3];?></td>
                        <td class="border text-right"><?php if(isDecimal($lst[$k][4])) echo number_format($lst[$k][4],2,'.',','); else echo number_format($lst[$k][4],0,'.',',');?></td>
                        <td class="border text-right"><?php if(isDecimal($lst[$k][5])) echo number_format($lst[$k][5],2,'.',','); else echo number_format($lst[$k][5],0,'.',',');?></td>
                    </tr>
                    <?php
                                $sums[0] += $lst[$k][4];
                                $sums[1] += $lst[$k][5];
                            }
                    ?>
                    <tr>
                        <td class="border font-weight-bold" colspan="3">Grand Total</td>
                        <td class="border font-weight-bold text-right"><?php if(isDecimal($sums[0])) echo number_format($sums[0],2,'.',','); else echo number_format($sums[0],0,'.',',');?></td>
                        <td class="border font-weight-bold text-right"><?php if(isDecimal($sums[1])) echo number_format($sums[1],2,'.',','); else echo number_format($sums[1],0,'.',',');?></td>
                    </tr>
                </tbody>
            </table>
            <?php
                        }
                    }
                }
                else if(strcasecmp($lp,"5") == 0)
                {
                    //$frm = date('Y-m-d', strtotime("-1month", strtotime(date('Y-m-d'))));
                    //$to = date('Y-m-d');
                    $lgrade = getTrmGrade($frm, $to, $dgfk, $wgfk);
                    $datas = getTrmFrmTo7($frm, $to, $sp, $tgfk, $jgfk, $dgfk, $wgfk);
                    $adatas = getTrmFrmTo7($frm, $to, "", $tgfk, $jgfk, $dgfk, $wgfk);
                    $data = $datas[0];
                    $adata = $adatas[0];
                    $date = $datas[1];
                    $ldate = $datas[2];
                    $arr = array();
                    for($i = 0; $i < count($lgrade); $i++)
                        $arr[count($arr)] = getTrmFrmTo8($ldate, $sp, $tgfk, $lgrade[$i][0], $jgfk, $dgfk, $wgfk);
            ?>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-2">
                <div class="">
                    <div class="col-12"><h4 class="mb-0">Grafik Keseluruhan</h4></div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-8 mt-2 mb-3 pw-100">
                        <canvas id="lp-trm-chart" class="w-100 h-100"></canvas>
                    </div>
                    <div class="pagebreak"></div>

                    <div class="col-12 mt-3"><hr class="print-no-border"><h4 class="mb-0">Grafik Seluruh Grade</h4></div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-8 mt-2 mb-3 pw-100">
                        <canvas id="lp-gtrm-chart" class="w-100 h-100"></canvas>
                    </div>
                    <div class="pagebreak"></div>

                    <div class="col-12 mt-3"><hr class="print-no-border"><h4 class="mb-0">Grafik Per Grade</h4></div>
                <?php
                    for($i = 0; $i < count($lgrade); $i++)
                    {
                ?>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-8 mt-2 mb-3 pw-100">
                        <canvas id="lp-trm-chart-<?php echo $i;?>" class="w-100 h-100"></canvas>
                        <?php
                            if($i != count($lgrade) - 1)
                            {
                        ?>
                        <div class="pagebreak"></div>
                        <?php
                            }
                        ?>
                    </div>
                <?php
                    }
                ?>
                </div>

                <div class="scripts">
                    <script type="text/javascript">
                        $(document).ready(function(){
                            var lgrade = (<?php echo json_encode($lgrade);?>), lval = (<?php echo json_encode($arr);?>), lchart = [], dataset = [], data = (<?php echo json_encode($data);?>), adata = (<?php echo json_encode($adata);?>), w = $(".pw-100").css("width"), mw = $(".pw-100").css("max-width"), f = $(".pw-100").css("flex"), pos = $(".pw-100").css("position"), h = $(".pw-100").css("height"), sp = "<?php echo $sp;?>", nsp = "<?php echo $nsp;?>", tchart = [];
                            
                            if(sp === ""){
                                tchart = [{ 
                                    label: "Keseluruhan", 
                                    data: data, 
                                    backgroundColor: rnd_rgb(1), 
                                    borderColor: rnd_rgb(0.2), 
                                    borderWidth: 1, 
                                }];
                            }
                            else{
                                tchart = [
                                    { 
                                        label: "Keseluruhan", 
                                        data: adata, 
                                        backgroundColor: rnd_rgb(1), 
                                        borderColor: rnd_rgb(0.2), 
                                        borderWidth: 1, 
                                    },
                                    { 
                                        label: nsp, 
                                        data: data, 
                                        backgroundColor: rnd_rgb(1), 
                                        borderColor: rnd_rgb(0.2), 
                                        borderWidth: 1, 
                                    }
                                ]
                            }
                            
                            for(var i = 0; i < lgrade.length; i++)
                            {
                                lchart[i] = new Chart(document.getElementById("lp-trm-chart-"+i), {
                                    type: 'bar',
                                    data: {
                                        labels: (<?php echo json_encode($date);?>),
                                        datasets: [{ 
                                            label: lgrade[i][1], 
                                            data: lval[i], 
                                            backgroundColor: rnd_rgb(1), 
                                            borderColor: rnd_rgb(0.2), 
                                            borderWidth: 1, 
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        }
                                    }
                                });

                                dataset.push({ label: lgrade[i][1], data: lval[i], backgroundColor: rnd_rgb(1), borderColor: rnd_rgb(0.2), borderWidth: 1, })
                            }

                            chart = new Chart(document.getElementById("lp-trm-chart"), {
                                type: 'bar',
                                data: {
                                    labels: (<?php echo json_encode($date);?>),
                                    datasets: tchart,
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                            
                            chart2 = new Chart(document.getElementById("lp-gtrm-chart"), {
                                type: 'bar',
                                data: {
                                    labels: (<?php echo json_encode($date);?>),
                                    datasets: dataset
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });

                            $(".btn-print2").click(() => {
                                $(".pw-100").css("width", "100%");
                                $(".pw-100").css("max-width", "100%");
                                $(".pw-100").css("flex", "0 0 100%");

                                chart.resize();
                                chart2.resize();
                                for(var i = 0; i < lgrade.length; i++)
                                    lchart[i].resize();

                                window.print();
                            });

                            window.onafterprint = () => {
                                $(".pw-100").css("width", w);
                                $(".pw-100").css("max-width", mw);
                                $(".pw-100").css("flex", f);
                                $(".pw-100").css("position", pos);
                            }
                        })
                    </script>
                </div>
            </div>
            <?php
                }
                else if(strcasecmp($lp,"6") == 0)
                {
            ?>
            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">Supplier</th>
                            <th class="border sticky-top align-middle text-right">BB</th>
                            <th class="border sticky-top align-middle text-right">Poto</th>
                            <th class="border sticky-top align-middle text-right">DLL</th>
                            <th class="border sticky-top align-middle text-right">Min</th>
                            <th class="border sticky-top align-middle text-right">DP</th>
                            <th class="border sticky-top align-middle text-right">Pot Lain</th>
                            <th class="border sticky-top align-middle text-right">Tbh Lain</th>
                            <th class="border sticky-top align-middle text-right">Minum</th>
                            <th class="border sticky-top align-middle text-right">Jlh Terima (KG)</th>
                            <th class="border sticky-top align-middle text-right">Jlh Cut (KG)</th>
                            <th class="border sticky-top align-middle text-right">Jlh Beku (KG)</th>
                            <th class="border sticky-top align-middle text-right">Jlh Ekor</th>
                            <th class="border sticky-top align-middle text-right">Total</th>
                            <th class="border sticky-top align-middle text-right">Simpanan</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $lst = getTrmFrmTo9($frm, $to, $sp, $jsup);

                            $sum = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                            $tmp = "";
                            for($i = 0; $i < count($lst); $i++)
                            {
                                $vdll = $lst[$i][15];
                                $kdll = $lst[$i][16];
                                $dp = $lst[$i][17];
                                $pdll = $lst[$i][25];
                                $tdll = $lst[$i][26];
                                $mnm = $lst[$i][27];
                                $min = $lst[$i][28];
                        ?>
                        <tr>
                            <td class="border"><?php echo date('M Y', strtotime($lst[$i][1]));?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][3])) echo number_format($lst[$i][3], 2, '.', ','); else echo number_format($lst[$i][3], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][4])) echo number_format($lst[$i][4], 2, '.', ','); else echo number_format($lst[$i][4], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($vdll)) echo number_format($vdll, 2, '.', ','); else echo number_format($vdll, 0, '.', ','); if(strcasecmp($kdll,"") != 0 && $vdll != 0) echo " (".$kdll.")";?></td>
                            <td class="border text-right"><?php if(isDecimal($min)) echo number_format($min, 2, '.', ','); else echo number_format($min, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($dp)) echo number_format($dp, 2, '.', ','); else echo number_format($dp, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($pdll)) echo number_format($pdll, 2, '.', ','); else echo number_format($pdll, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($tdll)) echo number_format($tdll, 2, '.', ','); else echo number_format($tdll, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($mnm)) echo number_format($mnm, 2, '.', ','); else echo number_format($mnm, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][10])) echo number_format($lst[$i][10], 2, '.', ','); else echo number_format($lst[$i][10], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][11])) echo number_format($lst[$i][11], 2, '.', ','); else echo number_format($lst[$i][11], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][23])) echo number_format($lst[$i][23], 2, '.', ','); else echo number_format($lst[$i][23], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][20])) echo number_format($lst[$i][20], 2, '.', ','); else echo number_format($lst[$i][20], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][18])) echo number_format($lst[$i][18], 2, '.', ','); else echo number_format($lst[$i][18], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][19])) echo number_format($lst[$i][19], 2, '.', ','); else echo number_format($lst[$i][19], 0, '.', ',');?></td>
                        </tr>
                        <?php
                                $sum[0] += $lst[$i][3];
                                $sum[1] += $lst[$i][4];
                                $sum[4] += $vdll;
                                $sum[5] += $dp;
                                $sum[10] += $pdll;
                                $sum[11] += $tdll;
                                $sum[12] += $min;
                                $sum[13] += $mnm;
                                $sum[2] += $lst[$i][10];
                                $sum[3] += $lst[$i][11];
                                $sum[6] += $lst[$i][18];
                                $sum[7] += $lst[$i][19];
                                $sum[8] += $lst[$i][20];
                                $sum[9] += $lst[$i][23];
                            }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="2">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[4])) echo number_format($sum[4], 2, '.', ','); else echo number_format($sum[4], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[12])) echo number_format($sum[12], 2, '.', ','); else echo number_format($sum[12], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[5])) echo number_format($sum[5], 2, '.', ','); else echo number_format($sum[5], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[10])) echo number_format($sum[10], 2, '.', ','); else echo number_format($sum[10], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[11])) echo number_format($sum[11], 2, '.', ','); else echo number_format($sum[11], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[13])) echo number_format($sum[13], 2, '.', ','); else echo number_format($sum[13], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[3])) echo number_format($sum[3], 2, '.', ','); else echo number_format($sum[3], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[9])) echo number_format($sum[9], 2, '.', ','); else echo number_format($sum[9], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[8])) echo number_format($sum[8], 2, '.', ','); else echo number_format($sum[8], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[6])) echo number_format($sum[6], 2, '.', ','); else echo number_format($sum[6], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[7])) echo number_format($sum[7], 2, '.', ','); else echo number_format($sum[7], 0, '.', ',')?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
                }
            ?>
        </div>
        <?php
            }
        ?>
    </div>

    <?php
        require("./modals/mdl-ssup.php");
        require("./bin/php/footer.php");

        closeDB($db);
    ?>
</body>

</html>