var gvpjm, gvtt, gvkrm, gvbb, gvmv;

//RETUR KIRIM
function getNIDRKrm(){
    Process();
    setTimeout(function(){
        if(!$("#div-err-rkrm-1").hasClass("d-none"))
            $("#div-err-rkrm-1").addClass("d-none");
            
        if(!$("#div-err-rkrm-2").hasClass("d-none"))
            $("#div-err-rkrm-2").addClass("d-none");
            
        if(!$("#div-err-rkrm-3").hasClass("d-none"))
            $("#div-err-rkrm-3").addClass("d-none");
            
        if(!$("#div-err-rkrm-4").hasClass("d-none"))
            $("#div-err-rkrm-4").addClass("d-none");
            
        if(!$("#div-scs-rkrm-1").hasClass("d-none"))
            $("#div-scs-rkrm-1").addClass("d-none");

        $("#mdl-nrkrm").modal("show");

        swal.close();
    }, 200);
}

function schRKrm(x){
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/srkrm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-rkrm").html(setToTblRKrm(json));

                swal.close();
            },
            error : function(){
                swal("Error (SRKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblRKrm(x){
    var hsl = "";

    if(x.count[0] > 0){
        for(var i = 0; i < x.count[0]; i++){
            var dtl = "<ul class=\"m-0 small\">";

            for(var j = 0; j < x.dtl[i].length; j++){
                var nama = x.dtl[i][j][3]+" / "+x.dtl[i][j][4];

                if(x.dtl[i][j][5] !== ""){
                    nama += " / "+x.dtl[i][j][5];
                }
                
                if(x.dtl[i][j][6] !== ""){
                    nama += " / "+x.dtl[i][j][6];
                }

                dtl += "<li>"+nama+" ("+NumberFormat2(x.dtl[i][j][2])+" KG)</li>";    
            }

            dtl += "</ul>";

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][7])+"</td>"+
                        "<td class=\"border\">"+dtl+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eRKrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delRKrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewRKrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"More\" width=\"20\"></button></td>"+
                    "</tr>";
        }
    }
    else{
        hsl += "<tr>"+
                    "<td colspan=\"9\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";
    }

    return hsl;
}

