<div class="modal fade" id="mdl-nsaw" tabindex="-1" role="dialog" aria-labelledby="mdl-nsaw" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sawing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-saw-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-saw-2">Data bahan tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-saw-3">Data bahan / hasil produk harus di-isi !!!</div>

                <div class="alert alert-success d-none" id="div-scs-saw-1">Sawing berhasil ditambahkan !!!</div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>"></div>
                        </div>
                        <hr>
                    </div>
                    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Bahan Baku</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-pro" name="txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="txt-pro">

                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-spro2" type="button" data-value="#mdl-nsaw" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="txt-nma-grade" name="txt-nma-grade" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="txt-nma-kate" name="txt-nma-kate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="txt-nma-skate" name="txt-nma-skate" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-none">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat (KG)</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight-pro" name="txt-weight-pro" placeholder="" autocomplete="off" step="any"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tahap Ke</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="txt-thp" name="txt-thp" placeholder="" autocomplete="off" step="1" max="100"></div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket" name="txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5>Hasil Sawing</h5>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Produk</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-pro2" name="txt-nma-pro2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="txt-pro2">

                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-spro3" type="button" data-value="#mdl-nsaw" data-target="#mdl-spro3" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-grade2" name="txt-nma-grade2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-kate2" name="txt-nma-kate2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-skate2" name="txt-nma-skate2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat Saat Ini (KG)</span></div>
                            <div class="col-9"><input type="text" class="form-control cformat" id="txt-weight-now" name="txt-weight-now" placeholder="" autocomplete="off" readonly></div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat (KG)</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight" name="txt-weight" placeholder="" autocomplete="off" step="any"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snsaw">Simpan</button>
            </div>
        </div>
    </div>
</div>