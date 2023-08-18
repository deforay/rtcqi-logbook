<!--
    Author             : Prasath M
    Date               : 02 Jun 2021
    Description        : Monthly reports view screen
    Last Modified Date : 02 Jun 2021
    Last Modified Name : Prasath M
-->

@extends('layouts.main')

@section('content')

<?php
$enddate = date('d-M-Y');
$startdate = date('d-M-Y', strtotime('-29 days'));
$messages=Lang::get('messages');
?>

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">{{ $messages['manage']}}
                        </li>
                        <li class="breadcrumb-item"><a href="/monthlyreport/">{{ $messages['monthly_report']}}</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
            <?php $role = session('role');
                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['bulk']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['bulk'] == "allow")) {?>
                <a href="/monthlyreportdata" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                    <b><i class="la la-upload"></i> {{ $messages['bulk_upload_monthly_reports']}}</b>
                <?php } ?>
                </a>
                <?php $role = session('role');
                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['add']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['add'] == "allow")) {?>
                <a href="/monthlyreport/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                    <b><i class="ft-plus icon-left"></i> {{ $messages['add_monthly_report']}}</b>
                <?php } ?>
                </a>
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
                            <h3 class="content-header-title mb-0">{{ $messages['monthly_report']}}</h3>
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
                                    <h4 class="card-title">{{ $messages['filter_the_data']}}</h4><br>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ $messages['date_range']}} <span class="mandatory">*</span>
                                                    </h5>
                                                    <div class="form-group">
                                                    <input type="text" id="searchDate" name="searchDate" style="padding-top: 1.47rem;padding-right: 0.75rem;padding-bottom: 1.47rem;padding-left: 0.75rem;" class="form-control" placeholder="{{ $messages['select_date_range']}}" value="{{$startdate}} to {{$enddate}}" />
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                <h5>{{ $messages['province_name']}}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId[]" title="{{ $messages['please_select_province_name']}}">
                                                            @foreach($province as $row)
                                                            <option value="{{$row->province_id}}">{{$row->province_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ $messages['district_name']}}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="districtId" name="districtId[]" title="{{ $messages['please_select_district_name']}}">
                                                            @foreach($district as $row)
                                                            <option value="{{$row->district_id}}">{{$row->district_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>{{ $messages['sub_district_name']}}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="subDistrictId" name="subDistrictId[]" title="{{ $messages['please_select_sub_district_name']}}">
                                                            @foreach($subdistrict as $row)
                                                            <option value="{{$row->sub_district_id}}">{{$row->sub_district_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5> {{ $messages['site_name']}}
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="testSiteId" name="testSiteId[]" title="{{ $messages['please_select_test_site_name']}}">
                                                            @foreach($testSite as $row)
                                                            <option value="{{$row->ts_id}}">{{$row->site_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-7" style="color:#FFF;">
                                                <div class="form-group row">

                                                    <div class="col-md-8">
                                                        <button type="submit" onclick="getAllMonthlyReport();return false;" class="btn btn-info"> {{ $messages['search']}}</button>&nbsp;&nbsp;
                                                        <a class="btn btn-danger btn-md" href="/monthlyreport"><span>{{ $messages['reset']}}</span></a>&nbsp;&nbsp;
                                                    </div>
                                                </div></div>
                                        </div>
                                <p class="card-text"></p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="mothlyreportList">
                                        <thead>
                                            <tr>
                                                <th>{{ $messages['site_name']}}</th>
                                                <th>{{ $messages['entry_point']}}</th>
                                                <th>{{ $messages['reporting_month']}}</th>
                                                <th>{{ $messages['date_of_data_collection']}}</th>
                                                <th>{{ $messages['name_of_data_collector']}}</th>
                                                <th>{{ $messages['book_number']}}</th>
                                                <th>{{ $messages['start_date']}}</th>
                                                <th>{{ $messages['end_date']}}</th>
                                                <th>{{ $messages['total_number_of_pages']}}</th>
                                                <th>{{ $messages['last_modified_on']}}</th>
                                                <?php $role = session('role');
                                                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit'] == "allow")) {?>
                                                <th>{{ $messages['action']}}</th>
                                                <?php } ?>
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
<script>
    $(document).ready(function() {
        $.blockUI();
        getAllMonthlyReport();
        $.unblockUI();
        $('.js-example-basic-multiple').select2();
        $selectElement = $('#provinceId').select2({
            placeholder: "{{ $messages['select_province_name']}}",
            allowClear: true,
        });
        $('#provinceId').on('select2:select', function(e) {
            getAllMonthlyReport();
        });

        $('#provinceId').on('select2:unselect', function(e) {
            getAllMonthlyReport();

        });
        $selectElement = $('#districtId').select2({
            placeholder: "{{ $messages['select_district_name']}}",
            allowClear: true,
        });
        $('#districtId').on('select2:select', function(e) {
            getAllMonthlyReport();
        });

        $('#districtId').on('select2:unselect', function(e) {
            getAllMonthlyReport();

        });
        $selectElement = $('#subDistrictId').select2({
            placeholder: "{{ $messages['select_sub_district_name']}}",
            allowClear: true,
        });
        $('#subDistrictId').on('select2:select', function(e) {
            getAllMonthlyReport();
        });

        $('#subDistrictId').on('select2:unselect', function(e) {
            getAllMonthlyReport();

        });
        $selectElement = $('#testSiteId').select2({
            placeholder: "{{ $messages['select_test_site_name']}}",
            allowClear: true
        });
        $('#testSiteId').on('select2:select', function(e) {
            getAllMonthlyReport();
        });
        $('#testSiteId').on('select2:unselect', function(e) {
            getAllMonthlyReport();
        });
    });

    function getAllMonthlyReport() {
        let searchDate = $('#searchDate').val() || '';
        let provinceId = $('#provinceId').val() || '';
        let districtId = $('#districtId').val() || '';
        let subDistrictId = $('#subDistrictId').val() || '';
        let testSiteId = $('#testSiteId').val() || '';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#mothlyreportList').DataTable({
            processing: true,
            destroy: true,
            serverSide: true,
            scrollX: false,
            autoWidth: false,
            ajax: {
                url: '{{ url("getAllMonthlyReport") }}',
                type: 'POST',
                data: {
                searchDate: searchDate,
                provinceId: provinceId,
                districtId: districtId,
                subDistrictId: subDistrictId,
                testSiteId: testSiteId,
                },
            },
            columns: [

                {
                    data: 'site_name',
                    name: 'site_name',
                    className: 'firstcaps'
                },

                {
                    data: 'site_type_name',
                    name: 'site_type_name',
                    className: 'firstcaps'
                },

                {
                    data: 'reporting_month',
                    name: 'reporting_month'
                },

                {
                    data: 'date_of_data_collection',
                    name: 'date_of_data_collection',render: function(data, type, full) {
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
                    name: 'start_test_date',render: function(data, type, full) {
     return moment(new Date(data)).format('DD-MMM-YYYY');
                    }
                },

                {
                    data: 'end_test_date',
                    name: 'end_test_date',render: function(data, type, full) {
     return moment(new Date(data)).format('DD-MMM-YYYY');
                    }
                },

                {
                    data: 'page_no',
                    name: 'page_no'
                },
                {
                    data: 'last_modified_on',
                    name: 'last_modified_on',render: function(data, type, full) {
     return moment(new Date(data)).format('DD-MMM-YYYY HH:mm:ss');
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [9, 'desc']
            ]
        });
    }
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
@endsection
