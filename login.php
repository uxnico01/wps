<?php
    require("./bin/php/clsfunction.php");
    
    session_destroy();

    $login = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | PT Winson Prima Sejahtera</title>
    
    <style>
        html,
        body
        {
            margin: 0;
            padding: 0;
            widows: 100%;
        }
    </style>
    
    <?php
        require("./bin/php/head.php");
    ?>
</head>
<body class="bg-secondary2 d-flex align-items-center h-100">   
    <div class="container">
        <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-5 mx-auto card p-0 text-dark shadow rounded">
            <div class="card-header text-center d-flex align-items-center">
                <div class="mx-auto"><a href="./login"><img src="./bin/img/logo.png" alt="Logo" width="70"></a> <span class="h3">Login</span></div>
            </div>
            
            <div class="card-body border border-left-0 border-right-0 modal-body">
                <div class="alert alert-danger d-none" id="div-err-1">Username dan password harus diisi !!!</div>
                
                <div class="alert alert-danger d-none" id="div-err-2">Akun tidak ditemukan !!!</div>
                
                <div class="alert alert-danger d-none" id="div-err-3">Password salah !!!</div>
                
                <div class="alert alert-danger d-none" id="div-err-4">Akun ini di blokir atau tidak aktif !!!</div>
                
                <?php
                    if(isset($_GET["exp"]))
                    {
                        if(strcasecmp($_GET["exp"],"1") == 0)
                        {
                ?>
                <div class="alert alert-danger">Sesi anda habis, harap login kembali !!!</div>
                <?php
                        }
                    }
                ?>
                
                <div class="row my-4">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 pt-1">Username</div>
                    <div class="col-12 col-sm-12 col-md-7 col-lg-8 col-xl-9"><input type="text" class="form-control inp-set" id="txt-user" name="txt-user" autocomplete="off" placeholder="Username" autofocus></div>
                </div>
                
                <div class="row my-4">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 pt-1">Password</div>
                    <div class="col-12 col-sm-12 col-md-7 col-lg-8 col-xl-9">
                        <div class="input-group">
                            <input type="password" class="form-control inp-set" id="txt-pass" name="txt-pass" autocomplete="off" placeholder="Password">
                            
                            <div class="input-group-append">
                                <button class="btn btn-light border border-dark vpass" data-value="#txt-pass"><img src="./bin/img/icon/view-icon.png" alt="View" width="25"></button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="my-3 d-flex">
                    <button class="btn btn-dark btn-block shadow" id="btn-lgn">Login</button><br>
                </div>
            </div>
            
            <div class="card-footer">
                <p class="text-center mb-0 small">&copy PT Winson Prima Sejahtera 2021 <?php if(strcasecmp(date('Y'),"2021") != 0) echo " - ".date('Y');?>. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>