//TANDA TERIMA
function viewHTT(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthtt.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#id_bfr").text(json.dbfr[0]);
                $("#tgl_bfr").text(json.dbfr[1]);
                $("#sup_bfr").text(json.dbfr[2]);
                $("#bb_bfr").text(NumberFormat2(json.dbfr[3]));
                $("#poto_bfr").text(NumberFormat2(json.dbfr[4]));
                $("#ket_bfr").text(json.dbfr[5]);
                $("#ket2_bfr").text(json.dbfr[6]);
                $("#ket3_bfr").text(json.dbfr[7]);

                $("#lhst_bfr").html(setToTblVHTT(json));

                $("#id_afr").text(json.dafr[0]);
                $("#tgl_afr").text(json.dafr[1]);
                $("#sup_afr").text(json.dafr[2]);
                $("#bb_afr").text(NumberFormat2(json.dafr[3]));
                $("#poto_afr").text(NumberFormat2(json.dafr[4]));
                $("#ket_afr").text(json.dafr[5]);
                $("#ket2_afr").text(json.dafr[6]);
                $("#ket3_afr").text(json.dafr[7]);

                $("#lhst_afr").html(setToTblVHTT(json, 2));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHTT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHTT(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dbfr2[i][8]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][10]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][11]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][4])+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][12]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][13])+"</td>"+
                    "</tr>"
    }
    else
    {
        for(var i = 0; i < x.count[1]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][11]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][4])+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][12]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][13])+"</td>"+
                    "</tr>"
    }

    return hsl;
}

