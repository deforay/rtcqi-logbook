<!--
    Author             : Sijulda M
    Date               : 10 June 2021
    Description        : Logbook report
    Last Modified Date : 17 June 2021
    Last Modified Name : Sakthivel M
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
                        <li class="breadcrumb-item active">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/notreportedsites/">Not Reported Sites</a>
                        </li>
                    </ol>
                </div>
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
                            <h3 class="content-header-title mb-0">Not Reported Sites</h3>
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
                                    <form class="form form-horizontal" role="form" name="notReportedSitesFilter" id="notReportedSitesFilter" method="post" action="/notreportedsitesexcelexport">
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
                                                <h5>Province Name
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId[]" title="Please select Province Name">
                                                            @foreach($province as $row)
                                                            <option value="{{$row->province_id}}">{{$row->province_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
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
                                        </div>
                                        <div class ="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>Sub District Name
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="subDistrictId" name="subDistrictId[]" title="Please select Sub District Name">
                                                            @foreach($subdistrict as $row)
                                                            <option value="{{$row->sub_district_id}}">{{$row->sub_district_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-7" style="color:#FFF;">
                                                <div class="form-group row">
                                                    <div class="col-md-8">
                                                        <button type="submit" onclick="getNotReportedSites();return false;" class="btn btn-info"> Search</button>&nbsp;&nbsp;
                                                        <a class="btn btn-danger btn-md" href="/notreportedsites"><span>Reset</span></a>&nbsp;&nbsp;
                                                        <?php $role = session('role');
                                                        if (isset($role['App\\Http\\Controllers\\Report\\ReportController']['notreportedsitesexport']) && ($role['App\\Http\\Controllers\\Report\\ReportController']['notreportedsitesexport'] == "allow")) {?>
                                                        <button type="submit" class="btn btn-primary">Export</button>
                                                       <?php } ?>
                                                    </div>
                                                </div></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-t-10">
                        <div id="notReportedSitesList"></div>
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
        getNotReportedSites();
        $('.js-example-basic-multiple').select2();
        $selectElement = $('#provinceId').select2({
            placeholder: "Select Province Name",
            allowClear: true,
        });
        $('#provinceId').on('select2:select', function(e) {
            getNotReportedSites();
        });

        $('#provinceId').on('select2:unselect', function(e) {
            getNotReportedSites();

        });
        $selectElement = $('#districtId').select2({
            placeholder: "Select District Name",
            allowClear: true,
        });
        $('#districtId').on('select2:select', function(e) {
            getNotReportedSites();
        });

        $('#districtId').on('select2:unselect', function(e) {
            getNotReportedSites();

        });
        $selectElement = $('#subDistrictId').select2({
            placeholder: "Select Sub District Name",
            allowClear: true,
        });
        $('#subDistrictId').on('select2:select', function(e) {
            getNotReportedSites();
        });

        $('#subDistrictId').on('select2:unselect', function(e) {
            getNotReportedSites();

        });
        
    });

    function getNotReportedSites() {
        let searchDate = $('#searchDate').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getNotReportedSites') }}",
            method: 'post',
            data: {
                searchDate: searchDate,
                provinceId: $("#provinceId").val(),
                districtId: $("#districtId").val(),
                subDistrictId: $("#subDistrictId").val(),                
            },
            error:function(e){
                //alert('happened error');
                console.log(e);
            },
            success: function(result) {
                //console.log('not reported list', result);
                $("#notReportedSitesList").html(result);
            }
        });
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

    $(document).ready(function() {
        var startDate = localStorage.getItem('date1');
        var endDate = localStorage.getItem('date2');
        var data = localStorage.getItem('site');
        // alert(data);
        if (startDate != null && endDate != null && data != null) {
            $("#startDate").val(startDate);
            $("#endDate").val(endDate);
            $("#testSiteId").val(data).trigger('change');
            window.localStorage.removeItem('date1');
            window.localStorage.removeItem('date2');
            window.localStorage.removeItem('site');
        }

    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

@endsection