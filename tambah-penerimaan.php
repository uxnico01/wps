<?php
    require("./bin/php/clsfunction.php");

    $nav = 4;

    $ttl = "Tambah - Penerimaan";

    $lsup = "{";
    $lasup = getAllSup();
    for($i = 0; $i < count($lasup); $i++)
        $lsup .= "\"".$lasup[$i][1]."\":\"".$lasup[$i][0]."\",";
    $lsup .= "}";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah - Penerimaan | PT Winson Prima Sejahtera</title>

    <?php
        require("./bin/php/head.php");
    ?>
</head>

<body class="d-flex flex-column mh-100">
    <div class="header">
        <?php
            if (!CekAksUser(substr($duser[7], 63, 1)))
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
                            <th class="border align-middle w-40px text-center">No</th>
                            <th class="border align-middle w-120px">Tgl Terima</th>
                            <th class="border align-middle w-150px">Supplier</th>
                            <th class="border align-middle w-100px">Tipe</th>
                            <th class="border align-middle w-250px">Produk</th>
                            <th class="border align-middle w-120px">Satuan</th>
                            <th class="border align-middle text-right w-80px">Berat (KG)</th>
                            <th class="border align-middle w-100px text-right">Harga</th>
                            <th class="border align-middle w-100px text-right">Simpanan</th>
                            <th class="border align-middle w-40px">Action</th>
                        </tr>
                    </thead>

                    <tbody id="lst-trm">
                        
                    </tbody>
                </table>
            </div>

            <div class="mt-3 row m-0">
                <div class="col-12 col-sm-12 col-md-6">
                    <button class="btn btn-sm btn-outline-success m-1" id="btn-ndtrm" data-count="0"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah Penerimaan</span></button>
                </div>
                <div class="col-12 col-sm-12 col-md-6  text-right">
                    <button class="btn btn-sm btn-primary m-1" id="btn-sdtrm"><span class="small">Selesai dan keluar</span></button>
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
        </div>
    </div>

    <?php
        require("./bin/php/footer.php");
    ?>
</body>
</html>