//PINJAMAN
function viewHPjm(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthpjm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#id_bfr").text(json.dbfr[0]);
                $("#tgl_bfr").text(json.dbfr[1]);
                $("#sup_bfr").text(json.dbfr[2]);
                $("#jlh_bfr").text(NumberFormat2(json.dbfr[3]));
                $("#ket1_bfr").text(json.dbfr[4]);
                $("#ket2_bfr").text(json.dbfr[5]);
                $("#ket3_bfr").text(json.dbfr[6]);

                $("#id_afr").text(json.dafr[0]);
                $("#tgl_afr").text(json.dafr[1]);
                $("#sup_afr").text(json.dafr[2]);
                $("#jlh_afr").text(NumberFormat2(json.dafr[3]));
                $("#ket1_afr").text(json.dafr[4]);
                $("#ket2_afr").text(json.dafr[5]);
                $("#ket3_afr").text(json.dafr[6]);

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHPJM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

//PENERIMAAN
function viewHTrm(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthtrm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#id_bfr").text(json.dbfr[0]);
                $("#tgl_bfr").text(json.dbfr[1]);
                $("#sup_bfr").text(json.dbfr[2]);
                $("#bb_bfr").text(NumberFormat2(json.dbfr[3]));
                $("#poto_bfr").text(NumberFormat2(json.dbfr[4]));
                $("#ket1_bfr").text(json.dbfr[5]);
                $("#ket2_bfr").text(json.dbfr[6]);
                $("#ket3_bfr").text(json.dbfr[7]);
                $("#kota_bfr").text(json.dbfr[10]);
                $("#dll_bfr").text(NumberFormat2(json.dbfr[11])+" ("+json.dbfr[12]+")");
                $("#dp_bfr").text(NumberFormat2(json.dbfr[13]));
                $("#pdll_bfr").text(NumberFormat2(json.dbfr[14]));
                $("#tdll_bfr").text(NumberFormat2(json.dbfr[15]));

                $("#lhst_bfr").html(setToTblVHTrm(json));

                $("#id_afr").text(json.dafr[0]);
                $("#tgl_afr").text(json.dafr[1]);
                $("#sup_afr").text(json.dafr[2]);
                $("#bb_afr").text(NumberFormat2(json.dafr[3]));
                $("#poto_afr").text(NumberFormat2(json.dafr[4]));
                $("#ket1_afr").text(json.dafr[5]);
                $("#ket2_afr").text(json.dafr[6]);
                $("#ket3_afr").text(json.dafr[7]);
                $("#kota_afr").text(json.dafr[10]);
                $("#dll_afr").text(NumberFormat2(json.dafr[11])+" ("+json.dafr[12]+")");
                $("#dp_afr").text(NumberFormat2(json.dafr[13]));
                $("#pdll_afr").text(NumberFormat2(json.dafr[14]));
                $("#tdll_afr").text(NumberFormat2(json.dafr[15]));

                $("#lhst_afr").html(setToTblVHTrm(json, 2));

                $("#id_pbd").html(json.dbfr[0]+" <b>-></b> "+json.dafr[0]);
                $("#tgl_pbd").html(json.dbfr[1]+" <b>-></b> "+json.dafr[1]);
                $("#sup_pbd").html(json.dbfr[2]+" <b>-></b> "+json.dafr[2]);
                $("#bb_pbd").html(NumberFormat2(json.dbfr[3])+" <b>-></b> "+NumberFormat2(json.dafr[3]));
                $("#poto_pbd").html(NumberFormat2(json.dbfr[4])+" <b>-></b> "+NumberFormat2(json.dafr[4]));
                $("#ket1_pbd").html(json.dbfr[5]+" <b>-></b> "+json.dafr[5]);
                $("#ket2_pbd").html(json.dbfr[6]+" <b>-></b> "+json.dafr[6]);
                $("#ket3_pbd").html(json.dbfr[7]+" <b>-></b> "+json.dafr[7]);
                $("#kota_pbd").html(json.dbfr[10]+" <b>-></b> "+json.dafr[10]);
                $("#dll_pbd").html(NumberFormat2(json.dbfr[11])+" ("+json.dbfr[12]+")"+" <b>-></b> "+NumberFormat2(json.dafr[11])+" ("+json.dafr[12]+")");
                $("#dp_pbd").html(NumberFormat2(json.dbfr[13])+" <b>-></b> "+NumberFormat2(json.dafr[13]));
                $("#pdll_pbd").html(NumberFormat2(json.dbfr[14])+" <b>-></b> "+NumberFormat2(json.dafr[14]));
                $("#tdll_pbd").html(NumberFormat2(json.dbfr[15])+" <b>-></b> "+NumberFormat2(json.dafr[15]));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHTRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHTrm(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dbfr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][8]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][10]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][11]+"</td>"+
                    "</tr>";
    }
    else
    {
        var hsl2 = "", parr = [];
        for(var i = 0; i < x.count[1]; i++)
        {
            var cek = false;
            for(var j = 0; j < x.count[0]; j++)
            {
                if(x.dafr2[i][2] === x.dbfr2[j][2] && x.dafr2[i][6] === x.dbfr2[j][6])
                {
                    cek = true;
                    break;
                }
            }

            if(!cek)
            {
                parr.push(x.dafr2[i][6]);
                hsl2 += "<tr>"+
                            "<td class=\"border\">"+x.dafr2[i][7]+"</td>"+
                            "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                            "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                            "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                            "<td class=\"border\">"+x.dafr2[i][11]+"</td>"+
                            "<td class=\"border\">Tambah</td>"+
                        "</tr>";
            }
            
            var cek = false;
            for(var j = 0; j < x.count[0]; j++)
            {
                if(x.dafr2[i][2] === x.dbfr2[j][2] && x.dafr2[i][3] === x.dbfr2[j][3] && x.dafr2[i][6] === x.dbfr2[j][6])
                {
                    cek = true;
                    break;
                }
            }

            if(!cek)
            {
                var cek2 = false;

                for(var k = 0; k < parr.length; k++)
                {
                    if(x.dafr2[i][6] === parr[k])
                    {
                        cek2 = true;
                        break;
                    }
                }

                if(!cek2)
                {
                    hsl2 += "<tr>"+
                                "<td class=\"border\">"+x.dafr2[i][7]+"</td>"+
                                "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                                "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                                "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                                "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                                "<td class=\"border\">"+x.dafr2[i][11]+"</td>"+
                                "<td class=\"border\">Ralat</td>"+
                            "</tr>";
                }
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dafr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][11]+"</td>"+
                    "</tr>";
        }

        for(var i = 0; i < x.count[0]; i++)
        {
            var cek = false;
            for(var j = 0; j < x.count[1]; j++)
            {
                if(x.dbfr2[i][2] === x.dafr2[j][2] && x.dbfr2[i][6] === x.dafr2[j][6])
                {
                    cek = true;
                    break;
                }
            }

            if(!cek)
                hsl2 += "<tr>"+
                            "<td class=\"border\">"+x.dbfr2[i][7]+"</td>"+
                            "<td class=\"border\">"+x.dbfr2[i][8]+"</td>"+
                            "<td class=\"border\">"+x.dbfr2[i][9]+"</td>"+
                            "<td class=\"border\">"+x.dbfr2[i][10]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                            "<td class=\"border\">"+x.dbfr2[i][11]+"</td>"+
                            "<td class=\"border\">Hapus</td>"+
                        "</tr>";
        }

        $("#lhst_pbd").html(hsl2);
    }

    return hsl;
}

