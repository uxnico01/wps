<div class="modal fade" id="mdl-npro" tabindex="-1" role="dialog" aria-labelledby="mdl-npro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-pro-1">Harap isi semua data dengan tanda * !!!</div>

                <div class="alert alert-danger d-none" id="div-err-pro-2">Terdapat data produk dengan ID ini !!!</div>

                <div class="alert alert-danger d-none" id="div-err-pro-3">Data Oz tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-pro-4">Data Cut Style tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-pro-5">Grade tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-pro-6">Kategori tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-pro-7">Golongan tidak ditemukan !!!</div>

                <div class="alert alert-danger d-none" id="div-err-pro-8">Kategori tidak ditemukan !!!</div>

                <div class="alert alert-success d-none" id="div-scs-pro-1">Produk berhasil ditambahkan !!!</div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">ID</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-id-pro" name="txt-id-pro" placeholder="" autocomplete="off" maxlength="25"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Nama</span><span class="text-danger">*</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma-pro" name="txt-nma-pro" placeholder="" autocomplete="off" maxlength="100"></div>
                </div>

                <div class="row mt-2 d-none">
                    <div class="col-3 mt-1"><span class="h6">Qty Awal (KG)</span></div>
                    <div class="col-9"><input type="number" class="form-control inp-set" id="nmbr-qawl-pro" name="nmbr-qawl-pro" placeholder="" autocomplete="off" step="any" value="0"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Grade</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <select name="slct-grade-pro" id="slct-grade-pro" class="custom-select">
                            <option value="">Pilih Grade</option>
                            <?php
                            $lst = getAllGrade();

                            for ($i = 0; $i < count($lst); $i++) {
                            ?>
                                <option value="<?php echo $lst[$i][0]; ?>"><?php echo $lst[$i][1]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Oz</span></div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control inp-set" id="txt-nma-kate" name="txt-nma-kate" placeholder="" autocomplete="off" maxlength="100" readonly>
                            <input type="text" class="d-none" id="txt-kate">

                            <div class="input-group-append">
                                <button class="btn btn-light border" type="button" data-value="#mdl-npro" data-target="#mdl-skate" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Cut Style</div>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control inp-set" id="txt-nma-skate" name="txt-nma-skate" placeholder="" autocomplete="off" maxlength="100" readonly>
                            <input type="text" class="d-none" id="txt-skate">

                            <div class="input-group-append">
                                <button class="btn btn-light border" type="button" data-value="#mdl-npro" data-target="#mdl-sskate" data-toggle="modal" data-backdrop="static" data-keyboard="false"><img src="./bin/img/icon/folder-icon.png" width="20" alt="Pilih"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Kategori</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <select name="slct-kates-pro" id="slct-kates-pro" class="custom-select">
                            <option value="">Pilih Kategori</option>
                            <?php
                                $lst = getAllKates($db);

                                for ($i = 0; $i < count($lst); $i++) {
                            ?>
                                <option value="<?php echo $lst[$i][0]; ?>"><?php echo $lst[$i][1]; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Golongan</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <select name="slct-gol-pro" id="slct-gol-pro" class="custom-select">
                            <option value="">Pilih Golongan</option>
                            <?php
                                $lst = getAllGol($db);

                                for ($i = 0; $i < count($lst); $i++) {
                            ?>
                                <option value="<?php echo $lst[$i][0]; ?>"><?php echo $lst[$i][1]; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Jenis Produk</span></div>
                    <!-- <span class="text-danger">*</span> -->
                    <div class="col-9">
                        <select name="slct-katej-pro" id="slct-katej-pro" class="custom-select">
                            <!-- <option value="">Pilih Jenis Produk</option> -->
                            <?php
                                $lst = getAllKatej($db);

                                for ($i = 0; $i < count($lst); $i++) {
                            ?>
                                <option value="<?php echo $lst[$i][0]; ?>"><?php echo $lst[$i][1]; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 d-none">
                    <div class="col-3 mt-1"><span class="h6">Sub Kategori</span><span class="text-danger">*</span></div>
                    <div class="col-9">
                        <select name="slct-skate" id="slct-skate" class="custom-select">
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Tampil produk pada</span></div>
                    <div class="col-9">
                        <div class="form-check my-1">
                            <input class="form-check-input" type="checkbox" value="" id="chk-trm">
                            <label class="form-check-label" for="chk-trm">Proses Penerimaan</label>
                        </div>
                        <div class="form-check my-1">
                            <input class="form-check-input" type="checkbox" value="" id="chk-cut">
                            <label class="form-check-label" for="chk-cut">Proses Cutting</label>
                        </div>
                        <div class="form-check my-1">
                            <input class="form-check-input" type="checkbox" value="" id="chk-vac">
                            <label class="form-check-label" for="chk-vac">Proses Vacuum</label>
                        </div>
                        <div class="form-check my-1">
                            <input class="form-check-input" type="checkbox" value="" id="chk-saw">
                            <label class="form-check-label" for="chk-saw">Proses Sawing</label>
                        </div>
                        <div class="form-check my-1">
                            <input class="form-check-input" type="checkbox" value="" id="chk-pkg">
                            <label class="form-check-label" for="chk-pkg">Proses Packaging</label>
                        </div>
                        <div class="form-check my-1">
                            <input class="form-check-input" type="checkbox" value="" id="chk-mp">
                            <label class="form-check-label" for="chk-mp">Proses Masuk Produk</label>
                        </div>
                        <div class="form-check my-1">
                            <input class="form-check-input" type="checkbox" value="" id="chk-frz">
                            <label class="form-check-label" for="chk-frz">Proses Pembekuan</label>
                        </div>
                    </div>
                </div>

                <?php
                    if(viewHarga())
                    {
                ?>
                <div class="row mt-2">
                    <div class="col-3 mt-1"><span class="h6">Harga Jual</span></div>
                    <div class="col-9"><input type="text" class="form-control inp-set cformat" id="txt-hsell" name="txt-hsell" placeholder="" autocomplete="off" value="0"></div>
                </div>
                <?php
                    }
                ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snpro">Simpan</button>
            </div>
        </div>
    </div>
</div>