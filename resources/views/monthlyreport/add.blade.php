<!-- 
    Author             : Prasath M
    Date               : 02 Jun 2021
    Description        : Monthly report add screen
    Last Modified Date : 02 Jun 2021
    Last Modified Name : Prasath M
-->
@extends('layouts.main')

@section('content')
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
                                    <div class="col-xl-4 col-lg-12">
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
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Site Type Name<span class="mandatory">*</span>
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
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Test Site Name<span class="mandatory">*</span>
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
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Site Unique Id <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="siteUniqueId" class="form-control  isRequired" autocomplete="off" placeholder="Enter Site Unique Id" name="siteUniqueId" title="Please Enter Site Unique Id" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Site Manager 
											</h5>
											<div class="form-group">
                                                <input type="text" id="siteManager" class="form-control" autocomplete="off" placeholder="Enter Site Manager" name="siteManager" title="Please Enter Site Manager" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Is Flu<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isFlu" name="isFlu" title="Please select Is Flu status">
                                                    <option value="yes" >Yes</option>
                                                    <option value="no" selected>No</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Is Recency<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="isRecency" name="isRecency" title="Please select Is Recency status">
                                                    <option value="yes" >Yes</option>
                                                    <option value="no" selected>No</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Contact Number 
											</h5>
											<div class="form-group">
                                                <input type="text" id="contactNo" class="form-control" autocomplete="off" placeholder="Enter Contact Number" name="contactNo" title="Please Enter Contact Number" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Latitude <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="latitude" class="form-control isRequired " autocomplete="off" placeholder="Enter latitude" name="latitude" title="Please Enter latitude" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Longitude <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="longitude" class="form-control isRequired " autocomplete="off" placeholder="Enter longitude" name="longitude" title="Please Enter longitude" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Algorithm Type 
											</h5>
											<div class="form-group">
                                                <input type="text" id="algoType" class="form-control" autocomplete="off" placeholder="Enter Algorithm Type" name="algoType" title="Please Enter Algorithm Type" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Date of data collection <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="DateOfCollect" class="form-control isRequired datepicker" autocomplete="off" placeholder="Enter Date Of Collection" name="DateOfCollect" title="Please Enter Date Of Collection" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Reporting Month <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="reportingMon" class="form-control isRequired datepicker" autocomplete="off" placeholder="Enter Reporting Month" name="reportingMon" title="Please Enter Reporting Month" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Book Number <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="bookNo" class="form-control isRequired" autocomplete="off" placeholder="Enter Book No" name="bookNo" title="Please Enter Book No" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Signature 
											</h5>
											<div class="form-group">
                                                <input type="text" id="signature" class="form-control  " autocomplete="off" placeholder="Enter Signature" name="signature" title="Please Enter Signature" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Name of Data Collected 
											</h5>
											<div class="form-group">
                                                <input type="text" id="nameOfDataCollect" class="form-control  " autocomplete="off" placeholder="Enter Name of Data Collected" name="nameOfDataCollect" title="Please Enter Name of Data Collected" >
											</div>
										</fieldset>
									</div>
                                </div>
								<div class="row">
								<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Page No 
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="pageNO" class="form-control  " autocomplete="off" placeholder="Enter Page No" name="pageNO" title="Please Enter Page No" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Start Date
											</h5>
											<div class="form-group">
                                                <input type="date" id="startDate" class="form-control  " autocomplete="off" name="startDate" title="Please Enter Start Date" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>End Date
											</h5>
											<div class="form-group">
                                                <input type="date" id="endDate" class="form-control  " autocomplete="off" name="endDate" title="Please Enter End Date" >
											</div>
										</fieldset>
									</div>
								</div>
							<div class="row">
							<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Test Kit Name1<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testkitId1" name="testkitId1" title="Please select Test Kit Name1">
                                                    @foreach($kittype as $row2)
                                                    <option value="{{$row2->tk_id}}">{{$row2->test_kit_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Lot No 1 
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="lotNO1" class="form-control  " autocomplete="off" placeholder="Enter Lot No" name="lotNO1" title="Please Enter Lot No1" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Expiry Date 1
											</h5>
											<div class="form-group">
                                                <input type="date" id="expiryDate1" class="form-control  " autocomplete="off" name="expiryDate1" title="Please Enter Expiry Date1" >
											</div>
										</fieldset>
									</div>
							</div> 
							<div class="row">
							<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Reactive - R - 1
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalReactive1" class="form-control  " autocomplete="off" placeholder="Enter Total Reactive - R - 1" name="totalReactive1" title="Please Enter Total Reactive - R - 1" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Non-Reactive - R - 1
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalNonReactive1" class="form-control  " autocomplete="off" placeholder="Enter Total Non-Reactive - R - 1" name="totalNonReactive1" title="Please Enter Total Non-Reactive - R - 1" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Invalid - INV - 1
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalInvalid1" class="form-control  " autocomplete="off" placeholder="Enter Total Invalid - INV - 1" name="totalInvalid1" title="Please Enter Total Invalid - INV - 1" >
											</div>
										</fieldset>
									</div>
									</div>
									<div class="row">
							<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Test Kit Name2<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testkitId2" name="testkitId2" title="Please select Test Kit Name2">
                                                    @foreach($kittype as $row2)
                                                    <option value="{{$row2->tk_id}}">{{$row2->test_kit_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Lot No 2
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="lotNO2" class="form-control  " autocomplete="off" placeholder="Enter Lot No" name="lotNO2" title="Please Enter Lot No2" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Expiry Date 2
											</h5>
											<div class="form-group">
                                                <input type="date" id="expiryDate2" class="form-control  " autocomplete="off" name="expiryDate2" title="Please Enter Expiry Date2" >
											</div>
										</fieldset>
									</div>
							</div> 
							<div class="row">
							<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Reactive - R - 2
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalReactive2" class="form-control  " autocomplete="off" placeholder="Enter Total Reactive - R - 2" name="totalReactive2" title="Please Enter Total Reactive - R - 2" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Non-Reactive - R - 2
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalNonReactive2" class="form-control  " autocomplete="off" placeholder="Enter Total Non-Reactive - R - 2" name="totalNonReactive2" title="Please Enter Total Non-Reactive - R - 2" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Invalid - INV - 2
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalInvalid2" class="form-control  " autocomplete="off" placeholder="Enter Total Invalid - INV - 2" name="totalInvalid2" title="Please Enter Total Invalid - INV - 2" >
											</div>
										</fieldset>
									</div>
									</div>
									<div class="row">
							<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Test Kit Name3<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testkitId3" name="testkitId3" title="Please select Test Kit Name3">
                                                    @foreach($kittype as $row2)
                                                    <option value="{{$row2->tk_id}}">{{$row2->test_kit_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Lot No 3
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="lotNO3" class="form-control  " autocomplete="off" placeholder="Enter Lot No" name="lotNO3" title="Please Enter Lot No3" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Expiry Date 3
											</h5>
											<div class="form-group">
                                                <input type="date" id="expiryDate3" class="form-control  " autocomplete="off" name="expiryDate3" title="Please Enter Expiry Date3" >
											</div>
										</fieldset>
									</div>
							</div> 
							<div class="row">
							<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Reactive - R - 3
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalReactive3" class="form-control  " autocomplete="off" placeholder="Enter Total Reactive - R - 3" name="totalReactive3" title="Please Enter Total Reactive - R - 3" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Non-Reactive - R - 3
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalNonReactive3" class="form-control  " autocomplete="off" placeholder="Enter Total Non-Reactive - R - 3" name="totalNonReactive3" title="Please Enter Total Non-Reactive - R - 3" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Invalid - INV - 3
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalInvalid3" class="form-control  " autocomplete="off" placeholder="Enter Total Invalid - INV - 3" name="totalInvalid3" title="Please Enter Total Invalid - INV - 3" >
											</div>
										</fieldset>
									</div>
									</div>
									<div class="row">
							<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Reactive - R
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalReactive" class="form-control  " autocomplete="off" placeholder="Enter Total Reactive - R" name="totalReactive" title="Please Enter Total Reactive - R" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Non-Reactive - R
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalNonReactive" class="form-control  " autocomplete="off" placeholder="Enter Total Non-Reactive - R" name="totalNonReactive" title="Please Enter Total Non-Reactive - R" >
											</div>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Total Invalid - INV
											</h5>
											<div class="form-group">
                                                <input type="number" min="0" id="totalInvalid" class="form-control  " autocomplete="off" placeholder="Enter Total Invalid - INV" name="totalInvalid" title="Please Enter Total Invalid - INV" >
											</div>
										</fieldset>
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
</script>
@endsection