//CUTTING
function viewHCut(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthcut.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output), tmrgn = "";

                if(json.dbfr[2] === "1")
                    tmrgn = "<";
                else if(json.dbfr[2] === "2")
                    tmrgn = ">";

                $("#tgl_bfr").text(json.dbfr[1]);
                $("#mrgn_bfr").text(tmrgn+" "+NumberFormat2(json.dbfr[3]));

                $("#lhst_bfr").html(setToTblVHCut(json));

                tmrgna = "";
                if(json.dafr[2] === "1")
                    tmrgna = "<";
                else if(json.dafr[2] === "2")
                    tmrgna = ">";

                $("#tgl_afr").text(json.dafr[1]);
                $("#mrgn_afr").text(tmrgna+" "+NumberFormat2(json.dafr[3]));

                $("#lhst_afr").html(setToTblVHCut(json, 2));

                $("#mdl-hview").modal("show");

                $("#tgl_pbd").html(json.dbfr[1]+" <b>-></b> "+json.dafr[1]);
                $("#mrgn_pbd").html(tmrgn+" "+NumberFormat2(json.dbfr[3])+" <b>-></b> "+tmrgna+" "+NumberFormat2(json.dafr[3]));

                swal.close();
            },
            error : function(){
                swal("Error (VHCUT) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHCut(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var g = ["", "", "", "", "", ""], npro = x.dbfr2[i][12]+" / "+x.dbfr2[i][13];

            if(x.dbfr2[i][14] !== ""){
                npro += " / "+x.dbfr2[i][14];
            }
            
            if(x.dbfr2[i][15] !== ""){
                npro += " / "+x.dbfr2[i][15];
            }

            for(var j = 4; j < 10; j++)
            {
                if(x.dbfr2[i][j] != 0)
                    g[j-4] = " ("+x.dbfr2[i][16+j-4]+")";
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dbfr2[i][22]+"</td>"+
                        "<td class=\"border\">"+npro+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][23]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][4])+g[0]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][5])+g[1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][6])+g[2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][7])+g[3]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][8])+g[4]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][9])+g[5]+"</td>"+
                    "</tr>";
        }
    }
    else
    {
        var hsl2 = "", parr = [];
        for(var i = 0; i < x.count[1]; i++)
        {
            var g = ["", "", "", "", "", ""], npro = x.dafr2[i][12]+" / "+x.dafr2[i][13];

            if(x.dafr2[i][14] !== ""){
                npro += " / "+x.dafr2[i][14];
            }
            
            if(x.dafr2[i][15] !== ""){
                npro += " / "+x.dafr2[i][15];
            }

            for(var j = 4; j < 10; j++)
            {
                if(x.dafr2[i][j] != 0)
                    g[j-4] = " ("+x.dafr2[i][16+j-4]+")";
            }

            var cek = false;
            for(var j = 0; j < x.count[0]; j++)
            {
                if(x.dafr2[i][2] === x.dbfr2[j][2] && x.dafr2[i][22] === x.dbfr2[j][22])
                {
                    cek = true;
                    break;
                }
            }

            if(!cek)
            {
                parr.push(x.dafr2[i][22]);
                hsl2 += "<tr>"+
                            "<td class=\"border\">"+x.dafr2[i][22]+"</td>"+
                            "<td class=\"border\">"+npro+"</td>"+
                            "<td class=\"border\">"+x.dafr2[i][23]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][4])+g[0]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][5])+g[1]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][6])+g[2]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][7])+g[3]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][8])+g[4]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][9])+g[5]+"</td>"+
                            "<td class=\"border\">Tambah</td>"+
                        "</tr>";
            }
            
            var cek = false;
            for(var j = 0; j < x.count[0]; j++)
            {
                if(x.dafr2[i][2] === x.dbfr2[j][2] && x.dafr2[i][3] === x.dbfr2[j][3] && x.dafr2[i][4] === x.dbfr2[j][4] && x.dafr2[i][5] === x.dbfr2[j][5] && x.dafr2[i][6] === x.dbfr2[j][6] && x.dafr2[i][7] === x.dbfr2[j][7] && x.dafr2[i][22] === x.dbfr2[j][22] && x.dafr2[i][16] === x.dbfr2[j][16] && x.dafr2[i][17] === x.dbfr2[j][17] && x.dafr2[i][18] === x.dbfr2[j][18] && x.dafr2[i][19] === x.dbfr2[j][19] && x.dafr2[i][20] === x.dbfr2[j][20] && x.dafr2[i][21] === x.dbfr2[j][21])
                {
                    cek = true;
                    break;
                }
            }

            if(!cek)
            {
                var cek2 = false;

                for(var k = 0; k < parr.length; k++)
                {
                    if(x.dafr2[i][22] === parr[k])
                    {
                        cek2 = true;
                        break;
                    }
                }

                if(!cek2)
                {
                    hsl2 += "<tr>"+
                                "<td class=\"border\">"+x.dafr2[i][22]+"</td>"+
                                "<td class=\"border\">"+npro+"</td>"+
                                "<td class=\"border\">"+x.dafr2[i][23]+"</td>"+
                                "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                                "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][4])+g[0]+"</td>"+
                                "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][5])+g[1]+"</td>"+
                                "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][6])+g[2]+"</td>"+
                                "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][7])+g[3]+"</td>"+
                                "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][8])+g[4]+"</td>"+
                                "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][9])+g[5]+"</td>"+
                                "<td class=\"border\">Ralat</td>"+
                            "</tr>";
                }
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dafr2[i][22]+"</td>"+
                        "<td class=\"border\">"+npro+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][23]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][4])+g[0]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][5])+g[1]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][6])+g[2]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][7])+g[3]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][8])+g[4]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][9])+g[5]+"</td>"+
                    "</tr>";
        }

        for(var i = 0; i < x.count[0]; i++)
        {
            var cek = false, npro = x.dbfr2[i][12]+" / "+x.dbfr2[i][13];

            if(x.dbfr2[i][14] !== ""){
                npro += " / "+x.dbfr2[i][14];
            }
            
            if(x.dbfr2[i][15] !== ""){
                npro += " / "+x.dbfr2[i][15];
            }
            for(var j = 0; j < x.count[1]; j++)
            {
                if(x.dbfr2[i][2] === x.dafr2[j][2] && x.dbfr2[i][22] === x.dafr2[j][22])
                {
                    cek = true;
                    break;
                }
            }

            if(!cek)
                hsl2 += "<tr>"+
                            "<td class=\"border\">"+x.dbfr2[i][22]+"</td>"+
                            "<td class=\"border\">"+npro+"</td>"+
                            "<td class=\"border\">"+x.dbfr2[i][23]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][4])+g[0]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][5])+g[1]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][6])+g[2]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][7])+g[3]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][8])+g[4]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][9])+g[5]+"</td>"+
                            "<td class=\"border\">Hapus</td>"+
                        "</tr>";
        }

        $("#lhst_pbd").html(hsl2);
    }

    return hsl;
}

