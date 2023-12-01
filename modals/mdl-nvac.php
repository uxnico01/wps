<div class="modal fade" id="mdl-nvac" tabindex="-1" role="dialog" aria-labelledby="mdl-nvac" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Vacuum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-vac-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-vac-2">Data bahan tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-vac-3">Berat bahan pertama melebihi sisa stock !!!</div>

                <div class="alert alert-danger d-none" id="div-err-vac-4">Berat bahan kedua melebihi sisa stock !!!</div>

                <div class="alert alert-danger d-none" id="div-err-vac-5">Tidak ada cutting pada tanggal yang di pilih !!!</div>

                <div class="alert alert-success d-none" id="div-scs-vac-1">Vacuum berhasil ditambahkan !!!</div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>" data-verif=""></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Type</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <select name="slct-type" id="slct-type" class="custom-select">
                                    <option value="1">Dari Cutting</option>
                                    <option value="2">Dari Bahan Sjd</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row d-none" id="div-ptype">
                    <div class="col-12"><hr><h5>Bahan Setengah Jadi</h5></div>
                    <div class="row mx-0">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="row mt-2">
                                <div class="col-3 mt-1"><span class="h6">Bhn Sjd 1</span><span class="text-danger">*</span></div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control inp-set" id="txt-nma-pro" name="txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                                        <input type="text" class="d-none" id="txt-pro">

                                        <div class="input-group-append">
                                            <button class="btn btn-light border btn-spro2" type="button" data-value="#mdl-nvac" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
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
                            
                            <div class="row mt-2">
                                <div class="col-3 mt-1"><span class="h6">Berat (KG)</span><span class="text-danger">*</span></div>
                                <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight-pro" name="txt-weight-pro" placeholder="" autocomplete="off" step="any"></div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="row mt-2">
                                <div class="col-3 mt-1"><span class="h6">Bhn Sjd 2</span></div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control inp-set" id="txt-nma-pro3" name="txt-nma-pro3" placeholder="" autocomplete="off" maxlength="100" readonly>
                                        <input type="text" class="d-none" id="txt-pro3">

                                        <div class="input-group-append">
                                            <button class="btn btn-light border btn-spro6" type="button" data-value="#mdl-nvac" data-target="#mdl-spro6" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                        </div>

                                        <div class="input-group-append">
                                            <button class="btn btn-light border btn-rvpro2" type="button" data-value="N"><img src="./bin/img/icon/refresh.png" width="20" alt="Refresh"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="txt-nma-grade3" name="txt-nma-grade3" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="txt-nma-kate3" name="txt-nma-kate3" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="txt-nma-skate3" name="txt-nma-skate3" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-3 mt-1"><span class="h6">Berat (KG)</span></div>
                                <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight-pro3" name="txt-weight-pro3" placeholder="" autocomplete="off" step="any"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket-pro" name="txt-ket-pro" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tahap Ke</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="txt-thp" name="txt-thp" placeholder="" autocomplete="off" step="1" max="100"></div>
                        </div>
                    </div>
                </div>

                <div class="row" id="div-ctype">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl Cut</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set dte-ctgl" id="dte-ctgl" name="dte-ctgl" placeholder="" autocomplete="off" data-value="" value="<?php echo date('Y-m-d');?>"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Hsl Cut</span></div>
                            <div class="col-9">
                                <select name="slct-hcut" id="slct-hcut" class="custom-select slct-hcut">
                                    <option value="0">Semua</option>
                                <?php
                                    if(getHCutTgl(date('Y-m-d')) > 0)
                                    {
                                ?>
                                    <option value="1">Non-Vitamin</option>
                                    <option value="2">Vitamin</option>
                                <?php
                                    }
                                ?>
                                </select>    
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket Cutting</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket-cpro" name="txt-ket-cpro" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tahap Ke</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="txt-thp-cpro" name="txt-thp-cpro" placeholder="" autocomplete="off" step="1" max="100"></div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5>Hasil Vaccum</h5>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Produk</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-pro2" name="txt-nma-pro2" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="txt-pro2">

                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-spro3" type="button" data-value="#mdl-nvac" data-target="#mdl-spro3" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
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

                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat Fresh (KG)</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-weight-fsh" name="txt-weight-fsh" placeholder="" autocomplete="off" step="any" readonly></div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat Defroze (KG)</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-weight-dfz" name="txt-weight-dfz" placeholder="" autocomplete="off" step="any" readonly></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2" id="div-grd-bb">
                            <div class="col-3 mt-1"><span class="h6">Grade Bahan Baku</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <select name="slct-grd" id="slct-grd" class="custom-select">
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat (KG)</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight" name="txt-weight" placeholder="" autocomplete="off" step="any"></div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket" name="txt-ket" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snvac">Simpan</button>
            </div>
        </div>
    </div>
</div>