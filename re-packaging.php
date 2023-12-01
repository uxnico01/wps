<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 4;

    $ttl = "Proses - Re-Packaging";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Re-Packaging | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 172, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 173, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nrpkg"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Re-Packaging</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-rpkg" placeholder="Cari Re-Packaging" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-rpkg"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">Produk Awal</th>
                            <th class="border sticky-top text-right">Berat Awal (KG)</th>
                            <th class="border sticky-top text-right">Berat Hasil (KG)</th>
                            <th class="border sticky-top">Keterangan</th>
                            <th class="border sticky-top">Hasil</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-rpkg">
                        <?php
                            $lst = getAllRPkg($db);
                            
                            for ($i = 0; $i < count($lst); $i++) {
                                $dtl = getRPkgItem($lst[$i][8], $db);
                                $nma = $lst[$i][1]." / ".$lst[$i][2];

                                if(strcasecmp($lst[$i][3],"") != 0){
                                    $nma .= " / ".$lst[$i][3];
                                }

                                if(strcasecmp($lst[$i][4],"") != 0){
                                    $nma .= " / ".$lst[$i][4];
                                }
                        ?>
                            <tr ondblclick="viewRPkg('<?php echo UE64($lst[$i][8]);?>')">
                                <td class="border"><?php echo $lst[$i][0];?></td>
                                <td class="border"><?php echo $nma;?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][5])) echo number_format($lst[$i][5],2,'.',','); else echo number_format($lst[$i][5],0,'.',','); ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][9])) echo number_format($lst[$i][9],2,'.',','); else echo number_format($lst[$i][9],0,'.',','); ?></td>
                                <td class="border"><?php echo $lst[$i][10];?></td>
                                <td class="border small">
                                    <ul>
                                    <?php
                                        for($j = 0; $j < count($dtl); $j++){
                                            $nma = $dtl[$j][4]." / ".$dtl[$j][5];

                                            if(strcasecmp($dtl[$j][6],"") != 0){
                                                $nma .= " / ".$dtl[$j][6];
                                            }
                                            
                                            if(strcasecmp($dtl[$j][7],"") != 0){
                                                $nma .= " / ".$dtl[$j][7];
                                            }
                                    ?>
                                        <li><?php echo $nma; echo " ("; if(isDecimal($dtl[$j][2])) echo number_format($dtl[$j][2],2,'.',','); else echo number_format($dtl[$j][2],0,'.',','); echo ")";?></li>
                                    <?php
                                        }
                                    ?>
                                    </ul>
                                </td>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border"><?php echo $lst[$i][7]; ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eRPkg('<?php echo UE64($lst[$i][8]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 175, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delRPkg('<?php echo UE64($lst[$i][8]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewRPkg('<?php echo UE64($lst[$i][8]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Re-Packaging" width="20"></button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="lmodals">
                <div class="modal fade" id="mdl-opt-rpkg" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-rpkg" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-rpkg">
                                </div>

                                <div class="my-2">
                                        <button class="btn btn-light border m-2" id="btn-view-rpkg" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Re-Packaging" width="25"> <span>Lihat Re-Packaging</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 173, 1)))
                        require("./modals/mdl-nrpkg.php");

                    //if (CekAksUser(substr($duser[7], 174, 1))) {
                ?>
                <div class="modal fade" id="mdl-erpkg" tabindex="-1" role="dialog" aria-labelledby="mdl-erpkg" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ralat Re-Packing</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                
                            <div class="modal-body pt-1">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="row mt-2">
                                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                                            <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-tgl" name="edt-dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="row mt-2">
                                            <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                                            <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket" name="edt-txt-ket" placeholder="" value="" maxlength="250"></div>
                                        </div>
                                    </div>
                                </div><hr>
                
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="row mt-2">
                                            <div class="col-3 mt-1"><span class="h6">Bahan Baku</span><span class="text-danger">*</span></div>
                                            <div class="col-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control inp-set" id="edt-txt-nma-pro" name="edt-txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                    <input type="text" class="d-none" id="edt-txt-pro">
                
                                                    <div class="input-group-append">
                                                        <button class="btn btn-light border btn-spro2" type="button" data-value="#mdl-erpkg" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-2">
                                            <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                                            <div class="col-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="edt-txt-nma-grade" name="edt-txt-nma-grade" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-2">
                                            <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                                            <div class="col-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="edt-txt-nma-kate" name="edt-txt-nma-kate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        
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
                                            <div class="col-3 mt-1"><span class="h6">Berat</span><span class="text-danger">*</span></div>
                                            <div class="col-9"><input type="number" class="form-control inp-set" id="edt-txt-weight-pro" name="edt-txt-weight-pro" placeholder="" autocomplete="off" step="any"></div>
                                        </div>
                                    </div>
                                </div><hr>
                
                                <div class="col-12 my-2 p-0">
                                    <button class="btn btn-light border border-success btn-rpkg-pro" id="btn-erpkg-pro"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Tambah Produk</span></button>
                                </div>
                
                                <div class="table-responsive my-2 mxh-60vh">
                                    <table class="table table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="border sticky-top align-middle">Produk</th>
                                                <th class="border sticky-top align-middle text-right">Berat</th>
                                                <th class="border sticky-top"></th>
                                            </tr>
                                        </thead>
                
                                        <tbody id="lst-erpkg">
                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                
                            <div class="modal-footer">
                                <div class="alert alert-danger mb-0 mr-2 d-none" id="edt-div-err-rpkg-1">Harap isi semua data dengan tanda * !!!</div>
                
                                <div class="alert alert-danger mb-0 mr-2 d-none" id="edt-div-err-rpkg-2">Data produk awal tidak dapat ditemukan !!!</div>
                
                                <div class="alert alert-danger mb-0 mr-2 d-none" id="edt-div-err-rpkg-3">Tidak terdapat hasil produk !!!</div>
                
                                <div class="alert alert-danger mb-0 mr-2 d-none" id="edt-div-err-rpkg-4">Proses re-packing tidak dapat ditemukan !!!</div>
                
                                <div class="alert alert-danger mb-0 mr-2 d-none" id="edt-div-err-rpkg-5">Berat Produk awal tidak mencukupi !!!</div>

                                <div class="alert alert-danger mb-0 mr-2 d-none" id="edt-div-err-rpkg-6">Hasil tidak boleh lebih besar dari produk awal !!!</div>
                
                                <div class="alert alert-success mb-0 mr-2 d-none" id="edt-div-scs-rpkg-1">Re-Packing berhasil ditambahkan !!!</div>
                
                                <button type="button" class="btn btn-primary" id="btn-serpkg" data-count="0">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                //}

                    require("./modals/mdl-spro2.php");
                    require("./modals/mdl-spro5.php");
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