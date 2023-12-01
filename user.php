<?php
    require("./bin/php/clsfunction.php");

    $nav = 2;

    $ttl = "Data - User";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data - User | PT Winson Prima Sejahtera</title>
    
    <?php
        require("./bin/php/head.php");
    ?>
    
    <style>
        #mdl-user-aks .modal-dialog
        {
            width: 85%;
            max-width: 85%;
        }
        
        @media (max-width: 768px)
        {
            #mdl-user-aks .modal-dialog
            {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <?php
            if(!CekAksUser(substr($duser[7],37,5)))
                ToHome();
        
            require("./bin/php/nav.php");
        ?>
    </div>
    
    <div class="col-12 py-3 mh-80vh">
        <div class="col-12 p-0">
            <div class="row sticky-top bg-light">
                <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-6">
                    <?php
                        if(CekAksUser(substr($duser[7],38,1)))
                        {
                    ?>
                    <button class="btn btn-outline-success m-1" id="btn-nuser"><img src="./bin/img/icon/plus.png" width="20" alt="Add"> <span class="small">Tambah User</span></button>
                    <?php
                        }
                    ?>
                </div>
                
                <div class="offset-lg-2 offset-xl-3 col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 py-1">
                    <div class="input-group">
                        <input type="text" class="form-control text-right" id="txt-srch-user" placeholder="Cari User" autocomplete="off" autofocus>
                        
                        <div class="input-group-append">
                            <button class="btn btn-light border" id="btn-srch-user"><img src="./bin/img/icon/search.png" alt="Cari" width="20"></button>
                        </div>
                    </div>
                </div>
            </div><hr>
            
            <div class="table-responsive mxh-70vh">
                <table class="table table-sm table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border sticky-top">Username</th>
                            <th class="border sticky-top">Nama</th>
                            <th class="border sticky-top">Posisi</th>
                            <th class="border sticky-top">Divisi</th>
                            <th class="border sticky-top">Active</th>
                            <th class="border sticky-top">Level</th>
                            <th class="border sticky-top mw-15p">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody id="lst-user">
                        <?php
                            $lst = getAllUser();
                        
                            for($i = 0; $i < count($lst); $i++)
                            {
                        ?>
                        <tr>
                            <td class="border"><?php echo $lst[$i][0];?></td>
                            <td class="border"><?php echo $lst[$i][2];?></td>
                            <td class="border"><?php echo $lst[$i][3];?></td>
                            <td class="border"><?php echo $lst[$i][4];?></td>
                            <td class="border"><?php echo $lst[$i][5];?></td>
                            <td class="border"><?php echo $lst[$i][6];?></td>
                            <td class="border mw-15p">
                                <?php
                                    if(CekAksUser(substr($duser[7],39,1)))
                                    {
                                ?>
                                <button class="btn btn-light border-warning mb-1 p-1" onclick="eUser('<?php echo UE64($lst[$i][0]);?>')"><img src="./bin/img/icon/edit-icon.png" alt="Ralat" width="18"></button>
                                <?php
                                    }
                                
                                    if(CekAksUser(substr($duser[7],40,1)))
                                    {
                                ?>
                                <button class="btn btn-light border-danger mb-1 p-1" onclick="delUser('<?php echo UE64($lst[$i][0]);?>')"><img src="./bin/img/icon/delete-icon.png" alt="Hapus" width="18"></button>
                                <?php
                                    }
                                
                                    if(CekAksUser(substr($duser[7],41,1)))
                                    {
                                ?>
                                <button class="btn btn-light border-info mb-1 p-1" onclick="mdlUser('<?php echo UE64($lst[$i][0]);?>')"><img src="./bin/img/icon/more-info.png" alt="More" width="20"></button></td>
                                <?php
                                    }
                                ?>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <div class="lmodals">
                <?php
                    if(CekAksUser(substr($duser[7],41,1)))
                    {
                ?>
                <div class="modal fade" id="mdl-opt-user" tabindex="-1" role="dialog" aria-labelledby="mdl-opt-user" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">More Option</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body pt-1">
                                <div class="d-none">
                                    <input type="text" id="txt-opt-user">
                                </div>
                               
                                <div class="my-2">
                                    <?php
                                        if(CekAksUser(substr($duser[7],60,1)))
                                        {
                                    ?>
                                    <button class="btn btn-light border m-2" data-dismiss="modal" id="btn-usr-aks"><img src="./bin/img/icon/access-icon.png" alt="Information" width="25"> <span>Set Access</span></button>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                    
                    if(CekAksUser(substr($duser[7],41,1)))
                    {
                ?>
                <div class="modal fade" id="mdl-user-aks" tabindex="-1" role="dialog" aria-labelledby="mdl-user-aks" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mt-1" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Set Access</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-target="#mdl-opt-user" data-toggle="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body pt-1">
                                <div class="my-2 mxh-70vh mh-70vh" style="overflow-x:hidden; overflow-y:scroll;">
                                    <h5 class="m-0 ml-2 mt-3 text-info">Home</h5><hr class="mt-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-31" onmouseover="cardHvr(31)" onmouseout="cardNHvr(31)">
                                                <div class="card-header csr-pntr" id="div-dhead-31" onclick="cardAct(31)">Home <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-31" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-31">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-31" onclick="chkAll(31)">
                                                        <label class="custom-control-label" for="chk-all-31">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-0">
                                                        <label class="custom-control-label" for="chk-aks-0">Verifikasi - Transaksi</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-171">
                                                        <label class="custom-control-label" for="chk-aks-171">Verifikasi - Penyesuaian</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-1">
                                                        <label class="custom-control-label" for="chk-aks-1">Live View</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="m-0 ml-2 text-info">Data</h5><hr class="mt-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-0" onmouseover="cardHvr(0)" onmouseout="cardNHvr(0)">
                                                <div class="card-header csr-pntr" id="div-dhead-0" onclick="cardAct(0)">Supplier <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-0" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-0">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-0" onclick="chkAll(0)">
                                                        <label class="custom-control-label" for="chk-all-0">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-2">
                                                        <label class="custom-control-label" for="chk-aks-2">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-3">
                                                        <label class="custom-control-label" for="chk-aks-3">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-4">
                                                        <label class="custom-control-label" for="chk-aks-4">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-5">
                                                        <label class="custom-control-label" for="chk-aks-5">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-6">
                                                        <label class="custom-control-label" for="chk-aks-6">Lihat History Penerimaan</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1 d-none">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-7">
                                                        <label class="custom-control-label" for="chk-aks-7">Lihat History Tanda Terima</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-8">
                                                        <label class="custom-control-label" for="chk-aks-8">Lihat History Pinjaman</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-103">
                                                        <label class="custom-control-label" for="chk-aks-103">Set Harga</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-104">
                                                        <label class="custom-control-label" for="chk-aks-104">Lihat History Potongan Pinjaman</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-105">
                                                        <label class="custom-control-label" for="chk-aks-105">Set Simpanan</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-106">
                                                        <label class="custom-control-label" for="chk-aks-106">Lihat History Simpanan</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-1" onmouseover="cardHvr(1)" onmouseout="cardNHvr(1)">
                                                <div class="card-header csr-pntr" id="div-dhead-1" onclick="cardAct(1)">Customer <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-1" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-1">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-1" onclick="chkAll(1)">
                                                        <label class="custom-control-label" for="chk-all-1">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-42">
                                                        <label class="custom-control-label" for="chk-aks-42">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-43">
                                                        <label class="custom-control-label" for="chk-aks-43">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-44">
                                                        <label class="custom-control-label" for="chk-aks-44">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-45">
                                                        <label class="custom-control-label" for="chk-aks-45">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-46">
                                                        <label class="custom-control-label" for="chk-aks-46">Lihat History PO</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-39" onmouseover="cardHvr(39)" onmouseout="cardNHvr(39)">
                                                <div class="card-header csr-pntr" id="div-dhead-39" onclick="cardAct(39)">P/O <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-39" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-39">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-39" onclick="chkAll(39)">
                                                        <label class="custom-control-label" for="chk-all-39">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-123">
                                                        <label class="custom-control-label" for="chk-aks-123">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-124">
                                                        <label class="custom-control-label" for="chk-aks-124">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-125">
                                                        <label class="custom-control-label" for="chk-aks-125">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-126">
                                                        <label class="custom-control-label" for="chk-aks-126">Hapus</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-2" onmouseover="cardHvr(2)" onmouseout="cardNHvr(2)">
                                                <div class="card-header csr-pntr" id="div-dhead-2" onclick="cardAct(2)">Produk <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-2" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-2">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-2" onclick="chkAll(2)">
                                                        <label class="custom-control-label" for="chk-all-2">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-9">
                                                        <label class="custom-control-label" for="chk-aks-9">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-10">
                                                        <label class="custom-control-label" for="chk-aks-10">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-11">
                                                        <label class="custom-control-label" for="chk-aks-11">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-12">
                                                        <label class="custom-control-label" for="chk-aks-12">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-13">
                                                        <label class="custom-control-label" for="chk-aks-13">Lihat History Penerimaan</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-14">
                                                        <label class="custom-control-label" for="chk-aks-14">Lihat History Vacuum</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-15">
                                                        <label class="custom-control-label" for="chk-aks-15">Lihat History Sawing</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-16">
                                                        <label class="custom-control-label" for="chk-aks-16">Lihat History Packaging</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-3" onmouseover="cardHvr(3)" onmouseout="cardNHvr(3)">
                                                <div class="card-header csr-pntr" id="div-dhead-3" onclick="cardAct(3)">Grade <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-3" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-3">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-3" onclick="chkAll(3)">
                                                        <label class="custom-control-label" for="chk-all-3">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-17">
                                                        <label class="custom-control-label" for="chk-aks-17">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-18">
                                                        <label class="custom-control-label" for="chk-aks-18">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-19">
                                                        <label class="custom-control-label" for="chk-aks-19">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-20">
                                                        <label class="custom-control-label" for="chk-aks-20">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-21">
                                                        <label class="custom-control-label" for="chk-aks-21">Lihat Daftar Produk</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-4" onmouseover="cardHvr(4)" onmouseout="cardNHvr(4)">
                                                <div class="card-header csr-pntr" id="div-dhead-4" onclick="cardAct(4)">Satuan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-4" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-4">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-4" onclick="chkAll(4)">
                                                        <label class="custom-control-label" for="chk-all-4">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-22">
                                                        <label class="custom-control-label" for="chk-aks-22">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-23">
                                                        <label class="custom-control-label" for="chk-aks-23">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-24">
                                                        <label class="custom-control-label" for="chk-aks-24">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-25">
                                                        <label class="custom-control-label" for="chk-aks-25">Hapus</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-5" onmouseover="cardHvr(5)" onmouseout="cardNHvr(5)">
                                                <div class="card-header csr-pntr" id="div-dhead-5" onclick="cardAct(5)">Oz <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-5" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-5">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-5" onclick="chkAll(5)">
                                                        <label class="custom-control-label" for="chk-all-5">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-26">
                                                        <label class="custom-control-label" for="chk-aks-26">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-27">
                                                        <label class="custom-control-label" for="chk-aks-27">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-28">
                                                        <label class="custom-control-label" for="chk-aks-28">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-29">
                                                        <label class="custom-control-label" for="chk-aks-29">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-30">
                                                        <label class="custom-control-label" for="chk-aks-30">Lihat Daftar Produk</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1 d-none">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-31">
                                                        <label class="custom-control-label" for="chk-aks-31">Lihat Daftar Sub Kategori</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-6" onmouseover="cardHvr(6)" onmouseout="cardNHvr(6)">
                                                <div class="card-header csr-pntr" id="div-dhead-6" onclick="cardAct(6)">Cut Style <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-6" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-6">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-6" onclick="chkAll(6)">
                                                        <label class="custom-control-label" for="chk-all-6">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-32">
                                                        <label class="custom-control-label" for="chk-aks-32">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-33">
                                                        <label class="custom-control-label" for="chk-aks-33">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-34">
                                                        <label class="custom-control-label" for="chk-aks-34">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-35">
                                                        <label class="custom-control-label" for="chk-aks-35">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-36">
                                                        <label class="custom-control-label" for="chk-aks-36">Lihat Daftar Produk</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-60" onmouseover="cardHvr(60)" onmouseout="cardNHvr(60)">
                                                <div class="card-header csr-pntr" id="div-dhead-60" onclick="cardAct(60)">Kategori <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-60" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-60">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-60" onclick="chkAll(60)">
                                                        <label class="custom-control-label" for="chk-all-60">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-180">
                                                        <label class="custom-control-label" for="chk-aks-180">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-181">
                                                        <label class="custom-control-label" for="chk-aks-181">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-182">
                                                        <label class="custom-control-label" for="chk-aks-182">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-183">
                                                        <label class="custom-control-label" for="chk-aks-183">Hapus</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-68" onmouseover="cardHvr(68)" onmouseout="cardNHvr(68)">
                                                <div class="card-header csr-pntr" id="div-dhead-68" onclick="cardAct(68)">Golongan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-68" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-68">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-68" onclick="chkAll(68)">
                                                        <label class="custom-control-label" for="chk-all-68">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-202">
                                                        <label class="custom-control-label" for="chk-aks-202">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-203">
                                                        <label class="custom-control-label" for="chk-aks-203">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-204">
                                                        <label class="custom-control-label" for="chk-aks-204">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-205">
                                                        <label class="custom-control-label" for="chk-aks-205">Hapus</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-7" onmouseover="cardHvr(7)" onmouseout="cardNHvr(7)">
                                                <div class="card-header csr-pntr" id="div-dhead-7" onclick="cardAct(7)">User <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-7" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-7">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-7" onclick="chkAll(7)">
                                                        <label class="custom-control-label" for="chk-all-7">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-37">
                                                        <label class="custom-control-label" for="chk-aks-37">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-38">
                                                        <label class="custom-control-label" for="chk-aks-38">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-39">
                                                        <label class="custom-control-label" for="chk-aks-39">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-40">
                                                        <label class="custom-control-label" for="chk-aks-40">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-41">
                                                        <label class="custom-control-label" for="chk-aks-41">Setting Akses</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-52" onmouseover="cardHvr(52)" onmouseout="cardNHvr(52)">
                                                <div class="card-header csr-pntr" id="div-dhead-52" onclick="cardAct(52)">Gudang <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-52" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-52">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-52" onclick="chkAll(52)">
                                                        <label class="custom-control-label" for="chk-all-52">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-159">
                                                        <label class="custom-control-label" for="chk-aks-159">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-160">
                                                        <label class="custom-control-label" for="chk-aks-160">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-161">
                                                        <label class="custom-control-label" for="chk-aks-161">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-162">
                                                        <label class="custom-control-label" for="chk-aks-162">Hapus</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5 class="m-0 ml-2 mt-3 text-info">Transaksi</h5><hr class="mt-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2 d-none">
                                            <div class="card p-0" id="card-aks-61" onmouseover="cardHvr(61)" onmouseout="cardNHvr(61)">
                                                <div class="card-header csr-pntr" id="div-dhead-61" onclick="cardAct(61)">Beli <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-61" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-61">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-61" onclick="chkAll(61)">
                                                        <label class="custom-control-label" for="chk-all-61">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-184">
                                                        <label class="custom-control-label" for="chk-aks-184">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-185">
                                                        <label class="custom-control-label" for="chk-aks-185">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-186">
                                                        <label class="custom-control-label" for="chk-aks-186">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-187">
                                                        <label class="custom-control-label" for="chk-aks-187">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1 d-none">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-188">
                                                        <label class="custom-control-label" for="chk-aks-188">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-62" onmouseover="cardHvr(62)" onmouseout="cardNHvr(62)">
                                                <div class="card-header csr-pntr" id="div-dhead-62" onclick="cardAct(62)">Retur Kirim <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-62" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-62">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-62" onclick="chkAll(62)">
                                                        <label class="custom-control-label" for="chk-all-62">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-189">
                                                        <label class="custom-control-label" for="chk-aks-189">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-190">
                                                        <label class="custom-control-label" for="chk-aks-190">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-191">
                                                        <label class="custom-control-label" for="chk-aks-191">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-192">
                                                        <label class="custom-control-label" for="chk-aks-192">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-193">
                                                        <label class="custom-control-label" for="chk-aks-193">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2 d-none">
                                            <div class="card p-0" id="card-aks-8" onmouseover="cardHvr(8)" onmouseout="cardNHvr(8)">
                                                <div class="card-header csr-pntr" id="div-dhead-8" onclick="cardAct(8)">Tanda Terima <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-8" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-8">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-8" onclick="chkAll(8)">
                                                        <label class="custom-control-label" for="chk-all-8">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-47">
                                                        <label class="custom-control-label" for="chk-aks-47">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-48">
                                                        <label class="custom-control-label" for="chk-aks-48">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-49">
                                                        <label class="custom-control-label" for="chk-aks-49">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-50">
                                                        <label class="custom-control-label" for="chk-aks-50">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-51">
                                                        <label class="custom-control-label" for="chk-aks-51">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-9" onmouseover="cardHvr(9)" onmouseout="cardNHvr(9)">
                                                <div class="card-header csr-pntr" id="div-dhead-9" onclick="cardAct(9)">Peminjaman <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-9" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-9">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-9" onclick="chkAll(9)">
                                                        <label class="custom-control-label" for="chk-all-9">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-52">
                                                        <label class="custom-control-label" for="chk-aks-52">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-53">
                                                        <label class="custom-control-label" for="chk-aks-53">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-54">
                                                        <label class="custom-control-label" for="chk-aks-54">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-55">
                                                        <label class="custom-control-label" for="chk-aks-55">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-56">
                                                        <label class="custom-control-label" for="chk-aks-56">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-33" onmouseover="cardHvr(33)" onmouseout="cardNHvr(33)">
                                                <div class="card-header csr-pntr" id="div-dhead-33" onclick="cardAct(33)">Penarikan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-33" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-33">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-33" onclick="chkAll(33)">
                                                        <label class="custom-control-label" for="chk-all-33">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-107">
                                                        <label class="custom-control-label" for="chk-aks-107">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-108">
                                                        <label class="custom-control-label" for="chk-aks-108">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-109">
                                                        <label class="custom-control-label" for="chk-aks-109">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-110">
                                                        <label class="custom-control-label" for="chk-aks-110">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-111">
                                                        <label class="custom-control-label" for="chk-aks-111">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-47" onmouseover="cardHvr(47)" onmouseout="cardNHvr(47)">
                                                <div class="card-header csr-pntr" id="div-dhead-47" onclick="cardAct(47)">BB <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-47" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-47">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-47" onclick="chkAll(47)">
                                                        <label class="custom-control-label" for="chk-all-47">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-145">
                                                        <label class="custom-control-label" for="chk-aks-145">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-146">
                                                        <label class="custom-control-label" for="chk-aks-146">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-147">
                                                        <label class="custom-control-label" for="chk-aks-147">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-148">
                                                        <label class="custom-control-label" for="chk-aks-148">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-149">
                                                        <label class="custom-control-label" for="chk-aks-149">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-49" onmouseover="cardHvr(49)" onmouseout="cardNHvr(49)">
                                                <div class="card-header csr-pntr" id="div-dhead-49" onclick="cardAct(49)">Penyesuaian Stok <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-49" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-49">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-49" onclick="chkAll(49)">
                                                        <label class="custom-control-label" for="chk-all-49">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-151">
                                                        <label class="custom-control-label" for="chk-aks-151">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-152">
                                                        <label class="custom-control-label" for="chk-aks-152">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-153">
                                                        <label class="custom-control-label" for="chk-aks-153">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-154">
                                                        <label class="custom-control-label" for="chk-aks-154">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-155">
                                                        <label class="custom-control-label" for="chk-aks-155">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-53" onmouseover="cardHvr(53)" onmouseout="cardNHvr(53)">
                                                <div class="card-header csr-pntr" id="div-dhead-53" onclick="cardAct(53)">Pindah Stok <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-53" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-53">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-53" onclick="chkAll(53)">
                                                        <label class="custom-control-label" for="chk-all-53">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-163">
                                                        <label class="custom-control-label" for="chk-aks-163">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-164">
                                                        <label class="custom-control-label" for="chk-aks-164">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-165">
                                                        <label class="custom-control-label" for="chk-aks-165">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-166">
                                                        <label class="custom-control-label" for="chk-aks-166">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-167">
                                                        <label class="custom-control-label" for="chk-aks-167">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5 class="m-0 ml-2 mt-3 text-info">Proses</h5><hr class="mt-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-11" onmouseover="cardHvr(11)" onmouseout="cardNHvr(11)">
                                                <div class="card-header csr-pntr" id="div-dhead-11" onclick="cardAct(11)">Penerimaan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-11" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-11">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-11" onclick="chkAll(11)">
                                                        <label class="custom-control-label" for="chk-all-11">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-62">
                                                        <label class="custom-control-label" for="chk-aks-62">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-63">
                                                        <label class="custom-control-label" for="chk-aks-63">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-135">
                                                        <label class="custom-control-label" for="chk-aks-135">Ralat Parsial</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-64">
                                                        <label class="custom-control-label" for="chk-aks-64">Ralat Full</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-65">
                                                        <label class="custom-control-label" for="chk-aks-65">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-66">
                                                        <label class="custom-control-label" for="chk-aks-66">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-12" onmouseover="cardHvr(12)" onmouseout="cardNHvr(12)">
                                                <div class="card-header csr-pntr" id="div-dhead-12" onclick="cardAct(12)">Cutting <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-12" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-12">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-12" onclick="chkAll(12)">
                                                        <label class="custom-control-label" for="chk-all-12">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-67">
                                                        <label class="custom-control-label" for="chk-aks-67">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-68">
                                                        <label class="custom-control-label" for="chk-aks-68">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-69">
                                                        <label class="custom-control-label" for="chk-aks-69">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-70">
                                                        <label class="custom-control-label" for="chk-aks-70">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-119">
                                                        <label class="custom-control-label" for="chk-aks-119">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-13" onmouseover="cardHvr(13)" onmouseout="cardNHvr(13)">
                                                <div class="card-header csr-pntr" id="div-dhead-13" onclick="cardAct(13)">Vacuum <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-13" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-13">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-13" onclick="chkAll(13)">
                                                        <label class="custom-control-label" for="chk-all-13">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-71">
                                                        <label class="custom-control-label" for="chk-aks-71">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-72">
                                                        <label class="custom-control-label" for="chk-aks-72">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-73">
                                                        <label class="custom-control-label" for="chk-aks-73">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-74">
                                                        <label class="custom-control-label" for="chk-aks-74">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-120">
                                                        <label class="custom-control-label" for="chk-aks-120">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-14" onmouseover="cardHvr(14)" onmouseout="cardNHvr(14)">
                                                <div class="card-header csr-pntr" id="div-dhead-14" onclick="cardAct(14)">Sawing <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-14" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-14">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-14" onclick="chkAll(14)">
                                                        <label class="custom-control-label" for="chk-all-14">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-75">
                                                        <label class="custom-control-label" for="chk-aks-75">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-76">
                                                        <label class="custom-control-label" for="chk-aks-76">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-77">
                                                        <label class="custom-control-label" for="chk-aks-77">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-78">
                                                        <label class="custom-control-label" for="chk-aks-78">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-121">
                                                        <label class="custom-control-label" for="chk-aks-121">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-57" onmouseover="cardHvr(57)" onmouseout="cardNHvr(57)">
                                                <div class="card-header csr-pntr" id="div-dhead-57" onclick="cardAct(57)">Re-Packaging <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-57" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-57">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-57" onclick="chkAll(57)">
                                                        <label class="custom-control-label" for="chk-all-57">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-172">
                                                        <label class="custom-control-label" for="chk-aks-172">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-173">
                                                        <label class="custom-control-label" for="chk-aks-173">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-174">
                                                        <label class="custom-control-label" for="chk-aks-174">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-175">
                                                        <label class="custom-control-label" for="chk-aks-175">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-176">
                                                        <label class="custom-control-label" for="chk-aks-176">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-10" onmouseover="cardHvr(10)" onmouseout="cardNHvr(10)">
                                                <div class="card-header csr-pntr" id="div-dhead-10" onclick="cardAct(10)">Packaging <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-10" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-10">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-10" onclick="chkAll(10)">
                                                        <label class="custom-control-label" for="chk-all-10">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-57">
                                                        <label class="custom-control-label" for="chk-aks-57">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-58">
                                                        <label class="custom-control-label" for="chk-aks-58">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-59">
                                                        <label class="custom-control-label" for="chk-aks-59">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-60">
                                                        <label class="custom-control-label" for="chk-aks-60">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-61">
                                                        <label class="custom-control-label" for="chk-aks-61">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-40" onmouseover="cardHvr(40)" onmouseout="cardNHvr(40)">
                                                <div class="card-header csr-pntr" id="div-dhead-40" onclick="cardAct(40)">Masuk Produk <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-40" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-40">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-40" onclick="chkAll(40)">
                                                        <label class="custom-control-label" for="chk-all-40">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-128">
                                                        <label class="custom-control-label" for="chk-aks-128">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-129">
                                                        <label class="custom-control-label" for="chk-aks-129">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-130">
                                                        <label class="custom-control-label" for="chk-aks-130">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-131">
                                                        <label class="custom-control-label" for="chk-aks-131">Hapus</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-201">
                                                        <label class="custom-control-label" for="chk-aks-201">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-44" onmouseover="cardHvr(44)" onmouseout="cardNHvr(44)">
                                                <div class="card-header csr-pntr" id="div-dhead-44" onclick="cardAct(44)">Pembekuan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-44" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-44">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-44" onclick="chkAll(44)">
                                                        <label class="custom-control-label" for="chk-all-44">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-138">
                                                        <label class="custom-control-label" for="chk-aks-138">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-139">
                                                        <label class="custom-control-label" for="chk-aks-139">Tambah</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-140">
                                                        <label class="custom-control-label" for="chk-aks-140">Ralat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-141">
                                                        <label class="custom-control-label" for="chk-aks-141">Hapus</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5 class="m-0 ml-2 mt-3 text-info">Laporan</h5><hr class="mt-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-15" onmouseover="cardHvr(15)" onmouseout="cardNHvr(15)">
                                                <div class="card-header csr-pntr" id="div-dhead-15" onclick="cardAct(15)">Produk <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-15" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-15">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-15" onclick="chkAll(15)">
                                                        <label class="custom-control-label" for="chk-all-15">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-79">
                                                        <label class="custom-control-label" for="chk-aks-79">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-80">
                                                        <label class="custom-control-label" for="chk-aks-80">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-16" onmouseover="cardHvr(16)" onmouseout="cardNHvr(16)">
                                                <div class="card-header csr-pntr" id="div-dhead-16" onclick="cardAct(16)">Supplier <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-16" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-16">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-16" onclick="chkAll(16)">
                                                        <label class="custom-control-label" for="chk-all-16">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-81">
                                                        <label class="custom-control-label" for="chk-aks-81">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-82">
                                                        <label class="custom-control-label" for="chk-aks-82">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-17" onmouseover="cardHvr(17)" onmouseout="cardNHvr(17)">
                                                <div class="card-header csr-pntr" id="div-dhead-17" onclick="cardAct(17)">Customer <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-17" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-17">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-17" onclick="chkAll(17)">
                                                        <label class="custom-control-label" for="chk-all-17">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-83">
                                                        <label class="custom-control-label" for="chk-aks-83">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-84">
                                                        <label class="custom-control-label" for="chk-aks-84">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-43" onmouseover="cardHvr(43)" onmouseout="cardNHvr(43)">
                                                <div class="card-header csr-pntr" id="div-dhead-43" onclick="cardAct(43)">Customer <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-43" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-43">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-43" onclick="chkAll(43)">
                                                        <label class="custom-control-label" for="chk-all-43">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-136">
                                                        <label class="custom-control-label" for="chk-aks-136">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-137">
                                                        <label class="custom-control-label" for="chk-aks-137">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-18" onmouseover="cardHvr(18)" onmouseout="cardNHvr(18)">
                                                <div class="card-header csr-pntr" id="div-dhead-18" onclick="cardAct(18)">Penerimaan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-18" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-18">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-18" onclick="chkAll(18)">
                                                        <label class="custom-control-label" for="chk-all-18">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-85">
                                                        <label class="custom-control-label" for="chk-aks-85">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-86">
                                                        <label class="custom-control-label" for="chk-aks-86">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-19" onmouseover="cardHvr(19)" onmouseout="cardNHvr(19)">
                                                <div class="card-header csr-pntr" id="div-dhead-19" onclick="cardAct(19)">Cutting <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-19" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-19">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-19" onclick="chkAll(19)">
                                                        <label class="custom-control-label" for="chk-all-19">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-87">
                                                        <label class="custom-control-label" for="chk-aks-87">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-88">
                                                        <label class="custom-control-label" for="chk-aks-88">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-20" onmouseover="cardHvr(20)" onmouseout="cardNHvr(20)">
                                                <div class="card-header csr-pntr" id="div-dhead-20" onclick="cardAct(20)">Vacuum <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-20" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-20">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-20" onclick="chkAll(20)">
                                                        <label class="custom-control-label" for="chk-all-20">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-89">
                                                        <label class="custom-control-label" for="chk-aks-89">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-90">
                                                        <label class="custom-control-label" for="chk-aks-90">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-21" onmouseover="cardHvr(21)" onmouseout="cardNHvr(21)">
                                                <div class="card-header csr-pntr" id="div-dhead-21" onclick="cardAct(21)">Sawing <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-21" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-21">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-21" onclick="chkAll(21)">
                                                        <label class="custom-control-label" for="chk-all-21">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-91">
                                                        <label class="custom-control-label" for="chk-aks-91">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-92">
                                                        <label class="custom-control-label" for="chk-aks-92">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-58" onmouseover="cardHvr(58)" onmouseout="cardNHvr(58)">
                                                <div class="card-header csr-pntr" id="div-dhead-58" onclick="cardAct(58)">Re-Packaging <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-58" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-58">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-58" onclick="chkAll(58)">
                                                        <label class="custom-control-label" for="chk-all-58">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-177">
                                                        <label class="custom-control-label" for="chk-aks-177">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-178">
                                                        <label class="custom-control-label" for="chk-aks-178">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-22" onmouseover="cardHvr(22)" onmouseout="cardNHvr(22)">
                                                <div class="card-header csr-pntr" id="div-dhead-22" onclick="cardAct(22)">Packaging <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-22" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-22">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-22" onclick="chkAll(22)">
                                                        <label class="custom-control-label" for="chk-all-22">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-93">
                                                        <label class="custom-control-label" for="chk-aks-93">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-94">
                                                        <label class="custom-control-label" for="chk-aks-94">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-41" onmouseover="cardHvr(41)" onmouseout="cardNHvr(41)">
                                                <div class="card-header csr-pntr" id="div-dhead-41" onclick="cardAct(41)">Masuk Produk <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-41" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-41">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-41" onclick="chkAll(41)">
                                                        <label class="custom-control-label" for="chk-all-41">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-132">
                                                        <label class="custom-control-label" for="chk-aks-132">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-133">
                                                        <label class="custom-control-label" for="chk-aks-133">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-45" onmouseover="cardHvr(45)" onmouseout="cardNHvr(45)">
                                                <div class="card-header csr-pntr" id="div-dhead-45" onclick="cardAct(45)">Pembekuan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-45" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-45">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-45" onclick="chkAll(45)">
                                                        <label class="custom-control-label" for="chk-all-45">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-142">
                                                        <label class="custom-control-label" for="chk-aks-142">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-143">
                                                        <label class="custom-control-label" for="chk-aks-143">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2 d-none">
                                            <div class="card p-0" id="card-aks-65" onmouseover="cardHvr(65)" onmouseout="cardNHvr(65)">
                                                <div class="card-header csr-pntr" id="div-dhead-65" onclick="cardAct(65)">Beli <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-65" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-65">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-65" onclick="chkAll(65)">
                                                        <label class="custom-control-label" for="chk-all-65">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-196">
                                                        <label class="custom-control-label" for="chk-aks-196">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-197">
                                                        <label class="custom-control-label" for="chk-aks-197">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-66" onmouseover="cardHvr(66)" onmouseout="cardNHvr(66)">
                                                <div class="card-header csr-pntr" id="div-dhead-66" onclick="cardAct(66)">Retur Kirim <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-66" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-66">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-66" onclick="chkAll(66)">
                                                        <label class="custom-control-label" for="chk-all-66">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-198">
                                                        <label class="custom-control-label" for="chk-aks-198">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-199">
                                                        <label class="custom-control-label" for="chk-aks-199">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-34" onmouseover="cardHvr(34)" onmouseout="cardNHvr(34)">
                                                <div class="card-header csr-pntr" id="div-dhead-34" onclick="cardAct(34)">Simpanan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-34" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-34">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-34" onclick="chkAll(34)">
                                                        <label class="custom-control-label" for="chk-all-34">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-112">
                                                        <label class="custom-control-label" for="chk-aks-112">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-113">
                                                        <label class="custom-control-label" for="chk-aks-113">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-36" onmouseover="cardHvr(36)" onmouseout="cardNHvr(36)">
                                                <div class="card-header csr-pntr" id="div-dhead-36" onclick="cardAct(36)">Pinjaman <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-36" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-36">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-36" onclick="chkAll(36)">
                                                        <label class="custom-control-label" for="chk-all-36">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-115">
                                                        <label class="custom-control-label" for="chk-aks-115">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-116">
                                                        <label class="custom-control-label" for="chk-aks-116">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-37" onmouseover="cardHvr(37)" onmouseout="cardNHvr(37)">
                                                <div class="card-header csr-pntr" id="div-dhead-37" onclick="cardAct(37)">BB <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-37" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-37">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-37" onclick="chkAll(37)">
                                                        <label class="custom-control-label" for="chk-all-37">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-117">
                                                        <label class="custom-control-label" for="chk-aks-117">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-118">
                                                        <label class="custom-control-label" for="chk-aks-118">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-50" onmouseover="cardHvr(50)" onmouseout="cardNHvr(50)">
                                                <div class="card-header csr-pntr" id="div-dhead-50" onclick="cardAct(50)">Penyesuaian Stok <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-50" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-50">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-50" onclick="chkAll(50)">
                                                        <label class="custom-control-label" for="chk-all-50">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-156">
                                                        <label class="custom-control-label" for="chk-aks-156">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-157">
                                                        <label class="custom-control-label" for="chk-aks-157">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-54" onmouseover="cardHvr(54)" onmouseout="cardNHvr(54)">
                                                <div class="card-header csr-pntr" id="div-dhead-54" onclick="cardAct(54)">Pindah Stok <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-54" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-54">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-54" onclick="chkAll(54)">
                                                        <label class="custom-control-label" for="chk-all-54">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-168">
                                                        <label class="custom-control-label" for="chk-aks-168">Lihat</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-169">
                                                        <label class="custom-control-label" for="chk-aks-169">Cetak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5 class="m-0 ml-2 mt-3 text-info">History</h5><hr class="mt-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2 d-none">
                                            <div class="card p-0" id="card-aks-63" onmouseover="cardHvr(63)" onmouseout="cardNHvr(63)">
                                                <div class="card-header csr-pntr" id="div-dhead-63" onclick="cardAct(63)">Beli <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-63" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-63">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-63" onclick="chkAll(63)">
                                                        <label class="custom-control-label" for="chk-all-63">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-194">
                                                        <label class="custom-control-label" for="chk-aks-194">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-64" onmouseover="cardHvr(64)" onmouseout="cardNHvr(64)">
                                                <div class="card-header csr-pntr" id="div-dhead-64" onclick="cardAct(64)">Retur Kirim <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-64" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-64">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-64" onclick="chkAll(64)">
                                                        <label class="custom-control-label" for="chk-all-64">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-195">
                                                        <label class="custom-control-label" for="chk-aks-195">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-23" onmouseover="cardHvr(23)" onmouseout="cardNHvr(23)">
                                                <div class="card-header csr-pntr" id="div-dhead-23" onclick="cardAct(23)">Peminjaman <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-23" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-23">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-23" onclick="chkAll(23)">
                                                        <label class="custom-control-label" for="chk-all-23">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-96">
                                                        <label class="custom-control-label" for="chk-aks-96">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2 d-none">
                                            <div class="card p-0" id="card-aks-24" onmouseover="cardHvr(24)" onmouseout="cardNHvr(24)">
                                                <div class="card-header csr-pntr" id="div-dhead-24" onclick="cardAct(24)">Tanda Terima <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-24" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-24">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-24" onclick="chkAll(24)">
                                                        <label class="custom-control-label" for="chk-all-24">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-97">
                                                        <label class="custom-control-label" for="chk-aks-97">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-26" onmouseover="cardHvr(26)" onmouseout="cardNHvr(26)">
                                                <div class="card-header csr-pntr" id="div-dhead-26" onclick="cardAct(26)">Penerimaan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-26" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-26">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-26" onclick="chkAll(26)">
                                                        <label class="custom-control-label" for="chk-all-26">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-98">
                                                        <label class="custom-control-label" for="chk-aks-98">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-27" onmouseover="cardHvr(27)" onmouseout="cardNHvr(27)">
                                                <div class="card-header csr-pntr" id="div-dhead-27" onclick="cardAct(27)">Cutting <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-27" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-27">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-27" onclick="chkAll(27)">
                                                        <label class="custom-control-label" for="chk-all-27">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-99">
                                                        <label class="custom-control-label" for="chk-aks-99">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-28" onmouseover="cardHvr(28)" onmouseout="cardNHvr(28)">
                                                <div class="card-header csr-pntr" id="div-dhead-28" onclick="cardAct(28)">Vacuum <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-28" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-28">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-28" onclick="chkAll(28)">
                                                        <label class="custom-control-label" for="chk-all-28">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-100">
                                                        <label class="custom-control-label" for="chk-aks-100">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-29" onmouseover="cardHvr(29)" onmouseout="cardNHvr(29)">
                                                <div class="card-header csr-pntr" id="div-dhead-29" onclick="cardAct(29)">Sawing <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-29" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-29">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-29" onclick="chkAll(29)">
                                                        <label class="custom-control-label" for="chk-all-29">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-101">
                                                        <label class="custom-control-label" for="chk-aks-101">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-59" onmouseover="cardHvr(59)" onmouseout="cardNHvr(59)">
                                                <div class="card-header csr-pntr" id="div-dhead-59" onclick="cardAct(59)">Re-Packaging <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-59" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-59">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-59" onclick="chkAll(59)">
                                                        <label class="custom-control-label" for="chk-all-59">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-179">
                                                        <label class="custom-control-label" for="chk-aks-179">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-30" onmouseover="cardHvr(30)" onmouseout="cardNHvr(30)">
                                                <div class="card-header csr-pntr" id="div-dhead-30" onclick="cardAct(30)">Packaging <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-30" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-30">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-30" onclick="chkAll(30)">
                                                        <label class="custom-control-label" for="chk-all-30">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-102">
                                                        <label class="custom-control-label" for="chk-aks-102">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-42" onmouseover="cardHvr(42)" onmouseout="cardNHvr(42)">
                                                <div class="card-header csr-pntr" id="div-dhead-42" onclick="cardAct(42)">Masuk Produk <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-42" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-42">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-42" onclick="chkAll(42)">
                                                        <label class="custom-control-label" for="chk-all-42">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-134">
                                                        <label class="custom-control-label" for="chk-aks-134">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-46" onmouseover="cardHvr(46)" onmouseout="cardNHvr(46)">
                                                <div class="card-header csr-pntr" id="div-dhead-46" onclick="cardAct(46)">Pembekuan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-46" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-46">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-46" onclick="chkAll(46)">
                                                        <label class="custom-control-label" for="chk-all-46">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-144">
                                                        <label class="custom-control-label" for="chk-aks-144">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-35" onmouseover="cardHvr(35)" onmouseout="cardNHvr(35)">
                                                <div class="card-header csr-pntr" id="div-dhead-35" onclick="cardAct(35)">Penarikan <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-35" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-35">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-35" onclick="chkAll(35)">
                                                        <label class="custom-control-label" for="chk-all-35">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-114">
                                                        <label class="custom-control-label" for="chk-aks-114">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-48" onmouseover="cardHvr(48)" onmouseout="cardNHvr(48)">
                                                <div class="card-header csr-pntr" id="div-dhead-48" onclick="cardAct(48)">BB <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-48" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-48">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-48" onclick="chkAll(48)">
                                                        <label class="custom-control-label" for="chk-all-48">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-150">
                                                        <label class="custom-control-label" for="chk-aks-150">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-51" onmouseover="cardHvr(51)" onmouseout="cardNHvr(51)">
                                                <div class="card-header csr-pntr" id="div-dhead-51" onclick="cardAct(51)">Penyesuaian Stok <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-51" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-51">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-51" onclick="chkAll(51)">
                                                        <label class="custom-control-label" for="chk-all-51">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-158">
                                                        <label class="custom-control-label" for="chk-aks-158">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-55" onmouseover="cardHvr(55)" onmouseout="cardNHvr(55)">
                                                <div class="card-header csr-pntr" id="div-dhead-55" onclick="cardAct(55)">Pindah Stok <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-55" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-55">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-55" onclick="chkAll(55)">
                                                        <label class="custom-control-label" for="chk-all-55">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-170">
                                                        <label class="custom-control-label" for="chk-aks-170">Lihat</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5 class="m-0 ml-2 mt-3 text-info">Utility</h5><hr class="mt-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-32" onmouseover="cardHvr(32)" onmouseout="cardNHvr(32)">
                                                <div class="card-header csr-pntr" id="div-dhead-32" onclick="cardAct(32)">Utility <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-32" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-32">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-all-32" onclick="chkAll(32)">
                                                        <label class="custom-control-label" for="chk-all-32">Select All</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-95">
                                                        <label class="custom-control-label" for="chk-aks-95">Setting</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-122">
                                                        <label class="custom-control-label" for="chk-aks-122">Repair</label>
                                                    </div>
                                                    
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-127">
                                                        <label class="custom-control-label" for="chk-aks-127">Tutup Buku</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5 class="m-0 ml-2 mt-3 text-info">Lainnya</h5><hr class="mt-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                            <div class="card p-0" id="card-aks-67" onmouseover="cardHvr(67)" onmouseout="cardNHvr(67)">
                                                <div class="card-header csr-pntr" id="div-dhead-67" onclick="cardAct(67)">Lainnya <img src="./bin/img/icon/arr-btm.png" alt="Arrow" id="img-aks-67" width="18" class="ml-2"></div>
                                                
                                                <div class="card-body py-1 d-none" id="div-dcard-67">
                                                    <div class="custom-control custom-checkbox my-1">
                                                        <input type="checkbox" class="custom-control-input" id="chk-aks-200">
                                                        <label class="custom-control-label" for="chk-aks-200">Lihat Harga Setelah Potong</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="row col-12 p-0 m-0">
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-left"><h6 class="m-0 text-danger">NB : Akses tidak berlaku untuk level owner</h6></div>
                                    
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                        <button type="button" class="btn btn-primary mb-2" id="btn-saks">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                
                    if(CekAksUser(substr($duser[7],38,1)))
                    {
                ?>
                <div class="modal fade" id="mdl-nuser" tabindex="-1" role="dialog" aria-labelledby="mdl-nuser" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body pt-1">
                                <div class="alert alert-danger d-none" id="div-err-user-1">Harap isi semua data dengan tanda * !!!</div>
                                
                                <div class="alert alert-danger d-none" id="div-err-user-2">Terdapat user dengan username ini !!!</div>

                                <div class="alert alert-success d-none" id="div-scs-user-1">User berhasil ditambahkan !!!</div>
                                
                                <div class="mt-2">
                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Username</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="txt-user" name="txt-user" placeholder="Username" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Password</span><span class="text-danger">*</span></div>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="password" class="form-control inp-set" id="txt-pass" name="txt-pass" placeholder="Password" autocomplete="off">

                                                <div class="input-group-append">
                                                    <button class="btn btn-light border border-dark vpass" data-value="#txt-pass"><img src="./bin/img/icon/view-icon.png" alt="View" width="25"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Nama</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="txt-nma" name="txt-nma" placeholder="Nama" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Posisi</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="txt-pos" name="txt-pos" placeholder="Posisi" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Divisi</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="txt-dvs" name="txt-dvs" placeholder="Divisi" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Level</span></div>
                                        <div class="col-9">
                                            <select name="slct-lvl" id="slct-lvl" class="custom-select">
                                                <option value="User">User</option>
                                                <?php
                                                    if(strcasecmp($duser[6],"User") != 0)
                                                    {
                                                ?>
                                                <option value="Owner">Owner</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-snuser">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                
                    if(CekAksUser(substr($duser[7],39,1)))
                    {
                ?>
                <div class="modal fade" id="mdl-euser" tabindex="-1" role="dialog" aria-labelledby="mdl-euser" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ralat User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body pt-1">
                                <div class="alert alert-danger d-none" id="div-edt-err-user-1">Harap isi semua data dengan tanda * !!!</div>
                                
                                <div class="alert alert-danger d-none" id="div-edt-err-user-2">Terdapat user dengan username ini !!!</div>
                                
                                <div class="alert alert-danger d-none" id="div-edt-err-user-3">Data user tidak ditemukan !!!</div>

                                <div class="alert alert-success d-none" id="div-edt-scs-user-1">User berhasil diubah !!!</div>
                                
                                <div class="mt-2">
                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Username</span><span class="text-danger">*</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-user" name="edt-txt-user" placeholder="User Username" autocomplete="off" maxlength="50"><input type="text" class="form-control d-none" id="edt-txt-buser" name="edt-txt-buser" placeholder="Username" autocomplete="off" maxlength="50"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Password</span></div>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="password" class="form-control inp-set" id="edt-txt-pass" name="edt-txt-pass" placeholder="Password" autocomplete="off">

                                                <div class="input-group-append">
                                                    <button class="btn btn-light border border-dark vpass" data-value="#edt-txt-pass"><img src="./bin/img/icon/view-icon.png" alt="View" width="25"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Nama</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-nma" name="edt-txt-nma" placeholder="Name" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Posisi</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-pos" name="edt-txt-pos" placeholder="Posisi" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Divisi</span></div>
                                        <div class="col-9"><input type="text" class="form-control inp-set" id="edt-txt-dvs" name="edt-txt-dvs" placeholder="Divisi" autocomplete="off" maxlength="100"></div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Level</span></div>
                                        <div class="col-9">
                                            <select name="edt-slct-lvl" id="edt-slct-lvl" class="custom-select">
                                                <option value="User">User</option>
                                                <?php
                                                    if(strcasecmp($duser[6],"User") != 0)
                                                    {
                                                ?>
                                                <option value="Owner">Owner</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3 mt-1"><span class="h6">Active</span></div>
                                        <div class="col-9">
                                            <select name="edt-slct-act" id="edt-slct-act" class="custom-select">
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-seuser">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    
    <?php
        require("./bin/php/footer.php");
    ?>
</body>
</html>