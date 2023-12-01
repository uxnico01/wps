<?php
    require("./bin/php/clsfunction.php");

    $db = OpenDB();

    $id = UD64(trim(mysqli_real_escape_string($db,$_GET["id"])));

    CloseDB($db);

    $data = getBBID($id);

    $duser = getUserID($_SESSION["user-kuma-wps"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaksi - BB | PT. Winson Prima Sejahtera</title>
    
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
                if(CekAksUser(substr($duser[7], 149, 1)))
                {
            ?>
            <button class="btn btn-sm btn-light border border-primary m-1 btn-print"><img src="./bin/img/icon/print-icon.png" alt="" width="25"> <span class="small">Print</span></button>
            <?php
                }
            ?>
            <button class="btn btn-sm btn-light border border-danger m-1 btn-close-view"><img src="./bin/img/icon/exit-icon.png" alt="" width="25"> <span class="small">Exit</span></button>
        </div>
    </div>

    <div class="my-2 container div-print <?php if(!cekAksUser(substr($duser[7], 149, 1))) echo "no-print";?>">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th colspan="3" class="font-weight-bolder text-center h5 pt-2 pb-4"><u><?php if(strcasecmp($data[4],"IN") == 0) echo "Penerimaan"; else echo "Pengeluaran";?> BB</u></th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="">No Transaksi</td>
                    <td colspan="2">: <?php echo $data[0];?></td>
                </tr>

                <tr>
                    <td class="">Tgl Transaksi</td>
                    <td colspan="2">: <?php echo date('d/m/Y', strtotime($data[1]));?></td>
                </tr>

                <tr>
                    <td class="">Uang Sejumlah</td>
                    <td colspan="2">: # <?php echo terbilang($data[2]);?> Rupiah # (Rp. <strong><?php echo number_format($data[2],0,'.',',');?></strong>)</td>
                </tr>

                <tr>
                    <td class="">Keterangan</td>
                    <td colspan="2">: <?php echo $data[3];?></td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td class="<?php if(strcasecmp($data[4],"OUT") == 0) echo "text-right"; else echo "text-center";?>" colspan="2"><br>Dibuat Oleh,<br><br><br><br>__________________</td>

                    <td class="text-center <?php if(strcasecmp($data[4],"OUT") == 0) echo "d-none";?>"><br>Yang Menerima,<br><br><br><br>__________________</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>