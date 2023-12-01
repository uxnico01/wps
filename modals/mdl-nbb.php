<div class="modal fade" id="mdl-nbb" tabindex="-1" role="dialog" aria-labelledby="mdl-nbb" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah BB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-bb-1">Harap isi semua data dengan tanda * !!!</div>
                
                <div class="alert alert-success d-none" id="div-scs-bb-1">Transaksi berhasil ditambahkan !!!</div>

                <div class="row mt-2 d-none">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id" name="txt-id" placeholder="" autocomplete="off" maxlength="25"></div>
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
                    <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket" name="txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Jenis</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <select name="slct-jns" id="slct-jns" class="custom-select">
                            <option value="OUT">Kurang</option>
                            <option value="IN">Tambah</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snbb">Simpan</button>
            </div>
        </div>
    </div>
</div>