var gvtrm, gvcut, gvvac, gvsaw, gvmp, lsup, gvpvac, gvpsaw, gvpkrm, gvrpkg, gvprpkg, lvgrade;

//PENERIMAAN
function getNIDTrm()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-trm-1").hasClass("d-none"))
            $("#div-err-trm-1").addClass("d-none");
            
        if(!$("#div-err-trm-2").hasClass("d-none"))
            $("#div-err-trm-2").addClass("d-none");
            
        if(!$("#div-err-trm-3").hasClass("d-none"))
            $("#div-err-trm-3").addClass("d-none");
            
        if(!$("#div-err-trm-4").hasClass("d-none"))
            $("#div-err-trm-4").addClass("d-none");
            
        if(!$("#div-err-trm-5").hasClass("d-none"))
            $("#div-err-trm-5").addClass("d-none");
            
        if(!$("#div-scs-trm-1").hasClass("d-none"))
            $("#div-scs-trm-1").addClass("d-none");

        $("#lst-ntrm").html("");
        $("#lst-dll").html("");
        $("#lst-pdll").html("");
        $("#lst-dp").html("");
        $("#txt-dp").val("");
        $("#txt-dll").val("");
        $("#txt-pdll").val("");
        $("#btn-sntrm").prop("disabled", false);
        $("#btn-sntrm").html("Simpan");
        $("#mdl-ntrm").modal("show");

        swal.close();
    }, 200);
}

function getNIDTrm2()
{
    Process();
    setTimeout(function(){
        window.location.href = "./tambah-penerimaan";
    }, 200);
}

function getNIDMTrm()
{
    Process();
    setTimeout(function(){
        $("#lst-nmtrm").html("");
        
        $("#btn-smntrm").prop("disabled", false);
        $("#btn-smntrm").html("Simpan");
        $("#mdl-nmtrm").modal("show");

        swal.close();
    }, 200);
}

function getMTrm()
{
    var tgl = $("#dte-mtgl").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gmtrm.php",
            type : "post",
            data : {tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-nmtrm").html(setToTblTrm3(json));

                $("#btn-snmtrm").attr("data-count", json.count[0]);

                swal.close();
            },
            error : function(){
                swal("Error (STRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function schTrm(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/strm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-trm").html(setToTblTrm(json));
                else if(y === 2)
                    $("#lst-strm").html(setToTblTrm2(json));

                swal.close();
            },
            error : function(){
                swal("Error (STRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblTrm(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var kdll = "", bb =  x.data[i][15] * x.data[i][14];

            if(x.data[i][12] !== "" && x.data[i][11] != 0)
                kdll = "("+x.data[i][12]+")";
            
            if(x.data[i][3] != 0)
                bb = x.data[i][3]

            hsl += "<tr ondblclick=\"viewTrm('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((bb)))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][4])))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][11])))+" "+kdll+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][16])))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][13])))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][17])))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][18])))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][19])))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][20])))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][21])))+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][24])))+"</td>"+
                        "<td class=\"border d-none\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border d-none\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][10]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eTrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewTrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"Lihat Penerimaan\" width=\"20\"></button></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"20\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function setToTblTrm2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgTrm('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][3]))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][4]))+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"10\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function setToTblTrm3(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][2]))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][3]))+"</td>"+
                        "<td class=\"border\"><input class=\"form-control cformat text-right\" value=\""+NumberFormat2(x.data[i][4])+"\" id=\"txt-mnm-"+i+"\" data-value=\""+UE64(x.data[i][5])+"\"/></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function chgTrm(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdttrm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-trm").val(json.data[0]);
                $("#dte-tgl").val(json.data[2]);
                $("#txt-nma-sup").val(json.sup[1]);
                $("#txt-sup").val(json.data[1]);
                $("#txt-bb").val(NumberFormat2(parseFloat(json.data[3])));
                $("#txt-poto").val(NumberFormat2(parseFloat(json.data[4])));
                $("#txt-poto").attr("data-value", UE64(json.spjm[0]));
                $("#spn-poto").text("Sisa Pinjaman : "+NumberFormat2(parseFloat(json.spjm[0])));
                $("#txt-ket1").val(json.data[5]);
                $("#txt-ket2").val(json.data[6]);
                $("#txt-ket3").val(json.data[7]);

                $("#lst-ntt").html(setToTblTrmPro3(json));
                
                $("#edt-txt-trm").val(json.data[0]);
                $("#edt-txt-nma-sup").val(json.sup[1]);
                $("#edt-txt-sup").val(json.data[1]);
                $("#edt-dte-tgl").val(json.data[2]);
                $("#edt-txt-bb").val(NumberFormat2(parseFloat(json.data[3])));
                $("#edt-txt-poto").val(NumberFormat2(parseFloat(json.data[4])));
                $("#edt-txt-poto").attr("data-value", UE64(json.spjm[0]));
                $("#edt-spn-poto").text("Sisa Pinjaman : "+NumberFormat2(parseFloat(json.spjm[0])));
                $("#edt-txt-ket1").val(json.data[5]);
                $("#edt-txt-ket2").val(json.data[6]);
                $("#edt-txt-ket3").val(json.data[7]);

                $("#lst-ett").html(setToTblTrmPro3(json,2));

                swal.close();

                $("#mdl-strm").modal("hide");
            },
            error : function(){
                swal("Error (CTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function schTrmItm(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/strmitm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-trm-itm").html(setToTblTrmItm(json));
                else if(y === 2)
                    $("#lst-trm2-itm").html(setToTblTrmItm2(json));

                swal.close();
            },
            error : function(){
                swal("Error (STRMITM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblTrmItm(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgTrmItm('"+UE64(x.data[i][0])+"', '"+UE64(x.data[i][5])+"', '"+UE64(x.data[i][6])+"', '"+UE64(x.data[i][7])+"', '"+UE64(x.data[i][8])+"', '"+UE64(x.data[i][3])+"', '"+UE64(x.data[i][4])+"')\">"+
                    "<td class=\"border\">"+x.data[i][0]+"</td>"+
                    "<td class=\"border\">"+x.data[i][1]+"</td>"+
                    "<td class=\"border\">"+x.data[i][2]+"</td>"+
                    "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "<td class=\"border\">"+x.data[i][4]+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][5]))+"</td>"+
                "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function setToTblTrmItm2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgTrmItm2('"+UE64(x.data[i][0])+"', '"+UE64(x.data[i][5])+"', '"+UE64(x.data[i][6])+"', '"+UE64(x.data[i][7])+"', '"+UE64(x.data[i][8])+"', '"+UE64(x.data[i][3])+"', '"+UE64(x.data[i][4])+"', '"+UE64(x.data[i][2])+"', '"+UE64(x.data[i][1])+"')\">"+
                    "<td class=\"border\">"+x.data[i][0]+"</td>"+
                    "<td class=\"border\">"+x.data[i][1]+"</td>"+
                    "<td class=\"border\">"+x.data[i][2]+"</td>"+
                    "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "<td class=\"border\">"+x.data[i][4]+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][5]))+"</td>"+
                "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function chgTrmItm(id, brt, tgl, urut, pro, nmpro, nmgrade)
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-cut-1").hasClass("d-none"))
            $("#div-err-cut-1").addClass("d-none");

        if(!$("#div-err-cut-2").hasClass("#d-none"))
            $("#div-err-cut-1").addClass("d-none");

        if(!$("#div-scs-cut-1").hasClass("d-none"))
            $("#div-scs-cut-1").addClass("d-none");

        $("#dte-tgl-trm").val(UD64(tgl));
        $("#txt-id-trm").val(UD64(id));
        $("#txt-nma-pro").val(UD64(nmpro));
        $("#txt-pro").val(UD64(pro));
        $("#txt-urut").val(UD64(urut));
        $("#txt-nma-grade").val(UD64(nmgrade));
        $("#txt-weight").val(NumberFormat2(parseFloat(UD64(brt))));

        $("#mdl-strm2").modal("hide");
        $("#mdl-ncut").modal("show");

        swal.close();
    }, 200);
}

function chgTrmItm2(id, brt, tgl, urut, pro, nmpro, nmgrade, nmsup, nmtgl)
{
    Process();
    setTimeout(function(){
        var i = "", nma = UD64(nmpro)+" / "+UD64(nmgrade)+" / "+UD64(brt)+" / "+UD64(nmsup)+" / "+UD64(id)+" / "+UD64(nmtgl), val = UD64(urut)+"|"+UD64(id)+"|"+UD64(brt)+"|"+UD64(pro);

        if($("#txt-srch-strm2-itm").attr("data-value") !== "" && $("#txt-srch-strm2-itm").attr("data-value") !== undefined)
            i = $("#txt-srch-strm2-itm").attr("data-value");

        if(i === "")
        {
            $("#txt-nma-trm").val(nma);
            $("#txt-trm").val(val);
        }
        else
        {
            $("#txt-nma-trm-"+i).val(nma);
            $("#txt-trm-"+i).val(val);
        }

        $("#mdl-strm3").modal("hide");

        swal.close();
    }, 200);
}

function eTTrm(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-err-trm-1").hasClass("d-none"))
        $("#div-err-trm-1").addClass("d-none");

    if(!$("#div-err-trm-2").hasClass("d-none"))
        $("#div-err-trm-2").addClass("d-none");

    if(!$("#div-err-trm-3").hasClass("d-none"))
        $("#div-err-trm-3").addClass("d-none");

    if(!$("#div-err-trm-4").hasClass("d-none"))
        $("#div-err-trm-4").addClass("d-none");

    if(!$("#div-err-trm-5").hasClass("d-none"))
        $("#div-err-trm-5").addClass("d-none");

    if(!$("#div-scs-trm-1").hasClass("d-none"))
        $("#div-scs-trm-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtttrm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();
                
                if(!$("#txt-vdll").hasClass("d-none"))
                    $("#txt-vdll").addClass("d-none");

                $("#txt-id").val(json.data[0]);
                $("#txt-nma-sup").val(json.sup[1]);
                $("#txt-sup").val(json.data[1]);
                $("#dte-tgl").val(json.data[2]);
                $("#txt-bb").val(NumberFormat2(parseFloat(json.data[3])));
                $("#txt-bb2").val(NumberFormat2(parseFloat(json.data[16])));
                $("#txt-poto").val(NumberFormat2(parseFloat(json.data[4])));
                $("#txt-poto").attr("data-value", UE64(json.spjm[0]));
                $("#spn-poto").text("Sisa Pinjaman : "+NumberFormat2(parseFloat(json.spjm[0])));
                $("#txt-ket1").val(json.data[5]);
                $("#txt-ket2").val(json.data[6]);
                $("#txt-ket3").val(json.data[7]);
                $("#txt-kota").val(json.data[12]);

                $("#txt-dll").val(NumberFormat2(json.data[13]));
                $("#txt-pdll").val(NumberFormat2(json.data[18]));
                $("#txt-tdll").val(NumberFormat2(json.data[19]));
                $("#txt-mnm").val(NumberFormat2(json.data[20]));

                sdll = "1";

                $("#txt-dp").val(NumberFormat2(json.data[15]));
                $("#txt-min").val(NumberFormat2(json.data[17]));

                $("#lst-ntrm").html(setToTblTrmPro4(json));
                $("#lst-dll").html(setToTblTrmDll(json));
                $("#lst-pdll").html(setToTblTrmPDll(json));
                $("#lst-dp").html(setToTblTrmDP(json));
                $("#lst-tdll").html(setToTblTrmTDll(json));

                setTimeout(function(){
                    updSumTrmTran("1");
                    updBB2Val();
                }, 200);

                $("#mdl-ltmp-trm").modal("hide");
                $("#mdl-ntrm").modal("show");
            },
            error : function(){
                swal("Error (ETTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function eTrm(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-trm-1").hasClass("d-none"))
        $("#div-edt-err-trm-1").addClass("d-none");

    if(!$("#div-edt-err-trm-2").hasClass("d-none"))
        $("#div-edt-err-trm-2").addClass("d-none");

    if(!$("#div-edt-err-trm-3").hasClass("d-none"))
        $("#div-edt-err-trm-3").addClass("d-none");

    if(!$("#div-edt-err-trm-4").hasClass("d-none"))
        $("#div-edt-err-trm-4").addClass("d-none");

    if(!$("#div-edt-err-trm-5").hasClass("d-none"))
        $("#div-edt-err-trm-5").addClass("d-none");

    if(!$("#div-edt-err-trm-6").hasClass("d-none"))
        $("#div-edt-err-trm-6").addClass("d-none");

    if(!$("#div-edt-err-trm-7").hasClass("d-none"))
        $("#div-edt-err-trm-7").addClass("d-none");

    if(!$("#div-edt-scs-trm-1").hasClass("d-none"))
        $("#div-edt-scs-trm-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdttrm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();
                
                if(!json.aks[0] && !json.aks[2] && y === 1)
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
                                $("#txt-vkode").attr("data-type", "TRM");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setTrmVerif(x);

                                gvtrm = setInterval(getTrmVerif, 1000);
                                break;

                            default: 
                                break;
                        }
                    })
                }
                else
                {
                    if(!$("#edt-txt-vdll").hasClass("d-none"))
                        $("#edt-txt-vdll").addClass("d-none");

                    $("#edt-txt-id").val(json.data[0]);
                    $("#edt-txt-bid").val(json.data[0]);
                    $("#edt-txt-nma-sup").val(json.sup[1]);
                    $("#edt-txt-sup").val(json.data[1]);
                    $("#edt-dte-tgl").val(json.data[2]);
                    $("#edt-txt-bb").val(NumberFormat2(parseFloat(json.data[3])));
                    $("#edt-txt-bb2").val(NumberFormat2(parseFloat(json.data[16])));
                    $("#edt-txt-poto").val(NumberFormat2(parseFloat(json.data[4])));
                    $("#edt-txt-poto").attr("data-value", UE64(json.spjm[0]));
                    $("#edt-spn-poto").text("Sisa Pinjaman : "+NumberFormat2(parseFloat(json.spjm[0])));
                    $("#edt-txt-ket1").val(json.data[5]);
                    $("#edt-txt-ket2").val(json.data[6]);
                    $("#edt-txt-ket3").val(json.data[7]);
                    $("#edt-txt-kota").val(json.data[12]);

                    $("#edt-txt-dll").val(NumberFormat2(json.data[13]));
                    $("#edt-txt-pdll").val(NumberFormat2(json.data[18]));
                    $("#edt-txt-tdll").val(NumberFormat2(json.data[18]));
                    $("#edt-txt-mnm").val(NumberFormat2(json.data[20]));

                    $("#edt-slct-gdg").val(json.data[21]);

                    sdll = "1";

                    $("#edt-txt-dp").val(NumberFormat2(json.data[15]));
                    $("#edt-txt-min").val(NumberFormat2(json.data[17]));

                    $("#lst-etrm").html(setToTblTrmPro(json));
                    $("#lst-dll").html(setToTblTrmDll(json));
                    $("#lst-pdll").html(setToTblTrmPDll(json));
                    $("#lst-dp").html(setToTblTrmDP(json));
                    $("#lst-tdll").html(setToTblTrmTDll(json));

                    setTimeout(function(){
                        updSumTrmTran("2");
                        updBB2Val();
                    }, 200);

                    $("#btn-setrm").prop("disabled", false);
                    $("#btn-setrm").html("Simpan");

                    $("#mdl-etrm").modal({backdrop : "static", keyboard : false});
                    $("#mdl-etrm").modal("show");
                }
            },
            error : function(){
                swal("Error (ETRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblTrmPro(x)
{
    var hsl = "", read = "";

    if(!x.aks[0])
        read = "readonly";

    for(var i = 0; i < x.count[0]; i++)
    {
        var ds = "";

        if(!x.aks[0] || x.data2[i][13] > 0)
            ds = "d-none";

        hsl += "<tr id=\"etrm-pro-"+i+"\">"+
                    "<td class=\"border\">"+x.data2[i][5]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][6]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][7]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][8]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][9]+"</td>"+
                    "<td class=\"border text-right\"><input type=\"text\" id=\"txt-etrm-pro-"+i+"\" class=\"form-control cformat inp-wtrm\" value=\""+NumberFormat2(parseFloat(x.data2[i][2]))+"\" data-value=\""+UE64(x.data2[i][1])+"\" data-stn=\""+UE64(x.data2[i][3])+"\" data-urut=\""+UE64(x.data2[i][4])+"\" data-grade=\""+UE64(x.data2[i][11])+"\" data-nmgrade=\""+UE64(x.data2[i][6])+"\" "+read+"></td>"+
                    "<td class=\"border text-right\"><input type=\"text\" id=\"txt-etrm-hrga-"+i+"\" class=\"form-control cformat\" value=\""+NumberFormat2(parseFloat(x.data2[i][10]))+"\" "+read+"></td>"+
                    "<td class=\"border text-right\"><input type=\"text\" id=\"txt-etrm-smpn-"+i+"\" class=\"form-control cformat\" value=\""+NumberFormat2(parseFloat(x.data2[i][12]))+"\" "+read+"></td>"+
                    "<td class=\"border d-flex\"><button class=\"btn btn-light border-danger mb-1 mr-1 p-1 "+ds+"\" onclick=\"delTrmPro('"+i+"', '"+UE64(2)+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button> <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"cpyTrmPro('"+i+"', '"+UE64(2)+"')\"><img src=\"./bin/img/icon/duplicate-icon.png\" alt=\"Duplikat\" width=\"18\"></button></td>"+
                "</tr>";
    }

    $("#btn-setrm").attr("data-count", x.count[0]);

    return hsl;
}

function setToTblTrmPro2(itm, nmgrade, kate, skate, sat, weight, itmnm, satnm, type, urut, harga, grade, smpn, aks)
{
    var n = $("#btn-sntrm").attr("data-count"), tname = "ntrm", tdharga = "<td class=\"border text-right\" id=\"txt-"+tname+"-hrga-"+n+"\">"+NumberFormat2(harga)+"</td>", tdsmpn = "<td class=\"border text-right\" id=\"txt-"+tname+"-smpn-"+n+"\">"+NumberFormat2(smpn)+"</td>", read = "";

    if(type === "2")
    {
        n = $("#btn-setrm").attr("data-count");
        tname = "etrm";
        $("#btn-setrm").attr("data-count", parseInt(n) + 1);

        if(!aks[0])
        {
            read = "readonly";
        }

        tdharga = "<td class=\"border text-right\"><input type=\"text\" id=\"txt-"+tname+"-hrga-"+n+"\" class=\"form-control cformat\" value=\""+NumberFormat2(parseFloat(harga))+"\" "+read+"></td>";

        tdsmpn = "<td class=\"border text-right\"><input type=\"text\" id=\"txt-"+tname+"-smpn-"+n+"\" class=\"form-control cformat\" value=\""+NumberFormat2(parseFloat(smpn))+"\" "+read+"></td>";
    }
    else
        $("#btn-sntrm").attr("data-count", parseInt(n) + 1);

    var dbtn = "<button class=\"btn btn-light border-danger mb-1 mr-1 p-1\" onclick=\"delTrmPro('"+n+"', '"+UE64(type)+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";

    return "<tr id=\""+tname+"-pro-"+n+"\">"+
                    "<td class=\"border\">"+itmnm+"</td>"+
                    "<td class=\"border\">"+nmgrade+"</td>"+
                    "<td class=\"border\">"+kate+"</td>"+
                    "<td class=\"border\">"+skate+"</td>"+
                    "<td class=\"border\">"+satnm+"</td>"+
                    "<td class=\"border text-right\"><input type=\"text\" id=\"txt-"+tname+"-pro-"+n+"\" class=\"form-control cformat inp-wtrm\" value=\""+NumberFormat2(parseFloat(weight))+"\" data-value=\""+UE64(itm)+"\" data-stn=\""+UE64(sat)+"\" data-urut=\""+UE64(urut)+"\" data-grade=\""+UE64(grade)+"\" data-nmgrade=\""+UE64(nmgrade)+"\"></td>"+
                    tdharga+
                    tdsmpn+
                    "<td class=\"border d-flex\">"+dbtn+" <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"cpyTrmPro('"+n+"', '"+UE64(type)+"')\"><img src=\"./bin/img/icon/duplicate-icon.png\" alt=\"Duplikat\" width=\"18\"></button></td>"+
                "</tr>";
}

function setToTblTrmPro3(x, y = 1)
{
    var hsl = "", type = "";

    if(y === 2)
        type = "edt-";

    for(var i = 0; i < x.count[1]; i++)
    {
        var harga = 0;
        
        if(x.data3[i][7] !== null)
            harga = x.data3[i][7];

        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data3[i][0]+"</td>"+
                    "<td class=\"border\">"+x.data3[i][1]+"</td>"+
                    "<td class=\"border\">"+x.data3[i][2]+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(x.data3[i][3])+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data3[i][4]))+"</td>"+
                    "<td class=\"border\"><input type=\"text\" class=\"form-control cformat\" id=\""+type+"txt-hrga-"+i+"\" value=\""+NumberFormat2(harga)+"\"></td>"+
                "</tr>";
    }

    return hsl;
}

function setToTblTrmPro4(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++)
    {
        hsl += "<tr id=\"ntrm-pro-"+i+"\">"+
                    "<td class=\"border\">"+x.data2[i][5]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][6]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][7]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][8]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][9]+"</td>"+
                    "<td class=\"border text-right\"><input type=\"text\" id=\"txt-ntrm-pro-"+i+"\" class=\"form-control cformat inp-wtrm\" value=\""+NumberFormat2(parseFloat(x.data2[i][2]))+"\" data-value=\""+UE64(x.data2[i][1])+"\" data-stn=\""+UE64(x.data2[i][3])+"\" data-urut=\""+UE64(x.data2[i][4])+"\" data-grade=\""+UE64(x.data2[i][11])+"\" data-nmgrade=\""+UE64(x.data2[i][6])+"\"></td>"+
                    "<td class=\"border text-right\"><input type=\"text\" id=\"txt-ntrm-hrga-"+i+"\" class=\"form-control cformat\" value=\""+NumberFormat2(parseFloat(x.data2[i][10]))+"\"></td>"+
                    "<td class=\"border text-right\"><input type=\"text\" id=\"txt-ntrm-smpn-"+i+"\" class=\"form-control cformat\" value=\""+NumberFormat2(parseFloat(x.data2[i][12]))+"\"></td>"+
                    "<td class=\"border d-flex\"><button class=\"btn btn-light border-danger mb-1 mr-1 p-1\" onclick=\"delTrmPro('"+i+"', '"+UE64(2)+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button> <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"cpyTrmPro('"+i+"', '"+UE64(2)+"')\"><img src=\"./bin/img/icon/duplicate-icon.png\" alt=\"Duplikat\" width=\"18\"></button></td>"+
                "</tr>";
    }

    $("#btn-sntrm").attr("data-count", x.count[0]);

    return hsl;
}

function setToTblTrmDll(x)
{
    var hsl = "", sum = 0;

    for(var i = 0; i < x.count[2]; i++)
    {
        var s1 = "", s2 = "", s3 = "";

        if(x.data4[i][1] === "1")
            s1 = " selected=\"selected\"";
        else if(x.data4[i][1] === "2")
            s2 = " selected=\"selected\"";
        else if(x.data4[i][1] === "3")
            s3 = " selected=\"selected\"";

        hsl += "<tr id=\"div-dtrm-"+i+"\">"+
                    "<td class=\"border\"><select class=\"custom-select\" id=\"slct-dll-"+i+"\"><option value=\"1\""+s1+">Cash</option><option value=\"2\""+s2+">Es</option><option value=\"3\""+s3+">Dll</option></select></td>"+
                    "<td class=\"border\"><input class=\"form-control\" id=\"txt-dll-"+i+"\" max-length=\"100\" value=\""+x.data4[i][2]+"\" autocomplete=\"off\"></td>"+
                    "<td class=\"border\"><input class=\"form-control cformat\" id=\"txt-vdll-"+i+"\" max-length=\"100\" value=\""+NumberFormat2(x.data4[i][3])+"\" autocomplete=\"off\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTrmDll("+i+")\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
                
        sum += parseFloat(x.data4[i][3]);
    }

    $("#edt-txt-dll").val(NumberFormat2(sum));
    $("#btn-sldll").attr("data-count", x.count[2]);

    return hsl;
}

function setToTblTrmPDll(x)
{
    var hsl = "", sum = 0;

    for(var i = 0; i < x.count[3]; i++)
    {
        var s1 = "", s2 = "", s3 = "";

        if(x.data5[i][1] === "1")
            s1 = " selected=\"selected\"";
        else if(x.data5[i][1] === "2")
            s2 = " selected=\"selected\"";
        else if(x.data5[i][1] === "3")
            s3 = " selected=\"selected\"";

        hsl += "<tr id=\"div-pdtrm-"+i+"\">"+
                    "<td class=\"border\"><select class=\"custom-select\" id=\"slct-pdll-"+i+"\"><option value=\"3\""+s3+">Dll</option></select></td>"+
                    "<td class=\"border\"><input class=\"form-control\" id=\"txt-pdll-"+i+"\" max-length=\"100\" value=\""+x.data5[i][2]+"\" autocomplete=\"off\"></td>"+
                    "<td class=\"border\"><input class=\"form-control cformat\" id=\"txt-vpdll-"+i+"\" max-length=\"100\" value=\""+NumberFormat2(x.data5[i][3])+"\" autocomplete=\"off\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTrmPDll("+i+")\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
                
        sum += parseFloat(x.data5[i][3]);
    }

    $("#edt-txt-pdll").val(NumberFormat2(sum));
    $("#btn-slpdll").attr("data-count", x.count[3]);

    return hsl;
}

function setToTblTrmDP(x)
{
    var hsl = "", sum = 0;

    for(var i = 0; i < x.count[4]; i++)
    {
        hsl += "<tr id=\"div-dp-"+i+"\">"+
                    "<td class=\"border\"><input type=\"date\" class=\"form-control\" id=\"dte-dp-"+i+"\" max-length=\"100\" value=\""+x.data6[i][1]+"\" autocomplete=\"off\"></td>"+
                    "<td class=\"border\"><input class=\"form-control cformat\" id=\"txt-vdp-"+i+"\" max-length=\"100\" value=\""+NumberFormat2(x.data6[i][2])+"\" autocomplete=\"off\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTrmDP("+i+")\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
                
        sum += parseFloat(x.data6[i][3]);
    }
    
    $("#btn-sldp").attr("data-count", x.count[4]);

    return hsl;
}

function setToTblTrmTDll(x)
{
    var hsl = "", sum = 0;

    for(var i = 0; i < x.count[5]; i++)
    {
        var s1 = "", s2 = "", s3 = "", read = "", read2 = "";

        if(x.data7[i][1] === "1")
            s1 = " selected=\"selected\"";
        else if(x.data7[i][1] === "2")
        {
            s2 = " selected=\"selected\"";
            read = "readonly";
        }
        else if(x.data7[i][1] === "3")
        {
            s3 = " selected=\"selected\"";
            read2 = "readonly";
        }

        hsl += "<tr id=\"div-pdtrm-"+i+"\">"+
                    "<td class=\"border\"><select class=\"custom-select slct-tdll\" id=\"slct-tdll-"+i+"\" data-value=\""+i+"\"><option value=\"2\""+s2+">Tambahan Ikan</option><option value=\"3\""+s3+">Dll</option></select></td>"+
                    "<td class=\"border\"><input class=\"form-control\" id=\"txt-tdll-"+i+"\" max-length=\"100\" value=\""+x.data7[i][2]+"\" autocomplete=\"off\"></td>"+
                    "<td class=\"border\"><input class=\"form-control inp-tdll\" id=\"nmbr-ktdll-"+i+"\" step=\"any\" autocomplete=\"off\" type=\"number\" "+read2+" value=\""+x.data7[i][5]+"\" data-value=\""+i+"\"></td>"+
                    "<td class=\"border\"><input class=\"form-control cformat inp-tdll\" id=\"txt-ttdll-"+i+"\" max-length=\"100\" autocomplete=\"off\" type=\"text\" "+read2+" value=\""+NumberFormat2(x.data7[i][6])+"\" data-value=\""+i+"\"></td>"+
                    "<td class=\"border\"><input class=\"form-control cformat\" id=\"txt-vtdll-"+i+"\" max-length=\"100\" value=\""+NumberFormat2(x.data7[i][3])+"\" autocomplete=\"off\" "+read+"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTrmPDll("+i+")\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
                
        sum += parseFloat(x.data7[i][3]);
    }

    $("#edt-txt-tdll").val(NumberFormat2(sum));
    $("#btn-sltdll").attr("data-count", x.count[5]);

    return hsl;
}

