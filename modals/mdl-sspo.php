<div class="modal fade" id="mdl-sspo" tabindex="-1" role="dialog" aria-labelledby="mdl-sspo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Gudang Pengiriman</h5>
                <button type="button" class="close mdl-cls" data-dismiss="modal" aria-label="Close" data-target="" data-toggle="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="my-2">
                    <label for="slct-gdg">Pilih Gudang <span class="text-danger">*</span></label>
                    <select name="slct-gdg" id="slct-gdg" class="custom-select" data-value="">
                        <?php
                            $lgdg = getAlLGdg($db);
                            for($i = 0; $i < count($lgdg); $i++){
                        ?>
                        <option value="<?php echo $lgdg[$i][0];?>"><?php echo $lgdg[$i][1];?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="my-2">
                    <label for="txt-ttgdg">No TT Gudang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" maxlength="100" id="txt-ttgdg">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-sspo">Kirim</button>
            </div>
        </div>
    </div>
</div>