<!--
    Author             : Prasath M
    Date               : 10 June 2021
    Description        : Overall Agreement page summary report
    Last Modified Date : 10 June 2021
    Last Modified Name : Prasath M
-->

@extends('layouts.main')

@section('content')
<style>
td{
    font-weight: 600;
    color: black;
}
</style>
<?php 
use App\Service\GlobalConfigService;
$GlobalConfigService = new GlobalConfigService();
$glob = $GlobalConfigService->getAllGlobalConfig();
$arr = array();
// now we create an associative array so that we can easily create view variables
for ($i = 0; $i < sizeof($glob); $i++) {
    $arr[$glob[$i]->global_name] = $glob[$i]->global_value;
}

$col = ['yellow', '#b5d477' , '#d08662', '#76cece', '#ea7786'];
$row = ['Kit Name', 'Lot No', 'Expiry Date', 'Test Result', 'No of Tests'];
?>

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
        <section >
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="content-header-title mb-0">Page Summary</h3>
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
                                    <div class="row">
                                        <div class="col-xl-2 col-6">
                                            <h5><strong>Facility:</strong></h5>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <span>{{$report[0]->facility_name}}</span>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <h5><strong>Site:</strong></h5>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <span>{{$report[0]->site_name}}</span>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <h5><strong>Algorithm:</strong></h5>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <span>{{$report[0]->algorithm_type}}</span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xl-2 col-6">
                                            <h5><strong>Book No:</strong></h5>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <span>{{$report[0]->book_no}}</span>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <h5><strong>Page No:</strong></h5>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <span>{{$report[0]->page_no}}</span>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <h5><strong>Start Test Date:</strong></h5>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <span>{{$report[0]->start_test_date}}</span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xl-2 col-6">
                                            <h5><strong>End Test Date:</strong></h5>
                                        </div>
                                        <div class="col-xl-2 col-6">
                                            <span>{{$report[0]->end_test_date}}</span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar tableFixHead">
                                        <table class="table table-bordered "  id="trendTable" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <!-- <th>Test</th>
                                                    <th>Kit Name</th>
                                                    <th>Lot No</th>
                                                    <th>Expiry Date</th>
                                                    <th>Test Result</th>
                                                    <th>Number Of Test</th> -->
                                                    <th>Test</th>
                                                    @for($i = 1; $i <= $arr['no_of_test']; $i++)
                                                        <th colspan="3" bgcolor="{{$col[$i]}}">Test{{$i}}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for($k = 0; $k < count($row); $k++)

                                                    <tr>
                                                        <td>{{$row[$k]}}</td>
                                                        @for($j = 1; $j <= $arr['no_of_test']; $j++)
                                                            <?php  $lot_no = 'lot_no_'.$j;  
                                                                $expiry_date = 'expiry_date_'.$j; 
                                                                $reactive = 'test_'.$j.'_reactive';
                                                                $testkit = 'test_'.$j.'_kit_id';   
                                                                $nonreactive = 'test_'.$j.'_nonreactive';  
                                                                $invalid = 'test_'.$j.'_invalid';   
                                                            ?>
                                                            @if($row[$k] == 'Lot No')
                                                                <td bgcolor="{{$col[$j]}}"colspan="3">{{$report[0]->$lot_no}}</td>
                                                            @elseif($row[$k] == 'Kit Name')
                                                                @foreach($kittype as $row2)
																    @if($row2->tk_id == $report[0]->$testkit)
                                                                        <td bgcolor="{{$col[$j]}}"colspan="3">{{$row2->test_kit_name}}</td>
                                                                    @endif
																@endforeach
                                                            @elseif($row[$k] == 'Expiry Date')
                                                                <td bgcolor="{{$col[$j]}}"colspan="3">{{$report[0]->$expiry_date}}</td>
                                                            @elseif($row[$k] == 'Test Result')
                                                                <td bgcolor="{{$col[$j]}}">R</td>
                                                                <td bgcolor="{{$col[$j]}}">NR</td>
                                                                <td bgcolor="{{$col[$j]}}">Inv</td>
                                                            @elseif($row[$k] == 'No of Tests')
                                                                <td bgcolor="{{$col[$j]}}">{{$report[0]->$reactive}}</td>
                                                                <td bgcolor="{{$col[$j]}}">{{$report[0]->$nonreactive}}</td>
                                                                <td bgcolor="{{$col[$j]}}">{{$report[0]->$invalid}}</td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                        <br>
										<table class="" style="width:80%;margin-left: 10%;">
                                            <thead>
                                                <tr>
                                                    <th colspan="5" style=" text-align: center;">
                                                        <h4 style="font-weight: 600;"> Final Result </h4>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th  style=" text-align: center;">
                                                        <h4 style="font-weight: 600;"> Positive </h4>
                                                    </th>
                                                    <th  style=" text-align: center;">
                                                        <h4 style="font-weight: 600;"> Negative </h4>
                                                    </th>
                                                    <th  style=" text-align: center;">
                                                        <h4 style="font-weight: 600;"> Indeterminate </h4>
                                                    </th>
                                                    <th  style=" text-align: center;">
                                                        <h4 style="font-weight: 600;"> Overall Agreement </h4>
                                                    </th>
                                                    <th  style=" text-align: center;">
                                                        <h4 style="font-weight: 600;"> Positive Agreement </h4>
                                                    </th>
                                                </tr>
                                            </thead>
											<tr style="line-height: 50px;">
												
												<td style=" text-align: center;" >
                                                    {{$report[0]->final_positive}}
												</td>
												<td style=" text-align: center;" >
                                                    {{$report[0]->final_negative}}
												</td>
												<td style=" text-align: center;" >
                                                    {{$report[0]->final_undetermined}}
												</td>
                                                <td style=" text-align: center;" >
                                                    {{$report[0]->overall_agreement}}
												</td>
												<td style=" text-align: center;" >
                                                    {{$report[0]->positive_agreement}}
												</td>
											</tr>
										</table>
                                    </div>
                                </div>
                                <div class="form-actions ml-5">
                                    <a href="/trendreport" >
                                    <button type="button" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                    </button>
                                    </a>
                                </div>
                            </div>                   
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
  <!-- <script>
  $(document).ready(function() {
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
</script> -->
  
@endsection
