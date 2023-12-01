<div class="modal fade" id="mdl-ntrm-pro" tabindex="-1" role="dialog" aria-labelledby="mdl-ntrm-pro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penerimaan - Produk</h5>
                <button type="button" class="close mdl-cls" data-dismiss="modal" aria-label="Close" data-target="" data-toggle="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-trm-pro-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-success d-none" id="div-scs-trm-pro-1">Produk berhasil ditambah !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Produk</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control inp-set" id="txt-nma-pro" name="txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                            <input type="text" class="d-none" id="txt-pro">
                            <input type="text" class="d-none" id="txt-trm-type-pro">

                            <div class="input-group-append">
                                <button class="btn btn-light border btn-spro2" type="button" data-value="#mdl-ntrm-pro" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-grade" name="txt-nma-grade" placeholder="" autocomplete="off" readonly><input type="text" class="d-none" id="txt-grade"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-kate" name="txt-nma-kate" placeholder="" autocomplete="off" readonly></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Cut Style</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-skate" name="txt-nma-skate" placeholder="" autocomplete="off" readonly></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Qty (KG)</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="number" class="form-control inp-set" id="txt-weight" name="txt-weight" placeholder="" autocomplete="off" step="any" value="0"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Satuan</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <select name="slct-sat" id="slct-sat" class="custom-select">
                            <option value="" data-value="">Pilih Satuan</option>
                            <?php
                            $lst = getAllSatuan();

                            for ($i = 0; $i < count($lst); $i++) {
                            ?>
                                <option value="<?php echo $lst[$i][0]; ?>" data-value="<?php echo UE64($lst[$i][1])?>"><?php echo $lst[$i][1]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-npnrm-pro">Simpan</button>
            </div>
        </div>
    </div>
</div>