<?php
    require("./bin/php/clsfunction.php");

    $nav = 2;

    $ttl = "Data - Cut Style";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data - Cut Style | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>

    <style>
        #mdl-lpro-skate .modal-dialog {
            width: 70%;
            max-width: 70%;
        }

        @media (max-width: 768px) {
            #mdl-lpro-skate .modal-dialog {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 32, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 33, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nskate"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Cut Style</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="txt-srch-skate" placeholder="Cari Cut Style" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-skate"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">Ket</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-skate">
                        <?php
                            $lst = getAllSKate();

                            for ($i = 0; $i < count($lst); $i++) {
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border mw-15p">
                                    <?php
                                        if (CekAksUser(substr($duser[7], 34, 1))) {
                                    ?>
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eSKate('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        }

                                        if (CekAksUser(substr($duser[7], 35, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delSKate('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }

                                        if (CekAksUser(substr($duser[7], 36, 1))) {
                                    ?>
                                        <button class="btn btn-light border-info mb-1 p-1" onclick="mdlSKate('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/more-info.png" alt="More" width="20"></button>
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
                    if (CekAksUser(substr($duser[7], 36, 1))) {
                ?>
                    <div class="modal fade" id="mdl-opt-skate" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-skate" aria-hidden="true">
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
                                        <input type="text" id="txt-opt-skate">
                                    </div>

                                    <div class="my-2">
                                        <?php
                                            if (CekAksUser(substr($duser[7], 30, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" id="btn-lpro-skate" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Daftar Produk" width="25"> <span>Daftar Produk</span></button>
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

                    if (CekAksUser(substr($duser[7], 36, 1))) {
                ?>
                    <div class="modal fade" id="mdl-lpro-skate" tabindex="-1" role="dialog" aria-labelledby="mdl-lpro-skate" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Daftar Produk</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-skate" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row my-2">
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control text-left" id="txt-srch-pro-skate" placeholder="Cari Produk" autocomplete="off">

                                                <div class="input-group-append">
                                                    <button class="btn btn-light border" id="btn-srch-pro-skate"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <th class="border align-middle sticky-top">ID</th>
                                                    <th class="border align-middle sticky-top">Nama</th>
                                                    <th class="border align-middle sticky-top">Grade</th>
                                                    <th class="border align-middle sticky-top">Oz</th>
                                                    <th class="border align-middle sticky-top text-right">Qty (KG)</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-pro">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }

                    if (CekAksUser(substr($duser[7], 33, 1)))
                        require("./modals/mdl-nskate.php");

                    if (CekAksUser(substr($duser[7], 34, 1))) {
                ?>
                    <div class="modal fade" id="mdl-eskate" tabindex="-1" role="dialog" aria-labelledby="mdl-eskate" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Cut Style</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-skate-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-skate-2">Terdapat data cut style dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-skate-3">Data cut style tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-skate-4">Data kategori tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-skate-1">Cut Style berhasil diubah !!!</div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                    </div>

                                    <div class="row mt-2 d-none">
                                        <div class="col-3 mt-1"><span class="h6">Kategori</span><span class="text-danger">*</span></div>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control inp-set" id="edt-txt-nma-kate" name="edt-txt-nma-kate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                <input type="text" class="d-none" id="edt-txt-kate">

                                                <div class="input-group-append">
                                                    <button class="btn btn-light border" type="button" data-value="#mdl-eskate" data-target="#mdl-skate" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-nma" name="edt-txt-nma" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket" name="edt-txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-seskate">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                    require("./modals/mdl-skate.php");
                ?>
            </div>
        </div>
    </div>

    <?php
        require("./bin/php/footer.php");
    ?>
</body>
</html>