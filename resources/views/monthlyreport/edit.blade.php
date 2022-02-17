@extends('layouts.main')
@section('content')
<?php

use App\Service\CommonService;

$common = new CommonService();
$date_of_data_collection = $common->humanDateFormat($result[0]->date_of_data_collection);
$reporting_month = ($result[0]->reporting_month);
// $reporting_month = 'Jun-2021';
{{--  dd($result);  --}}
$col = ['yellow', '#b5d477', '#d08662', '#76cece', '#ea7786'];
?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block"> Monthly report</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/monthlyreport/"> Monthly Report</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="content-body">
        <!-- horizontal grid start -->
        <section class="horizontal-grid" id="horizontal-grid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="form-section"><i class="la la-plus-square"></i> Edit Monthly Report</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div id="show_alert" class="mt-1" style=""></div>
                                <form class="form form-horizontal" role="form" name="editMonthlyReport" id="editMonthlyReport" method="post" action="/monthlyreport/edit/{{$id}}" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    @php
                                    $fnct = "mr_id##".($result[0]->mr_id);
                                    @endphp
                                    <div class="form-body row">
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Site Name<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="js-example-basic-single form-control isRequired" autocomplete="off" style="width:100%;" id="testsiteId" name="testsiteId" title="Please select Test Site Name">
                                                        @foreach($testsite as $row2)
                                                        <option value="{{$row2->ts_id}}" {{ $result[0]->ts_id == $row2->ts_id ?  'selected':''}}>{{$row2->site_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Site Type <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class=" js-example-basic-single form-control isRequired" autocomplete="off" style="width:100%;" id="sitetypeId" name="sitetypeId" title="Please select Site type Name">
                                                        @foreach($sitetype as $row1)
                                                        <option value="{{$row1->st_id}}" {{ $result[0]->st_id == $row1->st_id ?  'selected':''}}>{{$row1->site_type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Site ID <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="siteUniqueId" value="{{$result[0]->site_unique_id}}" class="form-control  isRequired" autocomplete="off" placeholder="Enter Site Unique Id" name="siteUniqueId" title="Please Enter Site Unique Id">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Province Name<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId" title="Please select Province Name">
                                                        <option value="">---Select---</option>
                                                        @foreach($province as $row)
                                                        <option value="{{$row->province_id}}" {{ $result[0]->provincesss_id == $row->province_id ?  'selected':''}}>{{$row->province_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Site Manager
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="siteManager" value="{{$result[0]->site_manager}}" class="form-control" autocomplete="off" placeholder="Enter Site Manager" name="siteManager" title="Please Enter Site Manager">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Is FLC?<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isFlu" name="isFlu" title="Please select Is Flu status">
                                                        <option value="">-- Select --</option>
                                                        <option value="yes" {{ $result[0]->is_flc == 'yes' ?  'selected':''}}>Yes</option>
                                                        <option value="no" {{ $result[0]->is_flc == 'no' ?  'selected':''}}>No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
										<fieldset>
											<h5>Tester Name <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="testername" class="form-control isRequired " value="{{$result[0]->tester_name}}" autocomplete="off" placeholder="Enter Tester Name" name="testername" title="Please Enter Tester Name" >
											</div>
										</fieldset>
									</div>
                                    <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Tester Contact Number
                                                </h5>
                                                <div class="form-group">
                                                <input type="tel" id="contactNo" maxlength="10" value="{{$result[0]->contact_no}}" onkeypress="return isNumberKey(event);" class="form-control  " autocomplete="off" placeholder="Enter Tester Contact Phone" name="contactNo" title="Please Enter Tester Contact Phone" >
                                                </div>
                                            </fieldset>
                                        </div>
                                        @if($global['recency_test']=='enabled')
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Does site do Recency Tests?<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isRecency" name="isRecency" title="Please select Is Recency status">
                                                        <option value="yes" {{ $result[0]->is_recency == 'yes' ?  'selected':''}}>Yes</option>
                                                        <option value="no" {{ $result[0]->is_recency == 'no' ?  'selected':''}}>No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        @endif
                                        {{--   <div class="form-group col-xl-3 col-lg-3">
										<fieldset>
											<h5>Latitude <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="latitude" value="{{$result[0]->latitude}}" class="form-control isRequired " autocomplete="off" placeholder="Enter latitude" name="latitude" title="Please Enter latitude" >
											</div>
										</fieldset>
									</div>
                                    <div class="form-group col-xl-3 col-lg-3">
										<fieldset>
											<h5>Longitude <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="longitude" value="{{$result[0]->longitude}}" class="form-control isRequired " autocomplete="off" placeholder="Enter longitude" name="longitude" title="Please Enter longitude" >
											</div>
										</fieldset>
									</div> --}}
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Algorithm Type
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="algoType" name="algoType" title="Please select Algorithm Type">
                                                        <option value="serial" {{ $result[0]->algorithm_type == 'serial' ?  'selected':''}}>Serial</option>
                                                        <option value="parallel" {{ $result[0]->algorithm_type == 'parallel' ?  'selected':''}}>Parallel</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Name of Data Collector
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="nameOfDataCollect" value="{{$result[0]->name_of_data_collector}}" class="form-control  " autocomplete="off" placeholder="Enter Name of Data Collected" name="nameOfDataCollect" title="Please Enter Name of Data Collected">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Date of Data Collection <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="DateOfCollect" value="{{$date_of_data_collection}}" class="form-control isRequired datepicker" autocomplete="off" placeholder="Enter Date Of Collection" name="DateOfCollect" title="Please Enter Date Of Collection">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Reporting Month <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="reportingMon" value="{{$reporting_month}}" class="form-control isRequired month" autocomplete="off" placeholder="Enter Reporting Month" name="reportingMon" title="Please Enter Reporting Month">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Book Number <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="bookNo" value="{{$result[0]->book_no}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Book No" name="bookNo" title="Please Enter Book No">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <br />
                                    <div id="test_row">
                                        <h4 style="font-weight: normal; text-transform:uppercase;" class="form-section">Test Details</h4>
                                        <?php $z = 0;  ?>
                                        @foreach($result['test_details'] as $list)
                                        <?php
                                        $start_test_date = $common->humanDateFormat($list->start_test_date);
                                        $end_test_date = $common->humanDateFormat($list->end_test_date);
                                        ?>
                                        <input type="hidden" id="mrp_id{{$z}}" name=mrp_id[] value="{{$list->mrp_id}}">
                                        <div class="testDetailsRow" id="test_details{{$z}}">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-12">
                                                    <fieldset>
                                                        <h5>Page No.</h5>
                                                        <div class="form-group">
                                                            <input type="number" min="0" value="{{$list->page_no}}" id="pageNO{{$z}}" class="form-control  " autocomplete="off" placeholder="Enter Page No." name="pageNO[]" title="Please Enter Page No">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-xl-4 col-lg-12">
                                                    <fieldset>
                                                        <h5>Start Date
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="text" id="startDate{{$z}}" value="{{$start_test_date}}" class="form-control dates " onchange="changeStartDate('{{$z}}')" placeholder="Enter Start Date" autocomplete="off" name="startDate[]" title="Please Enter Start Date">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-xl-4 col-lg-12">
                                                    <fieldset>
                                                        <h5>End Date
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="text" id="endDate{{$z}}" value="{{$end_test_date}}" class="form-control  dates" onchange="changeEndDate('{{$z}}')" placeholder="Enter End Date" autocomplete="off" name="endDate[]" title="Please Enter End Date">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <table class="table1" style="width:100%">
                                                <tr>
                                                    @if(count($allowedTestKitNo) > 0)
                                                    @for($i = 1; $i <= $globalValue; $i++) <?php $test_id = 'test_' . $i . '_kit_id';    ?> <td style=" text-align: center;" colspan="3">
                                                        <fieldset>
                                                        @if($i == 1)
                                                            <h5>Test Kit Name {{$i}}<span class="mandatory">*</span>
                                                            </h5>
                                                            @else 
                                                            <h5>Test Kit Name {{$i}}
                                                            </h5>
                                                            @endif
                                                            <div class="form-group">
                                                            @if($i == 1)
                                                                <select class="form-control isRequired selectTestKits" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_{{$z}}" data-id="{{$i}}_{{$z}}" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}" onchange="replaceTestKitHeadings('{{$i}}','{{$z}}',this)">
                                                                @else   
                                                                <select class="form-control selectTestKits" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_{{$z}}" data-id="{{$i}}_{{$z}}" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}" onchange="replaceTestKitHeadings('{{$i}}','{{$z}}',this)"> 
                                                            @endif
                                                                   <option value="">--Select--</option>
                                                                    @if(isset($allowedTestKitNo[$i]))
                                                                    @foreach($allowedTestKitNo[$i] as $value=>$option)
                                                                    <option value="{{$value}}" {{ $list->$test_id == $value ?  'selected':''}}>{{$option}}</option>
                                                                    @endforeach
                                                                    @else
                                                                    @foreach($kittype as $row2)
                                                                    <option value="{{$row2->tk_id}}" {{ $list->$test_id == $row2->tk_id ?  'selected':''}}>{{$row2->test_kit_name}}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </fieldset>
                                                        </td>
                                                        @endfor
                                                        @else
                                                        @for($i = 1; $i <= $globalValue; $i++) <?php $test_id = 'test_' . $i . '_kit_id';    ?> <td style=" text-align: center;" colspan="3">
                                                            <fieldset>
                                                                <h5>Test Kit Name{{$i}}<span class="mandatory">*</span>
                                                                </h5>
                                                                <div class="form-group">
                                                                    <select class="form-control isRequired selectTestKits" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_{{$z}}" data-id="{{$i}}_{{$z}}" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}" onchange="replaceTestKitHeadings('{{$i}}','{{$z}}',this)">
									                                    <option value="">--Select--</option>
                                                                        @foreach($kittype as $row2)
                                                                        <option value="{{$row2->tk_id}}" {{ $list->$test_id == $row2->tk_id ?  'selected':''}}>{{$row2->test_kit_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </fieldset>
                                                            </td>
                                                            @endfor
                                                            @endif
                                                </tr>
                                                <tr>
                                                    @for($j = 1; $j <= $globalValue; $j++) <?php $lot_no = 'lot_no_' . $j;
                                                                                            $expiry_date = 'expiry_date_' . $j; 
                                                                                            $expiryDate = $common->humanDateFormat($list->$expiry_date); ?> <td style=" text-align: center;">
                                                        <h5>Lot No. {{$j}}<span class="mandatory">*</span>
                                                        </h5>
                                                        @else 
                                                        <h5>Lot No. {{$j}}
                                                        </h5>
                                                        @endif
                                                        <div class="form-group">
                                                            @if($j == 1)
                                                            <input type="text" id="lotNO{{$j}}" value="{{$list->$lot_no}}" class="form-control isRequired " autocomplete="off" placeholder="Enter Lot No." name="lotNO{{$j}}[]" title="Please Enter Lot No.{{$j}}">
                                                            @else
                                                            <input type="text" id="lotNO{{$j}}" value="{{$list->$lot_no}}" class="form-control  " autocomplete="off" placeholder="Enter Lot No." name="lotNO{{$j}}[]" title="Please Enter Lot No.{{$j}}">
                                                            @endif
                                                        </div>
                                                        </td>
                                                        <td style=" text-align: center;" colspan="2">
                                                        @if($j == 1)
                                                            <h5>Expiry Date {{$j}}<span class="mandatory">*</span>
                                                            </h5>
                                                            @else 
                                                            <h5>Expiry Date {{$j}}
                                                            </h5>
                                                            @endif
                                                            <div class="form-group">
                                                                <input type="text" id="expiryDate{{$j}}" value="{{$expiryDate}}" class="form-control dates " autocomplete="off" placeholder="Enter Expiry Date" name="expiryDate{{$j}}[]" title="Please Enter Expiry Date{{$j}}">
                                                            </div>
                                                        </td>
                                                        @endfor
                                                </tr>
                                                <tr>
                                                    @for($k = 1; $k <= $globalValue; $k++)
                                                        <td colspan="3" style=" text-align: center;" bgcolor="{{$col[$k]}}">
                                                            <h4 id="testKitHeading{{$k}}_{{$z}}" style="font-weight: 600;color: white;">Test Kit {{$k}}</h4>
                                                        </td>
                                                        @endfor
                                                </tr>
                                                <tr>
                                                    @for($l = 1; $l <= $globalValue; $l++) <?php $reactive = 'test_' . $l . '_reactive';
                                                                                            $nonreactive = 'test_' . $l . '_nonreactive';
                                                                                            $invalid = 'test_' . $l . '_invalid';    ?> <td style=" text-align: center;" bgcolor="{{$col[$l]}}">
                                                        <h5 style="color: white; font-weight: 500;"> R
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="number" min="0" id="totalReactive{{$l}}" value="{{$list->$reactive}}" class="form-control  " autocomplete="off" placeholder="Enter Total Reactive - R - {{$l}}" name="totalReactive{{$l}}[]" title="Please Enter Total Reactive - R - {{$l}}">
                                                        </div>
                                                        </td>
                                                        <td style=" text-align: center;" bgcolor="{{$col[$l]}}">
                                                            <h5 style="color: white; font-weight: 500;">NR
                                                            </h5>
                                                            <div class="form-group">
                                                                <input type="number" min="0" id="totalNonReactive{{$l}}" value="{{$list->$nonreactive}}" class="form-control  " autocomplete="off" placeholder="Enter Total Non-Reactive - R - {{$l}}" name="totalNonReactive{{$l}}[]" title="Please Enter Total Non-Reactive - R - {{$l}}">
                                                            </div>
                                                        </td>
                                                        <td style=" text-align: center;" bgcolor="{{$col[$l]}}">
                                                            <h5 style="color: white; font-weight: 500;">INV
                                                            </h5>
                                                            <div class="form-group">
                                                                <input type="number" min="0" id="totalInvalid{{$l}}" value="{{$list->$invalid}}" class="form-control  " autocomplete="off" placeholder="Enter Total Invalid - INV - {{$l}}" name="totalInvalid{{$l}}[]" title="Please Enter Total Invalid - INV - {{$l}}">
                                                            </div>
                                                        </td>
                                                        @endfor
                                                </tr>
                                            </table>
                                            <br>
                                            <table class="table1" style="width:80%;margin-left: 10%;">
                                                <tr>
                                                    <td style=" text-align: center;">
                                                        <h4 style="font-weight: 600;"> Final Result </h4>
                                                    </td>
                                                    <td style=" text-align: center;">
                                                        <h5> Positive
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="number" min="0" id="totalPositive{{$z}}" value="{{$list->final_positive}}" class="form-control  " autocomplete="off" placeholder="Enter Final Positive" name="totalPositive[]" title="Please Enter Final Positive">
                                                        </div>
                                                    </td>
                                                    <td style=" text-align: center;">
                                                        <h5> Negative
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="number" min="0" id="totalNegative{{$z}}" value="{{$list->final_negative}}" class="form-control  " autocomplete="off" placeholder="Enter Final Negative" name="totalNegative[]" title="Please Enter Final Negative">
                                                        </div>
                                                    </td>
                                                    <td style=" text-align: center;">
                                                        <h5> Indeterminate
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="number" min="0" id="finalUndetermined{{$z}}" value="{{$list->final_undetermined}}" class="form-control  " autocomplete="off" placeholder="Enter Final Undertermined" name="finalUndetermined[]" title="Please Enter Final Undertermined">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <br>
                                        <?php $z++; ?>
                                        @endforeach
                                    </div>
                                    <br>
                                    <div class="row" style="color:white;margin-left:40%;">
                                        <div>
                                            <a onclick="insert_row();" class="btn btn-info grey">
                                                <i class="ft-plus icon-left"></i> Add Page
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/monthlyreport">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> Cancel
                                            </button>
                                        </a>
                                        <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- horizontal grid end -->
        </section>
    </div>
</div>
<link href="public/dist/css/select2.min.css" rel="stylesheet" />
<script src="public/dist/js/select2.min.js"></script>

<script>
	$(document).ready(function() {
		$('.js-example-basic-single').select2();
        $("#sitetypeId").val(data).trigger('change');
        $("#testsiteId").val(data).trigger('change');
        $selectElement = $('#testsiteId').prepend('<option selected></option>').select2({
            placeholder: "Select Site Name"
        });
		$selectElement = $('#sitetypeId').prepend('<option selected></option>').select2({
            placeholder: "Select Site Type"
        });
});
    $(document).ready(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-M-yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            // startDate:'today',
            todayHighlight: true,
            clearBtn: true,
        });
        $('.month').datepicker({
            autoclose: true,
            format: 'M-yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            viewMode: "months",
            minViewMode: "months",
            // startDate:'today',
            todayHighlight: true,
            clearBtn: true,
        });
        $(".dates").datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            endDate: today,
        });
        initSetTestkitHeadings();
    });
    var date1 = new Date();
    var today = new Date(date1.getFullYear(), date1.getMonth(), date1.getDate());

    function changeStartDate(id) {
        $("#startDate" + id).datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: today,
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#endDate' + id).datepicker('setStartDate', minDate);
        });
        // var minDate = new Date(selected.date.valueOf());
        //    $('#endDate'+id).datepicker('setStartDate', minDate);
    }

    function changeEndDate(id) {
        $("#endDate" + id).datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: today,
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#startDate' + id).datepicker('setEndDate', minDate);
        });
        // var minDate = new Date(selected.date.valueOf());
        //        $('#startDate'+id).datepicker('setEndDate', minDate);
    }
    duplicateName = true;

    function validateNow() {
        flag = deforayValidator.init({
            formId: 'editMonthlyReport'
        });

        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editMonthlyReport').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }

    //var rowCount = '{{$z - 1}}';
    var rowCount = $(".testDetailsRow").length;
    var gCnt = '{{$globalValue}}';
    var col = ['yellow', '#b5d477', '#d08662', '#76cece', '#ea7786'];

    function insert_row() {
        rowCount++;
        var div = '';

        div += '<br><div class="testDetailsRow" id="test_details' + rowCount + '">\
			<div class="row">\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>Page No.</h5>\
						<div class="form-group">\
							<input type="number" min="0" id="pageNO' + rowCount + '" class="form-control  " autocomplete="off" placeholder="Enter Page No." name="pageNO[]" title="Please Enter Page No" >\
						</div>\
					</fieldset>\
				</div>\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>Start Date\
						</h5>\
						<div class="form-group">\
							<input type="text" id="startDate' + rowCount + '" onchange="changeStartDate(' + rowCount + ')" class="form-control dates " placeholder="Enter Start Date" autocomplete="off" name="startDate[]" title="Please Enter Start Date" >\
						</div>\
					</fieldset>\
				</div>\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>End Date\
						</h5>\
						<div class="form-group">\
							<input type="text" id="endDate' + rowCount + '" onchange="changeEndDate(' + rowCount + ')" class="form-control  dates" placeholder="Enter End Date" autocomplete="off" name="endDate[]" title="Please Enter End Date" >\
						</div>\
					</fieldset>\
				</div>\
			</div>\
			<table class="table1" style="width:100%">\
			<tr>';
        div += '@if(count($allowedTestKitNo) > 0)\
				@for($i = 1; $i <= $globalValue; $i++)\
				<td  style=" text-align: center;" colspan="3" >\
						<fieldset>\
							<h5>Test Kit Name {{$i}}\
								</h5>\
								<div class="form-group">\
									<select class="form-control" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_'+rowCount+'" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}" onchange="replaceTestKitHeadings(\'{{$i}}\',\''+rowCount+'\',this)">\
									<option value="">--Select--</option>\
										@if(isset($allowedTestKitNo[$i]))\
											@foreach($allowedTestKitNo[$i] as $value=>$option)\
											<option value="{{$value}}">{{$option}}</option>\
											@endforeach\
										@else\
											@foreach($kittype as $row2)\
											<option value="{{$row2->tk_id}}" >{{$row2->test_kit_name}}</option>\
											@endforeach\
										@endif\
									</select>\
								</div>\
							</fieldset>\
						</td>\
						@endfor\
						@else\
						@for($i = 1; $i <= $globalValue; $i++)\
				        <td  style=" text-align: center;" colspan="3" >\
						<fieldset>\
							<h5>Test Kit Name{{$i}}\
								</h5>\
								<div class="form-group">\
									<select class="form-control" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_'+rowCount+'" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}"  onchange="replaceTestKitHeadings(\'{{$i}}\',\''+rowCount+'\',this)">\
									<option value="">--Select--</option>\
										@foreach($kittype as $row2)\
										<option value="{{$row2->tk_id}}">{{$row2->test_kit_name}}</option>\
										@endforeach\
									</select>\
								</div>\
							</fieldset>\
						</td>\
						@endfor\
						@endif';
        div += '</tr><tr>'
        for (var j = 1; j <= gCnt; j++) {
            div += '<td style=" text-align: center;">\
							<h5>Lot No. ' + j + ' \
							</h5>\
							<div class="form-group">\
								<input type="text" id="lotNO' + j + '" class="form-control  " autocomplete="off" placeholder="Enter Lot No." name="lotNO' + j + '[]" title="Please Enter Lot No.' + j + '" >\
							</div>\
					</td>\
					<td style=" text-align: center;" colspan="2">\
							<h5>Expiry Date ' + j + '\
							</h5>\
							<div class="form-group">\
								<input type="date" id="expiryDate' + j + '" class="form-control dates " autocomplete="off" placeholder="Enter Expiry Date" name="expiryDate' + j + '[]" title="Please Enter Expiry Date' + j + '" >\
							</div>\
					</td>';
        }
        div += '</tr><tr>'
        for (var k = 1; k <= gCnt; k++) {
            div += '<td colspan="3" style=" text-align: center;" bgcolor="' + col[k] + '">\
						<h4 id="testKitHeading' + k + '_'+rowCount+'" style="font-weight: 600;color: white;">Test Kit ' + k + '</h4>\
					</td>';
        }
        div += '</tr><tr>'
        for (var l = 1; l <= gCnt; l++) {
            div += '<td style=" text-align: center;" bgcolor="' + col[l] + '">\
						<h5 style="color: white; font-weight: 500;"> R\
						</h5>\
						<div class="form-group">\
							<input type="number" min="0" id="totalReactive' + l + '" class="form-control  " autocomplete="off" placeholder="Enter Total Reactive - R - ' + l + '" name="totalReactive' + l + '[]" title="Please Enter Total Reactive - R - ' + l + '" >\
						</div>\
					</td>\
					<td style=" text-align: center;" bgcolor="' + col[l] + '">\
							<h5 style="color: white; font-weight: 500;">NR\
							</h5>\
							<div class="form-group">\
							<input type="number" min="0" id="totalNonReactive' + l + '" class="form-control  " autocomplete="off" placeholder="Enter Total Non-Reactive - R - ' + l + '" name="totalNonReactive' + l + '[]" title="Please Enter Total Non-Reactive - R - ' + l + '" >\
						</div>\
					</td>\
					<td style=" text-align: center;" bgcolor="' + col[l] + '">\
						<h5 style="color: white; font-weight: 500;">INV </h5> ';
            div += '		<div class="form-group">\
							<input type="number" min="0" id="totalInvalid' + l + '" class="form-control  " autocomplete="off" placeholder="Enter Total Invalid - INV - ' + l + '" name="totalInvalid' + l + '[]" title="Please Enter Total Invalid - INV - ' + l + '" >\
						</div>\
					</td>'
        }
        div += '</tr></table><br>\
					<div class="row">\
						<div class="col-10">\
							<table class="table1" style="width:80%;margin-left: 10%;">\
								<tr>\
									<td  style=" text-align: center;">\
									<h4 style="font-weight: 600;"> Final Result </h4>\
									</td>\
									<td style=" text-align: center;" >\
										<h5> Positive\
										</h5>\
										<div class="form-group">\
											<input type="number" min="0" id="totalPositive' + rowCount + '" class="form-control  " autocomplete="off" placeholder="Enter Final Positive" name="totalPositive[]" title="Please Enter Final Positive" >\
										</div>\
									</td>\
									<td style=" text-align: center;" >\
										<h5> Negative\
										</h5>\
										<div class="form-group">\
											<input type="number" min="0" id="totalNegative' + rowCount + '" class="form-control  " autocomplete="off" placeholder="Enter Final Negative" name="totalNegative[]" title="Please Enter Final Negative" >\
										</div>\
									</td>\
									<td style=" text-align: center;" >\
										<h5> Indeterminate\
										</h5>\
										<div class="form-group">\
											<input type="number" min="0" id="finalUndetermined' + rowCount + '" class="form-control  " autocomplete="off" placeholder="Enter Final Undertermined" name="finalUndetermined[]" title="Please Enter Final Undertermined" >\
										</div>\
									</td>\
								</tr>\
							</table>\
							</div>\
						<div class="col-2 mt-5">\
							<div style="color:white;margin-left:5%;">\
								<a  onclick="delete_row(' + rowCount + ');" class="btn btn-danger grey">\
								<i class="ft-minus icon-left"></i> Remove Page\
								</a>\
							</div>\
						</div>\
					</div>\
				</div>';
        $("#test_row").append(div);
        $(".dates").datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            endDate: today,
        });
    }

    function delete_row(val) {
        if (val != 0) {
            $("#test_details" + val).remove();
        }
    }

    function replaceTestKitHeadings(headingNo,rowNo,selectObj){
        //console.log(headingNo,rowNo,$(selectObj).find(":selected").text());
        let optionSelected = ($(selectObj).val() && $(selectObj).find(":selected").text()) || `Test Kit ${headingNo}`;
        $(`#testKitHeading${headingNo}_${rowNo}`).html(optionSelected);
    }
    function initSetTestkitHeadings(){
        $(".selectTestKits").each(function(e){
            let uniqueRowId = $(this).attr("data-id");
            let headingId = (uniqueRowId).split('_')[0];
            let headingText = ($(this).val() && $(this).find(":selected").text()) || `Test Kit ${headingId}`;
            $(`#testKitHeading${uniqueRowId}`).html(headingText);
        })
    }
    $(document).ready(function() {

// Site Name Change
$('#testsiteId').change(function() {

    // Site id
    var id = $(this).val();
    // Empty the dropdown
    $('#provinceId').find('option').not(':first').remove();

    // AJAX request 
    $.ajax({
        url: "{{url('/getProvince') }}/" + id,
        type: 'get',
        dataType: 'json',
        success: function(response) {
            if (response.length == 0) {
                $("#siteUniqueId").val('');
                $("#siteManager").val('');
                $("#testername").val('');
                $("#contactNo").val('');
            } else {
                $.each(response, function(key, value) {
                    $("#siteUniqueId").val(value.site_id);
                    $("#siteManager").val(value.site_manager);
                    $("#testername").val(value.tester_name);
                    $("#contactNo").val(value.contact_no);
                    if(value.province_id!=null) {
                    $("#provinceId").append('<option value="' + value.province_id + '"selected>' + value.province_name + '</option>');
                    }
                });
            }

        }
    });
});

});
</script>
@endsection
