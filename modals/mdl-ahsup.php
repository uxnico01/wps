<div class="modal fade" id="mdl-ahsup" tabindex="-1" role="dialog" aria-labelledby="mdl-ahsup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Harga Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body py-1">
                <div class="my-2">
                    <label class="mb-0 font-weight-bold" for="slct-jns">Jenis <span class="text-danger">*</span></label>
                    <select name="slct-jns" id="slct-jns" class="custom-select">
                        <option value="3">Perubahan Harga</option>
                        <option value="1">Kenaikan Harga</option>
                        <option value="2">Penurunan Harga</option>
                    </select>
                </div>
                <div class="my-2">
                    <label class="mb-0 font-weight-bold" for="slct-prb-ahsup">Perubahan harga <span class="text-danger">*</span></label>
                    <select name="slct-prb-ahsup" id="slct-prb-ahsup" class="custom-select">
                        <option value="1">Keseluruhan</option>
                        <option value="2">Berdasarkan Grade</option>
                    </select>
                </div>
                <div class="my-2">
                    <label class="mb-0 font-weight-bold" for="slct-tsup">Data Supplier <span class="text-danger">*</span></label>
                    <select name="slct-tsup" id="slct-tsup" class="custom-select">
                        <option value="1">Semua Supplier</option>
                        <option value="2">Supplier Tertentu</option>
                    </select>
                </div>
                <div class="my-2 d-none" id="div-dsup">
                    <div class="mb-1"><strong>Pilih Supplier <span class="text-danger">*</span></strong> <button class="btn btn-sm btn-outline-success m-1" data-target="#mdl-ssup3" data-toggle="modal"><img src="./bin/img/icon/plus.png" width="20" alt="Add"></button></div>
                    <div id="lst-dsup" class="px-3 mxh-20vh"></div>
                    <hr>
                </div>
                <div class="my-2">
                    <label class="mb-0 font-weight-bold" for="slct-tsat">Data Satuan <span class="text-danger">*</span></label>
                    <select name="slct-tsat" id="slct-tsat" class="custom-select">
                        <option value="1">Semua Satuan</option>
                        <option value="2">Satuan Tertentu</option>
                    </select>
                </div>
                <div class="my-2 d-none" id="div-dsat">
                    <div class="mb-1"><strong>Pilih Satuan <span class="text-danger">*</span></strong> <button class="btn btn-sm btn-outline-success m-1" data-target="#mdl-ssat" data-toggle="modal"><img src="./bin/img/icon/plus.png" width="20" alt="Add"></button></div>
                    <div id="lst-dsat" class="px-3 mxh-20vh"></div>
                    <hr>
                </div>
                <div class="my-2">
                    <label class="mb-0 font-weight-bold" for="slct-tgrade">Data Grade <span class="text-danger">*</span></label>
                    <select name="slct-tgrade" id="slct-tgrade" class="custom-select">
                        <option value="1">Semua Grade</option>
                        <option value="2">Grade Tertentu</option>
                    </select>
                </div>
                <div class="my-2 d-none" id="div-dgrade">
                    <div class="mb-1"><strong>Pilih Grade <span class="text-danger">*</span></strong> <button class="btn btn-sm btn-outline-success m-1" data-target="#mdl-sgrade" data-toggle="modal"><img src="./bin/img/icon/plus.png" width="20" alt="Add"></button></div>
                    <div id="lst-dgrade" class="px-3 mxh-20vh"></div>
                    <hr>
                </div>
                <div class="my-2" id="div-jlh">
                    <label class="mb-0 font-weight-bold" for="txt-jlh">Nilai Perubahan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control cformat" id="txt-jlh">
                </div>
            </div>

            <div class="modal-footer">
                <div class="alert alert-danger d-none mb-0" id="div-err-ahsup-1">Terdapat data yang tidak sesuai, harap cek kembali !!!</div>
                
                <div class="alert alert-success d-none mb-0" id="div-scs-ahsup-1">Harga Supplier berhasil diubah !!!</div>
                <button type="button" class="btn btn-primary" id="btn-snahsup" data-csup="0" data-csat="0" data-cgrade="0">Simpan</button>
            </div>
        </div>
    </div>
</div>