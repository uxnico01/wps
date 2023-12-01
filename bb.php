<?php
    require("./bin/php/clsfunction.php");

    $nav = 3;

    $ttl = "Transaksi - BB";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - BB | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 145, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 146, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nbb"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah BB</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-bb" placeholder="Cari BB" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-bb"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top text-right">Jlh</th>
                            <th class="border sticky-top">Ket</th>
                            <th class="border sticky-top">Jenis</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-bb">
                        <?php
                            $lst = getAllBB();

                            for ($i = 0; $i < count($lst); $i++) {
                        ?>
                            <tr ondblclick="viewBB('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][2])) echo number_format($lst[$i][2],2,'.',','); else echo number_format($lst[$i][2],0,'.',',');?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][6])); ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eBB('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 148, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delBB('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewBB('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat BB" width="20"></button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="lmodals">
                <div class="modal fade" id="mdl-opt-bb" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-bb" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-bb">
                                </div>

                                <div class="my-2">
                                    <button class="btn btn-light border m-2" id="btn-view-bb" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat BB" width="25"> <span>Lihat BB</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 146, 1)))
                        require("./modals/mdl-nbb.php");

                    //if (CekAksUser(substr($duser[7], 28, 1))) {
                ?>
                    <div class="modal fade" id="mdl-ebb" tabindex="-1" role="dialog" aria-labelledby="mdl-ebb" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat BB</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-bb-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-bb-2">Transaksi tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-bb-1">Transaksi berhasil diubah !!!</div>

                                    <div class="row mt-2 d-none">
                                        <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-tgl" name="edt-dte-tgl" placeholder="" autocomplete="off"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Jlh</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-jlh" name="edt-txt-jlh" placeholder="" autocomplete="off"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket" name="edt-txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Jenis</span><span class="text-danger">*</span></div>
                                        <div class="col-9">
                                            <select name="edt-slct-jns" id="edt-slct-jns" class="custom-select">
                                                <option value="OUT">Kurang</option>
                                                <option value="IN">Tambah</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-sebb">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}
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