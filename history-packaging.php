<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 7;

    $ttl = "History - Pengiriman";

    $frm = date('Y-m-01');
    $to = date('Y-m-t');
    $jtgl = "1";
    if(isset($_GET["s"]))
    {
        $frm = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["f"]))));
        $to = date('Y-m-d', strtotime(trim(mysqli_real_escape_string($db, $_GET["tt"]))));
        $jtgl = trim(mysqli_real_escape_string($db, $_GET["jt"]));
    }

    closeDB($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>History - Pengiriman | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 96, 1)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0 no-print">
            <form method="get" class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2 offset-xl-3">
                    <label for="dte-frm">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dte-frm" name="f" value="<?php echo $frm;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 my-2">
                    <label for="dte-smpi">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="dte-smpi" name="tt" value="<?php echo $to;?>">
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 my-2">
                    <label for="slct-jt">Berdasarkan Tanggal</label>
                    <select name="jt" id="slct-jt" class="custom-select">
                        <option value="1" <?php if(strcasecmp($jtgl,"1") == 0) echo "selected=\"selected\"";?>>Perubahan</option>
                        <option value="2" <?php if(strcasecmp($jtgl,"2") == 0) echo "selected=\"selected\"";?>>Transaksi/Proses</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-2 col-lg-3 col-xl-2 d-flex align-items-end pb-1">
                    <div class="">
                        <button class="m-1 btn btn-primary" type="submit" name="s">Cari</button>
                    </div>
                </div>
            </form>
            <hr class="mt-1">
        </div>

        <?php
            if(isset($_GET["s"]))
            {
        ?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0">
            <div class="my-2 d-none">
                <h5>History Packaging</h5>
                <h5>Periode : <?php echo date('d/m/Y', strtotime($frm))." s/d ".date('d/m/Y', strtotime($to));?></h5>
                <h5>Tgl Cetak : <?php echo date('d/m/Y');?></h5>
            </div>

            <div class="table-responsive mh-70vh mxh-70vh">
                <table class="table table-sm table-striped" id="tbl-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top"></th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top">Oleh</th>
                            <th class="border sticky-top">Stat</th>
                            <th class="border sticky-top">Tgl</th>
                            <th class="border sticky-top d-none">Ket</th>
                            <th class="border sticky-top d-none">Ket2</th>
                            <th class="border sticky-top d-none">Ket3</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Input</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $lst = getHstKirimFrmTo($frm, $to, $jtgl);

                            for($i = 0; $i < count($lst); $i++)
                            {
                        ?>
                        <tr>
                            <td class="border"><button class="btn btn-sm border boder-info btn-vhst-krm" data-value="<?php echo UE64($lst[$i][0]);?>"><img src="./bin/img/icon/view-list-icon.png" alt="" width="18"></button></td>
                            <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][1]));?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border"><?php echo $lst[$i][3];?></td>
                            <?php
                                if(strcasecmp($lst[$i][3],"DELETE") == 0)
                                {
                            ?>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][5]));?></td>
                            <td class="border d-none"><?php echo $lst[$i][6];?></td>
                            <td class="border d-none"><?php echo $lst[$i][7];?></td>
                            <td class="border d-none"><?php echo $lst[$i][8];?></td>
                            <td class="border"><?php echo $lst[$i][9];?></td>
                            <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][10]));?></td>
                            <?php
                                }
                                else
                                {
                            ?>
                            <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][12]));?></td>
                            <td class="border d-none"><?php echo $lst[$i][13];?></td>
                            <td class="border d-none"><?php echo $lst[$i][14];?></td>
                            <td class="border d-none"><?php echo $lst[$i][15];?></td>
                            <td class="border"><?php echo $lst[$i][16];?></td>
                            <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][17]));?></td>
                            <?php
                                }
                            ?>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modals">
            <div class="modal fade" id="mdl-hview" tabindex="-1" role="dialog" aria-labelledby="mdl-hview" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Data History</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body py-1">
                            <h6 class="mt-2 mb-0">Sebelum</h6><hr>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2 d-none">ID : <span id="id_bfr"></span></div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2">Tgl : <span id="tgl_bfr"></span></div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2 d-none">Ket1 : <span id="ket1_bfr"></span></div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2 d-none">Ket2 : <span id="ket2_bfr"></span></div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2 d-none">Ket3 : <span id="ket3_bfr"></span></div>
                            </div>
                            <div class="table-responsive mxh-60vh">
                                <table class="table table-sm table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="border sticky-top">No P/O</th>
                                            <th class="border sticky-top">Produk</th>
                                            <th class="border sticky-top">Qty</th>
                                            <th class="border sticky-top">Tgl Exp</th>
                                            <th class="border text-right sticky-top">Berat (KG)</th>
                                            <th class="border sticky-top">Keterangan</th>
                                        </tr>
                                    </thead>

                                    <tbody id="lhst_bfr"></tbody>
                                </table>
                            </div>

                            <h6 class="mt-4 mb-0">Sesudah</h6><hr>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2 d-none">ID : <span id="id_afr"></span></div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2">Tgl : <span id="tgl_afr"></span></div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2 d-none">Ket1 : <span id="ket1_afr"></span></div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2 d-none">Ket2 : <span id="ket2_afr"></span></div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 my-2 d-none">Ket3 : <span id="ket3_afr"></span></div>
                            </div>
                            <div class="table-responsive mxh-60vh">
                                <table class="table table-sm table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="border sticky-top">No P/O</th>
                                            <th class="border sticky-top">Produk</th>
                                            <th class="border sticky-top">Qty</th>
                                            <th class="border sticky-top">Tgl Exp</th>
                                            <th class="border text-right sticky-top">Berat (KG)</th>
                                            <th class="border sticky-top">Keterangan</th>
                                        </tr>
                                    </thead>

                                    <tbody id="lhst_afr"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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