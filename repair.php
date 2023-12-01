<?php
    require("./bin/php/clsfunction.php");

    $nav = 6;

    $ttl = "Utility - Repair";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Utility - Repair | PT Winson Prima Sejahtera</title>
    
    <?php
        require("./bin/php/head.php");
    ?>
</head>
<body>
    <div class="header">
        <?php
            if(!CekAksUser(substr($duser[7],122,1)))
                ToHome();
        
            require("./bin/php/nav.php");
        ?>
    </div>
    
    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <h5 class="m-0 ml-2 text-info">Repair</h5><hr class="mt-0">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 mb-2">
                    <button class="btn btn-light btn-block border border-warning" id="btn-rstk">Repair Produk</button>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 mb-2">
                    <button class="btn btn-light btn-block border border-warning" id="btn-rpjm">Repair Pinjaman</button>
                </div>
            </div>
        </div>
    </div>
    
    <?php
        require("./bin/php/footer.php");
    ?>
</body>
</html>