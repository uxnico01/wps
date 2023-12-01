<?php
    require("./bin/php/clsfunction.php");

    $nav = 3;

    $ttl = "Transaksi - Peminjaman";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - Peminjaman | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 52, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 53, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-npjm"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Peminjaman</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-pjm" placeholder="Cari Peminjaman" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-pjm"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top text-right">Jlh</th>
                            <th class="border sticky-top text-right">Pot Lain</th>
                            <th class="border sticky-top text-right">Bayar</th>
                            <th class="border sticky-top text-right">Sisa</th>
                            <th class="border sticky-top">Ket 1</th>
                            <th class="border sticky-top">Ket 2</th>
                            <th class="border sticky-top">Ket 3</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-pjm">
                        <?php
                            $lst = getAllPjm();

                            for ($i = 0; $i < count($lst); $i++) {
                                $sup = getSupID($lst[$i][1]);

                                $tdcl = 0;
                                if(isDecimal($lst[$i][3]))
                                    $tdcl = 2;

                                $bdcl = 0;
                                if(isDecimal($lst[$i][4]))
                                    $bdcl = 2;

                                $sisa = $lst[$i][3]-$lst[$i][4]-$lst[$i][10];
                        ?>
                            <tr ondblclick="viewPjm('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo $sup[1]; ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][3],$tdcl,'.',','); ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][10])) echo number_format($lst[$i][10],2,'.',','); else echo number_format($lst[$i][10],0,'.',',');?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][4],$bdcl,'.',','); ?></td>
                                <td class="border text-right"><?php if(isDecimal($sisa)) echo number_format($sisa,2,'.',','); else echo number_format($sisa,0,'.',',');?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border"><?php echo $lst[$i][7]; ?></td>
                                <td class="border"><?php echo $lst[$i][8]; ?></td>
                                <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][9])); ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="ePjm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 55, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delPjm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewPjm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Peminjaman" width="20"></button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="lmodals">
                <div class="modal fade" id="mdl-opt-pjm" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-pjm" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-pjm">
                                </div>

                                <div class="my-2">
                                    <button class="btn btn-light border m-2" id="btn-view-pjm" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Peminjaman" width="25"> <span>Lihat Peminjaman</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 27, 1)))
                        require("./modals/mdl-npjm.php");

                    //if (CekAksUser(substr($duser[7], 28, 1))) {
                ?>
                    <div class="modal fade" id="mdl-epjm" tabindex="-1" role="dialog" aria-labelledby="mdl-epjm" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Peminjaman</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-pjm-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pjm-2">Terdapat data peminjaman dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pjm-3">Data supplier tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pjm-4">Data peminjaman tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-pjm-1">Peminjaman berhasil diubah !!!</div>

                                    <div class="row mt-2 d-none">
                                        <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Supplier</span><span class="text-danger">*</span></div>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control inp-set" id="edt-txt-nma-sup" name="edt-txt-nma-sup" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                <input type="text" class="d-none" id="edt-txt-sup">

                                                <div class="input-group-append">
                                                    <button class="btn btn-light border" type="button" data-value="#mdl-epjm" data-target="#mdl-ssup" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="col-3 mt-1"><span class="h6">Pot Lain</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-pot" name="edt-txt-pot" placeholder="" autocomplete="off"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket1" name="edt-txt-ket1" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Ket 2</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket2" name="edt-txt-ket2" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Ket 3</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket3" name="edt-txt-ket3" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-sepjm">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}

                    require("./modals/mdl-ssup.php");
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