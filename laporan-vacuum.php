<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Vacuum";

    $lp = "1";
    $jns = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    $type = "";
    $p = "";
    $np = "";
    $p2 = "";
    $np2 = "";
    $jtgl = "1";
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $jns = trim(mysqli_real_escape_string($db, $_GET["j"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        $p = trim(mysqli_real_escape_string($db, $_GET["p"]));
        $np = trim(mysqli_real_escape_string($db, $_GET["np"]));
        $p2 = trim(mysqli_real_escape_string($db, $_GET["p2"]));
        $np2 = trim(mysqli_real_escape_string($db, $_GET["np2"]));
        $jtgl = trim(mysqli_real_escape_string($db, $_GET["jt"]));

        if(strcasecmp($jns,"2") == 0)
            $type = "1";
        else if(strcasecmp($jns,"3") == 0)
            $type = "2";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Vacuum | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 89, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2">
                    <label for="slct-type-vac">Jenis Laporan</label>
                    <select name="l" id="slct-type-vac" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Rekap</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Rincian</option>
                        <option value="3" <?php if(strcasecmp($lp,"3") == 0) echo "selected=\"selected\"";?>>Hasil Per Produk</option>
                        <option value="4" <?php if(strcasecmp($lp,"4") == 0) echo "selected=\"selected\"";?>>Hasil Per Produk - Berdasarkan Golongan</option>
                        <option value="5" <?php if(strcasecmp($lp,"5") == 0) echo "selected=\"selected\"";?>>Rincian Grade Cutting</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2">
                    <label for="slct-jns">Jenis Vacuum</label>
                    <select name="j" id="slct-jns-vac" class="custom-select">
                        <option value="1" <?php if(strcasecmp($jns,"1") == 0) echo "selected=\"selected\"";?>>Semua</option>
                        <option value="2" <?php if(strcasecmp($jns,"2") == 0) echo "selected=\"selected\"";?>>Dari Cutting</option>
                        <option value="3" <?php if(strcasecmp($jns,"3") == 0) echo "selected=\"selected\"";?>>Dari Bahan Sjd</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($lp,"1") != 0 && strcasecmp($lp,"2") != 0 && strcasecmp($lp,"5") != 0 && strcasecmp($jns,"2") != 0) echo "d-none";?>" id="div-jtgl-vac">
                    <label for="slct-jtgl">Jenis Tanggal</label>
                    <select name="jt" id="slct-jtgl" class="custom-select">
                        <option value="1" <?php if(strcasecmp($jtgl,"1") == 0) echo "selected=\"selected\"";?>>Tanggal Vacuum</option>
                        <option value="2" <?php if(strcasecmp($jtgl,"2") == 0) echo "selected=\"selected\"";?>>Tanggal Cutting</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2" id="div-frm">
                    <label for="dte-frm">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dte-frm" name="f" value="<?php echo $frm;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2" id="div-to">
                    <label for="dte-smpi">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="dte-smpi" name="tt" value="<?php echo $to;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-2 my-2 <?php if(strcasecmp($lp,"3") == 0 || strcasecmp($lp,"4") == 0 || strcasecmp($lp,"5") == 0) echo "d-none";?>" id="div-bpro">
                    <label for="txt-nma-pro">Pilih Bahan Sjd</label>
                    <div class="d-none" id="bloodhound">
                        <input class="typeahead form-control" type="text">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set" id="txt-nma-pro3-0" name="np2" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $np2;?>">
                        <input type="text" class="d-none" id="txt-pro3-0" name="p2" value="<?php echo $p2;?>">

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-spro5" type="button" data-value="0"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                        </div>

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-rpro2" type="button" data-value="0"><img src="./bin/img/icon/delete-icon.png" width="20" alt="Reset"></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-2 my-2 <?php if(strcasecmp($lp,"1") == 0 || strcasecmp($lp,"5") == 0) echo "d-none";?>" id="div-hpro">
                    <label for="txt-nma-pro">Pilih Hasil Produk</label>
                    <div class="d-none" id="bloodhound">
                        <input class="typeahead form-control" type="text">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set txt-pro-lap" id="txt-nma-pro3-1" name="np" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $np;?>">
                        <input type="text" class="d-none" id="txt-pro3-1" name="p" value="<?php echo $p;?>">

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
                        <button class="m-1 btn btn-light border border-success" id="btn-vac-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 90, 1)))
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 90, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Vacuum</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <?php
                    if(strcasecmp($lp,"4") == 0){
                ?>
                <div id="tbl-data">
                    <?php
                        $lgol = getVacGolFrmTo($frm, $to, $type, $p, $db);

                        for($i = 0; $i < count($lgol); $i++){
                            $sum = 0;
                            $n = 1;
                    ?>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th class="border-0 text-center h4" colspan="3"><?php echo $lgol[$i][1];?></th>
                            </tr>
                        </thead>
                        <thead class="thead-dark">
                            <th class="border align-middle">No</th>
                            <th class="border align-middle">Produk</th>
                            <th class="border align-middle text-right">Qty (KG)</th>
                        </thead>
                        <tbody>
                            <?php
                                $lst = getVacFrmToGol($frm, $to, $type, $p, $lgol[$i][0], $db);

                                for($j = 0; $j < count($lst); $j++){
                                    $npro = $lst[$j][0]." / ".$lst[$j][1];

                                    if(strcasecmp($lst[$j][2],"") != 0){
                                        $npro .= " / ".$lst[$j][2];
                                    }

                                    if(strcasecmp($lst[$j][3],"") != 0){
                                        $npro .= " / ".$lst[$j][3];
                                    }
                            ?>
                            <tr>
                                <td class="border"><?php echo $n;?></td>
                                <td class="border"><?php echo $npro;?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$j][4])) echo number_format($lst[$j][4],2,'.',','); else echo number_format($lst[$j][4],0,'.',',');?></td>
                            </tr>
                            <?php
                                        $sum += $lst[$j][4];
                                        $n++;
                                    }
                            ?>
                            <tr>
                                <td class="border font-weight-bold text-right" colspan="2">Total</td>
                                <td class="border text-right font-weight-bold"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',')?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                        }
                    ?>
                </div>
                <?php
                    }
                    else if(strcasecmp($lp,"5") == 0){
                        $lvac = getVacGradeFrmTo($frm, $to, $jtgl, $db);
                ?>
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top">Tgl Vacuum</th>
                            <th class="border sticky-top">Tgl Cutting</th>
                            <th class="border sticky-top">Grade</th>
                            <th class="border sticky-top text-right">Berat Bahan baku</th>
                            <th class="border sticky-top text-right">Hasil Berat Cutting</th>
                            <th class="border sticky-top text-right">Persentase Cutting (%)</th>
                            <th class="border sticky-top">Hasil Produk Vacuum</th>
                            <th class="border sticky-top text-right">Hasil Berat Vacuum</th>
                            <th class="border sticky-top text-right">Persentase Vacuum Cutting (%)</th>
                            <th class="border sticky-top text-right">Persentase Vacuum Bahan Baku (%)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $tvdate = "";
                            $tvcdate = "";
                            $tgrade = "";
                            $bb = array(0, 0);
                            for($i = 0; $i < count($lvac); $i++){
                        ?>
                        <tr>
                            <?php
                                if(strcasecmp($lvac[$i][0],$tvdate) != 0 || strcasecmp($lvac[$i][1], $tvcdate) != 0){
                            ?>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lvac[$i][0]));?></td>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lvac[$i][1]));?></td>
                            <?php
                                    $tvdate = $lvac[$i][0];
                                    $tvcdate = $lvac[$i][1];
                                }
                                else{
                            ?>
                            <td class="border"></td>
                            <td class="border"></td>
                            <?php
                                }

                                if(strcasecmp($lvac[$i][2], $tgrade) != 0){
                                    $hcut = getSumCutGradeTgl($lvac[$i][2], $lvac[$i][1], $db);
                                    $bb = $hcut;
                            ?>
                            <td class="border"><?php echo $lvac[$i][3];?></td>
                            <td class="border text-right"><?php echo number_format($hcut[0],2,'.',',');?></td>
                            <td class="border text-right"><?php echo number_format($hcut[1],2,'.',',');?></td>
                            <td class="border text-right"><?php echo $hcut[0] == 0 ? "0" : number_format(($hcut[1]/$hcut[0])*100,2,'.',',');?> %</td>
                            <?php
                                    $tgrade = $lvac[$i][2];
                                }
                                else{
                            ?>
                            <td class="border"></td>
                            <td class="border"></td>
                            <td class="border"></td>
                            <td class="border"></td>
                            <?php
                                }

                                $pro = $lvac[$i][4]." / ".$lvac[$i][5];

                                if(strcasecmp($lvac[$i][6],"") != 0){
                                    $pro .= " / ".$lvac[$i][6];
                                }

                                if(strcasecmp($lvac[$i][7],"") != 0){
                                    $pro .= " / ".$lvac[$i][7];
                                }
                            ?>
                            <td class="border"><?php echo $pro;?></td>
                            <td class="border text-right"><?php echo number_format($lvac[$i][8],2,'.',',');?></td>
                            <td class="border text-right"><?php echo $bb[1] == 0 ? "0" : number_format(($lvac[$i][8]/$bb[1])*100,2,'.',',');?> %</td>
                            <td class="border text-right"><?php echo $bb[0] == 0 ? "0" : number_format(($lvac[$i][8]/$bb[0])*100,2,'.',',');?> %</td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    }
                    else{
                ?>
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <?php
                            if(strcasecmp($lp,"3") == 0){
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle">No</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle text-right">Qty (KG)</th>
                        </tr>
                        <?php
                            }
                            else
                            {
                        ?>
                        <tr>
                            <?php
                                if(strcasecmp($lp,"1") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle"></th>
                            <?php
                                }
                            ?>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">Tgl Cut</th>
                            <th class="border sticky-top align-middle text-right">Tahap</th>
                            <th class="border sticky-top align-middle">Ket</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle">Margin</th>
                            <?php
                                if(strcasecmp($lp,"1") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle text-right">Total Vacuum (KG)</th>
                            <th class="border sticky-top align-middle text-right">(%)</th>
                            <?php
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle text-right">(%)</th>
                            <?php
                                }
                            ?>
                        </tr>
                        <?php
                            }
                        ?>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"2") == 0)
                                $lst = getVacFrmTo2($frm, $to, $type, $p, $p2, $jtgl);
                            else if(strcasecmp($lp,"1") == 0)
                                $lst = getVacFrmTo($frm, $to, $type, $p, $jtgl);
                            else if(strcasecmp($lp,"3") == 0)
                                $lst = getVacFrmTo3($frm, $to, $type, $p);
                                
                            if(strcasecmp($lp,"3") == 0)
                            {
                                $sum = 0;
                                $n = 1;
                                for($i = 0; $i < count($lst); $i++){
                                    $npro = $lst[$i][0]." / ".$lst[$i][1];

                                    if(strcasecmp($lst[$i][2],"") != 0){
                                        $npro .= " / ".$lst[$i][2];
                                    }

                                    if(strcasecmp($lst[$i][3],"") != 0){
                                        $npro .= " / ".$lst[$i][3];
                                    }
                        ?>
                        <tr>
                            <td class="border"><?php echo $n;?></td>
                            <td class="border"><?php echo $npro;?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][4])) echo number_format($lst[$i][4],2,'.',','); else echo number_format($lst[$i][4],0,'.',',');?></td>
                        </tr>
                        <?php
                                    $sum += $lst[$i][4];
                                    $n++;
                                }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="2">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                            else
                            {
                                $sum = array(0, 0);
                                $tmp = "";
                                for($i = 0; $i < count($lst); $i++)
                                {
                        ?>
                        <tr>
                            <?php
                                if((strcasecmp($tmp, $lst[$i][0]) != 0 && strcasecmp($lp,"2") == 0) || strcasecmp($lp,"1") == 0)
                                {
                                    $weight = $lst[$i][7];
                                    $weight2 = 0;

                                    if(strcasecmp($lp,"1") == 0 && strcasecmp($lst[$i][17],"1") == 0){
                                        $weight2 = $lst[$i][23];
                                    }
                                    else if(strcasecmp($lp,"2") == 0 && strcasecmp($lst[$i][21],"1") == 0){
                                        $weight2 = $lst[$i][27];
                                    }

                                    if(strcasecmp($lp,"1") == 0 && strcasecmp($lst[$i][17],"1") == 0 && strcasecmp($lst[$i][16],"0") != 0)
                                    {
                                        if(strcasecmp($lst[$i][16],"1") == 0)
                                            $weight = $lst[$i][7] - $lst[$i][15];
                                        else
                                            $weight = $lst[$i][15];
                                    }
                                    else if(strcasecmp($lp,"2") == 0 && strcasecmp($lst[$i][21],"1") == 0 && strcasecmp($lst[$i][20],"0") != 0)
                                    {
                                        if(strcasecmp($lst[$i][20],"1") == 0)
                                            $weight = $lst[$i][7] - $lst[$i][19];
                                        else
                                            $weight = $lst[$i][19];
                                    }

                                    $tmrgn = "";
                                    if(strcasecmp($lst[$i][9],"1") == 0)
                                        $tmrgn = "<";
                                    else if(strcasecmp($lst[$i][9],"2") == 0)
                                        $tmrgn = ">";
                                    
                                    if(strcasecmp($lp,"1") == 0)
                                    {
                            ?>
                            <td class="border no-print"><button class="btn btn-sm border boder-info" onclick="viewVac('<?php echo UE64($lst[$i][0]);?>')"><img src="./bin/img/icon/view-list-icon.png" alt="" width="18"></button></td>
                            <?php
                                    }
                            ?>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1]));?></td>
                            <td class="border"><?php if(date('Y', strtotime($lst[$i][2])) < 2000) echo ""; else echo date('d/m/Y', strtotime($lst[$i][2]));?></td>
                            <td class="border text-right"><?php if(strcasecmp($lp,"1") == 0) echo number_format($lst[$i][13],0,'.',','); else echo number_format($lst[$i][17],0,'.',',');?></td>
                            <td class="border"><?php if(strcasecmp($lp,"1") == 0) echo $lst[$i][14]; else echo $lst[$i][18];?></td>
                            <td class="border"><ul class="small mb-0"><?php echo $lst[$i][3];?></ul></td>
                            <td class="border text-right"><?php if(isDecimal($weight-$weight2)) echo number_format($weight-$weight2, 2, '.', ','); else echo number_format($weight-$weight2, 0, '.', ',');?></td>
                            <td class="border"><?php echo $tmrgn." ".$lst[$i][8];?></td>
                            <?php
                                    $sum[0] += $weight-$weight2;
                                }
                                else
                                {
                            ?>
                            <td class="border" colspan="7"></td>
                            <?php
                                }

                                if(strcasecmp($lp,"1") == 0)
                                {
                                    if($weight == 0)
                                        $mrgn = 100;
                                    else
                                        $mrgn = ($lst[$i][12]/$weight) * 100;

                                    $fcolor = "";
                                    /*$fcolor = "text-danger";
                                    if((strcasecmp($lst[$i][9],"1") == 0 && $mrgn < $lst[$i][8]) || (strcasecmp($lst[$i][9],"2") == 0 && $mrgn > $lst[$i][9]))
                                        $fcolor = "text-success";*/
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][12])) echo number_format($lst[$i][12], 2, '.', ','); else echo number_format($lst[$i][12], 0, '.', ',');?></td>
                            <td class="border text-right <?php echo $fcolor;?>"><?php if(isDecimal($mrgn)) echo number_format($mrgn, 2, '.', ','); else echo number_format($mrgn, 0, '.', ',');?></td>
                            <?php
                                    $sum[1] += $lst[$i][12];
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                                    if($weight == 0)
                                        $mrgn = 100;
                                    else
                                        $mrgn = ($lst[$i][16]/$weight) * 100;

                                    $fcolor = "";
                                    /*$fcolor = "text-danger";
                                    if((strcasecmp($lst[$i][9],"1") == 0 && $mrgn < $lst[$i][8]) || (strcasecmp($lst[$i][9],"2") == 0 && $mrgn > $lst[$i][8]))
                                        $fcolor = "text-success";*/

                                    $nma = $lst[$i][12]." / ".$lst[$i][13];

                                    if(strcasecmp($lst[$i][14],"") != 0){
                                        $nma .= " / ".$lst[$i][14];
                                    }

                                    if(strcasecmp($lst[$i][15],"") != 0){
                                        $nma .= " / ".$lst[$i][15];
                                    }
                            ?>
                            <td class="border"><?php echo $nma;?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][16])) echo number_format($lst[$i][16], 2, '.', ','); else echo number_format($lst[$i][16], 0, '.', ',');?></td>
                            <td class="border text-right <?php echo $fcolor;?>"><?php if(isDecimal($mrgn)) echo number_format($mrgn, 2, '.', ','); else echo number_format($mrgn, 0, '.', ',');?></td>
                            <?php
                                    $sum[1] += $lst[$i][16];
                                }

                                $tmp = $lst[$i][0];
                            ?>
                        </tr>
                        <?php
                                }
                            }
                            
                            if(strcasecmp($lp,"1") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="6">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border font-weight-bold text-right"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="5">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border font-weight-bold text-right" colspan="2"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    }
                ?>
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