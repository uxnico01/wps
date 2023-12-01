<div class="modal fade" id="mdl-nkates" tabindex="-1" role="dialog" aria-labelledby="mdl-nkates" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-kates-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-kates-2">Terdapat data kategori dengan ID ini !!!</div>

                <div class="alert alert-success d-none" id="div-scs-kates-1">Kategori berhasil ditambahkan !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id-kates" name="txt-id-kates" placeholder="" autocomplete="off" maxlength="25"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-kates" name="txt-nma-kates" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Melalui Proses Cutting</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <select name="slct-cut-kates" id="slct-cut-kates" class="custom-select">
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snkates">Simpan</button>
            </div>
        </div>
    </div>
</div>