<?php
    require("./bin/php/clsfunction.php");

    $nav = 2;

    $ttl = "Data - Supplier";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data - Supplier | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>

    <style>
        #mdl-hst-prtt .modal-dialog,
        #mdl-hst-prtt2 .modal-dialog,
        #mdl-hst-trtt .modal-dialog,
        #mdl-hst-trpjm .modal-dialog,
        #mdl-hst-smpn .modal-dialog {
            width: 80%;
            max-width: 80%;
        }

        .modal-header-psup {
            align-items: center !important;
        }

        .psup-modal-header {
            display: flex;
            flex-direction: row;
        }

        .btn-simpanan {
            color: #000000;
            border: 1px solid rgba(0, 0, 0, 0.300);
            background-color: #FFFFFF;
        }

        .btn-simpanan:hover {
            border-color: #1E5963;
            background-color: #17A2B8;
        }

        .btn-simpanan-active
        {
            color: #FFFFFF !important;
            border-color: #1E5963;
            background-color: #17A2B8;
        }

        .btn-dupp-supp
        {
            color: #000000;
            border: 1px solid rgba(0, 0, 0, 0.300);
            background-color: #FFFFFF;
            width: 70%;
            margin-right: 1%;
        }

        .btn-dupp-supp:hover
        {
            border-color: #1E5963;
            background-color: #17A2B8;
        }

        .btn-dupp-supp-active
        {
            color: #FFFFFF !important;
            border-color: #1E5963;
            background-color: #17A2B8;
        }

        .collapse-supplier-button {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin-left: 10px;
            margin-right: 10px;
        }

        .collapse-supplier-button p {
            font-weight: 500;
        }

        .btn-supp
        {
            width: 80%;
            margin-right: 0.5%;
        }

        .btn-supp-del
        {
            width: 19%;
            margin-left: 0.5%;
        }

        .btn-dupp-supp-save
        {
            width: 19%;
            margin-right: 0.5%;
        }
        
        .btn-dupp-supp-del
        {
            width: 9%;
            margin-left: 0.5%;
        }

        .hide-duplicatesup-id {
            display: none;
        }

        .collapse-supplier-icon-switch[aria-expanded=true] .collapse-supplier-up {
            display: none;
        }

        .collapse-supplier-icon-switch[aria-expanded=false] .collapse-supplier-down {
            display: none;
        }
        
        @media (max-width: 768px) {
            #mdl-hst-prtt .modal-dialog,
            #mdl-hst-prtt2 .modal-dialog,
            #mdl-hst-trtt .modal-dialog,
            #mdl-hst-trpjm .modal-dialog,
            #mdl-hst-smpn .modal-dialog {
                width: 100%;
                max-width: 100%;
            }
        }
        
        /* Fitur: display simpanan duplikasi */
        #lst-btndcollapse {
            display: none;
        }
        #lst-btnsmpndup {
            display: none;
        }
    </style>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!cekAksUser(substr($duser[7], 2, 7)) || !cekAksUser(substr($duser[7],103,4)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if (cekAksUser(substr($duser[7], 3, 1))) {
                    ?>
                        <button class="btn btn-outline-success m-1" id="btn-nsup"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Supplier</span></button>
                    <?php
                        }

                        if (cekAksUser(substr($duser[7], 103, 1))) {
                    ?>
                        <button class="btn btn-light border-secondary m-1" data-toggle="modal" data-target="#mdl-ahsup"><img src="./bin/img/icon/money2-icon.png" width="20" alt="Add"> <span class="small">Ubah Harga Supplier</span></button>
                    <?php
                        }
                    ?>
                </div>

                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="txt-srch-sup" placeholder="Cari Supplier" autocomplete="off" autofocus>

                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-sup"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
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
                            <th class="border sticky-top">Nama</th>
                            <th class="border sticky-top">Alamat</th>
                            <th class="border sticky-top">Wilayah</th>
                            <th class="border sticky-top">Tel</th>
                            <th class="border sticky-top">Tel2</th>
                            <th class="border sticky-top">Email</th>
                            <th class="border sticky-top">Jenis</th>
                            <th class="border sticky-top">Badan Usaha</th>
                            <th class="border sticky-top">Ket</th>
                            <th class="border sticky-top text-right">Simpanan Awal</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-sup">
                        <?php
                        $lst = getAllSup();

                        for ($i = 0; $i < count($lst); $i++) {
                        ?>
                            <tr>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border"><?php echo $lst[$i][7]; ?></td>
                                <td class="border"><?php echo $lst[$i][8]; ?></td>
                                <td class="border"><?php echo $lst[$i][9]; ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][10])) echo number_format($lst[$i][10], 2, ',', '.'); else echo number_format($lst[$i][10], 0, ',', '.');?></td>
                                <td class="border mw-15p">
                                    <?php
                                    if (cekAksUser(substr($duser[7], 4, 1))) {
                                    ?>
                                        <button class="btn btn-light border-warning mb-1 p-1" onclick="eSup('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                    <?php
                                    }

                                    if (cekAksUser(substr($duser[7], 5, 1))) {
                                    ?>
                                        <button class="btn btn-light border-danger mb-1 p-1" onclick="delSup('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                    <?php
                                    }

                                    if (cekAksUser(substr($duser[7], 103, 1))) {
                                    ?>
                                        <button class="btn btn-light border-success mb-1 p-1" onclick="hrgSup('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/money2-icon.png" alt="Money" width="18"></button>
                                    <?php
                                    }

                                    if (cekAksUser(substr($duser[7], 105, 1))) {
                                    ?>
                                        <button class="btn btn-light border-secondary mb-1 p-1" onclick="smpnSup('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/wallet-icon.png" alt="Wallet" width="18"></button>
                                    <?php
                                    }

                                    if (cekAksUser(substr($duser[7], 6, 3)) || cekAksUser(substr($duser[7], 104, 1)) || cekAksUser(substr($duser[7], 106, 1))) {
                                    ?>
                                        <button class="btn btn-light border-info mb-1 p-1" onclick="mdlSup('<?php echo UE64($lst[$i][0]); ?>')"><img src="./bin/img/icon/more-info.png" alt="More" width="20"></button>
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
                if (cekAksUser(substr($duser[7], 6, 3)) || cekAksUser(substr($duser[7], 104, 1)) || cekAksUser(substr($duser[7], 106, 1))) {
                ?>
                    <div class="modal fade" id="mdl-opt-sup" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-sup" aria-hidden="true">
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
                                        <input type="text" id="txt-opt-sup">
                                    </div>

                                    <div class="my-2">
                                        <?php
                                        if (cekAksUser(substr($duser[7], 6, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-prtt" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History Penerimaan</span></button>
                                        <?php
                                        }

                                        /*if (cekAksUser(substr($duser[7], 7, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-trtt" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History Tanda Terima</span></button>
                                        <?php
                                        }*/

                                        if (cekAksUser(substr($duser[7], 8, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-trpjm" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History Pinjaman</span></button>
                                        <?php
                                        }

                                        if (cekAksUser(substr($duser[7], 104, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-prtt2" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History Potongan Pinjaman</span></button>
                                        <?php
                                        }

                                        if (cekAksUser(substr($duser[7], 106, 1))) {
                                        ?>
                                            <button class="btn btn-light border m-2" data-target="#mdl-hst-smpn" data-toggle="modal" data-dismiss="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/history-icon.png" alt="History" width="25"> <span>History Simpanan</span></button>
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

                if (cekAksUser(substr($duser[7], 6, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-prtt" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-prtt" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History Penerimaan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-sup" data-toggle="modal">
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
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-prtt" name="dte-to-prtt"value="<?php echo date('Y-m-t');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-prtt-sup">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <th class="border align-middle sticky-top">Tgl</th>
                                                    <th class="border align-middle sticky-top">ID</th>
                                                    <th class="border align-middle sticky-top text-right">Qty (Ekor)</th>
                                                    <th class="border align-middle sticky-top text-right">Berat (KG)</th>
                                                    <th class="border align-middle sticky-top text-right">BB</th>
                                                    <th class="border align-middle sticky-top text-right">Potongan</th>
                                                    <th class="border align-middle sticky-top">Ket1</th>
                                                    <th class="border align-middle sticky-top">Ket2</th>
                                                    <th class="border align-middle sticky-top">Ket3</th>
                                                    <th class="border align-middle sticky-top">User</th>
                                                    <th class="border align-middle sticky-top">Wkt Inp</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-sup-prtt">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (cekAksUser(substr($duser[7], 104, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-prtt2" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-prtt2" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History Potongan Pinjaman</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-sup" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="offset-xl-2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-frm-prtt2" name="dte-frm-prtt2" value="<?php echo date('Y-m-01');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 text-center"><span class="d-block mt-2">S/D</span></div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-prtt2" name="dte-to-prtt2"value="<?php echo date('Y-m-t');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-prtt2-sup">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <th class="border align-middle sticky-top">Tgl</th>
                                                    <th class="border align-middle sticky-top">ID</th>
                                                    <th class="border align-middle sticky-top text-right">Potongan</th>
                                                    <th class="border align-middle sticky-top">Ket1</th>
                                                    <th class="border align-middle sticky-top">Ket2</th>
                                                    <th class="border align-middle sticky-top">Ket3</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-sup-prtt2">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (cekAksUser(substr($duser[7], 106, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-smpn" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-smpn" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History Simpanan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-sup" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="offset-xl-2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-frm-smpn" name="dte-frm-smpn" value="<?php echo date('Y-m-01');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 text-center"><span class="d-block mt-2">S/D</span></div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-smpn" name="dte-to-smpn"value="<?php echo date('Y-m-t');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-smpn-sup">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <th class="border align-middle sticky-top">Tgl</th>
                                                    <th class="border align-middle sticky-top text-right">Simpanan</th>
                                                    <th class="border align-middle sticky-top text-right">Penarikan</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-sup-smpn">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                /*if (cekAksUser(substr($duser[7], 7, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-trtt" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-trtt" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History Tanda Terima</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-sup" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="offset-xl-2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-frm-trtt" name="dte-frm-trtt"value="<?php echo date('Y-m-01');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 text-center"><span class="d-block mt-2">S/D</span></div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-trtt" name="dte-to-trtt"value="<?php echo date('Y-m-t');?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-trtt-sup">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <th class="border align-middle sticky-top">Tgl</th>
                                                    <th class="border align-middle sticky-top">ID</th>
                                                    <th class="border align-middle sticky-top text-right">Qty (Ekor)</th>
                                                    <th class="border align-middle sticky-top text-right">Berat (KG)</th>
                                                    <th class="border align-middle sticky-top text-right">Sub Total</th>
                                                    <th class="border align-middle sticky-top text-right">BB</th>
                                                    <th class="border align-middle sticky-top text-right">Pinjaman</th>
                                                    <th class="border align-middle sticky-top text-right">Total</th>
                                                    <th class="border align-middle sticky-top">Ket1</th>
                                                    <th class="border align-middle sticky-top">Ket2</th>
                                                    <th class="border align-middle sticky-top">Ket3</th>
                                                    <th class="border align-middle sticky-top">User</th>
                                                    <th class="border align-middle sticky-top">Wkt Inp</th>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-sup-trtt">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }*/

                if (cekAksUser(substr($duser[7], 8, 1))) {
                ?>
                    <div class="modal fade" id="mdl-hst-trpjm" tabindex="-1" role="dialog" aria-labelledby="mdl-hst-trpjm" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">History Pinjaman</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-sup" data-toggle="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="row">
                                        <div class="offset-xl-2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-frm-trpjm" name="dte-frm-trpjm" value="<?php echo date('Y-m-01'); ?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 text-center"><span class="d-block mt-2">S/D</span></div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                                            <input type="date" class="form-control my-2 inp-set" id="dte-to-trpjm" name="dte-to-trpjm" value="<?php echo date('Y-m-t'); ?>">
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <button class="btn btn-primary my-2" id="btn-srch-trpjm-sup">Cari</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mxh-70vh">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-dark bg-dark text-light">
                                                <tr>
                                                    <td class="border align-middle sticky-top">Tgl</td>
                                                    <td class="border align-middle sticky-top">ID</td>
                                                    <td class="border align-middle sticky-top text-right">Jumlah</td>
                                                    <td class="border align-middle sticky-top text-right">Cross</td>
                                                    <td class="border align-middle sticky-top text-right">Sisa</td>
                                                    <td class="border align-middle sticky-top">Ket1</td>
                                                    <td class="border align-middle sticky-top">Ket2</td>
                                                    <td class="border align-middle sticky-top">Ket3</td>
                                                    <td class="border align-middle sticky-top">User</td>
                                                    <td class="border align-middle sticky-top">Wkt Inp</td>
                                                </tr>
                                            </thead>

                                            <tbody id="lst-sup-trpjm">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (cekAksUser(substr($duser[7], 3, 1)))
                    require("./modals/mdl-nsup.php");

                if (cekAksUser(substr($duser[7], 4, 1))) {
                ?>
                    <div class="modal fade" id="mdl-esup" tabindex="-1" role="dialog" aria-labelledby="mdl-esup" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ralat Supplier</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pt-1">
                                    <div class="alert alert-danger d-none" id="div-edt-err-sup-1">Harap isi semua data dengan tanda * !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-sup-2">Terdapat data supplier dengan ID ini !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-sup-3">Data supplier tidak ditemukan !!!</div>

                                    <div class="alert alert-danger d-none" id="div-edt-err-sup-4">Format email tidak valid !!!</div>

                                    <div class="alert alert-success d-none" id="div-edt-scs-sup-1">Supplier berhasil diubah !!!</div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-id" name="edt-txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="edt-txt-bid"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-nma" name="edt-txt-nma" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Alamat</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-addr" name="edt-txt-addr" placeholder="" autocomplete="off" maxlength="200"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Wilayah</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-reg" name="edt-txt-reg" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Tel</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-phone" name="edt-txt-phone" placeholder="" autocomplete="off" maxlength="50"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Tel 2</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-phone2" name="edt-txt-phone2" placeholder="" autocomplete="off" maxlength="50"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Email</span></div>
                                        <div class="col-9"><input type="email" class="form-control inp-set" id="edt-txt-mail" name="edt-txt-mail" placeholder="" autocomplete="off" maxlength="50"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Jenis</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set text-uppercase" id="edt-txt-ket" name="edt-txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Badan Usaha</span></div>
                                        <div class="col-9">
                                            <select name="edt-txt-ket2" id="edt-txt-ket2" class="custom-select">
                                                <option value="Y">Ya</option>
                                                <option value="N">No / Bukan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket3" name="edt-txt-ket3" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Simpanan Awal</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set cformat" id="edt-txt-smpn" name="edt-txt-smpn" placeholder="" autocomplete="off" maxlength="100"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-sesup">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if (cekAksUser(substr($duser[7], 103, 1))){
                    require("./modals/mdl-hsup.php");
                    require("./modals/mdl-ahsup.php");
                    require("./modals/mdl-ssup3.php");
                    require("./modals/mdl-sgrade.php");
                    require("./modals/mdl-ssat.php");
                }

                if (cekAksUser(substr($duser[7], 105, 1)))
                    require("./modals/mdl-psup.php");
                ?>
            </div>
        </div>
    </div>

    <?php
        require("./bin/php/footer.php");
    ?>
</body>
</html>