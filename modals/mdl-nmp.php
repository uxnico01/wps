<div class="modal fade" id="mdl-nmp" tabindex="-1" role="dialog" aria-labelledby="mdl-nmp" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Masuk Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-mp-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-success d-none" id="div-scs-mp-1">Masuk Produk berhasil ditambahkan !!!</div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>"></div>
                        </div>
                    </div>
                </div><hr>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Produk</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-pro2" name="txt-nma-pro2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="txt-pro2">

                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-spro3" type="button" data-value="#mdl-nmp" data-target="#mdl-spro3" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-grade2" name="txt-nma-grade2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-kate2" name="txt-nma-kate2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-skate2" name="txt-nma-skate2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat (KG)</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight" name="txt-weight" placeholder="" autocomplete="off" step="any"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket" name="txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snmp">Simpan</button>
            </div>
        </div>
    </div>
</div>