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
?>

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/monthlyreport/">Not Upload Monthly Reports</a>
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
                    <b><i class="la la-upload"></i> Bulk Upload Monthly Reports</b>
                <?php } ?>
                </a>
                <?php $role = session('role');
                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['add']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['add'] == "allow")) {?>
                <a href="/monthlyreport/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                    <b><i class="ft-plus icon-left"></i> Add Monthly Report</b>
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
                            <h3 class="content-header-title mb-0">Not Upload Monthly Report</h3>
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
                                   
                                <p class="card-text"></p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="mothlyreportList">
                                        <thead>
                                            <tr>
                                                <th>Site Name</th>
                                                <th>Site Type</th>
                                                <th>Facility</th>
                                                <th>Province Name</th>
                                                <th>Site Manager</th>
                                                <th>Site Unique Id</th>
                                                <th>Tester Name</th>
                                                <th>Reporting Month</th>
                                                <th>Date of Data Collection</th>
                                                <th>Name of Data Collector</th>
                                                <th>Book No</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Uploaded On</th>
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
       
       
    });

    function getAllMonthlyReport() {
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
                url: '{{ url("getAllNotUploadMonthlyReport") }}',
                type: 'POST',
                data: {
                    
                },
            },
            columns: [

                {
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
                    name: 'date_of_data_collection'
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
                    name: 'end_test_date'
                },
                {
                    data: 'added_on',
                    name: 'added_on',render: function(data, type, full) {
                        return moment(new Date(data)).format('DD-MMM-YYYY H:m:s');
                    }
                },
                
            ],
            order: [
                [13, 'desc']
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
