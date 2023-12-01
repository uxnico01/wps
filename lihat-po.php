<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    $data = getPOID($id, $db);
    $dtl = getPOItem($id, $db);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses - Penerimaan | PT. Winson Prima Sejahtera</title>
    
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
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-3 container div-print">
        <div>
            <div class="col-12 p-0">
                <h3 class="text-center">Permohonan <span class="text-success">Pengeluaran</span> Barang</h3>
                <div class="row">
                    <div class="col-9">
                        <div class="my-1"><span class="font-weight-bold">No</span> : <?php echo $data[10];?></div>
                        <div class="my-1"><span class="font-weight-bold">Tanggal</span> : <?php echo date('d/m/Y', strtotime($data[2]));?></div>
                    </div>
                </div>
                <div class="my-1"><span class="font-weight-bold">Customer</span> : <?php echo $data[11];?></div>
                <div class="my-1"><span class="font-weight-bold">Deskripsi</span> : Untuk pengiriman PO no <?php echo $data[0];?></div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm mt-1 mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border align-middle text-center">No</th>
                            <th class="border align-middle">Kode</th>
                            <th class="border align-middle">Produk</th>
                            <th class="border align-middle text-right">Qty</th>
                            <th class="border align-middle">Satuan</th>
                            <th class="border align-middle">Expired</th>
                            <th class="border align-middle text-right">Berat (KG)</th>
                            <th class="border align-middle">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $ttl = array();
                            for($i = 0; $i < count($dtl); $i++)
                            {
                                $nma = $dtl[$i][1]." / ".$dtl[$i][2];

                                if(strcasecmp($dtl[$i][3],"") != 0){
                                    $nma .= " / ".$dtl[$i][3];
                                }

                                if(strcasecmp($dtl[$i][4],"") != 0){
                                    $nma .= " / ".$dtl[$i][4];
                                }
                        ?>
                        <tr>
                            <td class="border text-center"><?php echo $i+1;?></td>
                            <td class="border"><?php echo $dtl[$i][0];?></td>
                            <td class="border"><?php echo $nma;?></td>
                            <td class="border text-right"><?php if(isDecimal($dtl[$i][5])) echo number_format($dtl[$i][5], 2, '.', ','); else echo number_format($dtl[$i][5],0,'.',',');?></td>
                            <td class="border"><?php echo $dtl[$i][6];?></td>
                            <td class="border"><?php echo date('d/m/Y', strtotime($dtl[$i][7]));?></td>
                            <td class="border text-right"><?php if(isDecimal($dtl[$i][8])) echo number_format($dtl[$i][8], 2, '.', ','); else echo number_format($dtl[$i][8],0,'.',',');?></td>
                            <td class="border"><?php echo $dtl[$i][9];?></td>
                        </tr>
                        <?php
                                $ttl[0] += $dtl[$i][5];
                                $ttl[1] += $dtl[$i][8];
                            }

                            if(count($dtl) < 6){
                                for($i = count($dtl); $i < 6; $i++){
                        ?>
                        <tr>
                            <td class="border h-m34"></td>
                            <td class="border h-m34"></td>
                            <td class="border h-m34"></td>
                            <td class="border h-m34"></td>
                            <td class="border h-m34"></td>
                            <td class="border h-m34"></td>
                            <td class="border h-m34"></td>
                            <td class="border h-m34"></td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                        <tr>
                            <td class="border-0 font-weight-bold text-right" colspan="3">Total</td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($ttl[0])) echo number_format($ttl[0], 2, '.',','); else echo number_format($ttl[0],0,'.',',');?></td>
                            <td class="border-0" colspan="2"></td>
                            <td class="border font-weight-bold text-right"><?php if(isDecimal($ttl[1])) echo number_format($ttl[1], 2, '.',','); else echo number_format($ttl[1],0,'.',',');?></td>
                        </tr>

                        <tr>
                            <td class="border-0 text-center" colspan="3"><br>Dikeluarkan Oleh,<br><br><br><br>____________________</td>
                            <td class="border-0 text-center" colspan="2"><br>Diterima Oleh,<br><br><br><br>____________________</td>
                            <td class="border-0 text-center"><br>Diajukan Oleh,<br>PT WPS TUNA<br><br><br>____________________</td>
                            <td class="border-0 text-center" colspan="2"><br>Diketahui Oleh,<br><br><br><br>____________________</td>
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