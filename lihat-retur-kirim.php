<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    $data = getRKirimID($id, $db);
    $dtl = getRKirimItem($id, $db);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - Retur Kirim | PT. Winson Prima Sejahtera</title>
    
    <?php
        if(file_exists("./bin/php/head.php"))
            require("./bin/php/head.php");
    ?>

    <style>
        table *
        {
            border: none !important;
        }
    </style>
</head>
<body>
    <div class="my-2 no-print">
        <div class="col-12">
            <?php
                if(cekAksUser(substr($duser[7], 193, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-3 container div-print <?php if(!cekAksUser(substr($duser[7], 193, 1))) echo "no-print";?>">
        <div>
            <div class="col-12 p-0">
                <h3 class="text-center">Retur Kirim</h3>
                
                <div class="my-1"><span class="font-weight-bold">No</span> : <?php echo $data[0];?></div>
                <div class="my-1"><span class="font-weight-bold">Tanggal</span> : <?php echo date('d/m/Y', strtotime($data[3]));?></div>
                <div class="my-1"><span class="font-weight-bold">Retur Dari PO</span> : <?php echo $data[2];?></div>
                <div class="my-1"><span class="font-weight-bold">Deskripsi</span> : <?php echo $data[4];?></div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm mt-1 mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border align-middle">Kode</th>
                            <th class="border align-middle">Produk</th>
                            <th class="border align-middle text-right">Berat (KG)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $ttl = 0;
                            for($i = 0; $i < count($dtl); $i++)
                            {
                                $nma = $dtl[$i][3]." / ".$dtl[$i][4];

                                if(strcasecmp($dtl[$i][5],"") != 0){
                                    $nma .= " / ".$dtl[$i][5];
                                }

                                if(strcasecmp($dtl[$i][6],"") != 0){
                                    $nma .= " / ".$dtl[$i][6];
                                }
                        ?>
                        <tr>
                            <td class="border"><?php echo $dtl[$i][1];?></td>
                            <td class="border"><?php echo $nma;?></td>
                            <td class="border text-right"><?php if(isDecimal($dtl[$i][2])) echo number_format($dtl[$i][2],2,'.',','); else echo number_format($dtl[$i][2],0,'.',',');?></td>
                        </tr>
                        <?php
                                $ttl += $dtl[$i][2];
                            }

                            if(count($dtl) < 6){
                                for($i = count($dtl); $i < 6; $i++){
                        ?>
                        <tr>
                            <td class="border h-m34"></td>
                            <td class="border h-m34"></td>
                            <td class="border h-m34"></td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                        <tr>
                            <td class="border-0 font-weight-bold text-right" colspan="2">Total</td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($ttl)) echo number_format($ttl,2,'.',','); else echo number_format($ttl,0,'.',',');?></td>
                            <td class="border-0" colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="div-mdl">
        <?php
            CloseDB($db);        
        ?>
    </div>
</body>
</html>