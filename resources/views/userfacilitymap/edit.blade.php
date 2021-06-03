<!-- 
    Author             : Sakthivel P
    Date               : 2 June 2021
    Description        : User Facility Map edit screen
    Last Modified Date : 2 June 2021
    Last Modified Name : Sakthivel P
-->
@extends('layouts.main')
@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">User Facility</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/userfacilitymap/">User Facility</a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit User Facility</h4>
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
                            <form class="form form-horizontal" role="form" name="editUserFacility" id="editUserFacility" method="post" action="/userfacilitymap/edit/{{$id}}" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                            @php
                                $fnct = "ufm_id##".($result[0]->ufm_id);
                            @endphp
                            <div class="row">
                            <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>User Name<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="userId" name="userId" title="Please select User Name">
                                                <option>Select User Name</option>
                                                 @foreach($user as $row)
                                                    <option value="{{$row->user_id}}" {{ $result[0]->user_id == $row->user_id ?  'selected':''}}>{{$row->first_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Facilty Name<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select multiple="multiple" class="form-control isRequired" autocomplete="off" style="width:100%;" id="facilityId" name="facilityId[]" title="Please select Facility Name">
                                                <option>Select Facility Name</option>
                                                    @foreach($facility as $row)
                                                    <option value="{{$row->facility_id}}" {{ $result[0]->facility_id == $row->facility_id ?  'selected':''}}>{{$row->facility_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                </div>
								<div class="form-actions right">
                                    <a href="/userfacilitymap" >
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
            formId: 'editUserFacility'
        });
        
        if (flag == true) {
            if (duplicateName) {
				document.getElementById('editUserFacility').submit();
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