//VACUUM
function viewHVac(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthvac.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output), tmrgn = "";

                if(json.dbfr[3] === "1")
                    tmrgn = "<";
                else if(json.dbfr[3] === "2")
                    tmrgn = ">";

                $("#tgl_bfr").text(json.dbfr[1]);
                $("#ctgl_bfr").text(json.dbfr[2]);
                $("#pro_bfr").html(json.dbfr[7]);
                $("#kate_bfr").text(json.dbfr[8]);
                $("#skate_bfr").text(json.dbfr[9]);
                $("#brt_bfr").text(NumberFormat2(json.dbfr[10]));
                $("#mrgn_bfr").text(tmrgn+" "+NumberFormat2(json.dbfr[4]));

                $("#lhst_bfr").html(setToTblVHVac(json));

                tmrgna = "";
                if(json.dafr[3] === "1")
                    tmrgna = "<";
                else if(json.dafr[3] === "2")
                    tmrgna = ">";

                $("#tgl_afr").text(json.dafr[1]);
                $("#ctgl_afr").text(json.dafr[2]);
                $("#pro_afr").html(json.dafr[7]);
                $("#kate_afr").text(json.dafr[8]);
                $("#skate_afr").text(json.dafr[9]);
                $("#brt_afr").text(NumberFormat2(json.dafr[10]));
                $("#mrgn_afr").text(tmrgna+" "+NumberFormat2(json.dafr[4]));

                $("#lhst_afr").html(setToTblVHVac(json, 2));

                $("#tgl_pbd").html(json.dbfr[1]+" <b>-></b> "+json.dafr[1]);
                $("#ctgl_pbd").html(json.dbfr[2]+" <b>-></b> "+json.dafr[2]);
                $("#pro_pbd").html(json.dbfr[7]+" <b>-></b> "+json.dafr[7]);
                $("#kate_pbd").html(json.dbfr[8]+" <b>-></b> "+json.dafr[8]);
                $("#skate_pbd").html(json.dbfr[9]+" <b>-></b> "+json.dafr[9]);
                $("#brt_pbd").html(NumberFormat2(json.dbfr[10])+" <b>-></b> "+NumberFormat2(json.dafr[10]));
                $("#mrgn_pbd").html(tmrgn+" "+NumberFormat2(json.dbfr[4])+" <b>-></b> "+tmrgna+" "+NumberFormat2(json.dafr[4]));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHVAC) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHVac(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dbfr2[i][6]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][8]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][10]+"</td>"+
                    "</tr>";
    }
    else
    {
        var hsl2 = "", parr = [];
        for(var i = 0; i < x.count[1]; i++)
        {
            var cek = false;
            for(var j = 0; j < x.count[0]; j++)
            {
                if(x.dafr2[i][2] === x.dbfr2[j][2] && x.dafr2[i][5] === x.dbfr2[j][5])
                {
                    cek = true;
                    break;
                }
            }

            if(!cek)
            {
                parr.push(x.dafr2[i][5]);
                hsl2 += "<tr>"+
                            "<td class=\"border\">"+x.dafr2[i][6]+"</td>"+
                            "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                            "<td class=\"border\">"+x.dafr2[i][7]+"</td>"+
                            "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                            "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                            "<td class=\"border\">Tambah</td>"+
                        "</tr>";
            }
            
            var cek = false;
            for(var j = 0; j < x.count[0]; j++)
            {
                if(x.dafr2[i][2] === x.dbfr2[j][2] && x.dafr2[i][3] === x.dbfr2[j][3] && x.dafr2[i][5] === x.dbfr2[j][5])
                {
                    cek = true;
                    break;
                }
            }

            if(!cek)
            {
                var cek2 = false;

                for(var k = 0; k < parr.length; k++)
                {
                    if(x.dafr2[i][5] === parr[k])
                    {
                        cek2 = true;
                        break;
                    }
                }

                if(!cek2)
                {
                    hsl2 += "<tr>"+
                                "<td class=\"border\">"+x.dafr2[i][6]+"</td>"+
                                "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                                "<td class=\"border\">"+x.dafr2[i][7]+"</td>"+
                                "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                                "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                                "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                                "<td class=\"border\">Ralat</td>"+
                            "</tr>";
                }
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dafr2[i][6]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                    "</tr>";
        }

        for(var i = 0; i < x.count[0]; i++)
        {
            var cek = false;
            for(var j = 0; j < x.count[1]; j++)
            {
                if(x.dbfr2[i][2] === x.dafr2[j][2] && x.dbfr2[i][5] === x.dafr2[j][5])
                {
                    cek = true;
                    break;
                }
            }

            if(!cek)
                hsl2 += "<tr>"+
                            "<td class=\"border\">"+x.dbfr2[i][6]+"</td>"+
                            "<td class=\"border\">"+x.dbfr2[i][9]+"</td>"+
                            "<td class=\"border\">"+x.dbfr2[i][7]+"</td>"+
                            "<td class=\"border\">"+x.dbfr2[i][8]+"</td>"+
                            "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                            "<td class=\"border\">"+x.dbfr2[i][10]+"</td>"+
                            "<td class=\"border\">Hapus</td>"+
                        "</tr>";
        }

        $("#lhst_pbd").html(hsl2);
    }

    return hsl;
}

