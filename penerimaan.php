<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 4;

    $ttl = "Proses - Penerimaan";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Penerimaan | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 62, 5)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 63, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1 d-none" id="btn-ntrm"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Penerimaan</span></button>
                        <button class="btn btn-outline-success m-1" id="btn-ntrm2"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Penerimaan</span></button>
                        <button class="btn btn-outline-success m-1" id="btn-nmtrm"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Minum</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-1 offset-xl-2 col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 py-1">
                    <div class="input-group">
                        <div class="input-group-preppend d-none">
                            <button class="btn btn-light border btn-vttrm" data-value=""><img src="./bin/img/icon/temporary-icon.png" alt="Temporary" width="20"></button>
                        </div>

                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-trm" placeholder="Cari Penerimaan" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-trm"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top text-right">BB</th>
                            <th class="border sticky-top text-right">Poto</th>
                            <th class="border sticky-top text-right">Dll</th>
                            <th class="border sticky-top text-right">Minus</th>
                            <th class="border sticky-top text-right">DP</th>
                            <th class="border sticky-top text-right">Pot Lain</th>
                            <th class="border sticky-top text-right">Tbh Lain</th>
                            <th class="border sticky-top text-right">Minum</th>
                            <th class="border sticky-top text-right">Berat (KG)</th>
                            <th class="border sticky-top text-right">Ekor</th>
                            <th class="border sticky-top">Ket 1</th>
                            <th class="border sticky-top text-right">Total Simpanan</th>
                            <th class="border sticky-top d-none">Ket 2</th>
                            <th class="border sticky-top d-none">Ket 3</th>
                            <th class="border sticky-top">Kota</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-trm">
                        <?php
                            $lst = getAllTrm();

                            for ($i = 0; $i < count($lst); $i++) {
                                $smpn = getSumSupSmpn2($lst[$i][1], $lst[$i][2]);
                                $sup = getSupID($lst[$i][1]);

                                $bb = $lst[$i][14] * getSumTrmID($lst[$i][0]);

                                if($lst[$i][3] != 0)
                                    $bb = $lst[$i][3];

                                $bbdcl = 0;
                                if(isDecimal($bb))
                                    $bbdcl = 2;

                                $pdcl = 0;
                                if(isDecimal($lst[$i][4]))
                                    $pdcl = 2;

                                $ddcl = 0;
                                if(isDecimal($lst[$i][11]))
                                    $ddcl = 2;

                                $dpdcl = 0;
                                if(isDecimal($lst[$i][13]))
                                    $dpdcl = 2;

                                $mdcl = 0;
                                if(isDecimal($lst[$i][15]))
                                    $mdcl = 2;

                                $dpddcl = 0;
                                if(isDecimal($lst[$i][16]))
                                    $dpddcl = 2;

                                $tdcl = 0;
                                if(isDecimal($lst[$i][4]))
                                    $tdcl = 2;

                                $dtddcl = 0;
                                if(isDecimal($lst[$i][17]))
                                    $dtddcl = 2;

                                $dmnm = 0;
                                if(isDecimal($lst[$i][18]))
                                    $dmnm = 2;
                        ?>
                            <tr ondblclick="viewTrm('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][2])); ?></td>
                                <td class="border"><?php echo $sup[1]; ?></td>
                                <td class="border text-right"><?php echo number_format($bb,$bbdcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][4],$pdcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][11],$ddcl,'.',','); if(strcasecmp($lst[$i][12],"") != 0 && $lst[$i][11] != 0) echo " (".$lst[$i][12].")";?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][15],$mdcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][13],$dpdcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][16],$dpddcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][17],$dtddcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][18],$dmnm,'.',','); ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][19])) echo number_format($lst[$i][19],2,'.',','); else echo number_format($lst[$i][19], 0, '.',','); ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][20])) echo number_format($lst[$i][20],2,'.',','); else echo number_format($lst[$i][20], 0, '.',','); ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border text-right"><?php if(isDecimal($smpn)) echo number_format($smpn,2,'.',','); else echo number_format($smpn, 0, '.',','); ?></td>
                                <td class="border d-none"><?php echo $lst[$i][6]; ?></td>
                                <td class="border d-none"><?php echo $lst[$i][7]; ?></td>
                                <td class="border"><?php echo $lst[$i][10]; ?></td>
                                <td class="border"><?php echo $lst[$i][8]; ?></td>
                                <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][9])); ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eTrm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 65, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delTrm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewTrm('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Penerimaan" width="20"></button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="lmodals">
                <div class="modal fade" id="mdl-opt-trm" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-trm" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-trm">
                                </div>

                                <div class="my-2">
                                        <button class="btn btn-light border m-2" id="btn-view-trm" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Penerimaan" width="25"> <span>Lihat Penerimaan</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 63, 1)))
                    {
                        require("./modals/mdl-npnrm.php");
                        require("./modals/mdl-nmpnrm.php");
                    }

                    //if (CekAksUser(substr($duser[7], 64, 1))) {
                ?>
                    <div class="modal fade" id="mdl-etrm" tabindex="-1" role="dialog" aria-labelledby="mdl-etrm" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-80p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Penerimaan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-trm-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-trm-2">Terdapat data penerimaan dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-trm-3">Data supplier tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-trm-4">Potongan tidak boleh melebihi pinjaman !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-trm-5">Harap masukkan produk yang diterima !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-trm-6">Data penerimaan tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-trm-7">Data Gudang tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-trm-1">Penerimaan berhasil diubah !!!</div>

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
                                                <div class="col-3 mt-1"><span class="h6">Supplier</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set" id="edt-txt-nma-sup" name="edt-txt-nma-sup" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                        <input type="text" class="d-none" id="edt-txt-sup">

                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border" type="button" data-value="#mdl-etrm" data-target="#mdl-ssup" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket1</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket1" name="edt-txt-ket1" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket2</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket2" name="edt-txt-ket2" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket3</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket3" name="edt-txt-ket3" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Kota</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-kota" name="edt-txt-kota" placeholder="" autocomplete="off" maxlength="50"></div>
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
                                    </div>

                                    <div class="col-12 my-2 p-0">
                                        <button class="btn btn-light border border-success btn-trm-pro" id="btn-etrm-pro" data-dismiss="modal"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Pilih Produk</span></button>
                                    </div>
                                    
                                    <div class="table-responsive my-2 mxh-60vh">
                                        <table class="table table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle">Produk</th>
                                                    <th class="border sticky-top align-middle">Grade</th>
                                                    <th class="border sticky-top align-middle">Oz</th>
                                                    <th class="border sticky-top align-middle">Cut Style</th>
                                                    <th class="border sticky-top align-middle">Satuan</th>
                                                    <th class="border sticky-top align-middle text-right">Berat</th>
                                                    <th class="border sticky-top align-middle text-right">Harga</th>
                                                    <th class="border sticky-top align-middle text-right">Simpanan</th>
                                                    <th class="border sticky-top"></th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-etrm">

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="table-responsive my-2">
                                        <table class="table table-sm table-striped mb-0">
                                            <thead class="thead-dark" id="th-setrm">

                                            </thead>

                                            <tbody id="lst-sepnrm">

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row border-top py-2 mt-3">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">BB</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-bb" name="edt-txt-bb" placeholder="" autocomplete="off"></div>

                                                <div class="col-3 mt-1"><span class="h6">BB (Satuan)</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set cformat" id="edt-txt-bb2" name="edt-txt-bb2" placeholder="" autocomplete="off">
                                                        <input type="text" class="form-control inp-set cformat" id="edt-txt-vbb" name="edt-txt-vbb" placeholder="" autocomplete="off" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Poto</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-poto" name="edt-txt-poto" placeholder="" autocomplete="off" data-value=""> <span class="text-danger small" id="edt-spn-poto"></span></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">DLL</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set cformat" id="edt-txt-dll" name="edt-txt-dll" placeholder="" autocomplete="off" maxlength="50" readonly>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border btn-ldll" type="button" data-value="#mdl-etrm" data-target="#mdl-ldll" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-dismiss="modal"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control d-none" id="edt-txt-vdll" name="edt-txt-vdll" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Poto Lainnya</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set cformat" id="edt-txt-pdll" name="edt-txt-pdll" placeholder="" autocomplete="off" maxlength="50" readonly>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border btn-lpdll" type="button" data-value="#mdl-etrm" data-target="#mdl-lpdll" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-dismiss="modal"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control d-none" id="edt-txt-vpdll" name="edt-txt-vpdll" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Minum</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-mnm" name="edt-txt-mnm" placeholder="" autocomplete="off" maxlength="50"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">DP</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set cformat" id="edt-txt-dp" name="edt-txt-dp" placeholder="" autocomplete="off" maxlength="50">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border btn-ldp" type="button" data-value="#mdl-etrm" data-target="#mdl-ldp" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-dismiss="modal"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="offset-md-6 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Minus</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-min" name="edt-txt-min" placeholder="" autocomplete="off" maxlength="50"></div>
                                            </div>
                                        </div>

                                        <div class="offset-md-6 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tambahan Lainnya</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set cformat" id="edt-txt-tdll" name="edt-txt-tdll" placeholder="" autocomplete="off" maxlength="50" readonly>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border btn-ltdll" type="button" data-value="#mdl-etrm" data-target="#mdl-ltdll" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-dismiss="modal"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control d-none" id="edt-txt-vtdll" name="edt-txt-vtdll" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-setrm">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}

                    require("./modals/mdl-npnrm-pro.php");
                    require("./modals/mdl-epnrm-pro.php");
                    require("./modals/mdl-spro2.php");
                    require("./modals/mdl-ssup.php");
                    require("./modals/mdl-vtran.php");
                    require("./modals/mdl-vdll.php");
                    require("./modals/mdl-ldll.php");
                    require("./modals/mdl-lpdll.php");
                    require("./modals/mdl-ltmp-pnrm.php");
                    require("./modals/mdl-ldp.php");
                    require("./modals/mdl-ltdll.php");
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