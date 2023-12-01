<div class="modal fade" id="mdl-nrkrm" tabindex="-1" role="dialog" aria-labelledby="mdl-nrkrm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Retur Kirim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-rkrm-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-rkrm-2">Data P/O tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-rkrm-3">Tidak terdapat produk yang di retur !!!</div>

                <div class="alert alert-danger d-none" id="div-err-rkrm-4">Retur tidak boleh melebihi jumlah kirim !!!</div>

                <div class="alert alert-success d-none" id="div-scs-rkrm-1">Retur Kirim berhasil ditambah !!!</div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                            <div class="col-9"><input type="date" class="form-control inp-set" id="dte-tgl" name="dte-tgl" placeholder="" value="<?php echo date('Y-m-d');?>"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Pilih PO</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="txt-po" name="txt-po" placeholder="" autocomplete="off" maxlength="100" readonly>

                                    <div class="input-group-append">
                                        <button class="btn btn-light border btn-spo-cus" type="button" data-value="#mdl-nrkrm"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Ket</span></div>
                            <div class="col-9"><input type="text" class="form-control inp-set" id="txt-ket" name="txt-ket" placeholder="" autocomplete="off" maxlength="250"></div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive my-2 mxh-60vh">
                    <table class="table table-sm table-data2">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top align-middle">Produk</th>
                                <th class="border sticky-top align-middle text-right">Jlh Kirim (KG)</th>
                                <th class="border sticky-top align-middle text-right">Jlh Retur (KG)</th>
                                <th class="border sticky-top align-middle">Action</th>
                            </tr>
                        </thead>

                        <tbody id="lst-nrkrm">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snrkrm" data-count="">Simpan</button>
            </div>
        </div>
    </div>
</div>