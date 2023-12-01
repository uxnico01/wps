<div class="modal fade" id="mdl-suser" tabindex="-1" role="dialog" aria-labelledby="mdl-suser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="col-12 m-0 p-0 my-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="txt-srch-suser" autocomplete="off" placeholder="Search Produk" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-suser"><img src="./bin/img/icon/search.png" alt="Search" width="20"></button>
                        </div>
                    </div>
                </div>
                                
                <div class="text-danger h6 small"><em>Klik baris 1x untuk memilih user !!!</em></div>
                
                <div class="table-responsive mxh-70vh">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top">Username</th>
                                <th class="border sticky-top">Nama</th>
                                <th class="border sticky-top">Posisi</th>
                                <th class="border sticky-top">Divisi</th>
                                <th class="border sticky-top">Active</th>
                                <th class="border sticky-top">Level</th>
                            </tr>
                        </thead>
                                        
                        <tbody id="lst-suser">
                            <?php
                                $lst = getAllUser();
                            
                                for($i = 0; $i < count($lst); $i++)
                                {
                            ?>
                            <tr onclick="chgUser('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo $lst[$i][0];?></td>
                                <td class="border"><?php echo $lst[$i][2];?></td>
                                <td class="border"><?php echo $lst[$i][3];?></td>
                                <td class="border"><?php echo $lst[$i][4];?></td>
                                <td class="border"><?php echo $lst[$i][5];?></td>
                                <td class="border"><?php echo $lst[$i][6];?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>