<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 3;

    $ttl = "Transaksi - Pindah Stok";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - Pindah Stok | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 163, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 164, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nmv"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Pindah Stok</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-1 offset-xl-2 col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-mv" placeholder="Cari Pindah Stok" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-mv"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-1 mb-2">

            <div class="table-responsive mxh-70vh">
                <table class="table table-sm table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top">ID</th>
                            <th class="border sticky-top">Tgl</th>
                            <th class="border sticky-top">Dari</th>
                            <th class="border sticky-top">Tujuan</th>
                            <th class="border sticky-top">Tipe</th>
                            <th class="border sticky-top">Kepada</th>
                            <th class="border sticky-top">Ket</th>
                            <th class="border sticky-top text-right">Total Berat (KG)</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top">No TT Gudang</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-mv">
                        <?php
                            $lst = getAllMove($db);

                            for ($i = 0; $i < count($lst); $i++) {
                        ?>
                            <tr ondblclick="viewMove('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo $lst[$i][10]; ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][9])) echo number_format($lst[$i][9],2,'.',','); else echo number_format($lst[$i][9],0,'.',','); ?></td>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border"><?php echo $lst[$i][7]; ?></td>
                                <td class="border"><?php echo $lst[$i][8]; ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eMove('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 166, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delMove('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewMove('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Pindah Stok" width="20"></button>
                                    <?php
                                        if (strcasecmp($lst[$i][8],"") == 0) {
                                    ?>
                                        <button class="btn btn-light border-success mb-1 p-1" onclick="setTTMove('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/check.png" alt="Check" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="lmodals">
                <div class="modal fade" id="mdl-opt-mv" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-mv" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">More Option</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body pt-1">
                                <div class="d-none">
                                    <input type="text" id="txt-opt-mv">
                                </div>

                                <div class="my-2">
                                        <button class="btn btn-light border m-2" id="btn-view-mv" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Pindah Stok" width="25"> <span>Lihat Pindah Stok</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 164, 1))){
                        require("./modals/mdl-nmv.php");
                    }

                    //if (CekAksUser(substr($duser[7], 64, 1))) {
                ?>
                    <div class="modal fade" id="mdl-emv" tabindex="-1" role="dialog" aria-labelledby="mdl-emv" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Pindah Stok</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-none">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-tgl" name="edt-dte-tgl" placeholder=""></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Kepada</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-to" name="edt-txt-to" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Dari Gdg</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <select name="edt-slct-gdgf" id="edt-slct-gdgf" class="custom-select">
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

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ke Gdg</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <select name="edt-slct-gdgt" id="edt-slct-gdgt" class="custom-select">
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

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Jenis</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <select name="edt-slct-tipe" id="edt-slct-tipe" class="custom-select">
                                                        <option value="">Pilih Jenis</option>
                                                        <option value="I">Penitipan</option>
                                                        <option value="O">Pengambilan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Deskripsi</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket" name="edt-txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">No TT</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ntt" name="edt-txt-ntt" placeholder="" autocomplete="off" maxlength="25"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 my-2 p-0">
                                        <button class="btn btn-light border border-success btn-mv-pro" id="btn-emv-pro"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Tambah Produk</span></button>
                                    </div>
                                    
                                    <div class="table-responsive my-2 mxh-60vh">
                                        <table class="table table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle w-200px">Produk</th>
                                                    <th class="border sticky-top align-middle text-right w-80px">Qty</th>
                                                    <th class="border sticky-top align-middle w-100px">Satuan</th>
                                                    <th class="border sticky-top align-middle text-right w-80px">Berat</th>
                                                    <th class="border sticky-top align-middle w-120px">Ket</th>
                                                    <th class="border sticky-top align-middle w-120px">Tgl Exp</th>
                                                    <th class="border sticky-top"></th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-emv">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-mv-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-mv-2">Terdapat data penerimaan dengan ID ini !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-mv-3">Data gudang awal tidak ditemukan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-mv-4">Data gudang tujuan tidak ditemukan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-mv-5">Harap masukkan produk yang dipindah !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-mv-6">Data pindah stok tidak ditemukan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-mv-7">Gudang awal dan gudang tujuan tidak boleh sama !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-mv-8">Terdapat qty produk yang tidak mencukupi pada gudang terpilih !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-mv-9">Terdapat qty produk yang tidak mencukupi pada gudang terpilih !!!</div>

                                    <div class="alert alert-success mb-0 mr-2 d-none" id="div-edt-scs-mv-1">Pindah Stok berhasil diubah !!!</div>

                                    <button type="button" class="btn btn-primary" id="btn-semv" data-count="0">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}

                    require("./modals/mdl-spro5.php");
                    require("./modals/mdl-uttmv.php");
                    require("./modals/mdl-vtran.php");
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