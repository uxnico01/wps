<?php
    require("./bin/php/clsfunction.php");

    $nav = 2;

    $ttl = "Data - Oz";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data - Oz | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>

    <style>
        #mdl-lpro-kate .modal-dialog,
        #mdl-lskate-kate .modal-dialog {
            width: 70%;
            max-width: 70%;
        }

        @media (max-width: 768px) {
            #mdl-lpro-kate .modal-dialog,
            #mdl-lskate-kate .modal-dialog {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 26, 6)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 27, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nkate"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Oz</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="txt-srch-kate" placeholder="Cari Oz" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-kate"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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

                    <tbody id="lst-kate">
                        <?php
                            $lst = getAllKate();

                            for ($i = 0; $i < count($lst); $i++) {
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border mw-15p">
                                    <?php
                                        if (CekAksUser(substr($duser[7], 28, 1))) {
                                    ?>
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eKate('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        }

                                        if (CekAksUser(substr($duser[7], 29, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delKate('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }

                                        if (CekAksUser(substr($duser[7], 30, 2))) {
                                    ?>
                                        <button class="btn btn-light border-info mb-1 p-1" onclick="mdlKate('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/more-info.png" alt="More" width="20"></button>
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
                    if (CekAksUser(substr($duser[7], 30, 2))) {
                ?>
                    <div class="modal fade" id="mdl-opt-kate" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-kate" aria-hidden="true">
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
                                        <input type="text" id="txt-opt-kate">
                                    </div>

                                    <div class="my-2">
                                        <?php
                                            if (CekAksUser(substr($duser[7], 30, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" id="btn-lpro-kate" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Daftar Produk" width="25"> <span>Daftar Produk</span></button>
                                        <?php
                                            }

                                            /*if (CekAksUser(substr($duser[7], 31, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" id="btn-lskate-kate" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Daftar Sub Oz" width="25"> <span>Daftar Cut Style</span></button>
                                        <?php
                                            }*/
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }

                    if (CekAksUser(substr($duser[7], 30, 1))) {
                ?>
                <div class="modal fade" id="mdl-lpro-kate" tabindex="-1" role="dialog" aria-labelledby="mdl-lpro-kate" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Daftar Produk</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-kate" data-toggle="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body pt-1">
                                <div class="row my-2">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control text-left" id="txt-srch-pro-kate" placeholder="Cari Produk" autocomplete="off">

                                            <div class="input-group-append">
                                                <button class="btn btn-light border" id="btn-srch-pro-kate"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                                                <th class="border align-middle sticky-top">Cut Style</th>
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

                    /*if (CekAksUser(substr($duser[7], 31, 1))) {
                ?>
                <div class="modal fade" id="mdl-lskate-kate" tabindex="-1" role="dialog" aria-labelledby="mdl-lskate-kate" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Daftar Sub Oz</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-kate" data-toggle="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body pt-1">
                                <div class="row my-2">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control text-left" id="txt-srch-skate-kate" placeholder="Cari Produk" autocomplete="off">

                                            <div class="input-group-append">
                                                <button class="btn btn-light border" id="btn-srch-skate-kate"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                                                <th class="border align-middle sticky-top">Ket</th>
                                            </tr>
                                        </thead>

                                        <tbody id="lst-skate">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }*/

                    if (CekAksUser(substr($duser[7], 27, 1)))
                        require("./modals/mdl-nkate.php");

                    if (CekAksUser(substr($duser[7], 28, 1))) {
                ?>
                    <div class="modal fade" id="mdl-ekate" tabindex="-1" role="dialog" aria-labelledby="mdl-ekate" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Oz</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-kate-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-kate-2">Terdapat data oz dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-kate-3">Data oz tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-kate-1">Oz berhasil diubah !!!</div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
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
                                    <button type="button" class="btn btn-primary" id="btn-sekate">Simpan</button>
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