<div class="modal fade" id="mdl-shrga-sup" tabindex="-1" role="dialog" aria-labelledby="mdl-shrga-sup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Harga - <strong id="st-nm-sup" data-value=""></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body py-1">
                <div class="row">
                    <?php
                        $lsat = getAllSatuan();
                        $lgrade = getAllGrade();

                        $n = 0;
                        for($i = 0; $i < count($lsat); $i++)
                        {
                    ?>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                        <div class="card p-0" id="card-aks-<?php echo $i;?>" onmouseover="cardHvr(<?php echo $i;?>)" onmouseout="cardNHvr(<?php echo $i;?>)">
                            <div class="card-header csr-pntr" id="div-dhead-<?php echo $i;?>" onclick="cardAct(<?php echo $i;?>)"><?php echo $lsat[$i][1];?> <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-<?php echo $i;?>" width="18" class="ml-2"></div>
                            
                            <div class="card-body py-1 d-none" id="div-dcard-<?php echo $i;?>">
                                <?php
                                    for($j = 0; $j < count($lgrade); $j++)
                                    {
                                ?>
                                <div class="row my-2">
                                    <div class="col-6"><?php echo $lgrade[$j][1];?></div>
                                    <div class="col-6"><input type="text" class="form-control cformat" id="txt-hsup-<?php echo $n;?>" data-sat="<?php echo UE64($lsat[$i][0]);?>" data-grade="<?php echo UE64($lgrade[$j][0]);?>"></div>
                                </div>
                                <?php
                                        $n++;
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-snhsup" data-count="<?php echo $n;?>">Simpan</button>
            </div>
        </div>
    </div>
</div>