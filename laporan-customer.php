<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 5;

    $ttl = "Laporan - Customer";

    $tmpl = "1";
    $jns = "1";
    $frm = date('Y-m-d');
    $to = date('Y-m-d');
    if(isset($_GET["s"]))
    {
        $tmpl = trim(mysqli_real_escape_string($db, $_GET["t"]));
        $jns = trim(mysqli_real_escape_string($db, $_GET["j"]));
        
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

    closeDB($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Customer | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 83, 2)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 my-2">
                    <label for="slct-type">Tampil Berdasarkan</label>
                    <select name="t" id="slct-type" class="custom-select slct-type">
                        <option value="1" <?php if(strcasecmp($tmpl,"1") == 0) echo "selected=\"selected\"";?>>Kirim hari ini</option>
                        <option value="2" <?php if(strcasecmp($tmpl,"2") == 0) echo "selected=\"selected\"";?>>Kirim bulan ini</option>
                        <option value="3" <?php if(strcasecmp($tmpl,"3") == 0) echo "selected=\"selected\"";?>>Kirim berdasarkan tanggal</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 my-2">
                    <label for="slct-type">Jenis Tampil</label>
                    <select name="j" id="slct-tmpl" class="custom-select">
                        <option value="1" <?php if(strcasecmp($jns,"1") == 0) echo "selected=\"selected\"";?>>Tampil semua</option>
                        <option value="2" <?php if(strcasecmp($jns,"2") == 0) echo "selected=\"selected\"";?>>Tampil bersaldo</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($type,"3") != 0) echo "d-none";?>" id="div-frm">
                    <label for="dte-frm">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dte-frm" name="f" value="<?php echo $frm;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 my-2 <?php if(strcasecmp($type,"3") != 0) echo "d-none";?>" id="div-to">
                    <label for="dte-smpi">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="dte-smpi" name="tt" value="<?php echo $to;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                        <button class="m-1 btn btn-light border border-success" id="btn-cus-xl" type="button"><img src="./bin/img/icon/excel-icon.png" alt="" width="21"></button>

                        <?php
                            if(cekAksUser(substr($duser[7], 84, 1)))
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0 <?php if(!cekAksUser(substr($duser[7], 84, 1))) echo "no-print";?>">
            <div class="my-2 print-only">
                <h5>Laporan Customer</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border">ID</th>
                            <th class="border">Nama</th>
                            <th class="border">Alamat</th>
                            <th class="border">Wilayah</th>
                            <th class="border">Tel</th>
                            <th class="border">Tel2</th>
                            <th class="border">Email</th>
                            <th class="border">Ket</th>
                            <th class="border">Ket2</th>
                            <th class="border">Ket3</th>
                            <th class="border text-right">Kirim</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $lst = getCusFrmTo($frm, $to);

                            $sum = 0;
                            for($i = 0; $i < count($lst); $i++)
                            {
                                if($lst[$i][10] == 0 && strcasecmp($jns,"2") == 0)
                                    continue;
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo $lst[$i][1];?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border"><?php echo $lst[$i][3];?></td>
                            <td class="border"><?php echo $lst[$i][4];?></td>
                            <td class="border"><?php echo $lst[$i][5];?></td>
                            <td class="border"><?php echo $lst[$i][6];?></td>
                            <td class="border"><?php echo $lst[$i][7];?></td>
                            <td class="border"><?php echo $lst[$i][8];?></td>
                            <td class="border"><?php echo $lst[$i][9];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][10])) echo number_format($lst[$i][10], 2, '.', ','); else echo number_format($lst[$i][10], 0, '.', ',');?></td>
                        </tr>
                        <?php
                                $sum += $lst[$i][10];
                            }
                        ?>
                        <tr>
                            <td class="border font-weight-bold text-right" colspan="10">Total</td>
                            <td class="border text-right font-weight-bold"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',')?></td>
                        </tr>
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