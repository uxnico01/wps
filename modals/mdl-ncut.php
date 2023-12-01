<div class="modal fade" id="mdl-ncut" tabindex="-1" role="dialog" aria-labelledby="mdl-ncut" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Cutting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-cut-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-cut-2">Data penerimaan tidak ditemukan !!!</div>

                <div class="alert alert-success d-none" id="div-scs-cut-1">Cutting berhasil ditambah !!!</div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl Cut</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>"></div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Supplier</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-sup" name="txt-nma-sup" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="txt-sup">

                                    <div class="input-group-append">
                                        <button class="btn btn-light border" type="button" data-value="#mdl-ncut" data-target="#mdl-ssup" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl Terima</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <input type="date" class="form-control" id="dte-tgl-trm" name="dte-tgl-trm" placeholder="" value="<?php echo date('Y-m-d');?>">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Produk</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="txt-nma-pro" name="txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="txt-pro">
                                    
                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-spro" type="button" data-value="#mdl-ncut" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                            <div class="col-9"><input type="text" class="form-control" id="txt-nma-grade" name="txt-nma-grade" placeholder="" autocomplete="off" readonly></div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat (KG)</span> <span class="text-danger">*</span></div>
                            <div class="col-9">
                                <select name="slct-weight" id="slct-weight" class="custom-select">
                                    <option value="" data-value="" data-value2="">Tidak ada penerimaan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Cut 1 (KG)</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-cut1" name="txt-cut1" placeholder="" autocomplete="off">
                                    <div class="input-group-append">
                                        <select name="slct-cut-1" id="slct-cut-1" class="custom-select">
                                            <option value="F">F</option>
                                            <option value="SP">SP</option>
                                            <option value="ST">ST</option>
                                            <option value="M">M</option>
                                            <option value="B">B</option>
                                            <option value="Vit">Vit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Cut 2 (KG)</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-cut2" name="txt-cut2" placeholder="" autocomplete="off">
                                    <div class="input-group-append">
                                        <select name="slct-cut-2" id="slct-cut-2" class="custom-select">
                                            <option value="F">F</option>
                                            <option value="SP">SP</option>
                                            <option value="ST">ST</option>
                                            <option value="M">M</option>
                                            <option value="B">B</option>
                                            <option value="Vit">Vit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Cut 3 (KG)</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-cut3" name="txt-cut3" placeholder="" autocomplete="off">
                                    <div class="input-group-append">
                                        <select name="slct-cut-3" id="slct-cut-3" class="custom-select">
                                            <option value="F">F</option>
                                            <option value="SP">SP</option>
                                            <option value="ST">ST</option>
                                            <option value="M">M</option>
                                            <option value="B">B</option>
                                            <option value="Vit">Vit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Cut 4 (KG)</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-cut4" name="txt-cut4" placeholder="" autocomplete="off">
                                    <div class="input-group-append">
                                        <select name="slct-cut-4" id="slct-cut-4" class="custom-select">
                                            <option value="F">F</option>
                                            <option value="SP">SP</option>
                                            <option value="ST">ST</option>
                                            <option value="M">M</option>
                                            <option value="B">B</option>
                                            <option value="Vit">Vit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 d-none">
                            <div class="col-3 mt-1"><span class="h6">Cut 5 (KG)</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-cut5" name="txt-cut5" placeholder="" autocomplete="off">
                                    <div class="input-group-append">
                                        <select name="slct-cut-5" id="slct-cut-5" class="custom-select">
                                            <option value="F">F</option>
                                            <option value="SP">SP</option>
                                            <option value="ST">ST</option>
                                            <option value="M">M</option>
                                            <option value="B">B</option>
                                            <option value="Vit">Vit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 d-none">
                            <div class="col-3 mt-1"><span class="h6">Cut 6 (KG)</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-cut6" name="txt-cut6" placeholder="" autocomplete="off">
                                    <div class="input-group-append">
                                        <select name="slct-cut-6" id="slct-cut-6" class="custom-select">
                                            <option value="F">F</option>
                                            <option value="SP">SP</option>
                                            <option value="ST">ST</option>
                                            <option value="M">M</option>
                                            <option value="B">B</option>
                                            <option value="Vit">Vit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                            <div class="col-9">
                                <input type="text" class="form-control inp-set" id="txt-ket" name="txt-ket" placeholder="" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">No Sample</span></div>
                            <div class="col-9">
                                <input type="number" class="form-control inp-set" id="nmbr-smpl" name="nmbr-smpl" placeholder="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="lscript">
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#dte-tgl").change(function(){
                                getSmplCut();
                            })
                        });
                    </script>
                </div>
                <button type="button" class="btn btn-primary" id="btn-sncut">Simpan</button>
            </div>
        </div>
    </div>
</div>