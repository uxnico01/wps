<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 2;

    $ttl = "Data - Produk";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data - Produk | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>

    <style>
        #mdl-hst-prvac .modal-dialog,
        #mdl-hst-prsaw .modal-dialog,
        #mdl-hst-trkrm .modal-dialog,
        #mdl-hst-prtt .modal-dialog {
            width: 80%;
            max-width: 80%;
        }

        @media (max-width: 768px) {
            #mdl-hst-prvac .modal-dialog,
            #mdl-hst-prsaw .modal-dialog,
            #mdl-hst-trkrm .modal-dialog,
            #mdl-hst-prtt .modal-dialog {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 9, 8)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (cekAksUser(substr($duser[7], 10, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-npro"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Produk</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="txt-srch-pro" placeholder="Cari Produk" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-pro"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-1 mb-2">

            <div class="table-responsive mxh-70vh">
                <table class="table table-sm table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border align-middle sticky-top">ID</th>
                            <th class="border align-middle sticky-top">Nama</th>
                            <th class="border align-middle sticky-top">Grade</th>
                            <th class="border align-middle sticky-top">Oz</th>
                            <th class="border align-middle sticky-top">Cut Style</th>
                            <th class="border align-middle sticky-top">Kategori</th>
                            <th class="border align-middle sticky-top">Golongan</th>
                            <th class="border align-middle sticky-top">Jenis Produk</th>
                            <th class="border align-middle sticky-top text-right">Qty</th>
                            <?php
                                if(viewHarga())
                                {
                            ?>
                            <th class="border align-middle sticky-top text-right">Harga Jual</th>
                            <?php
                                }
                            ?>
                            <th class="border align-middle sticky-top small">Tmpl Terima</th>
                            <th class="border align-middle sticky-top small">Tmpl Cutting</th>
                            <th class="border align-middle sticky-top small">Tmpl Vacuum</th>
                            <th class="border align-middle sticky-top small">Tmpl Sawing</th>
                            <th class="border align-middle sticky-top small">Tmpl Packaging</th>
                            <th class="border align-middle sticky-top small">Tmpl Msk Produk</th>
                            <th class="border align-middle sticky-top small">Tmpl Beku</th>
                            <th class="border align-middle sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-pro">
                        <?php
                        $lst = getAllPro();

                        for ($i = 0; $i < count($lst); $i++) {
                            $dcl = 0;

                            if(isDecimal($lst[$i][5])){
                                $dcl = 2;
                            }
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo $lst[$i][15]; ?></td>
                                <td class="border"><?php echo $lst[$i][16]; ?></td>
                                <td class="border"><?php echo $lst[$i][17]; ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][5],$dcl,'.',','); ?></td>
                                <?php
                                    if(viewHarga())
                                    {
                                ?>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][13])) echo number_format($lst[$i][13],2,'.',','); else echo number_format($lst[$i][13],0,'.',','); ?></td>
                                <?php
                                    }
                                ?>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border"><?php echo $lst[$i][7]; ?></td>
                                <td class="border"><?php echo $lst[$i][8]; ?></td>
                                <td class="border"><?php echo $lst[$i][9]; ?></td>
                                <td class="border"><?php echo $lst[$i][10]; ?></td>
                                <td class="border"><?php echo $lst[$i][11]; ?></td>
                                <td class="border"><?php echo $lst[$i][12]; ?></td>
                                <td class="border mw-15p">
                                    <?php
                                    if (cekAksUser(substr($duser[7], 11, 1))) {
                                    ?>
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="ePro('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                    }

                                    if (cekAksUser(substr($duser[7], 12, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delPro('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                    }

                                    if (cekAksUser(substr($duser[7], 13, 4))) {
                                    ?>
                                        <button class="btn btn-light border-info mb-1 p-1" onclick="mdlPro('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/more-info.png" alt="More" width="20"></button>
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
                <?php
                if (cekAksUser(substr($duser[7], 13, 4))) {
                ?>
                    <div class="modal fade" id="mdl-opt-pro" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-pro" aria-hidden="true">
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
                                        <input type="text" id="txt-opt-pro">
                                    </div>

                                    <div class="my-2">
                                        <?php
                                        if (cekAksUser(substr($duser[7], 13, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-prtt" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History Penerimaan</span></button>
                                        <?php
                                        }

                                        if (cekAksUser(substr($duser[7], 14, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-prvac" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History Vacuum</span></button>
                                        <?php
                                        }

                                        if (cekAksUser(substr($duser[7], 15, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-prsaw" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History Sawing</span></button>
                                        <?php
                                        }

                                        if (cekAksUser(substr($duser[7], 16, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-trkrm" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History Packaging</span></button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (cekAksUser(substr($duser[7], 13, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-prtt" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-prtt" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History Penerimaan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-pro" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="offset-xl-2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-frm-prtt" name="dte-frm-prtt" value="<?php echo date('Y-m-01');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 text-center"><span class="d-block mt-2">S/D</span></div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-prtt" name="dte-to-prtt" value="<?php echo date('Y-m-t');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-prtt-pro">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <th class="border align-middle sticky-top">Tgl</th>
                                                    <th class="border align-middle sticky-top">ID</th>
                                                    <th class="border align-middle sticky-top">Supplier</th>
                                                    <th class="border align-middle sticky-top text-right">Qty (Ekor)</th>
                                                    <th class="border align-middle sticky-top text-right">Berat (KG)</th>
                                                    <th class="border align-middle sticky-top text-right">BB</th>
                                                    <th class="border align-middle sticky-top text-right">Pinjaman</th>
                                                    <th class="border align-middle sticky-top">Ket1</th>
                                                    <th class="border align-middle sticky-top">Ket2</th>
                                                    <th class="border align-middle sticky-top">Ket3</th>
                                                    <th class="border align-middle sticky-top">User</th>
                                                    <th class="border align-middle sticky-top">Wkt Inp</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-pro-prtt">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (cekAksUser(substr($duser[7], 14, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-prvac" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-prvac" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History Vacuum</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-pro" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="offset-xl-2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-frm-prvac" name="dte-frm-prvac" value="<?php echo date('Y-m-01');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 text-center"><span class="d-block mt-2">S/D</span></div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-prvac" name="dte-to-prvac" value="<?php echo date('Y-m-t');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-prvac-pro">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <th class="border align-middle sticky-top">Tgl</th>
                                                    <th class="border align-middle sticky-top">Tgl Cut</th>
                                                    <th class="border align-middle sticky-top text-right">Qty Msk (KG)</th>
                                                    <th class="border align-middle sticky-top text-right">Qty Klr (KG)</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-pro-prvac">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (cekAksUser(substr($duser[7], 15, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-prsaw" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-prsaw" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History Sawing</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-pro" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="offset-xl-2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-frm-prsaw" name="dte-frm-prsaw" value="<?php echo date('Y-m-01');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 text-center"><span class="d-block mt-2">S/D</span></div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-prsaw" name="dte-to-prsaw" value="<?php echo date('Y-m-t');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-prsaw-pro">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <th class="border align-middle sticky-top">Tgl</th>
                                                    <th class="border align-middle sticky-top text-right">Qty Msk (KG)</th>
                                                    <th class="border align-middle sticky-top text-right">Qty Klr (KG)</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-pro-prsaw">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (cekAksUser(substr($duser[7], 16, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-trkrm" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-trkrm" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History Packaging</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-pro" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="offset-xl-2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-frm-trkrm" name="dte-frm-trkrm" value="<?php echo date('Y-m-01');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 text-center"><span class="d-block mt-2">S/D</span></div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-trkrm" name="dte-to-trkrm" value="<?php echo date('Y-m-t');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-trkrm-pro">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <th class="border align-middle sticky-top">Tgl</th>
                                                    <th class="border align-middle sticky-top">No PO</th>
                                                    <th class="border align-middle sticky-top text-right">Qty (KG)</th>
                                                    <th class="border align-middle sticky-top">Ket 1</th>
                                                    <th class="border align-middle sticky-top">Ket 2</th>
                                                    <th class="border align-middle sticky-top">Ket 3</th>
                                                    <th class="border align-middle sticky-top">User</th>
                                                    <th class="border align-middle sticky-top">Wkt Inp</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-pro-trkrm">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (cekAksUser(substr($duser[7], 10, 1)))
                    require("./modals/mdl-npro.php");

                if (cekAksUser(substr($duser[7], 11, 1))) {
                ?>
                    <div class="modal fade" id="mdl-epro" tabindex="-1" role="dialog" aria-labelledby="mdl-epro" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Produk</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-pro-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pro-2">Terdapat data produk dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pro-3">Data produk tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pro-4">Data Oz tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pro-5">Data Cut Style tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pro-6">Grade tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pro-7">Kategori tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pro-8">Golongan tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-pro-9">Jenis produk tidak ditemukan !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-pro-1">Produk berhasil diubah !!!</div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-nma" name="edt-txt-nma" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Grade</span><span class="text-danger">*</span></div>
                                        <div class="col-9">
                                            <select name="edt-slct-grade" id="edt-slct-grade" class="custom-select">
                                                <option value="">Pilih Grade</option>
                                                <?php
                                                    $lst = getAllGrade();

                                                    for($i = 0; $i < count($lst); $i++)
                                                    {
                                                ?>
                                                <option value="<?php echo $lst[$i][0];?>"><?php echo $lst[$i][1];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control inp-set" id="edt-txt-nma-kate" name="edt-txt-nma-kate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                <input type="text" class="d-none" id="edt-txt-kate">

                                                <div class="input-group-append">
                                                    <button class="btn btn-light border" type="button" data-value="#mdl-epro" data-target="#mdl-skate" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Qty Awal (KG)</span></div>
                                        <div class="col-9"><input type="number" class="form-control inp-set" id="edt-nmbr-qawl" name="edt-nmbr-qawl" placeholder="" autocomplete="off" step="any" value="0" readonly></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control inp-set" id="edt-txt-nma-skate" name="edt-txt-nma-skate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                                <input type="text" class="d-none" id="edt-txt-skate">

                                                <div class="input-group-append">
                                                    <button class="btn btn-light border" type="button" data-value="#mdl-epro" data-target="#mdl-sskate" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Kategori</span><span class="text-danger">*</span></div>
                                        <div class="col-9">
                                            <select name="edt-slct-kates" id="edt-slct-kates" class="custom-select">
                                                <option value="">Pilih Kategori</option>
                                                <?php
                                                    $lst = getAllKates($db);

                                                    for($i = 0; $i < count($lst); $i++)
                                                    {
                                                ?>
                                                <option value="<?php echo $lst[$i][0];?>"><?php echo $lst[$i][1];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Golongan</span><span class="text-danger">*</span></div>
                                        <div class="col-9">
                                            <select name="edt-slct-gol" id="edt-slct-gol" class="custom-select">
                                                <option value="">Pilih Golongan</option>
                                                <?php
                                                    $lst = getAllGol($db);

                                                    for($i = 0; $i < count($lst); $i++)
                                                    {
                                                ?>
                                                <option value="<?php echo $lst[$i][0];?>"><?php echo $lst[$i][1];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Jenis Produk</span></div>
                                        <!-- <span class="text-danger">*</span> -->
                                        <div class="col-9">
                                            <select name="edt-slct-katej" id="edt-slct-katej" class="custom-select">
                                                <!-- <option value="">Pilih Jenis Produk</option> -->
                                                <?php
                                                    $lst = getAllKatej($db);

                                                    for($i = 0; $i < count($lst); $i++)
                                                    {
                                                ?>
                                                <option value="<?php echo $lst[$i][0];?>"><?php echo $lst[$i][1];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2 d-none">
                                        <div class="col-3 mt-1"><span class="h6">Sub Kategori</span><span class="text-danger">*</span></div>
                                        <div class="col-9">
                                            <select name="edt-slct-skate" id="edt-slct-skate" class="custom-select">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Tampil produk pada</span></div>
                                        <div class="col-9">
                                            <div class="form-check my-1">
                                                <input class="form-check-input" type="checkbox" value="" id="edt-chk-trm">
                                                <label class="form-check-label" for="edt-chk-trm">Proses Penerimaan</label>
                                            </div>
                                            <div class="form-check my-1">
                                                <input class="form-check-input" type="checkbox" value="" id="edt-chk-cut">
                                                <label class="form-check-label" for="edt-chk-cut">Proses Cutting</label>
                                            </div>
                                            <div class="form-check my-1">
                                                <input class="form-check-input" type="checkbox" value="" id="edt-chk-vac">
                                                <label class="form-check-label" for="edt-chk-vac">Proses Vacuum</label>
                                            </div>
                                            <div class="form-check my-1">
                                                <input class="form-check-input" type="checkbox" value="" id="edt-chk-saw">
                                                <label class="form-check-label" for="edt-chk-saw">Proses Sawing</label>
                                            </div>
                                            <div class="form-check my-1">
                                                <input class="form-check-input" type="checkbox" value="" id="edt-chk-pkg">
                                                <label class="form-check-label" for="edt-chk-pkg">Proses Packaging</label>
                                            </div>
                                            <div class="form-check my-1">
                                                <input class="form-check-input" type="checkbox" value="" id="edt-chk-mp">
                                                <label class="form-check-label" for="edt-chk-mp">Proses Masuk Produk</label>
                                            </div>
                                            <div class="form-check my-1">
                                                <input class="form-check-input" type="checkbox" value="" id="edt-chk-frz">
                                                <label class="form-check-label" for="edt-chk-frz">Proses Pembekuan</label>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                        if(viewHarga())
                                        {
                                    ?>
                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Harga Jual</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-hsell" name="edt-txt-hsell" placeholder="" autocomplete="off" value="0"></div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-sepro">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                    require("./modals/mdl-skate.php");
                    require("./modals/mdl-sskate.php");
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