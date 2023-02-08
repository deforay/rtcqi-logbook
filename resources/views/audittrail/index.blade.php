<!--
    Author             : Sakthi
    Date               : 10 Mar 2022
    Description        : Audit Trail view screen
    Last Modified Date : 10 Mar 2022
    Last Modified Name : Sakthi
-->

@extends('layouts.main')

@section('content')

<?php
$enddate = date('d-M-Y');
$startdate = date('d-M-Y', strtotime('-29 days'));
?>

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/auditTrail/">Audit Trail</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
    <br>
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index">
        <div class="text-center" style=""><b>
                {{ session('status') }}</b></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <script>
        $('#show_alert_index').delay(3000).fadeOut();
    </script>
    @endif
    <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="content-body">
        <!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="content-header-title mb-0">Audit Trail</h3>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                            <div id="show_alert" class="mt-1"></div>
                                    <h4 class="card-title">Filter the data</h4><br>
                                    <form class="form" role="form" name="auditFilter" id="auditFilter" method="post" action="/auditTrail" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>Site Name <span class="mandatory">*</span>
                                                    </h5>
                                                    <div class="form-group">
                                                    <select class="js-example-basic-single form-control isRequired" autocomplete="off" style="width:100%;" id="testsiteId" name="testsiteId" title="Please select Test Site Name">
                                                        @foreach($testSite ?? '' as $row2)
                                                        <option value="{{$row2->ts_id}}">{{$row2->site_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                <h5>Reporting Month
                                                    </h5>
                                                    <div class="form-group">
                                                    <input type="text" id="reportingMon" class="form-control isRequired" autocomplete="off" placeholder="Enter Reporting Month" name="reportingMon" title="Please Enter Reporting Month" >
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-7" style="color:#FFF;">
                                                <div class="form-group row">

                                                    <div class="col-md-8">
                                                        <button type="submit" class="btn btn-info"> Search</button>&nbsp;&nbsp;
                                                        <a class="btn btn-danger btn-md" href="/auditTrail"><span>Reset</span></a>&nbsp;&nbsp;
                                                    </div>
                                                </div></div>
                                        </div>
</form>
                                <p class="card-text"></p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="mothlyreportList">
                                        <thead>
                                            <tr>
                                                <th>Event Type</th>
                                                <th>Action</th>
                                                <th>Resource</th>
                                                <th>IP Address</th>
                                                <th>Date Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
</div>
</div>
<link href="public/dist/css/select2.min.css" rel="stylesheet" />
<script src="public/dist/js/select2.min.js"></script>
<script>
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'auditFilter'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('auditFilter').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }
    $(document).ready(function() {
        $selectElement = $('#testsiteId').prepend('<option selected></option>').select2({
            placeholder: "Select Site Name"
        });
        $.blockUI();
        $.unblockUI();
        $('.js-example-basic-multiple').select2();
        $selectElement = $('#userId').select2({
            placeholder: "Select User Name",
            allowClear: true,
        });
       
        $('#reportingMon').datepicker({
            autoclose: true,
            format: 'M-yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            viewMode: "months",
            minViewMode: "months",
            // startDate:'today',
            todayHighlight: true,
            clearBtn: true,
        })
   /* .on('changeDate', checkExistingReportingMonth);

        $(".dates").datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
        });*/

    });

   
</script>
@endsection
