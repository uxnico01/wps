<div class="modal fade" id="mdl-ntt" tabindex="-1" role="dialog" aria-labelledby="mdl-ntt" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tanda Terima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-tt-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-tt-2">Terdapat data penerimaan dengan ID ini !!!</div>

                <div class="alert alert-danger d-none" id="div-err-tt-3">Data supplier tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-tt-4">Potongan tidak boleh melebihi pinjaman !!!</div>

                <div class="alert alert-danger d-none" id="div-err-tt-5">Data penerimaan tidak ditemukan !!!</div>

                <div class="alert alert-success d-none" id="div-scs-tt-1">Tanda Terima berhasil ditambahkan !!!</div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">ID Trm</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-trm" name="txt-trm" placeholder="" autocomplete="off" maxlength="25" readonly>

                                    <div class="input-group-append">
                                        <button class="btn btn-light border" type="button" data-value="#mdl-ett" data-target="#mdl-strm" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id" name="txt-id" placeholder="" autocomplete="off" maxlength="25"><input type="text" class="d-none" id="txt-bid"></div>
                        </div>
                    </div>
                </div>

                <div class="row">

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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">BB</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-bb" name="txt-bb" placeholder="" autocomplete="off"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Poto</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-poto" name="txt-poto" placeholder="" autocomplete="off" data-value=""> <span class="text-danger small" id="spn-poto"></span></div>
                        </div>
                    </div>
                </div>

                <div class="row">
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
                </div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket3</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket3" name="txt-ket3" placeholder="" autocomplete="off" maxlength="100"></div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive my-2 mxh-60vh">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top align-middle">Grade</th>
                                <th class="border sticky-top align-middle">Produk</th>
                                <th class="border sticky-top align-middle">Satuan</th>
                                <th class="border sticky-top align-middle text-right">Qty (KG)</th>
                                <th class="border sticky-top align-middle text-right">Qty (Ekor)</th>
                                <th class="border sticky-top align-middle text-right">Harga / KG</th>
                            </tr>
                        </thead>

                        <tbody id="lst-ntt">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-sntt">Simpan</button>
            </div>
        </div>
    </div>
</div>