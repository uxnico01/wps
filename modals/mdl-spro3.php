<div class="modal fade" id="mdl-spro3" tabindex="-1" role="dialog" aria-labelledby="mdl-spro3" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="col-12 m-0 p-0 my-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="txt-srch-spro3" autocomplete="off" placeholder="Search Produk" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-spro3"><img src="./bin/img/icon/search.png" alt="Search" width="20"></button>
                        </div>
                    </div>
                </div>
                                
                <div class="text-danger h6 small"><em>Klik baris 1x untuk memilih produk !!!</em></div>
                
                <div class="table-responsive mxh-70vh">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top">ID</th>
                                <th class="border sticky-top">Nama</th>
                                <th class="border sticky-top">Grade</th>
                                <th class="border sticky-top">Oz</th>
                                <th class="border sticky-top">Cut Style</th>
                            </tr>
                        </thead>
                                        
                        <tbody id="lst-sspro2">
                            <?php
                                /*$lst = getAllPro();
                            
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    if($i == 50)
                                        break;
                            ?>
                            <tr onclick="chgPro2('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                            </tr>
                            <?php
                                }*/
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>