<div class="modal fade" id="mdl-ssmpn-sup" tabindex="-1" role="dialog" aria-labelledby="mdl-ssmpn-sup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-70p" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-psup">
                <div class="psup-modal-header">
                    <h5 class="modal-title">Set Simpanan - <strong class="st-nm-psup-cls" data-value=""></strong></h5>
                </div>
                <div id="lst-btnsmpndup">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-3">
                <div class="d-flex flex-row">
                    <button class="collapse-supplier-icon-switch btn btn-simpanan mb-2 mt-2 btn-supp" type="button" data-toggle="collapse" data-target="#collapseSupplier" aria-expanded="false" aria-controls="collapseSupplier">
                        <div class="collapse-supplier-button">
                            <p class="st-nm-psup-cls mb-0" data-value=""></p>
                            <img class="collapse-supplier-up" src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks2-<?php echo $i;?>" width="14">
                            <img class="collapse-supplier-down" src="./bin/img/icon/arr-top-wh.png" alt="Arrow" id="img-aks2-<?php echo $i;?>" width="14">
                        </div>
                    </button>
                    <button type="button" class="btn btn-outline-primary mb-2 mt-2 btn-supp-del" id="btn-snpsup" data-count="<?php echo $n;?>">
                        <p class="mb-0">Simpan</p>
                    </button>
                </div>
                <div class="collapse mt-3" id="collapseSupplier">
                    <div class="row">
                        <?php
                            $lsat = getAllSatuan();
                            $lgrade = getAllGrade();

                            $n = 0;
                            for($i = 0; $i < count($lsat); $i++)
                            {
                        ?>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                            <div class="card p-0" id="card-aks2-<?php echo $i;?>" onmouseover="cardHvr2(<?php echo $i;?>)" onmouseout="cardNHvr2(<?php echo $i;?>)">
                                <div class="card-header csr-pntr" id="div-dhead2-<?php echo $i;?>" onclick="cardAct2(<?php echo $i;?>)"><?php echo $lsat[$i][1];?>
                                    <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks2-<?php echo $i;?>" width="18" class="ml-2">
                                </div>
                                <div class="card-body py-1 d-none" id="div-dcard2-<?php echo $i;?>">
                                    <?php
                                        for($j = 0; $j < count($lgrade); $j++)
                                        {
                                    ?>
                                    <div class="row my-2">
                                        <div class="col-6"><?php echo $lgrade[$j][1];?></div>
                                        <div class="col-6"><input type="text" class="form-control cformat" id="txt-psup-<?php echo $n;?>" data-sat="<?php echo UE64($lsat[$i][0]);?>" data-grade="<?php echo UE64($lgrade[$j][0]);?>"></div>
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
                <!-- Array -->
                <!-- class="accordion" -->
                <div id="lst-btndcollapse">
                    
                </div>
            </div>
        </div>
    </div>
</div>