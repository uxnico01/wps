<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 4;

    $ttl = "Proses - Sawing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Sawing | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 75, 4)) && !cekAksUser(substr($duser[7],121,1)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 76, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nsaw"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Sawing</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-saw" placeholder="Cari Sawing" autocomplete="off">
                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-saw"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">Bahan Sjd</th>
                            <th class="border sticky-top">Grade</th>
                            <th class="border sticky-top">Oz</th>
                            <th class="border sticky-top">Cut Style</th>
                            <th class="border sticky-top">Tahap Ke</th>
                            <th class="border sticky-top">Ket</th>
                            <th class="border sticky-top text-right">Berat (KG)</th>
                            <th class="border sticky-top text-right">Total (KG)</th>
                            <th class="border sticky-top">Hasil</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-saw">
                        <?php
                            $lst = getAllSaw();

                            for ($i = 0; $i < count($lst); $i++) {
                                $wdcl = 0;
                                if(isDecimal($lst[$i][4]))
                                    $wdcl = 2;

                                $mdcl = 0;
                                if(isDecimal($lst[$i][6]))
                                    $mdcl = 2;

                                $tdcl = 0;
                                if(isDecimal($lst[$i][8]))
                                    $tdcl = 2;
                                    
                                $pro = getProID($lst[$i][3]);
                                $grade = getGradeID($pro[4]);
                                $kate = getKateID($pro[2]);
                                $skate = getSKateID($pro[3]);
                        ?>
                            <tr ondblclick="viewSaw('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1])); ?></td>
                                <td class="border"><?php echo $pro[1];?></td>
                                <td class="border"><?php echo $grade[1];?></td>
                                <td class="border"><?php echo $kate[1];?></td>
                                <td class="border"><?php echo $skate[1];?></td>
                                <td class="border text-right"><?php if(strcasecmp($lst[$i][9],"0") == 0) echo ""; else echo $lst[$i][9];?></td>
                                <td class="border text-right"><?php echo $lst[$i][10];?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][4],$wdcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][8],$tdcl,'.',','); ?></td>
                                <td class="border small">
                                    <ul>
                                    <?php
                                        $dtl = getSawItem3($lst[$i][0]);

                                        for($j = 0; $j < count($dtl); $j++)
                                        {
                                            $jlh = number_format($dtl[$j][4], 0, '.', ',');

                                            if(isDecimal($dtl[$j][4]))
                                                $jlh = number_format($dtl[$j][4], 2, '.', ',');
                                    ?>
                                        <li><?php echo $dtl[$j][0]; if(strcasecmp($dtl[$j][1],"") != 0) echo " / ".$dtl[$j][1]; if(strcasecmp($dtl[$j][2],"") != 0) echo " / ".$dtl[$j][2]; if(strcasecmp($dtl[$j][3],"") != 0) echo " / ".$dtl[$j][3]; echo " (".$jlh.") "?></li>
                                    <?php
                                        }
                                    ?>
                                    </ul>
                                </td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][5])); ?></td>
                                <td class="border mw-15p">
                                    <?php
                                        if ($lst[$i][11] <= 3) {
                                    ?>
                                        <!-- <?php echo $lst[$i][11] ?> -->
                                        <!-- <?php echo $cond_rebalancing ?> -->
                                        <button class="btn btn-light border-success mb-1 p-1" onclick="reBlcSaw('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/balance-icon.png" alt="Balancing" width="18"></button>
                                    <?php } ?>

                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eSaw('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 78, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delSaw('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                        
                                        //if (CekAksUser(substr($duser[7], 121, 1)))
                                        {
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewSaw('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Sawing" width="18"></button>
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
                <div class="modal fade" id="mdl-opt-saw" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-saw" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-saw">
                                </div>

                                <div class="my-2">
                                        <button class="btn btn-light border m-2" id="btn-view-saw" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Sawing" width="25"> <span>Lihat Sawing</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 76, 1)))
                        require("./modals/mdl-nsaw.php");

                    //if (CekAksUser(substr($duser[7], 77, 1))) {
                ?>
                    <div class="modal fade" id="mdl-esaw" tabindex="-1" role="dialog" aria-labelledby="mdl-esaw" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Sawing</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-tgl" name="edt-dte-tgl" placeholder=""><input type="text" class="d-none" id="edt-txt-id"></div>
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
                                                <div class="col-3 mt-1"><span class="h6">Margin</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <select name="edt-slct-tmrgn" id="edt-slct-tmrgn" class="custom-select inp-jl">
                                                            <option value="1">Lebih Besar</option>
                                                            <option value="2">Lebih Kecil</option>
                                                        </select>

                                                        <input type="number" class="form-control inp-set" id="edt-txt-mrgn" name="edt-txt-mrgn" placeholder="" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Bahan Baku</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set" id="edt-txt-nma-pro" name="edt-txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                        <input type="text" class="d-none" id="edt-txt-pro">

                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border btn-spro2" type="button" data-value="#mdl-esaw" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="edt-txt-nma-grade" name="edt-txt-nma-grade" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="edt-txt-nma-kate" name="edt-txt-nma-kate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="edt-txt-nma-skate" name="edt-txt-nma-skate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Berat (KG)</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="number" class="form-control inp-set" id="edt-txt-weight-pro" name="edt-txt-weight-pro" placeholder="" autocomplete="off" step="any"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tahap Ke</span></div>
                                                <div class="col-9"><input type="number" class="form-control inp-set" id="edt-txt-thp" name="edt-txt-thp" placeholder="" autocomplete="off" step="1" max="100"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket" name="edt-txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 my-2 p-0">
                                        <button class="btn btn-light border border-success" data-toggle="modal" data-target="#mdl-npro-saw" data-keyboard="false" data-backdrop="static" data-dismiss="modal"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Pilih Produk</span></button>
                                    </div>
                                    
                                    <div class="table-responsive my-2 mxh-60vh">
                                        <table class="table table-sm table-data2">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle">Produk</th>
                                                    <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                                                    <th class="border sticky-top align-middle">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-esaw">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-saw-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-saw-2">Data bahan tidak ditemukan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-saw-3">Data sawing tidak ditemukan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-saw-4">Data bahan tidak boleh kosong !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-saw-5">Data gudang tidak ditemukan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-saw-6">Bahan baku tidak mencukupi !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-saw-7">Hasil tidak boleh melebihi bahan baku !!!</div>

                                    <div class="alert alert-success mb-0 mr-2 d-none" id="div-edt-scs-saw-1">Sawing berhasil diubah !!!</div>

                                    <button type="button" class="btn btn-primary" id="btn-sesaw" data-count="">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}
                    require("./modals/mdl-vtran.php");
                    require("./modals/mdl-npro-saw.php");
                    require("./modals/mdl-spro2.php");
                    require("./modals/mdl-spro3.php");
                    require("./modals/mdl-rbsaw.php");
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