<!--

    Date               : 27 May 2021
    Description        : Login screen
    Last Modified Date : 27 May 2021

-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<?php
$profileURl = "/user/profile/" . base64_encode(session('userId'));

use App\Service\GlobalConfigService;

$GlobalConfigService = new GlobalConfigService();
$glob = $GlobalConfigService->getAllGlobalConfig();
$globData = $GlobalConfigService->getGlobalConfigData('title_name');
$arr = array();
// now we create an associative array so that we can easily create view variables
for ($i = 0; $i < sizeof($glob); $i++) {
  $arr[$glob[$i]->global_name] = $glob[$i]->global_value;
}
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="RTCQI LOGBOOK">
  <meta name="keywords" content="RTCQI LOGBOOK">
  <meta name="author" content="Deforay">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>{{$globData}}</title>
  <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png')}}">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css')}}">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css')}}">
  <!-- END: Theme CSS-->

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/login-register.css')}}">
  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}">
  <!-- END: Custom CSS-->




</head>
<!-- END: Head-->
<style>
  html body.bg-full-screen-image {
    /*background: #63bef9  !important;*/
    background:url({{ asset('assets/images/1.jpg')
  }
  }) !important;
  background-size: cover !important;
  }

  .bottomgap {
    margin-bottom: 5px;
  }

  .error-msg {
    color: red;
  }

  .success-msg {
    color: green;
  }
</style>
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-overlay-menu 1-column menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-overlay-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                <div class="card-header border-0 text-center">
                  <div class="card-title text-center">
                    <div class="p-1">
                      <h3>{{$globData}}</h3>
                    </div>
                  </div>
                  @if($arr["logo"])
                  <img class="brand-logo" alt="rtcqui logbook logo" src="{{ url($arr["logo"])}}" style="height: 100px;width: 100px;">
                  @else
                  <img class="brand-logo" alt="rtcqui logbook logo" src="{{ asset('assets/images/default-logo.png')}}" style="height: 100px;width: 100px;">
                  @endif
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Login</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div id="show_alert" class="mt-1" style="display:none;"></div>
                  @if (session('status'))
                  <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index">
                    <div class="text-center" style="font-size: 18px;"><b>
                        {{ session('status') }}</b></div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <script>
                    $('#show_alert_index').delay(3000).fadeOut();
                  </script>
                  @endif

                  @if (session('success'))
                  <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index_success">
                    <div class="text-center" style="font-size: 18px;"><b>
                        {{ session('success') }}</b></div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <script>
                    $('#show_alert_index_success').delay(3000).fadeOut();
                  </script>
                  @endif
                  <div id="alert-new" style="display:none;"></div>
                  <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="card-body">
                    <form class="form-horizontal" method="post" name="userLogin" id="userLogin" action="login/validate" autocomplete="off">
                      @csrf
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Your Username" required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                      </fieldset>

                      <button type="submit" class="btn btn-outline-info btn-block" onclick="validateNow()"><i class="ft-unlock"></i> Login</button>
                      <button type="button" class="btn btn-outline-info btn-block" data-toggle="modal" data-target="#myModal">Forgot Password</button>
                    </form>
                    <div class="modal fade" id="myModal" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form method="post" role="form" class="form-horizontal" id="resetpwdmail">
                            @csrf
                            <div class="modal-header">
                              <h4>Reset password</h4>
                            </div>
                            <div class="modal-body">
                              <!-- <form id="resetpwdmail" action="pwdresetlink"> -->
                              <div class="form-group">

                                <label for="contact-email" class="col-lg-6 control-label">Enter your email</label>
                                <div class="col-lg-10">

                                  <input type="email" class="form-control bottomgap" name="email" id="contact-email" placeholder="you@example.com">
                                  <p id="reset-error" style="display:none;"></p>
                                  <!-- <br> -->

                                  <button type="submit" class="btn btn-primary">send email</button>

                                </div>

                                <!-- </form> -->
                              </div>
                              <div class="modal-footer">

                                <button class="btn btn-primary" type="button" data-dismiss="modal" aria-label="Close">Close</button>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>

                  </div>


                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- END: Content-->


  <!-- BEGIN: Vendor JS-->
  <script src="{{ asset('app-assets/vendors/js/vendors.min.js')}}"></script>
  <!-- BEGIN Vendor JS-->



</body>
<!-- END: Body-->

</html>
<script src="{{ asset('assets/js/deforayValidation.js') }}"></script>

<script>
  $(document).ready(function() {
    $('#resetpwdmail').on('submit', function(e) {
      e.preventDefault();
      console.log('this', this);
      email = $('#contact-email').val();
      if (email.length <= 0) {
        $("#reset-error").show();
        $("#reset-error").addClass("error-msg");
        $("#reset-error").removeClass("success-msg");
        $("#reset-error").text("Please Enter Email address");
        return false;
      } else {
        var EmailValidation = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if (EmailValidation.test(email)) {
          console.log('email is valid');
          sendResetLink();
        } else {
          console.log('invalid email');
          $("#reset-error").show();
          $("#reset-error").addClass("error-msg");
          $("#reset-error").removeClass("success-msg");
          $("#reset-error").text("Invalid Email address");
          return false;
        }
      }


    })
  });

  duplicateName = true;
  ismob = true;

  function validateNow() {
    userNameVal = $('#username').val();
    var EmailValidation = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if (EmailValidation.test(userNameVal)) {
      ismob = true;
    } else {
      $("html, body").animate({
        scrollTop: 0
      }, "slow");
      $("#showAlertIndex").text('Please give valid email address');
      $('#showAlertdiv').show();
      ismob = false;
    }

    if (ismob == true) {
      flag = deforayValidator.init({
        formId: 'userLogin'
      });

      if (flag == true) {
        if (duplicateName) {
          document.getElementById('userLogin').submit();
        }
      } else {
        $('#show_alert').html(flag).delay(3000).fadeOut();
        $('#show_alert').css("display", "block");
        $(".infocus").focus();
      }
    }
  }

  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }

  function sendResetLink() {
    $("#reset-error").show();
    $("#reset-error").addClass("success-msg");
    $("#reset-error").removeClass("error-msg");
    $("#reset-error").text("Loading...");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: "{{ url('/forgot/sendemailresetlink') }}",
      method: 'post',
      data: {
        email: $("#contact-email").val(),
      },
      success: function(result) {
        console.log('data results', result);
        result = JSON.parse(result);
        if (result.status == 'error') {
          $("#reset-error").show();
          $("#reset-error").addClass("error-msg");
          $("#reset-error").removeClass("success-msg");
          $("#reset-error").text(result.message);
        } else {
          $("#reset-error").hide();
          $("#reset-error").text('');
          $('#myModal').modal('hide');
          $("#alert-new").show();
          $("#alert-new").html('<div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index_ok"><div class="text-center" style="font-size: 18px;"><b>' + result.message + '</b></div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
        }

      }
    });
  }
</script>
