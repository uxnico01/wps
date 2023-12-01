<div class="modal fade" id="mdl-npro-mp" tabindex="-1" role="dialog" aria-labelledby="mdl-npro-mp" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-emp" data-toggle="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-mp-pro-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-success d-none" id="div-scs-mp-pro-1">Produk berhasil ditambahkan !!!</div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Produk</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="edt-txt-nma-pro2" name="edt-txt-nma-pro2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="edt-txt-pro2">

                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-spro3" type="button" data-target="#mdl-spro3" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
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
                                    <input type="text" class="form-control" id="edt-txt-nma-grade2" name="edt-txt-nma-grade2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="edt-txt-nma-kate2" name="edt-txt-nma-kate2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="edt-txt-nma-skate2" name="edt-txt-nma-skate2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat (KG)</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="edt-txt-weight" name="edt-txt-weight" placeholder="" autocomplete="off" step="any"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-ket" name="edt-txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-semp-pro">Simpan</button>
            </div>
        </div>
    </div>
</div>