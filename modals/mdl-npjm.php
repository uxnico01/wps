<div class="modal fade" id="mdl-npjm" tabindex="-1" role="dialog" aria-labelledby="mdl-npjm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-pjm-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-pjm-2">Terdapat data peminjaman dengan ID ini !!!</div>

                <div class="alert alert-danger d-none" id="div-err-pjm-3">Data supplier tidak ditemukan !!!</div>

                <div class="alert alert-success d-none" id="div-scs-pjm-1">Peminjaman berhasil ditambahkan !!!</div>

                <div class="row mt-2 d-none">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id" name="txt-id" placeholder="" autocomplete="off" maxlength="25"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Supplier</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control inp-set" id="txt-nma-sup" name="txt-nma-sup" placeholder="" autocomplete="off" maxlength="100" readonly>
                            <input type="text" class="d-none" id="txt-sup">

                            <div class="input-group-append">
                                <button class="btn btn-light border" type="button" data-value="#mdl-npjm" data-target="#mdl-ssup" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" autocomplete="off" value="<?php echo date('Y-m-d');?>"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Jlh</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-jlh" name="txt-jlh" placeholder="" autocomplete="off"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Pot Lain</div>
                    <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-pot" name="txt-pot" placeholder="" autocomplete="off"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket1" name="txt-ket1" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket 2</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket2" name="txt-ket2" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Ket 3</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket3" name="txt-ket3" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snpjm">Simpan</button>
            </div>
        </div>
    </div>
</div>