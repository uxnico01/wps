<div class="modal fade" id="mdl-nkrm" tabindex="-1" role="dialog" aria-labelledby="mdl-nkrm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Packaging</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-krm-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-krm-2">No P/O tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-krm-3">Produk tidak ditemukan !!!</div>

                <div class="alert alert-success d-none" id="div-scs-krm-1">Packaging berhasil ditambahkan !!!</div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>" data-verif=""></div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">No P/O</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-po" name="txt-po" placeholder="" autocomplete="off" maxlength="25" readonly>

                                    <div class="input-group-append">
                                        <button class="btn btn-light border" type="button" data-value="#mdl-nkrm" data-target="#mdl-spo" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12"><hr></div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Produk</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-pro" name="txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="txt-pro">

                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-spro" type="button" data-value="#mdl-nkrm" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-grade" name="txt-nma-grade" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-kate" name="txt-nma-kate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-skate" name="txt-nma-skate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Qty</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="number" class="form-control inp-set" id="txt-qty" name="txt-qty" placeholder="" autocomplete="off" step="any">
                                    <div class="input-group-append">
                                        <select name="slct-sat" id="slct-sat" class="custom-select">
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
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tglexp" name="dte-tglexp" placeholder="" autocomplete="off" step="any"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat (KG)</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight" name="txt-weight" placeholder="" autocomplete="off" step="any"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Keterangan</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set text-uppercase" id="txt-ket" name="txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snkrm" data-count="0">Simpan</button>
            </div>
        </div>
    </div>
</div>