//SAWING
function viewHSaw(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthsaw.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output), tmrgn = "";

                if(json.dbfr[2] === "1")
                    tmrgn = "<";
                else if(json.dbfr[2] === "2")
                    tmrgn = ">";

                $("#tgl_bfr").text(json.dbfr[1]);
                $("#pro_bfr").text(json.dbfr[6]);
                $("#kate_bfr").text(json.dbfr[7]);
                $("#skate_bfr").text(json.dbfr[8]);
                $("#brt_bfr").text(NumberFormat2(json.dbfr[9]));

                if(json.dbfr[16] == 0 || json.dbfr[16] != null)
                    $("#thp_bfr").text("");
                else
                    $("#thp_bfr").text(json.dbfr[16]);

                $("#mrgn_bfr").text(tmrgn+" "+NumberFormat2(json.dbfr[3]));

                $("#lhst_bfr").html(setToTblVHSaw(json));

                tmrgn = "";
                if(json.dafr[2] === "1")
                    tmrgn = "<";
                else if(json.dafr[2] === "2")
                    tmrgn = ">";

                $("#tgl_afr").text(json.dafr[1]);
                $("#pro_afr").text(json.dafr[6]);
                $("#kate_afr").text(json.dafr[7]);
                $("#skate_afr").text(json.dafr[8]);
                $("#brt_afr").text(NumberFormat2(json.dafr[9]));

                if(json.dafr[16] == 0 || json.dafr[16] != null)
                    $("#thp_afr").text("");
                else
                    $("#thp_afr").text(json.dafr[16]);

                $("#mrgn_afr").text(tmrgn+" "+NumberFormat2(json.dafr[3]));

                $("#lhst_afr").html(setToTblVHSaw(json, 2));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHSAW) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHSaw(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dbfr2[i][6]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][8]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                    "</tr>"
    }
    else
    {
        for(var i = 0; i < x.count[1]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dafr2[i][6]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                    "</tr>"
    }

    return hsl;
}

