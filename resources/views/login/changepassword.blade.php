<!-- 
    Author             : Prasath M
    Date               : 06 Feb 2020
    Description        : suppliers add screen
    Last Modified Date : 06 Feb 2020
    Last Modified Name : Prasath M
-->
@extends('layouts.main')

@section('content')
<style>
#register .short{
font-weight:bold;
color:#FF0000;
font-size:larger;
}
#register .weak{
font-weight:bold;
color:orange;
font-size:larger;
}
#register .good{
font-weight:bold;
color:#2D98F3;
font-size:larger;
}
#register .strong{
font-weight:bold;
color: limegreen;
font-size:larger;
}
</style>
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Change Password</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item active">Change Password</li>
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
						<h4 class="form-section"><i class="la la-plus-square"></i> Change Password</h4>
						<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
						<div class="heading-elements">
							<ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
								<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
							</ul>
						</div>
						<div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
					</div>
					@if (isset($status))
                    <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index" ><div class="text-center" style="font-size: 18px;"><b>
                        {{ $status }}</b></div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <script>$('#show_alert_index').delay(3000).fadeOut();</script>
                @endif
					<div class="card-content collapse show">
						<div class="card-body">
						<div id="show_alert"  class="mt-1" style=""></div>
            <form class="form form-horizontal" role="form" name="changepassword" id="changepassword" method="post" action="/changePassword/{{$id}}" autocomplete="off" onsubmit="validateNow();return false;">
            @csrf
			@php
            if(session('loginType') == 'users'){
				$fnct = "user_id##".(session('userId'));
                $tableName = 'users';
            }
            else{
                $fnct = "vendor_id##".(session('userId'));
                $tableName = 'vendors';
            }
			@endphp
              <div class="row">
									<div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Current Password <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                      <input type="password" id="currentPassword" class="form-control isRequired" autocomplete="off" placeholder="Enter a Current Password" name="currentPassword" title="Please Enter Current Password">
											</div>
										</fieldset>
									</div>
									<div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>New Password <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                      <input type="password" id="newPassword" class="form-control isRequired" autocomplete="off" placeholder="Enter a New Password" name="newPassword" title="Please Enter New Password">

					  <div class="invalid-feedback">
														must contain atleast 8 characters, 1 number , 1 alphabet and 1 special character
													</div>
											</div>
										</fieldset>
									</div>
									<div class="col-xl-6 col-lg-12">
										<fieldset>
											<h5>Confirm Password <span class="mandatory">*</span>
											</h5>
											<div class="form-group">
                      <input type="password" id="confirmPassword" class="form-control isRequired"  autocomplete="off" placeholder="Enter a Confirm Password" name="confirmPassword" title="Please Enter Confirm Password">
					  <span id="confirmresult" style="width: 100%;margin-top: 0.25rem;font-size: 80%;color: #FF4961;"></span>
                      <input type="hidden" id="passwordCheck" name="passwordCheck" class="isRequired" title="Passwords do not match.">
											</div>
										</fieldset>
									</div>

								</div>
								<div class="form-actions right">
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
 duplicateName = true;
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'changepassword'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('changepassword').submit();
            }
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
			$('#show_alert').css("display","block");
			$(".infocus").focus();
        }
    }



	// function passwordStrengthvalidation(passwordElementObject){
    //     const validPasswordRegEx = new RegExp("^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})|(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})");
    //     if(validPasswordRegEx.test(passwordElementObject.value) === false){
    //         $("#"+passwordElementObject.id).val("");
    //         $(".invalid-feedback").show();
    //     }else{
    //         $(".invalid-feedback").hide();
    //     }
    // }
	$(document).ready(function() {
		$('#confirmPassword').keyup(function() {			
			var nPws=$('#newPassword').val();
			var cPws=$('#confirmPassword').val();
			if(nPws!=cPws){
				$('#confirmresult').html('Passwords do not match.')
				$('#passwordCheck').val('');
			}else{

				$('#passwordCheck').val('passwordCheck');
			$('#confirmresult').html('')}
		})


		$('#newPassword').change(function() {
			
			$('#result').html(checkStrength($('#newPassword').val()))
		})
		function checkStrength(password) {
			var strength = 0
			if (password.length < 7) {
			$('#result').removeClass()
			$('#result').addClass('short')
			$('#passwordCheck').val('')
			$("#newPassword").val("");
			$(".invalid-feedback").show();
			return 'Too short'
			}
			if (password.length > 7) strength += 1
			// If password contains both lower and uppercase characters, increase strength value.
			if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
			// If it has numbers and characters, increase strength value.
			if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
			// If it has one special character, increase strength value.
			if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
			// If it has two special characters, increase strength value.
			if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
			// Calculated strength value, we can return messages
			// If value is less than 2
			if (strength < 2) {
			$('#result').removeClass()
			$('#result').addClass('weak')
			$('#passwordCheck').val('')
			$("#newPassword").val("");
			$(".invalid-feedback").show();
			return 'Weak'
			} else if (strength == 2) {
			$('#result').removeClass()
			$('#result').addClass('good')
			$('#passwordCheck').val('good')
			$(".invalid-feedback").hide();
			return 'Good'
			} else {
			$('#result').removeClass()
			$('#result').addClass('strong')
			$('#passwordCheck').val('strong')
			$(".invalid-feedback").hide();
			return 'Strong'
			}
		}
		
});



</script>
@endsection