<!--
    Author             : Sakthivel P
    Date               : 18 June 2021
    Description        : Custom Report screen
    Last Modified Date : 18 June 2021
    Last Modified Name : Sakthivel P
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
                        <li class="breadcrumb-item"><a href="/customreport/">Custom Report</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
                <!-- <a href="/userfacilitymap/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                <b><i class="ft-plus icon-left"></i> Add User Facility</b></a> -->
            </div>
        </div>
    </div>
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
                            <h3 class="content-header-title mb-0">Custom Report</h3>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div id="show_alert" class="mt-1" style=""></div>
                                    <h4 class="card-title">Filter the data</h4><br>
                                    <form class="form form-horizontal" role="form" name="customerReportFilter" id="customerReportFilter" method="post" action="/customerexcelexport">
                                        @csrf
                                        <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>Date Range <span class="mandatory">*</span>
                                                    </h5>
                                                    <div class="form-group">
                                                    <input type="text" id="searchDate" name="searchDate" class="form-control" placeholder="Select Date Range" value="{{$startdate}} to {{$enddate}}" />
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>Facilty Name
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="facilityId" name="facilityId[]" title="Please select Facility Name">
                                                            @foreach($facility as $row)
                                                            <option value="{{$row->facility_id}}">{{$row->facility_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>Testing Algothrim
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="algorithmType" name="algorithmType[]" title="Please select Algorithm Type">
                                                            <option value="serial">Serial</option>
                                                            <option value="parallel">Parallel</option>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>Select Report
                                                    </h5>
                                                    <div class="form-group">
                                                        <select class="js-example-basic-single form-control" autocomplete="off" style="width:100%;" id="report" name="report" title="Please select Report">
                                                            <option value="district">District</option>
                                                            <option value="province">Province</option>
                                                            <option value="sitetype">Site Type</option>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12" id="siteName" style="display:none;">
                                                <fieldset>
                                                    <h5>Test Site Name
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="testSiteId" name="testSiteId[]" title="Please select Test Site Name">
                                                            @foreach($testSite as $row)
                                                            <option value="{{$row->ts_id}}">{{$row->site_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12" id="districtName" style="display:none;">
                                                <fieldset>
                                                    <h5>District Name
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="districtId" name="districtId[]" title="Please select District  Name">
                                                            @foreach($district as $row)
                                                            <option value="{{$row->district_id}}">{{$row->district_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12" id="provinceName" style="display:none;">
                                                <fieldset>
                                                    <h5>Province Name
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId[]" title="Please select Province Name">
                                                            @foreach($province as $row)
                                                            <option value="{{$row->provincesss_id}}">{{$row->province_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>Report Frequency
                                                    </h5>
                                                    <div class="form-group">
                                                        <select class="form-control" autocomplete="off" style="width:100%;" id="reportFrequency" name="reportFrequency" title="Please select Report Frequency">
                                                            <option selected value="monthly">Monthly</option>
                                                            <option value="quaterly">Quarterly</option>
                                                            <option value="yearly">Yearly</option>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="form-group row">

                                                    <div class="col-md-8">
                                                        <button type="submit" onclick="getCustomReport();return false;" class="btn btn-info"> Search</button>&nbsp;&nbsp;
                                                        <a class="btn btn-danger btn-md" href="/customreport"><span>Reset</span></a>&nbsp;&nbsp;
                                                        <button type="submit" class="btn btn-primary">Export</button>
                                                    </div>
                                                </div></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-t-10">
                        <div id="customList"></div>
                    </div>
                </div>
            </div>
    </div>
    </section>
</div>
</div>
<style>
    .select2-selection__clear {
        display: none;
    }
</style>
<script>
    $(document).ready(function() {
        getCustomReport();
        $('.js-example-basic-multiple').select2();
        $selectElement = $('#facilityId').select2({
            placeholder: "Select Facility Name",
            allowClear: true
        });
        $('#facilityId').on('select2:select', function(e) {
            getCustomReport();
        });

        $('#facilityId').on('select2:unselect', function(e) {
            getCustomReport();

        });
        $selectElement = $('#algorithmType').select2({
            placeholder: "Select Testing Algothrim",
            allowClear: true
        });
        $('#algorithmType').on('select2:select', function(e) {
            getCustomReport();
        });
        $('#algorithmType').on('select2:unselect', function(e) {
            getCustomReport();
        });
        $('#reportFrequency').on('change', function() {
            getCustomReport();
        });
        $('.js-example-basic-single').select2();
        $selectElement = $('#report').prepend('<option selected></option>').select2({
            placeholder: "Select Report"
        });
    });

    //   duplicateName = true;

    $(document).ready(function() {
        $('#searchDate').daterangepicker({
                format: 'DD-MMM-YYYY',
                autoUpdateInput: false,
                separator: ' to ',
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                maxDate: moment(),
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'Last 60 Days': [moment().subtract('days', 59), moment()],
                    'Last 180 Days': [moment().subtract('days', 179), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
                    'Last 3 Months': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                }
            },
            function(start, end) {
                startDate = start.format('YYYY-MM-DD');
                endDate = end.format('YYYY-MM-DD');
                $('input[name="searchDate"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD-MMM-YYYY') + ' to ' + picker.endDate.format('DD-MMM-YYYY'));
                });
            });
    });

    function logData(siteId) {
        startDate = $('#startDate').val();
        endDate = $('#endDate').val();
        localStorage.setItem('date1', startDate);
        localStorage.setItem('date2', endDate);
        localStorage.setItem('site', siteId);
        window.open('/report/logbook');

    }

    $(document).ready(function() {
        $('#report').on('change', function() {
            if (this.value == 'sitetype') {
                $("#siteName").show();
                $('#districtId').val('');
                getCustomReport();
                $('#provinceId').val('');
                getCustomReport();
                $("#provinceName").hide();
                $("#districtName").hide();
                $selectElement = $('#testSiteId').select2({
                    placeholder: "Select Test Site Name",
                    allowClear: true
                });
                $('#testSiteId').on('select2:select', function(e) {
                    getCustomReport();
                });
                $('#testSiteId').on('select2:unselect', function(e) {
                    getCustomReport();
                });
            }
            if (this.value == 'district') {
                $("#districtName").show();
                $('#testSiteId').val('');
                getCustomReport();
                $('#provinceId').val('');
                getCustomReport();
                $("#provinceName").hide();
                $("#siteName").hide();
                $selectElement = $('#districtId').select2({
                    placeholder: "Select District Name",
                    allowClear: true
                });
                $('#districtId').on('select2:select', function(e) {
                    getCustomReport();
                });
                $('#districtId').on('select2:unselect', function(e) {
                    getCustomReport();
                });
            }
            if (this.value == 'province') {
                $("#provinceName").show();
                $('#districtId').val('');
                getCustomReport();
                $('#testSiteId').val('');
                getCustomReport();
                $("#districtName").hide();
                $("#siteName").hide();
                $selectElement = $('#provinceId').select2({
                    placeholder: "Select Province Name",
                    allowClear: true
                });
                $('#provinceId').on('select2:select', function(e) {
                    getCustomReport();
                });
                $('#provinceId').on('select2:unselect', function(e) {
                    getCustomReport();
                });
            }

        });
    });

    function getCustomReport() {
        let searchDate = $('#searchDate').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getCustomMonthlyReport') }}",
            method: 'post',
            data: {
                searchDate: searchDate,
                facilityId: $("#facilityId").val(),
                algorithmType: $("#algorithmType").val(),
                testSiteId: $("#testSiteId").val(),
                provinceId: $("#provinceId").val(),
                districtId: $("#districtId").val(),
                reportFrequency: $("#reportFrequency").val(),
            },
            success: function(result) {
                $("#customList").html(result);
            }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

@endsection