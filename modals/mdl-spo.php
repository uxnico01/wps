<div class="modal fade" id="mdl-spo" tabindex="-1" role="dialog" aria-labelledby="mdl-spo" aria-hidden="true">
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
                        <input type="text" class="form-control" id="txt-srch-spo" autocomplete="off" placeholder="Search P/O" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-spo"><img src="<?php if(file_exists("./bin/img/icon/search.png")) echo "./bin/img/icon/search.png"; else echo "../bin/img/icon/search.png";?>" alt="Search" width="20"></button>
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
                                        
                        <tbody id="lst-spo">
                            <?php
                                $lst = getAllPO("2");
                            
                                $n = 0;
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    if($n == 50)
                                        break;

                                    if((strcasecmp($lst[$i][6],"") == 0 && $lst[$i][7] < date('Y-m-d')) || strcasecmp($lst[$i][6],"N") == 0)
                                        continue;

                                    $cus = getCusID($lst[$i][1]);
                            ?>
                            <tr onclick="chgPO('<?php echo UE64($lst[$i][0]);?>')">
                                <td class="border"><?php echo $lst[$i][0]; ?></td>
                                <td class="border"><?php echo date('d/m/Y', strtotime($lst[$i][2])); ?></td>
                                <td class="border"><?php echo $cus[1]; ?></td>
                                <td class="border"><?php echo $lst[$i][3]; ?></td>
                                <td class="border"><?php echo $lst[$i][4]; ?></td>
                                <td class="border"><?php echo $lst[$i][5]; ?></td>
                            </tr>
                            <?php
                                    $n++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>