function eRKrm(x, y = 1){
    x = UD64(x);

    if(!$("#div-edt-err-rkrm-1").hasClass("d-none"))
        $("#div-edt-err-rkrm-1").addClass("d-none");

    if(!$("#div-edt-err-rkrm-2").hasClass("d-none"))
        $("#div-edt-err-rkrm-2").addClass("d-none");

    if(!$("#div-edt-err-rkrm-3").hasClass("d-none"))
        $("#div-edt-err-rkrm-3").addClass("d-none");

    if(!$("#div-edt-err-rkrm-4").hasClass("d-none"))
        $("#div-edt-err-rkrm-4").addClass("d-none");
            
    if(!$("#div-edt-err-rkrm-5").hasClass("d-none"))
        $("#div-edt-err-rkrm-5").addClass("d-none");

    if(!$("#div-edt-scs-rkrm-1").hasClass("d-none"))
        $("#div-edt-scs-rkrm-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtrkrm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();

                if(!json.aks[0] && y === 1)
                {
                    swal({
                        title : "Perhatian !!!",
                        text : "Anda tidak memiliki akses ralat, klik tombol verifikasi dibawah untuk mendapatkan akses ralat.",
                        icon : "warning",
                        dangerMode : true,
                        buttons : {
                            cancel : "Batal",
                            verif : "Verifikasi",
                        },
                        closeOnClickOutside : false,
                        closeOnEsc : false,
                    })
                    .then(value => {
                        switch(value){
                            case "verif":
                                if(!$("#txt-vkode").prop("readonly"))
                                    $("#txt-vkode").prop("readonly", true);

                                $("#head-vkode").text("");
                                $("#mdl-vrf").modal({backdrop : "static", keyboard : false});
                                $("#mdl-vrf").modal("show");
                                $("#txt-vkode").attr("data-type", "RKRM");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setRKrmVerif(x);

                                gvrkrm = setInterval(getRKrmVerif, 1000);
                                break;

                            default: 
                                break;
                        }
                    })
                }
                else
                {
                    $("#edt-txt-id").val(json.data[0]);
                    $("#edt-txt-nma-cus").val(json.data[10]);
                    $("#edt-txt-cus").val(json.data[1]);
                    $("#edt-txt-po").val(json.data[2]);
                    $("#edt-dte-tgl").val(json.data[3]);
                    $("#edt-txt-ket").val(json.data[4]);
                    $("#edt-slct-gdg").val(json.data[9]);
                    $("#lst-erkrm").html(setToTblERKrm(json));

                    $("#btn-serkrm").attr("data-count", json.dtl.length);

                    $("#mdl-erkrm").modal("show");
                }
            },
            error : function(){
                swal("Error (ERKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblERKrm(x){
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++){
        var nama = x.dtl[i][3]+" / "+x.dtl[i][4];

        if(x.dtl[i][5] !== ""){
            nama += " / "+x.dtl[i][5];
        }

        if(x.dtl[i][6] !== ""){
            nama += " / "+x.dtl[i][6];
        }

        hsl += "<tr id=\"row-erkrm-"+i+"\">"+
                    "<td class=\"border\">"+nama+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(x.dtl[i][7])+"</td>"+
                    "<td class=\"border\"><input class=\"form-control\" type=\"number\" id=\"edt-txt-weight-erkrm-"+i+"\" value=\""+x.dtl[i][2]+"\" data-value=\""+UE64(x.dtl[i][1])+"\" data-mvalue=\""+x.dtl[i][7]+"\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1 btn-dpro-erkrm\" data-value=\""+UE64(i)+"\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function getRKrmVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));

        $.ajax({
            url : "./bin/php/gdtrkrm.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[7] === "x")
                {
                    swal("Error (GRKRMVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")
                    
                    clearInterval(gvrkrm);
                }
                else if(json.data[7] !== "?" && json.data[7] !== "")
                {
                    $("#head-vkode").text(json.data[7]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[7]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvrkrm);
                }
            },
            error : function(){
                swal("Error (GRKRMVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setRKrmVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/srkrmvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SRKRMVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekRKrmVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eRKrm(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CRKRMVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function newRKrm(){
    var tgl = $("#dte-tgl").val(), po = $("#txt-po").val(), ket = $("#txt-ket").val(), lpro = [], lerr = [];

    for(var i = 0; i < $("#btn-snrkrm").attr("data-count"); i++){
        if($("#txt-weight-nrkrm-"+i).length > 0){
            if(parseFloat($("#txt-weight-nrkrm-"+i).attr("data-mvalue")) < parseFloat($("#txt-weight-nrkrm-"+i).val())){
                lerr.push(i);
            }

            lpro.push([UD64($("#txt-weight-nrkrm-"+i).attr("data-value")), $("#txt-weight-nrkrm-"+i).val()]);
        }
    }

    if(!$("#div-err-rkrm-1").hasClass("d-none"))
        $("#div-err-rkrm-1").addClass("d-none");
        
    if(!$("#div-err-rkrm-2").hasClass("d-none"))
        $("#div-err-rkrm-2").addClass("d-none");
        
    if(!$("#div-err-rkrm-3").hasClass("d-none"))
        $("#div-err-rkrm-3").addClass("d-none");
            
    if(!$("#div-err-rkrm-4").hasClass("d-none"))
        $("#div-err-rkrm-4").addClass("d-none");
        
    if(!$("#div-scs-rkrm-1").hasClass("d-none"))
        $("#div-scs-rkrm-1").addClass("d-none");

    if(tgl === "" || po === ""){
        $("#div-err-rkrm-1").removeClass("d-none");
    }
    else if(lpro.length === 0){
        $("#div-err-rkrm-3").removeClass("d-none");
    }
    else if(lerr.length > 0){
        for(var i = 0; i < lerr.length; i++){
            $("#txt-weight-nkrm-"+lerr[i]).addClass("bg-danger text-white");
        }

        $("#div-err-rkrm-4").removeClass("d-none");
    }
    else{
        lpro = JSON.stringify(lpro);
        
        $("#btn-snrkrm").prop("disabled", true);
        $("#btn-snrkrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nrkrm.php",
                type : "post",
                data : {tgl : tgl, po : po, ket : ket, lpro : lpro},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1){
                        $("#div-err-rkrm-1").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -2){
                        $("#div-err-rkrm-2").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -3){
                        $("#div-err-rkrm-3").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -4){
                        for(var i = 0; i < json.err2.length; i++){
                            $("#txt-weight-nkrm-"+json.err2[i]).addClass("bg-danger text-white");
                        }

                        $("#div-err-rkrm-4").removeClass("d-none");
                    }
                    else{
                        $("#div-scs-rkrm-1").removeClass("d-none");
                        $("#mdl-nkrm input").val("");
                        $("#lst-nrkrm").html("");
                        $("#dte-tgl").val(tgl);
                        $("#btn-snrkrm").attr("data-count", 0);
                    }
                    
                    $("#btn-snrkrm").prop("disabled", false);
                    $("#btn-snrkrm").html("Simpan");
                },
                error : function(){
                    $("#btn-snrkrm").prop("disabled", false);
                    $("#btn-snrkrm").html("Simpan");

                    swal("Error (NRKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updRKrm(){
    var tgl = $("#edt-dte-tgl").val(), po = $("#edt-txt-po").val(), ket = $("#edt-txt-ket").val(), lpro = [], bid = $("#edt-txt-id").val(), lerr = [], gdg = $("#edt-slct-gdg").val();
    
    for(var i = 0; i < $("#btn-serkrm").attr("data-count"); i++){
        if($("#edt-txt-weight-erkrm-"+i).length > 0){
            if(parseFloat($("#edt-txt-weight-erkrm-"+i).attr("data-mvalue")) < parseFloat($("#edt-txt-weight-erkrm-"+i).val())){
                lerr.push(i);
            }

            lpro.push([UD64($("#edt-txt-weight-erkrm-"+i).attr("data-value")), $("#edt-txt-weight-erkrm-"+i).val()]);
        }
    }

    if(!$("#div-edt-err-rkrm-1").hasClass("d-none"))
        $("#div-edt-err-rkrm-1").addClass("d-none");
        
    if(!$("#div-edt-err-rkrm-2").hasClass("d-none"))
        $("#div-edt-err-rkrm-2").addClass("d-none");
        
    if(!$("#div-edt-err-rkrm-3").hasClass("d-none"))
        $("#div-edt-err-rkrm-3").addClass("d-none");
            
    if(!$("#div-edt-err-rkrm-4").hasClass("d-none"))
        $("#div-edt-err-rkrm-4").addClass("d-none");
            
    if(!$("#div-edt-err-rkrm-5").hasClass("d-none"))
        $("#div-edt-err-rkrm-5").addClass("d-none");
        
    if(!$("#div-edt-scs-rkrm-1").hasClass("d-none"))
        $("#div-edt-scs-rkrm-1").addClass("d-none");

    if(tgl === "" || po === ""){
        $("#div-edt-err-rkrm-1").removeClass("d-none");
    }
    else if(lpro.length === 0){
        $("#div-edt-err-rkrm-3").removeClass("d-none");
    }
    else if(lerr.length > 0){
        for(var i = 0; i < lerr.length; i++){
            $("#edt-txt-weight-ekrm-"+lerr[i]).addClass("bg-danger text-white");
        }

        $("#div-edt-err-rkrm-4").removeClass("d-none");
    }
    else{
        lpro = JSON.stringify(lpro);
        
        $("#btn-serkrm").prop("disabled", true);
        $("#btn-serkrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/urkrm.php",
                type : "post",
                data : {tgl : tgl, po : po, ket : ket, lpro : lpro, bid : bid, gdg : gdg},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1){
                        $("#div-edt-err-rkrm-1").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -2){
                        $("#div-edt-err-rkrm-2").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -3){
                        $("#div-edt-err-rkrm-3").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -4){
                        for(var i = 0; i < json.err2.length; i++){
                            $("#edt-txt-weight-ekrm-"+json.err2[i]).addClass("bg-danger text-white");
                        }

                        $("#div-edt-err-rkrm-4").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -5){
                        $("#div-edt-err-rkrm-5").removeClass("d-none");
                    }
                    else{
                        $("#div-edt-scs-rkrm-1").removeClass("d-none");

                        $("#mdl-erkrm").modal("hide");
                        schRKrm($("#txt-srch-rkrm").val());
                    }
                    
                    $("#btn-serkrm").prop("disabled", false);
                    $("#btn-serkrm").html("Simpan");
                },
                error : function(){
                    $("#btn-serkrm").prop("disabled", false);
                    $("#btn-serkrm").html("Simpan");

                    swal("Error (URKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delRKrm(x){
    x = UD64(x);

    swal({
        title : "Perhatian !!!",
        text : "Anda hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/drkrm.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);
                        
                        swal({
                            title : "Sukses !!!",
                            text : "Data berhasil dihapus !!!",
                            icon : "success",
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        })
                        .then(ok => {
                            if(ok)
                                schRKrm($("#txt-srch-rkrm").val());
                        });
                    },
                    error : function(){
                        swal("Error (DRKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delProRKrm(x, y){
    x = UD64(x);

    swal({
        title : "Perhatian !!!",
        text : "Anda yakin hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) => {
        if(ok){
            if(y === "N"){
                $("#row-nrkrm-pro-"+x).remove();
            }
            else if(y === "E"){
                $("#row-erkrm-pro-"+x).remove();
            }
        }
    })
}

function viewRKrm(x){
    window.open("./lihat-retur-kirim?id="+x, "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//PINJAMAN
function getNIDPjm()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-pjm-1").hasClass("d-none"))
            $("#div-err-pjm-1").addClass("d-none");
            
        if(!$("#div-err-pjm-2").hasClass("d-none"))
            $("#div-err-pjm-2").addClass("d-none");
            
        if(!$("#div-err-pjm-3").hasClass("d-none"))
            $("#div-err-pjm-3").addClass("d-none");
            
        if(!$("#div-scs-pjm-1").hasClass("d-none"))
            $("#div-scs-pjm-1").addClass("d-none");

        $("#mdl-npjm").modal("show");

        swal.close();
    }, 200);
}

function schPjm(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/spjm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pjm").html(setToTblPjm(json));

                swal.close();
            },
            error : function(){
                swal("Error (SPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblPjm(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var sisa = x.data[i][3]-x.data[i][4]-x.data[i][10];
            hsl += "<tr ondblclick=\"viewPjm('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][10])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(sisa)+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"ePjm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delPjm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewPjm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"More\" width=\"20\"></button></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"13\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function ePjm(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-pjm-1").hasClass("d-none"))
        $("#div-edt-err-pjm-1").addClass("d-none");

    if(!$("#div-edt-err-pjm-2").hasClass("d-none"))
        $("#div-edt-err-pjm-2").addClass("d-none");

    if(!$("#div-edt-err-pjm-3").hasClass("d-none"))
        $("#div-edt-err-pjm-3").addClass("d-none");

    if(!$("#div-edt-err-pjm-4").hasClass("d-none"))
        $("#div-edt-err-pjm-4").addClass("d-none");

    if(!$("#div-edt-scs-pjm-1").hasClass("d-none"))
        $("#div-edt-scs-pjm-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtpjm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();

                if(!json.aks[0] && y === 1)
                {
                    swal({
                        title : "Perhatian !!!",
                        text : "Anda tidak memiliki akses ralat, klik tombol verifikasi dibawah untuk mendapatkan akses ralat.",
                        icon : "warning",
                        dangerMode : true,
                        buttons : {
                            cancel : "Batal",
                            verif : "Verifikasi",
                        },
                        closeOnClickOutside : false,
                        closeOnEsc : false,
                    })
                    .then(value => {
                        switch(value){
                            case "verif":
                                if(!$("#txt-vkode").prop("readonly"))
                                    $("#txt-vkode").prop("readonly", true);

                                $("#head-vkode").text("");
                                $("#mdl-vrf").modal({backdrop : "static", keyboard : false});
                                $("#mdl-vrf").modal("show");
                                $("#txt-vkode").attr("data-type", "PJM");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setPjmVerif(x);

                                gvpjm = setInterval(getPjmVerif, 1000);
                                break;

                            default: 
                                break;
                        }
                    })
                }
                else
                {
                    $("#edt-txt-id").val(json.data[0]);
                    $("#edt-txt-bid").val(json.data[0]);
                    $("#edt-txt-nma-sup").val(json.sup[1]);
                    $("#edt-txt-sup").val(json.data[1]);
                    $("#edt-dte-tgl").val(json.data[2]);
                    $("#edt-txt-jlh").val(NumberFormat2(json.data[3]));
                    $("#edt-txt-ket1").val(json.data[5]);
                    $("#edt-txt-ket2").val(json.data[6]);
                    $("#edt-txt-ket3").val(json.data[7]);
                    $("#edt-txt-pot").val(NumberFormat2(json.data[12]));

                    $("#mdl-epjm").modal("show");
                }
            },
            error : function(){
                swal("Error (EPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlPjm(x)
{
    x = UD64(x);

    $("#txt-opt-pjm").val(x);

    $("#mdl-opt-pjm").modal("show");
}

function getPjmVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));

        $.ajax({
            url : "./bin/php/gdtpjm.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[10] === "x")
                {
                    swal("Error (GPJMVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")
                    
                    clearInterval(gvpjm);
                }
                else if(json.data[10] !== "?" && json.data[10] !== "")
                {
                    $("#head-vkode").text(json.data[10]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[10]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvpjm);
                }
            },
            error : function(){
                swal("Error (GPJMVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setPjmVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/spjmvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SPJMVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekPjmVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        ePjm(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CPJMVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function newPjm()
{
    var id = $("#txt-id").val(), sup = $("#txt-sup").val(), tgl = $("#dte-tgl").val(), jlh = UnNumberFormat($("#txt-jlh").val()), ket1 = $("#txt-ket1").val(), ket2 = $("#txt-ket2").val(), ket3 = $("#txt-ket3").val(), pot = UnNumberFormat($("#txt-pot").val());

    if(!$("#div-err-pjm-1").hasClass("d-none"))
        $("#div-err-pjm-1").addClass("d-none");

    if(!$("#div-err-pjm-2").hasClass("d-none"))
        $("#div-err-pjm-2").addClass("d-none");

    if(!$("#div-err-pjm-3").hasClass("d-none"))
        $("#div-err-pjm-3").addClass("d-none");

    if(!$("#div-scs-pjm-1").hasClass("d-none"))
        $("#div-scs-pjm-1").addClass("d-none");

    if(sup === "" || tgl === "" || jlh === "" || jlh <= 0)
        $("#div-err-pjm-1").removeClass("d-none");
    else
    {
        $("#btn-snpjm").prop("disabled", true);
        $("#btn-snpjm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/npjm.php",
                type : "post",
                data : {id : id, sup : sup, tgl : tgl, jlh : jlh, ket1 : ket1, ket2 : ket2, ket3 : ket3, pot : pot},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-pjm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-pjm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-pjm-3").removeClass("d-none");
                    else
                    {
                        $("#mdl-npjm input").val("");
                        $("#dte-tgl").val(tgl);

                        $("#txt-id").focus().select();

                        $("#div-scs-pjm-1").removeClass("d-none");

                        schPjm($("#txt-srch-pjm").val());
                        
                        setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Pinjaman berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-peminjaman?id="+UE64(json.id[0]), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);
                    }

                    $("#btn-snpjm").prop("disabled", false);
                    $("#btn-snpjm").html("Simpan");
                },
                error : function(){
                    $("#btn-snpjm").prop("disabled", false);
                    $("#btn-snpjm").html("Simpan");
                    swal("Error (NPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updPjm()
{
    var id = $("#edt-txt-id").val(), sup = $("#edt-txt-sup").val(), tgl = $("#edt-dte-tgl").val(), jlh = UnNumberFormat($("#edt-txt-jlh").val()), ket1 = $("#edt-txt-ket1").val(), ket2 = $("#edt-txt-ket2").val(), ket3 = $("#edt-txt-ket3").val(), bid = $("#edt-txt-bid").val(), pot = UnNumberFormat($("#edt-txt-pot").val());

    if(!$("#div-edt-err-pjm-1").hasClass("d-none"))
        $("#div-edt-err-pjm-1").addClass("d-none");

    if(!$("#div-edt-err-pjm-2").hasClass("d-none"))
        $("#div-edt-err-pjm-2").addClass("d-none");

    if(!$("#div-edt-err-pjm-3").hasClass("d-none"))
        $("#div-edt-err-pjm-3").addClass("d-none");

    if(!$("#div-edt-scs-pjm-1").hasClass("d-none"))
        $("#div-edt-scs-pjm-1").addClass("d-none");

    if(id === "" || sup === "" || tgl === "" || jlh === "" || jlh <= 0)
        $("#div-edt-err-pjm-1").removeClass("d-none");
    else
    {
        $("#btn-sepjm").prop("disabled", true);
        $("#btn-sepjm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/upjm.php",
                type : "post",
                data : {id : id, sup : sup, tgl : tgl, jlh : jlh, ket1 : ket1, ket2 : ket2, ket3 : ket3, bid : bid, pot : pot},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-pjm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-pjm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-pjm-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-pjm-4").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-pjm-1").removeClass("d-none");

                        schPjm($("#txt-srch-pjm").val());

                        $("#mdl-epjm").modal("hide");
                        
                        setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Pinjaman berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-peminjaman?id="+UE64(id), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);
                    }

                    $("#btn-sepjm").prop("disabled", false);
                    $("#btn-sepjm").html("Simpan");
                },
                error : function(){
                    $("#btn-sepjm").prop("disabled", false);
                    $("#btn-sepjm").html("Simpan");
                    swal("Error (UPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delPjm(x)
{
    x = UD64(x);
    swal({
        title : "Perhatian !!!",
        text : "Anda hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dpjm.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DPJM - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
                        else
                        {
                            swal({
                                title : "Sukses !!!",
                                text : "Data berhasil dihapus !!!",
                                icon : "success",
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                            })
                            .then(ok => {
                                if(ok)
                                    schPjm($("#txt-srch-pjm").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function viewPjm(x = "")
{
    if(x === "")
        x = $("#txt-opt-pjm").val();
    else
        x = UD64(x);

    window.open("./lihat-peminjaman?id="+UE64(x), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//TANDA TERIMA
function getNIDTT()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-tt-1").hasClass("d-none"))
            $("#div-err-tt-1").addClass("d-none");

        if(!$("#div-err-tt-2").hasClass("d-none"))
            $("#div-err-tt-2").addClass("d-none");

        if(!$("#div-err-tt-3").hasClass("d-none"))
            $("#div-err-tt-3").addClass("d-none");

        if(!$("#div-err-tt-4").hasClass("d-none"))
            $("#div-err-tt-4").addClass("d-none");

        if(!$("#div-err-tt-5").hasClass("d-none"))
            $("#div-err-tt-5").addClass("d-none");

        if(!$("#div-scs-tt-1").hasClass("d-none"))
            $("#div-scs-tt-1").addClass("d-none");

        $("#mdl-ntt").modal("show");

        swal.close();
    }, 200);
}

function schTT(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/stt.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-tt").html(setToTblTT(json));

                swal.close();
            },
            error : function(){
                swal("Error (STT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblTT(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\">"+x.data[i][10]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eTT('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTT('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-info mb-1 p-1\" onclick=\"mdlTT('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/more-info.png\" alt=\"More\" width=\"20\"></button></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"12\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function eTT(x, y = 1)
{
    x = UD64(x);
    
    if(!$("#div-edt-err-tt-1").hasClass("d-none"))
        $("#div-edt-err-tt-1").addClass("d-none");

    if(!$("#div-edt-err-tt-2").hasClass("d-none"))
        $("#div-edt-err-tt-2").addClass("d-none");

    if(!$("#div-edt-err-tt-3").hasClass("d-none"))
        $("#div-edt-err-tt-3").addClass("d-none");

    if(!$("#div-edt-err-tt-4").hasClass("d-none"))
        $("#div-edt-err-tt-4").addClass("d-none");

    if(!$("#div-edt-err-tt-5").hasClass("d-none"))
        $("#div-edt-err-tt-5").addClass("d-none");

    if(!$("#div-edt-err-tt-6").hasClass("d-none"))
        $("#div-edt-err-tt-6").addClass("d-none");

    if(!$("#div-edt-scs-tt-1").hasClass("d-none"))
        $("#div-edt-scs-tt-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdttt.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();

                if(!json.aks[0] && y === 1)
                {
                    swal({
                        title : "Perhatian !!!",
                        text : "Anda tidak memiliki akses ralat, klik tombol verifikasi dibawah untuk mendapatkan akses ralat.",
                        icon : "warning",
                        dangerMode : true,
                        buttons : {
                            cancel : "Batal",
                            verif : "Verifikasi",
                        },
                        closeOnClickOutside : false,
                        closeOnEsc : false,
                    })
                    .then(value => {
                        switch(value){
                            case "verif":
                                if(!$("#txt-vkode").prop("readonly"))
                                    $("#txt-vkode").prop("readonly", true);

                                $("#head-vkode").text("");
                                $("#mdl-vrf").modal({backdrop : "static", keyboard : false});
                                $("#mdl-vrf").modal("show");
                                $("#txt-vkode").attr("data-type", "TT");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setTTVerif(x);

                                gvtt = setInterval(getTTVerif, 1000);
                                break;

                            default: 
                                break;
                        }
                    })
                }
                else
                {
                    $("#edt-txt-id").val(json.data[0]);
                    $("#edt-txt-bid").val(json.data[0]);
                    $("#edt-txt-nma-sup").val(json.sup[1]);
                    $("#edt-txt-sup").val(json.data[1]);
                    $("#edt-dte-tgl").val(json.data[2]);
                    $("#edt-txt-bb").val(NumberFormat2(json.data[3]));
                    $("#edt-txt-poto").val(NumberFormat2(json.data[4]));
                    $("#edt-txt-poto").attr("data-value", UE64(json.spjm[0]));
                    $("#edt-spn-poto").text("Sisa Pinjaman : "+NumberFormat2(json.spjm[0]));
                    $("#edt-txt-ket1").val(json.data[5]);
                    $("#edt-txt-ket2").val(json.data[6]);
                    $("#edt-txt-ket3").val(json.data[7]);
                    $("#edt-txt-trm").val(json.data[8]);
                    
                    $("#lst-ett").html(setToTblTrmPro3(json, 2));

                    $("#mdl-ett").modal("show");
                }
            },
            error : function(){
                swal("Error (ETRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlTT(x)
{
    x = UD64(x);

    $("#txt-opt-tt").val(x);

    $("#mdl-opt-tt").modal("show");
}

function getTTVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));
        $.ajax({
            url : "./bin/php/gdttt.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[11] === "x")
                {
                    swal("Error (GTTVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")
                    
                    clearInterval(gvtt);
                }
                else if(json.data[11] !== "?" && json.data[11] !== "")
                {
                    $("#head-vkode").text(json.data[11]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[11]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvtt);
                }
            },
            error : function(){
                swal("Error (GTTVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setTTVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sttvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (STTVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekTTVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eTT(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CTTVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function newTT()
{
    var id = $("#txt-id").val(), sup = $("#txt-sup").val(), tgl = $("#dte-tgl").val(), bb = UnNumberFormat($("#txt-bb").val()), poto = UnNumberFormat($("#txt-poto").val()), mpoto = UD64($("#txt-poto").attr("data-value")), ket1 = $("#txt-ket1").val(), ket2 = $("#txt-ket2").val(), ket3 = $("#txt-ket3").val(), trm = $("#txt-trm").val();

    if(!$("#div-err-tt-1").hasClass("d-none"))
        $("#div-err-tt-1").addClass("d-none");

    if(!$("#div-err-tt-2").hasClass("d-none"))
        $("#div-err-tt-2").addClass("d-none");

    if(!$("#div-err-tt-3").hasClass("d-none"))
        $("#div-err-tt-3").addClass("d-none");

    if(!$("#div-err-tt-4").hasClass("d-none"))
        $("#div-err-tt-4").addClass("d-none");

    if(!$("#div-err-tt-5").hasClass("d-none"))
        $("#div-err-tt-5").addClass("d-none");

    if(!$("#div-scs-tt-1").hasClass("d-none"))
        $("#div-scs-tt-1").addClass("d-none");
        
    ToTop();
    if(id === "" || sup === "" || tgl === "" || bb === "" || bb <= 0 || trm === "")
        $("#div-err-tt-1").removeClass("d-none");
    else if(parseFloat(poto) > parseFloat(mpoto))
        $("#div-err-tt-4").removeClass("d-none");
    else
    {
        $("#btn-sntt").prop("disabled", true);
        $("#btn-sntt").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        var lhrga = [], n = 0;

        for(var i = 0; i < $("#lst-ntt tr").length; i++)
        {
            lhrga[n] = UnNumberFormat($("#txt-hrga-"+i).val());

            n++;
        }

        lhrga = JSON.stringify(lhrga);

        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ntt.php",
                type : "post",
                data : {id : id, sup : sup, tgl : tgl, bb : bb, poto : poto, ket1 : ket1, ket2 : ket2, ket3 : ket3, lhrga : lhrga, trm : trm},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-tt-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-tt-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-tt-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-err-tt-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-err-tt-5").removeClass("d-none");
                    else
                    {
                        $("#mdl-ntt input").val("");
                        $("#mdl-ntt #lst-ntt").html("");
                        $("#dte-tgl").val(tgl);

                        $("#txt-id").focus().select();

                        $("#div-scs-tt-1").removeClass("d-none");

                        schTT($("#txt-srch-tt").val());
                        
                        setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Tanda terima berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-tanda-terima?id="+UE64(id), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);
                    }

                    $("#btn-sntt").prop("disabled", false);
                    $("#btn-sntt").html("Simpan");
                },
                error : function(){
                    $("#btn-sntt").prop("disabled", false);
                    $("#btn-sntt").html("Simpan");
                    swal("Error (NTT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updTT()
{
    var id = $("#edt-txt-id").val(), sup = $("#edt-txt-sup").val(), tgl = $("#edt-dte-tgl").val(), bb = UnNumberFormat($("#edt-txt-bb").val()), poto = UnNumberFormat($("#edt-txt-poto").val()), mpoto = UD64($("#edt-txt-poto").attr("data-value")), ket1 = $("#edt-txt-ket1").val(), ket2 = $("#edt-txt-ket2").val(), ket3 = $("#edt-txt-ket3").val(), trm = $("#edt-txt-trm").val(), bid = $("#edt-txt-bid").val();

    if(!$("#div-edt-err-tt-1").hasClass("d-none"))
        $("#div-edt-err-tt-1").addClass("d-none");

    if(!$("#div-edt-err-tt-2").hasClass("d-none"))
        $("#div-edt-err-tt-2").addClass("d-none");

    if(!$("#div-edt-err-tt-3").hasClass("d-none"))
        $("#div-edt-err-tt-3").addClass("d-none");

    if(!$("#div-edt-err-tt-4").hasClass("d-none"))
        $("#div-edt-err-tt-4").addClass("d-none");

    if(!$("#div-edt-err-tt-5").hasClass("d-none"))
        $("#div-edt-err-tt-5").addClass("d-none");

    if(!$("#div-edt-err-tt-6").hasClass("d-none"))
        $("#div-edt-err-tt-6").addClass("d-none");

    if(!$("#div-edt-scs-tt-1").hasClass("d-none"))
        $("#div-edt-scs-tt-1").addClass("d-none");

    ToTop();
    if(id === "" || sup === "" || tgl === "" || bb === "" || bb <= 0 || trm === "")
        $("#div-edt-err-tt-1").removeClass("d-none");
    else if(parseFloat(poto) > parseFloat(mpoto))
        $("#div-edt-err-tt-4").removeClass("d-none");
    else
    {
        $("#btn-sett").prop("disabled", true);
        $("#btn-sett").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        var lhrga = [], n = 0;

        for(var i = 0; i < $("#lst-ett tr").length; i++)
        {
            lhrga[n] = UnNumberFormat($("#edt-txt-hrga-"+i).val());

            n++;
        }

        lhrga = JSON.stringify(lhrga);

        setTimeout(function(){
            $.ajax({
                url : "./bin/php/utt.php",
                type : "post",
                data : {id : id, sup : sup, tgl : tgl, bb : bb, poto : poto, ket1 : ket1, ket2 : ket2, ket3 : ket3, lhrga : lhrga, trm : trm, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-tt-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-tt-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-tt-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-tt-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-tt-5").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -6)
                        $("#div-edt-err-tt-6").removeClass("d-none");
                    else
                    {
                        $("#mdl-ett input").val("");

                        $("#div-edt-scs-tt-1").removeClass("d-none");

                        schTT($("#txt-srch-tt").val());
                        
                        setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Tanda terima berhasil diubah, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-tanda-terima?id="+UE64(id), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);

                        $("#mdl-ett").modal("hide");
                    }

                    $("#btn-sett").prop("disabled", false);
                    $("#btn-sett").html("Simpan");
                },
                error : function(){
                    $("#btn-sett").prop("disabled", false);
                    $("#btn-sett").html("Simpan");
                    swal("Error (UTT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delTT(x)
{
    x = UD64(x);
    swal({
        title : "Perhatian !!!",
        text : "Anda hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dtt.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DTT - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
                        else
                        {
                            swal({
                                title : "Sukses !!!",
                                text : "Data berhasil dihapus !!!",
                                icon : "success",
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                            })
                            .then(ok => {
                                if(ok)
                                    schTT($("#txt-srch-tt").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DTT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function viewTT()
{
    var x = $("#txt-opt-tt").val();

    window.open("./lihat-tanda-terima?id="+UE64(x), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//PENARIKAN
function getNIDWd()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-wd-1").hasClass("d-none"))
            $("#div-err-wd-1").addClass("d-none");
            
        if(!$("#div-err-wd-2").hasClass("d-none"))
            $("#div-err-wd-2").addClass("d-none");
            
        if(!$("#div-err-wd-3").hasClass("d-none"))
            $("#div-err-wd-3").addClass("d-none");
            
        if(!$("#div-err-wd-4").hasClass("d-none"))
            $("#div-err-wd-4").addClass("d-none");
            
        if(!$("#div-scs-wd-1").hasClass("d-none"))
            $("#div-scs-wd-1").addClass("d-none");

        $("#mdl-nwd").modal("show");

        swal.close();
    }, 200);
}

function schWd(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/swd.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-wd").html(setToTblWd(json));

                swal.close();
            },
            error : function(){
                swal("Error (SWD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblWd(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"viewWd('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][3])+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eWd('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delWd('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewWd('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"More\" width=\"20\"></button></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"11\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function eWd(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-wd-1").hasClass("d-none"))
        $("#div-edt-err-wd-1").addClass("d-none");

    if(!$("#div-edt-err-wd-2").hasClass("d-none"))
        $("#div-edt-err-wd-2").addClass("d-none");

    if(!$("#div-edt-err-wd-3").hasClass("d-none"))
        $("#div-edt-err-wd-3").addClass("d-none");

    if(!$("#div-edt-err-wd-4").hasClass("d-none"))
        $("#div-edt-err-wd-4").addClass("d-none");

    if(!$("#div-edt-scs-wd-1").hasClass("d-none"))
        $("#div-edt-scs-wd-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtwd.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();

                if(!json.aks[0] && y === 1)
                {
                    swal({
                        title : "Perhatian !!!",
                        text : "Anda tidak memiliki akses ralat, klik tombol verifikasi dibawah untuk mendapatkan akses ralat.",
                        icon : "warning",
                        dangerMode : true,
                        buttons : {
                            cancel : "Batal",
                            verif : "Verifikasi",
                        },
                        closeOnClickOutside : false,
                        closeOnEsc : false,
                    })
                    .then(value => {
                        switch(value){
                            case "verif":
                                if(!$("#txt-vkode").prop("readonly"))
                                    $("#txt-vkode").prop("readonly", true);

                                $("#head-vkode").text("");
                                $("#mdl-vrf").modal({backdrop : "static", keyboard : false});
                                $("#mdl-vrf").modal("show");
                                $("#txt-vkode").attr("data-type", "WD");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setWdVerif(x);

                                gvwd = setInterval(getWdVerif, 1000);
                                break;

                            default: 
                                break;
                        }
                    })
                }
                else
                {
                    $("#edt-txt-id").val(json.data[0]);
                    $("#edt-txt-bid").val(json.data[0]);
                    $("#edt-txt-nma-sup").val(json.sup[1]);
                    $("#edt-txt-sup").val(json.data[1]);
                    $("#edt-dte-tgl").val(json.data[2]);
                    $("#edt-txt-jlh").val(NumberFormat2(json.data[3]));
                    $("#edt-txt-sjlh").val(NumberFormat2(json.ssmpn[0]));
                    $("#edt-txt-ket1").val(json.data[4]);
                    $("#edt-txt-ket2").val(json.data[5]);
                    $("#edt-txt-ket3").val(json.data[6]);

                    $("#mdl-ewd").modal("show");
                }
            },
            error : function(){
                swal("Error (EWD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlWd(x)
{
    x = UD64(x);

    $("#txt-opt-wd").val(x);

    $("#mdl-opt-wd").modal("show");
}

function getWdVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));

        $.ajax({
            url : "./bin/php/gdtwd.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[7] === "x")
                {
                    swal("Error (GWDVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")
                    
                    clearInterval(gvwd);
                }
                else if(json.data[7] !== "?" && json.data[7] !== "")
                {
                    $("#head-vkode").text(json.data[7]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[7]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvwd);
                }
            },
            error : function(){
                swal("Error (GWDVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setWdVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/swdvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SWDVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekWdVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eWd(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CWDVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function newWd()
{
    var id = $("#txt-id").val(), sup = $("#txt-sup").val(), tgl = $("#dte-tgl").val(), jlh = UnNumberFormat($("#txt-jlh").val()), ket1 = $("#txt-ket1").val(), ket2 = $("#txt-ket2").val(), ket3 = $("#txt-ket3").val();

    if(!$("#div-err-wd-1").hasClass("d-none"))
        $("#div-err-wd-1").addClass("d-none");

    if(!$("#div-err-wd-2").hasClass("d-none"))
        $("#div-err-wd-2").addClass("d-none");

    if(!$("#div-err-wd-3").hasClass("d-none"))
        $("#div-err-wd-3").addClass("d-none");

    if(!$("#div-err-wd-4").hasClass("d-none"))
        $("#div-err-wd-4").addClass("d-none");

    if(!$("#div-scs-wd-1").hasClass("d-none"))
        $("#div-scs-wd-1").addClass("d-none");

    if(sup === "" || tgl === "" || jlh === "" || jlh <= 0)
        $("#div-err-wd-1").removeClass("d-none");
    else
    {
        $("#btn-snwd").prop("disabled", true);
        $("#btn-snwd").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nwd.php",
                type : "post",
                data : {id : id, sup : sup, tgl : tgl, jlh : jlh, ket1 : ket1, ket2 : ket2, ket3 : ket3},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-wd-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-wd-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-wd-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-err-wd-4").removeClass("d-none");
                    else
                    {
                        $("#mdl-nwd input").val("");
                        $("#dte-tgl").val(tgl);

                        $("#txt-id").focus().select();

                        $("#div-scs-wd-1").removeClass("d-none");

                        schWd($("#txt-srch-wd").val());
                        
                        setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Penarikan berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-penarikan?id="+UE64(json.id[0]), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);
                    }

                    $("#btn-snwd").prop("disabled", false);
                    $("#btn-snwd").html("Simpan");
                },
                error : function(){
                    $("#btn-snwd").prop("disabled", false);
                    $("#btn-snwd").html("Simpan");
                    swal("Error (NWD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updWd()
{
    var id = $("#edt-txt-id").val(), sup = $("#edt-txt-sup").val(), tgl = $("#edt-dte-tgl").val(), jlh = UnNumberFormat($("#edt-txt-jlh").val()), ket1 = $("#edt-txt-ket1").val(), ket2 = $("#edt-txt-ket2").val(), ket3 = $("#edt-txt-ket3").val(), bid = $("#edt-txt-bid").val();

    if(!$("#div-edt-err-wd-1").hasClass("d-none"))
        $("#div-edt-err-wd-1").addClass("d-none");

    if(!$("#div-edt-err-wd-2").hasClass("d-none"))
        $("#div-edt-err-wd-2").addClass("d-none");

    if(!$("#div-edt-err-wd-3").hasClass("d-none"))
        $("#div-edt-err-wd-3").addClass("d-none");

    if(!$("#div-edt-err-wd-4").hasClass("d-none"))
        $("#div-edt-err-wd-4").addClass("d-none");

    if(!$("#div-edt-err-wd-5").hasClass("d-none"))
        $("#div-edt-err-wd-5").addClass("d-none");

    if(!$("#div-edt-scs-wd-1").hasClass("d-none"))
        $("#div-edt-scs-wd-1").addClass("d-none");

    if(id === "" || sup === "" || tgl === "" || jlh === "" || jlh <= 0)
        $("#div-edt-err-wd-1").removeClass("d-none");
    else
    {
        $("#btn-sewd").prop("disabled", true);
        $("#btn-sewd").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/uwd.php",
                type : "post",
                data : {id : id, sup : sup, tgl : tgl, jlh : jlh, ket1 : ket1, ket2 : ket2, ket3 : ket3, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-wd-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-wd-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-wd-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-wd-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-wd-5").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-wd-1").removeClass("d-none");

                        schWd($("#txt-srch-wd").val());

                        $("#mdl-ewd").modal("hide");
                        
                        setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Penarikan berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-penarikan?id="+UE64(id), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);
                    }

                    $("#btn-sewd").prop("disabled", false);
                    $("#btn-sewd").html("Simpan");
                },
                error : function(){
                    $("#btn-sewd").prop("disabled", false);
                    $("#btn-sewd").html("Simpan");
                    swal("Error (UWD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delWd(x)
{
    x = UD64(x);
    swal({
        title : "Perhatian !!!",
        text : "Anda hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dwd.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DWD - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
                        else
                        {
                            swal({
                                title : "Sukses !!!",
                                text : "Data berhasil dihapus !!!",
                                icon : "success",
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                            })
                            .then(ok => {
                                if(ok)
                                    schWd($("#txt-srch-wd").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DWD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function viewWd(x = "")
{
    if(x === "")
        x = $("#txt-opt-wd").val();
    else
        x = UD64(x);

    window.open("./lihat-penarikan?id="+UE64(x), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//BB
function getNIDBB()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-bb-1").hasClass("d-none"))
            $("#div-err-bb-1").addClass("d-none");
            
        if(!$("#div-scs-bb-1").hasClass("d-none"))
            $("#div-scs-bb-1").addClass("d-none");

        $("#mdl-nbb").modal("show");

        swal.close();
    }, 200);
}

function schBB(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sbb.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-bb").html(setToTblBB(json));

                swal.close();
            },
            error : function(){
                swal("Error (SBB) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblBB(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr ondblclick=\"viewBB('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][2])+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eBB('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delBB('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewBB('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"More\" width=\"20\"></button></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"8\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function eBB(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-bb-1").hasClass("d-none"))
        $("#div-edt-err-bb-1").addClass("d-none");

    if(!$("#div-edt-err-bb-2").hasClass("d-none"))
        $("#div-edt-err-bb-2").addClass("d-none");

    if(!$("#div-edt-scs-bb-1").hasClass("d-none"))
        $("#div-edt-scs-bb-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtbb.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();

                if(!json.aks[0] && y === 1)
                {
                    swal({
                        title : "Perhatian !!!",
                        text : "Anda tidak memiliki akses ralat, klik tombol verifikasi dibawah untuk mendapatkan akses ralat.",
                        icon : "warning",
                        dangerMode : true,
                        buttons : {
                            cancel : "Batal",
                            verif : "Verifikasi",
                        },
                        closeOnClickOutside : false,
                        closeOnEsc : false,
                    })
                    .then(value => {
                        switch(value){
                            case "verif":
                                if(!$("#txt-vkode").prop("readonly"))
                                    $("#txt-vkode").prop("readonly", true);

                                $("#head-vkode").text("");
                                $("#mdl-vrf").modal({backdrop : "static", keyboard : false});
                                $("#mdl-vrf").modal("show");
                                $("#txt-vkode").attr("data-type", "BB");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setBBVerif(x);

                                gvbb = setInterval(getBBVerif, 1000);
                                break;

                            default: 
                                break;
                        }
                    })
                }
                else
                {
                    $("#edt-txt-id").val(json.data[0]);
                    $("#edt-txt-bid").val(json.data[0]);
                    $("#edt-dte-tgl").val(json.data[1]);
                    $("#edt-txt-jlh").val(NumberFormat2(json.data[2]));
                    $("#edt-txt-ket").val(json.data[3]);
                    $("#edt-slct-jns").val(json.data[4]);

                    $("#mdl-ebb").modal("show");
                }
            },
            error : function(){
                swal("Error (EBB) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlBB(x)
{
    x = UD64(x);

    $("#txt-opt-bb").val(x);

    $("#mdl-opt-bb").modal("show");
}

function getBBVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));

        $.ajax({
            url : "./bin/php/gdtbb.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[7] === "x")
                {
                    swal("Error (GBBVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")
                    
                    clearInterval(gvbb);
                }
                else if(json.data[7] !== "?" && json.data[7] !== "")
                {
                    $("#head-vkode").text(json.data[7]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[7]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvbb);
                }
            },
            error : function(){
                swal("Error (GBBVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setBBVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sbbvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SBBVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekBBVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eBB(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CBBVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function newBB()
{
    var id = $("#txt-id").val(), tgl = $("#dte-tgl").val(), jlh = UnNumberFormat($("#txt-jlh").val()), ket = $("#txt-ket").val(), type = $("#slct-jns").val();

    if(!$("#div-err-bb-1").hasClass("d-none"))
        $("#div-err-bb-1").addClass("d-none");

    if(!$("#div-scs-bb-1").hasClass("d-none"))
        $("#div-scs-bb-1").addClass("d-none");

    if(tgl === "" || jlh === "" || jlh <= 0 || type === "")
        $("#div-err-bb-1").removeClass("d-none");
    else
    {
        $("#btn-snbb").prop("disabled", true);
        $("#btn-snbb").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nbb.php",
                type : "post",
                data : {id : id, tgl : tgl, jlh : jlh, ket : ket, type : type},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-bb-1").removeClass("d-none");
                    else
                    {
                        $("#mdl-nbb input").val("");
                        $("#dte-tgl").val(tgl);

                        $("#txt-id").focus().select();

                        $("#div-scs-bb-1").removeClass("d-none");

                        schBB($("#txt-srch-bb").val());
                        
                        /*setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Transaksi berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-bb?id="+UE64(json.id[0]), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);*/
                    }

                    $("#btn-snbb").prop("disabled", false);
                    $("#btn-snbb").html("Simpan");
                },
                error : function(){
                    $("#btn-snbb").prop("disabled", false);
                    $("#btn-snbb").html("Simpan");
                    swal("Error (NBB) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updBB()
{
    var id = $("#edt-txt-id").val(), tgl = $("#edt-dte-tgl").val(), jlh = UnNumberFormat($("#edt-txt-jlh").val()), ket = $("#edt-txt-ket").val(), type = $("#edt-slct-jns").val(), bid = $("#edt-txt-bid").val();

    if(!$("#div-edt-err-bb-1").hasClass("d-none"))
        $("#div-edt-err-bb-1").addClass("d-none");

    if(!$("#div-edt-err-bb-2").hasClass("d-none"))
        $("#div-edt-err-bb-2").addClass("d-none");

    if(!$("#div-edt-scs-bb-1").hasClass("d-none"))
        $("#div-edt-scs-bb-1").addClass("d-none");

    if(tgl === "" || jlh === "" || jlh <= 0 || type === "")
        $("#div-edt-err-bb-1").removeClass("d-none");
    else
    {
        $("#btn-sebb").prop("disabled", true);
        $("#btn-sebb").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ubb.php",
                type : "post",
                data : {id : id, tgl : tgl, jlh : jlh, ket : ket, type : type, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-bb-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-bb-2").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-bb-1").removeClass("d-none");

                        schBB($("#txt-srch-bb").val());

                        $("#mdl-ebb").modal("hide");
                        
                        /*setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Transaksi berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-bb?id="+UE64(id), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);*/
                    }

                    $("#btn-sebb").prop("disabled", false);
                    $("#btn-sebb").html("Simpan");
                },
                error : function(){
                    $("#btn-sebb").prop("disabled", false);
                    $("#btn-sebb").html("Simpan");
                    swal("Error (UBB) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delBB(x)
{
    x = UD64(x);
    swal({
        title : "Perhatian !!!",
        text : "Anda hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dbb.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);
                        
                        swal({
                            title : "Sukses !!!",
                            text : "Transaksi berhasil dihapus !!!",
                            icon : "success",
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        })
                        .then(ok => {
                            if(ok)
                                schBB($("#txt-srch-bb").val());
                        });
                    },
                    error : function(){
                        swal("Error (DBB) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function viewBB(x = "")
{
    if(x === "")
        x = $("#txt-opt-bb").val();
    else
        x = UD64(x);

    window.open("./lihat-bb?id="+UE64(x), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//PENYESUAIAN STOK
function getNIDPs()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-ps-1").hasClass("d-none"))
            $("#div-err-ps-1").addClass("d-none");

        if(!$("#div-scs-ps-1").hasClass("d-none"))
            $("#div-scs-ps-1").addClass("d-none");

        $("#btn-snps").prop("disabled", false);
        $("#btn-snps").html("Simpan");

        $("#mdl-nps").modal("show");

        swal.close();
    }, 200);
}

function schPs(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sps.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-ps").html(setToTblPs(json));

                swal.close();
            },
            error : function(){
                swal("Error (SPS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblPs(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var dtl = "";
            for(var j = 0; j < x.data2[i].length; j++)
            {
                dtl += "<li>"+x.data2[i][j][0];
                
                if(x.data2[i][j][1] !== "" && x.data2[i][j][1] !== null)
                    dtl += " / "+x.data2[i][j][1];
                
                if(x.data2[i][j][2] !== "" && x.data2[i][j][2] !== null)
                    dtl += " / "+x.data2[i][j][2];
                
                if(x.data2[i][j][3] !== "" && x.data2[i][j][3] !== null)
                    dtl += " / "+x.data2[i][j][3];
                    
                dtl += " ("+NumberFormat2(x.data2[i][j][4])+")";

                if(x.data2[i][j][5] !== "" && x.data2[i][j][5] !== null)
                    dtl += " "+x.data2[i][j][5];

                dtl += "</li>";
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border d-none\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat(x.data[i][3])+"</td>"+
                        "<td class=\"border small\"><ul>"+dtl+"</ul></td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"ePs('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delPs('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewPs('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"Lihat Penyesuaian Produk\" width=\"18\"></button></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                "<td colspan=\"13\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
            "</tr>";

    return hsl;
}

function ePs(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-ps-1").hasClass("d-none"))
        $("#div-edt-err-ps-1").addClass("d-none");

    if(!$("#div-edt-err-ps-2").hasClass("d-none"))
        $("#div-edt-err-ps-2").addClass("d-none");

    if(!$("#div-edt-err-ps-3").hasClass("d-none"))
        $("#div-edt-err-ps-3").addClass("d-none");

    if(!$("#div-edt-err-ps-4").hasClass("d-none"))
        $("#div-edt-err-ps-4").addClass("d-none");

    if(!$("#div-edt-scs-ps-1").hasClass("d-none"))
        $("#div-edt-scs-ps-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtps.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();

                if(!json.aks[0] && y === 1)
                {
                    swal({
                        title : "Perhatian !!!",
                        text : "Anda tidak memiliki akses ralat, klik tombol verifikasi dibawah untuk mendapatkan akses ralat.",
                        icon : "warning",
                        dangerMode : true,
                        buttons : {
                            cancel : "Batal",
                            verif : "Verifikasi",
                        },
                        closeOnClickOutside : false,
                        closeOnEsc : false,
                    })
                    .then(value => {
                        switch(value){
                            case "verif":
                                if(!$("#txt-vkode").prop("readonly"))
                                    $("#txt-vkode").prop("readonly", true);

                                $("#head-vkode").text("");
                                $("#mdl-vrf").modal({backdrop : "static", keyboard : false});
                                $("#mdl-vrf").modal("show");
                                $("#txt-vkode").attr("data-type", "Ps");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setPsVerif(x);

                                gvps = setInterval(getPsVerif, 1000);
                                break;

                            default: 
                                break;
                        }
                    })
                }
                else
                {
                    $("#edt-dte-tgl").val(json.data[1]);
                    $("#edt-txt-id").val(json.data[0]);
                    $("#edt-slct-gdg").val(json.data[7]);

                    $(".table-data2").DataTable().clear().destroy();

                    $("#lst-eps").html(setToTblEPs(json));

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $(".dataTables_scrollHeadInner").addClass("w-100");

                    $(".table").css("width", "100%");

                    $("#btn-seps").attr("data-count", json.count[1]);

                    $("#btn-seps").prop("disabled", false);
                    $("#btn-seps").html("Simpan");

                    $("#mdl-eps").modal("show");
                }
            },
            error : function(){
                swal("Error (EPS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblEPs(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[1]; i++)
    {
        hsl += "<tr id=\"lst-ps-pro-"+i+"\">"+
                    "<td class=\"border\">"+x.data3[i][0]+"</td>"+
                    "<td class=\"border\">"+x.data3[i][1]+"</td>"+
                    "<td class=\"border\">"+x.data3[i][2]+"</td>"+
                    "<td class=\"border\">"+x.data3[i][3]+"</td>"+
                    "<td class=\"border\"><input type=\"number\" step=\"any\" class=\"form-control\" id=\"txt-weight-"+i+"\" value=\""+x.data3[i][4]+"\" data-pro=\""+UE64(x.data3[i][6])+"\" data-urut=\""+UE64(x.data3[i][7])+"\"></td>"+
                    "<td class=\"border\"><input type=\"text\" maxlength=\"100\" class=\"form-control\" id=\"txt-ket-"+i+"\" value=\""+x.data3[i][5]+"\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delPsPro('"+i+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function getPsVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));
        $.ajax({
            url : "./bin/php/gdtps.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[5] === "x")
                {
                    swal("Error (GPSVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")
                    
                    clearInterval(gvps);
                }
                else if(json.data[5] !== "?" && json.data[5] !== "")
                {
                    $("#head-vkode").text(json.data[5]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[5]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvps);
                }
            },
            error : function(){
                swal("Error (GPSVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setPsVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/spsvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SPSVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekPsVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        ePs(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CPSVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function newDtlPs()
{
    var tgl = $("#dte-tgl").val(), pro = $("#txt-pro2").val(), brt = $("#txt-weight").val(), ket = $("#txt-ket").val(), ket2 = $("#txt-ket-pro").val();

    if(!$("#div-err-ps-1").hasClass("d-none"))
        $("#div-err-ps-1").addClass("d-none");

    if(!$("#div-scs-ps-1").hasClass("d-none"))
        $("#div-scs-ps-1").addClass("d-none");

    if(tgl === "" || pro === "" || brt === "")
        $("#div-err-ps-1").removeClass("d-none");
    else
    {
        $("#btn-snps").prop("disabled", true);
        $("#btn-snps").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ndps.php",
                type : "post",
                data : {tgl : tgl, pro : pro, brt : brt, ket : ket, ket2 : ket2},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-ps-1").removeClass("d-none");
                    else
                    {
                        $("#div-scs-ps-1").removeClass("d-none");

                        $("#mdl-nps input").val("");
                        $("#dte-tgl").val(tgl);

                        schPs($("#txt-srch-ps").val());
                    }

                    $("#btn-snps").prop("disabled", false);
                    $("#btn-snps").html("Simpan");
                },
                error : function(){
                    $("#btn-snps").prop("disabled", false);
                    $("#btn-snps").html("Simpan");
                    swal("Error (NDPS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDtlEPs()
{
    var pro = $("#edt-txt-pro2").val(), npsro = $("#edt-txt-nma-pro2").val(), kate = $("#edt-txt-nma-kate2").val(), skate = $("#edt-txt-nma-skate2").val(), weight = UnNumberFormat($("#edt-txt-weight").val()), n = parseInt($("#btn-seps").attr("data-count")), grade = $("#edt-txt-nma-grade2").val(), ket = $("#edt-txt-ket-pro").val();

    if(!$("#div-err-ps-pro-1").hasClass("d-none"))
        $("#div-err-ps-pro-1").addClass("d-none");

    if(!$("#div-scs-ps-pro-1").hasClass("d-none"))
        $("#div-scs-ps-pro-1").addClass("d-none");

    if(pro === "" || weight === "")
        $("#div-err-ps-pro-1").removeClass("d-none");
    else
    {
        $("#btn-seps-pro").prop("disabled", true);
        $("#btn-seps-pro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        $(".table-data2").DataTable().destroy();

        $("#lst-eps").append(setToTblEPsPro(pro, npsro, kate, skate, weight, grade, ket));

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });

        $(".dataTables_scrollHeadInner").addClass("w-100");

        $(".table").css("width", "100%");

        $("#btn-seps").attr("data-count", n + 1);
        
        $("#div-scs-ps-pro-1").removeClass("d-none");

        $("#mdl-npro-ps input").val("");

        $("#btn-seps-pro").prop("disabled", false);
        $("#btn-seps-pro").html("Simpan");
    }
}

function setToTblEPsPro(pro, npsro, kate, skate, weight, grade, ket)
{
    var n = $("#btn-seps").attr("data-count");

    return "<tr id=\"lst-ps-pro-"+n+"\">"+
                "<td class=\"border\">"+npsro+"</td>"+
                "<td class=\"border\">"+grade+"</td>"+
                "<td class=\"border\">"+kate+"</td>"+
                "<td class=\"border\">"+skate+"</td>"+
                "<td class=\"border\"><input type=\"number\" step=\"any\" class=\"form-control\" id=\"txt-weight-"+n+"\" value=\""+weight+"\" data-pro=\""+UE64(pro)+"\" data-urut=\""+UE64(0)+"\"></td>"+
                "<td class=\"border\"><input type=\"text\" step=\"any\" class=\"form-control\" id=\"txt-ket-pro-"+n+"\" value=\""+ket+"\"></td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delPsPro('"+n+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>";
}

function updPs()
{
    var tgl = $("#edt-dte-tgl").val(), id = $("#edt-txt-id").val(), lpro = [], n = 0, ket = $("#edt-txt-ket").val(), gdg = $("#edt-slct-gdg").val();

    $(".table-data2").DataTable().destroy();

    for(var i = 0; i < parseInt($("#btn-seps").attr("data-count")); i++)
    {
        if($("#txt-weight-"+i).length === 0)
            continue;

        lpro[n] = [UD64($("#txt-weight-"+i).attr("data-pro")), $("#txt-weight-"+i).val(), UD64($("#txt-weight-"+i).attr("data-urut")), $("#txt-ket-"+i).val()];
        
        n++;
    }

    lpro = JSON.stringify(lpro);

    if(!$("#div-edt-err-ps-1").hasClass("d-none"))
        $("#div-edt-err-ps-1").addClass("d-none");

    if(!$("#div-edt-err-ps-2").hasClass("d-none"))
        $("#div-edt-err-ps-2").addClass("d-none");

    if(!$("#div-edt-err-ps-3").hasClass("d-none"))
        $("#div-edt-err-ps-3").addClass("d-none");

    if(!$("#div-edt-err-ps-4").hasClass("d-none"))
        $("#div-edt-err-ps-4").addClass("d-none");

    if(!$("#div-edt-scs-ps-1").hasClass("d-none"))
        $("#div-edt-scs-ps-1").addClass("d-none");

    ToTop();
    if(tgl === "" || gdg === "")
        $("#div-edt-err-ps-1").removeClass("d-none");
    else if(lpro.length === 0)
        $("#div-edt-err-ps-2").removeClass("d-none");
    else
    {
        $("#btn-seps").prop("disabled", true);
        $("#btn-seps").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ups.php",
                type : "post",
                data : {id : id, tgl : tgl, lpro : lpro, ket : ket, gdg : gdg},
                success : function(output){
                    var json = $.parseJSON(output);

                    swal.close();

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-ps-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-ps-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-ps-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-ps-4").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-ps-1").removeClass("d-none");

                        schPs($("#txt-srch-ps").val());

                        $("#mdl-eps").modal("hide");
                    }

                    $("#btn-seps").prop("disabled", false);
                    $("#btn-seps").html("Simpan");
                },
                error : function(){
                    $("#btn-seps").prop("disabled", false);
                    $("#btn-seps").html("Simpan");
                    swal("Error (UPS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delPs(x)
{
    x = UD64(x);

    swal({
        title : "Perhatian !!!",
        text : "Yakin hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dps.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DPs - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
                        else
                        {
                            swal({
                                title : "Sukses !!!",
                                text : "Data berhasil dihapus !!!",
                                icon : "success",
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                            })
                            .then(ok => {
                                if(ok)
                                    schPs($("#txt-srch-ps").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DPS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delPsPro(x)
{
    swal({
        title : "Perhatian !!!",
        text : "Yakin hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            $(".table-data2").DataTable().destroy();

            $("#lst-ps-pro-"+x).remove();
    
            $(".table-data2").DataTable({
                dom: 'frt',
                scrollY: '42vh',
                scrollX: true,
                paging: false,
                autoWidth: false,
            });

            $(".dataTables_scrollHeadInner").addClass("w-100");

            $(".table").css("width", "100%");
        }
    })
}

function viewPs(x){
    x = UD64(x);

    window.open("./lihat-penyesuaian-stok?id="+UE64(x), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//PINDAH LOKASI
function getNIDMove(){
    Process();
    setTimeout(function(){
        if(!$("#div-err-mv-1").hasClass("d-none"))
            $("#div-err-mv-1").addClass("d-none");
            
        if(!$("#div-err-mv-2").hasClass("d-none"))
            $("#div-err-mv-2").addClass("d-none");
            
        if(!$("#div-err-mv-3").hasClass("d-none"))
            $("#div-err-mv-3").addClass("d-none");
            
        if(!$("#div-err-mv-4").hasClass("d-none"))
            $("#div-err-mv-4").addClass("d-none");
            
        if(!$("#div-err-mv-5").hasClass("d-none"))
            $("#div-err-mv-5").addClass("d-none");
            
        if(!$("#div-err-mv-6").hasClass("d-none"))
            $("#div-err-mv-6").addClass("d-none");
            
        if(!$("#div-err-mv-7").hasClass("d-none"))
            $("#div-err-mv-7").addClass("d-none");
            
        if(!$("#div-scs-mv-1").hasClass("d-none"))
            $("#div-scs-mv-1").addClass("d-none");

        $("#mdl-nmv").modal("show");

        swal.close();
    }, 200);
}

function schMove(x){
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/smv.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-mv").html(setToTblMove(json));

                swal.close();
            },
            error : function(){
                swal("Error (SPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblMove(x){
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr ondblclick=\"viewMove('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][10]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border text-right\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eMove('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delMove('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewMove('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"More\" width=\"20\"></button>";
            
            if(x.data[i][8] === "" || x.data[i][8] === null)
                hsl += " <button class=\"btn btn-light border-success mb-1 p-1\" onclick=\"setTTMove('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/check.png\" alt=\"Check\" width=\"18\"></button>";

            hsl += "</td></tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"12\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function eMove(x){
    x = UD64(x);

    if(!$("#div-edt-err-mv-1").hasClass("d-none"))
        $("#div-edt-err-mv-1").addClass("d-none");

    if(!$("#div-edt-err-mv-2").hasClass("d-none"))
        $("#div-edt-err-mv-2").addClass("d-none");

    if(!$("#div-edt-err-mv-3").hasClass("d-none"))
        $("#div-edt-err-mv-3").addClass("d-none");

    if(!$("#div-edt-err-mv-4").hasClass("d-none"))
        $("#div-edt-err-mv-4").addClass("d-none");

    if(!$("#div-edt-err-mv-5").hasClass("d-none"))
        $("#div-edt-err-mv-5").addClass("d-none");

    if(!$("#div-edt-err-mv-6").hasClass("d-none"))
        $("#div-edt-err-mv-6").addClass("d-none");

    if(!$("#div-edt-err-mv-7").hasClass("d-none"))
        $("#div-edt-err-mv-7").addClass("d-none");

    if(!$("#div-edt-err-mv-8").hasClass("d-none"))
        $("#div-edt-err-mv-8").addClass("d-none");

    if(!$("#div-edt-scs-mv-1").hasClass("d-none"))
        $("#div-edt-scs-mv-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtmv.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();

                if(!json.aks[0] && y === 1)
                {
                    swal({
                        title : "Perhatian !!!",
                        text : "Anda tidak memiliki akses ralat, klik tombol verifikasi dibawah untuk mendapatkan akses ralat.",
                        icon : "warning",
                        dangerMode : true,
                        buttons : {
                            cancel : "Batal",
                            verif : "Verifikasi",
                        },
                        closeOnClickOutside : false,
                        closeOnEsc : false,
                    })
                    .then(value => {
                        switch(value){
                            case "verif":
                                if(!$("#txt-vkode").prop("readonly"))
                                    $("#txt-vkode").prop("readonly", true);

                                $("#head-vkode").text("");
                                $("#mdl-vrf").modal({backdrop : "static", keyboard : false});
                                $("#mdl-vrf").modal("show");
                                $("#txt-vkode").attr("data-type", "PJM");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setMoveVerif(x);

                                gvmv = setInterval(getMoveVerif, 1000);
                                break;

                            default: 
                                break;
                        }
                    })
                }
                else
                {
                    $("#edt-txt-id").val(json.data[0]);
                    $("#edt-txt-bid").val(json.data[0]);
                    $("#edt-slct-gdgf").val(json.data[1]);
                    $("#edt-slct-gdgt").val(json.data[2]);
                    $("#edt-dte-tgl").val(json.data[3]);
                    $("#edt-slct-tipe").val(json.data[4]);
                    $("#edt-txt-ket").val(json.data[5]);
                    $("#edt-txt-ntt").val(json.data[10]);
                    $("#edt-txt-to").val(json.data[14]);
                    
                    $("#lst-emv").html(setToTblEMove(json));

                    for(var i = 0; i < json.count[0]; i++){
                        $("#edt-slct-sat-"+i).val(json.dtl[i][10]);
                    }

                    $("#btn-semv").attr("data-count", json.count[0]);

                    $("#mdl-emv").modal("show");
                }
            },
            error : function(){
                swal("Error (EPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setMoveVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/smvvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SMVVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekMoveVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eMove(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CMVVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function setToTblEMove(x){
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++){
        var nma = x.dtl[i][5]+" / "+x.dtl[i][6];

        if(x.dtl[i][7] !== ""){
            nma += " / "+x.dtl[i][7];
        }

        if(x.dtl[i][8] !== ""){
            nma += " / "+x.dtl[i][8];
        }

        hsl += "<tr id=\"row-emv-pro-"+i+"\">"+
                    "<td class=\"border\">"+
                        "<div class=\"input-group\">"+
                            "<input class=\"form-control\" type=\"text\" id=\"edt-txt-nma-pro3-"+i+"\" value=\""+nma+"\" readonly>"+
                            "<input class=\"form-control d-none\" type=\"text\" id=\"edt-txt-pro3-"+i+"\" value=\""+x.dtl[i][1]+"\" readonly>"+
                            "<div class=\"input-group-append\">"+
                                "<button class=\"btn btn-light border btn-spro3\" type=\"button\" data-toggle=\"modal\" data-backdrop=\"static\" data-keyboard=\"false\" data-target=\"#mdl-spro5\" data-value=\""+i+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\"></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<input class=\"form-control text-right\" type=\"number\" id=\"edt-nmbr-qty-"+i+"\" value=\""+x.dtl[i][9]+"\">"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<select id=\"edt-slct-sat-"+i+"\" class=\"custom-select\">"+
                            "<option value=\"BOX\">BOX</option>"+
                            "<option value=\"BAG\">BAG</option>"+
                            "<option value=\"PCS\">PCS</option>"+
                            "<option value=\"EKOR\">EKOR</option>"+
                        "</select>"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<input class=\"form-control text-right\" type=\"number\" id=\"edt-nmbr-weight-"+i+"\" value=\""+x.dtl[i][2]+"\">"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<input class=\"form-control\" type=\"text\" id=\"edt-txt-ket-"+i+"\" value=\""+x.dtl[i][3]+"\" maxlength=\"100\">"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<input class=\"form-control\" type=\"date\" id=\"edt-dte-tgl-"+i+"\" value=\""+x.dtl[i][11]+"\">"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delDtlMove('"+UE64(i)+"', 'E')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>"+
                    "</td>"+
                "</tr>";
    }

    return hsl;
}

function addDtlMove(){
    if($("#mdl-nmv").hasClass("show")){
        var count = $("#btn-snmv").attr("data-count");

        $("#lst-nmv").append(
            "<tr id=\"row-nmv-pro-"+count+"\">"+
                "<td class=\"border\">"+
                    "<div class=\"input-group\">"+
                        "<input class=\"form-control\" type=\"text\" id=\"txt-nma-pro3-"+count+"\" value=\"\" readonly>"+
                        "<input class=\"form-control d-none\" type=\"text\" id=\"txt-pro3-"+count+"\" value=\"\" readonly>"+
                        "<div class=\"input-group-append\">"+
                            "<button class=\"btn btn-light border btn-spro3\" type=\"button\" data-toggle=\"modal\" data-backdrop=\"static\" data-keyboard=\"false\" data-target=\"#mdl-spro5\" data-value=\""+count+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\"></button>"+
                        "</div>"+
                    "</div>"+
                "</td>"+
                "<td class=\"border\">"+
                    "<input class=\"form-control text-right\" type=\"number\" id=\"nmbr-qty-"+count+"\" value=\"\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<select id=\"slct-sat-"+count+"\" class=\"custom-select\">"+
                        "<option value=\"BOX\">BOX</option>"+
                        "<option value=\"BAG\">BAG</option>"+
                        "<option value=\"PCS\">PCS</option>"+
                        "<option value=\"EKOR\">EKOR</option>"+
                    "</select>"+
                "</td>"+
                "<td class=\"border\">"+
                    "<input class=\"form-control text-right\" type=\"number\" id=\"nmbr-weight-"+count+"\" value=\"\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<input class=\"form-control\" type=\"text\" id=\"txt-ket-"+count+"\" value=\"\" maxlength=\"100\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<input class=\"form-control\" type=\"date\" id=\"dte-tgl-"+count+"\" value=\"\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delDtlMove('"+UE64(count)+"', 'N')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>"+
                "</td>"+
            "</tr>"
        )

        $("#btn-snmv").attr("data-count", parseInt(count)+1);
    }
    else if($("#mdl-emv").hasClass("show")){
        var count = $("#btn-semv").attr("data-count");

        $("#lst-emv").append(
            "<tr id=\"row-emv-pro-"+count+"\">"+
                "<td class=\"border\">"+
                    "<div class=\"input-group\">"+
                        "<input class=\"form-control\" type=\"text\" id=\"edt-txt-nma-pro3-"+count+"\" value=\"\" readonly>"+
                        "<input class=\"form-control d-none\" type=\"text\" id=\"edt-txt-pro3-"+count+"\" value=\"\" readonly>"+
                        "<div class=\"input-group-append\">"+
                            "<button class=\"btn btn-light border btn-spro3\" type=\"button\" data-toggle=\"modal\" data-backdrop=\"static\" data-keyboard=\"false\" data-target=\"#mdl-spro5\" data-value=\""+count+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\"></button>"+
                        "</div>"+
                    "</div>"+
                "</td>"+
                "<td class=\"border\">"+
                    "<input class=\"form-control text-right\" type=\"number\" id=\"edt-nmbr-qty-"+count+"\" value=\"\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<select id=\"edt-slct-sat-"+count+"\" class=\"custom-select\">"+
                        "<option value=\"BOX\">BOX</option>"+
                        "<option value=\"BAG\">BAG</option>"+
                        "<option value=\"PCS\">PCS</option>"+
                        "<option value=\"EKOR\">EKOR</option>"+
                    "</select>"+
                "</td>"+
                "<td class=\"border\">"+
                    "<input class=\"form-control text-right\" type=\"number\" id=\"edt-nmbr-weight-"+count+"\" value=\"\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<input class=\"form-control\" type=\"text\" id=\"edt-txt-ket-"+count+"\" value=\"\" maxlength=\"100\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<input class=\"form-control\" type=\"date\" id=\"edt-dte-tgl-"+count+"\" value=\"\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delDtlMove('"+UE64(count)+"', 'E')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>"+
                "</td>"+
            "</tr>"
        )

        $("#btn-semv").attr("data-count", parseInt(count)+1);
    }
}

function setTTMove(x){
    $("#txt-id-ttmv").val(UD64(x));
    $("#mdl-uttmv").modal("show");
}

function newMove(){
    var tgl = $("#dte-tgl").val(), ket = $("#txt-ket").val(), gdgf = $("#slct-gdgf").val(), gdgt = $("#slct-gdgt").val(), tipe = $("#slct-tipe").val(), lpro = [], kpd = $("#txt-to").val();

    for(var i = 0; i < parseInt($("#btn-snmv").attr("data-count")); i++){
        if($("#txt-pro3-"+i).length > 0){
            if($("#nmbr-qty-"+i).hasClass("bg-danger"))
                $("#nmbr-qty-"+i).removeClass("bg-danger").removeClass("text-white");
            if($("#nmbr-weight-"+i).hasClass("bg-danger"))
                $("#nmbr-weight-"+i).removeClass("bg-danger").removeClass("text-white");

            lpro.push([$("#txt-pro3-"+i).val(), $("#nmbr-qty-"+i).val(), $("#txt-ket-"+i).val(), $("#nmbr-weight-"+i).val(), $("#slct-sat-"+i).val(), $("#dte-tgl-"+i).val(), i]);
        }
    }

    if(!$("#div-err-mv-1").hasClass("d-none"))
        $("#div-err-mv-1").addClass("d-none");

    if(!$("#div-err-mv-2").hasClass("d-none"))
        $("#div-err-mv-2").addClass("d-none");
        
    if(!$("#div-err-mv-3").hasClass("d-none"))
        $("#div-err-mv-3").addClass("d-none");
        
    if(!$("#div-err-mv-4").hasClass("d-none"))
        $("#div-err-mv-4").addClass("d-none");
        
    if(!$("#div-err-mv-5").hasClass("d-none"))
        $("#div-err-mv-5").addClass("d-none");
        
    if(!$("#div-err-mv-6").hasClass("d-none"))
        $("#div-err-mv-6").addClass("d-none");
        
    if(!$("#div-err-mv-7").hasClass("d-none"))
        $("#div-err-mv-7").addClass("d-none");
    
    if(!$("#div-err-mv-8").hasClass("d-none"))
        $("#div-err-mv-8").addClass("d-none");
        
    if(!$("#div-scs-mv-1").hasClass("d-none"))
        $("#div-scs-mv-1").addClass("d-none");

    if(tgl === "" || gdgf === "" || gdgt === "" || tipe === "" || kpd === ""){
        $("#div-err-mv-1").removeClass("d-none");
    }
    else if(lpro.length === 0){
        $("#div-err-mv-5").removeClass("d-none");
    }
    else{
        lpro = JSON.stringify(lpro);

        $("#btn-snmv").prop("disabled", true);
        $("#btn-snmv").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nmv.php",
                type : "post",
                data : {tgl : tgl, ket : ket, gdgf : gdgf, gdgt : gdgt, tipe : tipe, lpro : lpro, kpd : kpd},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1){
                        $("#div-err-mv-1").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -2){
                        $("#div-err-mv-2").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -3){
                        $("#div-err-mv-3").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -4){
                        $("#div-err-mv-4").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -5){
                        $("#div-err-mv-5").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -6){
                        $("#div-err-mv-6").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -7){
                        $("#div-err-mv-7").removeClass("d-none");
                        for(var i = 0; i < json.err2.length; i++){
                            $("#nmbr-qty-"+json.err2[i]).addClass("bg-danger text-white");
                        }
                    }
                    else if(parseInt(json.err[0]) === -8){
                        $("#div-err-mv-8").removeClass("d-none");
                        for(var i = 0; i < json.err2.length; i++){
                            $("#nmbr-weight-"+json.err2[i]).addClass("bg-danger text-white");
                        }
                    }
                    else{
                        $("#mdl-nmv input").val("");
                        $("#lst-nmv").html("");
                        $("#btn-snmv").attr("data-count", 0);
                        $("#dte-tgl").val(tgl);

                        $("#div-scs-mv-1").removeClass("d-none");
                        schMove($("#txt-srch-mv").val());
                    }

                    $("#btn-snmv").prop("disabled", false);
                    $("#btn-snmv").html("Simpan");
                },
                error : function(){
                    $("#btn-snmv").prop("disabled", false);
                    $("#btn-snmv").html("Simpan");
                    swal("Error (NMV) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                }
            })
        }, 200);
    }
}

function updMove(){
    var bid = $("#edt-txt-bid").val(), tgl = $("#edt-dte-tgl").val(), ket = $("#edt-txt-ket").val(), gdgf = $("#edt-slct-gdgf").val(), gdgt = $("#edt-slct-gdgt").val(), tipe = $("#edt-slct-tipe").val(), lpro = [], ntt = $("#edt-txt-ntt").val(), kpd = $("#edt-txt-to").val();

    for(var i = 0; i < parseInt($("#btn-semv").attr("data-count")); i++){
        if($("#edt-txt-pro3-"+i).length > 0)
            if($("#edt-nmbr-qty-"+i).hasClass("bg-danger"))
                $("#edt-nmbr-qty-"+i).removeClass("bg-danger").removeClass("text-white");
            if($("#edt-nmbr-weight-"+i).hasClass("bg-danger"))
                $("#edt-nmbr-weight-"+i).removeClass("bg-danger").removeClass("text-white");
            lpro.push([$("#edt-txt-pro3-"+i).val(), $("#edt-nmbr-qty-"+i).val(), $("#edt-txt-ket-"+i).val(), $("#edt-nmbr-weight-"+i).val(), $("#edt-slct-sat-"+i).val(), $("#edt-dte-tgl-"+i).val(), i]);
    }

    if(!$("#div-edt-err-mv-1").hasClass("d-none"))
        $("#div-edt-err-mv-1").addClass("d-none");

    if(!$("#div-edt-err-mv-2").hasClass("d-none"))
        $("#div-edt-err-mv-2").addClass("d-none");
        
    if(!$("#div-edt-err-mv-3").hasClass("d-none"))
        $("#div-edt-err-mv-3").addClass("d-none");
        
    if(!$("#div-edt-err-mv-4").hasClass("d-none"))
        $("#div-edt-err-mv-4").addClass("d-none");
        
    if(!$("#div-edt-err-mv-5").hasClass("d-none"))
        $("#div-edt-err-mv-5").addClass("d-none");
        
    if(!$("#div-edt-err-mv-6").hasClass("d-none"))
        $("#div-edt-err-mv-6").addClass("d-none");
        
    if(!$("#div-edt-err-mv-7").hasClass("d-none"))
        $("#div-edt-err-mv-7").addClass("d-none");
    
    if(!$("#div-edt-err-mv-8").hasClass("d-none"))
        $("#div-edt-err-mv-8").addClass("d-none");
    
    if(!$("#div-edt-err-mv-9").hasClass("d-none"))
        $("#div-edt-err-mv-9").addClass("d-none");
        
    if(!$("#div-edt-scs-mv-1").hasClass("d-none"))
        $("#div-edt-scs-mv-1").addClass("d-none");

    if(tgl === "" || gdgf === "" || gdgt === "" || tipe === "" || kpd === ""){
        $("#div-edt-err-mv-1").removeClass("d-none");
    }
    else if(lpro.length === 0){
        $("#div-edt-err-mv-5").removeClass("d-none");
    }
    else{
        lpro = JSON.stringify(lpro);

        $("#btn-semv").prop("disabled", true);
        $("#btn-semv").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/umv.php",
                type : "post",
                data : {tgl : tgl, ket : ket, gdgf : gdgf, gdgt : gdgt, tipe : tipe, lpro : lpro, bid : bid, ntt : ntt, kpd : kpd},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1){
                        $("#div-edt-err-mv-1").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -2){
                        $("#div-edt-err-mv-2").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -3){
                        $("#div-edt-err-mv-3").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -4){
                        $("#div-edt-err-mv-4").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -5){
                        $("#div-edt-err-mv-5").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -6){
                        $("#div-edt-err-mv-6").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -7){
                        $("#div-edt-err-mv-7").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -8){
                        $("#div-edt-err-mv-8").removeClass("d-none");
                        for(var i = 0; i < json.err2.length; i++){
                            $("#edt-nmbr-qty-"+json.err2[i]).addClass("bg-danger text-white");
                        }
                    }
                    else if(parseInt(json.err[0]) === -9){
                        $("#div-edt-err-mv-9").removeClass("d-none");
                        for(var i = 0; i < json.err3.length; i++){
                            $("#edt-nmbr-weight-"+json.err3[i]).addClass("bg-danger text-white");
                        }
                    }
                    else{
                        $("#div-edt-scs-mv-1").removeClass("d-none");
                        $("#mdl-emv").modal("hide");
                        schMove($("#txt-srch-mv").val());
                    }

                    $("#btn-semv").prop("disabled", false);
                    $("#btn-semv").html("Simpan");
                },
                error : function(){
                    $("#btn-semv").prop("disabled", false);
                    $("#btn-semv").html("Simpan");
                    swal("Error (UMV) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                }
            })
        }, 200);
    }
}

function updTTMove(){
    var id = $("#txt-id-ttmv").val(), ntt = $("#txt-ttmv").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/uttmv.php",
            type : "post",
            data : {id : id, ntt : ntt},
            success : function(output){
                var json = $.parseJSON(output);

                swal({
                    title : "Sukses !!!",
                    text : "Data berhasil di update",
                    icon : "success",
                    closeOnEsc : false,
                    closeOnClickOutside : false,
                })
                .then((ok) => {
                    if(ok){
                        $("#mdl-uttmv").modal("hide");
                        schMove($("#txt-srch-mv").val());
                    }
                });
            },
            error : function(){
                swal("Error (UTTMV) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function delMove(x){
    x = UD64(x);

    swal({
        title : "Perhatian !!!",
        icon : "warning",
        text : "Anda yakin hapus data ?",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) => {
        if(ok){
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dmv.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DMV - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
                        else
                        {
                            swal({
                                title : "Sukses !!!",
                                text : "Data berhasil dihapus !!!",
                                icon : "success",
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                            })
                            .then(ok => {
                                if(ok)
                                    schMove($("#txt-srch-mv").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DMV) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delDtlMove(x, y){
    x = UD64(x);

    swal({
        title : "Perhatian !!!",
        icon : "warning",
        text : "Anda yakin hapus data ?",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) =>{
        if(ok){
            if(y === 'N'){
                $("#row-nmv-pro-"+x).remove();
            }
            else if(y === 'E'){
                $("#row-emv-pro-"+x).remove();
            }
        }
    })
}

function viewMove(x = "")
{
    if(x === "")
        x = $("#txt-opt-mv").val();
    else
        x = UD64(x);

    window.open("./lihat-pindah-stok?id="+UE64(x), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}