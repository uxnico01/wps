<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 4;

    $ttl = "Proses - Vacuum";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Vacuum | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 71, 4)) && !cekAksUser(substr($duser[7],120,1)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 72, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nvac"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Vacuum</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-vac" placeholder="Cari Vacuum" autocomplete="off">
                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-vac"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">Tgl Cut</th>
                            <th class="border sticky-top">Bahan Sjd</th>
                            <th class="border sticky-top">Tahap Ke</th>
                            <th class="border sticky-top">Ket</th>
                            <th class="border sticky-top text-right">Berat (KG)</th>
                            <th class="border sticky-top text-right">Hasil (KG)</th>
                            <th class="border sticky-top">Hasil</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-vac">
                        <?php
                            $lst = getAllVac();

                            for ($i = 0; $i < count($lst); $i++) {
                                $weight = $lst[$i][6] + $lst[$i][16];

                                if(strcasecmp($lst[$i][2], "1") == 0 && strcasecmp($lst[$i][14],"0") != 0)
                                {
                                    if(strcasecmp($lst[$i][14],"1") == 0)
                                        $weight = $lst[$i][6]-$lst[$i][13]-$lst[$i][17];
                                    else
                                        $weight = $lst[$i][13];
                                }

                                $wdcl = 0;
                                if(isDecimal($weight))
                                    $wdcl = 2;

                                $mdcl = 0;
                                if(isDecimal($lst[$i][8]))
                                    $mdcl = 2;

                                $tdcl = 0;
                                if(isDecimal($lst[$i][10]))
                                    $tdcl = 2;

                                $nmpro = "";
                                $nmpro2 = "";
                                if(strcasecmp($lst[$i][5],"") != 0)
                                {
                                    $pro = getProID($lst[$i][5]);
                                    $grade = getGradeID($pro[4]);
                                    $kate = getKateID($pro[2]);
                                    $skate = getSKateID($pro[3]);
                                    $nmpro = "<li>".$pro[1];

                                    if(strcasecmp($grade[1],"") != 0)
                                        $nmpro .= " / ".$grade[1];

                                    if(strcasecmp($kate[1],"") != 0)
                                        $nmpro .= " / ".$kate[1];

                                    if(strcasecmp($skate[1],"") != 0)
                                        $nmpro .= " / ".$skate[1];

                                    if(isDecimal($lst[$i][6]))
                                        $nmpro .= " (".number_format($lst[$i][6],2,'.',',')." KG)";
                                    else
                                        $nmpro .= " (".number_format($lst[$i][6],0,'.',',')." KG)";

                                    $nmpro .= "</li>";
                                }

                                if(strcasecmp($lst[$i][15],"") != 0)
                                {
                                    $pro = getProID($lst[$i][15]);
                                    $grade = getGradeID($pro[4]);
                                    $kate = getKateID($pro[2]);
                                    $skate = getSKateID($pro[3]);
                                    $nmpro2 = "<li>".$pro[1];

                                    if(strcasecmp($grade[1],"") != 0)
                                        $nmpro2 .= " / ".$grade[1];

                                    if(strcasecmp($kate[1],"") != 0)
                                        $nmpro2 .= " / ".$kate[1];

                                    if(strcasecmp($skate[1],"") != 0)
                                        $nmpro2 .= " / ".$skate[1];

                                    if(isDecimal($lst[$i][16]))
                                        $nmpro2 .= " (".number_format($lst[$i][16],2,'.',',')." KG)";
                                    else
                                        $nmpro2 .= " (".number_format($lst[$i][16],0,'.',',')." KG)";

                                    $nmpro2 .= "</li>";
                                }
                        ?>
                            <tr ondblclick="viewVac('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][1])); ?></td>
                                <td class="border"><?php if(date('Y', strtotime($lst[$i][3])) < 2000) echo ""; else echo date('d/m/Y', strtotime($lst[$i][3])); ?></td>
                                <td class="border"><ul class="small mb-0"><?php echo $nmpro.$nmpro2;?></ul></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][12],0,'.',',');?></td>
                                <td class="border"><?php echo $lst[$i][11];?></td>
                                <td class="border text-right"><?php echo number_format($weight,$wdcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][10],$tdcl,'.',','); ?></td>
                                <td class="border small">
                                    <ul>
                                    <?php
                                        $dtl = getVacItem3($lst[$i][0]);

                                        for($j = 0; $j < count($dtl); $j++)
                                        {
                                            $jlh = number_format($dtl[$j][4], 0, '.', ',');

                                            if(isDecimal($dtl[$j][4]))
                                                $jlh = number_format($dtl[$j][4], 2, '.', ',');
                                    ?>
                                        <li><?php echo $dtl[$j][0]; if(strcasecmp($dtl[$j][1],"") != 0) echo " / ".$dtl[$j][1]; if(strcasecmp($dtl[$j][2],"") != 0) echo " / ".$dtl[$j][2]; if(strcasecmp($dtl[$j][3],"") != 0) echo " / ".$dtl[$j][3]; echo " (".$jlh." KG) "?></li>
                                    <?php
                                        }
                                    ?>
                                    </ul>
                                </td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][7])); ?></td>
                                <td class="border mw-15p">
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eVac('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                        if (CekAksUser(substr($duser[7], 74, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delVac('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                        }

                                        //if (CekAksUser(substr($duser[7], 120, 1)))
                                        {
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="viewVac('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/list-icon.png" alt="Lihat Vacuum" width="18"></button>
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
                <div class="modal fade" id="mdl-opt-vac" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-vac" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-vac">
                                </div>

                                <div class="my-2">
                                        <button class="btn btn-light border m-2" id="btn-view-vac" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Vacuum" width="25"> <span>Lihat Vacuum</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 72, 1)))
                        require("./modals/mdl-nvac.php");

                    //if (CekAksUser(substr($duser[7], 73, 1))) {
                ?>
                    <div class="modal fade" id="mdl-evac" tabindex="-1" role="dialog" aria-labelledby="mdl-evac" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Vacuum</h5>
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
                                                <div class="col-3 mt-1"><span class="h6">Type</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <select name="edt-slct-type" id="edt-slct-type" class="custom-select">
                                                        <option value="1">Dari Cutting</option>
                                                        <option value="2">Dari Bahan Sjd</option>
                                                    </select>
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
                                    </div>
                                    <hr>

                                    <div class="row" id="edt-div-ctype">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tgl Cut</span></div>
                                                <div class="col-9"><input type="date" class="form-control inp-set dte-ctgl" id="edt-dte-ctgl" name="edt-dte-ctgl" placeholder="" autocomplete="off" data-value=""></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Hasil Cut</span></div>
                                                <div class="col-9">
                                                    <select name="edt-slct-hcut" id="edt-slct-hcut" class="custom-select slct-hcut">
                                                        <option value="0">Semua</option>
                                                        <option value="1">Non-Vitamin</option>
                                                        <option value="2">Vitamin</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket Cutting</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket-cpro" name="edt-txt-ket-cpro" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tahap Ke</span></div>
                                                <div class="col-9"><input type="number" class="form-control inp-set" id="edt-txt-thp-cpro" name="edt-txt-thp-cpro" placeholder="" autocomplete="off" step="1" max="100"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-none" id="edt-div-ptype">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Bhn Sjd 1</span><span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set" id="edt-txt-nma-pro" name="edt-txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                        <input type="text" class="d-none" id="edt-txt-pro">

                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border btn-spro2" type="button" data-value="#mdl-evac" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
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
                                            
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Berat (KG)</span><span class="text-danger">*</span></div>
                                                <div class="col-9"><input type="number" class="form-control inp-set" id="edt-txt-weight-pro" name="edt-txt-weight-pro" placeholder="" autocomplete="off" step="any"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Bhn Sjd 2</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inp-set" id="edt-txt-nma-pro3" name="edt-txt-nma-pro3" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                        <input type="text" class="d-none" id="edt-txt-pro3">

                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border btn-spro6" type="button" data-value="#mdl-evac" data-target="#mdl-spro6" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                        </div>

                                                        <div class="input-group-append">
                                                            <button class="btn btn-light border btn-rvpro2" type="button" data-value="E"><img src="./bin/img/icon/refresh.png" width="20" alt="Refresh"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="edt-txt-nma-grade3" name="edt-txt-nma-grade3" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="edt-txt-nma-kate3" name="edt-txt-nma-kate3" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="edt-txt-nma-skate3" name="edt-txt-nma-skate3" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Berat (KG)</span></div>
                                                <div class="col-9"><input type="number" class="form-control inp-set" id="edt-txt-weight-pro3" name="edt-txt-weight-pro3" placeholder="" autocomplete="off" step="any"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                                                <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket-pro" name="edt-txt-ket-pro" placeholder="" autocomplete="off" maxlength="100"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tahap Ke</span></div>
                                                <div class="col-9"><input type="number" class="form-control inp-set" id="edt-txt-thp" name="edt-txt-thp" placeholder="" autocomplete="off" step="1" max="100"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 my-2 p-0">
                                        <button class="btn btn-light border border-success btn-vac-pro" data-toggle="modal" data-target="#mdl-npro-vac" data-keyboard="false" data-backdrop="static" data-dismiss="modal"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Pilih Produk</span></button>
                                    </div>
                                    
                                    <div class="table-responsive my-2 mxh-60vh">
                                        <table class="table table-sm table-data2">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle">Produk</th>
                                                    <th class="border sticky-top align-middle text-right">Berat (KG)</th>
                                                    <th class="border sticky-top align-middle">Keterangan</th>
                                                    <th class="border sticky-top align-middle">Grade bahan baku</th>
                                                    <th class="border sticky-top align-middle">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-evac">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-vac-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-vac-2">Data produk tidak ditemukan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-vac-3">Data vacuum tidak ditemukan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-vac-4">Data bahan tidak boleh kosong !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-vac-5">Berat bahan pertama melebihi sisa stock !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-vac-6">Berat bahan kedua melebihi sisa stock !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-vac-7">Data gudang tidak ditemukan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-vac-8">Hasil tidak boleh melebihi bahan !!!</div>

                                    <div class="alert alert-danger mb-0 mr-2 d-none" id="div-edt-err-vac-9">Tidak terdapat cutting pada tanggal yang di tentukan !!!</div>

                                    <div class="alert alert-success mb-0 mr-2 d-none" id="div-edt-scs-vac-1">Vacuum berhasil diubah !!!</div>

                                    <button type="button" class="btn btn-primary" id="btn-sevac" data-count="">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}
                    require("./modals/mdl-vtran.php");
                    require("./modals/mdl-npro-vac.php");
                    require("./modals/mdl-spro2.php");
                    require("./modals/mdl-spro3.php");
                    require("./modals/mdl-spro6.php");
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