<?php
    require("./bin/php/clsfunction.php");

    $nav = 4;

    $db = openDB();

    $ttl = "Tambah - Cutting";

    $lsup = "{";
    $lasup = getAllSup();
    for($i = 0; $i < count($lasup); $i++)
        $lsup .= "\"".$lasup[$i][1]."\":\"".$lasup[$i][0]."\",";
    $lsup .= "}";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah - Cutting | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 68, 1)))
                toHome();

            require("./bin/php/nav.php");
        ?>
    </div>

    <div class="col-12 pb-3 px-0">
        <div class="col-12 p-0">
            <div class="table-responsive mxh-68vh" data-value="">
                <table class="table table-sm table-hover table-striped table-data">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border align-middle w-40px">No</th>
                            <th class="border align-middle w-120px">Tgl Cut</th>
                            <th class="border align-middle w-200px">Supplier</th>
                            <th class="border align-middle w-450px">Produk</th>
                            <th class="border align-middle w-80px">Suhu</th>
                            <th class="border align-middle w-80px">Premium</th>
                            <th class="border align-middle text-right w-120px">Cut 1 (KG)</th>
                            <th class="border align-middle text-right w-120px">Cut 2 (KG)</th>
                            <th class="border align-middle text-right w-120px">Cut 3 (KG)</th>
                            <th class="border align-middle text-right w-120px">Cut 4 (KG)</th>
                            <th class="border align-middle w-180px">Ket</th>
                            <th class="border align-middle w-80px">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-cut">
                        
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="12"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3 row m-0">
                <div class="col-12 col-sm-12 col-md-6">
                    <button class="btn btn-sm btn-outline-success m-1" id="btn-ndcut" data-count="0"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Baris</span></button>
                </div>
            </div><hr>

            <?php
                $lset = getAllSett("ASCHPRO", $db);
                $spro = "";
                if(count($lset) > 0){
            ?>
            <h5 class="mb-0 mt-3 pl-2">Hasil Tetelan dan lainnya</h5>
            <div class="table-responsive mxh-40vh">
                <table class="table table-sm table-hover table-striped tbl-ncutpro">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border align-middle w-120px">Tgl Cut</th>
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
                            <th class="border align-middle text-right w-250px"><span class="small"><?php echo $nama;?></span> (KG)</th>
                            <?php
                                    if($i > 0){
                                        $spro .= "||";
                                    }
                                    
                                    $spro .= $lset[$i][1];
                                }
                            ?>
                            <th class="border align-middle w-80px">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-ncutpro">
                        
                    </tbody>
                </table>
            </div>

            <div class="mt-3 row mb-0 mx-0">
                <div class="col-12 col-sm-12 col-md-6">
                    <button class="btn btn-sm btn-outline-success m-1" id="btn-ndcutpro" data-count="0" data-cset="<?php echo count($lset);?>" data-spro="<?php echo UE64($spro);?>"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Baris</span></button>
                </div>
            </div><hr>
            <?php
                }
                
                $lset = getAllSett("ASCHNPRO", $db);
                $spro = "";
                if(count($lset) > 0){
            ?>
            <h5 class="mb-0 mt-3 pl-2">Hasil Tulang dan lainnya</h5>
            <div class="table-responsive mxh-40vh">
                <table class="table table-sm table-hover table-striped tbl-ncutnpro">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border align-middle w-120px">Tgl Cut</th>
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
                            <th class="border align-middle text-right w-250px"><span class="small"><?php echo $nama;?></span> (KG)</th>
                            <?php
                                    if($i > 0){
                                        $spro .= "||";
                                    }

                                    $spro .= $lset[$i][1];
                                }
                            ?>
                            <th class="border align-middle w-80px">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-ncutnpro">
                        
                    </tbody>
                </table>
            </div>
            <?php
                }
            ?>

            <div class="mt-3 row mb-0 mx-0">
                <?php
                    if(count($lset) > 0){
                ?>
                <div class="col-12 col-sm-12 col-md-6">
                    <button class="btn btn-sm btn-outline-success m-1" id="btn-ndcutnpro" data-count="0" data-cset="<?php echo count($lset);?>" data-spro="<?php echo UE64($spro);?>"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Baris</span></button>
                </div>
                <?php
                    }
                ?>
                
                <div class="<?php if(count($lset) == 0) echo "offset-md-6";?> col-12 col-sm-12 col-md-6 text-right">
                    <button class="btn btn-sm btn-primary m-1" id="btn-sdcut"><span class="small">Selesai dan keluar</span></button>
                </div>
            </div>

            <div class="lscript">
                <script type="text/javascript">
                    lsup = <?php echo $lsup;?>;

                    $(window).bind('beforeunload', function(){
                        return 'Are you sure you want to leave?';
                    });
                </script>
            </div>

            <div class="lmodals">
                <?php
                    require("./modals/mdl-spro7.php");
                ?>
            </div>
        </div>
    </div>

    <?php
        require("./bin/php/footer.php");

        closeDB($db);
    ?>
</body>
</html>