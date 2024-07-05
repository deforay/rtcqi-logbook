@extends('layouts.main')

@section('content')
<style>
    .table1 td {
        padding: 0.95rem 0.5rem;
        ;
    }
</style>
<?php
$todays_date = date('d-M-Y');
$name_of_collector = session('name');
use Illuminate\Support\Facades\Lang;
$col = ['yellow', '#b5d477', '#d08662', '#76cece', '#ea7786'];
// print_r($latest->test_1_kit_id);die;
$test = '';
$messages=Lang::get('messages');
$sample_collection_limit=$global['sample_collection_past_months_limit'];
?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">{{ $messages["monthly_report"]}}</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">{{ $messages["manage"]}}
                        </li>
                        <li class="breadcrumb-item"><a href="/monthlyreport/">{{ $messages["monthly_report"]}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $messages["add"]}}</li>
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
                                                <th>{{ $messages['site_name']}}</th>
                                                <th>{{ $messages['entry_point']}}</th>
                                                <th>{{ $messages['reporting_month']}}</th>
                                                <th>{{ $messages['date_of_data_collection']}}</th>
                                                <th>{{ $messages['name_of_data_collector']}}</th>
                                                <th>{{ $messages['book_number']}}</th>
                                                <th>{{ $messages['start_date']}}</th>
                                                <th>{{ $messages['end_date']}}</th>
                                                <th>{{ $messages['total_number_of_pages']}}</th>
                                                <th>{{ $messages['last_modified_on']}}</th>
                                                <?php $role = session('role');
                                                if (isset($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit']) && ($role['App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController']['edit'] == "allow")) {?>
                                                <th>{{ $messages["action"]}}</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="form-section"><i class="la la-plus-square"></i> {{ $messages["add_new_report"]}}</h4>
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
                                                <h5>{{ $messages["site_name"]}}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="js-example-basic-single form-control isRequired" autocomplete="off" style="width:100%;" id="testsiteId" name="testsiteId" title="{{ $messages['please_select_test_site_name']}}">
                                                        @foreach($testsite as $row2)
                                                        <option value="{{$row2->ts_id}}">{{$row2->site_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["entry_point"]}}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="js-example-basic-single form-control isRequired" autocomplete="off" style="width:100%;" id="sitetypeId" name="sitetypeId" title="{{ $messages['please_select_entry_point']}}">
                                                        @foreach($sitetype as $row1)
                                                        <option value="{{$row1->st_id}}">{{$row1->site_type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["site_id"]}}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="siteUniqueId" class="form-control" autocomplete="off" placeholder="{{$messages['enter_site_unique_id']}}" name="siteUniqueId" title="{{ $messages['please_enter_site_unique_id']}}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["province_name"]}}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId" title="{{ $messages['please_select_province_name']}}">
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
                                                <h5>{{ $messages["district_name"]}}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="districtId" name="districtId" title="{{ $messages['please_select_district_name']}}">
                                                        <option value="">---Select---</option>
                                                        @foreach($district as $row)
                                                        <option value="{{$row->district_id}}">{{$row->district_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["sub_district_name"]}}
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control" autocomplete="off" style="width:100%;" id="subDistrictId" name="subDistrictId" title="{{ $messages['please_select_sub_district_name']}}">
                                                        <option value="">---Select---</option>
                                                        @foreach($subdistrict as $row)
                                                        <option value="{{$row->sub_district_id}}">{{$row->sub_district_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["site_manager"]}}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="siteManager" class="form-control" autocomplete="off" placeholder="{{$messages['enter_site_manager']}}" name="siteManager" title="{{ $messages['please_enter_site_manager']}}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["is_flc"]}}<span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isFlu" name="isFlu" title="{{ $messages['please_select_is_flc_status']}}">
                                                        <option value="">-- Select --</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
										<fieldset>
											<h5>{{ $messages["lab_manager_name"]}} <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="testername" class="form-control isRequired " autocomplete="off" placeholder="{{$messages['enter_lab_manager_name']}}" name="testername" title="{{ $messages['please_enter_lab_manager_name']}}" >
											</div>
										</fieldset>
									</div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["lab_manager_contact_number"]}}
                                                </h5>
                                                <div class="form-group">
                                                <input type="tel" id="contactNo" maxlength="10" onkeypress="return isNumberKey(event);" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_tester_contact_phone']}}" name="contactNo" title="{{ $messages['please_enter_tester_contact_phone']}}" >
                                                </div>
                                            </fieldset>
                                        </div>
                                        @if($global['recency_test']=='enabled')
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["does_site_do_recency_tests"]}} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isRecency" name="isRecency" title="{{ $messages['please_select_does_site_do_recency_tests']}}?">
                                                        <option value="yes">Yes</option>
                                                        <option value="no" selected>No</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        @endif
                                        {{-- <div class="form-group col-xl-3 col-lg-3">
										<fieldset>
											<h5>{{ $messages["latitude"]}} <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="latitude" class="form-control isRequired " autocomplete="off" placeholder="{{$messages['enter_latitude']}}" name="latitude" title="{{ $messages['please_enter_latitude']}}" >
											</div>
										</fieldset>
									</div>
                                    <div class="form-group col-xl-3 col-lg-3">
										<fieldset>
											<h5>{{ $messages["longitude"]}} <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="longitude" class="form-control isRequired " autocomplete="off" placeholder="{{$messages['enter_longitude']}}" name="longitude" title="{{ $messages['please_enter_longitude']}}" >
											</div>
										</fieldset>
									</div> --}}
                                        
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <?php
                                                $testingAlgorithmType=explode(',',$testingAlgorithmType);
                                                ?>
                                                <h5>{{ __('messages.algorithm_type') }} <span class="mandatory">*</span></h5>
                                                <div class="form-group">
                                                    <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="algoType" name="algoType" title="{{ __('messages.select') }} {{ __('messages.algorithm_type') }}">
                                                        <option value="">---Select---</option>
                                                        @if(in_array("serial",$testingAlgorithmType))
                                                            <option value="serial">Serial</option>
                                                        @endif
                                                        @if(in_array("parallel",$testingAlgorithmType))
                                                            <option value="parallel">Parallel</option>
                                                        @endif
                                                        @if(in_array("who3",$testingAlgorithmType))
                                                            <option value="who3">WHO 3</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["name_of_data_collector"]}}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="nameOfDataCollect" class="form-control" autocomplete="off" placeholder="{{$messages['enter_name_of_data_collected']}}" name="nameOfDataCollect" title="{{ $messages['please_enter_name_of_data_collected']}}" value="{{$name_of_collector}}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["date_of_data_collection"]}}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="DateOfCollect" class="form-control" autocomplete="off" placeholder="{{$messages['enter_date_of_collection']}}" name="DateOfCollect" title="{{ $messages['please_enter_date_of_collection']}}" value="{{$todays_date}}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["reporting_month"]}} <span class="mandatory">*</span>
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="reportingMon" class="form-control isRequired" autocomplete="off" placeholder="{{$messages['enter_reporting_month']}}" name="reportingMon" title="{{ $messages['please_enter_reporting_month']}}" >
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3">
                                            <fieldset>
                                                <h5>{{ $messages["book_number"]}}
                                                </h5>
                                                <div class="form-group">
                                                    <input type="text" id="bookNo" class="form-control" autocomplete="off" placeholder="{{$messages['enter_book_no']}}." name="bookNo" title="{{ $messages['please_enter_book_no']}}">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <br />
                                    <div id="test_row">

                                        <h4 style="font-weight: normal; text-transform:uppercase;" class="form-section">{{ $messages["test_details"]}}</h4>

                                        <div class="testDetailsRow" id="test_details0">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-12">
                                                    <fieldset>
                                                        <h5>{{ $messages["page_no"]}}.</h5>
                                                        <div class="form-group">
                                                            <input type="number" min="0" id="pageNO1" class="form-control" autocomplete="off" placeholder="{{$messages['enter_page_no']}}." name="pageNO[]" title="{{ $messages['please_enter_page_no']}}." onchange="checkExistPageNos('1')">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-xl-4 col-lg-12">
                                                    <fieldset>
                                                        <h5>{{ $messages["start_date"]}} <span class="mandatory">*</span>
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="text" id="startDate0" class="form-control isRequired startDate" autocomplete="off" onchange="changeStartDate(0)" placeholder="{{$messages['enter_start_date']}}" name="startDate[]" title="{{ $messages['please_enter_start_date']}}">
                                                            <div id="show_error_date0" class="error-date" ></div>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                                <div class="col-xl-4 col-lg-12">
                                                    <fieldset>
                                                        <h5>{{ $messages["end_date"]}} <span class="mandatory">*</span>
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="text" id="endDate0" class="form-control isRequired  endDate" autocomplete="off" onchange="changeEndDate(0);" placeholder="{{$messages['enter_end_date']}}" name="endDate[]" title="{{ $messages['please_enter_end_date']}}">
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
                                                            <h5>{{ $messages["test_kit_name"]}} {{$i}}<span class="mandatory">*</span>
                                                            </h5>
                                                            @else
                                                            <h5>{{ $messages["test_kit_name"]}} {{$i}}
                                                            </h5>
                                                            @endif
                                                            <div class="form-group">
                                                            @if($i == 1)
                                                                <select class="form-control isRequired selectTestKits" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_0" name="testkitId{{$i}}[]" title="{{ $messages['please_select_test_kit_name']}}{{$i}}" onchange="replaceTestKitHeadings('{{$i}}','0',this)">
                                                                @else
                                                                <select class="form-control selectTestKits" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_0" name="testkitId{{$i}}[]" title="{{ $messages['please_select_test_kit_name']}}{{$i}}" onchange="replaceTestKitHeadings('{{$i}}','0',this)">
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
                                                                <h5>{{ $messages["test_kit_name"]}}{{$i}}<span class="mandatory">*</span>
                                                                </h5>
                                                                <div class="form-group">

                                                                    <select class="form-control isRequired selectTestKits" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_0" name="testkitId{{$i}}[]" title="{{ $messages['please_select_test_kit_name']}}{{$i}}" onchange="replaceTestKitHeadings('{{$i}}','0',this)">
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
                                                       <h5>{{ $messages["lot_no"]}} {{$j}}<span class="mandatory">*</span>
                                                        </h5>
                                                        @else
                                                        <h5>{{ $messages["lot_no"]}} {{$j}}
                                                        </h5>
                                                        @endif
                                                        <div class="form-group">
                                                        @if($j == 1)
                                                            <input type="text" id="lotNO0{{$j}}" class="form-control isRequired  " autocomplete="off" placeholder="{{$messages['enter_lot_no']}}." name="lotNO{{$j}}[]" title="{{ $messages['please_enter_lot_no']}}.{{$j}}" oninput="checklotNo('0','{{$j}}')">
                                                        @else
                                                            <input type="text" id="lotNO0{{$j}}" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_lot_no']}}." name="lotNO{{$j}}[]" title="{{ $messages['please_enter_lot_no']}}.{{$j}}" oninput="checklotNo('0','{{$j}}')">
                                                        @endif
                                                        </div>
                                                        </td>
                                                        <td style=" text-align: center;" colspan="2">
                                                        @if($j == 1)
                                                            <h5>{{ $messages["expiry_date"]}} {{$j}}<span class="mandatory">*</span>
                                                            </h5>
                                                            @else
                                                            <h5>{{ $messages["expiry_date"]}} {{$j}}
                                                            </h5>
                                                            @endif
                                                            <div class="form-group">
                                                            @if($j == 1)
                                                                <input type="text" id="expiryDate0{{$j}}" class="form-control isRequired dates " autocomplete="off" name="expiryDate{{$j}}[]" placeholder="{{$messages['enter_expiry_date']}}" title="{{ $messages['please_enter_expiry_date']}}{{$j}}" onchange="checklotNo('0','{{$j}}')">
                                                                @else
                                                                <input type="text" id="expiryDate0{{$j}}" class="form-control dates " autocomplete="off" name="expiryDate{{$j}}[]" placeholder="{{$messages['enter_expiry_date']}}" title="{{ $messages['please_enter_expiry_date']}}{{$j}}" onchange="checklotNo('0','{{$j}}')">
                                                                @endif
                                                            </div>
                                                        </td>
                                                        @endfor
                                                </tr>
                                                <tr>
                                                    @for($k = 1; $k <= $globalValue; $k++) <td colspan="3" style=" text-align: center;" bgcolor="{{$col[$k]}}">
                                                        <h4 id="testKitHeading{{$k}}_0" style="font-weight: 600;color: white;">{{ $messages["test_kit"]}} {{$k}}</h4>
                                                        </td>
                                                        @endfor
                                                </tr>
                                                <tr>
                                                    @for($l = 1; $l <= $globalValue; $l++) <td style=" text-align: center;" bgcolor="{{$col[$l]}}">
                                                        <h5 style="color: white; font-weight: 500;"> {{ $messages["reactive"]}}
                                                        </h5>
                                                        <div class="form-group">
                                                            <input type="number" min="0" id="totalReactive{{$l}}" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_total_reactive_r']}} {{$l}}" name="totalReactive{{$l}}[]" title="{{ $messages['please_enter_total_reactive_r']}} {{$l}}">
                                                        </div>
                                                        </td>
                                                        <td style=" text-align: center;" bgcolor="{{$col[$l]}}">
                                                            <h5 style="color: white; font-weight: 500;">{{ $messages["non_reactive"]}}
                                                            </h5>
                                                            <div class="form-group">
                                                                <input type="number" min="0" id="totalNonReactive{{$l}}" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_total_non_reactive_nr']}} {{$l}}" name="totalNonReactive{{$l}}[]" title="{{ $messages['please_enter_total_non_reactive_nr']}} {{$l}}">
                                                            </div>
                                                        </td>
                                                        <td style=" text-align: center;" bgcolor="{{$col[$l]}}">
                                                            <h5 style="color: white; font-weight: 500;">{{ $messages["invalid"]}}
                                                            </h5>
                                                            <div class="form-group">
                                                                <input type="number" min="0" id="totalInvalid{{$l}}" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_total_invalid_inv']}} {{$l}}" name="totalInvalid{{$l}}[]" title="{{ $messages['please_enter_total_invalid_inv']}} {{$l}}">
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
                                                                <h4 style="font-weight: 600;"> {{ $messages["final_result"]}} </h4>
                                                            </td>
                                                            <td style=" text-align: center;">
                                                                <h5> {{ $messages["positive"]}}
                                                                </h5>
                                                                <div class="form-group">
                                                                    <input type="number" min="0" id="totalPositive0" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_final_positive']}}" name="totalPositive[]" title="{{ $messages['please_enter_final_positive']}}">
                                                                </div>
                                                            </td>
                                                            <td style=" text-align: center;">
                                                                <h5> {{ $messages["negative"]}}
                                                                </h5>
                                                                <div class="form-group">
                                                                    <input type="number" min="0" id="totalNegative0" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_final_negative']}}" name="totalNegative[]" title="{{ $messages['please_enter_final_negative']}}">
                                                                </div>
                                                            </td>
                                                            <td style=" text-align: center;">
                                                                <h5> {{ $messages["indeterminate"]}}
                                                                </h5>
                                                                <div class="form-group">
                                                                    <input type="number" min="0" id="finalUndetermined0" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_final_undetermined']}}" name="finalUndetermined[]" title="{{ $messages['please_enter_final_undetermined']}}">
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
                                                <i class="ft-plus icon-left"></i> {{ $messages["add_page"]}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/monthlyreport">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> {{ $messages["cancel"]}}
                                            </button>
                                        </a>
                                        <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> {{ $messages["save"]}}
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
    var selectedEndDate="";
    $(document).ready(function() {
        var rr = "{{$defaulttestingAlgorithm}}";
        $('#algoType').val(rr);
        $("#monthlyReportListWrapper").hide();
        $('.js-example-basic-single').select2();
        $selectElement = $('#testsiteId').prepend('<option selected></option>').select2({
            placeholder: "{{$messages['select_site_name']}}"
        });
        $selectElement = $('#sitetypeId').prepend('<option selected></option>').select2({
            placeholder: "{{$messages['select_site_type']}}"
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
        $('#DateOfCollect').datepicker({
            autoclose: true,
            format: 'dd-M-yyyy',
            changeMonth: true,
            changeYear: true,
            startDate:new Date(new Date().setMonth(new Date().getMonth() - parseInt(<?php echo $sample_collection_limit?>))),
            endDate: new Date(),
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

        // Entry Point / Site Type Change
        $('#sitetypeId').change(function() {
            getAllMonthlyReport();
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
            $('#districtId').find('option').not(':first').remove();
            $('#subDistrictId').find('option').not(':first').remove();
            $('#bookNo').val('');

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
                        $("#bookNo").val('');
                    } else {
                        $.each(response, function(key, value) {

                            $("#siteUniqueId").val(value.site_id);
                            $("#siteManager").val(value.site_manager);
                            $("#testername").val(value.tester_name);
                            $("#contactNo").val(value.contact_no);
                            $("#bookNo").val(value.book_no);
                            if(value.province_id!=null) {
                            $("#provinceId").append('<option value="' + value.province_id + '"selected>' + value.province_name + '</option>');
                            }
                            if(value.district_id!=null) {
                            $("#districtId").append('<option value="' + value.district_id + '"selected>' + value.district_name + '</option>');
                            }
                            if(value.sub_district_id!=null) {
                            $("#subDistrictId").append('<option value="' + value.sub_district_id + '"selected>' + value.sub_district_name + '</option>');
                            }
                        });
            }

    }
});
});
loadReplaceTestKitHeadings();
    $("#endDate0").on("changeDate", function() { 
        endDate=$("#endDate0").val();
        if(endDate!=""){
            splitEndDate=endDate.split("-");
            selectedEndDate=splitEndDate[1]+'-'+splitEndDate[2];
            checkReportingMonth();
        }        
    });
 });

 function getAllMonthlyReport() {
    var siteTypeId = $('#sitetypeId').val() == '' ? "":parseInt($('#sitetypeId').val());
    var testSiteId = $('#testsiteId').val() == '' ? "" : parseInt($('#testsiteId').val());
    
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
            "aLengthMenu": [[5, 10, 15, 25, 50, 100 , -1], [5, 10, 15, 25, 50, 100, "All"]],
            ajax: {
                url: '{{ url("getSelectedSiteMonthlyReport") }}',
                type: 'POST',
                data: {
                    testSiteId: testSiteId,
                    siteTypeId: siteTypeId
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
            var errorMessage='<span style="color:red">{{$messages["please_select_start_date"]}}</span>'
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
        checkExistingSameSiteStartEndDate(id);
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
            //             var errorMessage="{{ __('messages.select') }} start date first";
            //             $('#endDate' + i).val('');
            //             $('#show_error_date'+i).html(flag).delay(3000).fadeOut();
            //             $('#show_error_date'+i).css("display", "block");
            //             $(".error-date").focus();
            //             return false;
            //         }
            //     }

            // }
            checkReportingMonth();
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
						<h5>{{ $messages["page_no"]}}.</h5>\
						<div class="form-group">\
							<input type="number" min="0" id="pageNO' + rowCount + '" class="form-control" autocomplete="off" placeholder="{{$messages['enter_page_no']}}." name="pageNO[]" title="{{$messages['please_enter_page_no']}}." onchange="checkExistPageNos(\'' + rowCount + '\')" >\
						</div>\
					</fieldset>\
				</div>\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>{{ $messages["start_date"]}} <span class="mandatory">*</span>\
						</h5>\
						<div class="form-group">\
							<input type="text" id="startDate' + rowCount + '" class="form-control startDate" onchange="changeStartDate(' + rowCount + ')" placeholder="{{$messages['enter_start_date']}}" autocomplete="off" name="startDate[]" title="{{ $messages['please_enter_start_date']}}" >\
                            <div id="show_error_date' + rowCount + '" class="error-date" ></div>\
						</div>\
					</fieldset>\
				</div>\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>{{ $messages["end_date"]}} <span class="mandatory">*</span>\
						</h5>\
						<div class="form-group">\
							<input type="text" id="endDate' + rowCount + '" class="form-control  endDate" onchange="changeEndDate(' + rowCount + ')" placeholder="{{$messages['enter_end_date']}}" autocomplete="off" name="endDate[]" title="{{$messages['please_enter_end_date']}}" >\
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
							<h5>{{ $messages["test_kit_name"]}} {{$i}}\
								</h5>\
								<div class="form-group">\
									<select class="form-control" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_' + rowCount + '" name="testkitId{{$i}}[]" title="{{$messages['please_select_test_kit_name']}}{{$i}}" onchange="replaceTestKitHeadings(\'{{$i}}\',\'' + rowCount + '\',this)">\
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
							<h5>{{ $messages["test_kit_name"]}}{{$i}}\
								</h5>\
								<div class="form-group">\
									<select class="form-control" autocomplete="off" style="width:100%;" id="testkitId{{$i}}_' + rowCount + '" name="testkitId{{$i}}[]" title="{{$messages['please_select_test_kit_name']}}{{$i}}" onchange="replaceTestKitHeadings(' {
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
							<h5>{{ $messages["lot_no"]}}. ' + j + ' \
							</h5>\
							<div class="form-group">\
								<input type="text" id="lotNO' + rowCount + '' + j + '" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_lot_no']}}." name="lotNO' + j + '[]" title="{{$messages['please_enter_lot_no']}}.' + j + '" oninput=checklotNo(' + rowCount + ',' + j + ')>\
							</div>\
					</td>\
					<td style=" text-align: center;" colspan="2">\
							<h5>{{ $messages["expiry_date"]}} ' + j + '\
							</h5>\
							<div class="form-group">\
								<input type="text" id="expiryDate' + rowCount + '' + j + '" class="form-control dates " autocomplete="off" placeholder="{{$messages['enter_expiry_date']}}" name="expiryDate' + j + '[]" title="{{$messages['please_enter_expiry_date']}}' + j + '" onchange=checklotNo(' + rowCount + ',' + j + ')>\
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
						<h5 style="color: white; font-weight: 500;"> {{ $messages["reactive"]}}\
						</h5>\
						<div class="form-group">\
							<input type="number" min="0" id="totalReactive' + l + '" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_total_reactive_r']}} ' + l + '" name="totalReactive' + l + '[]" title="{{ $messages['please_enter_total_reactive_r']}} ' + l + '" >\
						</div>\
					</td>\
					<td style=" text-align: center;" bgcolor="' + col[l] + '">\
							<h5 style="color: white; font-weight: 500;">{{ $messages["non_reactive"]}}\
							</h5>\
							<div class="form-group">\
							<input type="number" min="0" id="totalNonReactive' + l + '" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_total_non_reactive_nr']}} ' + l + '" name="totalNonReactive' + l + '[]" title="{{ $messages['please_enter_total_non_reactive_nr']}} ' + l + '" >\
						</div>\
					</td>\
					<td style=" text-align: center;" bgcolor="' + col[l] + '">\
						<h5 style="color: white; font-weight: 500;">{{ $messages["invalid"]}} </h5> ';
            div += '		<div class="form-group">\
							<input type="number" min="0" id="totalInvalid' + l + '" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_total_invalid_inv']}} ' + l + '" name="totalInvalid' + l + '[]" title="{{ $messages['please_enter_total_invalid_inv']}} ' + l + '" >\
						</div>\
					</td>'
        }
        div += '</tr></table><br>\
						<div class="row">\
							<div class="col-10">\
								<table class="table1" style="width:80%;margin-left: 10%;">\
									<tr>\
										<td  style=" text-align: center;">\
										<h4 style="font-weight: 600;"> {{ $messages["final_result"]}} </h4>\
										</td>\
										<td style=" text-align: center;" >\
											<h5> {{ $messages["positive"]}}\
											</h5>\
											<div class="form-group">\
												<input type="number" min="0" id="totalPositive' + rowCount + '" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_final_positive']}}" name="totalPositive[]" title="{{ $messages['please_enter_final_positive']}}" >\
											</div>\
										</td>\
										<td style=" text-align: center;" >\
											<h5> {{ $messages["negative"]}}\
											</h5>\
											<div class="form-group">\
												<input type="number" min="0" id="totalNegative' + rowCount + '" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_final_negative']}}" name="totalNegative[]" title="{{ $messages['please_enter_final_negative']}}" >\
											</div>\
										</td>\
										<td style=" text-align: center;" >\
											<h5> {{ $messages["indeterminate"]}}\
											</h5>\
											<div class="form-group">\
												<input type="number" min="0" id="finalUndetermined' + rowCount + '" class="form-control  " autocomplete="off" placeholder="{{$messages['enter_final_undetermined']}}" name="finalUndetermined[]" title="{{ $messages['please_enter_final_undetermined']}}" >\
											</div>\
										</td>\
									</tr>\
								</table>\
							</div>\
						<div class="col-2 mt-5">\
							<div style="color:white;margin-left:5%;">\
								<a  onclick="delete_row(' + rowCount + ');" class="btn btn-danger grey">\
								<i class="ft-minus icon-left"></i> {{ $messages["remove_page"]}}\
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
        
        $("#endDate"+rowCount).on("changeDate", function() { 
            endDate=$("#endDate"+rowCount).val();
            if(endDate!=""){
                splitEndDate=endDate.split("-");
                selectedEndDate=splitEndDate[1]+'-'+splitEndDate[2];
                checkReportingMonth();
            }
        });
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
                        var error='{{$messages['expiry_date_for_the_lot_no_was_recorded_as_previously']}}';
                        var errorMessageReplace=error.replace(':lotno', lot);
                        var errorMessage=error.replace(':expiry', result['expiry']);
                        alert(errorMessage);
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

            var error='{{$messages['page_no_has_already_been_added_for_this_product']}}';
            var errorMessage=error.replace(':pageno', itemId);
            alert(errorMessage);
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
                    if (result > 0)
                    {
                        var error='{{$messages['reporting_period_has_already_exist_for_this_site']}}';
                        var errorMessage=error.replace(':date', reportingDate);
                        alert(errorMessage);
                        $("#reportingMon").val('');
                        return;
                    }
                }
            });
        }
    }

    function checkExistingSameSiteStartEndDate(id) {
        var siteName= document.getElementById("testsiteId").value;
        var startDate = document.getElementById("startDate"+id).value;        
        var endDate = document.getElementById("endDate"+id).value;
        
        if(siteName != "" && startDate!='' &&  endDate!='')
        {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/getDuplicateMonthlyReport') }}",
                method: 'post',
                data: {
                    siteName: siteName,
                    startDate: startDate, 
                    endDate: endDate,
                },
                success: function(result){
                    
                    if (result.length > 0)
                    {
                        alert("Logbook data already recorded for "+result[0].site_name+" for the period "+startDate+" - "+endDate+" on "+result[0].date_of_data_collection);
                        document.getElementById("startDate"+id).value="";
                        document.getElementById("endDate"+id).value="";
                        $("#reportingMon").val('');
                        return;
                    }
                },
                error:function(e){
                    //console.log(e);
                }
            });
        }
    }
       

    function loadReplaceTestKitHeadings(){
        let defaultTestkit = $(".selectTestKits").length;
        for (var headingNo = 1; headingNo <= defaultTestkit; headingNo++) {
        let optionSelected = ($(`#testkitId`+headingNo+`_0`).val() && $(`#testkitId`+headingNo+`_0`).find(":selected").text()) || `Test Kit 1`;
        $(`#testKitHeading`+headingNo+`_0`).html(optionSelected);
        }
    }

    function checkReportingMonth(){
        var mnths = {
            "01" : "Jan",
            "02" : "Feb",
            "03" : "Mar",
            "04" : "Apr",
            "05" : "May",
            "06" : "Jun",
            "07" : "Jul",
            "08" : "Aug",
            "09" : "Sep",
            "10" : "Oct",
            "11" : "Nov",
            "12" : "Dec"
        };
        maxEndDate=[];
        $('.endDate').each(function() {
            maxEndDate.push(new Date($(this).val()));
        });
        let maximumDate = new Date(Math.max.apply(null, maxEndDate));
        
        var t=new Date(maximumDate);
        var year=t.getFullYear();
        var mnth = ("0" + (t.getMonth()+1)).slice(-2);
        
        maxSelectedDate=[mnths[mnth],year].join("-");
        $("#reportingMon").val(maxSelectedDate);

        checkExistingReportingMonth();
        /*
        reportingMon=$("#reportingMon").val();
        if(reportingMon!=selectedEndDate && selectedEndDate!="" && reportingMon!=""){
            duplicateName=false;
            alert("{{ __('messages.select') }} the valid reporting month");
        }else if(reportingMon==selectedEndDate){
            duplicateName=true;
        }
        */ 
    }

   
</script>
@endsection
