<div class="modal fade" id="mdl-nskate" tabindex="-1" role="dialog" aria-labelledby="mdl-nskate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Cut Style</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-skate-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-skate-2">Terdapat data cut style dengan ID ini !!!</div>

                <div class="alert alert-danger d-none" id="div-err-skate-3">Data kategori tidak ditemukan !!!</div>

                <div class="alert alert-success d-none" id="div-scs-skate-1">Cut Style berhasil ditambahkan !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id-skate" name="txt-id-skate" placeholder="" autocomplete="off" maxlength="25"></div>
                </div>

                <div class="row mt-2 d-none">
                    <div class="col-3 mt-1"><span class="h6">Kategori</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control inp-set" id="txt-nma-kate" name="txt-nma-kate" placeholder="" autocomplete="off" maxlength="100" readonly>
                            <input type="text" class="d-none" id="txt-kate">

                            <div class="input-group-append">
                                <button class="btn btn-light border" type="button" data-value="#mdl-nskate" data-target="#mdl-skate" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-skate" name="txt-nma-skate" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket-skate" name="txt-ket-kate" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snskate">Simpan</button>
            </div>
        </div>
    </div>
</div>