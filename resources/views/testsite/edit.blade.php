<!-- 
    Author             : Prasath M
    Date               : 28 May 2021
    Description        : Test Site edit screen
    Last Modified Date : 28 May 2021
    Last Modified Name : Prasath M
-->
@extends('layouts.main')
@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Test Site</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/testsite/">Test Site</a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit Test Site</h4>
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
                            <form class="form form-horizontal" role="form" name="editTestSite" id="editTestSite" method="post" action="/testsite/edit/{{$id}}" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                            @php
                                $fnct = "ts_id##".($result[0]->ts_id);
                            @endphp
                            <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Site Id
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="siteId" value="{{$result[0]->site_ID}}" class="form-control" autocomplete="off" placeholder="Enter Site Id" name="siteId" title="Please enter Site Id" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Site Name  <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="siteName" value="{{$result[0]->site_name}}" class="form-control isRequired" autocomplete="off" placeholder="Enter site name" name="siteName" title="Please enter site name" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Latitude 
											</h5>
											<div class="form-group">
                                                <input type="text" id="latitude" value="{{$result[0]->site_latitude}}" class="form-control " autocomplete="off" placeholder="Enter latitude" name="latitude" title="Please Enter latitude" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Longitude 
											</h5>
											<div class="form-group">
                                                <input type="text" id="longitude" value="{{$result[0]->site_longitude}}" class="form-control " autocomplete="off" placeholder="Enter longitude" name="longitude" title="Please Enter longitude" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Address1
											</h5>
											<div class="form-group">
                                                <input type="text" id="address1" value="{{$result[0]->site_address1}}" class="form-control  " autocomplete="off" placeholder="Enter address1" name="address1" title="Please Enter address1" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Address2
											</h5>
											<div class="form-group">
                                                <input type="text" id="address2" value="{{$result[0]->site_address2}}" class="form-control  " autocomplete="off" placeholder="Enter address2" name="address2" title="Please Enter address2" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Postal Code
											</h5>
											<div class="form-group">
                                                <input type="tel" maxlength="6" value="{{$result[0]->site_postal_code}}" onkeypress="return isNumberKey(event);" id="postalCode" class="form-control" autocomplete="off" placeholder="Enter Postal Code" name="postalCode" title="Please Enter Postal Code" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Country <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="country" value="{{$result[0]->site_country}}" class="form-control  isRequired" autocomplete="off" placeholder="Enter country" name="country" title="Please Enter country" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>State <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="state" value="{{$result[0]->site_state}}" class="form-control  isRequired" autocomplete="off" placeholder="Enter state" name="state" title="Please Enter state" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>City <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                                                <input type="text" id="city" value="{{$result[0]->site_city}}" class="form-control  isRequired" autocomplete="off" placeholder="Enter city" name="city" title="Please Enter city" >
											</div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Test Site Status<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testSiteStatus" name="testSiteStatus" title="Please select Test site status">
                                                    <option value="active" {{ $result[0]->test_site_status == 'active' ?  'selected':''}}>Active</option>
                                                    <option value="inactive" {{ $result[0]->test_site_status == 'inactive' ?  'selected':''}}>Inactive</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                </div>
								<div class="form-actions right">
                                    <a href="/testsite" >
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

<script>


 duplicateName = true;
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'editTestSite'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editTestSite').submit();
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