<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Cutting";

    $sett = getSett();
    $lp = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Cutting | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 87, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 my-2">
                    <label for="slct-jns">Jenis Laporan</label>
                    <select name="l" id="slct-jns" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Rekap</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Rincian</option>
                        <option value="3" <?php if(strcasecmp($lp,"3") == 0) echo "selected=\"selected\"";?>>Hasil Vaccum Per Grade</option>
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
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-cut-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 88, 1)))
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 88, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Cutting</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <?php
                    if(strcasecmp($lp,"3") == 0){
                        $lcut = getCutFrmTo3($frm, $to, $db);
                ?>
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top">Tgl</th>
                            <th class="border sticky-top">Grade</th>
                            <th class="border sticky-top text-right">Bahan Baku</th>
                            <th class="border sticky-top text-right">Hasil Cutting</th>
                            <th class="border sticky-top text-right">Persentase Cutting</th>
                            <th class="border sticky-top">Produk</th>
                            <th class="border sticky-top text-right">Hasil Vacuum</th>
                            <th class="border sticky-top text-right">Persentase Vacuum</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $tmp = "";
                            for($i = 0; $i < count($lcut); $i++){
                                $lvac = getVacItemCut($lcut[$i][0], $lcut[$i][1], $db);
                                
                                if(count($lvac) == 0){
                                    continue;
                                }
                        ?>
                        <tr>
                            <?php
                                if(strcasecmp($tmp, $lcut[$i][0]) != 0){
                            ?>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lcut[$i][0]));?></td>
                            <?php
                                    $tmp = $lcut[$i][0];
                                }
                                else{
                            ?>
                            <td class="border"></td>
                            <?php
                                }
                            ?>
                            <td class="border"><?php echo $lcut[$i][2];?></td>
                            <td class="border text-right"><?php echo number_format($lcut[$i][3],2,'.',',');?></td>
                            <td class="border text-right"><?php echo number_format($lcut[$i][4],2,'.',',');?></td>
                            <td class="border text-right"><?php echo $lcut[$i][4] == 0 ? 0 : number_format($lcut[$i][4]/$lcut[$i][3] * 100,2,'.',',');?> %</td>
                            <?php
                                for($j = 0; $j < count($lvac); $j++){
                                    $pro = $lvac[$j][0]." / ".$lvac[$j][1];

                                    if(strcasecmp($lvac[$j][2],"") != 0){
                                        $pro .= " / ".$lvac[$j][2];
                                    }

                                    if(strcasecmp($lvac[$j][3],"") != 0){
                                        $pro .= " / ".$lvac[$j][3];
                                    }

                                    if($j > 0){
                                        echo    "</tr>".
                                                "<tr>".
                                                    "<td class=\"border\"></td>".
                                                    "<td class=\"border\"></td>".
                                                    "<td class=\"border\"></td>".
                                                    "<td class=\"border\"></td>".
                                                    "<td class=\"border\"></td>";
                                    }
                            ?>
                            <td class="border"><?php echo $pro;?></td>
                            <td class="border text-right"><?php echo number_format($lvac[$j][4],2,'.',',');?></td>
                            <td class="border text-right"><?php echo $lcut[$i][4] == 0 ? 0 : number_format($lvac[$j][4]/$lcut[$i][4] * 100,2,'.',',');?> %</td>
                            <?php
                                }
                            ?>
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
                            if(strcasecmp($lp,"1") == 0)
                            {
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle" rowspan="2"></th>
                            <th class="border sticky-top align-middle" rowspan="2">Tgl</th>
                            <th class="border sticky-top align-middle" rowspan="2">Margin</th>
                            <th class="border sticky-top align-middle text-right small" <?php if (cekAksUser(substr($duser[7], 200, 1))) echo "colspan=\"2\""; else echo "rowspan=\"2\"";?>>Total Bahan Baku</th>
                            <th class="border sticky-top align-middle text-right small" <?php if (cekAksUser(substr($duser[7], 200, 1))) echo "colspan=\"3\""; else echo "colspan=\"2\"";?>>Total Cut</th>
                            <th class="border sticky-top align-middle text-right small" <?php if (cekAksUser(substr($duser[7], 200, 1))) echo "colspan=\"3\""; else echo "colspan=\"2\"";?>>Total Tetelan, dll</th>
                            <th class="border sticky-top align-middle text-right small" <?php if (cekAksUser(substr($duser[7], 200, 1))) echo "colspan=\"3\""; else echo "colspan=\"2\"";?>>Total Tulang, dll</th>
                            <th class="border sticky-top align-middle text-right small" colspan="2">Susut Potong</th>
                            <th class="border sticky-top align-middle text-right small" <?php if (cekAksUser(substr($duser[7], 200, 1))) echo "colspan=\"3\""; else echo "colspan=\"2\"";?>>Total Vac</th>
                            <th class="border sticky-top align-middle text-right small" <?php if (cekAksUser(substr($duser[7], 200, 1))) echo "colspan=\"3\""; else echo "colspan=\"2\"";?>>Susut Vac</th>
                        </tr>
                        <tr>
                            <th class="border sticky-top text-right top-30px">KG</th>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <th class="border sticky-top text-right top-30px">Rp</th>
                            <?php
                                }
                            ?>
                            <th class="border sticky-top text-right top-30px">KG</th>
                            <th class="border sticky-top text-right top-30px">%</th>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <th class="border sticky-top text-right top-30px">Rp</th>
                            <?php
                                }
                            ?>
                            <th class="border sticky-top text-right top-30px">KG</th>
                            <th class="border sticky-top text-right top-30px">%</th>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <th class="border sticky-top text-right top-30px">Rp</th>
                            <?php
                                }
                            ?>
                            <th class="border sticky-top text-right top-30px">KG</th>
                            <th class="border sticky-top text-right top-30px">%</th>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <th class="border sticky-top text-right top-30px">Rp</th>
                            <?php
                                }
                            ?>
                            <th class="border sticky-top text-right top-30px">KG</th>
                            <th class="border sticky-top text-right top-30px">%</th>
                            <th class="border sticky-top text-right top-30px">KG</th>
                            <th class="border sticky-top text-right top-30px">%</th>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <th class="border sticky-top text-right top-30px">Rp</th>
                            <?php
                                }
                            ?>
                            <th class="border sticky-top text-right top-30px">KG</th>
                            <th class="border sticky-top text-right top-30px">%</th>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <th class="border sticky-top text-right top-30px">Rp</th>
                            <?php
                                }
                            ?>
                        </tr>
                            <?php
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                            ?>
                        <tr>
                            <th class="border sticky-top align-middle">Tgl</th>
                            <th class="border sticky-top align-middle">Margin</th>
                            <th class="border sticky-top align-middle">Produk</th>
                            <th class="border sticky-top align-middle">Grade</th>
                            <th class="border sticky-top align-middle">Oz</th>
                            <th class="border sticky-top align-middle">Cut Style</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle text-right">Cut1 (KG)</th>
                            <th class="border sticky-top align-middle text-right">Cut2 (KG)</th>
                            <th class="border sticky-top align-middle text-right">Cut3 (KG)</th>
                            <th class="border sticky-top align-middle text-right">Cut4 (KG)</th>
                            <th class="border sticky-top align-middle text-right">Cut5 (KG)</th>
                            <th class="border sticky-top align-middle text-right">Cut6 (KG)</th>
                            <th class="border sticky-top align-middle text-right">Total Cut (KG)</th>
                            <th class="border sticky-top align-middle text-right">(%)</th>
                        </tr>
                            <?php
                                }
                            ?>
                    </thead>

                    <tbody>
                        <?php
                            if(strcasecmp($lp,"2") == 0)
                                $lst = getCutFrmTo2($frm, $to);
                            else
                                $lst = getCutFrmTo($frm, $to);

                            $sum = array(0, 0, 0, 0, 0, 0, 0, 0);
                            $harr = array(0, 0, 0, 0, 0);
                            $tmp = "";
                            for($i = 0; $i < count($lst); $i++)
                            {
                        ?>
                        <tr>
                            <?php
                                if((strcasecmp($tmp, $lst[$i][0]) != 0 && strcasecmp($lp,"2") == 0) || strcasecmp($lp,"1") == 0)
                                {
                                    $tmrgn = "";
                                    if(strcasecmp($lst[$i][3],"1") == 0)
                                        $tmrgn = "<";
                                    else if(strcasecmp($lst[$i][3],"2") == 0)
                                        $tmrgn = ">";

                                    if(strcasecmp($lp,"1") == 0)
                                    {
                            ?>
                            <td class="border no-print"><button class="btn btn-sm border boder-info" onclick="viewCut('<?php echo UE64($lst[$i][0]);?>')"><img src="./bin/img/icon/view-list-icon.png" alt="" width="18"></button></td>
                            <?php
                                    }
                            ?>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1]));?></td>
                            <td class="border"><?php echo $tmrgn." ".$lst[$i][2];?></td>
                            <?php
                                }
                                else
                                {
                            ?>
                            <td class="border" colspan="2"></td>
                            <?php
                                }

                                if(strcasecmp($lp,"1") == 0)
                                {
                                    $mrgn = ($lst[$i][7]/$lst[$i][6]) * 100;
                                    $ttmrgn = ($lst[$i][9]/$lst[$i][6]) * 100;
                                    $tlgmrgn = ($lst[$i][10]/$lst[$i][6]) * 100;
                                    $vmrgn = ($lst[$i][8]/$lst[$i][7]) * 100;

                                    $susut = $lst[$i][6] - $lst[$i][7] - $lst[$i][9] - $lst[$i][10];
                                    $psusut = ($susut / $lst[$i][6]) * 100;

                                    $vsusut = $lst[$i][7] - $lst[$i][8];
                                    $pvsusut = ($vsusut / $lst[$i][7]) * 100;

                                    $hcut = $lst[$i][11] * $sett[5][2]/100;
                                    $httl = $lst[$i][11] * $sett[6][2]/100;
                                    $htlg = $lst[$i][11] * $sett[7][2]/100;
                                    $hvac = $hcut * $vmrgn/100;
                                    $hvsusut = $hcut * $pvsusut/100;

                                    $fcolor = "text-danger";
                                    if((strcasecmp($lst[$i][3],"1") == 0 && $mrgn < $lst[$i][2]) || (strcasecmp($lst[$i][3],"2") == 0 && $mrgn > $lst[$i][3]))
                                        $fcolor = "text-success";
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][6])) echo number_format($lst[$i][6], 2, '.', ','); else echo number_format($lst[$i][6], 0, '.', ',');?></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][11])) echo number_format($lst[$i][11], 2, '.', ','); else echo number_format($lst[$i][11], 0, '.', ',');?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][7])) echo number_format($lst[$i][7], 2, '.', ','); else echo number_format($lst[$i][7], 0, '.', ',');?></td>
                            <td class="border text-right <?php echo $fcolor;?>"><?php if(isDecimal($mrgn)) echo number_format($mrgn, 2, '.', ','); else echo number_format($mrgn, 0, '.', ',');?></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right"><?php if(isDecimal($hcut)) echo number_format($hcut, 2, '.', ','); else echo number_format($hcut, 0, '.', ',');?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][9])) echo number_format($lst[$i][9], 2, '.', ','); else echo number_format($lst[$i][9], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($ttmrgn)) echo number_format($ttmrgn, 2, '.', ','); else echo number_format($ttmrgn, 0, '.', ',');?></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right"><?php if(isDecimal($httl)) echo number_format($httl, 2, '.', ','); else echo number_format($httl, 0, '.', ',');?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][10])) echo number_format($lst[$i][10], 2, '.', ','); else echo number_format($lst[$i][10], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($tlgmrgn)) echo number_format($tlgmrgn, 2, '.', ','); else echo number_format($tlgmrgn, 0, '.', ',');?></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right"><?php if(isDecimal($htlg)) echo number_format($htlg, 2, '.', ','); else echo number_format($htlg, 0, '.', ',');?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($susut)) echo number_format($susut, 2, '.', ','); else echo number_format($susut, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($psusut)) echo number_format($psusut, 2, '.', ','); else echo number_format($psusut, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][8])) echo number_format($lst[$i][8], 2, '.', ','); else echo number_format($lst[$i][8], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($vmrgn)) echo number_format($vmrgn, 2, '.', ','); else echo number_format($vmrgn, 0, '.', ',');?></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right"><?php if(isDecimal($hvac)) echo number_format($hvac, 2, '.', ','); else echo number_format($hvac, 0, '.', ',');?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($vsusut)) echo number_format($vsusut, 2, '.', ','); else echo number_format($vsusut, 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($pvsusut)) echo number_format($pvsusut, 2, '.', ','); else echo number_format($pvsusut, 0, '.', ',');?></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right"><?php if(isDecimal($hvsusut)) echo number_format($hvsusut, 2, '.', ','); else echo number_format($hvsusut, 0, '.', ',');?></td>
                            <?php
                                }
                            ?>
                            <?php
                                    $sum[0] += $lst[$i][6];
                                    $sum[1] += $lst[$i][7];
                                    $sum[2] += $lst[$i][9];
                                    $sum[3] += $lst[$i][10];
                                    $sum[4] += $susut;
                                    $sum[5] += $lst[$i][8];
                                    $sum[6] += $vsusut;
                                    $harr[0] += $lst[$i][11];
                                    $harr[1] += $hcut;
                                    $harr[2] += $httl;
                                    $harr[3] += $htlg;
                                    $harr[4] += $hvac;
                                    $harr[5] += $hvsusut;
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                                    $mrgn = ($lst[$i][17]/$lst[$i][10]) * 100;

                                    $fcolor = "text-danger";
                                    if((strcasecmp($lst[$i][3],"1") == 0 && $mrgn < $lst[$i][2]) || (strcasecmp($lst[$i][3],"2") == 0 && $mrgn > $lst[$i][3]))
                                        $fcolor = "text-success";
                            ?>
                            <td class="border"><?php echo $lst[$i][6];?></td>
                            <td class="border"><?php echo $lst[$i][7];?></td>
                            <td class="border"><?php echo $lst[$i][8];?></td>
                            <td class="border"><?php echo $lst[$i][9];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][10])) echo number_format($lst[$i][10], 2, '.', ','); else echo number_format($lst[$i][10], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][11])) echo number_format($lst[$i][11], 2, '.', ','); else echo number_format($lst[$i][11], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][12])) echo number_format($lst[$i][12], 2, '.', ','); else echo number_format($lst[$i][12], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][13])) echo number_format($lst[$i][13], 2, '.', ','); else echo number_format($lst[$i][13], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][14])) echo number_format($lst[$i][14], 2, '.', ','); else echo number_format($lst[$i][14], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][15])) echo number_format($lst[$i][15], 2, '.', ','); else echo number_format($lst[$i][15], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][16])) echo number_format($lst[$i][16], 2, '.', ','); else echo number_format($lst[$i][16], 0, '.', ',');?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][17])) echo number_format($lst[$i][17], 2, '.', ','); else echo number_format($lst[$i][17], 0, '.', ',');?></td>
                            <td class="border text-right <?php echo $fcolor;?>"><?php if(isDecimal($mrgn)) echo number_format($mrgn, 2, '.', ','); else echo number_format($mrgn, 0, '.', ',');?></td>
                            <?php
                                    $sum[0] += $lst[$i][10];
                                    $sum[1] += $lst[$i][11];
                                    $sum[2] += $lst[$i][12];
                                    $sum[3] += $lst[$i][13];
                                    $sum[4] += $lst[$i][14];
                                    $sum[5] += $lst[$i][15];
                                    $sum[6] += $lst[$i][16];
                                    $sum[7] += $lst[$i][17];
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
                            <td class="border font-weight-bold text-right" colspan="3">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($harr[0])) echo number_format($harr[0], 2, '.', ','); else echo number_format($harr[0], 0, '.', ',')?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($harr[1])) echo number_format($harr[1], 2, '.', ','); else echo number_format($harr[1], 0, '.', ',')?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($harr[2])) echo number_format($harr[2], 2, '.', ','); else echo number_format($harr[2], 0, '.', ',')?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[3])) echo number_format($sum[3], 2, '.', ','); else echo number_format($sum[3], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($harr[3])) echo number_format($harr[3], 2, '.', ','); else echo number_format($harr[3], 0, '.', ',')?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[4])) echo number_format($sum[4], 2, '.', ','); else echo number_format($sum[4], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[5])) echo number_format($sum[5], 2, '.', ','); else echo number_format($sum[5], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($harr[4])) echo number_format($harr[4], 2, '.', ','); else echo number_format($harr[4], 0, '.', ',')?></td>
                            <?php
                                }
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[6])) echo number_format($sum[6], 2, '.', ','); else echo number_format($sum[6], 0, '.', ',')?></td>
                            <td class="border"></td>
                            <?php
                                if (cekAksUser(substr($duser[7], 200, 1))){
                            ?>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($harr[5])) echo number_format($harr[5], 2, '.', ','); else echo number_format($harr[5], 0, '.', ',')?></td>
                            <?php
                                }
                            ?>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"2") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="6">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[2])) echo number_format($sum[2], 2, '.', ','); else echo number_format($sum[2], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[3])) echo number_format($sum[3], 2, '.', ','); else echo number_format($sum[3], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[4])) echo number_format($sum[4], 2, '.', ','); else echo number_format($sum[4], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[5])) echo number_format($sum[5], 2, '.', ','); else echo number_format($sum[5], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[6])) echo number_format($sum[6], 2, '.', ','); else echo number_format($sum[6], 0, '.', ',')?></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[7])) echo number_format($sum[7], 2, '.', ','); else echo number_format($sum[7], 0, '.', ',')?></td>
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
    require("./bin/php/footer.php");

    closeDB($db);
    ?>
</body>

</html>