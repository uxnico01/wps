<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 4;

    $ttl = "Proses - Packaging";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Packaging | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 57, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 58, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nkrm"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Packaging</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-krm" placeholder="Cari Packaging" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-krm"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-1 mb-2">

            <div class="table-responsive mxh-70vh">
                <table class="table table-sm table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top">Tgl</th>
                            <th class="border sticky-top text-right">Total (KG)</th>
                            <th class="border sticky-top d-none">Ket 1</th>
                            <th class="border sticky-top d-none">Ket 2</th>
                            <th class="border sticky-top d-none">Ket 3</th>
                            <th class="border sticky-top">Hasil</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-krm">
                        <?php
                            $lst = getAllKirim();

                            for ($i = 0; $i < count($lst); $i++) {
                                $tdcl = 0;
                                if(isDecimal($lst[$i][7]))
                                    $tdcl = 2;
                        ?>
                            <tr ondblclick="viewKrm('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1])); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][7],$tdcl,'.',','); ?></td>
                                <td class="border d-none"><?php echo $lst[$i][2]; ?></td>
                                <td class="border d-none"><?php echo $lst[$i][3]; ?></td>
                                <td class="border d-none"><?php echo $lst[$i][4]; ?></td>
                                <td class="border small">
                                    <ul>
                                    <?php
                                        $dtl = getKirimItem3($lst[$i][0]);

                                        for($j = 0; $j < count($dtl); $j++)
                                        {
                                            $jlh = number_format($dtl[$j][4], 0, '.', ',');

                                            if(isDecimal($dtl[$j][4]))
                                                $jlh = number_format($dtl[$j][4], 2, '.', ',');
                                    ?>
                                        <li><?php echo $dtl[$j][0]; if(strcasecmp($dtl[$j][1],"") != 0) echo " / ".$dtl[$j][1]; if(strcasecmp($dtl[$j][2],"") != 0) echo " / ".$dtl[$j][2]; if(strcasecmp($dtl[$j][3],"") != 0) echo " / ".$dtl[$j][3]; echo " (".$jlh.") [<strong>".$dtl[$j][5]."</strong>]"?></li>
                                    <?php
                                        }
                                    ?>
                                    </ul>
                                </td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][6])); ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eKrm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 60, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delKrm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewKrm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Packaging" width="20"></button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="lmodals">
                <div class="modal fade" id="mdl-opt-krm" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-krm" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-krm">
                                </div>

                                <div class="my-2">
                                        <button class="btn btn-light border m-2" id="btn-view-krm" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Packaging" width="25"> <span>Lihat Packaging</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 58, 1)))
                        require("./modals/mdl-nkrm.php");

                    //if (CekAksUser(substr($duser[7], 59, 1))) {
                ?>
                    <div class="modal fade" id="mdl-ekrm" tabindex="-1" role="dialog" aria-labelledby="mdl-ekrm" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Packaging</h5>
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

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-none">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket1</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket1" name="edt-txt-ket1" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-none">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket2</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket2" name="edt-txt-ket2" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-none">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket3</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket3" name="edt-txt-ket3" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 my-2 px-0">
                                        <button class="btn btn-light border border-success" id="btn-ekrm-pro" data-dismiss="modal"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Pilih Produk</span></button>
                                    </div>
                                    
                                    <div class="table-responsive my-2 mxh-60vh">
                                        <table class="table table-sm table-data2">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle w-100px">No P/O</th>
                                                    <th class="border sticky-top align-middle w-120px">Produk</th>
                                                    <th class="border sticky-top align-middle w-120px">Qty</th>
                                                    <th class="border sticky-top align-middle w-100px">Tgl Exp</th>
                                                    <th class="border sticky-top align-middle text-right w-80px">Berat</th>
                                                    <th class="border sticky-top align-middle w-100px">Keterangan</th>
                                                    <th class="border sticky-top"></th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-ekrm">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="alert alert-danger d-none" id="div-edt-err-krm-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-krm-2">Terdapat data pengiriman dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-krm-3">Data customer tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-krm-4">Harap masukkan produk !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-krm-5">Data packaging tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-krm-6">Data Gudang tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-krm-7">Terdapat berat produk yang tidak mencukupi !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-krm-1">Packaging berhasil diubah !!!</div>

                                    <button type="button" class="btn btn-primary" id="btn-sekrm">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}

                    require("./modals/mdl-scus.php");
                    require("./modals/mdl-nkrm-pro.php");
                    require("./modals/mdl-spro.php");
                    require("./modals/mdl-spro3.php");
                    require("./modals/mdl-spo.php");
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