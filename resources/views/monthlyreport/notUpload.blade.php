<!--

    Date               : 02 Jun 2021
    Description        : {{ __('messages.monthly_report') }}s view screen
    Last Modified Date : 02 Jun 2021

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
                        <li class="breadcrumb-item active">{{ __('messages.manage') }}
                        </li>
                        <li class="breadcrumb-item"><a href="/monthlyreport/">{{ __('messages.failed_imports_excel_upload') }}</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
                <?php $role = session('role');
                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['bulk']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['bulk'] == "allow")) { ?>
                    <a href="/monthlyreportdata" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                        <b><i class="la la-upload"></i> {{ __('messages.bulk_upload_monthly_reports') }}</b>

                    </a>
                <?php } ?>
                <?php $role = session('role');
                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['add']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['add'] == "allow")) { ?>
                    <a href="/monthlyreport/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                        <b><i class="ft-plus icon-left"></i> {{ __('messages.add') }} {{ __('messages.monthly_report') }}</b>
                    </a>
                <?php } ?>
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
                            <h3 class="content-header-title mb-0">{{ __('messages.failed_imports_excel_upload') }}</h3>
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
                            <div class="text-right mr-2 mt-2">

                            </div>
                            <div class="card-body card-dashboard">
                                <div id="show_alert" class="mt-1"></div>
                                <h4 class="card-title">{{ __('messages.filter_the_data') }}</h4><br>
                                <form name="trendReportFilter" id="trendReportFilter" method="post" action="/notuploadexcelexport">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.date_range') }} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="searchDate" name="searchDate" style="padding-top: 1.47rem;padding-right: 0.75rem;padding-bottom: 1.47rem;padding-left: 0.75rem;" class="form-control" placeholder="Select {{ __('messages.date_range') }}" value="{{$startdate}} to {{$enddate}}" />
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5>{{ __('messages.province_name') }}
                                                </h5>
                                                <div class="form-group">
                                                    <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="provinceName" name="provinceName[]" title="Please select {{ __('messages.province_name') }}">
                                                        @foreach($province as $row)
                                                        <option value="{{$row->province_name}}">{{$row->province_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <!-- <div class="col-xl-4 col-lg-12">
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
                                                </div> -->

                                        <div class="col-xl-4 col-lg-12">
                                            <fieldset>
                                                <h5> {{ __('messages.site_name') }}
                                                </h5>
                                                <div class="form-group">
                                                    <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="testSiteName" name="testSiteName[]" title="Please select Test {{ __('messages.site_name') }}">
                                                        @foreach($testSite as $row)
                                                        <option value="{{$row->test_site_name}}">{{$row->test_site_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-7" style="color:#FFF;">
                                            <div class="form-group row">

                                                <div class="col-md-7">
                                                    <div class="row" style="padding-left:15px;">
                                                        <div class="display-inline">
                                                            <button type="submit" onclick="getAllMonthlyReport();return false;" class="btn btn-info"> {{ __('messages.search') }}</button>
                                                        </div>
                                                        <div class="display-inline ml-2">
                                                            <a class="btn btn-danger btn-md" href="/monthlyreport/notUpload"><span>{{ __('messages.reset') }}</span></a>
                                                        </div>
                                                        <div class="display-inline ml-2">

                                                            <?php $role = session('role');
                                                            if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['notUploadExport']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['notUploadExport'] == "allow")) { ?>
                                                                <button type="submit" class="btn btn-primary">{{ __('messages.export') }}</button>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="card-text"></p>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration" id="monthlyreportList">

                                            <thead>
                                                <tr>
                                                    <th>{{ __('messages.site_name') }}</th>
                                                    <th>{{ __('messages.site_type') }}</th>
                                                    <th>{{ __('messages.facility') }}</th>
                                                    <th>{{ __('messages.province_name') }}</th>
                                                    <th>{{ __('messages.site_manager') }}</th>
                                                    <th>{{ __('messages.site_unique_id') }}</th>
                                                    <th>{{ __('messages.tester_name') }}</th>
                                                    <th>{{ __('messages.reporting_month') }}</th>
                                                    <th>{{ __('messages.date_of_data_collection') }}</th>
                                                    <th>{{ __('messages.name_of_data_collector') }}</th>
                                                    <th>{{ __('messages.book_no') }}</th>
                                                    <th>{{ __('messages.start_date') }}</th>
                                                    <th>{{ __('messages.end_date') }}</th>
                                                    <th>{{ __('messages.comment') }}</th>
                                                    <th>{{ __('messages.uploaded_on') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
</div>
</div>
<script>
    $(document).ready(function() {

        $.blockUI();
        getAllMonthlyReport();
        $.unblockUI();
        $('.js-example-basic-multiple').select2();
        $selectElement = $('#provinceName').select2({
            placeholder: "Select {{ __('messages.province_name') }}",
            allowClear: true,
        });
        $('#provinceName').on('select2:select', function(e) {
            getAllMonthlyReport();
        });

        $('#provinceName').on('select2:unselect', function(e) {
            getAllMonthlyReport();

        });
        $selectElement = $('#districtId').select2({
            placeholder: "Select District Name",
            allowClear: true,
        });
        $('#districtId').on('select2:select', function(e) {
            getAllMonthlyReport();
        });

        $('#districtId').on('select2:unselect', function(e) {
            getAllMonthlyReport();

        });
        $selectElement = $('#testSiteName').select2({
            placeholder: "Select Test {{ __('messages.site_name') }}",
            allowClear: true
        });
        $('#testSiteName').on('select2:select', function(e) {
            getAllMonthlyReport();
        });
        $('#testSiteName').on('select2:unselect', function(e) {
            getAllMonthlyReport();
        });
        $.unblockUI();
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

    function getAllMonthlyReport() {
        let searchDate = $('#searchDate').val() || '';
        let provinceName = $('#provinceName').val() || '';
        let testSiteName = $('#testSiteName').val() || '';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#monthlyreportList').DataTable({
            processing: true,
            destroy: true,
            serverSide: true,
            scrollX: false,
            autoWidth: false,
            ajax: {
                url: '{{ url("getAllNotUploadMonthlyReport") }}',
                type: 'POST',
                data: {
                    searchDate: searchDate,
                    provinceName: provinceName,
                    testSiteName: testSiteName,
                },

            },
            columns: [{
                    data: 'test_site_name',
                    name: 'test_site_name',
                    className: 'firstcaps'
                },
                {
                    data: 'site_type',
                    name: 'site_type',
                    className: 'firstcaps'
                },
                {
                    data: 'facility',
                    name: 'facility',
                },
                {
                    data: 'province_name',
                    name: 'province_name',
                },
                {
                    data: 'site_manager',
                    name: 'site_manager',
                },
                {
                    data: 'site_unique_id',
                    name: 'site_unique_id',
                },
                {
                    data: 'tester_name',
                    name: 'tester_name'
                },
                {
                    data: 'reporting_month',
                    name: 'reporting_month'
                },
                {
                    data: 'date_of_data_collection',
                    name: 'date_of_data_collection',
                    render: function(data, type, full) {
                        return moment(new Date(data)).format('DD-MMM-YYYY');
                    }
                },
                {
                    data: 'name_of_data_collector',
                    name: 'name_of_data_collector'
                },
                {
                    data: 'book_no',
                    name: 'book_no'
                },
                {
                    data: 'start_test_date',
                    name: 'start_test_date',
                    render: function(data, type, full) {
                        return moment(new Date(data)).format('DD-MMM-YYYY');
                    }
                },
                {
                    data: 'end_test_date',
                    name: 'end_test_date',
                    render: function(data, type, full) {
                        return moment(new Date(data)).format('DD-MMM-YYYY');
                    }
                },
                {
                    data: 'comment',
                    name: 'comment'
                },
                {
                    data: 'added_on',
                    name: 'added_on',
                    render: function(data, type, full) {
                        return moment(new Date(data)).format('DD-MMM-YYYY H:m:s');
                    }
                },

            ],
            order: [
                [14, 'desc']
            ]
        });
    }
    $(document).ready(function() {
        /*
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
           */
    });
</script>
@endsection
