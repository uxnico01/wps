<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 4;

    $ttl = "Proses - Masuk Produk";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Masuk Produk | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 128, 4)) && !CekAksUser(substr($duser[7], 201, 1)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 129, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nmp"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Masuk Produk</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-mp" placeholder="Cari Masuk Produk" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-mp"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-1 mb-2">

            <div class="table-responsive mxh-70vh">
                <table class="table table-sm table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top">Tgl Msk</th>
                            <th class="border sticky-top text-right">Total (KG)</th>
                            <th class="border sticky-top">Daftar Produk</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-mp">
                        <?php
                            $lst = getAllMP();

                            for ($i = 0; $i < count($lst); $i++) {
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][2])) echo number_format($lst[$i][2],2,'.',','); else echo number_format($lst[$i][2], 0, '.', ','); ?></td>
                                <td class="border small">
                                    <ul>
                                    <?php
                                        $dtl = getMPItem3($lst[$i][0]);

                                        for($j = 0; $j < count($dtl); $j++)
                                        {
                                            $jlh = number_format($dtl[$j][4], 0, '.', ',');

                                            if(isDecimal($dtl[$j][4]))
                                                $jlh = number_format($dtl[$j][4], 2, '.', ',');
                                    ?>
                                        <li><?php echo $dtl[$j][0]; if(strcasecmp($dtl[$j][1],"") != 0) echo " / ".$dtl[$j][1]; if(strcasecmp($dtl[$j][2],"") != 0) echo " / ".$dtl[$j][2]; if(strcasecmp($dtl[$j][3],"") != 0) echo " / ".$dtl[$j][3]; echo " (".$jlh.") "; if(strcasecmp($dtl[$j][5], "") != 0) echo $dtl[$j][5];?></li>
                                    <?php
                                        }
                                    ?>
                                    </ul>
                                </td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eMP('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 131, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delMP('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewMP('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Masuk Produk" width="20"></button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="lmodals">
                <?php
                    if (CekAksUser(substr($duser[7], 129, 1)))
                        require("./modals/mdl-nmp.php");

                    //if (CekAksUser(substr($duser[7], 130, 1))) {
                ?>
                    <div class="modal fade" id="mdl-emp" tabindex="-1" role="dialog" aria-labelledby="mdl-emp" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Masuk Produk</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-mp-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-mp-2">Data produk tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-mp-3">Data masuk produk tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-mp-4">Data bahan tidak boleh kosong !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-mp-5">Data gudangtidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-mp-1">Masuk Produk berhasil diubah !!!</div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-tgl" name="edt-dte-tgl" placeholder=""><input type="text" class="d-none" id="edt-txt-id"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Gudang</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <select name="edt-slct-gdg" id="edt-slct-gdg" class="custom-select">
                                                        <?php
                                                            $lgdg = getAllGdg($db);
                                                            for($i = 0; $i < count($lgdg); $i++){
                                                        ?>
                                                        <option value="<?php echo $lgdg[$i][0];?>"><?php echo $lgdg[$i][1];?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 my-2 p-0">
                                        <button class="btn btn-light border border-success btn-mp-pro" data-toggle="modal" data-target="#mdl-npro-mp" data-keyboard="false" data-backdrop="static" data-dismiss="modal"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Pilih Produk</span></button>
                                    </div>
                                    
                                    <div class="table-responsive my-2 mxh-60vh">
                                        <table class="table table-sm table-data2">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle">Produk</th>
                                                    <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                                                    <th class="border sticky-top align-middle">Keterangan</th>
                                                    <th class="border sticky-top align-middle">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-emp">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-semp" data-count="">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}
                    require("./modals/mdl-vtran.php");
                    require("./modals/mdl-npro-mp.php");
                    require("./modals/mdl-spro2.php");
                    require("./modals/mdl-spro3.php");
                ?>
            </div>
        </div>
    </div>

    <?php
        require("./bin/php/footer.php");

        closeDB($db);
    ?>
</body>
</html>