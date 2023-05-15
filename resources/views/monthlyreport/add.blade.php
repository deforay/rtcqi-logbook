@extends('layouts.main')

@section('content')
<style>
    .table1 td {
        padding: 0.95rem 0.5rem;
        ;
    }
</style>
<?php
$col = ['yellow', '#b5d477', '#d08662', '#76cece', '#ea7786'];
// print_r($latest->test_1_kit_id);die;
$test = '';

?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Monthly Report</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Manage
                        </li>
                        <li class="breadcrumb-item"><a href="/monthlyreport/">Monthly report</a>
                        </li>
                        <li class="breadcrumb-item active">Add</li>
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
                
                                <div class="table-responsive" id="monthlyReportListWrapper">
                                    <table class="table table-striped table-bordered zero-configuration" id="mothlyreportList">
                                        <thead>
                                            <tr>
                                                <th>Site Name</th>
                                                <th>Entry Point</th>
                                                <th>Reporting Month</th>
                                                <th>Date of Data Collection</th>
                                                <th>Name of Data Collector</th>
                                                <th>Book No</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Total Number of Pages</th>
                                                <th>Last Modified On</th>
                                                <?php $role = session('role');
                                                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit'] == "allow")) {?>
                                                <th>Action</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="form-section"><i class="la la-plus-square"></i> Add New Report</h4>
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
                                <form class="form" role="form" name="addMonthlyReport" id="addMonthlyReport" method="post" action="/monthlyreport/add" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="form-body row">

                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Site Name<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="js-example-basic-single form-control isRequired" autocomplete="off" style="width:100%;" id="testsiteId" name="testsiteId" title="Please select Test Site Name">
                                                        @foreach($testsite as $row2)
                                                        <option value="{{$row2->ts_id}}">{{$row2->site_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Entry Point<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="js-example-basic-single form-control isRequired" autocomplete="off" style="width:100%;" id="sitetypeId" name="sitetypeId" title="Please Select Entry Point">
                                                        @foreach($sitetype as $row1)
                                                        <option value="{{$row1->st_id}}">{{$row1->site_type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Site ID
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="siteUniqueId" class="form-control" autocomplete="off" placeholder="Enter Site Unique Id" name="siteUniqueId" title="Please Enter Site Unique Id">
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
                                                        <option value="{{$row->province_id}}">{{$row->province_name}}</option>
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
                                                    <input type="text" id="siteManager" class="form-control" autocomplete="off" placeholder="Enter Site Manager" name="siteManager" title="Please Enter Site Manager">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Is FLC?<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isFlu" name="isFlu" title="Please select Is FLC status">
                                                        <option value="">-- Select --</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
										<fieldset>
											<h5>Lab Manager Name <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="testername" class="form-control isRequired " autocomplete="off" placeholder="Enter Lab Manager Name" name="testername" title="Please Enter Lab Manager Name" >
											</div>
										</fieldset>
									</div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Lab Manager Contact Number
                                                </h5>
                                                <div class="form-group">
                                                <input type="tel" id="contactNo" maxlength="10" onkeypress="return isNumberKey(event);" class="form-control  " autocomplete="off" placeholder="Enter Tester Contact Phone" name="contactNo" title="Please Enter Tester Contact Phone" >
                                                </div>
                                            </fieldset>
                                        </div>
                                        @if($global['recency_test']=='enabled')
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Does site do Recency Tests?<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isRecency" name="isRecency" title="Please select Does site do Recency Tests?">
                                                        <option value="yes">Yes</option>
                                                        <option value="no" selected>No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        @endif
                                        {{-- <div class="form-group col-xl-3 col-lg-3">
										<fieldset>
											<h5>Latitude <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="latitude" class="form-control isRequired " autocomplete="off" placeholder="Enter latitude" name="latitude" title="Please Enter latitude" >
											</div>
										</fieldset>
									</div>
                                    <div class="form-group col-xl-3 col-lg-3">
										<fieldset>
											<h5>Longitude <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="longitude" class="form-control isRequired " autocomplete="off" placeholder="Enter longitude" name="longitude" title="Please Enter longitude" >
											</div>
										</fieldset>
									</div> --}}
                                        <!--
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Algorithm Type <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="algoType" name="algoType" title="Please select Algorithm Type">
                                                        <option value="">---Select---</option>
                                                        <option value="serial">Serial</option>
                                                        <option value="parallel">Parallel</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        -->
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Name of Data Collector
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="nameOfDataCollect" class="form-control" autocomplete="off" placeholder="Enter Name of Data Collected" name="nameOfDataCollect" title="Please Enter Name of Data Collected">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Date of Data Collection
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="DateOfCollect" class="form-control datepicker" autocomplete="off" placeholder="Enter Date Of Collection" name="DateOfCollect" title="Please Enter Date Of Collection">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Reporting Month <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="reportingMon" class="form-control isRequired" autocomplete="off" placeholder="Enter Reporting Month" name="reportingMon" title="Please Enter Reporting Month" >
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>Book Number
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="bookNo" class="form-control" autocomplete="off" placeholder="Enter Book No" name="bookNo" title="Please Enter Book No">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <br />
                                    <div id="test_row">

                                        <h4 style="font-weight: normal; text-transform:uppercase;" class="form-section">Test Details</h4>

                                        <div class="testDetailsRow" id="test_details0">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-12">
                                                    <fieldset>
                                                        <h5>Page No.</h5>
                                                        <div class="form-group">
                                                            <input type="number" min="0" id="pageNO1" class="form-control" autocomplete="off" placeholder="Enter Page No." name="pageNO[]" title="Please Enter Page No" onchange="checkExistPageNos('1')">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-xl-4 col-lg-12">
                                                    <fieldset>
                                                        <h5>Start Date <span class="mandatory">*</span>
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="text" id="startDate0" class="form-control isRequired startDate" autocomplete="off" onchange="changeStartDate(0)" placeholder="Enter Start Date" name="startDate[]" title="Please Enter Start Date">
                                                            <div id="show_error_date0" class="error-date" ></div>
                                                        </div>
                                                        
                                                    </fieldset>
                                                </div>
                                                <div class="col-xl-4 col-lg-12">
                                                    <fieldset>
                                                        <h5>End Date <span class="mandatory">*</span>
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="text" id="endDate0" class="form-control isRequired  endDate" autocomplete="off" onchange="changeEndDate(0);" placeholder="Enter End Date" name="endDate[]" title="Please Enter End Date">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <table class="table1" style="width:100%">
                                                <tr>
                                                    @if(count($allowedTestKitNo) > 0)
                                                    @for($i = 1; $i <= $globalValue; $i++) <?php
                                                                                            $test_id = 'test_' . $i . '_kit_id';
                                                                                            $test = '';
                                                                                            ?> <td style="text-align:center;" colspan="3">
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
                                                                <select class="form-control isRequired selectTestKits" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_0" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}" onchange="replaceTestKitHeadings('{{$i}}','0',this)">
                                                                @else
                                                                <select class="form-control selectTestKits" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_0" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}" onchange="replaceTestKitHeadings('{{$i}}','0',this)">
                                                                @endif
                                                                    <option value="">--Select--</option>
                                                                    @if(isset($allowedTestKitNo[$i]))
                                                                    @foreach($allowedTestKitNo[$i] as $value=>$option)
                                                                    @if(isset($latest->$test_id) && $latest->$test_id !='')
                                                                    <option value="{{$value}}" {{ $latest->$test_id == $value ?  'selected':''}}>{{$option}}</option>
                                                                    @else
                                                                    <option value="{{$value}}">{{$option}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                    @else
                                                                    @foreach($kittype as $row2)
                                                                    @if(isset($latest->$test_id) && $latest->$test_id !='')
                                                                    <option value="{{$row2->tk_id}}" {{ $latest->$test_id == $row2->tk_id ?  'selected':''}}>{{$row2->test_kit_name}}</option>
                                                                    @else
                                                                    <option value="{{$row2->tk_id}}">{{$row2->test_kit_name}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </fieldset>
                                                        </td>
                                                        @endfor
                                                        @else
                                                        @for($i = 1; $i <= $globalValue; $i++) <?php
                                                                                                $test_id = 'test_' . $i . '_kit_id';
                                                                                                $test = '';
                                                                                                ?> <td style=" text-align: center;" colspan="3">
                                                            <fieldset>
                                                                <h5>Test Kit Name{{$i}}<span class="mandatory">*</span>
                                                                </h5>
                                                                <div class="form-group">

                                                                    <select class="form-control isRequired selectTestKits" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_0" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}" onchange="replaceTestKitHeadings('{{$i}}','0',this)">
                                                                        <option value="">--Select--</option>
                                                                        @foreach($kittype as $row2)
                                                                        @if(isset($latest->$test_id) && $latest->$test_id !='')
                                                                        <option value="{{$row2->tk_id}}" {{ $latest->$test_id == $row2->tk_id ?  'selected':''}}>{{$row2->test_kit_name}}</option>
                                                                        @else
                                                                        <option value="{{$row2->tk_id}}">{{$row2->test_kit_name}}</option>
                                                                        @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </fieldset>
                                                            </td>
                                                            @endfor
                                                            @endif
                                                </tr>
                                                <tr>
                                                    @for($j = 1; $j <= $globalValue; $j++) <td style=" text-align: center;">
                                                    @if($j == 1)    
                                                       <h5>Lot No. {{$j}}<span class="mandatory">*</span>
                                                        </h5>
                                                        @else 
                                                        <h5>Lot No. {{$j}}
                                                        </h5>
                                                        @endif
                                                        <div class="form-group">
                                                        @if($j == 1)
                                                            <input type="text" id="lotNO0{{$j}}" class="form-control isRequired  " autocomplete="off" placeholder="Enter Lot No." name="lotNO{{$j}}[]" title="Please Enter Lot No.{{$j}}" oninput="checklotNo('0','{{$j}}')">
                                                        @else
                                                            <input type="text" id="lotNO0{{$j}}" class="form-control  " autocomplete="off" placeholder="Enter Lot No." name="lotNO{{$j}}[]" title="Please Enter Lot No.{{$j}}" oninput="checklotNo('0','{{$j}}')">
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
                                                            @if($j == 1)
                                                                <input type="text" id="expiryDate0{{$j}}" class="form-control isRequired dates " autocomplete="off" name="expiryDate{{$j}}[]" placeholder="Enter Expiry Date" title="Please Enter Expiry Date{{$j}}" onchange="checklotNo('0','{{$j}}')">
                                                                @else 
                                                                <input type="text" id="expiryDate0{{$j}}" class="form-control dates " autocomplete="off" name="expiryDate{{$j}}[]" placeholder="Enter Expiry Date" title="Please Enter Expiry Date{{$j}}" onchange="checklotNo('0','{{$j}}')">
                                                                @endif
                                                            </div>
                                                        </td>
                                                        @endfor
                                                </tr>
                                                <tr>
                                                    @for($k = 1; $k <= $globalValue; $k++) <td colspan="3" style=" text-align: center;" bgcolor="{{$col[$k]}}">
                                                        <h4 id="testKitHeading{{$k}}_0" style="font-weight: 600;color: white;">Test Kit {{$k}}</h4>
                                                        </td>
                                                        @endfor
                                                </tr>
                                                <tr>
                                                    @for($l = 1; $l <= $globalValue; $l++) <td style=" text-align: center;" bgcolor="{{$col[$l]}}">
                                                        <h5 style="color: white; font-weight: 500;"> R
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="number" min="0" id="totalReactive{{$l}}" class="form-control  " autocomplete="off" placeholder="Enter Total Reactive - R - {{$l}}" name="totalReactive{{$l}}[]" title="Please Enter Total Reactive - R - {{$l}}">
                                                        </div>
                                                        </td>
                                                        <td style=" text-align: center;" bgcolor="{{$col[$l]}}">
                                                            <h5 style="color: white; font-weight: 500;">NR
                                                            </h5>
                                                            <div class="form-group">
                                                                <input type="number" min="0" id="totalNonReactive{{$l}}" class="form-control  " autocomplete="off" placeholder="Enter Total Non-Reactive - R - {{$l}}" name="totalNonReactive{{$l}}[]" title="Please Enter Total Non-Reactive - R - {{$l}}">
                                                            </div>
                                                        </td>
                                                        <td style=" text-align: center;" bgcolor="{{$col[$l]}}">
                                                            <h5 style="color: white; font-weight: 500;">INV
                                                            </h5>
                                                            <div class="form-group">
                                                                <input type="number" min="0" id="totalInvalid{{$l}}" class="form-control  " autocomplete="off" placeholder="Enter Total Invalid - INV - {{$l}}" name="totalInvalid{{$l}}[]" title="Please Enter Total Invalid - INV - {{$l}}">
                                                            </div>
                                                        </td>

                                                        @endfor
                                                </tr>
                                            </table>
                                            <br>
                                            <div class="row">
                                                <div class="col-10">
                                                    <table class="table1" style="width:80%;margin-left: 10%;">
                                                        <tr>
                                                            <td style=" text-align: center;">
                                                                <h4 style="font-weight: 600;"> Final Result </h4>
                                                            </td>
                                                            <td style=" text-align: center;">
                                                                <h5> Positive
                                                                </h5>
                                                                <div class="form-group">
                                                                    <input type="number" min="0" id="totalPositive0" class="form-control  " autocomplete="off" placeholder="Enter Final Positive" name="totalPositive[]" title="Please Enter Final Positive">
                                                                </div>
                                                            </td>
                                                            <td style=" text-align: center;">
                                                                <h5> Negative
                                                                </h5>
                                                                <div class="form-group">
                                                                    <input type="number" min="0" id="totalNegative0" class="form-control  " autocomplete="off" placeholder="Enter Final Negative" name="totalNegative[]" title="Please Enter Final Negative">
                                                                </div>
                                                            </td>
                                                            <td style=" text-align: center;">
                                                                <h5> Indeterminate
                                                                </h5>
                                                                <div class="form-group">
                                                                    <input type="number" min="0" id="finalUndetermined0" class="form-control  " autocomplete="off" placeholder="Enter Final Undertermined" name="finalUndetermined[]" title="Please Enter Final Undertermined">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <!-- <div class="col-2">
												<div style="color:white;margin-left:10%;">
													<a  onclick="delete_row();" class="btn btn-danger grey">
													<i class="ft-minus icon-left"></i> Remove Page
													</a>
												</div>
											</div> -->
                                            </div>
                                        </div>
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
                                            <i class="la la-check-square-o"></i> Save
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
        $("#monthlyReportListWrapper").hide();
        $('.js-example-basic-single').select2();
        $selectElement = $('#testsiteId').prepend('<option selected></option>').select2({
            placeholder: "Select Site Name"
        });
        $selectElement = $('#sitetypeId').prepend('<option selected></option>').select2({
            placeholder: "Select Site Type"
        });
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
        $('#reportingMon').datepicker({
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
        })
    .on('changeDate', checkExistingReportingMonth);

        $(".dates").datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
        });

        $(".startDate").datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            todayHighlight: true,
     endDate: new Date()
        });
        $(".endDate").datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            todayHighlight: true,
     endDate: new Date()
        });

         // Site Name Change
         $('#testsiteId').change(function() {
            checkExistingReportingMonth();
// Site id
var id = $(this).val();
//get Site name last 5 records
getAllMonthlyReport();
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
loadReplaceTestKitHeadings();
 });

 function getAllMonthlyReport() {
    var testSiteId = parseInt($('#testsiteId').val());   
    //alert($('#testsiteId').val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#monthlyReportListWrapper').show();
        $('#mothlyreportList').DataTable({
            processing: true,
            destroy: true,
            serverSide: true,
            scrollX: false,
            autoWidth: false,
            paging: false,
            
            ajax: {
                url: '{{ url("getSelectedSiteMonthlyReport") }}',
                type: 'POST',
                data: {
                    testSiteId: testSiteId,               
                },
                
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
                    name: 'date_of_data_collection',render: function(data, type, full) {
     return moment(new Date(data)).format('DD-MMM-YYYY');
                    }
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
                    name: 'end_test_date',render: function(data, type, full) {
     return moment(new Date(data)).format('DD-MMM-YYYY');
                    }
                },

                {
                    data: 'page_no',
                    name: 'page_no'
                },
                {
                    data: 'last_modified_on',
                    name: 'last_modified_on',render: function(data, type, full) {
     return moment(new Date(data)).format('DD-MMM-YYYY HH:mm:ss');
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [9, 'desc']
            ],
            limit:5
        });
    }


    var date1 = new Date();
    var today = new Date(date1.getFullYear(), date1.getMonth(), date1.getDate());

    function changeStartDate(id) {
        $("#endDate" + id).val('');
        $("#startDate" + id).datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: today,
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#endDate' + id).datepicker('setStartDate', minDate);
        });
        // var minDate = new Date(selected.date.valueOf());
        // $('#endDate'+id).datepicker('setStartDate', minDate);
    }

    function changeEndDate(id) {
        
        if($('#startDate' + id).val() === ''){
            var errorMessage='<span style="color:red">Please select start date!</span>'
            $('#show_error_date'+id).html(errorMessage).delay(3000).fadeOut();
            $('#show_error_date'+id).css("display", "block"); 
            $("#endDate" + id).val('');           
            $(".error-date").focus();
        }else{
            $("#endDate" + id).datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: today,
            maxDate:"now"
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#startDate' + id).datepicker('setEndDate', minDate);
        });
        }
        
        // var minDate = new Date(selected.date.valueOf());
        //        $('#startDate'+id).datepicker('setEndDate', minDate);
    }
    duplicateName = true;

    function validateNow() {
        flag = deforayValidator.init({
            formId: 'addMonthlyReport'
        });
        
        if (flag == true) {
            // var rowCount = $(".testDetailsRow").length;
            // if(rowCount > 0){
            //     alert('sss');
            //     for(var i=0; $i<rowCount; $i++){
            //         if($('#startDate' + i).val() === '' && $('#endDate' + i).val() !== ''){           
            //             var errorMessage="please select start date first";
            //             $('#endDate' + i).val('');
            //             $('#show_error_date'+i).html(flag).delay(3000).fadeOut();
            //             $('#show_error_date'+i).css("display", "block");
            //             $(".error-date").focus();
            //             return false;
            //         }
            //     }                
            
            // }
            if (duplicateName) {
                document.getElementById('addMonthlyReport').submit();
            }
        } else {
            //alert(flag);
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }

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
							<input type="number" min="0" id="pageNO' + rowCount + '" class="form-control" autocomplete="off" placeholder="Enter Page No." name="pageNO[]" title="Please Enter Page No" onchange="checkExistPageNos(\'' + rowCount + '\')" >\
						</div>\
					</fieldset>\
				</div>\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>Start Date <span class="mandatory">*</span>\
						</h5>\
						<div class="form-group">\
							<input type="text" id="startDate' + rowCount + '" class="form-control startDate" onchange="changeStartDate(' + rowCount + ')" placeholder="Enter Start Date" autocomplete="off" name="startDate[]" title="Please Enter Start Date" >\
                            <div id="show_error_date' + rowCount + '" class="error-date" ></div>\
						</div>\
					</fieldset>\
				</div>\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>End Date <span class="mandatory">*</span>\
						</h5>\
						<div class="form-group">\
							<input type="text" id="endDate' + rowCount + '" class="form-control  endDate" onchange="changeEndDate(' + rowCount + ')" placeholder="Enter End Date" autocomplete="off" name="endDate[]" title="Please Enter End Date" >\
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
									<select class="form-control" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_' + rowCount + '" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}" onchange="replaceTestKitHeadings(\'{{$i}}\',\'' + rowCount + '\',this)">\
									<option value="">--Select--</option>\
										@if(isset($allowedTestKitNo[$i]))\
											@foreach($allowedTestKitNo[$i] as $value=>$option)\
												<option value="{{$value}}">{{$option}}</option>\
											@endforeach\
										@else\
											@foreach($kittype as $row2)\
												<option value="{{$row2->tk_id}}">{{$row2->test_kit_name}}</option>\
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
									<select class="form-control" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_' + rowCount + '" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}" onchange="replaceTestKitHeadings(' {
            {
                $i
            }
        }
        ',\'' + rowCount + '\',this)">\
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
								<input type="text" id="lotNO' + rowCount + '' + j + '" class="form-control  " autocomplete="off" placeholder="Enter Lot No." name="lotNO' + j + '[]" title="Please Enter Lot No.' + j + '" oninput=checklotNo(' + rowCount + ',' + j + ')>\
							</div>\
					</td>\
					<td style=" text-align: center;" colspan="2">\
							<h5>Expiry Date ' + j + '\
							</h5>\
							<div class="form-group">\
								<input type="text" id="expiryDate' + rowCount + '' + j + '" class="form-control dates " autocomplete="off" placeholder="Enter Expiry Date" name="expiryDate' + j + '[]" title="Please Enter Expiry Date' + j + '" onchange=checklotNo(' + rowCount + ',' + j + ')>\
							</div>\
					</td>';
        }
        div += '</tr><tr>'
        for (var k = 1; k <= gCnt; k++) {
            div += '<td colspan="3" style=" text-align: center;" bgcolor="' + col[k] + '">\
						<h4 id="testKitHeading' + k + '_' + rowCount + '" style="font-weight: 600;color: white;">Test Kit ' + k + '</h4>\
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
        });
        $(".startDate").datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            todayHighlight: true,
     endDate: new Date()
        });
        $(".endDate").datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            todayHighlight: true,
     endDate: new Date()
        });
        let defaultRow = 0;
        let defaultTestkit = $(".selectTestKits").length;
        for (var headingNo = 1; headingNo <= defaultTestkit; headingNo++) {
            let tkBlock1 = $(`#testkitId${headingNo}_${defaultRow}`).val();
            let lotNoBlock1 = $(`#lotNO${defaultRow}${headingNo}`).val();
            let expiryDateBlock1 = $(`#expiryDate${defaultRow}${headingNo}`).val();
            let lotNoBlock2 = $(`#lotNO${rowCount}${headingNo}`).val(lotNoBlock1);
            let expiryDateBlock2 = $(`#expiryDate${rowCount}${headingNo}`).val(expiryDateBlock1);
            let tkBlock2 = $(`#testkitId${headingNo}_${rowCount}`).val(tkBlock1);
            let optionSelected = ($(`#testkitId${headingNo}_${defaultRow}`).val() && $(`#testkitId${headingNo}_${defaultRow}`).find(":selected").text()) || `Test Kit ${headingNo}`;
            $(`#testKitHeading${headingNo}_${rowCount}`).html(optionSelected);
        }
    }

    function delete_row(val) {
        if (val != 0) {
            $("#test_details" + val).remove();
        }
    }

    function checklotNo(row, id) {
        var lot = $("#lotNO" + row + id).val();
        var expiry = $("#expiryDate" + row + id).val();
        var field = '	lot_no_' + id;
        var expfield = '	expiry_date_' + id;
        if (lot != '' && expiry != '') {
            console.log(lot + ' ' + expiry)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/CheckPreLot') }}",
                method: 'post',
                data: {
                    lot: lot,
                    expiry: expiry,
                    field: field,
                    expfield: expfield,
                },
                success: function(result) {
                    console.log(result)
                    if (result['status'] == 0) {
                        alert("The Expiry Date for the lot number " + lot + " was recorded as " + result['expiry'] + " previously")
                    }
                }
            });
        }
    }

    function checkExistPageNos(rowId) {
        var itemId = document.getElementById("pageNO" + rowId).value;
        var itemCount = document.getElementsByName("pageNO[]");
        var itemLength = itemCount.length - 1;
        var k = 0;
        for (i = 0; i <= itemLength; i++) {
            if (itemId == itemCount[i].value) {
                k++;
            }
        }
        if (k > 1) {
            alert("Page No. "+ itemId +" has already been added for this audit");
            $("#pageNO" + rowId).val('');
            $("#pageNO" + rowId).trigger('change');
        } else {
            // Do something
        }
    }
    //Replace Test Kit Heading No with Dropdown Name
    function replaceTestKitHeadings(headingNo, rowNo, selectObj) {
        let optionSelected = ($(selectObj).val() && $(selectObj).find(":selected").text()) || `Test Kit ${headingNo}`;
        $(`#testKitHeading${headingNo}_${rowNo}`).html(optionSelected);
    }

    //To check for existing report month for same site name on monthly report table
    function checkExistingReportingMonth() {
        var reportingDate = document.getElementById("reportingMon").value;
        var siteName= document.getElementById("testsiteId").value;
        if(reportingDate!='')
        {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/getReportingMonth') }}",
                method: 'post',
                data: {
                    reportingDate: reportingDate,
                    siteName: siteName,
                },
                success: function(result){
                    console.log(result)
                    if (result > 0)
                    {
                        alert("Reporting Period "+ reportingDate +" has already been added for this Site");
                        $("#reportingMon").val('');
                    }
                }
            });
        }
    }

    function loadReplaceTestKitHeadings(){
        let optionSelected = ($(`#testkitId1_0`).val() && $(`#testkitId1_0`).find(":selected").text()) || `Test Kit 1`;
        $(`#testKitHeading1_0`).html(optionSelected);
    }
</script>
@endsection