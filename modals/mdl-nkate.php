<div class="modal fade" id="mdl-nkate" tabindex="-1" role="dialog" aria-labelledby="mdl-nkate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Oz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-kate-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-kate-2">Terdapat data oz dengan ID ini !!!</div>

                <div class="alert alert-success d-none" id="div-scs-kate-1">Oz berhasil ditambahkan !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id-kate" name="txt-id-kate" placeholder="" autocomplete="off" maxlength="25"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-kate" name="txt-nma-kate" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket-kate" name="txt-ket-kate" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snkate">Simpan</button>
            </div>
        </div>
    </div>
</div>