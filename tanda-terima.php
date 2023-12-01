<?php
    require("./bin/php/clsfunction.php");

    $nav = 3;

    $ttl = "Transaksi - Tanda Terima";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - Tanda Terima | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 47, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 48, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-ntt"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Tanda Terima</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="txt-srch-tt" placeholder="Cari Tanda Terima" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-tt"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">Supplier</th>
                            <th class="border sticky-top text-right">BB</th>
                            <th class="border sticky-top text-right">Poto</th>
                            <th class="border sticky-top">Ket 1</th>
                            <th class="border sticky-top">Ket 2</th>
                            <th class="border sticky-top">Ket 3</th>
                            <th class="border sticky-top">No Terima</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-tt">
                        <?php
                            $lst = getAllTT();

                            for ($i = 0; $i < count($lst); $i++) {
                                $sup = getSupID($lst[$i][1]);

                                $bbdcl = 0;
                                if(isDecimal($lst[$i][3]))
                                    $bbdcl = 2;

                                $pdcl = 0;
                                if(isDecimal($lst[$i][4]))
                                    $pdcl = 2;
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][2])); ?></td>
                                <td class="border"><?php echo $sup[1]; ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][3],$bbdcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][4],$pdcl,'.',','); ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border"><?php echo $lst[$i][7]; ?></td>
                                <td class="border"><?php echo $lst[$i][8]; ?></td>
                                <td class="border"><?php echo $lst[$i][9]; ?></td>
                                <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][10])); ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eTT('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 65, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delTT('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                        <button class="btn btn-light border-info mb-1 p-1" onclick="mdlTT('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/more-info.png" alt="More" width="20"></button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="lmodals">
                <div class="modal fade" id="mdl-opt-tt" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-tt" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-tt">
                                </div>

                                <div class="my-2">
                                        <button class="btn btn-light border m-2" id="btn-view-tt" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Tanda Terima" width="25"> <span>Lihat Tanda Terima</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 48, 1)))
                        require("./modals/mdl-ntt.php");

                    //if (CekAksUser(substr($duser[7], 49, 1))) {
                ?>
                    <div class="modal fade" id="mdl-ett" tabindex="-1" role="dialog" aria-labelledby="mdl-ett" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Tanda Terima</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-tt-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-tt-2">Terdapat data penerimaan dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-tt-3">Data supplier tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-tt-4">Potongan tidak boleh melebihi pinjaman !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-tt-3">Data penerimaan tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-tt-6">Data tanda terima tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-tt-1">Tanda Terima berhasil diubah !!!</div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set" id="edt-txt-trm" name="edt-txt-trm" placeholder="" autocomplete="off" maxlength="25" readonly>

                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border" type="button" data-value="#mdl-ett" data-target="#mdl-strm" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-tgl" name="edt-dte-tgl" placeholder=""></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Supplier</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set" id="edt-txt-nma-sup" name="edt-txt-nma-sup" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                        <input type="text" class="d-none" id="edt-txt-sup">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">BB</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-bb" name="edt-txt-bb" placeholder="" autocomplete="off"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Poto</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-poto" name="edt-txt-poto" placeholder="" autocomplete="off" data-value=""> <span class="text-danger small" id="edt-spn-poto"></span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket1</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket1" name="edt-txt-ket1" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket2</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket2" name="edt-txt-ket2" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket3</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket3" name="edt-txt-ket3" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive my-2 mxh-60vh">
                                        <table class="table table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle">Grade</th>
                                                    <th class="border sticky-top align-middle">Produk</th>
                                                    <th class="border sticky-top align-middle">Satuan</th>
                                                    <th class="border sticky-top align-middle text-right">Qty (KG)</th>
                                                    <th class="border sticky-top align-middle text-right">Qty (Ekor)</th>
                                                    <th class="border sticky-top align-middle text-right">Harga / KG</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-ett">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-sett">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}

                    require("./modals/mdl-strm.php");
                    require("./modals/mdl-vtran.php");
                    require("./modals/mdl-ntt.php");
                    require("./modals/mdl-vtran.php");
                ?>
            </div>
        </div>
    </div>

    <?php
        require("./bin/php/footer.php");
    ?>
</body>
</html>