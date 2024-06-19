<!--
    Author             : ilahir
    Date               : 18 Dec 2023
    Description        : {{ __('messages.site_wise_report') }}
    Last Modified Date : 18 Dec 2023
    Last Modified Name : ilahir
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
                        <li class="breadcrumb-item"><a href="{{ url('sitewisereport') }}">{{ __('messages.site_wise_report') }}</a>
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
                            <h3 class="content-header-title mb-0">{{ __('messages.site_wise_report') }}</h3>
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
                                    <form class="form form-horizontal" role="form" name="trendReportFilter" id="trendReportFilter" method="post" action="/sitewisereportexport">
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
                                           
                                            <div class="col-md-12" style="color:#FFF;">
                                                <div class="form-group row">

                                                    <div class="col-md-8">
                                                        <button type="submit" onclick="getSitewiseReport();return false;" class="btn btn-info"> Search</button>&nbsp;&nbsp;
                                                        <a class="btn btn-danger btn-md" href='/sitewisereport'><span>Reset</span></a>&nbsp;&nbsp;
                                                        <button type="submit" class="btn btn-primary">Export</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row" id="mailDiv">
                                        <div class="col-xl-12 col-lg-12" >
                                            <fieldset>
                                                <h5>Subject <span class="mandatory">*</span></h5>
                                                <div class="form-group">
                                                    <input type="text" id="mailSubject" name="mailSubject" class="form-control isRequired" title="Please enter the mail subject" placeholder="Please enter the subject" />
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <fieldset>
                                                <h5>Message <span class="mandatory">*</span></h5>
                                                <div class="form-group">
                                                    <textarea class="form-control isRequired" id="message" name="message" title="Please enter the message"  placeholder="Please enter the message"></textarea>
                                                </div>
                                            </fieldset>
                                        </div>
                                    
                                        <div class="col-lg-12" id="siteNameList">
                                            
                                                <fieldset>
                                                    <h5>{{ __('messages.selected_test_site_name') }}</h5>
                                                    <div class="form-group">
                                                        <select multiple="multiple" class="js-example-basic-multiple form-control" autocomplete="off" style="width:100%;" id="selectedTestSiteId" name="selectedTestSiteId[]" title="Please select Test Site Name">
                                                            
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            
                                        </div>
                                        <div class="col-md-12">
                                            <input type="hidden" id="checkedTestSiteId" class="isRequired" title="Please select the test site name"/>
                                            <a class="btn btn-warning btn-md" href='javascript:void(0);' onclick="sendMail()"><span>{{ __('messages.send_mail') }}</span></a>
                                        </div>
                                    </div>
                                    
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive p-t-10">
                        <div id="trendList"></div>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/deforayModal.css')}}">
