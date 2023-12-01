<div class="modal fade" id="mdl-spo2" tabindex="-1" role="dialog" aria-labelledby="mdl-spo2" aria-hidden="true">
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
                        <input type="text" class="form-control" id="txt-srch-spo2" autocomplete="off" placeholder="Search P/O" data-value="">
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-spo2"><img src="<?php if(file_exists("./bin/img/icon/search.png")) echo "./bin/img/icon/search.png"; else echo "../bin/img/icon/search.png";?>" alt="Search" width="20"></button>
                        </div>
                    </div>
                </div>
                                
                <div class="text-danger h6 small"><em>Klik baris 1x untuk memilih P/O !!!</em></div>
                
                <div class="table-responsive mxh-70vh">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border sticky-top">Action</th>
                                <th class="border sticky-top">No P/O</th>
                                <th class="border sticky-top">Tgl Kirim</th>
                                <th class="border sticky-top">Customer</th>
                                <th class="border sticky-top">Ket1</th>
                                <th class="border sticky-top">Ket2</th>
                                <th class="border sticky-top">No TT Gudang</th>
                            </tr>
                        </thead>
                                        
                        <tbody id="lst-spo2">
                            <?php
                                $lst = getAllPO();
                            
                                $n = 0;
                                for($i = 0; $i < count($lst); $i++)
                                {
                                    if($n == 50)
                                        break;

                                    $cus = getCusID($lst[$i][1]);
                            ?>
                            <tr id="row-tpo-<?php echo $i;?>">
                                <td class="border"><button class="btn btn-sm btn-light border-success" onclick="addAtPO('<?php echo UE64($lst[$i][0]);?>', '<?php echo UE64(date('d/m/Y', strtotime($lst[$i][2])));?>', '<?php echo UE64($lst[$i][9]);?>', '<?php echo UE64($cus[1]);?>', this)"><img src="./bin/img/icon/plus.png" width="18"></button></td>
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