<div class="modal fade" id="mdl-nsup" tabindex="-1" role="dialog" aria-labelledby="mdl-nsup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-sup-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-sup-2">Terdapat data supplier dengan ID ini !!!</div>

                <div class="alert alert-danger d-none" id="div-err-sup-3">Format email tidak valid !!!</div>

                <div class="alert alert-success d-none" id="div-scs-sup-1">Supplier berhasil ditambahkan !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id-sup" name="txt-id-sup" placeholder="" autocomplete="off" maxlength="25"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-sup" name="txt-nma-sup" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Alamat</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-addr-sup" name="txt-addr-sup" placeholder="" autocomplete="off" maxlength="200"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Wilayah</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-reg-sup" name="txt-reg-sup" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tel</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-phone-sup" name="txt-phone-sup" placeholder="" autocomplete="off" maxlength="50"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tel 2</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-phone2-sup" name="txt-phone2-sup" placeholder="" autocomplete="off" maxlength="50"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Email</span></div>
                    <div class="col-9"><input type="email" class="form-control inp-set" id="txt-mail-sup" name="txt-mail-sup" placeholder="" autocomplete="off" maxlength="50"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Jenis</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set text-uppercase" id="txt-ket-sup" name="txt-ket-sup" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Badan Usaha</span></div>
                    <div class="col-9">
                        <select name="txt-ket2-sup" id="txt-ket2-sup" class="custom-select">
                            <option value="Y">Ya</option>
                            <option value="N">No / Bukan</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket3-sup" name="txt-ket3-sup" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Simpanan Awal</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-smpn-sup" name="txt-smpn-sup" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snsup">Simpan</button>
            </div>
        </div>
    </div>
</div>