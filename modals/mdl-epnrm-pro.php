<div class="modal fade" id="mdl-etrm-pro" tabindex="-1" role="dialog" aria-labelledby="mdl-etrm-pro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ralat Penerimaan - Produk</h5>
                <button type="button" class="close mdl-cls" data-dismiss="modal" aria-label="Close" data-target="" data-toggle="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-edt-err-trm-pro-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Produk</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control inp-set" id="edt-txt-nma-pro" name="edt-txt-nma-pro" placeholder="" autocomplete="off" maxlength="100" readonly>
                            <input type="text" class="d-none" id="edt-txt-pro">
                            <input type="text" class="d-none" id="edt-txt-trm-type-pro" data-count="">
                            <input type="text" class="d-none" id="edt-txt-urut">

                            <div class="input-group-append">
                                <button class="btn btn-light border" type="button" data-value="#mdl-etrm-pro" data-target="#mdl-spro" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Kategori</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-nma-kate" name="edt-txt-nma-kate" placeholder="" autocomplete="off" readonly></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Sub Kategori</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-nma-skate" name="edt-txt-nma-skate" placeholder="" autocomplete="off" readonly></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Grade</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-nma-grade" name="edt-txt-nma-grade" placeholder="" autocomplete="off" readonly></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Qty (KG)</span></div>
                    <div class="col-9"><input type="number" class="form-control inp-set" id="edt-txt-weight" name="edt-txt-weight" placeholder="" autocomplete="off" step="any" value="0"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Satuan</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <select name="edt-slct-sat" id="edt-slct-sat" class="custom-select">
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
                <button type="button" class="btn btn-primary" id="btn-epnrm-pro">Simpan</button>
            </div>
        </div>
    </div>
</div>