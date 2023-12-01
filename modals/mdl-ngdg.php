<div class="modal fade" id="mdl-ngdg" tabindex="-1" role="dialog" aria-labelledby="mdl-ngdg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Gudang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-gdg-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-gdg-2">Terdapat data Gudang dengan ID ini !!!</div>

                <div class="alert alert-success d-none" id="div-scs-gdg-1">Gudang berhasil ditambahkan !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id-gdg" name="txt-id-gdg" placeholder="" autocomplete="off" maxlength="25"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-gdg" name="txt-nma-gdg" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Alamat</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-addr-gdg" name="txt-addr-gdg" placeholder="" autocomplete="off" maxlength="250"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">PIC</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-pic-gdg" name="txt-pic-gdg" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tel</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-phone-gdg" name="txt-phone-gdg" placeholder="" autocomplete="off" maxlength="50"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-sngdg">Simpan</button>
            </div>
        </div>
    </div>
</div>