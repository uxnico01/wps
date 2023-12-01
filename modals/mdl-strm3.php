<div class="modal fade" id="mdl-strm3" tabindex="-1" role="dialog" aria-labelledby="mdl-strm3" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Penerimaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="col-12 m-0 p-0 my-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="txt-srch-strm2-itm" autocomplete="off" placeholder="Search Penerimaan" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-strm2-itm"><img src="./bin/img/icon/search.png" alt="Search" width="20"></button>
                        </div>
                    </div>
                </div>
                                
                <div class="text-danger h6 small"><em>Klik baris 1x untuk memilih penerimaan !!!</em></div>
                
                <div class="table-responsive mxh-70vh">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top">ID</th>
                                <th class="border sticky-top">Tgl</th>
                                <th class="border sticky-top">Supplier</th>
                                <th class="border sticky-top text-right">Produk</th>
                                <th class="border sticky-top text-right">Grade</th>
                                <th class="border sticky-top">Berat (KG)</th>
                            </tr>
                        </thead>
                                        
                        <tbody id="lst-trm2-itm">
                            <?php
                                $lst = getTrmItem2();
                            
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    if($i == 50)
                                        break;
                            ?>
                            <tr onclick="chgTrmItm2('<?php echo UE64($lst[$i][0]);?>', '<?php echo UE64($lst[$i][5]);?>', '<?php echo UE64($lst[$i][6]);?>', '<?php echo UE64($lst[$i][7]);?>', '<?php echo UE64($lst[$i][8]);?>', '<?php echo UE64($lst[$i][3]);?>', '<?php echo UE64($lst[$i][4]);?>', '<?php echo UE64($lst[$i][2]);?>')">
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo $lst[$i][1]; ?></td>
                                <td class="border"><?php echo $lst[$i][2]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border text-right"><?php if(isDecimal($lst[$i][5])) echo number_format($lst[$i][5],2,',','.'); else echo number_format($lst[$i][5],0,',','.');?></td>
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