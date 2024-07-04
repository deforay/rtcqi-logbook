<!--
    Author             : Sakthivel P
    Date               : 16 June 2021
    Description        : {{ __('messages.test_kit_use_report') }} screen
    Last Modified Date : 16 June 2021
    Last Modified Name : Sakthivel P
-->

@extends('layouts.main')

@section('content')

<?php
$enddate = date('d-M-Y', strtotime('last day of previous month'));
$startdate = date('01-M-Y', strtotime('-18 months'));

?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">{{ __('messages.manage') }}
                        </li>
                        <li class="breadcrumb-item"><a href="/testKitReport/">{{ __('messages.test_kit_use_report') }}</a>
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
                            <h3 class="content-header-title mb-0">{{ __('messages.test_kit_use_report') }}</h3>
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
                                    <h4 class="card-title">{{ __('messages.filter_the_data') }}</h4><br>
                                    <form class="form form-horizontal" role="form" name="testKitReportFilter" id="testKitReportFilter" method="post" action="/testkitexcelexport">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.date_range') }} <span class="mandatory">*</span>
                                                    </h5>
                                                    <div class="form-group">
                                                    <input type="text" id="searchDate" name="searchDate" class="form-control" placeholder="Select {{ __('messages.date_range') }}" value="{{$startdate}} to {{$enddate}}" />
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                <h5>{{ __('messages.province_name') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId[]" title="Please select {{ __('messages.province_name') }}">
                                                            @foreach($province as $row)
                                                            <option value="{{$row->province_id}}">{{$row->province_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.district_name') }}
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
                                        </div>
                                        <div class ="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.sub_district_name') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="subDistrictId" name="subDistrictId[]" title="Please select Sub District  Name">
                                                            @foreach($subdistrict as $row)
                                                            <option value="{{$row->sub_district_id}}">{{$row->sub_district_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.testing_algorithm') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="algorithmType" name="algorithmType[]" title="Please select Algorithm Type">
                                                        @if(in_array("serial",$testingAlgorithm))
                                                        <option value="serial">Serial</option>
                                                        @endif
                                                        @if(in_array("parallel",$testingAlgorithm))
                                                        <option value="parallel">Parallel</option>
                                                        @endif
                                                        @if(in_array("who3",$testingAlgorithm))
                                                        <option value="who3">WHO 3</option>
                                                        @endif
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.test_site_name') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="testSiteId" name="testSiteId[]" title="Please select {{ __('messages.test_site_name') }}">
                                                            @foreach($testSite as $row)
                                                            <option value="{{$row->ts_id}}">{{$row->site_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ __('messages.report_frequency') }}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select class="form-control" autocomplete="off" style="width:100%;" id="reportFrequency" name="reportFrequency" title="Please select {{ __('messages.report_frequency') }}">
                                                            <option selected value="monthly">Monthly</option>
                                                            <option value="quaterly">Quarterly</option>
                                                            <option value="yearly">Yearly</option>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-7" style="color:#FFF;">
                                                <div class="form-group row">

                                                    <div class="col-md-8">
                                                        <button type="submit" onclick="getTestKitReport();return false;" class="btn btn-info"> {{ __('messages.search') }}</button>&nbsp;&nbsp;
                                                        <a class="btn btn-danger btn-md" href='/testKitReport/'><span>Reset</span></a>&nbsp;&nbsp;
                                                        <?php $role = session('role');
                                                        if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['testkitexport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['testkitexport'] == "allow")) {?>
                                                        <button type="submit" name="exportReport" class="btn btn-primary">{{ __('messages.export') }}</button>
                                                        <button type="submit" name="exportSummaryReport" class="btn btn-primary">{{ __('messages.export_test_kit_summary') }}</button>
                                                       <?php } ?>
                                                    </div>
                                                </div>
                                            </div></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-t-10">
                        <div id="testKitList"></div>
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
    //   function exportF(elem) {
    //     startDate = $('#startDate').val();
    //       endDate = $('#endDate').val();
    //         $.ajaxSetup({
    //           headers: {
    //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //           }
    //       });
    //       $.ajax({
    //           url: "{{ url('/testpageexcel') }}",
    //           method: 'post',
    //           data : {
    //                     startDate:startDate,
    //                     endDate:endDate,
    //                     facilityId: $("#facilityId").val(),
    //                     algorithmType: $("#algorithmType").val(),
    //                     testSiteId: $("#testSiteId").val(),
    //                     reportFrequency: $("#reportFrequency").val(),
    //           },
    //           success: function(result){
    //           }
    //         });
    // 	}


    $(document).ready(function() {
        getTestKitReport();
        $('.js-example-basic-multiple').select2();
        $selectElement = $('#provinceId').select2({
            placeholder: "Select {{ __('messages.province_name') }}",
            allowClear: true,
        });
        $('#provinceId').on('select2:select', function(e) {
            getTestKitReport();
        });

        $('#provinceId').on('select2:unselect', function(e) {
            getTestKitReport();

        });
        $selectElement = $('#districtId').select2({
            placeholder: "Select District Name",
            allowClear: true,
        });
        $('#districtId').on('select2:select', function(e) {
            getTestKitReport();
        });

        $('#districtId').on('select2:unselect', function(e) {
            getTestKitReport();

        });
        $selectElement = $('#subDistrictId').select2({
            placeholder: "Select {{ __('messages.sub_district_name') }}",
            allowClear: true,
        });
        $('#subDistrictId').on('select2:select', function(e) {
            getTestKitReport();
        });

        $('#subDistrictId').on('select2:unselect', function(e) {
            getTestKitReport();

        });
        $selectElement = $('#algorithmType').select2({
            placeholder: "Select {{ __('messages.testing_algorithm') }}",
            allowClear: true
        });
        $('#algorithmType').on('select2:select', function(e) {
            getTestKitReport();
        });
        $('#algorithmType').on('select2:unselect', function(e) {
            getTestKitReport();
        });
        $selectElement = $('#testSiteId').select2({
            placeholder: "Select {{ __('messages.test_site_name') }}",
            allowClear: true
        });
        $('#testSiteId').on('select2:select', function(e) {
            getTestKitReport();
        });
        $('#testSiteId').on('select2:unselect', function(e) {
            getTestKitReport();
        });
        $('#reportFrequency').on('change', function() {
            getTestKitReport();
        });
    });
    //   duplicateName = true;
    function getTestKitReport() {
        // flag = deforayValidator.init({
        //     formId: 'trendReportFilter'
        // });

        // if (flag == true) {
        //     if (duplicateName) {
        //         document.getElementById('trendReportFilter').submit();
        //     }
        // }
        // else{
        //     // Swal.fire('Any fool can use a computer');
        //     $('#show_alert').html(flag).delay(3000).fadeOut();
        //     $('#show_alert').css("display","block");
        //     $(".infocus").focus();
        // }
        let searchDate = $('#searchDate').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getTestKitMonthlyReport') }}",
            method: 'post',
            data: {
                searchDate: searchDate,
                provinceId: $("#provinceId").val(),
                districtId: $("#districtId").val(),
                subDistrictId: $("#subDistrictId").val(),
                algorithmType: $("#algorithmType").val(),
                testSiteId: $("#testSiteId").val(),
                reportFrequency: $("#reportFrequency").val(),
            },
            error:function(e){
                console.log(e)
            },
            success: function(result) {
                $("#testKitList").html(result);
            }
        });
    }

    function clearStatus() {
        $.blockUI();
        getTestKitReport();
        $.unblockUI();
        $("#startDate").val("");
        $("#endDate").val("");
        $("#facilityId").val('').trigger('change');
        $("#algorithmType").val('').trigger('change');
        $("#testSiteId").val('').trigger('change');
    }

    $(document).ready(function() {
        $('#searchDate').daterangepicker({
                format: 'DD-MMM-YYYY',
                autoUpdateInput: false,
                separator: ' to ',
                startDate: moment().subtract(18, 'month').startOf('month'),
                endDate: moment().subtract(1, 'month').endOf('month'),
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
                    'Last 6 Months': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 9 Months': [moment().subtract(9, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 12 Months': [moment().subtract(12, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 18 Months': [moment().subtract(18, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

@endsection
