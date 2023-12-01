<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="./home"><img src="./bin/img/logo-wh.png" alt="Logo" width="50"> <span class=""><?php echo $ttl;?></span> <em class="small">- <?php if(isset($_SESSION["kuma-db"])) echo $_SESSION["kuma-db-nm"]; else echo "Bulan Berjalan";?></em></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-kumabis" aria-controls="navbar-kumabis" aria-expanded="false" aria-label="Navbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav-kumabis">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?php if(strcasecmp($nav,"1") == 0) echo "active";?>" href="./home">Home <?php if(strcasecmp($nav,"1") == 0) {?><span class="sr-only">(current)</span><?php }?></a>
            </li>
            
            <?php
                if(cekAksUser(substr($duser[7],2,46)) || cekAksUser(substr($duser[7],103,4)) || cekAksUser(substr($duser[7],123,4)) || cekAksUser(substr($duser[7],159,4)) || cekAksUser(substr($duser[7],180,4)) || cekAksUser(substr($duser[7],202,4)))
                {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link <?php if(strcasecmp($nav,"2") == 0) echo "active";?> dropdown-toggle" href="#" id="ldrop-data" role="button" data-toggle="dropdown">Data <?php if(strcasecmp($nav,"2") == 0) {?><span class="sr-only">(current)</span><?php }?></a>
                <div class="dropdown-menu scrollable-menu bg-dark" aria-labelledby="ldrop-data">
                    <?php
                        if(cekAksUser(substr($duser[7],2,7)) || cekAksUser(substr($duser[7],103,4)))
                        {
                    ?>
                    <a href="./supplier" class="dropdown-item text-light bg-dark">Supplier</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],42,5)))
                        {
                    ?>
                    <a href="./customer" class="dropdown-item text-light bg-dark">Customer</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],123,4)))
                        {
                    ?>
                    <a href="./po" class="dropdown-item text-light bg-dark">P/O</a>
                    <?php
                        }
                    
                        if((cekAksUser(substr($duser[7],2,7)) || cekAksUser(substr($duser[7],103,4)) || cekAksUser(substr($duser[7],42,5)) || cekAksUser(substr($duser[7],123,4))) && (cekAksUser(substr($duser[7],9,28)) || cekAksUser(substr($duser[7],159,4)) || cekAksUser(substr($duser[7],180,4)) || cekAksUser(substr($duser[7],202,4))))
                        {
                    ?>
                    <div class="dropdown-divider border-white"></div>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],9,8)))
                        {
                    ?>
                    <a href="./produk" class="dropdown-item text-light bg-dark">Produk</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],17,5)))
                        {
                    ?>
                    <a href="./grade" class="dropdown-item text-light bg-dark">Grade</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],26,6)))
                        {
                    ?>
                    <a href="./oz" class="dropdown-item text-light bg-dark">Oz</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],32,5)))
                        {
                    ?>
                    <a href="./cut-style" class="dropdown-item text-light bg-dark">Cut Style</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],180,4)))
                        {
                    ?>
                    <a href="./kategori" class="dropdown-item text-light bg-dark">Kategori</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],202,4)))
                        {
                    ?>
                    <a href="./golongan" class="dropdown-item text-light bg-dark">Golongan</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],22,4)))
                        {
                    ?>
                    <a href="./satuan" class="dropdown-item text-light bg-dark">Satuan</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],159,4)))
                        {
                    ?>
                    <a href="./gudang" class="dropdown-item text-light bg-dark">Gudang</a>
                    <?php
                        }
                    
                        if((cekAksUser(substr($duser[7],2,7)) || cekAksUser(substr($duser[7],103,4)) || cekAksUser(substr($duser[7],42,5)) || cekAksUser(substr($duser[7],123,4)) || cekAksUser(substr($duser[7],9,28)) || cekAksUser(substr($duser[7],159,4)) || cekAksUser(substr($duser[7],180,4)) || cekAksUser(substr($duser[7],202,4))) && cekAksUser(substr($duser[7],37,5)))
                        {
                    ?>
                    <div class="dropdown-divider border-white"></div>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],37,5)))
                        {
                    ?>
                    <a href="./user" class="dropdown-item text-light bg-dark">User</a>
                    <?php
                        }
                    ?>
                </div>
            </li>
            <?php
                }
            
                if(cekAksUser(substr($duser[7],52,5)) || cekAksUser(substr($duser[7],107,5)) || cekAksUser(substr($duser[7],145,5)) || cekAksUser(substr($duser[7],151,5)) || cekAksUser(substr($duser[7],163,5)) || cekAksUser(substr($duser[7],184,10)))
                {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link <?php if(strcasecmp($nav,"3") == 0) echo "active";?> dropdown-toggle" href="#" id="ldrop-tran" role="button" data-toggle="dropdown">Transaksi <?php if(strcasecmp($nav,"3") == 0) {?><span class="sr-only">(current)</span><?php }?></a>
                <div class="dropdown-menu scrollable-menu bg-dark" aria-labelledby="ldrop-tran">
                    <?php
                        if(cekAksUser(substr($duser[7],184,5)))
                        {
                    ?>
                    <a href="./beli" class="dropdown-item text-light bg-dark d-none">Beli</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],189,5)))
                        {
                    ?>
                    <a href="./retur-kirim" class="dropdown-item text-light bg-dark">Retur Pengiriman</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],184,10)) && (cekAksUser(substr($duser[7],52,5)) || cekAksUser(substr($duser[7],107,5)) || cekAksUser(substr($duser[7],145,5)) || cekAksUser(substr($duser[7],151,5)))){
                    ?>
                    <div class="dropdown-divider border-white"></div>
                    <?php
                        }

                        /*if(cekAksUser(substr($duser[7],47,5)))
                        {
                    ?>
                    <a href="./tanda-terima" class="dropdown-item text-light bg-dark">Tanda Terima</a>
                    <?php
                        }*/
                    
                        if(cekAksUser(substr($duser[7],52,5)))
                        {
                    ?>
                    <a href="./peminjaman" class="dropdown-item text-light bg-dark">Peminjaman</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],107,5)))
                        {
                    ?>
                    <a href="./penarikan" class="dropdown-item text-light bg-dark">Penarikan</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],145,5)))
                        {
                    ?>
                    <a href="./bb" class="dropdown-item text-light bg-dark">BB</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],151,5)))
                        {
                    ?>
                    <a href="./penyesuaian-stok" class="dropdown-item text-light bg-dark">Penyesuaian Stok</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],163,5)))
                        {
                    ?>
                    <a href="./pindah-stok" class="dropdown-item text-light bg-dark">Pindah Stok</a>
                    <?php
                        }
                    ?>
                </div>
            </li>
            <?php
                }
            
                if(cekAksUser(substr($duser[7],57,22)) || cekAksUser(substr($duser[7],119,3)) || cekAksUser(substr($duser[7],128,4)) || cekAksUser(substr($duser[7],201,1)) || cekAksUser(substr($duser[7],138,4)) || cekAksUser(substr($duser[7],175,5)))
                {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link <?php if(strcasecmp($nav,"4") == 0) echo "active";?> dropdown-toggle" href="#" id="ldrop-pro" role="button" data-toggle="dropdown">Proses <?php if(strcasecmp($nav,"4") == 0) {?><span class="sr-only">(current)</span><?php }?></a>
                <div class="dropdown-menu scrollable-menu bg-dark" aria-labelledby="ldrop-pro">
                    <?php
                        if(cekAksUser(substr($duser[7],62,5)))
                        {
                    ?>
                    <a href="./penerimaan" class="dropdown-item text-light bg-dark">Penerimaan</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],67,4)) || cekAksUser(substr($duser[7],119,1)))
                        {
                    ?>
                    <a href="./cutting" class="dropdown-item text-light bg-dark">Cutting</a>
                    <?php
                        }
                    
                    if(cekAksUser(substr($duser[7],71,4)) || cekAksUser(substr($duser[7],120,1)))
                        {
                    ?>
                    <a href="./vacuum" class="dropdown-item text-light bg-dark">Vacuum</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],75,4)) || cekAksUser(substr($duser[7],121,1)))
                        {
                    ?>
                    <a href="./sawing" class="dropdown-item text-light bg-dark">Sawing</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],175,5)))
                        {
                    ?>
                    <a href="./re-packaging" class="dropdown-item text-light bg-dark">Re-Packaging</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],57,5)))
                        {
                    ?>
                    <a href="./packaging" class="dropdown-item text-light bg-dark">Packaging</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],128,4)) || cekAksUser(substr($duser[7],201,1)))
                        {
                    ?>
                    <a href="./masuk-produk" class="dropdown-item text-light bg-dark">Masuk Produk</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],138,4)))
                        {
                    ?>
                    <a href="./pembekuan" class="dropdown-item text-light bg-dark">Pembekuan</a>
                    <?php
                        }
                    ?>
                </div>
            </li>
            <?php
                }
            
                if(cekAksUser(substr($duser[7],79,16)) || cekAksUser(substr($duser[7],112,2)) || cekAksUser(substr($duser[7],115,2)) || cekAksUser(substr($duser[7],117,2)) || cekAksUser(substr($duser[7],132,2)) || cekAksUser(substr($duser[7],136,2)) || cekAksUser(substr($duser[7],142,2)) || cekAksUser(substr($duser[7],156,2)) || cekAksUser(substr($duser[7],177,2)) || cekAksUser(substr($duser[7],196,4)))
                {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link <?php if(strcasecmp($nav,"5") == 0) echo "active";?> dropdown-toggle" href="#" id="ldrop-rpt" role="button" data-toggle="dropdown">Laporan <?php if(strcasecmp($nav,"5") == 0) {?><span class="sr-only">(current)</span><?php }?></a>
                <div class="dropdown-menu scrollable-menu bg-dark" aria-labelledby="ldrop-rpt">
                    <?php
                        if(cekAksUser(substr($duser[7],79,2)))
                        {
                    ?>
                    <a href="./laporan-produk" class="dropdown-item text-light bg-dark">Laporan Produk</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],81,2)))
                        {
                    ?>
                    <a href="./laporan-supplier" class="dropdown-item text-light bg-dark">Laporan Supplier</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],83,2)))
                        {
                    ?>
                    <a href="./laporan-customer" class="dropdown-item text-light bg-dark">Laporan Customer</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],136,2)))
                        {
                    ?>
                    <a href="./laporan-po" class="dropdown-item text-light bg-dark">Laporan P/O</a>
                    <?php
                        }
                    
                        if((cekAksUser(substr($duser[7],79,6)) || cekAksUser(substr($duser[7],136,2)) || cekAksUser(substr($duser[7],142,2)) || cekAksUser(substr($duser[7],177,2))) && cekAksUser(substr($duser[7],85,8)))
                        {
                    ?>
                    <div class="dropdown-divider border-white"></div>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],85,2)))
                        {
                    ?>
                    <a href="./laporan-penerimaan" class="dropdown-item text-light bg-dark">Laporan Penerimaan</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],87,2)))
                        {
                    ?>
                    <a href="./laporan-cutting" class="dropdown-item text-light bg-dark">Laporan Cutting</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],89,2)))
                        {
                    ?>
                    <a href="./laporan-vacuum" class="dropdown-item text-light bg-dark">Laporan Vacuum</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],91,2)))
                        {
                    ?>
                    <a href="./laporan-sawing" class="dropdown-item text-light bg-dark">Laporan Sawing</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],177,2)))
                        {
                    ?>
                    <a href="./laporan-re-packaging" class="dropdown-item text-light bg-dark">Laporan Re-Packaging</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],93,2)))
                        {
                    ?>
                    <a href="./laporan-packaging" class="dropdown-item text-light bg-dark">Laporan Packaging</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],132,2)))
                        {
                    ?>
                    <a href="./laporan-masuk-produk" class="dropdown-item text-light bg-dark">Laporan Masuk Produk</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],142,2)))
                        {
                    ?>
                    <a href="./laporan-pembekuan" class="dropdown-item text-light bg-dark">Laporan Pembekuan</a>
                    <?php
                        }
                    
                        if((cekAksUser(substr($duser[7],79,6)) || cekAksUser(substr($duser[7],136,2)) || cekAksUser(substr($duser[7],85,8)) || cekAksUser(substr($duser[7],142,2)) || cekAksUser(substr($duser[7],177,2))) && (cekAksUser(substr($duser[7],196,4)) || cekAksUser(substr($duser[7],112,2)) || cekAksUser(substr($duser[7],115,2)) || cekAksUser(substr($duser[7],117,2)) || cekAksUser(substr($duser[7],156,2)) || cekAksUser(substr($duser[7],168,2))))
                        {
                    ?>
                    <div class="dropdown-divider border-white"></div>
                    <?php
                        }
                        
                        if(cekAksUser(substr($duser[7],196,2)))
                        {
                    ?>
                    <a href="./laporan-beli" class="dropdown-item text-light bg-dark d-none">Laporan Beli</a>
                    <?php
                        }
                        
                        if(cekAksUser(substr($duser[7],198,2)))
                        {
                    ?>
                    <a href="./laporan-retur-kirim" class="dropdown-item text-light bg-dark">Laporan Retur Kirim</a>
                    <?php
                        }
                        
                        if(cekAksUser(substr($duser[7],112,2)))
                        {
                    ?>
                    <a href="./laporan-simpanan" class="dropdown-item text-light bg-dark">Laporan Simpanan</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],115,2)))
                        {
                    ?>
                    <a href="./laporan-pinjaman" class="dropdown-item text-light bg-dark">Laporan Pinjaman</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],117,2)))
                        {
                    ?>
                    <a href="./laporan-bb" class="dropdown-item text-light bg-dark">Laporan BB</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],156,2)))
                        {
                    ?>
                    <a href="./laporan-penyesuaian-stok" class="dropdown-item text-light bg-dark">Laporan Penyesuaian Stok</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],168,2)))
                        {
                    ?>
                    <a href="./laporan-pindah-stok" class="dropdown-item text-light bg-dark">Laporan Pindah Stok</a>
                    <?php
                        }
                    ?>
                </div>
            </li>
            <?php
                }
            
                if(cekAksUser(substr($duser[7],95,1)) || cekAksUser(substr($duser[7],122,1)) || cekAksUser(substr($duser[7],127,1)) || viewHarga())
                {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link <?php if(strcasecmp($nav,"6") == 0) echo "active";?> dropdown-toggle" href="#" id="ldrop-oth" role="button" data-toggle="dropdown">Utility <?php if(strcasecmp($nav,"6") == 0) {?><span class="sr-only">(current)</span><?php }?></a>
                <div class="dropdown-menu scrollable-menu bg-dark" aria-labelledby="ldrop-oth">
                    <?php
                        if(cekAksUser(substr($duser[7],95,1)))
                        {
                    ?>
                    <a href="./setting" class="dropdown-item text-light bg-dark">Setting</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],122,1)))
                        {
                    ?>
                    <a href="./repair" class="dropdown-item text-light bg-dark">Repair</a>
                    <?php
                        }

                        if(cekAksUser(substr($duser[7],127,1)))
                        {
                    ?>
                    <a href="#" class="dropdown-item text-light bg-dark" data-target="#mdl-tbuku" data-toggle="modal">Tutup Buku</a>
                    <?php
                        }

                        if(viewHarga())
                        {
                    ?>
                    <a href="#" class="dropdown-item text-light bg-dark" id="btn-idata">Import Data</a>
                    <?php
                        }
                    ?>
                </div>
            </li>
            <?php
                }
            
                if(cekAksUser(substr($duser[7],96,7)) || cekAksUser(substr($duser[7],114,1)) || cekAksUser(substr($duser[7],134,1)) || cekAksUser(substr($duser[7],144,1)) || cekAksUser(substr($duser[7],150,1)) || cekAksUser(substr($duser[7],158,1)) || cekAksUser(substr($duser[7],170,1)) || cekAksUser(substr($duser[7],179,1)) || cekAksUser(substr($duser[7],194,2)))
                {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link <?php if(strcasecmp($nav,"7") == 0) echo "active";?> dropdown-toggle" href="#" id="ldrop-hst" role="button" data-toggle="dropdown">History <?php if(strcasecmp($nav,"7") == 0) {?><span class="sr-only">(current)</span><?php }?></a>
                <div class="dropdown-menu scrollable-menu bg-dark" aria-labelledby="ldrop-hst">
                    <?php
                        /*if(cekAksUser(substr($duser[7],96,1)))
                        {
                    ?>
                    <a href="./history-tanda-terima" class="dropdown-item text-light bg-dark">History Tanda Terima</a>
                    <?php
                        }*/
                    
                        if(cekAksUser(substr($duser[7],97,1)))
                        {
                    ?>
                    <a href="./history-peminjaman" class="dropdown-item text-light bg-dark">History Peminjaman</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],98,1)))
                        {
                    ?>
                    <a href="./history-penerimaan" class="dropdown-item text-light bg-dark">History Penerimaan</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],99,1)))
                        {
                    ?>
                    <a href="./history-cutting" class="dropdown-item text-light bg-dark">History Cutting</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],100,1)))
                        {
                    ?>
                    <a href="./history-vacuum" class="dropdown-item text-light bg-dark">History Vacuum</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],101,1)))
                        {
                    ?>
                    <a href="./history-sawing" class="dropdown-item text-light bg-dark">History Sawing</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],179,1)))
                        {
                    ?>
                    <a href="./history-re-packaging" class="dropdown-item text-light bg-dark">History Re-Packaging</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],102,1)))
                        {
                    ?>
                    <a href="./history-packaging" class="dropdown-item text-light bg-dark">History Packaging</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],134,1)))
                        {
                    ?>
                    <a href="./history-masuk-produk" class="dropdown-item text-light bg-dark">History Masuk Produk</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],144,1)))
                        {
                    ?>
                    <a href="./history-pembekuan" class="dropdown-item text-light bg-dark">History Pembekuan</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],194,1)))
                        {
                    ?>
                    <a href="./history-beli" class="dropdown-item text-light bg-dark d-none">History Beli</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],195,1)))
                        {
                    ?>
                    <a href="./history-retur-kirim" class="dropdown-item text-light bg-dark">History Retur Kirim</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],114,1)))
                        {
                    ?>
                    <a href="./history-penarikan" class="dropdown-item text-light bg-dark">History Penarikan</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],150,1)))
                        {
                    ?>
                    <a href="./history-bb" class="dropdown-item text-light bg-dark">History BB</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],158,1)))
                        {
                    ?>
                    <a href="./history-penyesuaian-stok" class="dropdown-item text-light bg-dark">History Penyesuaian Stok</a>
                    <?php
                        }
                    
                        if(cekAksUser(substr($duser[7],170,1)))
                        {
                    ?>
                    <a href="./history-pindah-stok" class="dropdown-item text-light bg-dark">History Pindah Stok</a>
                    <?php
                        }
                    ?>
                </div>
            </li>
            <?php
                }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="./bin/php/logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>