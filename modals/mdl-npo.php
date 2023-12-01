<div class="modal fade" id="mdl-npo" tabindex="-1" role="dialog" aria-labelledby="mdl-npo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah P/O</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-po-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-po-2">Terdapat data po dengan ID ini !!!</div>

                <div class="alert alert-danger d-none" id="div-err-po-3">Data customer tidak ditemukan !!!</div>

                <div class="alert alert-success d-none" id="div-scs-po-1">P/O berhasil ditambahkan !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id-po" name="txt-id-po" placeholder="" autocomplete="off" maxlength="25"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tgl Kirim</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" autocomplete="off" maxlength="100" value="<?php echo date('Y-m-d');?>"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Qty (KG)</span></div>
                    <div class="col-9"><input type="text" class="form-control cformat inp-set" id="txt-qty-po" name="txt-qty-po" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Customer</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control" id="txt-nma-cus" name="txt-nma-cus" placeholder="" autocomplete="off" maxlength="100" readonly>
                            <input type="text" class="d-none" id="txt-cus">

                            <div class="input-group-append">
                                <button class="btn btn-light border" type="button" data-value="#mdl-npo" data-target="#mdl-scus" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket" name="txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket2</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket2" name="txt-ket2" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tampil</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <select name="slct-tmpl" id="slct-tmpl" class="custom-select">
                            <option value="Y">Tampil</option>
                            <option value="N">Tidak Tampil</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 d-none">
                    <div class="col-3 mt-1"><span class="h6">Tampil Sampai Tgl</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="date" class="form-control inp-set" id="dte-dtgl" name="dte-dtgl" placeholder="" autocomplete="off" maxlength="100" value="<?php echo date('Y-m-d');?>"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snpo">Simpan</button>
            </div>
        </div>
    </div>
</div>