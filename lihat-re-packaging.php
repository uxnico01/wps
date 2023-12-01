<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    $data = getRPkgID($id, $db);
    $data2 = getRPkgItem($id, $db);

    $nma = $data[9]." / ".$data[10];

    if(strcasecmp($data[11],"") != 0){
        $nma .= " / ".$data[11];
    }

    if(strcasecmp($data[12],"") != 0){
        $nma .= " / ".$data[12];
    }

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Re - Packing | PT. Winson Prima Sejahtera</title>
    
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
                if(cekAksUser(substr($duser[7], 176, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-3 container div-print <?php if(!cekAksUser(substr($duser[7], 176, 1))) echo "no-print";?>">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <td colspan="17" class="h4 font-weight-bold text-center">Tally Re-Packaging</td>
                </tr>
                
                <tr>
                    <td class="text-left" colspan="3">Nomor : <span class="font-weight-bold"><?php echo $id;?></span></td>
                </tr>
                
                <tr>
                    <td class="text-left" colspan="3">Tanggal : <span class="font-weight-bold"><?php echo date('d - m - Y', strtotime($data[2]));?></span></td>
                </tr>
                
                <tr>
                    <td class="text-left" colspan="3">Tally : <span class="font-weight-bold"><?php echo $data[3];?></span></td>
                </tr>
                
                <tr>
                    <td class="text-left" colspan="3">Produk Awal : <span class="font-weight-bold"><?php echo $nma." ("; if(isDecimal($data[8])) echo number_format($data[8], 2, '.', ','); else echo number_format($data[8], 0, '.', ','); echo " KG)";?></span></td>
                </tr>
                
                <tr>
                    <td class="text-left" colspan="3">Ket : <span class="font-weight-bold"><?php echo $data[13];?></span></td>
                </tr>

                <tr class="thead-dark">
                    <th class="border align-middle text-center">No</th>
                    <th class="border align-middle">Produk</th>
                    <th class="border align-middle text-right">Berat (KG)</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $sum = 0;
                    for($i = 0; $i < count($data2); $i++){
                        $nma = $data2[$i][4]." / ".$data2[$i][5];

                        if(strcasecmp($data2[$i][6],"") != 0){
                            $nma .= " / ".$data2[$i][6];
                        }
                        
                        if(strcasecmp($data2[$i][7],"") != 0){
                            $nma .= " / ".$data2[$i][7];
                        }
                ?>
                <tr>
                    <td class="border text-center"><?php echo $i+1;?></td>
                    <td class="border"><?php echo $nma;?></td>
                    <td class="border text-right"><?php if(isDecimal($data2[$i][2])) echo number_format($data2[$i][2], 2, '.', ','); else echo number_format($data2[$i][2], 0, '.', ',');?></td>
                </tr>
                <?php
                        $sum += $data2[$i][2];
                    }
                ?>
                <tr>
                    <td class="border text-right font-weight-bold" colspan="2">Total</td>
                    <td class="border text-right font-weight-bold"><?php if(isDecimal($sum)) echo number_format($sum, 2, '.', ','); else echo number_format($sum, 0, '.', ',');?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
        CloseDB($db);
    ?>
</body>
</html>