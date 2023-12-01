<div class="modal fade" id="mdl-nmtrm" tabindex="-1" role="dialog" aria-labelledby="mdl-nmtrm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-80p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penerimaan - Minum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-2">
                            <div class="col-3 mt-1"><span class="h6">Tgl</span><span class="text-danger">*</span></div>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="date" class="form-control inp-set" id="dte-mtgl" name="dte-mtgl" placeholder="" value="<?php echo date('Y-m-d');?>">

                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" id="btn-smtrm">Set</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"><span class="text-danger small">NB : Transaksi yang dapat dimunculkan adalah maksimal 3 hari kebelakang</span></div>
                </div>
                
                <div class="table-responsive mb-2 mt-2 mxh-60vh">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top align-middle">Tgl</th>
                                <th class="border sticky-top align-middle">Supplier</th>
                                <th class="border sticky-top align-middle text-right">BB</th>
                                <th class="border sticky-top align-middle text-right">Dll</th>
                                <th class="border sticky-top align-middle text-right">Minum</th>
                            </tr>
                        </thead>

                        <tbody id="lst-nmtrm">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <div class="w-100 text-right">
                    <button type="button" class="btn btn-primary" id="btn-snmtrm" data-count="0">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>