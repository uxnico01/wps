//SUPPLIER
function getNIDSup()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-sup-1").hasClass("d-none"))
            $("#div-err-sup-1").addClass("d-none");
            
        if(!$("#div-err-sup-2").hasClass("d-none"))
            $("#div-err-sup-2").addClass("d-none");
            
        if(!$("#div-err-sup-3").hasClass("d-none"))
            $("#div-err-sup-3").addClass("d-none");

        if(!$("#div-scs-sup-1").hasClass("d-none"))
            $("#div-scs-sup-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidsup.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-sup").val(json.nid[0]);
                $("#mdl-nsup").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function schSup(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ssup.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-sup").html(setToTblSup(json));
                else if(y === 2)
                    $("#lst-sssup").html(setToTblSup2(json));
                else if(y === 3)
                    $("#lst-sssup2").html(setToTblSup3(json));
                else if(y === 4)
                    $("#lst-sssup3").html(setToTblSup4(json));

                swal.close();
            },
            error : function(){
                swal("Error (SSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblSup(x)
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
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][10])+"</td>"+
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eSup('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delSup('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            if(x.aks[3])
                hsl += " <button class=\"btn btn-light border-success mb-1 p-1\" onclick=\"hrgSup('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/money2-icon.png\" alt=\"More\" width=\"20\"></button>";
            
            if(x.aks[4])
                hsl += " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"smpnSup('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/wallet-icon.png\" alt=\"Wallet\" width=\"20\"></button>";
            
            if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-info mb-1 p-1\" onclick=\"mdlSup('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/more-info.png\" alt=\"More\" width=\"20\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"11\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function setToTblSup2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgSup('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
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
                    "<td colspan=\"10\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblSup3(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\"><button class=\"btn btn-sm btn-light border-success\" onclick=\"addAtSup('"+UE64(x.data[i][0])+"', '"+UE64(x.data[i][1])+"', '"+UE64(x.data[i][2])+"', '"+UE64(x.data[i][3])+"', this)\"><img src=\"./bin/img/icon/plus.png\" width=\"18\"></button></td>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblSup4(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\"><button class=\"btn btn-sm btn-light border-success\" onclick=\"addDtSup('"+UE64(x.data[i][0])+"', '"+UE64(x.data[i][1])+"')\"><img src=\"./bin/img/icon/plus.png\" width=\"18\"></button></td>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function chgSup(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtsup.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-nma-sup").val(json.data[1]);
                $("#txt-sup").val(x);
                $("#spn-poto").text("Sisa Pinjaman : "+NumberFormat2(json.spjm[0]));
                $("#txt-poto").attr("data-value", UE64(json.spjm[0]));

                $("#edt-txt-nma-sup").val(json.data[1]);
                $("#edt-txt-sup").val(x);
                $("#edt-spn-poto").text("Sisa Pinjaman : "+NumberFormat2(json.spjm[0]));
                $("#edt-txt-poto").attr("data-value", UE64(json.spjm[0]));

                if($("#lst-ntrm").length > 0 || $("#lst-etrm").length > 0)
                    updHSupTrm(json);

                $("#mdl-ssup").modal("hide");

                if($("#slct-weight").length > 0)
                    getTrmCut();

                if($("#txt-sjlh").length > 0)
                    $("#txt-sjlh").val(NumberFormat2(json.ssmpn[0]));
                    
                $("#txt-min").val(NumberFormat2(json.vmin[0]));

                swal.close();
            },
            error : function(){
                swal("Error (CHGSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function addAtSup(id, nama, addr, wila, x)
{
    var count = $("#btn-sat-trm").attr("data-csup"), err = 0;

    $(x).prop("disabled", true);
    $(x).html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");

    for(var i = 0; i < count; i++)
    {
        if($("#btn-dat-sup-trm-"+i).attr("data-value") === id)
        {
            err = -1;
            break;
        }
    }

    if(err === -1)
        swal("Error !!!", "Supplier sudah dipilih, harap memilih supplier lain", "error");
    else
    {
        $("#lst-tsup-trm").append(
            "<tr id=\"row-tsup-trm-"+count+"\">"+
                "<td class=\"border\">"+UD64(id)+"</td>"+
                "<td class=\"border\">"+UD64(nama)+"</td>"+
                "<td class=\"border\">"+UD64(addr)+"</td>"+
                "<td class=\"border\">"+UD64(wila)+"</td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-0\" onclick=\"delAtSupTrm('"+UE64(count)+"')\" data-value=\""+id+"\" id=\"btn-dat-sup-trm-"+i+"\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>"
        );

        $("#btn-sat-trm").attr("data-csup", parseInt(count)+1);
    }

    $(x).prop("disabled", false);
    $(x).html("<img src=\"./bin/img/icon/plus.png\" width=\"18\">");
}

function addDtSup(id, nama){
    id = UD64(id);
    nama = UD64(nama);
    var count = $("#btn-snahsup").attr("data-csup"), cek = false;
    
    for(var i = 0; i < count; i++){
        if($("#btn-dsup-"+i).length === 0)
            continue;

        var sup = UD64($("#btn-dsup-"+i).attr("data-sup"));
        if(sup === id){
            cek = true;
            break;
        }
    }

    if(!cek){
        $("#lst-dsup").append(
            "<div class=\"row my-1\" id=\"div-dsup-"+i+"\">"+
                "<div class=\"col-8\">"+nama+"</div>"+
                "<div class=\"col-4\"><button class=\"btn btn-sm btn-light border-danger btn-dsup\" id=\"btn-dsup-"+count+"\" data-sup=\""+UE64(id)+"\" data-value=\""+count+"\"><img src=\"./bin/img/icon/delete-icon.png\" width=\"18\"></button></div>"
            +"</div>"
        )

        $("#btn-snahsup").attr("data-csup", parseInt(count)+1);
    }
    else{
        swal("Error (ADSUP) !!!", "Harap memilih supplier lain karena supplier sudah dipilih sebelumnya !!!", "error");
    }
}

function delDtSup(x){
    swal({
        title : "Perhatian !!!",
        text : "Anda yakin hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) => {
        if(ok){
            $("#div-dsup-"+x).remove();
        }
    })
}

function updHSupTrm(x)
{
    for(var i = 0; i < parseInt($("#btn-sntrm").attr("data-count")); i++)
    {
        $("#txt-ntrm-smpn-"+i).text(0);
        $("#txt-ntrm-hrga-"+i).text(0);

        for(var j = 0; j < x.count[0]; j++)
        {
            var sat = UD64($("#txt-ntrm-pro-"+i).attr("data-stn")), grade = UD64($("#txt-ntrm-pro-"+i).attr("data-grade"));

            if(sat === x.data2[j][2] && grade === x.data2[j][1])
            {
                var hrga = 0;

                if(x.data2[j][3] !== 0)
                {
                    hrga = x.data2[j][3];

                    for(var k = 0; k < x.count[1]; k++)
                    {
                        if(x.data2[j][2] === x.data3[k][2] && x.data2[j][1] === x.data3[k][1])
                        {
                            $("#txt-ntrm-smpn-"+i).text(NumberFormat2(x.data3[k][3]));
                            hrga -= x.data3[k][3];
                            break;
                        }
                    }
                }

                $("#txt-ntrm-hrga-"+i).text(NumberFormat2(x.data2[j][3]));
            }
        }
    }

    for(var i = 0; i < parseInt($("#btn-setrm").attr("data-count")); i++)
    {
        $("#txt-etrm-smpn-"+i).text(0);
        $("#txt-etrm-hrga-"+i).text(0);

        for(var j = 0; j < x.count[0]; j++)
        {
            var sat = UD64($("#txt-etrm-pro-"+i).attr("data-stn")), grade = UD64($("#txt-etrm-pro-"+i).attr("data-grade"));
            
            if(sat === x.data2[j][2] && grade === x.data2[j][1])
            {
                var hrga = 0;

                if(x.data2[j][3] !== 0)
                {
                    hrga = x.data2[j][3];

                    for(var k = 0; k < x.count[1]; k++)
                    {
                        if(x.data2[j][2] === x.data3[k][2] && x.data2[j][1] === x.data3[k][1])
                        {
                            $("#txt-etrm-smpn-"+i).text(NumberFormat2(x.data3[k][3]));
                            hrga -= x.data3[k][3];
                            break;
                        }
                    }
                }

                $("#txt-etrm-hrga-"+i).text(NumberFormat2(x.data2[j][3]));
            }
        }
    }
}

function schHTrmSup()
{
    var frm = $("#dte-frm-prtt").val(), to = $("#dte-to-prtt").val(), sup = $("#txt-opt-sup").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shtrmsup.php",
            type : "post",
            data : {frm : frm, to : to, sup : sup, type : 1},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-sup-prtt").html(setToTblHTrmSup(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHTRMSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHTrmSup(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][2])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][5])+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\">"+x.data[i][10]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"11\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function schHTrmSup2()
{
    var frm = $("#dte-frm-prtt2").val(), to = $("#dte-to-prtt2").val(), sup = $("#txt-opt-sup").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shtrmsup.php",
            type : "post",
            data : {frm : frm, to : to, sup : sup, type : 2},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-sup-prtt2").html(setToTblHTrmSup2(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHTRMSUP2) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHTrmSup2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            if(x.data[i][5] === 0 || x.data[i][5] === null)
                continue;

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][5])+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function schHSmpnSup()
{
    var frm = $("#dte-frm-smpn").val(), to = $("#dte-to-smpn").val(), sup = $("#txt-opt-sup").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shsmpnsup.php",
            type : "post",
            data : {frm : frm, to : to, sup : sup},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-sup-smpn").html(setToTblHSmpnSup(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHSMPNSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHSmpnSup(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            if(x.data[i][1] === null)
                x.data[i][1] = 0;

            if(x.data[i][2] === null)
                x.data[i][2] = 0;
                
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][1])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][2])+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function schHTTSup()
{
    var frm = $("#dte-frm-trtt").val(), to = $("#dte-to-trtt").val(), sup = $("#txt-opt-sup").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shttsup.php",
            type : "post",
            data : {frm : frm, to : to, sup : sup},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-sup-trtt").html(setToTblHTTSup(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHTTSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHTTSup(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][2])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][5])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][6])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][7])+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\">"+x.data[i][10]+"</td>"+
                        "<td class=\"border\">"+x.data[i][11]+"</td>"+
                        "<td class=\"border\">"+x.data[i][12]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"13\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function schHPjmSup()
{
    var frm = $("#dte-frm-trpjm").val(), to = $("#dte-to-trpjm").val(), sup = $("#txt-opt-sup").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shpjmsup.php",
            type : "post",
            data : {frm : frm, to : to, sup : sup},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-sup-trpjm").html(setToTblHPjmSup(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHPJMSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHPjmSup(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][2])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
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

function eSup(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-sup-1").hasClass("d-none"))
            $("#div-edt-err-sup-1").addClass("d-none");

        if(!$("#div-edt-err-sup-2").hasClass("d-none"))
            $("#div-edt-err-sup-2").addClass("d-none");
            
        if(!$("#div-edt-err-sup-3").hasClass("d-none"))
            $("#div-edt-err-sup-3").addClass("d-none");
            
        if(!$("#div-edt-err-sup-4").hasClass("d-none"))
            $("#div-edt-err-sup-4").addClass("d-none");
            
        if(!$("#div-edt-scs-sup-1").hasClass("d-none"))
            $("#div-edt-scs-sup-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtsup.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);
                $("#edt-txt-addr").val(json.data[2]);
                $("#edt-txt-reg").val(json.data[3]);
                $("#edt-txt-phone").val(json.data[4]);
                $("#edt-txt-phone2").val(json.data[5]);
                $("#edt-txt-mail").val(json.data[6]);
                $("#edt-txt-ket").val(json.data[7]);
                $("#edt-txt-ket2").val(json.data[8]);
                $("#edt-txt-ket3").val(json.data[9]);
                $("#edt-txt-smpn").val(NumberFormat2(json.data[10]));

                $("#mdl-esup").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (ESUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlSup(x)
{
    x = UD64(x);

    $("#txt-opt-sup").val(x);

    $("#mdl-opt-sup").modal("show");
}

function hrgSup(x)
{
    x = UD64(x);

    var n = parseInt($("#btn-snhsup").attr("data-count"));

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthssup.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#st-nm-sup").text(json.sup[1]);
                $("#st-nm-sup").attr("data-value", UE64(x));

                for(var i = 0; i < n; i++)
                {
                    var sat = UD64($("#txt-hsup-"+i).attr("data-sat")), grade = UD64($("#txt-hsup-"+i).attr("data-grade"));

                    for(var j = 0; j < json.count[0]; j++)
                    {
                        if(json.data[j][1] === grade && json.data[j][2] === sat)
                        {
                            $("#txt-hsup-"+i).val(NumberFormat2(json.data[j][3]));

                            break;
                        }
                    }
                }

                swal.close();
                $("#mdl-shrga-sup").modal("show");
            },
            error : function(){
                swal("Error (HSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function updHSup()
{
    var n = parseInt($("#btn-snhsup").attr("data-count")), sup = UD64($("#st-nm-sup").attr("data-value")), ldata = [];

    $("#btn-snhsup").prop("disabled", true);
    $("#btn-snhsup").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

    for(var i = 0; i < n; i++)
    {
        ldata[i] = [UD64($("#txt-hsup-"+i).attr("data-grade")), UD64($("#txt-hsup-"+i).attr("data-sat")), UnNumberFormat($("#txt-hsup-"+i).val())];
    }

    ldata = JSON.stringify(ldata);

    setTimeout(function(){
        $.ajax({
            url : "./bin/php/uhsup.php",
            type : "post",
            data : {sup : sup, ldata : ldata},
            success : function(){
                $("#btn-snhsup").prop("disabled", false);
                $("#btn-snhsup").html("Simpan");

                $("#mdl-shrga-sup input").val("");
                $("#mdl-shrga-sup").modal("hide");

                swal("Sukses !!!", "Data berhasil diubah !!!", "success");
            },
            error : function(){
                $("#btn-snhsup").prop("disabled", false);
                $("#btn-snhsup").html("Simpan");

                swal("Error (HSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlDuplicateSupp(x)
{
    x = UD64(x);
    swal({
        title : "Perhatian !!!",
        text : "Yakin mau duplikasi data ?",
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
                    url : "./bin/php/newdsup.php",
                    type : "post",
                    data : {id : x},
                    success : function(){
                        $("#mdl-ssmpn-sup").modal("hide");
                        swal({
                            title : "Sukses !!!!",
                            text : "Data duplikat berhasil ditambahkan !!!",
                            icon : "success",
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        })
                        .then(ok => {
                            if(ok)
                            {
                                // 
                            }
                        });
                    },
                    error : function(){
                        swal("Error (NDSUPP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function hDupSup(x, y)
{
    x = UD64(x);

    var dupCount = parseInt(x.slice(-1));
    var totDup = parseInt(y);

    if(dupCount != totDup){
        swal({
            title : "Terjadi Kesalahan !!!",
            text : "Tolong hapus duplikasi yang terakhir terlebih dahulu !!!",
            icon : "error",
            buttons : {
                okay: "OK",
            },
            closeOnClickOutside: false,
            closeOnEsc: false,
        })
        .then((value) => {
            switch (value) {
                case "okay":
                    swal.close();
            }
        })
    }
    else {
        swal({
            title : "Perhatian !!!",
            text : "Yakin mau hapus duplikasi data ?",
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
                        url : "./bin/php/hdsup.php",
                        type : "post",
                        data : {id : x},
                        success : function(){
                            $("#mdl-ssmpn-sup").modal("hide");
                                swal({
                                    title : "Sukses !!!!",
                                    text : "Data duplikasi berhasil dihapus !!!",
                                    icon : "success",
                                    closeOnClickOutside : false,
                                    closeOnEsc : false,
                                })
                                .then(ok => {
                                    if(ok)
                                    {
                                        // 
                                    }
                                });
                            // }
                        },
                        error : function(){
                            swal("Error (HDSUPP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                        },
                    })
                }, 200);
            }
        });
    }
}

function btnSimpDupp(x)
{
    var hsl = "";

    hsl += "<button type=\"button\" onclick=\"mdlDuplicateSupp('"+UE64(x)+"')\" class=\"btn btn-outline-success py-2 px-3 ml-3\">"+
        "<span class=\"mr-1\">Simpanan Duplikasi</span>"+
        "<img class=\"ml-1\" src=\"./bin/img/icon/plus.png\" width=\"20\" alt=\"Duplicate Supplier Icon\">"+
        "</button>";

    return hsl;
}

function smpnSup(x)
{
    x = UD64(x);

    var n = parseInt($("#btn-snpsup").attr("data-count"));

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtpssup.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);
                // Nama Class
                $(".st-nm-psup-cls").text(json.sup[1]);
                $(".st-nm-psup-cls").attr("data-value", UE64(x));
                $("#lst-btndcollapse").html(setToCntDCollapse(json, json.sup[0]));

                for(var i = 0; i < n; i++)
                {
                    var sat = UD64($("#txt-psup-"+i).attr("data-sat")), grade = UD64($("#txt-psup-"+i).attr("data-grade"));

                    for(var j = 0; j < json.count[0]; j++)
                    {
                        if(json.data[j][1] === grade && json.data[j][2] === sat)
                        {
                            $("#txt-psup-"+i).val(NumberFormat2(json.data[j][3]));

                            break;
                        }
                    }
                }
                
                var eachDupp = json.count[2] / json.count[1];
                for(var k = 0; k < json.count[1]; k++)
                {
                    var sPrice = (eachDupp * (k + 1)) - eachDupp;
                    var ePrice = (eachDupp * (k + 1)) - 1;

                    for(var l = sPrice; l <= ePrice; l++)
                    {
                        var satdup = UD64($("#txt-dpsup-"+l).attr("data-sat-dup")), gradedup = UD64($("#txt-dpsup-"+l).attr("data-grade-dup"));

                        for(var m = sPrice; m <= ePrice; m++)
                        {
                            if(json.data3[m][3] === gradedup && json.data3[m][2] === satdup)
                            {
                                $("#txt-dpsup-"+l).val(NumberFormat2(json.data3[m][5]));
                                break;
                            }
                        }
                    }
                }
                swal.close();
                $("#mdl-ssmpn-sup").modal("show");
            },
            error : function(){
                swal("Error (PSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setToCntDCollapse(x, y)
{
    var hsl = "";
    var newSatuanId = x.count[3];
    var dataCountDup = x.count[2] / x.count[1];
    var newTextDup =  0;
    // Update
    var lastCount = x.count[2];
    var jumlahDup = x.count[1];
    $("#lst-btnsmpndup").html(btnSimpDupp(y));
    if(x.count[1] > 0)
    {
        for(var i = 0; i < x.data2.length; i++)
        {
            hsl += "<div class=\"d-flex flex-column\">"+
                "<div>"+
                "<button onclick=toggleDuppColor('"+x.data2[i][1]+"') id=\"collapse-button-"+x.data2[i][1]+"\" class=\"collapse-supplier-icon-switch btn mb-2 mt-2 btn-dupp-supp\" type=\"button\" data-toggle=\"collapse\" data-target=\"#"+x.data2[i][1]+"\" aria-expanded=\"false\" aria-controls=\""+x.data2[i][1]+"\">"+
                "<div class=\"collapse-supplier-button\">"+
                "<p class=\"mb-0\">"+x.data2[i][6]+"</p>"+
                "<img class=\"collapse-supplier-up\" src=\"./bin/img/icon/arr-btm-wh.png\" alt=\"Arrow\" id=\"img-aks2-"+i+"\" width=\"14\">"+
                "<img class=\"collapse-supplier-down\" src=\"./bin/img/icon/arr-top-wh.png\" alt=\"Arrow\" id=\"img-aks2-"+i+"\" width=\"14\">"+
                "</div>"+
                "</button>"+
                "<button type=\"button\" class=\"btn btn-outline-primary btn-dupp-supp-save\" onclick=\"updDPSup('"+x.data2[i][6]+"', '"+x.data2[i][4]+"', '"+lastCount+"', '"+jumlahDup+"')\" data-count=\""+dataCountDup+"\">"+
                "<p class=\"mb-0\">Simpan</p>"+
                "</button>"+
                "<button id=\"btn-hdupsup\" class=\"btn btn-light border-danger btn-dupp-supp-del\" onclick=\"hDupSup('"+UE64(x.data2[i][6])+"','"+jumlahDup+"')\" type=\"button\">"+
                "<img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus Duplikasi\" width=\"18\">"+
                "</button>"+
                "</div>"+
                "</div>";
                // Collapse
                // data-parent=\"#lst-btndcollapse\"
                hsl += "<div class=\"collapse mt-3\" id=\""+x.data2[i][1]+"\">"+
                    "<div class=\"row\">";
                // Collapse - Satuan
                for(var k = 0; k < x.count[3]; k++)
                {
                    hsl += "<div class=\"col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2\">"+
                        "<div class=\"card p-0\" id=\"card-aks2-"+newSatuanId+"\" onmouseover=\"cardHvr2("+newSatuanId+")\" onmouseout=\"cardNHvr2("+newSatuanId+")\">"+
                        "<div class=\"card-header csr-pntr\" id=\"div-dhead2-"+newSatuanId+"\" onclick=\"cardAct2("+newSatuanId+")\">"+x.data4[k][1]+""+
                        "<img src=\"./bin/img/icon/arr-btm.png\" alt=\"Arrow\" id=\"img-aks2-"+newSatuanId+"\" width=\"18\" class=\"ml-2\">"+
                        "</div>"+
                        "<div class=\"card-body py-1 d-none\" id=\"div-dcard2-"+newSatuanId+"\">";
                    newSatuanId++
                    // Collapse - Grade
                    for(var l = 0; l < x.count[4]; l++)
                    {
                        hsl += "<div class=\"row my-2\">"+
                            "<div class=\"col-6\">"+x.data5[l][1]+"</div>"+
                            "<div class=\"col-6\"><input type=\"text\" class=\"form-control cformat\" id=\"txt-dpsup-"+newTextDup+"\" data-sat-dup=\""+UE64(x.data4[k][0])+"\" data-grade-dup=\""+UE64(x.data5[l][0])+"\"></div>"+
                            "</div>";
                        newTextDup++
                    }
                    hsl += "</div>"+
                        "</div>"+
                        "</div>";
                }
            hsl += "</div>"+
                "</div>";
        }
    }
    return hsl;
}

function toggleDuppColor(x)
{
    setTimeout(function() {
        if(!$("#collapse-button-"+x).hasClass("collapsed"))
        {
            $("#collapse-button-"+x).addClass("btn-dupp-supp-active");
        }
        else
        {
            $("#collapse-button-"+x).removeClass("btn-dupp-supp-active");
        }
    }, 100);
}

function updDPSup(a, x, z, q)
{
    swal({
        title : "Harap tunggu",
        text : "Sedang memperbarui data",
        buttons : false,
    })

    var namSup = a, IDSup = x, IDDSup = namSup.slice(0, 1)+IDSup+namSup.slice(-1), jumlahDup = parseInt(q), totDup = parseInt(z), supD = IDSup, lDData = [], eachDupp = totDup / jumlahDup, currentArray = parseInt(namSup.slice(-1));
    
    if(jumlahDup > 1)
    {
        var sPrice = (eachDupp * currentArray) - eachDupp;
        var ePrice = (eachDupp * currentArray) - 1;

        for(var j = sPrice; j < ePrice; j++)
        {
            lDData[j] = [IDDSup, UD64($("#txt-dpsup-"+j).attr("data-sat-dup")), UD64($("#txt-dpsup-"+j).attr("data-grade-dup")), IDSup, UnNumberFormat($("#txt-dpsup-"+j).val()), namSup];
        }
    }
    else {
        for(var i = 0; i < totDup; i++)
        {
            lDData[i] = [IDDSup, UD64($("#txt-dpsup-"+i).attr("data-sat-dup")), UD64($("#txt-dpsup-"+i).attr("data-grade-dup")), IDSup, UnNumberFormat($("#txt-dpsup-"+i).val()), namSup];
        }
    }

    lDData = JSON.stringify(lDData);
    lDData = JSON.parse(lDData, (k, v) => Array.isArray(v) ? v.filter(e => e !== null) : v)
    lDData = JSON.stringify(lDData,
        (key, value) => (value === null) ? '-' : value
    );
    console.log(lDData);

    setTimeout(function(){
        $.ajax({
            url : "./bin/php/updsup.php",
            type : "post",
            data : {supD : supD, lDData : lDData},
            success : function(output){
                var json = $.parseJSON(output);

                if(parseInt(json.cek[0]) === -1){
                    // console.log('Tidak ada record');
                }
                else if(parseInt(json.cek[0]) === -2){
                    // console.log('Ada record');
                }
                else{
                    // console.log('?');
                }

                $("#mdl-ssmpn-sup input").val("");
                $("#mdl-ssmpn-sup").modal("hide");
                swal({
                    title : "Sukses !!!",
                    text : "Data duplikasi berhasil diubah !!!",
                    icon : "success",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                })
                .then(ok => {
                    if(ok)
                    {
                        // 
                    }
                });
            },
            error : function(){
                swal("Error (PDSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function updPSup()
{
    var n = parseInt($("#btn-snpsup").attr("data-count")), sup = UD64($(".st-nm-psup-cls").attr("data-value")), ldata = [];

    $("#btn-snpsup").prop("disabled", true);
    $("#btn-snpsup").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");

    for(var i = 0; i < n; i++)
    {
        ldata[i] = [UD64($("#txt-psup-"+i).attr("data-grade")), UD64($("#txt-psup-"+i).attr("data-sat")), UnNumberFormat($("#txt-psup-"+i).val())];
    }

    ldata = JSON.stringify(ldata);

    setTimeout(function(){
        $.ajax({
            url : "./bin/php/upsup.php",
            type : "post",
            data : {sup : sup, ldata : ldata},
            success : function(){
                $("#btn-snpsup").prop("disabled", false);
                $("#btn-snpsup").html("Simpan");
        
                $("#mdl-ssmpn-sup input").val("");
                $("#mdl-ssmpn-sup").modal("hide");
                swal({
                    title : "Sukses !!!",
                    text : "Data berhasil diubah !!!",
                    icon : "success",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                })
                .then(ok => {
                    if(ok)
                    {
                        // 
                    }
                });
            },
            error : function(){
                $("#btn-snpsup").prop("disabled", false);
                $("#btn-snpsup").html("Simpan");

                swal("Error (PSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function defaultSup(q, sync) {
    if (q === '') {
        sync(ndata_sup.get(data_sup[0], data_sup[1], data_sup[2]));
    }

    else {
        ndata_sup.search(q, sync);
    }
}

function autoCmpSup()
{
    $('#bloodhound .typeahead').typeahead({
        minLength: 0,
        highlight: true
    },
    {
        name: 'Supplier',
        source: defaultSup
    });
}

function getSlctSupCut(y)
{
    $("#btn-rsup").prop("disabled", true);
    $("#btn-rsup").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");
    setTimeout(function(){
        $.ajax({
            url : './bin/php/gasup.php',
            type : "post",
            data : {tgl : ""},
            success : function(output){
                var json = $.parseJSON(output), lst = "<option value=\"\">Pilih Supplier</option>";

                for(var i = 0; i < json.count[0]; i++)
                    lst += "<option value=\""+json.data[i][0]+"\">"+json.data[i][1]+"</option>";

                $("#slct-sup-"+y).html(lst);

                $("#btn-rsup").prop("disabled", false);
                $("#btn-rsup").html("<img src=\"./bin/img/icon/refresh.png\" width=\"15\" alt=\"Refresh\">");
            },
            error : function(){
                $("#btn-rsup").prop("disabled", false);
                $("#btn-rsup").html("<img src=\"./bin/img/icon/refresh.png\" width=\"15\" alt=\"Refresh\">");
                swal("Error (GSSUPCT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function getHSSup(sup, pro, sat, x){
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ghssup.php",
            type : "post",
            data : {sup : sup, pro : pro, sat : sat},
            success : function(output){
                var json = $.parseJSON(output);
                
                $("#txt-hrga-"+x).val(NumberFormat2(json.data[0]));
                $("#txt-smpn-"+x).val(NumberFormat2(json.data[1]));
            },
            error : function(){
                swal("Error (GHSSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function updAHSup(){
    var tsup = $("#slct-tsup").val(), tgrade = $("#slct-tgrade").val(), tsat = $("#slct-tsat").val(), lsup = [], lgrade = [], lsat = [], jns = $("#slct-jns").val(), jlh = UnNumberFormat($("#txt-jlh").val()), prb = $("#slct-prb-ahsup").val();

    if(jlh === "")
        jlh = 0;
    else
        jlh = parseFloat(jlh);

    if(tsup === "2"){
        for(var i = 0; i < $("#btn-snahsup").attr("data-csup"); i++){
            if($("#btn-dsup-"+i).length === 0)
                continue;

            lsup.push(UD64($("#btn-dsup-"+i).attr("data-sup")));
        }
    }

    if(tgrade === "2"){
        for(var i = 0; i < $("#btn-snahsup").attr("data-cgrade"); i++){
            if($("#btn-dgrade-"+i).length === 0)
                continue;

            lgrade.push([UD64($("#btn-dgrade-"+i).attr("data-grade")), UnNumberFormat($("#txt-gjlh-"+i).val())]);
        }
    }

    if(tsat === "2"){
        for(var i = 0; i < $("#btn-snahsup").attr("data-csat"); i++){
            if($("#btn-dsat-"+i).length === 0)
                continue;

            lsat.push(UD64($("#btn-dsat-"+i).attr("data-sat")));
        }
    }

    if(!$("#div-err-ahsup-1").hasClass("d-none"))
        $("#div-err-ahsup-1").addClass("d-none");

    if(!$("#div-scs-ahsup-1").hasClass("d-none"))
        $("#div-scs-ahsup-1").addClass("d-none");

    if((tsup === "2" && lsup === "") || (tgrade === "2" && lgrade === "") || (tsat === "2" && lsat === "") || (jlh === 0 && prb === "1") || (prb === "2" && lgrade.length === 0)){
        $("#div-err-ahsup-1").removeClass("d-none");
    }
    else{
        lsup = JSON.stringify(lsup);
        lgrade = JSON.stringify(lgrade);
        lsat = JSON.stringify(lsat);
        $("#btn-snahsup").prop("disabled", true);
        $("#btn-snahsup").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ahsup.php",
                type : "post",
                data : {tsup : tsup, lsup : lsup, tgrade : tgrade, lgrade : lgrade, tsat : tsat, lsat : lsat, jlh : jlh, jns : jns, prb : prb},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1){
                        $("#div-err-ahsup-1").removeClass("d-none");
                    }
                    else{
                        $("#div-scs-ahsup-1").removeClass("d-none");

                        $("#txt-jlh").val("");

                        $("#lst-dsup").html("");
                        $("#lst-dgrade").html("");
                        $("#lst-dsat").html("");

                        $("#btn-snahsup").attr("data-csup", 0);
                        $("#btn-snahsup").attr("data-cgrade", 0);
                        $("#btn-snahsup").attr("data-csat", 0);
                    }

                    $("#btn-snahsup").prop("disabled", false);
                    $("#btn-snahsup").html("Simpan");
                },
                error : function(){
                    swal("Error (UAHSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            });
        }, 200);
    }
}

function newSup()
{
    var id = $("#txt-id-sup").val(), name = $("#txt-nma-sup").val(), addr = $("#txt-addr-sup").val(), reg = $("#txt-reg-sup").val(), hp = $("#txt-phone-sup").val(), hp2 = $("#txt-phone2-sup").val(), mail = $("#txt-mail-sup").val(), ket1 = $("#txt-ket-sup").val(), ket2 = $("#txt-ket2-sup").val(), ket3 = $("#txt-ket3-sup").val(), smpn = UnNumberFormat($("#txt-smpn-sup").val());

    if(!$("#div-err-sup-1").hasClass("d-none"))
        $("#div-err-sup-1").addClass("d-none");

    if(!$("#div-err-sup-2").hasClass("d-none"))
        $("#div-err-sup-2").addClass("d-none");

    if(!$("#div-err-sup-3").hasClass("d-none"))
        $("#div-err-sup-3").addClass("d-none");

    if(!$("#div-scs-sup-1").hasClass("d-none"))
        $("#div-scs-sup-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-err-sup-1").removeClass("d-none");
    else
    {
        $("#btn-snsup").prop("disabled", true);
        $("#btn-snsup").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nsup.php",
                type : "post",
                data : {id : id, name : name, addr : addr, reg : reg, hp : hp, hp2 : hp2, mail : mail, ket1 : ket1, ket2 : ket2, ket3 : ket3, smpn : smpn},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-sup-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-sup-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-sup-3").removeClass("d-none");
                    else
                    {
                        $("#mdl-nsup input").val("");
                        $("#txt-id-sup").val(json.nid[0]);

                        $("#txt-id-sup").focus().select();
                        $("#div-scs-sup-1").removeClass("d-none");

                        schSup($("#txt-srch-sup").val());
                    }
                    
                    $("#btn-snsup").prop("disabled", false);
                    $("#btn-snsup").html("Simpan");
                },
                error : function(){
                    $("#btn-snsup").prop("disabled", false);
                    $("#btn-snsup").html("Simpan");
                    swal("Error (NSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updSup()
{
    var id = $("#edt-txt-id").val(), bid = $("#edt-txt-bid").val(), name = $("#edt-txt-nma").val(), addr = $("#edt-txt-addr").val(), reg = $("#edt-txt-reg").val(), hp = $("#edt-txt-phone").val(), hp2 = $("#edt-txt-phone2").val(), mail = $("#edt-txt-mail").val(), ket1 = $("#edt-txt-ket").val(), ket2 = $("#edt-txt-ket2").val(), ket3 = $("#edt-txt-ket3").val(), smpn = UnNumberFormat($("#edt-txt-smpn").val());

    if(!$("#div-edt-err-sup-1").hasClass("d-none"))
        $("#div-edt-err-sup-1").addClass("d-none");

    if(!$("#div-edt-err-sup-2").hasClass("d-none"))
        $("#div-edt-err-sup-2").addClass("d-none");

    if(!$("#div-edt-err-sup-3").hasClass("d-none"))
        $("#div-edt-err-sup-3").addClass("d-none");

    if(!$("#div-edt-err-sup-4").hasClass("d-none"))
        $("#div-edt-err-sup-4").addClass("d-none");

    if(!$("#div-edt-scs-sup-1").hasClass("d-none"))
        $("#div-edt-scs-sup-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-edt-err-sup-1").removeClass("d-none");
    else
    {
        $("#btn-sesup").prop("disabled", true);
        $("#btn-sesup").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/usup.php",
                type : "post",
                data : {id : id, name : name, addr : addr, reg : reg, hp : hp, hp2 : hp2, mail : mail, ket1 : ket1, ket2 : ket2, ket3 : ket3, bid : bid, smpn : smpn},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-sup-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-sup-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-sup-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-sup-4").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-sup-1").removeClass("d-none");

                        schSup($("#txt-srch-sup").val());
                    }
                    
                    $("#btn-sesup").prop("disabled", false);
                    $("#btn-sesup").html("Simpan");
                },
                error : function(){
                    $("#btn-sesup").prop("disabled", false);
                    $("#btn-sesup").html("Simpan");
                    swal("Error (USUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delSup(x)
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
                    url : "./bin/php/dsup.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DSUP - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schSup($("#txt-srch-sup").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DSUP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delAtSupTrm(x)
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
            $("#row-tsup-trm-"+x).remove();
    })
}

//CUSTOMER
function getNIDCus()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-cus-1").hasClass("d-none"))
            $("#div-err-cus-1").addClass("d-none");
            
        if(!$("#div-err-cus-2").hasClass("d-none"))
            $("#div-err-cus-2").addClass("d-none");
            
        if(!$("#div-err-cus-3").hasClass("d-none"))
            $("#div-err-cus-3").addClass("d-none");

        if(!$("#div-scs-cus-1").hasClass("d-none"))
            $("#div-scs-cus-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidcus.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-cus").val(json.nid[0]);
                $("#mdl-ncus").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDCUS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function schCus(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/scus.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-cus").html(setToTblCus(json));
                else if(y === 2)
                    $("#lst-sscus").html(setToTblCus2(json));
                else if(y === 3)
                    $("#lst-sscus2").html(setToTblCus3(json));

                swal.close();
            },
            error : function(){
                swal("Error (SCUS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblCus(x)
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
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eCus('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delCus('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-info mb-1 p-1\" onclick=\"mdlCus('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/more-info.png\" alt=\"More\" width=\"20\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"11\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblCus2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgCus('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
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
                    "<td colspan=\"10\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblCus3(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\"><button class=\"btn btn-sm btn-light border-success\" onclick=\"addAtCus('"+UE64(x.data[i][0])+"', '"+UE64(x.data[i][1])+"', '"+UE64(x.data[i][2])+"', '"+UE64(x.data[i][3])+"', this)\"><img src=\"./bin/img/icon/plus.png\" width=\"18\"></button></td>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function addAtCus(id, nama, addr, wila, x)
{
    var count = $("#btn-sat-trm").attr("data-ccus"), err = 0;

    $(x).prop("disabled", true);
    $(x).html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");

    for(var i = 0; i < count; i++)
    {
        if($("#btn-dat-cus-trm-"+i).attr("data-value") === id)
        {
            err = -1;
            break;
        }
    }

    if(err === -1)
        swal("Error !!!", "Customer sudah dipilih, harap memilih customer lain", "error");
    else
    {
        $("#lst-tcus-krm").append(
            "<tr id=\"row-tcus-krm-"+count+"\">"+
                "<td class=\"border\">"+UD64(id)+"</td>"+
                "<td class=\"border\">"+UD64(nama)+"</td>"+
                "<td class=\"border\">"+UD64(addr)+"</td>"+
                "<td class=\"border\">"+UD64(wila)+"</td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-0\" onclick=\"delAtCusKrm('"+UE64(count)+"')\" data-value=\""+id+"\" id=\"btn-dat-cus-krm-"+i+"\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>"
        );

        $("#btn-sat-krm").attr("data-ccus", parseInt(count)+1);
    }

    $(x).prop("disabled", false);
    $(x).html("<img src=\"./bin/img/icon/plus.png\" width=\"18\">");
}

function chgCus(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtcus.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-nma-cus").val(json.data[1]);
                $("#txt-cus").val(x);

                $("#edt-txt-nma-cus").val(json.data[1]);
                $("#edt-txt-cus").val(x);

                $("#mdl-scus").modal("hide");

                swal.close();
            },
            error : function(){
                swal("Error (CHGCUS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function schHKrmCus()
{
    var frm = $("#dte-frm-trkrm").val(), to = $("#dte-to-trkrm").val(), cus = $("#txt-opt-cus").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shkrmcus.php",
            type : "post",
            data : {frm : frm, to : to, cus : cus},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-cus-trkrm").html(setToTblHKrmCus(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHKRMCUS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHKrmCus(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][2])+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"8\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function eCus(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-cus-1").hasClass("d-none"))
            $("#div-edt-err-cus-1").addClass("d-none");

        if(!$("#div-edt-err-cus-2").hasClass("d-none"))
            $("#div-edt-err-cus-2").addClass("d-none");
            
        if(!$("#div-edt-err-cus-3").hasClass("d-none"))
            $("#div-edt-err-cus-3").addClass("d-none");
            
        if(!$("#div-edt-err-cus-4").hasClass("d-none"))
            $("#div-edt-err-cus-4").addClass("d-none");
            
        if(!$("#div-edt-scs-cus-1").hasClass("d-none"))
            $("#div-edt-scs-cus-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtcus.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);
                $("#edt-txt-addr").val(json.data[2]);
                $("#edt-txt-reg").val(json.data[3]);
                $("#edt-txt-phone").val(json.data[4]);
                $("#edt-txt-phone2").val(json.data[5]);
                $("#edt-txt-mail").val(json.data[6]);
                $("#edt-txt-ket").val(json.data[7]);
                $("#edt-txt-ket2").val(json.data[8]);
                $("#edt-txt-ket3").val(json.data[9]);

                $("#mdl-ecus").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (ECUS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlCus(x)
{
    x = UD64(x);

    $("#txt-opt-cus").val(x);

    $("#mdl-opt-cus").modal("show");
}

function newCus()
{
    var id = $("#txt-id-cus").val(), name = $("#txt-nma-cus").val(), addr = $("#txt-addr-cus").val(), reg = $("#txt-reg-cus").val(), hp = $("#txt-phone-cus").val(), hp2 = $("#txt-phone2-cus").val(), mail = $("#txt-mail-cus").val(), ket1 = $("#txt-ket-cus").val(), ket2 = $("#txt-ket2-cus").val(), ket3 = $("#txt-ket3-cus").val();

    if(!$("#div-err-cus-1").hasClass("d-none"))
        $("#div-err-cus-1").addClass("d-none");

    if(!$("#div-err-cus-2").hasClass("d-none"))
        $("#div-err-cus-2").addClass("d-none");

    if(!$("#div-err-cus-3").hasClass("d-none"))
        $("#div-err-cus-3").addClass("d-none");

    if(!$("#div-scs-cus-1").hasClass("d-none"))
        $("#div-scs-cus-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-err-cus-1").removeClass("d-none");
    else
    {
        $("#btn-sncus").prop("disabled", true);
        $("#btn-sncus").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ncus.php",
                type : "post",
                data : {id : id, name : name, addr : addr, reg : reg, hp : hp, hp2 : hp2, mail : mail, ket1 : ket1, ket2 : ket2, ket3 : ket3},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-cus-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-cus-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-cus-3").removeClass("d-none");
                    else
                    {
                        $("#mdl-ncus input").val("");
                        $("#txt-id-cus").val(json.nid[0]);

                        $("#txt-id-cus").focus().select();
                        $("#div-scs-cus-1").removeClass("d-none");

                        schCus($("#txt-srch-cus").val());
                    }
                    
                    $("#btn-sncus").prop("disabled", false);
                    $("#btn-sncus").html("Simpan");
                },
                error : function(){
                    $("#btn-sncus").prop("disabled", false);
                    $("#btn-sncus").html("Simpan");
                    swal("Error (NCUS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updCus()
{
    var id = $("#edt-txt-id").val(), bid = $("#edt-txt-bid").val(), name = $("#edt-txt-nma").val(), addr = $("#edt-txt-addr").val(), reg = $("#edt-txt-reg").val(), hp = $("#edt-txt-phone").val(), hp2 = $("#edt-txt-phone2").val(), mail = $("#edt-txt-mail").val(), ket1 = $("#edt-txt-ket").val(), ket2 = $("#edt-txt-ket2").val(), ket3 = $("#edt-txt-ket3").val();

    if(!$("#div-edt-err-cus-1").hasClass("d-none"))
        $("#div-edt-err-cus-1").addClass("d-none");

    if(!$("#div-edt-err-cus-2").hasClass("d-none"))
        $("#div-edt-err-cus-2").addClass("d-none");

    if(!$("#div-edt-err-cus-3").hasClass("d-none"))
        $("#div-edt-err-cus-3").addClass("d-none");

    if(!$("#div-edt-err-cus-4").hasClass("d-none"))
        $("#div-edt-err-cus-4").addClass("d-none");

    if(!$("#div-edt-scs-cus-1").hasClass("d-none"))
        $("#div-edt-scs-cus-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-edt-err-cus-1").removeClass("d-none");
    else
    {
        $("#btn-secus").prop("disabled", true);
        $("#btn-secus").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ucus.php",
                type : "post",
                data : {id : id, name : name, addr : addr, reg : reg, hp : hp, hp2 : hp2, mail : mail, ket1 : ket1, ket2 : ket2, ket3 : ket3, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-cus-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-cus-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-cus-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-cus-4").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-cus-1").removeClass("d-none");

                        schCus($("#txt-srch-cus").val());
                    }
                    
                    $("#btn-secus").prop("disabled", false);
                    $("#btn-secus").html("Simpan");
                },
                error : function(){
                    $("#btn-secus").prop("disabled", false);
                    $("#btn-secus").html("Simpan");
                    swal("Error (UCUS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delCus(x)
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
                    url : "./bin/php/dcus.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DCUS - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schCus($("#txt-srch-cus").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DCUS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delAtCusKrm(x)
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
            $("#row-tcus-krm-"+x).remove();
    })
}

//PO
function getNIDPO()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-po-1").hasClass("d-none"))
            $("#div-err-po-1").addClass("d-none");
            
        if(!$("#div-err-po-2").hasClass("d-none"))
            $("#div-err-po-2").addClass("d-none");

        if(!$("#div-scs-po-1").hasClass("d-none"))
            $("#div-scs-po-1").addClass("d-none");
            
        $("#mdl-npo").modal("show");

        swal.close();
    }, 200);
}

function schPO(x, y = 1, z = 1)
{
    var url = "./bin/php/spo.php", z = y;

    if($("#mdl-nkrm").length > 0 || $("#mdl-ekrm").length > 0){
        z = 1;
    }
    
    if(z === 2)
        url = "../bin/php/spo.php";

    Process("", z);
    setTimeout(function(){
        $.ajax({
            url : url,
            type : "post",
            data : {id : x, type : y},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-po").html(setToTblPO(json));
                else if(y === 2)
                    $("#lst-spo").html(setToTblPO2(json, z));
                else if(y === 3)
                    $("#lst-spo2").html(setToTblPO3(json));
                else if(y === 4)
                    $("#lst-spo3").html(setToTblPO4(json));
                else if(y === 5)
                    $("#lst-spo4").html(setToTblPO5(json));

                swal.close();
            },
            error : function(){
                swal("Error (SPO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblPO(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var stl = "text-danger";

            if(x.data[i][8] === "Sudah Kirim")
                stl = "text-success";

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][9])+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border "+stl+"\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][10]+"</td>"+
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"ePO('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delPO('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";

            //if(x.data[i][8] === "Sudah Kirim")
                //hsl += " <button class=\"btn btn-light border-primary mb-1 p-1\" onclick=\"unSendPO('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/unsend-icon.png\" alt=\"Batal Kirim\" width=\"18\"></button>";
            //else
            if(x.data[i][11] === "NS")
                hsl += " <button class=\"btn btn-light border-primary mb-1 p-1\" onclick=\"setSendPO('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/send-icon.png\" alt=\"Kirim\" width=\"18\"></button>";

            hsl +=      " <button class=\"btn btn-light border-secondary mb-1 p-1\" onclick=\"viewPO('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/list-icon.png\" alt=\"Lihat PO\" width=\"20\"></button></td></td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"8\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>";

    return hsl;
}

function setToTblPO2(x, y)
{
    var hsl = "", d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();
    
    var date = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day;

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            if(((x.data[i][6] === "" && x.data[i][7] < date) || x.data[i][6] === "N") && y === 1)
                continue;

            hsl += "<tr onclick=\"chgPO('"+UE64(x.data[i][0])+"', '"+y+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"8\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPO3(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\"><button class=\"btn btn-sm btn-light border-success\" onclick=\"addAtPO('"+UE64(x.data[i][0])+"', '"+UE64(x.data[i][2])+"', '"+UE64(x.data[i][9])+"', '"+UE64(x.data[i][1])+"', this)\"><img src=\"./bin/img/icon/plus.png\" width=\"18\"></button></td>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"7\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPO4(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgPO('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPO5(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgPORKrm('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function chgPO(x, y = 1)
{
    x = UD64(x);
    
    Process("", y);
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtpo.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-nma-po").val(json.data[1]);
                $("#txt-po").val(x);

                $("#edt-txt-nma-po").val(json.data[1]);
                $("#edt-txt-po").val(x);

                if($("#mdl-spo").length > 0)
                    $("#mdl-spo").modal("hide");
                
                if($("#mdl-spo3").length > 0)
                    $("#mdl-spo3").modal("hide");

                swal.close();
            },
            error : function(){
                Process2();
                setTimeout(function(){
                    $.ajax({
                        url : "../bin/php/gdtpo.php",
                        type : "post",
                        data : {id : x},
                        success : function(output){
                            var json = $.parseJSON(output);
            
                            $("#txt-nma-po").val(json.data[1]);
                            $("#txt-po").val(x);
            
                            $("#edt-txt-nma-po").val(json.data[1]);
                            $("#edt-txt-po").val(x);
            
                            $("#mdl-spo").modal("hide");
            
                            swal.close();
                        },
                        error : function(){
                            swal("Error (CHGPO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                        },
                    });
                }, 200);
            },
        });
    }, 200);
}

function chgPORKrm(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtpo.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if($("#mdl-nrkrm").hasClass("show")){
                    $("#txt-nma-po").val(json.data[1]);
                    $("#txt-po").val(x);

                    $("#lst-nrkrm").html(setToTblKrmPO(json));

                    $("#btn-snrkrm").attr("data-count", json.data2.length);
                }
                else if($("#mdl-erkrm").hasClass("show")){
                    $("#edt-txt-nma-po").val(json.data[1]);
                    $("#edt-txt-po").val(x);

                    $("#lst-erkrm").html(setToTblKrmPO(json));

                    $("#btn-serkrm").attr("data-count", json.data2.length);
                }

                $("#mdl-spo4").modal("hide");
                $($("#txt-srch-spo4").attr("data-value")).modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (CHGPO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setToTblKrmPO(x){
    var hsl = "";

    if($("#mdl-nrkrm").hasClass("show")){
        for(var i = 0; i < x.data2.length; i++){
            var nama = x.data2[i][1]+" / "+x.data2[i][2];

            if(x.data2[i][3] !== ""){
                nama += " / "+x.data2[i][3];
            }
            
            if(x.data2[i][4] !== ""){
                nama += " / "+x.data2[i][4];
            }

            hsl += "<tr id=\"row-nrkrm-pro-"+i+"\">"+
                        "<td class=\"border\">"+nama+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data2[i][8])+"</td>"+
                        "<td class=\"border\"><input type=\"number\" class=\"form-control text-right\" id=\"txt-weight-nrkrm-"+i+"\" data-value=\""+UE64(x.data2[i][0])+"\" value=\""+x.data2[i][8]+"\" data-mvalue=\""+x.data2[i][8]+"\"></td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1 btn-dpro-nrkrm\" data-value=\""+UE64(i)+"\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                    "</tr>";
        }
    }
    else if($("#mdl-erkrm").hasClass("show")){
        for(var i = 0; i < x.data2.length; i++){
            var nama = x.data2[i][1]+" / "+x.data2[i][2];

            if(x.data2[i][3] !== ""){
                nama += " / "+x.data2[i][3];
            }
            
            if(x.data2[i][4] !== ""){
                nama += " / "+x.data2[i][4];
            }

            hsl += "<tr id=\"row-erkrm-pro-"+i+"\">"+
                        "<td class=\"border\">"+nama+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data2[i][8])+"</td>"+
                        "<td class=\"border\"><input type=\"number\" class=\"form-control text-right\" id=\"edt-txt-weight-erkrm-"+i+"\" data-value=\""+UE64(x.data2[i][0])+"\" value=\""+x.data2[i][8]+"\" data-mvalue=\""+x.data2[i][8]+"\"></td>"+
                        "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-1 btn-dpro-erkrm\" data-value=\""+UE64(i)+"\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
                    "</tr>";
        }
    }
    
    return hsl;
}

function addAtPO(id, tgl, qty, cus, x)
{
    var count = $("#btn-sat-krm").attr("data-cpo"), err = 0;

    $(x).prop("disabled", true);
    $(x).html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");

    for(var i = 0; i < count; i++)
    {
        if($("#btn-dat-po-krm-"+i).attr("data-value") === id)
        {
            err = -1;
            break;
        }
    }

    if(err === -1)
        swal("Error !!!", "P/O sudah dipilih, harap memilih P/O lain", "error");
    else
    {
        $("#lst-tpo-krm").append(
            "<tr id=\"row-tpo-krm-"+count+"\">"+
                "<td class=\"border\">"+UD64(id)+"</td>"+
                "<td class=\"border\">"+UD64(tgl)+"</td>"+
                "<td class=\"border text-right\">"+NumberFormat2(UD64(qty))+"</td>"+
                "<td class=\"border\">"+UD64(cus)+"</td>"+
                "<td class=\"border\"><input type=\"date\" class=\"form-control\" id=\"dte-tpo-krm-"+i+"\"></td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-0\" onclick=\"delAtPOKrm('"+UE64(count)+"')\" data-value=\""+id+"\" id=\"btn-dat-po-krm-"+i+"\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>"
        );

        $("#btn-sat-krm").attr("data-cpo", parseInt(count)+1);
    }

    $(x).prop("disabled", false);
    $(x).html("<img src=\"./bin/img/icon/plus.png\" width=\"18\">");
}

function ePO(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-po-1").hasClass("d-none"))
            $("#div-edt-err-po-1").addClass("d-none");

        if(!$("#div-edt-err-po-2").hasClass("d-none"))
            $("#div-edt-err-po-2").addClass("d-none");
            
        if(!$("#div-edt-err-po-3").hasClass("d-none"))
            $("#div-edt-err-po-3").addClass("d-none");
            
        if(!$("#div-edt-scs-po-1").hasClass("d-none"))
            $("#div-edt-scs-po-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtpo.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma-cus").val(json.cus[1]);
                $("#edt-txt-cus").val(json.data[1]);
                $("#edt-dte-tgl").val(json.data[2]);
                $("#edt-txt-ket").val(json.data[3]);
                $("#edt-txt-ket2").val(json.data[4]);
                $("#edt-txt-ket3").val(json.data[5]);
                $("#edt-slct-tmpl").val(json.data[6]);
                $("#edt-dte-dtgl").val(json.data[7]);
                $("#edt-txt-qty").val(NumberFormat2(json.data[9]));

                $("#mdl-epo").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (EPO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setSendPO(x){
    $("#slct-gdg").attr("data-value", x);
    $("#mdl-sspo").modal("show");
}

function sendPO()
{
    var id = UD64($("#slct-gdg").attr("data-value")), gdg = $("#slct-gdg").val(), ntt = $("#txt-ttgdg").val();

    swal({
        title : "Perhatian !!!",
        text : "P/O yang dikirim akan mengurangi sisa stok pada Gudang yang dipilih dan tidak dapat diubah lagi, anda yakin kirim P/O ?",
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
                    url : "./bin/php/snpo.php",
                    type : "post",
                    data : {id : id, gdg : gdg, tt : ntt},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1){
                            var txt = "";
                            for(var i = 0; i < json.lpro.length; i++){
                                txt += "-"+json.lpro[i][0]+" \nKirim : "+NumberFormat2(json.lpro[i][1])+"\nSisa : "+NumberFormat2(json.lpro[i][2])+"\n";
                            }

                            swal("Error (SPO - 1) !!!", "Terdapat produk yang melebihi sisa stok, tidak dapat melakukan pengiriman !!!\n\n"+txt, "error");
                        }
                        else if(parseInt(json.err[0]) === -2){
                            swal("Error (SPO - 2) !!!", "Data tanda * wajib diisi !!!", "error");
                        }
                        else if(parseInt(json.err[0]) === -3){
                            swal("Error (SPO - 3) !!!", "Data gudang tidak dapat ditemukan !!!", "error");
                        }
                        else{
                            swal({
                                title : "Sukses !!!", 
                                text : "Status P/O berhasil diubah menjadi sudah kirim !!!", 
                                icon : "success",
                                closeOnEsc : false,
                                closeOnClickOutside : false,
                            })
                            .then(ok => {
                                if(ok)
                                    schPO($("#txt-srch-po").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (SPO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function unSendPO(x)
{
    x = UD64(x);

    swal({
        title : "Perhatian !!!",
        text : "Mengubah status P/O akan mempengaruhi sisa stok, anda yakin batal kirim P/O ?",
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
                    url : "./bin/php/usnpo.php",
                    type : "post",
                    data : {id : x},
                    success : function(){
                        swal({
                            title : "Sukses !!!", 
                            text : "Status P/O berhasil diubah menjadi belum kirim !!!", 
                            icon : "success",
                            closeOnEsc : false,
                            closeOnClickOutside : false,
                        })
                        .then(ok => {
                            if(ok)
                                schPO($("#txt-srch-po").val());
                        });
                    },
                    error : function(){
                        swal("Error (SPO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function newPO()
{
    var id = $("#txt-id-po").val(), tgl = $("#dte-tgl").val(), cus = $("#txt-cus").val(), ket = $("#txt-ket").val(), ket2 = $("#txt-ket2").val(), tmpl = $("#slct-tmpl").val(), dtmpl = $("#dte-dtgl").val(), qty = UnNumberFormat($("#txt-qty-po").val());

    if(!$("#div-err-po-1").hasClass("d-none"))
        $("#div-err-po-1").addClass("d-none");

    if(!$("#div-err-po-2").hasClass("d-none"))
        $("#div-err-po-2").addClass("d-none");

    if(!$("#div-err-po-3").hasClass("d-none"))
        $("#div-err-po-3").addClass("d-none");

    if(!$("#div-scs-po-1").hasClass("d-none"))
        $("#div-scs-po-1").addClass("d-none");

    if(id === "" || cus === "" || tgl === "")
        $("#div-err-po-1").removeClass("d-none");
    else
    {
        $("#btn-snpo").prop("disabled", true);
        $("#btn-snpo").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/npo.php",
                type : "post",
                data : {id : id, tgl : tgl, cus : cus, ket : ket, ket2 : ket2, tmpl : tmpl, dtmpl : dtmpl, qty : qty},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-po-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-po-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-po-2").removeClass("d-none");
                    else
                    {
                        $("#mdl-npo input").val("");
                        $("#dte-tgl").val(tgl);
                        $("#dte-dtgl").val(dtmpl);

                        $("#txt-id-po").focus().select();
                        $("#div-scs-po-1").removeClass("d-none");

                        schPO($("#txt-srch-po").val());
                    }
                    
                    $("#btn-snpo").prop("disabled", false);
                    $("#btn-snpo").html("Simpan");
                },
                error : function(){
                    $("#btn-snpo").prop("disabled", false);
                    $("#btn-snpo").html("Simpan");
                    swal("Error (NPO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updPO()
{
    var id = $("#edt-txt-id").val(), tgl = $("#edt-dte-tgl").val(), cus = $("#edt-txt-cus").val(), ket = $("#edt-txt-ket").val(), ket2 = $("#edt-txt-ket2").val(), tmpl = $("#edt-slct-tmpl").val(), dtmpl = $("#edt-dte-dtgl").val(), bid = $("#edt-txt-bid").val(), qty = UnNumberFormat($("#edt-txt-qty").val());

    if(!$("#div-edt-err-po-1").hasClass("d-none"))
        $("#div-edt-err-po-1").addClass("d-none");

    if(!$("#div-edt-err-po-2").hasClass("d-none"))
        $("#div-edt-err-po-2").addClass("d-none");

    if(!$("#div-edt-err-po-3").hasClass("d-none"))
        $("#div-edt-err-po-3").addClass("d-none");

    if(!$("#div-edt-err-po-4").hasClass("d-none"))
        $("#div-edt-err-po-4").addClass("d-none");

    if(!$("#div-edt-scs-po-1").hasClass("d-none"))
        $("#div-edt-scs-po-1").addClass("d-none");

    if(id === "" || cus === "" || tgl === "")
        $("#div-edt-err-po-1").removeClass("d-none");
    else
    {
        $("#btn-sepo").prop("disabled", true);
        $("#btn-sepo").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/upo.php",
                type : "post",
                data : {id : id, tgl : tgl, cus : cus, ket : ket, ket2 : ket2, tmpl : tmpl, dtmpl : dtmpl, bid : bid, qty : qty},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-po-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-po-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-po-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-po-4").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-po-1").removeClass("d-none");

                        schPO($("#txt-srch-po").val());
                    }
                    
                    $("#btn-sepo").prop("disabled", false);
                    $("#btn-sepo").html("Simpan");
                },
                error : function(){
                    $("#btn-sepo").prop("disabled", false);
                    $("#btn-sepo").html("Simpan");
                    swal("Error (UPO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delPO(x)
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
                    url : "./bin/php/dpo.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DPO - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schPO($("#txt-srch-po").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DPO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delAtPOKrm(x)
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
            $("#row-tpo-krm-"+x).remove();
    })
}

function viewPO(x){
    window.open("./lihat-po?id="+x, "popupWindow", "width="+$(window).width()+",height="+$(window).height()+",scrollbars=yes");
}

//GRADE
function getNIDGrade()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-grade-1").hasClass("d-none"))
            $("#div-err-grade-1").addClass("d-none");
            
        if(!$("#div-err-grade-2").hasClass("d-none"))
            $("#div-err-grade-2").addClass("d-none");

        if(!$("#div-scs-grade-1").hasClass("d-none"))
            $("#div-scs-grade-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidgrade.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-grade").val(json.nid[0]);
                $("#mdl-ngrade").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDGRD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function getGradePro()
{
    var id = $("#txt-opt-grade").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ggradepro.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro").html(setToTblGradePro(json));

                $("#mdl-lpro-grade").modal({backdrop : "static", keyboard : false});
                $("#mdl-lpro-grade").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GGRDPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function schGrade(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sgrade.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-grade").html(setToTblGrade(json));
                else if(y === 2)
                    $("#lst-ssgrade").html(setToTblGrade2(json));

                swal.close();
            },
            error : function(){
                swal("Error (SGRD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblGrade(x)
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
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eGrade('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delGrade('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-info mb-1 p-1\" onclick=\"mdlGrade('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/more-info.png\" alt=\"More\" width=\"20\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"4\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblGrade2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\"><button class=\"btn btn-sm btn-light border-success\" onclick=\"addDtGrade('"+UE64(x.data[i][0])+"', '"+UE64(x.data[i][1])+"')\"><img src=\"./bin/img/icon/plus.png\" width=\"18\"></button></td>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function schGradePro(x)
{
    var y = $("#txt-opt-grade").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sgradepro.php",
            type : "post",
            data : {id : x, id2 : y},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro").html(setToTblGradePro(json));

                swal.close();
            },
            error : function(){
                swal("Error (SGRDPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblGradePro(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function eGrade(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-grade-1").hasClass("d-none"))
            $("#div-edt-err-grade-1").addClass("d-none");

        if(!$("#div-edt-err-grade-2").hasClass("d-none"))
            $("#div-edt-err-grade-2").addClass("d-none");
            
        if(!$("#div-edt-err-grade-3").hasClass("d-none"))
            $("#div-edt-err-grade-3").addClass("d-none");
            
        if(!$("#div-edt-scs-grade-1").hasClass("d-none"))
            $("#div-edt-scs-grade-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtgrade.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);
                $("#edt-txt-ket").val(json.data[2]);

                $("#mdl-egrade").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (EGRD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlGrade(x)
{
    x = UD64(x);

    $("#txt-opt-grade").val(x);

    $("#mdl-opt-grade").modal("show");
}

function addDtGrade(id, nama){
    id = UD64(id);
    nama = UD64(nama);
    var count = $("#btn-snahsup").attr("data-cgrade"), cek = false, show = "d-none";

    if($("#slct-prb-ahsup").val() === "2"){
        show = "";
    }

    for(var i = 0; i < count; i++){
        if($("#btn-dgrade-"+i).length === 0)
            continue;

        var grade = UD64($("#btn-dgrade-"+i).attr("data-grade"));
        if(grade === id){
            cek = true;
            break;
        }
    }

    if(!cek){
        $("#lst-dgrade").append(
            "<div class=\"row my-1\" id=\"div-dgrade-"+i+"\">"+
                "<div class=\"col-6\">"+nama+"</div>"+
                "<div class=\"col-4\"><input class=\"form-control cformat txt-gjlh "+show+"\" type=\"text\" id=\"txt-gjlh-"+i+"\" autocomplete=\"Harga\"></div>"+
                "<div class=\"col-2\"><button class=\"btn btn-sm btn-light border-danger btn-dgrade\" id=\"btn-dgrade-"+count+"\" data-grade=\""+UE64(id)+"\" data-value=\""+count+"\"><img src=\"./bin/img/icon/delete-icon.png\" width=\"18\"></button></div>"
            +"</div>"
        )

        $("#btn-snahsup").attr("data-cgrade", parseInt(count)+1);
    }
    else{
        swal("Error (ADGRD) !!!", "Harap memilih grade lain karena grade sudah dipilih sebelumnya !!!", "error");
    }
}

function delDtGrade(x){
    swal({
        title : "Perhatian !!!",
        text : "Anda yakin hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) => {
        if(ok){
            $("#div-dgrade-"+x).remove();
        }
    })
}

function newGrade()
{
    var id = $("#txt-id-grade").val(), name = $("#txt-nma-grade").val(), ket = $("#txt-ket-grade").val();

    if(!$("#div-err-grade-1").hasClass("d-none"))
        $("#div-err-grade-1").addClass("d-none");

    if(!$("#div-err-grade-2").hasClass("d-none"))
        $("#div-err-grade-2").addClass("d-none");

    if(!$("#div-scs-grade-1").hasClass("d-none"))
        $("#div-scs-grade-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-err-grade-1").removeClass("d-none");
    else
    {
        $("#btn-sngrade").prop("disabled", true);
        $("#btn-sngrade").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ngrade.php",
                type : "post",
                data : {id : id, name : name, ket : ket},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-grade-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-grade-2").removeClass("d-none");
                    else
                    {
                        $("#mdl-ngrade input").val("");
                        $("#txt-id-grade").val(json.nid[0]);

                        $("#txt-id-grade").focus().select();
                        $("#div-scs-grade-1").removeClass("d-none");

                        schGrade($("#txt-srch-grade").val());
                    }
                    
                    $("#btn-sngrade").prop("disabled", false);
                    $("#btn-sngrade").html("Simpan");
                },
                error : function(){
                    $("#btn-sngrade").prop("disabled", false);
                    $("#btn-sngrade").html("Simpan");
                    swal("Error (NGRD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updGrade()
{
    var id = $("#edt-txt-id").val(), name = $("#edt-txt-nma").val(), ket = $("#edt-txt-ket").val(), bid = $("#edt-txt-bid").val();

    if(!$("#div-edt-err-grade-1").hasClass("d-none"))
        $("#div-edt-err-grade-1").addClass("d-none");

    if(!$("#div-edt-err-grade-2").hasClass("d-none"))
        $("#div-edt-err-grade-2").addClass("d-none");

    if(!$("#div-edt-err-grade-3").hasClass("d-none"))
        $("#div-edt-err-grade-3").addClass("d-none");

    if(!$("#div-edt-scs-grade-1").hasClass("d-none"))
        $("#div-edt-scs-grade-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-edt-err-grade-1").removeClass("d-none");
    else
    {
        $("#btn-segrade").prop("disabled", true);
        $("#btn-segrade").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ugrade.php",
                type : "post",
                data : {id : id, name : name, ket : ket, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-grade-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-grade-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-grade-3").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-grade-1").removeClass("d-none");

                        schGrade($("#txt-srch-grade").val());
                    }
                    
                    $("#btn-segrade").prop("disabled", false);
                    $("#btn-segrade").html("Simpan");
                },
                error : function(){
                    $("#btn-segrade").prop("disabled", false);
                    $("#btn-segrade").html("Simpan");
                    swal("Error (UGRD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delGrade(x)
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
                    url : "./bin/php/dgrade.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DGRD - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schGrade($("#txt-srch-grade").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DGRD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

//SATUAN
function getNIDSatuan()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-satuan-1").hasClass("d-none"))
            $("#div-err-satuan-1").addClass("d-none");
            
        if(!$("#div-err-satuan-2").hasClass("d-none"))
            $("#div-err-satuan-2").addClass("d-none");

        if(!$("#div-scs-satuan-1").hasClass("d-none"))
            $("#div-scs-satuan-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidsatuan.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-satuan").val(json.nid[0]);
                $("#mdl-nsatuan").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDSTN) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function schSatuan(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ssatuan.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-satuan").html(setToTblSatuan(json));
                else if(y === 2)
                    $("#lst-sssat").html(setToTblSatuan2(json));

                swal.close();
            },
            error : function(){
                swal("Error (SSTN) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblSatuan(x)
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
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eSatuan('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delSatuan('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"4\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblSatuan2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\"><button class=\"btn btn-sm btn-light border-success\" onclick=\"addDtSat('"+UE64(x.data[i][0])+"', '"+UE64(x.data[i][1])+"')\"><img src=\"./bin/img/icon/plus.png\" width=\"18\"></button></td>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function eSatuan(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-satuan-1").hasClass("d-none"))
            $("#div-edt-err-satuan-1").addClass("d-none");

        if(!$("#div-edt-err-satuan-2").hasClass("d-none"))
            $("#div-edt-err-satuan-2").addClass("d-none");
            
        if(!$("#div-edt-err-satuan-3").hasClass("d-none"))
            $("#div-edt-err-satuan-3").addClass("d-none");
            
        if(!$("#div-edt-scs-satuan-1").hasClass("d-none"))
            $("#div-edt-scs-satuan-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtsatuan.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);
                $("#edt-txt-ket").val(json.data[2]);

                $("#mdl-esatuan").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (ESTN) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function addDtSat(id, nama){
    id = UD64(id);
    nama = UD64(nama);
    var count = $("#btn-snahsup").attr("data-csat"), cek = false;

    for(var i = 0; i < count; i++){
        if($("#btn-dsat-"+i).length === 0)
            continue;

        var sat = UD64($("#btn-dsat-"+i).attr("data-sat"));
        if(sat === id){
            cek = true;
            break;
        }
    }

    if(!cek){
        $("#lst-dsat").append(
            "<div class=\"row my-1\" id=\"div-dsat-"+i+"\">"+
                "<div class=\"col-8\">"+nama+"</div>"+
                "<div class=\"col-4\"><button class=\"btn btn-sm btn-light border-danger btn-dsat\" id=\"btn-dsat-"+count+"\" data-sat=\""+UE64(id)+"\" data-value=\""+count+"\"><img src=\"./bin/img/icon/delete-icon.png\" width=\"18\"></button></div>"
            +"</div>"
        )

        $("#btn-snahsup").attr("data-csat", parseInt(count)+1);
    }
    else{
        swal("Error (ADSAT) !!!", "Harap memilih satuan lain karena satuan sudah dipilih sebelumnya !!!", "error");
    }
}

function delDtSat(x){
    swal({
        title : "Perhatian !!!",
        text : "Anda yakin hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) => {
        if(ok){
            $("#div-dsat-"+x).remove();
        }
    })
}

function newSatuan()
{
    var id = $("#txt-id-satuan").val(), name = $("#txt-nma-satuan").val(), ket = $("#txt-ket-satuan").val();

    if(!$("#div-err-satuan-1").hasClass("d-none"))
        $("#div-err-satuan-1").addClass("d-none");

    if(!$("#div-err-satuan-2").hasClass("d-none"))
        $("#div-err-satuan-2").addClass("d-none");

    if(!$("#div-scs-satuan-1").hasClass("d-none"))
        $("#div-scs-satuan-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-err-satuan-1").removeClass("d-none");
    else
    {
        $("#btn-snsatuan").prop("disabled", true);
        $("#btn-snsatuan").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nsatuan.php",
                type : "post",
                data : {id : id, name : name, ket : ket},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-satuan-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-satuan-2").removeClass("d-none");
                    else
                    {
                        $("#mdl-nsatuan input").val("");
                        $("#txt-id-satuan").val(json.nid[0]);

                        $("#txt-id-satuan").focus().select();
                        $("#div-scs-satuan-1").removeClass("d-none");

                        schSatuan($("#txt-srch-satuan").val());
                    }
                    
                    $("#btn-snsatuan").prop("disabled", false);
                    $("#btn-snsatuan").html("Simpan");
                },
                error : function(){
                    $("#btn-snsatuan").prop("disabled", false);
                    $("#btn-snsatuan").html("Simpan");
                    swal("Error (NSTN) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updSatuan()
{
    var id = $("#edt-txt-id").val(), name = $("#edt-txt-nma").val(), ket = $("#edt-txt-ket").val(), bid = $("#edt-txt-bid").val();

    if(!$("#div-edt-err-satuan-1").hasClass("d-none"))
        $("#div-edt-err-satuan-1").addClass("d-none");

    if(!$("#div-edt-err-satuan-2").hasClass("d-none"))
        $("#div-edt-err-satuan-2").addClass("d-none");

    if(!$("#div-edt-err-satuan-3").hasClass("d-none"))
        $("#div-edt-err-satuan-3").addClass("d-none");

    if(!$("#div-edt-scs-satuan-1").hasClass("d-none"))
        $("#div-edt-scs-satuan-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-edt-err-satuan-1").removeClass("d-none");
    else
    {
        $("#btn-sesatuan").prop("disabled", true);
        $("#btn-sesatuan").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/usatuan.php",
                type : "post",
                data : {id : id, name : name, ket : ket, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-satuan-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-satuan-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-satuan-3").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-satuan-1").removeClass("d-none");

                        schSatuan($("#txt-srch-satuan").val());
                    }
                    
                    $("#btn-sesatuan").prop("disabled", false);
                    $("#btn-sesatuan").html("Simpan");
                },
                error : function(){
                    $("#btn-sesatuan").prop("disabled", false);
                    $("#btn-sesatuan").html("Simpan");
                    swal("Error (USTN) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delSatuan(x)
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
                    url : "./bin/php/dsatuan.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DSTN - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schSatuan($("#txt-srch-satuan").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DSTN) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

//KATEGORI
function getNIDKate()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-kate-1").hasClass("d-none"))
            $("#div-err-kate-1").addClass("d-none");
            
        if(!$("#div-err-kate-2").hasClass("d-none"))
            $("#div-err-kate-2").addClass("d-none");

        if(!$("#div-scs-kate-1").hasClass("d-none"))
            $("#div-scs-kate-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidkate.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-kate").val(json.nid[0]);
                $("#mdl-nkate").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function getKatePro()
{
    var id = $("#txt-opt-kate").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gkatepro.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro").html(setToTblKatePro(json));

                $("#mdl-lpro-kate").modal({backdrop : "static", keyboard : false});
                $("#mdl-lpro-kate").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GKATEPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function getKateSKate()
{
    var id = $("#txt-opt-kate").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gkateskate.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-skate").html(setToTblKateSKate(json));

                $("#mdl-lskate-kate").modal({backdrop : "static", keyboard : false});
                $("#mdl-lskate-kate").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GKATESKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function schKate(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/skate.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-kate").html(setToTblKate(json));
                else if(y === 2)
                    $("#lst-sskate").html(setToTblKate2(json));

                swal.close();
            },
            error : function(){
                swal("Error (SKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblKate(x)
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
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eKate('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delKate('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-info mb-1 p-1\" onclick=\"mdlKate('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/more-info.png\" alt=\"More\" width=\"20\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"4\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblKate2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgKate('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"3\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function chgKate(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtkate.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-nma-kate").val(json.data[1]);
                $("#txt-kate").val(x);

                $("#edt-txt-nma-kate").val(json.data[1]);
                $("#edt-txt-kate").val(x);
                
                $("#mdl-skate").modal("hide");

                swal.close();

                //updChgKateSKate(x);
            },
            error : function(){
                swal("Error (CHGKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function updChgKateSKate(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gkateskate.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#slct-skate").html(setToSlctSKate(json));
                $("#edt-slct-skate").html(setToSlctSKate(json));

                swal.close();
            },
            error : function(){
                swal("Error (UCHGKATESKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function schKatePro(x)
{
    var y = $("#txt-opt-kate").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/skatepro.php",
            type : "post",
            data : {id : x, id2 : y},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro").html(setToTblKatePro(json));

                swal.close();
            },
            error : function(){
                swal("Error (SKATEPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblKatePro(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function schKateSKate(x)
{
    var y = $("#txt-opt-kate").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/skateskate.php",
            type : "post",
            data : {id : x, id2 : y},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-skate").html(setToTblKateSKate(json));

                swal.close();
            },
            error : function(){
                swal("Error (SKATESKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblKateSKate(x)
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
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"3\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function eKate(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-kate-1").hasClass("d-none"))
            $("#div-edt-err-kate-1").addClass("d-none");

        if(!$("#div-edt-err-kate-2").hasClass("d-none"))
            $("#div-edt-err-kate-2").addClass("d-none");
            
        if(!$("#div-edt-err-kate-3").hasClass("d-none"))
            $("#div-edt-err-kate-3").addClass("d-none");
            
        if(!$("#div-edt-scs-kate-1").hasClass("d-none"))
            $("#div-edt-scs-kate-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtkate.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);
                $("#edt-txt-ket").val(json.data[2]);

                $("#mdl-ekate").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (EKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlKate(x)
{
    x = UD64(x);

    $("#txt-opt-kate").val(x);

    $("#mdl-opt-kate").modal("show");
}

function newKate()
{
    var id = $("#txt-id-kate").val(), name = $("#txt-nma-kate").val(), ket = $("#txt-ket-kate").val();

    if(!$("#div-err-kate-1").hasClass("d-none"))
        $("#div-err-kate-1").addClass("d-none");

    if(!$("#div-err-kate-2").hasClass("d-none"))
        $("#div-err-kate-2").addClass("d-none");

    if(!$("#div-scs-kate-1").hasClass("d-none"))
        $("#div-scs-kate-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-err-kate-1").removeClass("d-none");
    else
    {
        $("#btn-snkate").prop("disabled", true);
        $("#btn-snkate").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nkate.php",
                type : "post",
                data : {id : id, name : name, ket : ket},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-kate-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-kate-2").removeClass("d-none");
                    else
                    {
                        $("#mdl-nkate input").val("");
                        $("#txt-id-kate").val(json.nid[0]);

                        $("#txt-id-kate").focus().select();
                        $("#div-scs-kate-1").removeClass("d-none");

                        schKate($("#txt-srch-kate").val());
                    }
                    
                    $("#btn-snkate").prop("disabled", false);
                    $("#btn-snkate").html("Simpan");
                },
                error : function(){
                    $("#btn-snkate").prop("disabled", false);
                    $("#btn-snkate").html("Simpan");
                    swal("Error (NKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updKate()
{
    var id = $("#edt-txt-id").val(), bid = $("#edt-txt-bid").val(), name = $("#edt-txt-nma").val(), ket = $("#edt-txt-ket").val();

    if(!$("#div-edt-err-kate-1").hasClass("d-none"))
        $("#div-edt-err-kate-1").addClass("d-none");

    if(!$("#div-edt-err-kate-2").hasClass("d-none"))
        $("#div-edt-err-kate-2").addClass("d-none");

    if(!$("#div-edt-err-kate-3").hasClass("d-none"))
        $("#div-edt-err-kate-3").addClass("d-none");

    if(!$("#div-edt-scs-kate-1").hasClass("d-none"))
        $("#div-edt-scs-kate-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-edt-err-kate-1").removeClass("d-none");
    else
    {
        $("#btn-sekate").prop("disabled", true);
        $("#btn-sekate").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ukate.php",
                type : "post",
                data : {id : id, name : name, ket : ket, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-kate-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-kate-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-kate-3").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-kate-1").removeClass("d-none");

                        schKate($("#txt-srch-kate").val());
                    }
                    
                    $("#btn-sekate").prop("disabled", false);
                    $("#btn-sekate").html("Simpan");
                },
                error : function(){
                    $("#btn-sekate").prop("disabled", false);
                    $("#btn-sekate").html("Simpan");
                    swal("Error (UKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delKate(x)
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
                    url : "./bin/php/dkate.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DKATE - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schKate($("#txt-srch-kate").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

//SUB SKATEGORI
function getNIDSKate()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-skate-1").hasClass("d-none"))
            $("#div-err-skate-1").addClass("d-none");
            
        if(!$("#div-err-skate-2").hasClass("d-none"))
            $("#div-err-skate-2").addClass("d-none");
            
        if(!$("#div-err-skate-3").hasClass("d-none"))
            $("#div-err-skate-3").addClass("d-none");

        if(!$("#div-scs-skate-1").hasClass("d-none"))
            $("#div-scs-skate-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidskate.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-skate").val(json.nid[0]);
                $("#mdl-nskate").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDSKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function getSKatePro()
{
    var id = $("#txt-opt-skate").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gskatepro.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro").html(setToTblSKatePro(json));

                $("#mdl-lpro-skate").modal({backdrop : "static", keyboard : false});
                $("#mdl-lpro-skate").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GSKATEPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function schSKate(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sskate.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-skate").html(setToTblSKate(json));
                else if(y === 2)
                    $("#lst-ssskate").html(setToTblSKate2(json));

                swal.close();
            },
            error : function(){
                swal("Error (SSKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblSKate(x)
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
                        "<td class=\"border d-none\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eSKate('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delSKate('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-info mb-1 p-1\" onclick=\"mdlSKate('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/more-info.png\" alt=\"More\" width=\"20\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblSKate2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgSKate('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function chgSKate(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtskate.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-nma-skate").val(json.data[1]);
                $("#txt-skate").val(x);

                $("#edt-txt-nma-skate").val(json.data[1]);
                $("#edt-txt-skate").val(x);
                
                $("#mdl-sskate").modal("hide");

                swal.close();
            },
            error : function(){
                swal("Error (CHGKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function setToSlctSKate(x)
{
    var hsl = "<option value=\"\">Pilih Sub Kategori</option>";

    for(var i = 0; i < x.count[0]; i++)
        hsl += "<option value=\""+x.data[i][0]+"\">"+x.data[i][1]+"</option>"

    return hsl;
}

function schSKatePro(x)
{
    var y = $("#txt-opt-skate").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sskatepro.php",
            type : "post",
            data : {id : x, id2 : y},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro").html(setToTblSKatePro(json));

                swal.close();
            },
            error : function(){
                swal("Error (SSKATEPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblSKatePro(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function eSKate(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-skate-1").hasClass("d-none"))
            $("#div-edt-err-skate-1").addClass("d-none");

        if(!$("#div-edt-err-skate-2").hasClass("d-none"))
            $("#div-edt-err-skate-2").addClass("d-none");
            
        if(!$("#div-edt-err-skate-3").hasClass("d-none"))
            $("#div-edt-err-skate-3").addClass("d-none");
            
        if(!$("#div-edt-err-skate-4").hasClass("d-none"))
            $("#div-edt-err-skate-4").addClass("d-none");
            
        if(!$("#div-edt-scs-skate-1").hasClass("d-none"))
            $("#div-edt-scs-skate-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtskate.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);
                $("#edt-txt-ket").val(json.data[2]);
                //$("#edt-txt-kate").val(json.data[3]);
                //$("#edt-txt-nma-kate").val(json.kate[1]);

                $("#mdl-eskate").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (ESKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlSKate(x)
{
    x = UD64(x);

    $("#txt-opt-skate").val(x);

    $("#mdl-opt-skate").modal("show");
}

function newSKate()
{
    var id = $("#txt-id-skate").val(), name = $("#txt-nma-skate").val(), ket = $("#txt-ket-skate").val(), kate = $("#txt-kate").val();

    if(!$("#div-err-skate-1").hasClass("d-none"))
        $("#div-err-skate-1").addClass("d-none");

    if(!$("#div-err-skate-2").hasClass("d-none"))
        $("#div-err-skate-2").addClass("d-none");

    if(!$("#div-err-skate-3").hasClass("d-none"))
        $("#div-err-skate-3").addClass("d-none");

    if(!$("#div-scs-skate-1").hasClass("d-none"))
        $("#div-scs-skate-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-err-skate-1").removeClass("d-none");
    else
    {
        $("#btn-snskate").prop("disabled", true);
        $("#btn-snskate").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nskate.php",
                type : "post",
                data : {id : id, name : name, ket : ket, kate : kate},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-skate-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-skate-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-skate-2").removeClass("d-none");
                    else
                    {
                        $("#mdl-nskate input").val("");
                        $("#txt-id-skate").val(json.nid[0]);

                        $("#txt-id-skate").focus().select();
                        $("#div-scs-skate-1").removeClass("d-none");

                        schSKate($("#txt-srch-skate").val());
                    }
                    
                    $("#btn-snskate").prop("disabled", false);
                    $("#btn-snskate").html("Simpan");
                },
                error : function(){
                    $("#btn-snskate").prop("disabled", false);
                    $("#btn-snskate").html("Simpan");
                    swal("Error (NSKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updSKate()
{
    var id = $("#edt-txt-id").val(), bid = $("#edt-txt-bid").val(), name = $("#edt-txt-nma").val(), ket = $("#edt-txt-ket").val(), kate = $("#edt-txt-kate").val();

    if(!$("#div-edt-err-skate-1").hasClass("d-none"))
        $("#div-edt-err-skate-1").addClass("d-none");

    if(!$("#div-edt-err-skate-2").hasClass("d-none"))
        $("#div-edt-err-skate-2").addClass("d-none");

    if(!$("#div-edt-err-skate-3").hasClass("d-none"))
        $("#div-edt-err-skate-3").addClass("d-none");

    if(!$("#div-edt-err-skate-4").hasClass("d-none"))
        $("#div-edt-err-skate-4").addClass("d-none");

    if(!$("#div-edt-scs-skate-1").hasClass("d-none"))
        $("#div-edt-scs-skate-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-edt-err-skate-1").removeClass("d-none");
    else
    {
        $("#btn-seskate").prop("disabled", true);
        $("#btn-seskate").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/uskate.php",
                type : "post",
                data : {id : id, name : name, ket : ket, kate : kate, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-skate-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-skate-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-skate-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-skate-4").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-skate-1").removeClass("d-none");

                        schSKate($("#txt-srch-skate").val());
                    }
                    
                    $("#btn-seskate").prop("disabled", false);
                    $("#btn-seskate").html("Simpan");
                },
                error : function(){
                    $("#btn-seskate").prop("disabled", false);
                    $("#btn-seskate").html("Simpan");
                    swal("Error (USKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delSKate(x)
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
                    url : "./bin/php/dskate.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DSKATE - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schSKate($("#txt-srch-skate").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DSKATE) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

//PRODUK
function getNIDPro()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-pro-1").hasClass("d-none"))
            $("#div-err-pro-1").addClass("d-none");
            
        if(!$("#div-err-pro-2").hasClass("d-none"))
            $("#div-err-pro-2").addClass("d-none");
            
        if(!$("#div-err-pro-3").hasClass("d-none"))
            $("#div-err-pro-3").addClass("d-none");
            
        if(!$("#div-err-pro-4").hasClass("d-none"))
            $("#div-err-pro-4").addClass("d-none");
            
        if(!$("#div-err-pro-5").hasClass("d-none"))
            $("#div-err-pro-5").addClass("d-none");

        if(!$("#div-scs-pro-1").hasClass("d-none"))
            $("#div-scs-pro-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidpro.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-pro").val(json.nid[0]);
                $("#mdl-npro").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function schPro(x, y = 1)
{
    var type = "";

    if($("#mdl-ntrm").length > 0)
        type = "TRM";
    else if($("#mdl-ncut").length > 0)
        type = "CUT";
    else if($("#mdl-nvac").length > 0)
        type = "VAC";
    else if($("#mdl-nsaw").length > 0)
        type = "SAW";
    else if($("#mdl-nkrm").length > 0)
        type = "KRM";
    else if($("#mdl-nmp").length > 0)
        type = "MP";
    else if($("#mdl-nfrz").length > 0)
        type = "FRZ";
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/spro.php",
            type : "post",
            data : {id : x, type : type},
            success : function(output){
                var json = $.parseJSON(output);
                
                if(y === 1)
                    $("#lst-pro").html(setToTblPro(json));
                else if(y === 2)
                    $("#lst-sspro").html(setToTblPro2(json));
                else if(y === 3)
                    $("#lst-sspro").html(setToTblPro3(json));
                else if(y === 4)
                    $("#lst-sspro2").html(setToTblPro4(json));
                else if(y === 5)
                    $("#lst-sspro3").html(setToTblPro5(json));
                else if(y === 6)
                    $("#lst-sspro4").html(setToTblPro6(json));
                else if(y === 7)
                    $("#lst-sspro6").html(setToTblPro7(json));
                else if(y === 8)
                    $("#lst-sspro7").html(setToTblPro8(json));
                else if(y === 9)
                    $("#lst-sspro8").html(setToTblPro9(json));

                swal.close();
            },
            error : function(){
                swal("Error (SPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblPro(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][14]+"</td>"+
                        "<td class=\"border\">"+x.data[i][15]+"</td>"+
                        "<td class=\"border\">"+x.data[i][16]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][5])+"</td>";

            if(viewHarga())
                hsl +=  "<td class=\"border text-right\">"+NumberFormat2(x.data[i][13])+"</td>";

            hsl +=      "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\">"+x.data[i][10]+"</td>"+
                        "<td class=\"border\">"+x.data[i][11]+"</td>"+
                        "<td class=\"border\">"+x.data[i][12]+"</td>"+
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"ePro('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delPro('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-info mb-1 p-1\" onclick=\"mdlPro('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/more-info.png\" alt=\"More\" width=\"20\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"17\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPro2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgPro('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][5])+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPro3(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgPro('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPro4(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgPro2('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPro5(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\"><button class=\"btn btn-sm btn-light border-success\" onclick=\"addAtPro('"+UE64(x.data[i][0])+"', '"+UE64(x.data[i][1])+"', '"+UE64(x.data[i][4])+"', '"+UE64(x.data[i][2])+"', '"+UE64(x.data[i][3])+"', this, '"+x.data[i][5]+"')\"><img src=\"./bin/img/icon/plus.png\" width=\"18\"></button></td>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPro6(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgPro3('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][5])+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPro7(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgPro4('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPro8(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgPro5('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][5])+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function setToTblPro9(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var nma = x.data[i][1]+" / "+x.data[i][4];

            if(x.data[i][2] !== "" && x.data[i][2] !== null){
                nma += " / "+x.data[i][2];
            }

            if(x.data[i][3] !== "" && x.data[i][3] !== null){
                nma += " / "+x.data[i][3];
            }

            hsl += "<tr>"+
                        "<td class=\"border\"><button class=\"btn btn-sm btn-light border-success\" onclick=\"addSetPro('"+UE64(x.data[i][0])+"', '"+UE64(nma)+"')\"><img src=\"./bin/img/icon/plus.png\" width=\"18\"></button></td>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+nma+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"3\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function chgPro(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtpro.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output), nma = json.data[1];

                if(json.grade[0] !== "")
                    nma += " / "+json.grade[1];

                if(json.kate[0] !== "")
                    nma += " / "+json.kate[1];

                if(json.skate[0] !== "")
                    nma += " / "+json.skate[1];

                if($("#txt-srch-spro").attr("data-value") !== "" && $("#txt-srch-spro").attr("data-value") !== null && $("#txt-srch-spro").attr("data-value") !== undefined)
                {
                    $($("#txt-srch-spro").attr("data-value")).val(x);
                    $($("#txt-srch-spro").attr("data-value2")).val(json.data[1]);
                }
                else
                {
                    $("#txt-nma-pro").val(json.data[1]);
                    $("#txt-pro").val(x);
                    $("#txt-grade").val(json.grade[0]);
                    $("#txt-nma-grade").val(json.grade[1]);
                    $("#txt-nma-kate").val(json.kate[1]);
                    $("#txt-nma-skate").val(json.skate[1]);
                    
                    $("#edt-txt-nma-pro").val(json.data[1]);
                    $("#edt-txt-pro").val(x);
                    $("#edt-txt-grade").val(json.grade[0]);
                    $("#edt-txt-nma-grade").val(json.grade[1]);
                    $("#edt-txt-nma-kate").val(json.kate[1]);
                    $("#edt-txt-nma-skate").val(json.skate[1]);

                    if($(".txt-pro-lap").length > 0){
                        $("#txt-nma-pro").val(nma);
                    }

                    $("#mdl-spro").modal("hide");

                    if($("#slct-weight").length > 0)
                        getTrmCut();
                }

                $("#mdl-spro").modal("hide");

                swal.close();
            },
            error : function(){
                swal("Error (CHGPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function chgPro2(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtpro.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-nma-pro2").val(json.data[1]);
                $("#txt-pro2").val(x);
                $("#txt-nma-grade2").val(json.grade[1]);
                $("#txt-nma-kate2").val(json.kate[1]);
                $("#txt-nma-skate2").val(json.skate[1]);

                $("#edt-txt-nma-pro2").val(json.data[1]);
                $("#edt-txt-pro2").val(x);
                $("#edt-txt-nma-grade2").val(json.grade[1]);
                $("#edt-txt-nma-kate2").val(json.kate[1]);
                $("#edt-txt-nma-skate2").val(json.skate[1]);

                getWeightVacPro();
                getWeightSawPro();

                $("#mdl-spro3").modal("hide");

                swal.close();
            },
            error : function(){
                swal("Error (CHGPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function chgPro3(x)
{
    x = UD64(x);

    var i = "";

    if($("#txt-srch-spro5").attr("data-value") !== "" && $("#txt-srch-spro5").attr("data-value") !== undefined)
        i = $("#txt-srch-spro5").attr("data-value");
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtpro.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output), nma = json.data[1];

                if(json.grade[0] !== "")
                    nma += " / "+json.grade[1];

                if(json.kate[0] !== "")
                    nma += " / "+json.kate[1];

                if(json.skate[0] !== "")
                    nma += " / "+json.skate[1];
                    
                if(i === "")
                {
                    $("#txt-nma-pro3").val(nma);
                    $("#txt-pro3").val(x);
                }
                else
                {
                    if($("#mdl-emv").hasClass("show") || $("#mdl-erpkg").hasClass("show")){
                        $("#edt-txt-nma-pro3-"+i).val(nma);
                        $("#edt-txt-pro3-"+i).val(x);
                    }
                    else{
                        $("#txt-nma-pro3-"+i).val(nma);
                        $("#txt-pro3-"+i).val(x);
                    }
                }

                $("#mdl-spro5").modal("hide");

                swal.close();
            },
            error : function(){
                swal("Error (CHGPRO3) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function chgPro4(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtpro.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-nma-pro3").val(json.data[1]);
                $("#txt-pro3").val(x);
                $("#txt-nma-grade3").val(json.grade[1]);
                $("#txt-nma-kate3").val(json.kate[1]);
                $("#txt-nma-skate3").val(json.skate[1]);

                $("#edt-txt-nma-pro3").val(json.data[1]);
                $("#edt-txt-pro3").val(x);
                $("#edt-txt-nma-grade3").val(json.grade[1]);
                $("#edt-txt-nma-kate3").val(json.kate[1]);
                $("#edt-txt-nma-skate3").val(json.skate[1]);

                $("#mdl-spro6").modal("hide");

                swal.close();
            },
            error : function(){
                swal("Error (CHGPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function chgPro5(x)
{
    x = UD64(x);

    var i = "";

    if($("#txt-srch-spro7").attr("data-value") !== "" && $("#txt-srch-spro7").attr("data-value") !== undefined)
        i = $("#txt-srch-spro7").attr("data-value");
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtpro.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output), nma = json.data[1];

                if(json.grade[0] !== "")
                    nma += " / "+json.grade[1];

                if(json.kate[0] !== "")
                    nma += " / "+json.kate[1];

                if(json.skate[0] !== "")
                    nma += " / "+json.skate[1];
                
                if(i === "")
                {
                    $("#txt-nma-pro7").val(nma);
                    $("#txt-pro7").val(x);
                }
                else
                {
                    $(i+"-nma").val(nma);
                    $(i).val(x);
                }

                $("#mdl-spro7").modal("hide");

                swal.close();
            },
            error : function(){
                swal("Error (CHGPRO3) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function addAtPro(id, nama, grade, kate, skate, x, stok = 0)
{
    var list = $("#txt-srch-spro4").attr("data-value");
    $(x).prop("disabled", true);
    $(x).html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>");

    if(list === "lst-tpro-trm")
        addAtProTrm(id, nama, grade, kate, skate);
    else if(list === "lst-tpro-cut")
        addAtProCut(id, nama, grade, kate, skate);
    else if(list === "lst-tpro-krm")
        addAtProKrm(id, nama, grade, kate, skate, stok);

    $(x).prop("disabled", false);
    $(x).html("<img src=\"./bin/img/icon/plus.png\" width=\"18\">");
}

function addSetPro(id, nama){
    id = UD64(id);
    nama = UD64(nama);
    var vlst = $("#txt-srch-spro8").attr("data-value"), cek = false;

    if(vlst === "#lst-chpro"){
        var count = $("#btn-achpro").attr("data-count");
        for(var i = 0; i < count; i++){
            if($("#btn-dachpro-"+i).length > 0){
                if(UD64($("#btn-dachpro-"+i).attr("data-value")) === id){
                    cek = true;
                    break;
                }
            }
        }

        if(cek){
            swal("Error - 1 !!!", "Produk sudah dipilih sebelumnya...", "error");
        }
        else{
            Process();
            setTimeout(function(){
                $.ajax({
                    url : './bin/php/nsachpro.php',
                    type : "post",
                    data : {id : id},
                    success : function(output){
                        var json = $.parseJSON(output);

                        $("#lst-chpro").append("<li id=\"ls-achpro-"+count+"\">"+nama+" <button class=\"btn btn-sm btn-light btn-dachpro\" data-value=\""+UE64(id)+"\" data-id=\""+UE64(json.data[0])+"\" id=\"btn-dachpro-"+count+"\" data-value=\""+UE64(count)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></li>");

                        $("#btn-achpro").attr("data-count", parseInt(count) + 1);

                        swal.close();
                    },
                    error : function(){
                        swal("Error (ASPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    }
                })
            }, 200);
        }
    }
    else if(vlst === "#lst-chnpro"){
        var count = $("#btn-achnpro").attr("data-count");
        for(var i = 0; i < count; i++){
            if($("#btn-dachnpro-"+i).length > 0){
                if(UD64($("#btn-dachnpro-"+i).attr("data-value")) === id){
                    cek = true;
                    break;
                }
            }
        }

        if(cek){
            swal("Error - 2 !!!", "Produk sudah dipilih sebelumnya...", "error");
        }
        else{
            Process();
            setTimeout(function(){
                $.ajax({
                    url : './bin/php/nsachnpro.php',
                    type : "post",
                    data : {id : id},
                    success : function(output){
                        var json = $.parseJSON(output);

                        $("#lst-chnpro").append("<li id=\"ls-achnpro-"+count+"\">"+nama+" <button class=\"btn btn-sm btn-light btn-dachnpro\" data-value=\""+UE64(id)+"\" data-id=\""+UE64(json.data[0])+"\" id=\"btn-dachnpro-"+count+"\" data-count=\""+UE64(count)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></li>");

                        $("#btn-achnpro").attr("data-count", parseInt(count) + 1);

                        swal.close();
                    },
                    error : function(){
                        swal("Error (ASNPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    }
                })
            }, 200);
        }
    }
}

function addAtProTrm(id, nama, grade, kate, skate)
{
    var count = $("#btn-sat-trm").attr("data-cpro"), err = 0;

    for(var i = 0; i < count; i++)
    {
        if($("#btn-dat-pro-trm-"+i).attr("data-value") === id)
        {
            err = -1;
            break;
        }
    }

    if(err === -1)
        swal("Error !!!", "Produk sudah dipilih, harap memilih produk lain", "error");
    else
    {
        $("#lst-tpro-trm").append(
            "<tr id=\"row-tpro-trm-"+count+"\">"+
                "<td class=\"border\">"+UD64(id)+"</td>"+
                "<td class=\"border\">"+UD64(nama)+"</td>"+
                "<td class=\"border\">"+UD64(grade)+"</td>"+
                "<td class=\"border\">"+UD64(kate)+"</td>"+
                "<td class=\"border\">"+UD64(skate)+"</td>"+
                "<td class=\"border\"><input class=\"form-control h-auto py-0 text-right catpro inp-tbl\" type=\"number\" min=\"0\" max=\"100\" id=\"nmbr-tpro-"+count+"\" data-value=\""+count+"\"></td>"+
                "<td class=\"border\"><input class=\"form-control h-auto py-0 cformat text-right\" type=\"text\" id=\"txt-tpro-jlh-"+count+"\" readonly></td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-0\" onclick=\"delAtProTrm('"+UE64(count)+"')\" data-value=\""+id+"\" id=\"btn-dat-pro-trm-"+i+"\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>"
        )

        $("#btn-sat-trm").attr("data-cpro", parseInt(count)+1);
    }
}

function addAtProCut(id, nama, grade, kate, skate)
{
    var count = $("#btn-sat-trm").attr("data-cpro2"), err = 0;

    for(var i = 0; i < count; i++)
    {
        if($("#btn-dat-pro-cut-"+i).attr("data-value") === id)
        {
            err = -1;
            break;
        }
    }

    if(err === -1)
        swal("Error !!!", "Produk sudah dipilih, harap memilih produk lain", "error");
    else
    {
        $("#lst-tpro-cut").append(
            "<tr id=\"row-tpro-cut-"+count+"\">"+
                "<td class=\"border\">"+UD64(id)+"</td>"+
                "<td class=\"border\">"+UD64(nama)+"</td>"+
                "<td class=\"border\">"+UD64(grade)+"</td>"+
                "<td class=\"border\">"+UD64(kate)+"</td>"+
                "<td class=\"border\">"+UD64(skate)+"</td>"+
                "<td class=\"border\"><input class=\"form-control h-auto py-0 text-right inp-ctbl\" type=\"number\" min=\"0\" max=\"100\" id=\"nmbr-ctpro-"+count+"\" data-value=\""+count+"\"></td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-0\" onclick=\"delAtProCut('"+UE64(count)+"')\" data-value=\""+id+"\" id=\"btn-dat-pro-cut-"+i+"\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>"
        )

        $("#btn-sat-trm").attr("data-cpro2", parseInt(count)+1);
    }
}

function addAtProKrm(id, nama, grade, kate, skate, stok)
{
    var count = $("#btn-sat-krm").attr("data-cpro"), err = 0;

    for(var i = 0; i < count; i++)
    {
        if($("#btn-dat-pro-krm-"+i).attr("data-value") === id)
        {
            err = -1;
            break;
        }
    }

    if(err === -1)
        swal("Error !!!", "Produk sudah dipilih, harap memilih produk lain", "error");
    else
    {
        $("#lst-tpro-krm").append(
            "<tr id=\"row-tpro-krm-"+count+"\">"+
                "<td class=\"border\">"+UD64(id)+"</td>"+
                "<td class=\"border\">"+UD64(nama)+"</td>"+
                "<td class=\"border\">"+UD64(grade)+"</td>"+
                "<td class=\"border\">"+UD64(kate)+"</td>"+
                "<td class=\"border\">"+UD64(skate)+"</td>"+
                "<td class=\"border text-right\">"+NumberFormat2(stok)+"</td>"+
                "<td class=\"border\"><input class=\"form-control h-auto py-0 text-right catprok inp-ktbl\" type=\"number\" min=\"0\" max=\"100\" id=\"nmbr-tpro-krm-"+count+"\" data-value=\""+count+"\"></td>"+
                "<td class=\"border d-none\"><input class=\"form-control h-auto py-0 cformat text-right\" type=\"text\" id=\"txt-tpro-krm-jlh-"+count+"\" readonly></td>"+
                "<td class=\"border\"><button class=\"btn btn-light border-danger mb-1 p-0\" onclick=\"delAtProKrm('"+UE64(count)+"')\" data-value=\""+id+"\" id=\"btn-dat-pro-krm-"+i+"\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button></td>"+
            "</tr>"
        )

        $("#btn-sat-krm").attr("data-cpro", parseInt(count)+1);
    }
}

function schHTrmPro()
{
    var frm = $("#dte-frm-prtt").val(), to = $("#dte-to-prtt").val(), pro = $("#txt-opt-pro").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shtrmpro.php",
            type : "post",
            data : {frm : frm, to : to, pro : pro},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro-prtt").html(setToTblHTrmPro(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHTRMPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHTrmPro(x)
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
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][5])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][6])+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                        "<td class=\"border\">"+x.data[i][8]+"</td>"+
                        "<td class=\"border\">"+x.data[i][9]+"</td>"+
                        "<td class=\"border\">"+x.data[i][10]+"</td>"+
                        "<td class=\"border\">"+x.data[i][11]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"12\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function schHVacPro()
{
    var frm = $("#dte-frm-prvac").val(), to = $("#dte-to-prvac").val(), pro = $("#txt-opt-pro").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shvacpro.php",
            type : "post",
            data : {frm : frm, to : to, pro : pro},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro-prvac").html(setToTblHVacPro(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHVACPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHVacPro(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function schHSawPro()
{
    var frm = $("#dte-frm-prsaw").val(), to = $("#dte-to-prsaw").val(), pro = $("#txt-opt-pro").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shsawpro.php",
            type : "post",
            data : {frm : frm, to : to, pro : pro},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro-prsaw").html(setToTblHSawPro(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHSAWPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHSawPro(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][4])+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"5\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function schHKrmPro()
{
    var frm = $("#dte-frm-trkrm").val(), to = $("#dte-to-trkrm").val(), pro = $("#txt-opt-pro").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/shkrmpro.php",
            type : "post",
            data : {frm : frm, to : to, pro : pro},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pro-trkrm").html(setToTblHKrmPro(json));

                swal.close();
            },
            error : function(){
                swal("Error (SHKRMPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblHKrmPro(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.data[i][2])+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">"+x.data[i][7]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"9\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function ePro(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-pro-1").hasClass("d-none"))
            $("#div-edt-err-pro-1").addClass("d-none");

        if(!$("#div-edt-err-pro-2").hasClass("d-none"))
            $("#div-edt-err-pro-2").addClass("d-none");
            
        if(!$("#div-edt-err-pro-3").hasClass("d-none"))
            $("#div-edt-err-pro-3").addClass("d-none");
            
        if(!$("#div-edt-err-pro-4").hasClass("d-none"))
            $("#div-edt-err-pro-4").addClass("d-none");
            
        if(!$("#div-edt-err-pro-5").hasClass("d-none"))
            $("#div-edt-err-pro-5").addClass("d-none");
            
        if(!$("#div-edt-err-pro-6").hasClass("d-none"))
            $("#div-edt-err-pro-6").addClass("d-none");
            
        if(!$("#div-edt-scs-pro-1").hasClass("d-none"))
            $("#div-edt-scs-pro-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtpro.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);
                $("#edt-txt-nma-kate").val(json.kate[1])
                $("#edt-txt-kate").val(json.data[2]);
                $("#edt-txt-nma-skate").val(json.skate[1])
                $("#edt-txt-skate").val(json.data[3]);
                $("#edt-slct-grade").val(json.data[4]);
                $("#edt-nmbr-qawl").val(json.data[6]);
                $("#edt-slct-kates").val(json.data[15]);
                $("#edt-slct-gol").val(json.data[16]);
                $("#edt-slct-katej").val(json.data[17]);

                if($("#edt-txt-hsell").length > 0)
                    $("#edt-txt-hsell").val(NumberFormat2(json.data[14]));

                $("#edt-chk-trm").prop("checked", false);
                $("#edt-chk-cut").prop("checked", false);
                $("#edt-chk-vac").prop("checked", false);
                $("#edt-chk-saw").prop("checked", false);
                $("#edt-chk-pkg").prop("checked", false);
                $("#edt-chk-mp").prop("checked", false);
                $("#edt-chk-frz").prop("checked", false);

                if(json.data[7] === "Y")
                    $("#edt-chk-trm").prop("checked", true);

                if(json.data[8] === "Y")
                    $("#edt-chk-cut").prop("checked", true);

                if(json.data[9] === "Y")
                    $("#edt-chk-vac").prop("checked", true);

                if(json.data[10] === "Y")
                    $("#edt-chk-saw").prop("checked", true);

                if(json.data[11] === "Y")
                    $("#edt-chk-pkg").prop("checked", true);

                if(json.data[12] === "Y")
                    $("#edt-chk-mp").prop("checked", true);

                if(json.data[13] === "Y")
                    $("#edt-chk-frz").prop("checked", true);

                swal.close();

                /*updChgKateSKate(json.data[2]);

                setTimeout(function(){
                    $("#edt-slct-skate").val(json.data[3]);
                }, 500);*/

                $("#mdl-epro").modal("show");
            },
            error : function(){
                swal("Error (EPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlPro(x)
{
    x = UD64(x);

    $("#txt-opt-pro").val(x);

    $("#mdl-opt-pro").modal("show");
}

function newPro()
{
    var id = $("#txt-id-pro").val(), name = $("#txt-nma-pro").val(), qawl = $("#nmbr-qawl-pro").val(), grade = $("#slct-grade-pro").val(), kate = $("#txt-kate").val(), skate = $("#txt-skate").val(), strm = "N", scut = "N", svac = "N", ssaw = "N", spkg = "N", smp = "N", sfrz = "N", hsell = 0, kates = $("#slct-kates-pro").val(), gol = $("#slct-gol-pro").val(), katej = $("#slct-katej-pro").val();

    if($("#chk-trm").is(":checked"))
        strm = "Y";

    if($("#chk-cut").is(":checked"))
        scut = "Y";

    if($("#chk-vac").is(":checked"))
        svac = "Y";

    if($("#chk-saw").is(":checked"))
        ssaw = "Y";

    if($("#chk-pkg").is(":checked"))
        spkg = "Y";

    if($("#chk-mp").is(":checked"))
        smp = "Y";

    if($("#chk-frz").is(":checked"))
        sfrz = "Y";

    if($("#txt-hsell").length > 0)
    {
        if($("#txt-hsell").val() !== "")
            hsell = UnNumberFormat($("#txt-hsell").val());
    }

    if(!$("#div-err-pro-1").hasClass("d-none"))
        $("#div-err-pro-1").addClass("d-none");

    if(!$("#div-err-pro-2").hasClass("d-none"))
        $("#div-err-pro-2").addClass("d-none");

    if(!$("#div-err-pro-3").hasClass("d-none"))
        $("#div-err-pro-3").addClass("d-none");

    if(!$("#div-err-pro-4").hasClass("d-none"))
        $("#div-err-pro-4").addClass("d-none");

    if(!$("#div-err-pro-5").hasClass("d-none"))
        $("#div-err-pro-5").addClass("d-none");

    if(!$("#div-scs-pro-1").hasClass("d-none"))
        $("#div-scs-pro-1").addClass("d-none");

    if(id === "" || name === "" || grade === "")
        $("#div-err-pro-1").removeClass("d-none");
    else
    {
        $("#btn-snpro").prop("disabled", true);
        $("#btn-snpro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/npro.php",
                type : "post",
                data : {id : id, name : name, qawl : qawl, grade : grade, kate : kate, skate : skate, strm : strm, scut : scut, svac : svac, ssaw : ssaw, spkg : spkg, smp : smp, sfrz : sfrz, hsell : hsell, kates : kates, gol : gol, katej : katej},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-pro-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-pro-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-pro-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-err-pro-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-err-pro-5").removeClass("d-none");
                    else
                    {
                        $("#mdl-npro input").val("");
                        $("#mdl-npro .form-check-input").prop("checked", false);
                        $("#txt-id-pro").val(json.nid[0]);

                        $("#txt-id-pro").focus().select();
                        $("#div-scs-pro-1").removeClass("d-none");

                        schPro($("#txt-srch-pro").val());
                    }
                    
                    $("#btn-snpro").prop("disabled", false);
                    $("#btn-snpro").html("Simpan");
                },
                error : function(){
                    $("#btn-snpro").prop("disabled", false);
                    $("#btn-snpro").html("Simpan");
                    swal("Error (NPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updPro()
{
    var id = $("#edt-txt-id").val(), bid = $("#edt-txt-bid").val(), name = $("#edt-txt-nma").val(), grade = $("#edt-slct-grade").val(), kate = $("#edt-txt-kate").val(), skate = $("#edt-txt-skate").val(), qawl = $("#edt-nmbr-qawl").val(), strm = "N", scut = "N", svac = "N", ssaw = "N", spkg = "N", smp = "N", sfrz = "N", hsell = 0, kates = $("#edt-slct-kates").val(), gol = $("#edt-slct-gol").val(), katej = $("#edt-slct-katej").val();

    if($("#edt-chk-trm").is(":checked"))
        strm = "Y";

    if($("#edt-chk-cut").is(":checked"))
        scut = "Y";

    if($("#edt-chk-vac").is(":checked"))
        svac = "Y";

    if($("#edt-chk-saw").is(":checked"))
        ssaw = "Y";

    if($("#edt-chk-pkg").is(":checked"))
        spkg = "Y";

    if($("#edt-chk-mp").is(":checked"))
        smp = "Y";

    if($("#edt-chk-frz").is(":checked"))
        sfrz = "Y";

    if($("#edt-txt-hsell").length > 0)
    {
        if($("#edt-txt-hsell").val() !== "")
            hsell = UnNumberFormat($("#edt-txt-hsell").val());
    }

    if(!$("#div-edt-err-pro-1").hasClass("d-none"))
        $("#div-edt-err-pro-1").addClass("d-none");

    if(!$("#div-edt-err-pro-2").hasClass("d-none"))
        $("#div-edt-err-pro-2").addClass("d-none");

    if(!$("#div-edt-err-pro-3").hasClass("d-none"))
        $("#div-edt-err-pro-3").addClass("d-none");

    if(!$("#div-edt-err-pro-4").hasClass("d-none"))
        $("#div-edt-err-pro-4").addClass("d-none");

    if(!$("#div-edt-err-pro-5").hasClass("d-none"))
        $("#div-edt-err-pro-5").addClass("d-none");

    if(!$("#div-edt-err-pro-6").hasClass("d-none"))
        $("#div-edt-err-pro-6").addClass("d-none");

    if(!$("#div-edt-scs-pro-1").hasClass("d-none"))
        $("#div-edt-scs-pro-1").addClass("d-none");

    if(id === "" || name === "" || grade === "")
        $("#div-edt-err-pro-1").removeClass("d-none");
    else
    {
        $("#btn-sepro").prop("disabled", true);
        $("#btn-sepro").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/upro.php",
                type : "post",
                data : {id : id, name : name, grade : grade, kate : kate, skate : skate, bid : bid, qawl : qawl, strm : strm, scut : scut, svac : svac, ssaw : ssaw, spkg : spkg, smp : smp, sfrz : sfrz, hsell : hsell, kates : kates, gol : gol, katej : katej},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-pro-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-pro-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-pro-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-edt-err-pro-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-edt-err-pro-5").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -6)
                        $("#div-edt-err-pro-6").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-pro-1").removeClass("d-none");

                        schPro($("#txt-srch-pro").val());
                    }
                    
                    $("#btn-sepro").prop("disabled", false);
                    $("#btn-sepro").html("Simpan");
                },
                error : function(){
                    $("#btn-sepro").prop("disabled", false);
                    $("#btn-sepro").html("Simpan");
                    swal("Error (UPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delPro(x)
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
                    url : "./bin/php/dpro.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DPRO - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schPro($("#txt-srch-pro").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function delAtProTrm(x)
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
            $("#row-tpro-trm-"+x).remove();
    })
}

function delAtProCut(x)
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
            $("#row-tpro-cut-"+x).remove();
    })
}

function delAtProKrm(x)
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
            $("#row-tpro-krm-"+x).remove();
    })
}

//USER
function cardHvr(x)
{
    if(!$("#card-aks-"+x).hasClass("border-info") && !$("#card-aks-"+x).hasClass("active"))
        $("#card-aks-"+x).addClass("border-info");
}

function cardHvr2(x)
{
    if(!$("#card-aks2-"+x).hasClass("border-info") && !$("#card-aks2-"+x).hasClass("active"))
        $("#card-aks2-"+x).addClass("border-info");
}

function cardNHvr(x)
{
    if($("#card-aks-"+x).hasClass("border-info") && !$("#card-aks-"+x).hasClass("active"))
        $("#card-aks-"+x).removeClass("border-info");
}

function cardNHvr2(x)
{
    if($("#card-aks2-"+x).hasClass("border-info") && !$("#card-aks2-"+x).hasClass("active"))
        $("#card-aks2-"+x).removeClass("border-info");
}

function cardAct(x)
{
    if(!$("#card-aks-"+x).hasClass("active"))
    {
        $(".card .card-body").addClass("d-none");
        $(".card .card-header").removeClass("bg-info").removeClass("text-light");
        
        $(".card .csr-pntr>img").attr("src","./bin/img/icon/arr-btm.png");
        
        $(".card").removeClass("active").removeClass("border-info");

        $("#card-aks-"+x).addClass("active border-info");
        
        $("#img-aks-"+x).attr("src","./bin/img/icon/arr-top-wh.png");
    
        $("#div-dcard-"+x).removeClass("d-none");
        $("#div-dhead-"+x).addClass("bg-info text-light");
    }
    else
    {
        $("#card-aks-"+x).removeClass("active").removeClass("border-info");
        
        $("#img-aks-"+x).attr("src","./bin/img/icon/arr-btm.png");
    
        $("#div-dcard-"+x).addClass("d-none");
        $("#div-dhead-"+x).removeClass("bg-info").removeClass("text-light");
    }
}

function cardAct2(x)
{
    if(!$("#card-aks2-"+x).hasClass("active"))
    {
        $(".card .card-body").addClass("d-none");
        $(".card .card-header").removeClass("bg-info").removeClass("text-light");
        
        $(".card .csr-pntr>img").attr("src","./bin/img/icon/arr-btm.png");
        
        $(".card").removeClass("active").removeClass("border-info");

        $("#card-aks2-"+x).addClass("active border-info");
        
        $("#img-aks2-"+x).attr("src","./bin/img/icon/arr-top-wh.png");
    
        $("#div-dcard2-"+x).removeClass("d-none");
        $("#div-dhead2-"+x).addClass("bg-info text-light");
    }
    else
    {
        $("#card-aks2-"+x).removeClass("active").removeClass("border-info");
        
        $("#img-aks2-"+x).attr("src","./bin/img/icon/arr-btm.png");
    
        $("#div-dcard2-"+x).addClass("d-none");
        $("#div-dhead2-"+x).removeClass("bg-info").removeClass("text-light");
    }
}

function chkAll(x)
{
    if($("#chk-all-"+x).prop("checked"))
        $("#div-dcard-"+x+" .custom-control-input").prop("checked",true);
    else
        $("#div-dcard-"+x+" .custom-control-input").prop("checked",false);
}

function aksUser()
{
    var id = $("#txt-opt-user").val();

    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtuser.php",
            type : "post",
            data : {id : id},
            success : function(output){
                var json = $.parseJSON(output);

                setAksUser(json);

                $("#mdl-user-aks").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (AKSUSR) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setAksUser(x)
{
    $(".custom-control-input").prop("checked", false);

    for(var i = 0; i < x.data[7].length; i++)
    {
        if(x.data[7][i] === "1")
            $("#chk-aks-"+i).prop("checked", true);
        else
            $("#chk-aks-"+i).prop("checked", false);
    }
}

function saveUserAks()
{
    var id = $("#txt-opt-user").val(), aks = "";
    
    for(var i = 0; i < 207; i++)
    {
        if($("#chk-aks-"+i).length === 0)
        {
            aks += "0";
            continue;
        }
        
        if($("#chk-aks-"+i).is(":checked"))
            aks += "1";
        else
            aks += "0";
    }
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/saksuser.php",
            type : "post",
            data : {id : id, aks : aks},
            success : function(output){
                var json = $.parseJSON(output);
                
                swal.close();

                if(parseInt(json.err[0]) === -1)
                    swal("Error (SUSRA - 1) !!!", "User tidak ditemukan !!!", "error");
                else
                    swal("Sukses !!!", "Akses berhasil di set", "success");

                $("#mdl-user-aks").modal("hide");
            },
            error : function(){
                swal("Error (SUSRA) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function getNIDUser()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-user-1").hasClass("d-none"))
            $("#div-err-user-1").addClass("d-none");
            
        if(!$("#div-err-user-2").hasClass("d-none"))
            $("#div-err-user-2").addClass("d-none");
            
        if(!$("#div-scs-user-1").hasClass("d-none"))
            $("#div-scs-user-1").addClass("d-none");

        $("#mdl-nuser").modal("show");

        swal.close();
    }, 200)
}

function schUser(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/suser.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-user").html(setToTblUser(json));
                else
                    $("#lst-suser").html(setToTblUser2(json));

                swal.close();
            },
            error : function(){
                swal("Error (SUSR) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblUser(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eUser('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delUser('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";
            
            if(x.aks[2])
                hsl += " <button class=\"btn btn-light border-info mb-1 p-1\" onclick=\"mdlUser('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/more-info.png\" alt=\"More\" width=\"20\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"7\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function setToTblUser2(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr onclick=\"chgUser('"+UE64(x.data[i][0])+"')\">"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][2]+"</td>"+
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">"+x.data[i][5]+"</td>"+
                        "<td class=\"border\">"+x.data[i][6]+"</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"7\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"+
                "</tr>";

    return hsl;
}

function chgUser(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $("#txt-user").val(x);
        
        $("#edt-txt-user").val(x);

        $("#mdl-suser").modal("hide");

        swal.close();
    }, 200);
}

function eUser(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-user-1").hasClass("d-none"))
            $("#div-edt-err-user-1").addClass("d-none");

        if(!$("#div-edt-err-user-2").hasClass("d-none"))
            $("#div-edt-err-user-2").addClass("d-none");
            
        if(!$("#div-edt-err-user-3").hasClass("d-none"))
            $("#div-edt-err-user-3").addClass("d-none");
            
        if(!$("#div-edt-scs-user-1").hasClass("d-none"))
            $("#div-edt-scs-user-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtuser.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-user").val(json.data[0]);
                $("#edt-txt-buser").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[2]);
                $("#edt-txt-pos").val(json.data[3]);
                $("#edt-txt-dvs").val(json.data[4]);
                $("#edt-slct-act").val(json.data[5]);
                $("#edt-slct-lvl").val(json.data[6]);

                $("#mdl-euser").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (EUSR) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function mdlUser(x)
{
    x = UD64(x);

    $("#txt-opt-user").val(x);

    $("#mdl-opt-user").modal("show");
}

function newUser()
{
    var user = $("#txt-user").val(), pass = $("#txt-pass").val(), name = $("#txt-nma").val(), pos = $("#txt-pos").val(), div = $("#txt-dvs").val(), lvl = $("#slct-lvl").val();

    if(!$("#div-err-user-1").hasClass("d-none"))
        $("#div-err-user-1").addClass("d-none");

    if(!$("#div-err-user-2").hasClass("d-none"))
        $("#div-err-user-2").addClass("d-none");

    if(!$("#div-scs-user-1").hasClass("d-none"))
        $("#div-scs-user-1").addClass("d-none");

    if(user === "" || pass === "")
        $("#div-err-user-1").removeClass("d-none");
    else
    {
        $("#btn-snuser").prop("disabled", true);
        $("#btn-snuser").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nuser.php",
                type : "post",
                data : {user : user, pass : pass, name : name, pos : pos, div : div, lvl : lvl},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-user-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-user-2").removeClass("d-none");
                    else
                    {
                        $("#mdl-nuser input").val("");

                        $("#txt-user").focus().select();
                        $("#div-scs-user-1").removeClass("d-none");

                        schUser($("#txt-srch-user").val());
                    }

                    $("#btn-snuser").prop("disabled", false);
                    $("#btn-snuser").html("Simpan");
                },
                error : function(){
                    $("#btn-snuser").prop("disabled", false);
                    $("#btn-snuser").html("Simpan");
                    swal("Error (NUSR) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            });
        }, 200);
    }
}

function updUser()
{
    var user = $("#edt-txt-user").val(), pass = $("#edt-txt-pass").val(), name = $("#edt-txt-nma").val(), pos = $("#edt-txt-pos").val(), div = $("#edt-txt-dvs").val(), lvl = $("#edt-slct-lvl").val(), act = $("#edt-slct-act").val(), buser = $("#edt-txt-buser").val();

    if(!$("#div-edt-err-user-1").hasClass("d-none"))
        $("#div-edt-err-user-1").addClass("d-none");

    if(!$("#div-edt-err-user-2").hasClass("d-none"))
        $("#div-edt-err-user-2").addClass("d-none");

    if(!$("#div-edt-err-user-3").hasClass("d-none"))
        $("#div-edt-err-user-3").addClass("d-none");

    if(!$("#div-edt-scs-user-1").hasClass("d-none"))
        $("#div-edt-scs-user-1").addClass("d-none");

    if(user === "")
        $("#div-edt-err-user-1").removeClass("d-none");
    else
    {
        $("#btn-seuser").prop("disabled", true);
        $("#btn-seuser").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/uuser.php",
                type : "post",
                data : {user : user, pass : pass, name : name, pos : pos, div : div, lvl : lvl, act : act, buser : buser},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-user-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-user-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-user-3").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-user-1").removeClass("d-none");

                        schUser($("#txt-srch-user").val());
                    }

                    $("#btn-seuser").prop("disabled", false);
                    $("#btn-seuser").html("Simpan");
                },
                error : function(){
                    $("#btn-seuser").prop("disabled", false);
                    $("#btn-seuser").html("Simpan");
                    swal("Error (UUSR) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            });
        }, 200);
    }
}

function delUser(x)
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
                    url : "./bin/php/duser.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DUSR - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schUser($("#txt-srch-user").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DUSR) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

//GUDANG
function getNIDGdg()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-gdg-1").hasClass("d-none"))
            $("#div-err-gdg-1").addClass("d-none");
            
        if(!$("#div-err-gdg-2").hasClass("d-none"))
            $("#div-err-gdg-2").addClass("d-none");

        if(!$("#div-scs-gdg-1").hasClass("d-none"))
            $("#div-scs-gdg-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidgdg.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-gdg").val(json.nid[0]);
                $("#mdl-ngdg").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDGDG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function schGdg(x, y = 1)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sgdg.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                if(y === 1)
                    $("#lst-gdg").html(setToTblGdg(json));

                swal.close();
            },
            error : function(){
                swal("Error (SGDG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblGdg(x)
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
                        "<td class=\"border\">"+x.data[i][3]+"</td>"+
                        "<td class=\"border\">"+x.data[i][4]+"</td>"+
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eGdg('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delGdg('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"6\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function eGdg(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-gdg-1").hasClass("d-none"))
            $("#div-edt-err-gdg-1").addClass("d-none");

        if(!$("#div-edt-err-gdg-2").hasClass("d-none"))
            $("#div-edt-err-gdg-2").addClass("d-none");
            
        if(!$("#div-edt-err-gdg-3").hasClass("d-none"))
            $("#div-edt-err-gdg-3").addClass("d-none");
            
        if(!$("#div-edt-err-gdg-4").hasClass("d-none"))
            $("#div-edt-err-gdg-4").addClass("d-none");
            
        if(!$("#div-edt-scs-gdg-1").hasClass("d-none"))
            $("#div-edt-scs-gdg-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtgdg.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);
                $("#edt-txt-addr").val(json.data[2]);
                $("#edt-txt-pic").val(json.data[3]);
                $("#edt-txt-phone").val(json.data[4]);

                $("#mdl-egdg").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (EGDG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function newGdg()
{
    var id = $("#txt-id-gdg").val(), name = $("#txt-nma-gdg").val(), addr = $("#txt-addr-gdg").val(), pic = $("#txt-pic-gdg").val(), hp = $("#txt-phone-gdg").val();

    if(!$("#div-err-gdg-1").hasClass("d-none"))
        $("#div-err-gdg-1").addClass("d-none");

    if(!$("#div-err-gdg-2").hasClass("d-none"))
        $("#div-err-gdg-2").addClass("d-none");

    if(!$("#div-scs-gdg-1").hasClass("d-none"))
        $("#div-scs-gdg-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-err-gdg-1").removeClass("d-none");
    else
    {
        $("#btn-sngdg").prop("disabled", true);
        $("#btn-sngdg").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ngdg.php",
                type : "post",
                data : {id : id, name : name, addr : addr, pic : pic, hp : hp},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-gdg-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-gdg-2").removeClass("d-none");
                    else
                    {
                        $("#mdl-ngdg input").val("");
                        $("#txt-id-gdg").val(json.nid[0]);

                        $("#txt-id-gdg").focus().select();
                        $("#div-scs-gdg-1").removeClass("d-none");

                        schGdg($("#txt-srch-gdg").val());
                    }
                    
                    $("#btn-sngdg").prop("disabled", false);
                    $("#btn-sngdg").html("Simpan");
                },
                error : function(){
                    $("#btn-sngdg").prop("disabled", false);
                    $("#btn-sngdg").html("Simpan");
                    swal("Error (NGDG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updGdg()
{
    var id = $("#edt-txt-id").val(), bid = $("#edt-txt-bid").val(), name = $("#edt-txt-nma").val(), addr = $("#edt-txt-addr").val(), pic = $("#edt-txt-pic").val(), hp = $("#edt-txt-phone").val();

    if(!$("#div-edt-err-gdg-1").hasClass("d-none"))
        $("#div-edt-err-gdg-1").addClass("d-none");

    if(!$("#div-edt-err-gdg-2").hasClass("d-none"))
        $("#div-edt-err-gdg-2").addClass("d-none");

    if(!$("#div-edt-err-gdg-3").hasClass("d-none"))
        $("#div-edt-err-gdg-3").addClass("d-none");

    if(!$("#div-edt-scs-gdg-1").hasClass("d-none"))
        $("#div-edt-scs-gdg-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-edt-err-gdg-1").removeClass("d-none");
    else
    {
        $("#btn-segdg").prop("disabled", true);
        $("#btn-segdg").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ugdg.php",
                type : "post",
                data : {id : id, name : name, addr : addr, pic : pic, hp : hp, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-gdg-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-gdg-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-gdg-3").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-gdg-1").removeClass("d-none");

                        schGdg($("#txt-srch-gdg").val());
                    }
                    
                    $("#btn-segdg").prop("disabled", false);
                    $("#btn-segdg").html("Simpan");
                },
                error : function(){
                    $("#btn-segdg").prop("disabled", false);
                    $("#btn-segdg").html("Simpan");
                    swal("Error (UGDG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delGdg(x)
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
                    url : "./bin/php/dgdg.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DGDG - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schGdg($("#txt-srch-gdg").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DGDG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

//KATEGORIS
function getNIDKates()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-kates-1").hasClass("d-none"))
            $("#div-err-kates-1").addClass("d-none");
            
        if(!$("#div-err-kates-2").hasClass("d-none"))
            $("#div-err-kates-2").addClass("d-none");

        if(!$("#div-scs-kates-1").hasClass("d-none"))
            $("#div-scs-kates-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidkates.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-kates").val(json.nid[0]);
                $("#mdl-nkates").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDKATES) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function schKates(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/skates.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-kates").html(setToTblKates(json));

                swal.close();
            },
            error : function(){
                swal("Error (SKATES) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblKates(x)
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
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eKates('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delKates('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"4\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function chgKates(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtkates.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-nma-kates").val(json.data[1]);
                $("#txt-kates").val(x);

                $("#edt-txt-nma-kates").val(json.data[1]);
                $("#edt-txt-kates").val(x);
                
                $("#mdl-skates").modal("hide");

                swal.close();
            },
            error : function(){
                swal("Error (CHGKATES) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function eKates(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-kates-1").hasClass("d-none"))
            $("#div-edt-err-kates-1").addClass("d-none");

        if(!$("#div-edt-err-kates-2").hasClass("d-none"))
            $("#div-edt-err-kates-2").addClass("d-none");
            
        if(!$("#div-edt-err-kates-3").hasClass("d-none"))
            $("#div-edt-err-kates-3").addClass("d-none");
            
        if(!$("#div-edt-scs-kates-1").hasClass("d-none"))
            $("#div-edt-scs-kates-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtkates.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);
                $("#edt-slct-cut").val(json.data[2]);

                $("#mdl-ekates").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (EKATES) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function newKates()
{
    var id = $("#txt-id-kates").val(), name = $("#txt-nma-kates").val(), cut = $("#slct-cut-kates").val();

    if(!$("#div-err-kates-1").hasClass("d-none"))
        $("#div-err-kates-1").addClass("d-none");

    if(!$("#div-err-kates-2").hasClass("d-none"))
        $("#div-err-kates-2").addClass("d-none");

    if(!$("#div-scs-kates-1").hasClass("d-none"))
        $("#div-scs-kates-1").addClass("d-none");

    if(id === "" || name === "" || cut === "")
        $("#div-err-kates-1").removeClass("d-none");
    else
    {
        $("#btn-snkates").prop("disabled", true);
        $("#btn-snkates").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/nkates.php",
                type : "post",
                data : {id : id, name : name, cut : cut},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-kates-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-kates-2").removeClass("d-none");
                    else
                    {
                        $("#mdl-nkates input").val("");
                        $("#txt-id-kates").val(json.nid[0]);

                        $("#txt-id-kates").focus().select();
                        $("#div-scs-kates-1").removeClass("d-none");

                        schKates($("#txt-srch-kates").val());
                    }
                    
                    $("#btn-snkates").prop("disabled", false);
                    $("#btn-snkates").html("Simpan");
                },
                error : function(){
                    $("#btn-snkates").prop("disabled", false);
                    $("#btn-snkates").html("Simpan");
                    swal("Error (NKATES) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updKates()
{
    var id = $("#edt-txt-id").val(), bid = $("#edt-txt-bid").val(), name = $("#edt-txt-nma").val(), cut = $("#edt-slct-cut").val();

    if(!$("#div-edt-err-kates-1").hasClass("d-none"))
        $("#div-edt-err-kates-1").addClass("d-none");

    if(!$("#div-edt-err-kates-2").hasClass("d-none"))
        $("#div-edt-err-kates-2").addClass("d-none");

    if(!$("#div-edt-err-kates-3").hasClass("d-none"))
        $("#div-edt-err-kates-3").addClass("d-none");

    if(!$("#div-edt-scs-kates-1").hasClass("d-none"))
        $("#div-edt-scs-kates-1").addClass("d-none");

    if(id === "" || name === "" || cut === "")
        $("#div-edt-err-kates-1").removeClass("d-none");
    else
    {
        $("#btn-sekates").prop("disabled", true);
        $("#btn-sekates").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ukates.php",
                type : "post",
                data : {id : id, name : name, bid : bid, cut : cut},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-kates-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-kates-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-kates-3").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-kates-1").removeClass("d-none");

                        schKates($("#txt-srch-kates").val());
                    }
                    
                    $("#btn-sekates").prop("disabled", false);
                    $("#btn-sekates").html("Simpan");
                },
                error : function(){
                    $("#btn-sekates").prop("disabled", false);
                    $("#btn-sekates").html("Simpan");
                    swal("Error (UKATES) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delKates(x)
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
                    url : "./bin/php/dkates.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DKATES - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schKates($("#txt-srch-kates").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DKATES) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

//GOL
function getNIDGol()
{
    Process();
    setTimeout(function(){
        if(!$("#div-err-gol-1").hasClass("d-none"))
            $("#div-err-gol-1").addClass("d-none");
            
        if(!$("#div-err-gol-2").hasClass("d-none"))
            $("#div-err-gol-2").addClass("d-none");

        if(!$("#div-scs-gol-1").hasClass("d-none"))
            $("#div-scs-gol-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gnidgol.php",
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-id-gol").val(json.nid[0]);
                $("#mdl-ngol").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (GNIDGOL) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function schGol(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/sgol.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-gol").html(setToTblGol(json));

                swal.close();
            },
            error : function(){
                swal("Error (SGOL) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblGol(x)
{
    var hsl = "";

    if(x.count[0] > 0)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.data[i][0]+"</td>"+
                        "<td class=\"border\">"+x.data[i][1]+"</td>"+
                        "<td class=\"border\">";
            
            if(x.aks[0])
                hsl += " <button class=\"btn btn-light border-warning mb-1 p-1\" onclick=\"eGol('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/edit-icon.png\" alt=\"Ralat\" width=\"18\"></button>";
            
            if(x.aks[1])
                hsl += " <button class=\"btn btn-light border-danger mb-1 p-1\" onclick=\"delGol('"+UE64(x.data[i][0])+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"Hapus\" width=\"18\"></button>";

            hsl +=      "</td>"+
                    "</tr>";
        }
    }
    else
        hsl += "<tr>"+
                    "<td colspan=\"4\" class=\"text-center text-danger font-weight-bold border\">Data tidak ditemukan.</td>"
                "</tr>"

    return hsl;
}

function chgGol(x)
{
    x = UD64(x);
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdtgol.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#txt-nma-gol").val(json.data[1]);
                $("#txt-gol").val(x);

                $("#edt-txt-nma-gol").val(json.data[1]);
                $("#edt-txt-gol").val(x);
                
                $("#mdl-sgol").modal("hide");

                swal.close();
            },
            error : function(){
                swal("Error (CHGGOL) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function eGol(x)
{
    x = UD64(x);

    Process();
    setTimeout(function(){
        if(!$("#div-edt-err-gol-1").hasClass("d-none"))
            $("#div-edt-err-gol-1").addClass("d-none");

        if(!$("#div-edt-err-gol-2").hasClass("d-none"))
            $("#div-edt-err-gol-2").addClass("d-none");
            
        if(!$("#div-edt-err-gol-3").hasClass("d-none"))
            $("#div-edt-err-gol-3").addClass("d-none");
            
        if(!$("#div-edt-scs-gol-1").hasClass("d-none"))
            $("#div-edt-scs-gol-1").addClass("d-none");

        $.ajax({
            url : "./bin/php/gdtgol.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#edt-txt-id").val(json.data[0]);
                $("#edt-txt-bid").val(json.data[0]);
                $("#edt-txt-nma").val(json.data[1]);

                $("#mdl-egol").modal("show");
                swal.close();
            },
            error : function(){
                swal("Error (EGOL) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function newGol()
{
    var id = $("#txt-id-gol").val(), name = $("#txt-nma-gol").val();

    if(!$("#div-err-gol-1").hasClass("d-none"))
        $("#div-err-gol-1").addClass("d-none");

    if(!$("#div-err-gol-2").hasClass("d-none"))
        $("#div-err-gol-2").addClass("d-none");

    if(!$("#div-scs-gol-1").hasClass("d-none"))
        $("#div-scs-gol-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-err-gol-1").removeClass("d-none");
    else
    {
        $("#btn-sngol").prop("disabled", true);
        $("#btn-sngol").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ngol.php",
                type : "post",
                data : {id : id, name : name},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-gol-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-gol-2").removeClass("d-none");
                    else
                    {
                        $("#mdl-ngol input").val("");
                        $("#txt-id-gol").val(json.nid[0]);

                        $("#txt-id-gol").focus().select();
                        $("#div-scs-gol-1").removeClass("d-none");

                        schGol($("#txt-srch-gol").val());
                    }
                    
                    $("#btn-sngol").prop("disabled", false);
                    $("#btn-sngol").html("Simpan");
                },
                error : function(){
                    $("#btn-sngol").prop("disabled", false);
                    $("#btn-sngol").html("Simpan");
                    swal("Error (NGOL) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function updGol()
{
    var id = $("#edt-txt-id").val(), bid = $("#edt-txt-bid").val(), name = $("#edt-txt-nma").val();

    if(!$("#div-edt-err-gol-1").hasClass("d-none"))
        $("#div-edt-err-gol-1").addClass("d-none");

    if(!$("#div-edt-err-gol-2").hasClass("d-none"))
        $("#div-edt-err-gol-2").addClass("d-none");

    if(!$("#div-edt-err-gol-3").hasClass("d-none"))
        $("#div-edt-err-gol-3").addClass("d-none");

    if(!$("#div-edt-scs-gol-1").hasClass("d-none"))
        $("#div-edt-scs-gol-1").addClass("d-none");

    if(id === "" || name === "")
        $("#div-edt-err-gol-1").removeClass("d-none");
    else
    {
        $("#btn-segol").prop("disabled", true);
        $("#btn-segol").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/ugol.php",
                type : "post",
                data : {id : id, name : name, bid : bid},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    if(parseInt(json.err[0]) === -1)
                        $("#div-edt-err-gol-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-edt-err-gol-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-edt-err-gol-3").removeClass("d-none");
                    else
                    {
                        $("#div-edt-scs-gol-1").removeClass("d-none");

                        schGol($("#txt-srch-gol").val());
                    }
                    
                    $("#btn-segol").prop("disabled", false);
                    $("#btn-segol").html("Simpan");
                },
                error : function(){
                    $("#btn-segol").prop("disabled", false);
                    $("#btn-segol").html("Simpan");
                    swal("Error (UGOL) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function delGol(x)
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
                    url : "./bin/php/dgol.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(parseInt(json.err[0]) === -1)
                            swal("Error (DGOL - 1) !!!", "Data sedang dipakai, gagal menghapus data !!!", "error");
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
                                    schGol($("#txt-srch-gol").val());
                            });
                        }
                    },
                    error : function(){
                        swal("Error (DGOL) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}