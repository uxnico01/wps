<?php
    require("./bin/php/clsfunction.php");

    $nav = 2;

    $ttl = "Data - Customer";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data - Customer | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>

    <style>
        #mdl-hst-trkrm .modal-dialog
        {
            width: 80%;
            max-width: 80%;
        }

        @media (max-width: 768px) {

            #mdl-hst-trkrm .modal-dialog
            {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 42, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 43, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-ncus"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Customer</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="txt-srch-cus" placeholder="Cari Customer" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-cus"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">Nama</th>
                            <th class="border sticky-top">Alamat</th>
                            <th class="border sticky-top">Wilayah</th>
                            <th class="border sticky-top">Tel</th>
                            <th class="border sticky-top">Tel2</th>
                            <th class="border sticky-top">Email</th>
                            <th class="border sticky-top">Ket1</th>
                            <th class="border sticky-top">Ket2</th>
                            <th class="border sticky-top">Ket3</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-cus">
                        <?php
                        $lst = getAllCus();

                        for ($i = 0; $i < count($lst); $i++) {
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border"><?php echo $lst[$i][7]; ?></td>
                                <td class="border"><?php echo $lst[$i][8]; ?></td>
                                <td class="border"><?php echo $lst[$i][9]; ?></td>
                                <td class="border mw-15p">
                                    <?php
                                    if (CekAksUser(substr($duser[7], 44, 1))) {
                                    ?>
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eCus('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                    }

                                    if (CekAksUser(substr($duser[7], 45, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delCus('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                    }

                                    if (CekAksUser(substr($duser[7], 46, 1))) {
                                    ?>
                                        <button class="btn btn-light border-info mb-1 p-1" onclick="mdlCus('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/more-info.png" alt="More" width="20"></button>
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
                <?php
                if (CekAksUser(substr($duser[7], 46, 1))) {
                ?>
                    <div class="modal fade" id="mdl-opt-cus" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-cus" aria-hidden="true">
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
                                        <input type="text" id="txt-opt-cus">
                                    </div>

                                    <div class="my-2">
                                        <?php
                                            if (CekAksUser(substr($duser[7], 46, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-trkrm" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History PO</span></button>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (CekAksUser(substr($duser[7], 46, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-trkrm" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-trkrm" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History PO</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-cus" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="offset-xl-2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-frm-trkrm" name="dte-frm-trkrm" value="<?php echo date('Y-m-01'); ?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 text-center"><span class="d-block mt-2">S/D</span></div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-trkrm" name="dte-to-trkrm" value="<?php echo date('Y-m-d'); ?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-trkrm-cus">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <td class="border align-middle sticky-top">Tgl</td>
                                                    <td class="border align-middle sticky-top">ID</td>
                                                    <td class="border align-middle sticky-top">Ket1</td>
                                                    <td class="border align-middle sticky-top">Ket2</td>
                                                    <td class="border align-middle sticky-top">Ket3</td>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-cus-trkrm">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (CekAksUser(substr($duser[7], 3, 1)))
                    require("./modals/mdl-ncus.php");

                if (CekAksUser(substr($duser[7], 4, 1))) {
                ?>
                    <div class="modal fade" id="mdl-ecus" tabindex="-1" role="dialog" aria-labelledby="mdl-ecus" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Customer</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-cus-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-cus-2">Terdapat data Customer dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-cus-3">Data Customer tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-cus-4">Format email tidak valid !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-cus-1">Customer berhasil diubah !!!</div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-nma" name="edt-txt-nma" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Alamat</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-addr" name="edt-txt-addr" placeholder="" autocomplete="off" maxlength="200"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Wilayah</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-reg" name="edt-txt-reg" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Tel</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-phone" name="edt-txt-phone" placeholder="" autocomplete="off" maxlength="50"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Tel 2</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-phone2" name="edt-txt-phone2" placeholder="" autocomplete="off" maxlength="50"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Email</span></div>
                                        <div class="col-9"><input type="email" class="form-control inp-set" id="edt-txt-mail" name="edt-txt-mail" placeholder="" autocomplete="off" maxlength="50"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket" name="edt-txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Ket2</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket2" name="edt-txt-ket2" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Ket3</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket3" name="edt-txt-ket3" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-secus">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php
        require("./bin/php/footer.php");
    ?>
</body>
</html>