//RE-PACKAGING
function viewHRPkg(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthrpkg.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);
                
                var nma = json.dbfr[2]+" / "+json.dbfr[3];
                if(json.dbfr[4] !== ""){
                    nma += " / "+json.dbfr[4];
                }
                
                if(json.dbfr[5] !== ""){
                    nma += " / "+json.dbfr[5];
                }

                $("#id_bfr").text(json.dbfr[0]);
                $("#tgl_bfr").text(json.dbfr[1]);
                $("#pro_bfr").text(nma);
                $("#weight_bfr").text(NumberFormat2(json.dbfr[6]));

                $("#lhst_bfr").html(setToTblVHRPkg(json));
                
                var nma = json.dafr[2]+" / "+json.dafr[3];
                if(json.dafr[4] !== ""){
                    nma += " / "+json.dafr[4];
                }
                
                if(json.dafr[5] !== ""){
                    nma += " / "+json.dafr[5];
                }

                $("#id_afr").text(json.dafr[0]);
                $("#tgl_afr").text(json.dafr[1]);
                $("#pro_afr").text(nma);
                $("#weight_afr").text(NumberFormat2(json.dafr[6]));

                $("#lhst_afr").html(setToTblVHRPkg(json, 2));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHRPKG) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHRPkg(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++){
            var nma = x.dbfr2[i][1]+" / "+x.dbfr2[i][2];

            if(x.dbfr2[i][3] !== ""){
                nma += " / "+x.dbfr2[i][3];
            }

            if(x.dbfr2[i][4] !== ""){
                nma += " / "+x.dbfr2[i][4];
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+nma+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][5])+"</td>"+
                    "</tr>";
        }
    }
    else
    {
        for(var i = 0; i < x.count[1]; i++){
            var nma = x.dafr2[i][1]+" / "+x.dafr2[i][2];

            if(x.dafr2[i][3] !== ""){
                nma += " / "+x.dafr2[i][3];
            }

            if(x.dafr2[i][4] !== ""){
                nma += " / "+x.dafr2[i][4];
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+nma+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][5])+"</td>"+
                    "</tr>";
        }
    }

    return hsl;
}

//PACKAGING
function viewHKrm(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthkrm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);
                
                $("#id_bfr").text(json.dbfr[0]);
                $("#tgl_bfr").text(json.dbfr[1]);
                $("#ket1_bfr").text(json.dbfr[2]);
                $("#ket2_bfr").text(json.dbfr[3]);
                $("#ket3_bfr").text(json.dbfr[4]);

                $("#lhst_bfr").html(setToTblVHKrm(json));

                $("#id_afr").text(json.dafr[0]);
                $("#tgl_afr").text(json.dafr[1]);
                $("#ket1_afr").text(json.dafr[2]);
                $("#ket2_afr").text(json.dafr[3]);
                $("#ket3_afr").text(json.dafr[4]);

                $("#lhst_afr").html(setToTblVHKrm(json, 2));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHKrm(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++){
            var pro = x.dbfr2[i][6]+" / "+x.dbfr2[i][7];

            if(x.dbfr2[i][8] !== ""){
                pro += " / "+x.dbfr2[i][8];
            }

            if(x.dbfr2[i][9] !== ""){
                pro += " / "+x.dbfr2[i][9];
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dbfr2[i][10]+"</td>"+
                        "<td class=\"border\">"+pro+"</td>"+
                        "<td class=\"border\">"+NumberFormat2(x.dbfr2[i][11])+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][15]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][14]+"</td>"+
                    "</tr>";
        }
    }
    else
    {
        for(var i = 0; i < x.count[1]; i++){
            var pro = x.dafr2[i][6]+" / "+x.dafr2[i][7];

            if(x.dafr2[i][8] !== ""){
                pro += " / "+x.dafr2[i][8];
            }

            if(x.dafr2[i][9] !== ""){
                pro += " / "+x.dafr2[i][9];
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                        "<td class=\"border\">"+pro+"</td>"+
                        "<td class=\"border\">"+NumberFormat2(x.dafr2[i][11])+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][15]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][14]+"</td>"+
                    "</tr>";
        }
    }

    return hsl;
}

//PENARIKAN
function viewHWd(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthwd.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#id_bfr").text(json.dbfr[0]);
                $("#tgl_bfr").text(json.dbfr[1]);
                $("#sup_bfr").text(json.dbfr[2]);
                $("#jlh_bfr").text(NumberFormat2(json.dbfr[3]));
                $("#ket_bfr").text(json.dbfr[4]);
                $("#ket2_bfr").text(json.dbfr[5]);
                $("#ket3_bfr").text(json.dbfr[6]);

                $("#id_afr").text(json.dafr[0]);
                $("#tgl_afr").text(json.dafr[1]);
                $("#sup_afr").text(json.dafr[2]);
                $("#jlh_afr").text(NumberFormat2(json.dafr[3]));
                $("#ket_afr").text(json.dafr[4]);
                $("#ket2_afr").text(json.dafr[5]);
                $("#ket3_afr").text(json.dafr[6]);

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHWD) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

//MASUK PRODUK
function viewHMP(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthmp.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#tgl_bfr").text(json.dbfr[1]);

                $("#lhst_bfr").html(setToTblVHMP(json));

                $("#tgl_afr").text(json.dafr[1]);

                $("#lhst_afr").html(setToTblVHMP(json, 2));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHMP) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHMP(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dbfr2[i][6]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][8]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][10]+"</td>"+
                    "</tr>"
    }
    else
    {
        for(var i = 0; i < x.count[1]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dafr2[i][6]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                    "</tr>"
    }

    return hsl;
}

