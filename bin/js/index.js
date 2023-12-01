var lview;

function rnd_rgb(a = 1)
{
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + a + ')';
}

function viewHarga()
{
    return false;
}

function MdlFocus(x,y)
{
    $(x).on("shown.bs.modal", function(){
        $(y).focus().select();
    })
}

function CekAtStart(x)
{
    var elm = x, val = elm.value, cek = false;
    if(typeof elm.selectionStart === "number")
    {
        // Non-IE browsers
        cek = (elm.selectionStart === 0);
    }
    else if(document.selection && document.selection.createRange)
    {
        // IE <= 8 branch
        elm.focus();
        var selRange = document.selection.createRange();
        var inputRange = elm.createTextRange();
        var inputSelRange = inputRange.duplicate();
        inputSelRange.moveToBookmark(selRange.getBookmark());
        cek = inputSelRange.compareEndPoints("StartToStart", inputRange) === 0;
    }
    
    return cek;
}

function CekAtEnd(x)
{
    var elm = x, val = elm.value, cek = false;
    if(typeof elm.selectionStart === "number")
    {
        // Non-IE browsers
        cek = (elm.selectionEnd === val.length);
    }
    else if(document.selection && document.selection.createRange)
    {
        // IE <= 8 branch
        elm.focus();
        var selRange = document.selection.createRange();
        var inputRange = elm.createTextRange();
        var inputSelRange = inputRange.duplicate();
        inputSelRange.moveToBookmark(selRange.getBookmark());
        cek = inputSelRange.compareEndPoints("EndToEnd", inputRange) === 0;
    }
    
    return cek;
}

function EntrFrm(x,y,z = "")
{
    if($(x).prop("disabled"))
        $(x).removeAttr("disabled");
        
    $('body').on('keydown', y, function(e){
        if(e.keyCode == 13 || e.keyCode == 37 || e.keyCode == 39)
        {
            if(y == ".inp-set")
                SetEntr(e,x, "div.modal-body", ":input.inp-set", this, z);
            else if(y == ".inp-tgh")
                SetEntr(e,x, "#lst-dtl", ":input.inp-tgh", this, z, 2);
            else if(y == ".inp-byr")
                SetEntr(e,x, "#lst-dtl", ":input.inp-byr", this, z, 2);
            else if(y == ".inp-byr")
                SetEntr(e,x, "#lst-dtl", ":input.inp-jur", this, z, 2);
            else if(y == ".inp-tbl")
                SetEntr(e,x, "#lst-tpro-trm", ":input.inp-tbl", this, z, 2);
            else if(y == ".inp-ctbl")
                SetEntr(e,x, "#lst-tpro-cut", ":input.inp-ctbl", this, z, 2);
            else if(y == ".inp-ktbl")
                SetEntr(e,x, "#lst-tpro-krm", ":input.inp-ktbl", this, z, 2);
            else
                $(x).click();
        }
    });
}

function SetEntr(e, x, y, z, w, scroll, v = 1)
{
    var inputs = $(w).parents(y).eq(0).find(z);
    
    var idx = inputs.index(w);
    
    if(e.keyCode === 13 || (e.keyCode === 39 && $(w).prop("type") === "number") || (e.keyCode === 39 && CekAtEnd(w)))
    {
        if(idx === inputs.length - 1 && v === 1)
        {
            e.preventDefault();
            $(x).focus();
        }
        else if(idx === inputs.length - 1 && v === 2)
        {
            e.preventDefault();
            inputs[0].select();
            
            $(scroll).scrollTop(0);
        }
        else
        {
            e.preventDefault();
            inputs[idx + 1].select();
            
            if(idx >= 4)
                $(scroll).scrollTop((idx-1)*30);
        }
    }
    else
    {
        if((idx !== 0 && CekAtStart(w)) || (idx !== 0 && $(w).prop("type") === "number"))
        {
            e.preventDefault();
            inputs[idx - 1].select();
        }
    }
                
    return false;
}

function CekSesi()
{
    $.ajax({
        url : "./bin/php/csesi.php",
        type : "post",
        success : function(output){
            var json = $.parseJSON(output);
            
            if(json.err[0] == -1)
            {
                swal({
                    title : "Error !!!", 
                    text : "Maaf sesi anda telah berakhir, harap login kembali",
                    icon : "error",
                })
                .then(ok => {
                    if(ok)
                        window.location.href = "./login?exp=1";
                })
            }
        },
        error : function(){
            swal("Error (CS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
        }
    })
}

function GetUParam(x)
{
    var sPageURL = window.location.search.substring(1);
                        
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == x)
            return sParameterName[1];
    }
}

function ToTop()
{
    $("html, body").animate({scrollTop: 0}, 500);
    $('.modal').animate({ scrollTop: 0 }, 500);
}

function TinyMCE(x)
{
    tinymce.init({
        selector: x,
        plugins: 'print preview fullpage importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap emoticons',
        menu: {
            tc: {
                title: 'TinyComments',
                items: 'addcomment showcomments deleteallconversations'
            }
        },
        menubar: 'file edit view insert format tools table tc help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
        autosave_ask_before_unload: true,
        autosave_interval: "30s",
        autosave_prefix: "{path}{query}-{id}-",
        autosave_restore_when_empty: false,
        autosave_retention: "2m",
        image_advtab: true,
        importcss_append: true,
        height: 400,
        image_caption: true,
        noneditable_noneditable_class: "mceNonEditable",
        toolbar_drawer: 'sliding',
        spellchecker_dialog: true,
        spellchecker_whitelist: ['Ephox', 'Moxiecode'],
        tinycomments_mode: 'embedded',
        content_style: ".mymention{ color: gray; }",
        contextmenu: "link image imagetools table configurepermanentpen",
    });
}

function FormatUang(x)
{    
    $(function(){
        $("body").on("blur", x, function() {
            $(x).html(null);
            $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n'});
        })
        .on("keyup", x, function(e) {
            var e = window.event || e;
            var keyUnicode = e.charCode || e.keyCode;
            
            if(keyUnicode >= 65 && keyUnicode <= 90)
            {
                e.preventDefault();
                $(this).val(0);
            }
            else
            {
                if (e !== undefined) {
                    switch (keyUnicode) {
                        case 16: break; // Shift
                        case 17: break; // Ctrl
                        case 18: break; // Alt
                        case 27: this.value = ''; break; // Esc: clear entry
                        case 35: break; // End
                        case 36: break; // Home
                        case 37: break; // cursor left
                        case 38: break; // cursor up
                        case 39: break; // cursor right
                        case 40: break; // cursor down
                        case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                        case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                        case 190: break; // .
                        default: $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', eventOnDecimalsEntered: true });
                    }
                }
            }
        })
    })
}

function ToExcel(x,y,z)
{
    $(x).click(function(){
        $(y).table2excel({
            name: z,
            filename: z,
        });
    })
}

function NumberFormat(x)
{
    var hsl;

    if(isNaN(x))
        return 0;

    if(x % 1 != 0)
        x = parseFloat(x).toFixed(2);
    
    x = Math.round(x);
    
    x = x.toString().split(".");
    
    hsl = "";
    for(var i = 0; i < x[0].length; i++)
    {
        if(i == x[0].length - 1 && x[0].substr(x[0].length-1-i,1) == '-')
            hsl = x[0].substr(x[0].length-1-i,1)+hsl;
        else
        {
            if(i % 3 == 0 && i != 0)
                hsl = "."+hsl;
            
            hsl = x[0].substr(x[0].length-1-i,1)+hsl;
        }
    }

    if(x.length == 2)
        hsl += ","+x[1];
        
    return hsl;
}

function NumberFormat2(x)
{
    var hsl, y;

    if(isNaN(x))
        return 0;

    if(x % 1 != 0)
        x = parseFloat(x).toFixed(2);
        
    //x = Math.round(x);
    
    x = x.toString().split(",");
    y = x[0].toString().split(".");
    
    var length = x[0].length, str = x[0];
    
    if(y.length > 1)
    {
        length = y[0].length;
        str = y[0];
    }
    
    hsl = "";
    for(var i = 0; i < length; i++)
    {
        if(i == str.length - 1 && str.substr(str.length-1-i,1) == "-")
            hsl = str.substr(str.length-1-i,1)+hsl;
        else
        {
            if(i % 3 == 0 && i != 0)
                hsl = ","+hsl;

            hsl = str.substr(str.length-1-i,1)+hsl;
        }
    }
    
    if(y.length > 1)
        hsl += "."+y[1];
        
    return hsl;
}

