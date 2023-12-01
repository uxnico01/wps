var dates, datesc1, datesc2, datesc3, datesc4, datesc5, chart1, chart2, chart3, chart4, dchart1, dchart2, dchart3, dchart4, dchart5, lview, data_sup, data_pro, ndata_sup, ndata_pro;

$(function(){
    $(document).ready(function(){
        Login();
        EntrFrm("",".inp-tbl");
        EntrFrm("",".inp-ctbl");
        EntrFrm("",".inp-ktbl");
        
        EntrFrm("#btn-lgn",".inp-set");
        MdlFocus("#mdl-cpass", "#txt-bpass");
        EntrFrm("#btn-scpass",".inp-set");
        
        MdlFocus("#mdl-npro", "#txt-id-pro");
        MdlFocus("#mdl-epro", "#edt-txt-id");
        EntrFrm("#btn-snpro",".inp-set");
        EntrFrm("#btn-sepro",".inp-set");
        
        MdlFocus("#mdl-ngol", "#txt-id-gol");
        MdlFocus("#mdl-egol", "#edt-txt-id");
        EntrFrm("#btn-sngol",".inp-set");
        EntrFrm("#btn-segol",".inp-set");
        
        MdlFocus("#mdl-nkate", "#txt-id-kate");
        MdlFocus("#mdl-ekate", "#edt-txt-id");
        MdlFocus("#mdl-lpro-kate", "#txt-srch-pro-kate");
        MdlFocus("#mdl-lskate-kate", "#txt-srch-skate-kate");
        EntrFrm("#btn-snkate",".inp-set");
        EntrFrm("#btn-sekate",".inp-set");
        
        MdlFocus("#mdl-nkates", "#txt-id-kates");
        MdlFocus("#mdl-ekates", "#edt-txt-id");
        EntrFrm("#btn-snkates",".inp-set");
        EntrFrm("#btn-sekates",".inp-set");
        
        MdlFocus("#mdl-nskate", "#txt-id-skate");
        MdlFocus("#mdl-eskate", "#edt-txt-id");
        MdlFocus("#mdl-lpro-skate", "#txt-srch-pro-skate");
        EntrFrm("#btn-snskate",".inp-set");
        EntrFrm("#btn-seskate",".inp-set");
        
        MdlFocus("#mdl-ngrade", "#txt-id-grade");
        MdlFocus("#mdl-egrade", "#edt-txt-id");
        MdlFocus("#mdl-lpro-grade", "#txt-srch-pro-grade");
        EntrFrm("#btn-sngrade",".inp-set");
        EntrFrm("#btn-segrade",".inp-set");
        
        MdlFocus("#mdl-nsatuan", "#txt-id-satuan");
        MdlFocus("#mdl-esatuan", "#edt-txt-id");
        EntrFrm("#btn-snsatuan",".inp-set");
        EntrFrm("#btn-sesatuan",".inp-set");
        
        MdlFocus("#mdl-ncus", "#txt-id-cus");
        MdlFocus("#mdl-ecus", "#edt-txt-id");
        EntrFrm("#btn-sncus",".inp-set");
        EntrFrm("#btn-secus",".inp-set");
        
        MdlFocus("#mdl-nsup", "#txt-id-sup");
        MdlFocus("#mdl-esup", "#edt-txt-id");
        EntrFrm("#btn-snsup",".inp-set");
        EntrFrm("#btn-sesup",".inp-set");
        
        MdlFocus("#mdl-npo", "#txt-id-po");
        MdlFocus("#mdl-epo", "#edt-txt-id");
        EntrFrm("#btn-snpo",".inp-set");
        EntrFrm("#btn-sepo",".inp-set");
        
        MdlFocus("#mdl-nuser", "#txt-user");
        MdlFocus("#mdl-euser", "#edt-txt-user");
        EntrFrm("#btn-snuser",".inp-set");
        EntrFrm("#btn-seuser",".inp-set");
        
        MdlFocus("#mdl-ngdg", "#txt-id-gdg");
        MdlFocus("#mdl-egdg", "#edt-txt-id");
        EntrFrm("#btn-sngdg",".inp-set");
        EntrFrm("#btn-segdg",".inp-set");
        
        MdlFocus("#mdl-hst-trkrm", "#dte-frm-trkrm");
        MdlFocus("#mdl-hst-trtt", "#dte-frm-trtt");
        MdlFocus("#mdl-hst-trpjm", "#dte-frm-trpjm");
        MdlFocus("#mdl-hst-prtt", "#dte-frm-prtt");
        MdlFocus("#mdl-hst-prcut", "#dte-frm-prcut");
        MdlFocus("#mdl-hst-prvac", "#dte-frm-prvac");
        MdlFocus("#mdl-hst-prsaw", "#dte-frm-prsaw");
        
        MdlFocus("#mdl-spo2", "#txt-srch-spo2");
        MdlFocus("#mdl-scus", "#txt-srch-scus");
        MdlFocus("#mdl-scus2", "#txt-srch-scus2");
        //MdlFocus("#mdl-ssup", "#txt-srch-ssup");
        MdlFocus("#mdl-ssup2", "#txt-srch-ssup2");
        //MdlFocus("#mdl-spro", "#txt-srch-spro");
        //MdlFocus("#mdl-spro2", "#txt-srch-spro2");
        //MdlFocus("#mdl-spro3", "#txt-srch-spro3");
        MdlFocus("#mdl-spro4", "#txt-srch-spro4");
        MdlFocus("#mdl-skate", "#txt-srch-sskate");
        MdlFocus("#mdl-sskate", "#txt-srch-ssskate");
        MdlFocus("#mdl-rbsaw", "#txt-vblc");
        MdlFocus("#mdl-suser", "#txt-srch-suser");
        
        MdlFocus("#mdl-ntrm", "#txt-id");
        MdlFocus("#mdl-etrm", "#edt-txt-id");
        MdlFocus("#mdl-strm", "#txt-srch-strm");
        MdlFocus("#mdl-strm2", "#txt-srch-strm-itm");
        EntrFrm("#btn-npnrm-pro",".inp-set");
        MdlFocus("#mdl-vdll", "#txt-kdll");

        MdlFocus("#mdl-ncut", "#dte-tgl");
        MdlFocus("#mdl-ecut", "#edt-dte-tgl");

        MdlFocus("#mdl-nvac", "#dte-tgl");
        MdlFocus("#mdl-evac", "#edt-dte-tgl");

        MdlFocus("#mdl-npjm", "#txt-id");
        MdlFocus("#mdl-epjm", "#edt-txt-id");
        EntrFrm("#btn-snpjm",".inp-set");
        EntrFrm("#btn-sepjm",".inp-set");
        
        MdlFocus("#mdl-nkrm", "#txt-id");
        MdlFocus("#mdl-ekrm", "#edt-txt-id");
        MdlFocus("#mdl-skrm", "#txt-srch-skrm");
        MdlFocus("#mdl-skrm2", "#txt-srch-skrm-itm");
        EntrFrm("#btn-snkrm-pro",".inp-set");
        
        MdlFocus("#mdl-nwd", "#txt-id");
        MdlFocus("#mdl-ewd", "#edt-txt-id");
        EntrFrm("#btn-snwd",".inp-set");
        EntrFrm("#btn-sewd",".inp-set");

        MdlFocus("#mdl-nbb", "#dte-tgl");
        MdlFocus("#mdl-ebb", "#edt-dte-tgl");
        EntrFrm("#btn-snbb",".inp-set");
        EntrFrm("#btn-sebb",".inp-set");
        
        FormatUang(".cformat");
        
        ToExcel("#btn-pcut-xl", "#tbl-data", "Laporan Hasil Cutting");
        ToExcel("#btn-pro-xl", "#tbl-data", "Laporan Produk");
        ToExcel("#btn-cus-xl", "#tbl-data", "Laporan Customer");
        ToExcel("#btn-sup-xl", "#tbl-data", "Laporan Supplier");
        ToExcel("#btn-po-xl", "#tbl-data", "Laporan P/O");
        ToExcel("#btn-trm-xl", "#tbl-data", "Laporan Penerimaan");
        ToExcel("#btn-cut-xl", "#tbl-data", "Laporan Cutting");
        ToExcel("#btn-vac-xl", "#tbl-data", "Laporan Vacuum");
        ToExcel("#btn-saw-xl", "#tbl-data", "Laporan Sawing");
        ToExcel("#btn-krm-xl", "#tbl-data", "Laporan Pengiriman");
        ToExcel("#btn-smpn-xl", "#tbl-data", "Laporan Simpanan");
        ToExcel("#btn-pjm-xl", "#tbl-data", "Laporan Pinjaman");
        ToExcel("#btn-bb-xl", "#tbl-data", "Laporan BB");
        ToExcel("#btn-mp-xl", "#tbl-data", "Laporan Masuk Produk");
        ToExcel("#btn-ps-xl", "#tbl-data", "Laporan Penyesuaian Stok");
        ToExcel("#btn-rpkg-xl", "#tbl-data", "Laporan Re-Packaging");
        ToExcel("#btn-mv-xl", "#tbl-data", "Laporan Pindah Stok");
        ToExcel("#btn-rkrm-xl", "#tbl-data", "Laporan Retur Kirim");

        $(".table-data").DataTable({
            dom: 'rtip',
            scrollY: '48vh',
            scrollX: true,
            pageLength : 30,
            ordering : false,
            autoWidth: false,
        });

        $(".table-data2").DataTable({
            dom: 'rtip',
            scrollY: '48vh',
            scrollX: true,
            pageLength : 30,
            ordering : false,
            autoWidth: false,
        });

        $(".dataTables_paginate.paging_simple_numbers").addClass("small").addClass("pr-2");
        $(".dataTables_info").addClass("pl-2").addClass("small");
        $(".dataTables_scrollHeadInner").addClass("w-100");
        
        if($("#chart").length > 0)
        {
            var ctx = document.getElementById("chart"), ctx2 = document.getElementById("chart2"), ctx3 = document.getElementById("chart3"), ctx4 = document.getElementById("chart4"), ctx5 = document.getElementById("chart5");

            chart1 = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: datesc1,
                    datasets: [{
                        label: 'Penerimaan',
                        data: dchart1,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    }]
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

            chart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: datesc2,
                    datasets: [{
                        label: 'Cutting',
                        data: dchart2,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    }]
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

            chart3 = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: datesc3,
                    datasets: [{
                        label: 'Vacuum',
                        data: dchart3,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    }]
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

            chart4 = new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: datesc4,
                    datasets: [{
                        label: 'Sawing',
                        data: dchart4,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    }]
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

            chart5 = new Chart(ctx5, {
                type: 'bar',
                data: {
                    labels: datesc5,
                    datasets: [{
                        label: 'Packaging',
                        data: dchart5,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    }]
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
        }

        $("#slct-sdb").change(function(){
            chgDB();
        });
        
        $(".hdn-date").datepicker({
            showOn: "button",
            buttonText: "Pilih Tgl",
            buttonImage: "./bin/img/icon/calender-icon.png",
            buttonImageOnly: false,
            dateFormat: 'dd/mm/yy',
        });

        $(".hdn-date").change(function(){
            $(".txt-srch").val($(this).val());
        })

        $("#btn-scpass").click(function(){
            chgPass();
        });
        
        $("#btn-verif").click(function(){
            GetVerif();
        });
        
        $(function(){
            $('[data-toggle="popover"]').popover();
        });
        
        $(".mdl-cls").click(function(){
            setTimeout(function(){
                $(this).removeAttr("data-target");
                $(this).removeAttr("data-toggle");
            }, 1000);
        });
        
        $(".vpass").click(function(){
            ViewPass(this);
        });
        
        $(".popover-dismiss").popover({
            trigger: 'focus'
        });
        
        $("#btn-reld").click(function(){
            Reload();
        });

        $(".btn-close-view").click(function(){
            window.close();
        });

        $(".btn-print").click(function(){
            window.print();
        });

        $("#btn-snverif").click(function(){
            cekVerif();
        });

        //SUPPLIER
        $("#btn-hdupsup").click(function(){
            hDupSup();
        });

        $("#btn-nsup").click(function(){
            getNIDSup();
        });

        $("#btn-snhsup").click(function(){
            updHSup();
        });

        $("#btn-snpsup").click(function(){
            updPSup();
        });

        $("#btn-snsup").click(function(){
            newSup();
        });

        $("#btn-sesup").click(function(){
            updSup();
        });

        $("#txt-srch-sup").keydown(function(e){
            if(e.keyCode === 13)
                schSup($(this).val());
        });

        $("#btn-srch-sup").click(function(){
            schSup($("#txt-srch-sup").val());
        });

        $("#txt-srch-ssup").keydown(function(e){
            if(e.keyCode === 13)
                schSup($(this).val(), 2);
        });

        $("#btn-srch-ssup").click(function(){
            schSup($("#txt-srch-ssup").val(), 2);
        });

        $("#txt-srch-ssup2").keydown(function(e){
            if(e.keyCode === 13)
                schSup($(this).val(), 3);
        });

        $("#btn-srch-ssup2").click(function(){
            schSup($("#txt-srch-ssup2").val(), 3);
        });

        $("#txt-srch-ssup3").keydown(function(e){
            if(e.keyCode === 13)
                schSup($(this).val(), 4);
        });

        $("#btn-srch-ssup3").click(function(){
            schSup($("#txt-srch-ssup3").val(), 4);
        });

        $("#btn-srch-prtt-sup").click(function(){
            schHTrmSup();
        });

        $("#btn-srch-prtt2-sup").click(function(){
            schHTrmSup2();
        });

        $("#btn-srch-smpn-sup").click(function(){
            schHSmpnSup();
        });

        $("#btn-srch-trtt-sup").click(function(){
            schHTTSup();
        });

        $("#btn-srch-trpjm-sup").click(function(){
            schHPjmSup();
        });

        $("#slct-tsup").change(function(){
            if(!$("#div-dsup").hasClass("d-none"))
                $("#div-dsup").addClass("d-none");

            if($(this).val() === "2"){
                $("#div-dsup").removeClass("d-none");
            }
        });

        $("#slct-tgrade").change(function(){
            if(!$("#div-dgrade").hasClass("d-none"))
                $("#div-dgrade").addClass("d-none");

            if($(this).val() === "2"){
                $("#div-dgrade").removeClass("d-none");
            }
        });

        $("#slct-tsat").change(function(){
            if(!$("#div-dsat").hasClass("d-none"))
                $("#div-dsat").addClass("d-none");

            if($(this).val() === "2"){
                $("#div-dsat").removeClass("d-none");
            }
        });

        $("#btn-snahsup").click(function(){
            updAHSup();
        });

        $("body").on("click", ".btn-dsup", function(){
            delDtSup($(this).attr("data-value"));
        });

        $("#slct-prb-ahsup").change(function(){
            if($(this).val() === "1"){
                if(!$(".txt-gjlh").hasClass("d-none")){
                    $(".txt-gjlh").addClass("d-none");
                }

                if($("#div-jlh").hasClass("d-none")){
                    $("#div-jlh").removeClass("d-none");
                }
            }
            else if($(this).val() === "2"){
                if($(".txt-gjlh").hasClass("d-none")){
                    $(".txt-gjlh").removeClass("d-none");
                }

                if(!$("#div-jlh").hasClass("d-none")){
                    $("#div-jlh").addClass("d-none");
                } 
            }
        })

        //CUSTOMER
        $("#btn-ncus").click(function(){
            getNIDCus();
        });

        $("#btn-sncus").click(function(){
            newCus();
        });

        $("#btn-secus").click(function(){
            updCus();
        });

        $("#txt-srch-cus").keydown(function(e){
            if(e.keyCode === 13)
                schCus($(this).val());
        });

        $("#btn-srch-cus").click(function(){
            schCus($("#txt-srch-cus").val());
        });

        $("#txt-srch-scus").keydown(function(e){
            if(e.keyCode === 13)
                schCus($(this).val(), 2);
        });

        $("#btn-srch-scus").click(function(){
            schCus($("#txt-srch-scus").val(), 2);
        });

        $("#txt-srch-scus2").keydown(function(e){
            if(e.keyCode === 13)
                schCus($(this).val(), 3);
        });

        $("#btn-srch-scus2").click(function(){
            schCus($("#txt-srch-scus2").val(), 3);
        });

        $("#btn-srch-trkrm-cus").click(function(){
            schHKrmCus();
        });

        //PO
        $("#btn-npo").click(function(){
            getNIDPO();
        });

        $("#btn-snpo").click(function(){
            newPO();
        });

        $("#btn-sepo").click(function(){
            updPO();
        });

        $("#txt-srch-po").keydown(function(e){
            if(e.keyCode === 13)
                schPO($(this).val());
        });

        $("#btn-srch-po").click(function(){
            schPO($("#txt-srch-po").val());
        });

        $("#txt-srch-spo").keydown(function(e){
            if(e.keyCode === 13)
                schPO($(this).val(), 2);
        });

        $("#btn-srch-spo").click(function(){
            schPO($("#txt-srch-spo").val(), 2);
        });

        $("#txt-srch-spo2").keydown(function(e){
            if(e.keyCode === 13)
                schPO($(this).val(), 3);
        });

        $("#btn-srch-spo2").click(function(){
            schPO($("#txt-srch-spo2").val(), 3);
        });

        $("#txt-srch-spo3").keydown(function(e){
            if(e.keyCode === 13)
                schPO($(this).val(), 4);
        });

        $("#btn-srch-spo3").click(function(){
            schPO($("#txt-srch-spo3").val(), 4);
        });

        $("#txt-srch-spo4").keydown(function(e){
            if(e.keyCode === 13)
                schPO($(this).val(), 5);
        });

        $("#btn-srch-spo4").click(function(){
            schPO($("#txt-srch-spo4").val(), 5);
        });

        $("body").on("click", ".btn-spo-cus", function(){
            $("#txt-srch-spo4").attr("data-value", $(this).attr("data-value"));
            schPO("", 5);
            $("#mdl-spo4").modal("show");
        });

        $("#btn-sspo").click(function(){
            sendPO();
        })

        //GRADE
        $("#btn-ngrade").click(function(){
            getNIDGrade();
        });

        $("#btn-sngrade").click(function(){
            newGrade();
        });

        $("#btn-segrade").click(function(){
            updGrade();
        });

        $("#txt-srch-grade").keydown(function(e){
            if(e.keyCode === 13)
                schGrade($(this).val());
        });

        $("#btn-srch-grade").click(function(){
            schGrade($("#txt-srch-grade").val());
        });

        $("#txt-srch-sgrade").keydown(function(e){
            if(e.keyCode === 13)
                schGrade($(this).val(), 2);
        });

        $("#btn-srch-sgrade").click(function(){
            schGrade($("#txt-srch-sgrade").val(), 2);
        });

        $("#btn-lpro-grade").click(function(){
            getGradePro();
        });

        $("#txt-srch-pro-grade").keydown(function(e){
            if(e.keyCode === 13)
                schGradePro($(this).val());
        });

        $("#btn-srch-pro-grade").click(function(){
            schGradePro($("#txt-srch-pro-grade").val());
        });

        $("body").on("click", ".btn-dgrade", function(){
            delDtGrade($(this).attr("data-value"));
        });

        //SATUAN
        $("#btn-nsatuan").click(function(){
            getNIDSatuan();
        });

        $("#btn-snsatuan").click(function(){
            newSatuan();
        });

        $("#btn-sesatuan").click(function(){
            updSatuan();
        });

        $("#txt-srch-satuan").keydown(function(e){
            if(e.keyCode === 13)
                schSatuan($(this).val());
        });

        $("#btn-srch-satuan").click(function(){
            schSatuan($("#txt-srch-satuan").val());
        });

        $("#txt-srch-ssat").keydown(function(e){
            if(e.keyCode === 13)
                schSatuan($(this).val(), 2);
        });

        $("#btn-srch-ssat").click(function(){
            schSatuan($("#txt-srch-ssat").val(), 2);
        });

        $("body").on("click", ".btn-dsat", function(){
            delDtSat($(this).attr("data-value"));
        });

        //KATEGORI
        $("#btn-nkate").click(function(){
            getNIDKate();
        });

        $("#btn-snkate").click(function(){
            newKate();
        });

        $("#btn-sekate").click(function(){
            updKate();
        });

        $("#txt-srch-kate").keydown(function(e){
            if(e.keyCode === 13)
                schKate($(this).val());
        });

        $("#btn-srch-kate").click(function(){
            schKate($("#txt-srch-kate").val());
        });

        $("#txt-srch-sskate").keydown(function(e){
            if(e.keyCode === 13)
                schKate($(this).val(), 2);
        });

        $("#btn-srch-sskate").click(function(){
            schKate($("#txt-srch-sskate").val(), 2);
        });

        $("#btn-lpro-kate").click(function(){
            getKatePro();
        });

        $("#txt-srch-pro-kate").keydown(function(e){
            if(e.keyCode === 13)
                schKatePro($(this).val());
        });

        $("#btn-srch-pro-kate").click(function(){
            schKatePro($("#txt-srch-pro-kate").val());
        });

        $("#btn-lskate-kate").click(function(){
            getKateSKate();
        });

        $("#txt-srch-skate-kate").keydown(function(e){
            if(e.keyCode === 13)
                schKateSKate($(this).val());
        });

        $("#btn-srch-skate-kate").click(function(){
            schKateSKate($("#txt-srch-skate-kate").val());
        });

        //SUB KATEGORI
        $("#btn-nskate").click(function(){
            getNIDSKate();
        });

        $("#btn-snskate").click(function(){
            newSKate();
        });

        $("#btn-seskate").click(function(){
            updSKate();
        });

        $("#txt-srch-skate").keydown(function(e){
            if(e.keyCode === 13)
                schSKate($(this).val());
        });

        $("#btn-srch-skate").click(function(){
            schSKate($("#txt-srch-skate").val());
        });

        $("#txt-srch-ssskate").keydown(function(e){
            if(e.keyCode === 13)
                schSKate($(this).val(), 2);
        });

        $("#btn-srch-ssskate").click(function(){
            schSKate($("#txt-srch-ssskate").val(), 2);
        });

        $("#btn-lpro-skate").click(function(){
            getSKatePro();
        });

        $("#txt-srch-pro-skate").keydown(function(e){
            if(e.keyCode === 13)
                schSKatePro($(this).val());
        });

        $("#btn-srch-pro-skate").click(function(){
            schSKatePro($("#txt-srch-pro-skate").val());
        });

        //KATEGORIS
        $("#btn-nkates").click(function(){
            getNIDKates();
        });

        $("#btn-snkates").click(function(){
            newKates();
        });

        $("#btn-sekates").click(function(){
            updKates();
        });

        $("#txt-srch-kates").keydown(function(e){
            if(e.keyCode === 13)
                schKates($(this).val());
        });

        $("#btn-srch-kates").click(function(){
            schKates($("#txt-srch-kates").val());
        });

        //GOL
        $("#btn-ngol").click(function(){
            getNIDGol();
        });

        $("#btn-sngol").click(function(){
            newGol();
        });

        $("#btn-segol").click(function(){
            updGol();
        });

        $("#txt-srch-gol").keydown(function(e){
            if(e.keyCode === 13)
                schGol($(this).val());
        });

        $("#btn-srch-gol").click(function(){
            schGol($("#txt-srch-gol").val());
        });

        //PRODUK
        $("#btn-npro").click(function(){
            getNIDPro();
        });

        $("#btn-snpro").click(function(){
            newPro();
        });

        $("#btn-sepro").click(function(){
            updPro();
        });

        $("#txt-srch-pro").keydown(function(e){
            if(e.keyCode === 13)
                schPro($(this).val());
        });

        $("#btn-srch-pro").click(function(){
            schPro($("#txt-srch-pro").val());
        });

        $("#txt-srch-spro").keydown(function(e){
            if(e.keyCode === 13)
                schPro($(this).val(), 2);
        });

        $("#btn-srch-spro").click(function(){
            schPro($("#txt-srch-spro").val(), 2);
        });

        $(".btn-spro").click(function(){
            schPro("", 2);
        });

        $("#txt-srch-spro2").keydown(function(e){
            if(e.keyCode === 13)
                schPro($(this).val(), 3);
        });

        $("#btn-srch-spro2").click(function(){
            schPro($("#txt-srch-spro2").val(), 3);
        });

        $(".btn-spro2").click(function(){
            schPro("", 3);
        });

        $("#txt-srch-spro3").keydown(function(e){
            if(e.keyCode === 13)
                schPro($(this).val(), 4);
        });

        $("#btn-srch-spro3").click(function(){
            schPro($("#txt-srch-spro3").val(), 4);
        });

        $("body").on("click", ".btn-spro3", function(){
            if($(this).attr("data-value") !== undefined && $(this).attr("data-value") !== "")
                $("#txt-srch-spro5").attr("data-value", $(this).attr("data-value"));

            if($("#mdl-spro5").length > 0)
                schPro("", 6);
            else
                schPro("", 4);
        });

        $("#txt-srch-spro4").keydown(function(e){
            if(e.keyCode === 13)
                schPro($(this).val(), 5);
        });

        $("#btn-srch-spro4").click(function(){
            schPro($("#txt-srch-spro4").val(), 5);
        });

        $(".btn-spro4").click(function(){
            schPro("", 5);
        });

        $("#txt-srch-spro5").keydown(function(e){
            if(e.keyCode === 13)
                schPro($(this).val(), 6);
        });

        $("#btn-srch-spro5").click(function(){
            schPro($("#txt-srch-spro5").val(), 6);
        });

        $("body").on("click", ".btn-spro5", function(){
            $("#txt-srch-spro5").attr("data-value", $(this).attr("data-value"));
            $("#mdl-spro5").modal("show");
            schPro("", 6);
        });

        $("#txt-srch-spro6").keydown(function(e){
            if(e.keyCode === 13)
                schPro($(this).val(), 7);
        });

        $("#btn-srch-spro6").click(function(){
            schPro($("#txt-srch-spro6").val(), 7);
        });

        $(".btn-spro6").click(function(){
            schPro("", 7);
        });

        $("#txt-srch-spro7").keydown(function(e){
            if(e.keyCode === 13)
                schPro($(this).val(), 8);
        });

        $("#btn-srch-spro7").click(function(){
            schPro($("#txt-srch-spro7").val(), 8);
        });

        $("body").on("click", ".btn-spro7", function(){
            $("#txt-srch-spro7").attr("data-value", $(this).attr("data-value"));
            $("#mdl-spro7").modal("show");
            schPro("", 8);
        });

        $("#txt-srch-spro8").keydown(function(e){
            if(e.keyCode === 13)
                schPro($(this).val(), 9);
        });

        $("#btn-srch-spro8").click(function(){
            schPro($("#txt-srch-spro8").val(), 9);
        });

        $("#btn-srch-prtt-pro").click(function(){
            schHTrmPro();
        });

        $("#btn-srch-prvac-pro").click(function(){
            schHVacPro();
        });

        $("#btn-srch-prsaw-pro").click(function(){
            schHSawPro();
        });

        $("#btn-srch-trkrm-pro").click(function(){
            schHKrmPro();
        });

        $("body").on("input", ".catpro", function(){
            var count = $(this).attr("data-value"), sw = UnNumberFormat($("#txt-sw").val()), prsn = UnNumberFormat($(this).val());

            if(sw === "")
                sw = 0;

            if(prsn === 0)
                prsn = 0;
            else
                prsn = parseFloat(prsn/100);

            $("#txt-tpro-jlh-"+count).val(NumberFormat2(sw * prsn));
        });

        $("body").on("input", ".catprok", function(){
            var count = $(this).attr("data-value"), sw = UnNumberFormat($("#txt-sw-krm").val()), prsn = UnNumberFormat($(this).val());

            if(sw === "")
                sw = 0;

            if(prsn === 0)
                prsn = 0;
            else
                prsn = parseFloat(prsn/100);

            $("#txt-tpro-krm-jlh-"+count).val(NumberFormat2(sw * prsn));
        });

        $(".btn-chpro").click(function(){
            $("#txt-srch-spro4").attr("data-value",$(this).attr("data-value"));
        });

        $("body").on("change", ".slct-c1", function(){
            var n = $(this).attr("data-value");

            if(!$("#div-pro-cut1-"+n).hasClass("d-none"))
                $("#div-pro-cut1-"+n).addClass("d-none");

            if($(this).val() === "Dll")
                $("#div-pro-cut1-"+n).removeClass("d-none")
        });

        $("body").on("change", ".slct-c2", function(){
            var n = $(this).attr("data-value");

            if(!$("#div-pro-cut2-"+n).hasClass("d-none"))
                $("#div-pro-cut2-"+n).addClass("d-none");

            if($(this).val() === "Dll")
                $("#div-pro-cut2-"+n).removeClass("d-none")
        });

        $("body").on("change", ".slct-c3", function(){
            var n = $(this).attr("data-value");

            if(!$("#div-pro-cut3-"+n).hasClass("d-none"))
                $("#div-pro-cut3-"+n).addClass("d-none");

            if($(this).val() === "Dll")
                $("#div-pro-cut3-"+n).removeClass("d-none")
        });

        $("body").on("change", ".slct-c4", function(){
            var n = $(this).attr("data-value");

            if(!$("#div-pro-cut4-"+n).hasClass("d-none"))
                $("#div-pro-cut4-"+n).addClass("d-none");

            if($(this).val() === "Dll")
                $("#div-pro-cut4-"+n).removeClass("d-none")
        });

        $("body").on("change", ".slct-c5", function(){
            var n = $(this).attr("data-value");

            if(!$("#div-pro-cut5-"+n).hasClass("d-none"))
                $("#div-pro-cut5-"+n).addClass("d-none");

            if($(this).val() === "Dll")
                $("#div-pro-cut5-"+n).removeClass("d-none")
        });

        $("body").on("change", ".slct-c6", function(){
            var n = $(this).attr("data-value");

            if(!$("#div-pro-cut6-"+n).hasClass("d-none"))
                $("#div-pro-cut6-"+n).addClass("d-none");

            if($(this).val() === "Dll")
                $("#div-pro-cut6-"+n).removeClass("d-none")
        });

        //USER
        $("#btn-nuser").click(function(){
            getNIDUser();
        });

        $("#btn-snuser").click(function(){
            newUser();
        });

        $("#btn-seuser").click(function(){
            updUser();
        });

        $("#txt-srch-user").keydown(function(e){
            if(e.keyCode === 13)
                schUser($(this).val());
        });

        $("#btn-srch-user").click(function(){
            schUser($("#txt-srch-user").val());
        });

        $("#txt-srch-suser").keydown(function(e){
            if(e.keyCode === 13)
                schUser($(this).val(), 2);
        });

        $("#btn-srch-suser").click(function(){
            schUser($("#txt-srch-suser").val(), 2);
        });

        $("#btn-saks").click(function(){
            saveUserAks();
        });

        $("#btn-usr-aks").click(function(){
            aksUser();
        });

        //GUDANG
        $("#btn-ngdg").click(function(){
            getNIDGdg();
        });

        $("#btn-sngdg").click(function(){
            newGdg();
        });

        $("#btn-segdg").click(function(){
            updGdg();
        });

        $("#txt-srch-gdg").keydown(function(e){
            if(e.keyCode === 13)
                schGdg($(this).val());
        });

        $("#btn-srch-gdg").click(function(){
            schGdg($("#txt-srch-gdg").val());
        });

        //PINJAMAN
        $("#btn-npjm").click(function(){
            getNIDPjm();
        });

        $("#btn-snpjm").click(function(){
            newPjm();
        });

        $("#btn-sepjm").click(function(){
            updPjm();
        });

        $("#txt-srch-pjm").keydown(function(e){
            if(e.keyCode === 13)
                schPjm($(this).val());
        });

        $("#btn-srch-pjm").click(function(){
            schPjm($("#txt-srch-pjm").val());
        });

        $("#txt-srch-spjm").keydown(function(e){
            if(e.keyCode === 13)
                schPjm($(this).val(), 2);
        });

        $("#btn-srch-spjm").click(function(){
            schPjm($("#txt-srch-spjm").val(), 2);
        });

        $("#btn-view-pjm").click(function(){
            viewPjm();
        });

        //PINDAH STOK
        $("#btn-nmv").click(function(){
            getNIDMove();
        });

        $("#btn-snmv").click(function(){
            newMove();
        });

        $("#btn-semv").click(function(){
            updMove();
        });

        $("#txt-srch-mv").keydown(function(e){
            if(e.keyCode === 13)
                schMove($(this).val());
        });

        $("#btn-srch-mv").click(function(){
            schMove($("#txt-srch-mv").val());
        });

        $("#txt-srch-smv").keydown(function(e){
            if(e.keyCode === 13)
                schMove($(this).val(), 2);
        });

        $("#btn-srch-smv").click(function(){
            schMove($("#txt-srch-smv").val(), 2);
        });

        $("#btn-view-mv").click(function(){
            viewMove();
        });

        $(".btn-mv-pro").click(function(){
            addDtlMove();
        });

        $("#btn-snuttmv").click(function(){
            updTTMove();
        });

        //BB
        $("#btn-nbb").click(function(){
            getNIDBB();
        });

        $("#btn-snbb").click(function(){
            newBB();
        });

        $("#btn-sebb").click(function(){
            updBB();
        });

        $("#txt-srch-bb").keydown(function(e){
            if(e.keyCode === 13)
                schBB($(this).val());
        });

        $("#btn-srch-bb").click(function(){
            schBB($("#txt-srch-bb").val());
        });

        $("#btn-view-bb").click(function(){
            viewBB();
        });

        //PENERIMAAN
        $(".btn-trm-pro").click(function(){
            $("#btn-npnrm-pro").prop("disabled", false);
            $("#btn-npnrm-pro").html("Simpan");
        });

        $("body").on('change', '.inp-wtrm', function(){
            updSumTrmTran($("#txt-trm-type-pro").val());
            updBB2Val();
        });

        $("#txt-bb2").on("input", function(){
            updBB2Val();
        });

        $("#edt-txt-bb2").on("input", function(){
            updBB2Val();
        });

        $(".slct-dll").change(function(){
            if(!$("#txt-vdll").hasClass("d-none"))
                $("#txt-vdll").addClass("d-none");

            if(!$("#edt-txt-vdll").hasClass("d-none"))
                $("#edt-txt-vdll").addClass("d-none");

            if($(this).val() === "3")
            {
                if($(this).attr("id") === "slct-dll")
                {
                    $("#mdl-vdll .mdl-cls").attr("data-target", "#mdl-ntrm");
                    $("#mdl-ntrm").modal("hide");

                    $("#btn-svdll").attr("data-value", "#mdl-ntrm");
                }
                else
                {
                    $("#mdl-vdll .mdl-cls").attr("data-target", "#mdl-etrm");
                    $("#mdl-etrm").modal("hide");

                    $("#btn-svdll").attr("data-value", "#mdl-etrm");
                }

                $("#mdl-vdll").modal({backdrop : "static", keyboard : false});
                $("#mdl-vdll").modal("show");
            }
        });

        $("#btn-svdll").click(function(){
            var val = $("#txt-kdll").val(), mdl = $(this).attr("data-value");
            
            if(mdl === "#mdl-ntrm")
            {
                $("#txt-vdll").val(val);

                $("#txt-vdll").removeClass("d-none");
            }

            if(mdl === "#mdl-etrm")
            {
                $("#edt-txt-vdll").val(val);

                $("#edt-txt-vdll").removeClass("d-none");
            }

            $("#mdl-vdll").modal("hide");
            
            $("#txt-kdll").val("");
            $(mdl).modal("show");
        });

        $("#btn-ntrm").click(function(){
            getNIDTrm();
        });

        $("#btn-ntrm2").click(function(){
            getNIDTrm2();
        });

        $("#btn-nmtrm").click(function(){
            getNIDMTrm();
        });

        $(".btn-ldll").click(function(){
            $("#mdl-ldll .mdl-cls").attr("data-target", $(this).attr("data-value"));
            $("#btn-sldll").attr("data-value", $(this).attr("data-value"));
        });

        $("#btn-sldll").click(function(){
            saveDllTrm();
        });

        $(".btn-lpdll").click(function(){
            $("#mdl-lpdll .mdl-cls").attr("data-target", $(this).attr("data-value"));
            $("#btn-slpdll").attr("data-value", $(this).attr("data-value"));
        });

        $("#btn-slpdll").click(function(){
            savePDllTrm();
        });

        $(".btn-ldp").click(function(){
            $("#mdl-ldp .mdl-cls").attr("data-target", $(this).attr("data-value"));
            $("#btn-sldp").attr("data-value", $(this).attr("data-value"));
        });

        $("#btn-sldp").click(function(){
            saveDPTrm();
        });

        $(".btn-ltdll").click(function(){
            $("#mdl-ltdll .mdl-cls").attr("data-target", $(this).attr("data-value"));
            $("#btn-sltdll").attr("data-value", $(this).attr("data-value"));
        });

        $("#btn-sltdll").click(function(){
            saveTDllTrm();
        });

        $(".btn-vttrm").click(function(){
            $("#mdl-ltmp-trm .mdl-cls").attr("data-target", $(this).attr("data-value"));
            viewTTrm();
        });

        $("#btn-rstrm").click(function(){
            rstTrm();
        });

        $("body").on('click', ".btn-strm", function(){
            $("#txt-srch-strm2-itm").attr("data-value", $(this).attr("data-value"));
            schTrmItm("", 2);
            $("#mdl-strm3").modal("show");
        });

        $("#btn-sttrm").click(function(){
            newTTrm();
        });

        $("#btn-sntrm").click(function(){
            newTrm();
        });

        $("#btn-smtrm").click(function(){
            getMTrm();
        });

        $("#btn-snmtrm").click(function(){
            updMTrm();
        });

        $("#btn-npnrm-pro").click(function(){
            newDtlTrm();
        });

        $("#btn-ntrm-dll").click(function(){
            newDllTrm();
        });

        $("#btn-ntrm-pdll").click(function(){
            newPDllTrm();
        });

        $("#btn-ntrm-tdll").click(function(){
            newTDllTrm();
        });

        $("#btn-ntrm-dp").click(function(){
            newDPTrm();
        });

        $("#btn-setrm").click(function(){
            updTrm();
        });

        $("#btn-epnrm-pro").click(function(){
            updDtlTrm();
        });

        $("#txt-srch-trm").keydown(function(e){
            if(e.keyCode === 13)
                schTrm($(this).val());
        });

        $("#btn-srch-trm").click(function(){
            schTrm($("#txt-srch-trm").val());
        });

        $("#txt-srch-strm").keydown(function(e){
            if(e.keyCode === 13)
                schTrm($(this).val(), 2);
        });

        $("#btn-srch-strm").click(function(){
            schTrm($("#txt-srch-strm").val(), 2);
        });

        $("#btn-view-trm").click(function(){
            viewTrm();
        });

        $("#btn-ntrm-pro").click(function(){
            setTypeTrm(1);
        });

        $("#btn-etrm-pro").click(function(){
            setTypeTrm(2);
        });

        $("#txt-srch-strm-itm").keydown(function(e){
            if(e.keyCode === 13)
                schTrmItm($(this).val());
        });

        $("#btn-srch-strm-itm").click(function(){
            schTrmItm($("#txt-srch-strm-itm").val());
        });

        $("#txt-srch-strm2-itm").keydown(function(e){
            if(e.keyCode === 13)
                schTrmItm($(this).val(), 2);
        });

        $("#btn-srch-strm2-itm").click(function(){
            schTrmItm($("#txt-srch-strm2-itm").val(), 2);
        });

        $("#dte-tgl-trm").change(function(){
            getTrmCut();
        });

        $("#btn-stopt").click(function(){
            saveOptTrm();
        });

        $("body").on("change", ".slct-tdll", function(){
            var n = $(this).attr("data-value");

            if(!$("#nmbr-ktdll-"+n).attr("readonly"))
                $("#nmbr-ktdll-"+n).attr("readonly", true);

            if(!$("#txt-ttdll-"+n).attr("readonly"))
                $("#txt-ttdll-"+n).attr("readonly", true);

            if(!$("#txt-vtdll-"+n).attr("readonly"))
                $("#txt-vtdll-"+n).attr("readonly", true);

            if($(this).val() === "3")
                $("#txt-vtdll-"+n).attr("readonly", false);
            else
            {
                $("#nmbr-ktdll-"+n).attr("readonly", false);
                $("#txt-ttdll-"+n).attr("readonly", false);
            }
        });

        $("body").on("input", ".inp-tdll", function(){
            var n = $(this).attr("data-value"), kg = 0, val = 0;

            if($("#nmbr-ktdll-"+n).val() !== "")
                kg = $("#nmbr-ktdll-"+n).val();

            if($("#txt-ttdll-"+n).val() !== "")
                val = UnNumberFormat($("#txt-ttdll-"+n).val());

            $("#txt-vtdll-"+n).val(NumberFormat2(parseFloat(kg)*parseFloat(val)));
        });

        $("#btn-ndtrm").click(function(){
            addTrm();
        });

        $("body").on("click", ".btn-strm2", function(){
            newDtlTrm2($(this).attr("data-value"));
        });

        $("#btn-sdtrm").click(function(){
            swal({
                title : "Perhatian !!!",
                text : "Anda yakin selesai dan keluar dari penambahan penerimaan ?",
                icon : "warning",
                dangerMode : true,
                buttons : true,
            })
            .then(ok => {
                if(ok){
                    Process();
                    setTimeout(function(){
                        $.ajax({
                            url : "./bin/php/utqtrm.php",
                            success : function(){
                                $(window).unbind('beforeunload');
                                window.location.href = "./penerimaan";
                            },
                        });
                    }, 200);
                }
            })
        });

        $("body").on("change", ".slct-uhs", function(){
            var x = $(this).attr("data-value");
            getHSSup($("#txt-sup-"+x).val(), $("#slct-pro-"+x).val(), $("#slct-sat-"+x).val(), x);
        });

        //TANDA TERIMA
        $("#btn-ntt").click(function(){
            getNIDTT();
        });

        $("#btn-sntt").click(function(){
            newTT();
        });

        $("#btn-sett").click(function(){
            updTT();
        });

        $("#txt-srch-tt").keydown(function(e){
            if(e.keyCode === 13)
                schTT($(this).val());
        });

        $("#btn-srch-tt").click(function(){
            schTT($("#txt-srch-tt").val());
        });

        $("#btn-view-tt").click(function(){
            viewTT();
        });

        //CUTTING
        $("#btn-ncut").click(function(){
            getNIDCut();
        });

        $("#btn-ncut2").click(function(){
            getNIDCut2();
        });

        $("#btn-sncut").click(function(){
            newDtlCut();
        });

        $("#btn-secut").click(function(){
            updCut();
        });

        $("#txt-srch-cut").keydown(function(e){
            if(e.keyCode === 13)
                schCut($(this).val());
        });

        $("#btn-srch-cut").click(function(){
            schCut($("#txt-srch-cut").val());
        });

        $("#btn-view-cut").click(function(){
            viewCut();
        });

        $("#btn-ndcut").click(function(){
            addCut();
        });

        $("body").on("change", ".dte-cut", function(){
            getNoSample($(this).val(), $(this).attr("data-value"));
            getSlctTrmCut($("#txt-sup-"+$(this).attr("data-value")).val(), $(this).attr("data-value"));
        });

        $("body").on("change", ".slct-sup-trm", function(){
            getSlctTrmCut($(this).val(), $(this).attr("data-value"));
        });

        $("body").on("click", ".btn-rsup", function(){
            getSlctSupCut($(this).attr("data-value"));
        });

        $("body").on("click", ".btn-rtrm", function(){
            getSlctTrmCut($("#txt-sup-"+$(this).attr("data-value")).val(), $(this).attr("data-value"));
        });

        $("body").on("click", ".btn-scut", function(){
            newDtlCut2($(this).attr("data-value"));
        });

        $("body").on("click", ".btn-ecut", function(){
            
        });

        $("body").on("click", ".btn-dcut", function(){
            delCutPro2($(this).attr("data-value"));
        });

        $("body").on("click", ".btn-dcut2", function(){
            
        });

        $("#btn-sdcut").click(function(){
            swal({
                title : "Perhatian !!!",
                text : "Anda yakin selesai dan keluar dari penambahan cutting ?",
                icon : "warning",
                dangerMode : true,
                buttons : true,
            })
            .then(ok => {
                if(ok)
                {
                    $(window).unbind('beforeunload');
                    window.location.href = "./cutting";
                }
            })
        });

        if($(".tbl-ncutpro").length > 0){
            $(".tbl-ncutpro").addClass("w-100");

            $(".tbl-ncutpro").DataTable({
                dom: 'rtip',
                scrollY: '20vh',
                scrollX: true,
                pageLength : 10,
                ordering : false,
                autoWidth: false,
            });
            
            $(".dataTables_scrollHeadInner").addClass("w-100");
        }

        if($(".tbl-ncutnpro").length > 0){
            $(".tbl-ncutnpro").addClass("w-100");

            $(".tbl-ncutnpro").DataTable({
                dom: 'rtip',
                scrollY: '20vh',
                scrollX: true,
                pageLength : 10,
                ordering : false,
                autoWidth: false,
            });

            $(".dataTables_scrollHeadInner").addClass("w-100");
        }

        $(".dataTables_paginate.paging_simple_numbers").addClass("small").addClass("pr-2");
        $(".dataTables_info").addClass("pl-2").addClass("small");

        $("#btn-ndcutpro").click(function(){
            addHCutPro();
        });

        $("#btn-ndcutnpro").click(function(){
            addHCutNPro();
        });

        $("body").on("click", ".btn-scpro", function(){
            newHCutPro($(this).attr("data-value"));
        });

        $("body").on("click", ".btn-dcpro", function(){
            delHCutPro($(this).attr("data-value"));
        });

        $("body").on("click", ".btn-scnpro", function(){
            newHCutNPro($(this).attr("data-value"));
        });

        $("body").on("click", ".btn-dcnpro", function(){
            delHCutNPro($(this).attr("data-value"));
        });

        //VACUUM
        $(".btn-vac-pro").click(function(){
            $("#btn-sevac-pro").prop("disabled", false);
            $("#btn-sevac-pro").html("Simpan");
        });

        $("#mdl-nvac #dte-tgl").change(function(){
            getWeightVacPro();
        });

        $("#btn-nvac").click(function(){
            getNIDVac();
        });

        $("#btn-snvac").click(function(){
            newDtlVac();
        });

        $("#btn-sevac-pro").click(function(){
            newDtlEVac();
        });

        $("#btn-sevac").click(function(){
            updVac();
        });

        $("#txt-srch-vac").keydown(function(e){
            if(e.keyCode === 13)
                schVac($(this).val());
        });

        $("#btn-srch-vac").click(function(){
            schVac($("#txt-srch-vac").val());
        });

        // Vacuum Hasil
        $("#txt-srch-vac-hasil").keydown(function(e){
            if(e.keyCode === 13)
                schHasilVac($(this).val());
        });

        $("btn-srch-vac-hasil").keydown(function(){
            schHasilVac($("#txt-srch-vac-hasil").val());
        })

        $("#slct-type").change(function(){
            var x = $(this).val();

            if(!$("#div-ptype").hasClass("d-none"))
                $("#div-ptype").addClass("d-none");


            if(!$("#div-ctype").hasClass("d-none"))
                $("#div-ctype").addClass("d-none");

            if(x === "1")
                $("#div-ctype").removeClass("d-none");
            else if(x === "2")
                $("#div-ptype").removeClass("d-none");
        });

        $("#edt-slct-type").change(function(){
            var x = $(this).val();

            if(!$("#edt-div-ptype").hasClass("d-none"))
                $("#edt-div-ptype").addClass("d-none");

            if(!$("#edt-div-ctype").hasClass("d-none"))
                $("#edt-div-ctype").addClass("d-none");

            if(x === "1")
                $("#edt-div-ctype").removeClass("d-none");
            else if(x === "2")
                $("#edt-div-ptype").removeClass("d-none");
        });

        $("#btn-view-vac").click(function(){
            viewVac();
        });

        $(".dte-ctgl").change(function(){
            getHslCut($(this).val());
        });

        $(".btn-rvpro2").click(function(){
            reVPro2($(this).attr("data-value"));
        });

        //SAWING
        $(".btn-saw-pro").click(function(){
            $("#btn-sesaw-pro").prop("disabled", false);
            $("#btn-sesaw-pro").html("Simpan");
        });

        $("#mdl-nsaw #dte-tgl").change(function(){
            getWeightSawPro();
        });

        $("#btn-nsaw").click(function(){
            getNIDSaw();
        });

        $("#btn-snsaw").click(function(){
            newDtlSaw();
        });

        $("#btn-sesaw-pro").click(function(){
            newDtlESaw();
        });

        $("#btn-sesaw").click(function(){
            updSaw();
        });

        $("#txt-srch-saw").keydown(function(e){
            if(e.keyCode === 13)
                schSaw($(this).val());
        });

        $("#btn-srch-saw").click(function(){
            schSaw($("#txt-srch-saw").val());
        });

        //RE-PACKAGING
        $("#btn-nrpkg").click(function(){
            getNIDRPkg();
        });

        $("#btn-snrpkg").click(function(){
            newRPkg();
        });

        $("#btn-serpkg").click(function(){
            updRPkg();
        });

        $("#txt-srch-rpkg").keydown(function(e){
            if(e.keyCode === 13)
                schRPkg($(this).val());
        });

        $("#btn-srch-rpkg").click(function(){
            schRPkg($("#txt-srch-rpkg").val());
        });

        $("#btn-view-rpkg").click(function(){
            viewRPkg();
        });

        $(".btn-rpkg-pro").click(function(){
            addDtlRPkg();
        });

        //PACKAGING
        $(".btn-krm-pro").click(function(){
            $("#btn-snkrm-pro").prop("disabled", false);
            $("#btn-snkrm-pro").html("Simpan");
        });

        $("#btn-nkrm").click(function(){
            getNIDKrm();
        });

        $("#btn-snkrm").click(function(){
            newDtlKrm();
        });

        $("#btn-snkrm-pro").click(function(){
            newDtlEKrm();
        });

        $("#btn-sekrm").click(function(){
            updKrm();
        });

        $("#txt-srch-krm").keydown(function(e){
            if(e.keyCode === 13)
                schKrm($(this).val());
        });

        $("#btn-srch-krm").click(function(){
            schKrm($("#txt-srch-krm").val());
        });

        $("#btn-view-krm").click(function(){
            viewKrm();
        });

        $("#btn-nkrm-pro").click(function(){
            setTypeKrm(1);
        });

        $("#btn-ekrm-pro").click(function(){
            setTypeKrm(2);
        });

        //MASUK PRODUK
        $(".btn-mp-pro").click(function(){
            $("#btn-semp-pro").prop("disabled", false);
            $("#btn-semp-pro").html("Simpan");
        });

        $("#mdl-nmp #dte-tgl").change(function(){
            getWeightMPPro();
        });

        $("#btn-nmp").click(function(){
            getNIDMP();
        });

        $("#btn-snmp").click(function(){
            newDtlMP();
        });

        $("#btn-semp-pro").click(function(){
            newDtlEMP();
        });

        $("#btn-semp").click(function(){
            updMP();
        });

        $("#txt-srch-mp").keydown(function(e){
            if(e.keyCode === 13)
                schMP($(this).val());
        });

        $("#btn-srch-mp").click(function(){
            schMP($("#txt-srch-mp").val());
        });

        $("#slct-type").change(function(){
            var x = $(this).val();

            if(!$("#div-ptype").hasClass("d-none"))
                $("#div-ptype").addClass("d-none");

            if(!$("#div-ctype").hasClass("d-none"))
                $("#div-ctype").addClass("d-none");
                
            if(!$("#div-grd-bb").hasClass("d-none"))
                $("#div-grd-bb").addClass("d-none");

            if(x === "1"){
                $("#div-ctype").removeClass("d-none");
                $("#div-grd-bb").removeClass("d-none");
            }
            else if(x === "2")
                $("#div-ptype").removeClass("d-none");
        });

        $("#edt-slct-type").change(function(){
            var x = $(this).val();

            if(!$("#edt-div-ptype").hasClass("d-none"))
                $("#edt-div-ptype").addClass("d-none");

            if(!$("#edt-div-ctype").hasClass("d-none"))
                $("#edt-div-ctype").addClass("d-none");
                
            if(!$("#edt-div-grd-bb").hasClass("d-none"))
                $("#edt-div-grd-bb").addClass("d-none");

            if(x === "1"){
                $("#edt-div-ctype").removeClass("d-none");
                $("#edt-div-grd-bb").removeClass("d-none");
            }
            else if(x === "2")
                $("#edt-div-ptype").removeClass("d-none");
        });

        $("#btn-view-mp").click(function(){
            viewMP();
        });

        //PENYESUAIAN STOK
        $(".btn-ps-pro").click(function(){
            $("#btn-seps-pro").prop("disabled", false);
            $("#btn-seps-pro").html("Simpan");
        });
        
        $("#btn-nps").click(function(){
            getNIDPs();
        });

        $("#btn-snps").click(function(){
            newDtlPs();
        });

        $("#btn-seps-pro").click(function(){
            newDtlEPs();
        });

        $("#btn-seps").click(function(){
            updPs();
        });

        $("#txt-srch-ps").keydown(function(e){
            if(e.keyCode === 13)
                schPs($(this).val());
        });

        $("#btn-srch-ps").click(function(){
            schPs($("#txt-srch-ps").val());
        });

        $("#btn-view-ps").click(function(){
            viewPs();
        });

        //PEMBEKUAN
        $("#btn-nfrz").click(function(){
            getNIDFrz();
        });

        $("#btn-snfrz").click(function(){
            newDtlFrz();
        });

        $("#btn-sefrz").click(function(){
            updFrz();
        });

        $("#txt-srch-frz").keydown(function(e){
            if(e.keyCode === 13)
                schFrz($(this).val());
        });

        $("#btn-srch-frz").click(function(){
            schFrz($("#txt-srch-frz").val());
        });

        $("#btn-view-frz").click(function(){
            viewFrz();
        });

        $("#btn-frz-pro").click(function(){
            newDtlEFrz();
        });

        //SETTING
        $("#btn-sset").click(function(){
            saveSett();
        });

        $("#btn-achpro").click(function(){
            $("#txt-srch-spro8").attr("data-value", "#lst-chpro");
            $("#mdl-spro8").modal("show");
        });

        $("#btn-achnpro").click(function(){
            $("#txt-srch-spro8").attr("data-value", "#lst-chnpro");
            $("#mdl-spro8").modal("show");
        });

        $("body").on("click", ".btn-dachnpro", function(){
            delSettPro($(this).attr("data-count"), "ASCHNPRO", $(this).attr("data-id"));
        });

        $("body").on("click", ".btn-dachpro", function(){
            delSettPro($(this).attr("data-count"), "ASCHPRO", $(this).attr("data-id"));
        });

        //REPAIR
        $("#btn-rpjm").click(function(){
            repairPjm();
        });

        $("#btn-rstk").click(function(){
            repairStk();
        });

        //TUTUP BUKU
        $("#btn-stbuku").click(function(){
            saveTBuku();
        });

        //LAPORAN
        $(".btn-rsup").click(function(){
            $("#txt-nma-sup").val("");
            $("#txt-sup").val("");
        });

        $(".btn-rcus").click(function(){
            $("#txt-nma-cus").val("");
            $("#txt-cus").val("");
        });

        $(".btn-rpro").click(function(){
            $("#txt-nma-pro").val("");
            $("#txt-pro").val("");
        });

        $(".btn-rpro2").click(function(){
            $("#txt-nma-pro3-"+$(this).attr("data-value")).val("");
            $("#txt-pro3-"+$(this).attr("data-value")).val("");
        });

        $(".btn-rbb").click(function(){
            $("#txt-nma-bb").val("");
            $("#txt-bb").val("");
        });

        $(".btn-rpo").click(function(){
            $("#txt-nma-po").val("");
            $("#txt-po").val("");
        });

        $(".slct-type").change(function(){
            if(!$("#div-frm").hasClass("d-none"))
                $("#div-frm").addClass("d-none");

            if(!$("#div-to").hasClass("d-none"))
                $("#div-to").addClass("d-none");

            if($(this).val() === "3")
            {
                $("#div-frm").removeClass("d-none")
                $("#div-to").removeClass("d-none")
            }
        });

        $("#slct-lp-pro").change(function(){
            if(!$("#div-type").hasClass("d-none")){
                $("#div-type").addClass("d-none");
            }

            if(!$("#div-frm").hasClass("d-none")){
                $("#div-frm").addClass("d-none");
            }

            if(!$("#div-to").hasClass("d-none")){
                $("#div-to").addClass("d-none");
            }

            if(!$("#div-gol").hasClass("d-none")){
                $("#div-gol").addClass("d-none");
            }

            if(!$("#div-mdl-lp-pro").hasClass("d-none")){
                $("#div-mdl-lp-pro").addClass("d-none");
            }
                
            if($(this).val() !== "3"){
                $("#div-type").removeClass("d-none");

                if($("#slct-type").val() === "3"){
                    $("#div-frm").removeClass("d-none");
                    $("#div-to").removeClass("d-none");
                }
            }
            else if($(this).val() === "3"){
                $("#div-mdl-lp-pro").removeClass("d-none");
                $("#div-gol").removeClass("d-none")
            }
        });

        $("#slct-jns-trm").change(function(){
            if($("#div-sup").hasClass("d-none"))
                $("#div-sup").removeClass("d-none");
                
            if($("#div-frm").hasClass("d-none"))
                $("#div-frm").removeClass("d-none");

            if($("#div-to").hasClass("d-none"))
                $("#div-to").removeClass("d-none");

            if(!$("#div-tgfk").hasClass("d-none"))
                $("#div-tgfk").addClass("d-none");

            if(!$("#div-jgfk").hasClass("d-none"))
                $("#div-jgfk").addClass("d-none");

            if(!$("#div-dgfk").hasClass("d-none"))
                $("#div-dgfk").addClass("d-none");

            if(!$("#div-wgfk").hasClass("d-none"))
                $("#div-wgfk").addClass("d-none");

            if(!$("#div-scut").hasClass("d-none"))
                $("#div-scut").addClass("d-none");

            if(!$("#div-jsup").hasClass("d-none"))
                $("#div-jsup").addClass("d-none");

            if($(this).val() === "3"){
                $("#div-sup").addClass("d-none");
            }
            else if($(this).val() === "5"){
                $("#div-tgfk").removeClass("d-none");
                $("#div-jgfk").removeClass("d-none");
                $("#div-dgfk").removeClass("d-none");
                $("#div-wgfk").removeClass("d-none");
            }
            else if($(this).val() === "2"){
                $("#div-scut").removeClass("d-none");
                $("#div-jsup").removeClass("d-none");
            }
            else if($(this).val() === "1"){
                $("#div-jsup").removeClass("d-none");
            }
            else if($(this).val() === "6"){
                $("#div-jsup").removeClass("d-none");
            }
            else if($(this).val() === "4"){
                $("#div-jsup").removeClass("d-none");
            }
            else if($(this).val() === "8"){
                $("#div-jsup").removeClass("d-none");
            }
        })

        $("#slct-jns-pjm").change(function(){
            if($("#div-frm").hasClass("d-none"))
                $("#div-frm").removeClass("d-none");

            if($("#div-to").hasClass("d-none"))
                $("#div-to").removeClass("d-none");

            if($(this).val() === 3)
            {
                $("#div-frm").addClass("d-none");
                $("#div-to").addClass("d-none");
            }
        });

        $("#slct-type-vac").change(function(){
            if(!$("#div-bpro").hasClass("d-none"))
                $("#div-bpro").addClass("d-none");

            if(!$("#div-hpro").hasClass("d-none"))
                $("#div-hpro").addClass("d-none");

            if(!$("#div-jtgl-vac").hasClass("d-none"))
                $("#div-jtgl-vac").addClass("d-none");

            if(!$("#slct-jns-vac").prop("disabled"))
                $("#slct-jns-vac").prop("disabled", false);

            if($(this).val() === "1"){
                $("#div-bpro").removeClass("d-none");

                if($("#slct-jns-vac").val() === "2")
                    $("#div-jtgl-vac").removeClass("d-none");
            }
            else if($(this).val() === "2")
            {
                $("#div-bpro").removeClass("d-none");
                $("#div-hpro").removeClass("d-none");

                if($("#slct-jns-vac").val() === "2")
                    $("#div-jtgl-vac").removeClass("d-none");
            }
            else if($(this).val() === "3" || $(this).val() === "4")
                $("#div-hpro").removeClass("d-none");
            else if($(this).val() === "5"){
                $("#slct-jns-vac").prop("disabled", true);
                $("#slct-jns-vac").val("2");
                $("#div-jtgl-vac").removeClass("d-none");
            }
        });

        $("#slct-jns-saw").change(function(){
            if($("#div-bb").hasClass("d-none"))
                $("#div-bb").removeClass("d-none");
                
            if($(this).val() === "3")
                $("#div-bb").addClass("d-none");
        });

        $("#slct-jns-rpkg").change(function(){
            if(!$("#div-hpro").hasClass("d-none")){
                $("#div-hpro").addClass("d-none");
            }

            if($(this).val() === "2"){
                $("#div-hpro").removeClass("d-none");
            }
        });

        $("#slct-jns-krm").change(function(){
            if(!$("#div-po").hasClass("d-none"))
                $("#div-po").addClass("d-none");
                
            if($(this).val() === "2")
                $("#div-po").removeClass("d-none");
        });

        $(".inp-bb").click(function(){
            $("#txt-srch-spro").attr("data-value", "#txt-bb");
            $("#txt-srch-spro").attr("data-value2", "#txt-nma-bb");
        });

        $(".inp-lpro").click(function(){
            $("#txt-srch-spro").attr("data-value", "");
            $("#txt-srch-spro").attr("data-value2", "");
        });

        $("#slct-jns-bb").change(function(){
            if($("#div-ttran").hasClass("d-none"))
                $("#div-ttran").addClass("d-none");

            if($(this).val() === "2")
                $("#div-ttran").removeClass("d-none");
        });

        $("#slct-type-mv").change(function(){
            if(!$("#div-pro").hasClass("d-none"))
                $("#div-pro").addClass("d-none");

            if($(this).val() === "2"){
                $("#div-pro").removeClass("d-none");
            }
        });

        //HISTORY
        $(".btn-vhst-tt").click(function(){
            viewHTT(UD64($(this).attr("data-value")));
        });

        $(".btn-vhst-pjm").click(function(){
            viewHPjm(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-trm").click(function(){
            viewHTrm(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-cut").click(function(){
            viewHCut(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-vac").click(function(){
            viewHVac(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-saw").click(function(){
            viewHSaw(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-rpkg").click(function(){
            viewHRPkg(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-krm").click(function(){
            viewHKrm(UD64($(this).attr("data-value")));
        });

        $(".btn-vhst-wd").click(function(){
            viewHWd(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-mp").click(function(){
            viewHMP(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-frz").click(function(){
            viewHFrz(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-ps").click(function(){
            viewHPs(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-mv").click(function(){
            viewHMove(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-rkrm").click(function(){
            viewHRKrm(UD64($(this).attr("data-value")));
        });
        
        $(".btn-vhst-bb").click(function(){
            viewHBB(UD64($(this).attr("data-value")));
        });

        //VERIFIKASI
        $("body").on('click', '.btn-averif', function(){
            averif(UD64($(this).attr("data-value")), UD64($(this).attr("data-type")));
        });

        $("body").on('click', '.btn-cverif', function(){
            dverif(UD64($(this).attr("data-value")), UD64($(this).attr("data-type")));
        });

        $("body").on('click', '.btn-apverif', function(){
            apverif(UD64($(this).attr("data-value")));
        });

        $("body").on('click', '.btn-cpverif', function(){
            dpverif(UD64($(this).attr("data-value")), "");
        });

        $("#btn-snverif").click(function(){
            var type = $("#txt-vkode").attr("data-type");

            if(type === "TT")
                cekTTVerif();
            else if(type === "PJM")
                cekPjmVerif();
            else if(type === "PJM")
                cekPjmVerif();
            else if(type === "KRM")
                cekKrmVerif();
            else if(type === "TT")
                cekTTVerif();
            else if(type === "CUT")
                cekCutVerif();
            else if(type === "VAC")
                cekVacVerif();
            else if(type === "SAW")
                cekSawVerif();
            else if(type === "WD")
                cekWdVerif();
            else if(type === "WD")
                cekMPVerif();

            $("#txt-vkode").val("");
        });

        $("#link-vtran").click(function(){
            $("#link-vptran").removeClass("active");

            if(!$("#link-vtran").hasClass("active"))
                $("#link-vtran").addClass("active");

            if($("#div-vrf").hasClass("d-none"))
                $("#div-vrf").removeClass("d-none");

            if(!$("#div-pvrf").hasClass("d-none"))
                $("#div-pvrf").addClass("d-none");
        });

        $("#link-vptran").click(function(){
            $("#link-vtran").removeClass("active");

            if(!$("#link-vptran").hasClass("active"))
                $("#link-vptran").addClass("active");

            if(!$("#div-vrf").hasClass("d-none"))
                $("#div-vrf").addClass("d-none");

            if($("#div-pvrf").hasClass("d-none"))
                $("#div-pvrf").removeClass("d-none");
        })

        //LIVE VIEW
        $("#btn-slv-cut").click(function(){
            setDateLView($("#dte-tgl").val(), "#btn-slv-cut");

            getLViewCut();
        })

        $("#btn-slv-vac").click(function(){
            setDateLView($("#dte-tgl").val(), "#btn-slv-vac");

            getLViewVac();
        })

        $("#btn-slv-saw").click(function(){
            setDateLView($("#dte-tgl").val(), "#btn-slv-saw");

            getLViewSaw();
        })

        $("#btn-slv-krm").click(function(){
            getLViewKrm();
        })

        $("#btn-slv-inv").click(function(){
            setDateLView($("#dte-tgl").val(), "#btn-slv-inv");

            getLViewInv();
        })

        //PENARIKAN
        $("#btn-nwd").click(function(){
            getNIDWd();
        });

        $("#btn-snwd").click(function(){
            newWd();
        });

        $("#btn-sewd").click(function(){
            updWd();
        });

        $("#txt-srch-wd").keydown(function(e){
            if(e.keyCode === 13)
                schWd($(this).val());
        });

        $("#btn-srch-wd").click(function(){
            schWd($("#txt-srch-wd").val());
        });

        $("#btn-view-wd").click(function(){
            viewWd();
        });

        //AUTO
        $("#txt-sw").on("input", function(){
            updTAtPro();
        });

        $("#txt-sw-krm").on("input", function(){
            updTAtProKrm();
        });

        $("#btn-sat-date").click(function(){
            setAtDate();
        });

        $("#btn-sat-date-krm").click(function(){
            setAtDateKrm();
        });

        $("#rdo-asup-yes").click(function(){
            if(!$("#div-ssup").hasClass("d-none"))
                $("#div-ssup").addClass("d-none");
        });

        $("#rdo-asup-no").click(function(){
            if($("#div-ssup").hasClass("d-none"))
                $("#div-ssup").removeClass("d-none");
        });

        $("#rdo-acus-yes").click(function(){
            if(!$("#div-scus").hasClass("d-none"))
                $("#div-scus").addClass("d-none");
        });

        $("#rdo-acus-no").click(function(){
            if($("#div-scus").hasClass("d-none"))
                $("#div-scus").removeClass("d-none");
        });

        $("#rdo-ahcut-yes").click(function(){
            if(!$("#div-hcut").hasClass("d-none"))
                $("#div-hcut").addClass("d-none");
        });

        $("#rdo-ahcut-no").click(function(){
            if($("#div-hcut").hasClass("d-none"))
                $("#div-hcut").removeClass("d-none");
        });

        $("#rdo-pkrm-yes").click(function(){
            if(!$("#div-pkrm").hasClass("d-none"))
                $("#div-pkrm").addClass("d-none");
        });

        $("#rdo-pkrm-no").click(function(){
            if($("#div-pkrm").hasClass("d-none"))
                $("#div-pkrm").removeClass("d-none");
        });

        $("#btn-sat-trm").click(function(){
            autoGenTrm();
        });

        $("#btn-sat-krm").click(function(){
            autoGenKrm();
        });

        $(".nav-auto").click(function(){
            $(".nav-auto").removeClass("active");

            if(!$("#nav-trm").hasClass("d-none"))
                $("#nav-trm").addClass("d-none");

            if(!$("#nav-krm").hasClass("d-none"))
                $("#nav-krm").addClass("d-none");
                
            if($(this).attr("data-value") === "nav-trm")
            {
                $("#nav-trm").removeClass("d-none");
                $(this).addClass("active");
            }

            if($(this).attr("data-value") === "nav-krm")
            {
                $("#nav-krm").removeClass("d-none");
                $(this).addClass("active");
            }
        });

        //UTILITY
        $("#btn-idata").click(function(){
            importData();
        });

        //RETUR KIRIM
        $("#btn-nrkrm").click(function(){
            getNIDRKrm();
        });

        $("#btn-snrkrm").click(function(){
            newRKrm();
        });

        $("#btn-serkrm").click(function(){
            updRKrm();
        });

        $("#txt-srch-rkrm").keydown(function(e){
            if(e.keyCode === 13)
                schRKrm($(this).val());
        });

        $("#btn-srch-rkrm").click(function(){
            schRKrm($("#txt-srch-rkrm").val());
        });

        $("body").on("click", ".btn-dpro-nrkrm", function(){
            delProRKrm($(this).attr("data-value"), "N");
        });

        $("body").on("click", ".btn-dpro-erkrm", function(){
            delProRKrm($(this).attr("data-value"), "E");
        });

        $(".btn-simpanan").click(function() {
            $(this).toggleClass('btn-simpanan-active');
        });
    });
})
// (jQuery)