//FREEZING
function viewHFrz(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthfrz.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#tgl_bfr").text(json.dbfr[1]);

                $("#lhst_bfr").html(setToTblVHFrz(json));

                $("#tgl_afr").text(json.dafr[1]);

                $("#lhst_afr").html(setToTblVHFrz(json, 2));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHFRZ) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHFrz(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var dri = x.dbfr2[i][6];

            if(x.dbfr2[i][9] !== "" && x.dbfr2[i][9] !== null)
                dri += " / "+x.dbfr2[i][9];

            if(x.dbfr2[i][7] !== "" && x.dbfr2[i][7] !== null)
                dri += " / "+x.dbfr2[i][7];

            if(x.dbfr2[i][8] !== "" && x.dbfr2[i][8] !== null)
                dri += " / "+x.dbfr2[i][8];

            dri += " / "+NumberFormat2(x.dbfr2[i][3])+" / "+x.dbfr2[i][13]+" / "+x.dbfr2[i][11]+" / "+x.dbfr2[i][12];

            if(x.dbfr2[i][10] !== "" && x.dbfr2[i][10] !== null)
                dri += " - "+x.dbfr2[i][10];

            var fhsl = x.dbfr2[i][15];

            if(x.dbfr2[i][18] !== "" && x.dbfr2[i][18] !== null)
                fhsl += " / "+x.dbfr2[i][18];

            if(x.dbfr2[i][16] !== "" && x.dbfr2[i][16] !== null)
                fhsl += " / "+x.dbfr2[i][16];

            if(x.dbfr2[i][17] !== "" && x.dbfr2[i][17] !== null)
                fhsl += " / "+x.dbfr2[i][17];

            fhsl += " / "+NumberFormat2(x.dbfr2[i][3]);

            hsl += "<tr>"+
                        "<td class=\"border\">"+dri+"</td>"+
                        "<td class=\"border\">"+fhsl+"</td>"+
                    "</tr>";
        }
    }
    else
    {
        for(var i = 0; i < x.count[1]; i++)
        {
            var dri = x.dafr2[i][6];

            if(x.dafr2[i][9] !== "" && x.dafr2[i][9] !== null)
                dri += " / "+x.dafr2[i][9];

            if(x.dafr2[i][7] !== "" && x.dafr2[i][7] !== null)
                dri += " / "+x.dafr2[i][7];

            if(x.dafr2[i][8] !== "" && x.dafr2[i][8] !== null)
                dri += " / "+x.dafr2[i][8];

            dri += " / "+NumberFormat2(x.dafr2[i][3])+" / "+x.dafr2[i][13]+" / "+x.dafr2[i][11]+" / "+x.dafr2[i][12];

            if(x.dafr2[i][10] !== "" && x.dafr2[i][10] !== null)
                dri += " - "+x.dafr2[i][10];

            var fhsl = x.dafr2[i][15];

            if(x.dafr2[i][18] !== "" && x.dafr2[i][18] !== null)
                fhsl += " / "+x.dafr2[i][18];

            if(x.dafr2[i][16] !== "" && x.dafr2[i][16] !== null)
                fhsl += " / "+x.dafr2[i][16];

            if(x.dafr2[i][17] !== "" && x.dafr2[i][17] !== null)
                fhsl += " / "+x.dafr2[i][17];

            fhsl += " / "+NumberFormat2(x.dafr2[i][3]);

            hsl += "<tr>"+
                        "<td class=\"border\">"+dri+"</td>"+
                        "<td class=\"border\">"+fhsl+"</td>"+
                    "</tr>";
        }
    }

    return hsl;
}

//RETUR KIRIM
function viewHRKrm(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthrkrm.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#tgl_bfr").text(json.dbfr[0]);
                $("#id_bfr").text(json.dbfr[1]);
                $("#cus_bfr").text(json.dbfr[2]);
                $("#po_bfr").text(json.dbfr[3]);
                $("#ket_bfr").text(json.dbfr[4]);

                $("#lhst_bfr").html(setToTblVHRKrm(json));

                $("#tgl_afr").text(json.dafr[0]);
                $("#id_afr").text(json.dafr[1]);
                $("#cus_afr").text(json.dafr[2]);
                $("#po_afr").text(json.dafr[3]);
                $("#ket_afr").text(json.dafr[4]);


                $("#lhst_afr").html(setToTblVHRKrm(json, 2));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHRKRM) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHRKrm(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++)
        {
            var pro = x.dbfr2[i][0]+" / "+x.dbfr2[i][1];

            if(x.dbfr2[i][2] !== "" && x.dbfr2[i][2] !== null)
                pro += " / "+x.dbfr2[i][2];

            if(x.dbfr2[i][3] !== "" && x.dbfr2[i][3] !== null)
                pro += " / "+x.dbfr2[i][3];

            hsl += "<tr>"+
                        "<td class=\"border\">"+pro+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][4])+"</td>"+
                    "</tr>";
        }
    }
    else
    {
        for(var i = 0; i < x.count[1]; i++)
        {
            var pro = x.dafr2[i][0]+" / "+x.dafr2[i][1];

            if(x.dafr2[i][2] !== "" && x.dafr2[i][2] !== null)
                pro += " / "+x.dafr2[i][2];

            if(x.dafr2[i][3] !== "" && x.dafr2[i][3] !== null)
                pro += " / "+x.dafr2[i][3];

            hsl += "<tr>"+
                        "<td class=\"border\">"+pro+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][4])+"</td>"+
                    "</tr>";
        }
    }

    return hsl;
}

