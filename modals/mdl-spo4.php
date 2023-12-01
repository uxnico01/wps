<div class="modal fade" id="mdl-spo4" tabindex="-1" role="dialog" aria-labelledby="mdl-spo4" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih P/O</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="col-12 m-0 p-0 my-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="txt-srch-spo4" autocomplete="off" placeholder="Search P/O" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-spo4"><img src="<?php if(file_exists("./bin/img/icon/search.png")) echo "./bin/img/icon/search.png"; else echo "../bin/img/icon/search.png";?>" alt="Search" width="20"></button>
                        </div>
                    </div>
                </div>
                                
                <div class="text-danger h6 small"><em>Klik baris 1x untuk memilih P/O !!!</em></div>
                
                <div class="table-responsive mxh-70vh">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top">ID</th>
                                <th class="border sticky-top">Tgl Kirim</th>
                                <th class="border sticky-top">Customer</th>
                                <th class="border sticky-top">Ket1</th>
                                <th class="border sticky-top">Ket2</th>
                                <th class="border sticky-top">No TT Gudang</th>
                            </tr>
                        </thead>
                                        
                        <tbody id="lst-spo4">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>