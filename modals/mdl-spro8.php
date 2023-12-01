<div class="modal fade" id="mdl-spro8" tabindex="-1" role="dialog" aria-labelledby="mdl-spro8" aria-hidden="true">
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
                        <input type="text" class="form-control" id="txt-srch-spro8" autocomplete="off" placeholder="Search Produk" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-spro8"><img src="./bin/img/icon/search.png" alt="Search" width="20"></button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive mxh-70vh">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top">Action</th>
                                <th class="border sticky-top">Kode</th>
                                <th class="border sticky-top">Produk</th>
                            </tr>
                        </thead>
                        
                        <tbody id="lst-sspro8">
                            <?php
                                $lst = getAllPro();

                                for($i = 0; $i < count($lst); $i++){
                                    $nma = $lst[$i][1]." / ".$lst[$i][2];

                                    if(strcasecmp($lst[$i][3],"") != 0){
                                        $nma .= " / ".$lst[$i][3];
                                    }

                                    if(strcasecmp($lst[$i][4],"") != 0){
                                        $nma .= " / ".$lst[$i][4];
                                    }
                            ?>
                            <tr>
                                <td class="border"><button class="btn btn-sm btn-light border-success" onclick="addSetPro('<?php echo UE64($lst[$i][0]);?>', '<?php echo UE64($nma);?>')"><img src="./bin/img/icon/plus.png" width="18"></button></td>
                                <td class="border"><?php echo $lst[$i][0];?></td>
                                <td class="border"><?php echo $nma;?></td>
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