//PENYESUAN STOK
function viewHPs(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthps.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#tgl_bfr").text(json.dbfr[2]);

                $("#lhst_bfr").html(setToTblVHPs(json));

                $("#tgl_afr").text(json.dafr[2]);

                $("#lhst_afr").html(setToTblVHPs(json, 2));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHPS) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHPs(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dbfr2[i][6]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][8]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][10]+"</td>"+
                    "</tr>"
    }
    else
    {
        for(var i = 0; i < x.count[1]; i++)
            hsl += "<tr>"+
                        "<td class=\"border\">"+x.dafr2[i][6]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][7]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][8]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][3])+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                    "</tr>"
    }

    return hsl;
}

//PINDAH STOK
function viewHMove(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthmv.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#tgl_bfr").text(json.dbfr[0]);
                $("#frm_bfr").text(json.dbfr[2]);
                $("#to_bfr").text(json.dbfr[3]);
                $("#tipe_bfr").text(json.dbfr[4]);
                $("#to_bfr").text(json.dbfr[6]);
                $("#ket_bfr").text(json.dbfr[5]);

                $("#lhst_bfr").html(setToTblVHMove(json));

                $("#tgl_afr").text(json.dafr[0]);
                $("#frm_afr").text(json.dafr[2]);
                $("#to_afr").text(json.dafr[3]);
                $("#tipe_afr").text(json.dafr[4]);
                $("#to_afr").text(json.dafr[6]);
                $("#ket_afr").text(json.dafr[5]);

                $("#lhst_afr").html(setToTblVHMove(json, 2));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHMV) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}

function setToTblVHMove(x, y = 1)
{
    var hsl = "";

    if(y === 1)
    {
        for(var i = 0; i < x.count[0]; i++){
            var nma = x.dbfr2[i][5]+" / "+x.dbfr2[i][6];

            if(x.dbfr2[i][7] !== ""){
                nma += " / "+x.dbfr2[i][7];
            }

            if(x.dbfr2[i][8] !== ""){
                nma += " / "+x.dbfr2[i][8];
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+nma+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][3]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][10]+"</td>"+
                        "<td class=\"border\">"+x.dbfr2[i][11]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dbfr2[i][2])+"</td>"+
                    "</tr>";
        }
    }
    else
    {
        for(var i = 0; i < x.count[1]; i++){
            var nma = x.dafr2[i][5]+" / "+x.dafr2[i][6];

            if(x.dafr2[i][7] !== ""){
                nma += " / "+x.dafr2[i][7];
            }

            if(x.dafr2[i][8] !== ""){
                nma += " / "+x.dafr2[i][8];
            }

            hsl += "<tr>"+
                        "<td class=\"border\">"+nma+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][3]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][9]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][10]+"</td>"+
                        "<td class=\"border\">"+x.dafr2[i][11]+"</td>"+
                        "<td class=\"border text-right\">"+NumberFormat2(x.dafr2[i][2])+"</td>"+
                    "</tr>";
        }
    }

    return hsl;
}

//BB
function viewHBB(x)
{
    Process();
    setTimeout(function(){
        $.ajax({
            url : "./bin/php/gdthbb.php",
            type : "post",
            data : {id : x},
            success : function(output){
                var json = $.parseJSON(output);

                $("#id_bfr").text(json.dbfr[0]);
                $("#tgl_bfr").text(json.dbfr[1]);
                $("#jns_bfr").text(json.dbfr[4]);
                $("#ket_bfr").text(json.dbfr[3]);
                $("#jlh_bfr").text(NumberFormat2(json.dbfr[2]));

                $("#id_afr").text(json.dafr[0]);
                $("#tgl_afr").text(json.dafr[1]);
                $("#jns_afr").text(json.dafr[4]);
                $("#ket_afr").text(json.dafr[3]);
                $("#jlh_afr").text(NumberFormat2(json.dafr[2]));

                $("#mdl-hview").modal("show");

                swal.close();
            },
            error : function(){
                swal("Error (VHBB) !!!", "Tidak dapat terhubung ke server, harap coba beberapa saat lagi !!!", "error");
            },
        })
    }, 200);
}