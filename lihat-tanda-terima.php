<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    CloseDB($db);

    $data = getTTID($id);
    $sup = getSupID($data[1]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - Tanda Terima | PT. Winson Prima Sejahtera</title>
    
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
                if(cekAksUser(substr($duser[7], 51, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-2 container div-print <?php if(!cekAksUser(substr($duser[7], 51, 1))) echo "no-print";?>">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th colspan="7" class="h4 font-weight-bold text-center">Tanda Terima Bahan</th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Nomor</th>
                    <th colspan="2" class="text-left">: <?php echo $id;?></th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Tanggal</th>
                    <th colspan="2" class="text-left">: <?php echo date('d - m - Y', strtotime($data[2]));?></th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left">Supplier</th>
                    <th colspan="2" class="text-left">: <?php echo $sup[1];?></th>
                </tr>

                <tr class="thead-dark">
                    <th class="border align-middle">Grade</th>
                    <th class="border align-middle">Produk</th>
                    <th class="border align-middle">Satuan</th>
                    <th class="border align-middle text-right">Qty (Ekor)</th>
                    <th class="border align-middle text-right">Qty (KG)</th>
                    <th class="border align-middle text-right">Harga / KG</th>
                    <th class="border align-middle text-right">Total Harga</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $data2 = getTTItem($id);

                    for($i = 0; $i < count($data2); $i++)
                    {
                        $pro = getProID($data2[$i][1]);
                        $sat = getSatuanID($data2[$i][5]);
                        $grade = getGradeID($pro[4]);

                        $ttl = $data2[$i][3] * $data2[$i][4];

                        $dcl = 0;
                        if(isDecimal($data2[$i][3]))
                            $dcl = 2;

                        $hdcl = 0;
                        if(isDecimal($data2[$i][4]))
                            $hdcl = 2;

                        $tdcl = 0;
                        if(isDecimal($ttl))
                            $tdcl = 2;
                ?>
                <tr>
                    <td class="border"><?php echo $grade[1];?></td>
                    <td class="border"><?php echo $pro[1];?></td>
                    <td class="border"><?php echo $sat[1];?></td>
                    <td class="border text-right"><?php echo number_format($data2[$i][2], 0, '.', ',');?></td>
                    <td class="border text-right"><?php echo number_format($data2[$i][3], $dcl, '.', ',');?></td>
                    <td class="border text-right"><?php echo number_format($data2[$i][4], $hdcl, '.', ',');?></td>
                    <td class="border text-right"><?php echo number_format($ttl, $tdcl, '.', ',');?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>

            <tfoot>
                <?php
                    $lsat = getAllSatuan();

                    $sarr = array(0, 0, 0);
                    for($i = 0; $i < count($lsat); $i++)
                    {
                        $sum = getSumItemTTSat($id, $lsat[$i][0]);

                        if($sum[0] == 0)
                            continue;
                ?>
                <tr>
                    <td class="" colspan="3">Total Ikan <?php echo $lsat[$i][1];?></td>

                    <td class="text-right"><?php echo number_format($sum[0],0,'.',',');?> Ekor</td>

                    <td class="text-right" colspan="2"><?php if(isDecimal($sum[1])) echo number_format($sum[1],2,'.',','); else echo number_format($sum[1],0,'.',',');?> KG</td>

                    <td class="text-right" colspan="2"><?php if(isDecimal($sum[2])) echo number_format($sum[2],2,'.',','); else echo number_format($sum[2],0,'.',',');?></td>
                </tr>
                <?php
                        $sarr[0] += $sum[0];
                        $sarr[1] += $sum[1];
                        $sarr[2] += $sum[2];
                    }
                ?>
                <tr>
                    <td class="text-left border-top border-dark" colspan="3">Total Ikan</td>

                    <td class="text-right border-top border-dark"><?php echo number_format($sarr[0],0,'.',',');?> Ekor</td>

                    <td class="text-right border-top border-dark" colspan="2"><?php if(isDecimal($sarr[1])) echo number_format($sarr[1],2,'.',','); else echo number_format($sarr[1],0,'.',',');?> KG</td>

                    <td class="text-right border-top border-dark" colspan="2"><?php if(isDecimal($sarr[2])) echo number_format($sarr[2],2,'.',','); else echo number_format($sarr[2],0,'.',',');?></td>
                </tr>
                <?php
                    if($data[4] != 0)
                    {
                ?>
                <tr>
                    <td class="text-right" colspan="5">Total Potongan</td>

                    <td class="text-right" colspan="2">(<?php if(isDecimal($data[4])) echo number_format($data[4],2,'.',','); else echo number_format($data[4],0,'.',',');?>)</td>
                </tr>
                <?php
                    }

                    if($data[3] != 0)
                    {
                ?>
                <tr>
                    <td class="text-right" colspan="5">BB</td>

                    <td class="text-right" colspan="2">(<?php if(isDecimal($data[3])) echo number_format($data[3],2,'.',','); else echo number_format($data[3],0,'.',',');?>)</td>
                </tr>
                <?php
                    }

                    $sisa = $sarr[2] - $data[3] - $data[4];
                ?>
                <tr>
                    <td class="text-right border-top border-dark" colspan="5">Sisa</td>

                    <td class="text-right border-top border-dark" colspan="2"><?php if($sisa < 0) echo "("; if(isDecimal($sisa)) echo number_format($sisa,2,'.',','); else echo number_format($sisa,0,'.',','); if($sisa < 0) echo ")";?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>