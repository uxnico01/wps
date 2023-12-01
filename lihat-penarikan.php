<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    CloseDB($db);

    $data = getWdID($id);
    $sup = getSupID($data[1]);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - Penarikan | PT. Winson Prima Sejahtera</title>
    
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
                if(CekAksUser(substr($duser[7], 111, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-2 container div-print <?php if(!cekAksUser(substr($duser[7], 111, 1))) echo "no-print";?>">
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
                    <td class="">Telah Terima Penarikan Simpanan Dari</td>
                    <td colspan="2">: PT. Winson Prima Sejahtera</td>
                </tr>

                <tr>
                    <td class="">Uang Sejumlah</td>
                    <td colspan="2">: # <?php echo terbilang($data[3]);?> Rupiah#</td>
                </tr>

                <tr>
                    <td class="">Untuk Tujuan</td>
                    <td colspan="2">: Penarikan Simpanan No. <?php echo $data[0].", ".$sup[1];?></td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2"><br>Rp. <strong><?php echo number_format($data[3],0,'.',',');?></strong></td>

                    <td class="text-right"><br>Yang Menerima,<br><br><br><br>__________________</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>