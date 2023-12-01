<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    CloseDB($db);

    $data = getPjmID($id);
    $sup = getSupID($data[1]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - Peminjaman | PT. Winson Prima Sejahtera</title>
    
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
                if(CekAksUser(substr($duser[7], 56, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-2 container div-print <?php if(!cekAksUser(substr($duser[7], 56, 1))) echo "no-print";?>">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th colspan="3" class="h4 font-weight-bold text-center py-0">PT WINSON PRIMA SEJAHTERA</th>
                </tr>
                
                <tr>
                    <th colspan="3" class="h6 font-weight-bold text-center py-0">Jl. Pulau Solor II No.11/12, Sampali, Kec. Percut Sei Tuan</th>
                </tr>

                <tr>
                    <th colspan="3" class="h6 font-weight-bold text-center py-0">Kabupaten Deli Serdang, Sumatera Utara 20251</th>
                </tr>

                <tr>
                    <th colspan="3" class="h6 font-weight-bold text-center py-0">Tel. (061) 6871741</th>
                </tr>

                <tr>
                    <th colspan="3" class="font-weight-bolder text-center h5 py-2"><u>KWITANSI</u></th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="">Telah Terima Dari</td>
                    <td colspan="2">: PT. Winson Prima Sejahtera</td>
                </tr>

                <tr>
                    <td class="">Uang Sejumlah</td>
                    <td colspan="2">: # <?php echo terbilang($data[3]);?> Rupiah#</td>
                </tr>

                <tr>
                    <td class="">Untuk Tujuan</td>
                    <td colspan="2">: Peminjaman No. <?php echo $data[0].", ".$sup[1];?></td>
                </tr>

                <tr>
                    <td class="">Keterangan</td>
                    <td colspan="2">: <?php echo $data[5]." ".$data[6]." ".$data[7];?></td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2"><br>Rp. <strong><?php echo number_format($data[3]-$data[12],0,'.',',');?></strong></td>

                    <td class="text-right"><br>Yang Menerima,<br><br><br><br>__________________</td>
                </tr>
            </tfoot>
        </table>
        <div class="py-3">
            <h6>History Pembayaran / Pemotongan</h6>
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th class="border">No</th>
                        <th class="border">Tgl</th>
                        <th class="border">Nota</th>
                        <th class="border text-right">Jumlah</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $n = 1;
                        $spjm = getSumSupPjm4($data[1], $data[9]);
                        $ltrm = getTrmSupSPjm($data[1], $spjm);

                        $sum = 0;
                        if($data[12] != 0)
                        {
                    ?>
                    <tr>
                        <td class="border"><?php echo $n;?></td>
                        <td class="border"><?php echo date('d/m/Y', strtotime($data[2]));?></td>
                        <td class="border">Potongan Lain</td>
                        <td class="border text-right"><?php if(isDecimal($data[12])) echo number_format($data[12],2,'.',','); else echo number_format($data[12], 0, '.', ',');?></td>
                    </tr>
                    <?php
                            $n++;
                            $sum += $data[12];
                        }

                        for($i = 0; $i < count($ltrm); $i++)
                        {
                            $val = $ltrm[$i][2];

                            if($sum >= $data[3])
                                break;
                            else if($sum + $ltrm[$i][2] > $data[3])
                            {
                                $val = $data[3] - $sum;
                            }
                    ?>
                    <tr>
                        <td class="border"><?php echo $n;?></td>
                        <td class="border"><?php echo date('d/m/Y', strtotime($ltrm[$i][0]));?></td>
                        <td class="border"><?php echo $ltrm[$i][1];?></td>
                        <td class="border text-right"><?php if(isDecimal($val)) echo number_format($val,2,'.',','); else echo number_format($val, 0, '.', ',');?></td>
                    </tr>
                    <?php
                            $n++;
                            $sum += $val;
                        }
                    ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td class="border text-right font-weight-bold" colspan="3">Total</td>
                        <td class="border text-right font-weight-bold"><?php if(isDecimal($sum)) echo number_format($sum,2,'.',','); else echo number_format($sum, 0, '.', ',');?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>