<div class="modal fade" id="mdl-vrf" tabindex="-1" role="dialog" aria-labelledby="mdl-vrf" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="" data-toggle="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body py-1">
                <ul class="nav nav-tabs">
                    <?php
                        if(CekAksUser(substr($duser[7], 0, 1))){
                    ?>
                    <li class="nav-item">
                        <a class="nav-vrf nav-link active" href="#" id="link-vtran">Verifikasi Transaksi</a>
                    </li>
                    <?php
                        }

                        if(CekAksUser(substr($duser[7], 171, 1))){
                    ?>
                    <li class="nav-item">
                        <a class="nav-vrf nav-link <?php if(!CekAksUser(substr($duser[7], 0, 1))) echo "active";?>" href="#" id="link-vptran">Verifikasi Penyesuaian</a>
                    </li>
                    <?php
                        }
                    ?>
                </ul>

                <?php
                    if(CekAksUser(substr($duser[7], 0, 1))){
                ?>
                <div class="table-responsive my-1" id="div-vrf">
                    <table class="table table-sm table-hover table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top align-middle">Tgl</th>
                                <th class="border sticky-top align-middle">Tipe</th>
                                <th class="border sticky-top align-middle">Status</th>
                                <th class="border sticky-top align-middle">User</th>
                                <th class="border sticky-top align-middle">Action</th>
                            </tr>
                        </thead>

                        <tbody id="lst-vtran">

                        </tbody>
                    </table>
                </div>
                <?php
                    }

                    if(CekAksUser(substr($duser[7], 171, 1))){
                ?>
                <div class="table-responsive my-1 <?php if(CekAksUser(substr($duser[7], 0, 1))) echo "d-none";?>" id="div-pvrf">
                    <table class="table table-sm table-hover table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top align-middle">Proses</th>
                                <th class="border sticky-top align-middle">Produk</th>
                                <th class="border sticky-top align-middle">Sisa Qty</th>
                                <th class="border sticky-top align-middle">Qty Proses</th>
                                <th class="border sticky-top align-middle">User</th>
                                <th class="border sticky-top align-middle">Action</th>
                            </tr>
                        </thead>

                        <tbody id="lst-pvtran"></tbody>
                    </table>
                </div>
                <?php
                    }
                ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-target="" data-toggle="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>