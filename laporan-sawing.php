<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Sawing";

    $lp = "1";
    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    $p = "";
    $np = "";
    $bb = "";
    $nbb = "";
    if(isset($_GET["s"]))
    {
        $lp = trim(mysqli_real_escape_string($db, $_GET["l"]));
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        $p = trim(mysqli_real_escape_string($db, $_GET["p"]));
        $np = trim(mysqli_real_escape_string($db, $_GET["np"]));
        $bb = trim(mysqli_real_escape_string($db, $_GET["bb"]));
        $nbb = trim(mysqli_real_escape_string($db, $_GET["nbb"]));
    }

    closeDB($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Sawing | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 91, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2">
                    <label for="slct-jns-saw">Jenis Laporan</label>
                    <select name="l" id="slct-jns-saw" class="custom-select">
                        <option value="1" <?php if(strcasecmp($lp,"1") == 0) echo "selected=\"selected\"";?>>Rekap</option>
                        <option value="4" <?php if(strcasecmp($lp,"4") == 0) echo "selected=\"selected\"";?>>Rekap Bahan Baku</option>
                        <option value="2" <?php if(strcasecmp($lp,"2") == 0) echo "selected=\"selected\"";?>>Rincian</option>
                        <option value="3" <?php if(strcasecmp($lp,"3") == 0) echo "selected=\"selected\"";?>>Hasil Proses</option>
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
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 my-2 <?php if(strcasecmp($lp,"3") == 0) echo "d-none";?>" id="div-bb">
                    <label for="txt-nma-bb">Pilih Bahan Baku</label>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set" id="txt-nma-bb" name="nbb" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $nbb;?>">
                        <input type="text" class="d-none" id="txt-bb" name="bb" value="<?php echo $bb;?>">

                        <div class="input-group-append">
                            <button class="btn btn-light border inp-bb" type="button" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                        </div>

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-rbb" type="button"><img src="./bin/img/icon/delete-icon.png" width="20" alt="Reset"></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 my-2" id="div-pro">
                    <label for="txt-nma-pro">Pilih Hasil</label>
                    <div class="input-group">
                        <input type="text" class="form-control inp-set" id="txt-nma-pro" name="np" placeholder="" autocomplete="off" maxlength="100" readonly value="<?php echo $np;?>">
                        <input type="text" class="d-none" id="txt-pro" name="p" value="<?php echo $p;?>">

                        <div class="input-group-append">
                            <button class="btn btn-light border inp-lpro" type="button" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                        </div>

                        <div class="input-group-append">
                            <button class="btn btn-light border btn-rpro" type="button"><img src="./bin/img/icon/delete-icon.png" width="20" alt="Reset"></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-saw-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 92, 1)))
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 92, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Sawing</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <?php
                            if(strcasecmp($lp,"3") == 0)
                            {
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle">No</th>
                            <th class="border sticky-top align-middle">Bahan Baku</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"4") == 0)
                            {
                        ?>
                        <tr>
                            <th class="border sticky-top align-middle">Bahan Baku</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle">Hasil</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle text-right">(%)</th>
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
                            <th class="border sticky-top align-middle">Hasil</th>
                            <th class="border sticky-top align-middle">Tahapan Ke</th>
                            <th class="border sticky-top align-middle">Ket</th>
                            <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                            <th class="border sticky-top align-middle">Margin</th>
                            <?php
                                if(strcasecmp($lp,"1") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle text-right">Total Sawing (KG)</th>
                            <th class="border sticky-top align-middle text-right">(%)</th>
                            <?php
                                }
                                else if(strcasecmp($lp,"2") == 0)
                                {
                            ?>
                            <th class="border sticky-top align-middle">Hasil</th>
                            <th class="border sticky-top align-middle">Tahapan Ke</th>
                            <th class="border sticky-top align-middle">Ket</th>
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
                                $lst = getSawFrmTo2($frm, $to, $p, $bb);
                            else if(strcasecmp($lp,"1") == 0)
                                $lst = getSawFrmTo($frm, $to, $p, $bb);
                            else if(strcasecmp($lp,"3") == 0)
                                $lst = getSawFrmTo3($frm, $to, $p);
                            else if(strcasecmp($lp,"4") == 0)
                                $lst = getSawFrmTo4($frm, $to, $p, $bb);

                            if(strcasecmp($lp,"3") == 0)
                            {
                                $sum = 0;
                                $n = 1;
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    $nma = $lst[$i][0]." / ".$lst[$i][1];

                                    if(strcasecmp($lst[$i][2],"") != 0){
                                        $nma .= " / ".$lst[$i][2];
                                    }

                                    if(strcasecmp($lst[$i][3],"") != 0){
                                        $nma .= " / ".$lst[$i][3];
                                    }
                        ?>
                        <tr>
                            <td class="border"><?php echo $n;?></td>
                            <td class="border"><?php echo $nma;?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][4])) echo number_format($lst[$i][4],2,'.',','); else echo number_format($lst[$i][4],0,'.',',');?></td>
                        </tr>
                        <?php
                                    $sum += $lst[$i][4];
                                    $n++;
                                }
                            }
                            else if(strcasecmp($lp,"4") == 0)
                            {
                                $tmp = "";
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    $prsn = ($lst[$i][9]/$lst[$i][4])*100;
                        ?>
                        <tr>
                            <?php
                                if(strcasecmp($tmp, $lst[$i][10]) != 0)
                                {
                                    $nma = $lst[$i][0]." / ".$lst[$i][1];

                                    if(strcasecmp($lst[$i][2],"") != 0){
                                        $nma .= " / ".$lst[$i][2];
                                    }

                                    if(strcasecmp($lst[$i][3],"") != 0){
                                        $nma .= " / ".$lst[$i][3];
                                    }
                            ?>
                            <td class="border"><?php echo $nma;?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][4])) echo number_format($lst[$i][4],2,'.',','); else echo number_format($lst[$i][4],0,'.',',');?></td>
                            <?php
                                    $tmp = $lst[$i][10];
                                }
                                else
                                {
                            ?>
                            <td class="border" colspan="2"></td>
                            <?php
                                }

                                $nma = $lst[$i][5]." / ".$lst[$i][6];

                                if(strcasecmp($lst[$i][7],"") != 0){
                                    $nma .= " / ".$lst[$i][7];
                                }

                                if(strcasecmp($lst[$i][8],"") != 0){
                                    $nma .= " / ".$lst[$i][8];
                                }
                            ?>
                            <td class="border"><?php echo $nma;?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][9])) echo number_format($lst[$i][9],2,'.',','); else echo number_format($lst[$i][9],0,'.',',');?></td>
                            <td class="border text-right"><?php if(isDecimal($prsn)) echo number_format($prsn,2,'.',','); else echo number_format($prsn,0,'.',',');?></td>
                        </tr>
                        <?php
                                }
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
                                    $tmrgn = "";
                                    if(strcasecmp($lst[$i][9],"1") == 0)
                                        $tmrgn = "<";
                                    else if(strcasecmp($lst[$i][9],"2") == 0)
                                        $tmrgn = ">";

                                    if(strcasecmp($lp,"1") == 0)
                                    {
                            ?>
                            <td class="border no-print"><button class="btn btn-sm border boder-info" onclick="viewSaw('<?php echo UE64($lst[$i][0]);?>')"><img src="./bin/img/icon/view-list-icon.png" alt="" width="18"></button></td>
                            <?php
                                    }

                                    $nma = $lst[$i][2]." / ".$lst[$i][3];

                                    if(strcasecmp($lst[$i][4],"") != 0){
                                        $nma .= " / ".$lst[$i][4];
                                    }

                                    if(strcasecmp($lst[$i][5],"") != 0){
                                        $nma .= " / ".$lst[$i][5];
                                    }
                            ?>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1]));?></td>
                            <td class="border"><?php echo $nma;?></td>
                            <?php
                                    if(strcasecmp($lp,"1") == 0)
                                    {
                            ?>
                            <td class="border"><?php echo $lst[$i][12];?></td>
                            <td class="border"><?php echo $lst[$i][13];?></td>
                            <?php
                                    }
                                    else if(strcasecmp($lp,"2") == 0)
                                    {
                            ?>
                            <td class="border"><?php echo $lst[$i][17];?></td>
                            <td class="border"><?php echo $lst[$i][18];?></td>
                            <?php
                                    }
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][6])) echo number_format($lst[$i][6], 2, '.', ','); else echo number_format($lst[$i][6], 0, '.', ',');?></td>
                            <td class="border"><?php echo $tmrgn." ".$lst[$i][7];?></td>
                            <?php
                                        $sum[0] += $lst[$i][6];
                                    }
                                    else
                                    {
                            ?>
                            <td class="border" colspan="6"></td>
                            <?php
                                    }

                                    if(strcasecmp($lp,"1") == 0)
                                    {
                                        if($lst[$i][6] == 0)
                                            $mrgn = 100;
                                        else
                                            $mrgn = ($lst[$i][11]/$lst[$i][6]) * 100;

                                        $fcolor = "";
                                        /*$fcolor = "text-danger";
                                        if((strcasecmp($lst[$i][8],"1") == 0 && $mrgn < $lst[$i][7]) || (strcasecmp($lst[$i][8],"2") == 0 && $mrgn > $lst[$i][7]))
                                            $fcolor = "text-success";*/
                            ?>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][11])) echo number_format($lst[$i][11], 2, '.', ','); else echo number_format($lst[$i][11], 0, '.', ',');?></td>
                            <td class="border text-right <?php echo $fcolor;?>"><?php if(isDecimal($mrgn)) echo number_format($mrgn, 2, '.', ','); else echo number_format($mrgn, 0, '.', ',');?></td>
                            <?php
                                        $sum[1] += $lst[$i][11];
                                    }
                                    else if(strcasecmp($lp,"2") == 0)
                                    {
                                        if($lst[$i][6] == 0)
                                            $mrgn = 100;
                                        else
                                            $mrgn = ($lst[$i][16]/$lst[$i][6]) * 100;
                                            
                                        $fcolor = "";
                                        /*$fcolor = "text-danger";
                                        if((strcasecmp($lst[$i][8],"1") == 0 && $mrgn < $lst[$i][7]) || (strcasecmp($lst[$i][8],"2") == 0 && $mrgn > $lst[$i][7]))
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
                            <td class="border"><?php echo $lst[$i][17];?></td>
                            <td class="border"><?php echo $lst[$i][18];?></td>
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
                        ?>
                        <?php
                            if(strcasecmp($lp,"1") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="5">Total</td>
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
                            <td class="border font-weight-bold text-right" colspan="4">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[0])) echo number_format($sum[0], 2, '.', ','); else echo number_format($sum[0], 0, '.', ',')?></td>
                            <td class="border font-weight-bold text-right" colspan="4"></td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum[1])) echo number_format($sum[1], 2, '.', ','); else echo number_format($sum[1], 0, '.', ',')?></td>
                        </tr>
                        <?php
                            }
                            else if(strcasecmp($lp,"3") == 0)
                            {
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="2">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',')?></td>
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
    ?>
</body>

</html>