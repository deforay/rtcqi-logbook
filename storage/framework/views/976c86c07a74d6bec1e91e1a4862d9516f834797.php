<!--Author : Prastah M
    Date : 27 May 2021
    Desc : head tag elements
-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
<meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
<meta name="author" content="Deforay">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title>RTCQI LOGBOOK</title>
<link rel="apple-touch-icon" href="<?php echo e(asset('app-assets/images/ico/apple-icon-120.png')); ?>">
<!-- <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('app-assets/images/logo/asm_logo.png')); ?>"> -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/vendors.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/weather-icons/climacons.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/fonts/meteocons/style.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/charts/morris.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/ui/jquery-ui.min.css')); ?>">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/bootstrap.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/bootstrap-extended.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/colors.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/components.css')); ?>">
<!-- END: Theme CSS-->

<!-- BEGIN: Page CSS-->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/core/menu/menu-types/vertical-overlay-menu.css')); ?>"> -->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/core/menu/menu-types/horizontal-menu.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/core/colors/palette-gradient.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/fonts/simple-line-icons/style.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/fonts/line-awesome/css/line-awesome.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/core/colors/palette-gradient.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/pages/timeline.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/pages/dashboard-ecommerce.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/plugins/sweetalert/sweetalert.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/plugins/forms/extended/form-extended.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/forms/selects/select2.min.css')); ?>">
<!-- END: Page CSS-->

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/tables/datatable/datatables.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css/core/colors/palette-switch.min.css')); ?>">

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/style.css')); ?>">
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- BEGIN: Vendor JS-->
<script src="<?php echo e(asset('app-assets/vendors/js/vendors.min.js')); ?>"></script>
<!-- BEGIN Vendor JS-->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/js/datepicker/datepicker3.css')); ?>">
<script src="<?php echo e(asset('app-assets/vendors/js/forms/extended/typeahead/typeahead.bundle.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('app-assets/vendors/js/forms/extended/typeahead/bloodhound.min.js')); ?>" type="text/javascript"></script>
<!-- <script src="<?php echo e(asset('app-assets/js/scripts/forms/extended/form-typeahead.js')); ?>" type="text/javascript"></script> -->
<script src="<?php echo e(asset('app-assets/vendors/js/forms/extended/typeahead/handlebars.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('app-assets/vendors/js/forms/extended/formatter/formatter.min.js')); ?>"></script>
<script src="<?php echo e(asset('app-assets/vendors/js/forms/extended/maxlength/bootstrap-maxlength.js')); ?>"></script>
<script src="<?php echo e(asset('app-assets/vendors/js/forms/extended/card/jquery.card.js')); ?>"></script>
<style type="text/css">
    table {
        border-radius: 6px !important;
        -webkit-box-shadow: 0px 0px 8px 3px rgba(161,161,168,1);
        -moz-box-shadow: 0px 0px 8px 3px rgba(161,161,168,1);
        box-shadow: 0px 0px 5px -1px rgb(197, 197, 197);
    }

    table>thead{
        background-color: #d4e4f09e !important;
        /* color: #9d9da0;
        text-transform: uppercase !important; */
    }

    .row > button{
        vertical-align:
    }

    .table tr td:last-child{
        /* vertical-align: middle !important; */
    }
    .table td{
        vertical-align: middle !important;
    }

    .main-menu.menu-light .navigation > li.active > a {
        font-weight: 700;
        background: #2f9ff221 !important;
        margin: 0 1rem 0 1rem;
        border-radius: 0.3rem;
    }
    .main-menu.menu-light .navigation > li.open > ul > li:hover.active > a {
        padding: 9px 18px 9px 40px;
    }
    .main-menu.menu-light .navigation > li .active > a {
        color: #85899b;
        font-weight: 700;
        background: #bcbec821;
        margin: 0 1rem 0 1rem;
        border-radius: 0.3rem;
        padding-left: 40px;
    }


    /* Action By Selvam: Uncommented this block
       Reason: Dashboard Recent Transaction Table UI Affected
    */


    .card-headers {
        padding: 1.0rem 2.5rem;
        margin-bottom: 0;
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    .card-headers:first-child {
        border-radius: .45rem .45rem 0 0;
        background-color: #ffffff;
    }

    .card-headers .heading-elements, .card-headers .heading-elements-toggle {
        background-color: inherit;
        position: absolute;
        top: 14px;
        right: 20px;
    }

    #blue-grey-box-shadow{
        -webkit-box-shadow: 0px 5px 7px 0px rgba(199,199,199,1) !important;
        -moz-box-shadow: 0px 5px 7px 0px rgba(199,199,199,1) !important;
        box-shadow: 0px 5px 7px 0px rgba(199,199,199,1) !important;
    }

</style>
<?php /**PATH /var/www/rtcqi-logbook/resources/views/layoutsections/header.blade.php ENDPATH**/ ?>