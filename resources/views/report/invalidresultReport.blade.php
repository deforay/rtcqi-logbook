<!--
    Author             : Sakthivel P
    Date               : 21 June 2021
    Description        : Invalid Results report
    Last Modified Date : 17 June 2021
    Last Modified Name : Sakthivel M
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
                        <li class="breadcrumb-item"><a href="/invalidresultreport/">Invalid Results Report</a>
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
                            <h3 class="content-header-title mb-0">Invalid Results Report</h3>
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
                                    <form class="form form-horizontal" role="form" name="invalidResultReportFilter" id="invalidResultReportFilter" method="post" action="/invalidresultexcelexport">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>Start Date <span class="mandatory">*</span>
                                                    </h5>
                                                    <div class="form-group">
                                                        <input type="text" id="startDate" value="<?php echo date('d-m-Y', strtotime('-30 days')); ?>" class="form-control isRequired" autocomplete="off" name="startDate" title="Please select Start Date">
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>End Date <span class="mandatory">*</span>
                                                    </h5>
                                                    <div class="form-group">
                                                        <input type="text" id="endDate" value="<?php echo date('d-m-Y'); ?>" class="form-control isRequired" autocomplete="off" name="endDate" title="Please select End Date">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5>Testing Algothrim
                                                    </h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="algorithmType" name="algorithmType[]" title="Please select Alogrithm Type">
                                                            <option value="serial">Serial</option>
                                                            <option value="parallel">Parallel</option>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <fieldset>
                                                    <h5> Site Name
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

                                            <div class="col-md-7" style="color:#FFF;">
                                                <div class="form-group row">

                                                    <div class="col-md-8">
                                                        <button type="submit" onclick="getInvalidResultReport();return false;" class="btn btn-info"> Search</button>&nbsp;&nbsp;
                                                        <a class="btn btn-danger btn-md" href="/invalidresultreport/"><span>Reset</span></a>&nbsp;&nbsp;
                                                        <button type="submit" class="btn btn-primary">Export</button>
                                                    </div>
                                                </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-t-10">
                        <div id="invalidResultList"></div>
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
        getInvalidResultReport();
        $('.js-example-basic-multiple').select2();
        $selectElement = $('#facilityId').select2({
            placeholder: "Select Facility Name",
            allowClear: true,
        });
        $('#facilityId').on('select2:select', function(e) {
            getInvalidResultReport();
        });

        $('#facilityId').on('select2:unselect', function(e) {
            getInvalidResultReport();

        });
        $selectElement = $('#algorithmType').select2({
            placeholder: "Select Testing Algothrim",
            allowClear: true
        });
        $('#algorithmType').on('select2:select', function(e) {
            getInvalidResultReport();
        });
        $('#algorithmType').on('select2:unselect', function(e) {
            getInvalidResultReport();
        });
        $selectElement = $('#testSiteId').select2({
            placeholder: "Select Test Site Name",
            allowClear: true
        });
        $('#testSiteId').on('select2:select', function(e) {
            getInvalidResultReport();
        });
        $('#testSiteId').on('select2:unselect', function(e) {
            getInvalidResultReport();
        });
    });

    function getInvalidResultReport() {
        startDate = $('#startDate').val();
        endDate = $('#endDate').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getInvalidResultReport') }}",
            method: 'post',
            data: {
                startDate: startDate,
                endDate: endDate,
                facilityId: $("#facilityId").val(),
                algorithmType: $("#algorithmType").val(),
                testSiteId: $("#testSiteId").val(),
            },
            success: function(result) {
                $("#invalidResultList").html(result);
            }
        });
    }

    $(document).ready(function() {
        var date1 = new Date();
        var today = new Date(date1.getFullYear(), date1.getMonth(), date1.getDate());
        $("#startDate").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: today,
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#endDate').datepicker('setStartDate', minDate);
        });

        $("#endDate").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: today,
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#startDate').datepicker('setEndDate', minDate);
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

@endsection