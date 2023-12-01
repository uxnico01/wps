<div class="modal fade" id="mdl-sskate" tabindex="-1" role="dialog" aria-labelledby="mdl-sskate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Cut Style</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="col-12 m-0 p-0 my-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="txt-srch-ssskate" autocomplete="off" placeholder="Search Cut Style" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-ssskate"><img src="./bin/img/icon/search.png" alt="Search" width="20"></button>
                        </div>
                    </div>
                </div>
                                
                <div class="text-danger h6 small"><em>Klik baris 1x untuk memilih cut style !!!</em></div>
                
                <div class="table-responsive mxh-70vh">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top">ID</th>
                                <th class="border sticky-top">Nama</th>
                                <th class="border sticky-top">Ket</th>
                            </tr>
                        </thead>
                                        
                        <tbody id="lst-ssskate">
                            <?php
                                $lst = getAllSKate();
                            
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    if($i == 50)
                                        break;
                            ?>
                            <tr onclick="chgSKate('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
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