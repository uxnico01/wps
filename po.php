<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 2;

    $ttl = "Data - P/O";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data - P/O | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 123, 4)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 124, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-npo"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah P/O</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="txt-srch-po" placeholder="Cari P/O" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-po"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">Tgl Kirim</th>
                            <th class="border sticky-top text-right">Qty (KG)</th>
                            <th class="border sticky-top">Customer</th>
                            <th class="border sticky-top">Ket1</th>
                            <th class="border sticky-top">Ket2</th>
                            <th class="border sticky-top">No TT Gudang</th>
                            <th class="border sticky-top">Tampil</th>
                            <th class="border sticky-top">Status</th>
                            <th class="border sticky-top">No Pengeluaran</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-po">
                        <?php
                            $lst = getAllPO();

                            for ($i = 0; $i < count($lst); $i++) {
                                $cus = getCusID($lst[$i][1]);

                                $stl = "text-danger";
                                if(strcasecmp($lst[$i][8],"Sudah Kirim") == 0)
                                    $stl = "text-success";
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][2])); ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][9])) echo number_format($lst[$i][9],2,'.',','); else echo number_format($lst[$i][9],0,'.',','); ?></td>
                                <td class="border"><?php echo $cus[1]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border <?php echo $stl;?>"><?php echo $lst[$i][8]; ?></td>
                                <td class="border"><?php echo $lst[$i][10]; ?></td>
                                <td class="border mw-15p">
                                    <?php
                                        if (CekAksUser(substr($duser[7], 125, 1))) {
                                    ?>
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="ePO('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        }

                                        if (CekAksUser(substr($duser[7], 126, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delPO('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }

                                        /*if(strcasecmp($lst[$i][8],"Sudah Kirim") == 0)
                                        {
                                    ?>
                                        <button class="btn btn-light border-primary mb-1 p-1" onclick="unSendPO('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/unsend-icon.png" alt="Kirim" width="18"></button>
                                    <?php
                                        }
                                        else*/
                                        if(strcasecmp($lst[$i][11],"NS") == 0)
                                        {
                                    ?>
                                        <button class="btn btn-light border-primary mb-1 p-1" onclick="setSendPO('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/send-icon.png" alt="Kirim" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                    <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewPO('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat PO" width="20"></button>
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
                if (CekAksUser(substr($duser[7], 123, 1)))
                    require("./modals/mdl-npo.php");

                if (CekAksUser(substr($duser[7], 124, 1))) {
                ?>
                    <div class="modal fade" id="mdl-epo" tabindex="-1" role="dialog" aria-labelledby="mdl-epo" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat P/O</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-po-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-po-2">Terdapat data po dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-po-3">Data customer tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-po-4">Data po tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-po-1">P/O berhasil diubah !!!</div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Tgl Kirim</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-tgl" name="edt-dte-tgl" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Qty (KG)</span></div>
                                        <div class="col-9"><input type="text" class="form-control cformat inp-set" id="edt-txt-qty" name="edt-txt-qty" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Customer</span><span class="text-danger">*</span></div>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="edt-txt-nma-cus" name="edt-txt-nma-cus" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                <input type="text" class="d-none" id="edt-txt-cus">

                                                <div class="input-group-append">
                                                    <button class="btn btn-light border" type="button" data-value="#mdl-epo" data-target="#mdl-scus" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="col-3 mt-1"><span class="h6">Tampil</span></div>
                                        <div class="col-9">
                                            <select name="edt-slct-tmpl" id="edt-slct-tmpl" class="custom-select">
                                                <option value="Y">Tampil</option>
                                                <option value="N">Tidak Tampil</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2 d-none">
                                        <div class="col-3 mt-1"><span class="h6">Tampil Sampai Tgl</span></div>
                                        <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-dtgl" name="edt-dte-dtgl" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-sepo">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                    require("./modals/mdl-scus.php");
                    require("./modals/mdl-sspo.php");
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