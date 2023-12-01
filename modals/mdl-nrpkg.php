<div class="modal fade" id="mdl-nrpkg" tabindex="-1" role="dialog" aria-labelledby="mdl-nrpkg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Re-Packing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>" data-verif=""></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket" name="txt-ket" placeholder="" value="" maxlength="250"></div>
                        </div>
                    </div>
                </div><hr>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Bahan Baku</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control inp-set" id="txt-nma-pro" name="txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                                    <input type="text" class="d-none" id="txt-pro">

                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-spro2" type="button" data-value="#mdl-nrpkg" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
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

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Berat</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight-pro" name="txt-weight-pro" placeholder="" autocomplete="off" step="any"></div>
                        </div>
                    </div>
                </div><hr>

                <div class="col-12 my-2 p-0">
                    <button class="btn btn-light border border-success btn-rpkg-pro" id="btn-nrpkg-pro"><img src="./bin/img/icon/plus.png" alt="" width="18"> <span class="small">Tambah Produk</span></button>
                </div>

                <div class="table-responsive my-2 mxh-60vh">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top align-middle">Produk</th>
                                <th class="border sticky-top align-middle text-right">Berat</th>
                                <th class="border sticky-top"></th>
                            </tr>
                        </thead>

                        <tbody id="lst-nrpkg">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-rpkg-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-rpkg-2">Data produk awal tidak dapat ditemukan !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-rpkg-3">Tidak terdapat hasil produk !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-rpkg-4">Hasil tidak boleh lebih besar dari produk awal !!!</div>

                <div class="alert alert-danger mb-0 mr-2 d-none" id="div-err-rpkg-5">QTY tidak boleh melebihi sisa stok !!!</div>

                <div class="alert alert-success mb-0 mr-2 d-none" id="div-scs-rpkg-1">Re-Packing berhasil ditambahkan !!!</div>

                <button type="button" class="btn btn-primary" id="btn-snrpkg" data-count="0">Simpan</button>
            </div>
        </div>
    </div>
</div>