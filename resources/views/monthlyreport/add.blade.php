<!-- 
    Author             : Prasath M
    Date               : 02 Jun 2021
    Description        : Monthly report add screen
    Last Modified Date : 02 Jun 2021
    Last Modified Name : Prasath M
-->
@extends('layouts.main')

@section('content')
<style>
.table1 td{
 padding: 0.95rem 0.5rem;; 
}
</style>
<?php
$col = ['yellow', '#b5d477' , '#d08662', '#76cece', '#ea7786'];
// $data= array();
// $testkit_id = array();
// $test_kit_name = array();
// foreach($allowedTestKitNo as $rows)
// {
// $data[] = $rows->test_kit_no;
// $testkit_id[] = $rows->testkit_id;
// $test_kit_name[] = $rows->test_kit_name;
// }
// dd($allowedTestKitNo);die;

?>
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Monthly report</h3>
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
      <div class="content-body">
	<!-- horizontal grid start -->
	<section class="horizontal-grid" id="horizontal-grid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="form-section"><i class="la la-plus-square"></i> Add Monthly report</h4>
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
						<div id="show_alert"  class="mt-1" style=""></div>
                            <form class="form form-horizontal" role="form" name="addMonthlyReport" id="addMonthlyReport" method="post" action="/monthlyreport/add" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                                <div class="row">
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Province Name<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId" title="Please select Province Name">
                                                    @foreach($province as $row)
                                                    <option value="{{$row->provincesss_id}}">{{$row->province_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
									<div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Site Name<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testsiteId" name="testsiteId" title="Please select Test Site Name">
                                                    @foreach($testsite as $row2)
                                                    <option value="{{$row2->ts_id}}">{{$row2->site_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Site Type<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="sitetypeId" name="sitetypeId" title="Please select Site type Name">
                                                    @foreach($sitetype as $row1)
                                                    <option value="{{$row1->st_id}}">{{$row1->site_type_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Site Unique Id <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="siteUniqueId" class="form-control  isRequired" autocomplete="off" placeholder="Enter Site Unique Id" name="siteUniqueId" title="Please Enter Site Unique Id" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Site Manager 
											</h5>
											<div class="form-group">
                                                <input type="text" id="siteManager" class="form-control" autocomplete="off" placeholder="Enter Site Manager" name="siteManager" title="Please Enter Site Manager" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Is FLC<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isFlu" name="isFlu" title="Please select Is FLC status">
                                                    <option value="yes" >Yes</option>
                                                    <option value="no" selected>No</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Does site do Recency Tests?<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isRecency" name="isRecency" title="Please select Does site do Recency Tests?">
                                                    <option value="yes" >Yes</option>
                                                    <option value="no" selected>No</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Contact Number 
											</h5>
											<div class="form-group">
                                                <input type="text" id="contactNo" class="form-control" autocomplete="off" placeholder="Enter Contact Number" name="contactNo" title="Please Enter Contact Number" >
											</div>
										</fieldset>
									</div>
                                    <!-- <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Latitude <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="latitude" class="form-control isRequired " autocomplete="off" placeholder="Enter latitude" name="latitude" title="Please Enter latitude" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Longitude <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="longitude" class="form-control isRequired " autocomplete="off" placeholder="Enter longitude" name="longitude" title="Please Enter longitude" >
											</div>
										</fieldset>
									</div> -->
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Algorithm Type <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
												<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="algoType" name="algoType" title="Please select Algorithm Type">
													<option >Select Algorith Type</option>
													<option value="serial">Serial</option>
                                                    <option value="parallel" >Parallel</option>
                                                </select>
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Date of data collection <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="DateOfCollect" class="form-control isRequired datepicker" autocomplete="off" placeholder="Enter Date Of Collection" name="DateOfCollect" title="Please Enter Date Of Collection" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Reporting Month <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="reportingMon" class="form-control isRequired datepicker" autocomplete="off" placeholder="Enter Reporting Month" name="reportingMon" title="Please Enter Reporting Month" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Book Number <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="bookNo" class="form-control isRequired" autocomplete="off" placeholder="Enter Book No" name="bookNo" title="Please Enter Book No" >
											</div>
										</fieldset>
									</div>
                                    <!-- <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Signature 
											</h5>
											<div class="form-group">
                                                <input type="text" id="signature" class="form-control  " autocomplete="off" placeholder="Enter Signature" name="signature" title="Please Enter Signature" >
											</div>
										</fieldset>
									</div> -->
                                    <div class="col-xl-3 col-lg-12">
										<fieldset>
											<h5>Name of Data Collector 
											</h5>
											<div class="form-group">
                                                <input type="text" id="nameOfDataCollect" class="form-control  " autocomplete="off" placeholder="Enter Name of Data Collected" name="nameOfDataCollect" title="Please Enter Name of Data Collected" >
											</div>
										</fieldset>
									</div>
                                </div>
								<br/>
								<div id="test_row">
									<div class="row ml-2">
										<h4 style="font-weight: 600;">Test Details</h4>
									</div>
									<hr>
									<div id="test_details0">
										<div class="row">
											<div class="col-xl-4 col-lg-12">
												<fieldset>
													<h5>Page No 
													</h5>
													<div class="form-group">
														<input type="number" min="0" id="pageNO0" class="form-control  " autocomplete="off" placeholder="Enter Page No" name="pageNO[]" title="Please Enter Page No" >
													</div>
												</fieldset>
											</div>
											<div class="col-xl-4 col-lg-12">
												<fieldset>
													<h5>Start Date
													</h5>
													<div class="form-group">
														<input type="date" id="startDate0" class="form-control  " autocomplete="off" name="startDate[]" title="Please Enter Start Date" >
													</div>
												</fieldset>
											</div>
											<div class="col-xl-4 col-lg-12">
												<fieldset>
													<h5>End Date
													</h5>
													<div class="form-group">
														<input type="date" id="endDate0" class="form-control  " autocomplete="off" name="endDate[]" title="Please Enter End Date" >
													</div>
												</fieldset>
											</div>
										</div>
										<table class="table1" style="width:100%">
											<tr>
											@if(count($allowedTestKitNo) > 0)
											@for($i = 1; $i <= $globalValue; $i++)
												<td  style=" text-align: center;" colspan="3" >
													<fieldset>
														<h5>Test Kit Name{{$i}}<span class="mandatory">*</span>
														</h5>
														<div class="form-group">

															<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testkitId{{$i}}" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}">
																@foreach($allowedTestKitNo[$i] as $value=>$option)
																
																<option value="{{$value}}">{{$option}}</option>
																@endforeach
															</select>
														</div>
													</fieldset>
												</td>
											@endfor
											@else 
											@for($i = 1; $i <= $globalValue; $i++)
												<td  style=" text-align: center;" colspan="3" >
													<fieldset>
														<h5>Test Kit Name{{$i}}<span class="mandatory">*</span>
														</h5>
														<div class="form-group">

															<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testkitId{{$i}}" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}">
																@foreach($kittype as $row2)
																
																<option value="{{$row2->tk_id}}">{{$row2->test_kit_name}}</option>
																@endforeach
															</select>
														</div>
													</fieldset>
												</td>
											@endfor
											@endif
											</tr>
											<tr>
											@for($j = 1; $j <= $globalValue; $j++)
												<td style=" text-align: center;">
														<h5>Lot No {{$j}} 
														</h5>
														<div class="form-group">
															<input type="number" min="0" id="lotNO{{$j}}" class="form-control  " autocomplete="off" placeholder="Enter Lot No" name="lotNO{{$j}}[]" title="Please Enter Lot No{{$j}}" >
														</div>
												</td>
												<td style=" text-align: center;" colspan="2">
														<h5>Expiry Date {{$j}}
														</h5>
														<div class="form-group">
															<input type="date" id="expiryDate{{$j}}" class="form-control  " autocomplete="off" name="expiryDate{{$j}}[]" title="Please Enter Expiry Date{{$j}}" >
														</div>
												</td>
											@endfor
											</tr>
											<tr>
												@for($k = 1; $k <= $globalValue; $k++)
													<td colspan="3" style=" text-align: center;" bgcolor="{{$col[$k]}}">
														<h4 style="font-weight: 600;color: white;">Test Kit {{$k}}</h4>
													</td>
												@endfor
											</tr>
											<tr>
											@for($l = 1; $l <= $globalValue; $l++)
												<td style=" text-align: center;" bgcolor="{{$col[$l]}}">
													<h5 style="color: white; font-weight: 500;"> R
													</h5>
													<div class="form-group">
														<input type="number" min="0" id="totalReactive{{$l}}" class="form-control  " autocomplete="off" placeholder="Enter Total Reactive - R - {{$l}}" name="totalReactive{{$l}}[]" title="Please Enter Total Reactive - R - {{$l}}" >
													</div>
												</td>
												<td style=" text-align: center;" bgcolor="{{$col[$l]}}">
														<h5 style="color: white; font-weight: 500;">NR
														</h5>
														<div class="form-group">
														<input type="number" min="0" id="totalNonReactive{{$l}}" class="form-control  " autocomplete="off" placeholder="Enter Total Non-Reactive - R - {{$l}}" name="totalNonReactive{{$l}}[]" title="Please Enter Total Non-Reactive - R - {{$l}}" >
													</div>
												</td>
												<td style=" text-align: center;" bgcolor="{{$col[$l]}}">
														<h5 style="color: white; font-weight: 500;">INV 
														</h5>
														<div class="form-group">
														<input type="number" min="0" id="totalInvalid{{$l}}" class="form-control  " autocomplete="off" placeholder="Enter Total Invalid - INV - {{$l}}" name="totalInvalid{{$l}}[]" title="Please Enter Total Invalid - INV - {{$l}}" >
													</div>
												</td>
												
												@endfor
											</tr>
										</table>
										<br>
										<table class="table1" style="width:80%;margin-left: 10%;">
											<tr>
												<td  style=" text-align: center;">
												<h4 style="font-weight: 600;"> Final Result </h4>
												</td>
												<td style=" text-align: center;" >
													<h5> Positive
													</h5>
													<div class="form-group">
														<input type="number" min="0" id="totalPositive0" class="form-control  " autocomplete="off" placeholder="Enter Final Positive" name="totalPositive[]" title="Please Enter Final Positive" >
													</div>
												</td>
												<td style=" text-align: center;" >
													<h5> Negative
													</h5>
													<div class="form-group">
														<input type="number" min="0" id="totalNegative0" class="form-control  " autocomplete="off" placeholder="Enter Final Negative" name="totalNegative[]" title="Please Enter Final Negative" >
													</div>
												</td>
												<td style=" text-align: center;" >
													<h5> Indeterminate
													</h5>
													<div class="form-group">
														<input type="number" min="0" id="finalUndetermined0" class="form-control  " autocomplete="off" placeholder="Enter Final Undertermined" name="finalUndetermined[]" title="Please Enter Final Undertermined" >
													</div>
												</td>
											</tr>
										</table>
									</div>
								</div>
								<div class="form-actions right">
                                    <a href="/monthlyreport" >
                                    <button type="button" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                    </button>
                                    </a>
                                    <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Save
                                    </button>
								</div>
							</form>
							<br>
								<div class="row" style="margin-left:40%;">
									<button  onclick="insert_row();" class="btn btn-info grey">
                                    <i class="ft-plus icon-left"></i> Add New Test
                                    </button>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	<!-- horizontal grid end -->
</section>
</div>
</div>

<script>
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
});
 duplicateName = true;
    function validateNow() {
            flag = deforayValidator.init({
                formId: 'addMonthlyReport'
            });
            
            if (flag == true) {
                if (duplicateName) {
                    document.getElementById('addMonthlyReport').submit();
                }
            }
            else{
                // Swal.fire('Any fool can use a computer');
                $('#show_alert').html(flag).delay(3000).fadeOut();
                $('#show_alert').css("display","block");
                $(".infocus").focus();
            }
	}
	
var rowCount = 0;
var gCnt = '{{$globalValue}}';
var col = ['yellow', '#b5d477' , '#d08662', '#76cece', '#ea7786'];
function insert_row()
{
	rowCount++;
	var div = '';

	div+='<br><div id="test_details'+rowCount+'">\
			<div class="row">\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>Page No \
						</h5>\
						<div class="form-group">\
							<input type="number" min="0" id="pageNO'+rowCount+'" class="form-control  " autocomplete="off" placeholder="Enter Page No" name="pageNO[]" title="Please Enter Page No" >\
						</div>\
					</fieldset>\
				</div>\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>Start Date\
						</h5>\
						<div class="form-group">\
							<input type="date" id="startDate'+rowCount+'" class="form-control  " autocomplete="off" name="startDate[]" title="Please Enter Start Date" >\
						</div>\
					</fieldset>\
				</div>\
				<div class="col-xl-4 col-lg-12">\
					<fieldset>\
						<h5>End Date\
						</h5>\
						<div class="form-group">\
							<input type="date" id="endDate'+rowCount+'" class="form-control  " autocomplete="off" name="endDate[]" title="Please Enter End Date" >\
						</div>\
					</fieldset>\
				</div>\
			</div>\
			<table class="table1" style="width:100%">\
			<tr>';
			
				div+='@if(count($allowedTestKitNo) > 0)\
				@for($i = 1; $i <= $globalValue; $i++)\
				<td  style=" text-align: center;" colspan="3" >\
						<fieldset>\
							<h5>Test Kit Name{{$i}}<span class="mandatory">*</span>\
								</h5>\
								<div class="form-group">\
									<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testkitId{{$i}}" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}">\
										@foreach($allowedTestKitNo[$i] as $value=>$option)\
										<option value="{{$value}}">{{$option}}</option>\
										@endforeach\
									</select>\
								</div>\
							</fieldset>\
						</td>\
						@endfor\
						@else\
						@for($i = 1; $i <= $globalValue; $i++)\
				        <td  style=" text-align: center;" colspan="3" >\
						<fieldset>\
							<h5>Test Kit Name{{$i}}<span class="mandatory">*</span>\
								</h5>\
								<div class="form-group">\
									<select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testkitId{{$i}}" name="testkitId{{$i}}[]" title="Please select Test Kit Name{{$i}}">\
										@foreach($kittype as $row2)\
										<option value="{{$row2->tk_id}}">{{$row2->test_kit_name}}</option>\
										@endforeach\
									</select>\
								</div>\
							</fieldset>\
						</td>\
						@endfor\
						@endif';
			div+='</tr><tr>'
			for(var j=1; j<=gCnt;j++)
			{
				div+='<td style=" text-align: center;">\
							<h5>Lot No '+j+' \
							</h5>\
							<div class="form-group">\
								<input type="number" min="0" id="lotNO'+j+'" class="form-control  " autocomplete="off" placeholder="Enter Lot No" name="lotNO'+j+'[]" title="Please Enter Lot No'+j+'" >\
							</div>\
					</td>\
					<td style=" text-align: center;" colspan="2">\
							<h5>Expiry Date '+j+'\
							</h5>\
							<div class="form-group">\
								<input type="date" id="expiryDate'+j+'" class="form-control  " autocomplete="off" name="expiryDate'+j+'[]" title="Please Enter Expiry Date'+j+'" >\
							</div>\
					</td>';
			}
			div+='</tr><tr>'
			for(var k=1; k<=gCnt;k++)
			{
				div+='<td colspan="3" style=" text-align: center;" bgcolor="'+col[k]+'">\
						<h4 style="font-weight: 600;color: white;">Test Kit '+k+'</h4>\
					</td>';
			}
			div+='</tr><tr>'
			for(var l=1; l<=gCnt;l++)
			{
				div+='<td style=" text-align: center;" bgcolor="'+col[l]+'">\
						<h5 style="color: white; font-weight: 500;"> R\
						</h5>\
						<div class="form-group">\
							<input type="number" min="0" id="totalReactive'+l+'" class="form-control  " autocomplete="off" placeholder="Enter Total Reactive - R - '+l+'" name="totalReactive'+l+'[]" title="Please Enter Total Reactive - R - '+l+'" >\
						</div>\
					</td>\
					<td style=" text-align: center;" bgcolor="'+col[l]+'">\
							<h5 style="color: white; font-weight: 500;">NR\
							</h5>\
							<div class="form-group">\
							<input type="number" min="0" id="totalNonReactive'+l+'" class="form-control  " autocomplete="off" placeholder="Enter Total Non-Reactive - R - '+l+'" name="totalNonReactive'+l+'[]" title="Please Enter Total Non-Reactive - R - '+l+'" >\
						</div>\
					</td>\
					<td style=" text-align: center;" bgcolor="'+col[l]+'">\
						<h5 style="color: white; font-weight: 500;">INV </h5> ';
			div+='		<div class="form-group">\
							<input type="number" min="0" id="totalInvalid'+l+'" class="form-control  " autocomplete="off" placeholder="Enter Total Invalid - INV - '+l+'" name="totalInvalid'+l+'[]" title="Please Enter Total Invalid - INV - '+l+'" >\
						</div>\
					</td>'
			}
			div+='</tr></table><br>\
					<table class="table1" style="width:80%;margin-left: 10%;">\
						<tr>\
							<td  style=" text-align: center;">\
							<h4 style="font-weight: 600;"> Final Result </h4>\
							</td>\
							<td style=" text-align: center;" >\
								<h5> Positive\
								</h5>\
								<div class="form-group">\
									<input type="number" min="0" id="totalPositive'+rowCount+'" class="form-control  " autocomplete="off" placeholder="Enter Final Positive" name="totalPositive[]" title="Please Enter Final Positive" >\
								</div>\
							</td>\
							<td style=" text-align: center;" >\
								<h5> Negative\
								</h5>\
								<div class="form-group">\
									<input type="number" min="0" id="totalNegative'+rowCount+'" class="form-control  " autocomplete="off" placeholder="Enter Final Negative" name="totalNegative[]" title="Please Enter Final Negative" >\
								</div>\
							</td>\
							<td style=" text-align: center;" >\
								<h5> Indeterminate\
								</h5>\
								<div class="form-group">\
									<input type="number" min="0" id="finalUndetermined'+rowCount+'" class="form-control  " autocomplete="off" placeholder="Enter Final Undertermined" name="finalUndetermined[]" title="Please Enter Final Undertermined" >\
								</div>\
							</td>\
						</tr>\
					</table>\
				</div>';
	$("#test_row").append(div);
}
</script>
@endsection