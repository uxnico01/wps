<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();
    $nav = 4;

    $ttl = "Proses - Pembekuan";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Pembekuan | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 138, 4)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (CekAksUser(substr($duser[7], 139, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nfrz"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Pembekuan</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right txt-srch" id="txt-srch-frz" placeholder="Cari Pembekuan" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <input type="text" class="hdn-date d-none">
                            <button class="btn btn-light border" id="btn-srch-frz"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">Dari</th>
                            <th class="border sticky-top">Hasil</th>
                            <th class="border sticky-top">User</th>
                            <th class="border sticky-top">Wkt</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-frz">
                        <?php
                            $lst = getAllFrz();

                            for($i = 0; $i < count($lst); $i++)
                            {
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][1];?></td>
                            <td class="border text-right"><?php if(isDecimal($lst[$i][2])) echo number_format($lst[$i][2],2,'.',','); else echo number_format($lst[$i][2],0,'.',',');?></td>
                            <td class="border small">
                                <?php
                                    $lst2 = getFrzItem2($lst[$i][0]);
                                ?>
                                <ul>
                                    <?php
                                        for($j = 0; $j < count($lst2); $j++)
                                        {
                                            $dtl = $lst2[$j][0];
                
                                            if($lst2[$j][1] !== "" && $lst2[$j][1] !== null)
                                                $dtl .= " / ".$lst2[$j][1];
                                            
                                            if($lst2[$j][2] !== "" && $lst2[$j][2] !== null)
                                                $dtl .= " / ".$lst2[$j][2];
                                            
                                            if($lst2[$j][3] !== "" && $lst2[$j][3] !== null)
                                                $dtl .= " / ".$lst2[$j][3];
                            
                                            $dtl .= " / ".$lst2[$j][4]." / ".$lst2[$j][5]." / ".$lst2[$j][6];
                                            
                                            if(isDecimal($lst2[$j][7]))
                                                $dtl .= " (".number_format($lst2[$j][7],2,'.',',').")";
                                            else
                                                $dtl .= " (".number_format($lst2[$j][7],0,'.',',').")";
                                            
                                            if($lst2[$j][8] !== "" && $lst2[$j][8] !== null)
                                                $dtl .= " - ".$lst2[$j][8];
                                    ?>
                                    <li><?php echo $dtl;?></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td class="border small">
                                <ul>
                                    <?php
                                        for($j = 0; $j < count($lst2); $j++)
                                        {
                                            $dtl = $lst2[$j][11];
                
                                            if($lst2[$j][12] !== "" && $lst2[$j][12] !== null)
                                                $dtl .= " / ".$lst2[$j][12];
                                            
                                            if($lst2[$j][13] !== "" && $lst2[$j][13] !== null)
                                                $dtl .= " / ".$lst2[$j][13];
                                            
                                            if($lst2[$j][14] !== "" && $lst2[$j][14] !== null)
                                                $dtl .= " / ".$lst2[$j][14];
                                            
                                            if(isDecimal($lst2[$j][7]))
                                                $dtl .= " (".number_format($lst2[$j][7],2,'.',',').")";
                                            else
                                                $dtl .= " (".number_format($lst2[$j][7],0,'.',',').")";
                                    ?>
                                    <li><?php echo $dtl;?></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td class="border"><?php echo $lst[$i][3];?></td>
                            <td class="border"><?php echo $lst[$i][4];?></td>
                            <td class="border">
                                <button class="btn btn-light border-warning mb-1 p-1" onclick="eFrz('<?php echo UE64($lst[$i][0]);?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                <?php
                                    if (CekAksUser(substr($duser[7], 141, 1))) {
                                ?>
                                    <button class="btn btn-light border-danger mb-1 p-1" onclick="delFrz('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
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
                <div class="modal fade" id="mdl-opt-frz" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-frz" aria-hidden="true">
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
                                    <input type="text" id="txt-opt-frz">
                                </div>

                                <div class="my-2">
                                        <button class="btn btn-light border m-2" id="btn-view-frz" data-dismiss="modal"><img src="./bin/img/icon/list-icon.png" alt="Lihat Pembekuan" width="25"> <span>Lihat Pembekuan</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if (CekAksUser(substr($duser[7], 139, 1)))
                        require("./modals/mdl-nfrz.php");

                    //if (CekAksUser(substr($duser[7], 140, 1))) {
                ?>
                    <div class="modal fade" id="mdl-efrz" tabindex="-1" role="dialog" aria-labelledby="mdl-efrz" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Pembekuan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-frz-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-frz-2">Data produk tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-frz-3">Data pembekuan tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-frz-4">Tidak ada produk yang dibekukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-frz-5">Data gudang tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-frz-1">Pembekuan berhasil diubah !!!</div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="row mt-2">
                                                <div class="col-3 mt-1"><span class="h6">Tgl Beku</span><span class="text-danger">*</span></div>
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
                                    </div>

                                    <div class="col-12 my-2 p-0">
                                        <button class="btn btn-light border border-success" id="btn-frz-pro"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Tambah Pembekuan</span></button>
                                    </div>
                                    
                                    <div class="table-responsive my-2 mxh-60vh">
                                        <table class="table table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="border sticky-top align-middle">Dari</th>
                                                    <th class="border sticky-top align-middle">Hasil</th>
                                                    <th class="border sticky-top align-middle">Ket</th>
                                                    <th class="border sticky-top align-middle">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-efrz">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-sefrz" data-count="">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                //}
                    require("./modals/mdl-vtran.php");
                    require("./modals/mdl-spro5.php");
                    require("./modals/mdl-strm3.php");
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