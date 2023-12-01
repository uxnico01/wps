<div class="modal fade" id="mdl-ncus" tabindex="-1" role="dialog" aria-labelledby="mdl-ncus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-cus-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-cus-2">Terdapat data Customer dengan ID ini !!!</div>

                <div class="alert alert-danger d-none" id="div-err-cus-3">Format email tidak valid !!!</div>

                <div class="alert alert-success d-none" id="div-scs-cus-1">Customer berhasil ditambahkan !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id-cus" name="txt-id-cus" placeholder="" autocomplete="off" maxlength="25"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-cus" name="txt-nma-cus" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Alamat</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-addr-cus" name="txt-addr-cus" placeholder="" autocomplete="off" maxlength="200"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Wilayah</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-reg-cus" name="txt-reg-cus" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tel</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-phone-cus" name="txt-phone-cus" placeholder="" autocomplete="off" maxlength="50"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tel 2</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-phone2-cus" name="txt-phone2-cus" placeholder="" autocomplete="off" maxlength="50"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Email</span></div>
                    <div class="col-9"><input type="email" class="form-control inp-set" id="txt-mail-cus" name="txt-mail-cus" placeholder="" autocomplete="off" maxlength="50"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket-cus" name="txt-ket-cus" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket2</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket2-cus" name="txt-ket2-cus" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket3</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket3-cus" name="txt-ket3-cus" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-sncus">Simpan</button>
            </div>
        </div>
    </div>
</div>