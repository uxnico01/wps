<div class="modal fade" id="mdl-tbuku" tabindex="-1" role="dialog" aria-labelledby="mdl-tbuku" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tutup Buku : <?php echo date('F Y');?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pt-1">
                <div class="alert alert-danger d-none" id="div-err-tbuku-1">Pengisian tidak sesuai, harap melakukan pengecekan kembali !!!</div>

                <div class="my-3">
                    <label for="txt-stbuku">Ketik "<strong class="text-danger">SAYA SETUJU</strong>"</label>
                    <input type="text" id="txt-stbuku" name="txt-stbuku" class="form-control">
                </div>

                <div class="my-3">
                    <div>Bila anda yakin, <strong class="text-danger">check 3x</strong> dibawah ini !</div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="chk-sttp-bln" value="Y">
                        <label class="form-check-label" for="chk-sttp-bln">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="chk-sttp-bln2" value="Y">
                        <label class="form-check-label" for="chk-sttp-bln2">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="chk-sttp-bln3" value="Y">
                        <label class="form-check-label" for="chk-sttp-bln3">Yes</label>
                    </div>
                </div>

                <div class="my-3">
                    <div>Lanjut data stock saat ini ?</div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="chk-sttp-dstk" id="chk-sttp-dstk-y" value="Y">
                        <label class="form-check-label" for="chk-sttp-dstk-y">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="chk-sttp-dstk" id="chk-sttp-dstk-n" value="N">
                        <label class="form-check-label" for="chk-sttp-dstk-n">No</label>
                    </div>
                </div>

                <div class="my-3">
                    <div>Lanjut data simpanan saat ini ?</div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="chk-sttp-dsmpn" id="chk-sttp-dsmpn-y" value="Y">
                        <label class="form-check-label" for="chk-sttp-dsmpn-y">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="chk-sttp-dsmpn" id="chk-sttp-dsmpn-n" value="N">
                        <label class="form-check-label" for="chk-sttp-dsmpn-n">No</label>
                    </div>
                </div>

                <div class="my-3">
                    <div>Lanjut data pinjaman saat ini ?</div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="chk-sttp-dpjm" id="chk-sttp-dpjm-y" value="Y">
                        <label class="form-check-label" for="chk-sttp-dpjm-y">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="chk-sttp-dpjm" id="chk-sttp-dpjm-n" value="N">
                        <label class="form-check-label" for="chk-sttp-dpjm-n">No</label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm btn-primary" id="btn-stbuku">Tutup Buku</button>
            </div>
        </div>
    </div>
</div>