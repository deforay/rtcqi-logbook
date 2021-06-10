<!--
    Author             : Prasath M
    Date               : 10 June 2021
    Description        : Logbook report
    Last Modified Date : 10 June 2021
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
                        <li class="breadcrumb-item"><a href="/logbook/">Logbook Report</a>
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
                            <h3 class="content-header-title mb-0">Logbook Report</h3>
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
                            <div class="row">
                            <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Start Date <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="date" id="startDate" value="{{date('Y-m-d', strtotime('-30 days'))}}" class="form-control isRequired" autocomplete="off" name="startDate" title="Please select Start Date" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>End Date <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="date" id="endDate" value="{{date('Y-m-d')}}" class="form-control isRequired" autocomplete="off" name="endDate" title="Please select End Date" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Facilty Name
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control" autocomplete="off" style="width:100%;" id="facilityId" name="facilityId" title="Please select Facility Name">
                                                <option value="">Select Facility Name</option>
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
                                                <option value="">Select Testing Algothrim</option>
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
                                                <select class="form-control" autocomplete="off" style="width:100%;" id="testSiteId" name="testSiteId" title="Please select Test Site Name">
                                                <option value="">Select Test Site Name</option>
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
                                <button type="submit" onclick="getLogbookReport();return false;" class="btn btn-info"> Search</button>&nbsp;&nbsp;
                                <a class="btn btn-danger btn-md"
                                     href = "/logbook"><span>Reset</span></a>&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                </div></div></div>
                <div class="table-responsive p-t-10">
                    <div id="logbookList"></div>
                    </div>       
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
  <script>
  $(document).ready(function() {
    getLogbookReport();
    });
    function getLogbookReport() {
      startDate = $('#startDate').val();
      endDate = $('#endDate').val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
                url: "{{ url('/getLogbookReport') }}",
                method: 'post',
                data: {
                    startDate:startDate,
                    endDate:endDate,
                    facilityId: $("#facilityId").val(),
                    algorithmType: $("#algorithmType").val(),
                    testSiteId: $("#testSiteId").val(),
                    reportFrequency: $("#reportFrequency").val(),
                },
                success: function(result){
                   $("#logbookList").html(result);
                }
            });
	}
</script>
  
@endsection
