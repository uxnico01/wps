<div class="modal fade" id="mdl-nmv" tabindex="-1" role="dialog" aria-labelledby="mdl-nmv" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pindah Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-none">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id" name="txt-id" placeholder="" autocomplete="off" maxlength="25"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Kepada</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-to" name="txt-to" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Dari Gdg</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <select name="slct-gdgf" id="slct-gdgf" class="custom-select">
                                    <?php
                                    $lgdg = getAllGdg($db);
                                    for ($i = 0; $i < count($lgdg); $i++) {
                                    ?>
                                        <option value="<?php echo $lgdg[$i][0]; ?>"><?php echo $lgdg[$i][1]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ke Gdg</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <select name="slct-gdgt" id="slct-gdgt" class="custom-select">
                                    <?php
                                    $lgdg = getAllGdg($db);
                                    for ($i = 0; $i < count($lgdg); $i++) {
                                    ?>
                                        <option value="<?php echo $lgdg[$i][0]; ?>"><?php echo $lgdg[$i][1]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Jenis</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <select name="slct-tipe" id="slct-tipe" class="custom-select">
                                    <option value="">Pilih Jenis</option>
                                    <option value="I">Penitipan</option>
                                    <option value="O">Pengambilan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Deskripsi</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket" name="txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 my-2 p-0">
                    <button class="btn btn-light border border-success btn-mv-pro" id="btn-nmv-pro"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Tambah Produk</span></button>
                </div>

                <div class="table-responsive my-2 mxh-60vh">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top align-middle w-200px">Produk</th>
                                <th class="border sticky-top align-middle text-right w-80px">Qty</th>
                                <th class="border sticky-top align-middle w-100px">Satuan</th>
                                <th class="border sticky-top align-middle text-right w-80px">Berat</th>
                                <th class="border sticky-top align-middle w-120px">Ket</th>
                                <th class="border sticky-top align-middle w-120px">Tgl Exp</th>
                                <th class="border sticky-top"></th>
                            </tr>
                        </thead>

                        <tbody id="lst-nmv">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-mv-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-mv-2">Terdapat data penerimaan dengan ID ini !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-mv-3">Data gudang awal tidak ditemukan !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-mv-4">Data gudang tujuan tidak ditemukan !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-mv-5">Harap masukkan produk yang dipindah !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-mv-6">Gudang awal dan gudang tujuan tidak boleh sama !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-mv-7">Terdapat qty produk yang tidak mencukupi pada gudang terpilih !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-mv-8">Terdapat qty produk yang tidak mencukupi pada gudang terpilih !!!</div>

                <div class="alert alert-success mb-0 mr-2 d-none" id="div-scs-mv-1">Pindah Stok berhasil ditambahkan !!!</div>

                <button type="button" class="btn btn-primary" id="btn-snmv" data-count="0">Simpan</button>
            </div>
        </div>
    </div>
</div>