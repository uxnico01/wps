<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 2;

    $ttl = "Data - Gudang";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data - Gudang | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 159, 4)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 160, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-ngdg"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Gudang</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="txt-srch-gdg" placeholder="Cari Gudang" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-gdg"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">PIC</th>
                            <th class="border sticky-top">Tel</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-gdg">
                        <?php
                        $lst = getAllGdg($db);

                        for ($i = 0; $i < count($lst); $i++) {
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border mw-15p">
                                    <?php
                                    if (CekAksUser(substr($duser[7], 161, 1))) {
                                    ?>
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eGdg('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                    }

                                    if (CekAksUser(substr($duser[7], 162, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delGdg('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
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
                if (CekAksUser(substr($duser[7], 160, 1)))
                    require("./modals/mdl-ngdg.php");

                if (CekAksUser(substr($duser[7], 161, 1))) {
                ?>
                    <div class="modal fade" id="mdl-egdg" tabindex="-1" role="dialog" aria-labelledby="mdl-egdg" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Gudang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-gdg-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-gdg-2">Terdapat data Gudang dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-gdg-3">Data Gudang tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-gdg-1">Gudang berhasil diubah !!!</div>

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
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-addr" name="edt-txt-addr" placeholder="" autocomplete="off" maxlength="250"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">PIC</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-pic" name="edt-txt-pic" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Tel</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-phone" name="edt-txt-phone" placeholder="" autocomplete="off" maxlength="50"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-segdg">Simpan</button>
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

        closeDB($db);
    ?>
</body>
</html>