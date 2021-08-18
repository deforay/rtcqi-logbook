<!-- 
    Author             : Prasath M
    Date               : 31 May 2021
    Description        : Province edit screen
    Last Modified Date : 31 May 2021
    Last Modified Name : Prasath M
-->
@extends('layouts.main')
@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Province</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/province/">Province</a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit Province</h4>
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
                            <form class="form form-horizontal" role="form" name="editProvince" id="editProvince" method="post" action="/province/edit/{{$id}}" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                            @php
                                $fnct = "provincesss_id##".($result[0]->provincesss_id);
                            @endphp
                            <div class="row">
							<div class="col-xl-4 col-lg-12">
                                        <fieldset>
                                            <h5>Province Name<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="provinceName" value="{{$result[0]->province_name}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Province Name" name="provinceName" title="Please enter Province Name" >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Province Status<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="provinceStatus" name="provinceStatus" title="Please select Province status">
                                                    <option value="active" {{ $result[0]->province_status == 'active' ?  'selected':''}}>Active</option>
                                                    <option value="inactive" {{ $result[0]->province_status == 'inactive' ?  'selected':''}}>Inactive</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                </div>
								<div class="form-actions right">
                                    <a href="/province" >
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
            formId: 'editProvince'
        });
        
        if (flag == true) {
            if (duplicateName) {
				document.getElementById('editProvince').submit();
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