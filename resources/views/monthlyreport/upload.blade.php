<!-- 
    Author             : Prasath M
    Date               : 16 Jun 2021
    Description        : import Monthly report Form
    Last Modified Date : 16 Jun 2021
    Last Modified Name : Prasath M
-->

@extends('layouts.main')

@section('content')

<br>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top d-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Import
                        </li>
                        <li class="breadcrumb-item"><a href="/monthlyreportdata/">Import Monthly report</a>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="content-header-right col-md-6 col-12 ">
            <div class="dropdown float-md-right ml-1">
                @if($global['no_of_test'] == 1)
                <a href="{{ asset('assets/MonthlyReportSample1test.xlsx') }}" onclick="insertData()" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                    @elseif($global['no_of_test'] == 2)
                    <a href="{{ asset('assets/MonthlyReportSample2test.xlsx') }}" onclick="insertData()" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                        @elseif($global['no_of_test'] == 3)
                        <a href="{{ asset('assets/MonthlyReportSample3test.xlsx') }}" onclick="insertData()" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                            @elseif($global['no_of_test'] == 4)
                            <a href="{{ asset('assets/MonthlyReportSample4test.xlsx') }}" onclick="insertData()" class="btn btn-outline-info round box-shadow-1 px-2" id="btnGroupDrop1">
                                @endif
                                <b><i class="ft-download icon-left"></i> Download Sample Monthly Report Excel Sheet</b></a>
            </div>

        </div>
    </div>
    @if (isset($status))
    <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index">
        <div class="text-center" style=""><b>
                {!! $status !!}</b></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>

    <script>
        // ses = "{{ session('status') }}"
        // $('#modalBody').html(ses)
        $('#show_alert_index').delay(7000).fadeOut();
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
                            <h4 class="card-title"></h4>
                            <h3 class="content-header-title mb-0">Import Monthly Report</h3>
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
                                <div id="show_alert" class="mt-1" style=""></div>
                                <form class="form form-horizontal" role="form" name="monreportUpload" id="monreportUpload" method="post" enctype="multipart/form-data" action="/monthlyreportdata" autocomplete="off" onsubmit="validateNow();return false;">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12">
                                            <label>Select File for Upload</label> <span class="mandatory">*</span>
                                            <span class="text-muted">.xls, .xslx</span>
                                            <input class="form-control isRequired" accept=".xlsx, .xls" type="file" name="grade_excel" title="Please Select File" />
                                        </div>
                                        <div class="col-xl-3 mt-4 col-lg-12">
                                            <div class="form-group">
                                                <input type="submit" name="upload" onclick="validateNow();return false;" class="btn btn-primary  mt-2" value="Upload">&nbsp;&nbsp;
                                                <a href="/monthlyreport">
                                                    <input type="button" name="cancel" class="btn btn-warning  mt-2" value="Cancel"></a>
                                            </div>
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
    duplicateName = true;

    function validateNow() {
        flag = deforayValidator.init({
            formId: 'monreportUpload'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('monreportUpload').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }

    function insertData(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/insertTrackTable') }}",
            method: 'get',
            success: function(result) {
            }
        });
    }
</script>
@endsection