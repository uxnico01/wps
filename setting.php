<?php
    require("./bin/php/clsfunction.php");

    $db = openDB();

    $nav = 6;

    $ttl = "Utility - Setting";

    $sett = getSett();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>KumaBis - Others - Setting</title>
    
    <?php
        require("./bin/php/head.php");
    ?>
</head>
<body>
    <div class="header">
        <?php
            if(!CekAksUser(substr($duser[7],95,1)))
                ToHome();
        
            require("./bin/php/nav.php");
        ?>
    </div>
    
    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <h5 class="m-0 ml-2 text-info">Setting</h5><hr class="mt-0">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-2">
                    <div class="card p-0" id="card-aks-0">
                        <div class="card-header csr-pntr font-weight-bold" id="div-dhead-0">Setting - Margin</div>

                        <div class="card-body py-1" id="div-dcard-0" style="overflow-x:hidden; overflow-y:scroll;">
                            <div class="mb-3">
                                <label class="m-0" for="slct-mcut">Margin Error Cutting</label>
                                <div class="input-group">
                                    <select name="slct-mcut" id="slct-mcut" class="custom-select inp-jl">
                                        <option value="1" <?php if(strcasecmp($sett[0][1],"1") == 0) echo "selected=\"selected\"";?>>Lebih Kecil</option>
                                        <option value="2" <?php if(strcasecmp($sett[0][1],"2") == 0) echo "selected=\"selected\"";?>>Lebih Besar</option>
                                    </select>

                                    <div class="input-group-append">
                                        <input type="number" class="form-control" min="0" max="100" step="any" id="nmbr-mcut" value="<?php echo $sett[0][2];?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="m-0" for="slct-mvac">Margin Error Vacuum</label>
                                <div class="input-group">
                                    <select name="slct-mvac" id="slct-mvac" class="custom-select inp-jl">
                                        <option value="1" <?php if(strcasecmp($sett[1][1],"1") == 0) echo "selected=\"selected\"";?>>Lebih Kecil</option>
                                        <option value="2" <?php if(strcasecmp($sett[1][1],"2") == 0) echo "selected=\"selected\"";?>>Lebih Besar</option>
                                    </select>

                                    <div class="input-group-append">
                                        <input type="number" class="form-control" min="0" max="100" step="any" id="nmbr-mvac" value="<?php echo $sett[1][2];?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="m-0" for="slct-msaw">Margin Error Sawing</label>
                                <div class="input-group">
                                    <select name="slct-msaw" id="slct-msaw" class="custom-select inp-jl">
                                        <option value="1" <?php if(strcasecmp($sett[2][1],"1") == 0) echo "selected=\"selected\"";?>>Lebih Kecil</option>
                                        <option value="2" <?php if(strcasecmp($sett[2][1],"2") == 0) echo "selected=\"selected\"";?>>Lebih Besar</option>
                                    </select>

                                    <div class="input-group-append">
                                        <input type="number" class="form-control" min="0" max="100" step="any" id="nmbr-msaw" value="<?php echo $sett[2][2];?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-2">
                    <div class="card p-0" id="card-aks-1">
                        <div class="card-header csr-pntr font-weight-bold" id="div-dhead-1">Setting - Gudang</div>

                        <div class="card-body py-1" id="div-dcard-1" style="overflow-x:hidden; overflow-y:scroll;">
                            <div class="mb-3">
                                <label class="m-0" for="slct-gdg">Gudang Proses</label>
                                <div class="input-group">
                                    <select name="slct-gdg" id="slct-gdg" class="custom-select inp-jl">
                                        <?php
                                            $lgdg = getAllGdg($db);
                                            for($i = 0; $i < count($lgdg); $i++){
                                        ?>
                                        <option value="<?php echo $lgdg[$i][0];?>" <?php if(strcasecmp($lgdg[$i][0],$sett[3][3]) == 0) echo "selected=\"selected\"";?>><?php echo $lgdg[$i][1];?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="m-0" for="slct-kgdg">Gudang Pengiriman</label>
                                <div class="input-group">
                                    <select name="slct-kgdg" id="slct-kgdg" class="custom-select inp-jl">
                                        <?php
                                            $lgdg = getAllGdg($db);
                                            for($i = 0; $i < count($lgdg); $i++){
                                        ?>
                                        <option value="<?php echo $lgdg[$i][0];?>" <?php if(strcasecmp($lgdg[$i][0],$sett[4][3]) == 0) echo "selected=\"selected\"";?>><?php echo $lgdg[$i][1];?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-2">
                    <div class="card p-0" id="card-aks-1">
                        <div class="card-header csr-pntr font-weight-bold" id="div-dhead-1">Setting - Cutting</div>

                        <div class="card-body py-1" id="div-dcard-c1" style="overflow-x:hidden; overflow-y:scroll;">
                            <?php
                                $lset = getAllSett("ASCHPRO", $db);
                            ?>
                            <div class="mb-3">
                                <h6 class="mb-1">Daftar Produk Tetelan dan lainnya <button class="btn btn-light btn-sm border-0 p-1" id="btn-achpro" data-count="<?php echo count($lset);?>"><img src="./bin/img/icon/plus.png" width="18" alt="Add"></button></h6>
                                <div class="mxh-20vh">
                                    <ul id="lst-chpro">
                                        <?php
                                            for($i = 0; $i < count($lset); $i++){
                                                $dpro = getProID2($lset[$i][1], $db);
                                                $nama = $dpro[1]." / ".$dpro[15];

                                                if(strcasecmp($dpro[16],"") != 0){
                                                    $nama .= " / ".$dpro[16];
                                                }

                                                if(strcasecmp($dpro[17],"") != 0){
                                                    $nama .= " / ".$dpro[17];
                                                }
                                        ?>
                                        <li id="ls-achpro-<?php echo $i;?>"><?php echo $nama;?><button class="btn btn-sm btn-light btn-dachpro" data-value="<?php echo UE64($lset[$i][1]);?>" data-id="<?php echo UE64($lset[$i][0]);?>" id="btn-dachpro-<?php echo $i;?>" data-count="<?php echo UE64($i);?>"><img src="./bin/img/icon/cancel-icon.png" width="18"></button></li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-body py-1" id="div-dcard-c2" style="overflow-x:hidden; overflow-y:scroll;">
                            <?php
                                $lset = getAllSett("ASCHNPRO", $db);
                            ?>
                            <div class="mb-3">
                                <h6 class="mb-1">Daftar Produk Tulang dan lainnya <button class="btn btn-light btn-sm border-0 p-1" id="btn-achnpro" data-count="<?php echo count($lset);?>"><img src="./bin/img/icon/plus.png" width="18" alt="Add"></button></h6>
                                <div class="mxh-20vh">
                                    <ul id="lst-chnpro">
                                        <?php
                                            for($i = 0; $i < count($lset); $i++){
                                                $dpro = getProID2($lset[$i][1], $db);
                                                $nama = $dpro[1]." / ".$dpro[15];

                                                if(strcasecmp($dpro[16],"") != 0){
                                                    $nama .= " / ".$dpro[16];
                                                }

                                                if(strcasecmp($dpro[17],"") != 0){
                                                    $nama .= " / ".$dpro[17];
                                                }
                                        ?>
                                        <li id="ls-achnpro-<?php echo $i;?>"><?php echo $nama;?><button class="btn btn-sm btn-light btn-dachpro" data-value="<?php echo UE64($lset[$i][1]);?>" data-id="<?php echo UE64($lset[$i][0]);?>" id="btn-dachnpro-<?php echo $i;?>" data-count="<?php echo UE64($i);?>"><img src="./bin/img/icon/cancel-icon.png" width="18"></button></li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-2">
                    <div class="card p-0" id="card-aks-0">
                        <div class="card-header csr-pntr font-weight-bold" id="div-dhead-0">Setting - Harga Cutting</div>

                        <div class="card-body py-1" id="div-dcard-0" style="overflow-x:hidden; overflow-y:scroll;">
                            <div class="mb-3">
                                <label class="m-0" for="nmbr-hcut">Persentase Harga Hasil Cutting (%)</label>
                                <input type="number" id="nmbr-hcut" class="form-control" max="100" step="any" value="<?php echo $sett[5][2];?>">
                            </div>

                            <div class="mb-3">
                                <label class="m-0" for="nmbr-hpcut">Persentase Harga Produk Tetelan dan lainnya (%)</label>
                                <input type="number" id="nmbr-hpcut" class="form-control" max="100" step="any" value="<?php echo $sett[6][2];?>">
                            </div>

                            <div class="mb-3">
                                <label class="m-0" for="nmbr-hpncut">Persentase Harga Produk Tulang dan lainnya (%)</label>
                                <input type="number" id="nmbr-hpncut" class="form-control" max="100" step="any" value="<?php echo $sett[7][2];?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lmodals">
                <?php
                    require("./modals/mdl-spro8.php");
                ?>
            </div>
            
            <div class="col-12 p-0 mt-3">
                <button class="btn btn-light border-primary" type="button" id="btn-sset"><img src="./bin/img/icon/save-icon.png" alt="Save" width="25"> <span>Simpan</span></button>
            </div>
        </div>
    </div>
    
    <?php
        require("./bin/php/footer.php");

        closeDB($db);
    ?>
</body>
</html>