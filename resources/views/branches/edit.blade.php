<!-- 
    Author             : Sudarmathi M
    Date               : 18 June 2020
    Description        : User add screen
    Last Modified Date : 18 June 2020
    Last Modified Name : Sudarmathi M
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Branches</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/branches/">Branches</a>
			</li>
			<li class="breadcrumb-item active">Edit</li>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit Branches</h4>
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
                            <form class="form form-horizontal" role="form" name="addBranch" id="addBranch" method="post" action="/branches/edit/{{base64_encode($result[0]->branch_id)}}" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                            @php
                                $fnct = "branch_id##".($result[0]->branch_id);
                            @endphp
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Branch Name <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="branchName" value="{{$result[0]->branch_name}}" class="form-control isRequired" autocomplete="off" placeholder="Enter a branch name" name="branchName" title="Please enter branch name" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Branch Type<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="branchType" name="branchType" title="Please select branch type">
                                                <option value="">Select Branch Type</option>
                                                @foreach($branchType as $type)
													<option value="{{ $type->branch_type_id }}" {{ $result[0]->branch_type_id == $type->branch_type_id ?  'selected':''}}>{{ $type->branch_type }}</option>
												@endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Mobile Number<span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="tel" maxlength="10" value="{{$result[0]->phone}}" onkeypress="return isNumberKey(event);" id="mobileNo" class="form-control isMobNo isRequired" autocomplete="off" placeholder="Enter a Mobile Number" name="mobileNo" title="Please Enter Mobile Number" onblur="checkNameValidation('branches','phone', this.id,'{{$fnct}}','Entered mobile number is already exist.')">
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Email <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="email" value="{{$result[0]->email}}" class="form-control isEmail isRequired" autocomplete="off" placeholder="Enter a Email" name="email" title="Please Enter Email" onblur="checkNameValidation('branches','email', this.id,'{{$fnct}}','Entered mail id is already exist.')">
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Address Line 1 <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="addressLine1" value="{{$result[0]->address_line_1}}" class="form-control isRequired" autocomplete="off" placeholder="Enter a address line1" name="addressLine1" title="Please enter address line1" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Address Line 2
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="addressLine2" value="{{$result[0]->address_line_2}}" class="form-control" autocomplete="off" placeholder="Enter a address line2" name="addressLine2" title="Please enter address line2" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Country<span class="mandatory">*</span> </h5>
											<div class="form-group">
                                            <select class="form-control isRequired select2" autocomplete="off" style="width:100%;" id="country" name="country" title="Please select country" >
                                            <option value="">Select Country</option>
                                            @foreach($country as $type)
                                            <option value="{{ $type->country_id }}" {{ $result[0]->country == $type->country_id ?  'selected':''}}>{{ $type->country_name }}</option>
                                            @endforeach
                                            </select>
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>State<span class="mandatory">*</span> </h5>
											<div class="form-group">
                                                <input type="text" class="form-control isRequired" value="{{$result[0]->state}}" autocomplete="off" style="width:100%;" id="state" name="state" title="Please select state" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>City <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="city" value="{{$result[0]->city}}" class="form-control isRequired" autocomplete="off" placeholder="Enter a city" name="city" title="Please enter city">
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Pincode 
											</h5>
											<div class="form-group">
                                                <input type="text" id="pincode" value="{{$result[0]->pincode}}" maxlength='6' onkeypress="return isNumberKey(event);" class="form-control isPincode" autocomplete="off" placeholder="Enter a pincode" name="pincode" title="Please enter pincode">
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Branch Status<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="branchStatus" name="branchStatus" title="Please select User status">
                                                    <option value="active" {{ $result[0]->branch_status == 'active' ?  'selected':''}}>Active</option>
                                                    <option value="inactive" {{ $result[0]->branch_status == 'inactive' ?  'selected':''}}>Inactive</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                </div>
								<div class="form-actions right">
                                    <a href="/branches" >
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
    $(".select2").select2();
});


 duplicateName = true;
    function validateNow() {
        pinNum = $('#pincode').val();
		if(pinNum.length!=6){
            $("html, body").animate({ scrollTop: 0 }, "slow");
			$("#showAlertIndex").text('Please give 6 digit pincode number');
			$('#showAlertdiv').show();
			ispin = false;
            $('#pincode').css('background-color', 'rgb(255, 255, 153)')
            $('#pincode').focus()
			$('#showAlertdiv').delay(3000).fadeOut();
		}
		else{
			ispin = true;
        }
        mobNum = $('#mobileNo').val();
		if(mobNum.length!=10){
			$("html, body").animate({ scrollTop: 0 }, "slow");
			$("#showAlertIndex").text('Please give 10  digit mobile number');
			$('#showAlertdiv').show();
			ismob = false;
            $('#mobileNo').css('background-color', 'rgb(255, 255, 153)')
            $('#mobileNo').focus()
			$('#showAlertdiv').delay(3000).fadeOut();
		}
		else{
			ismob = true;
		}
		if(ismob==true && ispin==true){
            flag = deforayValidator.init({
                formId: 'addBranch'
            });
            
            if (flag == true) {
                if (duplicateName) {
                    document.getElementById('addBranch').submit();
                }
            }
            else{
                // Swal.fire('Any fool can use a computer');
                $('#show_alert').html(flag).delay(3000).fadeOut();
                $('#show_alert').css("display","block");
                $(".infocus").focus();
            }
        }
	}
	
	
</script>
@endsection