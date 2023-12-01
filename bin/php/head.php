<?php
    if(!isset($login))
    {
        isLogOut();

        $user = $_SESSION["user-kuma-wps"];

        $duser = getUserID($user);
    }
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Stock Management System">
<meta name="author" content="Unonymous">
<meta name="keywords" content="">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />

<link rel="stylesheet" href="./bin/vendor/typeahead.js/typeahead.css">
<link rel="stylesheet" href="./bin/vendor/bootstrapv4/css/bootstrap.css">
<link rel="stylesheet" href="./bin/vendor/bootstrapv4/css/bootstrap-imageupload.css">
<link rel="stylesheet" href="./bin/vendor/jquery-ui-1.12.1/jquery-ui.css">
<link rel="stylesheet" href="./bin/vendor/DataTables/datatables.css">
<link rel="stylesheet" href="./bin/vendor/DataTables/DataTables-1.11.2/css/responsive.dataTables.css">
<link rel="stylesheet" href="./bin/vendor/DataTables/plugins/buttons.dataTables.min.css">
<link rel="stylesheet" href="./bin/css/index.css?v=1.1.0">

<link rel="apple-touch-icon" sizes="180x180" href="./bin/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="./bin/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="./bin/img/favicon/favicon-16x16.png">
<link rel="manifest" href="./bin/img/favicon/site.webmanifest">
<link rel="mask-icon" href="./bin/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="theme-color" content="#ffffff">

<script type="text/javascript" src="./bin/vendor/jquery/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="./bin/vendor/jquery-base64/jquery.base64.js"></script>
<script type="text/javascript" src="./bin/vendor/jquery/jquery.formatCurrency-1.4.0.js"></script>
<script type="text/javascript" src="./bin/vendor/bootstrapv4/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="./bin/vendor/bootstrapv4/js/bootstrap-imageupload.js"></script>
<!-- <script type="text/javascript" src="./bin/vendor/tinymce/tinymce.min.js"></script> -->
<script type="text/javascript" src="./bin/vendor/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="./bin/vendor/chartjs/dist/Chart.js"></script>
<script type="text/javascript" src="./bin/vendor/googleapis/jquery.table2excel.js"></script>
<script type="text/javascript" src="./bin/vendor/jquery-ui-1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="./bin/vendor/typeahead.js/typeahead.bundle.js"></script>
<script type="text/javascript" src="./bin/vendor/typeahead.js/typeahead.jquery.js"></script>
<script type="text/javascript" src="./bin/vendor/bootstrap-4-autocomplete/bootstrap-4-autocomplete.min.js"></script>
<script type="text/javascript" src="./bin/vendor/DataTables/datatables.js"></script>
<script type="text/javascript" src="./bin/vendor/DataTables/DataTables-1.11.2/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="./bin/vendor/DataTables/plugins/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="./bin/vendor/DataTables/plugins/jszip.min.js"></script>
<script type="text/javascript" src="./bin/vendor/DataTables/plugins/pdfmake.min.js"></script>
<script type="text/javascript" src="./bin/vendor/DataTables/plugins/vfs_fonts.js"></script>
<script type="text/javascript" src="./bin/vendor/DataTables/plugins/buttons.html5.min.js"></script>
<script type="text/javascript" src="./bin/vendor/DataTables/plugins/buttons.print.min.js"></script>
<script type="text/javascript" src="./bin/js/index.js?v=2.7.2"></script>
<script type="text/javascript" src="./bin/js/data-script.js?v=2.7.2"></script>
<script type="text/javascript" src="./bin/js/tran-script.js?v=2.7.2"></script>
<script type="text/javascript" src="./bin/js/proc-script.js?v=2.7.2"></script>
<script type="text/javascript" src="./bin/js/hst-script.js?v=2.7.2"></script>
<script type="text/javascript" src="./bin/js/script.js?v=2.7.2"></script>