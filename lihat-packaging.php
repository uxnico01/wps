<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    CloseDB($db);

    $data = getKirimID($id);
    $cus = getCusID($data[1]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Packing | PT. Winson Prima Sejahtera</title>
    
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
                if(cekAksUser(substr($duser[7], 61, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-2 container div-print <?php if(!cekAksUser(substr($duser[7], 61, 1))) echo "no-print";?>">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th colspan="7" class="h4 font-weight-bold text-center">Tally Packaging</th>
                </tr>
                
                <tr>
                    <th class="font-weight-bold text-left d-none">Nomor</th>
                    <th class="text-left d-none">: <?php echo $id;?></th>
                    <th class="font-weight-bold text-left">Tanggal</th>
                    <th class="text-left" colspan="2">: <?php echo date('d - m - Y', strtotime($data[1]));?></th>
                </tr>

                <?php
                    if(strcasecmp($data[3],"") != 0 || strcasecmp($data[4],"") != 0 || strcasecmp($data[4],"") != 0)
                    {
                ?>
                <tr>
                    <th colspan="font-weight-bold text-left">Keterangan</th>
                    <th class="text-left" colspan="2"><?php echo $data[3];?></th>
                </tr>
                <?php
                        if(strcasecmp($data[4],"") != 0)
                        {
                ?>
                <tr>
                    <th colspan="font-weight-bold text-left"></th>
                    <th class="text-left" colspan="2"><?php echo $data[4];?></th>
                </tr>
                <?php
                        }

                        if(strcasecmp($data[5],"") != 0)
                        {
                ?>
                <tr>
                    <th colspan="font-weight-bold text-left"></th>
                    <th class="text-left" colspan="2"><?php echo $data[5];?></th>
                </tr>
                <?php
                        }
                    }
                ?>

                <tr class="thead-dark">
                    <th class="border align-middle">No</th>
                    <th class="border align-middle">P/O</th>
                    <th class="border align-middle">Produk</th>
                    <th class="border align-middle text-right">Qty</th>
                    <th class="border align-middle">Satuan</th>
                    <th class="border align-middle">Tgl Exp</th>
                    <th class="border align-middle text-right">Berat (KG)</th>
                    <th class="border align-middle">Ket</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $data2 = getKirimItem($id);

                    $ttl = array(0, 0);
                    for($i = 0; $i < count($data2); $i++)
                    {
                        $pro = getProID($data2[$i][1]);
                        $grade = getGradeID($pro[4]);
                        $kate = getKateID($pro[2]);
                        $skate = getSKateID($pro[3]);

                        $nmpro = $pro[1]." / ".$grade[1];

                        if(strcasecmp($kate[1],"") != 0)
                            $nmpro .= " / ".$kate[1];
                            
                        if(strcasecmp($skate[1],"") != 0)
                            $nmpro .= " / ".$skate[1];
                ?>
                <tr>
                    <td class="border"><?php echo $i+1;?></td>
                    <td class="border"><?php echo $data2[$i][4];?></td>
                    <td class="border"><?php echo $nmpro;?></td>
                    <td class="border text-right"><?php if(isDecimal($data2[$i][5])) echo number_format($data5[$i][2], 2, '.', ','); else echo number_format($data2[$i][5], 0, '.', ',');?></td>
                    <td class="border"><?php echo $data2[$i][6];?></td>
                    <td class="border"><?php echo date('d/m/Y', strtotime($data2[$i][7]));?></td>
                    <td class="border text-right"><?php if(isDecimal($data2[$i][2])) echo number_format($data2[$i][2], 2, '.', ','); else echo number_format($data2[$i][2], 0, '.', ',');?></td>
                    <td class="border"><?php echo $data2[$i][8];?></td>
                </tr>
                <?php
                        $ttl[0] += $data2[$i][5];
                        $ttl[1] += $data2[$i][2];
                    }
                ?>
            </tbody>

            <tfoot>
                <tr>
                    <td class="border font-weight-bold text-right pr-3" colspan="3">Total</td>
                    <td class="border font-weight-bold text-right"><?php if(isDecimal($ttl[0])) echo number_format($ttl[0],2,'.',','); else echo number_format($ttl[0],0,'.',',');?></td>
                    <td class="border" colspan="2"></td>
                    <td class="border font-weight-bold text-right"><?php if(isDecimal($ttl[1])) echo number_format($ttl[1],2,'.',','); else echo number_format($ttl[1],0,'.',',');?> KG</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>