function UnNumberFormat(x)
{
    var hsl = x;
    
    x = x.toString().split(".");
    
    var y = x[x.length-1].split(",");
    
    if(x.length > 1 && y[0].length === 3)
    {
        var z = x[0].toString().split(",");
        
        if(z.length === 1)
        {
            hsl = "";
            
            for(var i = 0; i < x.length; i++)
            {
                if(i == x.length - 1)
                    hsl = hsl + y[0];
                else
                    hsl = hsl+x[i];
            }
            
            if(y.length === 2)
                hsl = hsl+"."+y[1];
            
            return hsl;
        }
    }
    
    return UnNumberFormat2(hsl);
}

function UnNumberFormat2(x)
{
    var hsl = "";
    
    x = x.toString().split(",");
    
    for(var i = 0; i < x.length; i++)
    {
        hsl = hsl+x[i];
    }
    
    return hsl;
}

function Reload()
{
    window.location.reload();
}

function ImgUpload(x)
{
    x.imageupload();

    $('#imageupload-disable').on('click', function(){
        x.imageupload('disable');
        $(this).blur();
    })

    $('#imageupload-enable').on('click', function(){
        x.imageupload('enable');
        $(this).blur();
    })

    $('#imageupload-reset').on('click', function(){
        x.imageupload('reset');
        $(this).blur();
    });
}

function CekPDF()
{
    $("#pdf-file").change(function(e){
        if(!$("#div-err-p1").hasClass("d-none"))
            $("#div-err-p1").addClass("d-none");
                    
        if(!$("#div-err-p2").hasClass("d-none"))
            $("#div-err-p2").addClass("d-none");
                    
        var files = e.originalEvent.target.files;
        for (var i=0; i<files.length; i++)
        {
            var s = files[i].size, t = files[i].type;
                        
            if(s > (10 * 1024000))
                $("#div-err-p2").removeClass("d-none");
            else if(t != "application/pdf")
                $("#div-err-p1").removeClass("d-none");
        }
    });
}

function GetLinkPara(x)
{
    var sPageURL = window.location.search.substring(1);
                        
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == x)
            return sParameterName[1];
    }
}

function Process(x = "", y = 1)
{
    var icon = "./bin/img/process.gif";
    
    if(y === 2)
        icon = "../bin/img/process.gif";

    swal({
        text: x,
        icon: icon,
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
    })
}

function Process2(x = "")
{
    swal({
        text: x,
        icon: "../bin/img/process.gif",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
    })
}

function UD64(x)
{
    x = x.replace(/\./g,"+");
    x = x.replace(/\_/g,"/");
    x = x.replace(/\-/g,"=");
    
    return $.base64.decode(x);
}

function UE64(x)
{
    var y = $.base64.encode(x);
    
    y = y.replace(/\+/g,".");
    y = y.replace(/\//g,"_");
    y = y.replace(/\=/g,"-");
    
    return y;
}

function htmlspecialchars(x)
{
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return x.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function htmlspecialchars_decode(x)
{
    var map = {
        '&amp;': '&;',
        '&lt;': '<;',
        '&gt;': '>',
        '&quot;': '"',
        '&#039;': "'",
    };

    return x.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m) { return map[m]; });
}

