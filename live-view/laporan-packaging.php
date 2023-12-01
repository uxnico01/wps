<?php
    require("../bin/php/clsfunction.php");

    $nav = 1;

    $ttl = "Live View - Laporan Packaging";

    $tgl = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Live View - Laporan Packaging | PT Winson Prima Sejahtera</title>

    <?php
        require("../bin/php/head-live.php");
    ?>
</head>

<body class="mh-100">
    <div class="container-fluid py-2" style="min-height: 100vh;">
        <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 mt-2 mb-2 no-print mx-auto">
            <div class="input-group">
                <select name="slct-tkrm" id="slct-tkrm" class="custom-select">
                    <option value="0">Muncul Semua</option>
                    <option value="1">Pilih P/O</option>
                </select>

                <div class="input-group-append">
                    <button class="btn btn-light border" id="btn-slv-krm"><img src="../bin/img/icon/search.png" alt="Cari" width="20"></button>
                </div>

                <div class="input-group-append">
                    <button class="btn btn-light border btn-print"><img src="../bin/img/icon/print-icon.png" alt="Print" width="20"></button>
                </div>

                <div class="input-group-append">
                    <button class="btn btn-light border btn-close-view"><img src="../bin/img/icon/cancel-icon.png" alt="Tutup" width="20"></button>
                </div>
            </div>

            <div class="input-group d-none" id="div-po">
                <input type="text" id="txt-po" class="form-control" readonly>

                <div class="">
                    <button class="btn btn-light border" data-target="#mdl-spo" data-toggle="modal" value="<?php echo UE64($tgl);?>"><img src="../bin/img/icon/folder-icon.png" alt="Cari" width="20"></button>
                </div>
            </div>
        </div><hr class="no-print">

        <div class="print-only">
            <h4>Live View - Laporan Packaging</h4>
        </div>
        <div class="row" id="lv-krm">
            <?php
                $lpo = getAllPO();

                for($i = 0; $i < count($lpo); $i++)
                {
            ?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 my-2">
                <div class="border p-3">
                    <h5 class="text-center m-0 border-bottom border-dark pb-2"><?php echo $lpo[$i][0];?></h5>
                    <ul class="py-2">
                        <?php
                            $ldpo = getKirimItemPO($lpo[$i][0]);

                            for($j = 0; $j < count($ldpo); $j++)
                            {
                                $dtl = $ldpo[$j][0]." / ";

                                if(strcasecmp($ldpo[$j][1],"") != 0)
                                    $dtl .= $ldpo[$j][1];
                                
                                $dtl .= " / ";

                                if(strcasecmp($ldpo[$j][2],"") != 0)
                                    $dtl .= $ldpo[$j][2];
                                
                                $dtl .= " / ";

                                if(strcasecmp($ldpo[$j][3],"") != 0)
                                    $dtl .= $ldpo[$j][3];
                                    
                                if(isDecimal($ldpo[$j][4]))
                                    $dtl .= " / <strong>".number_format($ldpo[$j][4],2,'.',',')."</strong>";
                                else
                                    $dtl .= " / <strong>".number_format($ldpo[$j][4],0,'.',',')."</strong>";
                        ?>
                        <li><?php echo $dtl;?></li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

    <div class="lscripts">
        <script type="text/javascript">
            $(document).ready(function() {
                $("#slct-tkrm").change(function(){
                    if(!$("#div-po").hasClass("d-none"))
                        $("#div-po").addClass("d-none");

                    if($(this).val() === "1")
                        $("#div-po").removeClass("d-none");

                    getLViewKrm();
                });
                
                setInterval(getLViewKrm, 5000);
            });
        </script>
    </div>

    <div class="lmodals">
        <?php
            require("../modals/mdl-spo.php");
        ?>
    </div>
</body>

</html>