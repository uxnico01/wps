<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 4;

    $ttl = "Proses - Cutting";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Cutting | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 67, 4)) && !cekAksUser(substr($duser[7],119,1)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 68, 1))) {
                    ?>
                        <!-- <button class="btn btn-outline-success m-1" id="btn-ncut"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Cutting</span></button> -->
                        <button class="btn btn-outline-success m-1" id="btn-ncut2"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Cutting</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-cut" placeholder="Cari Cutting" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-cut"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top text-right">Margin (%)</th>
                            <th class="border sticky-top text-right">Total Berat (KG)</th>
                            <th class="border sticky-top text-right">Total Cut (KG)</th>
                            <th class="border sticky-top text-right small">Total Cut Non-Vit (KG)</th>
                            <th class="border sticky-top text-right small">Total Cut Vit (KG)</th>
                            <th class="border sticky-top text-right small">Total Cut Tetelan, dll (KG)</th>
                            <th class="border sticky-top text-right small">Total Cut Tulang, dll (KG)</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-cut">
                        <?php
                            $lst = getAllCut();

                            for ($i = 0; $i < count($lst); $i++) {
                                $mdcl = 0;
                                if(isDecimal($lst[$i][2]))
                                    $mdcl = 2;

                                $wdcl = 0;
                                if(isDecimal($lst[$i][5]))
                                    $wdcl = 2;

                                $cdcl = 0;
                                if(isDecimal($lst[$i][6]))
                                    $cdcl = 2;

                                $tmrgn = "";
                                if(strcasecmp($lst[$i][7],"1") == 0)
                                    $tmrgn = "<";
                                else if(strcasecmp($lst[$i][7],"2") == 0)
                                    $tmrgn = ">";

                                $svit = $lst[$i][8]+$lst[$i][9]+$lst[$i][10]+$lst[$i][11]+$lst[$i][12]+$lst[$i][13];
                        ?>
                            <tr ondblclick="viewCut('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1])); ?></td>
                                <td class="border text-right"><?php echo $tmrgn." ".number_format($lst[$i][2], $mdcl, '.', ',');?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][5],$wdcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][6],$cdcl,'.',','); ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][6]-$svit)) echo number_format($lst[$i][6]-$svit,2,'.',','); else echo number_format($lst[$i][6]-$svit,0,'.',','); ?></td>
                                <td class="border text-right"><?php if(isDecimal($svit)) echo number_format($svit,2,'.',','); else echo number_format($svit,0,'.',','); ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][14])) echo number_format($lst[$i][14],2,'.',','); else echo number_format($lst[$i][14],0,'.',','); ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][15])) echo number_format($lst[$i][15],2,'.',','); else echo number_format($lst[$i][15],0,'.',','); ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][4])); ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eCut('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 70, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delCut('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }

                                        //if (CekAksUser(substr($duser[7], 119, 1)))
                                        {
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewCut('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Cutting" width="18"></button>
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
                <div class="modal fade" id="mdl-opt-cut" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-cut" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-cut">
                                </div>

                                <div class="my-2">
                                        <button class="btn btn-light border m-2" id="btn-view-cut" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Cutting" width="25"> <span>Lihat Cutting</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    //if (CekAksUser(substr($duser[7], 68, 1)))
                        //require("./modals/mdl-ncut.php");

                    //if (CekAksUser(substr($duser[7], 69, 1))) {
                ?>
                    <div class="modal fade" id="mdl-ecut" tabindex="-1" role="dialog" aria-labelledby="mdl-ecut" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-90p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Cutting</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1 pb-2">
                                    <div class="alert alert-danger d-none" id="div-edt-err-cut-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-cut-2">Tidak ada data yang di cutting !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-cut-3">Data cutting tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-cut-4">Data gudang tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-cut-5">Hasil tidak dapat melebihi bahan baku !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-cut-1">Cutting berhasil diubah !!!</div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="date" class="form-control inp-set" id="edt-dte-tgl" name="edt-dte-tgl" placeholder=""><input type="text" class="d-none" id="edt-txt-id"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Margin</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <select name="edt-slct-tmrgn" id="edt-slct-tmrgn" class="custom-select inp-jl">
                                                            <option value="1">Lebih Kecil</option>
                                                            <option value="2">Lebih Besar</option>
                                                        </select>

                                                        <input type="number" class="form-control inp-set" id="edt-txt-mrgn" name="edt-txt-mrgn" placeholder="" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
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
                                    </div>

                                    <hr>
                                    <h5 class="m-0">Hasil Potong</h5>
                                    <div class="table-responsive my-2 mxh-60vh" style="width: 100%;">
                                        <table class="table table-sm table-data2" style="width: 100%;">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle w-50px">No</th>
                                                    <th class="border sticky-top align-middle w-150px">Produk</th>
                                                    <th class="border sticky-top align-middle w-150px">Tgl Terima</th>
                                                    <th class="border sticky-top align-middle w-100px">Supplier</th>
                                                    <th class="border sticky-top align-middle text-right w-80px">Berat (KG)</th>
                                                    <th class="border sticky-top align-middle w-100px">Suhu</th>
                                                    <th class="border sticky-top align-middle w-80px">Premium</th>
                                                    <th class="border sticky-top align-middle w-80px">Cut1</th>
                                                    <th class="border sticky-top align-middle w-80px">Cut2</th>
                                                    <th class="border sticky-top align-middle w-80px">Cut3</th>
                                                    <th class="border sticky-top align-middle w-80px">Cut4</th>
                                                    <th class="border sticky-top align-middle d-none">Cut5</th>
                                                    <th class="border sticky-top align-middle d-none">Cut6</th>
                                                    <th class="border sticky-top align-middle w-100px">Ket</th>
                                                    <th class="border sticky-top align-middle w-70px">No Sample</th>
                                                    <th class="border sticky-top align-middle w-50px">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-ecut">

                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>
                                    <h5 class="m-0">Hasil Tetelan dan lainnya</h5>
                                    <div class="table-responsive my-2 mxh-40vh" style="width: 100%;">
                                        <table class="table table-sm" style="width: 100%;" id="tbl-cpro">
                                            <thead class="thead-dark" id="th-ecut-pro">
                                                <th class="border sticky-top mw-70p">Produk</th>
                                                <th class="border sticky-top text-right mw-30p">Berat</th>
                                            </thead>

                                            <tbody id="lst-ecut-pro">

                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>
                                    <h5 class="m-0">Hasil Tulang dan lainnya</h5>
                                    <div class="table-responsive my-2 mxh-40vh" style="width: 100%;">
                                        <table class="table table-sm" style="width: 100%;" id="tbl-cnpro">
                                            <thead class="thead-dark" id="th-ecut-npro">
                                                <th class="border sticky-top mw-70p">Produk</th>
                                                <th class="border sticky-top text-right mw-30p">Berat</th>
                                            </thead>

                                            <tbody id="lst-ecut-npro">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-secut" data-count="" data-ccpro="" data-ccnpro="">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}

                    require("./modals/mdl-vtran.php");
                    require("./modals/mdl-strm2.php");
                    require("./modals/mdl-spro.php");
                    require("./modals/mdl-ssup.php");
                    require("./modals/mdl-spro7.php");
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