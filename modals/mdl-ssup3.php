<div class="modal fade" id="mdl-ssup3" tabindex="-1" role="dialog" aria-labelledby="mdl-ssup3" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-80p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="col-12 m-0 p-0 my-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="txt-srch-ssup3" autocomplete="off" placeholder="Search Supplier" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-ssup3"><img src="./bin/img/icon/search.png" alt="Search" width="20"></button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive mxh-70vh">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top">Action</th>
                                <th class="border sticky-top">Kode</th>
                                <th class="border sticky-top">Nama</th>
                                <th class="border sticky-top">Alamat</th>
                                <th class="border sticky-top">Wilayah</th>
                            </tr>
                        </thead>
                                        
                        <tbody id="lst-sssup3">
                            <?php
                                $lst = getAllSup();
                            
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    if($i == 50)
                                        break;
                            ?>
                            <tr id="row-tsup-trm-<?php echo $i;?>">
                                <td class="border"><button class="btn btn-sm btn-light border-success" onclick="addDtSup('<?php echo UE64($lst[$i][0]);?>', '<?php echo UE64($lst[$i][1]);?>')"><img src="./bin/img/icon/plus.png" width="18"></button></td>
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
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