<!--
    Author             : Sakthivel P
    Date               : 2 June 2021
    Description        : User Facility Map view screen
    Last Modified Date : 2 June 2021
    Last Modified Name : Sakthivel P
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
                        <li class="breadcrumb-item"><a href="/trendreport/">Trend Report</a>
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
                            <h3 class="content-header-title mb-0">Trend Report</h3>
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
                        <div id="show_alert"  class="mt-1" style=""></div>
                <h4 class="card-title">Filter the data</h4><br>
                <form class="form form-horizontal" role="form" name="trendReportFilter" id="trendReportFilter" method="" action="" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                <div class="row">
                <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Start Date <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="date" id="startDate" class="form-control isRequired" autocomplete="off" name="startDate" title="Please select Start Date" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>End Date <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="date" id="endDate" class="form-control isRequired" autocomplete="off" name="endDate" title="Please select End Date" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Facilty Name
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control" autocomplete="off" style="width:100%;" id="facilityId" name="facilityId" title="Please select Facility Name">
                                                <option value="0">Select Facility Name</option>
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
                                                <select class="form-control" autocomplete="off" style="width:100%;" id="algorithmType" name="algorithmType" title="Please select Facility Name">
                                                <option value="0">Select Testing Algothrim</option>
                                                    @foreach($monthlyReport as $row)
                                                    <option value="{{$row->mr_id}}">{{$row->algorithm_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Test Site Name
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control" autocomplete="off" style="width:100%;" id="testSiteId" name="testSiteId" title="Please select Test Site Name">
                                                <option value="0">Select Test Site Name</option>
                                                    @foreach($testSite as $row)
                                                    <option value="{{$row->ts_id}}">{{$row->site_name}}</option>
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
                                                <option value="0">Select Report Frequency</option>
                                                <option value="daily">Daily</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="yearly">Yearly</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-md-7" style="color:#FFF;">
                        <div class="form-group row">
                            
                            <div class="col-md-8">
                                <button type="submit" onclick="validateNow();return false;" class="btn btn-info"> Search</button>&nbsp;&nbsp;
                                <button class="btn btn-danger btn-md"
                                    onclick='clearStatus();'><span>Reset</span></button>&nbsp;&nbsp;

<a href="javascript:void(0);" onclick="exportExcel();" class="btn btn-success"><i
        class="fa fa-download"></i>Export Execl</a>
                            </div>
                        </div>
							</form>
                    </div>
                </div></div></div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <p class="card-text"></p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="trendReportFilter">
                                        <thead>
                                            <tr>
                                                <th>Facility</th>
                                                <th>Site</th>
                                                <th>Algo</th>
                                                <th>Testing Month</th>
                                                <th>Total Tests</th>
                                                <th colspan="3" style="center">Test 1</th>
                                                <th colspan="3" style="center">Test 2</th>
                                                <th>% Pos</th>
                                                <th>Positive Agr</th>
                                                <th>OverAll Agr</th>
                                            </tr>
                                            <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>R</th>
                                            <th>NR</th>
                                            <th>INV</th>
                                            <th>R</th>
                                            <th>NR</th>
                                            <th>INV</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
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
//   $(document).ready(function() {
//         $.blockUI();
//         getTrendMonthlyReport();
//         $.unblockUI();
//     });
  duplicateName = true;
    function validateNow() {
            flag = deforayValidator.init({
                formId: 'trendReportFilter'
            });
            
            if (flag == true) {
                if (duplicateName) {
                    document.getElementById('trendReportFilter').submit();
                }
            }
            else{
                // Swal.fire('Any fool can use a computer');
                $('#show_alert').html(flag).delay(3000).fadeOut();
                $('#show_alert').css("display","block");
                $(".infocus").focus();
            }
      startDate = $('#startDate').val();
      endDate = $('#endDate').val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#trendReportFilter').DataTable({
            processing: true,
            destroy : true,
            serverSide: true,
            scrollX: true,
            autoWidth:false,
            scrollY: "400px",
            scrollCollapse: true,
            ajax: {
                url:'{{ url("getTrendMonthlyReport") }}',
                type: 'POST',
                data: {
                    startDate:startDate,
                    endDate:endDate,
                    facilityId: $("#facilityId").val(),
                    algorithmType: $("#algorithmType").val(),
                    testSiteId: $("#testSiteId").val(),
                    reportFrequency: $("#reportFrequency").val(),
                },
            },
            // columns: [
                    
            //         { data: 'invoice_no', name: 'invoice_no' },
            //         { data: 'invoice_date', name: 'invoice_date' },
            //         { data: 'keyperson_name', name: 'keyperson_name',className:'firstcaps' },
            //         { data: 'customer_name', name: 'customer_name',className:'firstcaps' },
            //         { data: 'indent_no', name: 'indent_no' },
            //         { data: 'invoice_status', name: 'invoice_status', className:'firstcaps' },
            //         { data: 'state_name', name: 'state_name' },
            //         { data: 'location_name', name: 'location_name',className:'firstcaps' },
            //         { data: 'sector_name', name: 'sector_name',className:'firstcaps' },
            //         { data: 'grade_name', name: 'grade_name',className:'firstcaps' },
            //         { data: 'grade_quality', name: 'grade_quality' },
            //         { data: 'qty', name: 'qty' },
            //     ],
            // order: [[0, 'desc']]
        });
	}

  function clearStatus() {
        $("#startDate").val("");
        $("#endDate").val("");
        var dropDown = document.getElementById("facilityId");
        dropDown.selectedIndex = 0;
        var dropDown = document.getElementById("algorithmType");
        dropDown.selectedIndex = 0;
        var dropDown = document.getElementById("testSiteId");
        dropDown.selectedIndex = 0;
        var dropDown = document.getElementById("reportFrequency");
        dropDown.selectedIndex = 0;
    }</script>
  
@endsection
