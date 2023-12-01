<?php
require("./bin/php/clsfunction.php");

$login = true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Auto Generate Data | PT Winson Prima Sejahtera</title>

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            widows: 100%;
        }
    </style>

    <link rel="stylesheet" href="./bin/vendor/bootstrap-5.1.2-dist/css/bootstrap.css">
    <script type="text/javascript" src="./bin/vendor/bootstrap-5.1.2-dist/js/bootstrap.bundle.js"></script>
    <?php
    require("./bin/php/head.php");
    ?>
</head>

<body class="bg-secondary2 h-100">
    <div class="container pb-2">
        <h4 class="pt-3">Auto Generate Data - WPS Stock</h4>

        <ul class="nav nav-tabs mt-3">
            <li class="nav-item">
                <a class="nav-link nav-auto active" aria-current="page" href="#" data-value="nav-trm">Penerimaan - Cutting</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-auto" href="#" data-value="nav-krm">Packaging</a>
            </li>
        </ul>

        <div id="nav-trm">
            <div class="row m-0">
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 bg-light my-2 py-2 rounded">
                    <label for="txt-sw">Total Berat (KG)</label>
                    <input type="text" class="form-control cformat" id="txt-sw" autocomplete="off">
                </div>
            </div>

            <div class="accordion accordion-flush" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">Tahap 1 - Tentukan Produk</button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne" data-bs-parent="#accordionPanelsStayOpenExample">
                        <div class="accordion-body">
                            <div class="my-1"><button class="btn btn-sm btn-primary btn-chpro btn-spro4" data-value="lst-tpro-trm" data-target="#mdl-spro4" data-toggle="modal"><img src="./bin/img/icon/plus-wh.png" width="15" alt="Add" style="margin-top:-5px"> <span class="">Pilih Produk</span></button></div>
                            <div class="table table-responsive mxh-40vh">
                                <table class="table table-sm table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="border sticky-top align-middle">Kode</th>
                                            <th class="border sticky-top align-middle">Nama</th>
                                            <th class="border sticky-top align-middle">Grade</th>
                                            <th class="border sticky-top align-middle">Oz</th>
                                            <th class="border sticky-top align-middle">Cut Style</th>
                                            <th class="border sticky-top align-middle text-right">%</th>
                                            <th class="border sticky-top align-middle text-right">Jlh</th>
                                            <th class="border sticky-top align-middle">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="lst-tpro-trm"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">Tahap 2 - Tentukan Supplier</button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo" data-bs-parent="#accordionPanelsStayOpenExample">
                        <div class="accordion-body">
                            <div class="my-2">
                                <strong for="" class="mr-3">Semua Supplier ?</strong>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rdo-asup" id="rdo-asup-yes" value="Y" checked>
                                    <label class="form-check-label" for="rdo-asup-yes">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rdo-asup" id="rdo-asup-no" value="N">
                                    <label class="form-check-label" for="rdo-asup-no">Tidak</label>
                                </div>
                            </div>
                            <div class="d-none" id="div-ssup">
                                <div class="my-1"><button class="btn btn-sm btn-primary btn-chsup" data-value="lst-tsup-trm" data-target="#mdl-ssup2" data-toggle="modal"><img src="./bin/img/icon/plus-wh.png" width="15" alt="Add" style="margin-top:-5px"> <span class="">Pilih Supplier</span></button></div>
                                <div class="table table-responsive mxh-40vh">
                                    <table class="table table-sm table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="border sticky-top align-middle">Kode</th>
                                                <th class="border sticky-top align-middle">Nama</th>
                                                <th class="border sticky-top align-middle">Alamat</th>
                                                <th class="border sticky-top align-middle">Wilayah</th>
                                                <th class="border sticky-top align-middle">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="lst-tsup-trm"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">Tahap 3 - Tentukan Tanggal Transaksi</button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree" data-bs-parent="#accordionPanelsStayOpenExample">
                        <div class="accordion-body">
                            <div class="row mb-2">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <label for="dte-frm">Dari Tanggal</label>
                                    <input type="date" class="form-control" id="dte-frm">
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <label for="dte-frm">Sampai Tanggal</label>
                                    <input type="date" class="form-control" id="dte-to">
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 d-flex align-items-end">
                                    <div class="">
                                        <button class="btn btn-primary" id="btn-sat-date">Set</button>
                                    </div>
                                </div>
                            </div>

                            <div class="my-2 d-none" id="div-tdate-trm">
                                <hr>
                                <h6>Daftar Tanggal</h6>
                                <div class="row" id="lst-tdate-trm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">Tahap 4 - Settingan Penerimaan</button>
                    </h2>
                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour" data-bs-parent="#accordionPanelsStayOpenExample">
                        <div class="accordion-body">
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Range Berat (KG)</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2"><input type="number" class="form-control" id="nmbr-rfrm" step="any" value="50"></div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 col-xl-1 d-flex align-items-center">
                                    <div class="text-center w-100">To</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2"><input type="number" class="form-control" id="nmbr-rto" step="any" value="100"></div>
                            </div>
                            <div class="row my-2 d-none">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Range Jlh Ikan Per Transaksi</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-1 col-xl-1"><input type="number" class="form-control" id="nmbr-rjffrm" step="any" value="1"></div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 col-xl-1 d-flex align-items-center">
                                    <div class="text-center w-100">To</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-1 col-xl-1"><input type="number" class="form-control" id="nmbr-rjfto" step="any" value="5"></div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Min Transaksi Per Tgl</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-1 col-xl-1"><input type="number" class="form-control" id="nmbr-msup" step="1" value="3"></div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Max Transaksi Per Tgl</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-1 col-xl-1"><input type="number" class="form-control" id="nmbr-mxsup" step="1" value="6"></div>
                            </div>
                            <div class="row my-2 d-none">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Max Berat (KG) Per Transaksi</div>
                                </div>
                                <div class="col-5 col-sm-5 col-md-3 col-lg-2 col-xl-2"><input type="text" class="form-control cformat" id="txt-mxw" value="<?php echo number_format(1000, 0, '.', ','); ?>"></div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">User yang melakukan input</div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <select name="slct-user" id="slct-user" class="custom-select">
                                        <?php
                                        $luser = getAllUser();

                                        for ($i = 0; $i < count($luser); $i++) {
                                        ?>
                                            <option value="<?php echo $luser[$i][0]; ?>"><?php echo $luser[$i][2]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Satuan</div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <select name="slct-sat" id="slct-sat" class="custom-select">
                                        <?php
                                        $lsat = getAllSatuan();

                                        for ($i = 0; $i < count($lsat); $i++) {
                                        ?>
                                            <option value="<?php echo $lsat[$i][0]; ?>"><?php echo $lsat[$i][1]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">Tahap 5 - Setting Cutting</button>
                    </h2>
                    <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFive" data-bs-parent="#accordionPanelsStayOpenExample">
                        <div class="accordion-body">
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Range Hasil Cutting (%)</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-1 col-xl-1"><input type="number" class="form-control" id="nmbr-tsfrm" step="any" value="50" max="100" min="0"></div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 col-xl-1 d-flex align-items-center">
                                    <div class="text-center w-100">To</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-1 col-xl-1"><input type="number" class="form-control" id="nmbr-tsto" step="any" value="55" max="100" min="0"></div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Jlh Potongan Per Ikan <strong class="text-secondary small">(MAX 6)</strong></div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-1 col-xl-1"><input type="number" class="form-control" id="nmbr-jpot" step="1" value="4" max="6" min="1"></div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">User yang melakukan input</div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <select name="slct-user-cut" id="slct-user-cut" class="custom-select">
                                        <?php
                                        $luser = getAllUser();

                                        for ($i = 0; $i < count($luser); $i++) {
                                        ?>
                                            <option value="<?php echo $luser[$i][0]; ?>"><?php echo $luser[$i][2]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">Tahap 6 - Tentukan Produk Hasil Cutting</button>
                    </h2>
                    <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSix" data-bs-parent="#accordionPanelsStayOpenExample">
                        <div class="accordion-body">
                            <div class="my-2">
                                <strong for="" class="mr-3">Hasil Cutting Random ?</strong>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rdo-ahcut" id="rdo-ahcut-yes" value="Y" checked>
                                    <label class="form-check-label" for="rdo-ahcut-yes">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rdo-ahcut" id="rdo-ahcut-no" value="N">
                                    <label class="form-check-label" for="rdo-ahcut-no">Tidak</label>
                                </div>
                            </div>
                            <div class="d-none" id="div-hcut">
                                <div class="my-1"><button class="btn btn-sm btn-primary btn-chpro btn-spro4" data-value="lst-tpro-cut" data-target="#mdl-spro4" data-toggle="modal"><img src="./bin/img/icon/plus-wh.png" width="15" alt="Add" style="margin-top:-5px"> <span class="">Pilih Produk</span></button></div>
                                <div class="table table-responsive mxh-40vh">
                                    <table class="table table-sm table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="border sticky-top align-middle">Kode</th>
                                                <th class="border sticky-top align-middle">Nama</th>
                                                <th class="border sticky-top align-middle">Grade</th>
                                                <th class="border sticky-top align-middle">Oz</th>
                                                <th class="border sticky-top align-middle">Cut Style</th>
                                                <th class="border sticky-top align-middle text-right">%</th>
                                                <th class="border sticky-top align-middle">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="lst-tpro-cut"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeven">Tahap 7 - Setting Hasil Cutting</button>
                    </h2>
                    <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSeven" data-bs-parent="#accordionPanelsStayOpenExample">
                        <div class="accordion-body">
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">User yang melakukan input</div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <select name="slct-user-vac" id="slct-user-vac" class="custom-select">
                                        <?php
                                        $luser = getAllUser();

                                        for ($i = 0; $i < count($luser); $i++) {
                                        ?>
                                            <option value="<?php echo $luser[$i][0]; ?>"><?php echo $luser[$i][2]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-100 text-right mt-3 mb-1">
                <div class="form-check form-switch my-1">
                    <input class="form-check-input" type="checkbox" role="switch" id="chk-ocut">
                    <label class="form-check-label small" for="chk-ocut">Cutting Tanpa Penerimaan</label>
                </div>
                <div class="form-check form-switch my-1">
                    <input class="form-check-input" type="checkbox" role="switch" id="chk-dpd-hcut">
                    <label class="form-check-label small" for="chk-dpd-hcut">Produk yang diterima merupakan hasil cutting</label>
                </div>
                <div class="form-check form-switch my-1">
                    <input class="form-check-input" type="checkbox" role="switch" id="chk-dpd">
                    <label class="form-check-label small" for="chk-dpd">Hapus data lama pada tanggal terpilih</label>
                </div>
            </div>

            <div class="w-100 text-right mt-2 mb-3">
                <span class="text-danger small mr-2 d-none" id="div-err-at-trm-1">** Total berat tidak sesuai</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-trm-2">** Harap memilih data produk</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-trm-3">** Harap memilih data supplier</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-trm-4">** Harap menetapkan tanggal transaksi</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-trm-5">** Total persentase semua produk wajib 100%</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-trm-6">** Harap memilih hasil produk cutting</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-trm-7">** Total persentase produk hasil cutting wajib 100%</span>
                <span class="text-success small mr-2 d-none" id="div-err-at-scs-1">- Generate data berhasil -</span>
                <button class="btn btn-sm btn-success" id="btn-sat-trm" data-cpro="0" data-cpro2="0" data-csup="0" data-cdate="0">Generate</button>
            </div>
        </div>

        <div class="mt-2 d-none" id="nav-krm">
            <div class="row m-0 d-none">
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 bg-light my-2 py-2 rounded">
                    <label for="txt-sw-krm">Total Berat (KG) <span class="text-danger small">Total berat akan disesuaikan dengan jumlah berat dari P/O yang sudah di-input sebelumnya pada tanggal yang ditentukan</span></label>
                    <input type="text" class="form-control cformat d-none" id="txt-sw-krm" autocomplete="off">
                </div>
            </div>

            <div class="accordion accordion-flush" id="accordionPanelsStayOpenExample2">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingZero">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseZero2" aria-expanded="true" aria-controls="panelsStayOpen-collapseZero2">Tahap 1 - Tentukan P/O</button>
                    </h2>
                    <div id="panelsStayOpen-collapseZero2" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingZero" data-bs-parent="#accordionPanelsStayOpenExample2">
                        <div class="accordion-body">
                            <div class="my-1"><button class="btn btn-sm btn-primary" data-target="#mdl-spo2" data-toggle="modal"><img src="./bin/img/icon/plus-wh.png" width="15" alt="Add" style="margin-top:-5px"> <span class="">Pilih P/O</span></button></div>
                            <div class="table table-responsive mxh-40vh">
                                <table class="table table-sm table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="border sticky-top align-middle">No P/O</th>
                                            <th class="border sticky-top align-middle">Tgl Kirim</th>
                                            <th class="border sticky-top align-middle text-right">Qty (KG)</th>
                                            <th class="border sticky-top align-middle">Customer</th>
                                            <th class="border sticky-top align-middle">Tgl Mulai Packing</th>
                                            <th class="border sticky-top align-middle">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="lst-tpo-krm"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne2" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne2">Tahap 2 - Tentukan Produk</button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne2" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne" data-bs-parent="#accordionPanelsStayOpenExample2">
                        <div class="accordion-body">
                            <div class="my-2">
                                <strong for="" class="mr-3">Produk yang di kirim random ?</strong>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rdo-pkrm" id="rdo-pkrm-yes" value="Y" checked>
                                    <label class="form-check-label" for="rdo-pkrm-yes">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rdo-pkrm" id="rdo-pkrm-no" value="N">
                                    <label class="form-check-label" for="rdo-pkrm-no">Tidak</label>
                                </div>
                            </div>
                            <div id="div-pkrm" class="d-none">
                                <div class="my-1"><button class="btn btn-sm btn-primary btn-chpro btn-spro4" data-value="lst-tpro-krm" data-target="#mdl-spro4" data-toggle="modal"><img src="./bin/img/icon/plus-wh.png" width="15" alt="Add" style="margin-top:-5px"> <span class="">Pilih Produk</span></button></div>
                                <div class="table table-responsive mxh-40vh">
                                    <table class="table table-sm table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="border sticky-top align-middle">Kode</th>
                                                <th class="border sticky-top align-middle">Nama</th>
                                                <th class="border sticky-top align-middle">Grade</th>
                                                <th class="border sticky-top align-middle">Oz</th>
                                                <th class="border sticky-top align-middle">Cut Style</th>
                                                <th class="border sticky-top align-middle text-right">Jlh Stok Saat Ini</th>
                                                <th class="border sticky-top align-middle text-right">%</th>
                                                <th class="border sticky-top align-middle text-right d-none">Jlh Packaging</th>
                                                <th class="border sticky-top align-middle">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="lst-tpro-krm"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item d-none">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo2" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo2">Tahap 3 - Tentukan Customer</button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo2" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo" data-bs-parent="#accordionPanelsStayOpenExample2">
                        <div class="accordion-body">
                            <div class="my-2">
                                <strong for="" class="mr-3">Semua Customer ?</strong>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rdo-acus" id="rdo-acus-yes" value="Y" checked>
                                    <label class="form-check-label" for="rdo-acus-yes">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rdo-acus" id="rdo-acus-no" value="N">
                                    <label class="form-check-label" for="rdo-acus-no">Tidak</label>
                                </div>
                            </div>
                            <div class="d-none" id="div-scus">
                                <div class="my-1"><button class="btn btn-sm btn-primary btn-chcus" data-value="lst-tcus-trm" data-target="#mdl-scus2" data-toggle="modal"><img src="./bin/img/icon/plus-wh.png" width="15" alt="Add" style="margin-top:-5px"> <span class="">Pilih Customer</span></button></div>
                                <div class="table table-responsive mxh-40vh">
                                    <table class="table table-sm table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="border sticky-top align-middle">Kode</th>
                                                <th class="border sticky-top align-middle">Nama</th>
                                                <th class="border sticky-top align-middle">Alamat</th>
                                                <th class="border sticky-top align-middle">Wilayah</th>
                                                <th class="border sticky-top align-middle">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="lst-tcus-krm"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree2" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree2">Tahap 3 - Tentukan Tanggal Transaksi</button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree2" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree" data-bs-parent="#accordionPanelsStayOpenExample2">
                        <div class="accordion-body">
                            <div class="row mb-2">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <label for="dte-frm">Dari Tanggal</label>
                                    <input type="date" class="form-control" id="dte-frm-krm">
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <label for="dte-frm">Sampai Tanggal</label>
                                    <input type="date" class="form-control" id="dte-to-krm">
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 d-flex align-items-end">
                                    <div class="">
                                        <button class="btn btn-primary" id="btn-sat-date-krm">Set</button>
                                    </div>
                                </div>
                            </div>

                            <div class="my-2 d-none" id="div-tdate-krm">
                                <hr>
                                <h6>Daftar Tanggal</h6>
                                <div class="row" id="lst-tdate-krm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour2" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour2">Tahap 4 - Settingan Packaging</button>
                    </h2>
                    <div id="panelsStayOpen-collapseFour2" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour" data-bs-parent="#accordionPanelsStayOpenExample2">
                        <div class="accordion-body">
                            <div class="row my-2 d-none">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Range Jlh P/O</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2"><input type="number" class="form-control" id="nmbr-pofrm" step="1" value="1"></div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 col-xl-1 d-flex align-items-center">
                                    <div class="text-center w-100">To</div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2"><input type="number" class="form-control" id="nmbr-poto" step="1" value="3"></div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Kurs (Rp)</div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <input type="text" class="form-control cformat text-right" id="txt-kurs" value="0">
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">Sisa Stock (Rp)</div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <input type="text" class="form-control cformat text-right" id="txt-sstk" value="0">
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 d-flex align-items-center">
                                    <div class="small">User yang melakukan input</div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <select name="slct-user-krm" id="slct-user-krm" class="custom-select">
                                        <?php
                                        $luser = getAllUser();

                                        for ($i = 0; $i < count($luser); $i++) {
                                        ?>
                                            <option value="<?php echo $luser[$i][0]; ?>"><?php echo $luser[$i][2]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-100 text-right mt-3 mb-1">
                <div class="form-check form-switch my-1">
                    <input class="form-check-input" type="checkbox" role="switch" id="chk-dpd-krm">
                    <label class="form-check-label small" for="chk-dpd-krm">Hapus data lama pada P/O terpilih</label>
                </div>
            </div>

            <div class="w-100 text-right mt-2 mb-3">
                <span class="text-danger small mr-2 d-none" id="div-err-at-krm-1">** Total berat tidak valid</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-krm-2">** Harap memilih data produk</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-krm-3">** Harap memilih data customer</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-krm-4">** Harap menetapkan tanggal transaksi</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-krm-5">** Total persentase semua produk wajib 100%</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-krm-6">** Harap memilih data P/O</span>
                <span class="text-danger small mr-2 d-none" id="div-err-at-krm-7">** Tanggal mulai packing tidak valid</span>
                <span class="text-success small mr-2 d-none" id="div-scs-at-krm-1">- Generate data berhasil -</span>
                <button class="btn btn-sm btn-success" id="btn-sat-krm" data-cpro="0" data-ccus="0" data-cdate="0" data-cpo="0">Generate</button>
            </div>
        </div>

        <div class="lmodals">
            <?php
            require("./modals/mdl-spro4.php");
            require("./modals/mdl-ssup2.php");
            require("./modals/mdl-scus2.php");
            require("./modals/mdl-spo2.php");
            ?>
        </div>
    </div>
</body>

</html>