<div class="modal fade" id="mdl-ntrm" tabindex="-1" role="dialog" aria-labelledby="mdl-ntrm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-80p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penerimaan <button class="btn btn-light border btn-vttrm" data-value="#mdl-ntrm" data-dismiss="modal"><img src="./bin/img/icon/temporary-icon.png" alt="Temporary" width="20"></button><br></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-trm-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-trm-2">Terdapat data penerimaan dengan ID ini !!!</div>

                <div class="alert alert-danger d-none" id="div-err-trm-3">Data supplier tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-trm-4">Potongan tidak boleh melebihi pinjaman !!!</div>

                <div class="alert alert-danger d-none" id="div-err-trm-5">Harap masukkan produk yang diterima !!!</div>

                <div class="alert alert-success d-none" id="div-scs-trm-1">Penerimaan berhasil ditambahkan !!!</div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-none">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id" name="txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="form-control d-none" id="txt-asid" name="txt-asid" placeholder="" autocomplete="off" maxlength="25"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>"></div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Supplier</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-sup" name="txt-nma-sup" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="txt-sup">

                                    <div class="input-group-append">
                                        <button class="btn btn-light border" type="button" data-value="#mdl-ntrm" data-target="#mdl-ssup" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket1</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket1" name="txt-ket1" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket2</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket2" name="txt-ket2" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket3</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket3" name="txt-ket3" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Kota</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-kota" name="txt-kota" placeholder="" autocomplete="off" maxlength="50"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-2 p-0">
                    <button class="btn btn-light border border-success btn-trm-pro" id="btn-ntrm-pro" data-dismiss="modal" data-value="#mdl-npnrm"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Pilih Produk</span></button>
                    <br><strong class="small" id="str-asave"></strong>
                </div>

                <div class="table-responsive mb-2 mt-1 mxh-60vh">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top align-middle">Produk</th>
                                <th class="border sticky-top align-middle">Grade</th>
                                <th class="border sticky-top align-middle">Oz</th>
                                <th class="border sticky-top align-middle">Cut Style</th>
                                <th class="border sticky-top align-middle">Satuan</th>
                                <th class="border sticky-top align-middle text-right">Berat</th>
                                <th class="border sticky-top align-middle text-right">Harga</th>
                                <th class="border sticky-top align-middle text-right">Simpanan</th>
                                <th class="border sticky-top"></th>
                            </tr>
                        </thead>

                        <tbody id="lst-ntrm">

                        </tbody>
                    </table>
                </div>

                <div class="table-responsive my-2">
                    <table class="table table-sm table-striped mb-0">
                        <thead class="thead-dark" id="th-sntrm">

                        </thead>

                        <tbody id="lst-snpnrm">

                        </tbody>
                    </table>
                </div>

                <div class="row py-2 border-top">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">BB</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-bb" name="txt-bb" placeholder="" autocomplete="off"></div>

                            <div class="col-3 mt-1"><span class="h6">BB (Satuan)</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-bb2" name="txt-bb2" placeholder="" autocomplete="off">
                                    <input type="text" class="form-control inp-set cformat" id="txt-vbb" name="txt-vbb" placeholder="" autocomplete="off" readonly>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Poto</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-poto" name="txt-poto" placeholder="" autocomplete="off" data-value=""> <span class="text-danger small" id="spn-poto"></span></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">DLL</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-dll" name="txt-dll" placeholder="" autocomplete="off" maxlength="50" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-ldll" type="button" data-value="#mdl-ntrm" data-target="#mdl-ldll" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-dismiss="modal"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Poto Lainnya</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-pdll" name="txt-pdll" placeholder="" autocomplete="off" maxlength="50" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-lpdll" type="button" data-value="#mdl-ntrm" data-target="#mdl-lpdll" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-dismiss="modal"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Minum</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-mnm" name="txt-mnm" placeholder="" autocomplete="off" maxlength="50"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">DP</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-dp" name="txt-dp" placeholder="" autocomplete="off" maxlength="50">
                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-ldp" type="button" data-value="#mdl-ntrm" data-target="#mdl-ldp" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-dismiss="modal"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="offset-md-6 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Minus</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-min" name="txt-min" placeholder="" autocomplete="off" maxlength="50"></div>
                        </div>
                    </div>

                    <div class="offset-md-6 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tambahan Lainnya</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set cformat" id="txt-tdll" name="txt-tdll" placeholder="" autocomplete="off" maxlength="50" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-ltdll" type="button" data-value="#mdl-ntrm" data-target="#mdl-ltdll" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-dismiss="modal"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="d-flex w-100">
                    <button type="button" class="btn btn-secondary" id="btn-sttrm">Pending</button>
                    <button type="button" class="btn btn-warning ml-2 mr-auto" id="btn-rstrm">Reset</button>
                    <button type="button" class="btn btn-primary" id="btn-sntrm" data-count="0">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>