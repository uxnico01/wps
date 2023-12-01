<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 3;

    $ttl = "Transaksi - Retur Kirim";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - Retur Kirim | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 189, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 190, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nrkrm"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Retur Kirim</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-rkrm" placeholder="Cari Retur Kirim" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-rkrm"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-1 mb-2">

            <div class="table-responsive mxh-70vh">
                <table class="table table-sm table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top">No Retur</th>
                            <th class="border sticky-top">Tgl</th>
                            <th class="border sticky-top">Supplier</th>
                            <th class="border sticky-top">Dari P/O</th>
                            <th class="border sticky-top">Total Retur (KG)</th>
                            <th class="border sticky-top">Daftar Produk</th>
                            <th class="border sticky-top">Ket</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-rkrm">
                        <?php
                            $lst = getAllRKirim($db);

                            for ($i = 0; $i < count($lst); $i++) {
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][7])) echo number_format($lst[$i][7],2,'.',','); else echo number_format($lst[$i][7],0,'.',','); ?></td>
                                <td class="border small">
                                    <ul>
                                    <?php
                                        $dtl = getRKirimItem($lst[$i][0], $db);

                                        for($j = 0; $j < count($dtl); $j++)
                                        {
                                            $nama = $dtl[$j][3]." / ".$dtl[$j][4];

                                            if(strcasecmp($dtl[$j][5],"") != 0){
                                                $nama .= " / ".$dtl[$j][5];
                                            }

                                            if(strcasecmp($dtl[$j][6],"") != 0){
                                                $nama .= " / ".$dtl[$j][6];
                                            }

                                            $jlh = number_format($dtl[$j][2], 0, '.', ',');

                                            if(isDecimal($dtl[$j][2]))
                                                $jlh = number_format($dtl[$j][2], 2, '.', ',');
                                    ?>
                                        <li><?php echo $nama." (".$jlh." KG) ";?></li>
                                    <?php
                                        }
                                    ?>
                                    </ul>
                                </td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eRKrm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 192, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delRKrm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewRKrm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Retur Kirim" width="20"></button>
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
                    if (CekAksUser(substr($duser[7], 190, 1)))
                        require("./modals/mdl-nrkrm.php");

                    //if (CekAksUser(substr($duser[7], 191, 1))) {
                ?>
                    <div class="modal fade" id="mdl-erkrm" tabindex="-1" role="dialog" aria-labelledby="mdl-erkrm" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Retur Kirim</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-rkrm-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-rkrm-2">Data P/O tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-rkrm-3">Tidak terdapat produk yang di retur !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-rkrm-4">Retur tidak boleh melebihi jumlah kirim !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-rkrm-5">Data gudang tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-rkrm-1">Retur Kirim berhasil diubah !!!</div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-tgl" name="edt-dte-tgl" placeholder=""><input type="text" class="d-none" id="edt-txt-id"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Pilih PO</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="edt-txt-po" name="edt-txt-po" placeholder="" autocomplete="off" maxlength="100" readonly>

                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border btn-spo-cus" type="button" data-value="#mdl-erkrm"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                        </div>
                                                    </div>
                                                </div>
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

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket" name="edt-txt-ket" placeholder="" autocomplete="off" maxlength="250"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive my-2 mxh-60vh">
                                        <table class="table table-sm table-data2">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle">Produk</th>
                                                    <th class="border sticky-top align-middle text-right">Jlh Kirim (KG)</th>
                                                    <th class="border sticky-top align-middle text-right">Jlh Retur (KG)</th>
                                                    <th class="border sticky-top align-middle">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-erkrm">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-serkrm" data-count="">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}
                    require("./modals/mdl-vtran.php");
                    require("./modals/mdl-scus.php");
                    require("./modals/mdl-spo4.php");
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