function Login()
{
    $("#btn-lgn").click(function(){        
        var user = $("#txt-user").val(), pass = $("#txt-pass").val();
        
        if(!$("#div-err-1").hasClass("d-none"))
            $("#div-err-1").addClass("d-none");
        
        if(!$("#div-err-2").hasClass("d-none"))
            $("#div-err-2").addClass("d-none");
        
        if(!$("#div-err-3").hasClass("d-none"))
            $("#div-err-3").addClass("d-none");
        
        if(!$("#div-err-4").hasClass("d-none"))
            $("#div-err-4").addClass("d-none");
        
        ToTop();
        if(user == "" || pass == "")
            $("#div-err-1").removeClass("d-none");
        else
        {
            $("#btn-lgn").prop("disabled", true);
            $("#btn-lgn").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Login");

            $.ajax({
                url : "./bin/php/login.php",
                type : "post",
                data : {user : user, pass : pass},
                success : function(output){
                    var json = $.parseJSON(output);
                    
                    $("#btn-lgn").prop("disabled", false);
                    $("#btn-lgn").html("Login");
                    
                    if(json.err[0] == -1)
                        $("#div-err-1").removeClass("d-none");
                    else if(json.err[0] == -2)
                        $("#div-err-2").removeClass("d-none");
                    else if(json.err[0] == -3)
                        $("#div-err-3").removeClass("d-none");
                    else if(json.err[0] == -4)
                        $("#div-err-4").removeClass("d-none");
                    else
                    {
                        $("#btn-lgn").prop("disabled", true);
                        $("#btn-lgn").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Logging In...");
                        window.location.href = "./home";
                    }
                },
                error : function(){
                    $("#btn-lgn").prop("disabled", false);
                    $("#btn-lgn").html("Login");
                    swal("Error (LGN) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                }
            })
        }
    })
}

function ViewPass(x)
{
    var mdl = $(x).attr("data-value");
    
    if($(mdl).attr("type") === "password")
    {
        $(mdl).attr("type", "text");
        $(x).html("<img src=\"./bin/img/icon/unview-icon.png\" alt=\"Hide\" width=\"25\">");
    }
    else
    {
        $(mdl).attr("type", "password");
        $(x).html("<img src=\"./bin/img/icon/view-icon.png\" alt=\"Hide\" width=\"25\">");
    }
}

function CekFileFormat(x, y)
{
    $(x).change(function(){
        if($.isArray(y))
            var arr = y;
        else
            var arr = y.split(",");
        
        if($.inArray($(this).val().split('.').pop().toLowerCase(), arr) == -1)
        {
            swal("Error (CFF) !!!", "Tipe file yang di upload tidak sesuai !!!", "error");
            
            $(this).val("");
        }
    });
}

function CekUpload(x)
{
    $(x).change(function(e){
        /*var files = e.originalEvent.target.files;
        for (var i=0; i<files.length; i++)
        {
            var s = files[i].size, t = files[i].type;
            
            var y = t.split("/");
            
            if(s > (100 * 1024000))
            {
                swal("Error (CUPLD - 1) !!!", "Maksimum size video adalah 100 MB !!!", "error");
            
                $(x).val("");
            }
            else if(y[0] != "video")
            {
                swal("Error (CUPLD - 2) !!!", "Harap mengupload video !!!", "error");
            
                $(x).val("");
            }
        }*/
    });
}

function cekVerif()
{
    var type = $("#txt-vkode").attr("data-type");

    if(type === "PJM")
        cekPjmVerif();
    else if(type === "TRM")
        cekTrmVerif();
    else if(type === "CUT")
        cekCutVerif();
    else if(type === "VAC")
        cekVacVerif();
    else if(type === "SAW")
        cekSawVerif();
    else if(type === "KRM")
        cekKrmVerif();
}

//SETTING
function saveSett()
{
    var smcut = $("#slct-mcut").val(), vmcut = $("#nmbr-mcut").val(), smvac = $("#slct-mvac").val(), vmvac = $("#nmbr-mvac").val(), smsaw = $("#slct-msaw").val(), vmsaw = $("#nmbr-msaw").val(), gdg = $("#slct-gdg").val(), kgdg = $("#slct-kgdg").val(), phcut = $("#nmbr-hcut").val(), phttl = $("#nmbr-hpcut").val(), phtlg = $("#nmbr-hpncut").val();
    
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ssett.php",
            type : "post",
            data : {smcut : smcut, vmcut : vmcut, smvac : smvac, vmvac : vmvac, smsaw : smsaw, vmsaw : vmsaw, gdg : gdg, kgdg : kgdg, phcut : phcut, phttl : phttl, phtlg : phtlg},
            success : function(){
                swal("Sukses !!!", "Setting berhasil di simpan, setting mulai berlaku pada transaksi selanjutnya !!!", "success");
            },
            error : function(){
                swal("Error (SSETT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function delSettPro(x, y, z){
    x = UD64(x);
    z = UD64(z);

    swal({
        title : "Perhatian !!!",
        text: "Anda yakin hapus data ?",
        icon : "warning",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) => {
        if(ok){
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dsettpro.php",
                    type : "post",
                    data : {id : z},
                    success : function(output){
                        var json = $.parseJSON(output);

                        if(y === "ASCHNPRO"){
                            $("#ls-achnpro-"+x).remove();
                        }
                        else if(y === "ASCHPRO"){
                            $("#ls-achpro-"+x).remove();
                        }

                        swal("Sukses !!!", "Data berhasil dihapus !!!", "success");
                    },
                    error : function(){
                        swal("Error (DSTPRO) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    }
                })
            }, 200);
        }
    })
}

function chgPass()
{
    var bpass = $("#txt-bpass").val(), npass = $("#txt-npass").val(), cnpass = $("#txt-cnpass").val();

    if(!$("#div-err-cpass-1").hasClass("d-none"))
        $("#div-err-cpass-1").addClass("d-none");

    if(!$("#div-err-cpass-2").hasClass("d-none"))
        $("#div-err-cpass-2").addClass("d-none");

    if(!$("#div-err-cpass-3").hasClass("d-none"))
        $("#div-err-cpass-3").addClass("d-none");

    if(!$("#div-scs-cpass-1").hasClass("d-none"))
        $("#div-scs-cpass-1").addClass("d-none");

    if(bpass === "" || npass === "" || cnpass === "")
        $("#div-err-cpass-1").removeClass("d-none");
    else if(npass !== cnpass)
        $("#div-err-cpass-2").removeClass("d-none");
    else
    {
        $("#btn-scpass").prop("disabled", true);
        $("#btn-scpass").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Simpan");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/cpass.php",
                type : "post",
                data : {bpass : bpass, npass : npass, cnpass : cnpass},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-cpass-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-cpass-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-cpass-3").removeClass("d-none");
                    else
                    {
                        $("#div-scs-cpass-1").removeClass("d-none");

                        $("#mdl-cpass input").val("");
                    }

                    $("#btn-scpass").prop("disabled", false);
                    $("#btn-scpass").html("Simpan");
                },
                error : function(){
                    $("#btn-scpass").prop("disabled", false);
                    $("#btn-scpass").html("Simpan");

                    swal("Error (CPASS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function getVerif()
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gverif.php",
            type : "post",
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-vtran").html(setToTblVerif(json));
            },
            error : function(){
                swal("Error (GVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVerif(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++)
    {
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[0][i][0]+"</td>"+
                    "<td class=\"border\">Penerimaan</td>"+
                    "<td class=\"border text-warning\">Edit</td>"+
                    "<td class=\"border\">"+x.data[0][i][1]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-sm btn-light m-1 border border-success rounded btn-averif\" data-value=\""+UE64(x.data[0][i][2])+"\" data-type=\""+UE64(1)+"\"><img src=\"./bin/img/icon/checkmark-icon.png\" width=\"18\"></button> <button class=\"btn btn-sm btn-light border m-1 border-danger rounded btn-cverif\" data-value=\""+UE64(x.data[0][i][2])+"\" data-type=\""+UE64(1)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></td>"+
                "</tr>";
    }

    for(var i = 0; i < x.count[1]; i++)
    {
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[1][i][0]+"</td>"+
                    "<td class=\"border\">Cutting</td>"+
                    "<td class=\"border text-warning\">Edit</td>"+
                    "<td class=\"border\">"+x.data[1][i][1]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-sm btn-light m-1 border border-success rounded btn-averif\" data-value=\""+UE64(x.data[1][i][2])+"\" data-type=\""+UE64(2)+"\"><img src=\"./bin/img/icon/checkmark-icon.png\" width=\"18\"></button> <button class=\"btn btn-sm btn-light border m-1 border-danger rounded btn-cverif\" data-value=\""+UE64(x.data[1][i][2])+"\" data-type=\""+UE64(2)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></td>"+
                "</tr>";
    }

    for(var i = 0; i < x.count[2]; i++)
    {
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[2][i][0]+"</td>"+
                    "<td class=\"border\">Vacuum</td>"+
                    "<td class=\"border text-warning\">Edit</td>"+
                    "<td class=\"border\">"+x.data[2][i][1]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-sm btn-light m-1 border border-success rounded btn-averif\" data-value=\""+UE64(x.data[2][i][2])+"\" data-type=\""+UE64(3)+"\"><img src=\"./bin/img/icon/checkmark-icon.png\" width=\"18\"></button> <button class=\"btn btn-sm btn-light border m-1 border-danger rounded btn-cverif\" data-value=\""+UE64(x.data[2][i][2])+"\" data-type=\""+UE64(3)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></td>"+
                "</tr>";
    }

    for(var i = 0; i < x.count[3]; i++)
    {
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[3][i][0]+"</td>"+
                    "<td class=\"border\">Sawing</td>"+
                    "<td class=\"border text-warning\">Edit</td>"+
                    "<td class=\"border\">"+x.data[3][i][1]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-sm btn-light m-1 border border-success rounded btn-averif\" data-value=\""+UE64(x.data[3][i][2])+"\" data-type=\""+UE64(4)+"\"><img src=\"./bin/img/icon/checkmark-icon.png\" width=\"18\"></button> <button class=\"btn btn-sm btn-light border m-1 border-danger rounded btn-cverif\" data-value=\""+UE64(x.data[3][i][2])+"\" data-type=\""+UE64(4)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></td>"+
                "</tr>";
    }

    for(var i = 0; i < x.count[4]; i++)
    {
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[4][i][0]+"</td>"+
                    "<td class=\"border\">Tanda Terima</td>"+
                    "<td class=\"border text-warning\">Edit</td>"+
                    "<td class=\"border\">"+x.data[4][i][1]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-sm btn-light m-1 border border-success rounded btn-averif\" data-value=\""+UE64(x.data[4][i][2])+"\" data-type=\""+UE64(5)+"\"><img src=\"./bin/img/icon/checkmark-icon.png\" width=\"18\"></button> <button class=\"btn btn-sm btn-light border m-1 border-danger rounded btn-cverif\" data-value=\""+UE64(x.data[4][i][2])+"\" data-type=\""+UE64(5)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></td>"+
                "</tr>";
    }

    for(var i = 0; i < x.count[5]; i++)
    {
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[5][i][0]+"</td>"+
                    "<td class=\"border\">Peminjaman</td>"+
                    "<td class=\"border text-warning\">Edit</td>"+
                    "<td class=\"border\">"+x.data[5][i][1]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-sm btn-light m-1 border border-success rounded btn-averif\" data-value=\""+UE64(x.data[5][i][2])+"\" data-type=\""+UE64(6)+"\"><img src=\"./bin/img/icon/checkmark-icon.png\" width=\"18\"></button> <button class=\"btn btn-sm btn-light border m-1 border-danger rounded btn-cverif\" data-value=\""+UE64(x.data[5][i][2])+"\" data-type=\""+UE64(6)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></td>"+
                "</tr>";
    }

    for(var i = 0; i < x.count[6]; i++)
    {
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[6][i][0]+"</td>"+
                    "<td class=\"border\">Packaging</td>"+
                    "<td class=\"border text-warning\">Edit</td>"+
                    "<td class=\"border\">"+x.data[6][i][1]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-sm btn-light m-1 border border-success rounded btn-averif\" data-value=\""+UE64(x.data[6][i][2])+"\" data-type=\""+UE64(7)+"\"><img src=\"./bin/img/icon/checkmark-icon.png\" width=\"18\"></button> <button class=\"btn btn-sm btn-light border m-1 border-danger rounded btn-cverif\" data-value=\""+UE64(x.data[6][i][2])+"\" data-type=\""+UE64(7)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></td>"+
                "</tr>";
    }

    for(var i = 0; i < x.count[7]; i++)
    {
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[7][i][0]+"</td>"+
                    "<td class=\"border\">Masuk Produk</td>"+
                    "<td class=\"border text-warning\">Edit</td>"+
                    "<td class=\"border\">"+x.data[7][i][1]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-sm btn-light m-1 border border-success rounded btn-averif\" data-value=\""+UE64(x.data[7][i][2])+"\" data-type=\""+UE64(8)+"\"><img src=\"./bin/img/icon/checkmark-icon.png\" width=\"18\"></button> <button class=\"btn btn-sm btn-light border m-1 border-danger rounded btn-cverif\" data-value=\""+UE64(x.data[7][i][2])+"\" data-type=\""+UE64(7)+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function averif(x, y)
{
    swal({
        title : "Perhatian !!!",
        text : "Anda yakin verifikasi ?",
        icon : "warning",
        buttons : true,
        dangerMode : true,
    })
    .then((ok) => {
        if(ok){
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/averif.php",
                    type : "post",
                    data : {id : x, type : y},
                    success : function(output){
                        var json = $.parseJSON(output);
                        getVerif();

                        swal.close();
                    },
                    error : function(){
                        swal("Error (AVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200)
        }
    });
}

function dverif(x, y)
{
    swal({
        title : "Perhatian !!!",
        text : "Anda yakin tolak verifikasi ?",
        icon : "warning",
        buttons : true,
        dangerMode : true,
    })
    .then((ok) => {
        if(ok){
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dverif.php",
                    type : "post",
                    data : {id : x, type : y},
                    success : function(output){
                        var json = $.parseJSON(output);
                        getVerif();

                        swal.close();
                    },
                    error : function(){
                        swal("Error (DVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function getPVerif()
{
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gpverif.php",
            type : "post",
            success : function(output){
                var json = $.parseJSON(output);

                $("#lst-pvtran").html(setToTblPVerif(json));
            },
            error : function(){
                swal("Error (GPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblPVerif(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++){
        var nma = x.data[i][2]+" / "+x.data[i][3];

        if(x.data[i][4] !== "")
            nma += x.data[i][4];
            
        if(x.data[i][5] !== "")
            nma += x.data[i][5];

        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[i][1]+"</td>"+
                    "<td class=\"border\">"+nma+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(x.data[i][6])+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(x.data[i][7])+"</td>"+
                    "<td class=\"border\">"+x.data[i][8]+"</td>"+
                    "<td class=\"border\"><button class=\"btn btn-sm btn-light border m-1 border-success rounded btn-apverif\" data-value=\""+UE64(x.data[i][0])+"\"><img src=\"./bin/img/icon/checkmark-icon.png\" width=\"18\"></button> <button class=\"btn btn-sm btn-light border m-1 border-danger rounded btn-cpverif\" data-value=\""+UE64(x.data[i][0])+"\"><img src=\"./bin/img/icon/cancel-icon.png\" width=\"18\"></button></td>"+
                "</tr>";
    }

    return hsl;
}

function apverif(x)
{
    swal({
        title : "Perhatian !!!",
        text : "Anda yakin verifikasi ?",
        icon : "warning",
        buttons : true,
        dangerMode : true,
    })
    .then((ok) => {
        if(ok){
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/apverif.php",
                    type : "post",
                    data : {id : x},
                    success : function(output){
                        var json = $.parseJSON(output);
                        getPVerif();

                        swal.close();
                    },
                    error : function(){
                        swal("Error (APVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    });
}

function dpverif(x, y)
{
    swal({
        title : "Perhatian !!!",
        text : "Anda yakin tolak verifikasi ?",
        icon : "warning",
        buttons : true,
        dangerMode : true,
    })
    .then((ok) => {
        if(ok){
            Process();
            setTimeout(function(){
                $.ajax({
                    url : "./bin/php/dpverif.php",
                    type : "post",
                    data : {id : x, ket : y},
                    success : function(output){
                        var json = $.parseJSON(output);
                        getPVerif();

                        swal.close();
                    },
                    error : function(){
                        swal("Error (DPVRF) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200)
        }
    });
}

function getLView()
{
    var ctx = document.getElementById("chart5");

    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ldview.php",
            success : function(output){
                var json = $.parseJSON(output);

                lview = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Today"],
                        datasets: [
                            {
                                label: 'Penerimaan',
                                data: [json.data[0]],
                                backgroundColor: 'rgb(110, 161, 255)',
                                borderColor: 'rgb(110, 161, 255)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Cutting',
                                data: [json.data[1]],
                                backgroundColor: 'rgb(255, 110, 110)',
                                borderColor: 'rgb(255, 110, 110)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Vacuum',
                                data: [json.data[2]],
                                backgroundColor: 'rgb(255, 248, 110)',
                                borderColor: 'rgb(255, 248, 110)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Sawing',
                                data: [json.data[3]],
                                backgroundColor: 'rgb(110, 255, 127)',
                                borderColor: 'rgb(110, 255, 127)',
                                borderWidth: 1,
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            },
            error : function(){
                swal("Error (GLVIEW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function updLView()
{
    var ctx = document.getElementById("chart5");

    setTimeout(function(){
        $.ajax({
            url : "./bin/php/ldview.php",
            success : function(output){
                var json = $.parseJSON(output);

                lview.data.datasets.pop();
                lview.data.datasets.pop();
                lview.data.datasets.pop();
                lview.data.datasets.pop();
                lview.data.datasets.push({
                    label: 'Penerimaan',
                    data: [json.data[0]],
                    backgroundColor: 'rgb(110, 161, 255)',
                    borderColor: 'rgb(110, 161, 255)',
                    borderWidth: 1,
                });
                lview.data.datasets.push({
                    label: 'Cutting',
                    data: [json.data[1]],
                    backgroundColor: 'rgb(255, 110, 110)',
                    borderColor: 'rgb(255, 110, 110)',
                    borderWidth: 1,
                });
                lview.data.datasets.push({
                    label: 'Vacuum',
                    data: [json.data[2]],
                    backgroundColor: 'rgb(255, 248, 110)',
                    borderColor: 'rgb(255, 248, 110)',
                    borderWidth: 1,
                });
                lview.data.datasets.push({
                    label: 'Sawing',
                    data: [json.data[3]],
                    backgroundColor: 'rgb(110, 255, 127)',
                    borderColor: 'rgb(110, 255, 127)',
                    borderWidth: 1,
                });
                lview.update()
            },
            error : function(){
                swal("Error (ULVIEW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200)
}

function desLView()
{
    lview.destroy();
}

function setDateLView(x, y)
{
    $(y).val(UE64(x));
}

function getLViewCut()
{
    var tgl = UD64($("#btn-slv-cut").val());
    
    setTimeout(function(){
        $.ajax({
            url : "../bin/php/gdtlivecut.php",
            type : "post",
            data : {tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                $("#spn-dte").text(json.dte[0]);
                setToLVCut(json);
            },
            error : function(){
                swal("Error (GLVIEWCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToLVCut(x)
{
    var pnrm = "", cut = "", lv = "";

    for(var i = 0; i < x.count[0]; i++)
    {
        if(i != 0)
        {
            pnrm += "<hr>";
            cut += "<hr>";
        }

        var npnrm = "<h6 class=\""+x.lwrn[i]+"\">"+x.ltgl[i]+"</h6>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Total (Ekor)</div>"+
                    "<div class=\"col-6 my-1 font-weight-bold\">"+NumberFormat2(x.ltrm[i][1])+"</div>"+
                "</div>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Total (KG)</div>"+
                    "<div class=\"col-7 my-1 font-weight-bold\">"+NumberFormat2(parseFloat(x.ltrm[i][0]))+"</div>"+
                "</div>";

        var ncut = "<h6 class=\""+x.lwrn[i]+"\">"+x.ltgl[i]+"</h6>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Total (Ekor)</div>"+
                    "<div class=\"col-7 my-1 font-weight-bold\">"+NumberFormat2(x.lcut[i][1])+"</div>"+
                "</div>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Total (KG)</div>"+
                    "<div class=\"col-7 my-1 font-weight-bold\">"+NumberFormat2(parseFloat(x.lcut[i][0]))+" ["+NumberFormat2(((parseFloat(x.lcut[i][0]) / parseFloat(x.ltrm[i][0]))*100).toFixed(2))+" %]<br>("+x.set[0]+" "+x.set[1]+" %)</div>"+
                "</div>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Ket Cutting : </div>"+
                    "<div class=\"col-7 my-1 small\">";

        for(var j = 0; j < x.lket[i].length; j++)
        {
            if(j != 0)
                ncut += "<br>";

            ncut += x.lket[i][j][0]+" = "+NumberFormat2(x.lket[i][j][1])+" KG";
        }
                
        ncut +=      "</div>"+
                "</div>"+
                "<div class=\"row mt-3\">"+
                    "<div class=\"col-5 my-1\">Total Beku (Ekor)</div>"+
                    "<div class=\"col-7 my-1 font-weight-bold\">"+NumberFormat2(x.lfrz[i][1])+"</div>"+
                "</div>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Total Beku (KG)</div>"+
                    "<div class=\"col-7 my-1 font-weight-bold\">"+NumberFormat2(parseFloat(x.lfrz[i][0]))+" ["+NumberFormat2(((parseFloat(x.lfrz[i][0]) / parseFloat(x.ltrm[i][0]))*100).toFixed(2))+" %]</div>"+
                "</div>";

        var nvac = "<h6 class=\""+x.lwrn[i]+"\">"+x.ltgl[i]+"</h6>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Bahan (KG)</div>"+
                    "<div class=\"col-6 my-1 font-weight-bold\">"+NumberFormat2(x.lvac[i][1])+"</div>"+
                "</div>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Hasil (KG)</div>"+
                    "<div class=\"col-6 my-1 font-weight-bold\">"+NumberFormat2(x.lvac[i][0])+"</div>"+
                "</div>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Persentase</div>"+
                    "<div class=\"col-7 my-1 font-weight-bold\">"+NumberFormat2(parseFloat(x.lvac[i][0])/parseFloat(x.lvac[i][1])*100)+" %</div>"+
                "</div>"+
                "<div class=\"row\">"+
                    "<div class=\"col-5 my-1\">Dari Cut Tgl : </div>"+
                    "<div class=\"col-7 my-1 small\">";

        for(var j = 0; j < x.lv[i].length; j++)
        {
            if(j != 0)
                nvac += "<br>";

            nvac += x.lv[i][j][0]+" = "+NumberFormat2(x.lv[i][j][1])+" KG";
        }

        nvac +=     "</div>"+
                "</div>";

        pnrm += npnrm;
        cut += ncut;

        lv += "<div class=\"row m-0\"><div class=\"col-4\">"+npnrm+"</div><div class=\"col-4 border-left\">"+ncut+"</div><div class=\"col-4 border-left\">"+nvac+"</div></div><hr>";
    }
    
    //$("#dpnrm").html(pnrm);
    //$("#dcut").html(cut);
    $("#live-view").html(lv);
}

function getLViewVac()
{
    var tgl = UD64($("#btn-slv-vac").val());
    
    setTimeout(function(){
        $.ajax({
            url : "../bin/php/gdtlivevac.php",
            type : "post",
            data : {tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                $("#spn-dte").text(json.dte[0]);
                $("#lv-vac").html(setToLVVac(json));
            },
            error : function(){
                swal("Error (GLVIEWVAC) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToLVVac(x)
{
    var hsl = "", count, sum, rspn = 1;

    for(var i = 0; i < x.count[0]; i++)
    {
        count = 0;
        sum = 0;
        rspn = 1;
    
        if(x.lsvacc[i].length != 0)
        {
            count = x.lsvacc[i].length - 1;
            rspn = x.lsvacc[i].length;
        }

        for(var j = 0; j <= count; j++)
        {
            hsl += "<tr>";

            if(j === 0)
            {
                hsl += "<td class=\"border font-weight-bold\" rowspan=\""+rspn+"\">Cutting ("+x.lvacc[i][1]+") = "+NumberFormat2(x.lvacc[i][2])+" KG</td>";
            }

            if(x.lsvacc[i].length > 0)
            {
                hsl += "<td class=\"border\">"+x.lsvacc[i][j][0]+" / "+x.lsvacc[i][j][1];
                
                if(x.lsvacc[i][j][2] !== "")
                    hsl += " / "+x.lsvacc[i][j][2];
                
                if(x.lsvacc[i][j][3] !== "")
                    hsl += " / "+x.lsvacc[i][j][3];

                var prsn = ((x.lsvacc[i][j][4] / x.lvacc[i][2]) * 100).toFixed(2);

                hsl += " = "+NumberFormat2(x.lsvacc[i][j][4])+" KG <strong>("+NumberFormat2(prsn)+" %)</strong></td>";

                sum += parseFloat(prsn);
            }

            hsl += "</tr>";
        }

        hsl += "<tr>"+
                    "<td class=\"border text-right font-weight-bold\">Total</td>"+
                    "<td class=\"border text-right font-weight-bold\">"+NumberFormat2(sum)+" %</td>"+
                "</tr>";
    }

    for(var i = 0; i < x.count[1]; i++)
    {
        count = 0;
        sum = 0;
        rspn = 1;
    
        if(x.lsvac[i].length != 0)
        {
            count = x.lsvac[i].length - 1;
            rspn = x.lsvac[i].length;
        }

        for(var j = 0; j <= count; j++)
        {
            hsl += "<tr>";

            if(j === 0)
            {
                if(x.lvac[i][6] !== "")
                {
                    hsl += "<td class=\"border font-weight-bold\" rowspan=\""+rspn+"\"><ul class=\"small mb-0\">";
                    
                    hsl += "<li>"+x.lvac[i][0]+" / "+x.lvac[i][1];
                
                    if(x.lvac[i][2] !== "")
                        hsl += " / "+x.lvac[i][2];
                    
                    if(x.lvac[i][3] !== "")
                        hsl += " / "+x.lvac[i][3];
                    
                    hsl += " = "+NumberFormat2(x.lvac[i][4])+" KG</li><li>"+x.lvac[i][6]+" / "+x.lvac[i][7];
                
                    if(x.lvac[i][8] !== "")
                        hsl += " / "+x.lvac[i][8];
                    
                    if(x.lvac[i][9] !== "")
                        hsl += " / "+x.lvac[i][9];

                    hsl += " = "+NumberFormat2(x.lvac[i][10])+" KG</li></ul>";
                }
                else
                {
                    hsl += "<td class=\"border font-weight-bold\" rowspan=\""+rspn+"\">"+x.lvac[i][0]+" / "+x.lvac[i][1];
                
                    if(x.lvac[i][2] !== "")
                        hsl += " / "+x.lvac[i][2];
                    
                    if(x.lvac[i][3] !== "")
                        hsl += " / "+x.lvac[i][3];

                    hsl += " = "+NumberFormat2(x.lvac[i][4])+" KG</td>";
                }
            }

            if(x.lsvac[i].length > 0)
            {
                hsl += "<td class=\"border\">"+x.lsvac[i][j][0]+" / "+x.lsvac[i][j][1];
                
                if(x.lsvac[i][j][2] !== "")
                    hsl += " / "+x.lsvac[i][j][2];
                
                if(x.lsvac[i][j][3] !== "")
                    hsl += " / "+x.lsvac[i][j][3];
                    
                var prsn = ((x.lsvac[i][j][4] / (parseFloat(x.lvac[i][4])+parseFloat(x.lvac[i][10]))) * 100).toFixed(2);

                hsl += " = "+NumberFormat2(x.lsvac[i][j][4])+" KG <strong>("+NumberFormat2(prsn)+" %)</strong></td>";

                sum += parseFloat(prsn);
            }

            hsl += "</tr>";
        }

        hsl += "<tr>"+
                    "<td class=\"border text-right font-weight-bold\">Total</td>"+
                    "<td class=\"border text-right font-weight-bold\">"+NumberFormat2(sum)+" %</td>"+
                "</tr>";
    }

    return hsl;
}

function getLViewSaw()
{
    var tgl = UD64($("#btn-slv-saw").val());
    
    setTimeout(function(){
        $.ajax({
            url : "../bin/php/gdtlivesaw.php",
            type : "post",
            data : {tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                $("#spn-dte").text(json.dte[0]);
                $("#lv-saw").html(setToLVSaw(json));
            },
            error : function(){
                swal("Error (GLVIEWSAW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToLVSaw(x)
{
    var hsl = "", count, sum, rspn;

    for(var i = 0; i < x.count[0]; i++)
    {
        count = 0;
        sum = 0;
        rspn = 1;
        
        if(x.lssaw[i].length != 0)
        {
            count = x.lssaw[i].length - 1;
            rspn = x.lssaw[i].length;
        }

        for(var j = 0; j <= count; j++)
        {
            hsl += "<tr>";

            if(j === 0)
            {
                hsl += "<td class=\"border font-weight-bold\" rowspan=\""+rspn+"\">"+x.lsaw[i][0]+" / "+x.lsaw[i][1];
                
                if(x.lsaw[i][2] !== "")
                    hsl += " / "+x.lsaw[i][2];
                
                if(x.lsaw[i][3] !== "")
                    hsl += " / "+x.lsaw[i][3];

                hsl += " = "+NumberFormat2(x.lsaw[i][4])+" KG</td>";
            }

            if(x.lssaw[i].length > 0)
            {
                hsl += "<td class=\"border\">"+x.lssaw[i][j][0]+" / "+x.lssaw[i][j][1];
                
                if(x.lssaw[i][j][2] !== "")
                    hsl += " / "+x.lssaw[i][j][2];
                
                if(x.lssaw[i][j][3] !== "")
                    hsl += " / "+x.lssaw[i][j][3];

                var prsn = 0;
                if(x.lsaw[i][4] != 0)
                    prsn = ((x.lssaw[i][j][4] / x.lsaw[i][4]) * 100).toFixed(2);

                hsl += " = "+NumberFormat2(x.lssaw[i][j][4])+" KG <strong>("+NumberFormat2(prsn)+" %)</strong></td>";

                sum += parseFloat(prsn);
            }

            hsl += "</tr>";
        }

        hsl += "<tr>"+
                    "<td class=\"border text-right font-weight-bold\">Total</td>"+
                    "<td class=\"border text-right font-weight-bold\">"+NumberFormat2(sum.toFixed(2))+" %</td>"+
                "</tr>";
    }

    return hsl;
}

function getLViewInv()
{
    var tgl = UD64($("#btn-slv-inv").val());
    
    setTimeout(function(){
        $.ajax({
            url : "../bin/php/gdtliveinv.php",
            type : "post",
            data : {tgl : tgl},
            success : function(output){
                var json = $.parseJSON(output);

                //$("#spn-dte").text(json.dte[0]);
                
                $("#lv-cpro").text(NumberFormat2(json.pro[0])+" ("+NumberFormat2(json.pro[1])+" KG)");
                $("#lv-strm").text(NumberFormat2(json.trm[1])+" Ekor ("+NumberFormat2(json.trm[0])+" KG)");
                $("#lv-sbproc").text(NumberFormat2(json.proc[0]));
                $("#lv-shproc").text(NumberFormat2(json.proc[1]));
                $("#lv-inv").html(setToLVInv(json));
            },
            error : function(){
                swal("Error (GLVIEWINV) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToLVInv(x)
{
    var hsl = "";

    /*for(var i = 0; i < x.count[0]; i++)
    {
        for(var j = 7; j <= 27; j++)
        {
            if(isNaN(parseFloat(x.data[i][j])))
                x.data[i][j] = 0;
            else
                x.data[i][j] = parseFloat(x.data[i][j]);
        }
        
        hsl += "<tr>"+
                    "<td class=\"border\">"+x.data[i][0]+"</td>"+
                    "<td class=\"border\">"+x.data[i][1]+"</td>"+
                    "<td class=\"border\">"+x.data[i][4]+"</td>"+
                    "<td class=\"border\">"+x.data[i][2]+"</td>"+
                    "<td class=\"border\">"+x.data[i][3]+"</td>"+
                    "<td class=\"border text-right\">"+NumberFormat2(parseFloat(x.data[i][32]))+"</td>"+
                "</tr>"
    }*/

    for(var i = 0; i < x.count[0]; i++){
        var lqty = "";

        for(var j = 2; j < x.data[i].length; j++){
            lqty += "<td class=\"border text-right\">"+NumberFormat2(x.data[i][j])+"</td>";
        }

        hsl += "<tr>"+
                    "<td class=\"border text-center\">"+(i+1)+"</td>"+
                    "<td class=\"border\">"+x.data[i][0]+"</td>"+
                    "<td class=\"border\">"+x.data[i][1]+"</td>"+
                    lqty+
                "</tr>";
    }

    return hsl;
}

function repairPjm()
{
    swal({
        title : "Perhatian !!!",
        text : "Anda yakin memperbaiki data pinjaman ?",
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
                    url : "./bin/php/rpjm.php",
                    success : function(){
                        swal("Sukses !!!", "Repair berhasil !!!", "success");
                    },
                    error : function(){
                        swal("Error (RPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function repairStk()
{
    swal({
        title : "Perhatian !!!",
        text : "Anda yakin memperbaiki data produk ?",
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
                    url : "./bin/php/rstk.php",
                    success : function(){
                        swal("Sukses !!!", "Repair berhasil !!!", "success");
                    },
                    error : function(){
                        swal("Error (RSTK) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}

function getLViewKrm()
{
    var type = $("#slct-tkrm").val(), po = $("#txt-po").val();
    
    setTimeout(function(){
        $.ajax({
            url : "../bin/php/gdtlivekrm.php",
            type : "post",
            data : {type : type, po : po},
            success : function(output){
                var json = $.parseJSON(output);

                $("#lv-krm").html(setToLVKrm(json));
            },
            error : function(){
                swal("Error (GLVIEWKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToLVKrm(x)
{
    var hsl = "";

    for(var i = 0; i < x.count[0]; i++)
    {
        hsl += "<div class=\"col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 my-2\">"+
                    "<div class=\"border p-3\">"+
                        "<h5 class=\"text-center m-0 border-bottom border-dark pb-2\">"+x.lpo[i][0]+"</h5>"+
                        "<ul class=\"py-2\">";

        for(var j = 0; j < x.ldpo[i].length; j++)
        {
            var dtl = x.ldpo[i][j][0]+" / ";

            if(x.ldpo[i][j][1] !== "" && x.ldpo[i][j][1] !== null)
                dtl += x.ldpo[i][j][1];
            
            dtl += " / ";

            if(x.ldpo[i][j][2] !== "" && x.ldpo[i][j][2] !== null)
                dtl += x.ldpo[i][j][2];

            dtl += " / ";

            if(x.ldpo[i][j][3] !== "" && x.ldpo[i][j][3] !== null)
                dtl += x.ldpo[i][j][3];

            dtl += " / <strong>"+NumberFormat2(x.ldpo[i][j][4])+"</strong>";

            hsl +=          "<li>"+dtl+"</li>";
        }

        hsl +=          "</ul>"+
                    "</div>"+
                "</div>";
    }

    return hsl;
}

function chgDB()
{
    setTimeout(function(){
        var db = $("#slct-sdb").val();

        $.ajax({
            url : "./bin/php/cdb.php",
            type : "post",
            data : {db : db},
            error : function(){
                swal("Error (CDB) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        });
    }, 200);
}

function saveTBuku()
{
    var txt = $("#txt-stbuku").val(), c1 = $("#chk-sttp-bln").is(":checked"), c2 = $("#chk-sttp-bln2").is(":checked"), c3 = $("#chk-sttp-bln3").is(":checked"), dstk = "N", dpjm = "N", dsmpn = "N";
    if(!$("#div-err-tbuku-1").hasClass("d-none"))
        $("#div-err-tbuku-1").addClass("d-none");

    if($("#chk-sttp-dstk-y").is(":checked"))
        dstk = "Y";
    
    if($("#chk-sttp-dpjm-y").is(":checked"))
        dpjm = "Y";
    
    if($("#chk-sttp-dsmpn-y").is(":checked"))
        dsmpn = "Y";

    swal({
        title : "Perhatian !!!",
        icon : "warning",
        text : "Yakin tutup buku ?",
        dangerMode : true,
        buttons : true,
    })
    .then(ok => {
        if(ok)
        {
            if(txt !== "SAYA SETUJU" || !c1 || !c2 || !c3)
                $("#div-err-tbuku-1").removeClass("d-none");
            else
            {
                Process();
                setTimeout(function(){
                    $.ajax({
                        url : "./bin/php/stbuku.php",
                        type : "post",
                        data : {txt : txt, c1 : c1, c2 : c2, c3 : c3, dstk : dstk, dpjm : dpjm, dsmpn : dsmpn},
                        success : function(output){
                            var json = $.parseJSON(output);

                            if(parseInt(json.err[0]) === -1)
                                $("#div-err-tbuku-1").removeClass("d-none");
                            else
                            {
                                swal({
                                    title : "Sukses !!!",
                                    text : "Tutup buku berhasil, silahkan klik \"OK\" untuk memuat ulang halaman...",
                                    icon : "success",
                                    closeOnClickOutside : false,
                                    closeOnEsc : false,
                                })
                                .then(ok => {
                                    if(ok)
                                        Reload();
                                })
                            }
                        },
                        error : function(){
                            swal("Error (STBK) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                        },
                    })
                })
            }
        }
    })
}

//AUTO
function updTAtPro()
{
    for(var i = 0; i < parseInt($("#btn-sat-trm").attr("data-cpro")); i++)
    {
        if($("#nmbr-tpro-"+i).length === 0)
            continue;

        var sw = UnNumberFormat($("#txt-sw").val()), prsn = UnNumberFormat($("#nmbr-tpro-"+i).val());

        if(sw === "")
            sw = 0;

        if(prsn === 0)
            prsn = 0;
        else
            prsn = parseFloat(prsn/100);

        $("#txt-tpro-jlh-"+i).val(NumberFormat2(sw * prsn));
    }
}

function updTAtProKrm()
{
    for(var i = 0; i < parseInt($("#btn-sat-krm").attr("data-cpro")); i++)
    {
        if($("#nmbr-tpro-krm-"+i).length === 0)
            continue;

        var sw = UnNumberFormat($("#txt-sw-krm").val()), prsn = UnNumberFormat($("#nmbr-tpro-krm-"+i).val());

        if(sw === "")
            sw = 0;

        if(prsn === 0)
            prsn = 0;
        else
            prsn = parseFloat(prsn/100);

        $("#txt-tpro-krm-jlh-"+i).val(NumberFormat2(sw * prsn));
    }
}

function setAtDate()
{
    var frm = new Date($("#dte-frm").val()), to = new Date($("#dte-to").val()), hsl = "";

    $("#btn-sat-date").prop("disabled", true);
    $("#btn-sat-date").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Set");

    if(!$("#div-tdate-trm").hasClass("d-none"))
        $("#div-tdate-trm").addClass("d-none");

    if(frm > to)
    {
        tmp = frm;
        frm = to;
        to = tmp;
    }
    
    var arr = [frm];
    while(frm < to)
    {
        var date = new Date(frm);
        arr.push(date);
        date.setDate(date.getDate() + 1);

        frm = date;
    }
    
    for(var i = 0; i < arr.length; i++)
    {
        hsl +=  "<div class=\"col-6 col-sm-6 col-md-3 col-lg-2 col-xl-2 my-1\" id=\"div-tdate-trm-"+i+"\">"+
                    "<div class=\"input-group border\">"+
                        "<input type=\"date\" class=\"form-control-plaintext pl-1 py-1 hdn-cal-icon small\" id=\"dte-tgl-at-"+i+"\" value=\"\" readonly>"+
                        "<div class=\"input-group-append\">"+
                            "<button class=\"btn btn-light border-danger p-1\" onclick=\"delAtTglTrm('"+UE64(i)+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"\" width=\"18\"></button>"+
                        "</div>"+
                    "</div>"+
                "</div>";
    }

    $("#lst-tdate-trm").html(hsl);

    for(var i = 0; i < arr.length; i++)
        $("#dte-tgl-at-"+i)[0].valueAsDate = arr[i];

    $("#div-tdate-trm").removeClass("d-none");
    $("#btn-sat-trm").attr("data-cdate", arr.length);
    $("#btn-sat-date").prop("disabled", false);
    $("#btn-sat-date").html("Set");
}

function setAtDateKrm()
{
    var frm = new Date($("#dte-frm-krm").val()), to = new Date($("#dte-to-krm").val()), hsl = "";

    $("#btn-sat-date-krm").prop("disabled", true);
    $("#btn-sat-date-krm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Set");

    if(!$("#div-tdate-krm").hasClass("d-none"))
        $("#div-tdate-krm").addClass("d-none");

    if(frm > to)
    {
        tmp = frm;
        frm = to;
        to = tmp;
    }
    
    var arr = [frm];
    while(frm < to)
    {
        var date = new Date(frm);
        arr.push(date);
        date.setDate(date.getDate() + 1);

        frm = date;
    }
    
    for(var i = 0; i < arr.length; i++)
    {
        hsl +=  "<div class=\"col-6 col-sm-6 col-md-3 col-lg-2 col-xl-2 my-1\" id=\"div-tdate-krm-"+i+"\">"+
                    "<div class=\"input-group border\">"+
                        "<input type=\"date\" class=\"form-control-plaintext pl-1 py-1 hdn-cal-icon small\" id=\"dte-tgl-at-krm-"+i+"\" value=\"\" readonly>"+
                        "<div class=\"input-group-append\">"+
                            "<button class=\"btn btn-light border-danger p-1\" onclick=\"delAtTglKrm('"+UE64(i)+"')\"><img src=\"./bin/img/icon/delete-icon.png\" alt=\"\" width=\"18\"></button>"+
                        "</div>"+
                    "</div>"+
                "</div>";
    }

    $("#lst-tdate-krm").html(hsl);

    for(var i = 0; i < arr.length; i++)
        $("#dte-tgl-at-krm-"+i)[0].valueAsDate = arr[i];

    $("#div-tdate-krm").removeClass("d-none");
    $("#btn-sat-krm").attr("data-cdate", arr.length);
    $("#btn-sat-date-krm").prop("disabled", false);
    $("#btn-sat-date-krm").html("Set");
}

function delAtTglTrm(x)
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
            $("#div-tdate-trm-"+x).remove();
    })
}

function delAtTglKrm(x)
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
            $("#div-tdate-krm-"+x).remove();
    })
}

function autoGenTrm()
{
    var lpro = [], lsup = [], tsup = "Y", ltgl = [], mbrt = $("#nmbr-rfrm").val(), mxbrt = $("#nmbr-rto").val(), mtran = $("#nmbr-msup").val(), mxtran = $("#nmbr-mxsup").val(), sw = UnNumberFormat($("#txt-sw").val()), cpro = $("#btn-sat-trm").attr("data-cpro"), csup = $("#btn-sat-trm").attr("data-csup"), ctgl = $("#btn-sat-trm").attr("data-cdate"), mxsbrt = UnNumberFormat($("#txt-mxw").val()), user = $("#slct-user").val(), sat = $("#slct-sat").val(), mjf = $("#nmbr-rjffrm").val(), mxjf = $("#nmbr-rjfto").val(), prsn = 0, rcfrm = $("#nmbr-tsfrm").val(), rcto = $("#nmbr-tsto").val(), jpot = $("#nmbr-jpot").val(), cuser = $("#slct-user-cut").val(), lcpro = [], cpro2 = $("#btn-sat-trm").attr("data-cpro2"), cprsn = 0, vuser = $("#slct-user-vac").val(), dpd = "N", dpdhc = "N", tcut = "Y", ocut = "N";

    if($("#chk-dpd").is(":checked"))
        dpd = "Y";

    if($("#chk-dpd-hcut").is(":checked"))
        dpdhc = "Y";

    if(!$("#div-err-at-trm-1").hasClass("d-none"))
        $("#div-err-at-trm-1").addClass("d-none");

    if(!$("#div-err-at-trm-2").hasClass("d-none"))
        $("#div-err-at-trm-2").addClass("d-none");

    if(!$("#div-err-at-trm-3").hasClass("d-none"))
        $("#div-err-at-trm-3").addClass("d-none");

    if(!$("#div-err-at-trm-4").hasClass("d-none"))
        $("#div-err-at-trm-4").addClass("d-none");

    if(!$("#div-err-at-trm-5").hasClass("d-none"))
        $("#div-err-at-trm-5").addClass("d-none");

    if(!$("#div-err-at-trm-6").hasClass("d-none"))
        $("#div-err-at-trm-6").addClass("d-none");

    if(!$("#div-err-at-trm-7").hasClass("d-none"))
        $("#div-err-at-trm-7").addClass("d-none");

    if(!$("#div-err-at-scs-1").hasClass("d-none"))
        $("#div-err-at-scs-1").addClass("d-none");

    for(var i = 0; i < cpro; i++)
    {
        if($("#btn-dat-pro-trm-"+i).length === 0)
            continue;

        lpro.push([UD64($("#btn-dat-pro-trm-"+i).attr("data-value")), $("#nmbr-tpro-"+i).val()]);
        prsn += Math.round(parseFloat($("#nmbr-tpro-"+i).val())*100)/100;
    }


    if($("#rdo-ahcut-no").is(":checked"))
    {
        tcut = "N";
        for(var i = 0; i < cpro2; i++)
        {
            if($("#btn-dat-pro-cut-"+i).length === 0)
                continue;

            lcpro.push([UD64($("#btn-dat-pro-cut-"+i).attr("data-value")), $("#nmbr-ctpro-"+i).val()]);
            cprsn += Math.round(parseFloat($("#nmbr-ctpro-"+i).val()) * 100)/100;
        }
    }

    if($("#rdo-asup-no").is(":checked"))
    {
        tsup = "N";
        for(var i = 0; i < csup; i++)
        {
            if($("#btn-dat-sup-trm-"+i).length === 0)
                continue;

            lsup.push(UD64($("#btn-dat-sup-trm-"+i).attr("data-value")));
        }
    }

    if($("#chk-ocut").is(":checked")){
        ocut = "Y";
    }

    for(var i = 0; i < ctgl; i++)
    {
        if($("#dte-tgl-at-"+i).length === 0)
            continue;
        
        ltgl.push($("#dte-tgl-at-"+i).val());
    }
    
    if((sw === "" || parseFloat(sw) == 0 || parseFloat(sw) < 0) && ocut === "N")
        $("#div-err-at-trm-1").removeClass("d-none");
    else if((cpro === 0 || $("#lst-tpro-trm tr").length === 0) && ocut === "N")
        $("#div-err-at-trm-2").removeClass("d-none");
    else if(tsup === "N" && (csup === 0 || $("#lst-tsup-trm tr").length === 0))
        $("#div-err-at-trm-3").removeClass("d-none");
    else if(ctgl === 0 || $("#lst-tdate-trm div").length === 0)
        $("#div-err-at-trm-4").removeClass("d-none");
    else if(parseFloat(prsn) !== 100 && ocut === "N")
        $("#div-err-at-trm-5").removeClass("d-none");
    else if(dpdhc === "N" && (cpro2 === 0 || $("#lst-tpro-cut tr").length === 0) && !$("#rdo-ahcut-yes").is(":checked"))
        $("#div-err-at-trm-6").removeClass("d-none");
    else if(dpdhc === "N" && cprsn !== 100 && !$("#rdo-ahcut-yes").is(":checked"))
        $("#div-err-at-trm-7").removeClass("d-none");
    else
    {
        lpro = JSON.stringify(lpro);
        lcpro = JSON.stringify(lcpro);
        lsup = JSON.stringify(lsup);
        ltgl = JSON.stringify(ltgl);

        $("#btn-sat-trm").prop("disabled", true);
        $("#btn-sat-trm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Generate");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/genattrm.php",
                type : "post",
                data : {sw : sw, lpro : lpro, tsup : tsup, lsup : lsup, ltgl : ltgl, mbrt : mbrt, mxbrt : mxbrt, mtran : mtran, mxtran : mxtran, mxsbrt : mxsbrt, user : user, sat : sat, mjf : mjf, mxjf : mxjf, rcfrm : rcfrm, rcto : rcto, jpot : jpot, cuser : cuser, lcpro : lcpro, vuser : vuser, dpd : dpd, dpdhc : dpdhc, tcut : tcut, ocut : ocut},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-at-trm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-at-trm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-at-trm-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-err-at-trm-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-err-at-trm-5").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -6)
                        $("#div-err-at-trm-6").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -7)
                        $("#div-err-at-trm-7").removeClass("d-none");
                    else
                    {
                        /*$("#btn-sat-trm").attr("data-cpro", 0);
                        $("#btn-sat-trm").attr("data-cpro2", 0);
                        $("#btn-sat-trm").attr("data-csup", 0);
                        $("#btn-sat-trm").attr("data-cdate", 0);
                        $("#lst-tpro-trm").html("");
                        $("#lst-tsup-trm").html("");
                        $("#lst-tpro-cut").html("");
                        $("#lst-tdate-trm").html("");*/
                        $("#div-err-at-scs-1").removeClass("d-none");
                    }

                    $("#btn-sat-trm").prop("disabled", false);
                    $("#btn-sat-trm").html("Generate");
                },
                error : function(){
                    $("#btn-sat-trm").prop("disabled", false);
                    $("#btn-sat-trm").html("Generate");
                    swal("Error (AGTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function autoGenKrm()
{
    var lpro = [], lcus = [], tcus = "Y", ltgl = [], mpo = $("#nmbr-pofrm").val(), mxpo = $("#nmbr-poto").val(), sw = UnNumberFormat($("#txt-sw-krm").val()), cpro = $("#btn-sat-krm").attr("data-cpro"), csup = $("#btn-sat-krm").attr("data-csup"), ctgl = $("#btn-sat-krm").attr("data-cdate"), prsn = 0, kuser = $("#slct-user-krm").val(), dpdk = "N", tcus = "Y", lpo = [], cpo = $("#btn-sat-krm").attr("data-cpo"), pkrm = "Y", sstk = UnNumberFormat($("#txt-sstk").val()), kurs = UnNumberFormat($("#txt-kurs").val());

    if($("#chk-dpd-krm").is(":checked"))
        dpdk = "Y";

    if(!$("#div-err-at-krm-1").hasClass("d-none"))
        $("#div-err-at-krm-1").addClass("d-none");

    if(!$("#div-err-at-krm-2").hasClass("d-none"))
        $("#div-err-at-krm-2").addClass("d-none");

    if(!$("#div-err-at-krm-3").hasClass("d-none"))
        $("#div-err-at-krm-3").addClass("d-none");

    if(!$("#div-err-at-krm-4").hasClass("d-none"))
        $("#div-err-at-krm-4").addClass("d-none");

    if(!$("#div-err-at-krm-5").hasClass("d-none"))
        $("#div-err-at-krm-5").addClass("d-none");

    if(!$("#div-err-at-krm-6").hasClass("d-none"))
        $("#div-err-at-krm-6").addClass("d-none");

    if(!$("#div-err-at-krm-7").hasClass("d-none"))
        $("#div-err-at-krm-7").addClass("d-none");

    if(!$("#div-scs-at-krm-1").hasClass("d-none"))
        $("#div-scs-at-krm-1").addClass("d-none");

    if($("#rdo-pkrm-no").is(":checked"))
    {
        pkrm = "N";
        for(var i = 0; i < cpro; i++)
        {
            if($("#btn-dat-pro-krm-"+i).length === 0)
                continue;

            lpro.push([UD64($("#btn-dat-pro-krm-"+i).attr("data-value")), $("#nmbr-tpro-krm-"+i).val()]);
            prsn += parseFloat($("#nmbr-tpro-krm-"+i).val());
        }
    }

    if($("#rdo-acus-no").is(":checked"))
    {
        tcus = "N";
        for(var i = 0; i < ccus; i++)
        {
            if($("#btn-dat-cus-trm-"+i).length === 0)
                continue;

            lcus.push(UD64($("#btn-dat-cus-trm-"+i).attr("data-value")));
        }
    }

    for(var i = 0; i < ctgl; i++)
    {
        if($("#dte-tgl-at-krm-"+i).length === 0)
            continue;
        
        ltgl.push($("#dte-tgl-at-krm-"+i).val());
    }

    for(var i = 0; i < cpo; i++)
    {
        if($("#btn-dat-po-krm-"+i).length === 0)
            continue;

        lpo.push([UD64($("#btn-dat-po-krm-"+i).attr("data-value")), $("#dte-tpo-krm-"+i).val()]);
    }
    
    /*if(sw === "" || parseFloat(sw) == 0 || parseFloat(sw) < 0)
        $("#div-err-at-krm-1").removeClass("d-none");
    else*/ if(cpro === 0 || $("#lst-tpro-krm tr").length === 0 && $("#rdo-pkrm-no").is(":checked"))
        $("#div-err-at-krm-2").removeClass("d-none");
    else if(tcus === "N" && (ccus === 0 || $("#lst-tcus-krm tr").length === 0))
        $("#div-err-at-krm-3").removeClass("d-none");
    else if(ctgl === 0 || $("#lst-tdate-krm div").length === 0)
        $("#div-err-at-krm-4").removeClass("d-none");
    else if(prsn !== 100 && $("#rdo-pkrm-no").is(":checked"))
        $("#div-err-at-krm-5").removeClass("d-none");
    else if((cpo === 0 || $("#lst-tpo-krm tr").length === 0) && $("#rdo-pkrm-no").is(":checked"))
        $("#div-err-at-krm-6").removeClass("d-none");
    else
    {
        lpro = JSON.stringify(lpro);
        lcus = JSON.stringify(lcus);
        ltgl = JSON.stringify(ltgl);
        lpo = JSON.stringify(lpo);

        $("#btn-sat-krm").prop("disabled", true);
        $("#btn-sat-krm").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Generate");
        setTimeout(function(){
            $.ajax({
                url : "./bin/php/genatkrm.php",
                type : "post",
                data : {sw : sw, lpro : lpro, tcus : tcus, lcus : lcus, ltgl : ltgl, mpo : mpo, mxpo : mxpo, kuser : kuser, dpdk : dpdk, lpo : lpo, pkrm : pkrm, sstk : sstk, kurs : kurs},
                success : function(output){
                    var json = $.parseJSON(output);

                    if(parseInt(json.err[0]) === -1)
                        $("#div-err-at-krm-1").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -2)
                        $("#div-err-at-krm-2").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -3)
                        $("#div-err-at-krm-3").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -4)
                        $("#div-err-at-krm-4").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -5)
                        $("#div-err-at-krm-5").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -6)
                        $("#div-err-at-krm-6").removeClass("d-none");
                    else if(parseInt(json.err[0]) === -7)
                        $("#div-err-at-krm-7").removeClass("d-none");
                    else
                    {
                        /*$("#btn-sat-krm").attr("data-cpro", 0);
                        $("#btn-sat-krm").attr("data-ccus", 0);
                        $("#btn-sat-krm").attr("data-cdate", 0);
                        $("#lst-tpro-krm").html("");
                        $("#lst-tcus-krm").html("");
                        $("#lst-tdate-krm").html("");*/
                        $("#div-scs-at-krm-1").removeClass("d-none");
                    }

                    $("#btn-sat-krm").prop("disabled", false);
                    $("#btn-sat-krm").html("Generate");
                },
                error : function(){
                    $("#btn-sat-krm").prop("disabled", false);
                    $("#btn-sat-krm").html("Generate");
                    swal("Error (AGKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                },
            })
        }, 200);
    }
}

function importData()
{
    swal({
        title : "Perhatian !!!",
        icon : "warning",
        text : "Anda yakin import data ?",
        dangerMode : true,
        buttons : true,
    })
    .then((ok) => {
        if(ok)
        {
            Process();
            setTimeout(function(){
                $.ajax({
                    url : './bin/php/impdata.php',
                    success : function(output){
                        var json = $.parseJSON(output);
                        swal("Sukses !!!", "Import data berhasil...", "success");
                    },
                    error : function(){
                        swal("Error (IDT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
                    },
                })
            }, 200);
        }
    })
}