<!--
    Author             : Prasath M
    Date               : 02 Jun 2021
    Description        : Monthly reports view screen
    Last Modified Date : 02 Jun 2021
    Last Modified Name : Prasath M
-->

@extends('layouts.main')

@section('content')


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/monthlyreport/">Monthly Reports</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
                <a href="/monthlyreportdata" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                    <b><i class="la la-upload"></i> Bulk Upload Monthly Reports</b>
                </a>
                <a href="/monthlyreport/add" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                    <b><i class="ft-plus icon-left"></i> Add Monthly Report</b>
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
                            <h3 class="content-header-title mb-0">Monthly Report</h3>
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
                                <p class="card-text"></p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="mothlyreportList">
                                        <thead>
                                            <tr>
                                                <th>Site Name</th>
                                                <th>Site Type</th>
                                                <th>Reporting Month</th>
                                                <th>Date of Data Collection</th>
                                                <th>Name of Data Collector</th>
                                                <th>Book No</th>
                                                <th>Total Number of Pages</th>
                                                <th>Last Modified On</th>
                                                <th>Action</th>
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
                url: '{{ url("getAllMonthlyReport") }}',
                type: 'POST',
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
                    data: 'page_no',
                    name: 'page_no'
                },
                {
                    data: 'last_modified_on',
                    name: 'last_modified_on'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [7, 'desc']
            ]
        });
    }
</script>
@endsection