<script src="{{ asset('assets/js/deforayModal.js') }}"></script>
<script>
    checkedTestSiteId = [];
    $(document).ready(function() {
        $("#provinceId").change(function () {
            var datas = $(this).val();
            //console.log(datas);
            listDistrictForProvince();
        });
        $("#districtId").change(function () {
            var datas = $(this).val();
            //console.log(datas);
            listSubDistrictForDistrict();
        });
        getSitewiseReport();
        $('.js-example-basic-multiple').select2();
        $selectElement = $('#provinceId').select2({
            placeholder: "Select {{ __('messages.province_name') }}",
            allowClear: true,
        });
        $('#provinceId').on('select2:select', function(e) {
            getSitewiseReport();
        });

        $('#provinceId').on('select2:unselect', function(e) {
            getSitewiseReport();

        });
        $selectElement = $('#districtId').select2({
            placeholder: "Select {{ __('messages.district_name') }}",
            allowClear: true,
        });
        $('#districtId').on('select2:select', function(e) {
            getSitewiseReport();
        });

        $('#districtId').on('select2:unselect', function(e) {
            getSitewiseReport();

        });

        $selectElement = $('#subDistrictId').select2({
            placeholder: "Select {{ __('messages.sub_district_name') }}",
            allowClear: true,
        });
        $('#subDistrictId').on('select2:select', function(e) {
            getSitewiseReport();
        });

        $('#subDistrictId').on('select2:unselect', function(e) {
            getSitewiseReport();

        });
        
        $selectElement = $('#testSiteId').select2({
            placeholder: "Select Test Site Name",
            allowClear: true
        });
        $('#testSiteId').on('select2:select', function(e) {
            getSitewiseReport();
        });
        $('#testSiteId').on('select2:unselect', function(e) {
            getSitewiseReport();
        });
        
        $('#selectedTestSiteId').on("select2:unselect", function (e) {
            var data = e.params.data;
            //$('#selectedTestSiteId').select2('destroy').html('')
            //$(e).remove();
            
            removeSitenameLable(data.id);
        });
    });

    function listDistrictForProvince() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getDistrictByProvinceId') }}",
            method: 'post',
            data: {
                provinceId: $("#provinceId").val(),
            },
            success: function(result) {
                var districtsOption = '';
                result.forEach((res)=>{
                    districtsOption += '<option value="'+res.district_id+'">'+res.district_name+'</option>';
                });
                $('#districtId').html(districtsOption);
            }
        });
    }

    function listSubDistrictForDistrict() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getSubDistrictByDistrictId') }}",
            method: 'post',
            data: {
                districtId: $("#districtId").val(),
            },
            success: function(result) {
                console.log('data results', result);
                // console.log($('#districtId').html(''));
                var subDistrictsOption = '';
                result.forEach((res)=>{
                    subDistrictsOption += '<option value="'+res.sub_district_id+'">'+res.sub_district_name+'</option>';
                });
                $('#subDistrictId').html(subDistrictsOption);
            }
        });
    }
    //   duplicateName = true;
    function getSitewiseReport() {
        $.blockUI();
        //$("#siteNameList").empty();
        $("#mailDiv").hide();
        let searchDate = $('#searchDate').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getSiteWiseReport') }}",
            method: 'post',
            data: {
                searchDate: searchDate,
                provinceId: $("#provinceId").val(),
                districtId: $("#districtId").val(),
                subDistrictId: $("#subDistrictId").val(),
                testSiteId: $("#testSiteId").val(),
            },
            success: function(result) {
                $("#trendList").html(result);
                $.unblockUI();
            },
            error:function(e){
                console.log(e);
            }
        });
    }

    function clearStatus() {
        $.blockUI();
        getSitewiseReport();
        $.unblockUI();
        $("#startDate").val("");
        $("#endDate").val("");
        $("#facilityId").val('').trigger('change');
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

    function logData(siteId) {
        startDate = $('#startDate').val();
        endDate = $('#endDate').val();
        localStorage.setItem('date1', startDate);
        localStorage.setItem('date2', endDate);
        localStorage.setItem('site', siteId);
        window.open('/report/logbook');

    }

    function handleSiteName(obj){
        //console.log(obj.id);
        if(obj.checked){
            //btn=' <a href="javascript:void(0);" id="btn_'+obj.id+'" class="btn btn-outline-primary btn-sm" title="Delete" onclick="removeSitenameLable(this,\''+obj.id+'\')"> '+obj.value+' <i class="ft-x"></i></a> ';
            opt='<option value="'+obj.id+'" selected="selected">'+obj.value+'</option>'
            $("#selectedTestSiteId").append(opt);
            checkedTestSiteId.push(obj.id);
            document.getElementById("checkedTestSiteId").value=checkedTestSiteId;
        }else{
            //$("#btn_"+obj.id).remove();
            //index=checkedTestSiteId.indexOf(obj.id);
            removeSitenameLable(obj.id);
            //checkedTestSiteId.splice(index, 1);
            //document.getElementById("checkedTestSiteId").value=checkedTestSiteId;
        }
        if(checkedTestSiteId.length>0){
            $("#mailDiv").show()
        }else{
            $("#mailDiv").hide()
        }
    }

    function removeSitenameLable(chkId){
        //$(obj).remove();
        $("#selectedTestSiteId option[value="+chkId+"]").remove();
        $("#"+chkId).prop("checked", false);
        index=checkedTestSiteId.indexOf(chkId);
        checkedTestSiteId.splice(index, 1);
        document.getElementById("checkedTestSiteId").value=checkedTestSiteId;
        if(checkedTestSiteId.length>0){
            $("#mailDiv").show()
        }else{
            $("#mailDiv").hide()
        }
    }

    function sendMail(){
        flag = deforayValidator.init({
            formId: 'mailDiv'
        });
        if (flag == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }   
            });
            $.ajax({
                url: "{{ url('/sendMail') }}",
                method: 'post',
                data: {
                    subject: $("#mailSubject").val(),
                    message: $("#message").val(),
                    testSiteId: $("#checkedTestSiteId").val(),
                },
                success: function(result) {
                    alert(result.success);
                    location.reload();
                },
                error: function(e){
                    console.log(e);
                }
            });
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
            $(".infocus").focus();
        }
        //siteId=$("#checkedTestSiteId").val();
        //showModal('sendMail/'+siteId,600,300);
    }

    
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

@endsection
