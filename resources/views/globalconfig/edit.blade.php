<!-- 
    Author             : Prasath M
    Date               : 03 Jun 2021
    Description        : Global Config edit screen
    Last Modified Date : 03 Jun 2021
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
			<li class="breadcrumb-item"><a href="/globalconfig/">Global Config</a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit Global Config</h4>
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
                            <form class="form form-horizontal" role="form" name="editGlobalConfig" id="editGlobalConfig" method="post" action="/globalconfig/edit/" autocomplete="off" enctype="multipart/form-data" onsubmit="validateNow();return false;">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4 col-lg-12">
                                    <fieldset>
                                        <h5>Instance Name<span class="mandatory">*</span>
                                        </h5>
                                        <div class="form-group">
                                            <input type="text" id="instance_name" value="{{$result['instance_name']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Instance Name" name="instance_name" title="Please enter Instance Name" >
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-12">
                                    <fieldset>
                                        <h5>Institute Name<span class="mandatory">*</span>
                                        </h5>
                                        <div class="form-group">
                                            <input type="text" id="institute_name" value="{{$result['institute_name']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Institute Name" name="institute_name" title="Please enter Institute Name" >
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-12">
                                    <fieldset>
                                        <h5>Admin Name<span class="mandatory">*</span>
                                        </h5>
                                        <div class="form-group">
                                            <input type="text" id="admin_name" value="{{$result['admin_name']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Admin Name" name="admin_name" title="Please enter Admin Name" >
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-12">
                                    <fieldset>
                                        <h5>Admin Email<span class="mandatory">*</span>
                                        </h5>
                                        <div class="form-group">
                                            <input type="text" id="admin_email" value="{{$result['admin_email']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Admin Email" name="admin_email" title="Please enter Admin Email" >
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-12">
                                    <fieldset>
                                        <h5>Admin Phone<span class="mandatory">*</span>
                                        </h5>
                                        <div class="form-group">
                                            <input type="text" id="admin_phone" value="{{$result['admin_phone']}}" class="form-control isRequired" autocomplete="off" placeholder="Enter Admin Phone" name="admin_phone" title="Please enter Admin Phone" >
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-12">
                                    <fieldset>
                                        <h5>Recency Test<span class="mandatory">*</span>
                                        </h5>
                                        <div class="form-group">
                                            <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="recency_test" name="recency_test" title="Please select Recency Test">
                                                <option value="enabled" {{ $result['recency_test'] == 'enabled' ?  'selected':''}}>Enabled</option>
                                                <option value="disabled" {{ $result['recency_test'] == 'disabled' ?  'selected':''}}>Disabled</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-12">
                                    <fieldset>
                                        <h5>Number of Test<span class="mandatory">*</span>
                                        </h5>
                                        <div class="form-group">
                                            <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="no_of_test" name="no_of_test" title="Please select Number of Test">
                                                <option value="1" {{ $result['no_of_test'] == '1' ?  'selected':''}}>1</option>
                                                <option value="2" {{ $result['no_of_test'] == '2' ?  'selected':''}}>2</option>
                                                <option value="3" {{ $result['no_of_test'] == '3' ?  'selected':''}}>3</option>
                                                <option value="4" {{ $result['no_of_test'] == '4' ?  'selected':''}}>4</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-12">
                                        <fieldset class="form-group">
                                        <h5>Logo
                                        </h5>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="uploadFile" name="uploadFile[]" >
                                                <label class="custom-file-label" for="uploadFile" aria-describedby="uploadFile">Choose file</label>
                                                <button type="submit" id="upload" class="btn btn-success" style="display:none;">Upload</button>
                                            </div>
                                        </fieldset>
                                    </div>
                            </div>
                            <div class="form-actions right">
                                <a href="/globalconfig" >
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
            formId: 'editGlobalConfig'
        });
        
        if (flag == true) {
            if (duplicateName) {
				document.getElementById('editGlobalConfig').submit();
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