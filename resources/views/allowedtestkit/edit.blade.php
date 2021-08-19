<!-- 
    Author             : Sakthivel P
    Date               : 3 June 2021
    Description        : Allowed Test Kit edit screen
    Last Modified Date : 3 June 2021
    Last Modified Name : Sakthivel P
-->
@extends('layouts.main')
@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Allowed Test Kit</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/allowedtestkit/">Allowed Test Kit</a>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Edit Allowed Test Kit</h4>
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
                            <form class="form form-horizontal" role="form" name="editAllowedTestKit" id="editAllowedTestKit" method="post" action="/allowedtestkit/edit/{{$id}}" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                            @php
                                $fnct = "test_kit_no##".($result[0]->test_kit_no);
                            @endphp
                            <div class="row">
                            <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Test Kit No<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="testKitNo" name="testKitNo" title="Please Select Test Kit No">
                                                <option value="">Select Test Kit No</option>
                                                <option value="1" <?php if($result[0]->test_kit_no == '1') { ?> selected="selected"<?php } ?>>1</option>
                                                <option value="2" <?php if($result[0]->test_kit_no == '2') { ?> selected="selected"<?php } ?>>2</option>
                                                <option value="3" <?php if($result[0]->test_kit_no == '3') { ?> selected="selected"<?php } ?>>3</option>
                                                <option value="4" <?php if($result[0]->test_kit_no == '4') { ?> selected="selected"<?php } ?>>4</option>
                                                <option value="5" <?php if($result[0]->test_kit_no == '5') { ?> selected="selected"<?php } ?>>5</option>
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                    <div class="col-xl-4 col-lg-12">
										<fieldset>
											<h5>Test Kit Name<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <select multiple="multiple" class="js-example-basic-multiple form-control isRequired" autocomplete="off" style="width:100%;" id="testKitName" name="testKitName[]" title="Please Select Test Kit Name">
                                                @foreach($test as $row)
                                                    <option value="{{$row->tk_id}}" {{ in_array($row->tk_id, $testKitId) ?  'selected':''}}>{{$row->test_kit_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</fieldset>
									</div>
                                </div>
								<div class="form-actions right">
                                    <a href="/allowedtestkit" >
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
            formId: 'editAllowedTestKit'
        });
        
        if (flag == true) {
            if (duplicateName) {
				document.getElementById('editAllowedTestKit').submit();
            }
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
            $(".infocus").focus();
        }
	}
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
    $selectElement = $('#testKitName').select2({
    placeholder: "Select Test Kit Name",
    allowClear: true
  });
});
</script>
<link href="public/dist/css/select2.min.css" rel="stylesheet" />
<script src="public/dist/js/select2.min.js"></script>
@endsection