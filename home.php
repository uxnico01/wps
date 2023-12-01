<?php
    require("./bin/php/clsfunction.php");
    
    $nav = 1;

    $ttl = "Home";

    $arrm = getAllDateMonth();
    $trm = array();
    $tdate = array();

    $cut = array();
    $cdate = array();

    $vac = array();
    $vdate = array();

    $saw = array();
    $sdate = array();

    $krm = array();
    $kdate = array();

    //PENERIMAAN
    $ttdate = array();
    $ttrm = array();
    $ltrm = getLastSumThrTrm();
    $n = count($ltrm) - 1;
    for($i = 0; $i < count($ltrm); $i++)
    {
        $ttdate[$n] = date('d/m', strtotime($ltrm[$i][0]));

        if(isDecimal($ltrm[$i][1]))
            $ttrm[$n] = number_format($ltrm[$i][1], 2, '.', '');
        else
            $ttrm[$n] = number_format($ltrm[$i][1], 0, '.', '');
        
        $n--;
    }

    for($i = 0; $i < count($ttdate); $i++)
    {
        $tdate[count($tdate)] = $ttdate[$i];
        $trm[count($trm)] = $ttrm[$i];
    }

    //CUTTING
    $tcdate = array();
    $tcut = array();
    $lcut = getLastSumThrCut();
    $n = count($lcut) - 1;
    for($i = 0; $i < count($lcut); $i++)
    {
        $tcdate[$n] = date('d/m', strtotime($lcut[$i][0]));

        if(isDecimal($lcut[$i][1]))
            $tcut[$n] = number_format($lcut[$i][1], 2, '.', '');
        else
            $tcut[$n] = number_format($lcut[$i][1], 0, '.', '');
        
        $n--;
    }

    for($i = 0; $i < count($tcdate); $i++)
    {
        $cdate[count($cdate)] = $tcdate[$i];
        $cut[count($cut)] = $tcut[$i];
    }

    //VACUUM
    $tvdate = array();
    $tvac = array();
    $lvac = getLastSumThrVac();
    $n = count($lvac) - 1;
    for($i = 0; $i < count($lvac); $i++)
    {
        $tvdate[$n] = date('d/m', strtotime($lvac[$i][0]));

        if(isDecimal($lvac[$i][1]))
            $tvac[$n] = number_format($lvac[$i][1], 2, '.', '');
        else
            $tvac[$n] = number_format($lvac[$i][1], 0, '.', '');
        
        $n--;
    }

    for($i = 0; $i < count($tvdate); $i++)
    {
        $vdate[count($vdate)] = $tvdate[$i];
        $vac[count($vac)] = $tvac[$i];
    }

    //SAWING
    $tsdate = array();
    $tsaw = array();
    $lsaw = getLastSumThrSaw();
    $n = count($lsaw) - 1;
    for($i = 0; $i < count($lsaw); $i++)
    {
        $tsdate[$n] = date('d/m', strtotime($lsaw[$i][0]));

        if(isDecimal($lsaw[$i][1]))
            $tsaw[$n] = number_format($lsaw[$i][1], 2, '.', '');
        else
            $tsaw[$n] = number_format($lsaw[$i][1], 0, '.', '');
        
        $n--;
    }

    for($i = 0; $i < count($tsdate); $i++)
    {
        $sdate[count($sdate)] = $tsdate[$i];
        $saw[count($saw)] = $tsaw[$i];
    }

    //PACKAGING
    $tkdate = array();
    $tkrm = array();
    $lkrm = getLastSumThrKirim();
    $n = count($lkrm) - 1;
    for($i = 0; $i < count($lkrm); $i++)
    {
        $tkdate[$n] = date('d/m', strtotime($lkrm[$i][0]));

        if(isDecimal($lkrm[$i][1]))
            $tkrm[$n] = number_format($lkrm[$i][1], 2, '.', '');
        else
            $tkrm[$n] = number_format($lkrm[$i][1], 0, '.', '');
        
        $n--;
    }

    for($i = 0; $i < count($tkdate); $i++)
    {
        $kdate[count($kdate)] = $tkdate[$i];
        $krm[count($krm)] = $tkrm[$i];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home | PT Winson Prima Sejahtera</title>

    <?php
    require("./bin/php/head.php");
    ?>

    <style>
        /*#mdl-lview .modal-dialog {
            width: 80%;
            max-width: 80%;
        }

        @media (max-width: 768px) {
            #mdl-lview .modal-dialog {
                width: 100%;
                max-width: 100%;
            }
        }*/
    </style>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
        require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3">
        <div class="col-12 p-0">
            <h4 class="m-0 text-info font-weight-bolder" style="font-variant: small-caps;">Selamat datang, <?php echo $duser[2]; ?></h4>
            <div class="my-2 px-0 col-12 col-sm-12 col-md-12 col-lg-7 col-xl-6">
                <div class="input-group">
                    <select name="slct-sdb" id="slct-sdb" class="custom-select">
                        <?php
                            $ldb = getListDB();

                            for($i = 0; $i < count($ldb); $i++)
                            {
                                if(strcasecmp($ldb[$i],"kuma_wps") == 0)
                                    $x = "Bulan Berjalan";
                                else
                                    $x = strtoupper(explode("kuma_wps_", $ldb[$i])[1]);
                        ?>
                        <option value="<?php echo $ldb[$i];?>" <?php if(isset($_SESSION["kuma-db"])) { if(strcasecmp($_SESSION["kuma-db"], $ldb[$i]) == 0) echo "selected=\"selected\"";}?>><?php echo $x;?></option>
                        <?php
                            }
                        ?>
                    </select>

                    <div class="input-group-append">
                        <button class="btn btn-light border" onclick="Reload()"><img src="./bin/img/icon/refresh.png" alt="" width="20"></button>
                    </div>

                    <button class="btn btn-sm btn-light border border-secondary mx-1" data-target="#mdl-cpass" data-toggle="modal" id="btn-verif"><img src="./bin/img/icon/password-icon.png" alt="Ganti Password" width="25"> <span>Ganti Password</span></button>
                    <?php if (CekAksUser(substr($duser[7], 0, 1)) || CekAksUser(substr($duser[7], 171, 1))) { ?><button class="btn btn-sm btn-light border border-primary mx-1" data-target="#mdl-vrf" data-toggle="modal" id="btn-verif"><img src="./bin/img/icon/verif-icon.png" alt="Verifikasi" width="25"> <span>Verifikasi</span></button><?php } if (CekAksUser(substr($duser[7], 1, 1))) { ?><button class="btn btn-sm btn-light border border-danger mx-1" data-target="#mdl-lview" data-toggle="modal" id="btn-verif"><img src="./bin/img/icon/live-view-icon.png" alt="Live View" width="48.5"> <span>Live View</span></button><?php } ?>
                </div>
            </div>
            <hr class="mt-1">
        </div>

        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 my-2">
                    <h5 class="my-2">Proses Penerimaan (30 transaksi terakhir)</h5>
                    <canvas id="chart"></canvas>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 my-2">
                    <h5 class="my-2">Proses Cutting (30 transaksi terakhir)</h5>
                    <canvas id="chart2"></canvas>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 my-2">
                    <h5 class="my-2">Proses Vacuum (30 transaksi terakhir)</h5>
                    <canvas id="chart3"></canvas>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 my-2">
                    <h5 class="my-2">Proses Sawing (30 transaksi terakhir)</h5>
                    <canvas id="chart4"></canvas>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 my-2">
                    <h5 class="my-2">Proses Packaging (30 transaksi terakhir)</h5>
                    <canvas id="chart5"></canvas>
                </div>
                
                <div class="scripts">
                    <script type="text/javascript">
                        dates = (<?php echo json_encode($arrm);?>);
                        datesc1 = (<?php echo json_encode($tdate);?>);
                        dchart1 = (<?php echo json_encode($trm);?>);

                        datesc2 = (<?php echo json_encode($cdate);?>);
                        dchart2 = (<?php echo json_encode($cut);?>);
                        
                        datesc3 = (<?php echo json_encode($vdate);?>);
                        dchart3 = (<?php echo json_encode($vac);?>);
                        
                        datesc4 = (<?php echo json_encode($sdate);?>);
                        dchart4 = (<?php echo json_encode($saw);?>);
                        
                        datesc5 = (<?php echo json_encode($kdate);?>);
                        dchart5 = (<?php echo json_encode($krm);?>);
                    </script>
                </div>
            </div>
        </div>

        <div class="lmodals">
            <?php
                if(CekAksUser(substr($duser[7], 0, 1)) || CekAksUser(substr($duser[7], 171, 1)))
                    require("./modals/mdl-verif.php");
            ?>

            <div class="modal fade" id="mdl-cpass" tabindex="-1" role="dialog" aria-labelledby="mdl-cpass" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ganti Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="" data-toggle="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body py-1">
                            <div class="alert alert-danger d-none" id="div-err-cpass-1">
                                <h6 class="m-0">Harap isi semua data tanda '*' !!!</h6>
                            </div>
                            <div class="alert alert-danger d-none" id="div-err-cpass-2">
                                <h6 class="m-0">Password baru dan konfirmasi password baru tidak sesuai !!!</h6>
                            </div>
                            <div class="alert alert-danger d-none" id="div-err-cpass-3">
                                <h6 class="m-0">Password lama salah !!!</h6>
                            </div>
                            <div class="alert alert-success d-none" id="div-scs-cpass-1">
                                <h6 class="m-0">Password berhasil diubah !!!</h6>
                            </div>

                            <div class="row my-2">
                                <div class="col-12">
                                    <label for="txt-bpass">Password Lama <span class="text-danger">*</span></label>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 px-0">
                                        <div class="input-group">
                                            <input type="password" class="form-control inp-set" id="txt-bpass" name="txt-bpass" maxlength="50">
                                            
                                            <div class="input-group-append">
                                                <button class="btn btn-light border border-dark vpass" data-value="#txt-bpass"><img src="./bin/img/icon/view-icon.png" alt="View" width="25"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-12">
                                    <label for="txt-npass">Password Baru <span class="text-danger">*</span></label>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 px-0">
                                        <div class="input-group">
                                            <input type="password" class="form-control inp-set" id="txt-npass" name="txt-npass" maxlength="50">
                                            
                                            <div class="input-group-append">
                                                <button class="btn btn-light border border-dark vpass" data-value="#txt-npass"><img src="./bin/img/icon/view-icon.png" alt="View" width="25"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-12">
                                    <label for="txt-cnpass">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 px-0">
                                        <div class="input-group">
                                            <input type="password" class="form-control inp-set" id="txt-cnpass" name="txt-cnpass" maxlength="50">
                                            
                                            <div class="input-group-append">
                                                <button class="btn btn-light border border-dark vpass" data-value="#txt-cnpass"><img src="./bin/img/icon/view-icon.png" alt="View" width="25"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-scpass">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="mdl-lview" tabindex="-1" role="dialog" aria-labelledby="mdl-lview" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Live View</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="" data-toggle="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body py-2">
                            <div class="row">
                                <div class="col-6 my-2">
                                    <a class="btn btn-sm btn-block py-1 px-2 btn-light border border-secondary shadow" style="border-radius: 10px;" target="_blank" href="./live-view/laporan-cutting">Laporan Cutting</a>
                                </div>
                                <div class="col-6 my-2">
                                    <a class="btn btn-sm btn-block py-1 px-2 btn-light border border-secondary shadow" style="border-radius: 10px;" target="_blank" href="./live-view/laporan-vakuman">Laporan Vakuman</a>
                                </div>
                                <div class="col-6 my-2">
                                    <a class="btn btn-sm btn-block py-1 px-2 btn-light border border-secondary shadow" style="border-radius: 10px;" target="_blank" href="./live-view/laporan-sawing">Laporan Sawing</a>
                                </div>
                                <div class="col-6 my-2">
                                    <a class="btn btn-sm btn-block py-1 px-2 btn-light border border-secondary shadow" style="border-radius: 10px;" target="_blank" href="./live-view/laporan-packaging">Laporan Packaging</a>
                                </div>
                                <div class="col-6 my-2">
                                    <a class="btn btn-sm btn-block py-1 px-2 btn-light border border-secondary shadow" style="border-radius: 10px;" target="_blank" href="./live-view/laporan-inventory">Laporan Inventory</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="scripts">
                <script type="text/javascript">
                    $(document).ready(function() {
                        getVerif();
                        getPVerif();
                        //getLView();

                        setInterval(getVerif, 5000);
                        setInterval(getPVerif, 5000);
                        //setInterval(updLView, 10000);
                    });
                </script>
            </div>
        </div>
    </div>

    <?php
        require("./bin/php/footer.php");
    ?>
</body>

</html>