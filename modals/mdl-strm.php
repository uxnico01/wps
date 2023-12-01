<div class="modal fade" id="mdl-strm" tabindex="-1" role="dialog" aria-labelledby="mdl-strm" aria-hidden="true">
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
                        <input type="text" class="form-control" id="txt-srch-strm" autocomplete="off" placeholder="Search Penerimaan" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-strm"><img src="./bin/img/icon/search.png" alt="Search" width="20"></button>
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
                                <th class="border sticky-top text-right">BB</th>
                                <th class="border sticky-top text-right">Poto</th>
                                <th class="border sticky-top">Ket 1</th>
                                <th class="border sticky-top">Ket 2</th>
                                <th class="border sticky-top">Ket 3</th>
                                <th class="border sticky-top">User</th>
                                <th class="border sticky-top">Wkt</th>
                            </tr>
                        </thead>
                                        
                        <tbody id="lst-strm">
                            <?php
                                $lst = getAllTrmNTT();
                            
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    if($i == 50)
                                        break;
                                        
                                    $sup = getSupID($lst[$i][1]);
    
                                    $bbdcl = 0;
                                    if(isDecimal($lst[$i][3]))
                                        $bbdcl = 2;
    
                                    $pdcl = 0;
                                    if(isDecimal($lst[$i][4]))
                                        $pdcl = 2;
                            ?>
                            <tr onclick="chgTrm('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][2])); ?></td>
                                <td class="border"><?php echo $sup[1]; ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][3],$bbdcl,'.',','); ?></td>
                                <td class="border text-right"><?php echo number_format($lst[$i][4],$pdcl,'.',','); ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                                <td class="border"><?php echo $lst[$i][6]; ?></td>
                                <td class="border"><?php echo $lst[$i][7]; ?></td>
                                <td class="border"><?php echo $lst[$i][8]; ?></td>
                                <td class="border"><?php echo date('d/m/Y H:i', strtotime($lst[$i][9])); ?></td>
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