function eTrmPro(x, y)
{
    Process();
    setTimeout(function(){
        y = UD64(y), urut = 0;

        if(y === "1")
        {
            var pro = UD64($("#ntrm-pro-"+x).attr("data-value"));
            var weight = UD64($("#ntrm-pro-"+x).attr("data-weight"));
            var sat = UD64($("#ntrm-pro-"+x).attr("data-stn"));
        }
        else
        {
            var pro = UD64($("#etrm-pro-"+x).attr("data-value"));
            var weight = UD64($("#etrm-pro-"+x).attr("data-weight"));
            var sat = UD64($("#etrm-pro-"+x).attr("data-stn"));
            var urut = UD64($("#etrm-pro-"+x).attr("data-urut"));
        }

        if(!$("#div-edt-err-trm-pro-1").hasClass("d-none"))
            $("#div-edt-err-trm-pro-1").addClass("d-none");
        
        $.ajax({
            url : "./bin/php/gdtpro.php",
            type : "post",
            data : {id : pro},
            success : function(output){
                var json = $.parseJSON(output);
                
                if(y === "1")
                    $("#mdl-ntrm").modal("hide");
                else if(y === "2")
                    $("#mdl-etrm").modal("hide");

                $("#edt-txt-pro").val(pro);
                $("#edt-txt-nma-pro").val(json.pro[1]);
                $("#edt-txt-nma-kate").val(json.kate[1]);
                $("#edt-txt-nma-skate").val(json.skate[1]);
                $("#edt-txt-nma-grade").val(json.grade[1]);
                $("#edt-slct-sat").val(sat);
                $("#edt-txt-weight").val(NumberFormat2(parseFloat(weight)));
                $("#edt-txt-urut").val(urut);

                $("#mdl-etrm-pro").modal({backdrop : "static", keyboard : false});
                $("#mdl-etrm-pro").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (ETRMPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    });
}

function mdlTrm(x)
{
    x = UD64(x);

    $("#txt-opt-trm").val(x);

    $("#mdl-opt-trm").modal("show");
}

function getTrmVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));
        $.ajax({
            url : "./bin/php/gdttrm.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[10] === "x")
                {
                    swal("Error (GTRMVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide");
                    clearInterval(gvtrm);
                }
                else if(json.data[10] !== "?" && json.data[10] !== "")
                {
                    $("#head-vkode").text(json.data[10]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[10]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvtrm);
                }
            },
            error : function(){
                swal("Error (GTRMVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setTrmVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/strmvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (STRMVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekTrmVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eTrm(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CTRMVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function getTrmCut()
{
    var sup = $("#txt-sup").val(), ttrm = $("#dte-tgl-trm").val(), pro = $("#txt-pro").val();

    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gtrmcut.php",
            type : "post",
            data : {sup : sup, ttrm : ttrm, pro : pro},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.count[0] === 0)
                    $("#slct-weight").html("<option value=\"\" data-value=\"\" data-value2=\"\">Tidak ada penerimaan</option>");
                else
                {
                    var hsl = "";

                    for(var i = 0; i < json.count[0]; i++)
                        hsl += "<option value=\""+json.data[i][0]+"\" data-value=\""+UE64(json.data[i][1])+"\" data-value2=\""+UE64(json.data[i][2])+"\">"+json.data[i][0]+" - "+json.data[i][2]+"</option>";

                    $("#slct-weight").html(hsl);
                }
            },
            error : function(){
                swal("Error (GTRMCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function rstTrm()
{
    swal({
        title : "Perhatian !!!",
        text : "Yakin reset input ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            ToTop();

            $("#btn-rstrm").prop("disabled", true);
            $("#btn-rstrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

            setTimeout(function(){
                var tgl = $("#dte-tgl").val();
                if(!$("#div-err-trm-1").hasClass("d-none"))
                    $("#div-err-trm-1").addClass("d-none");
            
                if(!$("#div-err-trm-2").hasClass("d-none"))
                    $("#div-err-trm-2").addClass("d-none");
            
                if(!$("#div-err-trm-3").hasClass("d-none"))
                    $("#div-err-trm-3").addClass("d-none");
            
                if(!$("#div-err-trm-4").hasClass("d-none"))
                    $("#div-err-trm-4").addClass("d-none");
            
                if(!$("#div-err-trm-5").hasClass("d-none"))
                    $("#div-err-trm-5").addClass("d-none");
            
                if(!$("#div-scs-trm-1").hasClass("d-none"))
                    $("#div-scs-trm-1").addClass("d-none");
            
                $("#mdl-ntrm input").val("");
                $("#mdl-ntrm #lst-ntrm").html("");
                $("#lst-dll").html("");
                $("#lst-pdll").html("");
                $("#lst-dp").html("");
                $("#lst-pdll").html("");
                $("#lst-tdll").html("");
                $("#lst-dp").html("");
                $("#dte-tgl").val(tgl);
                $("#btn-sntrm").attr("data-count",0);
                $("#btn-sldll").attr("data-count",0);
                $("#btn-slpdll").attr("data-count",0);
                $("#btn-sldp").attr("data-count",0);
                $("#btn-sltdll").attr("data-count",0);

                swal("Sukses !!!", "Reset data berhasil !!!", "success");

                $("#btn-rstrm").prop("disabled", false);
                $("#btn-rstrm").html("Reset");
            }, 200);
        }
    })
}

function viewTTrm()
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gattrm.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-tmp-trm").html(setToTblTTrm(json));

                $("#mdl-ltmp-trm").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VTTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblTTrm(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++)
    {
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[i][2]+"</td>"+
                    "<td class=\"border\">"+x.data[i][1]+"</td>"+
                    "<td class=\"border\">"+x.data[i][9]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eTTrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button> <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTTrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function newTTrm()
{
    var id = $("#txt-id").val(), sup = $("#txt-sup").val(), tgl = $("#dte-tgl").val(), bb = UnNumberFormat($("#txt-bb").val()), poto = UnNumberFormat($("#txt-poto").val()), mpoto = UD64($("#txt-poto").attr("data-value")), ket1 = $("#txt-ket1").val(), ket2 = $("#txt-ket2").val(), ket3 = $("#txt-ket3").val(), kota = $("#txt-kota").val(), dp = UnNumberFormat($("#txt-dp").val()), vdll = UnNumberFormat($("#txt-dll").val()), bb2 = UnNumberFormat($("#txt-bb2").val()), min = UnNumberFormat($("#txt-min").val()), vpdll = UnNumberFormat($("#txt-pdll").val()), vtdll = UnNumberFormat($("#txt-tdll").val()), mnm = UnNumberFormat($("#txt-mnm").val());
    
    if(!$("#div-err-trm-1").hasClass("d-none"))
        $("#div-err-trm-1").addClass("d-none");

    if(!$("#div-err-trm-2").hasClass("d-none"))
        $("#div-err-trm-2").addClass("d-none");

    if(!$("#div-err-trm-3").hasClass("d-none"))
        $("#div-err-trm-3").addClass("d-none");

    if(!$("#div-err-trm-4").hasClass("d-none"))
        $("#div-err-trm-4").addClass("d-none");

    if(!$("#div-err-trm-5").hasClass("d-none"))
        $("#div-err-trm-5").addClass("d-none");

    if(!$("#div-scs-trm-1").hasClass("d-none"))
        $("#div-scs-trm-1").addClass("d-none");
        
    ToTop();
    if(sup === "" || tgl === "" || parseFloat(bb) < 0)
        $("#div-err-trm-1").removeClass("d-none");
    else if(parseFloat(poto) > parseFloat(mpoto))
        $("#div-err-trm-4").removeClass("d-none");
    else if($("#lst-ntrm tr").length === 0)
        $("#div-err-trm-5").removeClass("d-none");
    else
    {
        $("#btn-sttrm").prop("disabled", true);
        $("#btn-sttrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Pending");

        var lpro = [], n = 0, dll = [], pdll = [], ldp = [], tdll = [];

        for(var i = 0; i < parseInt($("#btn-sntrm").attr("data-count")); i++)
        {
            if($("#txt-ntrm-pro-"+i).length === 0)
                continue;

            lpro[n] = [UD64($("#txt-ntrm-pro-"+i).attr("data-value")), UnNumberFormat($("#txt-ntrm-pro-"+i).val()), UD64($("#txt-ntrm-pro-"+i).attr("data-stn")), UnNumberFormat($("#txt-ntrm-hrga-"+i).val()), UnNumberFormat($("#txt-ntrm-smpn-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-sldll").attr("data-count")); i++)
        {
            if($("#slct-dll-"+i).length === 0)
                continue;

            dll[n] = [$("#slct-dll-"+i).val(), $("#txt-dll-"+i).val(), UnNumberFormat($("#txt-vdll-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-slpdll").attr("data-count")); i++)
        {
            if($("#slct-pdll-"+i).length === 0)
                continue;

            pdll[n] = [$("#slct-pdll-"+i).val(), $("#txt-pdll-"+i).val(), UnNumberFormat($("#txt-vpdll-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-sldp").attr("data-count")); i++)
        {
            if($("#dte-dp-"+i).length === 0)
                continue;

            ldp[n] = [$("#dte-dp-"+i).val(), UnNumberFormat($("#txt-vdp-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-sltdll").attr("data-count")); i++)
        {
            var kg = 0, val = 0;
            if($("#slct-tdll-"+i).length === 0)
                continue;

            if($("#slct-tdll-"+i).val() === "2")
            {
                if($("#nmbr-ktdll-"+i).val() !== "")
                    kg = $("#nmbr-ktdll-"+i).val();

                if($("#txt-ttdll-"+i).val() !== "")
                    val = UnNumberFormat($("#txt-ttdll-"+i).val());
            }

            tdll[n] = [$("#slct-tdll-"+i).val(), $("#txt-tdll-"+i).val(), UnNumberFormat($("#txt-vtdll-"+i).val()), kg, val];

            n++;
        }

        lpro = JSON.stringify(lpro);
        dll = JSON.stringify(dll);
        pdll = JSON.stringify(pdll);
        ldp = JSON.stringify(ldp);
        tdll = JSON.stringify(tdll);

        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nttrm.php",
                type : "post",
                data : {id : id, sup : sup, tgl : tgl, bb : bb, poto : poto, ket1 : ket1, ket2 : ket2, ket3 : ket3, lpro : lpro, kota : kota, dll : dll, pdll : pdll, dp : dp, vdll : vdll, vpdll : vpdll, bb2 : bb2, min : min, ldp : ldp, tdll : tdll, vtdll : vtdll, mnm : mnm},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-trm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-trm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-trm-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-err-trm-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-err-trm-5").removeClass("d-none");
                    else
                    {
                        $("#txt-id").val(json.id[0]);
                        swal("Sukses !!!", "Penyimpanan data berhasil !!!", "success");
                    }

                    $("#btn-sttrm").prop("disabled", false);
                    $("#btn-sttrm").html("Pending");
                },
                error : function(){
                    $("#btn-sttrm").prop("disabled", false);
                    $("#btn-sttrm").html("Pending");
                    swal("Error (NTTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function getSlctTrmCut(x, y)
{
    var tgl = $("#dte-tgl-"+y).val();
    
    $("#btn-rtrm").prop("disabled", true);
    $("#btn-rtrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/strmsup.php",
            type : "post",
            data : {id : x, tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output), opt = "";
                
                if(json.count[0] == 0)
                    opt = "<option value=\"\">Tidak ada penerimaan</option>";
                else
                {
                    for(var i = 0; i < json.count[0]; i++)
                    {
                        var ket = "";
                        if(json.data[i][7] !== ""){
                            ket = json.data[i][7]+" | ";
                        }
                        opt += "<option value=\""+json.data[i][0]+"|"+json.data[i][5]+"|"+json.data[i][6]+"\">"+json.data[i][2]+" | "+json.data[i][1]+" | "+ket+json.data[i][3]+" | "+NumberFormat2(json.data[i][4])+"</option>";

                        //ltrm += "\""+json.data[i][2]+" | "+json.data[i][3]+" | "+json.data[i][1]+" | "+json.data[i][0]+" | "+NumberFormat2(json.data[i][4])+"\":\""+json.data[i][0]+"|"+json.data[i][5]+"|"+json.data[i][6]+"\",";
                    }
                }
                
                $("#slct-trm-"+y).html(opt);

                $("#btn-rtrm").prop("disabled", false);
                $("#btn-rtrm").html("<img src=\"./bin/img/icon/refresh.png\" width=\"15\" alt=\"Refresh\">");
            },
            error : function(){
                $("#btn-rtrm").prop("disabled", false);
                $("#btn-rtrm").html("<img src=\"./bin/img/icon/refresh.png\" width=\"15\" alt=\"Refresh\">");
                swal("Error (GSTRMCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function newTrm()
{
    var id = $("#txt-id").val(), sup = $("#txt-sup").val(), tgl = $("#dte-tgl").val(), bb = UnNumberFormat($("#txt-bb").val()), poto = UnNumberFormat($("#txt-poto").val()), mpoto = UD64($("#txt-poto").attr("data-value")), ket1 = $("#txt-ket1").val(), ket2 = $("#txt-ket2").val(), ket3 = $("#txt-ket3").val(), kota = $("#txt-kota").val(), dp = UnNumberFormat($("#txt-dp").val()), vdll = UnNumberFormat($("#txt-dll").val()), bb2 = UnNumberFormat($("#txt-bb2").val()), min = UnNumberFormat($("#txt-min").val()), vpdll = UnNumberFormat($("#txt-pdll").val()), vtdll = UnNumberFormat($("#txt-tdll").val()), mnm = UnNumberFormat($("#txt-mnm").val());
    
    if(!$("#div-err-trm-1").hasClass("d-none"))
        $("#div-err-trm-1").addClass("d-none");

    if(!$("#div-err-trm-2").hasClass("d-none"))
        $("#div-err-trm-2").addClass("d-none");

    if(!$("#div-err-trm-3").hasClass("d-none"))
        $("#div-err-trm-3").addClass("d-none");

    if(!$("#div-err-trm-4").hasClass("d-none"))
        $("#div-err-trm-4").addClass("d-none");

    if(!$("#div-err-trm-5").hasClass("d-none"))
        $("#div-err-trm-5").addClass("d-none");

    if(!$("#div-scs-trm-1").hasClass("d-none"))
        $("#div-scs-trm-1").addClass("d-none");
        
    ToTop();
    if(sup === "" || tgl === "" || parseFloat(bb) < 0)
        $("#div-err-trm-1").removeClass("d-none");
    else if(parseFloat(poto) > parseFloat(mpoto))
        $("#div-err-trm-4").removeClass("d-none");
    else if($("#lst-ntrm tr").length === 0)
        $("#div-err-trm-5").removeClass("d-none");
    else
    {
        $("#btn-sntrm").prop("disabled", true);
        $("#btn-sntrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        var lpro = [], n = 0, dll = [], pdll = [], ldp = [], tdll = [];

        for(var i = 0; i < parseInt($("#btn-sntrm").attr("data-count")); i++)
        {
            if($("#txt-ntrm-pro-"+i).length === 0)
                continue;

            lpro[n] = [UD64($("#txt-ntrm-pro-"+i).attr("data-value")), UnNumberFormat($("#txt-ntrm-pro-"+i).val()), UD64($("#txt-ntrm-pro-"+i).attr("data-stn")), UnNumberFormat($("#txt-ntrm-hrga-"+i).val()), UnNumberFormat($("#txt-ntrm-smpn-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-sldll").attr("data-count")); i++)
        {
            if($("#slct-dll-"+i).length === 0)
                continue;

            dll[n] = [$("#slct-dll-"+i).val(), $("#txt-dll-"+i).val(), UnNumberFormat($("#txt-vdll-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-slpdll").attr("data-count")); i++)
        {
            if($("#slct-pdll-"+i).length === 0)
                continue;

            pdll[n] = [$("#slct-pdll-"+i).val(), $("#txt-pdll-"+i).val(), UnNumberFormat($("#txt-vpdll-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-sldp").attr("data-count")); i++)
        {
            if($("#dte-dp-"+i).length === 0)
                continue;

            ldp[n] = [$("#dte-dp-"+i).val(), UnNumberFormat($("#txt-vdp-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-sltdll").attr("data-count")); i++)
        {
            var kg = 0, val = 0;
            if($("#slct-tdll-"+i).length === 0)
                continue;

            if($("#slct-tdll-"+i).val() === "2")
            {
                if($("#nmbr-ktdll-"+i).val() !== "")
                    kg = $("#nmbr-ktdll-"+i).val();

                if($("#txt-ttdll-"+i).val() !== "")
                    val = UnNumberFormat($("#txt-ttdll-"+i).val());
            }

            tdll[n] = [$("#slct-tdll-"+i).val(), $("#txt-tdll-"+i).val(), UnNumberFormat($("#txt-vtdll-"+i).val()), kg, val];

            n++;
        }

        lpro = JSON.stringify(lpro);
        dll = JSON.stringify(dll);
        pdll = JSON.stringify(pdll);
        ldp = JSON.stringify(ldp);
        tdll = JSON.stringify(tdll);

        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ntrm.php",
                type : "post",
                data : {id : id, sup : sup, tgl : tgl, bb : bb, poto : poto, ket1 : ket1, ket2 : ket2, ket3 : ket3, lpro : lpro, kota : kota, dll : dll, pdll : pdll, dp : dp, vdll : vdll, vpdll : vpdll, bb2 : bb2, min : min, ldp : ldp, tdll : tdll, vtdll : vtdll, mnm : mnm},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-trm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-trm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-trm-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-err-trm-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-err-trm-5").removeClass("d-none");
                    else
                    {
                        $("#mdl-ntrm input").val("");
                        $("#mdl-ntrm #lst-ntrm").html("");
                        $("#lst-dll").html("");
                        $("#lst-pdll").html("");
                        $("#lst-dp").html("");
                        $("#lst-tdll").html("");
                        $("#th-sntrm").html("");
                        $("#lst-snpnrm").html("");
                        $("#dte-tgl").val(tgl);
                        $("#btn-sntrm").attr("data-count",0);
                        $("#btn-sldll").attr("data-count",0);
                        $("#btn-slpdll").attr("data-count",0);
                        $("#btn-sltdll").attr("data-count",0);

                        $("#txt-id").focus().select();

                        $("#div-scs-trm-1").removeClass("d-none");

                        schTrm($("#txt-srch-trm").val());
                        
                        /*setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Proses penerimaan berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-penerimaan?id="+UE64(json.id[0]), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);*/
                    }

                    $("#btn-sntrm").prop("disabled", false);
                    $("#btn-sntrm").html("Simpan");
                },
                error : function(){
                    $("#btn-sntrm").prop("disabled", false);
                    $("#btn-sntrm").html("Simpan");
                    swal("Error (NTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDllTrm()
{
    var ttl = parseInt($("#btn-sldll").attr("data-count"));

    $("#lst-dll").append("<tr id=\"div-dtrm-"+ttl+"\">"+
                            "<td class=\"border\"><select class=\"custom-select\" id=\"slct-dll-"+ttl+"\"><option value=\"1\">Cash</option><option value=\"2\">Es</option><option value=\"3\">Dll</option></select></td>"+
                            "<td class=\"border\"><input class=\"form-control\" id=\"txt-dll-"+ttl+"\" max-length=\"100\" autocomplete=\"off\" text=\"text\"></td>"+
                            "<td class=\"border\"><input class=\"form-control cformat\" id=\"txt-vdll-"+ttl+"\" max-length=\"100\" autocomplete=\"off\" text=\"text\"></td>"+
                            "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTrmDll("+ttl+")\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                        "</tr>");

    $("#btn-sldll").attr("data-count", ttl + 1);
}

function newPDllTrm()
{
    var ttl = parseInt($("#btn-slpdll").attr("data-count"));

    $("#lst-pdll").append("<tr id=\"div-pdtrm-"+ttl+"\">"+
                            "<td class=\"border\"><select class=\"custom-select\" id=\"slct-pdll-"+ttl+"\"><option value=\"3\">Dll</option></select></td>"+
                            "<td class=\"border\"><input class=\"form-control\" id=\"txt-pdll-"+ttl+"\" max-length=\"100\" autocomplete=\"off\" type=\"text\"></td>"+
                            "<td class=\"border\"><input class=\"form-control cformat\" id=\"txt-vpdll-"+ttl+"\" max-length=\"100\" autocomplete=\"off\" type=\"text\"></td>"+
                            "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTrmPDll("+ttl+")\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                        "</tr>");

    $("#btn-slpdll").attr("data-count", ttl + 1);
}

function newTDllTrm()
{
    var ttl = parseInt($("#btn-sltdll").attr("data-count"));

    $("#lst-tdll").append("<tr id=\"div-tdtrm-"+ttl+"\">"+
                            "<td class=\"border\"><select class=\"custom-select slct-tdll\" id=\"slct-tdll-"+ttl+"\" data-value=\""+ttl+"\"><option value=\"2\">Tambahan Ikan</option><option value=\"3\">Dll</option></select></td>"+
                            "<td class=\"border\"><input class=\"form-control\" id=\"txt-tdll-"+ttl+"\" max-length=\"100\" autocomplete=\"off\" type=\"text\"></td>"+
                            "<td class=\"border\"><input class=\"form-control inp-tdll\" id=\"nmbr-ktdll-"+ttl+"\" step=\"any\" autocomplete=\"off\" type=\"number\" data-value=\""+ttl+"\"></td>"+
                            "<td class=\"border\"><input class=\"form-control cformat inp-tdll\" id=\"txt-ttdll-"+ttl+"\" max-length=\"100\" autocomplete=\"off\" type=\"text\" data-value=\""+ttl+"\"></td>"+
                            "<td class=\"border\"><input class=\"form-control cformat\" id=\"txt-vtdll-"+ttl+"\" max-length=\"100\" autocomplete=\"off\" type=\"text\" readonly></td>"+
                            "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTrmTDll("+ttl+")\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                        "</tr>");

    $("#btn-sltdll").attr("data-count", ttl + 1);
}

function newDPTrm()
{
    var ttl = parseInt($("#btn-sldp").attr("data-count"));

    $("#lst-dp").append("<tr id=\"div-dp-"+ttl+"\">"+
                            "<td class=\"border\"><input class=\"form-control\" id=\"dte-dp-"+ttl+"\" max-length=\"100\" autocomplete=\"off\" type=\"date\"></td>"+
                            "<td class=\"border\"><input class=\"form-control cformat\" id=\"txt-vdp-"+ttl+"\" max-length=\"100\" autocomplete=\"off\" type=\"text\"></td>"+
                            "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delTrmDP("+ttl+")\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                        "</tr>");

    $("#btn-sldp").attr("data-count", ttl + 1);
}

function saveDllTrm()
{
    var sum = 0, mdl = $("#btn-sldll").attr("data-value");

    for(var i = 0; i < parseInt($("#btn-sldll").attr("data-count")); i++)
    {
        if($("#slct-dll-"+i).length === 0)
            continue;

        sum += parseFloat(UnNumberFormat($("#txt-vdll-"+i).val()));
    }
    
    if(mdl === "#mdl-ntrm")
        $("#txt-dll").val(NumberFormat2(sum));
    else
        $("#edt-txt-dll").val(NumberFormat2(sum));

    $("#mdl-ldll").modal("hide");
    $(mdl).modal("show");
}

function savePDllTrm()
{
    var sum = 0, mdl = $("#btn-slpdll").attr("data-value");

    for(var i = 0; i < parseInt($("#btn-slpdll").attr("data-count")); i++)
    {
        if($("#slct-pdll-"+i).length === 0)
            continue;

        sum += parseFloat(UnNumberFormat($("#txt-vpdll-"+i).val()));
    }
    
    if(mdl === "#mdl-ntrm")
        $("#txt-pdll").val(NumberFormat2(sum));
    else
        $("#edt-txt-pdll").val(NumberFormat2(sum));

    $("#mdl-lpdll").modal("hide");
    $(mdl).modal("show");
}

function saveDPTrm()
{
    var sum = 0, mdl = $("#btn-sldp").attr("data-value");

    for(var i = 0; i < parseInt($("#btn-sldp").attr("data-count")); i++)
    {
        if($("#dte-dp-"+i).length === 0)
            continue;

        sum += parseFloat(UnNumberFormat($("#txt-vdp-"+i).val()));
    }
    
    if(mdl === "#mdl-ntrm")
        $("#txt-dp").val(NumberFormat2(sum));
    else
        $("#edt-txt-dp").val(NumberFormat2(sum));

    $("#mdl-ldp").modal("hide");
    $(mdl).modal("show");
}

function saveTDllTrm()
{
    var sum = 0, mdl = $("#btn-sltdll").attr("data-value");

    for(var i = 0; i < parseInt($("#btn-sltdll").attr("data-count")); i++)
    {
        if($("#slct-tdll-"+i).length === 0)
            continue;

        sum += parseFloat(UnNumberFormat($("#txt-vtdll-"+i).val()));
    }
    
    if(mdl === "#mdl-ntrm")
        $("#txt-tdll").val(NumberFormat2(sum));
    else
        $("#edt-txt-tdll").val(NumberFormat2(sum));

    $("#mdl-ltdll").modal("hide");
    $(mdl).modal("show");
}

function setTypeTrm(x)
{
    $("#txt-trm-type-pro").val(x);

    if(!$("#div-err-trm-pro-1").hasClass("d-none"))
        $("#div-err-trm-pro-1").addClass("d-none");

    if(!$("#div-scs-trm-pro-1").hasClass("d-none"))
        $("#div-scs-trm-pro-1").addClass("d-none");

    if(x === 1)
        $("#mdl-ntrm-pro .mdl-cls").attr("data-target", "#mdl-ntrm");
    else if(x === 2)
        $("#mdl-ntrm-pro .mdl-cls").attr("data-target", "#mdl-etrm");

    $("#mdl-ntrm-pro").modal({backdrop : "static", keyboard : false});
    $("#mdl-ntrm-pro").modal("show");
}

function addTrm()
{
    var count = parseInt($("#btn-ndtrm").attr("data-count")), tgl = "", sup = "", nsup = "", pro = "", tp = "", sat = "";

    if($("#lst-trm tr input").length > 0){
        tgl = $("#lst-trm tr:last").find("input[type='date']").val();
        sup = $("#lst-trm tr:last").find("input.txt-sup").val();
        nsup = $("#lst-trm tr:last").find("input.txt-nsup").val();
        pro = $("#lst-trm tr:last").find("select.slct-pro").val();
        tp = $("#lst-trm tr:last").find("select.slct-tp").val();
        sat = $("#lst-trm tr:last").find("select.slct-sat").val();
    }
        
    $("#btn-ndtrm").prop("disabled", true);
    $("#btn-ndtrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Tambah Penerimaan");
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gndtrm.php",
            type : "post",
            success : function(output){
                var json = $.parseJSON(output), htrm = $("#lst-trm").html(), lpro = "", lsat = "";

                for(var i = 0; i < json.pro.length; i++){
                    var txt = json.pro[i][1]+" / "+json.pro[i][2];

                    if(json.pro[i][3] !== "" && json.pro[i][3] !== null)
                        txt += " / "+json.pro[i][3];

                    if(json.pro[i][4] !== "" && json.pro[i][4] !== null)
                        txt += " / "+json.pro[i][4];

                    lpro += "<option value=\""+json.pro[i][0]+"\">"+txt+"</option>";
                }

                for(var i = 0; i < json.sat.length; i++){
                    lsat += "<option value=\""+json.sat[i][0]+"\">"+json.sat[i][1]+"</option>";
                }

                $(".table-data").DataTable().destroy();
                
                $("#lst-trm").append(
                    "<tr id=\"row-trm-"+count+"\">"+
                        "<td class=\"border p-0 text-center\">"+(count+1)+"</td>"+
                        "<td class=\"border p-0\"><input type=\"date\" class=\"form-control pb-0 pt-1 pt-xl-0 pl-1 pr-0 h-28 dte-trm\" id=\"dte-tgl-"+count+"\" value=\""+tgl+"\" data-value=\""+count+"\"></td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28 txt-nsup\" id=\"txt-nma-sup-"+count+"\" autocomplete=\"off\" value=\""+nsup+"\">"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28 d-none txt-sup\" id=\"txt-sup-"+count+"\" autocomplete=\"off\" data-value=\""+count+"\" value=\""+sup+"\">"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<select name=\"slct-tp-"+count+"\" id=\"slct-tp-"+count+"\" class=\"custom-select py-0 pl-1 h-28 slct-tp\">"+
                                    "<option value=\"\">Tidak ada</option>"+
                                    "<option value=\"1\">1</option>"+
                                    "<option value=\"2\">2</option>"+
                                    "<option value=\"3\">3</option>"+
                                    "<option value=\"4\">4</option>"+
                                    "<option value=\"5\">5</option>"+
                                    "<option value=\"6\">6</option>"+
                                    "<option value=\"7\">7</option>"+
                                    "<option value=\"8\">8</option>"+
                                    "<option value=\"9\">9</option>"+
                                    "<option value=\"10\">10</option>"+
                                    "<option value=\"no insang\">no insang</option>"+
                                    "<option value=\"insang\">insang</option>"+
                                "</select>"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<select name=\"slct-pro-"+count+"\" id=\"slct-pro-"+count+"\" class=\"custom-select py-0 pl-1 h-28 slct-uhs slct-pro\" data-value=\""+count+"\">"+
                                    "<option value=\"\">Pilih Produk</option>"+
                                    lpro+
                                "</select>"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<select name=\"slct-sat-"+count+"\" id=\"slct-sat-"+count+"\" class=\"custom-select py-0 pl-1 h-28 slct-uhs slct-sat\" data-value=\""+count+"\">"+
                                    "<option value=\"\">Pilih Satuan</option>"+
                                    lsat+
                                "</select>"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<input type=\"number\" class=\"form-control py-0 pl-1 h-28 text-right\" id=\"nmbr-kg-"+count+"\" autocomplete=\"off\">"+
                        "</td>"+
                        "<td class=\"border p-0 text-right\">"+
                            "<input type=\"text\" class=\"form-control py-0 pl-1 h-28 text-right\" id=\"txt-hrga-"+count+"\" autocomplete=\"off\" readonly>"+
                        "</td>"+
                        "<td class=\"border p-0 text-right\">"+
                            "<input type=\"text\" class=\"form-control py-0 pl-1 h-28 text-right\" id=\"txt-smpn-"+count+"\" autocomplete=\"off\" readonly>"+
                        "</td>"+
                        "<td class=\"border p-0\" id=\"div-btn-dtrm-"+count+"\">"+
                            "<button class=\"btn btn-light border border-primary py-0 px-1 ml-1 btn-strm2\" data-value=\""+count+"\" id=\"btn-sntrm-"+count+"\"><img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\"></button>"+
                        "</td>"+
                    "</tr>"
                )
        
                $('#txt-nma-sup-'+count).autocomplete({
                    source: lsup,
                    onSelectItem : (item) => {
                        $("#txt-sup-"+count).val(item.value);
                        getHSSup(item.value, $("#slct-pro-"+count).val(), $("#slct-sat-"+count).val(), count);
                    },
                    highlightClass: 'text-danger',
                    treshold: 0,
                });

                var table = $(".table-data").DataTable({
                    dom: 'rtip',
                    scrollY: '48vh',
                    scrollX: true,
                    pageLength : 30,
                    ordering : false,
                    autoWidth: false,
                });

                $(".dataTables_paginate.paging_simple_numbers").addClass("small").addClass("pr-2");
                $(".dataTables_info").addClass("pl-2").addClass("small");

                $(".table-data").DataTable().page('last').draw('page');
                
                var $scrollBody = $(table.table().node()).parent();
                $scrollBody.scrollTop($scrollBody.get(0).scrollHeight);

                $("#slct-tp-"+count).val(tp);
                $("#slct-pro-"+count).val(pro);
                $("#slct-sat-"+count).val(sat).change();

                $("#btn-ndtrm").attr("data-count", parseInt(count) + 1);

                $("#btn-ndtrm").prop("disabled", false);
                $("#btn-ndtrm").html("<img src=\"./bin/img/icon/plus.png\" width=\"20\" alt=\"Add\"> <span class=\"small\"> Tambah Penerimaan");
            },
            error : function(){
                $("#btn-ndtrm").prop("disabled", false);
                $("#btn-ndtrm").html("<img src=\"./bin/img/icon/plus.png\" width=\"20\" alt=\"Add\"> <span class=\"small\"> Tambah Penerimaan");
                swal("Error (ATRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function newDtlTrm()
{
    var type = $("#txt-trm-type-pro").val(), pro = $("#txt-pro").val(), nmpro = $("#txt-nma-pro").val(), kate = $("#txt-nma-kate").val(), skate = $("#txt-nma-skate").val(), grade = $("#txt-grade").val(), nmgrade = $("#txt-nma-grade").val(), sat = $("#slct-sat").val(), nmsat = UD64($("option:selected", "#slct-sat").attr("data-value")), weight = UnNumberFormat($("#txt-weight").val());
    
    if(!$("#div-err-trm-pro-1").hasClass("d-none"))
        $("#div-err-trm-pro-1").addClass("d-none");

    if(!$("#div-scs-trm-pro-1").hasClass("d-none"))
        $("#div-scs-trm-pro-1").addClass("d-none");

    if(pro === "" || sat === "" || weight === "" || weight <= 0)
        $("#div-err-trm-pro-1").removeClass("d-none");
    else
    {
        $("#btn-npnrm-pro").prop("disabled", true);
        $("#btn-npnrm-pro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        setTimeout(function(){
            var sup = $("#txt-sup").val();

            if(type === "2")
                sup = $("#edt-txt-sup").val();

            $.ajax({
                url : "./bin/php/gdthsup.php",
                type : "post",
                data : {sup : sup, grade : grade, sat : sat},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(type === "1")
                        $("#lst-ntrm").append(setToTblTrmPro2(pro, nmgrade, kate, skate, sat, weight, nmpro, nmsat, type, 0, json.data[3], grade, json.data2[3], json.aks));
                    else
                        $("#lst-etrm").append(setToTblTrmPro2(pro, nmgrade, kate, skate, sat, weight, nmpro, nmsat, type, 0, json.data[3], grade, json.data2[3], json.aks));

                    $("#mdl-ntrm-pro input").val("");

                    $("#div-scs-trm-pro-1").removeClass("d-none");

                    $("#txt-trm-type-pro").val(type);

                    $("#btn-npnrm-pro").prop("disabled", false);
                    $("#btn-npnrm-pro").html("Simpan");

                    setTimeout(function(){
                        updSumTrmTran(type);
                        updBB2Val();
                    }, 200);
                },
                error : function(){
                    $("#btn-npnrm-pro").prop("disabled", false);
                    $("#btn-npnrm-pro").html("Simpan");
                    swal("Error (NDTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDtlTrm2(x)
{
    var tgl = $("#dte-tgl-"+x).val(), sup = $("#txt-sup-"+x).val(), kg = $("#nmbr-kg-"+x).val(), tipe = $("#slct-tp-"+x).val(), sat = $("#slct-sat-"+x).val(), pro = $("#slct-pro-"+x).val();
    
    if(tgl === "" || sup === "" || kg === "" || sat === "" || pro == "")
        swal("Error (NDTRM2 - 1) !!!", "Tanggal, supplier, produk, satuan dan berat tidak boleh kosong !!!", "error");
    else
    {
        $("#btn-sntrm-"+x).prop("disabled", true);
        $("#btn-sntrm-"+x).html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ndtrm.php",
                type : "post",
                data : {tgl : tgl, sup : sup, pro : pro, kg : kg, tipe : tipe, sat : sat},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        swal("Error (NDTRM2 - 2) !!!", "Tanggal, supplier, produk, satuan dan berat tidak boleh kosong !!!", "error");
                    else if(parseInt(json.err[0]) === -2)
                        swal("Error (NDTRM2 - 3) !!!", "Tidak dapat menemukan data supplier !!!", "error");
                    else if(parseInt(json.err[0]) === -3)
                        swal("Error (NDTRM2 - 4) !!!", "Tidak dapat menemukan data produk !!!", "error");
                    else if(parseInt(json.err[0]) === -4)
                        swal("Error (NDTRM2 - 5) !!!", "Tidak dapat menemukan data satuan !!!", "error");
                    else
                    {
                        $("#dte-tgl-"+x).prop("readonly", true);
                        $("#txt-nma-sup-"+x).prop("readonly", true);
                        $("#nmbr-kg-"+x).prop("readonly", true);
                        $("#slct-sat-"+x).prop("disabled", true);
                        $("#slct-pro-"+x).prop("disabled", true);
                        $("#slct-tp-"+x).prop("disabled", true);
                        $("#div-btn-dtrm-"+x).html("");
                        
                        $('#txt-nma-sup-'+x).autocomplete({
                            source: {},
                        });
                    }
                    
                    $("#btn-sntrm-"+x).prop("disabled", false);
                    $("#btn-sntrm-"+x).html("<img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\">");
                },
                error : function(){
                    $("#btn-sntrm-"+x).prop("disabled", false);
                    $("#btn-sntrm-"+x).html("<img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\">");
                    swal("Error (NDTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updSumTrmTran(type)
{
    var len = 0, data = [], head = "", body = "", body2 = "", tname = "ntrm", n = 0;
    
    if(type === "1")
        len = parseInt($("#btn-sntrm").attr("data-count"));
    else
    {
        len = parseInt($("#btn-setrm").attr("data-count"));
        tname = "etrm";
    }

    for(var i = 0; i < len; i++)
    {
        if($("#txt-"+tname+"-pro-"+i).length === 0)
            continue;

        var grade = UD64($("#txt-"+tname+"-pro-"+i).attr("data-nmgrade")), val = $("#txt-"+tname+"-pro-"+i).val();

        var cek = false;
        for(var j = 0; j < data.length; j++)
        {
            if(data[j][0] === grade)
            {
                data[j][1] += parseFloat(val);
                data[j][2] += 1;
                cek = true;
                break;
            }
        }

        if(!cek)
        {
            data[n] = [grade, parseFloat(val), 1];
            n++;
        }
    }

    head = "<tr><th class=\"border text-center\">Grade</th>";
    body = "<tr><td class=\"border text-center\">Jumlah (KG)</td>";
    body2 = "<tr><td class=\"border font-weight-bold text-center\">Grand Total (KG)</td>";
    body3 = "<tr><td class=\"border text-center\">Jumlah (Ekor)</td>";
    var sum = 0;
    for(var i = 0; i < data.length; i++)
    {
        head += "<th class=\"border text-center\">"+data[i][0]+"</th>";
        body += "<td class=\"border text-center\">"+NumberFormat2(data[i][1])+"</td>";
        body3 += "<td class=\"border text-center\">"+NumberFormat2(data[i][2])+"</td>";

        sum += data[i][1];
    }
    head += "</tr>";
    body += "</tr>";
    body2 += "<td class=\"border text-center font-weight-bold\" colspan=\""+data.length+"\">"+NumberFormat2(sum)+"</td></tr>";
    body3 += "</tr>";

    if(type === "1")
    {
        $("#th-sntrm").html(head);
        $("#lst-snpnrm").html(body);
        $("#lst-snpnrm").append(body3);
        $("#lst-snpnrm").append(body2);
    }
    else
    {
        $("#th-setrm").html(head);
        $("#lst-sepnrm").html(body);
        $("#lst-sepnrm").append(body3);
        $("#lst-sepnrm").append(body2);
    }
}

function updMTrm()
{
    var len = $("#btn-snmtrm").attr("data-count"), arr = [];

    for(var i = 0; i < len; i++)
    {
        if($("#txt-mnm-"+i).length === 0)
            continue;

        arr.push([UD64($("#txt-mnm-"+i).attr("data-value")), UnNumberFormat($("#txt-mnm-"+i).val())]);
    }

    arr = JSON.stringify(arr);

    $("#btn-snmtrm").prop("disabled", true);
    $("#btn-snmtrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/umtrm.php",
            type : "post",
            data : {arr : arr},
            success : function(output){
                var json = $.parseJSON(output);

                $("#btn-snmtrm").prop("disabled", false);
                $("#btn-snmtrm").html("Simpan");
                swal("Sukses !!!", "Data berhasil diperbaharui !!!", "success");
            },
            error : function(){
                $("#btn-snmtrm").prop("disabled", false);
                $("#btn-snmtrm").html("Simpan");
                swal("Error (UMTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function updTrm()
{
    var id = $("#edt-txt-id").val(), sup = $("#edt-txt-sup").val(), tgl = $("#edt-dte-tgl").val(), bb = UnNumberFormat($("#edt-txt-bb").val()), poto = UnNumberFormat($("#edt-txt-poto").val()), mpoto = $("#edt-txt-poto").attr("data-value"), ket1 = $("#edt-txt-ket1").val(), ket2 = $("#edt-txt-ket2").val(), ket3 = $("#edt-txt-ket3").val(), bid = $("#edt-txt-bid").val(), kota = $("#edt-txt-kota").val(), dp = UnNumberFormat($("#edt-txt-dp").val()), vdll = UnNumberFormat($("#edt-txt-dll").val()), bb2 = UnNumberFormat($("#edt-txt-bb2").val()), min = UnNumberFormat($("#edt-txt-min").val()), vpdll = UnNumberFormat($("#edt-txt-pdll").val()), vtdll = UnNumberFormat($("#edt-txt-tdll").val()), mnm = UnNumberFormat($("#edt-txt-mnm").val()), gdg = $("#edt-slct-gdg").val();

    if(!$("#div-edt-err-trm-1").hasClass("d-none"))
        $("#div-edt-err-trm-1").addClass("d-none");

    if(!$("#div-edt-err-trm-2").hasClass("d-none"))
        $("#div-edt-err-trm-2").addClass("d-none");

    if(!$("#div-edt-err-trm-3").hasClass("d-none"))
        $("#div-edt-err-trm-3").addClass("d-none");

    if(!$("#div-edt-err-trm-4").hasClass("d-none"))
        $("#div-edt-err-trm-4").addClass("d-none");

    if(!$("#div-edt-err-trm-5").hasClass("d-none"))
        $("#div-edt-err-trm-5").addClass("d-none");

    if(!$("#div-edt-err-trm-6").hasClass("d-none"))
        $("#div-edt-err-trm-6").addClass("d-none");

    if(!$("#div-edt-err-trm-7").hasClass("d-none"))
        $("#div-edt-err-trm-7").addClass("d-none");

    if(!$("#div-edt-scs-trm-1").hasClass("d-none"))
        $("#div-edt-scs-trm-1").addClass("d-none");

    ToTop();
    if(id === "" || sup === "" || tgl === "" || parseFloat(bb) < 0 || gdg === "")
        $("#div-edt-err-trm-1").removeClass("d-none");
    else if(parseFloat(poto) > parseFloat(mpoto))
        $("#div-edt-err-trm-4").removeClass("d-none");
    else if($("#lst-etrm tr").length === 0)
        $("#div-edt-err-trm-5").removeClass("d-none");
    else
    {
        $("#btn-setrm").prop("disabled", true);
        $("#btn-setrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        var lpro = [], n = 0, dll = [], pdll = [], ldp = [], tdll = [];

        for(var i = 0; i < parseInt($("#btn-setrm").attr("data-count")); i++)
        {
            if($("#txt-etrm-pro-"+i).length === 0)
                continue;

            lpro[n] = [UD64($("#txt-etrm-pro-"+i).attr("data-value")), UnNumberFormat($("#txt-etrm-pro-"+i).val()), UD64($("#txt-etrm-pro-"+i).attr("data-stn")), UD64($("#txt-etrm-pro-"+i).attr("data-urut")), UnNumberFormat($("#txt-etrm-hrga-"+i).val()), UnNumberFormat($("#txt-etrm-smpn-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-sldll").attr("data-count")); i++)
        {
            if($("#slct-dll-"+i).length === 0)
                continue;

            dll[n] = [$("#slct-dll-"+i).val(), $("#txt-dll-"+i).val(), UnNumberFormat($("#txt-vdll-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-slpdll").attr("data-count")); i++)
        {
            if($("#slct-pdll-"+i).length === 0)
                continue;

            pdll[n] = [$("#slct-pdll-"+i).val(), $("#txt-pdll-"+i).val(), UnNumberFormat($("#txt-vpdll-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-sldp").attr("data-count")); i++)
        {
            if($("#dte-dp-"+i).length === 0)
                continue;

            ldp[n] = [$("#dte-dp-"+i).val(), UnNumberFormat($("#txt-vdp-"+i).val())];

            n++;
        }

        n = 0;
        for(var i = 0; i < parseInt($("#btn-sltdll").attr("data-count")); i++)
        {
            var kg = 0, val = 0;
            if($("#slct-tdll-"+i).length === 0)
                continue;

            if($("#slct-tdll-"+i).val() === "2")
            {
                if($("#nmbr-ktdll-"+i).val() !== "")
                    kg = $("#nmbr-ktdll-"+i).val();

                if($("#txt-ttdll-"+i).val() !== "")
                    val = UnNumberFormat($("#txt-ttdll-"+i).val());
            }

            tdll[n] = [$("#slct-tdll-"+i).val(), $("#txt-tdll-"+i).val(), UnNumberFormat($("#txt-vtdll-"+i).val()), kg, val];

            n++;
        }

        lpro = JSON.stringify(lpro);
        dll = JSON.stringify(dll);
        pdll = JSON.stringify(pdll);
        ldp = JSON.stringify(ldp);
        tdll = JSON.stringify(tdll);

        setTimeout(function(){
            $.ajax({
                url : "./bin/php/utrm.php",
                type : "post",
                data : {id : id, sup : sup, tgl : tgl, bb : bb, poto : poto, ket1 : ket1, ket2 : ket2, ket3 : ket3, bid : bid, lpro : lpro, kota : kota, dll : dll, pdll : pdll, dp : dp, vdll : vdll, vpdll : vpdll, bb2 : bb2, min : min, ldp : ldp, tdll : tdll, vtdll : vtdll, mnm : mnm, gdg : gdg},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-trm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-trm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-trm-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-trm-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-trm-5").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -6)
                        $("#div-edt-err-trm-6").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -7)
                        $("#div-edt-err-trm-7").removeClass("d-none");
                    else
                    {
                        eTrm(UE64(id));
                        schTrm($("#txt-srch-trm").val());
                        
                        $("#div-edt-scs-trm-1").removeClass("d-none");

                        //$("#mdl-etrm").modal("hide");

                        /*setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Proses penerimaan berhasil diubah, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-penerimaan?id="+UE64(id), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);*/
                    }

                    $("#btn-setrm").prop("disabled", false);
                    $("#btn-setrm").html("Simpan");
                },
                error : function(){
                    $("#btn-setrm").prop("disabled", false);
                    $("#btn-setrm").html("Simpan");
                    swal("Error (UTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delTTrm(x)
{
    x = UD64(x);
    swal({
        title : "Perhatian !!!",
        text : "Yakin hapus data pending ?",
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
                    url : "./bin/php/dttrm.php",
                    type : "post",
                    data : {id : x},
                    success : function(){
                        swal({
                            title : "Sukses !!!",
                            text : "Data berhasil dihapus !!!",
                            icon : "success",
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        })
                        .then(ok => {
                            if(ok)
                                viewTTrm();
                        });
                    },
                    error : function(){
                        swal("Error (DTTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delTrm(x)
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
                    url : "./bin/php/dtrm.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DTRM - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schTrm($("#txt-srch-trm").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delTrmPro(x, y)
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
            var type = "ntrm";

            y = UD64(y);

            if(y === "2")
                type = "etrm";

            $("#"+type+"-pro-"+x).remove();
            updSumTrmTran($("#txt-trm-type-pro").val());
        }
    })
}

function cpyTrmPro(x, y)
{
    swal({
        title : "Perhatian !!!",
        text : "Yakin duplikat data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            var type = "ntrm";

            y = UD64(y);

            if(y === "2")
                type = "etrm";

            var n = $("#btn-sntrm").attr("data-count"), l = "lst-ntrm";

            if(y === "2")
            {
                n = $("#btn-setrm").attr("data-count");
                l = "lst-etrm";
                $("#btn-setrm").attr("data-count", parseInt(n) + 1);
            }
            else
                $("#btn-sntrm").attr("data-count", parseInt(n) + 1);
                
            var str = $("#"+type+"-pro-"+x).html().replace("txt-"+type+"-pro-"+x, "txt-"+type+"-pro-"+n);
            str = str.replace("delTrmPro('"+x+"'", "delTrmPro('"+n+"'");
            str = str.replace("cpyTrmPro('"+x+"'", "cpyTrmPro('"+n+"'");
            str = str.replace("txt-"+type+"-hrga-"+x, "txt-"+type+"-hrga-"+n);
            str = str.replace("txt-"+type+"-smpn-"+x, "txt-"+type+"-smpn-"+n);
            
            $("#"+l+" tr#"+type+"-pro-"+x).after("<tr id=\""+type+"-pro-"+n+"\">"+str+"</tr>");

            $("#txt-"+type+"-pro-"+n).val(0);
            $("#txt-"+type+"-pro-"+n).prop("readonly", false);
            $("#txt-"+type+"-pro-"+n).attr("data-urut", UE64(0));
            $("#"+type+"-pro-"+n+" .btn.border-danger").removeClass("d-none");

            updSumTrmTran($("#txt-trm-type-pro").val());
        }
    })
}

function delTrmDll(x)
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
            $("#div-dtrm-"+x).remove();
    });
}

function delTrmPDll(x)
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
            $("#div-pdtrm-"+x).remove();
    });
}

function delTrmTDll(x)
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
            $("#div-tdtrm-"+x).remove();
    });
}

function delTrmDP(x)
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
            $("#div-dp-"+x).remove();
    });
}

function updBB2Val()
{
    var nsum = 0, esum = 0, nbb = parseFloat(UnNumberFormat($("#txt-bb2").val())), ebb = parseFloat(UnNumberFormat($("#edt-txt-bb2").val()));
    for(var i = 0; i < parseInt($("#btn-sntrm").attr("data-count")); i++)
    {
        if($("#txt-ntrm-pro-"+i).length === 0)
            continue;

        nsum += parseFloat(UnNumberFormat($("#txt-ntrm-pro-"+i).val()));
    }

    for(var i = 0; i < parseInt($("#btn-setrm").attr("data-count")); i++)
    {
        if($("#txt-etrm-pro-"+i).length === 0)
            continue;

        esum += parseFloat(UnNumberFormat($("#txt-etrm-pro-"+i).val()));
    }
    
    $("#txt-vbb").val(NumberFormat2(nbb * nsum));
    $("#edt-txt-vbb").val(NumberFormat2(ebb * esum));
}

function viewTrm(x = "")
{
    if(x === "")
        x = UE64($("#txt-opt-trm").val());
        
    window.open("./lihat-penerimaan?id="+x, "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

function saveOptTrm()
{
    var jns = $("#slct-lp-trm").val();

    if(!$("#div-lp1").hasClass("d-none"))
        $("#div-lp1").addClass("d-none");

    if(!$("#div-lp2").hasClass("d-none"))
        $("#div-lp2").addClass("d-none");

    if(jns === "1")
        $("#div-lp1").removeClass("d-none");
    else if(jns === "2")
        $("#div-lp2").removeClass("d-none");

    $("#mdl-opt-trm").modal("hide");
}

//CUTTING
function getNIDCut()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-cut-1").hasClass("d-none"))
            $("#div-err-cut-1").addClass("d-none");
            
        if(!$("#div-err-cut-2").hasClass("d-none"))
            $("#div-err-cut-2").addClass("d-none");
            
        if(!$("#div-scs-cut-1").hasClass("d-none"))
            $("#div-scs-cut-1").addClass("d-none");

        getSmplCut();
        $("#btn-sncut").prop("disabled", false);
        $("#btn-sncut").html("Simpan");
        $("#mdl-ncut").modal("show");

        swal.close();
    }, 200);
}

function getNIDCut2()
{
    Process();
    setTimeout(function(){
        window.location.href = "./tambah-cutting";
    }, 200);
}

function getSmplCut()
{
    var tgl = $("#dte-tgl").val();
    
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gsmplcut.php",
            type : "post",
            data : {tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                $("#nmbr-smpl").val(json.nsmpl[0]);
            },
            error : function(){
                swal("Error (GSMPLCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function schCut(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/scut.php",
            type :"post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-cut").html(setToTblCut(json));

                swal.close();
            },
            error : function(){
                swal("Error (SCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblCut(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var tmrgn = "";

            if(x.data[i][7] === "1")
                tmrgn = "<";
            else if(x.data[i][7] === "2")
                tmrgn = ">";

            var slsh = x.data[i][6]-x.data[i][14];

            hsl += "<tr ondblclick=\"viewCut('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+tmrgn+" "+NumberFormat2(parseFloat(x.data[i][2]))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][5]))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][6]))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(slsh))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][14]))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][15]))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][16]))+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eCut('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            

            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delCut('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            //if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewCut('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"Lihat Cutting\" width=\"18\"></button>";
            
                
            hsl += " </td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"11\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function eCut(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-cut-1").hasClass("d-none"))
        $("#div-edt-err-cut-1").addClass("d-none");

    if(!$("#div-edt-err-cut-2").hasClass("d-none"))
        $("#div-edt-err-cut-2").addClass("d-none");

    if(!$("#div-edt-err-cut-3").hasClass("d-none"))
        $("#div-edt-err-cut-3").addClass("d-none");

    if(!$("#div-edt-err-cut-4").hasClass("d-none"))
        $("#div-edt-err-cut-4").addClass("d-none");

    if(!$("#div-edt-err-cut-5").hasClass("d-none"))
        $("#div-edt-err-cut-5").addClass("d-none");

    if(!$("#div-edt-scs-cut-1").hasClass("d-none"))
        $("#div-edt-scs-cut-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtcut.php",
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
                                $("#txt-vkode").attr("data-type", "CUT");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setCutVerif(x);

                                gvcut = setInterval(getCutVerif, 1000);
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
                    $("#edt-txt-mrgn").val(json.data[2]);
                    $("#edt-slct-tmrgn").val(json.data[7]);
                    $("#edt-slct-gdg").val(json.data[8]);

                    $(".table-data2").DataTable().clear().destroy();
                    $("#tbl-cpro").DataTable().clear().destroy();
                    $("#tbl-cnpro").DataTable().clear().destroy();

                    $("#lst-ecut").html(setToTblECut(json));

                    for(var i = 0; i < json.count[0]; i++)
                    {
                        $("#slct-cut-"+i+"-1").val(json.data2[i][16]).change();
                        $("#slct-cut-"+i+"-2").val(json.data2[i][17]).change();
                        $("#slct-cut-"+i+"-3").val(json.data2[i][18]).change();
                        $("#slct-cut-"+i+"-4").val(json.data2[i][19]).change();
                        $("#slct-cut-"+i+"-5").val(json.data2[i][20]).change();
                        $("#slct-cut-"+i+"-6").val(json.data2[i][21]).change();
                        $("#slct-sh-"+i).val(json.data2[i][37]);
                        $("#slct-pr-"+i).val(json.data2[i][38]);
                    }

                    $("#lst-ecut-pro").html(setToTblECutPro(json));
                    $("#lst-ecut-npro").html(setToTblECutNPro(json));

                    $("#mdl-ecut").modal("show");

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $("#tbl-cpro").DataTable({
                        dom: 'frt',
                        scrollY: '28vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $("#tbl-cnpro").DataTable({
                        dom: 'frt',
                        scrollY: '28vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $(".dataTables_scrollHeadInner").addClass("w-100");

                    $("#mdl-ecut .table").css("width", "100%");

                    $("#btn-secut").prop("disabled", false);
                    $("#btn-secut").attr("data-count", json.count[0]);
                    $("#btn-secut").attr("data-ccpro", json.data3.length);
                    $("#btn-secut").attr("data-ccnpro", json.data4.length);
                    $("#btn-secut").html("Simpan");
                }
            },
            error : function(){
                swal("Error (ECUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblECut(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++)
    {
        hsl += "<tr id=\"lst-cut-pro-"+i+"\">"+
                    "<td class=\"border\">"+x.data2[i][23]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][12]+" / "+x.data2[i][13]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][14]+"</td>"+
                    "<td class=\"border\">"+x.data2[i][15]+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data2[i][11]))+"</td>"+
                    "<td class=\"border\">"+
                        "<select class=\"form-control py-0 px-1\" id=\"slct-sh-"+i+"\">"+
                            "<option value=\"R\">Rendah</option>"+
                            "<option value=\"S\">Sedang</option>"+
                            "<option value=\"T\">Tinggi</option>"+
                        "</select>"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<select class=\"form-control py-0 px-1\" id=\"slct-pr-"+i+"\">"+
                            "<option value=\"N\">Tidak</option>"+
                            "<option value=\"Y\">Premium</option>"+
                            "<option value=\"PR2\">Premium 2</option>"+
                        "</select>"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<input type=\"number\" step=\"any\" class=\"form-control py-0 px-1\" id=\"txt-cut1-"+i+"\" value=\""+x.data2[i][2]+"\" data-value=\""+UE64(x.data2[i][0])+"\" data-pro=\""+UE64(x.data2[i][1])+"\" data-urut=\""+UE64(x.data2[i][8])+"\"data-weight=\""+UE64(x.data2[i][11])+"\"data-trm=\""+UE64(x.data2[i][9])+"\"data-utrm=\""+UE64(x.data2[i][10])+"\">"+
                        "<select class=\"custom-select py-0 px-1 slct-c1\" id=\"slct-cut-"+i+"-1\" data-value=\""+i+"\"><option value=\"F\">F</option><option value=\"SP\">SP</option><option value=\"ST\">ST</option><option value=\"M\">M</option><option value=\"B\">B</option><option value=\"Dll\">Dll</option></select>"+
                        "<div class=\"input-group-append d-none\" id=\"div-pro-cut1-"+i+"\">"+
                            "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut1-"+i+"-nma\" readonly value=\""+x.data2[i][30]+"\">"+
                            "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut1-"+i+"\" value=\""+x.data2[i][24]+"\">"+
                            "<div class=\"input-group-append\">"+
                                "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut1-"+i+"\" type=\"button\" data-value=\"#txt-pro-cut1-"+i+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<input type=\"number\" step=\"any\" class=\"form-control py-0 px-1\" id=\"txt-cut2-"+i+"\" value=\""+x.data2[i][3]+"\">"+
                        "<select class=\"custom-select py-0 px-1 slct-c2\" id=\"slct-cut-"+i+"-2\" data-value=\""+i+"\"><option value=\"F\">F</option><option value=\"SP\">SP</option><option value=\"ST\">ST</option><option value=\"M\">M</option><option value=\"B\">B</option><option value=\"Dll\">Dll</option></select>"+
                        "<div class=\"input-group-append d-none\" id=\"div-pro-cut2-"+i+"\">"+
                            "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut2-"+i+"-nma\" readonly value=\""+x.data2[i][31]+"\">"+
                            "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut2-"+i+"\" readonly value=\""+x.data2[i][25]+"\">"+
                            "<div class=\"input-group-append\">"+
                                "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut2-"+i+"\" type=\"button\" data-value=\"#txt-pro-cut2-"+i+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<input type=\"number\" step=\"any\" class=\"form-control py-0 px-1\" id=\"txt-cut3-"+i+"\" value=\""+x.data2[i][4]+"\">"+
                        "<select class=\"custom-select py-0 px-1 slct-c3\" id=\"slct-cut-"+i+"-3\" data-value=\""+i+"\"><option value=\"F\">F</option><option value=\"SP\">SP</option><option value=\"ST\">ST</option><option value=\"M\">M</option><option value=\"B\">B</option><option value=\"Dll\">Dll</option></select>"+
                        "<div class=\"input-group-append d-none\" id=\"div-pro-cut3-"+i+"\">"+
                            "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut3-"+i+"-nma\" readonly value=\""+x.data2[i][32]+"\">"+
                            "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut3-"+i+"\" readonly value=\""+x.data2[i][26]+"\">"+
                            "<div class=\"input-group-append\">"+
                                "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut3-"+i+"\" type=\"button\" data-value=\"#txt-pro-cut3-"+i+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<input type=\"number\" step=\"any\" class=\"form-control py-0 px-1\" id=\"txt-cut4-"+i+"\" value=\""+x.data2[i][5]+"\">"+
                        "<select class=\"custom-select py-0 px-1 slct-c4\" id=\"slct-cut-"+i+"-4\" data-value=\""+i+"\"><option value=\"F\">F</option><option value=\"SP\">SP</option><option value=\"ST\">ST</option><option value=\"M\">M</option><option value=\"B\">B</option><option value=\"Dll\">Dll</option></select>"+
                        "<div class=\"input-group-append d-none\" id=\"div-pro-cut4-"+i+"\">"+
                            "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut4-"+i+"-nma\" readonly value=\""+x.data2[i][33]+"\">"+
                            "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut4-"+i+"\" readonly value=\""+x.data2[i][27]+"\">"+
                            "<div class=\"input-group-append\">"+
                                "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut4-"+i+"\" type=\"button\" data-value=\"#txt-pro-cut4-"+i+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border d-none\">"+
                        "<input type=\"number\" step=\"any\" class=\"form-control py-0 px-1\" id=\"txt-cut5-"+i+"\" value=\""+x.data2[i][6]+"\">"+
                        "<select class=\"custom-select py-0 px-1 slct-c5\" id=\"slct-cut-"+i+"-5\" data-value=\""+i+"\"><option value=\"F\">F</option><option value=\"SP\">SP</option><option value=\"ST\">ST</option><option value=\"M\">M</option><option value=\"B\">B</option><option value=\"Dll\">Dll</option></select>"+
                        "<div class=\"input-group-append d-none\" id=\"div-pro-cut5-"+i+"\">"+
                            "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut5-"+i+"-nma\" readonly value=\""+x.data2[i][34]+"\">"+
                            "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut5-"+i+"\" readonly value=\""+x.data2[i][28]+"\">"+
                            "<div class=\"input-group-append\">"+
                                "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut5-"+i+"\" type=\"button\" data-value=\"#txt-pro-cut5-"+i+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border d-none\">"+
                        "<input type=\"number\" step=\"any\" class=\"form-control py-0 px-1\" id=\"txt-cut6-"+i+"\" value=\""+x.data2[i][7]+"\">"+
                        "<select class=\"custom-select py-0 px-1 slct-c6\" id=\"slct-cut-"+i+"-6\" data-value=\""+i+"\"><option value=\"F\">F</option><option value=\"SP\">SP</option><option value=\"ST\">ST</option><option value=\"M\">M</option><option value=\"B\">B</option><option value=\"Dll\">Dll</option></select>"+
                        "<div class=\"input-group-append d-none\" id=\"div-pro-cut6-"+i+"\">"+
                            "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut6-"+i+"-nma\" readonly value=\""+x.data2[i][35]+"\">"+
                            "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut6-"+i+"\" readonly value=\""+x.data2[i][29]+"\">"+
                            "<div class=\"input-group-append\">"+
                                "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut6-"+i+"\" type=\"button\" data-value=\"#txt-pro-cut6-"+i+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border\"><input type=\"text\" class=\"form-control\" id=\"txt-ket-"+i+"\" value=\""+x.data2[i][22]+"\"></td>"+
                    "<td class=\"border\"><input type=\"text\" class=\"form-control\" id=\"txt-nsmpl-"+i+"\" value=\""+x.data2[i][23]+"\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delCutPro('"+i+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function setToTblECutPro(x){
    var hsl = "";

    for(var i = 0; i < x.data3.length; i++){
        var nama = x.data3[i][4]+" / "+x.data3[i][5];

        if(x.data3[i][6] !== ""){
            nama += " / "+x.data3[i][6];
        }

        if(x.data3[i][7] !== ""){
            nama += " / "+x.data3[i][7];
        }

        hsl += "<tr>"+
                    "<td class=\"border\">"+nama+"</td>"+
                    "<td class=\"border\"><input type=\"number\" class=\"form-control text-right\" value=\""+x.data3[i][2]+"\" data-value=\""+UE64(x.data3[i][1])+"\" id=\"nmbr-cpro-"+i+"\"></td>"+
                "</tr>";
    }

    return hsl;
}

function setToTblECutNPro(x){
    var hsl = "";

    for(var i = 0; i < x.data4.length; i++){
        var nama = x.data4[i][4]+" / "+x.data4[i][5];

        if(x.data4[i][6] !== ""){
            nama += " / "+x.data4[i][6];
        }

        if(x.data4[i][7] !== ""){
            nama += " / "+x.data4[i][7];
        }

        hsl += "<tr>"+
                    "<td class=\"border\">"+nama+"</td>"+
                    "<td class=\"border\"><input type=\"number\" class=\"form-control text-right\" value=\""+x.data4[i][2]+"\" data-value=\""+UE64(x.data4[i][1])+"\" id=\"nmbr-cnpro-"+i+"\"></td>"+
                "</tr>";
    }

    return hsl;
}

function mdlCut(x)
{
    x = UD64(x);

    $("#txt-opt-cut").val(x);

    $("#mdl-opt-cut").modal("show");
}

function getCutVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));
        $.ajax({
            url : "./bin/php/gdtcut.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[5] === "x")
                {
                    swal("Error (GCUTVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")

                    clearInterval(gvcut);
                }
                else if(json.data[5] !== "?" && json.data[5] !== "")
                {
                    $("#head-vkode").text(json.data[5]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[5]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvcut);
                }
            },
            error : function(){
                swal("Error (GCUTVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setCutVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/scutvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SCUTVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekCutVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eCut(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CCUTVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function addCut()
{
    var count = parseInt($("#btn-ndcut").attr("data-count")), tgl = "";

    if($("#lst-cut tr").length > 0)
        tgl = $("#lst-cut tr:last").find("input[type='date']").val();
        
    $("#btn-ndcut").prop("disabled", true);
    $("#btn-ndcut").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Tambah Baris");
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gasup.php",
            type : "post",
            data : {tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output), lst = "", hcut = $("#lst-cut").html();

                //for(var i = 0; i < json.count[0]; i++)
                    //lst += "<option value=\""+json.data[i][0]+"\">"+json.data[i][1]+"</option>";

                $(".table-data").DataTable().destroy();

                //if(count !== 0)
                    //$("#lst-cut").html(hcut);
                
                $("#lst-cut").append(
                    "<tr id=\"row-cut-"+count+"\">"+
                        "<td class=\"border p-0\"><input type=\"number\" class=\"form-control py-0 pl-1 pr-0 h-28\" id=\"nmbr-smpl-"+count+"\" autocomplete=\"off\" value=\""+json.data2[0]+"\"></td>"+
                        "<td class=\"border p-0\"><input type=\"date\" class=\"form-control pb-0 pt-1 pt-xl-0 pl-1 pr-0 h-28 dte-cut\" id=\"dte-tgl-"+count+"\" value=\""+json.data2[1]+"\" data-value=\""+count+"\"></td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<select name=\"slct-sup-"+count+"\" id=\"slct-sup-"+count+"\" class=\"custom-select py-0 pl-1 h-28 slct-sup-trm d-none\" data-value=\""+count+"\">"+
                                    "<option value=\"\">Pilih Supplier</option>"+
                                    lst+
                                "</select>"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-nma-sup-"+count+"\" autocomplete=\"off\">"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28 d-none\" id=\"txt-sup-"+count+"\" autocomplete=\"off\" data-value=\""+count+"\">"+
                                "<div class=\"input-group-append d-none\">"+
                                    "<button class=\"btn btn-light border btn-rsup p-0\" type=\"button\" data-value=\""+count+"\" id=\"btn-rsup-"+count+"\"><img src=\"./bin/img/icon/refresh.png\" width=\"15\" alt=\"Refresh\"></button>"+
                                "</div>"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<select name=\"slct-trm-"+count+"\" id=\"slct-trm-"+count+"\" class=\"custom-select py-0 pl-1 h-28\">"+
                                    "<option value=\"\" data-tt=\"\" data-urut=\"\">Tidak ada penerimaan</option>"+
                                "</select>"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28 d-none\" id=\"txt-strm-"+count+"\" autocomplete=\"off\">"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28 d-none\" id=\"txt-trm-"+count+"\" autocomplete=\"off\" data-value=\""+count+"\">"+
                                "<div class=\"input-group-append\">"+
                                    "<button class=\"btn btn-light border btn-rtrm p-0\" type=\"button\" data-value=\""+count+"\" id=\"btn-rtrm-"+count+"\"><img src=\"./bin/img/icon/refresh.png\" width=\"15\" alt=\"Refresh\"></button>"+
                                "</div>"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<select class=\"custom-select py-0 pl-1 h-28\" id=\"slct-sh-"+count+"\">"+
                                "<option value=\"R\">Rendah</option>"+
                                "<option value=\"S\">Sedang</option>"+
                                "<option value=\"T\">Tinggi</option>"+
                            "</select>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<select class=\"custom-select py-0 pl-1 h-28\" id=\"slct-pr-"+count+"\">"+
                                "<option value=\"N\">Tidak</option>"+
                                "<option value=\"Y\">Premium</option>"+
                                "<option value=\"PR2\">Premium 2</option>"+
                            "</select>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<input type=\"number\" class=\"form-control py-0 pl-1 h-28\" id=\"nmbr-c1-"+count+"\" autocomplete=\"off\">"+
                                "<div class=\"input-group-append\">"+
                                    "<select name=\"slct-c1-"+count+"\" id=\"slct-c1-"+count+"\" class=\"custom-select py-0 pl-1 h-28 slct-c1\" data-value=\""+count+"\">"+
                                        "<option value=\"F\">F</option>"+
                                        "<option value=\"SP\">SP</option>"+
                                        "<option value=\"ST\">ST</option>"+
                                        "<option value=\"M\">M</option>"+
                                        "<option value=\"B\">B</option>"+
                                        ""+
                                        "<option value=\"Dll\">Dll</option>"+
                                    "</select>"+
                                "</div>"+
                            "</div>"+
                            "<div class=\"input-group-append d-none\" id=\"div-pro-cut1-"+count+"\">"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut1-"+count+"-nma\" readonly>"+
                                "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut1-"+count+"\" readonly>"+
                                "<div class=\"input-group-append\">"+
                                    "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut1-"+count+"\" type=\"button\" data-value=\"#txt-pro-cut1-"+count+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                                "</div>"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<input type=\"number\" class=\"form-control py-0 pl-1 h-28\" id=\"nmbr-c2-"+count+"\" autocomplete=\"off\">"+
                                "<div class=\"input-group-append\">"+
                                    "<select name=\"slct-c2-"+count+"\" id=\"slct-c2-"+count+"\" class=\"custom-select py-0 pl-1 h-28 slct-c2\" data-value=\""+count+"\">"+
                                        "<option value=\"F\">F</option>"+
                                        "<option value=\"SP\">SP</option>"+
                                        "<option value=\"ST\">ST</option>"+
                                        "<option value=\"M\">M</option>"+
                                        "<option value=\"B\">B</option>"+
                                        ""+
                                        "<option value=\"Dll\">Dll</option>"+
                                    "</select>"+
                                "</div>"+
                            "</div>"+
                            "<div class=\"input-group-append d-none\" id=\"div-pro-cut2-"+count+"\">"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut2-"+count+"-nma\" readonly>"+
                                "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut2-"+count+"\" readonly>"+
                                "<div class=\"input-group-append\">"+
                                    "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut2-"+count+"\" type=\"button\" data-value=\"#txt-pro-cut2-"+count+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                                "</div>"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<input type=\"number\" class=\"form-control py-0 pl-1 h-28\" id=\"nmbr-c3-"+count+"\" autocomplete=\"off\">"+
                                "<div class=\"input-group-append\">"+
                                    "<select name=\"slct-c3-"+count+"\" id=\"slct-c3-"+count+"\" class=\"custom-select py-0 pl-1 h-28 slct-c3\" data-value=\""+count+"\">"+
                                        "<option value=\"F\">F</option>"+
                                        "<option value=\"SP\">SP</option>"+
                                        "<option value=\"ST\">ST</option>"+
                                        "<option value=\"M\">M</option>"+
                                        "<option value=\"B\">B</option>"+
                                        ""+
                                        "<option value=\"Dll\">Dll</option>"+
                                    "</select>"+
                                "</div>"+
                            "</div>"+
                            "<div class=\"input-group-append d-none\" id=\"div-pro-cut3-"+count+"\">"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut3-"+count+"-nma\" readonly>"+
                                "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut3-"+count+"\" readonly>"+
                                "<div class=\"input-group-append\">"+
                                    "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut3-"+count+"\" type=\"button\" data-value=\"#txt-pro-cut3-"+count+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                                "</div>"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\">"+
                            "<div class=\"input-group\">"+
                                "<input type=\"number\" class=\"form-control py-0 pl-1 h-28\" id=\"nmbr-c4-"+count+"\" autocomplete=\"off\">"+
                                "<div class=\"input-group-append\">"+
                                    "<select name=\"slct-c4-"+count+"\" id=\"slct-c4-"+count+"\" class=\"custom-select py-0 pl-1 h-28 slct-c4\" data-value=\""+count+"\">"+
                                        "<option value=\"F\">F</option>"+
                                        "<option value=\"SP\">SP</option>"+
                                        "<option value=\"ST\">ST</option>"+
                                        "<option value=\"M\">M</option>"+
                                        "<option value=\"B\">B</option>"+
                                        ""+
                                        "<option value=\"Dll\">Dll</option>"+
                                    "</select>"+
                                "</div>"+
                            "</div>"+
                            "<div class=\"input-group-append d-none\" id=\"div-pro-cut4-"+count+"\">"+
                                "<input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-pro-cut4-"+count+"-nma\" readonly>"+
                                "<input type=\"text\" class=\"form-control d-none\" id=\"txt-pro-cut4-"+count+"\" readonly>"+
                                "<div class=\"input-group-append\">"+
                                    "<button class=\"btn btn-light border btn-spro7 py-0 px-1 h-28\" id=\"btn-pro-cut4-"+count+"\" type=\"button\" data-value=\"#txt-pro-cut4-"+count+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                                "</div>"+
                            "</div>"+
                        "</td>"+
                        "<td class=\"border p-0\"><input type=\"text\" class=\"form-control py-0 pl-1 h-28\" id=\"txt-ket-"+count+"\" placeholder=\"\" autocomplete=\"off\"></td>"+
                        "<td class=\"border p-0\" id=\"div-btn-dcut-"+count+"\">"+
                            "<button class=\"btn btn-light border border-primary py-0 px-1 ml-1 btn-scut\" data-value=\""+count+"\" id=\"btn-sncut-"+count+"\"><img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\"></button>"+
                            "<button class=\"btn btn-light border border-danger py-0 px-1 ml-1 btn-dcut\" data-value=\""+count+"\" id=\"btn-dcut-"+count+"\"><img src=\"./bin/img/icon/cancel-icon.png\" alt=\"\" width=\"17\"></button>"+
                        "</td>"+
                    "</tr>"
                )
        
                $('#txt-nma-sup-'+count).autocomplete({
                    source: lsup,
                    onSelectItem : (item) => {
                        $("#txt-sup-"+count).val(item.value);
                        getSlctTrmCut(item.value, count);
                    },
                    highlightClass: 'text-danger',
                    treshold: 0,
                });

                var table = $(".table-data").DataTable({
                    dom: 'rtip',
                    scrollY: '48vh',
                    scrollX: true,
                    pageLength : 30,
                    ordering : false,
                    autoWidth: false,
                });

                $(".dataTables_paginate.paging_simple_numbers").addClass("small").addClass("pr-2");
                $(".dataTables_info").addClass("pl-2").addClass("small");

                $(".table-data").DataTable().page('last').draw('page');
                
                var $scrollBody = $(table.table().node()).parent();
                $scrollBody.scrollTop($scrollBody.get(0).scrollHeight);

                $("#btn-ndcut").attr("data-count", parseInt(count) + 1);

                $("#btn-ndcut").prop("disabled", false);
                $("#btn-ndcut").html("<img src=\"./bin/img/icon/plus.png\" width=\"20\" alt=\"Add\"> <span class=\"small\"> Tambah Baris");
            },
            error : function(){
                $("#btn-ndcut").prop("disabled", false);
                $("#btn-ndcut").html("<img src=\"./bin/img/icon/plus.png\" width=\"20\" alt=\"Add\"> <span class=\"small\"> Tambah Baris");
                swal("Error (ACUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function addHCutPro(){
    var count = parseInt($("#btn-ndcutpro").attr("data-count")), cset = parseInt($("#btn-ndcutpro").attr("data-cset")), tgl = "", spro = UD64($("#btn-ndcutpro").attr("data-spro"));

    if($("#lst-ncutpro tr").length > 0)
        tgl = $("#lst-ncutpro tr:last").find("input[type='date']").val();
        
    $("#btn-ndcutpro").prop("disabled", true);
    $("#btn-ndcutpro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Tambah Baris");
    setTimeout(function(){
        var set = "", lset = spro.split("||");
        $(".tbl-ncutpro").DataTable().destroy();

        for(var i = 0; i < cset; i++){
            set += "<td class=\"border p-0\">"+
                        "<input type=\"number\" class=\"form-control py-0 pl-1 h-28\" id=\"nmbr-cpro-"+count+"-"+i+"\" autocomplete=\"off\" data-value=\""+UE64(lset[i])+"\">"+
                    "</td>";
        }
        
        $("#lst-ncutpro").append(
            "<tr id=\"row-cpro-"+count+"\">"+
                "<td class=\"border p-0\"><input type=\"date\" class=\"form-control pb-0 pt-1 pt-xl-0 pl-1 pr-0 h-28\" id=\"dte-tgl-cpro-"+count+"\" value=\""+tgl+"\"></td>"+
                set+
                "<td class=\"border p-0\" id=\"div-btn-dcut-cpro-"+count+"\">"+
                    "<button class=\"btn btn-light border border-primary py-0 px-1 ml-1 btn-scpro\" data-value=\""+count+"\" id=\"btn-scpro-"+count+"\"><img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\"></button>"+
                    "<button class=\"btn btn-light border border-danger py-0 px-1 ml-1 btn-dcpro\" data-value=\""+count+"\" id=\"btn-dcpro-"+count+"\"><img src=\"./bin/img/icon/cancel-icon.png\" alt=\"\" width=\"17\"></button>"+
                "</td>"+
            "</tr>"
        )

        var table = $(".tbl-ncutpro").DataTable({
            dom: 'rtip',
            scrollY: '20vh',
            scrollX: true,
            pageLength : 10,
            ordering : false,
            autoWidth: false,
        });
        
        $(".dataTables_paginate.paging_simple_numbers").addClass("small").addClass("pr-2");
        $(".dataTables_info").addClass("pl-2").addClass("small");

        $(".tbl-ncutpro").DataTable().page('last').draw('page');
        
        var $scrollBody = $(table.table().node()).parent();
        $scrollBody.scrollTop($scrollBody.get(0).scrollHeight);

        $("#btn-ndcutpro").attr("data-count", parseInt(count) + 1);

        $("#btn-ndcutpro").prop("disabled", false);
        $("#btn-ndcutpro").html("<img src=\"./bin/img/icon/plus.png\" width=\"20\" alt=\"Add\"> <span class=\"small\"> Tambah Baris");
    }, 200);
}

function addHCutNPro(){
    var count = parseInt($("#btn-ndcutnpro").attr("data-count")), cset = parseInt($("#btn-ndcutnpro").attr("data-cset")), tgl = "", spro = UD64($("#btn-ndcutpro").attr("data-spro"));

    if($("#lst-ncutnpro tr").length > 0)
        tgl = $("#lst-ncutnpro tr:last").find("input[type='date']").val();
        
    $("#btn-ndcutnpro").prop("disabled", true);
    $("#btn-ndcutnpro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Tambah Baris");
    setTimeout(function(){
        var set = "", lset = spro.split("||");
        $(".tbl-ncutnpro").DataTable().destroy();

        for(var i = 0; i < cset; i++){
            set += "<td class=\"border p-0\">"+
                        "<input type=\"number\" class=\"form-control py-0 pl-1 h-28\" id=\"nmbr-cnpro-"+count+"-"+i+"\" autocomplete=\"off\" data-value=\""+UE64(lset[i])+"\">"+
                    "</td>";
        }
        
        $("#lst-ncutnpro").append(
            "<tr id=\"row-cnpro-"+count+"\">"+
                "<td class=\"border p-0\"><input type=\"date\" class=\"form-control pb-0 pt-1 pt-xl-0 pl-1 pr-0 h-28\" id=\"dte-tgl-cnpro-"+count+"\" value=\""+tgl+"\"></td>"+
                set+
                "<td class=\"border p-0\" id=\"div-btn-dcut-cnpro-"+count+"\">"+
                    "<button class=\"btn btn-light border border-primary py-0 px-1 ml-1 btn-scnpro\" data-value=\""+count+"\" id=\"btn-scnpro-"+count+"\"><img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\"></button>"+
                    "<button class=\"btn btn-light border border-danger py-0 px-1 ml-1 btn-dcnpro\" data-value=\""+count+"\" id=\"btn-dcnpro-"+count+"\"><img src=\"./bin/img/icon/cancel-icon.png\" alt=\"\" width=\"17\"></button>"+
                "</td>"+
            "</tr>"
        )

        var table = $(".tbl-ncutnpro").DataTable({
            dom: 'rtip',
            scrollY: '20vh',
            scrollX: true,
            pageLength : 10,
            ordering : false,
            autoWidth: false,
        });

        $(".dataTables_paginate.paging_simple_numbers").addClass("small").addClass("pr-2");
        $(".dataTables_info").addClass("pl-2").addClass("small");

        $(".tbl-ncutnpro").DataTable().page('last').draw('page');
        
        var $scrollBody = $(table.table().node()).parent();
        $scrollBody.scrollTop($scrollBody.get(0).scrollHeight);

        $("#btn-ndcutnpro").attr("data-count", parseInt(count) + 1);

        $("#btn-ndcutnpro").prop("disabled", false);
        $("#btn-ndcutnpro").html("<img src=\"./bin/img/icon/plus.png\" width=\"20\" alt=\"Add\"> <span class=\"small\"> Tambah Baris");
    }, 200);
}

function getNoSample(x, y)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gnsmpl.php",
            type : "post",
            data : {tgl : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#nmbr-smpl-"+y).val(json.data[0]);
            },
            error : function(){
                swal("Error (GNSMPL) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
            }
        })
    }, 200);
}

function getHslCut(x)
{
    $.ajax({
        url : "./bin/php/gthcut.php",
        type : "post",
        data : {tgl : x},
        success : function(output){
            var json = $.parseJSON(output), hcut = $("#slct-hcut").val(), hecut = $("#edt-slct-hcut").val();

            if(json.data[0] > 0)
            {
                $("#slct-hcut").html(
                    "<option value=\"0\">Semua</option>"
                );

                $("#edt-slct-hcut").html(
                    "<option value=\"0\">Semua</option>"
                );
            }
            else
            {
                $("#slct-hcut").html("<option value=\"0\">Semua</option>");
                $("#edt-slct-hcut").html("<option value=\"0\">Semua</option>");
                hcut = "0";
                hecut = "0";
            }

            $("#slct-grd").html(json.hgrd[0]);
            $("#edt-slct-grd").html(json.hgrd[0]);

            $("#slct-hcut").val(hcut);
            $("#edt-slct-hcut").val(hecut);
        },
        error : function(){
            swal("Error (GHCUT) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
        },
    })
}

function newDtlCut()
{
    var tgl = $("#dte-tgl").val(), pro = $("#txt-pro").val(), cut1 = $("#txt-cut1").val(), cut2 = $("#txt-cut2").val(), cut3 = $("#txt-cut3").val(), cut4 = $("#txt-cut4").val(), cut5 = $("#txt-cut5").val(), cut6 = $("#txt-cut6").val(), berat = $("#slct-weight").val(), utrm = UD64($('option:selected', '#slct-weight').attr('data-value')), utgl = $("#dte-tgl-trm").val(), trm = UD64($('option:selected', '#slct-weight').attr('data-value2')), scut1 = $("#slct-cut-1").val(), scut2 = $("#slct-cut-2").val(), scut3 = $("#slct-cut-3").val(), scut4 = $("#slct-cut-4").val(), scut5 = $("#slct-cut-5").val(), scut6 = $("#slct-cut-6").val(), ket = $("#txt-ket").val(), nsmpl = $("#nmbr-smpl").val();

    if(!$("#div-err-cut-1").hasClass("d-none"))
        $("#div-err-cut-1").addClass("d-none");

    if(!$("#div-err-cut-2").hasClass("d-none"))
        $("#div-err-cut-2").addClass("d-none");

    if(!$("#div-scs-cut-1").hasClass("d-none"))
        $("#div-scs-cut-1").addClass("d-none");

    ToTop();
    if(tgl === "" || pro === "" || berat === "" || berat < 0)
        $("#div-err-cut-1").removeClass("d-none");
    else
    {
        $("#btn-sncut").prop("disabled", true);
        $("#btn-sncut").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ndcut.php",
                type : "post",
                data : {tgl : tgl, pro : pro, berat : berat, cut1 : cut1, cut2 : cut2, cut3 : cut3, cut4 : cut4, cut5 : cut5, cut6 : cut6, utrm : utrm, trm : trm, scut1 : scut1, scut2 : scut2, scut3, scut4, scut5, scut6, ket : ket, nsmpl : nsmpl},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-cut-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-cut-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        swal("Error (NDCUT - 1) !!!", "Produk yang diterima sudah di-cutting, harap lakukan pengecekan kembali !!!", "error");
                    else if(parseInt(json.err[0]) === -5)
                        swal("Error (NDCUT - 2) !!!", "Berat hasil produk melebihi berat bahan baku !!!", "error");
                    else if(parseInt(json.err[0]) === -6)
                        swal("Error (NDCUT - 3) !!!", "No Sample pada cutting tgl tersebut sudah ada !!!", "error");
                    else
                    {
                        $("#div-scs-cut-1").removeClass("d-none");

                        $("#mdl-ncut input").val("")

                        $("#dte-tgl").val(tgl);
                        $("#dte-tgl-trm").val(utgl);
                        $("#nmbr-smpl").val(json.nsmpl[0]);
                        
                        schCut($("#txt-srch-cut").val());

                        getTrmCut();
                    }

                    $("#btn-sncut").prop("disabled", false);
                    $("#btn-sncut").html("Simpan");
                },
                error : function(){
                    $("#btn-sncut").prop("disabled", false);
                    $("#btn-sncut").html("Simpan");
                    swal("Error (NDCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDtlCut2(x)
{
    var tgl = $("#dte-tgl-"+x).val(), trm = $("#slct-trm-"+x).val(), cut1 = $("#nmbr-c1-"+x).val(), cut2 = $("#nmbr-c2-"+x).val(), cut3 = $("#nmbr-c3-"+x).val(), cut4 = $("#nmbr-c4-"+x).val(), scut1 = $("#slct-c1-"+x).val(), scut2 = $("#slct-c2-"+x).val(), scut3 = $("#slct-c3-"+x).val(), scut4 = $("#slct-c4-"+x).val(), ket = $("#txt-ket-"+x).val(), nsmpl = $("#nmbr-smpl-"+x).val(), strm = $("#slct-trm-"+x).val().split("|"), cpro1 = $("#txt-pro-cut1-"+x).val(), cpro2 = $("#txt-pro-cut2-"+x).val(), cpro3 = $("#txt-pro-cut3-"+x).val(), cpro4 = $("#txt-pro-cut4-"+x).val(), suhu = $("#slct-sh-"+x).val(), pr = $("#slct-pr-"+x).val();
    
    if(tgl === "" || trm === "")
        swal("Error (NDCUT - 1) !!!", "Tanggal dan produk tidak boleh kosong !!!", "error");
    else if((scut1 === "Dll" && cpro1 === "") || (scut2 === "Dll" && cpro2 === "") || (scut3 === "Dll" && cpro3 === "") || (scut4 === "Dll" && cpro4 === ""))
        swal("Error (NDCUT - 5) !!!", "Data produk tidak boleh kosong jika jenis cutting adalah 'Dll' !!!", "error");
    else
    {
        var trm = strm[0], utrm = strm[1], pro = strm[2];
        $("#btn-sncut-"+x).prop("disabled", true);
        $("#btn-sncut-"+x).html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ndcut.php",
                type : "post",
                data : {tgl : tgl, pro : pro, cut1 : cut1, cut2 : cut2, cut3 : cut3, cut4 : cut4, cut5 : 0, cut6 : 0, utrm : utrm, trm : trm, scut1 : scut1, scut2 : scut2, scut3 : scut3, scut4 : scut4, scut5 : 'F', scut6 : 'F', ket : ket, nsmpl : nsmpl, cpro1 : cpro1, cpro2 : cpro2, cpro3 : cpro3, cpro4 : cpro4, suhu, suhu, pr : pr},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        swal("Error (NDCUT - 2) !!!", "Tanggal dan produk tidak boleh kosong !!!", "error");
                    else if(parseInt(json.err[0]) === -2)
                        swal("Error (NDCUT - 3) !!!", "Tidak dapat menemukan produk dalam penerimaan / produk sudah pernah dicutting !!!", "error");
                    else if(parseInt(json.err[0]) === -3)
                        swal("Error (NDCUT - 4) !!!", "Produk yang diterima sudah di-cutting, harap lakukan pengecekan kembali !!!", "error");
                    else if(parseInt(json.err[0]) === -4)
                        swal("Error (NDCUT - 5) !!!", "Data produk tidak boleh kosong jika jenis cutting adalah 'Dll' !!!", "error");
                    else if(parseInt(json.err[0]) === -5)
                        swal("Error (NDCUT - 6) !!!", "Berat hasil produk melebihi berat bahan baku !!!", "error");
                    else
                    {
                        $("#nmbr-smpl-"+x).prop("readonly", true);
                        $("#dte-tgl-"+x).prop("readonly", true);
                        $("#txt-nma-sup-"+x).prop("readonly", true);
                        $("#nmbr-c1-"+x).prop("readonly", true);
                        $("#nmbr-c2-"+x).prop("readonly", true);
                        $("#nmbr-c3-"+x).prop("readonly", true);
                        $("#nmbr-c4-"+x).prop("readonly", true);
                        $("#txt-ket-"+x).prop("readonly", true);
                        $("#slct-sup-"+x).prop("disabled", true);
                        $("#slct-trm-"+x).prop("disabled", true);
                        $("#slct-sh-"+x).prop("disabled", true);
                        $("#slct-c1-"+x).prop("disabled", true);
                        $("#slct-c2-"+x).prop("disabled", true);
                        $("#slct-c3-"+x).prop("disabled", true);
                        $("#slct-c4-"+x).prop("disabled", true);
                        $("#btn-pro-cut1-"+x).prop("disabled", true);
                        $("#btn-pro-cut2-"+x).prop("disabled", true);
                        $("#btn-pro-cut3-"+x).prop("disabled", true);
                        $("#btn-pro-cut4-"+x).prop("disabled", true);
                        $("#btn-rsup-"+x).prop("disabled", true);
                        $("#btn-rtrm-"+x).prop("disabled", true);
                        $("#div-btn-dcut-"+x).html("");
                        
                        $('#txt-nma-sup-'+x).autocomplete({
                            source: {},
                        });
                    }
                    
                    $("#btn-sncut-"+x).prop("disabled", false);
                    $("#btn-sncut-"+x).html("<img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\">");
                },
                error : function(){
                    $("#btn-sncut-"+x).prop("disabled", false);
                    $("#btn-sncut-"+x).html("<img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\">");
                    swal("Error (NDCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newHCutPro(x){
    var tgl = $("#dte-tgl-cpro-"+x).val(), cset = $("#btn-ndcutpro").attr("data-cset"), lpro = [];

    for(var i = 0; i < cset; i++){
        lpro.push([UD64($("#nmbr-cpro-"+x+"-"+i).attr("data-value")), $("#nmbr-cpro-"+x+"-"+i).val()]);
    }

    if(tgl === ""){
        swal("Error (NHCUTPRO - 1) !!!", "Tanggal wajib diisi !!!", "error");
    }
    else{
        lpro = JSON.stringify(lpro);

        $("#btn-scpro-"+x).prop("disabled", true);
        $("#btn-scpro-"+x).html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nhcutpro.php",
                type : "post",
                data : {tgl : tgl, lpro : lpro},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1){
                        swal("Error (NHCUTPRO - 2) !!!", "Tanggal wajib diisi !!!", "error");
                    }
                    else if(parseInt(json.err[0]) === -2){
                        swal("Error (NHCUTPRO - 3) !!!", "Tidak ditemukan data cutting pada tanggal tersebut !!!", "error");
                    }
                    else if(parseInt(json.err[0]) === -3){
                        swal("Error (NHCUTPRO - 4) !!!", "Hasil KG melebihi bahan baku !!!", "error");
                    }
                    else{
                        $("#dte-tgl-cpro-"+x).attr("readonly", true);

                        for(var i = 0; i < cset; i++){
                            $("#nmbr-cpro-"+x+"-"+i).attr("readonly", true);
                        }

                        $("#div-btn-dcut-cpro-"+x).addClass("d-none");
                    }
                    
                    $("#btn-scpro-"+x).prop("disabled", false);
                    $("#btn-scpro-"+x).html("<img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\">");
                },
                error : function(){
                    $("#btn-scpro-"+x).prop("disabled", false);
                    $("#btn-scpro-"+x).html("<img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\">");

                    swal("Error (NHCUTPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newHCutNPro(x){
    var tgl = $("#dte-tgl-cnpro-"+x).val(), cset = $("#btn-ndcutnpro").attr("data-cset"), lpro = [];

    for(var i = 0; i < cset; i++){
        lpro.push([UD64($("#nmbr-cnpro-"+x+"-"+i).attr("data-value")), $("#nmbr-cnpro-"+x+"-"+i).val()]);
    }

    if(tgl === ""){
        swal("Error (NHCUTNPRO - 1) !!!", "Tanggal wajib diisi !!!", "error");
    }
    else{
        lpro = JSON.stringify(lpro);

        $("#btn-scnpro-"+x).prop("disabled", true);
        $("#btn-scnpro-"+x).html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nhcutnpro.php",
                type : "post",
                data : {tgl : tgl, lpro : lpro},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1){
                        swal("Error (NHCUTNPRO - 2) !!!", "Tanggal wajib diisi !!!", "error");
                    }
                    else if(parseInt(json.err[0]) === -2){
                        swal("Error (NHCUTNPRO - 3) !!!", "Tidak ditemukan data cutting pada tanggal tersebut !!!", "error");
                    }
                    else if(parseInt(json.err[0]) === -3){
                        swal("Error (NHCUTNPRO - 4) !!!", "Hasil KG melebihi bahan baku !!!", "error");
                    }
                    else{
                        $("#dte-tgl-cnpro-"+x).attr("readonly", true);

                        for(var i = 0; i < cset; i++){
                            $("#nmbr-cnpro-"+x+"-"+i).attr("readonly", true);
                        }

                        $("#div-btn-dcut-cnpro-"+x).addClass("d-none");
                    }
                    
                    $("#btn-scnpro-"+x).prop("disabled", false);
                    $("#btn-scnpro-"+x).html("<img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\">");
                },
                error : function(){
                    $("#btn-scnpro-"+x).prop("disabled", false);
                    $("#btn-scnpro-"+x).html("<img src=\"./bin/img/icon/save-icon.png\" alt=\"\" width=\"18\">");

                    swal("Error (NHCUTNPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updCut()
{
    var id= $("#edt-txt-id").val(), tgl = $("#edt-dte-tgl").val(), margin = $("#edt-txt-mrgn").val(), lpro = [], tmargin = $("#edt-slct-tmrgn").val(), n = 0, gdg = $("#edt-slct-gdg").val(), lcpro = [], lcnpro = [];

    $(".table-data2").DataTable().destroy();
    $("#tbl-cpro").DataTable().destroy();
    $("#tbl-cnpro").DataTable().destroy();

    for(var i = 0; i < $("#btn-secut").attr("data-count"); i++)
    {
        if($("#txt-cut1-"+i).length === 0)
            continue;

        lpro[n] = [UD64($("#txt-cut1-"+i).attr("data-value")), UD64($("#txt-cut1-"+i).attr("data-pro")), $("#txt-cut1-"+i).val(), $("#txt-cut2-"+i).val(), $("#txt-cut3-"+i).val(), $("#txt-cut4-"+i).val(), $("#txt-cut5-"+i).val(), $("#txt-cut6-"+i).val(), UD64($("#txt-cut1-"+i).attr("data-urut")), UD64($("#txt-cut1-"+i).attr("data-trm")), UD64($("#txt-cut1-"+i).attr("data-utrm")), UD64($("#txt-cut1-"+i).attr("data-weight")), $("#slct-cut-"+i+"-1").val(), $("#slct-cut-"+i+"-2").val(), $("#slct-cut-"+i+"-3").val(), $("#slct-cut-"+i+"-4").val(), $("#slct-cut-"+i+"-5").val(), $("#slct-cut-"+i+"-6").val(), $("#txt-ket-"+i).val(), $("#txt-nsmpl-"+i).val(), $("#txt-pro-cut1-"+i).val(), $("#txt-pro-cut2-"+i).val(), $("#txt-pro-cut3-"+i).val(), $("#txt-pro-cut4-"+i).val(), $("#txt-pro-cut5-"+i).val(), $("#txt-pro-cut6-"+i).val(), $("#slct-sh-"+i).val(), $("#slct-pr-"+i).val()];

        n++;
    }

    for(var i = 0; i < $("#btn-secut").attr("data-ccpro"); i++){
        lcpro.push([UD64($("#nmbr-cpro-"+i).attr("data-value")), $("#nmbr-cpro-"+i).val()]);
    }

    for(var i = 0; i < $("#btn-secut").attr("data-ccnpro"); i++){
        lcnpro.push([UD64($("#nmbr-cnpro-"+i).attr("data-value")), $("#nmbr-cnpro-"+i).val()]);
    }

    lpro = JSON.stringify(lpro);
    lcpro = JSON.stringify(lcpro);
    lcnpro = JSON.stringify(lcnpro);
    
    if(!$("#div-edt-err-cut-1").hasClass("d-none"))
        $("#div-edt-err-cut-1").addClass("d-none");

    if(!$("#div-edt-err-cut-2").hasClass("d-none"))
        $("#div-edt-err-cut-2").addClass("d-none");

    if(!$("#div-edt-err-cut-3").hasClass("d-none"))
        $("#div-edt-err-cut-3").addClass("d-none");

    if(!$("#div-edt-err-cut-4").hasClass("d-none"))
        $("#div-edt-err-cut-4").addClass("d-none");

    if(!$("#div-edt-err-cut-5").hasClass("d-none"))
        $("#div-edt-err-cut-5").addClass("d-none");

    if(!$("#div-edt-scs-cut-1").hasClass("d-none"))
        $("#div-edt-scs-cut-1").addClass("d-none");

    ToTop();
    if(tgl === "" || margin === "" || gdg === ""){
        $("#div-edt-err-cut-1").removeClass("d-none");
        
        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });

        $("#tbl-cpro").DataTable({
            dom: 'frt',
            scrollY: '28vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });

        $("#tbl-cnpro").DataTable({
            dom: 'frt',
            scrollY: '28vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });
    }
    else if(lpro.length === 0){
        $("#div-edt-err-cut-2").removeClass("d-none");

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });

        $("#tbl-cpro").DataTable({
            dom: 'frt',
            scrollY: '28vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });

        $("#tbl-cnpro").DataTable({
            dom: 'frt',
            scrollY: '28vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });
    }
    else{
        Process();
        $("#btn-secut").prop("disabled", true);
        $("#btn-secut").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ucut.php",
                type : "post",
                data : {id : id, tgl : tgl, margin : margin, lpro : lpro, tmargin : tmargin, gdg : gdg, lcpro : lcpro, lcnpro : lcnpro},
                success : function(output){
                    var json = $.parseJSON(output);

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $("#tbl-cpro").DataTable({
                        dom: 'frt',
                        scrollY: '28vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $("#tbl-cnpro").DataTable({
                        dom: 'frt',
                        scrollY: '28vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-cut-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-cut-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-cut-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-cut-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-cut-5").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-cut-1").removeClass("d-none");

                        schCut($("#txt-srch-cut").val());

                        schTrmItm($("#txt-srch-strm-itm").val());

                        $("#mdl-ecut").modal("hide");
                    }

                    swal.close();
                    $("#btn-secut").prop("disabled", false);
                    $("#btn-secut").html("Simpan");
                },
                error : function(){
                    $("#btn-secut").prop("disabled", false);
                    $("#btn-secut").html("Simpan");
                    swal("Error (UCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delCut(x)
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
                    url : "./bin/php/dcut.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DCUT - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                {
                                    schCut($("#txt-srch-cut").val());
                                    
                                    schTrmItm($("#txt-srch-strm-itm").val());
                                }
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delCut2(x, y, z)
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
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dcut2.php",
                    type : "post",
                    data : {id : x, urut : y},
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
                                $("#row-cut-"+z).remove();
                        });
                    },
                    error : function(){
                        swal("Error (DCUT2) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delCutPro(x, y)
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

            $("#lst-cut-pro-"+x).remove();
    
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

function delCutPro2(x)
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
            $("#row-cut-"+x).remove();
    })
}

function delHCutPro(x){
    swal({
        title : "Perhatian !!!",
        icon : "warning",
        text : "Anda yakin hapus data ?",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) => {
        if(ok){
            $(".tbl-ncutpro").DataTable().destroy();

            $("#row-cpro-"+x).remove();
    
            $(".tbl-ncutpro").DataTable({
                dom: 'frt',
                scrollY: '20vh',
                scrollX: true,
                paging: false,
                autoWidth: false,
            });

            $(".dataTables_scrollHeadInner").addClass("w-100");

            $(".table").css("width", "100%");
        }
    })
}

function delHCutNPro(x){
    swal({
        title : "Perhatian !!!",
        icon : "warning",
        text : "Anda yakin hapus data ?",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) => {
        if(ok){
            $(".tbl-ncutnpro").DataTable().destroy();

            $("#row-cnpro-"+x).remove();
    
            $(".tbl-ncutnpro").DataTable({
                dom: 'frt',
                scrollY: '20vh',
                scrollX: true,
                paging: false,
                autoWidth: false,
            });

            $(".dataTables_scrollHeadInner").addClass("w-100");

            $(".table").css("width", "100%");
        }
    })
}

function viewCut(x = "")
{
    if(x === "")
        x = UE64($("#txt-opt-cut").val());
        
    window.open("./lihat-cutting?id="+x, "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//VACUUM
function getNIDVac()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-vac-1").hasClass("d-none"))
            $("#div-err-vac-1").addClass("d-none");

        if(!$("#div-err-vac-2").hasClass("d-none"))
            $("#div-err-vac-2").addClass("d-none");

        if(!$("#div-err-vac-3").hasClass("d-none"))
            $("#div-err-vac-3").addClass("d-none");

        if(!$("#div-err-vac-4").hasClass("d-none"))
            $("#div-err-vac-4").addClass("d-none");

        if(!$("#div-err-vac-5").hasClass("d-none"))
            $("#div-err-vac-5").addClass("d-none");

        if(!$("#div-scs-vac-1").hasClass("d-none"))
            $("#div-scs-vac-1").addClass("d-none");

        $("#btn-snvac").prop("disabled", false);
        $("#btn-snvac").html("Simpan");

        getHslCut($("#dte-ctgl").val());

        $("#mdl-nvac").modal("show");

        swal.close();
    }, 200);
}

function schVac(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/svac.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-vac").html(setToTblVac(json));

                swal.close();
            },
            error : function(){
                swal("Error (SVAC) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVac(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var dtl = "", weight = x.data[i][6], bsjd = "";
            for(var j = 0; j < x.data2[i].length; j++)
            {
                dtl += "<li>"+x.data2[i][j][0];
                
                if(x.data2[i][j][1] !== "" && x.data2[i][j][1] !== null)
                    dtl += " / "+x.data2[i][j][1];
                
                if(x.data2[i][j][2] !== "" && x.data2[i][j][2] !== null)
                    dtl += " / "+x.data2[i][j][2];
                
                if(x.data2[i][j][3] !== "" && x.data2[i][j][3] !== null)
                    dtl += " / "+x.data2[i][j][3];
                    
                dtl += " ("+NumberFormat2(x.data2[i][j][4])+" KG)</li>";
            }

            if(x.data[i][2] === "1" && x.data[i][18] !== "0")
            {
                if(x.data[i][18] === "1")
                    weight = x.data[i][6] - x.data[i][17] - x.data[i][26];
                else
                    weight = x.data[i][17];
            }

            if(x.data[i][5] !== "")
            {
                bsjd += "<li>"+x.data[i][8];

                if(x.data[i][14])
                    bsjd += " / "+x.data[i][14];

                if(x.data[i][9])
                    bsjd += " / "+x.data[i][9];

                if(x.data[i][10])
                    bsjd += " / "+x.data[i][10];
                
                bsjd += " ("+NumberFormat2(x.data[i][25])+" KG)</li>";
            }
            
            if(x.data[i][19] !== "")
            {
                bsjd += "<li>"+x.data[i][21];

                if(x.data[i][22])
                    bsjd += " / "+x.data[i][22];

                if(x.data[i][23])
                    bsjd += " / "+x.data[i][23];

                if(x.data[i][24])
                    bsjd += " / "+x.data[i][24];
                
                bsjd += " ("+NumberFormat2(x.data[i][20])+" KG)</li>";
            }

            hsl += "<tr ondblclick=\"viewVac('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\"><ul class=\"small\">"+bsjd+"</ul></td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][16])+"</td>"+
                        "<td class=\"border\">"+x.data[i][15]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(weight))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][11]))+"</td>"+
                        "<td class=\"border small\"><ul>"+dtl+"</ul></td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eVac('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delVac('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            //if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewVac('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"Lihat Vacuum\" width=\"18\"></button>";
            
                
            hsl += " </td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                "<td colspan=\"14\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
            "</tr>";

    return hsl;
}

function eVac(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-vac-1").hasClass("d-none"))
        $("#div-edt-err-vac-1").addClass("d-none");

    if(!$("#div-edt-err-vac-2").hasClass("d-none"))
        $("#div-edt-err-vac-2").addClass("d-none");

    if(!$("#div-edt-err-vac-3").hasClass("d-none"))
        $("#div-edt-err-vac-3").addClass("d-none");

    if(!$("#div-edt-err-vac-4").hasClass("d-none"))
        $("#div-edt-err-vac-4").addClass("d-none");

    if(!$("#div-edt-err-vac-5").hasClass("d-none"))
        $("#div-edt-err-vac-5").addClass("d-none");

    if(!$("#div-edt-err-vac-6").hasClass("d-none"))
        $("#div-edt-err-vac-6").addClass("d-none");

    if(!$("#div-edt-err-vac-7").hasClass("d-none"))
        $("#div-edt-err-vac-7").addClass("d-none");

    if(!$("#div-edt-err-vac-8").hasClass("d-none"))
        $("#div-edt-err-vac-8").addClass("d-none");

    if(!$("#div-edt-err-vac-9").hasClass("d-none"))
        $("#div-edt-err-vac-9").addClass("d-none");

    if(!$("#div-edt-scs-vac-1").hasClass("d-none"))
        $("#div-edt-scs-vac-1").addClass("d-none");

    if(!$("#edt-div-ptype").hasClass("d-none"))
        $("#edt-div-ptype").addClass("d-none");

    if(!$("#edt-div-ctype").hasClass("d-none"))
        $("#edt-div-ctype").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtvac.php",
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
                                $("#txt-vkode").attr("data-type", "VAC");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setVacVerif(x);

                                gvvac = setInterval(getVacVerif, 1000);
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
                    $("#edt-slct-type").val(json.data[2]);
                    $("#edt-txt-nma-pro").val(json.pro[1]);
                    $("#edt-txt-pro").val(json.data[5]);
                    $("#edt-txt-weight-pro").val(json.data[6]);
                    $("#edt-txt-nma-grade").val(json.pro[2]);
                    $("#edt-txt-nma-kate").val(json.pro[3]);
                    $("#edt-txt-nma-skate").val(json.pro[4]);
                    $("#edt-dte-ctgl").val(json.data[3]);
                    $("#edt-slct-tmrgn").val(json.data[9]);
                    $("#edt-txt-mrgn").val(json.data[8]);
                    $("#edt-slct-hcut").val(json.data[14]);
                    $("#edt-slct-gdg").val(json.data[17]);

                    $("#edt-txt-nma-pro3").val(json.pro2[1]);
                    $("#edt-txt-pro3").val(json.data[15]);
                    $("#edt-txt-weight-pro3").val(json.data[16]);
                    $("#edt-txt-nma-grade3").val(json.pro2[2]);
                    $("#edt-txt-nma-kate3").val(json.pro2[3]);
                    $("#edt-txt-nma-skate3").val(json.pro2[4]);

                    if(json.data[2] === "1")
                    {
                        $("#edt-div-ctype").removeClass("d-none");
                        $("#edt-txt-ket-cpro").val(json.data[12]);
                        $("#edt-txt-thp-cpro").val(json.data[13]);
                    }
                    else if(json.data[2] === "2")
                    {
                        $("#edt-div-ptype").removeClass("d-none");
                        $("#edt-txt-ket-pro").val(json.data[12]);
                        $("#edt-txt-thp").val(json.data[13]);
                    }

                    $(".table-data2").DataTable().clear().destroy();

                    $("#lst-evac").html(setToTblEVac(json));

                    for(var i = 0; i < json.count[1]; i++){
                        $("#edt-slct-grd-"+i).val(json.data3[i][9]);
                    }

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $(".dataTables_scrollHeadInner").addClass("w-100");

                    $(".table").css("width", "100%");

                    lvgrade = json.lgrade;

                    $("#btn-sevac").attr("data-count", json.count[1]);

                    $("#edt-slct-type").change();

                    $("#btn-sevac").prop("disabled", false);
                    $("#btn-sevac").html("Simpan");

                    getHslCut(json.data[3]);

                    $("#mdl-evac").modal("show");
                }
            },
            error : function(){
                swal("Error (EVAC) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblEVac(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[1]; i++){
        var nma = x.data3[i][4]+" / "+x.data3[i][7];

        if(x.data3[i][5] !== ""){
            nma += " / "+x.data3[i][5];
        }
        
        if(x.data3[i][6] !== ""){
            nma += " / "+x.data3[i][6];
        }

        hsl += "<tr id=\"lst-vac-pro-"+i+"\">"+
                    "<td class=\"border\">"+nma+"</td>"+
                    "<td class=\"border\"><input type=\"number\" step=\"any\" class=\"form-control\" id=\"txt-weight-"+i+"\" value=\""+x.data3[i][2]+"\" data-pro=\""+UE64(x.data3[i][1])+"\" data-urut=\""+UE64(x.data3[i][3])+"\"></td>"+
                    "<td class=\"border\"><input type=\"text\" maxlength=\"100\" class=\"form-control\" id=\"txt-ket-"+i+"\" value=\""+x.data3[i][8]+"\"></td>"+
                    "<td class=\"border\"><select class=\"custom-select\" id=\"edt-slct-grd-"+i+"\">"+x.hgrd[0]+"</select></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delVacPro('"+i+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function mdlVac(x)
{
    x = UD64(x);

    $("#txt-opt-vac").val(x);

    $("#mdl-opt-vac").modal("show");
}

function getVacVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));
        $.ajax({
            url : "./bin/php/gdtvac.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[10] === "x")
                {
                    swal("Error (GVACVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide");
                    
                    clearInterval(gvvac);
                }
                else if(json.data[10] !== "?" && json.data[10] !== "")
                {
                    $("#head-vkode").text(json.data[10]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[10]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvvac);
                }
            },
            error : function(){
                swal("Error (GVACVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setVacVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/svacvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SVACVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekVacVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eVac(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CVACVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function setVacPVerif(pro, brt, tgl)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/svacpvrf.php",
            type : "post",
            data : {pro : pro, brt : brt, tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                $("#dte-tgl").attr("data-verif", json.vpid[0]);
            },
            error : function(){
                swal("Error (SVACPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function getVacPVerif()
{
    setTimeout(function(){
        var id = $("#dte-tgl").attr("data-verif");
        $.ajax({
            url : "./bin/php/gdtpvrf.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[7] === "C")
                {
                    swal("Error (GVACPVRF) !!!", "Permintaan verifikasi di tolak !!!", "error");
                    
                    clearInterval(gvpvac);
                }
                else if(json.data[7] === "V")
                {
                    clearInterval(gvpvac);
                    setTimeout(function(){
                        newDtlVac();
                    }, 200);
                }
            },
            error : function(){
                swal("Error (GVACPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function getWeightVacPro()
{
    var tgl = $("#dte-tgl").val(), id = $("#txt-pro2").val();

    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gwvacpro.php",
            type : "post",
            data : {id : id, tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                if($("#txt-weight-fsh").length > 0)
                    $("#txt-weight-fsh").val(NumberFormat2(parseFloat(json.data[0])));
                    
                if($("#txt-weight-dfz").length > 0)
                    $("#txt-weight-dfz").val(NumberFormat2(parseFloat(json.data[1])));
            },
            error : function(){
                swal("Error (GWVACPRO) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
            },
        })
    }, 200)
}

function reVPro2(x)
{
    if(x === "N")
    {
        $("#txt-nma-pro3").val("");
        $("#txt-pro3").val("");
        $("#txt-weight-pro3").val(0);
        $("#txt-nma-grade3").val("");
        $("#txt-nma-kate3").val("");
        $("#txt-nma-skate3").val("");
    }
    else if(x === "E")
    {
        $("#edt-txt-nma-pro3").val("");
        $("#edt-txt-pro3").val("");
        $("#edt-txt-weight-pro3").val(0);
        $("#edt-txt-nma-grade3").val("");
        $("#edt-txt-nma-kate3").val("");
        $("#edt-txt-nma-skate3").val("");
    }
}

function newDtlVac()
{
    var tgl = $("#dte-tgl").val(), type = $("#slct-type").val(), fnmpro = $("#txt-nma-pro").val(), fpro = $("#txt-pro").val(), fbrt = $("#txt-weight-pro").val(), pro = $("#txt-pro2").val(), brt = $("#txt-weight").val(), ctgl = $("#dte-ctgl").val(), fnmgrade = $("#txt-nma-grade").val(), fnmkate = $("#txt-nma-kate").val(), fnmskate = $("#txt-nma-skate").val(), ket = $("#txt-ket").val(), ketp = $("#txt-ket-pro").val(), thp = $("#txt-thp").val(), hcut = $("#slct-hcut").val(), fnmpro2 = $("#txt-nma-pro3").val(), fpro2 = $("#txt-pro3").val(), fbrt2 = $("#txt-weight-pro3").val(), fnmgrade2 = $("#txt-nma-grade3").val(), fnmkate2 = $("#txt-nma-kate3").val(), fnmskate2 = $("#txt-nma-skate3").val(), vid = $("#dte-tgl").attr("data-verif"), grade = $("#slct-grd").val();

    if(type === "1")
    {
        ketp = $("#txt-ket-cpro").val();
        thp = $("#txt-thp-cpro").val();
    }

    if(!$("#div-err-vac-1").hasClass("d-none"))
        $("#div-err-vac-1").addClass("d-none");

    if(!$("#div-err-vac-2").hasClass("d-none"))
        $("#div-err-vac-2").addClass("d-none");

    if(!$("#div-err-vac-3").hasClass("d-none"))
        $("#div-err-vac-3").addClass("d-none");

    if(!$("#div-err-vac-4").hasClass("d-none"))
        $("#div-err-vac-4").addClass("d-none");

    if(!$("#div-err-vac-5").hasClass("d-none"))
        $("#div-err-vac-5").addClass("d-none");

    if(!$("#div-scs-vac-1").hasClass("d-none"))
        $("#div-scs-vac-1").addClass("d-none");

    if(tgl === "" || (type === "1" && ctgl === "") || (type === "2" && (fpro === "" || fbrt === "")) || pro === "" || brt === "")
        $("#div-err-vac-1").removeClass("d-none");
    else
    {
        $("#btn-snvac").prop("disabled", true);
        $("#btn-snvac").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ndvac.php",
                type : "post",
                data : {tgl : tgl, type : type, fpro : fpro, fbrt : fbrt, pro : pro, brt : brt, ctgl : ctgl, ket : ket, ketp : ketp, thp : thp, hcut : hcut, fpro2 : fpro2, fbrt2 : fbrt2, vid : vid, grade : grade},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-vac-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-vac-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3){
                        //$("#div-err-vac-3").removeClass("d-none");
                        swal({
                            title : "Perhatian !!!",
                            text : "Berat bahan pertama melebihi sisa stock, minta verifikasi ?",
                            icon : "warning",
                            dangerMode : true,
                            buttons : true,
                        })
                        .then((ok) => {
                            if(ok){
                                setVacPVerif(fpro, fbrt, tgl);
                                gvpvac = setInterval(getVacPVerif, 1000);
                                Process();
                            }
                        })
                    }
                    else if(parseInt(json.err[0]) === -4){
                        //$("#div-err-vac-4").removeClass("d-none");
                        swal({
                            title : "Perhatian !!!",
                            text : "Berat bahan kedua melebihi sisa stock, minta verifikasi ?",
                            icon : "warning",
                            dangerMode : true,
                            buttons : true,
                        })
                        .then((ok) => {
                            if(ok){
                                setVacPVerif(fpro2, fbrt2, tgl);
                                gvpvac = setInterval(getVacPVerif, 1000);
                                Process();
                            }
                        })
                    }
                    else if(parseInt(json.err[0]) === -5)
                        swal("Error (NDVAC - 1) !!!", "Berat hasil produk melebihi berat bahan baku !!!", "error");
                    else if(parseInt(json.err[0]) === -6)
                        $("#div-err-vac-5").removeClass("d-none");
                    else
                    {
                        $("#div-scs-vac-1").removeClass("d-none");

                        $("#mdl-nvac input").val("");
                        $("#dte-tgl").val(tgl);
                        $("#dte-ctgl").val(ctgl);
                        $("#slct-type").val(type);
                        $("#txt-pro").val(fpro);
                        $("#txt-nma-pro").val(fnmpro);
                        $("#txt-nma-grade").val(fnmgrade);
                        $("#txt-nma-kate").val(fnmkate);
                        $("#txt-nma-skate").val(fnmskate);
                        $("#txt-weight-pro").val(fbrt);
                        $("#txt-pro3").val(fpro2);
                        $("#txt-nma-pro3").val(fnmpro2);
                        $("#txt-nma-grade3").val(fnmgrade2);
                        $("#txt-nma-kate3").val(fnmkate2);
                        $("#txt-nma-skate3").val(fnmskate2);
                        $("#txt-weight-pro3").val(fbrt2);
                        $("#txt-ket").val(ket);
                        $("#dte-tgl").attr("data-verif", "");

                        schVac($("#txt-srch-vac").val());
                    }

                    $("#btn-snvac").prop("disabled", false);
                    $("#btn-snvac").html("Simpan");
                },
                error : function(){
                    $("#btn-snvac").prop("disabled", false);
                    $("#btn-snvac").html("Simpan");
                    swal("Error (NDVAC) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDtlEVac()
{
    var pro = $("#edt-txt-pro2").val(), nmpro = $("#edt-txt-nma-pro2").val(), kate = $("#edt-txt-nma-kate2").val(), skate = $("#edt-txt-nma-skate2").val(), weight = UnNumberFormat($("#edt-txt-weight").val()), n = parseInt($("#btn-sevac").attr("data-count")), grade = $("#edt-txt-nma-grade2").val(), ket = $("#edt-txt-ket").val(), vgrade = $("#edt-slct-grd").val();

    if(!$("#div-err-vac-pro-1").hasClass("d-none"))
        $("#div-err-vac-pro-1").addClass("d-none");

    if(!$("#div-scs-vac-pro-1").hasClass("d-none"))
        $("#div-scs-vac-pro-1").addClass("d-none");

    if(pro === "" || weight === "")
        $("#div-err-vac-pro-1").removeClass("d-none");
    else
    {
        $("#btn-sevac-pro").prop("disabled", true);
        $("#btn-sevac-pro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        $(".table-data2").DataTable().destroy();

        $("#lst-evac").append(setToTblEVacPro(pro, nmpro, kate, skate, weight, grade, ket, lvgrade, vgrade));

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });

        $(".dataTables_scrollHeadInner").addClass("w-100");

        $(".table").css("width", "100%");

        $("#btn-sevac").attr("data-count", n + 1);
        
        $("#div-scs-vac-pro-1").removeClass("d-none");

        $("#mdl-npro-vac input").val("");

        $("#btn-sevac-pro").prop("disabled", false);
        $("#btn-sevac-pro").html("Simpan");
    }
}

function setToTblEVacPro(pro, nmpro, kate, skate, weight, grade, ket, lgrade, vgrade)
{
    var n = $("#btn-sevac").attr("data-count"), nma = nmpro + " / " + grade, hgrd = "<option value=\"\">Tanpa grade</option>";

    if(kate !== ""){
        nma += " / "+kate;
    }

    if(skate !== ""){
        nma += " / "+skate;
    }

    for(var i = 0; i < lgrade.length; i++){
        var slct = "";

        if(lgrade[i][0] === vgrade){
            slct = "selected=\"selected\"";
        }

        hgrd += "<option value=\""+lgrade[i][0]+"\" "+slct+">"+lgrade[i][1]+"</option>";
    }

    return "<tr id=\"lst-vac-pro-"+n+"\">"+
                "<td class=\"border\">"+nma+"</td>"+
                "<td class=\"border\"><input type=\"number\" step=\"any\" class=\"form-control\" id=\"txt-weight-"+n+"\" value=\""+weight+"\" data-pro=\""+UE64(pro)+"\" data-urut=\""+UE64(0)+"\"></td>"+
                "<td class=\"border\"><input type=\"text\" step=\"any\" class=\"form-control\" id=\"txt-ket-"+n+"\" value=\""+ket+"\"></td>"+
                "<td class=\"border\"><select class=\"custom-select\" id=\"edt-slct-grd-"+n+"\">"+hgrd+"</select></td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delVacPro('"+n+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>";
}

function updVac()
{
    var tgl = $("#edt-dte-tgl").val(), id = $("#edt-txt-id").val(), type = $("#edt-slct-type").val(), fpro = $("#edt-txt-pro").val(), fbrt = $("#edt-txt-weight-pro").val(), ctgl = $("#edt-dte-ctgl").val(), tmargin = $("#edt-slct-tmrgn").val(), margin = $("#edt-txt-mrgn").val(), lpro = [], n = 0, ket = $("#edt-txt-ket-pro").val(), thp = $("#edt-txt-thp").val(), hcut = $("#edt-slct-hcut").val(), fpro2 = $("#edt-txt-pro3").val(), fbrt2 = $("#edt-txt-weight-pro3").val(), gdg = $("#edt-slct-gdg").val();

    $(".table-data2").DataTable().destroy();

    if(type === "1")
    {
        ket = $("#edt-txt-ket-cpro").val();
        thp = $("#edt-txt-thp-cpro").val();
    }

    for(var i = 0; i < parseInt($("#btn-sevac").attr("data-count")); i++)
    {
        if($("#txt-weight-"+i).length === 0)
            continue;

        lpro[n] = [UD64($("#txt-weight-"+i).attr("data-pro")), $("#txt-weight-"+i).val(), UD64($("#txt-weight-"+i).attr("data-urut")), $("#txt-ket-"+i).val(), $("#edt-slct-grd-"+i).val()];
        
        n++;
    }

    lpro = JSON.stringify(lpro);

    if(!$("#div-edt-err-vac-1").hasClass("d-none"))
        $("#div-edt-err-vac-1").addClass("d-none");

    if(!$("#div-edt-err-vac-2").hasClass("d-none"))
        $("#div-edt-err-vac-2").addClass("d-none");

    if(!$("#div-edt-err-vac-3").hasClass("d-none"))
        $("#div-edt-err-vac-3").addClass("d-none");

    if(!$("#div-edt-err-vac-4").hasClass("d-none"))
        $("#div-edt-err-vac-4").addClass("d-none");

    if(!$("#div-edt-err-vac-5").hasClass("d-none"))
        $("#div-edt-err-vac-5").addClass("d-none");

    if(!$("#div-edt-err-vac-6").hasClass("d-none"))
        $("#div-edt-err-vac-6").addClass("d-none");

    if(!$("#div-edt-err-vac-7").hasClass("d-none"))
        $("#div-edt-err-vac-7").addClass("d-none");

    if(!$("#div-edt-err-vac-8").hasClass("d-none"))
        $("#div-edt-err-vac-8").addClass("d-none");

    if(!$("#div-edt-scs-vac-1").hasClass("d-none"))
        $("#div-edt-scs-vac-1").addClass("d-none");

    //ToTop();
    if(tgl === "" || margin === "" || (type === "1" && ctgl === "") || (type === "2" && (fpro === "" || fbrt === "")) || gdg === ""){
        $("#div-edt-err-vac-1").removeClass("d-none");

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });
    }
    else if(lpro.length === 0){
        $("#div-edt-err-vac-4").removeClass("d-none");

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });
    }
    else
    {
        $("#btn-sevac").prop("disabled", true);
        $("#btn-sevac").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        setTimeout(function(){
            $.ajax({
                url : "./bin/php/uvac.php",
                type : "post",
                data : {id : id, tgl : tgl, margin : margin, lpro : lpro, tmargin : tmargin, type : type, fpro : fpro, fbrt : fbrt, ctgl : ctgl, ket : ket, thp : thp, hcut : hcut, fpro2 : fpro2, fbrt2 : fbrt2, gdg : gdg},
                success : function(output){
                    var json = $.parseJSON(output);

                    swal.close();

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-vac-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-vac-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-vac-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-vac-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-vac-5").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -6)
                        $("#div-edt-err-vac-6").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -7)
                        $("#div-edt-err-vac-7").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -8)
                        $("#div-edt-err-vac-8").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-vac-1").removeClass("d-none");

                        schVac($("#txt-srch-vac").val());

                        $("#mdl-evac").modal("hide");
                    }

                    $("#btn-sevac").prop("disabled", false);
                    $("#btn-sevac").html("Simpan");
                },
                error : function(){
                    $("#btn-sevac").prop("disabled", false);
                    $("#btn-sevac").html("Simpan");
                    swal("Error (UVAC) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delVac(x)
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
                    url : "./bin/php/dvac.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DVAC - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schVac($("#txt-srch-vac").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DVAC) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delVacPro(x, y)
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
            
            $("#lst-vac-pro-"+x).remove();
    
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

function viewVac(x = "")
{
    if(x === "")
        x = UE64($("#txt-opt-vac").val());
        
    window.open("./lihat-vacuum?id="+x, "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//SAWING
function getNIDSaw()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-saw-1").hasClass("d-none"))
            $("#div-err-saw-1").addClass("d-none");
            
        if(!$("#div-err-saw-2").hasClass("d-none"))
            $("#div-err-saw-2").addClass("d-none");
            
        if(!$("#div-err-saw-3").hasClass("d-none"))
            $("#div-err-saw-3").addClass("d-none");
            
        if(!$("#div-scs-saw-1").hasClass("d-none"))
            $("#div-scs-saw-1").addClass("d-none");

        $("#btn-snsaw").prop("disabled", false);
        $("#btn-snsaw").html("Simpan");

        $("#mdl-nsaw").modal("show");

        swal.close();
    }, 200);
}

function schSaw(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ssaw.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-saw").html(setToTblSaw(json));

                swal.close();
            },
            error : function(){
                swal("Error (SSAW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblSaw(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var dtl = "", thp = "";
            for(var j = 0; j < x.data2[i].length; j++)
            {
                dtl += "<li>"+x.data2[i][j][0];
                
                if(x.data2[i][j][1] !== "" && x.data2[i][j][1] !== null)
                    dtl += " / "+x.data2[i][j][1];
                
                if(x.data2[i][j][2] !== "" && x.data2[i][j][2] !== null)
                    dtl += " / "+x.data2[i][j][2];
                
                if(x.data2[i][j][3] !== "" && x.data2[i][j][3] !== null)
                    dtl += " / "+x.data2[i][j][3];
                    
                dtl += " ("+NumberFormat2(x.data2[i][j][4])+")</li>";
            }
            
            if(x.data[i][13] != 0 && x.data[i][13] != null)
                thp = x.data[i][13];
            console.log(x.data[i][16])
            hsl += "<tr ondblclick=\"viewSaw('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\">"+x.data[i][12]+"</td>"+
                        "<td class=\"border\">"+x.data[i][10]+"</td>"+
                        "<td class=\"border\">"+x.data[i][11]+"</td>"+
                        "<td class=\"border text-right\">"+thp+"</td>"+
                        "<td class=\"border text-right\">"+x.data[i][14]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][4])))+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][8])))+"</td>"+
                        "<td class=\"border small\"><ul>"+dtl+"</ul></td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">";
            if(x.data[i][16] <= 3)
                hsl += "<button class=\"btn btn-light border-success mb-1 p-1\" onclick=\"reBlcSaw('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/balance-icon.png\" alt=\"Balancing\" width=\"18\"></button>";
            
            hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eSaw('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delSaw('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            //if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewSaw('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"Lihat Sawing\" width=\"18\"></button>";
            
                
            hsl += " </td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                "<td colspan=\"13\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
            "</tr>";

    return hsl;
}

function eSaw(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-saw-1").hasClass("d-none"))
        $("#div-edt-err-saw-1").addClass("d-none");

    if(!$("#div-edt-err-saw-2").hasClass("d-none"))
        $("#div-edt-err-saw-2").addClass("d-none");

    if(!$("#div-edt-err-saw-3").hasClass("d-none"))
        $("#div-edt-err-saw-3").addClass("d-none");

    if(!$("#div-edt-err-saw-4").hasClass("d-none"))
        $("#div-edt-err-saw-4").addClass("d-none");

    if(!$("#div-edt-err-saw-5").hasClass("d-none"))
        $("#div-edt-err-saw-5").addClass("d-none");

    if(!$("#div-edt-err-saw-6").hasClass("d-none"))
        $("#div-edt-err-saw-6").addClass("d-none");

    if(!$("#div-edt-err-saw-7").hasClass("d-none"))
        $("#div-edt-err-saw-7").addClass("d-none");

    if(!$("#div-edt-scs-saw-1").hasClass("d-none"))
        $("#div-edt-scs-saw-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtsaw.php",
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
                                $("#txt-vkode").attr("data-type", "SAW");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setSawVerif(x);

                                gvsaw = setInterval(getSawVerif, 1000);
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
                    $("#edt-txt-nma-pro").val(json.pro[1]);
                    $("#edt-txt-pro").val(json.data[3]);
                    $("#edt-txt-weight-pro").val(json.data[4]);
                    $("#edt-slct-tmrgn").val(json.data[7]);
                    $("#edt-txt-mrgn").val(json.data[6]);
                    $("#edt-txt-thp").val(json.data[10]);
                    $("#edt-txt-ket").val(json.data[11]);
                    $("#edt-slct-gdg").val(json.data[12]);

                    $(".table-data2").DataTable().clear().destroy();

                    $("#lst-esaw").html(setToTblESaw(json));

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $(".dataTables_scrollHeadInner").addClass("w-100");

                    $(".table").css("width", "100%");

                    $("#btn-sesaw").prop("disabled", false);
                    $("#btn-sesaw").html("Simpan");

                    $("#btn-sesaw").attr("data-count", json.count[1]);

                    $("#mdl-esaw").modal("show");
                }
            },
            error : function(){
                swal("Error (ESAW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblESaw(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[1]; i++)
    {
        var nma = x.data3[i][4]+" / "+x.data3[i][7];

        if(x.data3[i][5] !== ""){
            nma += x.data3[i][5];
        }

        if(x.data3[i][6] !== ""){
            nma += x.data3[i][6];
        }

        hsl += "<tr id=\"lst-saw-pro-"+i+"\">"+
                    "<td class=\"border\">"+nma+"</td>"+
                    "<td class=\"border\"><input type=\"number\" step=\"any\" class=\"form-control\" id=\"txt-weight-"+i+"\" value=\""+x.data3[i][2]+"\" data-pro=\""+UE64(x.data3[i][1])+"\" data-urut=\""+UE64(x.data3[i][3])+"\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delSawPro('"+i+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function mdlSaw(x)
{
    x = UD64(x);

    $("#txt-opt-saw").val(x);

    $("#mdl-opt-saw").modal("show");
}

function reBlcSaw(x)
{
    x = UD64(x);

    $("#txt-id-rblc").val(x);

    $("#mdl-rbsaw").modal("show");
}

function updBlcSaw()
{
    var id = $("#txt-id-rblc").val(), qty = UnNumberFormat($("#txt-vblc").val());

    setTimeout(function(){
        $("#btn-snrbsaw").prop("disabled", true);
        $("#btn-snrbsaw").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        $.ajax({
            url : "./bin/php/ubsaw.php",
            type : "post",
            data : {id : id, qty : qty},
            success : function(output){
                var json = $.parseJSON(output);

                $("#btn-snrbsaw").prop("disabled", false);
                $("#btn-snrbsaw").html("Simpan");
                
                if(parseInt(json.err[0]) === -1){
                    swal("Error (UBLCSAW - 1) !!!", "Berat bahan baku tidak boleh lebih kecil dari hasil !!!", "error");
                }
                else if(parseInt(json.err[0]) === -2){
                    swal({
                        title : "Perhatian !!!",
                        text : "Berat bahan baku melebihi sisa stock, minta verifikasi ?",
                        icon : "warning",
                        dangerMode : true,
                        buttons : true,
                    })
                    .then((ok) => {
                        if(ok){
                            setSawPVerif2(id, qty);
                            gvpsaw = setInterval(getSawPVerif, 1000);
                            Process();
                        }
                    })
                }
                else{
                    $("#mdl-rbsaw").modal("hide");
                    $("#mdl-rbsaw input").val("");
                
                    swal({
                        title : "Sukses !!!",
                        text : "Data berhasil di update !!!",
                        icon : "success",
                        closeOnEsc : false,
                        closeOnClickOutside : false,
                    })
                    .then(ok => {
                        if(ok)
                            schSaw($("#txt-srch-saw").val());
                    });
                }
            },
            error : function(){
                $("#btn-snrbsaw").prop("disabled", false);
                $("#btn-snrbsaw").html("Simpan");
                swal("Error (UBLCSAW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    })
}

function getSawVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));
        $.ajax({
            url : "./bin/php/gdtsaw.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[8] === "x")
                {
                    swal("Error (GSAWVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")

                    clearInterval(gvsaw);
                }
                else if(json.data[8] !== "?" && json.data[8] !== "")
                {
                    $("#head-vkode").text(json.data[8]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[8]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvsaw);
                }
            },
            error : function(){
                swal("Error (GSAWVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setSawVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ssawvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SSAWVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekSawVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eSaw(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CSAWVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function setSawPVerif(pro, brt, tgl)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ssawpvrf.php",
            type : "post",
            data : {pro : pro, brt : brt, tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                $("#dte-tgl").attr("data-verif", json.vpid[0]);
            },
            error : function(){
                swal("Error (SSAWPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setSawPVerif2(id, brt)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ssawpvrf2.php",
            type : "post",
            data : {id : id, brt : brt},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-vblc").attr("data-verif", json.vpid[0]);
            },
            error : function(){
                swal("Error (SSAWPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function getSawPVerif()
{
    setTimeout(function(){
        var id = $("#dte-tgl").attr("data-verif");

        if($("#mdl-rbsaw").hasClass("show")){
            id = $("#txt-vblc").attr("data-verif");
        }

        $.ajax({
            url : "./bin/php/gdtpvrf.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[7] === "C")
                {
                    swal("Error (GSAWPVRF) !!!", "Permintaan verifikasi di tolak !!!", "error");
                    
                    clearInterval(gvpsaw);
                }
                else if(json.data[7] === "V")
                {
                    clearInterval(gvpsaw);
                    setTimeout(function(){
                        if($("#mdl-rbsaw").hasClass("show")){
                            updBlcSaw();
                        }
                        else{
                            newDtlSaw();
                        }
                    }, 200);
                }
            },
            error : function(){
                swal("Error (GSAWPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function getWeightSawPro()
{
    var tgl = $("#dte-tgl").val(), id = $("#txt-pro2").val();

    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gwsawpro.php",
            type : "post",
            data : {id : id, tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                if($("#txt-weight-now").length > 0)
                    $("#txt-weight-now").val(NumberFormat2(parseFloat(json.data[0])));
            },
            error : function(){
                swal("Error (GWVACPRO) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
            },
        })
    }, 200)
}

function newDtlSaw()
{
    var tgl = $("#dte-tgl").val(), fnmpro = $("#txt-nma-pro").val(), fpro = $("#txt-pro").val(), fbrt = $("#txt-weight-pro").val(), pro = $("#txt-pro2").val(), brt = $("#txt-weight").val(), fnmgrade = $("#txt-nma-grade").val(), fnmkate = $("#txt-nma-kate").val(), fnmskate = $("#txt-nma-skate").val(), thp = $("#txt-thp").val(), ket = $("#txt-ket").val();

    if(!$("#div-err-saw-1").hasClass("d-none"))
        $("#div-err-saw-1").addClass("d-none");

    if(!$("#div-err-saw-2").hasClass("d-none"))
        $("#div-err-saw-2").addClass("d-none");

    if(!$("#div-err-saw-3").hasClass("d-none"))
        $("#div-err-saw-3").addClass("d-none");

    if(!$("#div-scs-saw-1").hasClass("d-none"))
        $("#div-scs-saw-1").addClass("d-none");

    if(tgl === "" || fpro === "")
        $("#div-err-saw-1").removeClass("d-none");
    else if(fpro === "" && pro === "")
        $("#div-err-saw-3").removeClass("d-none");
    else
    {
        $("#btn-snsaw").prop("disabled", true);
        $("#btn-snsaw").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ndsaw.php",
                type : "post",
                data : {tgl : tgl, fpro : fpro, fbrt : fbrt, pro : pro, brt : brt, thp : thp, ket : ket},
                success : function(output){
                    var json = $.parseJSON(output);

                    swal.close();

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-saw-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-saw-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-saw-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4){
                        //$("#div-err-saw-4").removeClass("d-none");
                        swal({
                            title : "Perhatian !!!",
                            text : "Berat bahan baku melebihi sisa stock, minta verifikasi ?",
                            icon : "warning",
                            dangerMode : true,
                            buttons : true,
                        })
                        .then((ok) => {
                            if(ok){
                                setSawPVerif(fpro, fbrt, tgl);
                                gvpsaw = setInterval(getSawPVerif, 1000);
                                Process();
                            }
                        })
                    }
                    else if(parseInt(json.err[0]) === -5)
                        swal("Error (NDSAW - 1) !!!", "Berat hasil produk melebihi berat bahan baku !!!", "error");
                    else
                    {
                        $("#div-scs-saw-1").removeClass("d-none");

                        $("#mdl-nsaw input").val("");
                        $("#dte-tgl").val(tgl);
                        $("#txt-pro").val(fpro);
                        $("#txt-nma-pro").val(fnmpro);
                        $("#txt-nma-grade").val(fnmgrade);
                        $("#txt-nma-kate").val(fnmkate);
                        $("#txt-nma-skate").val(fnmskate);
                        $("#txt-weight-pro").val(fbrt);
                        $("#txt-thp").val(thp);
                        $("#txt-ket").val(ket);

                        schSaw($("#txt-srch-saw").val());
                    }

                    $("#btn-snsaw").prop("disabled", false);
                    $("#btn-snsaw").html("Simpan");
                },
                error : function(){
                    $("#btn-snsaw").prop("disabled", false);
                    $("#btn-snsaw").html("Simpan");
                    swal("Error (NDSAW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDtlESaw()
{
    var pro = $("#edt-txt-pro2").val(), nmpro = $("#edt-txt-nma-pro2").val(), kate = $("#edt-txt-nma-kate2").val(), skate = $("#edt-txt-nma-skate2").val(), weight = UnNumberFormat($("#edt-txt-weight").val()), n = parseInt($("#btn-sesaw").attr("data-count")), grade = $("#edt-txt-nma-grade2").val();

    if(!$("#div-err-saw-pro-1").hasClass("d-none"))
        $("#div-err-saw-pro-1").addClass("d-none");

    if(!$("#div-scs-saw-pro-1").hasClass("d-none"))
        $("#div-scs-saw-pro-1").addClass("d-none");

    if(pro === "" || weight === "")
        $("#div-err-saw-pro-1").removeClass("d-none");
    else
    {
        $("#btn-sesaw-pro").prop("disabled", true);
        $("#btn-sesaw-pro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        $(".table-data2").DataTable().destroy();

        $("#lst-esaw").append(setToTblESawPro(pro, nmpro, kate, skate, weight, grade));

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });

        $(".dataTables_scrollHeadInner").addClass("w-100");

        $(".table").css("width", "100%");

        $("#btn-sesaw").attr("data-count", n + 1);
        
        $("#div-scs-saw-pro-1").removeClass("d-none");

        $("#mdl-npro-saw input").val("");

        $("#btn-sesaw-pro").prop("disabled", false);
        $("#btn-sesaw-pro").html("Simpan");
    }
}

function setToTblESawPro(pro, nmpro, kate, skate, weight, grade)
{
    var n = $("#btn-sesaw").attr("data-count"), nma = nmpro+" / "+grade;

    if(kate !== ""){
        nma += " / "+kate;
    }
    
    if(skate !== ""){
        nma += " / "+skate;
    }

    return "<tr id=\"lst-saw-pro-"+n+"\">"+
                "<td class=\"border\">"+nma+"</td>"+
                "<td class=\"border\"><input type=\"number\" step=\"any\" class=\"form-control\" id=\"txt-weight-"+n+"\" value=\""+weight+"\" data-pro=\""+UE64(pro)+"\" data-urut=\""+UE64(0)+"\"></td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delSawPro('"+n+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>";
}

function updSaw()
{
    var tgl = $("#edt-dte-tgl").val(), id = $("#edt-txt-id").val(), fpro = $("#edt-txt-pro").val(), fbrt = $("#edt-txt-weight-pro").val(), tmargin = $("#edt-slct-tmrgn").val(), margin = $("#edt-txt-mrgn").val(), lpro = [], n = 0, thp = $("#edt-txt-thp").val(), ket = $("#edt-txt-ket").val(), gdg = $("#edt-slct-gdg").val();

    $(".table-data2").DataTable().destroy();

    for(var i = 0; i < parseInt($("#btn-sesaw").attr("data-count")); i++)
    {
        if($("#txt-weight-"+i).length === 0)
            continue;

        lpro[n] = [UD64($("#txt-weight-"+i).attr("data-pro")), $("#txt-weight-"+i).val(), UD64($("#txt-weight-"+i).attr("data-urut"))];

        n++;
    }

    lpro = JSON.stringify(lpro);

    if(!$("#div-edt-err-saw-1").hasClass("d-none"))
        $("#div-edt-err-saw-1").addClass("d-none");

    if(!$("#div-edt-err-saw-2").hasClass("d-none"))
        $("#div-edt-err-saw-2").addClass("d-none");

    if(!$("#div-edt-err-saw-3").hasClass("d-none"))
        $("#div-edt-err-saw-3").addClass("d-none");

    if(!$("#div-edt-err-saw-4").hasClass("d-none"))
        $("#div-edt-err-saw-4").addClass("d-none");

    if(!$("#div-edt-err-saw-5").hasClass("d-none"))
        $("#div-edt-err-saw-5").addClass("d-none");

    if(!$("#div-edt-err-saw-6").hasClass("d-none"))
        $("#div-edt-err-saw-6").addClass("d-none");

    if(!$("#div-edt-err-saw-7").hasClass("d-none"))
        $("#div-edt-err-saw-7").addClass("d-none");

    if(!$("#div-edt-scs-saw-1").hasClass("d-none"))
        $("#div-edt-scs-saw-1").addClass("d-none");

    //ToTop();
    if(tgl === "" || margin === "" || fpro === "" || fbrt === "" || gdg === ""){
        $("#div-edt-err-saw-1").removeClass("d-none");

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });
    }
    else if(lpro.length === 0){
        $("#div-edt-err-saw-4").removeClass("d-none");

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });
    }
    else
    {
        $("#btn-sesaw").prop("disabled", true);
        $("#btn-sesaw").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        setTimeout(function(){
            $.ajax({
                url : "./bin/php/usaw.php",
                type : "post",
                data : {id : id, tgl : tgl, margin : margin, lpro : lpro, tmargin : tmargin, fpro : fpro, fbrt : fbrt, thp : thp, ket : ket, gdg : gdg},
                success : function(output){
                    var json = $.parseJSON(output);

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    swal.close();

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-saw-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-saw-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-saw-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-saw-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-saw-5").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -6)
                        $("#div-edt-err-saw-6").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -7)
                        $("#div-edt-err-saw-7").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-saw-1").removeClass("d-none");

                        schSaw($("#txt-srch-saw").val());

                        $("#mdl-esaw").modal("hide");
                    }

                    $("#btn-sesaw").prop("disabled", false);
                    $("#btn-sesaw").html("Simpan");
                },
                error : function(){
                    $("#btn-sesaw").prop("disabled", false);
                    $("#btn-sesaw").html("Simpan");
                    swal("Error (USAW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delSaw(x)
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
                    url : "./bin/php/dsaw.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DSAW - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schSaw($("#txt-srch-saw").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DSAW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delSawPro(x, y)
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

            $("#lst-saw-pro-"+x).remove();
    
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

function viewSaw(x = "")
{
    if(x === "")
        x = UE64($("#txt-opt-saw").val());
        
    window.open("./lihat-sawing?id="+x, "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//PACKAGING
function getNIDKrm()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-krm-1").hasClass("d-none"))
            $("#div-err-krm-1").addClass("d-none");
            
        if(!$("#div-err-krm-2").hasClass("d-none"))
            $("#div-err-krm-2").addClass("d-none");
            
        if(!$("#div-err-krm-3").hasClass("d-none"))
            $("#div-err-krm-3").addClass("d-none");
            
        if(!$("#div-scs-krm-1").hasClass("d-none"))
            $("#div-scs-krm-1").addClass("d-none");

        $("#btn-snkrm").prop("disabled", false);
        $("#btn-snkrm").html("Simpan");

        $("#mdl-nkrm").modal("show");

        swal.close();
    }, 200);
}

function schKrm(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/skrm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-krm").html(setToTblKrm(json));

                swal.close();
            },
            error : function(){
                swal("Error (SKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblKrm(x)
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
                    
                dtl += " ("+NumberFormat2(x.data2[i][j][4])+") [<strong>"+x.data2[i][j][5]+"</strong>]</li>";
            }

            hsl += "<tr ondblclick=\"viewKrm('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][7]))+"</td>"+
                        "<td class=\"border d-none\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border d-none\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border d-none\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border small\"><ul>"+dtl+"</ul></td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eKrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delKrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewKrm('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"Lihat Packaging\" width=\"20\"></button></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"10\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function eKrm(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-krm-1").hasClass("d-none"))
        $("#div-edt-err-krm-1").addClass("d-none");

    if(!$("#div-edt-err-krm-2").hasClass("d-none"))
        $("#div-edt-err-krm-2").addClass("d-none");

    if(!$("#div-edt-err-krm-3").hasClass("d-none"))
        $("#div-edt-err-krm-3").addClass("d-none");

    if(!$("#div-edt-err-krm-4").hasClass("d-none"))
        $("#div-edt-err-krm-4").addClass("d-none");

    if(!$("#div-edt-err-krm-5").hasClass("d-none"))
        $("#div-edt-err-krm-5").addClass("d-none");

    if(!$("#div-edt-err-krm-6").hasClass("d-none"))
        $("#div-edt-err-krm-6").addClass("d-none");

    if(!$("#div-edt-err-krm-7").hasClass("d-none"))
        $("#div-edt-err-krm-7").addClass("d-none");

    if(!$("#div-edt-scs-krm-1").hasClass("d-none"))
        $("#div-edt-scs-krm-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtkrm.php",
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
                                $("#txt-vkode").attr("data-type", "KRM");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setKrmVerif(x);

                                gvkrm = setInterval(getKrmVerif, 1000);
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
                    $("#edt-txt-ket1").val(json.data[2]);
                    $("#edt-txt-ket2").val(json.data[3]);
                    $("#edt-txt-ket3").val(json.data[4]);
                    $("#edt-slct-gdg").val(json.data[9]);

                    $(".table-data2").DataTable().clear().destroy();

                    $("#lst-ekrm").html(setToTblKrmPro(json));

                    for(var i = 0; i < json.count[1]; i++){
                        $("#edt-slct-sat-"+i).val(json.data3[i][10]);
                    }

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $(".dataTables_scrollHeadInner").addClass("w-100");

                    $(".table").css("width", "100%");

                    $("#btn-sekrm").prop("disabled", false);
                    $("#btn-sekrm").html("Simpan");

                    $("#mdl-ekrm").modal("show");
                }
            },
            error : function(){
                swal("Error (EPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblKrmPro(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[1]; i++)
    {
        var pro = x.data3[i][4]+" / "+x.data3[i][7], read = "", dis = "";

        if(x.data3[i][5] !== "")
            pro += " / "+x.data3[i][5];
            
        if(x.data3[i][6] !== "")
            pro += " / "+x.data3[i][6];

        if(x.data3[i][12] === "SN"){
            read = "readonly";
            dis = "disabled";
        }

        hsl += "<tr id=\"ekrm-pro-"+i+"\">"+
                    "<td class=\"border\">"+x.data3[i][8]+"</td>"+
                    "<td class=\"border\">"+pro+"</td>"+
                    "<td class=\"border\">"+
                        "<div class=\"input-group\">"+
                            "<input class=\"form-control\" type=\"number\" id=\"edt-txt-qty-"+i+"\" value=\""+x.data3[i][9]+"\" "+read+">"+
                            "<div class=\"input-group-append\">"+
                                "<select class=\"custom-select\" id=\"edt-slct-sat-"+i+"\" "+dis+">"+
                                    "<option value=\"BOX\">BOX</option>"+
                                    "<option value=\"BAG\">BAG</option>"+
                                    "<option value=\"PCS\">PCS</option>"+
                                    "<option value=\"EKOR\">EKOR</option>"+
                                "</select>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border\"><input class=\"form-control\" type=\"date\" id=\"edt-dte-tglexp-"+i+"\" value=\""+x.data3[i][11]+"\" "+read+"></td>"+
                    "<td class=\"border\"><input class=\"form-control cformat\" id=\"ekrm-wpro-"+i+"\" value=\""+NumberFormat2(x.data3[i][2])+"\" data-urut=\""+UE64(x.data3[i][3])+"\" data-po=\""+UE64(x.data3[i][8])+"\" data-pro=\""+UE64(x.data3[i][1])+"\" "+read+"></td>"+
                    "<td class=\"border\"><input class=\"form-control\" type=\"text\" id=\"edt-txt-ket-"+i+"\" value=\""+x.data3[i][13]+"\" "+read+" maxlength=\"100\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delKrmPro('"+i+"', '"+UE64(2)+"')\" "+dis+"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
    }

    $("#btn-sekrm").attr("data-count", x.count[0]);

    return hsl;
}

function setToTblKrmPro2(itm, kate, skate, weight, itmnm, type, grade)
{
    var n = $("#btn-snkrm").attr("data-count"), tname = "nkrm", urut = 0;

    if(type === "2")
    {
        n = $("#btn-sekrm").attr("data-count");
        tname = "ekrm";
        $("#btn-sekrm").attr("data-count", parseInt(n) + 1);
    }
    else
        $("#btn-snkrm").attr("data-count", parseInt(n) + 1);

    return "<tr id=\""+tname+"-pro-"+n+"\">"+
                    "<td class=\"border\">"+itmnm+"<input class=\"d-none\" id=\"txt-"+tname+"-pro-"+n+"\" data-value=\""+UE64(itm)+"\" data-urut=\""+UE64(urut)+"\"></td>"+
                    "<td class=\"border\">"+grade+"</td>"+
                    "<td class=\"border\">"+kate+"</td>"+
                    "<td class=\"border\">"+skate+"</td>"+
                    "<td class=\"border\"><input class=\"form-control cformat\" id=\""+tname+"-wpro-"+n+"\" value=\""+NumberFormat2(weight)+"\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delKrmPro('"+n+"', '"+UE64(type)+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
}

function mdlKrm(x)
{
    x = UD64(x);

    $("#txt-opt-krm").val(x);

    $("#mdl-opt-krm").modal("show");
}

function getKrmVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));

        $.ajax({
            url : "./bin/php/gdtkrm.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);
                
                if(json.data[7] === "x")
                {
                    swal("Error (GKRMVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")
                    
                    clearInterval(gvkrm);
                }
                else if(json.data[7] !== "?" && json.data[7] !== "")
                {
                    $("#head-vkode").text(json.data[7]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[7]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvkrm);
                }
            },
            error : function(){
                swal("Error (GPJMVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setKrmVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/skrmvrf.php",
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

function cekKrmVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eKrm(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CKRMVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function setKrmPVerif(pro, brt, tgl)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/skrmpvrf.php",
            type : "post",
            data : {pro : pro, brt : brt, tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                $("#dte-tgl").attr("data-verif", json.vpid[0]);
            },
            error : function(){
                swal("Error (SKRMPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function getKrmPVerif()
{
    setTimeout(function(){
        var id = $("#dte-tgl").attr("data-verif");
        $.ajax({
            url : "./bin/php/gdtpvrf.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[7] === "C")
                {
                    swal("Error (GKRMPVRF) !!!", "Permintaan verifikasi di tolak !!!", "error");
                    
                    clearInterval(gvpkrm);
                }
                else if(json.data[7] === "V")
                {
                    clearInterval(gvpkrm);
                    setTimeout(function(){
                        newDtlKrm();
                    }, 200);
                }
            },
            error : function(){
                swal("Error (GKRMPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setTypeKrm(x)
{
    $("#txt-krm-type-pro").val(x);

    if(!$("#div-err-krm-pro-1").hasClass("d-none"))
        $("#div-err-krm-pro-1").addClass("d-none");

    if(!$("#div-scs-krm-pro-1").hasClass("d-none"))
        $("#div-scs-krm-pro-1").addClass("d-none");
        
    if(x === 1)
        $("#mdl-nkrm-pro .mdl-cls").attr("data-target", "#mdl-nkrm");
    else if(x === 2)
        $("#mdl-nkrm-pro .mdl-cls").attr("data-target", "#mdl-ekrm");

    $("#mdl-nkrm-pro").modal({backdrop : "static", keyboard : false});
    $("#mdl-nkrm-pro").modal("show");
}

function newKrm()
{
    var id = $("#txt-id").val(), cus = $("#txt-cus").val(), tgl = $("#dte-tgl").val(), ket1 = $("#txt-ket1").val(), ket2 = $("#txt-ket2").val(), ket3 = $("#txt-ket3").val();

    if(!$("#div-err-krm-1").hasClass("d-none"))
        $("#div-err-krm-1").removeClass("d-none");

    if(!$("#div-err-krm-2").hasClass("d-none"))
        $("#div-err-krm-2").removeClass("d-none");

    if(!$("#div-err-krm-3").hasClass("d-none"))
        $("#div-err-krm-3").removeClass("d-none");

    if(!$("#div-err-krm-4").hasClass("d-none"))
        $("#div-err-krm-4").removeClass("d-none");

    if(!$("#div-scs-krm-1").hasClass("d-none"))
        $("#div-scs-krm-1").removeClass("d-none");

    ToTop();
    if(cus === "" || tgl === "")
        $("#div-err-krm-1").removeClass("d-none");
    else if(parseInt($("#btn-snkrm").attr("data-count")) === 0)
        $("#div-err-krm-4").removeClass("d-none");
    else
    {
        $("#btn-snkrm").prop("disabled", true);
        $("#btn-snkrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        var lpro = [], n = 0;

        for(var i = 0; i < parseInt($("#btn-snkrm").attr("data-count")); i++)
        {
            if($("#txt-nkrm-pro-"+i).length === 0)
                continue;

            lpro[n] = [UD64($("#txt-nkrm-pro-"+i).attr("data-value")), UnNumberFormat($("#nkrm-wpro-"+i).val())];

            n++;
        }

        lpro = JSON.stringify(lpro);

        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nkrm.php",
                type : "post",
                data : {id : id, cus : cus, tgl : tgl, ket1 : ket1, ket2 : ket2, ket3 : ket3, lpro : lpro},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-krm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-krm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-krm-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-err-krm-4").removeClass("d-none");
                    else
                    {
                        $("#mdl-nkrm input").val("");
                        $("#mdl-nkrm #lst-nkrm").html("");
                        $("#btn-snkrm").attr("data-value",0);

                        $("#dte-tgl").val(tgl);

                        $("#txt-id").focus().select();

                        $("#div-scs-krm-1").removeClass("d-none");

                        schKrm($("#txt-srch-krm").val());
                        
                        setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Pengiriman berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-pengiriman?id="+UE64(json.id[0]), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);
                    }

                    $("#btn-snkrm").prop("disabled", false);
                    $("#btn-snkrm").html("Simpan");
                },
                error : function(){
                    $("#btn-snkrm").prop("disabled", false);
                    $("#btn-snkrm").html("Simpan");
                    swal("Error (NTKM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDtlKrm()
{
    var tgl = $("#dte-tgl").val(), po = $("#txt-po").val(), pro = $("#txt-pro").val(), brt = $("#txt-weight").val(), qty = $("#txt-qty").val(), sat = $("#slct-sat").val(), tglexp = $("#dte-tglexp").val(), ket = $("#txt-ket").val();

    if(!$("#div-err-krm-1").hasClass("d-none"))
        $("#div-err-krm-1").addClass("d-none");

    if(!$("#div-err-krm-2").hasClass("d-none"))
        $("#div-err-krm-2").addClass("d-none");

    if(!$("#div-err-krm-3").hasClass("d-none"))
        $("#div-err-krm-3").addClass("d-none");

    if(!$("#div-scs-krm-1").hasClass("d-none"))
        $("#div-scs-krm-1").addClass("d-none");

    if(tgl === "" || po === "" || pro === "" || brt <= 0 || qty === "" || sat === "" || tglexp === "" || ket === "")
        $("#div-err-krm-1").removeClass("d-none");
    else
    {
        $("#btn-snkrm").prop("disabled", true);
        $("#btn-snkrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ndkrm.php",
                type : "post",
                data : {tgl : tgl, po : po, pro : pro, brt : brt, qty : qty, sat : sat, tglexp : tglexp, ket : ket},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-krm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-krm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-krm-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4){
                        swal({
                            title : "Perhatian !!!",
                            text : "Jumlah pengiriman melebihi sisa stock, minta verifikasi ?",
                            icon : "warning",
                            dangerMode : true,
                            buttons : true,
                        })
                        .then((ok) => {
                            if(ok){
                                setKrmPVerif(pro, brt, tgl);
                                gvpkrm = setInterval(getKrmPVerif, 1000);
                                Process();
                            }
                        })
                    }
                    else
                    {
                        $("#div-scs-krm-1").removeClass("d-none");

                        $("#mdl-nkrm input").val("");
                        $("#dte-tgl").val(tgl);
                        $("#txt-po").val(po);

                        schKrm($("#txt-srch-krm").val());
                    }

                    $("#btn-snkrm").prop("disabled", false);
                    $("#btn-snkrm").html("Simpan");
                },
                error : function(){
                    $("#btn-snkrm").prop("disabled", false);
                    $("#btn-snkrm").html("Simpan");
                    swal("Error (NDKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDtlEKrm()
{
    var pro = $("#txt-pro2").val(), nmpro = $("#txt-nma-pro2").val(), kate = $("#txt-nma-kate2").val(), skate = $("#txt-nma-skate2").val(), weight = UnNumberFormat($("#txt-weight2").val()), n = parseInt($("#btn-sekrm").attr("data-count")), grade = $("#txt-nma-grade2").val(), po = $("#edt-txt-po").val(), qty = $("#txt-qty2").val(), sat = $("#slct-sat2").val(), tglexp = $("#dte-tglexp2").val(), ket = $("#txt-ket2").val();

    if(!$("#div-err-krm-pro-1").hasClass("d-none"))
        $("#div-err-krm-pro-1").addClass("d-none");

    if(!$("#div-scs-krm-pro-1").hasClass("d-none"))
        $("#div-scs-krm-pro-1").addClass("d-none");

    if(po === "" || pro === "" || weight === "" || qty === "" || sat === "" || tglexp === "")
        $("#div-err-krm-pro-1").removeClass("d-none");
    else
    {
        $("#btn-sekrm-pro").prop("disabled", true);
        $("#btn-sekrm-pro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        $(".table-data2").DataTable().destroy();

        $("#lst-ekrm").append(setToTblEKrmPro(pro, nmpro, kate, skate, weight, grade, po, qty, sat, tglexp, ket));

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });

        $("#edt-slct-sat-"+n).val(sat);

        $(".dataTables_scrollHeadInner").addClass("w-100");

        $(".table").css("width", "100%");

        $("#btn-sekrm").attr("data-count", n + 1);
        
        $("#div-scs-krm-pro-1").removeClass("d-none");

        $("#mdl-nkrm-pro input").val("");

        $("#btn-snkrm-pro").prop("disabled", false);
        $("#btn-snkrm-pro").html("Simpan");
    }
}

function setToTblEKrmPro(pro, nmpro, kate, skate, weight, grade, po, qty, sat, tglexp, ket)
{
    var n = $("#btn-sekrm").attr("data-count"), npro = nmpro+" / "+grade;

    if(kate !== "")
        npro += " / "+kate;

    if(skate !== "")
        npro += " / "+skate;

    return "<tr id=\"ekrm-pro-"+n+"\">"+
                "<td class=\"border\">"+po+"</td>"+
                "<td class=\"border\">"+npro+"</td>"+
                "<td class=\"border\">"+
                    "<div class=\"input-group\">"+
                        "<input class=\"form-control\" type=\"number\" id=\"edt-txt-qty-"+n+"\" value=\""+qty+"\">"+
                        "<div class=\"input-group-append\">"+
                            "<select class=\"custom-select\" id=\"edt-slct-sat-"+n+"\">"+
                                "<option value=\"BOX\">BOX</option>"+
                                "<option value=\"BAG\">BAG</option>"+
                                "<option value=\"PCS\">PCS</option>"+
                                "<option value=\"EKOR\">EKOR</option>"+
                            "</select>"+
                        "</div>"+
                    "</div>"+
                "</td>"+
                "<td class=\"border\"><input class=\"form-control\" type=\"date\" id=\"edt-dte-tglexp-"+n+"\" value=\""+tglexp+"\"></td>"+
                "<td class=\"border\"><input type=\"number\" step=\"any\" class=\"form-control\" id=\"ekrm-wpro-"+n+"\" value=\""+weight+"\" data-pro=\""+UE64(pro)+"\" data-po=\""+UE64(po)+"\" data-urut=\""+UE64(0)+"\"></td>"+
                "<td class=\"border\"><input type=\"text\" maxlength=\"100\" class=\"form-control\" id=\"edt-txt-ket-"+n+"\" value=\""+ket+"\"></td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delKrmPro('"+n+"', '"+UE64(2)+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>";
}

function updKrm()
{
    var id = $("#edt-txt-id").val(), tgl = $("#edt-dte-tgl").val(), ket1 = $("#edt-txt-ket1").val(), ket2 = $("#edt-txt-ket2").val(), ket3 = $("#edt-txt-ket3").val(), bid = $("#edt-txt-bid").val(), gdg = $("#edt-slct-gdg").val();

    if(!$("#div-edt-err-krm-1").hasClass("d-none"))
        $("#div-edt-err-krm-1").addClass("d-none");

    if(!$("#div-edt-err-krm-2").hasClass("d-none"))
        $("#div-edt-err-krm-2").addClass("d-none");

    if(!$("#div-edt-err-krm-3").hasClass("d-none"))
        $("#div-edt-err-krm-3").addClass("d-none");

    if(!$("#div-edt-err-krm-4").hasClass("d-none"))
        $("#div-edt-err-krm-4").addClass("d-none");

    if(!$("#div-edt-err-krm-5").hasClass("d-none"))
        $("#div-edt-err-krm-5").addClass("d-none");

    if(!$("#div-edt-err-krm-6").hasClass("d-none"))
        $("#div-edt-err-krm-6").addClass("d-none");

    if(!$("#div-edt-err-krm-7").hasClass("d-none"))
        $("#div-edt-err-krm-7").addClass("d-none");

    if(!$("#div-edt-scs-krm-1").hasClass("d-none"))
        $("#div-edt-scs-krm-1").addClass("d-none");

    ToTop();
    if(id === "" || tgl === "" || gdg === "")
        $("#div-edt-err-krm-1").removeClass("d-none");
    else if(parseInt($("#btn-sekrm").attr("data-count")) === 0)
        $("#div-edt-err-krm-4").removeClass("d-none");
    else
    {
        $("#btn-sekrm").prop("disabled", true);
        $("#btn-sekrm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        $(".table-data2").DataTable().destroy();

        var lpro = [], n = 0;

        for(var i = 0; i < parseInt($("#btn-sekrm").attr("data-count")); i++)
        {
            if($("#ekrm-wpro-"+i).length === 0)
                continue;

            if($("#ekrm-wpro-"+i).hasClass("bg-danger"))
                $("#ekrm-wpro-"+i).removeClass("bg-danger").removeClass("text-white");

            lpro[n] = [UD64($("#ekrm-wpro-"+i).attr("data-pro")), UnNumberFormat($("#ekrm-wpro-"+i).val()), UD64($("#ekrm-wpro-"+i).attr("data-urut")), UD64($("#ekrm-wpro-"+i).attr("data-po")), $("#edt-txt-qty-"+i).val(), $("#edt-slct-sat-"+i).val(), $("#edt-dte-tglexp-"+i).val(), i, $("#edt-txt-ket-"+i).val()];

            n++;
        }
        
        lpro = JSON.stringify(lpro);
        
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ukrm.php",
                type : "post",
                data : {id : id, tgl : tgl, ket1 : ket1, ket2 : ket2, ket3 : ket3, bid : bid, lpro : lpro, gdg : gdg},
                success : function(output){
                    var json = $.parseJSON(output);

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-krm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-krm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-krm-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-krm-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-krm-5").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -6)
                        $("#div-edt-err-krm-6").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -7){
                        $("#div-edt-err-krm-7").removeClass("d-none");
                        for(var i = 0; i < json.err2.length; i++){
                            $("#ekrm-wpro-"+json.err2[i]).addClass("bg-danger text-white");
                        }
                    }
                    else
                    {
                        $("#div-edt-scs-krm-1").removeClass("d-none");

                        schKrm($("#txt-srch-krm").val());

                        $("#mdl-ekrm").modal("hide");
                        
                        /*setTimeout(function(){
                            swal({
                                title : "Perhatian !!!",
                                text : "Packaging berhasil disimpan, lihat hasil ?",
                                buttons : true,
                                icon : "warning",
                                closeOnClickOutside : false,
                                closeOnEsc : false,
                            })
                            .then(ok => {
                                if(ok)
                                    window.open("./lihat-pengiriman?id="+UE64(id), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
                            });
                        }, 800);*/
                    }

                    $("#btn-sekrm").prop("disabled", false);
                    $("#btn-sekrm").html("Simpan");
                },
                error : function(){
                    $("#btn-sekrm").prop("disabled", false);
                    $("#btn-sekrm").html("Simpan");
                    swal("Error (UKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delKrm(x)
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
                    url : "./bin/php/dkrm.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DKRM - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schKrm($("#txt-srch-krm").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delKrmPro(x, y)
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
            var type = "nkrm";

            y = UD64(y);

            if(y === "2")
                type = "ekrm";
                
            $(".table-data2").DataTable().destroy();

            $("#"+type+"-pro-"+x).remove();
    
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

function viewKrm(x = "")
{
    if(x === "")
        x = UE64($("#txt-opt-krm").val());

    window.open("./lihat-packaging?id="+x, "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//MASUK PRODUK
function getNIDMP()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-mp-1").hasClass("d-none"))
            $("#div-err-mp-1").addClass("d-none");

        if(!$("#div-scs-mp-1").hasClass("d-none"))
            $("#div-scs-mp-1").addClass("d-none");

        $("#btn-snmp").prop("disabled", false);
        $("#btn-snmp").html("Simpan");

        $("#mdl-nmp").modal("show");

        swal.close();
    }, 200);
}

function schMP(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/smp.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-mp").html(setToTblMP(json));

                swal.close();
            },
            error : function(){
                swal("Error (SMP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblMP(x)
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
                        "<td class=\"border text-right\">"+NumberFormat(x.data[i][2])+"</td>"+
                        "<td class=\"border small\"><ul>"+dtl+"</ul></td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eMP('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delMP('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewMP('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"Lihat Penerimaan\" width=\"20\"></button></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                "<td colspan=\"13\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
            "</tr>";

    return hsl;
}

function eMP(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-mp-1").hasClass("d-none"))
        $("#div-edt-err-mp-1").addClass("d-none");

    if(!$("#div-edt-err-mp-2").hasClass("d-none"))
        $("#div-edt-err-mp-2").addClass("d-none");

    if(!$("#div-edt-err-mp-3").hasClass("d-none"))
        $("#div-edt-err-mp-3").addClass("d-none");

    if(!$("#div-edt-err-mp-4").hasClass("d-none"))
        $("#div-edt-err-mp-4").addClass("d-none");

    if(!$("#div-edt-err-mp-5").hasClass("d-none"))
        $("#div-edt-err-mp-5").addClass("d-none");

    if(!$("#div-edt-scs-mp-1").hasClass("d-none"))
        $("#div-edt-scs-mp-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtmp.php",
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
                                $("#txt-vkode").attr("data-type", "MP");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setMPVerif(x);

                                gvmp = setInterval(getMPVerif, 1000);
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
                    $("#edt-slct-gdg").val(json.data[6]);

                    $(".table-data2").DataTable().clear().destroy();

                    $("#lst-emp").html(setToTblEMP(json));

                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    $(".dataTables_scrollHeadInner").addClass("w-100");

                    $(".table").css("width", "100%");

                    $("#btn-semp").attr("data-count", json.count[1]);

                    $("#btn-semp").prop("disabled", false);
                    $("#btn-semp").html("Simpan");

                    $("#mdl-emp").modal("show");
                }
            },
            error : function(){
                swal("Error (EMP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblEMP(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[1]; i++)
    {
        var nma = x.data3[i][0]+" / "+x.data3[i][1];

        if(x.data3[i][2] !== ""){
            nma += " / "+x.data3[i][2];
        }

        if(x.data3[i][3] !== ""){
            nma += " / "+x.data3[i][3];
        }

        hsl += "<tr id=\"lst-mp-pro-"+i+"\">"+
                    "<td class=\"border\">"+nma+"</td>"+
                    "<td class=\"border\"><input type=\"number\" step=\"any\" class=\"form-control\" id=\"txt-weight-"+i+"\" value=\""+x.data3[i][4]+"\" data-pro=\""+UE64(x.data3[i][6])+"\" data-urut=\""+UE64(x.data3[i][7])+"\"></td>"+
                    "<td class=\"border\"><input type=\"text\" maxlength=\"100\" class=\"form-control\" id=\"txt-ket-"+i+"\" value=\""+x.data3[i][5]+"\"></td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delMPPro('"+i+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function getMPVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));
        $.ajax({
            url : "./bin/php/gdtmp.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[4] === "x")
                {
                    swal("Error (GMPVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")
                    
                    clearInterval(gvmp);
                }
                else if(json.data[4] !== "?" && json.data[4] !== "")
                {
                    $("#head-vkode").text(json.data[4]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[4]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvmp);
                }
            },
            error : function(){
                swal("Error (GMPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setMPVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/smpvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SMPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekMPVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eMP(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CMPVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function newDtlMP()
{
    var tgl = $("#dte-tgl").val(), pro = $("#txt-pro2").val(), brt = $("#txt-weight").val(), ket = $("#txt-ket").val();

    if(!$("#div-err-mp-1").hasClass("d-none"))
        $("#div-err-mp-1").addClass("d-none");

    if(!$("#div-scs-mp-1").hasClass("d-none"))
        $("#div-scs-mp-1").addClass("d-none");

    if(tgl === "" || pro === "" || brt === "")
        $("#div-err-mp-1").removeClass("d-none");
    else
    {
        $("#btn-snmp").prop("disabled", true);
        $("#btn-snmp").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ndmp.php",
                type : "post",
                data : {tgl : tgl, pro : pro, brt : brt, ket : ket},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-mp-1").removeClass("d-none");
                    else
                    {
                        $("#div-scs-mp-1").removeClass("d-none");

                        $("#mdl-nmp input").val("");
                        $("#dte-tgl").val(tgl);

                        schMP($("#txt-srch-mp").val());
                    }

                    $("#btn-snmp").prop("disabled", false);
                    $("#btn-snmp").html("Simpan");
                },
                error : function(){
                    $("#btn-snmp").prop("disabled", false);
                    $("#btn-snmp").html("Simpan");
                    swal("Error (NDMP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDtlEMP()
{
    var pro = $("#edt-txt-pro2").val(), nmpro = $("#edt-txt-nma-pro2").val(), kate = $("#edt-txt-nma-kate2").val(), skate = $("#edt-txt-nma-skate2").val(), weight = UnNumberFormat($("#edt-txt-weight").val()), n = parseInt($("#btn-semp").attr("data-count")), grade = $("#edt-txt-nma-grade2").val(), ket = $("#edt-txt-ket").val();

    if(!$("#div-err-mp-pro-1").hasClass("d-none"))
        $("#div-err-mp-pro-1").addClass("d-none");

    if(!$("#div-scs-mp-pro-1").hasClass("d-none"))
        $("#div-scs-mp-pro-1").addClass("d-none");

    if(pro === "" || weight === "")
        $("#div-err-mp-pro-1").removeClass("d-none");
    else
    {
        $("#btn-semp-pro").prop("disabled", true);
        $("#btn-semp-pro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

        $(".table-data2").DataTable().destroy();

        $("#lst-emp").append(setToTblEMPPro(pro, nmpro, kate, skate, weight, grade, ket));

        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });

        $(".dataTables_scrollHeadInner").addClass("w-100");

        $(".table").css("width", "100%");

        $("#btn-semp").attr("data-count", n + 1);
        
        $("#div-scs-mp-pro-1").removeClass("d-none");

        $("#mdl-npro-mp input").val("");

        $("#btn-semp-pro").prop("disabled", false);
        $("#btn-semp-pro").html("Simpan");
    }
}

function setToTblEMPPro(pro, nmpro, kate, skate, weight, grade, ket)
{
    var n = $("#btn-semp").attr("data-count"), nma = nmpro+" / "+grade;

    if(kate !== ""){
        nma += " / "+kate;
    }
    
    if(skate !== ""){
        nma += " / "+skate;
    }

    return "<tr id=\"lst-mp-pro-"+n+"\">"+
                "<td class=\"border\">"+nma+"</td>"+
                "<td class=\"border\"><input type=\"number\" step=\"any\" class=\"form-control\" id=\"txt-weight-"+n+"\" value=\""+weight+"\" data-pro=\""+UE64(pro)+"\" data-urut=\""+UE64(0)+"\"></td>"+
                "<td class=\"border\"><input type=\"text\" step=\"any\" class=\"form-control\" id=\"txt-ket-"+n+"\" value=\""+ket+"\"></td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delMPPro('"+n+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>";
}

function updMP()
{
    var tgl = $("#edt-dte-tgl").val(), id = $("#edt-txt-id").val(), lpro = [], n = 0, gdg = $("#edt-slct-gdg").val();

    $(".table-data2").DataTable().destroy();

    for(var i = 0; i < parseInt($("#btn-semp").attr("data-count")); i++)
    {
        if($("#txt-weight-"+i).length === 0)
            continue;

        lpro[n] = [UD64($("#txt-weight-"+i).attr("data-pro")), $("#txt-weight-"+i).val(), UD64($("#txt-weight-"+i).attr("data-urut")), $("#txt-ket-"+i).val()];
        
        n++;
    }

    lpro = JSON.stringify(lpro);

    if(!$("#div-edt-err-mp-1").hasClass("d-none"))
        $("#div-edt-err-mp-1").addClass("d-none");

    if(!$("#div-edt-err-mp-2").hasClass("d-none"))
        $("#div-edt-err-mp-2").addClass("d-none");

    if(!$("#div-edt-err-mp-3").hasClass("d-none"))
        $("#div-edt-err-mp-3").addClass("d-none");

    if(!$("#div-edt-err-mp-4").hasClass("d-none"))
        $("#div-edt-err-mp-4").addClass("d-none");

    if(!$("#div-edt-err-mp-5").hasClass("d-none"))
        $("#div-edt-err-mp-5").addClass("d-none");

    if(!$("#div-edt-scs-mp-1").hasClass("d-none"))
        $("#div-edt-scs-mp-1").addClass("d-none");

    //ToTop();
    if(tgl === "" || gdg === ""){
        $("#div-edt-err-mp-1").removeClass("d-none");
    
        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });
    }
    else if(lpro.length === 0){
        $("#div-edt-err-mp-4").removeClass("d-none");
    
        $(".table-data2").DataTable({
            dom: 'frt',
            scrollY: '42vh',
            scrollX: true,
            paging: false,
            autoWidth: false,
        });
    }
    else
    {
        $("#btn-semp").prop("disabled", true);
        $("#btn-semp").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ump.php",
                type : "post",
                data : {id : id, tgl : tgl, lpro : lpro, gdg : gdg},
                success : function(output){
                    var json = $.parseJSON(output);
    
                    $(".table-data2").DataTable({
                        dom: 'frt',
                        scrollY: '42vh',
                        scrollX: true,
                        paging: false,
                        autoWidth: false,
                    });

                    swal.close();

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-mp-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-mp-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-mp-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-mp-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-mp-5").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-mp-1").removeClass("d-none");

                        schMP($("#txt-srch-mp").val());

                        $("#mdl-emp").modal("hide");
                    }

                    $("#btn-semp").prop("disabled", false);
                    $("#btn-semp").html("Simpan");
                },
                error : function(){
                    $("#btn-semp").prop("disabled", false);
                    $("#btn-semp").html("Simpan");
                    swal("Error (UMP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delMP(x)
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
                    url : "./bin/php/dmp.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DMP - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schMP($("#txt-srch-mp").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DMP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delMPPro(x, y)
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

            $("#lst-mp-pro-"+x).remove();
    
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

function viewMP(x)
{
    window.open("./lihat-masuk-produk?id="+x, "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//PEMBEKUAN
function getNIDFrz()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-frz-1").hasClass("d-none"))
            $("#div-err-frz-1").addClass("d-none");

        if(!$("#div-scs-frz-1").hasClass("d-none"))
            $("#div-scs-frz-1").addClass("d-none");

        $("#btn-snfrz").prop("disabled", false);
        $("#btn-snfrz").html("Simpan");

        $("#mdl-nfrz").modal("show");

        swal.close();
    }, 200);
}

function schFrz(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sfrz.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-frz").html(setToTblFrz(json));

                swal.close();
            },
            error : function(){
                swal("Error (SFRZ) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblFrz(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var dtl = "", dtl2 = "";
            for(var j = 0; j < x.data2[i].length; j++)
            {
                dtl += "<li>"+x.data2[i][j][0];
                
                if(x.data2[i][j][1] !== "" && x.data2[i][j][1] !== null)
                    dtl += " / "+x.data2[i][j][1];
                
                if(x.data2[i][j][2] !== "" && x.data2[i][j][2] !== null)
                    dtl += " / "+x.data2[i][j][2];
                
                if(x.data2[i][j][3] !== "" && x.data2[i][j][3] !== null)
                    dtl += " / "+x.data2[i][j][3];

                dtl += " / "+x.data2[i][j][4]+" / "+x.data2[i][j][5]+" / "+x.data2[i][j][6];
                    
                dtl += " ("+NumberFormat2(x.data2[i][j][7])+")</li>";
                
                if(x.data2[i][j][8] !== "" && x.data2[i][j][8] !== null)
                    dtl += " - "+x.data2[i][j][8];

                dtl2 += "<li>"+x.data2[i][j][11];
                
                if(x.data2[i][j][12] !== "" && x.data2[i][j][12] !== null)
                    dtl2 += " / "+x.data2[i][j][12];
                
                if(x.data2[i][j][13] !== "" && x.data2[i][j][13] !== null)
                    dtl2 += " / "+x.data2[i][j][13];
                
                if(x.data2[i][j][14] !== "" && x.data2[i][j][14] !== null)
                    dtl2 += " / "+x.data2[i][j][14];
                    
                dtl2 += " ("+NumberFormat2(x.data2[i][j][7])+")</li>";
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][2])+"</td>"+
                        "<td class=\"border small\"><ul>"+dtl+"</ul></td>"+
                        "<td class=\"border small\"><ul>"+dtl2+"</ul></td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eFrz('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delFrz('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
                
            hsl += " </td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                "<td colspan=\"7\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
            "</tr>";

    return hsl;
}

function eFrz(x, y = 1)
{
    x = UD64(x);

    if(!$("#div-edt-err-frz-1").hasClass("d-none"))
        $("#div-edt-err-frz-1").addClass("d-none");

    if(!$("#div-edt-err-frz-2").hasClass("d-none"))
        $("#div-edt-err-frz-2").addClass("d-none");

    if(!$("#div-edt-err-frz-3").hasClass("d-none"))
        $("#div-edt-err-frz-3").addClass("d-none");

    if(!$("#div-edt-scs-frz-1").hasClass("d-none"))
        $("#div-edt-scs-frz-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtfrz.php",
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
                                $("#txt-vkode").attr("data-type", "FRZ");
                                $("#txt-vkode").attr("data-value", UE64(x));

                                setFrzVerif(x);

                                gvfrz = setInterval(getFrzVerif, 1000);
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
                    $("#edt-slct-gdg").val(json.data[6]);

                    $("#lst-efrz").html(setToTblEFrz(json));

                    $("#btn-sefrz").attr("data-count", json.count[1]);

                    $("#btn-sefrz").prop("disabled", false);
                    $("#btn-sefrz").html("Simpan");

                    $("#mdl-efrz").modal("show");
                }
            },
            error : function(){
                swal("Error (EFRZ) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblEFrz(x)
{
    var hsl = "", n = 0;

    for(var i = 0; i < x.count[1]; i++)
    {
        var npro = "", ntrm = "", pro = "", trm = "";
        
        ntrm += x.data3[i][0];
        trm += x.data3[i][9]+"|"+x.data3[i][5]+"|"+x.data3[i][7]+"|"+x.data3[i][15];
        pro = x.data3[i][16];
        
        if(x.data3[i][1] !== "" && x.data3[i][1] !== null)
            ntrm += " / "+x.data3[i][1];

        ntrm += " / "+NumberFormat2(x.data3[i][7]);
        
        if(x.data3[i][2] !== "" && x.data3[i][2] !== null)
            ntrm += " / "+x.data3[i][2];
        
        if(x.data3[i][3] !== "" && x.data3[i][3] !== null)
            ntrm += " / "+x.data3[i][3];

        ntrm += " / "+x.data3[i][4]+" / "+x.data3[i][5]+" / "+x.data3[i][6];

        npro += x.data3[i][11];
        
        if(x.data3[i][12] !== "" && x.data3[i][12] !== null)
            npro += " / "+x.data3[i][12];
        
        if(x.data3[i][13] !== "" && x.data3[i][13] !== null)
            npro += " / "+x.data3[i][13];
        
        if(x.data3[i][14] !== "" && x.data3[i][14] !== null)
            npro += " / "+x.data3[i][14];
        
        hsl += "<tr id=\"lst-frz-pro-"+n+"\">"+
                    "<td class=\"border\">"+
                        "<div class=\"input-group\">"+
                            "<input type=\"text\" class=\"form-control\" maxlength=\"100\" id=\"txt-nma-trm-"+n+"\" readonly value=\""+ntrm+"\">"+
                            "<input type=\"text\" class=\"d-none\" maxlength=\"100\" id=\"txt-trm-"+n+"\" value=\""+trm+"\">"+
                            "<div class=\"input-group-append\">"+
                                "<button class=\"btn btn-light border btn-strm\" type=\"button\" data-value=\""+n+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<div class=\"input-group\">"+
                            "<input type=\"text\" class=\"form-control\" maxlength=\"100\" id=\"txt-nma-pro3-"+n+"\" readonly value=\""+npro+"\">"+
                            "<input type=\"text\" class=\"d-none\" maxlength=\"100\" id=\"txt-pro3-"+n+"\" value=\""+pro+"\">"+
                            "<div class=\"input-group-append\">"+
                                "<button class=\"btn btn-light border btn-spro5\" type=\"button\" data-value=\""+n+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<div class=\"input-group\">"+
                            "<input type=\"text\" class=\"form-control\" maxlength=\"100\" id=\"txt-ket-"+n+"\" value=\""+x.data3[i][8]+"\">"+
                        "</div>"+
                    "</td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delFrzPro('"+n+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                "</tr>";
        
        n++;
    }

    return hsl;
}

function getFrzVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));
        $.ajax({
            url : "./bin/php/gdtfrz.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[4] === "x")
                {
                    swal("Error (GFRZVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide")
                    
                    clearInterval(gvfrz);
                }
                else if(json.data[4] !== "?" && json.data[4] !== "")
                {
                    $("#head-vkode").text(json.data[4]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[4]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvfrz);
                }
            },
            error : function(){
                swal("Error (GFRZVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setFrzVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sfrzvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SFRZVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekFrzVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eFrz(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CFRZVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function newDtlFrz()
{
    var tgl = $("#dte-tgl").val(), trm = $("#txt-trm").val(), pro = $("#txt-pro3").val(), ket = $("#txt-ket").val();

    if(!$("#div-err-frz-1").hasClass("d-none"))
        $("#div-err-frz-1").addClass("d-none");

    if(!$("#div-err-frz-2").hasClass("d-none"))
        $("#div-err-frz-2").addClass("d-none");

    if(!$("#div-scs-frz-1").hasClass("d-none"))
        $("#div-scs-frz-1").addClass("d-none");

    if(tgl === "" || pro === "" || trm === "")
        $("#div-err-frz-1").removeClass("d-none");
    else
    {
        $("#btn-snfrz").prop("disabled", true);
        $("#btn-snfrz").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ndfrz.php",
                type : "post",
                data : {tgl : tgl, pro : pro, trm : trm, ket : ket},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-frz-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-frz-2").removeClass("d-none");
                    else
                    {
                        $("#div-scs-frz-1").removeClass("d-none");

                        $("#mdl-nfrz input").val("");
                        $("#dte-tgl").val(tgl);

                        schFrz($("#txt-srch-frz").val());
                    }

                    $("#btn-snfrz").prop("disabled", false);
                    $("#btn-snfrz").html("Simpan");
                },
                error : function(){
                    $("#btn-snfrz").prop("disabled", false);
                    $("#btn-snfrz").html("Simpan");
                    swal("Error (NDFRZ) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function newDtlEFrz()
{
    var n = $("#btn-sefrz").attr("data-count");

    $("#btn-sefrz").attr("data-count", parseInt(n)+1);

    $("#lst-efrz").append(
        "<tr id=\"lst-frz-pro-"+n+"\">"+
            "<td class=\"border\">"+
                "<div class=\"input-group\">"+
                    "<input type=\"text\" class=\"form-control\" maxlength=\"100\" id=\"txt-nma-trm-"+n+"\" readonly>"+
                    "<input type=\"text\" class=\"d-none\" maxlength=\"100\" id=\"txt-trm-"+n+"\">"+
                    "<div class=\"input-group-append\">"+
                        "<button class=\"btn btn-light border btn-strm\" type=\"button\" data-value=\""+n+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                    "</div>"+
                "</div>"+
            "</td>"+
            "<td class=\"border\">"+
                "<div class=\"input-group\">"+
                    "<input type=\"text\" class=\"form-control\" maxlength=\"100\" id=\"txt-nma-pro3-"+n+"\" readonly>"+
                    "<input type=\"text\" class=\"d-none\" maxlength=\"100\" id=\"txt-pro3-"+n+"\">"+
                    "<div class=\"input-group-append\">"+
                        "<button class=\"btn btn-light border btn-spro5\" type=\"button\" data-value=\""+n+"\"><img src=\"./bin/img/icon/folder-icon.png\" width=\"20\" alt=\"Pilih\"></button>"+
                    "</div>"+
                "</div>"+
            "</td>"+
            "<td class=\"border\">"+
                "<div class=\"input-group\">"+
                    "<input type=\"text\" class=\"form-control\" maxlength=\"100\" id=\"txt-ket-"+n+"\">"+
                "</div>"+
            "</td>"+
            "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delFrzPro('"+n+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
        "</tr>"
    );
}

function updFrz()
{
    var tgl = $("#edt-dte-tgl").val(), id = $("#edt-txt-id").val(), data = [], n = 0, gdg = $("#edt-slct-gdg").val();

    for(var i = 0; i < parseInt($("#btn-sefrz").attr("data-count")); i++)
    {
        if($("#txt-trm-"+i).length === 0)
            continue;

        data[n] = [$("#txt-trm-"+i).val(), $("#txt-pro3-"+i).val(), $("#txt-ket-"+i).val()];
        
        n++;
    }

    data = JSON.stringify(data);

    if(!$("#div-edt-err-frz-1").hasClass("d-none"))
        $("#div-edt-err-frz-1").addClass("d-none");

    if(!$("#div-edt-err-frz-2").hasClass("d-none"))
        $("#div-edt-err-frz-2").addClass("d-none");

    if(!$("#div-edt-err-frz-3").hasClass("d-none"))
        $("#div-edt-err-frz-3").addClass("d-none");

    if(!$("#div-edt-err-frz-4").hasClass("d-none"))
        $("#div-edt-err-frz-4").addClass("d-none");

    if(!$("#div-edt-err-frz-5").hasClass("d-none"))
        $("#div-edt-err-frz-5").addClass("d-none");

    if(!$("#div-edt-scs-frz-1").hasClass("d-none"))
        $("#div-edt-scs-frz-1").addClass("d-none");

    //ToTop();
    if(tgl === "" || gdg === "")
        $("#div-edt-err-frz-1").removeClass("d-none");
    else if(data.length === 0)
        $("#div-edt-err-frz-4").removeClass("d-none");
    else
    {
        $("#btn-sefrz").prop("disabled", true);
        $("#btn-sefrz").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ufrz.php",
                type : "post",
                data : {id : id, tgl : tgl, data : data, gdg : gdg},
                success : function(output){
                    var json = $.parseJSON(output);

                    swal.close();

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-frz-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-frz-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-frz-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-frz-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-frz-5").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-frz-1").removeClass("d-none");

                        schFrz($("#txt-srch-frz").val());

                        $("#mdl-efrz").modal("hide");
                    }

                    $("#btn-sefrz").prop("disabled", false);
                    $("#btn-sefrz").html("Simpan");
                },
                error : function(){
                    $("#btn-sefrz").prop("disabled", false);
                    $("#btn-sefrz").html("Simpan");
                    swal("Error (UFRZ) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delFrz(x)
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
                    url : "./bin/php/dfrz.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DFRZ - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schFrz($("#txt-srch-frz").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DFRZ) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delFrzPro(x, y)
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
            $("#lst-frz-pro-"+x).remove();
    })
}

//RE-PACKING
function getNIDRPkg(){
    Process();
    setTimeout(function(){
        if(!$("#div-err-rpkg-1").hasClass("d-none"))
            $("#div-err-rpkg-1").addClass("d-none");
            
        if(!$("#div-err-rpkg-2").hasClass("d-none"))
            $("#div-err-rpkg-2").addClass("d-none");
            
        if(!$("#div-err-rpkg-3").hasClass("d-none"))
            $("#div-err-rpkg-3").addClass("d-none");
            
        if(!$("#div-err-rpkg-4").hasClass("d-none"))
            $("#div-err-rpkg-4").addClass("d-none");
            
        if(!$("#div-scs-rpkg-1").hasClass("d-none"))
            $("#div-scs-rpkg-1").addClass("d-none");
            
        $("#btn-snrpkg").prop("disabled", false);
        $("#btn-snrpkg").html("Simpan");
        $("#mdl-nrpkg").modal("show");

        swal.close();
    }, 200);
}

function schRPkg(x){
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/srpkg.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-rpkg").html(setToTblRPkg(json));

                swal.close();
            },
            error : function(){
                swal("Error (SRPKG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblRPkg(x){
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++){
        var nma = x.data[i][1]+" / "+x.data[i][2], dtl = "";

        if(x.data[i][3] !== ""){
            nma += " / "+x.data[i][3];
        }

        if(x.data[i][4] !== ""){
            nma += " / "+x.data[i][4];
        }
        
        for(var j = 0; j < x.data2[i].length; j++){
            var nma2 = x.data2[i][j][4]+" / "+x.data2[i][j][5];

            if(x.data2[i][j][6] !== ""){
                nma2 += " / "+x.data2[i][j][6];
            }
    
            if(x.data2[i][j][7] !== ""){
                nma2 += " / "+x.data2[i][j][7];
            }

            dtl += "<li>"+nma2+" ("+NumberFormat2(x.data2[i][j][2])+")</li>";
        }

        hsl += "<tr ondblclick=\"viewRPkg('"+UE64(x.data[i][8])+"')\">"+
                    "<td class=\"border\">"+x.data[i][0]+"</td>"+
                    "<td class=\"border\">"+nma+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][5])))+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(parseFloat((x.data[i][9])))+"</td>"+
                    "<td class=\"border\">"+x.data[i][10]+"</td>"+
                    "<td class=\"border small\"><ul>"+dtl+"</ul></td>"+
                    "<td class=\"border\">"+x.data[i][6]+"</td>"+
                    "<td class=\"border\">"+x.data[i][7]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eRPkg('"+UE64(x.data[i][8])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
        
        if(x.aks[1])
            hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delRPkg('"+UE64(x.data[i][8])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
        
            
        hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewRPkg('"+UE64(x.data[i][8])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"Lihat Penerimaan\" width=\"20\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function eRPkg(x, y = 1){
    x = UD64(x);

    if(!$("#edt-div-err-rpkg-1").hasClass("d-none"))
        $("#edt-div-err-rpkg-1").addClass("d-none");

    if(!$("#edt-div-err-rpkg-2").hasClass("d-none"))
        $("#edt-div-err-rpkg-2").addClass("d-none");
        
    if(!$("#edt-div-err-rpkg-3").hasClass("d-none"))
        $("#edt-div-err-rpkg-3").addClass("d-none");
        
    if(!$("#edt-div-err-rpkg-4").hasClass("d-none"))
        $("#edt-div-err-rpkg-4").addClass("d-none");
        
    if(!$("#edt-div-err-rpkg-5").hasClass("d-none"))
        $("#edt-div-err-rpkg-5").addClass("d-none");
        
    if(!$("#edt-div-err-rpkg-6").hasClass("d-none"))
        $("#edt-div-err-rpkg-6").addClass("d-none");
        
    if(!$("#edt-div-scs-rpkg-1").hasClass("d-none"))
        $("#edt-div-scs-rpkg-1").addClass("d-none");

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtrpkg.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                swal.close();

                if(!json.aks[0] && y === 1){
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

                                setRPkgVerif(x);

                                gvrpkg = setInterval(getRPkgVerif, 1000);
                                break;

                            default: 
                                break;
                        }
                    })
                }
                else{
                    $("#edt-dte-tgl").val(json.data[2]);
                    $("#edt-txt-ket").val(json.data[13]);
                    $("#edt-txt-bid").val(json.data[0]);
                    $("#edt-txt-nma-pro").val(json.data[9]);
                    $("#edt-txt-pro").val(json.data[7]);
                    $("#edt-txt-nma-grade").val(json.data[10]);
                    $("#edt-txt-nma-kate").val(json.data[11]);
                    $("#edt-txt-nma-skate").val(json.data[12]);
                    $("#edt-txt-weight-pro").val(json.data[8]);

                    $("#lst-erpkg").html(setToTblERPkg(json));
                    $("#btn-serpkg").attr("data-count", json.count[0]);

                    $("#mdl-erpkg").modal("show");
                }
            },
            error : function(){
                swal("Error (ERPKG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblERPkg(x){
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++){
        var nma = x.dtl[i][4]+" / "+x.dtl[i][5];

        if(x.dtl[i][6] !== ""){
            nma += " / "+x.dtl[i][6];
        }

        if(x.dtl[i][7] !== ""){
            nma += " / "+x.dtl[i][7];
        }

        hsl += "<tr id=\"row-erpkg-pro-"+i+"\">"+
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
                        "<input class=\"form-control text-right\" type=\"number\" id=\"edt-nmbr-weight-"+i+"\" value=\""+x.dtl[i][2]+"\">"+
                    "</td>"+
                    "<td class=\"border\">"+
                        "<button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delDtlRPkg('"+UE64(i)+"', 'E')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>"+
                    "</td>"+
                "</tr>";
    }

    return hsl;
}

function addDtlRPkg(){
    if($("#mdl-nrpkg").hasClass("show")){
        var count = $("#btn-snrpkg").attr("data-count");

        $("#lst-nrpkg").append(
            "<tr id=\"row-nrpkg-pro-"+count+"\">"+
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
                    "<input class=\"form-control text-right\" type=\"number\" id=\"nmbr-weight-"+count+"\" value=\"\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delDtlRPkg('"+UE64(count)+"', 'N')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>"+
                "</td>"+
            "</tr>"
        )

        $("#btn-snrpkg").attr("data-count", parseInt(count)+1);
    }
    else if($("#mdl-erpkg").hasClass("show")){
        var count = $("#btn-serpkg").attr("data-count");

        $("#lst-erpkg").append(
            "<tr id=\"row-erpkg-pro-"+count+"\">"+
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
                    "<input class=\"form-control text-right\" type=\"number\" id=\"edt-nmbr-weight-"+count+"\" value=\"\">"+
                "</td>"+
                "<td class=\"border\">"+
                    "<button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delDtlRPkg('"+UE64(count)+"', 'E')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>"+
                "</td>"+
            "</tr>"
        )

        $("#btn-serpkg").attr("data-count", parseInt(count)+1);
    }
}

function getRPkgVerif()
{
    setTimeout(function(){
        var id = UD64($("#txt-vkode").attr("data-value"));
        $.ajax({
            url : "./bin/php/gdtrpkg.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[5] === "x")
                {
                    swal("Error (GRPKGVRF) !!!", "Permintaan ralat di tolak !!!", "error");

                    $("#mdl-vrf").modal("hide");
                    
                    clearInterval(gvrpkg);
                }
                else if(json.data[5] !== "?" && json.data[5] !== "")
                {
                    $("#head-vkode").text(json.data[5]);
                    $("#txt-vkode").attr("data-value2", UE64(json.data[5]));

                    if($("#txt-vkode").prop("readonly"))
                        $("#txt-vkode").prop("readonly", false);

                    clearInterval(gvrpkg);
                }
            },
            error : function(){
                swal("Error (GRPKGVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setRPkgVerif(x)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/srpkgvrf.php",
            type : "post",
            data : {id : x},
            success : function(){

            },
            error : function(){
                swal("Error (SRPKGVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function cekRPkgVerif()
{
    var vkode = UD64($("#txt-vkode").attr("data-value2")), tkode = $("#txt-vkode").val(), id = $("#txt-vkode").attr("data-value");

    if(tkode === vkode && tkode !== "")
    {
        eRPkg(id, 2);
        
        $("#mdl-vrf").modal("hide");
    }
    else if((tkode !== "" && tkode !== vkode) || tkode === "")
        swal("Error (CRPKGVRF) !!!", "Kode verifikasi salah, harap cek kembali !!!", "error");
}

function setRPkgPVerif(pro, brt, tgl)
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/srpkgpvrf.php",
            type : "post",
            data : {pro : pro, brt : brt, tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                $("#dte-tgl").attr("data-verif", json.vpid[0]);
            },
            error : function(){
                swal("Error (SRPKGPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function getRPkgPVerif()
{
    setTimeout(function(){
        var id = $("#dte-tgl").attr("data-verif");
        $.ajax({
            url : "./bin/php/gdtpvrf.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                if(json.data[7] === "C")
                {
                    swal("Error (GRPKGPVRF) !!!", "Permintaan verifikasi di tolak !!!", "error");
                    
                    clearInterval(gvprpkg);
                }
                else if(json.data[7] === "V")
                {
                    clearInterval(gvprpkg);
                    setTimeout(function(){
                        newRPkg();
                    }, 200);
                }
            },
            error : function(){
                swal("Error (GRPKGPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function newRPkg(){
    var tgl = $("#dte-tgl").val(), ket = $("#txt-ket").val(), pro = $("#txt-pro").val(), weight = $("#txt-weight-pro").val(), lpro = [];

    for(var i = 0; i < parseInt($("#btn-snrpkg").attr("data-count")); i++){
        if($("#txt-pro3-"+i).length > 0)
            lpro.push([$("#txt-pro3-"+i).val(), $("#nmbr-weight-"+i).val()]);
    }

    if(!$("#div-err-rpkg-1").hasClass("d-none"))
        $("#div-err-rpkg-1").addClass("d-none");

    if(!$("#div-err-rpkg-2").hasClass("d-none"))
        $("#div-err-rpkg-2").addClass("d-none");
        
    if(!$("#div-err-rpkg-3").hasClass("d-none"))
        $("#div-err-rpkg-3").addClass("d-none");
        
    if(!$("#div-err-rpkg-4").hasClass("d-none"))
        $("#div-err-rpkg-4").addClass("d-none");
        
    if(!$("#div-scs-rpkg-1").hasClass("d-none"))
        $("#div-scs-rpkg-1").addClass("d-none");

    if(tgl === "" || pro === "" || weight === ""){
        $("#div-err-rpkg-1").removeClass("d-none");
    }
    else if(lpro.length === 0){
        $("#div-err-rpkg-3").removeClass("d-none");
    }
    else{
        lpro = JSON.stringify(lpro);

        $("#btn-snrpkg").prop("disabled", true);
        $("#btn-snrpkg").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nrpkg.php",
                type : "post",
                data : {tgl : tgl, pro : pro, weight : weight, lpro : lpro, ket : ket},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1){
                        $("#div-err-rpkg-1").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -2){
                        $("#div-err-rpkg-2").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -3){
                        $("#div-err-rpkg-3").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -4){
                        $("#div-err-rpkg-5").removeClass("d-none");
                        swal({
                            title : "Perhatian !!!",
                            text : "Jumlah produk awal melebihi sisa stock, minta verifikasi ?",
                            icon : "warning",
                            dangerMode : true,
                            buttons : true,
                        })
                        .then((ok) => {
                            if(ok){
                                setRPkgPVerif(pro, weight, tgl);
                                gvprpkg = setInterval(getRPkgPVerif, 1000);
                                Process();
                            }
                        })
                    }
                    else if(parseInt(json.err[0]) === -5){
                        $("#div-err-rpkg-4").removeClass("d-none");
                    }
                    else{
                        $("#mdl-nrpkg input").val("");
                        $("#lst-nrpkg").html("");
                        $("#btn-snrpkg").attr("data-count", 0);
                        $("#dte-tgl").val(tgl);

                        $("#div-scs-rpkg-1").removeClass("d-none");
                        schRPkg($("#txt-srch-rpkg").val());
                    }

                    $("#btn-snrpkg").prop("disabled", false);
                    $("#btn-snrpkg").html("Simpan");
                },
                error : function(){
                    $("#btn-snrpkg").prop("disabled", false);
                    $("#btn-snrpkg").html("Simpan");
                    swal("Error (NRPKG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                }
            })
        }, 200);
    }
}

function updRPkg(){
    var tgl = $("#edt-dte-tgl").val(), ket = $("#edt-txt-ket").val(), pro = $("#edt-txt-pro").val(), weight = $("#edt-txt-weight-pro").val(), lpro = [], bid = $("#edt-txt-bid").val();

    for(var i = 0; i < parseInt($("#btn-serpkg").attr("data-count")); i++){
        if($("#edt-txt-pro3-"+i).length > 0)
            lpro.push([$("#edt-txt-pro3-"+i).val(), $("#edt-nmbr-weight-"+i).val()]);
    }
    
    if(!$("#edt-div-err-rpkg-1").hasClass("d-none"))
        $("#edt-div-err-rpkg-1").addClass("d-none");

    if(!$("#edt-div-err-rpkg-2").hasClass("d-none"))
        $("#edt-div-err-rpkg-2").addClass("d-none");
        
    if(!$("#edt-div-err-rpkg-3").hasClass("d-none"))
        $("#edt-div-err-rpkg-3").addClass("d-none");
        
    if(!$("#edt-div-err-rpkg-4").hasClass("d-none"))
        $("#edt-div-err-rpkg-4").addClass("d-none");
        
    if(!$("#edt-div-err-rpkg-5").hasClass("d-none"))
        $("#edt-div-err-rpkg-5").addClass("d-none");
        
    if(!$("#edt-div-err-rpkg-6").hasClass("d-none"))
        $("#edt-div-err-rpkg-6").addClass("d-none");
        
    if(!$("#edt-div-scs-rpkg-1").hasClass("d-none"))
        $("#edt-div-scs-rpkg-1").addClass("d-none");

    if(tgl === "" || pro === "" || weight === ""){
        $("#edt-div-err-rpkg-1").removeClass("d-none");
    }
    else if(lpro.length === 0){
        $("#edt-div-err-rpkg-3").removeClass("d-none");
    }
    else{
        lpro = JSON.stringify(lpro);
        
        $("#btn-serpkg").prop("disabled", true);
        $("#btn-serpkg").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/urpkg.php",
                type : "post",
                data : {tgl : tgl, pro : pro, weight : weight, lpro : lpro, bid : bid, ket : ket},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1){
                        $("#edt-div-err-rpkg-1").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -2){
                        $("#edt-div-err-rpkg-2").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -3){
                        $("#edt-div-err-rpkg-3").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -4){
                        $("#edt-div-err-rpkg-4").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -5){
                        $("#edt-div-err-rpkg-5").removeClass("d-none");
                    }
                    else if(parseInt(json.err[0]) === -6){
                        $("#edt-div-err-rpkg-6").removeClass("d-none");
                    }
                    else{
                        $("#edt-div-scs-rpkg-1").removeClass("d-none");
                        schRPkg($("#txt-srch-rpkg").val());
                        $("#mdl-erpkg").modal("hide");
                    }

                    $("#btn-serpkg").prop("disabled", false);
                    $("#btn-serpkg").html("Simpan");
                },
                error : function(){
                    $("#btn-serpkg").prop("disabled", false);
                    $("#btn-serpkg").html("Simpan");
                    swal("Error (NRPKG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                }
            })
        }, 200);
    }
}

function delRPkg(x){
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
                    url : "./bin/php/drpkg.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DRPKG - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schRPkg($("#txt-srch-rpkg").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DRPKG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delDtlRPkg(x, y){
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
                $("#row-nrpkg-pro-"+x).remove();
            }
            else if(y === 'E'){
                $("#row-erpkg-pro-"+x).remove();
            }
        }
    })
}

function viewRPkg(x){
    x = UD64(x);
    
    window.open("./lihat-re-packaging?id="+UE64(x), "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}