<div class="modal fade" id="mdl-nkrm-pro" tabindex="-1" role="dialog" aria-labelledby="mdl-nkrm-pro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Packaging - Produk</h5>
                <button type="button" class="close mdl-cls" data-dismiss="modal" aria-label="Close" data-target="" data-toggle="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-krm-pro-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-success d-none" id="div-scs-krm-pro-1">Produk berhasil ditambah !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">No P/O</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control inp-set" id="edt-txt-po" name="edt-txt-po" placeholder="" autocomplete="off" maxlength="100" readonly>

                            <div class="input-group-append">
                                <button class="btn btn-light border" type="button" data-value="#mdl-nkrm-pro" data-target="#mdl-spo" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                            </div>
                        </div>
                    </div>
                </div><hr>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Produk</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control inp-set" id="txt-nma-pro2" name="txt-nma-pro2" placeholder="" autocomplete="off" maxlength="100" readonly>
                            <input type="text" class="d-none" id="txt-pro2">
                            <input type="text" class="d-none" id="txt-krm-type-pro">

                            <div class="input-group-append">
                                <button class="btn btn-light border" type="button" data-value="#mdl-nkrm-pro" data-target="#mdl-spro3" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-grade2" name="txt-nma-grade2" placeholder="" autocomplete="off" readonly></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-kate2" name="txt-nma-kate2" placeholder="" autocomplete="off" readonly></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-skate2" name="txt-nma-skate2" placeholder="" autocomplete="off" readonly></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Qty</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="number" class="form-control inp-set" id="txt-qty2" name="txt-qty2" placeholder="" autocomplete="off" step="any">
                            <div class="input-group-append">
                                <select name="slct-sat2" id="slct-sat2" class="custom-select">
                                    <option value="BOX">BOX</option>
                                    <option value="BAG">BAG</option>
                                    <option value="PCS">PCS</option>
                                    <option value="EKOR">EKOR</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tgl Exp</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tglexp2" name="dte-tglexp2" placeholder="" autocomplete="off" step="any"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Qty (KG)</span></div>
                    <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight2" name="txt-weight2" placeholder="" autocomplete="off" step="any" value="0"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Keterangan</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set text-uppercase" id="txt-ket2" name="txt-ket2" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snkrm-pro">Simpan</button>
            </div>
        </div>
    </div>
</div>